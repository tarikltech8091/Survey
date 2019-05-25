@extends('layout.master')
@section('content')
    <div class="row">
        <div class="col-md-12">
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
            <div class="panel panel-default btn-squared">
                <div class="panel-heading">
                    <i class="fa fa-external-link-square"></i>
                    Question Answer List
                    <div class="panel-tools">
                        <a class="btn btn-xs btn-link panel-collapse collapses" href="#">
                        </a>
                        <a class="btn btn-xs btn-link panel-close" href="#">
                            <i class="fa fa-times"></i>
                        </a>
                    </div>
                </div>
                <div class="panel-body">

                    <div class="tabbable">

                        <div class="tab-content">
                            <div id="create_question_answer" class="tab-pane active">
                                <div class="row">
                                    <div class="col-md-12">

                                        <form method="get"  action="{{url('/surveyer/question/answer/list')}}">


                                            <div class="col-md-3">
                                                <div class="form-group has-feedback ">
                                                    <label for="search_from">
                                                        <strong>Search by status : </strong>
                                                    </label>
                                                    <select class="form-control search-select" name="question_answer_status">
                                                        <option {{(isset($_GET['question_answer_status']) && ($_GET['question_answer_status']==22)) ? 'selected' : ''}} value="22">All</option>
                                                        <option {{(isset($_GET['question_answer_status']) && ($_GET['question_answer_status']==1)) ? 'selected' : ''}} value="1">Publish</option>
                                                        <option {{(isset($_GET['question_answer_status']) && ($_GET['question_answer_status']==0)) ? 'selected' : ''}} value="0">Unpublish</option>
                                                    </select>
                                                </div>
                                            </div>


                                            <div class="col-md-3">
                                                <div class="form-group has-feedback ">
                                                    <label for="search_from">
                                                        <strong>Search by Campaign : </strong>
                                                    </label>
                                                    <select class="form-control search-select" name="answer_campaign_id">
                                                        <option {{(isset($_GET['answer_campaign_id']) && ($_GET['answer_campaign_id']==0)) ? 'selected' : ''}} value="0">All</option>

                                                        @if(!empty($all_campaign) && count($all_campaign) > 0)
                                                        @foreach($all_campaign as $key => $list)
                                                            <option {{(isset($_GET['answer_campaign_id']) && ($_GET['answer_campaign_id'] == $list->id)) ? 'selected' : ''}} value="{{$list->id}}">{{$list->campaign_name}}</option>
                                                        @endforeach
                                                        @endif
                                                    </select>
                                                </div>
                                            </div>


                                            <div class="col-md-1" style="margin-top:25px;">
                                                <div class="form-group">
                                                    <input type="submit" class="btn btn-primary btn-squared" value="Search">
                                                </div>
                                            </div>

                                        </form>
                                        
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>


                    <div class="table-responsive">
                        <table class="table table-hover table-bordered table-striped nopadding">
                            <thead>
                            <tr>
                                <th class="text-center">#</th>
                                <th class="text-center">Campaign Name</th>
                                <th class="text-center">Surveyer Number</th>
                                <th class="text-center">Participate Mobile</th>
                                <th class="text-center">Question Title</th>
                                <!-- <th class="text-center">Question Type</th> -->
                                <th class="text-center" class="text-center">Question Position</th>
                                <th class="text-center" class="text-center">Option 1</th>
                                <th class="text-center" class="text-center">Option 2</th>
                                <th class="text-center" class="text-center">Option 3</th>
                                <th class="text-center" class="text-center">Option 4</th>
                                <th class="text-center" class="text-center">New Option</th>
                                <th class="text-center" class="text-center">Status</th>
                            </tr>
                            </thead>
                            <tbody>
                            @if(!empty($all_content) && count($all_content) > 0)
                                <?php $page=isset($_GET['page'])? ($_GET['page']-1):0;?>
                                @foreach($all_content as $key => $question)
                                    <tr>
                                        <td class="text-center">{{($key+1+($perPage*$page))}}</td>
                                        <td class="text-center">{{$question->campaign_name}}</td>
                                        <td class="text-center">{{$question->surveyer_mobile}}</td>
                                        <td class="text-center">{{$question->answer_participate_mobile}}</td>
                                        <td class="text-center">{{ str_limit($question->question_answer_title, 15)  }}</td>
                                        <!-- <td>{{$question->question_answer_type}}</td> -->
                                        <td class="text-center">{{$question->question_position}}</td>
                                        <td class="text-center">{{$question->question_answer_option_1}}</td>
                                        <td class="text-center">{{$question->question_answer_option_2}}</td>
                                        <td class="text-center">{{$question->question_answer_option_3}}</td>
                                        <td class="text-center">{{$question->question_answer_option_4}}</td>
                                        <td class="text-center">{{$question->question_answer_text_value}}</td>
                                        <td class="text-center">
                                            @if($question->question_answer_status == 1)
                                                <span class="label label-success btn-squared">Published</span>
                                            @else
                                                <span class="label label-danger btn-squared">Unpublished</span>
                                            @endif
                                        </td>

                                    </tr>
                                @endforeach
                            @else
                                <tr class="text-center">
                                    <td colspan="11">No Data available</td>
                                </tr>
                            @endif
                            </tbody>
                        </table>
                        {{isset($pagination)? $pagination:""}}
                    </div>

                </div>
            </div>
        </div>
    </div>
    <style type="text/css">
        .table .tbl_image {
            width: 10%;
        }
        .table .tbl_image img {
            width: 50%;
        }
    </style>
@endsection

@section('JScript')
    <script>
        $(function () {
            var site_url = $('.site_url').val();

            //publish and unpublish
            $('.status-change').on('click', function (e) {
                e.preventDefault();
                var status = $(this).data('publish-status');
                var id = $(this).data('question-answer-id');
                if(status == 0) {
                    bootbox.dialog({
                        message: "Are you sure you want to unpublish this answer question ?",
                        title: "<i class='glyphicon glyphicon-eye-close'></i> Unpublish !",
                        buttons: {
                            danger: {
                                label: "No!",
                                className: "btn-danger btn-squared",
                                callback: function() {
                                    $('.bootbox').modal('hide');
                                }
                            },
                            success: {
                                label: "Yes!",
                                className: "btn-success btn-squared",
                                callback: function() {
                                    $.ajax({
                                        type: 'GET',
                                        url: site_url+'/surveyer/question/answer/change/status/'+id+'/'+status
                                    }).done(function(response){
                                        bootbox.alert(response,
                                            function(){
                                                location.reload(true);
                                            }
                                        );

                                    }).fail(function(response){
                                        bootbox.alert(response);
                                    })
                                }
                            }
                        }
                    });
                } else {
                    bootbox.dialog({
                        message: "Are you sure you want to publish this question ?",
                        title: "<i class='glyphicon glyphicon-eye-open'></i> Publish !",
                        buttons: {
                            danger: {
                                label: "No!",
                                className: "btn-danger btn-squared",
                                callback: function() {
                                    $('.bootbox').modal('hide');
                                }
                            },
                            success: {
                                label: "Yes!",
                                className: "btn-success btn-squared",
                                callback: function() {
                                    $.ajax({
                                        type: 'GET',
                                        url: site_url+'/surveyer/question/answer/change/status/'+id+'/'+status
                                    }).done(function(response){
                                        bootbox.alert(response,
                                            function(){
                                                location.reload(true);
                                            }
                                        );
                                    }).fail(function(response){
                                        bootbox.alert(response);
                                    })
                                }
                            }
                        }
                    });
                }
            });

        });
    </script>
@endsection