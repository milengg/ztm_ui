#!/bin/bash

xset -dpms
xset s off
openbox-session &

while true; do
  xrandr -s 1280x800
  rm -rf ~/.{config,cache}/google-chrome/
  google-chrome --kiosk --incognito --no-experiments --noerrdialogs --simulate-outdated-no-au="Tue, 31 Dec 2120 23:59:59 GMT" --disable-infobars --disable-pinch --overscroll-history-navigation=0 --no-first-run  'http://localhost'

  # Monitor the D-Bus connection
  while true; do
    if ! dbus-send --session --dest=org.freedesktop.DBus --type=method_call \
      /org/freedesktop/DBus org.freedesktop.DBus.ListNames &>/dev/null; then
      echo "D-Bus connection lost. Restarting kiosk..."
      sleep 5
      systemctl restart kiosk.service
      exit 1
    fi
    sleep 2
  done
done
