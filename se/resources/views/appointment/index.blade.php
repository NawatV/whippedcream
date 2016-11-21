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
  <div class="panel-body">
    <table class="table table-bordered">
        <tr>
            <th>patient name</th>
            <th>doctor name</th>
            <th>date</th>
            <th>time</th>
            <th>symptom</th>
        </tr>
        @foreach ($appointments as $appointment)
            <tr>
                <td>{{ $appointment -> patient -> user -> firstname }}</td>
                <td>{{ $appointment -> doctor -> user -> firstname }}</td>
                <td>{{ $appointment -> appDate }}</td>
                <td>{{ $appointment -> appTime }}</td>
                <td>{{ $appointment -> symptom }}</td>
                <td>
                    <a href = "{{ url('appointment/'.$appointment -> appointmentId.'/edit') }}">เเก้ไข</a>
                    <form class="form-horizontal style-form" method="post" action="{{ url('deleteAppointment/'.$appointment -> appointmentId) }}">
                          <input type="hidden" name="_token" value="{{ csrf_token() }}">
                          <input type="submit" class="btn btn-primary pull-right" value="ลบ">
                          <input type="hidden" name="_token" value="{{csrf_token()}}">
                    </form>
                </td>
            </tr>
        @endforeach
    </table>
    <a href = "{{url('appointment/create')}}" class="btn btn-primary">เพิ่มข้อมูล</a>
  </div>
@endsection
