@extends('layouts.theme')
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>

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

                <select id = "department">
                      <option selected disabled>Choose Department</option>
                      @foreach ($departments as $department)
                          <option value="{{$department -> departmentId}}">{{$department -> departmentName}}</option>
                      @endforeach  
                </select>

                <div class = "panel-body">
                    <form class="form-horizontal style-form" method="post" action="{{url('/appointment')}}">
                      <input type="hidden" name="_token" value="{{csrf_token()}}">

                      <div class="form-group">
                            <label class="col-sm-2 control-label">อาการ</label>
                            <input type="text" class="form-control" name="symptom">
                      </div>

                      <div class = "form-group">
                        <div id = "doctor">
                          <input type="radio" name="doctorId" value="2"> 1<br>
                          <input type="radio" name="doctorId" value="3"> 2<br>
                          <input type="radio" name="doctorId" value="5"> 3
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
  <script>
var tmp; 


  $(document).ready(function(){
    $("select").change(function(){
        $.ajax({
          url: "/queryDoctor",
          data: {
            id: $('#department :selected').val()
          },
          success: function( result ) {
            console.log(result)
            $("#doctor").empty();
            $("#doctor").append('<input type="radio" name="doctorId" value="0"> random<br>');
            //ocument.getElementById("demo").innerHTML = result;
            for (i = 0; i < result.length; i++) {
                tmp = '<input type="radio" name="doctorId" value="' + result[i][0] + '">' + result[i][1] + " " 
                + result[i][2] + '<br>';
                
                $("#doctor").append(tmp);
            }
          }
        });
    });
  });
</script>

@endsection
