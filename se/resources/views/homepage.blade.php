@extends('layouts.theme')

@section('css')
    <style>
        .midImage {
            text-align: center;
            overflow: hidden;
        }

        img {
            position: fixed;
            display: block;
            right: 0px;
            width: 60%;
            height: auto;
            overflow: hidden;
            opacity: 0.3;
        }
    </style>




@endsection

@section('content')
    @if (session('status'))
        <script>
            swal("{{session('status')}}", "สามารถกดเลือกที่เมนูทางซ้าย เพื่อทำนัดหมายได้เลย", "success");
        </script>
    @endif




    <div class="row mt">

        <div class="midImage">
            <!-- <div style="margin: auto auto"> -->
            <img src="{{url('assets/img/whippedcreamLogo.png')}}">
            <!-- </div> -->
        </div>

    </div>

@endsection
