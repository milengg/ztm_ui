

<?php $__env->startSection('content'); ?>
<div class="bg-blue-block flex justify-center py-5">
    <h1 class="text-white font-bold text-4xl">НАСТРОЙКИ - ztmUI</h1>
</div>

<?php
if (! isset($_instance)) {
    $html = \Livewire\Livewire::mount('info', [])->html();
} elseif ($_instance->childHasBeenRendered('X5syYle')) {
    $componentId = $_instance->getRenderedChildComponentId('X5syYle');
    $componentTag = $_instance->getRenderedChildComponentTagName('X5syYle');
    $html = \Livewire\Livewire::dummyMount($componentId, $componentTag);
    $_instance->preserveRenderedChild('X5syYle');
} else {
    $response = \Livewire\Livewire::mount('info', []);
    $html = $response->html();
    $_instance->logRenderedChild('X5syYle', $response->id(), \Livewire\Livewire::getRootElementTagName($html));
}
echo $html;
?>

<div class="mt-2 mx-4">
    <div class="grid grid-cols-4 gap-4">
    <?php $__empty_1 = true; $__currentLoopData = $contents; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $content): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
        <div>
            <p class="text-white font-bold">Версия ъпдейт: <?php echo e($content->version); ?></p>
            <p class="text-white">Тип: <?php echo e($content->type); ?></p>
            <p class="text-white">Промени: <?php echo e($content->content); ?></p>
        </div>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
        <div>
            <p class="text-white font-bold">няма данни за момента </p>
        </div>
    <?php endif; ?>
    </div>
</div>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\laragon\www\ztm_ui\resources\views/panel/changelog.blade.php ENDPATH**/ ?>