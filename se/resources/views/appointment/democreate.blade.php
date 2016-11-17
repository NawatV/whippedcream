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
  <div class="row mt">
    <div class="col-lg-12">
        <div class="form-panel">
          <div class="container-fluid">
                <h4 class="mb"><i class="fa fa-angle-right"></i> สร้างการนัดหมาย</h4>
                        <!-- Open Form -->
                  <form class="form-horizontal style-form" method="post" action="{{url('/appointment')}}">
                      <input type="hidden" name="_token" value="{{csrf_token()}}">
                                <div class="form-group">
                                      <label class="col-sm-2 control-label">SSN/HN</label>
                                      <div class="col-sm-10">
                                        <input type="text" class="form-control" name="symptom">
                                      </div>
                                </div>

                                <div class="form-group">
                                      <label class="col-sm-2 control-label">อาการ</label>
                                      <div class="col-sm-10">
                                        <input type="text" class="form-control" name="symptom">
                                      </div>
                                </div>

                                <div class="form-group">
                                  <label class="col-sm-2 control-label">เลือกแผนก</label>
                                    <div class="col-sm-10">
                                      <select class="form-control" id = "department" name = "departmentId">
                                        <option selected disabled>แผนก</option>
                                        <option value="1">test1</option>
                                        <option value="2">test2</option>
                                        <option value="3">test3</option>
                                      </select>
                                    </div>
                                </div>

                                <div class = "form-group">
                                      <label class="col-sm-2 control-label">เลือกหมอ</label>
                                      <div id = "doctor" class="col-sm-10">
                                        <span class="input-group-addon">
                                          <div class="col-sm-3">
                                            <img src="http://www.w3schools.com/images/w3schools_green.jpg"><br />
                                            <input type="radio" name="doctorId" value="0"> random &nbsp;&nbsp;
                                          </div>
                                          <div class="col-sm-3">
                                            <img src="http://www.w3schools.com/images/w3schools_green.jpg"><br />
                                            <input type="radio" name="doctorId" value="0"> random &nbsp;&nbsp;
                                          </div>
                                          <div class="col-sm-3">
                                            <img src="http://www.w3schools.com/images/w3schools_green.jpg"><br />
                                            <input type="radio" name="doctorId" value="0"> random &nbsp;&nbsp;
                                          </div>
                                          <div class="col-sm-3">
                                            <img src="http://www.w3schools.com/images/w3schools_green.jpg"><br />
                                            <input type="radio" name="doctorId" value="0"> random &nbsp;&nbsp;
                                          </div>
                                          <div class="col-sm-3">
                                            <img src="http://www.w3schools.com/images/w3schools_green.jpg"><br />
                                            <input type="radio" name="doctorId" value="0"> random &nbsp;&nbsp;
                                          </div>
                                        </span><!-- /input-group -->
                                      </div>
                                </div>

                                <div class="form-group">
                                  <label class="col-sm-2 control-label">เลือกวัน</label>
                                  <input type="date" value="2013-01-08" name="bday">
                                </div>

                                <div class="form-group">
                                  <label class="col-sm-2 control-label">เลือกช่วงเวลา</label>
                                  <div class="col-sm-10">
                                    <select class="form-control" id = "department" name = "departmentId">
                                          <option value="1">เช้า</option>
                                          <option value="2"  selected>บ่าย</option>
                                    </select>
                                  </div>
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
@endsection
