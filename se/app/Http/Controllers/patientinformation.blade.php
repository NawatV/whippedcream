@extends('layouts.theme')

@section('css')
@endsection

@section('name')
    {{session('name')}}
@endsection

@section('content')
    <div class="row mt">
        <div class="col-lg-12">
            <div class="form-panel">
                <div class="container-fluid">
                    <h4 class="mb">
                        <i class="fa fa-angle-right"></i> &nbsp;ข้อมูลทั่วไป
                    </h4>
                    <a class="btn btn-primary pull-right" href="{{ url('/editpatientinformation') }}">แก้ไข</a>
                    <form class="form style-form" action="{{url('/vitalsign')}}" method="post">
                        <div class="form-group">
                            <label class="col-sm-2 control-label">เลขประจำตัวผู้ป่วย</label>
                            <div class="col-lg-10">
                                <p class="form-control-static">xxxxxxxxxxxxx</p>
                            </div>

                            <label class="col-sm-2 control-label">ชื่อ</label>
                            <div class="col-lg-10">
                                <p class="form-control-static">บุณพจน์</p>
                            </div>
                            <label class="col-sm-2 control-label">นามสกุล</label>
                            <div class="col-lg-10">
                                <p class="form-control-static">นามสกุลไรก็ไม่รู้</p>
                            </div>


                            <label class="col-sm-2 control-label">เพศ</label>
                            <div class="col-lg-10">
                                <p class="form-control-static">ชาย</p>
                            </div>
                            <label class="col-sm-2 control-label">วันเกิด</label>
                            <div class="col-lg-10">
                                <p class="form-control-static">01 / 01 / 2537</p>
                            </div>


                            <label class="col-sm-2 control-label">ที่อยู่</label>
                            <div class="col-lg-10">
                                <p class="form-control-static">xxxxxxxxxxx</p>
                            </div>


                            <label class="col-sm-2 control-label">เบอร์โทรศัพท์</label>
                            <div class="col-lg-10">
                                <p class="form-control-static">08x-xxx-xxxx </p>
                            </div>


                            <label class="col-sm-2 control-label">อีเมล</label>
                            <div class="col-lg-10">
                                <p class="form-control-static">xxxxx@xxxxx.com</p>
                            </div>
                            <label class="col-sm-2 control-label">กรุ๊ปเลือด</label>
                            <div class="col-lg-10">
                                <p class="form-control-static">O</p>
                            </div>

                            <label class="col-sm-2 control-label">ประวัติการแพ้ยา</label>
                            <div class="col-lg-10">
                                <p class="form-control-static">xxxxxxxxxxx</p>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('special-content')

@endsection

@section('script')

@endsection
