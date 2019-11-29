@extends ('dashboard.layout.app')

@section ('content')

<div class="row">
    
    <div class="col-md-12">
        
        <!-- Sessions Messages -->
        @if (Session::has('success'))
        <div class="custom-alerts alert alert-success fade in">
            {{ Session::get('success') }}
        </div>
        @endif

        @if (Session::has('error'))
        <div class="custom-alerts alert alert-danger fade in">
            {{ Session::get('error') }}
        </div>
        @endif

        <!-- Edit User -->
        <div class="portlet light ">

            <div class="portlet-title tabbable-line">
                <div class="caption caption-md">
                    <i class="icon-globe theme-font hide"></i>
                    <span class="caption-subject font-blue-madison bold uppercase">Edit "{{ $user->first_name }} {{ $user->last_name }}" Profile</span>
                </div>
            </div>

            <div class="portlet-body">

                <form method="POST" action="{{ Protocol::home() }}/dashboard/users/edit/{{ $user->username }}" enctype="multipart/form-data">
                    
                    {{ csrf_field() }}

                    <div class="row">

                        <!-- First Name -->
                        <div class="col-md-6">
                            <div class="form-group form-md-line-input {{ $errors->has('first_name') ? 'has-error' : '' }}">
                                <input type="text" class="form-control" id="first_name" placeholder="Enter first name" value="{{ $user->first_name }}" name="first_name">
                                <label for="first_name">الاسم الاول</label>
                                @if ($errors->has('first_name'))
                                <span class="help-block">{{ $errors->first('first_name') }}</span>
                                @endif
                            </div>
                        </div>

                        <!-- Last Name -->
                        <div class="col-md-6">
                            <div class="form-group form-md-line-input {{ $errors->has('last_name') ? 'has-error' : '' }}">
                                <input type="text" class="form-control" id="last_name" placeholder="Enter last name" value="{{ $user->last_name }}" name="last_name">
                                <label for="last_name">الاسم الاخير</label>
                                @if ($errors->has('last_name'))
                                <span class="help-block">{{ $errors->first('last_name') }}</span>
                                @endif
                            </div>
                        </div>
    
                        <!-- Username -->
                        <div class="col-md-6">
                            <div class="form-group form-md-line-input {{ $errors->has('username') ? 'has-error' : '' }}">
                                <input type="text" class="form-control" id="username" placeholder="Enter username" value="{{ $user->username }}" name="username">
                                <label for="username">اسم المستخدم</label>
                                @if ($errors->has('username'))
                                <span class="help-block">{{ $errors->first('username') }}</span>
                                @endif
                            </div>
                        </div>

                        <!-- E-mail Address -->
                        <div class="col-md-6">
                            <div class="form-group form-md-line-input {{ $errors->has('email') ? 'has-error' : '' }}">
                                <input type="text" class="form-control" id="email" placeholder="Enter e-mail Address" value="{{ $user->email }}" name="email">
                                <label for="email">عنوان بريد الكتروني</label>
                                @if ($errors->has('email'))
                                <span class="help-block">{{ $errors->first('email') }}</span>
                                @endif
                            </div>
                        </div>

                        <!-- User Country -->
                        <div class="col-md-6">
                            <div class="form-group form-md-line-input {{ $errors->has('country') ? 'has-error' : '' }}">
                                 <select class="form-control" id="country" name="country" onchange="getStates(this.value)">
                                    @foreach ($countries as $country)
                                    <option value="{{ $country->sortname }}" {{ $country->sortname == $user->country_code ? 'selected' : '' }}>{{ $country->name }}</option>
                                    @endforeach
                                </select>
                                <label for="country">بلد</label>
                                @if ($errors->has('country'))
                                <span class="help-block">{{ $errors->first('country') }}</span>
                                @endif
                            </div>
                        </div>

                        <!-- User State -->
                        <div class="col-md-6">
                            <div class="form-group form-md-line-input {{ $errors->has('state') ? 'has-error' : '' }}">
                                 <select class="form-control" id="putStates" name="state" onchange="getCities(this.value)">
                                    @foreach ($states as $state)
                                    <option value="{{ $state->id }}" {{ $state->id == $user->state ? 'selected' : '' }}>{{ $state->name }}</option>
                                    @endforeach
                                </select>
                                <label for="putStates">دولة</label>
                                @if ($errors->has('state'))
                                <span class="help-block">{{ $errors->first('state') }}</span>
                                @endif
                            </div>
                        </div>

                        <!-- User City -->
                        <div class="col-md-6">
                            <div class="form-group form-md-line-input {{ $errors->has('city') ? 'has-error' : '' }}">
                                 <select class="form-control" id="putCities" name="city">
                                    @foreach ($cities as $city)
                                    <option value="{{ $city->id }}" {{ $city->id == $user->city ? 'selected' : '' }}>{{ $city->name }}</option>
                                    @endforeach
                                </select>
                                <label for="putCities">City</label>
                                @if ($errors->has('city'))
                                <span class="help-block">{{ $errors->first('city') }}</span>
                                @endif
                            </div>
                        </div>

                        <!-- Phone Number -->
                        <div class="col-md-6">

                            <div class="row">
                                
                                <!-- Phone Code -->
                                <div class="col-md-3">
                                    <div class="form-group form-md-line-input {{ $errors->has('phonecode') ? 'has-error' : '' }}">
                                        <input type="text" class="form-control" id="putPhoneCode" value="{{ $default_country->phonecode }}" name="phonecode">
                                        <label for="putPhoneCode">كود</label>
                                        @if ($errors->has('phonecode'))
                                        <span class="help-block">{{ $errors->first('phonecode') }}</span>
                                        @endif
                                    </div>
                                </div>

                                <!-- Phone Number -->
                                <div class="col-md-9">
                                    <div class="form-group form-md-line-input {{ $errors->has('phone') ? 'has-error' : '' }}">
                                        <input type="text" class="form-control" id="phone" placeholder="Enter phone number" value="{{ $user->phone }}" name="phone">
                                        <label for="phone">رقم الهاتف</label>
                                        @if ($errors->has('phone'))
                                        <span class="help-block">{{ $errors->first('phone') }}</span>
                                        @endif
                                    </div>
                                </div>
                            

                            </div>

                        </div>

                        <!-- Hide Phone Number -->
                        <div class="col-md-6">
                            <div class="form-group form-md-line-input {{ $errors->has('phone_hidden') ? 'has-error' : '' }}">
                                 <select class="form-control" id="phone_hidden" name="phone_hidden">
                                    @if ($user->phone_hidden)
                                    <option value="1">مخفي</option>
                                    <option value="0">مرئي</option>
                                    @else 
                                    <option value="0">مرئي</option>
                                    <option value="1">مخفي</option>
                                    @endif
                                </select>
                                <label for="phone_hidden">إخفاء رقم الهاتف</label>
                                @if ($errors->has('phone_hidden'))
                                <span class="help-block">{{ $errors->first('phone_hidden') }}</span>
                                @endif
                            </div>
                        </div>

                        <!-- Gender -->
                        <div class="col-md-6">
                            <div class="form-group form-md-line-input {{ $errors->has('gender') ? 'has-error' : '' }}">
                                 <select class="form-control" id="gender" name="gender">
                                    @if ($user->gender)
                                    <option value="1">ولد</option>
                                    <option value="0">بنت</option>
                                    @else 
                                    <option value="0">بنت</option>
                                    <option value="1">ولد</option>
                                    @endif
                                </select>
                                <label for="gender">النوع</label>
                                @if ($errors->has('gender'))
                                <span class="help-block">{{ $errors->first('gender') }}</span>
                                @endif
                            </div>
                        </div>

                        <!-- Is Administrator -->
                        <div class="col-md-6">
                            <div class="form-group form-md-line-input {{ $errors->has('is_admin') ? 'has-error' : '' }}">
                                 <select class="form-control" id="is_admin" name="is_admin">
                                    @if ($user->is_admin)
                                    <option value="1">نعم</option>
                                    <option value="0">لا</option>
                                    @else
                                    <option value="0">لا</option>
                                    <option value="1">نعم</option>
                                    @endif
                                </select>
                                <label for="is_admin">Is Administrator</label>
                                @if ($errors->has('is_admin'))
                                <span class="help-block">{{ $errors->first('is_admin') }}</span>
                                @endif
                            </div>
                        </div>

                        <!-- Account Type -->
                        <div class="col-md-6">
                            <div class="form-group form-md-line-input {{ $errors->has('account_type') ? 'has-error' : '' }}">
                                 <select class="form-control" id="account_type" name="account_type">
                                    @if ($user->account_type)
                                    <option value="1">المحترفين</option>
                                    <option value="0">اساسي</option>
                                    @else
                                    <option value="0">اساسي</option>
                                    <option value="1">المحترفين</option>
                                    @endif
                                </select>
                                <label for="account_type">نوع الحساب</label>
                                @if ($errors->has('account_type'))
                                <span class="help-block">{{ $errors->first('account_type') }}</span>
                                @endif
                            </div>
                        </div>

                        <!-- Status -->
                        <div class="col-md-6">
                            <div class="form-group form-md-line-input {{ $errors->has('status') ? 'has-error' : '' }}">
                                 <select class="form-control" id="status" name="status">
                                    @if ($user->status)
                                    <option value="1">نشيط</option>
                                    <option value="0">غير نشط</option>
                                    @else
                                    <option value="0">غير نشط</option>
                                    <option value="1">نشيط</option>
                                    @endif
                                </select>
                                <label for="status">الحالة</label>
                                @if ($errors->has('status'))
                                <span class="help-block">{{ $errors->first('status') }}</span>
                                @endif
                            </div>
                        </div>
                            
                        <div class="col-md-6">
                            <!-- Change Avatar -->
                            <div class="form-group form-md-line-input {{ $errors->has('avatar') ? 'has-error' : '' }}">
                                <input type="file" name="avatar" class="form-control" id="avatar">
                                <label for="avatar">تحرير الصورة الرمزية</label>
                                @if ($errors->has('avatar'))
                                <span class="help-block">{{ $errors->first('avatar') }}</span>
                                @endif
                            </div>
                        </div>


                        <hr>

                        <!-- Update Password -->
                        <div class="col-md-6">
                            <div class="form-group form-md-line-input {{ $errors->has('password') ? 'has-error' : '' }}">
                                <input type="password" class="form-control" id="password" placeholder="Enter Password" name="password">
                                <label for="password">كلمة السر الجديدة</label>
                                @if ($errors->has('password'))
                                <span class="help-block">{{ $errors->first('password') }}</span>
                                @endif
                            </div>
                        </div>

                        <!-- Confirm Password -->
                        <div class="col-md-6">
                            <div class="form-group form-md-line-input {{ $errors->has('password_confirmation') ? 'has-error' : '' }}">
                                <input type="password" class="form-control" id="password_confirmation" placeholder="Confirm Password" name="password_confirmation">
                                <label for="password_confirmation">تأكيد كلمة المرور</label>
                                @if ($errors->has('password_confirmation'))
                                <span class="help-block">{{ $errors->first('password_confirmation') }}</span>
                                @endif
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

@endsection