@extends('layouts.theme')

@section('css')

@endsection

@section('content')
    @if (session('status'))
        <script>
            swal("{{session('status')}}", "", "success");
            {{session()->forget('status')}}
        </script>
    @endif
    @if (session('unauthorized'))
        <script>
            swal({
                title: "Nope",
                text: "You are not authorized there!",
                type: "error",
                confirmButtonColor: "#d9534f",
                confirmButtonText: "Understood",
                closeOnConfirm: false
            });
            {{session()->forget('unauthorized')}}
        </script>
    @endif


    {{--<h1>--}}
        {{--{{session('userId')}}--}}
        {{--<br>--}}
        {{--{{session('userType')}}--}}
        {{--<br>--}}
        {{--{{session('name')}}--}}
        {{--<br>--}}
    {{--</h1>--}}




    <div class="row mt">

        <div class="midImage">
            <!-- <div style="margin: auto auto"> -->
            <img src="{{url('assets/img/whippedcreamLogo.png')}}">
            <!-- </div> -->
        </div>

    </div>

@endsection
