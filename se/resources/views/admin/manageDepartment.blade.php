@extends('adminTemplate')
@section('main-content')
    @if(Session::get('edit_dep_error') == 1)
        <div id="error-popup" class="admin-popup-position-dont-hide" style="z-index: 2">
            <div id="admin-error-popup-wrapper">
                <div id="admin-error-popup-container" align="center">
                    <div style="font-size: 18px; float: right; position: relative; left: 10px">
                        <a href="#" onclick="toggle_visibility('error-popup');" style="text-decoration: none">
                            <i class="fa fa-times-circle"></i>
                        </a>
                    </div>
                    <p style="font-size: 120px; color: #ed5565"><i class="fa fa-exclamation-circle"></i></p>
                    <h4 style="position: relative; bottom: 26px"> ชื่อแผนกมีอยู่แล้ว <br> ไม่สามารถเปลี่ยนชื่อแผนกได้
                    </h4>
                </div>
            </div>
        </div>
    @endif
    @if(Session::get('edit_dep_error') == 2)
        <div id="error-popup" class="admin-popup-position-dont-hide" style="z-index: 2">
            <div id="admin-error-popup-wrapper">
                <div id="admin-error-popup-container" align="center">
                    <div style="font-size: 18px; float: right; position: relative; left: 10px">
                        <a href="#" onclick="toggle_visibility('error-popup');" style="text-decoration: none">
                            <i class="fa fa-times-circle"></i>
                        </a>
                    </div>
                    <p style="font-size: 120px; color: #f4d442"><i class="fa fa-info-circle"></i></p>
                    <h4 style="position: relative; bottom: 26px"> ยังมีแพทย์หรือพยาบาลอยู่ในแผนก <br> ไม่สามารถลบแผนกได้
                    </h4>
                </div>
            </div>
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
        <form action="/manageDepartment" method="get">
            <div class="row">
                <div class="mt2">
                    <!--Department Name-->
                    <div class="col-xs-5 col-lg-5" align="left">
                        <label class="col-xs-2 col-lg-2 control-label" style="margin-top: 9px">ชื่อแผนก</label>
                        <div class="col-xs-10 col-lg-10">
                            <input type="text" class="form-control" name='dep_name' placeholder="{{$departmentName}}"
                                   onfocus="this.placeholder = 'ทั้งหมด'">
                        </div>
                    </div>
                    <div class="col-xs-5 col-lg-5" align="left">
                        <button type="submit" class="btn btn-theme04" style="height: 35px">ค้นหา</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
    <!--end of search form-->

    <div class="row heightFull">
        <!--start account list-->
        <div class="account-list-area account-list-search-active">
            <div>
                <p class="account-list-header col-xs-1 col-lg-1">ลำดับ</p>
                <p class="account-list-header col-xs-2 col-lg-2">เลขที่แผนก</p>
                <p class="account-list-header col-xs-4 col-lg-4">ชื่อแผนก</p>
                <p class="account-list-header col-xs-3 col-lg-3">ชื่อแผนก</p>
                <p class="account-list-header last-column col-xs-2 col-lg-2">การดำเนินการ</p>
            </div>
            <div class="account-list-panel">

            @foreach($departments as $department)
                <!--edit popup-->
                    <div id="edit_dep_popup{{$department->index}}" class="admin-popup-position" style="z-index: 2">
                        <div id="admin-popup-wrapper">
                            <div id="admin-popup-container">
                                <h4 style="margin-top: 18px; padding-bottom: 12px; border-bottom: 1px solid #e3e6ea; text-align: center">
                                    แก้ไขชื่อแผนก: {{$department->departmentName}}</h4>
                                <form action="/manageDepartment" method="post">
                                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                    <input type="hidden" name="old_name" value="{{$department->departmentName}}">
                                    <input type="hidden" name="operation" value="change_name">
                                    <div style="padding-left: 14px; margin-bottom: 8px; margin-top: 14px">
                                        <label style="margin-right: 8px"> ชื่อแผนก </label>
                                        <input type="text" name="new_name"
                                               placeholder="{{$department->departmentName}}">
                                    </div>
                                    <div align="center" style="margin-top: 16px">
                                        <button type="button" class="btn btn-theme04 btn-lg"
                                                onclick="toggle_visibility('edit_dep_popup{{$department->index}}');">
                                            ยกเลิก
                                        </button>
                                        <span style="margin-right: 10px"></span>
                                        <button type="submit" class="btn btn-success btn-lg">บันทึก</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <div id="delete_dep_popup{{$department->index}}" class="admin-popup-position" style="z-index: 2">
                        <div id="admin-popup-wrapper">
                            <div id="admin-popup-container">
                                <h4 style="margin-top: 18px; padding-bottom: 12px; border-bottom: 1px solid #e3e6ea; text-align: center">
                                    ลบแผนก: {{$department->departmentName}}</h4>
                                <form action="/manageDepartment" method="post">
                                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                    <input type="hidden" name="name" value="{{$department->departmentName}}">
                                    <input type="hidden" name="operation" value="delete">

                                    <div align="center" style="margin-top: 16px">
                                        <button type="button" class="btn btn-theme04 btn-lg"
                                                onclick="toggle_visibility('delete_dep_popup{{$department->index}}');">
                                            ยกเลิก
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
                                <p class="account-excerpt col-xs-1 col-lg-1">{{$department->index}}</p>
                                <p class="account-excerpt col-xs-2 col-lg-2"
                                   style="padding-left: 8px">{{$department->departmentId}}</p>
                                <p class="account-excerpt col-xs-4 col-lg-4"
                                   style="padding-left: 16px">{{$department->departmentName}}</p>
                                <p class="account-excerpt col-xs-3 col-lg-3"
                                   style="padding-left: 20px">{{$department->location}}</p>
                            </a>
                            <p class="account-excerpt col-xs-2 col-lg-2" style="padding-left: 22px">
                                <a href="#" onclick="toggle_visibility('edit_dep_popup{{$department->index}}');">
                                    <i class="fa fa-pencil-square"></i> แก้ไข <span style="margin-right: 10px"></span>
                                </a>
                                <a href="#" onclick="toggle_visibility('delete_dep_popup{{$department->index}}');">
                                    <i class="fa fa-user-times"></i> ลบ
                                </a>
                            </p>
                        </div>
                    </div>
                @endforeach

            </div>
        </div>
    </div>
@stop