@extends('layouts.theme')

@section('name')
    {{session('name')}}
@endsection

@section('content')
    <!-- BASIC FORM ELELEMNTS -->
    <div class="row mt">
        <div class="col-lg-12">
            <div class="form-panel">
                <div class="container-fluid">

                    <h1>ดูอาการทั่วไป</h1>

                    <br>
                        <div class="form-horizontal style-form">
                            <div class="form-group">
                                    <label class="col-sm-2 col-sm-2 control-label">รหัสประจำตัวผู้ป่วย</label>
                                    <div class="col-sm-5">
                                        <input type="text" class="form-control" value="{{$patients2->hn}}" readonly>
                                    </div>
                            </div>
                            <div class="form-group">
                                    <label class="col-sm-2 col-sm-2 control-label">ชื่อ</label>
                                    <div class="col-sm-5">
                                        <input type="text" class="form-control" value="{{$patients->firstname}}" readonly>
                                    </div>
                            </div>
                            <div class="form-group">
                                    <label class="col-sm-2 col-sm-2 control-label">นามสกุล</label>
                                    <div class="col-sm-5">
                                        <input type="text" class="form-control" value="{{$patients->lastname}}" readonly>
                                    </div>
                            </div>
                            <div class="form-group">
                                    <label class="col-sm-2 col-sm-2 control-label">น้ำหนัก</label>
                                    <div class="col-sm-5">
                                        <input type="text" class="form-control" value="{{$vitalsigns->height}}" readonly>
                                    </div>
                            </div>
                            <div class="form-group">
                                    <label class="col-sm-2 col-sm-2 control-label">ส่วนสูง</label>
                                    <div class="col-sm-5">
                                        <input type="text" class="form-control" value="{{$vitalsigns->weight}}" readonly>
                                    </div>
                            </div>
                            <div class="form-group">
                                    <label class="col-sm-2 col-sm-2 control-label">อุณหภูมิ</label>
                                    <div class="col-sm-5">
                                        <input type="text" class="form-control" value="{{$vitalsigns->temperature}}" readonly>
                                    </div>
                            </div>
                            <div class="form-group">
                                    <label class="col-sm-2 col-sm-2 control-label">ชีพจร</label>
                                    <div class="col-sm-5">
                                        <input type="text" class="form-control" value="{{$vitalsigns->pulse}}" readonly>
                                    </div>
                            </div>
                            <div class="form-group">
                                    <label class="col-sm-2 col-sm-2 control-label">ความดัน Systolic </label>
                                    <div class="col-sm-5">
                                        <input type="text" class="form-control" value="{{$vitalsigns->systolic}}" readonly>
                                    </div>
                            </div>
                            <div class="form-group">
                                    <label class="col-sm-2 col-sm-2 control-label">ความดัน Diastolic</label>
                                    <div class="col-sm-5">
                                        <input type="text" class="form-control" value="{{$vitalsigns->diastolic}}" readonly>
                                    </div>
                            </div>

                      <form class="form-horizontal style-form" action="seeEditVitalSignHistory" method="post">
                              <input type="hidden" name="_token" value="{{ csrf_token() }}">
                              <input type="hidden" name="userId" value="{{$patients->userId}}">
                              <input type="hidden" name="vitalsignID" value="{{$vitalsigns->vitalSignDataId}}">
                              <button type="submit" class="btn btn-primary pull-right"> แก้ไข</button>
                    </form>

                </div>
            </div>


        </div>
    </div>







@endsection
