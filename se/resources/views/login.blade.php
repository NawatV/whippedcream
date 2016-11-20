<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <!-- <meta name="author" content="Dashboard"> -->
    <!-- <meta name="keyword" content="Dashboard, Bootstrap, Admin, Template, Theme, Responsive, Fluid, Retina"> -->

    <title>Hospital OPD System</title>

    <!-- Bootstrap core CSS -->
    <link href="assets/css/bootstrap.css" rel="stylesheet">
    <!--external css-->
    <link href="assets/font-awesome/css/font-awesome.css" rel="stylesheet"/>
    <link href="https://fonts.googleapis.com/css?family=Kanit:400,700" rel="stylesheet">
    <!--  <link rel="stylesheet" type="text/css" href="assets/js/bootstrap-datepicker/css/datepicker.css" />
     <link rel="stylesheet" type="text/css" href="assets/js/bootstrap-daterangepicker/daterangepicker.css" /> -->

    <!-- Custom styles for this template -->
    <link href="assets/css/loginPage.css" rel="stylesheet">
    <link href="assets/css/style-responsive.css" rel="stylesheet">

    <link rel="stylesheet" href="/assets/css/sweetalert.css">

    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->

    <script src="/assets/js/sweetalert.min.js"></script>
    <script src="/assets/js/jquery-1.8.3.min.js"></script>


</head>

<body>

<!-- **********************************************************************************************************************************************************
MAIN CONTENT
*********************************************************************************************************************************************************** -->
<div id="login-page">
    <div class="container">
        @if(count($errors) > 0)
            <script>
                swal('ไม่มีรายชื่อผู้ใช้ภายในระบบ!', 'ลองใส่ Username หรือ Password อีกครั้ง', 'error');
            </script>
        @endif

        <form class="form-login" action="/login" method="post">
            <input type="hidden" name="_token" value="{{ csrf_token() }}">
            <h2 class="form-login-heading">sign in now</h2>
            <div class="login-wrap">
                <input type="text" class="form-control" placeholder="User ID" name="username">
                <br>
                <input type="password" class="form-control" placeholder="Password" name="password">
                <br>
                <div class="form-group">
                    <button class="btn btn-theme col-sm-5" type="submit"><i class="fa fa-lock"></i> เข้าสู่ระบบ</button>
                    <button class="btn btn-theme col-sm-5 col-sm-offset-2" type="button"
                            onclick="window.location.href='{{url('/register')}}'"><i class="fa fa-lock"></i> ลงทะเบียน
                    </button>
                </div>
                <br>
            </div>

        </form>

    </div>
</div>

<!-- js placed at the end of the document so the pages load faster -->
<script src="assets/js/jquery.js"></script>
<script src="assets/js/bootstrap.min.js"></script>


</body>

</html>
