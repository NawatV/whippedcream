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
                                      <option value="1">test1</option>
                                      <option value="2">test2</option>
                                      <option value="3">test3</option>
                                </select>
                              </div>

                              <div class = "form-group">
                                <div id = "doctor">
                                    <label class="col-sm-2 control-label">หมอ</label><br><br>
                                    <input type="radio" name="doctorId" value="0"> ทดสอบเพื่อทำfont1<br>
                                    <input type="radio" name="doctorId" value="1"> ทดสอบเพื่อทำfont2<br>
                                    <input type="radio" name="doctorId" value="3"> ทดสอบเพื่อทำfont3<br>
                                </div>
                              </div>


                              <div class="form-group">
                                <label class="col-sm-2 control-label">เลือกวัน</label>
                                <input type="date" value="2013-01-08" name="bday">
                              </div>

                              <div class="form-group">
                                <label class="col-sm-2 control-label">เลือกช่วงเวลา</label>
                                <select id = "department" name = "departmentId">
                                      <option value="1">เช้า</option>
                                      <option value="2"  selected>บ่าย</option>
                                </select>
                              </div>

                              <div class = "form-group">
                                  <div class = "col-sm-10">
                                      <input type="submit" class="btn btn-primary pull-right" value="บันทึก">
                                      <a href = "" class="btn btn-primary">back</a>
                                  </div>
                              </div>               
                          </form>
                        </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
