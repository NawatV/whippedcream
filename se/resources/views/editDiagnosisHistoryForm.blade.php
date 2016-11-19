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
                    <form class="form-horizontal style-form" action="confirm" method="post">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">

                        <div class="form-group">
                            <div class="container">
                                <label class="col-sm-2 col-sm-2 control-label">เลขรหัสโรค</label>
                                <div class="col-sm-2">
                                    <input name="hnNumber" type="text" class="form-control">
                                </div>
                                {{--<button type="submit" class="btn btn-primary">ค้นหาด้วยเลขประจำตัวผู้ป่วย--}}
                                {{--</button>--}}
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="container">
                                <label class="col-sm-2 col-sm-2 control-label">คำวินิจฉัย ดั้งเดิม</label>
                                <div class="col-sm-3">
                                    <span style="display: block; word-break:break-all; width: 80%;">{{$diagnosis->diagnosisDetail}}</span>
                                    <input name="firstname" type="text" class="form-control">
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="container">
                                <label class="col-sm-2 col-sm-2 control-label">คำวินิจฉัย ใหม่</label>
                                <div class="col-sm-3">
                                    <input name="firstname" type="text" class="form-control">
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-sm-3 col-lg-3"></div>
                            <button type="submit" ac class="btn btn-success center-block col-sm-2 col-lg-2">
                                ยืนยัน
                            </button>
                            <div class="col-sm-2 col-lg-2"></div>
                            <button type="button" class="btn btn-danger center-block col-sm-2 col-lg-2">
                                ยกเลิก
                            </button>
                            <div class="col-sm-3 col-lg-3"></div>
                        </div>
                    </form>

                </div>
            </div>


        </div>
    </div>







@endsection
