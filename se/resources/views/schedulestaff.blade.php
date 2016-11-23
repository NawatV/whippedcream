<?php
  //---- for transfering the data into symbols  
  //Schedule
if($pack != NULL){
  $mon = $pack['sche'] -> monPeriod;
  $tue = $pack['sche'] -> tuePeriod;
  $wed = $pack['sche'] -> wedPeriod;
  $thu = $pack['sche'] -> thuPeriod;
  $fri = $pack['sche'] -> friPeriod;
  $sat = $pack['sche'] -> satPeriod;
  $sun = $pack['sche'] -> sunPeriod;

  $weektmp = array();
  $weektmp[0] = $mon;
  $weektmp[1] = $tue;
  $weektmp[2] = $wed;
  $weektmp[3] = $thu;
  $weektmp[4] = $fri;
  $weektmp[5] = $sat;
  $weektmp[6] = $sun;

  $week = array();

  for($i=0; $i<=6; $i++){
      if($weektmp[$i]==0){
          $week[$i][0] = " ";
          $week[$i][1] = " ";
      }
      else if($weektmp[$i]==1){
          $week[$i][0] = "+";
          $week[$i][1] = " ";
      }
      else if($weektmp[$i]==2){
          $week[$i][0] = " ";
          $week[$i][1] = "+";
      }
      else if($weektmp[$i]==3){
          $week[$i][0] = "+";
          $week[$i][1] = "+";
      }

  }

  $abs = $pack['abs'];  //Haven't check error cases yet
  $c =0 ;
  foreach($pack['abs'] as $i) {
    if($i->leavePeriod == "1") $abs[$c] -> leavePeriod = "morning"; 
    else if($i->leavePeriod == "2") $abs[$c] -> leavePeriod = "afternoon";
    else if($i->leavePeriod =="3") $abs[$c] -> leavePeriod = "the whole day";
    $c ++;
  }

}

else {
  $week = array();
  for($i=0; $i<=6; $i++){
    $week[$i][0]=" ";
    $week[$i][1]=" "; 
  }

  //here----
  /*
  $abs = $pack['abs'];  //Haven't check error cases yet
  $c =0 ;
  foreach($pack['abs'] as $i) {
    if($i->leavePeriod == "1") $abs[$c] -> leavePeriod = "morning"; 
    else if($i->leavePeriod == "2") $abs[$c] -> leavePeriod = "afternoon";
    else if($i->leavePeriod =="3") $abs[$c] -> leavePeriod = "the whole day";
    $c ++;
  }*/
  $abs = array();

}

?>

<!DOCTYPE html>
<html lang="en">
  <head>
      <!--for calendar-->
      <link href="https://code.jquery.com/ui/1.10.4/themes/ui-lightness/jquery-ui.css" rel="stylesheet">
      <script src="https://code.jquery.com/jquery-1.10.2.js"></script>
      <script src="https://code.jquery.com/ui/1.10.4/jquery-ui.js"></script>

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

    <script>
        $(function () {
            $("#datepicker").datepicker();
        });
    </script>

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

            <!--serach box for staff-->
         <form class="navbar-form navbar-right" method="post" action="{{url('/schedulestaff')}}" >

              <input type="hidden" name="_token" value="{{csrf_token()}}">
              <input type="text" name="searchId" class="form-control" placeholder="Search...">

            <button class="btn btn-default" type="submit" id="searchButton" >
                <img src="img/searchButton.png">
            </button>

          </form>


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
                                  <td class = "centered">{{$week[0][0]}}</td>
                                  <td class = "centered">{{$week[1][0]}}</td>
                                  <td class = "centered">{{$week[2][0]}}</td>
                                  <td class = "centered">{{$week[3][0]}}</td>
                                  <td class = "centered">{{$week[4][0]}}</td>
                                  <td class = "centered">{{$week[5][0]}}</td>
                                  <td class = "centered">{{$week[6][0]}}</td>

                              </tr>
                              <tr>
                                  <td>Afternoon</td>
                                  <<td class = "centered">{{$week[0][1]}}</td>
                                  <td class = "centered">{{$week[1][1]}}</td>
                                  <td class = "centered">{{$week[2][1]}}</td>
                                  <td class = "centered">{{$week[3][1]}}</td>
                                  <td class = "centered">{{$week[4][1]}}</td>
                                  <td class = "centered">{{$week[5][1]}}</td>
                                  <td class = "centered">{{$week[6][1]}}</td>
                              </tr>
                            
                              </tbody>
                          </table>
                          </section>



                  </div><!-- /content-panel -->
               </div><!-- /col-lg-4 -->
        </div><!-- /row -->

    <!--Add absentDate (for Doctor)-->
         <div class="row mt">
            <div class="col-lg-10">
                <div class="form-panel">
                      <h4 class="mb"><i class="fa fa-angle-right"></i> Absent</h4>
                      <div class="form-group">

                    @foreach ($abs as $d)
                        <h5>Absent Date {{$d -> leaveDate}} - {{$d-> leavePeriod }}</h5>
                    @endforeach
                       </div>
                </div>
            </div>
         </div>              

		</section> 

      </section><!-- /MAIN CONTENT -->

      <!--main content end-->
      <!--footer start-->

      <!--footer end-->
  </section>

<!-- for dropdownlist and change content -->
  <script type="text/javascript">
    $(document).ready(function () {
  $('.group').hide();
  $('#option1').show();
  $('#selectMe').change(function () {
    $('.group').hide();
    $('#'+$(this).val()).show();
  })
});
</script>

<!-- force to choose at most 1 (checkbox) -->
<script type="text/javascript">
$('input[type="checkbox"]').on('change', function() {
   $(this).siblings('input[type="checkbox"]').prop('checked', false);
});
</script>

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
