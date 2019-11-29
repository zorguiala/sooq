<?php $__env->startSection('content'); ?>

<!-- Edit Store -->
<div class="row">
	
	<div class="col-md-12">

		<!-- Session Messages -->
    	<?php if(Session::has('error')): ?>
    	<div class="alert alert-danger">
           	<?php echo e(Session::get('error')); ?> 
        </div>
        <?php endif; ?>
        <?php if(Session::has('success')): ?>
    	<div class="alert alert-success">
           	<?php echo e(Session::get('success')); ?> 
        </div>
        <?php endif; ?>
		
		<div class="portlet light ">

            <div class="portlet-title tabbable-line">
                <div class="caption caption-md">
                    <span class="caption-subject font-blue bold uppercase">Edit "<?php echo e($store->title); ?>" Store</span>
                </div>
            </div>

			<div class="portlet-body">
				
                <form method="POST" action="<?php echo e(Protocol::home()); ?>/dashboard/stores/edit/<?php echo e($store->username); ?>" enctype="multipart/form-data">
                    
                    <?php echo e(csrf_field()); ?>


                    <div class="row">

                        <!-- Store Title -->
                        <div class="col-md-6">
                            <div class="form-group form-md-line-input <?php echo e($errors->has('title') ? 'has-error' : ''); ?>">
                                <input type="text" class="form-control" id="title" placeholder="Enter store title" value="<?php echo e($store->title); ?>" name="title">
                                <label for="title">عنوان المتجر</label>
                                <?php if($errors->has('title')): ?>
                                <span class="help-block"><?php echo e($errors->first('title')); ?></span>
                                <?php endif; ?>
                            </div>
                        </div>

                        <!-- Store Username -->
                        <div class="col-md-6">
                            <div class="form-group form-md-line-input <?php echo e($errors->has('username') ? 'has-error' : ''); ?>">
                                <input type="text" class="form-control" id="username" placeholder="Enter store username" value="<?php echo e($store->username); ?>" name="username">
                                <label for="username">اسم المستخدم</label>
                                <?php if($errors->has('username')): ?>
                                <span class="help-block"><?php echo e($errors->first('username')); ?></span>
                                <?php endif; ?>
                            </div>
                        </div>

                        <!-- Short Description -->
                        <div class="col-md-6">
                            <div class="form-group form-md-line-input <?php echo e($errors->has('short_desc') ? 'has-error' : ''); ?>">
                                <input type="text" class="form-control" id="short_desc" placeholder="Enter short description" value="<?php echo e($store->short_desc); ?>" name="short_desc">
                                <label for="short_desc">وصف قصير</label>
                                <?php if($errors->has('short_desc')): ?>
                                <span class="help-block"><?php echo e($errors->first('short_desc')); ?></span>
                                <?php endif; ?>
                            </div>
                        </div>
    
                        <!-- Long Description -->
                        <div class="col-md-6">
                            <div class="form-group form-md-line-input <?php echo e($errors->has('long_desc') ? 'has-error' : ''); ?>">
                                <textarea rows="4" class="form-control" id="long_desc" placeholder="Enter long description" name="long_desc"><?php echo e($store->long_desc); ?></textarea>
                                <label for="long_desc">وصف طويل</label>
                                <?php if($errors->has('long_desc')): ?>
                                <span class="help-block"><?php echo e($errors->first('long_desc')); ?></span>
                                <?php endif; ?>
                            </div>
                        </div>

                        <!-- Store Category -->
                        <div class="col-md-6">
                            <div class="form-group form-md-line-input <?php echo e($errors->has('category') ? 'has-error' : ''); ?>">
                                 <select class="form-control" id="category" name="category">
                                    <option></option>
                                    <?php if(count(Helper::parent_categories())): ?>
                                    <?php $__currentLoopData = Helper::parent_categories(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $parent): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <optgroup label="<?php echo e($parent->category_name); ?>">
                                        <?php if(count(Helper::sub_categories($parent->id))): ?>
                                        <?php $__currentLoopData = Helper::sub_categories($parent->id); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $sub): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option <?php echo e($store->category == $sub->id ? 'selected' : ''); ?> value="<?php echo e($sub->id); ?>"><?php echo e($sub->category_name); ?></option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        <?php endif; ?>
                                    </optgroup>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    <?php endif; ?>
                                </select>
                                <label for="category">فئة المتجر</label>
                                <?php if($errors->has('category')): ?>
                                <span class="help-block"><?php echo e($errors->first('category')); ?></span>
                                <?php endif; ?>
                            </div>
                        </div>

                        <!-- Status -->
                        <div class="col-md-6">
                            <div class="form-group form-md-line-input <?php echo e($errors->has('status') ? 'has-error' : ''); ?>">
                                 <select class="form-control" id="status" name="status">
                                    <?php if($store->status): ?>
                                    <option value="1">نشيط</option>
                                    <option value="0">غير نشط</option>
                                    <?php else: ?> 
                                    <option value="0">غير نشط</option>
                                    <option value="1">نشيط</option>
                                    <?php endif; ?>
                                </select>
                                <label for="status">Store Status</label>
                                <?php if($errors->has('status')): ?>
                                <span class="help-block"><?php echo e($errors->first('status')); ?></span>
                                <?php endif; ?>
                            </div>
                        </div>

                        <!-- Change Logo -->
                        <div class="col-md-12">
                            <div class="form-group form-md-line-input <?php echo e($errors->has('logo') ? 'has-error' : ''); ?>">
                                <input accept="image/*" type="file" name="logo" class="form-control" id="logo">
                                <label for="logo">تحرير الشعار</label>
                                <?php if($errors->has('logo')): ?>
                                <span class="help-block"><?php echo e($errors->first('logo')); ?></span>
                                <?php endif; ?>
                            </div>
                        </div>

                        <!-- Change Cover -->
                        <div class="col-md-12">
                            <div class="form-group form-md-line-input <?php echo e($errors->has('cover') ? 'has-error' : ''); ?>">
                                <input accept="image/*" type="file" name="cover" class="form-control" id="cover">
                                <label for="cover">تحرير الغلاف</label>
                                <?php if($errors->has('cover')): ?>
                                <span class="help-block"><?php echo e($errors->first('cover')); ?></span>
                                <?php endif; ?>
                            </div>
                        </div>

                        <!-- Store Address -->
                        <div class="col-md-6">
                            <div class="form-group form-md-line-input <?php echo e($errors->has('address') ? 'has-error' : ''); ?>">
                                <input type="text" class="form-control" id="address" placeholder="Enter store address" value="<?php echo e($store->address); ?>" name="address">
                                <label for="address">عنوان المحل</label>
                                <?php if($errors->has('address')): ?>
                                <span class="help-block"><?php echo e($errors->first('address')); ?></span>
                                <?php endif; ?>
                            </div>
                        </div> 

                        <!-- Facebook Page -->
                        <div class="col-md-6">
                            <div class="form-group form-md-line-input <?php echo e($errors->has('fb_page') ? 'has-error' : ''); ?>">
                                <input type="text" class="form-control" id="fb_page" placeholder="Enter facebook page" value="<?php echo e($store->fb_page); ?>" name="fb_page">
                                <label for="fb_page">Facebook صفحة</label>
                                <?php if($errors->has('fb_page')): ?>
                                <span class="help-block"><?php echo e($errors->first('fb_page')); ?></span>
                                <?php endif; ?>
                            </div>
                        </div> 

                        <!-- Twitter Page -->
                        <div class="col-md-6">
                            <div class="form-group form-md-line-input <?php echo e($errors->has('tw_page') ? 'has-error' : ''); ?>">
                                <input type="text" class="form-control" id="tw_page" placeholder="Enter twitter page" value="<?php echo e($store->tw_page); ?>" name="tw_page">
                                <label for="tw_page">Twitter صفحة</label>
                                <?php if($errors->has('tw_page')): ?>
                                <span class="help-block"><?php echo e($errors->first('tw_page')); ?></span>
                                <?php endif; ?>
                            </div>
                        </div> 

                        <!-- Google Page -->
                        <div class="col-md-6">
                            <div class="form-group form-md-line-input <?php echo e($errors->has('go_page') ? 'has-error' : ''); ?>">
                                <input type="text" class="form-control" id="go_page" placeholder="Enter google page" value="<?php echo e($store->go_page); ?>" name="go_page">
                                <label for="fb_page">Google صفحة</label>
                                <?php if($errors->has('go_page')): ?>
                                <span class="help-block"><?php echo e($errors->first('go_page')); ?></span>
                                <?php endif; ?>
                            </div>
                        </div> 

                        <!-- Youtube Page -->
                        <div class="col-md-6">
                            <div class="form-group form-md-line-input <?php echo e($errors->has('yt_page') ? 'has-error' : ''); ?>">
                                <input type="text" class="form-control" id="yt_page" placeholder="Enter youtube page" value="<?php echo e($store->yt_page); ?>" name="yt_page">
                                <label for="fb_page">Youtube صفحة</label>
                                <?php if($errors->has('yt_page')): ?>
                                <span class="help-block"><?php echo e($errors->first('yt_page')); ?></span>
                                <?php endif; ?>
                            </div>
                        </div> 

                        <!-- Website -->
                        <div class="col-md-6">
                            <div class="form-group form-md-line-input <?php echo e($errors->has('website') ? 'has-error' : ''); ?>">
                                <input type="text" class="form-control" id="website" placeholder="Enter website" value="<?php echo e($store->website); ?>" name="website">
                                <label for="fb_page">موقع الكتروني</label>
                                <?php if($errors->has('website')): ?>
                                <span class="help-block"><?php echo e($errors->first('website')); ?></span>
                                <?php endif; ?>
                            </div>
                        </div>                      

                        <div class="col-md-12">
                            <button style="width: 100%" type="submit" class="btn default">تحديث المتجر</button>
                        </div>

                    </div>

                </form>

		    </div>
		</div>

	</div>

</div>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('dashboard.layout.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>