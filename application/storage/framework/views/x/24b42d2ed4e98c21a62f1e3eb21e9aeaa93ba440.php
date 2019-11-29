<?php $__env->startSection('content'); ?>

<div class="row">
    
    <div class="col-md-12">

        <div class="portlet light ">

            <div class="portlet-title tabbable-line">
                <div class="caption caption-md">
                    <i class="icon-globe theme-font hide"></i>
                    <span class="caption-subject font-black-madison bold uppercase"><?php echo e($message->subject); ?></span>
                </div>
                <div class="actions">

                    <!-- User Details -->
                    <a class="btn btn-circle btn-icon-only btn-default" href="<?php echo e(Protocol::home()); ?>/dashboard/users/details/<?php echo e($message->msg_from); ?>">
                        <i class="icon-user"></i>
                    </a>

                    <!-- Delete Message -->
                    <a class="btn btn-circle btn-icon-only btn-default" href="<?php echo e(Protocol::home()); ?>/dashboard/messages/users/delete/<?php echo e($message->id); ?>">
                        <i class="icon-trash"></i>
                    </a>
                    
                </div>
            </div>

            <div class="portlet-body">
                
                <div class="grey-gallery well"><?php echo nl2br($message->message); ?></div>

            </div>

        </div>

    </div>

</div>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('dashboard.layout.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>