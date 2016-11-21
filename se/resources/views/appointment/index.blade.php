@extends('layouts.theme')
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
@section('name')
    {{session('name')}}
@endsection


@section('content')
    @if (session('createAppSuccess'))
        <script>
            swal("ทำการนัดหมายเรียบร้อย", "จะมี SMS และ E-mail ส่งถึง เพื่อสรุปรายละเอียดอีกครั้ง", "success")
            {{session()->forget('createAppSuccess')}}
        </script>
    @endif

    <!-- BASIC FORM ELELEMNTS -->
    <div class="panel-body appointmentTable">
        <div class="paddingFormCreate centered">
            <h2>รายการนัดหมาย</h2>
            <br>
            <div class="container-fluid">
                <table class="table table-bordered ">
                    <tr>
                        <th>ชื่อผู้ป่วย</th>
                        <th>แพทย์ที่ต้องการพบ</th>
                        <th>วันที่</th>
                        <th>ช่วงเวลา</th>
                        <th>อาการ</th>
                        <th>แก้ไข</th>
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
                                <a href="{{ url('appointment/'.$appointment -> appointmentId.'/edit') }}">
                                    <i class="fa fa-edit" style="font-size:30px"></i>
                                </a>
                            </td>
                            <td>
                                <form class="form-horizontal style-form" method="post"
                                      action="{{ url('deleteAppointment/'.$appointment -> appointmentId) }}">
                                    <input type="submit" class="btn btn-danger btn-xs" value="ลบ">
                                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </table>
            </div>
        </div>
    </div>
@endsection
