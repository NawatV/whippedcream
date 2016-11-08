@extends('layouts.theme')

@section('name')
  Mr. Someone
@endsection

@section('leftnav')
  <li class="sub-menu">
    <a href="javascript:;" >
      <i class="fa fa-calendar"></i><span>รายการนัดหมาย</span>
    </a>
  </li>

  <li class="sub-menu">
    <a class="active" href="{{url('/vitalsign')}}" >
      <i class="fa fa-pencil-square-o"></i><span>บันทึกอาการทั่วไป</span>
    </a>
  </li>

  <li class="sub-menu">
    <a href="javascript:;" >
      <i class="fa fa-info-circle"></i><span>ข้อมูลผู้ป่วย</span>
    </a>
  </li>
@endsection

@section('content')
  <div class="row mt">
    <div class="col-lg-12">
        <div class="form-panel">
          <div class="container-fluid">
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
                <input type="button" class="btn btn-primary" id="test" value="test">
              </div>
            </form>
          </div>
        </div>
    </div>
  </div>
@endsection

@section('special-content')
  <!-- Start Modal -->
  <div class="modal fade" tabindex="-1" role="dialog" id="myModal">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <h4 class="modal-title">Modal title</h4>
        </div>
        <div class="modal-body">
          <p>One fine body&hellip;</p>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
          <button type="button" class="btn btn-primary">Save changes</button>
        </div>
      </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
  </div><!-- /.modal -->
  <!-- End Modal -->
@endsection

@section('script')
  <script>
    $(document).ready(function(){
      $('#test').click(function(){
        $('#myModal').modal('toggle');
      });
    });
  </script>
@endsection
