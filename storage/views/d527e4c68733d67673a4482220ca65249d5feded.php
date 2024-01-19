

<?php $__env->startSection('content'); ?>
<div class="bg-blue-block flex justify-center py-5">
    <h1 class="text-white font-bold text-4xl">НАСТРОЙКИ - ztmUI</h1>
</div>

<?php
if (! isset($_instance)) {
    $html = \Livewire\Livewire::mount('info', [])->html();
} elseif ($_instance->childHasBeenRendered('eF2ztOl')) {
    $componentId = $_instance->getRenderedChildComponentId('eF2ztOl');
    $componentTag = $_instance->getRenderedChildComponentTagName('eF2ztOl');
    $html = \Livewire\Livewire::dummyMount($componentId, $componentTag);
    $_instance->preserveRenderedChild('eF2ztOl');
} else {
    $response = \Livewire\Livewire::mount('info', []);
    $html = $response->html();
    $_instance->logRenderedChild('eF2ztOl', $response->id(), \Livewire\Livewire::getRootElementTagName($html));
}
echo $html;
?>

<div class="relative overflow-x-auto">
    <table class="w-full text-sm text-left text-white">
        <thead class="text-xs text-white uppercase bg-blue-block">
            <tr>
                <th scope="col" class="px-6 py-3">
                    Параметър
                </th>
                <th scope="col" class="px-6 py-3">
                    Стойност
                </th>
                <th scope="col" class="px-6 py-3">
                    Синхронизация bgERP
                </th>
                <th scope="col" class="px-6 py-3">
                    Действия
                </th>
            </tr>
        </thead>
        <tbody>
            <?php $__empty_1 = true; $__currentLoopData = $settings; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $setting): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
            <tr class="bg-blue-dark border-b border-blue-block">
                <th scope="row" class="px-6 py-4 font-medium text-white whitespace-nowrap">
                    <?php echo e($setting->parameter_name); ?>

                </th>
                <td class="px-6 py-4">
                    <?php echo e($setting->parameter_value); ?>

                </td>
                <td class="px-6 py-4">
                    <?php echo e($setting->bgerp_sync ? 'Да':'Не'); ?>

                </td>
                <?php if($setting->parameter_name != 'serial_number' && $setting->parameter_name != 'updater_version'): ?>
                <td class="px-6 py-4">
                    <a href="<?php echo e(route('admin.edit.parameter', $setting->id)); ?>" class="text-purple-700 hover:text-white border border-purple-700 hover:bg-purple-800 focus:ring-4 focus:outline-none focus:ring-purple-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:border-purple-400 dark:text-purple-400 dark:hover:text-white dark:hover:bg-purple-500 dark:focus:ring-purple-900">
                        Редакция
                    </a>
                </td>
                <?php else: ?>
                <td class="px-6 py-4"></td>
                <?php endif; ?>
            </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
            <tr class="bg-blue-dark border-b border-blue-block">
                <th scope="row" class="px-6 py-4 font-medium text-white whitespace-nowrap">
                    Няма намерени параметри в базата данни!
                </th>
                <td></td>
                <td></td>
                <td></td>
            </tr>
            <?php endif; ?>
        </tbody>
    </table>
    <?php echo e($settings->links()); ?>

</div>
<?php $__env->startPush('js'); ?>
<script src="<?php echo e(asset('js/auth.js')); ?>"></script>
<?php $__env->stopPush(); ?>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\laragon\www\ztm_ui\resources\views/panel/index.blade.php ENDPATH**/ ?>