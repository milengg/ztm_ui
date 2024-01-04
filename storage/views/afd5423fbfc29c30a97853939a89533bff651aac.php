

<?php $__env->startSection('content'); ?>
<div class="grid grid-cols-3 gap-4 m-5 pt-2">
    <div>
        <div class="flex justify-between px-14">
            <!--<p class="text-teal-custom font-roboto font-bold text-4xl">BCVT LOGO</p>-->
            <img src="<?php echo e(asset('img/bcvt-logo.png')); ?>" alt="bcvt logo" />
            <button id="lock_button" onclick="pinScreen()" disabled>
                <img src="<?php echo e(asset('img/icons/settings.png')); ?>" alt="settings"/>
            </button>
        </div>
        <div class="mt-3 text-center">
            <p class="text-white font-roboto text-2xl font-bold"> <?php echo e($hostname->parameter_value); ?></p>
        </div>
        <div class="flex flex-col text-center mt-3">
            <div id="clock" class="text-white text-center font-roboto text-9xl"><?php echo e(date('H:i')); ?></div>
            <div id="date" class="text-teal-dark text-center font-roboto pl-5 mt-5 text-5xl"><?php echo e(bgDate('d M Y')); ?></div>
        </div>
    </div>
    <div class="bg-blue-block rounded-3xl">
        <?php
if (! isset($_instance)) {
    $html = \Livewire\Livewire::mount('climate', [])->html();
} elseif ($_instance->childHasBeenRendered('9j2z5d1')) {
    $componentId = $_instance->getRenderedChildComponentId('9j2z5d1');
    $componentTag = $_instance->getRenderedChildComponentTagName('9j2z5d1');
    $html = \Livewire\Livewire::dummyMount($componentId, $componentTag);
    $_instance->preserveRenderedChild('9j2z5d1');
} else {
    $response = \Livewire\Livewire::mount('climate', []);
    $html = $response->html();
    $_instance->logRenderedChild('9j2z5d1', $response->id(), \Livewire\Livewire::getRootElementTagName($html));
}
echo $html;
?>
    </div>
    <div class="bg-blue-block rounded-3xl">
        <?php
if (! isset($_instance)) {
    $html = \Livewire\Livewire::mount('lights', [])->html();
} elseif ($_instance->childHasBeenRendered('p3MwJmr')) {
    $componentId = $_instance->getRenderedChildComponentId('p3MwJmr');
    $componentTag = $_instance->getRenderedChildComponentTagName('p3MwJmr');
    $html = \Livewire\Livewire::dummyMount($componentId, $componentTag);
    $_instance->preserveRenderedChild('p3MwJmr');
} else {
    $response = \Livewire\Livewire::mount('lights', []);
    $html = $response->html();
    $_instance->logRenderedChild('p3MwJmr', $response->id(), \Livewire\Livewire::getRootElementTagName($html));
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
        <div class="flex justify-center mt-7">
            <img class="rounded" src="<?php echo e(asset('img/bcvt-qr.png')); ?>" width="100" alt="qr code" />
        </div>
        <div class="flex justify-center mt-3">
            <p class="text-white font-roboto">версия на софтуера: v.<?php echo e($version); ?></p>
        </div>
    </div>
    <div class="bg-blue-block rounded-3xl">
        <?php
if (! isset($_instance)) {
    $html = \Livewire\Livewire::mount('vent', [])->html();
} elseif ($_instance->childHasBeenRendered('PxSlQM2')) {
    $componentId = $_instance->getRenderedChildComponentId('PxSlQM2');
    $componentTag = $_instance->getRenderedChildComponentTagName('PxSlQM2');
    $html = \Livewire\Livewire::dummyMount($componentId, $componentTag);
    $_instance->preserveRenderedChild('PxSlQM2');
} else {
    $response = \Livewire\Livewire::mount('vent', []);
    $html = $response->html();
    $_instance->logRenderedChild('PxSlQM2', $response->id(), \Livewire\Livewire::getRootElementTagName($html));
}
echo $html;
?>
    </div>
    <div class="bg-blue-block rounded-3xl">
        <?php
if (! isset($_instance)) {
    $html = \Livewire\Livewire::mount('blinds', [])->html();
} elseif ($_instance->childHasBeenRendered('XanGpJ6')) {
    $componentId = $_instance->getRenderedChildComponentId('XanGpJ6');
    $componentTag = $_instance->getRenderedChildComponentTagName('XanGpJ6');
    $html = \Livewire\Livewire::dummyMount($componentId, $componentTag);
    $_instance->preserveRenderedChild('XanGpJ6');
} else {
    $response = \Livewire\Livewire::mount('blinds', []);
    $html = $response->html();
    $_instance->logRenderedChild('XanGpJ6', $response->id(), \Livewire\Livewire::getRootElementTagName($html));
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

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\laragon\www\ztmUI-prod\resources\views/welcome.blade.php ENDPATH**/ ?>