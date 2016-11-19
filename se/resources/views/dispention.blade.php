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
                    <li><a href="index.html" class="logo" postion ="right" ><i class="fa fa-user"></i>  Mr. Someone</a><li>
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
                      <a class = "active"  href="javascript:;" >
                          <i class="fa fa-plus-square"></i>
                          <span>Dispention</span>
                      </a>

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

   ******************************* -->
      <!--main content start-->
      <section id="main-content">
          <section class="wrapper">
            <h3><i class="fa fa-angle-right"></i>Dispention</h3>




            <!-- SORTABLE TO DO LIST -->

              <div class="row mt mb">
                  <div class="col-md-12">
                      <section class="task-panel tasks-widget">

                          <div class="panel-body">
                              <div class="task-content">
                                  <ul id="sortable" class="task-list">


                                      <li class="list-success">
                                          <i class=" fa fa-ellipsis-v"></i>

                                          <div class="task-title">
                                              <span class="task-title-sp"><a href = "#">Miss Emma Stone</a> - 29/10/2016 - Morning</span>
                                              <span class="badge bg-success">Waiting</span>
                                              <div class="pull-right hidden-phone">
                                                  <button class="btn btn-success btn-xs fa fa-check"></button>
                                                  <button class="btn btn-primary btn-xs fa fa-pencil"></button>

                                              </div>
                                          </div>
                                      </li>
                                       <li class="list-success">
                                          <i class=" fa fa-ellipsis-v"></i>

                                          <div class="task-title">
                                              <span class="task-title-sp"><a href = "#">Mr. Peter Parker</a> - 29/10/2016 - Morning</span>
                                              <span class="badge bg-success">Waiting</span>
                                              <div class="pull-right hidden-phone">
                                                  <button class="btn btn-success btn-xs fa fa-check"></button>
                                                  <button class="btn btn-primary btn-xs fa fa-pencil"></button>

                                              </div>
                                          </div>
                                      </li>
                                       <li class="list-success">
                                          <i class=" fa fa-ellipsis-v"></i>

                                          <div class="task-title">
                                              <span class="task-title-sp"><a href = "#">Miss Emilia Clarke</a> - 29/10/2016 - Morning</span>
                                              <span class="badge bg-success">Waiting</span>
                                              <div class="pull-right hidden-phone">
                                                  <button class="btn btn-success btn-xs fa fa-check"></button>
                                                  <button class="btn btn-primary btn-xs fa fa-pencil"></button>

                                              </div>
                                          </div>
                                      </li>
                                       <li class="list-success">
                                          <i class=" fa fa-ellipsis-v"></i>

                                          <div class="task-title">
                                              <span class="task-title-sp"><a href = "#">Mr. Bean</a> - 29/10/2016 - Morning</span>
                                              <span class="badge bg-success">Waiting</span>
                                              <div class="pull-right hidden-phone">
                                                  <button class="btn btn-success btn-xs fa fa-check"></button>
                                                  <button class="btn btn-primary btn-xs fa fa-pencil"></button>

                                              </div>
                                          </div>
                                      </li>
                                        <li class="list-primary">
                                          <i class=" fa fa-ellipsis-v"></i>

                                          <div class="task-title">
                                              <span class="task-title-sp"><a href = "#">Mr. Robot</a> - 29/10/2016 - Morning</span>
                                              <span class="badge bg-theme">Done</span>
                                              <div class="pull-right hidden-phone">


                                              </div>
                                          </div>

                                      </li>
                                      <li class="list-primary">
                                          <i class=" fa fa-ellipsis-v"></i>

                                          <div class="task-title">
                                              <span class="task-title-sp"><a href = "#">Mr. Tom Cruise</a> - 29/10/2016 - Morning</span>
                                              <span class="badge bg-theme">Done</span>
                                              <div class="pull-right hidden-phone">


                                              </div>
                                          </div>

                                      </li>
                                      <li class="list-primary">
                                          <i class=" fa fa-ellipsis-v"></i>

                                          <div class="task-title">
                                              <span class="task-title-sp"><a href = "#">Miss Emma Watson</a> - 29/10/2016 - Morning</span>
                                              <span class="badge bg-theme">Done</span>
                                              <div class="pull-right hidden-phone">


                                              </div>
                                          </div>

                                      </li>
                                        <li class="list-info">
                                          <i class=" fa fa-ellipsis-v"></i>

                                          <div class="task-title">
                                              <span class="task-title-sp"><a href = "#">Miss You Somuch</a> - 29/10/2016 - Morning</span>
                                              <span class="badge bg-important">Cancel</span>
                                              <div class="pull-right hidden-phone">

                                              </div>
                                          </div>
                                      </li>

                                  </ul>
                              </div>
                          </div>
                           <div class=" add-task-row">

                                  <a class="btn btn-default btn-sm pull-right" href="todo_list.html#">See All Lists</a>
                              </div>
                      </section>
                  </div><!--/col-md-12 -->
              </div><!-- /row -->

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
  <script src="http://code.jquery.com/ui/1.10.3/jquery-ui.js"></script>
    <script src="assets/js/tasks.js" type="text/javascript"></script>

    <script>
      jQuery(document).ready(function() {
          TaskList.initTaskWidget();
      });

      $(function() {
          $( "#sortable" ).sortable();
          $( "#sortable" ).disableSelection();
      });

    </script>


  <script>
      //custom select box

      $(function(){
          $('select.styled').customSelect();
      });

  </script>

  </body>
</html>
