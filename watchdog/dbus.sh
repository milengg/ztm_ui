#!/bin/bash

log_file="DBus.log"

log_message() {
    current_time=$(date +"%Y-%m-%d %H:%M:%S")
    echo "[$current_time] $1" | tee -a "$log_file"
}

restart_dbus_services() {
    log_message "Attempting to restart dbus.service and dbus.socket..."

    sudo systemctl restart dbus.service
    sleep 2

    sudo systemctl restart dbus.socket
    sleep 2

    # Verify restart
    if systemctl is-active --quiet dbus.service && systemctl is-active --quiet dbus.socket; then
        log_message "D-Bus restarted successfully."
        return 0
    else
        log_message "D-Bus failed to restart! Attempting full reset..."
        return 1
    fi
}

full_dbus_reset() {
    log_message "Performing a full reset of D-Bus..."

    # Stop D-Bus completely
    sudo systemctl stop dbus.service
    sudo systemctl stop dbus.socket
    sleep 2

    # Kill any remaining dbus-daemon processes
    sudo pkill -9 dbus-daemon
    sleep 2

    # Reload systemd to prevent stale state issues
    sudo systemctl daemon-reexec
    sleep 2

    # Start D-Bus services again
    sudo systemctl start dbus.service
    sudo systemctl start dbus.socket
    sleep 2

    # Verify restart
    if systemctl is-active --quiet dbus.service && systemctl is-active --quiet dbus.socket; then
        log_message "D-Bus fully reset and running."
    else
        log_message "Critical error: D-Bus could not be restarted. Manual intervention required."
    fi
}

restart_kiosk() {
    log_message "Restarting kiosk service..."
    sudo systemctl restart kiosk
    sleep 2

    if systemctl is-active --quiet kiosk; then
        log_message "Kiosk service restarted successfully."
    else
        log_message "Warning: Kiosk service failed to start!"
    fi
}

while true; do
    # Check if either dbus.service or dbus.socket is down
    if ! systemctl is-active --quiet dbus.service || ! systemctl is-active --quiet dbus.socket; then
        log_message "D-Bus service or socket is not active!"

        # Attempt to restart normally
        if ! restart_dbus_services; then
            # If normal restart fails, perform a full reset
            full_dbus_reset
        fi

        # Restart kiosk service as well
        restart_kiosk
    fi

    # Check logs for D-Bus disconnection errors
    if journalctl -u dbus --no-pager -n 10 | grep -q "D-Bus connection was disconnected"; then
        log_message "Detected D-Bus disconnection! Restarting services..."
        restart_dbus_services
        restart_kiosk
    fi

    #log_message "D-Bus is running fine."

    # Wait 30 seconds before checking again
    sleep 30
done

