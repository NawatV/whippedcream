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
  <div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">New Appointment</div>

                        <!-- Open Form -->
                        <div class = "panel-body">
                            <form class="form-horizontal style-form" method="post" action="{{url('/appointment')}}">
                              <input type="hidden" name="_token" value="{{csrf_token()}}">

                              <div class="form-group">
                                    <label class="col-sm-2 control-label">SSN/HN</label>
                                    <input type="text" class="form-control" name="symptom">
                              </div>

                              <div class="form-group">
                                    <label class="col-sm-2 control-label">อาการ</label>
                                    <input type="text" class="form-control" name="symptom">
                              </div>

                              <div class="form-group">
                                <select id = "department" name = "departmentId">
                                      <option selected disabled>Choose Department</option>
                                      @foreach ($departments as $department)
                                          <option value="{{$department -> departmentId}}">{{$department -> departmentName}}</option>
                                      @endforeach
                                </select>
                              </div>

                              <div class = "form-group">
                                <div id = "doctor">
                                </div>
                              </div>

                              <div class = "form-group">
                                <div id = "date">
                                </div>
                              </div>

                              <div class="form-group">
                                <div id = "time">
                                </div>
                              </div>

                              <div class = "form-group">
                                  <div class = "col-sm-10">
                                      <input type="submit" class="btn btn-primary pull-right" value="บันทึก">
                                      <a href = "{{url('appointment')}}" class="btn btn-primary">back</a>
                                  </div>
                              </div>
                          </form>
                        </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>

  $(document).ready(function(){
    $("#department").change(function(){
        $.ajax({
            url: "/queryDoctor",
            data: {
              id: $('#department :selected').val()
            },
            success: function( result ) {
              console.log(result)
              $("#doctor").empty();
              $("#doctor").append('<input type="radio" name="doctorId" value="0" onclick="if(this.checked){queryDoctorDateTime()}"> random<br>');
              for (i = 0; i < result.length; i++) {
                  tmp = '<input type="radio" name="doctorId" value="' + result[i][0] + '"' + 'onclick="if(this.checked){queryDoctorDateTime()}">' + result[i][1] + " "
                  + result[i][2] + '<br>';

                  $("#doctor").append(tmp);
              }
            }
          });
     });

   });

   var fastestdate;
   function queryDoctorDateTime() {
        //console.log($('input[name=doctorId]:checked', '#doctor').val());
        $.ajax({
            url: "/queryDoctorDateTime",
            data: {
              id: $('input[name=doctorId]:checked', '#doctor').val(),
              departmentId: $('#department :selected').val()
            },
            success: function( result ) {
                console.log(result)
                $("#date").empty();
                $("#time").empty();
                fastestdate = result[7][1];
                //$("#date").append('<input type="date" value="' + result[7][1] + '" name="bday">');
                $("#date").append('<input class="form-control" type="text" id="datepicker" name="appDate">');
                if(result[8][1] == "1"){
                  $("#time").append('<input type="radio" name="appTime" value="1" checked="checked"> เช้า<br>');
                  $("#time").append('<input type="radio" name="appTime" value="2" disabled> บ่าย<br>');
                }else if(result[8][1] == "2"){
                  $("#time").append('<input type="radio" name="appTime" value="1" disabled> เช้า<br>');
                  $("#time").append('<input type="radio" name="appTime" value="2" checked="checked"> บ่าย<br>');
                }else if(result[8][1] == "3"){
                  $("#time").append('<input type="radio" name="appTime" value="1" checked="checked"> เช้า<br>');
                  $("#time").append('<input type="radio" name="appTime" value="2"> บ่าย<br>');
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

                if (date.getDate() == new Date("2016/11/26").getDate()) return false;

                return [(day == params[5][1] || day == params[3][1] || day == params[1][1] || day == params[0][1] || day == params[2][1] || day == params[4][1] || day == params[6][1]), ''];
              },
              onSelect: function(date) {
                 $.ajax({
                    url: "/queryPeriod",
                    data: {
                      id: $('input[name=doctorId]:checked', '#doctor').val(),
                      day : $( "#datepicker" ).datepicker( "getDate" ).getDay()
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
