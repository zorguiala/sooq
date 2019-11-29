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

        <!-- Edit User -->
        <div class="portlet light ">

            <div class="portlet-title tabbable-line">
                <div class="caption caption-md">
                    <i class="icon-globe theme-font hide"></i>
                    <span class="caption-subject font-blue-madison bold uppercase">Edit "<?php echo e($user->first_name); ?> <?php echo e($user->last_name); ?>" Profile</span>
                </div>
            </div>

            <div class="portlet-body">

                <form method="POST" action="<?php echo e(Protocol::home()); ?>/dashboard/users/edit/<?php echo e($user->username); ?>" enctype="multipart/form-data">
                    
                    <?php echo e(csrf_field()); ?>


                    <div class="row">

                        <!-- First Name -->
                        <div class="col-md-6">
                            <div class="form-group form-md-line-input <?php echo e($errors->has('first_name') ? 'has-error' : ''); ?>">
                                <input type="text" class="form-control" id="first_name" placeholder="Enter first name" value="<?php echo e($user->first_name); ?>" name="first_name">
                                <label for="first_name">الاسم الاول</label>
                                <?php if($errors->has('first_name')): ?>
                                <span class="help-block"><?php echo e($errors->first('first_name')); ?></span>
                                <?php endif; ?>
                            </div>
                        </div>

                        <!-- Last Name -->
                        <div class="col-md-6">
                            <div class="form-group form-md-line-input <?php echo e($errors->has('last_name') ? 'has-error' : ''); ?>">
                                <input type="text" class="form-control" id="last_name" placeholder="Enter last name" value="<?php echo e($user->last_name); ?>" name="last_name">
                                <label for="last_name">الاسم الاخير</label>
                                <?php if($errors->has('last_name')): ?>
                                <span class="help-block"><?php echo e($errors->first('last_name')); ?></span>
                                <?php endif; ?>
                            </div>
                        </div>
    
                        <!-- Username -->
                        <div class="col-md-6">
                            <div class="form-group form-md-line-input <?php echo e($errors->has('username') ? 'has-error' : ''); ?>">
                                <input type="text" class="form-control" id="username" placeholder="Enter username" value="<?php echo e($user->username); ?>" name="username">
                                <label for="username">اسم المستخدم</label>
                                <?php if($errors->has('username')): ?>
                                <span class="help-block"><?php echo e($errors->first('username')); ?></span>
                                <?php endif; ?>
                            </div>
                        </div>

                        <!-- E-mail Address -->
                        <div class="col-md-6">
                            <div class="form-group form-md-line-input <?php echo e($errors->has('email') ? 'has-error' : ''); ?>">
                                <input type="text" class="form-control" id="email" placeholder="Enter e-mail Address" value="<?php echo e($user->email); ?>" name="email">
                                <label for="email">عنوان بريد الكتروني</label>
                                <?php if($errors->has('email')): ?>
                                <span class="help-block"><?php echo e($errors->first('email')); ?></span>
                                <?php endif; ?>
                            </div>
                        </div>

                        <!-- User Country -->
                        <div class="col-md-6">
                            <div class="form-group form-md-line-input <?php echo e($errors->has('country') ? 'has-error' : ''); ?>">
                                 <select class="form-control" id="country" name="country" onchange="getStates(this.value)">
                                    <?php $__currentLoopData = $countries; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $country): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($country->sortname); ?>" <?php echo e($country->sortname == $user->country_code ? 'selected' : ''); ?>><?php echo e($country->name); ?></option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </select>
                                <label for="country">بلد</label>
                                <?php if($errors->has('country')): ?>
                                <span class="help-block"><?php echo e($errors->first('country')); ?></span>
                                <?php endif; ?>
                            </div>
                        </div>

                        <!-- User State -->
                        <div class="col-md-6">
                            <div class="form-group form-md-line-input <?php echo e($errors->has('state') ? 'has-error' : ''); ?>">
                                 <select class="form-control" id="putStates" name="state" onchange="getCities(this.value)">
                                    <?php $__currentLoopData = $states; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $state): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($state->id); ?>" <?php echo e($state->id == $user->state ? 'selected' : ''); ?>><?php echo e($state->name); ?></option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </select>
                                <label for="putStates">دولة</label>
                                <?php if($errors->has('state')): ?>
                                <span class="help-block"><?php echo e($errors->first('state')); ?></span>
                                <?php endif; ?>
                            </div>
                        </div>

                        <!-- User City -->
                        <div class="col-md-6">
                            <div class="form-group form-md-line-input <?php echo e($errors->has('city') ? 'has-error' : ''); ?>">
                                 <select class="form-control" id="putCities" name="city">
                                    <?php $__currentLoopData = $cities; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $city): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($city->id); ?>" <?php echo e($city->id == $user->city ? 'selected' : ''); ?>><?php echo e($city->name); ?></option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </select>
                                <label for="putCities">City</label>
                                <?php if($errors->has('city')): ?>
                                <span class="help-block"><?php echo e($errors->first('city')); ?></span>
                                <?php endif; ?>
                            </div>
                        </div>

                        <!-- Phone Number -->
                        <div class="col-md-6">

                            <div class="row">
                                
                                <!-- Phone Code -->
                                <div class="col-md-3">
                                    <div class="form-group form-md-line-input <?php echo e($errors->has('phonecode') ? 'has-error' : ''); ?>">
                                        <input type="text" class="form-control" id="putPhoneCode" value="<?php echo e($default_country->phonecode); ?>" name="phonecode">
                                        <label for="putPhoneCode">كود</label>
                                        <?php if($errors->has('phonecode')): ?>
                                        <span class="help-block"><?php echo e($errors->first('phonecode')); ?></span>
                                        <?php endif; ?>
                                    </div>
                                </div>

                                <!-- Phone Number -->
                                <div class="col-md-9">
                                    <div class="form-group form-md-line-input <?php echo e($errors->has('phone') ? 'has-error' : ''); ?>">
                                        <input type="text" class="form-control" id="phone" placeholder="Enter phone number" value="<?php echo e($user->phone); ?>" name="phone">
                                        <label for="phone">رقم الهاتف</label>
                                        <?php if($errors->has('phone')): ?>
                                        <span class="help-block"><?php echo e($errors->first('phone')); ?></span>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            

                            </div>

                        </div>

                        <!-- Hide Phone Number -->
                        <div class="col-md-6">
                            <div class="form-group form-md-line-input <?php echo e($errors->has('phone_hidden') ? 'has-error' : ''); ?>">
                                 <select class="form-control" id="phone_hidden" name="phone_hidden">
                                    <?php if($user->phone_hidden): ?>
                                    <option value="1">مخفي</option>
                                    <option value="0">مرئي</option>
                                    <?php else: ?> 
                                    <option value="0">مرئي</option>
                                    <option value="1">مخفي</option>
                                    <?php endif; ?>
                                </select>
                                <label for="phone_hidden">إخفاء رقم الهاتف</label>
                                <?php if($errors->has('phone_hidden')): ?>
                                <span class="help-block"><?php echo e($errors->first('phone_hidden')); ?></span>
                                <?php endif; ?>
                            </div>
                        </div>

                        <!-- Gender -->
                        <div class="col-md-6">
                            <div class="form-group form-md-line-input <?php echo e($errors->has('gender') ? 'has-error' : ''); ?>">
                                 <select class="form-control" id="gender" name="gender">
                                    <?php if($user->gender): ?>
                                    <option value="1">ولد</option>
                                    <option value="0">بنت</option>
                                    <?php else: ?> 
                                    <option value="0">بنت</option>
                                    <option value="1">ولد</option>
                                    <?php endif; ?>
                                </select>
                                <label for="gender">النوع</label>
                                <?php if($errors->has('gender')): ?>
                                <span class="help-block"><?php echo e($errors->first('gender')); ?></span>
                                <?php endif; ?>
                            </div>
                        </div>

                        <!-- Is Administrator -->
                        <div class="col-md-6">
                            <div class="form-group form-md-line-input <?php echo e($errors->has('is_admin') ? 'has-error' : ''); ?>">
                                 <select class="form-control" id="is_admin" name="is_admin">
                                    <?php if($user->is_admin): ?>
                                    <option value="1">نعم</option>
                                    <option value="0">لا</option>
                                    <?php else: ?>
                                    <option value="0">لا</option>
                                    <option value="1">نعم</option>
                                    <?php endif; ?>
                                </select>
                                <label for="is_admin">Is Administrator</label>
                                <?php if($errors->has('is_admin')): ?>
                                <span class="help-block"><?php echo e($errors->first('is_admin')); ?></span>
                                <?php endif; ?>
                            </div>
                        </div>

                        <!-- Account Type -->
                        <div class="col-md-6">
                            <div class="form-group form-md-line-input <?php echo e($errors->has('account_type') ? 'has-error' : ''); ?>">
                                 <select class="form-control" id="account_type" name="account_type">
                                    <?php if($user->account_type): ?>
                                    <option value="1">المحترفين</option>
                                    <option value="0">اساسي</option>
                                    <?php else: ?>
                                    <option value="0">اساسي</option>
                                    <option value="1">المحترفين</option>
                                    <?php endif; ?>
                                </select>
                                <label for="account_type">نوع الحساب</label>
                                <?php if($errors->has('account_type')): ?>
                                <span class="help-block"><?php echo e($errors->first('account_type')); ?></span>
                                <?php endif; ?>
                            </div>
                        </div>

                        <!-- Status -->
                        <div class="col-md-6">
                            <div class="form-group form-md-line-input <?php echo e($errors->has('status') ? 'has-error' : ''); ?>">
                                 <select class="form-control" id="status" name="status">
                                    <?php if($user->status): ?>
                                    <option value="1">نشيط</option>
                                    <option value="0">غير نشط</option>
                                    <?php else: ?>
                                    <option value="0">غير نشط</option>
                                    <option value="1">نشيط</option>
                                    <?php endif; ?>
                                </select>
                                <label for="status">الحالة</label>
                                <?php if($errors->has('status')): ?>
                                <span class="help-block"><?php echo e($errors->first('status')); ?></span>
                                <?php endif; ?>
                            </div>
                        </div>
                            
                        <div class="col-md-6">
                            <!-- Change Avatar -->
                            <div class="form-group form-md-line-input <?php echo e($errors->has('avatar') ? 'has-error' : ''); ?>">
                                <input type="file" name="avatar" class="form-control" id="avatar">
                                <label for="avatar">تحرير الصورة الرمزية</label>
                                <?php if($errors->has('avatar')): ?>
                                <span class="help-block"><?php echo e($errors->first('avatar')); ?></span>
                                <?php endif; ?>
                            </div>
                        </div>


                        <hr>

                        <!-- Update Password -->
                        <div class="col-md-6">
                            <div class="form-group form-md-line-input <?php echo e($errors->has('password') ? 'has-error' : ''); ?>">
                                <input type="password" class="form-control" id="password" placeholder="Enter Password" name="password">
                                <label for="password">كلمة السر الجديدة</label>
                                <?php if($errors->has('password')): ?>
                                <span class="help-block"><?php echo e($errors->first('password')); ?></span>
                                <?php endif; ?>
                            </div>
                        </div>

                        <!-- Confirm Password -->
                        <div class="col-md-6">
                            <div class="form-group form-md-line-input <?php echo e($errors->has('password_confirmation') ? 'has-error' : ''); ?>">
                                <input type="password" class="form-control" id="password_confirmation" placeholder="Confirm Password" name="password_confirmation">
                                <label for="password_confirmation">تأكيد كلمة المرور</label>
                                <?php if($errors->has('password_confirmation')): ?>
                                <span class="help-block"><?php echo e($errors->first('password_confirmation')); ?></span>
                                <?php endif; ?>
                            </div>
                        </div>                        

                        <div class="col-md-12">
                            <button type="submit" style="width: 100%" class="btn blue">تحديث</button>
                        </div>

                    </div>

                </form>

            </div>

        </div>

    </div>

</div>

<script type="text/javascript">
    
    /**
    * Get States
    */
    function getStates(country) {
        var _root = $('#root').attr('data-root');
        var country_id = country;
        $.ajax({
            type: "GET",
            url: _root + '/tools/geo/states/states_by_country',
            data: {
                country_id: country_id
            },
            success: function(response) {
                if (response.status == 'success') {
                    $('#putStates').find('option').remove();
                    $('#putStates').append($('<option>', {
                        text: 'Select state',
                        value: 'all'
                    }));
                    $.each(response.data, function(array, object) {
                        $('#putStates').append($('<option>', {
                            value: object.id,
                            text: object.name
                        }))
                    });

                    // Change phonecode
                    document.getElementById('putPhoneCode').value = response.phonecode;
                }
                if (response.status == 'error') {
                    alert(response.msg)
                }
            }
        })
    }

    /**
    * Get Cities
    */
    function getCities(state) {
        var _root = $('#root').attr('data-root');
        var state_id = state;
        $.ajax({
            type: "GET",
            url: _root + '/tools/geo/cities/cities_by_state',
            data: {
                state_id: state_id
            },
            success: function(response) {
                if (response.status == 'success') {
                    $('#putCities').find('option').remove();
                    $('#putCities').append($('<option>', {
                        text: 'Select city',
                        value: 'all'
                    }));
                    $.each(response.data, function(array, object) {
                        $('#putCities').append($('<option>', {
                            value: object.id,
                            text: object.name
                        }))
                    });
                }
                if (response.status == 'error') {
                    alert(response.msg)
                }
            }
        })
    }

</script>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('dashboard.layout.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>