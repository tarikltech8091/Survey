@extends('layout.master')
@section('content')
    <div class="row">
        <div class="col-md-12">
            <!-- start: FORM VALIDATION 2 PANEL -->
            <div class="panel panel-default btn-squared">
                <div class="panel-heading">
                    <i class="fa fa-external-link-square"></i>
                    Create Question
                    <div class="panel-tools">
                        <a class="btn btn-xs btn-link panel-collapse collapses" href="#">
                        </a>
                        <a class="btn btn-xs btn-link panel-close" href="#">
                            <i class="fa fa-times"></i>
                        </a>
                    </div>
                </div>
                <div class="panel-body">
                    @if($errors->count() > 0 )
                        <div class="alert alert-danger btn-squared">
                            <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                            <h6>The following errors have occurred:</h6>
                            <ul>
                                @foreach( $errors->all() as $message )
                                    <li>{{ $message }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    @if(Session::has('message'))
                        <div class="alert alert-success btn-squared" role="alert">
                            <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                            {{ Session::get('message') }}
                        </div>
                    @endif
                    @if(Session::has('errormessage'))
                        <div class="alert alert-danger btn-squared" role="alert">
                            <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                            {{ Session::get('errormessage') }}
                        </div>
                    @endif

                    <div class="tabbable">


                        <ul id="myTab" class="nav nav-tabs tab-bricky">
                            <li class="active">
                                <a href="{{url('/question/create')}}">
                                    <i class="green fa fa-bell"></i> Add Question
                                </a>
                            </li>
                            <li class="">
                                <a href="{{url('/question/list')}}">
                                    <i class="green clip-feed"></i> Question List
                                </a>
                            </li>
                        </ul>


                        <div class="tab-content">
                            <div id="create_album" class="tab-pane active">
                                <div class="row">
                                    <div class="col-md-12">


                                        <form role="form" class="form-horizontal" action="{{ url('/question/save') }}"
                                              id="question" method="post" role="form" enctype="multipart/form-data">
                                            <input type="hidden" name="_token" value="{{csrf_token()}}">

                                            <div class="col-md-6">

                                                <div class="form-group">
                                                    <label class="col-sm-3 control-label">
                                                        <strong>Participate Name</strong>
                                                        <span class="symbol required" aria-required="true"></span>
                                                    </label>
                                                    <div class="col-sm-9">
                                                        <input type="text" class="form-control" name="participate_name">
                                                    </div>
                                                </div>
                                                
                                                <div class="form-group">
                                                    <label class="col-sm-3 control-label">
                                                        <strong>Participate Join Date</strong>
                                                        <span class="symbol required" aria-required="true"></span>
                                                    </label>
                                                    <div class="col-sm-9">
                                                        <input type="date" class="form-control" name="participate_join_date">
                                                    </div>
                                                </div>

                                                <div class="form-group">
                                                    <label class="col-sm-3 control-label">
                                                        <strong>Participate Mobile</strong>
                                                        <span class="symbol required" aria-required="true"></span>
                                                    </label>
                                                    <div class="col-sm-9">
                                                        <input type="text" class="form-control" name="participate_mobile">
                                                    </div>
                                                </div>

                                                <div class="form-group">
                                                    <label class="col-sm-3 control-label">
                                                        <strong>Participate Email</strong>
                                                    </label>
                                                    <div class="col-sm-9">
                                                        <input type="email" class="form-control" name="participate_email">
                                                    </div>
                                                </div>

                                                <div class="form-group">
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
                                                        <strong>Participate Address</strong>
                                                    </label>
                                                    <div class="col-sm-9">
                                                        <textarea name="participate_address" class="form-control" cols="10" rows="7"></textarea>
                                                    </div>
                                                </div>

                                            </div>

                                            <div class="col-md-6">

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
                                                        <strong>Participate District</strong>
                                                        <span class="symbol required" aria-required="true"></span>
                                                    </label>
                                                    <div class="col-sm-9">
                                                        <select id="form-field-select-3" class="form-control search-select"
                                                                name="participate_district">
                                                            <option value="">&nbsp;Please Select a Type</option>

                                                            @if(!empty($all_district))
                                                            @foreach($all_district as $key =>$list)
                                                                <option value="{{$list}}">{{$list}}</option>
                                                            @endforeach
                                                            @endif

                                                        </select>
                                                    </div>
                                                </div>


                                                <div class="form-group">
                                                    <label class="col-sm-3 control-label">
                                                        <strong>Participate Zone</strong>
                                                        <span class="symbol required" aria-required="true"></span>
                                                    </label>
                                                    <div class="col-sm-9">
                                                        <input type="text" class="form-control" name="participate_zone">
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




                                                <div class="form-group">
                                                    <label class="col-sm-3 control-label">
                                                        <strong>Participate Image</strong>
                                                    </label>
                                                    <div class="col-sm-9">
                                                        <div class="fileupload fileupload-new" data-provides="fileupload">
                                                            <div class="fileupload-new thumbnail" style="width: 150px; height: 150px;"><img src="{{asset('assets/images/profile.png')}}" alt="">
                                                            </div>
                                                            <div class="fileupload-preview fileupload-exists thumbnail" style="max-width: 150px; max-height: 150px; line-height: 20px;"></div>
                                                            <div class="user-edit-image-buttons">
                                                                <span class="btn btn-light-grey btn-file"><span class="fileupload-new"><i class="fa fa-picture"></i> Select image</span><span class="fileupload-exists"><i class="fa fa-picture"></i> Change</span>
                                                                    <input type="file" name="participate_profile_image">
                                                                </span>
                                                                <a href="#" class="btn fileupload-exists btn-light-grey" data-dismiss="fileupload">
                                                                    <i class="fa fa-times"></i> Remove
                                                                </a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                            </div>


                                            <div class="col-md-12">

                                                <div class="form-group">
                                                    <div class="col-sm-12">
                                                        <strong>Question <span class="symbol required" aria-required="true"></span> : {{isset($content)? $content->value :''}} Which sim are you used?</strong>
                                                    </div>
                                                </div>

                                                <label class="col-sm-1 control-label">
                                                </label>
                                                <div class="col-sm-11">
                                                    <div class="form-check form-check-inline">
                                                      <input type="checkbox" class="form-check-input" name="inlineMaterialRadiosExample">
                                                      <label class="form-check-label" for="materialInline1">GrameenPhone</label>
                                                    </div>
                                                </div>


                                                <label class="col-sm-1 control-label">
                                                </label>
                                                <div class="col-sm-11">
                                                    <div class="form-check form-check-inline">
                                                      <input type="checkbox" class="form-check-input" name="inlineMaterialRadiosExample">
                                                      <label class="form-check-label" for="materialInline1">Banglalink</label>
                                                    </div>
                                                </div>



                                                <label class="col-sm-1 control-label">
                                                </label>
                                                <div class="col-sm-11">
                                                    <div class="form-check form-check-inline">
                                                      <input type="checkbox" class="form-check-input" name="inlineMaterialRadiosExample2">
                                                      <label class="form-check-label" for="materialInline1">Airtel</label>
                                                    </div>
                                                </div>



                                                <label class="col-sm-1 control-label">
                                                </label>
                                                <div class="col-sm-11">
                                                    <div class="form-check form-check-inline">
                                                      <input type="checkbox" class="form-check-input" name="inlineMaterialRadiosExample3">
                                                      <label class="form-check-label" for="materialInline1">Robi</label>
                                                    </div>
                                                </div>



                                                <div class="form-group">
                                                    <div class="col-sm-12">
                                                        <strong>Optional Answer : </strong><input type="text" class="form-control" name="question_option_new">
                                                    </div>
                                                </div>

                                            </div>


                                            <div class="form-group">
                                                <div class="col-sm-9">
                                                </div>
                                                <div class="col-sm-3">
                                                    <input class="btn btn-danger btn-squared" name="reset" value="Reset" type="reset">
                                                    <input class="btn btn-success btn-squared" name="submit" value="Save & Next" type="submit">
                                                </div>
                                            </div>

                                        </form>
                                    </div>
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
    <script>
        $(function () {
            $('#question').validate({
                rules: {
                    question_campaign_id: {
                        required: true
                    },
                    question_type: {
                        required: true
                    },
                    question_title: {
                        required: true
                    },
                    question_position: {
                        required: true
                    },
                    question_option_1: {
                        required: true
                    },
                    question_option_2: {
                        required: true
                    },
                    question_option_3: {
                        required: true
                    },
                    question_special: {
                        required: true
                    },
                    question_points: {
                        required: true
                    }
                },
                highlight: function (element) {
                    $(element).closest('.form-group').removeClass('has-success').addClass('has-error');
                },
                unhighlight: function (element) {
                    $(element).closest('.form-group').removeClass('has-error').addClass('has-success');
                },
                errorElement: 'span',
                errorClass: 'help-block',
                errorPlacement: function (error, element) {
                    if (element.parent('.input-group').length) {
                        error.insertAfter(element.parent());
                    } else {
                        error.insertAfter(element);
                        element.attr("placeholder",error.text());
                    }
                }
            });

            $(function(){
                $("#video_url").hide();
                $('#quiz_type').change(function() {
                    var type = this.value;
                    if(type=="video")
                    {
                        $("#video_url").show();
                    } else{
                        $("#video_url").hide();
                    }
                });
            });
        })
    </script>
@endsection