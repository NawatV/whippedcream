@extends('layouts.theme')

@section('name')
    {{session('name')}}
@endsection




@section('content')
    <div class="row mt">
        <div class="col-lg-12">
            <div class="form-panel">
                <div class="container-fluid">

                    {{--<h1>This is editDiagnosisHistory</h1>--}}
                    <h1>ค้นหารายการนัดหมายทั้งหมด</h1>

                    <h4 class="mb">
                        <i class="fa fa-angle-right"></i> ค้นหารายการนัดหมายทั้งหมด ของผู้ป่วยที่ต้องการ
                    </h4>
                    {{--<div class="container">--}}
                    {{--<h5>สามารถกรอกอย่างใดอย่างหนึ่ง หรือ ทั้งหมด</h5>--}}
                    {{--</div>--}}
                    <br>
                    <form class="form-horizontal style-form" action="staffsearchpatientfound" method="get">
                        {{--<input type="hidden" name="_token" value="{{ csrf_token() }}">--}}
                        <div class="form-group">
                            <div class="container">
                                <label class="col-sm-2 col-sm-2 control-label">เลขบัตรประจำตัวประชาชน</label>
                                <div class="col-sm-6">
                                    <input name="idNumber" type="text" class="form-control">
                                </div>
                                {{--<button type="submit" class="btn btn-primary">ค้นหาด้วยเลขบัตรประจำตัวประชาชน--}}
                                {{--</button>--}}

                            </div>
                        </div>

                        <div class="form-group">
                            <div class="container">
                                <label class="col-sm-2 col-sm-2 control-label">เลขประจำตัวผู้ป่วย</label>
                                <div class="col-sm-6">
                                    <input name="hnNumber" type="text" class="form-control">
                                </div>
                                {{--<button type="submit" class="btn btn-primary">ค้นหาด้วยเลขประจำตัวผู้ป่วย--}}
                                {{--</button>--}}
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="container">
                                <label class="col-sm-2 col-sm-2 control-label">ชื่อ</label>
                                <div class="col-sm-3">
                                    <input name="firstname" type="text" class="form-control">
                                </div>

                                <label class="col-sm-2 col-sm-2 control-label">นามสกุล</label>
                                <div class="col-sm-3">
                                    <input name="lastname" type="text" class="form-control">
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <button type="submit" class="btn btn-success center-block">
                                ค้นหาด้วย เลขบัตรประจำตัวประชาชน หรือ เลขประจำตัวผู้ป่วย หรือ ชื่อ และ นามสกุล
                                อย่างใดอย่างหนึ่ง
                            </button>
                        </div>
                    </form>

                </div>
            </div>

            <div class="form-panel">
                <div class="container-fluid">
                    <h2>ผลลัพธ์การค้นหา</h2>
                    <ul class="list-group">
                        @if(empty($patients))
                            <li class="list-group-item">ไม่มีผลลัพธ์การค้นหา</li>
                        @endif
                        @foreach($patients as $patient)
                            <li class="list-group-item">{{$patient}}</li>
                        @endforeach
                    </ul>
                </div>
            </div>

        </div>
    </div>
@endsection
