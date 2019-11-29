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
                    <span class="caption-subject bold font-blue uppercase">Footer اعدادات</span>
                </div>
            </div>
            <div class="portlet-body">
                <form role="form" action="<?php echo e(Protocol::home()); ?>/dashboard/settings/footer" method="POST" enctype="multipart/form-data">
                
                	<?php echo e(csrf_field()); ?>


                	<!-- MailChimp API Key -->
                    <div class="form-group <?php echo e($errors->has('mailchip_api_key') ? 'has-error' : ''); ?>">
                        <label class="control-label">MailChimp API Key</label>
                        <input type="text" class="form-control" name="mailchip_api_key" value="<?php echo e(config('newsletter.apiKey')); ?>"> 
                        <?php if($errors->has('mailchip_api_key')): ?>
                        <span class="help-block"><?php echo e($errors->first('mailchip_api_key')); ?></span>
                        <?php endif; ?>
                    </div>

                    <!-- MailChimp List ID -->
                    <div class="form-group <?php echo e($errors->has('mailchip_list_id') ? 'has-error' : ''); ?>">
                        <label class="control-label">MailChimp List ID</label>
                        <input type="text" class="form-control" name="mailchip_list_id" value="<?php echo e(config('newsletter.lists.subscribers.id')); ?>"> 
                        <?php if($errors->has('mailchip_list_id')): ?>
                        <span class="help-block"><?php echo e($errors->first('mailchip_list_id')); ?></span>
                        <?php endif; ?>
                    </div>

                    <!-- Upload Footer Logo -->
                    <div class="form-group <?php echo e($errors->has('footer_logo') ? 'has-error' : ''); ?>">
                        <label class="control-label">رفع شعار الفوتر</label>
                        <input type="file" name="footer_logo" accept="image/*" /> 
                        <?php if($errors->has('footer_logo')): ?>
                        <span class="help-block"><?php echo e($errors->first('footer_logo')); ?></span>
                        <?php endif; ?>
                    </div>

                    <!-- Footer Copyright -->
                    <div class="form-group <?php echo e($errors->has('footer_copyright') ? 'has-error' : ''); ?>">
                        <label class="control-label">Footer حقوق النشر</label>
                        <input type="text" class="form-control" name="footer_copyright" value="<?php echo e(config('footer.copyright')); ?>"> 
                        <?php if($errors->has('footer_copyright')): ?>
                        <span class="help-block"><?php echo e($errors->first('footer_copyright')); ?></span>
                        <?php endif; ?>
                    </div>

                    <!-- Footer Column One -->
                    <div class="form-group <?php echo e($errors->has('footer_column_one') ? 'has-error' : ''); ?>">
                        <label class="control-label">Footer العمود الأول</label>
                        <input type="text" class="form-control" name="footer_column_one" value="<?php echo e(config('footer.column_one')); ?>"> 
                        <?php if($errors->has('footer_column_one')): ?>
                        <span class="help-block"><?php echo e($errors->first('footer_column_one')); ?></span>
                        <?php endif; ?>
                    </div>

                    <!-- Footer Column Two -->
                    <div class="form-group <?php echo e($errors->has('footer_column_two') ? 'has-error' : ''); ?>">
                        <label class="control-label">Footer العمود الثاني</label>
                        <input type="text" class="form-control" name="footer_column_two" value="<?php echo e(config('footer.column_two')); ?>"> 
                        <?php if($errors->has('footer_column_two')): ?>
                        <span class="help-block"><?php echo e($errors->first('footer_column_two')); ?></span>
                        <?php endif; ?>
                    </div>

                    <!-- Footer Column Three -->
                    <div class="form-group <?php echo e($errors->has('footer_column_three') ? 'has-error' : ''); ?>">
                        <label class="control-label">Footer العمود الثالث</label>
                        <input type="text" class="form-control" name="footer_column_three" value="<?php echo e(config('footer.column_three')); ?>"> 
                        <?php if($errors->has('footer_column_three')): ?>
                        <span class="help-block"><?php echo e($errors->first('footer_column_three')); ?></span>
                        <?php endif; ?>
                    </div>

                    <!-- Footer Column Four -->
                    <div class="form-group <?php echo e($errors->has('footer_column_four') ? 'has-error' : ''); ?>">
                        <label class="control-label">Footer العمود الرابع</label>
                        <input type="text" class="form-control" name="footer_column_four" value="<?php echo e(config('footer.column_four')); ?>"> 
                        <?php if($errors->has('footer_column_four')): ?>
                        <span class="help-block"><?php echo e($errors->first('footer_column_four')); ?></span>
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