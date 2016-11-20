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
              <div class="container-fluid">



              </div>

            <div class="form-group">
            <div class="container-fluid">
                <label class="col-sm-2 control-label">ส่วนสูง</label>
                    <div class="col-lg-5">
                        <p class="form-control-label">{{$patients->height}}</p>
                    </div>
            </div>
            <div class="container-fluid">
                <label class="col-sm-2 control-label">น้ำหนัก</label>
                    <div class="col-lg-5">
                        <p class="form-control-label">{{$patients->weight}}</p>
                    </div>
            </div>
            <div class="container-fluid">
                <label class="col-sm-2 control-label">อุณหภูมิ</label>
                    <div class="col-lg-5">
                        <p class="form-control-label">{{$patients->pulse}}</p>
                    </div>
            </div>
           <div class="container-fluid">
                <label class="col-sm-2 control-label">อัตราเต้นของหัวใจ</label>
                    <div class="col-lg-5">
                        <p class="form-control-label">{{$patients->systolic}}</p>
                    </div>
            </div>
            <div class="container-fluid">
                <label class="col-sm-2 control-label">ความดัน Systolic</label>
                    <div class="col-lg-5">
                        <p class="form-control-label">{{$patients->diastolic}}</p>
                    </div>
            </div>

            <div class="container-fluid">
                <label class="col-sm-2 control-label">ความดัน Diastolic</label>
                    <div class="col-lg-5">
                        <p class="form-control-label">{{$patients->address}}</p>
                    </div>
            </div>


            </div>


        <a class="btn btn-primary pull-right" href="{{ url('/editpatientinformation') }}">แก้ไข</a>


          </div>
        </div>
    </div>
  </div>
@endsection

@section('special-content')

@endsection

@section('script')

@endsection
