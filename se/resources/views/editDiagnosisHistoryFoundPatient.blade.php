@extends('layouts.theme')

@section('name')
    {{session('name')}}

@endsection

@section('content')
    <!-- BASIC FORM ELELEMNTS -->
    <div class="row mt">
        <div class="col-lg-12">
            <div class="form-panel">
                <div class="container-fluid">
                    {{--<h1>Found Patient</h1>--}}
                    {{--<p>{{$patients}}</p>--}}
                    {{--<p>{{$diagnoses}}</p>--}}
                    {{--<p>{{$appointments}}</p>--}}
                    <h1>รายการตรวจพบ และ คำวินิจฉัย</h1>
                    <h2>{{$patients->firstname.' '.$patients->lastname}}</h2>
                </div>

                <hr style="width: 95%;">

                <div class="container-fluid">

                    @if(empty($diagnoses))
                        <h3>ไม่มีรายละเอียดการตรวจ</h3>
                    @else

                        <table class="table table-striped">
                            <thead>
                            <tr>
                                <th class="col-xs-2 col-lg-2">ตรวจ ณ วันที่</th>
                                <th class="col-xs-3 col-lg-3">แพทย์ผู้ตรวจ</th>
                                <th class="col-xs-5 col-lg-5">รายละเอียดการตรวจ</th>
                                <th class="col-xs-2 col-lg-2">แก้ไขข้อมูล</th>
                            </tr>
                            </thead>
                            <tbody>
                            @for($i=0; $i < count($diagnoses);$i++)
                                <tr>
                                    <td>{{$diagnoses[$i]->diagnosisDate}}</td>
                                    <td>{{$doctors[$i]->firstname.' '.$doctors[$i]->lastname}}</td>
                                    <td>{{$diagnoses[$i]->diagnosisDetail}}</td>
                                    <td>

                                        <form method="GET" class="form-horizontal style-form"
                                              action="findPatientFromHnIdNameForDiagnosis/{{$diagnoses[$i]->diagnosisId}}/edit"/>

                                        <button type="submit" class="btn btn-danger btn-sm">
                                            <i class="fa fa-pencil-square"></i>
                                            แก้ไข
                                        </button>

                                        </form>


                                        {{--<form method="post" class="form-horizontal style-form"--}}
                                              {{--action="editDiagnosisHistory/{{$diagnoses[$i]->diagnosisId}}/delete"/>--}}
                                               {{--<input type="hidden" name="_token" value="{{ csrf_token() }}">--}}

                                        {{--<button type="submit">--}}
                                            {{--<i class="fa fa-pencil-square"></i>--}}
                                            {{--ลบ--}}
                                        {{--</button>--}}

                                        {{--</form>--}}

                                    </td>
                                </tr>
                            @endfor
                            </tbody>
                        </table>

                    @endif

                    {{--<ul class="list-group">--}}
                    {{--@if(empty($diagnoses))--}}
                    {{--<li class="list-group-item">ไม่มีผลลัพธ์การค้นหา</li>--}}
                    {{--@else--}}
                    {{--<h2>Has diagnosis</h2>--}}
                    {{--@endif--}}
                    {{--@foreach($diagnoses as $diagnosis)--}}
                    {{--<li class="list-group-item">{{$diagnosis}}</li>--}}
                    {{--@endforeach--}}
                    {{--</ul>--}}


                </div>

            </div>
        </div>







@endsection
