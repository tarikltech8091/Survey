@extends('portal.layout.master')
@section('content')
    <div class="common_background" style="padding: 10px;">
        <div class="details_common_background2">
            <div class="row" style="margin-bottom: 60px">

                <div class="card">
                    <style>

                            ::placeholder {
                                color: #655a5a;
                            }
                            .submit_button_color{
                                color: #000000; 
                            }

                    </style>

                    <div class="card-content" style="padding-bottom: 0px">
                            <p id="total" class="center-align">Participate</p>
                            <div class="jakat_calculator">
                                <div class="row" style="margin: 0 3px">
                                    <div class="input-field col s12">
                                        <input type="text" name="name" placeholder="Participate Name"/>
                                    </div>
                                </div>
                                <div class="row" style="margin: 0 3px">
                                    <div class="input-field col s12">
                                        <input type="date" name="date" placeholder="Participate Join date"/>
                                    </div>
                                </div>
                                <div class="row" style="margin: 0 3px">
                                    <div class="input-field col s12">
                                        <input type="text" name="mobile" placeholder="Participate Mobile"/>
                                    </div>
                                </div>
                                <div class="row" style="margin: 0 3px">
                                    <div class="input-field col s12">
                                        <input type="email" name="email" placeholder="Participate Email"/>
                                    </div>
                                </div>
                                <div class="row" style="margin: 0 3px">
                                    <div class="input-field col s12">
                                        <input type="text" name="address" placeholder="Address"/>
                                    </div>
                                </div>
                                <div class="row" style="margin: 0 3px">
                                    <div class="input-field col s12">
                                        <input type="text" name="post_code" placeholder="Post Code"/>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col s12">
                                        <label>District Select</label>
                                        <select name="participate_district"  class="browser-default" style="background-color: #cccccc; border: 2px #9e9e9e solid;">
                                            <option value=""selected>Please Select a District</option>
                                            @if(!empty($all_district))
                                            @foreach($all_district as $key =>$list)
                                                <option value="{{$list}}">{{$list}}</option>
                                            @endforeach
                                            @endif
                                        </select>
                                    </div>
                                </div>


                                <div class="row">
                                    <div class="col s12">
                                        <label>Zone Select</label>
                                        <select name="participate_zone"  class="browser-default" style="background-color: #cccccc; border: 2px #9e9e9e solid;">
                                            <option value="">&nbsp;Please Select a Zone</option>

                                            @if(!empty($all_zone))
                                            @foreach($all_zone as $key =>$list)
                                                <option value="{{$list->zone_name}}">{{$list->zone_name}}</option>
                                            @endforeach
                                            @endif
                                    </select>
                                    </div>
                                </div>







                                <!-- <div class="form-group">
                                    <label class="col-sm-3 control-label">
                                        <strong>Participate Gender</strong>
                                        <span class="symbol required" aria-required="true"></span>
                                    </label>
                                    <div class="col-sm-9">
                                        <select id="form-field-select-3" class="form-control search-select"
                                                name="participate_gender">
                                            <option value="">&nbsp;Please Select a Type</option>
                                            <option value="male">Male</option>
                                            <option value="female">Female</option>
                                            <option value="common">Common</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="col-sm-3 control-label">
                                        <strong>Participate Age</strong>
                                        <span class="symbol required" aria-required="true"></span>
                                    </label>
                                    <div class="col-sm-9">
                                        <select id="form-field-select-3" class="form-control search-select" name="participate_age">
                                            <option value="">&nbsp;Please Select a Type</option>
                                            <option value="0-18">0-18</option>
                                            <option value="19-25">19-25</option>
                                            <option value="26-35">26-35</option>
                                            <option value="36-50">36-50</option>
                                            <option value="50-100">50-100</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="col-sm-3 control-label">
                                        <strong>Participate Religion</strong>
                                        <span class="symbol required" aria-required="true"></span>
                                    </label>
                                    <div class="col-sm-9">
                                        <select id="form-field-select-3" class="form-control search-select"
                                                name="participate_religion">
                                            <option value="">&nbsp;Please Select a Type</option>
                                            <option {{(old('participate_religion')== "islam") ? "selected" :''}}  value="islam">Islam</option>
                                            <option {{(old('participate_religion')== "christianity") ? "selected" :''}} value="christianity">Christianity</option>
                                            <option {{(old('participate_religion')== "hinduism") ? "selected" :''}} value="hinduism">Hinduism</option>
                                            <option {{(old('participate_religion')== "buddhism") ? "selected" :''}} value="buddhism">Buddhism</option>
                                        </select>
                                    </div>
                                </div>



                                <div class="form-group">
                                    <label class="col-sm-3 control-label">
                                        <strong>Participate Occupation</strong>
                                        <span class="symbol required" aria-required="true"></span>
                                    </label>
                                    <div class="col-sm-9">
                                        <select id="form-field-select-3" class="form-control search-select"
                                                name="participate_occupation">
                                            <option value="">&nbsp;Please Select a Type</option>
                                            <option value="student">Student</option>
                                            <option value="teacher">Teacher</option>
                                            <option value="business">Business</option>
                                            <option value="govt-service">Govt. Service</option>
                                            <option value="private-service">Private Service</option>
                                        </select>
                                    </div>
                                </div>


                                <div class="form-group">
                                    <label class="col-sm-3 control-label">
                                        <strong>Participate Post Code</strong>
                                    </label>
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control" name="participate_post_code">
                                    </div>
                                </div>


                                <div class="form-group">
                                    <label class="col-sm-3 control-label">
                                        <strong>Participate NID</strong>
                                    </label>
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control" name="participate_nid">
                                    </div>
                                </div>
 -->












                                <div class="row">
                                    <div class="col s4">
                                    </div>
                                    <div class="col s4">
                                        <input type="submit" class="waves-light btn" value="Submit">
                                    </div>
                                    <div class="col s4">
                                    </div>
                                </div>
                            </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
@endsection
@section('JScript')
    <script type="text/javascript">
        $(document).ready(function(){
            var site_url = $('.site_url').val();
            $('.calculate').on('click',function(){
                var value1= $('#value1').val()/100*2.5;
                var value2 = $('#value2').val()/100*2.5;
                var value3 = $('#value3').val()/100*10;
                var value4 = $('#value4').val()/100*20;
                var value5 = $('#value5').val()/100*2.5;
                var value6 = $('#value6').val()/100*2.5;
                var totalAmount=(value1+value2+value3+value4+value5+value6);
                console.log(totalAmount.toFixed(2));
                $('#total').html('<b>মোট যাকাতের পরিমাণ</b>'+' '+totalAmount.toFixed(2)+' '+'<b>টাকা<b>')
            })
        });
        function isNumberKey(evt){
            var charCode = (evt.which) ? evt.which : event.keyCode
            if (charCode > 31 && (charCode < 48 || charCode > 57))
                return false;
            return true;
        }
    </script>
@endsection