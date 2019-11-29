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
                    <span class="caption-subject bold font-blue uppercase">PaySafeCard اعدادات بوابة</span>
                </div>
            </div>
            <div class="portlet-body">
                <form role="form" action="<?php echo e(Protocol::home()); ?>/dashboard/settings/payments/paysafecard" method="POST">
                
                	<?php echo e(csrf_field()); ?>


                    <!-- Payment Currency -->
                    <div class="form-group <?php echo e($errors->has('currency') ? 'has-error' : ''); ?>">
                        <label class="control-label">عملة الدفع</label>
                        <select class="form-control" name="currency">
                            <?php $__currentLoopData = Currencies::paysafecard(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $currency => $name): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($currency); ?>" <?php echo e(config('paysafecard.currency') == $currency ? 'selected' : ''); ?>><?php echo e($name); ?></option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                        <?php if($errors->has('currency')): ?>
                        <span class="help-block"><?php echo e($errors->first('currency')); ?></span>
                        <?php endif; ?>
                    </div>

                	<!-- Account upgrade price per day -->
                    <div class="form-group <?php echo e($errors->has('account_price') ? 'has-error' : ''); ?>">
                        <label class="control-label">سعر ترقية الحساب في اليوم</label>
                        <input type="text" class="form-control" name="account_price" value="<?php echo e(config('paysafecard.account_price')); ?>"> 
                        <?php if($errors->has('account_price')): ?>
                        <span class="help-block"><?php echo e($errors->first('account_price')); ?></span>
                        <?php endif; ?>
                    </div>

                    <!-- Ad upgrade price per day -->
                    <div class="form-group <?php echo e($errors->has('ad_price') ? 'has-error' : ''); ?>">
                        <label class="control-label">سعر ترقية الإعلان يوميًا</label>
                        <input type="text" class="form-control" name="ad_price" value="<?php echo e(config('paysafecard.ad_price')); ?>"> 
                        <?php if($errors->has('ad_price')): ?>
                        <span class="help-block"><?php echo e($errors->first('ad_price')); ?></span>
                        <?php endif; ?>
                    </div>

                    <!-- PaySafeCard API Key -->
                    <div class="form-group <?php echo e($errors->has('psc_key') ? 'has-error' : ''); ?>">
                        <label class="control-label">PaySafeCard API الرئيسية</label>
                        <input type="text" class="form-control" id="psc_key" placeholder="Your paysafecard api key" name="psc_key" value="<?php echo e(config('paysafecard.psc_key')); ?>">
                        <?php if($errors->has('psc_key')): ?>
                        <span class="help-block"><?php echo e($errors->first('psc_key')); ?></span>
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