		<?php echo $__env->make('dashboard.includes.header', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>

        <div class="page-container">
            
        <?php echo $__env->make('dashboard.includes.sidebar', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>

            <div class="page-content-wrapper">

                <div class="page-content">

                <?php echo $__env->yieldContent('content'); ?>

                </div>

            </div>

        </div>

        <?php echo $__env->make('dashboard.includes.footer', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>