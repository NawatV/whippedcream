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

                    <h1>แบบฟอร์ม แก้ไขประวัติคำวินิจฉัย</h1>

                    <br>
                    <form class="form-horizontal style-form" action="/editDiagnosisHistory/{{$diagnosis->diagnosisId}}/confirm" method="delete">
                    {{--<form class="form-horizontal style-form" action="/confirm" method="post">--}}
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">

                        <div class="form-group">
                            <div class="container">
                                <label class="col-sm-2 col-sm-2 control-label">เลขรหัสโรค เดิม</label>
                                <div class="col-sm-2">
                                    <input type="text" class="form-control" value="{{$diagnosis->symptomcode}}" readonly>
                                </div>

                                <label class="col-sm-2 col-sm-2 control-label col-lg-offset-1">เลขรหัสโรค ใหม่</label>
                                <div class="col-sm-2">
                                    <input name="newSymptomcode" type="text" class="form-control">
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="container">
                                <label class="col-sm-2 col-lg-2 control-label">คำวินิจฉัย เดิม</label>
                                <div class="col-sm-6 col-lg-6">
                                    <input type="text" value="{{$diagnosis->diagnosisDetail}}"
                                           class="form-control" readonly>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="container">
                                <label class="col-sm-2 col-sm-2 control-label">คำวินิจฉัย ใหม่</label>
                                <div class="col-sm-6 col-lg-6">
                                    <input name="newDiagnosisDetail" type="text" class="form-control">
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-sm-1 col-lg-1"></div>
                            <button type="submit" class="btn btn-success center-block col-sm-2 col-lg-2">
                                ยืนยัน
                            </button>
                            {{--<div class="col-sm-2 col-lg-2"></div>--}}
                            {{--<a type="button" class="btn btn-danger center-block col-sm-2 col-lg-2" href="{{ url()->previous() }}">--}}
                                {{--ยกเลิก--}}
                            {{--</a>--}}
                            <div class="col-sm-1 col-lg-1"></div>
                        </div>
                    </form>

                </div>
            </div>


        </div>
    </div>







@endsection
