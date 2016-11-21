<!doctype html>
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
    <link href="assets/font-awesome/css/font-awesome.css" rel="stylesheet"/>
    <link href="https://fonts.googleapis.com/css?family=Kanit:400,700" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="assets/js/bootstrap-daterangepicker/daterangepicker.css"/>
    <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <link rel="stylesheet" href="/resources/demos/style.css">

    <!-- Custom styles for this template -->
    <link href="assets/css/registerPage.css" rel="stylesheet">
    <link href="assets/css/style-responsive.css" rel="stylesheet">

    <link rel="stylesheet" href="/assets/css/sweetalert.css">
    <script src="/assets/js/sweetalert.min.js"></script>
    <script src="/assets/js/jquery-1.8.3.min.js"></script>


    <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <link rel="stylesheet" href="/resources/demos/style.css">
    <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    <script>
        $(function () {
            $( "#datepicker" ).datepicker({
                dateFormat: "dd/mm/yy"
            });
        });

    </script>

</head>


<body>
@if(count($errors)>0)
    <script>
        swal({
            title: "ไม่สามารถลงทะเบียนได้",
            text: "กรุณาใส่ข้อมูลให้ครบทุกช่อง",
            type: "error",
            confirmButtonColor: "#DD6B55",
            confirmButtonText: "ย้อนกลับไปแก้ไข",
            closeOnConfirm: true
        });
    </script>
    {{--@foreach($errors->all() as $error)--}}
    {{--{{$error}}<br>--}}
    {{--@endforeach--}}
@endif

<div class="login-page">
    <div class="form-register">

        <div class="heading">
            <h2 class="form-register-heading">ลงทะเบียน</h2>
        </div>

        <div class="row mt">


            <form class="form-horizontal style-form" action="register" method="post">
                <input type="hidden" name="_token" value="{{ csrf_token() }}">

                <div class="form-group">
                    <label class="col-sm-2 col-sm-2 control-label">ชี่อ</label>
                    <div class="col-sm-4">
                        <input type="text" class="form-control" name="firstname" value="{{old('firstname')}}">
                    </div>

                    <label class="col-sm-2 col-sm-2 control-label">นามสกุล</label>
                    <div class="col-sm-4">
                        <input type="text" class="form-control" name="lastname" value="{{old('lastname')}}">
                    </div>

                </div>


                <div class="form-group">
                    <label class="col-sm-2 col-sm-2 control-label">เลขบัตรประจำตัวประชาชน</label>
                    <div class="col-sm-4">
                        <input type="text" class="form-control" name="idNumber" value="{{old('idNumber')}}">
                    </div>


                    <label class="col-sm-2 col-sm-2 control-label">วัน/เดือน/ปี เกิด</label>
                    <div class="col-sm-4">
                        <div class="input-group date" data-provide="datepicker">
                            <input type="text" class="form-control" id="datepicker" name="birthDate"
                                   value="{{old('birthDate')}}">
                            <div class="input-group-addon">
                                <span class="glyphicon glyphicon-th"></span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-sm-2 col-sm-2 control-label">เบอร์โทรศัพท์</label>
                    <div class="col-sm-4">
                        <input type="text" class="form-control" name="phoneNumber" value="{{old('phoneNumber')}}">
                    </div>

                    <label class="col-sm-2 col-sm-2 control-label">อีเมล</label>
                    <div class="col-sm-4">
                        <input type="text" class="form-control" name="email" value="{{old('email')}}">
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-sm-2 col-sm-2 control-label">ที่อยู่</label>
                    <div class="col-sm-10">
                        <textarea class="form-control textareaControl" rows="4" name="address">{{old('address')}}</textarea>
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-sm-2 col-sm-2 control-label">เพศ</label>
                    <div class="col-sm-4">
                        <div class="radio">
                            <label class="col-sm-6">
                                <input type="radio" name="gender" id="optionsRadios1" value="male"
                                        {{ old('gender') == 'male'?'checked':''}} > ชาย
                            </label>

                            <label class="col-sm-6">
                                <input type="radio" name="gender" id="optionsRadios2"
                                       value="female" {{ old('gender') == 'female'?'checked':''}}>
                                หญิง
                            </label>
                        </div>
                    </div>

                    <label class="col-sm-2 col-sm-2 control-label">กรุ๊ปเลือด</label>
                    <div class="col-sm-4">
                        <div class="radio">
                            <label class="col-sm-3">
                                <input type="radio" name="bloodType" id="optionsRadios1" value="A"
                                        {{ old('bloodType') == 'A'?'checked':''}}> A
                            </label>

                            <label class="col-sm-3">
                                <input type="radio" name="bloodType" id="optionsRadios2"
                                       value="B" {{ old('bloodType') == 'B'?'checked':''}}> B
                            </label>

                            <label class="col-sm-3">
                                <input type="radio" name="bloodType" id="optionsRadios3"
                                       value="AB" {{ old('bloodType') == 'AB'?'checked':''}}> AB
                            </label>

                            <label class="col-sm-3">
                                <input type="radio" name="bloodType" id="optionsRadios4"
                                       value="O" {{ old('bloodType') == 'O'?'checked':''}}> O
                            </label>
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-sm-2 col-sm-2 control-label">ประวัติการแพ้ยา</label>
                    <div class="col-sm-4">
                        <input type="text" class="form-control" placeholder="ถ้าไม่มีประวัติการแพ้ยา ให้ใส่ -"
                               name="allergen" value="{{old('allergen')}}">
                    </div>
                </div>


                <div class="form-group">
                    <label class="col-sm-2 col-sm-2 control-label">ชื่อผู้ใช้</label>
                    <div class="col-sm-4">
                        <input type="text" class="form-control" placeholder="username" name="username"
                               value="{{old('username')}}">
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-sm-2 col-sm-2 control-label">รหัสผ่าน</label>
                    <div class="col-sm-4">
                        <input type="password" class="form-control" placeholder="password" name="password"
                               value="{{old('password')}}">
                    </div>

                    <label class="col-sm-2 col-sm-2 control-label">ยืนยันรหัสผ่าน</label>
                    <div class="col-sm-4">
                        <input type="password" class="form-control" placeholder="confirm password"
                               name="password_confirmation">

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

</body>
</html>