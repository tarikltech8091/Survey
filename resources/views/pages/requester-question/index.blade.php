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
                    question
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


                            <ul id="myTab" class="nav nav-tabs tab-bricky">
                                <li>
                                    <a href="{{url('/requester/question/create')}}">
                                        <i class="green fa fa-bell"></i> Add Question
                                    </a>
                                </li>
                                <li class="active">
                                    <a href="{{url('/requester/question/list')}}">
                                        <i class="green clip-feed"></i> Question List
                                    </a>
                                </li>
                            </ul>


                            <div class="tab-content">
                                <div id="create_album" class="tab-pane active">
                                    <div class="row">
                                        <div class="col-md-12">

                                            <form method="get"  action="{{url('/requester/question/list')}}">
                                                <div class="col-md-3">
                                                    <div class="form-group has-feedback ">
                                                        <label for="search_from">
                                                            <strong>Search by status : </strong>
                                                        </label>
                                                        <select class="form-control search-select" name="question_status">
                                                            <option {{(isset($_GET['question_status']) && ($_GET['question_status']==1)) ? 'selected' : ''}} value="1">Publish</option>
                                                            <option {{(isset($_GET['question_status']) && ($_GET['question_status']==0)) ? 'selected' : ''}} value="0">Unpublish</option>
                                                        </select>
                                                    </div>
                                                </div>

                                                <div class="col-md-3">
                                                    <div class="form-group has-feedback ">
                                                        <label for="search_from">
                                                            <strong>Search by Campaign : </strong>
                                                        </label>
                                                        <select id="form-field-select-3" class="form-control search-select" name="question_campaign_id">
                                                            <option value="0">&nbsp;All</option>

                                                            @if(!empty($all_campaign))
                                                            @foreach($all_campaign as $key =>$list)
                                                                <option{{(isset($_GET['question_campaign_id']) && ($_GET['question_campaign_id']== $list->id)) ? 'selected' : ''}} value="{{$list->id}}">{{$list->campaign_name}}</option>
                                                            @endforeach
                                                            @endif

                                                        </select>
                                                    </div>
                                                </div>

                                                <div class="col-md-1" style="margin-top:22px;">
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
                                <th>#</th>
                                <th>Campaign Name</th>
                                <th>Question Title</th>
                                <th>Question Type</th>
                                <th>Question Position</th>
                                <th>Option 1</th>
                                <th>Option 2</th>
                                <th>Option 3</th>
                                <th>Option 4</th>
                                <th>Special</th>
                                <!-- <th>Points</th> -->
                                <th>Publish Status</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            @if(!empty($all_content) && count($all_content) > 0)
                                <?php $page=isset($_GET['page'])? ($_GET['page']-1):0;?>
                                @foreach($all_content as $key => $question)
                                    <tr>
                                        <td>{{($key+1+($perPage*$page))}}</td>
                                        <td>{{$question->question_campaign_name}}</td>
                                        <td>{{$question->question_title}}</td>
                                        <td>{{$question->question_type}}</td>
                                        <td>{{$question->question_position}}</td>
                                        <td>{{$question->question_option_1}}</td>
                                        <td>{{$question->question_option_2}}</td>
                                        <td>{{$question->question_option_3}}</td>
                                        <td>{{$question->question_option_4}}</td>
                                        <td>{{$question->question_special}}</td>
                                        <!-- <td>{{$question->question_points}}</td> -->
                                        <td>{{$question->question_published_status}}</td>
                                        <td>
                                            @if($question->question_status == 1)
                                                <span class="label label-success">
                                                    Published
                                                </span>
                                            @else
                                                <span class="label label-danger">
                                                    Un-published
                                                </span>
                                            @endif
                                        </td>
                                        <td style="width:14%">
                                            <div class="btn-group">
                                                @if(!empty($question))
                                                    @if($question->campaign_status == 2)
                                                        <button type="button" class="btn btn-purple"><i class="fa fa-wrench"></i> Action</button><button data-toggle="dropdown" class="btn btn-purple dropdown-toggle"><span class="caret"></span></button>
                                                        <ul class="dropdown-menu" role="menu">
                                                            
                                                            <li><a href="{{url('/requester/question/edit/id-'.$question->id)}}"><i class="fa fa-pencil"></i> Edit</a></li>

                                                            <!-- <li>
                                                                @if($question->question_status == 1)
                                                                    <a class="status-change"
                                                                       data-publish-status="0" data-question-id="{{ $question->id}}" title="Click for unpublish">
                                                                        <i class="fa fa-unlock"></i> Un Publish
                                                                    </a>
                                                                @else
                                                                    <a class="status-change " title="Click for publish"
                                                                       data-publish-status="1" data-question-id="{{ $question->id}}">
                                                                        <i class="fa fa-lock"></i> Publish
                                                                    </a>
                                                                @endif
                                                            </li>
                                                            <li>
                                                                <a class="question-delete" data-question-id="{{ $question->id}}">
                                                                    <i class="fa fa-trash-o" aria-hidden="true"></i> Delete
                                                                </a>
                                                            </li> -->
                                                        </ul>
                                                    @else
                                                        <button type="button" class="btn btn-success"> Active</button>
                                                    @endif
                                                
                                                @endif
                                            </div>
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
                var id = $(this).data('question-id');
                if(status == 0) {
                    bootbox.dialog({
                        message: "Are you sure you want to unpublish this question ?",
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
                                        url: site_url+'/requester/question/change/status/'+id+'/'+status
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
                                        url: site_url+'/requester/question/change/status/'+id+'/'+status
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
            // question delete
            $('.question-delete').on('click', function (e) {
                e.preventDefault();
                var id = $(this).data('question-id');
                bootbox.dialog({
                    message: "Are you sure you want to delete this question ?",
                    title: "<i class='glyphicon glyphicon-trash'></i> Delete !",
                    buttons: {
                        success: {
                            label: "No",
                            className: "btn-success btn-squared",
                            callback: function() {
                                $('.bootbox').modal('hide');
                            }
                        },
                        danger: {
                            label: "Delete!",
                            className: "btn-danger btn-squared",
                            callback: function() {
                                $.ajax({
                                    type: 'GET',
                                    url: site_url+'/requester/question/delete/id-'+id,
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
            });
        });
    </script>
@endsection