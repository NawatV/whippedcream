@extends('layouts.theme')
<link href="{{ url('assets/css/bootstrap-datepicker3.min.css')}}" rel="stylesheet">
<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<script src="https://code.jquery.com/jquery-1.12.4.js"></script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>


@section('name')
    {{session('name')}}
@endsection



@section('content')
    @if(count($errors)>0)
        <script>
            swal({
                title: "ไม่สามารถลงทะเบียนได้",
                text: "กรุณาใส่ข้อมูลให้ครบและถูกต้องทุกช่อง",
                type: "error",
                confirmButtonColor: "#DD6B55",
                confirmButtonText: "แก้ไข",
                closeOnConfirm: true
            });
        </script>
    @endif
    @if(session('errorSameAppointment'))
        <script>
            swal({
                title: "ไม่สามารถทำนัดซ้ำได้",
                text: "คุณได้ทำการนัดในวันที่คุณเลือกไปแล้ว",
                type: "error",
                confirmButtonColor: "#DD6B55",
                confirmButtonText: "ย้อนกลับ",
                closeOnConfirm: true
            });
            {{session()->forget('errorSameAppointment')}}
        </script>
    @endif

    <!-- BASIC FORM ELELEMNTS -->
    <div class="row mt">
        <div class="col-lg-12">
            <div class="form-panel">
                <div class="container-fluid">
                    <h2 class="mb"><i class="fa fa-angle-right"></i> สร้างการนัดหมาย</h2>
                    <!-- Open Form -->
                    <form class="form-horizontal style-form" method="post" action="{{url('/appointment')}}">
                        <input type="hidden" name="_token" value="{{csrf_token()}}">
                        <div class="form-group">
                            <label class="col-sm-3 text-right">รหัสประจำตัวประชาชน / เลขรหัสโรงพยาบาล</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" name="patientId" value="{{old('patientId')}}">
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-3 text-right">อาการ</label>
                            <div class="col-sm-9">
                                <textarea class="form-control" rows="5" name="symptom">{{old('symptom')}}</textarea>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-3 text-right">เลือกแผนก</label>
                            <div class="col-sm-9">
                                <select class="form-control" id="department" name="departmentId">
                                    <option selected disabled>แผนก</option>
                                    @foreach ($departments as $department)
                                        <option value="{{$department -> departmentId}}">{{$department -> departmentName}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-3 text-right">เลือกหมอ</label>
                            <div id="doctor" class="col-sm-9 radio">
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-3 text-right">เลือกวัน</label>
                            <div class="col-sm-9" id="date">
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-3 text-right">เลือกช่วงเวลา</label>
                            <div class="col-sm-9 radio" id="time">
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-sm-2 col-lg-offset-3 col-sm-offset-3">
                                <a href="/appointment" class="btn btn-danger btn-block">ย้อนกลับ</a>
                            </div>
                            <div class="col-sm-2 col-lg-offset-2 col-lg-offset-2">
                                <input type="submit" class="btn btn-success btn-block" value="บันทึก">
                            </div>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>

    <script>

        $(document).ready(function () {
            $("#department").change(function () {
                $.ajax({
                    url: "/queryDoctor",
                    data: {
                        id: $('#department :selected').val()
                    },
                    success: function (result) {
                        console.log(result)
                        $("#doctor").empty();
                        $("#doctor").append('<label class="col-sm-3">');
                        $("#doctor").append('<div class="testBackground">');
                        $("#doctor").append('<input style="" type="radio" name="doctorId" value="0" onclick="if(this.checked){queryDoctorDateTime()}"> random');
                        $("#doctor").append('</label>');
                        for (i = 0; i < result.length; i++) {
                            tmp = '<input type="radio" name="doctorId" value="' + result[i][0] + '"' + 'onclick="if(this.checked){queryDoctorDateTime()}">' + result[i][1] + " "
                                    + result[i][2];
//                            $("#doctor").append('<label class="col-sm-3">');
                            $("#doctor").append(tmp);
                            $("#doctor").append('</div>');
                            $("#doctor").append('</label>');
                        }
                    }
                });
            });

        });

        var fastestdate;
        function queryDoctorDateTime() {
            //console.log($('input[name=doctorId]:checked', '#doctor').val());
            $.ajax({
                url: "/queryDoctorDateTime",
                data: {
                    id: $('input[name=doctorId]:checked', '#doctor').val(),
                    departmentId: $('#department :selected').val()
                },
                success: function (result) {
                    console.log(result)
                    $("#date").empty();
                    $("#time").empty();
                    fastestdate = result[7][1];
                    //$("#date").append('<input type="date" value="' + result[7][1] + '" name="bday">');
                    $("#date").append('<label class="col-sm-4">');
                    $("#date").append('<input class="form-control" type="text" id="datepicker" name="appDate">');
                    if (result[8][1] == "1") {
                        $("#time").append('<label class="col-sm-4">');
                        $("#time").append('<input type="radio" name="appTime" value="1" checked="checked"> เช้า<br>');
                        $("#time").append('</label>');
                        $("#time").append('<label class="col-sm-4">');
                        $("#time").append('<input type="radio" name="appTime" value="2" disabled> บ่าย<br>');
                        $("#time").append('</label>');
                    } else if (result[8][1] == "2") {
                        $("#time").append('<label class="col-sm-4">');
                        $("#time").append('<input type="radio" name="appTime" value="1" disabled> เช้า<br>');
                        $("#time").append('</label>');
                        $("#time").append('<label class="col-sm-4">');
                        $("#time").append('<input type="radio" name="appTime" value="2" checked="checked"> บ่าย<br>');
                        $("#time").append('</label>');
                    } else if (result[8][1] == "3") {
                        $("#time").append('<label class="col-sm-4">');
                        $("#time").append('<input type="radio" name="appTime" value="1" checked="checked"> เช้า<br>');
                        $("#time").append('</label>');
                        $("#time").append('<label class="col-sm-4">');
                        $("#time").append('<input type="radio" name="appTime" value="2"> บ่าย<br>');
                        $("#time").append('</label>');
                    }
                    //<label class="col-sm-2 control-label">เลือกวัน</label>
                    //<input class="form-control" type="text" id="datepicker" >
                    myFunction(result, fastestdate);
                }
            });
        }

        function myFunction(params, fastestdate) {
            $("#datepicker").datepicker({
                dateFormat: 'yy-mm-dd',
                maxDate: "+1y",
                minDate: fastestdate,
                beforeShowDay: function (date) {
                    var day = date.getDay();
                    var dd = date.getDate();
                    var mm = date.getMonth() + 1;
                    var yy = date.getFullYear();
                    //ทำให้ format ตรง จาก วันที่ 3 ให้เป็น  03
                    if (dd < 10) dd = '0' + dd;
                    if (mm < 10) mm = '0' + mm;

                    var thisDate = yy + '-' + mm + '-' + dd;
                    var arrayOfDisabledDates = params[9];
                    if (arrayOfDisabledDates.indexOf(thisDate) != -1) return false;
                    return [(day == params[5][1] || day == params[3][1] || day == params[1][1] || day == params[0][1] || day == params[2][1] || day == params[4][1] || day == params[6][1]), ''];
                },
                onSelect: function (date) {
                    $.ajax({
                        url: "/queryPeriod",
                        data: {
                            id: $('input[name=doctorId]:checked', '#doctor').val(),
                            day: $("#datepicker").datepicker("getDate").getDay(),
                            date: $("#datepicker").datepicker("getDate").getDate(),
                            month: $("#datepicker").datepicker("getDate").getMonth() + 1,
                            year: $("#datepicker").datepicker("getDate").getFullYear()
                        },
                        success: function (result) {
                            console.log(result)
                            $("#time").empty();
                            //$("#date").append('<input type="date" value="' + result[7][1] + '" name="bday">');
                            if (result == "1") {
                                $("#time").append('<input type="radio" name="appTime" value="1" checked="checked"> เช้า<br>');
                                $("#time").append('<input type="radio" name="appTime" value="2" disabled> บ่าย<br>');
                            } else if (result == "2") {
                                $("#time").append('<input type="radio" name="appTime" value="1" disabled> เช้า<br>');
                                $("#time").append('<input type="radio" name="appTime" value="2" checked="checked"> บ่าย<br>');
                            } else if (result == "3") {
                                $("#time").append('<input type="radio" name="appTime" value="1" checked="checked"> เช้า<br>');
                                $("#time").append('<input type="radio" name="appTime" value="2"> บ่าย<br>');
                            }
                        }
                    });
                }
            }).val(fastestdate);
        }


    </script>


@endsection
