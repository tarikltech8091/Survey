@extends('layout.master')
@section('content')
    <div class="row">
        <div class="col-md-12">
            <!-- start: FORM VALIDATION 2 PANEL -->
            <div class="panel panel-default btn-squared">
                <div class="panel-heading">
                    <i class="fa fa-external-link-square"></i>
                    Edit question
                    <div class="panel-tools">
                        <a class="btn btn-xs btn-link panel-collapse collapses" href="#">
                        </a>
                        <a class="btn btn-xs btn-link panel-close" href="#">
                            <i class="fa fa-times"></i>
                        </a>
                    </div>
                </div>
                <div class="panel-body">
                    <ul class="nav nav-tabs tab-bricky">
                        <li>
                            <a href="{{url('/question/create')}}">
                                <i class="green fa fa-bell"></i> Add Question
                            </a>
                        </li>
                        <li>
                            <a href="{{url('/question/list')}}">
                                <i class="green clip-feed"></i> Question List
                            </a>
                        </li>
                    </ul>
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
                    <form role="form" class="form-horizontal" action="{{ url('/question/update/id-'.$edit->id) }}"
                          id="question" method="post" role="form" enctype="multipart/form-data">
                        <input type="hidden" name="_token" value="{{csrf_token()}}">
                        
                        <div class="form-group">
                            <label class="col-sm-3 control-label">
                                <strong>Campaign</strong>
                                <span class="symbol required" aria-required="true"></span>
                            </label>
                            <div class="col-sm-6">
                                <select id="form-field-select-3" class="form-control search-select"
                                        name="question_campaign_id">
                                    <option value="">&nbsp;Please Select a Campaign</option>

                                    @if(!empty($all_campaign))
                                    @foreach($all_campaign as $key =>$list)
                                        <option {{($edit->question_campaign_id == $list->id) ? "selected" :''}} value="{{$list->id}}">{{$list->campaign_name}}</option>
                                        <input type="hidden" class="form-control" name="question_campaign_name" value="{{$list->campaign_name}}">
                                    @endforeach
                                    @endif

                                </select>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-3 control-label">
                                <strong>Question Type</strong>
                                <span class="symbol required" aria-required="true"></span>
                            </label>
                            <div class="col-sm-6">
                                <select id="form-field-select-3" class="form-control search-select" name="question_type">
                                    <option value="">&nbsp;Please Select a Type</option>
                                    <option {{($edit->question_type == 'multi') ? "selected" :''}} value="multi">Multi</option>
                                    <option {{($edit->question_type == 'single') ? "selected" :''}} value="single">Single</option>
                                    <option {{($edit->question_type == 'text') ? "selected" :''}}  value="text">Text</option>
                                </select>
                            </div>
                        </div>


                        <div class="form-group">
                            <label class="col-sm-3 control-label">
                                <strong>Question Title</strong>
                                <span class="symbol required" aria-required="true"></span>
                            </label>
                            <div class="col-sm-6">
                                <input type="text" class="form-control" name="question_title"  value="{{(isset($edit->question_title) && !empty($edit->question_title))? $edit->question_title:''}}">
                            </div>
                        </div>


                        <div class="form-group">
                            <label class="col-sm-3 control-label">
                                <strong>Question Position</strong>
                                <span class="symbol required" aria-required="true"></span>
                            </label>
                            <div class="col-sm-6">
                                <input type="number" class="form-control" name="question_position" value="{{(isset($edit->question_position) && !empty($edit->question_position))? $edit->question_position:''}}">
                            </div>
                        </div>


                        <div class="form-group">
                            <label class="col-sm-3 control-label">
                                <strong>Option 1</strong>
                                <span class="symbol required" aria-required="true"></span>
                            </label>
                            <div class="col-sm-6">
                                <input type="text" class="form-control" name="question_option_1"  value="{{(isset($edit->question_option_1) && !empty($edit->question_option_1))? $edit->question_option_1:''}}">
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-3 control-label">
                                <strong>Option 2</strong>
                                <span class="symbol required" aria-required="true"></span>
                            </label>
                            <div class="col-sm-6">
                                <input type="text" class="form-control" name="question_option_2"  value="{{(isset($edit->question_option_2) && !empty($edit->question_option_2))? $edit->question_option_2:''}}">
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-3 control-label">
                                <strong>Option 3</strong>
                                <span class="symbol required" aria-required="true"></span>
                            </label>
                            <div class="col-sm-6">
                                <input type="text" class="form-control" name="question_option_3"  value="{{(isset($edit->question_option_3) && !empty($edit->question_option_3))? $edit->question_option_3:''}}">
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-3 control-label">
                                <strong>Option 4</strong>
                            </label>
                            <div class="col-sm-6">
                                <input type="text" class="form-control" name="question_option_4"  value="{{(isset($edit->question_option_4) && !empty($edit->question_option_4))? $edit->question_option_4:''}}">
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-3 control-label">
                                <strong>Option New</strong>
                            </label>
                            <div class="col-sm-6">
                                <input type="text" class="form-control" name="question_option_new"  value="{{(isset($edit->question_option_new) && !empty($edit->question_option_new))? $edit->question_option_new:''}}">
                            </div>
                        </div>


                        <div class="form-group">
                            <label class="col-sm-3 control-label">
                                <strong>Question Special</strong>
                                <span class="symbol required" aria-required="true"></span>
                            </label>
                            <div class="col-sm-6">
                                <input type="radio" name="question_special" {{($edit->question_special == 1) ? "checked" :''}} value="1"> Yes<br>
                                <input type="radio" name="question_special" {{($edit->question_special == 0) ? "checked" :''}} value="0"> No
                            </div>
                        </div>


                        <div class="form-group">
                            <label class="col-sm-3 control-label">
                                <strong>Question Point</strong>
                                <span class="symbol required" aria-required="true"></span>
                            </label>
                            <div class="col-sm-6">
                                <input type="number" class="form-control" name="question_points" value="{{(isset($edit->question_points) && !empty($edit->question_points))? $edit->question_points:''}}">
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-sm-4">
                            </div>
                            <div class="col-sm-4">
                                <input class="btn btn-danger btn-squared" name="reset" value="Reset" type="reset">
                                <input class="btn btn-success btn-squared" name="submit" value="Update" type="submit">
                            </div>
                            <div class="col-sm-4">
                            </div>
                        </div>
                    </form>
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
                var initial = $('#question_type').val();
                if( initial == "text") {
                    $("#video_url").hide();
                }
                if( initial == "video") {
                    $("#video_url").show();
                }

                $('#question_type').change(function() {
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