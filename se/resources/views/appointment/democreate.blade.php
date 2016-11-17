@extends('layouts.theme')
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
                                        <textarea class="form-control" rows="5" name="symptom"></textarea>
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
                                          <div class="col-sm-4">
                                            <img src="https://image.freepik.com/free-icon/question-mark_318-52837.jpg" class="img-responsive center-block"  ><br />
                                            <input type="radio" name="doctorId" value="0"> random &nbsp;&nbsp;
                                          </div>
                                          <div class="col-sm-4">
                                            <img src="http://orientalbalance.com/wp-content/uploads/2014/08/doctor.jpg" class="img-responsive center-block"  ><br />
                                            <input type="radio" name="doctorId" value="0"> Dr. A &nbsp;&nbsp;
                                          </div>
                                          <div class="col-sm-4">
                                            <img src="http://pngimg.com/upload/doctor_PNG15959.png" class="img-responsive center-block"  ><br />
                                            <input type="radio" name="doctorId" value="0"> Dr. B &nbsp;&nbsp;
                                          </div>
                                          <div class="col-sm-4">
                                            <img src="http://www.apollonion.com/assets/image/imagesplashdoc/women-img0001.png" class="img-responsive center-block"  ><br />
                                            <input type="radio" name="doctorId" value="0"> Dr. C &nbsp;&nbsp;
                                          </div>
                                          <div class="col-sm-4">
                                            <img src="http://ichef-1.bbci.co.uk/news/660/media/images/76055000/jpg/_76055361_482566485.jpg" class="img-responsive center-block"  ><br />
                                            <input type="radio" name="doctorId" value="0"> Dr. D &nbsp;&nbsp;
                                          </div>
                                        </span><!-- /input-group -->
                                      </div>
                                </div>

                                <div class="form-group">
                                  <label class="col-sm-2 control-label">เลือกวัน</label>
                                  <div class="col-sm-10">
                                    <input class="form-control" type="text" id="datepicker">
                                  </div>

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

<script>
$( function() {
  $( "#datepicker" ).datepicker();
} );
</script>

@endsection
