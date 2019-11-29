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
                    <span class="caption-subject bold font-blue uppercase">SEO اعدادات</span>
                </div>
            </div>
            <div class="portlet-body">
                <form role="form" action="<?php echo e(Protocol::home()); ?>/dashboard/settings/seo" method="POST">

                	<?php echo e(csrf_field()); ?>


                	<!-- Meta Description -->
                    <div class="form-group <?php echo e($errors->has('description') ? 'has-error' : ''); ?>">
                        <label class="control-label">SEO وصف</label>
                        <textarea row="3" class="form-control" name="description" placeholder="SEO Description"><?php echo e($settings->description); ?></textarea>
                        <?php if($errors->has('description')): ?>
                        <span class="help-block"><?php echo e($errors->first('description')); ?></span>
                        <?php endif; ?>
                    </div>

                    <!-- SEO Keywords -->
                    <div class="form-group <?php echo e($errors->has('keywords') ? 'has-error' : ''); ?>">
                        <label class="control-label">SEO كلمات</label>
                        <input type="text" class="form-control" name="keywords" value="<?php echo e($settings->keywords); ?>" placeholder="SEO Keywords"> 
                        <?php if($errors->has('keywords')): ?>
                        <span class="help-block"><?php echo e($errors->first('keywords')); ?></span>
                        <?php endif; ?>
                    </div>

                    <!-- Google Analytics Traking Code -->
                    <div class="form-group <?php echo e($errors->has('google_analytics') ? 'has-error' : ''); ?>">
                        <label class="control-label">مدونة تتبع Google Analytics</label>
                        <textarea row="3" class="form-control" name="google_analytics" placeholder="Google Analytics Traking Code"><?php echo e($settings->google_analytics); ?></textarea>
                        <?php if($errors->has('google_analytics')): ?>
                        <span class="help-block"><?php echo e($errors->first('google_analytics')); ?></span>
                        <?php endif; ?>
                    </div>

                    <!-- Header Code -->
                    <div class="form-group <?php echo e($errors->has('header_code') ? 'has-error' : ''); ?>">
                        <label class="control-label">Header Code</label>
                        <textarea row="3" class="form-control" name="header_code" placeholder="Header Code"><?php echo e($settings->header_code); ?></textarea>
                        <?php if($errors->has('header_code')): ?>
                        <span class="help-block"><?php echo e($errors->first('header_code')); ?></span>
                        <?php endif; ?>
                    </div>

                    <!-- Sitemap -->
                    <div class="form-group <?php echo e($errors->has('is_sitemap') ? 'has-error' : ''); ?>">
                        <label class="control-label">خريطة الموقع</label>
                        <select class="form-control" name="is_sitemap">
                            <?php if($settings->is_sitemap): ?>
                            <option value="1">تمكين</option>
                            <option value="0">تعطيل</option>
                            <?php else: ?> 
                            <option value="0">تعطيل</option>
                            <option value="1">تمكين</option>
                            <?php endif; ?>
                        </select>
                        <?php if($errors->has('is_sitemap')): ?>
                        <span class="help-block"><?php echo e($errors->first('is_sitemap')); ?></span>
                        <?php endif; ?>
                        <span class="help-block"><a target="_blank" class="text-muted uppercase" href="<?php echo e(Protocol::home()); ?>/sitemap">Sitemap</a></span>
                        <span class="help-block"><a target="_blank" class="text-muted uppercase" href="<?php echo e(Protocol::home()); ?>/sitemap/ads">ADS Sitemap</a></span>
                        <span class="help-block"><a target="_blank" class="text-muted uppercase" href="<?php echo e(Protocol::home()); ?>/sitemap/categories">Categories Sitemap</a></span>
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