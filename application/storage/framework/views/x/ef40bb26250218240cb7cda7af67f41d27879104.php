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
                    <span class="caption-subject font-blue-madison bold uppercase">إنشاء مقال جديد</span>
                </div>
            </div>
            <div class="portlet-body form">
                <form role="form" class="form-horizontal" action="<?php echo e(Protocol::home()); ?>/dashboard/articles/create" method="POST" enctype="multipart/form-data">
                    <?php echo e(csrf_field()); ?>

                    <div class="form-body">

                        <!-- Title -->
                        <div class="form-group form-md-line-input <?php echo e($errors->has('title') ? 'has-error' :''); ?>">
                            <label class="col-md-2 control-label" for="title">عنوان المقال</label>
                            <div class="col-md-10">
                                <input type="text" class="form-control" id="title" placeholder="Article Title" name="title" value="<?php echo e(old('title')); ?>">
                                <div class="form-control-focus"> </div>
                                <?php if($errors->has('title')): ?>
                                <span class="help-block"><?php echo e($errors->first('title')); ?></span>
                                <?php endif; ?>
                            </div>
                        </div>

                        <!-- Cover -->
                        <div class="form-group form-md-line-input <?php echo e($errors->has('cover') ? 'has-error' :''); ?>">
                            <label class="col-md-2 control-label" for="cover">غلاف المقال</label>
                            <div class="col-md-10">
                                <input type="file" class="form-control" id="cover"  name="cover" value="<?php echo e(old('cover')); ?>">
                                <div class="form-control-focus"> </div>
                                <?php if($errors->has('cover')): ?>
                                <span class="help-block"><?php echo e($errors->first('cover')); ?></span>
                                <?php endif; ?>
                            </div>
                        </div>

                        <!-- Content -->
                        <div class="form-group form-md-line-input">
                            <label class="col-md-2 control-label" for="content">محتوى المقالة</label>
                            <div class="col-md-10">
                                <textarea name="content"><?php echo e(old('content')); ?></textarea>
                                <script>
                                    CKEDITOR.replace( 'content' );
                                </script>
                            </div>
                        </div>

                    </div>
                    <div class="form-actions">
                        <div class="row">
                            <div class="col-md-offset-2 col-md-10">
                                <button type="submit" class="btn blue">انشاء مقالة</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('dashboard.layout.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>