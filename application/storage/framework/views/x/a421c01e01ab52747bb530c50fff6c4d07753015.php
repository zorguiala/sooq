<?php $__env->startSection('content'); ?>

<div class="row">
	<div class="col-md-12">

		<!-- Session Messages -->
        <?php if(Session::has('error')): ?>
        <div class="alert alert-danger"><?php echo e(Session::get('error')); ?></div>
        <?php endif; ?>

        <?php if(Session::has('success')): ?>
        <div class="alert alert-success"><?php echo e(Session::get('success')); ?></div>
        <?php endif; ?> 
		
		<div class="profile">
			<div class="portlet light ">
                <div class="portlet-title tabbable-line">
                    <div class="caption caption-md">
                        <i class="icon-globe theme-font hide"></i>
                        <span class="caption-subject font-blue bold uppercase">تحرير الإعلان</span>
                    </div>
                </div>
                <div class="portlet-body">
                    <div class="tab-content">

                        <div class="tab-pane active" id="tab_1_1">
                            <form role="form" action="<?php echo e(Protocol::home()); ?>/dashboard/ads/edit/<?php echo e($ad->ad_id); ?>" method="POST" enctype="multipart/form-data">

                            	<?php echo e(csrf_field()); ?>


                            	<!-- Ad Title -->
                                <div class="form-group <?php echo e($errors->has('title') ? 'has-error' :''); ?>">
                                    <label class="control-label">Title</label>
                                    <input placeholder="Title" value="<?php echo e($ad->title); ?>" class="form-control" type="text" name="title"> 
                                    <?php if($errors->has('title')): ?>
	                                <span class="help-block"><?php echo e($errors->first('title')); ?></span>
	                                <?php endif; ?>
                                </div>

                                <!-- Ad Description -->
                                <div class="form-group <?php echo e($errors->has('description') ? 'has-error' :''); ?>">
                                    <label class="control-label">Description</label>
                                    <textarea class="form-control" rows="10" placeholder="Description" name="description"><?php echo e($ad->description); ?></textarea> 
                                    <?php if($errors->has('description')): ?>
	                                <span class="help-block"><?php echo e($errors->first('description')); ?></span>
	                                <?php endif; ?>
                                </div>

                                <!-- Ad Category -->
                                <div class="form-group <?php echo e($errors->has('category') ? 'has-error' :''); ?>">
                                    <label class="control-label">اختر القسم</label>
                                    <select class="form-control" name="category">
                                        <?php if(count(Helper::parent_categories())): ?>
                                        <?php $__currentLoopData = Helper::parent_categories(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $parent): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option value="<?php echo e($parent->id); ?>" <?php echo e($ad->category == $parent->id ? 'selected' : ''); ?>>-- <?php echo e($parent->category_name); ?> --</option>
                                        <?php if(count(Helper::sub_categories($parent->id))): ?>
                                        <?php $__currentLoopData = Helper::sub_categories($parent->id); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $sub): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option <?php echo e($ad->category == $sub->id ? 'selected' : ''); ?> value="<?php echo e($sub->id); ?>"><?php echo e($sub->category_name); ?></option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        <?php endif; ?>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        <?php endif; ?>
                                    </select>
                                    <?php if($errors->has('category')): ?>
	                                <span class="help-block"><?php echo e($errors->first('category')); ?></span>
	                                <?php endif; ?>
                                </div>

                                <!-- Regular Price -->
                                <div class="form-group <?php echo e($errors->has('regular_price') ? 'has-error' :''); ?>">
                                    <label class="control-label">Regular Price</label>
                                    <input placeholder="Regular Price" value="<?php echo e($ad->regular_price); ?>" class="form-control" type="text" name="regular_price"> 
                                    <?php if($errors->has('regular_price')): ?>
	                                <span class="help-block"><?php echo e($errors->first('regular_price')); ?></span>
	                                <?php endif; ?>
                                </div>

                                <!-- Ad Price -->
                                <div class="form-group <?php echo e($errors->has('price') ? 'has-error' :''); ?>">
                                    <label class="control-label">Sale Price</label>
                                    <input placeholder="Sale Price" value="<?php echo e($ad->price); ?>" class="form-control" type="text" name="price"> 
                                    <?php if($errors->has('price')): ?>
                                    <span class="help-block"><?php echo e($errors->first('price')); ?></span>
                                    <?php endif; ?>
                                </div>

                                <!-- Currency -->
                                <div class="form-group <?php echo e($errors->has('currency') ? 'has-error' :''); ?>">
                                    <label class="control-label">Currency</label>
                                    <select class="form-control" name="currency">
                                    	<?php $__currentLoopData = Currencies::database(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $currency): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option value="<?php echo e($currency->code); ?>" <?php echo e($ad->currency == $currency->code ? 'selected' : ''); ?>><?php echo e($currency->code); ?></option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </select>
                                    <?php if($errors->has('currency')): ?>
	                                <span class="help-block"><?php echo e($errors->first('currency')); ?></span>
	                                <?php endif; ?>
                                </div>

                                <!-- Negotiable -->
                                <div class="form-group <?php echo e($errors->has('negotiable') ? 'has-error' :''); ?>">
                                    <label class="control-label">قابل للتفاوض</label>
                                    <select class="form-control" name="negotiable">
                                        <?php if($ad->negotiable): ?>
                                        <option value="1">قابل للتفاوض</option>
                                        <option value="0">غير قابل للتفاوض</option>
                                        <?php else: ?>
                                        <option value="0">غير قابل للتفاوض</option>
                                        <option value="1">قابل للتفاوض</option>
                                        <?php endif; ?>
                                    </select>
                                    <?php if($errors->has('negotiable')): ?>
                                    <span class="help-block"><?php echo e($errors->first('negotiable')); ?></span>
                                    <?php endif; ?>
                                </div>

                                <!-- Condition -->
                                <div class="form-group <?php echo e($errors->has('condition') ? 'has-error' :''); ?>">
                                    <label class="control-label">Condition</label>
                                    <select class="form-control" name="condition">
                                    	<?php if($ad->is_used): ?>
                                        <option value="1">مستخدم</option>
                                        <option value="0">جديد</option>
                                        <?php else: ?>
                                        <option value="0">جديد</option>
                                        <option value="1">مستخدم</option>
                                        <?php endif; ?>
                                    </select>
                                    <?php if($errors->has('condition')): ?>
	                                <span class="help-block"><?php echo e($errors->first('condition')); ?></span>
	                                <?php endif; ?>
                                </div>

                                <!-- Status -->
                                <div class="form-group <?php echo e($errors->has('status') ? 'has-error' :''); ?>">
                                    <label class="control-label">Status</label>
                                    <select class="form-control" name="status">
                                    	<?php if($ad->status): ?>
                                        <option value="1">نشط</option>
                                        <option value="0">غير نشط</option>
                                        <?php else: ?>
                                        <option value="0">غير نشط</option>
                                        <option value="1">نشط</option>
                                        <?php endif; ?>
                                    </select>
                                    <?php if($errors->has('status')): ?>
	                                <span class="help-block"><?php echo e($errors->first('status')); ?></span>
	                                <?php endif; ?>
                                </div>

                                <!-- Featured -->
                                <div class="form-group <?php echo e($errors->has('featured') ? 'has-error' :''); ?>">
                                    <label class="control-label">Featured</label>
                                    <select class="form-control" name="featured">
                                    	<?php if($ad->is_featured): ?>
                                        <option value="1">نعم</option>
                                        <option value="0">لا</option>
                                        <?php else: ?>
                                        <option value="0">لا</option>
                                        <option value="1">نعم</option>
                                        <?php endif; ?>
                                    </select>
                                    <?php if($errors->has('featured')): ?>
	                                <span class="help-block"><?php echo e($errors->first('featured')); ?></span>
	                                <?php endif; ?>
                                </div>

                                <!-- Archived -->
                                <div class="form-group <?php echo e($errors->has('archived') ? 'has-error' :''); ?>">
                                    <label class="control-label">Archived</label>
                                    <select class="form-control" name="archived">
                                    	<?php if($ad->is_archived): ?>
                                        <option value="1">نعم</option>
                                        <option value="0">لا</option>
                                        <?php else: ?>
                                        <option value="0">لا</option>
                                        <option value="1">نعم</option>
                                        <?php endif; ?>
                                    </select>
                                    <?php if($errors->has('archived')): ?>
	                                <span class="help-block"><?php echo e($errors->first('archived')); ?></span>
	                                <?php endif; ?>
                                </div>

                                <!-- Youtube -->
                                <div class="form-group <?php echo e($errors->has('youtube') ? 'has-error' :''); ?>">
                                    <label class="control-label">Youtube Video</label>
                                    <input placeholder="Youtube Video" value="<?php echo e($ad->youtube); ?>" class="form-control" type="text" name="youtube"> 
                                    <?php if($errors->has('youtube')): ?>
                                    <span class="help-block"><?php echo e($errors->first('youtube')); ?></span>
                                    <?php endif; ?>
                                </div>

                                <!-- Affiliate Link -->
                                <div class="form-group <?php echo e($errors->has('affiliate_link') ? 'has-error' :''); ?>">
                                    <label class="control-label">اضف لينك</label>
                                    <input placeholder="Amazon, eBay, Aliexpress... Affiliate link here" value="<?php echo e($ad->affiliate_link); ?>" class="form-control" type="text" name="affiliate_link"> 
                                    <?php if($errors->has('affiliate_link')): ?>
                                    <span class="help-block"><?php echo e($errors->first('affiliate_link')); ?></span>
                                    <?php endif; ?>
                                </div>

                                <!-- Photos Uploader -->
                                <div class="images-uploader-box">
                                    <ul>
                                        <?php if(Profile::hasStore(Auth::id())): ?>
                                            <?php 
                                                $maxImages = Helper::settings_membership()->pro_ad_images;
                                            ?>
                                        <?php else: ?> 
                                            <?php 
                                                $maxImages = Helper::settings_membership()->free_ad_images;
                                            ?>
                                        <?php endif; ?>
            
                                        <?php for($i = 1; $i <= $maxImages; $i++): ?>
                                        <li>
                                            <div class="images-uploader-item">

                                                    <div style="top:37%; height: 100%">
                                                        <a href="#" class="images-uploader-item-addphoto">
                                                            <i class="icon-plus3"></i>
                                                            <input onchange="uploaderGetPreview(this)" id="uploaderImageId<?php echo e($i); ?>" class="images-uploader-input" name="photos[]" type="file" accept="image/*" style="top: -10px;right: -40px;position: absolute;cursor: pointer;opacity: 0;font-size: 100px;" />
                                                        </a>
                                                    </div>

                                                    <div class="images-uploader-nav-panel" id="remove-icon-uploaderImageId<?php echo e($i); ?>"  onclick="uploaderRemovePreview(this)" data-input-id="uploaderImageId<?php echo e($i); ?>">
                                                        <i class="icon-cross2 images-uploader-remove-icon"></i>
                                                    </div>

                                                    <div class="images-uploader-preview" id="uploaderImageId<?php echo e($i); ?>Preview"></div>
                                            </div>
                                        </li>
                                        <?php endfor; ?>
                                    </ul>
                                </div>

                                <!-- Old Images -->
                                <div>
                                    <ul style="list-style: none;padding-left: 0" class="row">
                                        <?php for($j=0; $j<= $ad->photos_number; $j++): ?>
                                        <li class="col-sm-6 col-md-3" style="margin-bottom: 20px;">
                                            <a href="<?php echo e(Protocol::home()); ?>/application/public/uploads/images/<?php echo e($ad->ad_id); ?>/previews/preview_<?php echo e($j); ?>.jpg" target="_blank">
                                                <div style="background-image: url(<?php echo e(Protocol::home()); ?>/application/public/uploads/images/<?php echo e($ad->ad_id); ?>/previews/preview_<?php echo e($j); ?>.jpg);height: 90px;width: 100%;border-radius: 5px !important;background-position: 50%;background-size: cover;"></div>
                                            </a>
                                        </li>
                                        <?php endfor; ?>
                                    </ul>
                                </div>

                                <div class="margiv-top-10">
                                    <button type="submit" class="btn default" style="width: 100%;text-transform: uppercase;"> تحديث الإعلان </button>
                                </div>

                            </form>
                        </div>

                    </div>
                </div>
            </div>
		</div>

	</div>
</div>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('dashboard.layout.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>