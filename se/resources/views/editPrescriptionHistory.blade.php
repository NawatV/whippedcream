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


                    <h1>This is editPrescriptionHistory</h1>


                    <h4 class="mb">
                        <i class="fa fa-angle-right"></i> ค้นหาผู้ป่วยที่ต้องการ
                    </h4>
                    <h5>สามารถกรอกอย่างใดอย่างหนึ่ง หรือ ทั้งหมด</h5>
                    <form class="form-horizontal style-form" method="get">
                        <div class="form-group">
                            <label class="col-sm-2 col-sm-2 control-label">เลขบัตรประจำตัวประชาชน</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control">
                            </div>
                            <button type="button" class="btn btn-primary pull-right ">ค้นหาด้วยเลขบัตรประจำตัวประชาชน
                            </button>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-2 col-sm-2 control-label">เลขประจำตัวผู้ป่วย</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control">
                            </div>
                            <button type="button" class="btn btn-primary pull-right ">ค้นหาด้วยเลขประจำตัวผู้ป่วย
                            </button>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-2 col-sm-2 control-label">ชื่อ</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control">
                            </div>

                            <label class="col-sm-2 col-sm-2 control-label">นามสกุล</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control">
                            </div>
                            <button type="button" class="btn btn-primary pull-right ">ค้นหาด้วยชื่อ และ นามสกุล</button>
                        </div>

                    </form>


                </div>
            </div>
        </div>
    </div>

@endsection
