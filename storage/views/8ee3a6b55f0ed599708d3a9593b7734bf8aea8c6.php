

<?php $__env->startSection('content'); ?>
<div class="bg-blue-block flex justify-center py-5">
    <h1 class="text-white font-bold text-4xl">НАСТРОЙКИ - ztmUI</h1>
</div>

<?php
if (! isset($_instance)) {
    $html = \Livewire\Livewire::mount('info', [])->html();
} elseif ($_instance->childHasBeenRendered('iIue7Se')) {
    $componentId = $_instance->getRenderedChildComponentId('iIue7Se');
    $componentTag = $_instance->getRenderedChildComponentTagName('iIue7Se');
    $html = \Livewire\Livewire::dummyMount($componentId, $componentTag);
    $_instance->preserveRenderedChild('iIue7Se');
} else {
    $response = \Livewire\Livewire::mount('info', []);
    $html = $response->html();
    $_instance->logRenderedChild('iIue7Se', $response->id(), \Livewire\Livewire::getRootElementTagName($html));
}
echo $html;
?>

<div class="relative overflow-x-auto">
    <table class="w-full text-sm text-left text-white">
        <thead class="text-xs text-white uppercase bg-blue-block">
            <tr>
                <th scope="col" class="px-6 py-3">
                    Действие
                </th>
                <th scope="col" class="px-6 py-3">
                    Стойност
                </th>
                <th scope="col" class="px-6 py-3">
                    Дата на събитие
                </th>
            </tr>
        </thead>
        <tbody>
            <?php $__empty_1 = true; $__currentLoopData = $logs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $log): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
            <tr class="bg-blue-dark border-b border-blue-block">
                <?php if($log->action == 'Админ пин приет' || $log->action == 'Ресет пин приет'): ?>
                <th scope="row" class="px-6 py-4 font-medium text-green-500 whitespace-nowrap">
                    <?php echo e($log->action); ?>

                </th>
                <td class="px-6 py-4">
                    <?php echo e($log->action_value); ?>

                </td>
                <?php else: ?>
                <th scope="row" class="px-6 py-4 font-medium text-red-500 whitespace-nowrap">
                    <?php echo e($log->action); ?>

                </th>
                <td class="px-6 py-4">
                    <?php echo e($log->action_value); ?>

                </td>
                <?php endif; ?>
                <td class="px-6 py-4">
                    <?php echo e($log->created_at); ?>

                </td>
            </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
            <tr class="bg-blue-dark border-b border-blue-block">
                <th scope="row" class="px-6 py-4 font-medium text-white whitespace-nowrap">
                    Няма намерени параметри в базата данни!
                </th>
                <td></td>
                <td></td>
            </tr>
            <?php endif; ?>
        </tbody>
    </table>
    <?php echo e($logs->links()); ?>

</div>
<?php $__env->startPush('js'); ?>
<script src="<?php echo e(asset('js/auth.js')); ?>"></script>
<?php $__env->stopPush(); ?>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\laragon\www\ztm_ui\resources\views/panel/logs.blade.php ENDPATH**/ ?>