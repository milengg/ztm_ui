var idleTime = 0;

$(document).ready(function () {
    var idleInterval = setInterval(timerIncrement, 1000);

    $(this).on('mousemove touchmove mousedown touchstart keypress', function(e) {
        idleTime = 0;
    });
});

function timerIncrement() {
    idleTime = idleTime + 1;
    if (idleTime >= 10) {
        document.getElementById("climate").disabled = true;
        document.getElementById("lights").disabled = true;
        document.getElementById("blinds").disabled = true;
        document.getElementById("vent").disabled = true;
        document.getElementById("lock_button").disabled = false;
    }
}

function pinScreen() {
    document.getElementById("lock").classList.remove("hidden");
}