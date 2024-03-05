<!DOCTYPE html>
<html lang="<?php echo e(str_replace('_', '-', app()->getLocale())); ?>">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">

        <title>ztmUI</title>

        <!-- CSS -->
        <?php echo app('Illuminate\Foundation\Vite')(['resources/css/app.css', 'resources/js/app.js']); ?>
        <link rel="stylesheet" href="<?php echo e(asset('css/range-slider.css')); ?>">
        <!-- Livewire -->
        <?php echo \Livewire\Livewire::styles(); ?>

        <!-- Jquery -->
        <script src="<?php echo e(asset('js/jquery-3.6.3.min.js')); ?>"></script>
        <!-- Toastr Notifications -->
        <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
        <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
        <!-- keyboard -->
        <script src="<?php echo e(asset('js/kioskboard-aio-2.3.0.min.js')); ?>"></script>
    </head>
    <body class="antialiased bg-blue-body">
        <main>
            <?php echo $__env->yieldContent('content'); ?>
            <?php
if (! isset($_instance)) {
    $html = \Livewire\Livewire::mount('lock', [])->html();
} elseif ($_instance->childHasBeenRendered('lURqHLU')) {
    $componentId = $_instance->getRenderedChildComponentId('lURqHLU');
    $componentTag = $_instance->getRenderedChildComponentTagName('lURqHLU');
    $html = \Livewire\Livewire::dummyMount($componentId, $componentTag);
    $_instance->preserveRenderedChild('lURqHLU');
} else {
    $response = \Livewire\Livewire::mount('lock', []);
    $html = $response->html();
    $_instance->logRenderedChild('lURqHLU', $response->id(), \Livewire\Livewire::getRootElementTagName($html));
}
echo $html;
?>
        </main>
        <script src="https://unpkg.com/flowbite@1.5.5/dist/flowbite.js"></script>
        <?php echo \Livewire\Livewire::scripts(); ?>

        <?php echo $__env->yieldPushContent('js'); ?>

        <script>
            <?php if(Session::has('message')): ?>
            toastr.options =
            {
            	"closeButton" : true,
            	"progressBar" : true,
              "positionClass": "toast-top-right",
            }
            		toastr.success("<?php echo e(session('message')); ?>");
            <?php endif; ?>
  
            <?php if(Session::has('error')): ?>
            toastr.options =
            {
            	"closeButton" : true,
            	"progressBar" : true,
              "positionClass": "toast-top-right",
            }
            		toastr.error("<?php echo e(session('error')); ?>");
            <?php endif; ?>
  
            <?php if(Session::has('info')): ?>
            toastr.options =
            {
            	"closeButton" : true,
            	"progressBar" : true,
              "positionClass": "toast-top-right",
            }
            		toastr.info("<?php echo e(session('info')); ?>");
            <?php endif; ?>
  
            <?php if(Session::has('warning')): ?>
            toastr.options =
            {
            	"closeButton" : true,
            	"progressBar" : true,
              "positionClass": "toast-top-right",
            }
            		toastr.warning("<?php echo e(session('warning')); ?>");
            <?php endif; ?>
        </script>
    </body>
</html>
<?php /**PATH C:\laragon\www\ztmUI\resources\views/layouts/app.blade.php ENDPATH**/ ?>