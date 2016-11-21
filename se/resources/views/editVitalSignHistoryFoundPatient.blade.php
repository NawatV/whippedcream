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
                    <h1>อาการทั่วไป</h1>
                    <h2>{{$patients->firstname.' '.$patients->lastname}}</h2>
                </div>

                <hr style="width: 95%;">

                <div class="container-fluid">

                    @if(empty($vitalsigns))
                        <h3>ไม่มีรายละเอียดการตรวจ</h3>
                    @else

                        <table class="table table-striped">
                            <thead>
                            <tr>
                                <th class="col-xs-2 col-lg-2">ตรวจ ณ วันที่</th>

                                <th class="col-xs-2 col-lg-2"></th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($vitalsigns as $vitalsign)
                                <tr>
                                    <td>{{$vitalsign->vitalSignDataDate}}</td>
                                    <td>
                                        <form method="post" class="form-horizontal style-form"
                                              action="seeVitalSignHistory"/>
                                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                        <input type="hidden" name="userId" value="{{$patients->userId}}">
                                        <input type="hidden" name="vitalsignID" value="{{$vitalsign->vitalSignDataId}}">
                                        <button type="submit">
                                            <i class="fa fa-search"></i>
                                            ดู
                                        </button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>

                    @endif

                </div>

            </div>
        </div>


@endsection
