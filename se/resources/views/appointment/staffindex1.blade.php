@extends('layouts.theme')
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
@section('name')
    {{session('name')}}
@endsection




@section('content')
    <!-- BASIC FORM ELELEMNTS -->
    <div class="panel-body appointmentTable">
        <div class="paddingFormCreate centered">
            <table class="table table-bordered">
                <tr>
                    <th>ชื่อผู้ป่วย</th>
                    <th>แพทย์ที่ต้องการพบ</th>
                    <th>วันที่</th>
                    <th>ช่วงเวลา</th>
                    <th>อาการ</th>
                    {{--<th>ปริ้นท์ใบนัดหมาย</th>--}}
                    <th>ปริ้นท์</th>
                    <th>ลบ</th>
                </tr>
                @foreach ($appointments as $appointment)
                    <tr>
                        <td>{{ $appointment -> patient -> user -> firstname }}</td>
                        <td>{{ $appointment -> doctor -> user -> firstname }}</td>
                        <td>{{ $appointment -> appDate }}</td>
                        <td>{{ $appointment -> appTime }}</td>
                        <td>{{ $appointment -> symptom }}</td>
                        <td>
                            <a href="{{ url('appointment/'.$appointment -> appointmentId.'/appointmentpdf') }}">
                                <i class="fa fa-print" style="font-size:30px"></i>
                            </a>
                        </td>
                        <td>
                            <form class="form-horizontal style-form" method="post"
                                  action="{{ url('deleteAppointment/'.$appointment -> appointmentId) }}">
                                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                <input type="submit" class="btn btn-danger btn-xs" value="ลบ">
                            </form>
                        </td>
                    </tr>
                @endforeach
            </table>
        </div>
    </div>
@endsection
