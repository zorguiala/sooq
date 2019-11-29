<?php $__env->startSection('content'); ?>

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
            <div class="portlet-title">
                <div class="caption caption-md">
                    <span class="caption-subject font-blue-madison bold uppercase">Edit <?php echo e($page->page_name); ?> Page</span>
                </div>
            </div>
            <div class="portlet-body form">
                <form role="form" class="form-horizontal" action="<?php echo e(Protocol::home()); ?>/dashboard/pages/edit/<?php echo e($page->page_slug); ?>" method="POST">
                	<?php echo e(csrf_field()); ?>

                    <div class="form-body">

                    	<!-- Page Name -->
                        <div class="form-group form-md-line-input <?php echo e($errors->has('page_name') ? 'has-error' :''); ?>">
                            <label class="col-md-2 control-label" for="page_name">اسم الصفحة</label>
                            <div class="col-md-10">
                                <input type="text" class="form-control" id="page_name" placeholder="Page Name" name="page_name" value="<?php echo e($page->page_name); ?>">
                                <div class="form-control-focus"> </div>
                                <?php if($errors->has('page_name')): ?>
                                <span class="help-block"><?php echo e($errors->first('page_name')); ?></span>
                                <?php endif; ?>
                            </div>
                        </div>

                        <!-- Page Slug -->
                        <div class="form-group form-md-line-input <?php echo e($errors->has('page_slug') ? 'has-error' :''); ?>">
                            <label class="col-md-2 control-label" for="page_slug">الصفحة</label>
                            <div class="col-md-10">
                                <input type="text" class="form-control" id="page_slug" placeholder="Page Slug" name="page_slug" value="<?php echo e($page->page_slug); ?>">
                                <div class="form-control-focus"> </div>
                                <?php if($errors->has('page_slug')): ?>
                                <span class="help-block"><?php echo e($errors->first('page_slug')); ?></span>
                                <?php endif; ?>
                            </div>
                        </div>

                        <!-- Page Collection -->
                        <div class="form-group form-md-line-input <?php echo e($errors->has('page_col') ? 'has-error' :''); ?>">
                            <label class="col-md-2 control-label" for="page_col">ودجت الصفحة </label>
                            <div class="col-md-10">
                                <select class="form-control" id="page_col" name="page_col">
                                    <?php
                                    $pages = Config::get('footer');
                                    unset($pages['copyright']);
                                    ?>
                                    <?php $__currentLoopData = $pages; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $col => $title): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($col); ?>"><?php echo e($title); ?></option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </select>
                                <div class="form-control-focus"> </div>
                                <?php if($errors->has('page_col')): ?>
                                <span class="help-block"><?php echo e($errors->first('page_col')); ?></span>
                                <?php endif; ?>
                            </div>
                        </div>

                        <!-- Page Content -->
                        <div class="form-group form-md-line-input">
                            <label class="col-md-2 control-label" for="is_sub">محتوى الصفحة </label>
                            <div class="col-md-10">
                                <textarea name="page_content"><?php echo e($page->page_content); ?></textarea>
                                <script>
                                    CKEDITOR.replace( 'page_content' );
                                </script>
                            </div>
                        </div>

                    </div>
                    <div class="form-actions">
                        <div class="row">
                            <div class="col-md-offset-2 col-md-10">
                                <button type="submit" class="btn blue">تحرير الصفحة</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('dashboard.layout.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>