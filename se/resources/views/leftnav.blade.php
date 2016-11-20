@if(session('userType') == 'patient')
  <li class="sub-menu">
    <a class="leftnav" href="javascript:;" >
      <i class="fa fa-info-circle"></i><span>ข้อมูลส่วนตัว</span>
    </a>
  </li>

  <li class="sub-menu">
    <a class="leftnav" href="javascript:;" >
      <i class="fa fa-calendar-plus-o"></i><span>สร้างการนัดหมาย</span>
    </a>
  </li>

  <li class="sub-menu">
    <a class="leftnav" href="javascript:;" >
      <i class="fa fa-calendar-check-o"></i><span>รายการนัดหมาย</span>
    </a>
  </li>
@elseif(session('userType') == 'nurse')
  <li class="sub-menu">
    <a class="leftnav" href="javascript:;" >
      <i class="fa fa-calendar-check-o"></i><span>รายการนัดหมาย</span>
    </a>
  </li>

  <li class="sub-menu">
    <a class="leftnav" href="{{url('/vitalsign')}}" >
      <i class="fa fa-pencil-square-o"></i><span>บันทึกอาการทั่วไป</span>
    </a>
  </li>

  <li class="sub-menu">
    <a class="leftnav" href="javascript:;" >
      <i class="fa fa-info-circle"></i><span>ข้อมูลผู้ป่วย</span>
    </a>
  </li>
@elseif(session('userType') == 'doctor')
  <li class="sub-menu">
    <a class="leftnav" href="javascript:;" >
      <i class="fa fa-calendar"></i><span>ตารางวันและเวลาออกตรวจ</span>
    </a>
  </li>

  <li class="sub-menu">
    <a class="leftnav" href="javascript:;" >
      <i class="fa fa-calendar-check-o"></i><span>รายการนัดหมาย</span>
    </a>
  </li>

  <li class="sub-menu">
    <a class="leftnav" href="{{url('/diagnosis')}}" >
      <i class="fa fa-pencil-square-o"></i><span>บันทึกคำวินิจฉัยและสั่งยา</span>
    </a>
  </li>

  <li class="sub-menu">
    <a class="leftnav" href="javascript:;" >
      <i class="fa fa-info-circle"></i><span>ข้อมูลผู้ป่วย</span>
    </a>
  </li>
@elseif(session('userType') == 'pharmacist')
  <li class="sub-menu">
    <a class="leftnav" href="{{url('/dispensation')}}" >
      <i class="fa fa-plus-square"></i><span>จ่ายยา</span>
    </a>
  </li>

  <li class="sub-menu">
    <a class="leftnav" href="javascript:;" >
      <i class="fa fa-info-circle"></i><span>ข้อมูลผู้ป่วย</span>
    </a>
  </li>
@elseif(session('userType') == 'staff')
  <li class="sub-menu">
    <a class="leftnav" href="javascript:;" >
      <i class="fa fa-info-circle"></i><span>ข้อมูลผู้ป่วย</span>
    </a>
  </li>

  <li class="sub-menu">
    <a class="leftnav" href="javascript:;" >
      <i class="fa fa-calendar-plus-o"></i><span>สร้างการนัดหมาย</span>
    </a>
  </li>

  <li class="sub-menu">
    <a class="leftnav" href="javascript:;" >
      <i class="fa fa-calendar-plus-o"></i><span>สร้างการนัดหมายแบบ Walk In</span>
    </a>
  </li>

  <li class="sub-menu">
    <a class="leftnav" href="javascript:;" >
      <i class="fa fa-calendar-check-o"></i><span>รายการนัดหมาย</span>
    </a>
  </li>
@endif
