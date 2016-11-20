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
            <h4 class="mb"><i class="fa fa-angle-right"></i> &nbsp;ข้อมูลทั่วไป</h4>
              <div class="container-fluid">

            <form class="form-horizontal style-form" action="findPatientFromHnIdNameForVitalSign" method="post">
                <input type="hidden" name="userId" value="{{$patients->userId}}">
                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                <button type="submit" class="btn btn-primary pull-right"> ดูอาการทั่วไป</button>
            </form>
            <form class="form-horizontal style-form" action="findPatientFromHnIdNameForDiagnosis" method="post">
                <input type="hidden" name="userId" value="{{$patients->userId}}">
                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                <button type="submit" class="btn btn-primary pull-right"> ดูข้อมูลวินิจฉัย</button>
            </form>

              </div>
			<form class="form style-form" action="{{url('/searchPatientInformation')}}" method="post">
            <div class="form-group">
            <div class="container-fluid">
                <label class="col-sm-2 control-label">เลขประจำตัวผู้ป่วย</label>
                	<div class="col-lg-5">
                        <p class="form-control-label">{{$patients->hn}}</p>
                    </div>
            </div>
            <div class="container-fluid">
                <label class="col-sm-2 control-label">ชื่อ</label>
               		<div class="col-lg-5">
                        <p class="form-control-label">{{$patients->firstname}}</p>
                    </div>
            </div>
            <div class="container-fluid">
                <label class="col-sm-2 control-label">นามสกุล</label>
                	<div class="col-lg-5">
                  		<p class="form-control-label">{{$patients->lastname}}</p>
                	</div>
            </div>
           <div class="container-fluid">
                <label class="col-sm-2 control-label">เพศ</label>
                	<div class="col-lg-5">
                        <p class="form-control-label">{{$patients->gender}}</p>
                    </div>
            </div>
            <div class="container-fluid">
                <label class="col-sm-2 control-label">วันเกิด</label>
             		<div class="col-lg-5">
                        <p class="form-control-label">{{$patients->birthDate}}</p>
                    </div>
            </div>

            <div class="container-fluid">
                <label class="col-sm-2 control-label">ที่อยู่</label>
                	<div class="col-lg-5">
                        <p class="form-control-label">{{$patients->address}}</p>
                    </div>
            </div>
            <div class="container-fluid">
                <label class="col-sm-2 control-label">เบอร์โทรศัพท์</label>
                	<div class="col-lg-5">
                        <p class="form-control-label">{{$patients->phoneNumber}}</p>
                    </div>
            </div>
           <div class="container-fluid">
                <label class="col-sm-2 control-label">อีเมล</label>
                	<div class="col-lg-5">
                        <p class="form-control-label">{{$patients->email}}</p>
                    </div>
            </div>
            <div class="container-fluid">
                <label class="col-sm-2 control-label">กรุ๊ปเลือด</label>
                	<div class="col-lg-5">
                        <p class="form-control-label">{{$patients->bloodType}}</p>
            		</div>
			</div>
            <div class="container-fluid">
                <label class="col-sm-2 control-label">ประวัติการแพ้ยา</label>
                	<div class="col-lg-5">
                        <p class="form-control-label">{{$patients->allergen}}</p>
                    </div>
            </div>

            </div>
        </form>

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
