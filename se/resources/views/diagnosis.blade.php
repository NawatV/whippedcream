@extends('layouts.theme')

@section('css')
@endsection

@section('name')
    {{session('name')}}
@endsection

@section('content')
    <div class="row mt">
        <div class="col-lg-12">
            <div class="form-panel">
                <div class="container-fluid">
                    <h4 class="mb"><i class="fa fa-angle-right"></i> &nbsp;บันทึกคำวินิจฉัยและสั่งยา</h4>

                    <form class="form-horizontal style-form" method="post" action="{{url('/diagnosis')}}">
                        <input type="hidden" name="_token" value="{{csrf_token()}}">
                        <div class="form-group">
                            <label class="col-sm-2 control-label">HN</label>
                            <div class="col-sm-4">
                                <input type="text" class="form-control" name="hn" value="{{old('hn')}}">
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-2 control-label">ชื่อ</label>
                            <div class="col-sm-4">

                                <input type="text" class="form-control" name="firstname" value="{{old('firstname')}}">
                            </div>
                            <label class="col-sm-2 control-label">นามสกุล</label>
                            <div class="col-sm-4">
                                <input type="text" class="form-control" name="lastname" value="{{old('lastname')}}">
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-2 control-label">รหัสโรค</label>
                            <div class="col-sm-4">
                                <select class="form-control" name="symptomcode">
                                    <option value="icd10" {{ old('symptomcode') == 'icd10' ? 'selected' : ''}} >ICD10
                                    </option>
                                    <option value="snowmed" {{ old('symptomcode') == 'snowmed' ? 'selected' : ''}} >
                                        SNOWMED
                                    </option>
                                    <option value="drg" {{ old('symptomcode') == 'drg' ? 'selected' : ''}} >DRG</option>
                                </select>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-2 control-label">รายละเอียดการวินิจฉัย</label>
                            <div class="col-sm-10">
                                <textarea class="form-control" rows="5" style="resize:vertical"
                                          name="details">{{ old('details') }}</textarea>
                            </div>
                        </div>

                        @if(old('drug1'))
                            @php
                                $num = 1
                            @endphp

                            @while(true)
                                @if(old('drug'.$num))
                                    <div class="form-group {{'drugGroup'.$num}}">
                                        <label class="col-sm-2 control-label">ยา</label>
                                        <div class="col-sm-4">
                                            <select class="form-control" id="{{'drug'.$num}}" name="{{'drug'.$num}}">
                                                <option disabled {{ old('drug'.$num) ? '' : 'selected'}} >-- Select
                                                    Medicine --
                                                </option>
                                                <option {{ old('drug'.$num) == 'Aspirin'? 'selected' : ''}} >Aspirin
                                                </option>
                                                <option {{ old('drug'.$num) == 'Chlorpheniramine Maleate'? 'selected' : ''}} >
                                                    Chlorpheniramine Maleate
                                                </option>
                                                <option {{ old('drug'.$num) == 'Dimenhydrinate'? 'selected' : ''}} >
                                                    Dimenhydrinate
                                                </option>
                                                <option {{ old('drug'.$num) == 'Mebendazole'? 'selected' : ''}} >
                                                    Mebendazole
                                                </option>
                                                <option {{ old('drug'.$num) == 'Paracetamol'? 'selected' : ''}} >
                                                    Paracetamol
                                                </option>
                                                <option {{ old('drug'.$num) == 'Ponstan'? 'selected' : ''}} >Ponstan
                                                </option>
                                            </select>
                                        </div>

                                        <label class="col-sm-2 control-label">ปริมาณ</label>
                                        <div class="col-sm-4">
                                            <input type="text" class="form-control" id="{{'quantity'.$num}}"
                                                   name="{{'quantity'.$num}}"
                                                   value="{{old('quantity'.$num)}}" {{ old('drug'.$num) ? '' : 'disabled'}}>
                                        </div>
                                    </div>

                                    <div class="form-group {{'drugGroup'.$num}}">
                                        <label class="col-sm-2 control-label">วิธีใช้</label>
                                        <div class="col-sm-10">
                                            <textarea class="form-control" rows="5" style="resize:vertical"
                                                      id="{{'usage'.$num}}"
                                                      name="{{'usage'.$num}}" {{ old('drug'.$num) ? '' : 'disabled'}}>{{old('usage'.$num)}}</textarea>
                                        </div>
                                    </div>
                                @else
                                    @break
                                @endif

                                @php
                                    $num++
                                @endphp

                            @endwhile

                        @else
                            <div class="form-group drugGroup1">
                                <label class="col-sm-2 control-label">ยา</label>
                                <div class="col-sm-4">
                                    <select class="form-control" id="drug1" name="drug1">
                                        <option disabled {{ old('drug1') ? '' : 'selected'}} >-- Select Medicine --
                                        </option>
                                        <option {{ old('drug1') == 'Aspirin'? 'selected' : ''}} >Aspirin</option>
                                        <option {{ old('drug1') == 'Chlorpheniramine Maleate'? 'selected' : ''}} >
                                            Chlorpheniramine Maleate
                                        </option>
                                        <option {{ old('drug1') == 'Dimenhydrinate'? 'selected' : ''}} >Dimenhydrinate
                                        </option>
                                        <option {{ old('drug1') == 'Mebendazole'? 'selected' : ''}} >Mebendazole
                                        </option>
                                        <option {{ old('drug1') == 'Paracetamol'? 'selected' : ''}} >Paracetamol
                                        </option>
                                        <option {{ old('drug1') == 'Ponstan'? 'selected' : ''}} >Ponstan</option>
                                    </select>
                                </div>

                                <label class="col-sm-2 control-label">ปริมาณ</label>
                                <div class="col-sm-4">
                                    <input type="text" class="form-control" id="quantity1" name="quantity1"
                                           value="{{old('quantity1')}}" {{ old('drug1') ? '' : 'disabled'}}>
                                </div>
                            </div>

                            <div class="form-group drugGroup1">
                                <label class="col-sm-2 control-label">วิธีใช้</label>
                                <div class="col-sm-10">
                                    <textarea class="form-control" rows="5" style="resize:vertical" id="usage1"
                                              name="usage1" {{ old('drug1') ? '' : 'disabled'}}>{{old('usage1')}}</textarea>
                                </div>
                            </div>
                        @endif

                        <div class="form-group" id="inc-dec">
                            <div class="col-sm-12">
                                <button type="button" class="btn btn-danger pull-right ml" id="decrease">
                                    <i class="fa fa-minus" aria-hidden="true"></i>&nbsp;&nbsp;ลดยา
                                </button>

                                <button type="button" class="btn btn-info pull-right" id="increase">
                                    <i class="fa fa-plus" aria-hidden="true"></i>&nbsp;&nbsp;เพิ่มยา
                                </button>
                            </div>
                        </div>

                        <div class="mt">
                            <input type="submit" class="btn btn-primary pull-right" value="บันทึก">
                        </div>

                    </form>
                </div>
            </div>
            @endsection

            @section('special-content')
                <div class="modal fade" tabindex="-1" role="dialog" id="error-modal">
                    <div class="modal-dialog modal-md" role="document">
                        <div class="modal-content">
                            <div class="modal-header" style="border-radius:5px 5px 0 0; text-align:center">
                                <h4 class="modal-title">ข้อผิดพลาด</h4>
                            </div>
                            <div class="modal-body" style="text-align:center; padding-left:11px; padding-right:11px">
                                @if(count($errors) > 0)
                                    @foreach($errors->all() as $error)
                                        <h5>{{$error}}</h5>
                                    @endforeach
                                @endif
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                            </div>
                        </div><!-- /.modal-content -->
                    </div><!-- /.modal-dialog -->
                </div><!-- /.modal -->
            @endsection


            @section('script')
                @if(count($errors) > 0)
                    <script>
                        $('#error-modal').modal('toggle');
                    </script>
                @endif

                <script>
                    $(document).ready(function () {

                        $("form").change(function (event) {
                            var id = event.target.id;
                            if (id.substr(0, 4) == "drug") {
                                var num = id.substr(4);
                                $("#quantity" + num).removeAttr("disabled");
                                $("#usage" + num).removeAttr("disabled");
                            }
                        });

                        var index = $("select").length - 1;

                        $("#increase").click(function () {
                            ++index;
                            $("#inc-dec").before("\
        <div class='form-group drugGroup" + index + "'>\
          <label class='col-sm-2 control-label'>ยา</label>\
          <div class='col-sm-4'>\
            <select class='form-control' id='drug" + index + "' name='drug" + index + "'>\
              <option disabled selected>-- Select Medicine --</option>\
              <option>Aspirin</option>\
              <option>Chlorpheniramine Maleate</option>\
              <option>Dimenhydrinate</option>\
              <option>Mebendazole</option>\
              <option>Paracetamol</option>\
              <option>Ponstan</option>\
            </select>\
          </div>\
          \
          <label class='col-sm-2 control-label'>ปริมาณ</label>\
          <div class='col-sm-4'>\
            <input type='text' class='form-control' id='quantity" + index + "' name='quantity" + index + "' disabled>\
          </div>\
        </div>\
        \
        <div class='form-group drugGroup" + index + "'>\
          <label class='col-sm-2 control-label'>วิธีใช้</label>\
          <div class='col-sm-10'>\
            <textarea class='form-control' rows='5' style='resize:vertical' id='usage" + index + "' name='usage" + index + "' disabled></textarea>\
          </div>\
        </div>\
        ");
                        });

                        $("#decrease").click(function () {
                            $(".drugGroup" + index).remove();
                            if (index >= 1) --index;
                        });

                    });
                </script>
@endsection
