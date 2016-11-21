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

    <link href="{{url('assets/css/afterLogin.css')}}" rel="stylesheet">


    <link rel="stylesheet" href="/assets/css/sweetalert.css">
    <script src="/assets/js/sweetalert.min.js"></script>

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
        <a class="logo"><b>WhippedCream System 0.1</b></a>
        <!--logo end-->

        <div class="top-menu">
            <ul class="nav pull-right top-menu">
                <a class="logo" postion="right" style="margin-right: 30px">
                    <i class="fa fa-user"></i>&nbspคุณ{{session('name')}}&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                </a>
                <li>
                    <a href="/logout" class="btn btn-danger logout">
                        ออกจากระบบ
                    </a>
                </li>
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
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
<script class="include" type="text/javascript" src="{{url('assets/js/jquery.dcjqaccordion.2.7.js')}}"></script>
<script src="{{url('assets/js/jquery.scrollTo.min.js')}}"></script>
<script src="{{url('assets/js/jquery.nicescroll.js')}}" type="text/javascript"></script>



<!--common script for all pages-->
<script src="{{asset('assets/js/common-scripts.js')}}"></script>

<!--script for this page-->

<!--custom switch-->
<script src="{{asset('assets/js/jquery.scrollTo.min.js')}}"></script>

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
