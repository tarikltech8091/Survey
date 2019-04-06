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
                                              id="quiz" method="post" role="form" enctype="multipart/form-data">
                                            <input type="hidden" name="_token" value="{{csrf_token()}}">
                                            <div class="form-group">
                                                <label class="col-sm-3 control-label">
                                                    <strong>Campaign</strong>
                                                    <span class="symbol required" aria-required="true"></span>
                                                </label>
                                                <div class="col-sm-9">
                                                    <select id="form-field-select-3" class="form-control search-select" name="question_campaign_id">
                                                        <option value="">&nbsp;Please Select a Campaign</option>

                                                        @if(!empty($all_campaign))
                                                        @foreach($all_campaign as $key =>$list)
                                                            <option value="{{$list->id}}">{{$list->campaign_name}}</option>
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
                                                <div class="col-sm-9">
                                                    <select id="form-field-select-3" class="form-control search-select" name="question_type">
                                                        <option value="">&nbsp;Please Select a Type</option>
                                                        <option value="easy">Easy</option>
                                                        <option value="hard">Hard</option>
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label class="col-sm-3 control-label">
                                                    <strong>Question Position</strong>
                                                    <span class="symbol required" aria-required="true"></span>
                                                </label>
                                                <div class="col-sm-9">
                                                    <input type="number" class="form-control" name="question_position">
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label class="col-sm-3 control-label">
                                                    <strong>Question Title</strong>
                                                    <span class="symbol required" aria-required="true"></span>
                                                </label>
                                                <div class="col-sm-9">
                                                    <input type="text" class="form-control" name="question_title">
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label class="col-sm-3 control-label">
                                                    <strong>Option 1</strong>
                                                    <span class="symbol required" aria-required="true"></span>
                                                </label>
                                                <div class="col-sm-9">
                                                    <input type="text" class="form-control" name="question_option_1">
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label class="col-sm-3 control-label">
                                                    <strong>Option 2</strong>
                                                    <span class="symbol required" aria-required="true"></span>
                                                </label>
                                                <div class="col-sm-9">
                                                    <input type="text" class="form-control" name="question_option_2">
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label class="col-sm-3 control-label">
                                                    <strong>Option 3</strong>
                                                    <span class="symbol required" aria-required="true"></span>
                                                </label>
                                                <div class="col-sm-9">
                                                    <input type="text" class="form-control" name="question_option_3">
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label class="col-sm-3 control-label">
                                                    <strong>Option 4</strong>
                                                    <span class="symbol required" aria-required="true"></span>
                                                </label>
                                                <div class="col-sm-9">
                                                    <input type="text" class="form-control" name="question_option_4">
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label class="col-sm-3 control-label">
                                                    <strong>Option New</strong>
                                                    <span class="symbol required" aria-required="true"></span>
                                                </label>
                                                <div class="col-sm-9">
                                                    <input type="text" class="form-control" name="question_option_new">
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label class="col-sm-3 control-label">
                                                    <strong>Question Special</strong>
                                                    <span class="symbol required" aria-required="true"></span>
                                                </label>
                                                <div class="col-sm-9">
                                                    <input type="radio" name="question_special" value="1"> Yes<br>
                                                    <input type="radio" name="question_special" value="0"> No
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label class="col-sm-3 control-label">
                                                    <strong>Prize Amount</strong>
                                                    <span class="symbol required" aria-required="true"></span>
                                                </label>
                                                <div class="col-sm-9">
                                                    <input type="number" class="form-control" name="question_prize_amount">
                                                </div>
                                            </div>


                                            <div class="form-group">
                                                <label class="col-sm-3 control-label">
                                                    <strong>Physical Prize</strong>
                                                    <span class="symbol required" aria-required="true"></span>
                                                </label>
                                                <div class="col-sm-9">
                                                    <input type="text" class="form-control" name="question_physical_prize">
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label class="col-sm-3 control-label">
                                                    <strong>Question Point</strong>
                                                    <span class="symbol required" aria-required="true"></span>
                                                </label>
                                                <div class="col-sm-9">
                                                    <input type="number" class="form-control" name="question_points">
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <div class="col-sm-4">
                                                </div>
                                                <div class="col-sm-4">
                                                    <input class="btn btn-danger btn-squared" name="reset" value="Reset" type="reset">
                                                    <input class="btn btn-success btn-squared" name="submit" value="Save" type="submit">
                                                </div>
                                                <div class="col-sm-4">
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
            $('#quiz').validate({
                rules: {
                    question_id: {
                        required: true
                    },
                    quiz_title: {
                        required: true
                    },
                    question_option_1: {
                        required: true
                    },
                    question_option_2: {
                        required: true
                    },
                    quiz_answer: {
                        required: true
                    },
                    quiz_type: {
                        required: true
                    },
                    video_url: {
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