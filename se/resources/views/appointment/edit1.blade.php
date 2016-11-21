@extends('layouts.theme')
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
<link href="{{ url('assets/css/bootstrap-datepicker3.min.css')}}" rel="stylesheet">
<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<script src="https://code.jquery.com/jquery-1.12.4.js"></script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
@section('name')
  นายแพทย์
@endsection

@section('leftnav')
  <li class="sub-menu">
    <a href="javascript:;" >
      <i class="fa fa-calendar"></i><span>ตารางวันและเวลา</span>
    </a>
  </li>

  <li class="sub-menu">
    <a class="active" href="javascript:;" >
      <i class="fa fa-plus-circle"></i><span>สร้างการนัดหมาย</span>
    </a>
  </li>

  <li class="sub-menu">
    <a href="javascript:;" >
      <i class="fa fa-pencil-square"></i><span>การนัดหมาย</span>
    </a>
  </li>

  <li class="sub-menu">
    <a href="javascript:;" >
      <i class="fa fa-heart"></i><span>บันทึกคำวินิจฉัยและใบสั่งยา</span>
    </a>
  </li>

  <li class="sub-menu">
    <a href="javascript:;" >
      <i class="fa fa-group"></i><span>ข้อมูลผู้ป่วย</span>
    </a>
  </li>

  <li class="sub-menu">
    <a href="javascript:;" >
      <i class="fa fa-plus-square"></i><span>จ่ายยา</span>
    </a>
  </li>
@endsection


@section('content')
	<!-- BASIC FORM ELELEMNTS -->
  <div class="row mt">
    <div class="col-lg-12">
        <div class="form-panel">
          <div class="container-fluid">
                <h4 class="mb"><i class="fa fa-angle-right"></i> เเก้ไขการนัดหมาย</h4>
                  <!-- Open Form -->
                {!! Form::model($appointment, array('url' => 'appointment/'.$appointment->appointmentId, 'method' => 'post')) !!}
                {{csrf_field()}}
                  <div class="form-group">
                        <label class="col-sm-2 text-right">เเผนก</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" value="{{$appointment->doctor->department->departmentName}}" readonly>
                        </div>
                  </div>

                   name="appDate"
                   
                  <input type="hidden"  name="appointmentId" value="{{$appointment->appointmentId}} ">
                  <input type="hidden" id="doctor" value="{{$appointment->doctor->doctorId}}">
                  <input type="hidden" id="department" value="{{$appointment->doctor->department->departmentId}}">

                  <div class="form-group">
                        <label class="col-sm-2 text-right">ชื่อหมอ</label>
                        <div class="col-sm-10">
                          <input type="text" class="form-control" value="{{$appointment->doctor->user->firstname}} {{$appointment->doctor->user->lastname}}" readonly>
                        </div>
                  </div>

                  <div class="form-group">
                        <label class="col-sm-2 text-right">อาการ</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" value="{{$appointment->symptom}}" readonly>
                        </div>
                  </div>

                  <div class="form-group">
                        <label class="col-sm-2 text-right">วันที่นัดเก่า</label>
                        <div class="col-sm-10">
                            <input type="text" id="dateold" class="form-control" value="{{$appointment->appDate}}" readonly>
                        </div>
                  </div>

                  <div class="form-group">
                        <label class="col-sm-2 text-right">ช่วงเวลาที่นัดเก่า</label>
                        <div class="col-sm-10">
                            @if($appointment->appTime == "13:00:00")
                                <input type="text" id="timeold" class="form-control" value="ช่วงบ่าย" readonly>
                            @else
                                <input type="text" id="timeold" class="form-control" value="ช่วงเช้า" readonly>
                            @endif
                        </div>
                  </div>

                  <div class="form-group">
                        <label class="col-sm-2 text-right">เลือกวันใหม่</label>
                        <div class="col-sm-10" id = "date">
                            <input class="form-control" type="text" id="datepicker" name="appDate">
                        </div>
                  </div>

                  <div class="form-group">
                        <label class="col-sm-2 text-right">เลือกช่วงเวลาใหม่</label>
                        <div class="col-sm-10 radio" id = "time">
                            <input class="form-control" type="text" id="datepicker" name="appDate">
                        </div>
                  </div>


                  <div class = "form-group">
                      <div class = "col-sm-10">
                          {{ form::submit('บันทึก', ["class" => 'btn btn-primary'])  }} 
                          <a href = "{{url('appointment')}}" class="btn btn-primary">back</a>
                      </div>
                  </div>                      
                {!! Form::close() !!}
              </div>
            </div>
        </div>
    </div>
</div>
</div>


<script>

var fastestdate;
  $( function() {
    queryDoctorDateTime();
  } );

   function queryDoctorDateTime() {
        console.log($('#doctor').val());
        console.log($('#department').val());
        $.ajax({
            url: "/queryDoctorDateTime",
            data: {
              id: $('#doctor').val(),
              departmentId: $('#department').val()
            },
            success: function( result ) {
                console.log(result)
                $("#date").empty();
                $("#time").empty();
                fastestdate = result[7][1];
                //$("#date").append('<input type="date" value="' + result[7][1] + '" name="bday">');
                $("#date").append('<label class="col-sm-4">');
                $("#date").append('<input class="form-control" type="text" id="datepicker" name="appDate">');
                if(result[8][1] == "1"){
                  $("#time").append('<label class="col-sm-4">');
                  $("#time").append('<input type="radio" name="appTime" value="1" checked="checked"> เช้า<br>');
                  $("#time").append('</label>');
                  $("#time").append('<label class="col-sm-4">');
                  $("#time").append('<input type="radio" name="appTime" value="2" disabled> บ่าย<br>');
                  $("#time").append('</label>');
                }else if(result[8][1] == "2"){
                  $("#time").append('<label class="col-sm-4">');
                  $("#time").append('<input type="radio" name="appTime" value="1" disabled> เช้า<br>');
                  $("#time").append('</label>');
                  $("#time").append('<label class="col-sm-4">');
                  $("#time").append('<input type="radio" name="appTime" value="2" checked="checked"> บ่าย<br>');
                  $("#time").append('</label>');
                }else if(result[8][1] == "3"){
                  $("#time").append('<label class="col-sm-4">');
                  $("#time").append('<input type="radio" name="appTime" value="1" checked="checked"> เช้า<br>');
                  $("#time").append('</label>');
                  $("#time").append('<label class="col-sm-4">');
                  $("#time").append('<input type="radio" name="appTime" value="2"> บ่าย<br>');
                  $("#time").append('</label>');
                }
                //<label class="col-sm-2 control-label">เลือกวัน</label>
                //<input class="form-control" type="text" id="datepicker" >
                myFunction(result,fastestdate);
            }
          });
   }

function myFunction(params,fastestdate) {
        $( "#datepicker" ).datepicker({
              dateFormat: 'yy-mm-dd',
              maxDate: "+1y",
              minDate: fastestdate,
              beforeShowDay: function(date){
                var day = date.getDay();
                var dd = date.getDate();
                var mm = date.getMonth()+1;
                var yy = date.getFullYear();
                var thisDate = yy+'-'+mm+'-'+dd;
                var arrayOfDisabledDates = params[9];
                if(arrayOfDisabledDates.indexOf(thisDate)!=-1) return false;
                return [(day == params[5][1] || day == params[3][1] || day == params[1][1] || day == params[0][1] || day == params[2][1] || day == params[4][1] || day == params[6][1]), ''];
              },
              onSelect: function(date) {
                 $.ajax({
                    url: "/queryPeriod",
                    data: {
                      id: $('#doctor').val(),
                      day : $("#datepicker").datepicker( "getDate" ).getDay(),
                      date : $("#datepicker").datepicker( "getDate" ).getDate(),
                      month : $("#datepicker").datepicker( "getDate" ).getMonth()+1,
                      year : $("#datepicker").datepicker( "getDate" ).getFullYear()
                    },
                    success: function( result ) {
                      console.log(result)
                      $("#time").empty();
                      //$("#date").append('<input type="date" value="' + result[7][1] + '" name="bday">');
                      if(result == "1"){
                        $("#time").append('<input type="radio" name="appTime" value="1" checked="checked"> เช้า<br>');
                        $("#time").append('<input type="radio" name="appTime" value="2" disabled> บ่าย<br>');
                      }else if(result == "2"){
                        $("#time").append('<input type="radio" name="appTime" value="1" disabled> เช้า<br>');
                        $("#time").append('<input type="radio" name="appTime" value="2" checked="checked"> บ่าย<br>');
                      }else if(result  == "3"){
                        $("#time").append('<input type="radio" name="appTime" value="1" checked="checked"> เช้า<br>');
                        $("#time").append('<input type="radio" name="appTime" value="2"> บ่าย<br>');
                      }
                    }
                });
              }
        }).val(fastestdate);
}
</script>

@endsection
