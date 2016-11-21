@extends('adminTemplate')
@section('main-content')
    @if(Session::get('create_doc_error') == 1)
        <div id="error-popup" class="admin-popup-position-dont-hide" style="z-index: 2">
            <div id="admin-error-popup-wrapper">
                <div id="admin-error-popup-container" align="center">
                    <div style="font-size: 18px; float: right; position: relative; left: 10px">
                        <a href="#" onclick="toggle_visibility('error-popup');" style="text-decoration: none">
                            <i class="fa fa-times-circle"></i>
                        </a>
                    </div>
                    <p style="font-size: 120px; color: #f4d442"><i class="fa fa-info-circle"></i></p>
                    <h4 style="position: relative; bottom: 26px"> กรุณากรอกข้อมูลให้ครบถ้วน </h4>
                </div>
            </div>
        </div>
    @endif
    @if(Session::get('create_doc_error') == 2)
        <div id="error-popup" class="admin-popup-position-dont-hide" style="z-index: 2">
            <div id="admin-error-popup-wrapper">
                <div id="admin-error-popup-container" align="center">
                    <div style="font-size: 18px; float: right; position: relative; left: 10px">
                        <a href="#" onclick="toggle_visibility('error-popup');" style="text-decoration: none">
                            <i class="fa fa-times-circle"></i>
                        </a>
                    </div>
                    <p style="font-size: 120px; color: #ed5565"><i class="fa fa-exclamation-circle"></i></p>
                    <h4 style="position: relative; bottom: 26px"> บัญชีนี้มีอยู่ในระบบอยู่แล้ว </h4>
                </div>
            </div>
        </div>
    @endif
    @if(Session::get('create_doc_error') == 3)
        <div id="error-popup" class="admin-popup-position-dont-hide" style="z-index: 2">
            <div id="admin-error-popup-wrapper">
                <div id="admin-error-popup-container" align="center">
                    <div style="font-size: 18px; float: right; position: relative; left: 10px">
                        <a href="#" onclick="toggle_visibility('error-popup');" style="text-decoration: none">
                            <i class="fa fa-times-circle"></i>
                        </a>
                    </div>
                    <p style="font-size: 120px; color: #f4d442"><i class="fa fa-info-circle"></i></p>
                    <h4 style="position: relative; bottom: 26px"> กรุณากรอกวันเกิดให้ถูกต้อง </h4>
                </div>
            </div>
        </div>
    @endif
    @if(Session::get('create_doc_error') == 4)
        <div id="error-popup" class="admin-popup-position-dont-hide" style="z-index: 2">
            <div id="admin-error-popup-wrapper">
                <div id="admin-error-popup-container" align="center">
                    <div style="font-size: 18px; float: right; position: relative; left: 10px">
                        <a href="#" onclick="toggle_visibility('error-popup');" style="text-decoration: none">
                            <i class="fa fa-times-circle"></i>
                        </a>
                    </div>
                    <p style="font-size: 120px; color: #f4d442"><i class="fa fa-info-circle"></i></p>
                    <h4 style="position: relative; bottom: 26px"> กรุณากรอกเบอร์โทรศัพท์มือถือให้ถูกต้อง </h4>
                </div>
            </div>
        </div>
    @endif
    @if(Session::get('create_doc_error') == 5)
        <div id="error-popup" class="admin-popup-position-dont-hide" style="z-index: 2">
            <div id="admin-error-popup-wrapper">
                <div id="admin-error-popup-container" align="center">
                    <div style="font-size: 18px; float: right; position: relative; left: 10px">
                        <a href="#" onclick="toggle_visibility('error-popup');" style="text-decoration: none">
                            <i class="fa fa-times-circle"></i>
                        </a>
                    </div>
                    <p style="font-size: 120px; color: #f4d442"><i class="fa fa-info-circle"></i></p>
                    <h4 style="position: relative; bottom: 26px"> กรุณากรอกเลขประจำตัวประชาชนให้ถูกต้อง </h4>
                </div>
            </div>
        </div>
    @endif
    @if(Session::get('create_doc_error') == 6)
        <div id="error-popup" class="admin-popup-position-dont-hide" style="z-index: 2">
            <div id="admin-error-popup-wrapper">
                <div id="admin-error-popup-container" align="center">
                    <div style="font-size: 18px; float: right; position: relative; left: 10px">
                        <a href="#" onclick="toggle_visibility('error-popup');" style="text-decoration: none">
                            <i class="fa fa-times-circle"></i>
                        </a>
                    </div>
                    <p style="font-size: 120px; color: #f4d442"><i class="fa fa-info-circle"></i></p>
                    <h4 style="position: relative; bottom: 26px"> กรุณากรอกอีเมลให้ถูกต้อง </h4>
                </div>
            </div>
        </div>
    @endif
    <!--create-account-form-panel is new-->
    <div class="paddingFormCreate">
        <div class="create-account-form-panel">
            <h4 class="ml mb"><i class="fa fa-angle-right"></i> สร้างบัญชีผู้ใช้: แพทย์</h4>
            <form class="form-horizontal style-form" method="post">
                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                <div class="row form-group">
                    <div class="col-xs-5 col-lg-5" align="left" style="padding-left: 5px">
                        <label class="col-xs-2 col-lg-2 control-label">ชื่อ</label>
                        <div class="col-sm-9">
                            @if(Session::has('old_value'))
                                <input type="text" class="form-control" name="firstname"
                                       value="{{Session::get('old_value')['firstname']}}">
                            @else
                                <input type="text" class="form-control" name="firstname">
                            @endif
                        </div>
                    </div>
                    <div class="col-xs-7 col-lg-7" align="left">
                        <label class="col-xs-2 col-lg-2 control-label">นามสกุล</label>
                        <div class="col-sm-10">
                            @if(Session::has('old_value'))
                                <input type="text" class="form-control" name="lastname"
                                       value="{{Session::get('old_value')['lastname']}}">
                            @else
                                <input type="text" class="form-control" name="lastname">
                            @endif
                        </div>
                    </div>
                </div>

                <div class="row form-group">
                    <div class="col-xs-12 col-lg-12" align="left" style="padding-left: 5px">
                        <label class="col-xs-2 col-lg-2 control-label">เลขประจำตัวประชาชน</label>
                        <div class="col-sm-10">
                            @if(Session::has('old_value'))
                                <input type="text" class="form-control" name="ssn"
                                       value="{{Session::get('old_value')['ssn']}}">
                            @else
                                <input type="text" class="form-control" name="ssn">
                            @endif
                        </div>
                    </div>
                </div>
                <div class="row form-group">
                    <div class="col-xs-12 col-lg-12" align="left" style="padding-left: 5px">
                        <label class="col-xs-2 col-lg-2 control-label">เลขประจำตัวแพทย์</label>
                        <div class="col-sm-10">
                            @if(Session::has('old_value'))
                                <input type="text" class="form-control" name="doctorNumber"
                                       value="{{Session::get('old_value')['doctorNumber']}}">
                            @else
                                <input type="text" class="form-control" name="doctorNumber">
                            @endif


                        </div>
                    </div>
                </div>
                <div class="row form-group">
                    <div class="col-xs-12 col-lg-12" align="left" style="padding-left: 5px">
                        <label class="col-xs-2 col-lg-2 control-label">แผนก</label>
                        <div class="col-sm-10">
                            <select id="dep_list" name='department'
                                    style="width: 100%; border-radius: 5px; height: 35px; border-color: #cccccc">
                                @foreach($available_deps as $available_dep)
                                    <option value="{{ $available_dep['departmentName'] }}">{{ $available_dep['departmentName'] }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
                <div class="row form-group">
                    <div class="col-xs-12 col-lg-12" align="left" style="padding-left: 5px">
                        <label class="col-xs-2 col-lg-2 control-label">เพศ</label>
                        <div class="col-xs-10 col-lg-10">
                            @if(Session::has('old_value'))
                                @if(Session::get('old_value')['gender'] == 'ชาย')
                                    <input type="radio" name="gender" value="ชาย" checked
                                           style="margin-top: 8px; margin-right: 3px"> ชาย </input>
                                    <input type="radio" name="gender" value="หญิง"
                                           style="margin-top: 8px; margin-right: 3px; margin-left: 40px"> หญิง </input>
                                @elseif(Session::get('old_value')['gender'] == 'หญิง')
                                    <input type="radio" name="gender" value="ชาย"
                                           style="margin-top: 8px; margin-right: 3px">
                                    ชาย </input>
                                    <input type="radio" name="gender" value="หญิง" checked
                                           style="margin-top: 8px; margin-right: 3px; margin-left: 40px"> หญิง </input>
                                @else
                                    <input type="radio" name="gender" value="ชาย"
                                           style="margin-top: 8px; margin-right: 3px">
                                    ชาย </input>
                                    <input type="radio" name="gender" value="หญิง"
                                           style="margin-top: 8px; margin-right: 3px; margin-left: 40px"> หญิง </input>
                                @endif
                            @else
                                <input type="radio" name="gender" value="ชาย"
                                       style="margin-top: 8px; margin-right: 3px">
                                ชาย </input>
                                <input type="radio" name="gender" value="หญิง"
                                       style="margin-top: 8px; margin-right: 3px; margin-left: 40px"> หญิง </input>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="row form-group">
                    <div class="col-xs-12 col-lg-12" align="left" style="padding-left: 5px">
                        <label class="col-xs-2 col-lg-2 control-label">วันเกิด</label>
                        <div class="col-sm-10">
                            @if(Session::has('old_value'))
                                <input type="text" class="form-control input-group date" id="datepicker1"
                                       name="birthDate"
                                       placeholder="MM/DD/YYYY (ปี ค.ศ.)"
                                       value="{{Session::get('old_value')['birthDate']}}">
                            @else
                                <input type="text" class="form-control input-group date" id="datepicker1"
                                       name="birthDate"
                                       placeholder="MM/DD/YYYY (ปี ค.ศ.)">
                            @endif
                        </div>
                    </div>
                </div>
                <div class="row form-group">
                    <div class="col-xs-5 col-lg-5" align="left" style="padding-left: 5px">
                        <label class="col-xs-2 col-lg-2 control-label">อีเมล</label>
                        <div class="col-sm-9">
                            @if(Session::has('old_value'))
                                <input type="text" class="form-control" name="email"
                                       value="{{Session::get('old_value')['email']}}">
                            @else
                                <input type="text" class="form-control" name="email">
                            @endif
                        </div>
                    </div>
                    <div class="col-xs-7 col-lg-7" align="left">
                        <label class="col-xs-3 col-lg-3 control-label">เบอร์โทรศัพท์มือถือ</label>
                        <div class="col-sm-9">
                            @if(Session::has('old_value'))
                                <input type="text" class="form-control" name="phoneNumber" placeholder="08XXXXXXXX"
                                       value="{{Session::get('old_value')['phoneNumber']}}">
                            @else
                                <input type="text" class="form-control" name="phoneNumber" placeholder="08XXXXXXXX">
                            @endif
                        </div>
                    </div>
                </div>
                <div class="row form-group">
                    <div class="col-xs-12 col-lg-12" align="left" style="padding-left: 5px">
                        <label class="col-xs-2 col-lg-2 control-label">ที่อยู่</label>
                        <div class="col-sm-10">
                            @if(Session::has('old_value'))
                                <input type="text" class="form-control" name="address"
                                       value="{{Session::get('old_value')['address']}}">
                            @else
                                <input type="text" class="form-control" name="address">
                            @endif
                        </div>
                    </div>
                </div>
                <div class="row form-group">
                    <div class="col-xs-12 col-lg-12" align="left" style="padding-left: 5px">
                        <p class="col-xs-2 col-lg-2 control-label">ตารางการออกตรวจ</label>
                        <div class="col-xs-10 col-lg-10">
                            <div class="row">
                                <div class="col-xs-12 col-lg-12">
                                    <label class="col-xs-2 col-lg-2 control-label">วันจันทร์</label>
                                    <input type="checkbox" name="mon_mor" value="1"
                                           style="margin-top: 8px; margin-right: 3px">
                                    9:00-11:30 น. </input>
                                    <input type="checkbox" name="mon_af" value="2"
                                           style="margin-top: 8px; margin-right: 3px; margin-left: 40px"> 13:00-15:30
                                    น. </input>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-xs-12 col-lg-12">
                                    <label class="col-xs-2 col-lg-2 control-label">วันอังคาร</label>
                                    <input type="checkbox" name="tue_mor" value="1"
                                           style="margin-top: 8px; margin-right: 3px">
                                    9:00-11:30 น. </input>
                                    <input type="checkbox" name="tue_af" value="2"
                                           style="margin-top: 8px; margin-right: 3px; margin-left: 40px"> 13:00-15:30
                                    น. </input>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-xs-12 col-lg-12">
                                    <label class="col-xs-2 col-lg-2 control-label">วันพุธ</label>
                                    <input type="checkbox" name="wed_mor" value="1"
                                           style="margin-top: 8px; margin-right: 3px">
                                    9:00-11:30 น. </input>
                                    <input type="checkbox" name="wed_af" value="2"
                                           style="margin-top: 8px; margin-right: 3px; margin-left: 40px"> 13:00-15:30
                                    น. </input>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-xs-12 col-lg-12">
                                    <label class="col-xs-2 col-lg-2 control-label">วันพฤหัสบดี</label>
                                    <input type="checkbox" name="thu_mor" value="1"
                                           style="margin-top: 8px; margin-right: 3px">
                                    9:00-11:30 น. </input>
                                    <input type="checkbox" name="thu_af" value="2"
                                           style="margin-top: 8px; margin-right: 3px; margin-left: 40px"> 13:00-15:30
                                    น. </input>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-xs-12 col-lg-12">
                                    <label class="col-xs-2 col-lg-2 control-label">วันศุกร์</label>
                                    <input type="checkbox" name="fri_mor" value="1"
                                           style="margin-top: 8px; margin-right: 3px">
                                    9:00-11:30 น. </input>
                                    <input type="checkbox" name="fri_af" value="2"
                                           style="margin-top: 8px; margin-right: 3px; margin-left: 40px"> 13:00-15:30
                                    น. </input>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-xs-12 col-lg-12">
                                    <label class="col-xs-2 col-lg-2 control-label">วันเสาร์</label>
                                    <input type="checkbox" name="sat_mor" value="1"
                                           style="margin-top: 8px; margin-right: 3px">
                                    9:00-11:30 น. </input>
                                    <input type="checkbox" name="sat_af" value="2"
                                           style="margin-top: 8px; margin-right: 3px; margin-left: 40px"> 13:00-15:30
                                    น. </input>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-xs-12 col-lg-12">
                                    <label class="col-xs-2 col-lg-2 control-label">วันอาทิตย์</label>
                                    <input type="checkbox" name="sun_mor" value="1"
                                           style="margin-top: 8px; margin-right: 3px">
                                    9:00-11:30 น. </input>
                                    <input type="checkbox" name="sun_af" value="2"
                                           style="margin-top: 8px; margin-right: 3px; margin-left: 40px"> 13:00-15:30
                                    น. </input>
                                </div>
                            </div>
                        </div>
                    </div>


                </div>
                <div class="row form-group">
                    <div class="col-xs-12 col-lg-12" align="center">
                        <button type="submit" class="btn btn-theme04 btn-lg">สร้างบัญชี</button>
                    </div>
                </div>
            </form>
        </div>
    </div>





@stop
