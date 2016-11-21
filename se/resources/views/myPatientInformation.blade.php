@extends('layouts.theme')

@section('css')
  <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">
@endsection

@section('name')
  Mr. Someone
@endsection

@section('leftnav')
  	<li class="sub-menu">
        <a class="active" href="javascript:;" >
        	<i class="fa fa-user"></i><span>ข้อมูลทั่วไป</span>
        </a>
    </li>
    <li class="sub-menu">
        <a href="javascript:;" >
            <i class="fa fa-plus-circle"></i><span>สร้างการนัดหมาย</span>

        </a>
    </li>
    <li class="sub-menu">
        <a href="javascript:;" >
            <i class="fa fa-pencil-square"></i><span>การนัดหมาย</span>
        </a>
    </li>
@endsection

@section('content')
  <div class="row mt">
    <div class="col-lg-12">
        <div class="form-panel">
          <div class="container-fluid">
            <div class="container">
            <h4 class="mb"><i class="fa fa-angle-right"></i> &nbsp;ข้อมูลทั่วไป</h4>

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
                  <label class="col-sm-2 col-sm-2 control-label">เพศ</label>
                  <div class="col-sm-5">
                      <input type="text" class="form-control" value="{{$patients->gender}}" readonly>
                  </div>
          </div>
          <div class="form-group">
                  <label class="col-sm-2 col-sm-2 control-label">รหัสประจำตัวประชาชน</label>
                  <div class="col-sm-5">
                      <input type="text" class="form-control" value="{{$patients->idNumber}}" readonly>
                  </div>
          </div>
          <div class="form-group">
                  <label class="col-sm-2 col-sm-2 control-label">วันเกิด</label>
                  <div class="col-sm-5">
                      <input type="text" class="form-control" value="{{$patients->birthDate}}" readonly>
                  </div>
          </div>
          <div class="form-group">
                  <label class="col-sm-2 col-sm-2 control-label">ที่อยู่</label>
                  <div class="col-sm-5">
                      <input type="text" class="form-control" value="{{$patients->address}}" readonly>
                  </div>
          </div>
          <div class="form-group">
                  <label class="col-sm-2 col-sm-2 control-label">เบอร์โทรศัพท์</label>
                  <div class="col-sm-5">
                      <input type="text" class="form-control" value="{{$patients->phoneNumber}}" readonly>
                  </div>
          </div>
          <div class="form-group">
                  <label class="col-sm-2 col-sm-2 control-label">อีเมล</label>
                  <div class="col-sm-5">
                      <input type="text" class="form-control" value="{{$patients->email}}" readonly>
                  </div>
          </div>
          <div class="form-group">
                  <label class="col-sm-2 col-sm-2 control-label">กรุ๊ปเลือด</label>
                  <div class="col-sm-5">
                      <input type="text" class="form-control" value="{{$patients->bloodType}}" readonly>
                  </div>
          </div>
          <div class="form-group">
                  <label class="col-sm-2 col-sm-2 control-label">ประวัติการแพ้ยา</label>
                  <div class="col-sm-5">
                      <input type="text" class="form-control" value="{{$patients->allergen}}" readonly>
                  </div>
          </div>
          <form class="form-horizontal style-form" action="myEditedPatientInformation" method="post">
              <input type="hidden" name="userId" value="{{$patients->userId}}">
              <input type="hidden" name="_token" value="{{ csrf_token() }}">
              <button type="submit" class="btn btn-primary pull-right"> แก้ไข</button>
          </form>
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
