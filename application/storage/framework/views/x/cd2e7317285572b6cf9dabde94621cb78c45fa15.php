<?php $__env->startSection('seo'); ?>

<?php echo SEO::generate(); ?>


<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>

<!-- Create New Store -->
<div class="row">

	<div class="col-md-8">

		<?php if(Session::has('error')): ?>
		<div class="alert bg-danger alert-styled-left">
			<button type="button" class="close" data-dismiss="alert"><span>×</span><span class="sr-only">Close</span></button>
			<?php echo e(Session::get('error')); ?>

	    </div>
	    <?php endif; ?>

	    <?php if(Session::has('success')): ?>
		<div class="alert bg-success alert-styled-left">
			<button type="button" class="close" data-dismiss="alert"><span>×</span><span class="sr-only">Close</span></button>
			<?php echo e(Session::get('success')); ?>

	    </div>
	    <?php endif; ?>

		<!-- Page Body -->
		<div class="panel panel-flat">

			<form action="<?php echo e(Protocol::home()); ?>/create/store" method="POST" enctype="multipart/form-data">

				<div class="panel-body page_content">

						<?php echo e(csrf_field()); ?>

						
						<!-- Store Username -->
						<div class="form-group <?php echo e($errors->has('username') ? 'has-error' : ''); ?>">
							<label><?php echo e(Lang::get('create/store.lang_store_username')); ?></label>
							<input type="text" value="<?php echo e(old('username')); ?>" class="form-control input-xlg" name="username" placeholder="<?php echo e(Lang::get('create/store.lang_store_username_placeholder')); ?>">
							<?php if($errors->has('username')): ?>
							<span class="help-block"><?php echo e($errors->first('username')); ?></span>
							<?php endif; ?>
						</div>

						<!-- Store Title -->
						<div class="form-group <?php echo e($errors->has('title') ? 'has-error' : ''); ?>">
							<label><?php echo e(Lang::get('create/store.lang_store_title')); ?></label>
							<input type="text" value="<?php echo e(old('title')); ?>" class="form-control input-xlg" name="title" placeholder="<?php echo e(Lang::get('create/store.lang_store_title_placeholder')); ?>">
							<?php if($errors->has('title')): ?>
							<span class="help-block"><?php echo e($errors->first('title')); ?></span>
							<?php endif; ?>
						</div>

						<!-- Short Description -->
						<div class="form-group <?php echo e($errors->has('short_desc') ? 'has-error' : ''); ?>">
							<label><?php echo e(Lang::get('create/store.lang_store_short_description')); ?></label>
							<input type="text" value="<?php echo e(old('short_desc')); ?>" class="form-control input-xlg" name="short_desc" placeholder="<?php echo e(Lang::get('create/store.lang_store_short_description_placeholder')); ?>">
							<?php if($errors->has('short_desc')): ?>
							<span class="help-block"><?php echo e($errors->first('short_desc')); ?></span>
							<?php endif; ?>
						</div>

						<!-- Long Description -->
						<div class="form-group <?php echo e($errors->has('long_desc') ? 'has-error' : ''); ?>">
							<label><?php echo e(Lang::get('create/store.lang_store_long_description')); ?></label>
							<textarea name="long_desc" rows="10" class="form-control" placeholder="<?php echo e(Lang::get('create/store.lang_store_long_description_placeholder')); ?>"></textarea>
							<?php if($errors->has('long_desc')): ?>
							<span class="help-block"><?php echo e($errors->first('long_desc')); ?></span>
							<?php endif; ?>
						</div>

						<!-- Select Category -->
						<div class="form-group select-size-lg <?php echo e($errors->has('category') ? 'has-error' : ''); ?>">
							<label><?php echo e(Lang::get('create/store.lang_store_category')); ?></label>
							<select required="" class="select-search" data-placeholder="<?php echo e(Lang::get('create/ad.lang_select_category')); ?>" name="category">
                                <option></option>
                                <?php if(count(Helper::parent_categories())): ?>
                                <?php $__currentLoopData = Helper::parent_categories(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $parent): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            	<option class="select2-results__group" value="<?php echo e($parent->id); ?>" <?php echo e(old('category') == $parent->id ? 'selected' : ''); ?>>-- <?php echo e($parent->category_name); ?> --</option>
                                <?php if(count(Helper::sub_categories($parent->id))): ?>
                                <?php $__currentLoopData = Helper::sub_categories($parent->id); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $sub): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option <?php echo e(old('category') == $sub->id ? 'selected' : ''); ?> value="<?php echo e($sub->id); ?>"><?php echo e($sub->category_name); ?></option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                <?php endif; ?>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                <?php endif; ?>
                        	</select>
						</div>

						<!-- Store Logo -->
						<div class="form-group upload-store-logo-rtl <?php echo e($errors->has('logo') ? 'has-error' : ''); ?>">
							<label class="display-block"><?php echo e(Lang::get('create/store.lang_store_logo')); ?></label>
	                        <input type="file" class="file-styled" name="logo">
	                        <span class="help-block"><?php echo e(Lang::get('create/store.lang_accepted_formats')); ?></span>
	                        <?php if($errors->has('logo')): ?>
							<span class="help-block"><?php echo e($errors->first('logo')); ?></span>
							<?php endif; ?>
						</div>

				</div>

				<div class="panel-footer">
					<div class="heading-elements">
						<div class="pull-left mt-5 <?php echo e($errors->has('terms') ? 'has-error' : ''); ?>" style="margin-left: 20px;">
							<label class="checkbox-inline text-grey-400">
								<input type="checkbox" class="styled" name="terms">
								<?php echo e(Lang::get('create/ad.lang_i_have_confirm')); ?> <a href="<?php echo e(config('pages.terms')); ?>" target="_blank"><?php echo e(Lang::get('create/ad.lang_terms_of_service')); ?></a>
							</label>
							<?php if($errors->has('terms')): ?>
							<span class="help-block"><?php echo e($errors->first('terms')); ?></span>
							<?php endif; ?>
						</div>
						
						<?php if(Helper::settings_security()->recaptcha): ?>
							<?php echo app('captcha')->render(); ?>
						<?php endif; ?>

						<button type="submit" class="btn btn-primary heading-btn pull-right"><?php echo e(Lang::get('create/store.lang_create_store')); ?></button>
					</div>
				</div>

			</form>

		</div>

	</div>

	<div class="col-md-4">
		
		<div class="panel">
			<div class="panel-body text-center">
				<div class="icon-object border-blue text-blue"><i class="icon-reading"></i></div>
				<h5 class="text-semibold"><?php echo e(Lang::get('create/ad.lang_terms_of_service')); ?></h5>
				<p class="mb-15"><?php echo e(Lang::get('create/store.lang_terms_of_service_p')); ?></p>
				<a href="<?php echo e(config('pages.terms')); ?>" target="_blank" class="btn btn-primary"><?php echo e(Lang::get('create/ad.lang_terms_of_service')); ?></a>
			</div>
		</div>

		<!-- Contact us if you have any questions -->
		<div class="panel panel-body media-rtl">
			<div class="media no-margin stack-media-on-mobile">
				<div class="media-left media-middle">
					<i class="icon-lifebuoy icon-3x text-muted no-edge-top"></i>
				</div>

				<div class="media-body">
					<h6 class="media-heading text-semibold"><?php echo e(Lang::get('create/ad.lang_got_question')); ?></h6>
					<span class="text-muted"><?php echo e(Lang::get('contact.lang_contact_us_directly')); ?></span>
				</div>

				<div class="media-right media-middle">
					<a href="<?php echo e(Protocol::home()); ?>/contact" class="btn btn-primary"><?php echo e(Lang::get('create/ad.lang_contact')); ?></a>
				</div>
			</div>
		</div>

	</div>

</div>

<?php $__env->stopSection(); ?>
<?php echo $__env->make(Theme::get().'.layout.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>