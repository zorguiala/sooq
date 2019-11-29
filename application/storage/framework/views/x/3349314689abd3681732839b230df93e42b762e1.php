<?php $__env->startSection('content'); ?>

<div class="row">
	
	<div class="col-md-12">

        <!-- Session Messages -->
        <?php if(Session::has('success')): ?>
        <div class="alert alert-success">
            <?php echo e(Session::get('success')); ?> 
        </div>
        <?php endif; ?>
        <?php if(Session::has('error')): ?>
        <div class="alert alert-danger">
            <?php echo e(Session::get('error')); ?> 
        </div>
        <?php endif; ?>
		
		<div class="portlet light bordered">
            <div class="portlet-title">
                <div class="caption">
                    <span class="caption-subject bold font-blue uppercase">إعدادات الصفحة الرئيسية</span>
                </div>
            </div>
            <div class="portlet-body">
                <form role="form" action="<?php echo e(Protocol::home()); ?>/dashboard/settings/home" method="POST" enctype="multipart/form-data">
                
                	<?php echo e(csrf_field()); ?>


                    <!-- Upload Wallpaper -->
                    <div class="form-group <?php echo e($errors->has('wallpaper') ? 'has-error' : ''); ?>">
                        <label class="control-label">تحميل خلفية</label>
                        <input type="file" name="wallpaper"/> 
                        <?php if($errors->has('wallpaper')): ?>
                        <span class="help-block"><?php echo e($errors->first('wallpaper')); ?></span>
                        <?php endif; ?>
                    </div>

                    <!-- Video Link -->
                    <div class="form-group <?php echo e($errors->has('video') ? 'has-error' : ''); ?>">
                        <label class="control-label">رابط الفيديو</label>
                        <input type="text" class="form-control" name="video" value="<?php echo e(Config::get('home.video')); ?>"> 
                        <?php if($errors->has('video')): ?>
                        <span class="help-block"><?php echo e($errors->first('video')); ?></span>
                        <?php endif; ?>
                    </div>

                    <!-- Save Changes -->
                    <div class="margin-top-10">
                        <button type="submit" class="btn default" style="width: 100%;">حفظ التغييرات </button>
                    </div>
                </form>
            </div>
        </div>

	</div>

</div>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('dashboard.layout.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>