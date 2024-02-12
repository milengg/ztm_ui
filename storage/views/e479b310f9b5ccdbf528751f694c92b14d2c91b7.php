

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
} elseif ($_instance->childHasBeenRendered('ii3zKsR')) {
    $componentId = $_instance->getRenderedChildComponentId('ii3zKsR');
    $componentTag = $_instance->getRenderedChildComponentTagName('ii3zKsR');
    $html = \Livewire\Livewire::dummyMount($componentId, $componentTag);
    $_instance->preserveRenderedChild('ii3zKsR');
} else {
    $response = \Livewire\Livewire::mount('climate', []);
    $html = $response->html();
    $_instance->logRenderedChild('ii3zKsR', $response->id(), \Livewire\Livewire::getRootElementTagName($html));
}
echo $html;
?>
    </div>
    <div class="bg-blue-block rounded-3xl">
        <?php
if (! isset($_instance)) {
    $html = \Livewire\Livewire::mount('lights', [])->html();
} elseif ($_instance->childHasBeenRendered('cVkVxes')) {
    $componentId = $_instance->getRenderedChildComponentId('cVkVxes');
    $componentTag = $_instance->getRenderedChildComponentTagName('cVkVxes');
    $html = \Livewire\Livewire::dummyMount($componentId, $componentTag);
    $_instance->preserveRenderedChild('cVkVxes');
} else {
    $response = \Livewire\Livewire::mount('lights', []);
    $html = $response->html();
    $_instance->logRenderedChild('cVkVxes', $response->id(), \Livewire\Livewire::getRootElementTagName($html));
}
echo $html;
?>
    </div>
    <div class="mt-5">
        <div class="flex justify-center">
            <img id="forecast_icon_1" class="inline pr-10" width="120px" alt="weather1" />
            <p id="forecast_temp_1" class="text-gray-dark font-roboto text-6xl">0°C</p>
        </div>
        <div class="flex justify-center mt-5">
            <p class="text-teal-custom font-roboto pr-14 text-2xl">СЛЕД 3 ЧАСА <span id="forecast_temp_2">0°C</span></p>
            <img id="forecast_icon_2" width="60px" class="inline" alt="weather2" />
        </div>
        <div class="flex justify-center mt-3">
            <p class="text-teal-custom font-roboto pr-14 text-2xl">СЛЕД 6 ЧАСА <span id="forecast_temp_3">0°C</span></p>
            <img id="forecast_icon_3" width="60px" class="inline" alt="weather3" />
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
} elseif ($_instance->childHasBeenRendered('vXAbGzQ')) {
    $componentId = $_instance->getRenderedChildComponentId('vXAbGzQ');
    $componentTag = $_instance->getRenderedChildComponentTagName('vXAbGzQ');
    $html = \Livewire\Livewire::dummyMount($componentId, $componentTag);
    $_instance->preserveRenderedChild('vXAbGzQ');
} else {
    $response = \Livewire\Livewire::mount('vent', []);
    $html = $response->html();
    $_instance->logRenderedChild('vXAbGzQ', $response->id(), \Livewire\Livewire::getRootElementTagName($html));
}
echo $html;
?>
    </div>
    <div class="bg-blue-block rounded-3xl">
        <?php
if (! isset($_instance)) {
    $html = \Livewire\Livewire::mount('blinds', [])->html();
} elseif ($_instance->childHasBeenRendered('9VMKINb')) {
    $componentId = $_instance->getRenderedChildComponentId('9VMKINb');
    $componentTag = $_instance->getRenderedChildComponentTagName('9VMKINb');
    $html = \Livewire\Livewire::dummyMount($componentId, $componentTag);
    $_instance->preserveRenderedChild('9VMKINb');
} else {
    $response = \Livewire\Livewire::mount('blinds', []);
    $html = $response->html();
    $_instance->logRenderedChild('9VMKINb', $response->id(), \Livewire\Livewire::getRootElementTagName($html));
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
        setInterval(fetchWeather, 900000);
    });
</script>
<?php $__env->stopPush(); ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\laragon\www\ztm_ui\resources\views/welcome.blade.php ENDPATH**/ ?>