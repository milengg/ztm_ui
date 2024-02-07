

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
} elseif ($_instance->childHasBeenRendered('VZpVGqX')) {
    $componentId = $_instance->getRenderedChildComponentId('VZpVGqX');
    $componentTag = $_instance->getRenderedChildComponentTagName('VZpVGqX');
    $html = \Livewire\Livewire::dummyMount($componentId, $componentTag);
    $_instance->preserveRenderedChild('VZpVGqX');
} else {
    $response = \Livewire\Livewire::mount('climate', []);
    $html = $response->html();
    $_instance->logRenderedChild('VZpVGqX', $response->id(), \Livewire\Livewire::getRootElementTagName($html));
}
echo $html;
?>
    </div>
    <div class="bg-blue-block rounded-3xl">
        <?php
if (! isset($_instance)) {
    $html = \Livewire\Livewire::mount('lights', [])->html();
} elseif ($_instance->childHasBeenRendered('VUrBn58')) {
    $componentId = $_instance->getRenderedChildComponentId('VUrBn58');
    $componentTag = $_instance->getRenderedChildComponentTagName('VUrBn58');
    $html = \Livewire\Livewire::dummyMount($componentId, $componentTag);
    $_instance->preserveRenderedChild('VUrBn58');
} else {
    $response = \Livewire\Livewire::mount('lights', []);
    $html = $response->html();
    $_instance->logRenderedChild('VUrBn58', $response->id(), \Livewire\Livewire::getRootElementTagName($html));
}
echo $html;
?>
    </div>
    <div class="mt-5">
        <div class="flex justify-center">
            <img class="inline pr-10" src="<?php echo e(asset('img/weather/thunders.png')); ?>" alt="weather" />
            <p class="text-gray-dark font-roboto text-6xl">26°C</p>
        </div>
        <div class="flex justify-center mt-5">
            <p class="text-teal-custom font-roboto pr-14 text-2xl">СЛЕД 3 ЧАСА 26°C</p>
            <img class="inline" src="<?php echo e(asset('img/weather/rain.png')); ?>" alt="weather" />
        </div>
        <div class="flex justify-center mt-3">
            <p class="text-teal-custom font-roboto pr-14 text-2xl">СЛЕД 6 ЧАСА 16°C</p>
            <img class="inline" src="<?php echo e(asset('img/weather/rain.png')); ?>" alt="weather" />
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
} elseif ($_instance->childHasBeenRendered('vMwmhwC')) {
    $componentId = $_instance->getRenderedChildComponentId('vMwmhwC');
    $componentTag = $_instance->getRenderedChildComponentTagName('vMwmhwC');
    $html = \Livewire\Livewire::dummyMount($componentId, $componentTag);
    $_instance->preserveRenderedChild('vMwmhwC');
} else {
    $response = \Livewire\Livewire::mount('vent', []);
    $html = $response->html();
    $_instance->logRenderedChild('vMwmhwC', $response->id(), \Livewire\Livewire::getRootElementTagName($html));
}
echo $html;
?>
    </div>
    <div class="bg-blue-block rounded-3xl">
        <?php
if (! isset($_instance)) {
    $html = \Livewire\Livewire::mount('blinds', [])->html();
} elseif ($_instance->childHasBeenRendered('iFpuTXH')) {
    $componentId = $_instance->getRenderedChildComponentId('iFpuTXH');
    $componentTag = $_instance->getRenderedChildComponentTagName('iFpuTXH');
    $html = \Livewire\Livewire::dummyMount($componentId, $componentTag);
    $_instance->preserveRenderedChild('iFpuTXH');
} else {
    $response = \Livewire\Livewire::mount('blinds', []);
    $html = $response->html();
    $_instance->logRenderedChild('iFpuTXH', $response->id(), \Livewire\Livewire::getRootElementTagName($html));
}
echo $html;
?>
    </div>
</div>
<?php $__env->startPush('js'); ?>
<script src="<?php echo e(asset('js/clock.js')); ?>"></script>
<script src="<?php echo e(asset('js/functions.js')); ?>"></script>
<script src="<?php echo e(asset('js/lock.js')); ?>"></script>
<?php $__env->stopPush(); ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\laragon\www\ztm_ui\resources\views/welcome.blade.php ENDPATH**/ ?>