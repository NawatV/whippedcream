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

                    <h1>ดูอาการทั่วไป</h1>

                    <br>
                    <form class="form-horizontal style-form" action="editVitalSignHistory" method="post">
                      <input type="hidden" name="_token" value="{{ csrf_token() }}">
                      <input type="hidden" name="userId" value="{{$patients->userId}}">
                      <input type="hidden" name="vitalsignID" value="{{$vitalsigns->vitalSignDataId}}">
                        <div class="form-horizontal style-form">
                            <div class="form-group">
                                    <label class="col-sm-2 col-sm-2 control-label">รหัสประจำตัวผู้ป่วย</label>
                                    <div class="col-sm-5">
                                        <input type="text" class="form-control" value="{{$patients2->hn}}" readonly name="hn">
                                    </div>
                            </div>
                            <div class="form-group">
                                    <label class="col-sm-2 col-sm-2 control-label">ชื่อ</label>
                                    <div class="col-sm-5">
                                        <input type="text" class="form-control" value="{{$patients->firstname}}" readonly name="firstname">
                                    </div>
                            </div>
                            <div class="form-group">
                                    <label class="col-sm-2 col-sm-2 control-label">นามสกุล</label>
                                    <div class="col-sm-5">
                                        <input type="text" class="form-control" value="{{$patients->firstname}}" readonly name="lastname">
                                    </div>
                            </div>
                            <div class="form-group">
                                    <label class="col-sm-2 col-sm-2 control-label">น้ำหนัก</label>
                                    <div class="col-sm-5">
                                        <input type="text" class="form-control" value="{{$vitalsigns->height}}" name="weight">
                                    </div>
                            </div>
                            <div class="form-group">
                                    <label class="col-sm-2 col-sm-2 control-label">ส่วนสูง</label>
                                    <div class="col-sm-5">
                                        <input type="text" class="form-control" value="{{$vitalsigns->weight}}" name="height">
                                    </div>
                            </div>
                            <div class="form-group">
                                    <label class="col-sm-2 col-sm-2 control-label">อุณหภูมิ</label>
                                    <div class="col-sm-5">
                                        <input type="text" class="form-control" value="{{$vitalsigns->temperature}}" name="temperature">
                                    </div>
                            </div>
                            <div class="form-group">
                                    <label class="col-sm-2 col-sm-2 control-label">ชีพจร</label>
                                    <div class="col-sm-5">
                                        <input type="text" class="form-control" value="{{$vitalsigns->pulse}}" name="pulse">
                                    </div>
                            </div>
                            <div class="form-group">
                                    <label class="col-sm-2 col-sm-2 control-label">ความดัน Systolic </label>
                                    <div class="col-sm-5">
                                        <input type="text" class="form-control" value="{{$vitalsigns->systolic}}" name="systolic">
                                    </div>
                            </div>
                            <div class="form-group">
                                    <label class="col-sm-2 col-sm-2 control-label">ความดัน Diastolic</label>
                                    <div class="col-sm-5">
                                        <input type="text" class="form-control" value="{{$vitalsigns->diastolic}}" name="diastolic">
                                    </div>
                            </div>
                            <button type="submit" class="btn btn-primary pull-right"> ยืนยัน</button>
                    </form>
                              <a href="{{ URL::previous() }}" class="btn btn-primary pull-right"> ยกเลิก</a>
                </div>
            </div>


        </div>
    </div>







@endsection
