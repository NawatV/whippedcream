@extends('layouts.theme')

@section('css')
  <style>
    .dispensation-content div:hover
    {
      background-color: #F5F5F5;
    }

    .dispensation-list-wait
    {
      border-left: solid #78CD51 3px;
      margin-bottom: 2px;
      padding: 15px 0 15px 15px;
    }

    .dispensation-list-success
    {
      border-left: solid #41CAC0 3px;
      margin-bottom: 2px;
      padding: 15px 0 15px 15px;
    }

    .dispensation-list-cancel
    {
      border-left: solid #ff6c60 3px;
      margin-bottom: 2px;
      padding: 15px 0 15px 15px;
    }

    .ml
    {
      margin-left: 15px;
    }

    .mr
    {
      margin-right: 15px;
    }
  </style>
@endsection

@section('name')
  {{$name}}
@endsection

@section('content')
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
  <div class="row mt">
    <div class="col-lg-12">
      <div class="form-panel" style="height: 80vh">
        <div class="container-fluid" style="height: 100%;">
          <h4 class="mb"><i class="fa fa-angle-right"></i> &nbsp;จ่ายยา</h4>

          <div class="dispensation-content"  style="height:85%; overflow: auto">

            @if(count($dispense_list) > 0)
              @foreach($dispense_list as $list)
                @if(is_null($list['status']))
                  <div class="dispensation-list-wait">
                    <i class="fa fa-info" aria-hidden="true"></i>
                    <span class="ml"><span class="name">{{ $list['name'] }}</span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;หมายเลขใบสั่งยา : <span class="index">{{ $list['index'] }}</span></span>
                    <span class="badge bg-success ml status">Waiting</span>
                    <div class="pull-right mr button-group">
                      <button class="btn btn-success btn-xs fa fa-check confirm"></button>
                      <button class="btn btn-primary btn-xs fa fa-pencil edit"></button>
                    </div>
                  </div>
                @elseif($list['status'])
                  <div class="dispensation-list-success">
                    <i class="fa fa-info" aria-hidden="true"></i>
                    <span class="ml"><span class="name">{{ $list['name'] }}</span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;หมายเลขใบสั่งยา : <span class="index">{{ $list['index'] }}</span></span>
                    <span class="badge bg-theme ml status">Done</span>
                  </div>
                @else
                  <div class="dispensation-list-cancel">
                    <i class="fa fa-info" aria-hidden="true"></i>
                    <span class="ml"><span class="name">{{ $list['name'] }}</span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;หมายเลขใบสั่งยา : <span class="index">{{ $list['index'] }}</span></span>
                    <span class="badge bg-important ml status">Cancel</span>
                  </div>
                @endif
              @endforeach
            @endif

          </div>

        </div>
      </div>
    </div>
  </div>

@endsection

@section('special-content')
  <div class="modal fade" tabindex="-1" role="dialog" id="prescription-list">
    <div class="modal-dialog modal-md" role="document">
      <div class="modal-content">
        <div class="modal-header" style="border-radius:5px 5px 0 0; text-align:center">
          <h4 class="modal-title">รายการยา</h4>
        </div>
        <div class="modal-body" id="prescription-list-content" >
        </div>
      </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
  </div><!-- /.modal -->


  <div class="modal fade" tabindex="-1" role="dialog" id="edit-prescription">
    <div class="modal-dialog modal-md" role="document">
      <div class="modal-content">
        <div class="modal-header" style="border-radius:5px 5px 0 0; text-align:center">
          <h4 class="modal-title">แก้ไขรายการยา</h4>
        </div>
        <div class="modal-body" >
          <form class="form-horizontal" method="post" action="{{url('/dispensation')}}">
            <input type="hidden" name="_token" value="{{csrf_token()}}">
            <input type="hidden" id="pct_id" name="prescriptionId" value="">
            <div class="form-group" style="padding-left:15px; padding-right:15px">
              <label>รายละเอียด</label>
              <textarea class="form-control" style="resize: none;" rows="5" name="edit-detail"></textarea>
              <input type="submit" class="btn btn-primary form-control mt" value="ส่งการแก้ไข">
            </div>
          </form>
        </div>
      </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
  </div><!-- /.modal -->
@endsection

@section('script')
  <script>
    $(document).ready(function(){
      $('.dispensation-content').on('click', 'div', function(){

        var prescriptionId = $(this).find('.index').text();

        $.ajax({
          url: '/dispensation/'+ prescriptionId,
          success: function(response){

            if(response == "failed") location.reload();

            var drug_list = "";

            for(var i = 0; i < response.drugs.length; i++){
              drug_list += "<div class='row mb'>\
                              <div class='col-sm-6'><b>ยา : </b>" + response.drugs[i]['drugName'] + "</div>\
                              <div class='col-sm-6'><b>จำนวน : </b>" + response.drugs[i]['drugAmount'] + " เม็ด</div>\
                              <div class='col-sm-12' style='margin-top: 10px;'><b>วิธีใช้ : </b>" + response.drugs[i]['drugUsage'] + "</div>\
                            </div><hr style='border-color:#e0e0e0; background-color:#e0e0e0'>";
            }

            $("#prescription-list-content").html(drug_list);

            $('#prescription-list').modal('toggle');
          }
        });

      });

      var num  = $('.dispensation-content > div').length;

              @php
                $index_list = [];
                foreach($dispense_list as $list){
                  if(is_null($list['status'])) array_push($index_list, $list['index']);
                }
              @endphp

      var list = {{json_encode($index_list)}};


      $('.dispensation-content').on('click', '.confirm', function(event){
        event.stopPropagation();

        var prescriptionId = $(this).parents('.dispensation-list-wait').find('.index').text();

        $(this).parents('.dispensation-list-wait').attr('id','confirm-list');

        $.ajax({
          url: '/dispensation/confirm/' + prescriptionId,
          success: function(response){
            if(response == "success") {
              $('.dispensation-content').append($('#confirm-list'));

              $('#confirm-list').find('.status').removeClass('bg-success').addClass('bg-theme').html("Done");

              $('#confirm-list').removeClass('dispensation-list-wait').addClass('dispensation-list-success');

              $('#confirm-list .button-group').remove();

              $('#confirm-list').removeAttr('id');

              var i = list.indexOf(parseInt(prescriptionId));

              if(i != -1){
                list.splice(i,1);
              }

            }else {
              location.reload();
            }
          }
        });
      });

      $('.dispensation-content').on('click', '.edit', function(event){
        event.stopPropagation();
        var index = $(this).parents('.dispensation-list-wait').find('.index').text();
        $('#pct_id').attr('value', index);
        $('#edit-prescription').modal('toggle');
      });


      setInterval(function(){
        $.ajax({
          url: '/dispensation/list?num=' + num + '&list=' + list,
          success: function(response){
            if(response !== "success"){
              for(var i = 0; i < response.length; i++){

                var node = '<div class="dispensation-list-wait">\
                  <i class="fa fa-info" aria-hidden="true"></i>\
                  <span class="ml"><span class="name">'+ response[i]['name'] +'</span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;หมายเลขใบสั่งยา : <span class="index">'+ response[i]['index'] +'</span></span>\
                  <span class="badge bg-success ml status">Waiting</span>\
                  <div class="pull-right mr button-group">\
                    <button class="btn btn-success btn-xs fa fa-check confirm"></button>\
                    <button class="btn btn-primary btn-xs fa fa-pencil edit"></button>\
                  </div>\
                </div>'

                $('.dispensation-content > *').eq(list.length-1).after(node);

                list.push(response[i]['index']);
                ++num;
              }
            }
          }

        });
      }, 5000);


    });
  </script>
@endsection
