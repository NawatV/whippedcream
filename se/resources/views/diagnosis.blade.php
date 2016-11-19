@extends('layouts.theme')

@section('css')
  <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">
@endsection

@section('name')
  MR.SOMEONE
@endsection

@section('leftnav')
  <li class="sub-menu">
    <a href="javascript:;" >
      <i class="fa fa-calendar"></i><span>ตารางวันและเวลาออกตรวจ</span>
    </a>
  </li>

  <li class="sub-menu">
    <a  href="javascript:;" >
      <i class="fa fa-calendar-check-o"></i><span>รายการนัดหมาย</span>
    </a>
  </li>

  <li class="sub-menu">
    <a class = "active"  href="{{url('diagnosis')}}" >
      <i class="fa fa-pencil-square-o"></i><span>บันทึกคำวินิจฉัยและสั่งยา</span>
    </a>
  </li>

  <li class="sub-menu">
    <a  href="javascript:;" >
      <i class="fa fa-info-circle"></i><span>ข้อมูลผู้ป่วย</span>
    </a>
  </li>
@endsection


@section('content')
  <div class="row mt">
    <div class="col-lg-12">
      <div class="form-panel">
        <div class="container-fluid">
          <h4 class="mb"><i class="fa fa-angle-right"></i> &nbsp;บันทึกคำวินิจฉัยและสั่งยา</h4>

          <form class="form-horizontal style-form" method="post" action="{{url('/diagnosis')}}">
            <input type="hidden" name="_token" value="{{csrf_token()}}">
            <div class="form-group">
              <label class="col-sm-2 control-label">HN</label>
              <div class="col-sm-4">
                <input type="text" class="form-control" name="hn">
              </div>
            </div>

            <div class="form-group">
              <label class="col-sm-2 control-label">ชื่อ</label>
              <div class="col-sm-4">
                <input type="text" class="form-control" name="firstname">
              </div>
              <label class="col-sm-2 control-label">นามสกุล</label>
              <div class="col-sm-4">
                <input type="text" class="form-control" name="lastname">
              </div>
            </div>

            <div class="form-group">
              <label class="col-sm-2 control-label">รหัสโรค</label>
              <div class="col-sm-4">
                <select class="form-control" name="symptomcode">
                  <option selected>ICD10</option>
                  <option>SNOWMED</option>
                  <option>DRG</option>
                </select>
              </div>
            </div>

            <div class="form-group">
              <label class="col-sm-2 control-label">รายละเอียดการวินิจฉัย</label>
              <div class="col-sm-10">
                <textarea class="form-control" rows="5" style="resize:vertical" name="details"></textarea>
              </div>
            </div>

            <div class="form-group drugGroup1">
              <label class="col-sm-2 control-label">ยา</label>
              <div class="col-sm-4">
                <select class="form-control" id="drug1" name="drug1">
                  <option disabled selected>-- Select Medicine --</option>
                  <option>Aspirin</option>
                  <option>Chlorpheniramine Maleate</option>
                  <option>Dimenhydrinate</option>
                  <option>Mebendazole</option>
                  <option>Paracetamol</option>
                  <option>Ponstan</option>
                </select>
              </div>

              <label class="col-sm-2 control-label">ปริมาณ</label>
              <div class="col-sm-4">
                <input type="text" class="form-control" id="quantity1" name="quantity1" disabled>
              </div>
            </div>

            <div class="form-group drugGroup1">
              <label class="col-sm-2 control-label">วิธีใช้</label>
              <div class="col-sm-10">
                <textarea class="form-control" rows="5" style="resize:vertical" id="usage1" name="usage1" disabled></textarea>
              </div>
            </div>

            <div class="form-group" id="inc-dec">
              <div class="col-sm-12">
                <button type="button" class="btn btn-danger pull-right ml" id="decrease">
                  <i class="fa fa-minus" aria-hidden="true"></i>&nbsp;&nbsp;ลดยา
                </button>

                <button type="button" class="btn btn-info pull-right" id="increase">
                  <i class="fa fa-plus" aria-hidden="true"></i>&nbsp;&nbsp;เพิ่มยา
                </button>
              </div>
            </div>

            <div class="mt">
              <input type="submit" class="btn btn-primary pull-right" value="บันทึก">
            </div>

          </form>
        </div>
      </div>
    </div>
  </div>
@endsection

@section('script')
  <script>
    $(document).ready(function(){

      $("form").change(function(event){
        var id = event.target.id;
        if(id.substr(0,4) == "drug"){
          var num = id.substr(4);
          $("#quantity"+ num).removeAttr("disabled");
          $("#usage"+ num).removeAttr("disabled");
        }
      });

      var index = 1;

      $("#increase").click(function(){
        ++index;
        $("#inc-dec").before("\
        <div class='form-group drugGroup"+index+"'>\
          <label class='col-sm-2 control-label'>ยา</label>\
          <div class='col-sm-4'>\
            <select class='form-control' id='drug"+index+"' name='drug"+index+"'>\
              <option disabled selected>-- Select Medicine --</option>\
              <option>Aspirin</option>\
              <option>Chlorpheniramine Maleate</option>\
              <option>Dimenhydrinate</option>\
              <option>Mebendazole</option>\
              <option>Paracetamol</option>\
              <option>Ponstan</option>\
            </select>\
          </div>\
          \
          <label class='col-sm-2 control-label'>ปริมาณ</label>\
          <div class='col-sm-4'>\
            <input type='text' class='form-control' id='quantity"+index+"' name='quantity"+index+"' disabled>\
          </div>\
        </div>\
        \
        <div class='form-group drugGroup"+index+"'>\
          <label class='col-sm-2 control-label'>วิธีใช้</label>\
          <div class='col-sm-10'>\
            <textarea class='form-control' rows='5' style='resize:vertical' id='usage"+index+"' name='usage"+index+"' disabled></textarea>\
          </div>\
        </div>\
        ");
      });

      $("#decrease").click(function(){
          $(".drugGroup"+index).remove();
          if(index >= 1) --index;
      });

    });
  </script>
@endsection
