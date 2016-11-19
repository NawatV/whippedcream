
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="Dashboard">
    <meta name="keyword" content="Dashboard, Bootstrap, Admin, Template, Theme, Responsive, Fluid, Retina">

    <title>Hospital OPD System</title>

    <!-- Bootstrap core CSS -->
    <link href="assets/css/bootstrap.css" rel="stylesheet">
    <!--external css-->
    <link href="assets/font-awesome/css/font-awesome.css" rel="stylesheet" />
    <link rel="stylesheet" type="text/css" href="assets/js/bootstrap-datepicker/css/datepicker.css" />
    <link rel="stylesheet" type="text/css" href="assets/js/bootstrap-daterangepicker/daterangepicker.css" />

    <!-- Custom styles for this template -->
    <link href="assets/css/style.css" rel="stylesheet">
    <link href="assets/css/style-responsive.css" rel="stylesheet">

    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
      <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>

  <body>

  <section id="container" >
      <!-- **********************************************************************************************************************************************************
      TOP BAR CONTENT & NOTIFICATIONS
      *********************************************************************************************************************************************************** -->
      <!--header start-->
      <header class="header black-bg">

            <!--logo start-->
            <a href="index.html" class="logo"><b>Whipped Cream</b></a>
            <!--logo end-->
            <div class="nav notify-row" id="top_menu">

            </div>

            <div class="top-menu">

            	<ul class="nav pull-right top-menu">
                <a href="index.html" class="logo" postion ="right" ><i class="fa fa-user"></i>  Mr. Someone&emsp;</a>
                    <li><a class="logout" href="login.html">Logout</a></li>
            	</ul>
            </div>
        </header>
      <!--header end-->

     <!-- **********************************************************************************************************************************************************
      MAIN SIDEBAR MENU
      *********************************************************************************************************************************************************** -->
      <!--sidebar start-->
      <aside>
          <div id="sidebar"  class="nav-collapse ">
              <!-- sidebar menu start-->
              <ul class="sidebar-menu" id="nav-accordion">



                  <li class="sub-menu">
                      <a href="javascript:;" >
                          <i class="fa fa-user"></i>
                          <span>Profile</span>
                      </a>
                      <ul class="sub">
                          <li><a  href="blank.html">Blank Page</a></li>
                          <li><a  href="login.html">Login</a></li>
                          <li><a  href="lock_screen.html">Lock Screen</a></li>
                      </ul>
                  </li>
                  <li class="sub-menu">
                      <a class="active" href="javascript:;" >
                          <i class="fa fa-plus-circle"></i>
                          <span>Make Appointment</span>
                      </a>

                  </li>
                    <li class="sub-menu">
                      <a href="javascript:;" >
                          <i class="fa fa-pencil-square"></i>
                          <span>Appointment</span>
                      </a>
                      <ul class="sub">
                          <li><a  href="blank.html">Blank Page</a></li>
                          <li><a  href="login.html">Login</a></li>
                          <li><a  href="lock_screen.html">Lock Screen</a></li>
                      </ul>
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
          <section class="wrapper">


          	<!-- BASIC FORM ELELEMNTS -->
          	<div class="row mt">
          		<div class="col-lg-12">
                  <div class="form-panel">
                  	  <h4 class="mb"><i class="fa fa-angle-right"></i> Make Appointment</h4>
                      <form class="form-horizontal style-form" method="get">
                          <div class="form-group">
                              <label class="col-sm-2 col-sm-2 control-label">SSN / HN</label>
                              <div class="col-sm-10">
                                  <input type="text" class="form-control">
                              </div>
                          </div>
                          <div class="form-group">
                              <label class="col-sm-2 col-sm-2 control-label">Basic Symptoms</label>
                              <div class="col-sm-10">
                                  <textarea class="form-control" id="exampleTextarea" rows="5"></textarea>
                              </div>
                          </div>
                           <div class="form-group">
                              <label class="col-sm-2 col-sm-2 control-label">Department</label>
            <div class="col-sm-10">
                                      <select class="form-control">
                            <option>Department of Ophthalmology</option>
                            <option>Department of Surgery</option>

            </select>
</div>

                          </div>
                            <div class="form-group">
                           <label class="col-sm-2 col-sm-2 control-label">Doctor</label>
                           <div class="col-sm-10">
                        <div class="radio">

              <label class="col-sm-4">
              <p class="left"><a href="profile.html"><img src="assets/img/question.jpeg" class="img-circle" width="100"></a></p>
                <input type="radio" name="optionsRadios" id="optionsRadios1" value="option1" checked>
                Random Doctor
              </label>
              <label class="col-sm-4">
              <p class="left"><a href="profile.html"><img src="assets/img/ui-sam.jpg" class="img-circle" width="100"></a></p>
                <input type="radio" name="optionsRadios" id="optionsRadios2" value="option2">
                Doctor House
              </label>
              <label class="col-sm-4">
              <p class="left"><a href="profile.html"><img src="assets/img/ui-sam.jpg" class="img-circle" width="100"></a></p>
                <input type="radio" name="optionsRadios" id="optionsRadios3" value="option3">
                Doctor Strange
              </label>
              </div>
              </div>
              </div>
                <div class="form-group">
                           <label class="col-sm-2 col-sm-2 control-label">Date</label>
                           <div class="col-sm-10">
                        <div class="radio">

              <label class="col-sm-12">
                <input type="radio" name="optionsRadios" id="optionsRadios1" value="option1" checked>
                Appointment Date : 01 / 11 / 2016
              </label>

              <label class="col-sm-12">
                <input type="radio" name="optionsRadios" id="optionsRadios2" value="option2">
                Custom Select
              </label>
             <hr>
              <div class="form-group">
                              <label class="col-sm-2 col-sm-2 control-label">Date</label>
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
                              <label class="col-sm-2 col-sm-2 control-label">Time</label>
                              <div class="col-sm-4">
                                  <div class="input-group date" data-provide="datepicker">
                                  <input type="text" class="form-control">
                                 <div class="input-group-addon">
                               <span class="glyphicon glyphicon-th"></span>
                                </div>
                                </div>
                              </div>
                          </div>

            </div>
            </div>
            </div>


                          </form>

                      </div>
                      </div>
                      </div>


                     <button type="button" class="btn pull-right btn-theme04 btn-lg">Confirm</button>
		</section><! --/wrapper -->

      </section><!-- /MAIN CONTENT -->

      <!--main content end-->
      <!--footer start-->

      <!--footer end-->
  </section>

    <!-- js placed at the end of the document so the pages load faster -->
    <script src="assets/js/jquery.js"></script>
    <script src="assets/js/bootstrap.min.js"></script>
    <script class="include" type="text/javascript" src="assets/js/jquery.dcjqaccordion.2.7.js"></script>
    <script src="assets/js/jquery.scrollTo.min.js"></script>
    <script src="assets/js/jquery.nicescroll.js" type="text/javascript"></script>


    <!--common script for all pages-->
    <script src="assets/js/common-scripts.js"></script>

    <!--script for this page-->
    <script src="assets/js/jquery-ui-1.9.2.custom.min.js"></script>

	<!--custom switch-->
	<script src="assets/js/bootstrap-switch.js"></script>

	<!--custom tagsinput-->
	<script src="assets/js/jquery.tagsinput.js"></script>

	<!--custom checkbox & radio-->

	<script type="text/javascript" src="assets/js/bootstrap-datepicker/js/bootstrap-datepicker.js"></script>
	<script type="text/javascript" src="assets/js/bootstrap-daterangepicker/date.js"></script>
	<script type="text/javascript" src="assets/js/bootstrap-daterangepicker/daterangepicker.js"></script>

	<script type="text/javascript" src="assets/js/bootstrap-inputmask/bootstrap-inputmask.min.js"></script>


	<script src="assets/js/form-component.js"></script>


  <script>
      //custom select box

      $(function(){
          $('select.styled').customSelect();
      });

  </script>

  </body>
</html>
