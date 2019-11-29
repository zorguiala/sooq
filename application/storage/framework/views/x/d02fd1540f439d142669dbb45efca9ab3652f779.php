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

        <div class="portlet light ">

            <div class="portlet-title tabbable-line">
                <div class="caption caption-md">
                    <i class="icon-globe theme-font hide"></i>
                    <span class="caption-subject font-blue bold uppercase">SMTP اعدادات</span>
                </div>
                <div class="actions" style="float: right;width: 75%;">
                    <div class="form-group">
                        <label style="padding-top: 5px;" class="col-md-4 control-label">خادم الاختبار</label>
                        <div class="col-md-8">
                            <div class="input-group">
                                <div class="input">
                                    <input id="testEmailField" class="form-control" type="text" placeholder="Enter e-mail address"> </div>
                                <span class="input-group-btn">
                                    <button id="testServer" class="btn btn-success" type="button">
                                        <i class="fa fa-envelope"></i> إرسال رسالة اختبار</button>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="portlet-body">

                <form action="<?php echo e(Protocol::home()); ?>/dashboard/settings/smtp" method="POST">
                    
                    <?php echo e(csrf_field()); ?>


                    <!-- Mail Driver -->
                    <div class="form-group <?php echo e($errors->has('driver') ? 'has-error' : ''); ?>">
                        <label class="control-label">سائق البريد</label>
                        <select class="form-control" id="driver" name="driver">
                            <?php $__currentLoopData = $drivers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $value => $driver): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($value); ?>" <?php echo e($value == config('mail.driver') ? 'selected' : ''); ?> ><?php echo e($driver); ?></option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                        <?php if($errors->has('driver')): ?>
                        <span class="help-block"><?php echo e($errors->first('driver')); ?></span>
                        <?php endif; ?>
                    </div>

                    <!-- Mail Host Server -->
                    <div class="form-group form-md-line-input <?php echo e($errors->has('host') ? 'has-error' : ''); ?>">
                        <input class="form-control" id="host" name="host" placeholder="Mail Host Server" value="<?php echo e(config('mail.host')); ?>" type="text">
                        <label for="host">Mail Host Server</label>
                        <?php if($errors->has('host')): ?>
                        <span class="help-block"><?php echo e($errors->first('host')); ?></span>
                        <?php endif; ?>
                    </div>

                    <!-- Mail Port -->
                    <div class="form-group form-md-line-input <?php echo e($errors->has('port') ? 'has-error' : ''); ?>">
                        <input class="form-control" id="host" name="port" placeholder="Mail Port" value="<?php echo e(config('mail.port')); ?>" type="text">
                        <label for="port">Mail Port</label>
                        <?php if($errors->has('port')): ?>
                        <span class="help-block"><?php echo e($errors->first('port')); ?></span>
                        <?php endif; ?>
                    </div>

                    <!-- Mail Username -->
                    <div class="form-group form-md-line-input <?php echo e($errors->has('username') ? 'has-error' : ''); ?>">
                        <input class="form-control" id="host" name="username" placeholder="Mail Username" value="<?php echo e(config('mail.username')); ?>" type="text">
                        <label for="username">اسم مستخدم البريد</label>
                        <?php if($errors->has('username')): ?>
                        <span class="help-block"><?php echo e($errors->first('username')); ?></span>
                        <?php endif; ?>
                    </div>

                    <!-- Mail Password -->
                    <div class="form-group form-md-line-input <?php echo e($errors->has('password') ? 'has-error' : ''); ?>">
                        <input class="form-control" id="host" name="password" placeholder="***********" type="password">
                        <label for="password">كلمة السر</label>
                        <?php if($errors->has('password')): ?>
                        <span class="help-block"><?php echo e($errors->first('password')); ?></span>
                        <?php endif; ?>
                    </div>

                    <!-- Sender Email Address -->
                    <div class="form-group form-md-line-input <?php echo e($errors->has('email') ? 'has-error' : ''); ?>">
                        <input class="form-control" id="host" name="email" placeholder="Sender Email Address" value="<?php echo e(config('mail.from.address')); ?>" type="text">
                        <label for="email">عنوان البريد الإلكتروني للمرسل</label>
                        <?php if($errors->has('email')): ?>
                        <span class="help-block"><?php echo e($errors->first('email')); ?></span>
                        <?php endif; ?>
                    </div>

                    <!-- Sender Name -->
                    <div class="form-group form-md-line-input <?php echo e($errors->has('name') ? 'has-error' : ''); ?>">
                        <input class="form-control" id="host" name="name" placeholder="Sender Name" value="<?php echo e(config('mail.from.name')); ?>" type="text">
                        <label for="name">اسم المرسل</label>
                        <?php if($errors->has('name')): ?>
                        <span class="help-block"><?php echo e($errors->first('name')); ?></span>
                        <?php endif; ?>
                    </div>

                    <!-- Encryption Protocol -->
                    <div class="form-group <?php echo e($errors->has('encryption') ? 'has-error' : ''); ?>">
                        <label class="control-label">بروتوكول التشفير</label>
                        <select class="form-control" id="encryption" name="encryption">
                            <?php if(config('mail.encryption') == 'tls'): ?>
                            <option value="tls">TLS</option>
                            <option value="ssl">SSL</option>
                            <?php else: ?>
                            <option value="ssl">SSL</option>
                            <option value="tls">TLS</option>
                            <?php endif; ?>
                        </select>
                        <?php if($errors->has('encryption')): ?>
                        <span class="help-block"><?php echo e($errors->first('encryption')); ?></span>
                        <?php endif; ?>
                    </div>

                    <button style="width: 100%" type="submit" class="btn default">تحديث الاعدادات</button>

                </form>

            </div>

        </div>

    </div>

</div>

<script type="text/javascript">
    
    $('#testServer').on('click', function(e){

        e.preventDefault();

        var email     = document.getElementById('testEmailField').value,
            home      = document.getElementById('root').getAttribute('data-root'),
            newUrl    = home + '/dashboard/settings/smtp/test?email=' +email;

        window.open(newUrl, '_blank', 'location=yes,height=570,width=520,scrollbars=yes,status=yes');


    })

</script>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('dashboard.layout.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>