@extends('adminTemplate')
@section('main-content')
    @if(Session::has('account_owner') and Session::has('generated_username') and Session::has('generated_password'))
        <div id="inform_user_popup" class="admin-popup-position-dont-hide" style="z-index: 2">
            <div id="admin-popup-wrapper">
                <div id="admin-popup-container">
                    <div style="font-size: 18px; float: right; position: relative; left: 10px">
                        <a href="#" onclick="toggle_visibility('inform_user_popup');" style="text-decoration: none">
                            <i class="fa fa-times-circle"></i>
                        </a>
                    </div>
                    <h3 style="margin-top: 18px; margin-bottom: 15px; padding-bottom: 12px; border-bottom: 1px solid #e3e6ea; text-align: center">
                        สร้างบัญชีสำเร็จ</h3>
                    <p style="font-size: 16px"> เจ้าของบัญชี: {{Session::get('account_owner')}} </p>
                    <p style="font-size: 16px"> ชื่อผู้ใช้: {{Session::get('generated_username')}}</p>
                    <p style="font-size: 16px; margin-bottom: 15px">
                        รหัสผ่าน: {{Session::get('generated_password')}}</p>
                    <p style="color: red; text-align: center"> คำเตือน: กรุณาจดจำรหัสผ่านก่อนปิดหน้าต่างนี้ </p>
                </div>
            </div>
<<<<<<< HEAD
        </div>
    @endif
    @if(Session::get('delete_doc_error') == 1)
        <div id="error-popup" class="admin-popup-position-dont-hide" style="z-index: 2">
            <div id="admin-error-popup-wrapper">
                <div id="admin-error-popup-container" align="center">
                    <div style="font-size: 18px; float: right; position: relative; left: 10px">
                        <a href="#" onclick="toggle_visibility('error-popup');" style="text-decoration: none">
                            <i class="fa fa-times-circle"></i>
                        </a>
                    </div>
                    <p style="font-size: 120px; color: #ed5565"><i class="fa fa-exclamation-circle"></i></p>
                    <h4 style="position: relative; bottom: 26px"> แพทย์ยังมีการนัดหมายในวันนี้อยู่ <br>
                        ไม่สามารถลบบัญชีได้ </h4>
                </div>
            </div>
=======
>>>>>>> f2d65c9b791b70eba4e564cff4ef77a1ab8b3909
        </div>
    @endif

    <div class="row">
        <!--start of  search form-->
        <div class="col-xs-12 col-lg-12">
            <h4 style="margin-top: -3px;margin-bottom: 15px; margin-left: 10px" align="left"><i
                        class="fa fa-angle-right"></i> ค้นหา </h4>
        </div>
    </div>
    <!--mt2 is new-->
    <!--search-form-panel is new-->
    <!--hide is new-->
    <div class="search-form-panel">
        <form action="/manageAccount" method="get">

            <div class="row">
                <div class="search-form-group">
                    <!--Name-->
<<<<<<< HEAD
                    <label class="col-xs-2 col-lg-2 control-label mt2">ชื่อ-นามสกุล</label>
                    <div class="col-xs-3 col-lg-3">
=======
                    <label class="col-xs-1 col-lg-1 control-label mt2">ชื่อ-นามสกุล</label>
                    <div class="col-xs-4 col-lg-4">
>>>>>>> f2d65c9b791b70eba4e564cff4ef77a1ab8b3909
                        <input type="text" class="form-control" name='name' placeholder="{{$name}}"
                               onfocus="this.placeholder = ''">
                    </div>
                    <!--Department-->
<<<<<<< HEAD
                    <label class="col-xs-offset-2 col-lg-offset-1 col-xs-2 col-lg-2 control-label mt2">แผนก</label>
                    <div class="col-xs-3 col-lg-3">
=======
                    <label class="col-xs-offset-1 col-lg-offset-1 col-xs-1 col-lg-1 control-label mt2">แผนก</label>
                    <div class="col-xs-4 col-lg-4">
>>>>>>> f2d65c9b791b70eba4e564cff4ef77a1ab8b3909
                        <input type="text" class="form-control" name='department' placeholder="{{$dep}}"
                               onfocus="this.placeholder = ''">
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="search-form-group">
                    <!--HN/ID-->
                    <label class="col-xs-2 col-lg-2 control-label mt2">เลขประจำตัวผู้ป่วย / บุคลากร</label>
                    <div class="col-xs-3 col-lg-3">
                        <input type="text" class="form-control" name='id' placeholder="{{$id}}"
                               onfocus="this.placeholder = ''">
                    </div>
                    <!--SSN-->
                    <label class="col-xs-offset-1 col-lg-offset-1 col-xs-2 col-lg-2 control-label mt2">เลขประจำตัวประชาชน</label>
                    <div class="col-xs-3 col-lg-3">
                        <input type="text" class="form-control" name='ssn' placeholder="{{$ssn}}"
                               onfocus="this.placeholder = ''">
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="search-form-group">
                    <!--Account Type-->
                    <label class="col-xs-2 col-lg-2 control-label mt2">ประเภทบัญชี</label>
                    <div class="col-xs-10 col-lg-10">
                        @if ($wanted_userType[0] != '')
<<<<<<< HEAD
                            <input type="checkbox" name="userType_Pa" value="patient" checked
                                   style="margin-top: 9px; margin-right: 3px"> ผู้ป่วย </input>
                        @else
                            <input type="checkbox" name="userType_Pa" value="patient"
                                   style="margin-top: 9px; margin-right: 3px"> ผู้ป่วย </input>
                        @endif
                        @if ($wanted_userType[1] != '')
                            <input type="checkbox" name="userType_S" value="staff" checked
                                   style="margin-top: 9px; margin-right: 3px; margin-left: 40px"> เจ้าหน้าที่ </input>
                        @else
                            <input type="checkbox" name="userType_S" value="staff"
                                   style="margin-top: 9px; margin-right: 3px; margin-left: 40px"> เจ้าหน้าที่ </input>
                        @endif
                        @if ($wanted_userType[2] != '')
                            <input type="checkbox" name="userType_D" value="doctor" checked
                                   style="margin-top: 9px; margin-right: 3px; margin-left: 40px"> แพทย์ </input>
                        @else
                            <input type="checkbox" name="userType_D" value="doctor"
                                   style="margin-top: 9px; margin-right: 3px; margin-left: 40px"> แพทย์ </input>
                        @endif
                        @if ($wanted_userType[3] != '')
                            <input type="checkbox" name="userType_N" value="nurse" checked
                                   style="margin-top: 9px; margin-right: 3px; margin-left: 40px"> พยาบาล </input>
                        @else
                            <input type="checkbox" name="userType_N" value="nurse"
                                   style="margin-top: 9px; margin-right: 3px; margin-left: 40px"> พยาบาล </input>
                        @endif
                        @if ($wanted_userType[4] != '')
                            <input type="checkbox" name="userType_Ph" value="pharmacist" checked
                                   style="margin-top: 9px; margin-right: 3px; margin-left: 40px"> เภสัชกร </input>
                        @else
                            <input type="checkbox" name="userType_Ph" value="pharmacist"
                                   style="margin-top: 9px; margin-right: 3px; margin-left: 40px"> เภสัชกร </input>
                        @endif
                        @if ($wanted_userType[5] != '')
                            <input type="checkbox" name="userType_A" value="admin" checked
                                   style="margin-top: 9px; margin-right: 3px; margin-left: 40px"> ผู้คุมระบบ </input>
                        @else
                            <input type="checkbox" name="userType_A" value="admin"
=======
                            <input type="checkbox" name="userType_Pa" value="ผู้ป่วย" checked
                                   style="margin-top: 9px; margin-right: 3px"> ผู้ป่วย </input>
                        @else
                            <input type="checkbox" name="userType_Pa" value="ผู้ป่วย"
                                   style="margin-top: 9px; margin-right: 3px"> ผู้ป่วย </input>
                        @endif
                        @if ($wanted_userType[1] != '')
                            <input type="checkbox" name="userType_S" value="เจ้าหน้าที่" checked
                                   style="margin-top: 9px; margin-right: 3px; margin-left: 40px"> เจ้าหน้าที่ </input>
                        @else
                            <input type="checkbox" name="userType_S" value="เจ้าหน้าที่"
                                   style="margin-top: 9px; margin-right: 3px; margin-left: 40px"> เจ้าหน้าที่ </input>
                        @endif
                        @if ($wanted_userType[2] != '')
                            <input type="checkbox" name="userType_D" value="แพทย์" checked
                                   style="margin-top: 9px; margin-right: 3px; margin-left: 40px"> แพทย์ </input>
                        @else
                            <input type="checkbox" name="userType_D" value="แพทย์"
                                   style="margin-top: 9px; margin-right: 3px; margin-left: 40px"> แพทย์ </input>
                        @endif
                        @if ($wanted_userType[3] != '')
                            <input type="checkbox" name="userType_N" value="พยาบาล" checked
                                   style="margin-top: 9px; margin-right: 3px; margin-left: 40px"> พยาบาล </input>
                        @else
                            <input type="checkbox" name="userType_N" value="พยาบาล"
                                   style="margin-top: 9px; margin-right: 3px; margin-left: 40px"> พยาบาล </input>
                        @endif
                        @if ($wanted_userType[4] != '')
                            <input type="checkbox" name="userType_Ph" value="เภสัชกร" checked
                                   style="margin-top: 9px; margin-right: 3px; margin-left: 40px"> เภสัชกร </input>
                        @else
                            <input type="checkbox" name="userType_Ph" value="เภสัชกร"
                                   style="margin-top: 9px; margin-right: 3px; margin-left: 40px"> เภสัชกร </input>
                        @endif
                        @if ($wanted_userType[5] != '')
                            <input type="checkbox" name="userType_A" value="ผู้คุมระบบ" checked
                                   style="margin-top: 9px; margin-right: 3px; margin-left: 40px"> ผู้คุมระบบ </input>
                        @else
                            <input type="checkbox" name="userType_A" value="ผู้คุมระบบ"
>>>>>>> f2d65c9b791b70eba4e564cff4ef77a1ab8b3909
                                   style="margin-top: 9px; margin-right: 3px; margin-left: 40px"> ผู้คุมระบบ </input>
                        @endif
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-lg-12" align="center" style="padding-top: 10px">
                    <button type="submit" class="btn btn-theme04 btn-lg">ค้นหา</button>
                </div>
            </div>

        </form>
    </div>
    <!--end of search form-->

    <div class="row">
        <!--start account list-->
        <div class="account-list-area account-list-search-active">
            <div>
                <p class="account-list-header col-xs-1 col-lg-1">ลำดับ</p>
                <p class="account-list-header col-xs-2 col-lg-2">เลขที่บัญชี</p>
                <p class="account-list-header col-xs-3 col-lg-3">ชื่อ-นามสกุล</p>
                <p class="account-list-header col-xs-3 col-lg-3">ชื่อผู้ใช้</p>
                <p class="account-list-header col-xs-1 col-lg-1">ประเภท</p>
                <p class="account-list-header last-column col-xs-2 col-lg-2">การดำเนินการ</p>
            </div>
            <div class="account-list-panel">

<<<<<<< HEAD

            {{--@foreach($users as $user)--}}
            {{--@if($user->userType == 'admin')--}}
            {{--{{dd($user->patient->hn)}}--}}
            {{--@endif--}}
            {{--@endforeach--}}


            {{--@if($users == '')--}}
            {{--DoNothing--}}
            {{--@else--}}
            @foreach($users as $user)
                <!--edit popup-->
                    @if ($user->userType != 'patient' and $user->userType != 'admin')
=======
            @foreach($users as $user)
                <!--edit popup-->
                    @if ($user->userType != 'ผู้ป่วย' and $user->userType != 'ผู้คุมระบบ')
>>>>>>> f2d65c9b791b70eba4e564cff4ef77a1ab8b3909
                        <div id="edit_right_popup{{$user->index}}" class="admin-popup-position" style="z-index: 2">
                            <div id="admin-popup-wrapper">
                                <div id="admin-popup-container">
                                    <h4 style="margin-top: 18px; padding-bottom: 12px; border-bottom: 1px solid #e3e6ea; text-align: center">
                                        แก้ไขสิทธิ์: {{$user->firstname}} {{$user->lastname}}</h4>
                                    <form action="/manageAccount" method="post">
                                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                        <input type="hidden" name="username" value="{{ $user->username }}">
                                        <input type="hidden" name="operation" value="change_right">
<<<<<<< HEAD
                                        @if ($user->userType == 'doctor' or $user->userType == 'nurse')
                                            <div style="padding-left: 14px; margin-bottom: 8px; margin-top: 14px">
                                                <label style="margin-right: 8px"> แผนก </label>
                                                <!--must test if not change dept-->
                                                @if ($user->userType == 'doctor')
=======
                                        @if ($user->userType == 'แพทย์' or $user->userType == 'พยาบาล')
                                            <div style="padding-left: 14px; margin-bottom: 8px; margin-top: 14px">
                                                <label style="margin-right: 8px"> แผนก </label>
                                                <!--must test if not change dept-->
                                                @if ($user->userType == 'แพทย์')
>>>>>>> f2d65c9b791b70eba4e564cff4ef77a1ab8b3909
                                                    <input type="text" name="new_department"
                                                           placeholder="{{ $user->doctor->department->departmentName }}">
                                                @else
                                                    <input type="text" name="new_department"
                                                           placeholder="{{ $user->nurse->department->departmentName }}">
                                                @endif
                                            </div>
                                        @endif
                                        <div class="row">
                                            <div class="col-xs-6 col-lg-6">
<<<<<<< HEAD
                                                @if ($user->userType == 'doctor' or $user->userType == 'nurse' or $user->userType == 'staff')
=======
                                                @if ($user->userType == 'แพทย์' or $user->userType == 'พยาบาล' or $user->userType == 'เจ้าหน้าที่')
>>>>>>> f2d65c9b791b70eba4e564cff4ef77a1ab8b3909
                                                    <div class="col-xs-12 col-lg-12">
                                                        <input type="checkbox" name="gen_H" value="Allow" checked
                                                               style="margin-top: 9px; margin-right: 3px">
                                                        ดูประวัติอาการทั่วไป </input>
                                                    </div>
                                                @endif
                                                <div class="col-xs-12 col-lg-12">
                                                    <input type="checkbox" name="dia_H" value="Allow" checked
                                                           style="margin-top: 9px; margin-right: 3px">
                                                    ดูประวัติคำวินิจฉัย </input>
                                                </div>
                                                <div class="col-xs-12 col-lg-12">
                                                    <input type="checkbox" name="pre_H" value="Allow" checked
                                                           style="margin-top: 9px; margin-right: 3px">
                                                    ดูประวัติการสั่งยา </input>
                                                </div>
                                            </div>
                                            <div class="col-xs-6 col-lg-6">
                                                <div class="col-xs-12 col-lg-12">
                                                    <input type="checkbox" name="pro_E" value="Allow" checked
                                                           style="margin-top: 9px; margin-right: 3px">
                                                    แก้ไขข้อมูลทั่วไปของผู้ป่วย </input>
                                                </div>
<<<<<<< HEAD
                                                @if ($user->userType == 'doctor')
=======
                                                @if ($user->userType == 'แพทย์')
>>>>>>> f2d65c9b791b70eba4e564cff4ef77a1ab8b3909
                                                    <div class="col-xs-12 col-lg-12">
                                                        <input type="checkbox" name="dia_E" value="Allow" checked
                                                               style="margin-top: 9px; margin-right: 3px">
                                                        แก้ไขประวัติคำวินิจฉัย </input>
                                                    </div>
                                                    <div class="col-xs-12 col-lg-12">
                                                        <input type="checkbox" name="pre_E" value="Allow" checked
                                                               style="margin-top: 9px; margin-right: 3px">
                                                        แก้ไขประวัติการสั่งยา </input>
                                                    </div>
                                                @endif
<<<<<<< HEAD
                                                @if ($user->userType == 'nurse')
=======
                                                @if ($user->userType == 'พยาบาล')
>>>>>>> f2d65c9b791b70eba4e564cff4ef77a1ab8b3909
                                                    <div class="col-xs-12 col-lg-12">
                                                        <input type="checkbox" name="gen_E" value="Allow" checked
                                                               style="margin-top: 9px; margin-right: 3px">
                                                        แก้ไขประวัติอาการทั่วไป </input>
                                                    </div>
                                                @endif
                                            </div>
                                        </div>
                                        <div align="center" style="margin-top: 16px">
                                            <button type="button" class="btn btn-theme04 btn-lg"
                                                    onclick="toggle_visibility('edit_right_popup{{$user->index}}');">
                                                ยกเลิก
                                            </button>
                                            <span style="margin-right: 10px"></span>
                                            <button type="submit" class="btn btn-success btn-lg">บันทึก</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @endif
                    <div id="delete_user_popup{{$user->index}}" class="admin-popup-position" style="z-index: 2">
                        <div id="admin-popup-wrapper">
                            <div id="admin-popup-container">
                                <h4 style="margin-top: 18px; padding-bottom: 12px; border-bottom: 1px solid #e3e6ea; text-align: center">
                                    ลบบัญชี: {{$user->firstname}} {{$user->lastname}}</h4>
                                <form action="/manageAccount" method="post">
                                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                    <input type="hidden" name="username" value="{{ $user->username }}">
                                    <input type="hidden" name="operation" value="delete">

                                    <div align="center" style="margin-top: 16px">
                                        <button type="button" class="btn btn-theme04 btn-lg"
<<<<<<< HEAD
                                                onclick="toggle_visibility('delete_user_popup{{$user->index}}');">
                                            ยกเลิก
=======
                                                onclick="toggle_visibility('delete_user_popup{{$user->index}}');">ยกเลิก
>>>>>>> f2d65c9b791b70eba4e564cff4ef77a1ab8b3909
                                        </button>
                                        <span style="margin-right: 10px"></span>
                                        <button type="submit" class="btn btn-success btn-lg">ยืนยัน</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>

                    <div>
                        <div style="margin-left: 4px">
                            <a href="#" class="account-row">
                                <p class="account-excerpt col-xs-1 col-lg-1">{{$user->index}}</p>
                                <p class="account-excerpt col-xs-2 col-lg-2"
                                   style="padding-left: 8px">{{$user->userId}}</p>
                                <p class="account-excerpt col-xs-3 col-lg-3"
                                   style="padding-left: 12px">{{$user->firstname}} {{$user->lastname}}</p>
                                <p class="account-excerpt col-xs-3 col-lg-3"
                                   style="padding-left: 16px">{{$user->username}}</p>
<<<<<<< HEAD
                                @if ($user->userType == 'patient')
                                    <p class="account-excerpt col-xs-1 col-lg-1" style="padding-left: 20px">
                                        ผู้ป่วย</p>
                                @elseif ($user->userType == 'staff')
                                    <p class="account-excerpt col-xs-1 col-lg-1" style="padding-left: 20px">
                                        เจ้าหน้าที่</p>
                                @elseif ($user->userType == 'doctor')
                                    <p class="account-excerpt col-xs-1 col-lg-1" style="padding-left: 20px">
                                        แพทย์</p>
                                @elseif ($user->userType == 'nurse')
                                    <p class="account-excerpt col-xs-1 col-lg-1" style="padding-left: 20px">
                                        พยาบาล</p>
                                @elseif ($user->userType == 'pharmacist')
                                    <p class="account-excerpt col-xs-1 col-lg-1" style="padding-left: 20px">
                                        เภสัชกร</p>
                                @else
                                    <p class="account-excerpt col-xs-1 col-lg-1" style="padding-left: 20px">
                                        ผู้คุมระบบ</p>
                                @endif
                            </a>
                            <p class="account-excerpt col-xs-1 col-lg-2" style="padding-left: 22px">
                                @if ($user->userType != 'patient' and $user->userType != 'admin')
=======
                                <p class="account-excerpt col-xs-1 col-lg-1"
                                   style="padding-left: 20px">{{$user->userType}}</p>
                            </a>
                            <p class="account-excerpt col-xs-1 col-lg-2" style="padding-left: 22px">
                                @if ($user->userType != 'ผู้ป่วย' and $user->userType != 'ผู้คุมระบบ')
>>>>>>> f2d65c9b791b70eba4e564cff4ef77a1ab8b3909
                                    <a href="#" onclick="toggle_visibility('edit_right_popup{{$user->index}}');">
                                        <i class="fa fa-pencil-square"></i> แก้ไขสิทธิ์ <span
                                                style="margin-right: 10px"></span>
                                    </a>
                                @endif
                                <a href="#" onclick="toggle_visibility('delete_user_popup{{$user->index}}');">
                                    <i class="fa fa-user-times"></i> ลบ
                                </a>
                            </p>
                        </div>

                        <div class="account-detail hide">
                            <div class="row">
                                <!--picture section-->
                                <div class="col-xs-1 col-lg-1" style="margin-top: 8px">
                                </div>
                                <div class="col-xs-2 col-lg-2" style="margin-top: 8px" align="center">
                                    <img src="assets/img/ui-sam.jpg" class="img-circle" width="100">
                                </div>
                                <!--info section-->
                                <div class="col-xs-9 col-lg-9" align="left" style="margin-top: 8px">
<<<<<<< HEAD
                                    @if ($user->userType == 'patient')
=======
                                    @if ($user->userType == 'ผู้ป่วย')
>>>>>>> f2d65c9b791b70eba4e564cff4ef77a1ab8b3909
                                        <div class="col-xs-4 col-lg-4">
                                            <p>เลขประจำตัวผู้ป่วย: {{$user->patient->hn}}</p>
                                        </div>
                                        <div class="col-xs-8 col-lg-8">
                                            <p>เลขประจำตัวประชาชน: {{$user->idNumber}}</p>
                                        </div>
<<<<<<< HEAD
                                        @if ($user->gender == 'male')
                                            <div class="col-xs-4 col-lg-4">
                                                <p>เพศ: ชาย</p>
                                            </div>
                                        @else
                                            <div class="col-xs-4 col-lg-4">
                                                <p>เพศ: หญิง</p>
                                            </div>
                                        @endif
=======
                                        <div class="col-xs-4 col-lg-4">
                                            <p>เพศ: {{$user->gender}}</p>
                                        </div>
>>>>>>> f2d65c9b791b70eba4e564cff4ef77a1ab8b3909
                                        <div class="col-xs-4 col-lg-4">
                                            <p>วันเกิด: {{$user->birthDate}}</p>
                                        </div>
                                        <div class="col-xs-4 col-lg-4">
                                            <p>กรุ๊ปเลือด: {{$user->patient->bloodType}}</p>
                                        </div>
                                        <div class="col-xs-12 col-lg-12" style="margin-bottom: 10px">
                                            <p>การแพ้: {{$user->patient->allergen}}</p>
                                        </div>
                                        <div class="col-xs-4 col-lg-4">
                                            <p><i class="fa fa-phone-square"
                                                  style="margin-right: 5px"></i> {{$user->phoneNumber}}</p>
                                        </div>
                                        <div class="col-xs-8 col-lg-8">
<<<<<<< HEAD
                                            <p><i class="fa fa-envelope"
                                                  style="margin-right: 5px"></i> {{$user->email}}
=======
                                            <p><i class="fa fa-envelope" style="margin-right: 5px"></i> {{$user->email}}
>>>>>>> f2d65c9b791b70eba4e564cff4ef77a1ab8b3909
                                            </p>
                                        </div>
                                        <div class="col-xs-12 col-lg-12">
                                            <p><i class="fa fa-address-book"
                                                  style="margin-right: 5px"></i> {{$user->address}}</p>
                                        </div>
                                    @else
<<<<<<< HEAD
                                        @if ($user->userType == 'staff')
                                            <div class="col-xs-4 col-lg-4">
                                                <p>เลขประจำตัวเจ้าหน้าที่: {{$user->staff->staffNumber}}</p>
                                            </div>
                                        @elseif ($user->userType == 'doctor')
                                            <div class="col-xs-4 col-lg-4">
                                                <p>เลขประจำตัวแพทย์: {{$user->doctor->doctorNumber}}</p>
                                            </div>
                                        @elseif ($user->userType == 'nurse')
                                            <div class="col-xs-4 col-lg-4">
                                                <p>เลขประจำตัวพยาบาล: {{$user->nurse->nurseNumber}}</p>
                                            </div>
                                        @elseif ($user->userType == 'pharmacist')
                                            <div class="col-xs-4 col-lg-4">
                                                <p>เลขประจำตัวเภสัชกร: {{$user->pharmacist->pharmacistNumber}}</p>
                                            </div>
                                        @elseif ($user->userType == 'admin')
=======
                                        @if ($user->userType == 'เจ้าหน้าที่')
                                            <div class="col-xs-4 col-lg-4">
                                                <p>เลขประจำตัวเจ้าหน้าที่: {{$user->staff->staffNumber}}</p>
                                            </div>
                                        @elseif ($user->userType == 'แพทย์')
                                            <div class="col-xs-4 col-lg-4">
                                                <p>เลขประจำตัวแพทย์: {{$user->doctor->doctorNumber}}</p>
                                            </div>
                                        @elseif ($user->userType == 'พยาบาล')
                                            <div class="col-xs-4 col-lg-4">
                                                <p>เลขประจำตัวพยาบาล: {{$user->nurse->nurseNumber}}</p>
                                            </div>
                                        @elseif ($user->userType == 'เภสัชกร')
                                            <div class="col-xs-4 col-lg-4">
                                                <p>เลขประจำตัวเภสัชกร: {{$user->pharmacist->pharmacistNumber}}</p>
                                            </div>
                                        @else
>>>>>>> f2d65c9b791b70eba4e564cff4ef77a1ab8b3909
                                            <div class="col-xs-4 col-lg-4">
                                                <p>เลขประจำตัวผู้คุมระบบ: {{$user->admin->adminNumber}}</p>
                                            </div>
                                        @endif
                                        <div class="col-xs-8 col-lg-8">
                                            <p>เลขประจำตัวประชาชน: {{$user->idNumber}}</p>
                                        </div>
<<<<<<< HEAD
                                        @if ($user->gender == 'male')
                                            <div class="col-xs-4 col-lg-4">
                                                <p>เพศ: ชาย</p>
                                            </div>
                                        @else
                                            <div class="col-xs-4 col-lg-4">
                                                <p>เพศ: หญิง</p>
                                            </div>
                                        @endif
                                        <div class="col-xs-8 col-lg-8">
                                            <p>วันเกิด: {{$user->birthDate}}</p>
                                        </div>
                                        @if ($user->userType == 'doctor')
                                            <div class="col-xs-12 col-lg-12">
                                                <p>แผนก: {{$user->doctor->department->departmentName}}</p>
                                            </div>
                                        @elseif ($user->userType == 'nurse')
=======
                                        <div class="col-xs-4 col-lg-4">
                                            <p>เพศ: {{$user->gender}}</p>
                                        </div>
                                        <div class="col-xs-8 col-lg-8">
                                            <p>วันเกิด: {{$user->birthDate}}</p>
                                        </div>
                                        @if ($user->userType == 'แพทย์')
                                            <div class="col-xs-12 col-lg-12">
                                                <p>แผนก: {{$user->doctor->department->departmentName}}</p>
                                            </div>
                                        @elseif ($user->userType == 'พยาบาล')
>>>>>>> f2d65c9b791b70eba4e564cff4ef77a1ab8b3909
                                            <div class="col-xs-12 col-lg-12">
                                                <p>แผนก: {{$user->nurse->department->departmentName}}</p>
                                            </div>
                                        @endif
                                        <div class="col-xs-4 col-lg-4">
                                            <p><i class="fa fa-phone-square"
                                                  style="margin-top: 10px; margin-right: 5px"></i> {{$user->phoneNumber}}
                                            </p>
                                        </div>
                                        <div class="col-xs-8 col-lg-8">
                                            <p><i class="fa fa-envelope"
<<<<<<< HEAD
                                                  style="margin-top: 10px; margin-right: 5px"></i> {{$user->email}}
                                            </p>
=======
                                                  style="margin-top: 10px; margin-right: 5px"></i> {{$user->email}}</p>
>>>>>>> f2d65c9b791b70eba4e564cff4ef77a1ab8b3909
                                        </div>
                                        <div class="col-xs-12 col-lg-12">
                                            <p><i class="fa fa-address-book"
                                                  style="margin-right: 5px"></i> {{$user->address}}</p>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
<<<<<<< HEAD
                {{--@endif--}}
=======

>>>>>>> f2d65c9b791b70eba4e564cff4ef77a1ab8b3909
            </div>
        </div>
    </div>
@stop