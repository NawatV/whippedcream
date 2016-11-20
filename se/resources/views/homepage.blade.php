@extends('layouts.theme')

@section('css')
  <style>
    .panel-body{
      text-align: center;
    }

    img{
      width: 50%;
      height: 50%;
      opacity: 0.3;
    }
  </style>
@endsection

@section('content')
  <div class="row mt">

      <div class="panel-body">
        <!-- <div style="margin: auto auto"> -->
            <img src="{{url('assets/img/whippedcreamLogo.png')}}">
        <!-- </div> -->

      </div>

  </div>
@endsection
