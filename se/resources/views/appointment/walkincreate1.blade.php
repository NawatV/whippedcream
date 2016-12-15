@extends('layouts.theme')
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
<link href="{{ url('assets/css/bootstrap-datepicker3.min.css')}}" rel="stylesheet">
<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<script src="https://code.jquery.com/jquery-1.12.4.js"></script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>


@section('name')
  {{session('name')}}
@endsection




@section('content')
    @if(count($errors)>0)
        <script>
            swal({
                title: "ไม่สามารถทำนัดได้",
                text: "กรุณาใส่ข้อมูลให้ครบและถูกต้องทุกช่อง",
                type: "error",
                confirmButtonColor: "#DD6B55",
                confirmButtonText: "แก้ไข",
                closeOnConfirm: true
            });
        </script>
    @endif
	<!-- BASIC FORM ELELEMNTS -->
  <div class="row mt">
    <div class="col-lg-12">
        <div class="form-panel">
          <div class="container-fluid">
                <h4 class="mb"><i class="fa fa-angle-right"></i> สร้างการนัดหมายเเบบwalk in</h4>
                        <!-- Open Form -->
                  <form class="form-horizontal style-form" method="post" action="{{url('/appointment/walkinstore')}}">
                      <input type="hidden" name="_token" value="{{csrf_token()}}">
                                <div class="form-group">
                                      <label class="col-sm-2 text-right">เลขรหัสโรงพยาบาล</label>
                                      <div class="col-sm-10">
                                        <input type="text" class="form-control" name="patientId">
                                      </div>
                                </div>

                                <div class="form-group">
                                      <label class="col-sm-2 text-right">อาการ</label>
                                      <div class="col-sm-10">
                                        <textarea class="form-control" rows="5" name="symptom"></textarea>
                                      </div>
                                </div>

                                <div class="form-group">
                                  <label class="col-sm-2 text-right">เลือกแผนก</label>
                                    <div class="col-sm-10">
                                      <select class="form-control" id = "department" name = "departmentId">
                                          <option selected disabled>แผนก</option>
                                          @foreach ($departments as $department)
                                              <option value="{{$department -> departmentId}}">{{$department -> departmentName}}</option>
                                          @endforeach
                                      </select>
                                    </div>
                                </div>

                                <div class ="form-group">
                                      <label class="col-sm-2 text-right">เลือกหมอ</label>
                                      <div id = "doctor" class="col-sm-10 radio">
                                      </div>
                                </div>

                                <div class="form-group">
                                  <label class="col-sm-2 text-right">เลือกวัน</label>
                                  <div class="col-sm-10" id = "date">
                                  </div>
                                </div>

                                <div class="form-group">
                                  <label class="col-sm-2 text-right">เลือกช่วงเวลา</label>
                                  <div class="col-sm-10 radio" id = "time">
                                  </div>
                                </div>

                                <div class = "form-group">
                                    <div class = "col-sm-10">
                                        <input type="submit" class="btn btn-primary pull-right" value="บันทึก">
                                        <a href = "" class="btn btn-primary">กลับ</a>
                                    </div>
                                </div>
                  </form>


          </div>
      </div>
  </div>
</div>

<script>

  $(document).ready(function(){
    $("#department").change(function(){
      //console.log($('#department :selected').val());
        $.ajax({
            url: "/queryDoctorWalkIn",
            data: {
              id: $('#department :selected').val()
            },
            success: function( result ) {
              console.log(result)
              $("#doctor").empty();
              for (i = 0; i < result.length; i++) {
                  tmp = '<input type="radio" name="doctorId" value="' + result[i][0] + '"' + 'onclick="if(this.checked){queryDoctorDateTime()}">' + result[i][1] + " "
                  + result[i][2] + '<br>';
                  $("#doctor").append('<label class="col-sm-4">');
                  $("#doctor").append(tmp);
                  $("#doctor").append('</label>');
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
              beforeShowDay: function(date){
                  var day = date.getDay();
                  var dd = date.getDate();
                  var mm = date.getMonth()+1;
                  var yy = date.getFullYear(); 
               }
        }).datepicker({ dateFormat: 'yy-mm-dd'}).datepicker("setDate", new Date());
}


</script>


@endsection
