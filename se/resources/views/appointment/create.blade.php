@extends('layouts.theme')

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
  <div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">New Appointment</div>

                <div class = "panel-body">
                    {!! Form::open(['url' => 'appointment']) !!}
                       {{csrf_field()}}
                    
                       <select>
                             @foreach ($departments as $department)
                                <option value="{{$department -> departmentName}}">{{$department -> departmentName}}</option>
                            @endforeach
                        </select>

                        <div class = "form-group">
                            <div class = "col-xs-4">
                                {{ Form::label('symptom', 'อาการ') }}
                                {{ Form::text('symptom', null, ["class" => "form-control"]) }}
                            </div>
                        </div>

                        <div class = "form-group">
                            <div class = "col-xs-4">
                                {{ Form::label('doctorId', 'เลขหมอ') }}
                                {{ Form::text('doctorId', null, ["class" => "form-control"]) }}
                            </div>
                        </div>  

                        <div class = "form-group">
                            <div class = "col-sm-10">
                                {{ form::submit('บันทึก', ["class" => 'btn btn-primary'])  }} 
                                <a href = "{{url('appointment')}}" class="btn btn-primary">back</a>
                            </div>
                        </div>                      
                    {!! Form::close() !!}

                    
                </div>
            </div>
        </div>
    </div>
</div>
  
@endsection
