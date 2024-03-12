

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
} elseif ($_instance->childHasBeenRendered('70NUd7c')) {
    $componentId = $_instance->getRenderedChildComponentId('70NUd7c');
    $componentTag = $_instance->getRenderedChildComponentTagName('70NUd7c');
    $html = \Livewire\Livewire::dummyMount($componentId, $componentTag);
    $_instance->preserveRenderedChild('70NUd7c');
} else {
    $response = \Livewire\Livewire::mount('climate', []);
    $html = $response->html();
    $_instance->logRenderedChild('70NUd7c', $response->id(), \Livewire\Livewire::getRootElementTagName($html));
}
echo $html;
?>
    </div>
    <div class="bg-blue-block rounded-3xl">
        <?php
if (! isset($_instance)) {
    $html = \Livewire\Livewire::mount('lights', [])->html();
} elseif ($_instance->childHasBeenRendered('pVUtjt7')) {
    $componentId = $_instance->getRenderedChildComponentId('pVUtjt7');
    $componentTag = $_instance->getRenderedChildComponentTagName('pVUtjt7');
    $html = \Livewire\Livewire::dummyMount($componentId, $componentTag);
    $_instance->preserveRenderedChild('pVUtjt7');
} else {
    $response = \Livewire\Livewire::mount('lights', []);
    $html = $response->html();
    $_instance->logRenderedChild('pVUtjt7', $response->id(), \Livewire\Livewire::getRootElementTagName($html));
}
echo $html;
?>
    </div>
    <div class="mt-5">
        <div class="flex justify-center">
            <img id="forecast_icon_1" class="inline pr-10" width="100px" alt="weather1" />
            <p id="forecast_temp_1" class="text-gray-dark font-roboto text-5xl">0°C</p>
        </div>
        <div class="flex justify-center mt-5">
            <p class="text-teal-custom font-roboto pr-14 text-2xl">СЛЕД 3 ЧАСА <span id="forecast_temp_2">0°C</span></p>
            <img id="forecast_icon_2" width="45px" class="inline" alt="weather2" />
        </div>
        <div class="flex justify-center mt-3">
            <p class="text-teal-custom font-roboto pr-14 text-2xl">СЛЕД 6 ЧАСА <span id="forecast_temp_3">0°C</span></p>
            <img id="forecast_icon_3" width="45px" class="inline" alt="weather3" />
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
} elseif ($_instance->childHasBeenRendered('AUJwgSu')) {
    $componentId = $_instance->getRenderedChildComponentId('AUJwgSu');
    $componentTag = $_instance->getRenderedChildComponentTagName('AUJwgSu');
    $html = \Livewire\Livewire::dummyMount($componentId, $componentTag);
    $_instance->preserveRenderedChild('AUJwgSu');
} else {
    $response = \Livewire\Livewire::mount('vent', []);
    $html = $response->html();
    $_instance->logRenderedChild('AUJwgSu', $response->id(), \Livewire\Livewire::getRootElementTagName($html));
}
echo $html;
?>
    </div>
    <div class="bg-blue-block rounded-3xl">
        <?php
if (! isset($_instance)) {
    $html = \Livewire\Livewire::mount('blinds', [])->html();
} elseif ($_instance->childHasBeenRendered('B026lLh')) {
    $componentId = $_instance->getRenderedChildComponentId('B026lLh');
    $componentTag = $_instance->getRenderedChildComponentTagName('B026lLh');
    $html = \Livewire\Livewire::dummyMount($componentId, $componentTag);
    $_instance->preserveRenderedChild('B026lLh');
} else {
    $response = \Livewire\Livewire::mount('blinds', []);
    $html = $response->html();
    $_instance->logRenderedChild('B026lLh', $response->id(), \Livewire\Livewire::getRootElementTagName($html));
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
                    console.log(response);
                    $('#forecast_temp_1').empty();
                    $('#forecast_temp_2').empty();
                    $('#forecast_temp_3').empty();
                    //Icon
                    var forecast_icon_url1 = 'weather-icons/' + response["envm.forecast.icon_0"].value + '.svg';
                    var forecast_icon_url2 = 'weather-icons/' + response["envm.forecast.icon_3"].value + '.svg';
                    var forecast_icon_url3 = 'weather-icons/' + response["envm.forecast.icon_6"].value + '.svg';
                    $('#forecast_icon_1').attr('src', forecast_icon_url1);
                    $('#forecast_icon_2').attr('src', forecast_icon_url2);
                    $('#forecast_icon_3').attr('src', forecast_icon_url3);
                    //Temp
                    $('#forecast_temp_1').append(response["envm.forecast.temp_0"].value + '°C');
                    $('#forecast_temp_2').append(response["envm.forecast.temp_3"].value + '°C');
                    $('#forecast_temp_3').append(response["envm.forecast.temp_6"].value + '°C');
                },
                error: function(xhr, status, error) {
                    console.error(error);
                }
            });
        }

        fetchWeather();
        setInterval(fetchWeather, 300000);
    });
</script>
<?php $__env->stopPush(); ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\laragon\www\ztm_ui\resources\views/welcome.blade.php ENDPATH**/ ?>