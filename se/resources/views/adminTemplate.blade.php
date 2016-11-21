<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="Dashboard">
    <meta name="keyword" content="Dashboard, Bootstrap, Admin, Template, Theme, Responsive, Fluid, Retina">

    <title>WhippedCream System 0.1 -- Administrator section</title>

    <!-- Bootstrap core CSS -->
    <link href="assets/css/bootstrap.css" rel="stylesheet">
    <!--external css-->
    <link href="assets/font-awesome/css/font-awesome.css" rel="stylesheet"/>

    <!-- Custom styles for this template -->
    <link href="assets/css/style.css" rel="stylesheet">
    <link href="assets/css/style-responsive.css" rel="stylesheet">

    <link href="assets/css/addonAdminSection.css" rel="stylesheet">


{{--<link rel="stylesheet" type="text/css" href="assets/js/bootstrap-datepicker/css/datepicker.css"/>--}}
{{--<link rel="stylesheet" type="text/css" href="assets/js/bootstrap-daterangepicker/daterangepicker.css"/>--}}


<!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->


    <script type="text/javascript">
        <!--
        function toggle_visibility(id) {
            var e = document.getElementById(id);
            if (e.style.display == 'block')
                e.style.display = 'none';
            else
                e.style.display = 'block';
        }
        //-->
    </script>


    <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <link rel="stylesheet" href="/resources/demos/style.css">
    <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    <script>
        $(function () {
            $("#datepicker1").datepicker({
                dateFormat: "dd/mm/yy"
            });
        });
    </script>


    <link rel="stylesheet" href="/assets/css/sweetalert.css">
    <script src="/assets/js/sweetalert.min.js"></script>
    <script src="/assets/js/jquery-1.8.3.min.js"></script>


</head>

<body>

@if (session('userType') === 'admin')
    <script>
        swal("{{session('status')}}", "", "success");
    </script>
@else
    <script>
        {{session(['unauthorized' => 'e'])}}
        window.location.href = "/homepage";
    </script>
@endif


<section id="container" style="z-index: 1">
    <!-- **********************************************************************************************************************************************************
    TOP BAR CONTENT & NOTIFICATIONS
    *********************************************************************************************************************************************************** -->
    <!--header start-->
    <header class="header black-bg" style="z-index: 1">
        <div class="sidebar-toggle-box">
            <div class="fa fa-bars tooltips" data-placement="right" data-original-title="Toggle Navigation"></div>
        </div>
        <!--logo start-->
        {{--<a href="/" class="logo"><b>Whipped Cream</b></a>--}}
        <a href="/manageAccount" class="logo"><b>WhippedCream System 0.1</b></a>
        <!--logo end-->
        <div class="top-menu">
            <ul class="nav pull-right top-menu">
                <a class="logo" postion="right" style="margin-right: 30px">
                    <i class="fa fa-lock" style="margin-right: 10px"></i>
                    Administrator mode
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

                <div style="margin-top: 100px; margin-bottom: 20px">
                    <p class="centered" style=""><a href="/manageAccount"><img src="assets/img/lock_Large.png"
                                                                               class="img-circle"
                                                                               width="150"></a></p>
                    <h3 class="centered" style="color: white;">Administrator Mode</h3>
                </div>

                <li class="mt">
                    <a href="/manageAccount">
                        <i class="fa fa-users"></i>
                        <span>จัดการบัญชีผู้ใช้</span>
                    </a>
                </li>

                <li class="sub-menu">
                    <a href="javascript:;">
                        <i class="fa fa-user-plus"></i>
                        <span>สร้างบัญชีผู้ใช้</span>
                    </a>
                    <ul class="sub">
                        <li><a href="/createStaff">ประเภทเจ้าหน้าที่</a></li>
                        <li><a href="/createDoctor">ประเภทแพทย์</a></li>
                        <li><a href="/createNurse">ประเภทพยาบาล</a></li>
                        <li><a href="/createPharmacist">ประเภทเภสัชกร</a></li>
                        <li><a href="/createAdmin">ประเภทผู้คุมระบบ</a></li>
                    </ul>
                </li>

                <li>
                    <a href="/manageDepartment">
                        <i class="fa fa-hospital-o"></i>
                        <span>จัดการรายชื่อแผนก</span>
                    </a>
                </li>

                <li>
                    <a href="/createDepartment">
                        <i class="fa fa-plus-square"></i>
                        <span>สร้างแผนก</span>
                    </a>
                </li>
            </ul>
            <!-- sidebar menu end-->
        </div>
    </aside>
    <!--sidebar end-->

    <!-- **********************************************************************************************************************************************************
    MAIN CONTENT
    *********************************************************************************************************************************************************** -->
    <!--main content start-->
    <section id="main-content">
        <section class="wrapper site-min-height">
            <div class="row mt">
                <div class="col-lg-12" align="center">
                    @yield('main-content')
                </div>
            </div>

        </section>
        <! --/wrapper -->
    </section><!-- /MAIN CONTENT -->

    <!--main content end-->


    {{--<!--footer start-->--}}
    {{--<footer class="site-footer">--}}
    {{--<div class="text-center">--}}
    {{--2014 - Alvarez.is--}}
    {{--<a href="blank.html#" class="go-top">--}}
    {{--<i class="fa fa-angle-up"></i>--}}
    {{--</a>--}}
    {{--</div>--}}
    {{--</footer>--}}
    {{--<!--footer end-->--}}


</section>

<!-- js placed at the end of the document so the pages load faster -->
<script src="assets/js/jquery.js"></script>
<script src="assets/js/bootstrap.min.js"></script>
<script src="assets/js/jquery-ui-1.9.2.custom.min.js"></script>
<script src="assets/js/jquery.ui.touch-punch.min.js"></script>
<script class="include" type="text/javascript" src="assets/js/jquery.dcjqaccordion.2.7.js"></script>
<script src="assets/js/jquery.scrollTo.min.js"></script>
<script src="assets/js/jquery.nicescroll.js" type="text/javascript"></script>

<!--custom javascript-->
<script src="assets/js/admin-js/view_account.js"></script>

<!--common script for all pages-->
<script src="assets/js/common-scripts.js"></script>

<!--script for this page-->

<script>
    //custom select box

    $(function () {
        $('select.styled').customSelect();
    });

</script>

</body>
</html>
