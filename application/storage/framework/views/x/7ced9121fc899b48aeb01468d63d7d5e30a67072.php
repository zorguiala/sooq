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
                    <span class="caption-subject bold font-blue uppercase">الاعدادات العامة</span>
                </div>
            </div>
            <div class="portlet-body">
                <form role="form" action="<?php echo e(Protocol::home()); ?>/dashboard/settings/general" method="POST" enctype="multipart/form-data">
                
                	<?php echo e(csrf_field()); ?>


                	<!-- Site Title -->
                    <div class="form-group <?php echo e($errors->has('title') ? 'has-error' : ''); ?>">
                        <label class="control-label">عنوان الموقع</label>
                        <input type="text" class="form-control" name="title" value="<?php echo e($settings->title); ?>"> 
                        <?php if($errors->has('title')): ?>
                        <span class="help-block"><?php echo e($errors->first('title')); ?></span>
                        <?php endif; ?>
                    </div>

                    <!-- Short Description -->
                    <div class="form-group <?php echo e($errors->has('description') ? 'has-error' : ''); ?>">
                        <label class="control-label">Short Description</label>
                        <input type="text" class="form-control" name="description" value="<?php echo e($settings->description); ?>"> 
                        <?php if($errors->has('description')): ?>
                        <span class="help-block"><?php echo e($errors->first('description')); ?></span>
                        <?php endif; ?>
                    </div>

                    <!-- Upload Logo -->
                    <div class="form-group <?php echo e($errors->has('logo') ? 'has-error' : ''); ?>">
                        <label class="control-label">رفع الشعار</label>
                        <input type="file" name="logo"/> 
                        <?php if($errors->has('logo')): ?>
                        <span class="help-block"><?php echo e($errors->first('logo')); ?></span>
                        <?php endif; ?>
                    </div>

                    <!-- Upload Favicon -->
                    <div class="form-group <?php echo e($errors->has('favicon') ? 'has-error' : ''); ?>">
                        <label class="control-label">تحميل  Favicon</label>
                        <input type="file" name="favicon"/> 
                        <?php if($errors->has('favicon')): ?>
                        <span class="help-block"><?php echo e($errors->first('favicon')); ?></span>
                        <?php endif; ?>
                    </div>

                    <!-- Default Language -->
                    <div class="form-group <?php echo e($errors->has('language') ? 'has-error' : ''); ?>">
                        <label class="control-label">اللغة الافتراضية</label>
                        <select class="form-control" name="language">
                            <?php $__currentLoopData = Countries::languages(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $name): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option <?php echo e($settings->language == $key ? 'selected' : ''); ?> value="<?php echo e($key); ?>"><?php echo e($name); ?></option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                        <?php if($errors->has('language')): ?>
                        <span class="help-block"><?php echo e($errors->first('language')); ?></span>
                        <?php endif; ?>
                    </div>

                    <!-- Site Direction -->
                    <div class="form-group <?php echo e($errors->has('direction') ? 'has-error' : ''); ?>">
                        <label class="control-label">اتجاه الموقع</label>
                        <select class="form-control" name="direction">
                            <?php if(config('app.rtl')): ?>
                            <option value="1">RTL</option>
                            <option value="0">LTR</option>
                            <?php else: ?> 
                            <option value="0">LTR</option>
                            <option value="1">RTL</option>
                            <?php endif; ?>
                        </select>
                        <?php if($errors->has('direction')): ?>
                        <span class="help-block"><?php echo e($errors->first('direction')); ?></span>
                        <?php endif; ?>
                    </div>

                    <!-- Default Host -->
                    <div class="form-group <?php echo e($errors->has('cloud') ? 'has-error' : ''); ?>">
                        <label class="control-label">Default Host</label>
                        <select class="form-control" name="cloud">
                            <?php $__currentLoopData = $clouds; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $cloud): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option <?php echo e($settings->default_host == $cloud ? 'selected' : ''); ?> value="<?php echo e($cloud); ?>"><?php echo e($cloud); ?></option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                        <?php if($errors->has('cloud')): ?>
                        <span class="help-block"><?php echo e($errors->first('cloud')); ?></span>
                        <?php endif; ?>
                    </div>

                    <!-- Facebook Page -->
                    <div class="form-group <?php echo e($errors->has('facebook') ? 'has-error' : ''); ?>">
                        <label class="control-label">Facebook صفحة</label>
                        <input type="text" class="form-control" name="facebook" value="<?php echo e(config('social.facebook')); ?>"> 
                        <?php if($errors->has('facebook')): ?>
                        <span class="help-block"><?php echo e($errors->first('facebook')); ?></span>
                        <?php endif; ?>
                    </div>

                    <!-- Twitter Page -->
                    <div class="form-group <?php echo e($errors->has('twitter') ? 'has-error' : ''); ?>">
                        <label class="control-label">Twitter صفحة</label>
                        <input type="text" class="form-control" name="twitter" value="<?php echo e(config('social.twitter')); ?>"> 
                        <?php if($errors->has('twitter')): ?>
                        <span class="help-block"><?php echo e($errors->first('twitter')); ?></span>
                        <?php endif; ?>
                    </div>

                    <!-- Google Page -->
                    <div class="form-group <?php echo e($errors->has('google') ? 'has-error' : ''); ?>">
                        <label class="control-label">Google صفحة</label>
                        <input type="text" class="form-control" name="google" value="<?php echo e(config('social.google')); ?>"> 
                        <?php if($errors->has('google')): ?>
                        <span class="help-block"><?php echo e($errors->first('google')); ?></span>
                        <?php endif; ?>
                    </div>

                    <!-- Android Application -->
                    <div class="form-group <?php echo e($errors->has('android') ? 'has-error' : ''); ?>">
                        <label class="control-label">Android تطبيق</label>
                        <input type="text" class="form-control" name="android" value="<?php echo e(config('social.android')); ?>"> 
                        <?php if($errors->has('android')): ?>
                        <span class="help-block"><?php echo e($errors->first('android')); ?></span>
                        <?php endif; ?>
                    </div>

                    <!-- iPhone Application -->
                    <div class="form-group <?php echo e($errors->has('iphone') ? 'has-error' : ''); ?>">
                        <label class="control-label">iPhone تطبيق</label>
                        <input type="text" class="form-control" name="iphone" value="<?php echo e(config('social.iphone')); ?>"> 
                        <?php if($errors->has('iphone')): ?>
                        <span class="help-block"><?php echo e($errors->first('iphone')); ?></span>
                        <?php endif; ?>
                    </div>

                    <!-- Windows Phone Application -->
                    <div class="form-group <?php echo e($errors->has('windows') ? 'has-error' : ''); ?>">
                        <label class="control-label">Windows Phone تطبيق</label>
                        <input type="text" class="form-control" name="windows" value="<?php echo e(config('social.windows')); ?>"> 
                        <?php if($errors->has('windows')): ?>
                        <span class="help-block"><?php echo e($errors->first('windows')); ?></span>
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