<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Hospital OPD System</title>

    <!-- Bootstrap core CSS -->
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet">
    <!--external css-->
    <!-- <link href="assets/font-awesome/css/font-awesome.css" rel="stylesheet" /> -->
    <link href="https://fonts.googleapis.com/css?family=Kanit:400,700" rel="stylesheet">
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="{{url('assets/css/style.css')}}" rel="stylesheet">
    <link href="{{url('assets/css/style-responsive.css')}}" rel="stylesheet">

    @yield('css')

</head>

<body>
<section id="container">
    <!-- **********************************************************************************************************************************************************
    TOP BAR CONTENT & NOTIFICATIONS
    *********************************************************************************************************************************************************** -->
    <!--header start-->
    <header class="header black-bg">

        <!--logo start-->
        <a class="logo"><b>Whipped Cream</b></a>
        <!--logo end-->

        <div class="top-menu">
            <ul class="nav pull-right top-menu">
                {{--<a class="logo" postion="right"><i class="fa fa-user"></i>&nbsp;คุณ{{$name}}&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;--}}
                <a class="logo" postion="right"><i class="fa fa-user"></i>&nbsp;คุณ{{$request->session()->get('name')}}&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                </a>
                <li><a class="logout" href="{{ url('/login') }}">ออกจากระบบ</a></li>
            </ul>
        </div>
    </header>
    <!--header end-->

    <!-- **********************************************************************************************************************************************************
     MAIN SIDEBAR MENU
     *********************************************************************************************************************************************************** -->
    <!--sidebar start-->
    <aside>
        <div id="sidebar" class="nav-collapse ">
            <!-- sidebar menu start-->
            <ul class="sidebar-menu" id="nav-accordion">
                @include('leftnav')
            </ul>
            <!-- sidebar menu end-->
        </div>
    </aside>
    <!--sidebar end-->

    <section id="main-content">
        <section class="wrapper pl">
            @yield('content')
        </section>
        <! --/wrapper -->
    </section><!-- /MAIN CONTENT -->


    <!--main content end-->
    <!--footer start-->
@yield('special-content')
<!--footer end-->

</section>


<!-- js placed at the end of the document so the pages load faster -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
<script class="include" type="text/javascript" src="{{url('assets/js/jquery.dcjqaccordion.2.7.js')}}"></script>
<script src="{{url('assets/js/jquery.scrollTo.min.js')}}"></script>
<script src="{{url('assets/js/jquery.nicescroll.js')}}" type="text/javascript"></script>

<!--common script for all pages-->
<script src="{{url('assets/js/common-scripts.js')}}"></script>

<!--script for this page-->
<script src="{{url('assets/js/jquery-ui-1.9.2.custom.min.js')}}"></script>

<!--custom switch-->
<script src="{{url('assets/js/bootstrap-switch.js')}}"></script>

<!--custom tagsinput-->
<script src="{{url('assets/js/jquery.tagsinput.js')}}"></script>

<!--custom checkbox & radio-->
<script type="text/javascript" src="{{url('assets/js/bootstrap-inputmask/bootstrap-inputmask.min.js')}}"></script>

<script src="{{url('assets/js/form-component.js')}}"></script>

<script>
    $(document).ready(function () {
        var pathname = window.location.href;

        $('.leftnav').each(function () {
            if ($(this).attr('href') == pathname) {
                $(this).addClass('active');
            }
        });
    });
</script>

@yield('script')

</body>
</html>
