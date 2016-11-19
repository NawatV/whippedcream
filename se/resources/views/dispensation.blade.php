@extends('layouts.theme')

@section('css')
  <style>
    .dispensation-list-wait
    {
      border-left: solid #78CD51 3px;
      margin-bottom: 2px;
      padding: 15px 0 15px 15px;
     }

     .dispensation-list-success
     {
       border-left: solid #41CAC0 3px;
       margin-bottom: 2px;
       padding: 15px 0 15px 15px;
      }

      .dispensation-list-cancel
      {
        border-left: solid #ff6c60 3px;
        margin-bottom: 2px;
        padding: 15px 0 15px 15px;
       }

     .ml
     {
       margin-left: 15px;
     }

     .mr
     {
       margin-right: 15px;
     }
  </style>
@endsection

@section('name')
  {{$name}}
@endsection

@section('leftnav')
  <li class="sub-menu">
    <a class = "active"  href="{{url('dispention')}}" >
      <i class="fa fa-plus-square"></i><span>จ่ายยา</span>
    </a>
  </li>

  <li class="sub-menu">
    <a  href="javascript:;" >
      <i class="fa fa-info-circle"></i><span>ข้อมูลผู้ป่วย</span>
    </a>
  </li>
@endsection



@section('content')
  <div class="row mt">
    <div class="col-lg-12">
      <div class="form-panel" style="height: 80vh">
        <div class="container-fluid" style="height: 100%;">
          <h4 class="mb"><i class="fa fa-angle-right"></i> &nbsp;จ่ายยา</h4>

          <div class="dispensation-content"  style="height:85%; overflow: auto">

            @if(count($dispense_list) > 0)
              @foreach($dispense_list as $list)
                @if(is_null($list['status']))
                  <div class="dispensation-list-wait">
                    <i class="fa fa-info" aria-hidden="true"></i>
                    <span class="ml"><a href = "#">{{ $list['name'] }}</a></span>
                    <span class="badge bg-success ml">Waiting</span>
                    <div class="pull-right mr">
                      <button class="btn btn-success btn-xs fa fa-check"></button>
                      <button class="btn btn-primary btn-xs fa fa-pencil"></button>
                    </div>
                  </div>
                @elseif($list['status'])
                  <div class="dispensation-list-success">
                    <i class="fa fa-info" aria-hidden="true"></i>
                    <span class="ml"><a href = "#">{{ $list['name'] }}</a></span>
                    <span class="badge bg-theme ml">Done</span>
                  </div>
                @else
                  <div class="dispensation-list-cancel">
                    <i class="fa fa-info" aria-hidden="true"></i>
                    <span class="ml"><a href = "#">{{ $list['name'] }}</a></span>
                    <span class="badge bg-important ml">Cancel</span>
                  </div>
                @endif
              @endforeach
            @endif

          </div>
          
        </div>
      </div>
    </div>
  </div>

@endsection

@section('script')

@endsection
