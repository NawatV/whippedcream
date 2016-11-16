@extends('adminTemplate')
@section('main-content')
<!--create-account-form-panel is new-->
@if(Session::get('create_dep_error') == 1)
<div id="error-popup" class="admin-popup-position-dont-hide" style="z-index: 2">
  <div id="admin-error-popup-wrapper">
    <div id="admin-error-popup-container" align="center">
      <div style="font-size: 18px; float: right; position: relative; left: 10px">
        <a href="#" onclick="toggle_visibility('error-popup');" style="text-decoration: none">
          <i class="fa fa-times-circle"></i>
        </a>
      </div>
      <p style="font-size: 120px; color: #f4d442"><i class="fa fa-info-circle"></i></p>
      <h4 style="position: relative; bottom: 26px"> กรุณากรอกข้อมูลให้ครบถ้วน </h4>
    </div>  </div>
</div>
@endif
@if(Session::get('create_dep_error') == 2)
<div id="error-popup" class="admin-popup-position-dont-hide" style="z-index: 2">
  <div id="admin-error-popup-wrapper">
    <div id="admin-error-popup-container" align="center">
      <div style="font-size: 18px; float: right; position: relative; left: 10px">
        <a href="#" onclick="toggle_visibility('error-popup');" style="text-decoration: none">
          <i class="fa fa-times-circle"></i>
        </a>
      </div>
      <p style="font-size: 120px; color: #ed5565"><i class="fa fa-exclamation-circle"></i></p>
      <h4 style="position: relative; bottom: 26px"> แผนกนี้มีอยู่ในระบบอยู่แล้ว </h4>
    </div>  </div>
</div>
@endif
<div class="create-account-form-panel">
  <h4 class="ml mb"><i class="fa fa-angle-right"></i> สร้างแผนก</h4>
  <form class="form-horizontal style-form" method="post" action="/createDepartment">
  	<input type="hidden" name="_token" value="{{ csrf_token() }}">
    <div class="row form-group">
      <div class="col-xs-12 col-lg-12" align="left" style="padding-left: 5px">
        <label class="col-xs-1 col-lg-1 control-label">ชื่อแผนก</label>
        <div class="col-sm-7">
          <input type="text" class="form-control" name="departmentName">
        </div>
      </div>
    </div>
    <div class="row form-group">
      <div class="col-xs-12 col-lg-12" align="left" style="padding-left: 5px">
        <label class="col-xs-1 col-lg-1 control-label">สถานที่</label>
        <div class="col-sm-7">
          <input type="text" class="form-control" name="location">
        </div>
      </div>
    </div>
    <div class="row form-group">
      <div class="col-xs-12 col-lg-12" align="center">
        <button type="submit" class="btn btn-theme04 btn-lg">สร้างแผนก</button>
      </div>
    </div>
  </form>
</div>
@stop
