var rangeSliderClimate = document.getElementById("climate");
var textElementClimate = document.getElementById("climate-value");

var rangeSliderLights = document.getElementById("lights");
var textElementLights = document.getElementById("lights-value");

var rangeSliderBlinds = document.getElementById("blinds");
var textElementBlinds = document.getElementById("blinds-value");

var rangeSliderVent = document.getElementById("vent");
var textElementVent = document.getElementById("vent-value");

const WAIT_TIME = 500;

function debounce(func, wait) {
    let timeout;
    return function(...args) {
      clearTimeout(timeout);
      timeout = setTimeout(() => {
        func.apply(this, args);
      }, wait);
    };
}

rangeSliderClimate.addEventListener("change", debounce(function() {
    setRegisters({
        "register_name": "hvac.temp_1.adjust",
        "value": rangeSliderClimate.value
    });
}, WAIT_TIME));
rangeSliderClimate.addEventListener("input", function() {
    textElementClimate.innerHTML = rangeSliderClimate.value + "<span class='font-roboto text-5xl absolute pt-1 pl-2'>°C</span>";
});

rangeSliderLights.addEventListener("change", debounce(function() {
    setRegisters({
        "register_name": "light.target_illum",
        "value": rangeSliderLights.value
    });
}, WAIT_TIME));
rangeSliderLights.addEventListener("input", function() {
    textElementLights.innerHTML = rangeSliderLights.value + "<span class='font-roboto text-5xl absolute pt-1 pl-2'>%</span>";
});

rangeSliderBlinds.addEventListener("change", debounce(function() {
    setRegisters({
        "register_name": "blinds.blind_1.position",
        "value": rangeSliderBlinds.value
    });
    setRegisters({
        "register_name": "blinds.blind_2.position",
        "value": rangeSliderBlinds.value
    });
    setRegisters({
        "register_name": "blinds.blind_3.position",
        "value": rangeSliderBlinds.value
    });
    setRegisters({
        "register_name": "blinds.blind_4.position",
        "value": rangeSliderBlinds.value
    });
}, WAIT_TIME));
rangeSliderBlinds.addEventListener("input", function() {
    textElementBlinds.innerHTML = rangeSliderBlinds.value + "<span class='font-roboto text-5xl absolute pt-1 pl-2'>%</span>";
});

rangeSliderVent.addEventListener("change", debounce(function() {
    setRegisters({
        "register_name": "vent.op_setpoint_1",
        "value": rangeSliderVent.value
    });
}, WAIT_TIME));
rangeSliderVent.addEventListener("input", function() {
    textElementVent.innerHTML = rangeSliderVent.value + "<span class='font-roboto text-5xl absolute pt-1 pl-2'>%</span>";
});

function setRegisters(registers) {
    $.ajax({
        type: "POST",
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        url: '/data/post',
        data: {
            reg_values: registers,
        },
        success: function() {
            console.log("Submit successful!");
        },
        error: function(xhr, textStatus, errorThrown) {
            console.log('Register: '+errorThrown);
        }
    });
}

$(document).ready(function()
{
    function updateRangeCover($range)
    {
        var percent = (($range[0].value -  $range[0].min) / ($range[0].max - $range[0].min)) * 100;
        $range.css('background-image','-webkit-gradient(linear, left top, right top, color-stop(' + percent + '%, var(--range-full)), color-stop(' + percent + '%, var(--range-empty)))');
    }

    $('.range-slider input[type=range]').on('input', function()
    {
        updateRangeCover($(this));
    });

    $('.range-slider input[type=range]').each(function()
    {
        updateRangeCover($(this));
    });
});