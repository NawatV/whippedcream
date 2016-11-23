@extends('layouts.theme')

@section('css')
@endsection

@section('name')
    {{session('name')}}
@endsection

@section('content')
    <div class="row mt">
        <div class="col-lg-10">
            <div class="form-panel">
                <div class="container-fluid">
                    <h4 class="mb"><i class="fa fa-angle-right"></i> &nbsp;ข้อมูลทั่วไป</h4>

                    <div class="form-horizontal style-form">
                        <div class="form-group">
                            <label class="col-sm-2 col-lg-2 control-label">รหัสประจำตัวผู้ป่วย</label>
                            <div class="col-sm-6">
                                <input type="text" class="form-control" value="{{$patients2->hn}}" readonly>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 col-lg-2 control-label">ชื่อ</label>
                            <div class="col-sm-6">
                                <input type="text" class="form-control" value="{{$patients->firstname}}" readonly>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 col-lg-2 control-label">นามสกุล</label>
                            <div class="col-sm-6">
                                <input type="text" class="form-control" value="{{$patients->lastname}}" readonly>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 col-lg-2 control-label">เพศ</label>
                            <div class="col-sm-6">
                                <input type="text" class="form-control" value="{{$patients->gender}}" readonly>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 col-lg-2 control-label">รหัสประจำตัวประชาชน</label>
                            <div class="col-sm-6">
                                <input type="text" class="form-control" value="{{$patients->idNumber}}" readonly>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 col-lg-2 control-label">วันเกิด</label>
                            <div class="col-sm-6">
                                <input type="text" class="form-control" value="{{$patients->birthDate}}" readonly>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 col-lg-2 control-label">ที่อยู่</label>
                            <div class="col-sm-6">
                                <textarea class="form-control textareaControl" rows="4" readonly>
                                    {{$patients->address}}
                                </textarea>
                                {{--<input type="text" class="form-control" value="" readonly>--}}
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 col-lg-2 control-label">เบอร์โทรศัพท์</label>
                            <div class="col-sm-6">
                                <input type="text" class="form-control" value="{{$patients->phoneNumber}}" readonly>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 col-lg-2 control-label">อีเมล</label>
                            <div class="col-sm-6">
                                <input type="text" class="form-control" value="{{$patients->email}}" readonly>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 col-lg-2 control-label">กรุ๊ปเลือด</label>
                            <div class="col-sm-6">
                                <input type="text" class="form-control" value="{{$patients2->bloodType}}" readonly>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 col-lg-2 control-label">ประวัติการแพ้ยา</label>
                            <div class="col-sm-6">
                                <input type="text" class="form-control" value="{{$patients2->allergen}}" readonly>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-lg-offset-5 col-sm-2 col-lg-2">
                                <form class="form-horizontal style-form" action="myEditedPatientInformation"
                                      method="post">
                                    <input type="hidden" name="userId" value="{{$patients->userId}}">
                                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                    <button type="submit" class="btn btn-primary btn-block"> แก้ไข</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('special-content')

@endsection

@section('script')

@endsection
