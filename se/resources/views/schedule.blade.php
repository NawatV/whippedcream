@extends('layouts.theme')

@section('name')
    {{session('name')}}
@endsection

@section('content')

    <?php
    //---- for transfering the data into symbols
    //Schedule
    if ($pack != NULL) {
        $mon = $pack['sche']->monPeriod;
        $tue = $pack['sche']->tuePeriod;
        $wed = $pack['sche']->wedPeriod;
        $thu = $pack['sche']->thuPeriod;
        $fri = $pack['sche']->friPeriod;
        $sat = $pack['sche']->satPeriod;
        $sun = $pack['sche']->sunPeriod;

        $weektmp = array();
        $weektmp[0] = $mon;
        $weektmp[1] = $tue;
        $weektmp[2] = $wed;
        $weektmp[3] = $thu;
        $weektmp[4] = $fri;
        $weektmp[5] = $sat;
        $weektmp[6] = $sun;

        $week = array();

        for ($i = 0; $i <= 6; $i++) {
            if ($weektmp[$i] == 0) {
                $week[$i][0] = " ";
                $week[$i][1] = " ";
            } else if ($weektmp[$i] == 1) {
                $week[$i][0] = "+";
                $week[$i][1] = " ";
            } else if ($weektmp[$i] == 2) {
                $week[$i][0] = " ";
                $week[$i][1] = "+";
            } else if ($weektmp[$i] == 3) {
                $week[$i][0] = "+";
                $week[$i][1] = "+";
            }

        }

        $abs = $pack['abs'];  //Haven't check error cases yet
        $c = 0;
        foreach ($pack['abs'] as $i) {
            if ($i->leavePeriod == "1") $abs[$c]->leavePeriod = "morning";
            else if ($i->leavePeriod == "2") $abs[$c]->leavePeriod = "afternoon";
            else if ($i->leavePeriod == "3") $abs[$c]->leavePeriod = "the whole day";
            $c++;
        }

    } else {
        $week = array();
        for ($i = 0; $i <= 6; $i++) {
            $week[$i][0] = " ";
            $week[$i][1] = " ";
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

    <div class="paddingFormCreate">

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
                                <td class="centered">{{$week[0][0]}}</td>
                                <td class="centered">{{$week[1][0]}}</td>
                                <td class="centered">{{$week[2][0]}}</td>
                                <td class="centered">{{$week[3][0]}}</td>
                                <td class="centered">{{$week[4][0]}}</td>
                                <td class="centered">{{$week[5][0]}}</td>
                                <td class="centered">{{$week[6][0]}}</td>

                            </tr>
                            <tr>
                                <td>Afternoon</td>
                                <
                                <td class="centered">{{$week[0][1]}}</td>
                                <td class="centered">{{$week[1][1]}}</td>
                                <td class="centered">{{$week[2][1]}}</td>
                                <td class="centered">{{$week[3][1]}}</td>
                                <td class="centered">{{$week[4][1]}}</td>
                                <td class="centered">{{$week[5][1]}}</td>
                                <td class="centered">{{$week[6][1]}}</td>
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

                        @foreach ($abs as $d)
                            <h5>Absent Date {{$d -> leaveDate}} - {{$d-> leavePeriod }}</h5>
                        @endforeach

                        <div class="col-lg-10">

                            <form class="form-login " method="post" action="/schedule">

                                <!--<div class="form-group">-->
                                <!--<div class=col-md-6>-->

                                <!--MUST HAVE IT"S AN EXCEPTION-->
                                <input type="hidden" name="_token" value="{{csrf_token()}}">

                                <input type="text" class="form-control" placeholder="absentDate" name="absentdate"
                                       id="datepicker">
                                <!--
                                <div class="input-group">
                                  <input type="text" class="form-control" placeholder="absentPeriod" name="absentdate" id="option1">

                                  <input type="text" class="form-control" placeholder="absentPeriod" name="absentdate" id="option2">

                                  <div id="option1" class="form-control group">morning</div>
                                  <div id="option2" class="form-control group">afternoon</div>
                                  <select id="selectMe">
                                    <option value="option1">morning</option>
                                    <option value="option2">afternoon</option>
                                  </select>

                                </div>
                                -->

                                <input type="checkbox" name="absentperiod" value="1">Morning<br>
                                <input type="checkbox" name="absentperiod" value="2">Afternoon<br>
                                <input type="checkbox" name="absentperiod" value="3">The whole day<br>
                                <button class="btn btn-theme col-sm-5" type="submit"></i>add</button>

                                <!--</div>-->
                                <!--
                                <div class=col-md-5>
                                     <div class="form-group">
                                        <button class="btn btn-theme col-sm-5" type="submit"></i>add</button>
                                     </div>
                                </div>
                                -->
                            </form>
                        </div>


                    </div>

                </div><!-- /form-panel -->
            </div><!-- /col-lg-12 -->
        </div>

    </div>



@endsection