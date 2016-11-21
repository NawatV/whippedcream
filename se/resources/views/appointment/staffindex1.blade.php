@extends('layouts.theme')
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
@section('name')
    {{session('name')}}
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
                    <a href = "{{ url('appointment/'.$appointment -> appointmentId.'/appointmentpdf') }}">สร้างใบนัดหมาย</a>
                    <form class="form-horizontal style-form" method="post"
                          action="{{ url('deleteAppointment/'.$appointment -> appointmentId) }}">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <input type="submit" class="btn btn-primary pull-right" value="ลบ">
                        <input type="hidden" name="_token" value="{{csrf_token()}}">
                    </form>
                </td>
            </tr>
        @endforeach
    </table>
  </div>
@endsection
