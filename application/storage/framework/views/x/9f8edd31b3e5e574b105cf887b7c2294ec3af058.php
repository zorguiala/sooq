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
                    <span class="caption-subject bold font-blue uppercase">Watermark Settings</span>
                </div>
            </div>
            <div class="portlet-body">
                <form role="form" action="<?php echo e(Protocol::home()); ?>/dashboard/settings/watermark" method="POST" enctype="multipart/form-data">
                	<?php echo e(csrf_field()); ?>


                	<!-- Watermark Position -->
                    <div class="form-group">
                        <label class="control-label">Watermark Position</label>
                        <select class="form-control <?php echo e($errors->has('position') ? 'has-error' : ''); ?>" name="position">
                            <?php if($watermark->position == "top_right"): ?>
                            <option value="top_right">أعلى اليمين</option>
                            <option value="top_left">أعلى اليسار</option>
                            <option value="bottom_right">أسفل اليمين</option>
                            <option value="bottom_left">أسفل اليسار</option>
                            <option value="center">وسط</option>
                            <?php elseif($watermark->position == "top_left"): ?>
                            <option value="top_left">أعلى اليسار</option>
                            <option value="top_right">أعلى اليمين</option>
                            <option value="bottom_right">أسفل اليمين</option>
                            <option value="bottom_left">أسفل اليسار</option>
                            <option value="center">وسط</option>
                            <?php elseif($watermark->position == "bottom_right"): ?>
                            <option value="bottom_right">أسفل اليمين</option>
                            <option value="top_right">أعلى اليمين</option>
                            <option value="top_left">أعلى اليسار</option>
                            <option value="bottom_left">أسفل اليمين</option>
                            <option value="center">وسط</option>
                            <?php elseif($watermark->position == "bottom_left"): ?>
                            <option value="bottom_left">أسفل اليمين</option>
                            <option value="top_right">أعلى اليمين</option>
                            <option value="top_left">أعلى اليسار</option>
                            <option value="bottom_right">أسفل اليمين</option>
                            <option value="center">وسط</option>
                            <?php else: ?> 
                            <option value="center">وسط</option>
                            <option value="top_right">أعلى اليمين</option>
                            <option value="top_left">أعلى اليسار</option>
                            <option value="bottom_right">أسفل اليمين</option>
                            <option value="bottom_left">أسفل اليمين</option>
                            <?php endif; ?>
                        </select>
                        <?php if($errors->has('position')): ?>
                        <span class="help-block">
                            <?php echo e($errors->first('position')); ?>

                        </span>
                        <?php endif; ?>
                    </div>

                    <!-- Watermark Opacity -->
                    <div class="form-group <?php echo e($errors->has('opacity') ? 'has-error' : ''); ?>">
                        <label class="control-label">Watermark Opacity</label>
                        <select class="form-control" name="opacity">
                            <?php if($watermark->opacity == 25): ?>
                            <option value="25">25%</option>
                            <option value="50">50%</option>
                            <option value="75">75%</option>
                            <option value="100">100%</option>
                            <?php elseif($watermark->opacity == 50): ?>
                            <option value="50">50%</option>
                            <option value="25">25%</option>
                            <option value="75">75%</option>
                            <option value="100">100%</option>
                            <?php elseif($watermark->opacity == 75): ?>
                            <option value="75">75%</option>
                            <option value="25">25%</option>
                            <option value="50">50%</option>
                            <option value="100">100%</option>
                            <?php else: ?>
                            <option value="100">100%</option>
                            <option value="25">25%</option>
                            <option value="50">50%</option>
                            <option value="75">75%</option>
                            <?php endif; ?>
                        </select>
                        <?php if($errors->has('opacity')): ?>
                        <span class="help-block">
                            <?php echo e($errors->first('opacity')); ?>

                        </span>
                        <?php endif; ?>
                    </div>

                    <!-- Enable Watermark -->
                    <div class="form-group <?php echo e($errors->has('is_active') ? 'has-error' : ''); ?>">
                        <label class="control-label">تمكين Watermark</label>
                        <select class="form-control" name="is_active">
                            <?php if($watermark->is_active): ?>
                            <option value="1">تمكين</option>
                            <option value="0">تعطيل</option>
                            <?php else: ?> 
                            <option value="0">تعطيل</option>
                            <option value="1">تمكين</option>
                            <?php endif; ?>
                        </select>
                        <?php if($errors->has('is_active')): ?>
                        <span class="help-block">
                            <?php echo e($errors->first('is_active')); ?>

                        </span>
                        <?php endif; ?>
                    </div>

					<!-- Upload Watermark -->
                    <div class="form-group <?php echo e($errors->has('watermark') ? 'has-error' : ''); ?>">
                        <label class="control-label">تحميل Watermark</label>
                        <input type="file" name="watermark"/>
                        <?php if($errors->has('watermark')): ?>
                        <span class="help-block">
                            <?php echo e($errors->first('watermark')); ?>

                        </span>
                        <?php endif; ?> 
                    </div>

                    <!-- Save Changes -->
                    <div class="margin-top-10">
                        <button type="submit" class="btn default" style="width: 100%">حفظ التغييرات </button>
                    </div>
                </form>
            </div>
        </div>

	</div>

</div>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('dashboard.layout.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>