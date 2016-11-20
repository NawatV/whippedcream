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
            <h4 class="mb"><i class="fa fa-angle-right"></i> &nbsp;ดูอาการทั่วไป&nbsp;&nbsp;{{$patients->firstname}}&nbsp;{{$patients->lastname}} </h4>


                <div class="form-horizontal style-form">
                    <div class="form-group">
                            <label class="col-sm-2 col-sm-2 control-label">น้ำหนัก</label>
                            <div class="col-sm-5">
                                <input type="text" class="form-control" value="{{$patients->weight}}" readonly>
                            </div>
                    </div>
                    <div class="form-group">
                            <label class="col-sm-2 col-sm-2 control-label">ส่วนสูง</label>
                            <div class="col-sm-5">
                                <input type="text" class="form-control" value="{{$patients->height}}" readonly>
                            </div>
                    </div>
                    <div class="form-group">
                            <label class="col-sm-2 col-sm-2 control-label">อุณหภูมิ</label>
                            <div class="col-sm-5">
                                <input type="text" class="form-control" value="{{$patients->temperature}}" readonly>
                            </div>
                    </div>
                    <div class="form-group">
                            <label class="col-sm-2 col-sm-2 control-label">ชีพจร</label>
                            <div class="col-sm-5">
                                <input type="text" class="form-control" value="{{$patients->pulse}}" readonly>
                            </div>
                    </div>
                    <div class="form-group">
                            <label class="col-sm-2 col-sm-2 control-label">ความดัน Systolic</label>
                            <div class="col-sm-5">
                                <input type="text" class="form-control" value="{{$patients->systolic}}" readonly>
                            </div>
                    </div>
                    <div class="form-group">
                            <label class="col-sm-2 col-sm-2 control-label">ความดัน Diastolic</label>
                            <div class="col-sm-5">
                                <input type="text" class="form-control" value="{{$patients->diastolic}}" readonly>
                            </div>
                    </div>

                    <form class="form-horizontal style-form" action="editVitalSi" method="post">
                        <input type="hidden" name="userId" value="{{$patients->userId}}">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <button type="submit" class="btn btn-primary pull-right"> แก้ไข</button>
                    </form>
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
