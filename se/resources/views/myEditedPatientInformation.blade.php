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
                    <h4 class="mb"><i class="fa fa-angle-right"></i> &nbsp;แก้ไขข้อมูลทั่วไป</h4>
                    <form class="form-horizontal style-form" action="seeEditedMyPatientInformation" method="post">
                        <input type="hidden" name="userId" value="{{$patients->userId}}">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <div class="form-group">
                            <label class="col-sm-2 col-sm-2 control-label">รหัสประจำตัวผู้ป่วย</label>
                            <div class="col-sm-5">
                                <input type="text" class="form-control" value="{{$patients2->hn}}" name="hn" readonly>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 col-sm-2 control-label">ชื่อ</label>
                            <div class="col-sm-5">
                                <input type="text" class="form-control" value="{{$patients->firstname}}"
                                       name="firstname">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 col-sm-2 control-label">นามสกุล</label>
                            <div class="col-sm-5">
                                <input type="text" class="form-control" value="{{$patients->lastname}}" name="lastname">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 col-sm-2 control-label">เพศ</label>
                            <div class="col-sm-5">
                                <input type="text" class="form-control" value="{{$patients->gender}}" name="gender">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 col-sm-2 control-label">รหัสประจำตัวประชาชน</label>
                            <div class="col-sm-5">
                                <input type="text" class="form-control" value="{{$patients->idNumber}}" name="idNumber">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 col-sm-2 control-label">วันเกิด</label>
                            <div class="col-sm-5">
                                <input type="text" class="form-control" value="{{$patients->birthDate}}"
                                       name="birthDate">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 col-sm-2 control-label">ที่อยู่</label>
                            <div class="col-sm-5">
                                <textarea name="address" class="form-control textareaControl" rows="4">
                                    {{$patients->address}}
                                </textarea>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 col-sm-2 control-label">เบอร์โทรศัพท์</label>
                            <div class="col-sm-5">
                                <input type="text" class="form-control" value="{{$patients->phoneNumber}}"
                                       name="phoneNumber">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 col-sm-2 control-label">อีเมล</label>
                            <div class="col-sm-5">
                                <input type="text" class="form-control" value="{{$patients->email}}" name="email">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 col-sm-2 control-label">กรุ๊ปเลือด</label>
                            <div class="col-sm-5">
                                <input type="text" class="form-control" value="{{$patients2->bloodType}}"
                                       name="bloodType">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 col-sm-2 control-label">ประวัติการแพ้ยา</label>
                            <div class="col-sm-5">
                                <input type="text" class="form-control" value="{{$patients2->allergen}}"
                                       name="allergen">
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-lg-offset-3 col-sm-2 col-lg-2">
                                <button type="submit" class="btn btn-success btn-block" Z> ยืนยัน</button>
                            </div>
                            <div class="col-lg-offset-2 col-sm-2 col-lg-2">
                                <a href="{{ URL::to('/myPatientInformation') }}" class="btn btn-danger btn-block">
                                    ยกเลิก</a>
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
