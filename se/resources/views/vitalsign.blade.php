@extends('layouts.theme')

@section('css')
  <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">
@endsection

@section('name')
  {{$name}}
@endsection

@section('leftnav')
  <li class="sub-menu">
    <a href="javascript:;" >
      <i class="fa fa-calendar-check-o"></i><span>รายการนัดหมาย</span>
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

            <form class="form-horizontal style-form" action="{{url('/vitalsign')}}" method="post">
              <input type="hidden" name="_token" value="{{csrf_token()}}">
              <div class="form-group">
                <label class="col-sm-2 control-label">HN</label>
                <div class="col-sm-4">
                  <input type="text" class="form-control" name="hn" value="{{old('hn')}}">
                </div>
              </div>

              <div class="form-group">
                <label class="col-sm-2 control-label">ชื่อ</label>
                <div class="col-sm-4">
                  <input type="text" class="form-control" name="firstname" value="{{old('firstname')}}">
                </div>
                <label class="col-sm-2 control-label">นามสกุล</label>
                <div class="col-sm-4">
                  <input type="text" class="form-control" name="lastname" value="{{old('lastname')}}">
                </div>
              </div>

              <div class="form-group">
                <label class="col-sm-2 control-label">น้ำหนัก</label>
                <div class="col-sm-4">
                  <input type="text" class="form-control" name="weight" value="{{old('weight')}}">
                </div>
                <label class="col-sm-2 control-label">ส่วนสูง</label>
                <div class="col-sm-4">
                  <input type="text" class="form-control" name="height" value="{{old('height')}}">
                </div>
              </div>

              <div class="form-group">
                <label class="col-sm-2 control-label">อุณหภูมิ</label>
                <div class="col-sm-4">
                  <input type="text" class="form-control" name="temperature" value="{{old('temperature')}}">
                </div>
                <label class="col-sm-2 control-label">ชีพจร</label>
                <div class="col-sm-4">
                  <input type="text" class="form-control" name="pulse" value="{{old('pulse')}}">
                </div>
              </div>

              <div class="form-group">
                <label class="col-sm-2 control-label">ความดันโลหิต Systolic</label>
                <div class="col-sm-4">
                  <input type="text" class="form-control" name="systolic" value="{{old('systolic')}}">
                </div>
                <label class="col-sm-2 control-label">ความดันโลหิต Diastolic</label>
                <div class="col-sm-4">
                  <input type="text" class="form-control" name="diastolic" value="{{old('diastolic')}}">
                </div>
              </div>

              <div class="mt">
                <input type="submit" class="btn btn-primary pull-right" value="บันทึก">
              </div>
            </form>
          </div>
        </div>
    </div>
  </div>
@endsection

@section('special-content')
  <!-- Start Modal -->
  <div class="modal fade" tabindex="-1" role="dialog" id="error-modal">
    <div class="modal-dialog modal-md" role="document">
      <div class="modal-content">
        <div class="modal-header" style="border-radius:5px 5px 0 0; text-align:center">
          <h4 class="modal-title">ข้อผิดพลาด</h4>
        </div>
        <div class="modal-body" style="text-align:center; padding-left:11px; padding-right:11px">
          @if(count($errors) > 0)
            @foreach($errors->all() as $error)
              <h5>{{$error}}</h5>
            @endforeach
          @endif
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
      </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
  </div><!-- /.modal -->
  <!-- End Modal -->
@endsection

@section('script')
  @if(count($errors) > 0)
    <script>
      $('#error-modal').modal('toggle');
    </script>
  @endif
@endsection
