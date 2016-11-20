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
    <link href="assets/css/registerPage.css" rel="stylesheet">
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

<div class="login-page">
    <div class="form-register">

        <div class="heading">
            <h2 class="form-register-heading">ลงทะเบียน</h2>
        </div>

        <div class="row mt">


            <form class="form-horizontal style-form" method="get">
                <div class="form-group">
                    <label class="col-sm-2 col-sm-2 control-label">ชี่อ</label>
                    <div class="col-sm-4">
                        <input type="text" class="form-control" name="firstname">
                    </div>

                    <label class="col-sm-2 col-sm-2 control-label">นามสกุล</label>
                    <div class="col-sm-4">
                        <input type="text" class="form-control" name="lastname">
                    </div>

                </div>


                <div class="form-group">
                    <label class="col-sm-2 col-sm-2 control-label">เลขบัตรประจำตัวประชาชน</label>
                    <div class="col-sm-4">
                        <input type="text" class="form-control" name="idNumber">
                    </div>


                    <label class="col-sm-2 col-sm-2 control-label">วัน/เดือน/ปี เกิด</label>
                    <div class="col-sm-4">
                        <div class="input-group date" data-provide="datepicker">
                            <input type="text" class="form-control">
                            <div class="input-group-addon">
                                <span class="glyphicon glyphicon-th"></span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-sm-2 col-sm-2 control-label">เบอร์โทรศัพท์</label>
                    <div class="col-sm-4">
                        <input type="text" class="form-control" name="phoneNumber">
                    </div>

                    <label class="col-sm-2 col-sm-2 control-label">อีเมล</label>
                    <div class="col-sm-4">
                        <input type="text" class="form-control" name="email">
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-sm-2 col-sm-2 control-label">ที่อยู่</label>
                    <div class="col-sm-10">
                        <textarea class="form-control textareaControl" rows="4" name="address">
                        </textarea>
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-sm-2 col-sm-2 control-label">เพศ</label>
                    <div class="col-sm-4">
                        <div class="radio">
                            <label class="col-sm-6">
                                <input type="radio" name="gender" id="optionsRadios1" value="male"
                                       checked> ชาย
                            </label>

                            <label class="col-sm-6">
                                <input type="radio" name="gender" id="optionsRadios2"
                                       value="female">
                                หญิง
                            </label>
                        </div>
                    </div>

                    <label class="col-sm-2 col-sm-2 control-label">กรุ๊ปเลือด</label>
                    <div class="col-sm-4">
                        <div class="radio">
                            <label class="col-sm-3">
                                <input type="radio" name="bloodType" id="optionsRadios1" value="A"
                                       checked> A
                            </label>

                            <label class="col-sm-3">
                                <input type="radio" name="bloodType" id="optionsRadios2"
                                       value="B"> B
                            </label>

                            <label class="col-sm-3">
                                <input type="radio" name="bloodType" id="optionsRadios3"
                                       value="C"> AB
                            </label>

                            <label class="col-sm-3">
                                <input type="radio" name="bloodType" id="optionsRadios4"
                                       value="D"> O
                            </label>
                        </div>
                    </div>
                </div>

                <div class="form-group">

                </div>

                <div class="form-group">
                    <label class="col-sm-2 col-sm-2 control-label">ชื่อผู้ใช้</label>
                    <div class="col-sm-4">
                        <input type="text" class="form-control" placeholder="username" name="username">
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-sm-2 col-sm-2 control-label">รหัสผ่าน</label>
                    <div class="col-sm-4">
                        <input type="password" class="form-control" placeholder="password" name="password">
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-sm-2 col-sm-2 control-label">ยืนยันรหัสผ่าน</label>
                    <div class="col-sm-4">
                        <input type="password" class="form-control" placeholder="confirm password" name="confirmPassword">
                    </div>
                </div>


                <div class="mt">
                    <button type="submit" class="btn btn-primary btn-block btn-lg">
                        บันทึก
                    </button>

                </div>

            </form>

        </div>

    </div>

</div>


<!-- js placed at the end of the document so the pages load faster -->
<script src="assets/js/jquery.js"></script>
<script src="assets/js/bootstrap.min.js"></script>


</body>

</html>
