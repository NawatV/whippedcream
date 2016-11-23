@extends('layouts.theme')

@section('name')
    {{session('name')}}
@endsection

@section('content')


    @if (session('alertConfirmAbsent'))
        <script>
            swal("ทำการลาสำเร็จ", "", "success");
            {{session()->forget('alertConfirmAbsent')}}
        </script>
    @endif
    @if (session('errorSameLeave'))
        <script>
            swal("ไม่สามารถทำการลาได้", "วันที่ต้องการลา มีการถูกลาเรียบร้อยแล้ว กรุณาแก้ไขบันทึกนั้น แทนการทำลาครั้งใหม่", "error");
            {{session()->forget('errorSameLeave')}}
        </script>
    @endif



    <script>
        var sss = <?php echo $sche ?>;
        //        console.log(sss);

        $(function (workday) {
            $("#datepicker").datepicker({
                dateFormat: "yy/mm/dd",
                minDate: "+1d",
                beforeShowDay: function (date) {
                    var day = date.getDay();
                    var dd = date.getDate();
                    var mm = date.getMonth() + 1;
                    var yy = date.getFullYear();
                    //ทำให้ format ตรง จาก วันที่ 3 ให้เป็น  03
                    if (dd < 10) dd = '0' + dd;
                    if (mm < 10) mm = '0' + mm;

                    var thisDate = yy + '-' + mm + '-' + dd;
//                    console.log(day);

                    if (day == 0 && sss.sunPeriod != 0) return [true, ''];
                    else if (day == 1 && sss.monPeriod != 0) return [true, ''];
                    else if (day == 2 && sss.tuePeriod != 0) return [true, ''];
                    else if (day == 3 && sss.wedPeriod != 0) return [true, ''];
                    else if (day == 4 && sss.thuPeriod != 0) return [true, ''];
                    else if (day == 5 && sss.friPeriod != 0) return [true, ''];
                    else if (day == 6 && sss.satPeriod != 0) return [true, ''];
                    return [false, ''];

                },
                onSelect: function (date) {
                    $.ajax({
                        url: "/queryAbsentPeriod",
                        data: {
                            day: $("#datepicker").datepicker("getDate").getDay(),
                            date: $("#datepicker").datepicker("getDate").getDate(),
                            month: $("#datepicker").datepicker("getDate").getMonth() + 1,
                            year: $("#datepicker").datepicker("getDate").getFullYear()
                        },
                        success: function (result) {
                            console.log(result)
                            $("#time").empty();
                            if (result == "1") {
                                $("#time").append('<input type="radio" name="absentperiod" value="1" checked="checked"> Morning<br>');
                                $("#time").append('<input type="radio" name="absentperiod" value="2" disabled> Afternoon<br>');
                                $("#time").append('<input type="radio" name="absentperiod" value="3" disabled> The whole day<br>');
                            } else if (result == "2") {
                                $("#time").append('<input type="radio" name="absentperiod" value="1" disabled> Morning<br>');
                                $("#time").append('<input type="radio" name="absentperiod" value="2" checked="checked"> Afternoon<br>');
                                $("#time").append('<input type="radio" name="absentperiod" value="3" disabled> The whole day<br>');
                            } else if (result == "3") {
                                $("#time").append('<input type="radio" name="absentperiod" value="1"> Morning<br>');
                                $("#time").append('<input type="radio" name="absentperiod" value="2"> Afternoon<br>');
                                $("#time").append('<input type="radio" name="absentperiod" value="3"> The whole day<br>');
                            }
                        }
                    });
                }
            });
        });

        $

    </script>


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

                                <!--MUST HAVE IT"S AN EXCEPTION-->
                                <input type="hidden" name="_token" value="{{csrf_token()}}">

                                <input type="text" class="form-control" placeholder="เลือกวันที่ต้องการลา" name="absentdate"
                                       id="datepicker">

                                <div class="col-sm-9 radio"   id="time"></div>
                                {{--<input id="time" type="radio" name="absentperiod" value="1"> Morning<br>--}}
                                {{--<input type="radio" name="absentperiod" value="2"> Afternoon<br>--}}
                                {{--<input type="radio" name="absentperiod" value="3"> The whole day<br>--}}
                                <button class="btn btn-theme col-sm-5" type="submit"></i>add</button>


                            </form>
                        </div>


                    </div>

                </div><!-- /form-panel -->
            </div><!-- /col-lg-12 -->
        </div>

    </div>



@endsection