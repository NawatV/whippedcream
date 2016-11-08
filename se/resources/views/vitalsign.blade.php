@extends('layouts.theme')

@section('name')
  Mr. Someone
@endsection

@section('content')
<h4 class="mb"><i class="fa fa-angle-right"></i> &nbsp;บันทึกอาการทั่วไป</h4>

<form class="form-horizontal" action="{{url('/vitalsign')}}" method="post">
  <input type="hidden" name="_token" value="{{csrf_token()}}">
  <div class="form-group">
    <label class="col-sm-2 control-label">HN</label>
    <div class="col-sm-4">
      <input type="text" class="form-control" name="hn">
    </div>
  </div>

  <div class="form-group">
    <label class="col-sm-2 control-label">ชื่อ</label>
    <div class="col-sm-4">
      <input type="text" class="form-control" name="firstname">
    </div>
    <label class="col-sm-2 control-label">นามสกุล</label>
    <div class="col-sm-4">
      <input type="text" class="form-control" name="lastname">
    </div>
  </div>

  <div class="form-group">
    <label class="col-sm-2 control-label">น้ำหนัก</label>
    <div class="col-sm-4">
      <input type="text" class="form-control" name="weight">
    </div>
    <label class="col-sm-2 control-label">ส่วนสูง</label>
    <div class="col-sm-4">
      <input type="text" class="form-control" name="height">
    </div>
  </div>

  <div class="form-group">
    <label class="col-sm-2 control-label">อุณหภูมิ</label>
    <div class="col-sm-4">
      <input type="text" class="form-control" name="temperature">
    </div>
    <label class="col-sm-2 control-label">ชีพจร</label>
    <div class="col-sm-4">
      <input type="text" class="form-control" name="pulse">
    </div>
  </div>

  <div class="form-group">
    <label class="col-sm-2 control-label">ความดันโลหิต Systolic</label>
    <div class="col-sm-4">
      <input type="text" class="form-control" name="systolic">
    </div>
    <label class="col-sm-2 control-label">ความดันโลหิต Diastolic</label>
    <div class="col-sm-4">
      <input type="text" class="form-control" name="diastolic">
    </div>
  </div>

  <div class="mt">
    <input type="submit" class="btn btn-primary pull-right" value="บันทึก">
  </div>

</form>
@endsection
