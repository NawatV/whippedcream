@extends('layouts.theme')

@section('name')
    นายแพทย์
@endsection

@section('leftnav')
    <li class="sub-menu">
        <a href="javascript:;">
            <i class="fa fa-calendar"></i><span>ตารางวันและเวลา</span>
        </a>
    </li>

    <li class="sub-menu">
        <a class="active" href="javascript:;">
            <i class="fa fa-plus-circle"></i><span>สร้างการนัดหมาย</span>
        </a>
    </li>

    <li class="sub-menu">
        <a href="javascript:;">
            <i class="fa fa-pencil-square"></i><span>การนัดหมาย</span>
        </a>
    </li>

    <li class="sub-menu">
        <a href="javascript:;">
            <i class="fa fa-heart"></i><span>บันทึกคำวินิจฉัยและใบสั่งยา</span>
        </a>
    </li>

    <li class="sub-menu">
        <a href="javascript:;">
            <i class="fa fa-group"></i><span>ข้อมูลผู้ป่วย</span>
        </a>
    </li>

    <li class="sub-menu">
        <a href="javascript:;">
            <i class="fa fa-plus-square"></i><span>จ่ายยา</span>
        </a>
    </li>
@endsection


@section('content')
    <!-- BASIC FORM ELELEMNTS -->
    <div class="row mt">
        <div class="col-lg-12">
            <div class="form-panel">
                <div class="container-fluid">
                    <h4 class="mb"><i class="fa fa-angle-right"></i> ลงทะเบียน</h4>
                    <form class="form-horizontal style-form" method="get">
                        <div class="form-group">
                            <label class="col-sm-2 col-sm-2 control-label">ชี่อ</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control">
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-2 col-sm-2 control-label">นามสกุล</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control">
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-2 col-sm-2 control-label">เลขบัตรประจำตัวประชาชน</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control">
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-2 col-sm-2 control-label">ที่อยู่</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control">
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-2 col-sm-2 control-label">เพศ</label>
                            <div class="col-sm-10">
                                <div class="radio">
                                    <label class="col-sm-2">
                                        <input type="radio" name="optionsRadios" id="optionsRadios1" value="option1"
                                               checked> ชาย
                                    </label>

                                    <label class="col-sm-2">
                                        <input type="radio" name="optionsRadios" id="optionsRadios2" value="option2">
                                        หญิง
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-2 col-sm-2 control-label">เบอร์โทรศัพท์</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control">
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-2 col-sm-2 control-label">อีเมล</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control">
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-2 col-sm-2 control-label">กรุ๊ปเลือด</label>
                            <div class="col-sm-10">
                                <div class="radio">
                                    <label class="col-sm-2">
                                        <input type="radio" name="optionsRadios" id="optionsRadios1" value="option1"
                                               checked> A
                                    </label>

                                    <label class="col-sm-2">
                                        <input type="radio" name="optionsRadios" id="optionsRadios2" value="option2"> B
                                    </label>

                                    <label class="col-sm-2">
                                        <input type="radio" name="optionsRadios" id="optionsRadios3" value="option3"> AB
                                    </label>

                                    <label class="col-sm-2">
                                        <input type="radio" name="optionsRadios" id="optionsRadios4" value="option4"> O
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-2 col-sm-2 control-label">วัน/เดือน/ปี เกิด</label>
                            <div class="col-sm-4">
                                <div class="input-group date" data-provide="datepicker">
                                    <input type="text" class="form-control">
                                    <div class="input-group-addon">
                                        <span class="glyphicon glyphicon-th"></span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-2 col-sm-2 control-label">ชื่อผู้ใช้</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control">
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-2 col-sm-2 control-label">รหัสผ่าน</label>
                            <div class="col-sm-10">
                                <input type="password" class="form-control" placeholder="">
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-2 col-sm-2 control-label">ยืนยันรหัสผ่าน</label>
                            <div class="col-sm-10">
                                <input type="password" class="form-control" placeholder="">
                            </div>
                        </div>

                    </form>

                    <button type="button" class="btn btn-primary pull-right ">บันทึก</button>
                </div>
            </div>
        </div>
    </div>

@endsection
