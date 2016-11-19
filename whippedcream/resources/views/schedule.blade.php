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
                      <a class="active" href="javascript:;" >
                          <i class="fa fa-calendar"></i>
                          <span>Schedule</span>
                      </a>

                  </li>
                  <li class="sub-menu">
                      <a  href="javascript:;" >
                          <i class="fa fa-pencil-square"></i>
                          <span>Appointment</span>
                      </a>
                      <ul class="sub">
                          <li><a  href="form_component.html">Make Appointment</a></li>
                          <li><a  href="blank.html">Cancle Appointment</a></li>
                          <li><a  href="login.html">Edit Appointment</a></li>
                      </ul>
                  </li>
                   <li class="sub-menu">
                      <a  href="javascript:;" >
                          <i class="fa fa-heart"></i>
                          <span>Diagnosis and Prescription</span>
                      </a>
                      <ul class="sub">
                          <li><a  href="form_component.html">Make Appointment</a></li>
                          <li><a  href="blank.html">Cancle Appointment</a></li>
                          <li><a  href="login.html">Edit Appointment</a></li>
                      </ul>
                  </li>
                   <li class="sub-menu">
                      <a  href="javascript:;" >
                          <i class="fa fa-group"></i>
                          <span>Patient Information</span>
                      </a>
                      <ul class="sub">
                          <li><a  href="form_component.html">Make Appointment</a></li>
                          <li><a  href="blank.html">Cancle Appointment</a></li>
                          <li><a  href="login.html">Edit Appointment</a></li>
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

          <div class="row mt">
            <div class="col-lg-12">
                      <div class="content-panel">
                      <h4><i class="fa fa-angle-right"></i> Daily Schedule</h4>
                          <section id="unseen">
                            <table class="table table-bordered table-striped table-condensed">
                              <thead>
                              <tr>
                                  <th>Time</th>
                                  <th>Monday</th>
                                  <th>Tuesday</th>
                                  <th>Wednesday</th>
                                  <th>Thursday</th>
                                  <th>Friday</th>
                                  <th>Saturday</th>
                                  <th>Sunday</th>

                              </tr>
                              </thead>
                              <tbody>
                              <tr>
                                  <td>Morning</td>
                                  <td class = "centered"></td>
                                  <td class = "centered">+</td>
                                  <td class = "centered"></td>
                                  <td class = "centered">+</td>
                                  <td class = "centered"></td>
                                  <td class = "centered">+</td>
                                  <td class = "centered">+</td>

                              </tr>
                              <tr>
                                  <td>Afternoon</td>
                                  <td class = "centered">+</td>
                                  <td class = "centered">+</td>
                                  <td class = "centered"></td>
                                  <td class = "centered"></td>
                                  <td class = "centered"></td>
                                  <td class = "centered"></td>
                                  <td class = "centered">+</td>
                              </tr>

                              </tbody>
                          </table>
                          </section>



                  </div><!-- /content-panel -->
               </div><!-- /col-lg-4 -->
        </div><!-- /row -->
         <div class="row mt">
            <div class="col-lg-10">
                <div class="form-panel">
                      <h4 class="mb"><i class="fa fa-angle-right"></i> Absent</h4>

                       <div class="form-group">
                        <h5> Absent Date : 01 / 12 / 2016 - Morning</h5>
                      <h5> Absent Date : 06 / 12 / 2016 - Afternoon</h5>
                              <label class="col-sm-2 col-sm-2 control-label">Absent Date</label>

                                  <div class="input-group date" data-provide="datepicker">
                                  <input type="text" class="form-control">
                                 <div class="input-group-addon">
                               <span class="glyphicon glyphicon-plus"></span>
                                </div>
                                </div>

                          </div>
                </div><!-- /form-panel -->
              </div><!-- /col-lg-12 -->
              </div>


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
