

<?php $__env->startSection('content'); ?>
<div class="bg-blue-block flex justify-center py-5">
    <h1 class="text-white font-bold text-4xl">НАСТРОЙКИ - ztmUI</h1>
</div>

<?php
if (! isset($_instance)) {
    $html = \Livewire\Livewire::mount('info', [])->html();
} elseif ($_instance->childHasBeenRendered('sSrgNFl')) {
    $componentId = $_instance->getRenderedChildComponentId('sSrgNFl');
    $componentTag = $_instance->getRenderedChildComponentTagName('sSrgNFl');
    $html = \Livewire\Livewire::dummyMount($componentId, $componentTag);
    $_instance->preserveRenderedChild('sSrgNFl');
} else {
    $response = \Livewire\Livewire::mount('info', []);
    $html = $response->html();
    $_instance->logRenderedChild('sSrgNFl', $response->id(), \Livewire\Livewire::getRootElementTagName($html));
}
echo $html;
?>

<div class="bg-blue-block p-10">
    <p class="text-xl text-white mb-5">Редактиране на параметър - <?php echo e($parameter->parameter_name); ?></p>
    <form method="POST" action="<?php echo e(route('admin.update.parameter', $parameter->id)); ?>">
      <?php echo csrf_field(); ?>
      <div class="mb-6">
        <label for="parameter_name" class="block mb-2 text-sm font-medium text-white">Параметър име</label>
        <input type="text" name="parameter_name" data-kioskboard-type="all" data-kioskboard-placement="bottom" data-kioskboard-specialcharacters="false" class="js-virtual-keyboard bg-gray-700 border border-gray-600 placeholder-gray-400 text-white text-sm rounded-lg block w-full p-2.5" value="<?php echo e($parameter->parameter_name); ?>" readonly>
      </div>
      <?php if($parameter->parameter_name == 'mode'): ?>
      <div class="mb-6">
        <label for="parameter_value" class="block mb-2 text-sm font-medium text-white">Параметър стойност</label>
        <select name="parameter_value" class="bg-gray-700 border border-gray-600 placeholder-gray-400 text-white text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5">
            <?php if($parameter->parameter_value == 'server'): ?>
            <option value="server" selected>Сървър</option>
            <option value="client">Клиент</option>
            <?php elseif($parameter->parameter_value == 'client'): ?>
            <option value="server">Сървър</option>
            <option value="client" selected>Клиент</option>
            <?php endif; ?>
        </select>
      </div>
      <?php else: ?>
      <div class="mb-6">
        <label for="parameter_value" class="block mb-2 text-sm font-medium text-white">Параметър стойност</label>
        <input type="text" name="parameter_value" data-kioskboard-type="all" data-kioskboard-placement="bottom" data-kioskboard-specialcharacters="false" class="js-virtual-keyboard bg-gray-700 border border-gray-600 placeholder-gray-400 text-white text-sm rounded-lg block w-full p-2.5" value="<?php echo e($parameter->parameter_value); ?>" required>
      </div>
      <?php endif; ?>
      <button type="submit" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Редактиране</button>
      <button type="button" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800" onclick="window.location.href='<?php echo e(route('admin.main')); ?>'">Отказ</button>
    </form>
</div>
<?php $__env->startPush('js'); ?>
<script src="<?php echo e(asset('js/keyboard-init.js')); ?>"></script>
<script>
    KioskBoard.run('.js-virtual-keyboard', {});
</script>
<script src="<?php echo e(asset('js/auth.js')); ?>"></script>
<?php $__env->stopPush(); ?>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\laragon\www\ztm_ui\resources\views/settings/edit_parameter.blade.php ENDPATH**/ ?>