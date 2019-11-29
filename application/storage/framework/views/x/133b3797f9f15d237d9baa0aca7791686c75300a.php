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
                    <span class="caption-subject bold font-blue uppercase">إعدادات المصادقة</span>
                </div>
            </div>
            <div class="portlet-body">
                <form role="form" action="<?php echo e(Protocol::home()); ?>/dashboard/settings/auth" method="POST">
                
                	<?php echo e(csrf_field()); ?>


                    <!-- After Register -->
                    <div class="form-group <?php echo e($errors->has('need_activation') ? 'has-error' : ''); ?>">
                        <label class="control-label">بعد التسجيل</label>
                        <select class="form-control" name="need_activation">
                            <?php if($settings->need_activation): ?>
                            <option value="1">تحتاج التنشيط</option>
                            <option value="0">تسجيل السيارات</option>
                            <?php else: ?> 
                            <option value="0">تسجيل السيارات</option>
                            <option value="1">تحتاج التنشيط</option>
                            <?php endif; ?>
                        </select>
                        <?php if($errors->has('need_activation')): ?>
                        <span class="help-block"><?php echo e($errors->first('need_activation')); ?></span>
                        <?php endif; ?>
                    </div>

                    <!-- Activation Type -->
                    <div class="form-group <?php echo e($errors->has('activation_type') ? 'has-error' : ''); ?>">
                        <label class="control-label">نوع التنشيط</label>
                        <select class="form-control" name="activation_type">
                            <?php if($settings->activation_type == 'admin'): ?>
                            <option value="admin">من لوحة المعلومات</option>
                            <option value="email">عبر البريد الالكتروني</option>
                            <option value="sms">عبر الرسائل القصيرة</option>
                            <?php elseif($settings->activation_type == 'email'): ?>
                            <option value="email">عبر البريد الالكتروني</option>
                            <option value="sms">عبر الرسائل القصيرة</option>
                            <option value="admin">من لوحة المعلومات</option>
                            <?php else: ?> 
                            <option value="sms">عبر الرسائل القصيرة</option>
                            <option value="email">عبر البريد الالكتروني</option>
                            <option value="admin">من لوحة المعلومات</option>
                            <?php endif; ?>
                        </select>
                        <?php if($errors->has('activation_type')): ?>
                        <span class="help-block"><?php echo e($errors->first('activation_type')); ?></span>
                        <?php endif; ?>
                    </div>

                	<!-- Activation Expired Time (minutes) -->
                    <div class="form-group <?php echo e($errors->has('activation_expired_time') ? 'has-error' : ''); ?>">
                        <label class="control-label">وقت الإنتهاء منتهي الصلاحية (بالدقائق)</label>
                        <input type="text" class="form-control" name="activation_expired_time" value="<?php echo e($settings->activation_expired_time); ?>"> 
                        <?php if($errors->has('activation_expired_time')): ?>
                        <span class="help-block"><?php echo e($errors->first('activation_expired_time')); ?></span>
                        <?php endif; ?>
                    </div>

                    <!-- Prevent Posting After X warnings -->
                    <div class="form-group <?php echo e($errors->has('max_warnings') ? 'has-error' : ''); ?>">
                        <label class="control-label">منع النشر بعد التحذيرات X</label>
                        <input type="text" class="form-control" name="max_warnings" value="<?php echo e($settings->max_warnings); ?>"> 
                        <?php if($errors->has('max_warnings')): ?>
                        <span class="help-block"><?php echo e($errors->first('max_warnings')); ?></span>
                        <?php endif; ?>
                    </div>

                    <hr>

                    <!-- Facebook -->
                    <div class="row">

                        <div class="col-md-6">
                            <!-- Facebook Client ID -->
                            <div class="form-group <?php echo e($errors->has('fb_client_id') ? 'has-error' : ''); ?>">
                                <label class="control-label">Facebook Client ID</label>
                                <input type="text" class="form-control" name="fb_client_id" value="<?php echo e(config('services.facebook.client_id')); ?>"> 
                                <?php if($errors->has('fb_client_id')): ?>
                                <span class="help-block"><?php echo e($errors->first('fb_client_id')); ?></span>
                                <?php endif; ?>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <!-- Facebook Client Secret -->
                            <div class="form-group <?php echo e($errors->has('fb_secret') ? 'has-error' : ''); ?>">
                                <label class="control-label">Facebook Client Secret</label>
                                <input type="text" class="form-control" name="fb_secret" value="<?php echo e(config('services.facebook.client_secret')); ?>"> 
                                <?php if($errors->has('fb_secret')): ?>
                                <span class="help-block"><?php echo e($errors->first('fb_secret')); ?></span>
                                <?php endif; ?>
                            </div>
                        </div>

                    </div>
                    
                    <hr>
                    
                    <!-- Twitter -->
                    <div class="row">

                        <div class="col-md-6">
                            <!-- Twitter Client ID -->
                            <div class="form-group <?php echo e($errors->has('tw_client_id') ? 'has-error' : ''); ?>">
                                <label class="control-label">Twitter Client ID</label>
                                <input type="text" class="form-control" name="tw_client_id" value="<?php echo e(config('services.twitter.client_id')); ?>"> 
                                <?php if($errors->has('tw_client_id')): ?>
                                <span class="help-block"><?php echo e($errors->first('tw_client_id')); ?></span>
                                <?php endif; ?>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <!-- Twitter Client Secret -->
                            <div class="form-group <?php echo e($errors->has('tw_secret') ? 'has-error' : ''); ?>">
                                <label class="control-label">Twitter Client Secret</label>
                                <input type="text" class="form-control" name="tw_secret" value="<?php echo e(config('services.twitter.client_secret')); ?>"> 
                                <?php if($errors->has('tw_secret')): ?>
                                <span class="help-block"><?php echo e($errors->first('tw_secret')); ?></span>
                                <?php endif; ?>
                            </div>
                        </div>

                    </div>
                    
                    <hr>

                    <!-- Google -->
                    <div class="row">
                        
                        <div class="col-md-6">
                            <!-- Google Client ID -->
                            <div class="form-group <?php echo e($errors->has('go_client_id') ? 'has-error' : ''); ?>">
                                <label class="control-label">Google Client ID</label>
                                <input type="text" class="form-control" name="go_client_id" value="<?php echo e(config('services.google.client_id')); ?>"> 
                                <?php if($errors->has('go_client_id')): ?>
                                <span class="help-block"><?php echo e($errors->first('go_client_id')); ?></span>
                                <?php endif; ?>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <!-- Google Client Secret -->
                            <div class="form-group <?php echo e($errors->has('go_client_secret') ? 'has-error' : ''); ?>">
                                <label class="control-label">Google Client Secret</label>
                                <input type="text" class="form-control" name="go_client_secret" value="<?php echo e(config('services.google.client_secret')); ?>"> 
                                <?php if($errors->has('go_client_secret')): ?>
                                <span class="help-block"><?php echo e($errors->first('go_client_secret')); ?></span>
                                <?php endif; ?>
                            </div>
                        </div>

                    </div>

                    <hr>

                    <!-- Instagram -->
                    <div class="row">

                        <div class="col-md-6">
                            <!-- Instagram Client ID -->
                            <div class="form-group <?php echo e($errors->has('in_client_id') ? 'has-error' : ''); ?>">
                                <label class="control-label">Instagram Client ID</label>
                                <input type="text" class="form-control" name="in_client_id" value="<?php echo e(config('services.instagram.client_id')); ?>"> 
                                <?php if($errors->has('in_client_id')): ?>
                                <span class="help-block"><?php echo e($errors->first('in_client_id')); ?></span>
                                <?php endif; ?>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <!-- Instagram Client Secret -->
                            <div class="form-group <?php echo e($errors->has('in_client_secret') ? 'has-error' : ''); ?>">
                                <label class="control-label">Instagram Client Secret</label>
                                <input type="text" class="form-control" name="in_client_secret" value="<?php echo e(config('services.instagram.client_secret')); ?>"> 
                                <?php if($errors->has('in_client_secret')): ?>
                                <span class="help-block"><?php echo e($errors->first('in_client_secret')); ?></span>
                                <?php endif; ?>
                            </div>
                        </div>

                    </div>

                    <hr>

                    <!-- Pinterest -->
                    <div class="row">

                        <div class="col-md-6">
                            <!-- Pinterest Client ID -->
                            <div class="form-group <?php echo e($errors->has('pi_client_id') ? 'has-error' : ''); ?>">
                                <label class="control-label">Pinterest Client ID</label>
                                <input type="text" class="form-control" name="pi_client_id" value="<?php echo e(config('services.pinterest.client_id')); ?>"> 
                                <?php if($errors->has('pi_client_id')): ?>
                                <span class="help-block"><?php echo e($errors->first('pi_client_id')); ?></span>
                                <?php endif; ?>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <!-- Pinterest Client Secret -->
                            <div class="form-group <?php echo e($errors->has('pi_client_secret') ? 'has-error' : ''); ?>">
                                <label class="control-label">Pinterest Client Secret</label>
                                <input type="text" class="form-control" name="pi_client_secret" value="<?php echo e(config('services.pinterest.client_secret')); ?>"> 
                                <?php if($errors->has('pi_client_secret')): ?>
                                <span class="help-block"><?php echo e($errors->first('pi_client_secret')); ?></span>
                                <?php endif; ?>
                            </div>
                        </div>

                    </div>

                    <hr>

                    <!-- Linkedin -->
                    <div class="row">

                        <div class="col-md-6">
                            <!-- Linkedin Client ID -->
                            <div class="form-group <?php echo e($errors->has('li_client_id') ? 'has-error' : ''); ?>">
                                <label class="control-label">Linkedin Client ID</label>
                                <input type="text" class="form-control" name="li_client_id" value="<?php echo e(config('services.linkedin.client_id')); ?>"> 
                                <?php if($errors->has('li_client_id')): ?>
                                <span class="help-block"><?php echo e($errors->first('li_client_id')); ?></span>
                                <?php endif; ?>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <!-- Linkedin Client Secret -->
                            <div class="form-group <?php echo e($errors->has('li_client_secret') ? 'has-error' : ''); ?>">
                                <label class="control-label">Linkedin Client Secret</label>
                                <input type="text" class="form-control" name="li_client_secret" value="<?php echo e(config('services.linkedin.client_secret')); ?>"> 
                                <?php if($errors->has('li_client_secret')): ?>
                                <span class="help-block"><?php echo e($errors->first('li_client_secret')); ?></span>
                                <?php endif; ?>
                            </div>
                        </div>

                    </div>

                    <hr>

                    <!-- VK -->
                    <div class="row">

                        <div class="col-md-6">
                            <!-- VK Client ID -->
                            <div class="form-group <?php echo e($errors->has('vk_client_id') ? 'has-error' : ''); ?>">
                                <label class="control-label">VK Client ID</label>
                                <input type="text" class="form-control" name="vk_client_id" value="<?php echo e(config('services.vkontakte.client_id')); ?>"> 
                                <?php if($errors->has('vk_client_id')): ?>
                                <span class="help-block"><?php echo e($errors->first('vk_client_id')); ?></span>
                                <?php endif; ?>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <!-- VK Client Secret -->
                            <div class="form-group <?php echo e($errors->has('vk_client_secret') ? 'has-error' : ''); ?>">
                                <label class="control-label">VK Client Secret</label>
                                <input type="text" class="form-control" name="vk_client_secret" value="<?php echo e(config('services.vkontakte.client_secret')); ?>"> 
                                <?php if($errors->has('vk_client_secret')): ?>
                                <span class="help-block"><?php echo e($errors->first('vk_client_secret')); ?></span>
                                <?php endif; ?>
                            </div>
                        </div>

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