<?php $__env->startSection('content'); ?>

<div class="row">
    
    <div class="col-md-12">
        
        <!-- Sessions Messages -->
        <?php if(Session::has('success')): ?>
        <div class="custom-alerts alert alert-success fade in">
            <?php echo e(Session::get('success')); ?>

        </div>
        <?php endif; ?>

        <?php if(Session::has('error')): ?>
        <div class="custom-alerts alert alert-danger fade in">
            <?php echo e(Session::get('error')); ?>

        </div>
        <?php endif; ?>

        <!-- Create a store -->
        <div class="portlet light ">

            <div class="portlet-title tabbable-line">
                <div class="caption caption-md">
                    <i class="icon-globe theme-font hide"></i>
                    <span class="caption-subject font-blue-madison bold uppercase">Create new store for "<?php echo e($user->username); ?>"</span>
                </div>
            </div>

            <div class="portlet-body">

                <form method="POST" action="<?php echo e(Protocol::home()); ?>/dashboard/users/<?php echo e($user->username); ?>/create/store" enctype="multipart/form-data">
                    
                    <?php echo e(csrf_field()); ?>


                    <div class="row">

                        <!-- Store username -->
                        <div class="col-md-6">
                            <div class="form-group form-md-line-input <?php echo e($errors->has('username') ? 'has-error' : ''); ?>">
                                <input type="text" class="form-control" id="username" placeholder="Enter store username" value="<?php echo e(old('username')); ?>" name="username">
                                <label for="username">اسم مستخدم المتجر</label>
                                <?php if($errors->has('username')): ?>
                                <span class="help-block"><?php echo e($errors->first('username')); ?></span>
                                <?php endif; ?>
                            </div>
                        </div>

                        <!-- Store title -->
                        <div class="col-md-6">
                            <div class="form-group form-md-line-input <?php echo e($errors->has('title') ? 'has-error' : ''); ?>">
                                <input type="text" class="form-control" id="title" placeholder="Enter store title" value="<?php echo e(old('title')); ?>" name="title">
                                <label for="title">عنوان المتجر</label>
                                <?php if($errors->has('title')): ?>
                                <span class="help-block"><?php echo e($errors->first('title')); ?></span>
                                <?php endif; ?>
                            </div>
                        </div>

                        <!-- Store short description -->
                        <div class="col-md-6">
                            <div class="form-group form-md-line-input <?php echo e($errors->has('short_desc') ? 'has-error' : ''); ?>">
                                <input type="text" class="form-control" id="short_desc" placeholder="Enter store short description" value="<?php echo e(old('short_desc')); ?>" name="short_desc">
                                <label for="short_desc">Store short description</label>
                                <?php if($errors->has('short_desc')): ?>
                                <span class="help-block"><?php echo e($errors->first('short_desc')); ?></span>
                                <?php endif; ?>
                            </div>
                        </div>

                        <!-- Store long description -->
                        <div class="col-md-6">
                            <div class="form-group form-md-line-input <?php echo e($errors->has('long_desc') ? 'has-error' : ''); ?>">
                                <textarea rows="5" class="form-control" id="long_desc" name="long_desc" placeholder="Enter store long description"><?php echo e(old('long_desc')); ?></textarea>
                                <label for="long_desc">Store long description</label>
                                <?php if($errors->has('long_desc')): ?>
                                <span class="help-block"><?php echo e($errors->first('long_desc')); ?></span>
                                <?php endif; ?>
                            </div>
                        </div>

                        <!-- Store expires after (days) -->
                        <div class="col-md-6">
                            <div class="form-group form-md-line-input <?php echo e($errors->has('ends_at') ? 'has-error' : ''); ?>">
                                <input type="number" class="form-control" id="ends_at" placeholder="Store ends after how many days?" value="<?php echo e(old('ends_at')); ?>" name="ends_at">
                                <label for="ends_at">Store expires after (days)</label>
                                <?php if($errors->has('ends_at')): ?>
                                <span class="help-block"><?php echo e($errors->first('ends_at')); ?></span>
                                <?php endif; ?>
                            </div>
                        </div>

                        <!-- Store Category -->
                        <div class="col-md-6">
                            <div class="form-group form-md-line-input <?php echo e($errors->has('category') ? 'has-error' :''); ?>">
                                <select id="category" class="form-control" name="category">
                                    <?php if(count(Helper::parent_categories())): ?>
                                    <?php $__currentLoopData = Helper::parent_categories(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $parent): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($parent->id); ?>" <?php echo e(old('category') == $parent->id ? 'selected' : ''); ?>>-- <?php echo e($parent->category_name); ?> --</option>
                                    <?php if(count(Helper::sub_categories($parent->id))): ?>
                                    <?php $__currentLoopData = Helper::sub_categories($parent->id); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $sub): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option <?php echo e(old('category') == $sub->id ? 'selected' : ''); ?> value="<?php echo e($sub->id); ?>"><?php echo e($sub->category_name); ?></option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    <?php endif; ?>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    <?php endif; ?>
                                </select>
                                <label for="category">Store category</label>
                                <?php if($errors->has('category')): ?>
                                <span class="help-block"><?php echo e($errors->first('category')); ?></span>
                                <?php endif; ?>
                            </div> 
                        </div>     

                        <div class="col-md-12">
                            <button type="submit" style="width: 100%" class="btn blue">إنشاء المتجر</button>
                        </div>

                    </div>

                </form>

            </div>

        </div>

    </div>

</div>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('dashboard.layout.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>