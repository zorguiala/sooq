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
                    <span class="caption-subject bold font-blue uppercase">App Geo اعدادات</span>
                </div>
            </div>
            <div class="portlet-body">
                <form role="form" action="<?php echo e(Protocol::home()); ?>/dashboard/settings/geo" method="POST">

                    <?php echo e(csrf_field()); ?>


                    <!-- International -->
                    <div class="form-group <?php echo e($errors->has('is_international') ? 'has-error' : ''); ?>">
                        <label class="control-label">دولي</label>
                        <select class="form-control" id="is_international" name="is_international">
                        <?php if($settings->is_international): ?>
                        <option value="1">دولي</option>
                        <option value="0">الوطني</option>
                        <?php else: ?>
                        <option value="0">الوطني</option>
                        <option value="1">دولي</option>
                        <?php endif; ?>
                    </select>
                        <?php if($errors->has('is_international')): ?>
                        <span class="help-block"><?php echo e($errors->first('is_international')); ?></span>
                        <?php endif; ?>
                    </div>

                    <!-- Default Country -->
                    <div class="form-group <?php echo e($errors->has('default_country') ? 'has-error' : ''); ?>">
                        <label class="control-label">البلد الافتراضي</label>
                        <select class="form-control" name="default_country" id="country" onchange="getStates(this.value)">
                        <?php $__currentLoopData = $countries; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $country): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo e($country->id); ?>" <?php echo e($settings->default_country == $country->id ? 'selected' : ''); ?>><?php echo e($country->name); ?></option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                        <?php if($errors->has('default_country')): ?>
                        <span class="help-block"><?php echo e($errors->first('default_country')); ?></span>
                        <?php endif; ?>
                    </div>

                    <!-- Default State -->
                    <div class="form-group <?php echo e($errors->has('default_state') ? 'has-error' : ''); ?>">
                        <label class="control-label">الدولة الافتراضية</label>
                        <select class="form-control" name="default_state" id="putStates" onchange="getCities(this.value)">
                        <?php $__currentLoopData = $states; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $state): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo e($state->id); ?>" <?php echo e($settings->default_state == $state->id ? 'selected' : ''); ?>><?php echo e($state->name); ?></option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                        <?php if($errors->has('default_state')): ?>
                        <span class="help-block"><?php echo e($errors->first('default_state')); ?></span>
                        <?php endif; ?>
                    </div>

                    <!-- Default City -->
                    <div class="form-group <?php echo e($errors->has('default_city') ? 'has-error' : ''); ?>">
                        <label class="control-label">المدينة الافتراضية</label>
                        <select class="form-control" id="putCities" name="default_city">
                        <?php $__currentLoopData = $cities; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $city): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo e($city->id); ?>" <?php echo e($settings->default_city == $city->id ? 'selected' : ''); ?>><?php echo e($city->name); ?></option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                        <?php if($errors->has('default_city')): ?>
                        <span class="help-block"><?php echo e($errors->first('default_city')); ?></span>
                        <?php endif; ?>
                    </div>

                    <!-- Enable States -->
                    <div class="form-group <?php echo e($errors->has('states_enabled') ? 'has-error' : ''); ?>">
                        <label class="control-label">تمكين الدول</label>
                        <select class="form-control" name="states_enabled">
                        <?php if($settings->states_enabled): ?>
                        <option value="1">تمكين</option>
                        <option value="0">تعطيل</option>
                        <?php else: ?>
                        <option value="0">تعطيل</option>
                        <option value="1">تمكين</option>
                        <?php endif; ?>
                    </select>
                        <?php if($errors->has('states_enabled')): ?>
                        <span class="help-block"><?php echo e($errors->first('states_enabled')); ?></span>
                        <?php endif; ?>
                    </div>

                    <!-- Enable Cities -->
                    <div class="form-group <?php echo e($errors->has('cities_enabled') ? 'has-error' : ''); ?>">
                        <label class="control-label">Enable Cities</label>
                        <select class="form-control" name="cities_enabled">
                        <?php if($settings->cities_enabled): ?>
                        <option value="1">تمكين</option>
                        <option value="0">تعطيل</option>
                        <?php else: ?>
                        <option value="0">تعطيل</option>
                        <option value="1">تمكين</option>
                        <?php endif; ?>
                    </select>
                        <?php if($errors->has('cities_enabled')): ?>
                        <span class="help-block"><?php echo e($errors->first('cities_enabled')); ?></span>
                        <?php endif; ?>
                    </div>

                    <!-- Default Currency -->
                    <div class="form-group <?php echo e($errors->has('default_currency') ? 'has-error' : ''); ?>">
                        <label class="control-label">Default Currency</label>
                        <select class="form-control" name="default_currency">
                            <?php $__currentLoopData = $currencies; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($key); ?>" <?php echo e($settings->default_currency == $key ? 'selected' : ''); ?>><?php echo e($value); ?></option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                        <?php if($errors->has('default_currency')): ?>
                        <span class="help-block"><?php echo e($errors->first('default_currency')); ?></span>
                        <?php endif; ?>
                    </div>

                    <!-- Default Locale -->
                    <div class="form-group <?php echo e($errors->has('default_locale') ? 'has-error' : ''); ?>">
                        <label class="control-label">اللغة الافتراضية</label>
                        <select class="form-control" name="default_locale">
                            <?php $__currentLoopData = $locales; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($key); ?>" <?php echo e($settings->default_locale == $key ? 'selected' : ''); ?>><?php echo e($value); ?></option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                        <?php if($errors->has('default_locale')): ?>
                        <span class="help-block"><?php echo e($errors->first('default_locale')); ?></span>
                        <?php endif; ?>
                    </div>

                    <!-- Trim Trailing Zeros -->
                    <div class="form-group <?php echo e($errors->has('trim_trailing_zeros') ? 'has-error' : ''); ?>">
                        <label class="control-label">Trim Trailing Zeros (1900.00$ to 1900$)</label>
                        <select class="form-control" name="trim_trailing_zeros">
                            <?php if(config('settings.trim_trailing_zeros')): ?>
                            <option value="1">تمكين</option>
                            <option value="0">تعطيل</option>
                            <?php else: ?>
                            <option value="0">تعطيل</option>
                            <option value="1">تمكين</option>
                            <?php endif; ?>
                        </select>
                        <?php if($errors->has('trim_trailing_zeros')): ?>
                        <span class="help-block"><?php echo e($errors->first('trim_trailing_zeros')); ?></span>
                        <?php endif; ?>
                    </div>

                    <hr>

                    <!-- Google maps api key -->
                    <div class="form-group <?php echo e($errors->has('google_maps_key') ? 'has-error' : ''); ?>">
                        <label class="control-label">Google maps api key (<a href="https://developers.google.com/maps/documentation/javascript/get-api-key" target="_blank">Get API Key</a>)</label>
                        <input class="form-control" name="google_maps_key" value="<?php echo e(config('google-maps.key')); ?>" placeholder="Your google maps api key">
                        <?php if($errors->has('google_maps_key')): ?>
                        <span class="help-block"><?php echo e($errors->first('google_maps_key')); ?></span>
                        <?php endif; ?>
                    </div>

                    <!-- Default Geo-location Address -->
                    <div class="form-group">
                        <label class="control-label">Default Geo-location Address</label>
                        <input class="form-control" placeholder="Enter default google maps address" id="geoLocation-address">
                    </div>

                    <!-- Geo Location Map -->
                    <div id="geoLocationMap" style="width: 100%; height: 450px;"></div>

                    <!-- Lat & Long -->
                    <div class="form-group">
                        <div class="col-lg-6">
                            <input type="hidden" class="form-control input-xlg" id="geoLocation-lat" name="latitude">
                        </div>

                        <div class="col-lg-6">
                            <input type="hidden" class="form-control input-xlg" id="geoLocation-lon" name="longitude">
                        </div>
                    </div>

                    <script>
                        $('#geoLocationMap').locationpicker({
                            location: {
                                latitude: '<?php echo e(config('settings.default_latitude')); ?>',
                                longitude: '<?php echo e(config('settings.default_longitude')); ?>'
                            },
                            radius: 300,
                            inputBinding: {
                                latitudeInput: $('#geoLocation-lat'),
                                longitudeInput: $('#geoLocation-lon'),
                                locationNameInput: $('#geoLocation-address')
                            },
                            enableAutocomplete: true
                        });
                    </script>

                    <!-- Save Changes -->
                    <div class="margin-top-10">
                        <button type="submit" class="btn default" style="width: 100%">حفظ التغييرات </button>
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