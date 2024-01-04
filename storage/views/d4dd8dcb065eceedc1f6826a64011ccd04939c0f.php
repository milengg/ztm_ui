<div class="grid grid-cols-1">
    <div class="bg-blue-dark p-4">
        <div class="flex justify-between">
            <div>
                <?php if(checkMode() == 'server'): ?>
                <h1 class="text-white text-2xl mb-2">Тази система е: <span class="bg-green-100 text-green-800 text-sm font-medium mr-2 px-2.5 py-0.5 rounded dark:bg-green-900 dark:text-green-300">Сървър</span></h2>
                <?php elseif(checkmode() == 'client'): ?>
                <h1 class="text-white text-2xl mb-2">Тази система е: <span class="bg-green-100 text-green-800 text-sm font-medium mr-2 px-2.5 py-0.5 rounded dark:bg-green-900 dark:text-green-300">Клиент</span></h2>
                <?php else: ?>
                <h1 class="text-white text-2xl mb-2">Тази система е: <span class="bg-red-100 text-red-800 text-sm font-medium mr-2 px-2.5 py-0.5 rounded dark:bg-red-900 dark:text-red-300">Липсва настройка</span></h2>
                <?php endif; ?>
            </div>
            <div>
                <?php if(checkMode() == 'server'): ?>
                    <button type="button" class="text-blue-700 hover:text-white border border-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center mr-2 mb-2 dark:border-blue-500 dark:text-blue-500 dark:hover:text-white dark:hover:bg-blue-500 dark:focus:ring-blue-800" onclick="window.location.href='<?php echo e(route('admin.clients')); ?>'">ТАБЛЕТИ</button>
                <?php elseif(checkMode() == 'client'): ?>
                    <button type="button" class="text-blue-700 hover:text-white border border-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center mr-2 mb-2 dark:border-blue-500 dark:text-blue-500 dark:hover:text-white dark:hover:bg-blue-500 dark:focus:ring-blue-800" onclick="window.location.href='<?php echo e(route('admin.clients')); ?>'">СЪРВЪР</button>
                <?php endif; ?>
                <button type="button" class="text-blue-700 hover:text-white border border-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center mr-2 mb-2 dark:border-blue-500 dark:text-blue-500 dark:hover:text-white dark:hover:bg-blue-500 dark:focus:ring-blue-800" onclick="window.location.href='<?php echo e(route('admin.main')); ?>'">ПАРАМЕТРИ</button>
                <button type="button" class="text-blue-700 hover:text-white border border-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center mr-2 mb-2 dark:border-blue-500 dark:text-blue-500 dark:hover:text-white dark:hover:bg-blue-500 dark:focus:ring-blue-800" onclick="window.location.href='<?php echo e(route('admin.logs')); ?>'">ЛОГОВЕ</button>
                <button type="button" class="text-blue-700 hover:text-white border border-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center mr-2 mb-2 dark:border-blue-500 dark:text-blue-500 dark:hover:text-white dark:hover:bg-blue-500 dark:focus:ring-blue-800" onclick="window.location.href='<?php echo e(route('admin.qt')); ?>'">ДИАГНОСТИКА</button>
                <button type="button" class="text-blue-700 hover:text-white border border-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center mr-2 mb-2 dark:border-blue-500 dark:text-blue-500 dark:hover:text-white dark:hover:bg-blue-500 dark:focus:ring-blue-800" onclick="disconnectAccount()">ИЗХОД ОТ СИСТЕМНОТО МЕНЮ</button>   
            </div>
        </div>
        <div class="grid grid-cols-3 gap-4">
            <div>
                <p class="text-sm text-white">ztmUI версия</p>
                <p class="text-lg text-white"><a class="font-medium text-blue-600 dark:text-blue-500 hover:underline" href="<?php echo e(route('admin.changelog')); ?>"><?php echo e($info['platform-version']); ?></a></p>
            </div>
            <div>
                <p class="text-sm text-white">PHP версия</p>
                <p class="text-lg text-white"><?php echo e($info['php-version']); ?></p>
            </div>
            <div>
                <p class="text-sm text-white">Curl плъгин</p>
                <p class="text-lg text-white"><?php echo e($info['curl-status'] ? 'Активен':'Неактивен'); ?></p>
            </div>
            <div>
                <p class="text-sm text-white">OS ядро</p>
                <p class="text-lg text-white"><?php echo e($info['os-core']); ?></p>
            </div>
            <div>
                <p class="text-sm text-white">Framework ядро</p>
                <p class="text-lg text-white"><?php echo e($info['framework']); ?></p>
            </div>
            <div>
                <p class="text-sm text-white">Име на хост</p>
                <p class="text-lg text-white"><?php echo e($hostname); ?></p>
            </div>
        </div>
    </div>
</div><?php /**PATH C:\laragon\www\ztmUI-prod\resources\views/livewire/info.blade.php ENDPATH**/ ?>