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

                                <div class ="form-group">
                                      <label class="col-sm-2 control-label">เลือกหมอ</label>
                                      <div id = "doctor" class="col-sm-10 radio">
                                          <label class="col-sm-4">
                                            <input type="radio" name="doctorId" value="0"> random
                                          </label>
                                          <label class="col-sm-4">
                                            <input type="radio" name="doctorId" value="1"> Dr. A
                                          </label>
                                          <label class="col-sm-4">
                                            <input type="radio" name="doctorId" value="2"> Dr. B
                                          </label>
                                          <label class="col-sm-4">
                                            <input type="radio" name="doctorId" value="3"> Dr. C
                                          </label>
                                          <label class="col-sm-4">
                                            <input type="radio" name="doctorId" value="4"> Dr. D
                                          </label>
                                      </div>
                                </div>

                                <div class="form-group">
                                  <label class="col-sm-2 control-label">เลือกวัน</label>
                                  <div class="col-sm-10">
                                    <input class="form-control" type="text" id="datepicker" >
                                  </div>

                                </div>

                                <div class="form-group">
                                  <label class="col-sm-2 control-label">เลือกช่วงเวลา</label>
                                  <div class="col-sm-10 radio">
                                    <label class="col-sm-4">
                                      <input type="radio" name="period" value="1"> เช้า
                                    </label>
                                    <label class="col-sm-4">
                                      <input type="radio" name="period" value="2"> บ่าย
                                    </label>
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

$(function() {
  $( "#datepicker" ).datepicker({
              dateFormat: 'dd-mm-yy'
          }).val(getTodaysDate(0));
    })
    function getTodaysDate (val) {
    var t = new Date, day, month, year = t.getFullYear();
    if (t.getDate() < 10) {
        day = "0" + t.getDate();
    }
    else {
        day = t.getDate();
    }
    if ((t.getMonth() + 1) < 10) {
        month = "0" + (t.getMonth() + 1 - val);
    }
    else {
        month = t.getMonth() + 1 - val;
    }

    return (day + '/' + month + '/' + year);
   }
</script>

@endsection
