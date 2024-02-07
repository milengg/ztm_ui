

<?php $__env->startSection('content'); ?>
<div class="grid grid-cols-3 gap-4 m-5 pt-2">
    <div>
        <div class="flex justify-between mt-3 px-14">
            <img src="<?php echo e(asset('img/bcvt-logo.png')); ?>" alt="bcvt logo" />
            <button id="lock_button" onclick="pinScreen()" disabled>
                <img src="<?php echo e(asset('img/icons/settings.png')); ?>" alt="settings"/>
            </button>
        </div>
        <div class="flex flex-col text-center mt-8">
            <div id="clock" class="text-white text-center font-roboto text-9xl"><?php echo e(date('H:i')); ?></div>
            <div id="date" class="text-teal-dark text-center font-roboto pl-5 mt-5 text-5xl"><?php echo e(bgDate('d M Y')); ?></div>
        </div>
    </div>
    <div class="bg-blue-block rounded-3xl">
        <?php
if (! isset($_instance)) {
    $html = \Livewire\Livewire::mount('climate', [])->html();
} elseif ($_instance->childHasBeenRendered('1XZVKjG')) {
    $componentId = $_instance->getRenderedChildComponentId('1XZVKjG');
    $componentTag = $_instance->getRenderedChildComponentTagName('1XZVKjG');
    $html = \Livewire\Livewire::dummyMount($componentId, $componentTag);
    $_instance->preserveRenderedChild('1XZVKjG');
} else {
    $response = \Livewire\Livewire::mount('climate', []);
    $html = $response->html();
    $_instance->logRenderedChild('1XZVKjG', $response->id(), \Livewire\Livewire::getRootElementTagName($html));
}
echo $html;
?>
    </div>
    <div class="bg-blue-block rounded-3xl">
        <?php
if (! isset($_instance)) {
    $html = \Livewire\Livewire::mount('lights', [])->html();
} elseif ($_instance->childHasBeenRendered('50RRFx5')) {
    $componentId = $_instance->getRenderedChildComponentId('50RRFx5');
    $componentTag = $_instance->getRenderedChildComponentTagName('50RRFx5');
    $html = \Livewire\Livewire::dummyMount($componentId, $componentTag);
    $_instance->preserveRenderedChild('50RRFx5');
} else {
    $response = \Livewire\Livewire::mount('lights', []);
    $html = $response->html();
    $_instance->logRenderedChild('50RRFx5', $response->id(), \Livewire\Livewire::getRootElementTagName($html));
}
echo $html;
?>
    </div>
    <div class="mt-5">
        <div class="flex justify-center">
            <img id="forecast_icon_1" class="inline pr-10" width="160px" alt="weather1" />
            <p id="forecast_temp_1" class="text-gray-dark font-roboto text-6xl">0°C</p>
        </div>
        <div class="flex justify-center mt-5">
            <p class="text-teal-custom font-roboto pr-14 text-2xl">СЛЕД 3 ЧАСА <span id="forecast_temp_2">0°C</span></p>
            <img id="forecast_icon_2" width="75px" class="inline" alt="weather2" />
        </div>
        <div class="flex justify-center mt-3">
            <p class="text-teal-custom font-roboto pr-14 text-2xl">СЛЕД 6 ЧАСА <span id="forecast_temp_3">0°C</span></p>
            <img id="forecast_icon_3" width="75px" class="inline" alt="weather3" />
        </div>
        <div class="flex justify-between mx-14 mt-7">
            <div class="mt-8 text-center">
                <p class="text-white font-roboto font-bold text-4xl"><?php echo e($hostname->parameter_value ?? 'ЛИПСВА'); ?></p>
            </div>
            <img class="rounded" src="<?php echo e(asset('img/bcvt-qr.png')); ?>" width="100" alt="qr code" />
        </div>
        <div class="flex justify-center mt-3">
            <p class="text-white font-roboto">версия на ztmUI: v.<?php echo e($version); ?></p>
        </div>
    </div>
    <div class="bg-blue-block rounded-3xl">
        <?php
if (! isset($_instance)) {
    $html = \Livewire\Livewire::mount('vent', [])->html();
} elseif ($_instance->childHasBeenRendered('uY3rUZS')) {
    $componentId = $_instance->getRenderedChildComponentId('uY3rUZS');
    $componentTag = $_instance->getRenderedChildComponentTagName('uY3rUZS');
    $html = \Livewire\Livewire::dummyMount($componentId, $componentTag);
    $_instance->preserveRenderedChild('uY3rUZS');
} else {
    $response = \Livewire\Livewire::mount('vent', []);
    $html = $response->html();
    $_instance->logRenderedChild('uY3rUZS', $response->id(), \Livewire\Livewire::getRootElementTagName($html));
}
echo $html;
?>
    </div>
    <div class="bg-blue-block rounded-3xl">
        <?php
if (! isset($_instance)) {
    $html = \Livewire\Livewire::mount('blinds', [])->html();
} elseif ($_instance->childHasBeenRendered('EqcQEVZ')) {
    $componentId = $_instance->getRenderedChildComponentId('EqcQEVZ');
    $componentTag = $_instance->getRenderedChildComponentTagName('EqcQEVZ');
    $html = \Livewire\Livewire::dummyMount($componentId, $componentTag);
    $_instance->preserveRenderedChild('EqcQEVZ');
} else {
    $response = \Livewire\Livewire::mount('blinds', []);
    $html = $response->html();
    $_instance->logRenderedChild('EqcQEVZ', $response->id(), \Livewire\Livewire::getRootElementTagName($html));
}
echo $html;
?>
    </div>
</div>
<?php $__env->startPush('js'); ?>
<script src="<?php echo e(asset('js/clock.js')); ?>"></script>
<script src="<?php echo e(asset('js/functions.js')); ?>"></script>
<script src="<?php echo e(asset('js/lock.js')); ?>"></script>
<script>
    $(document).ready(function() {
        function fetchWeather() {
            $.ajax({
                url: '/weather',
                type: 'GET',
                dataType: 'json',
                success: function(response) {
                    $('#forecast_temp_1').empty();
                    $('#forecast_temp_2').empty();
                    $('#forecast_temp_3').empty();
                    //Icon
                    var forecast_icon_url1 = 'weather-icons/' + response[4].value + '.svg';
                    var forecast_icon_url2 = 'weather-icons/' + response[8].value + '.svg';
                    var forecast_icon_url3 = 'weather-icons/' + response[12].value + '.svg';
                    $('#forecast_icon_1').attr('src', forecast_icon_url1);
                    $('#forecast_icon_2').attr('src', forecast_icon_url2);
                    $('#forecast_icon_3').attr('src', forecast_icon_url3);
                    //Temp
                    $('#forecast_temp_1').append(response[6].value + '°C');
                    $('#forecast_temp_2').append(response[10].value + '°C');
                    $('#forecast_temp_3').append(response[14].value + '°C');
                },
                error: function(xhr, status, error) {
                    console.error(error);
                }
            });
        }

        fetchWeather();
        setInterval(fetchWeather, 5000);
    });
</script>
<?php $__env->stopPush(); ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\laragon\www\ztm_ui\resources\views/welcome.blade.php ENDPATH**/ ?>