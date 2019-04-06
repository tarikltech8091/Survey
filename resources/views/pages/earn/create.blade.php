@extends('layout.master')
@section('content')
    <!--SHOW ERROR MESSAGE DIV-->
    <div class="row page_row">
        <div class="col-md-12">
            @if ($errors->count() > 0 )
                <div class="alert alert-danger">
                    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                    <h6>The following errors have occurred:</h6>
                    <ul>
                        @foreach( $errors->all() as $message )
                            <li>{{ $message }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            @if (Session::has('message'))
                <div class="alert alert-success" role="alert">
                    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                    {{ Session::get('message') }}
                </div>
            @endif
            @if (Session::has('errormessage'))
                <div class="alert alert-danger" role="alert">
                    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                    {{ Session::get('errormessage') }}
                </div>
            @endif
        </div>
    </div>
    <!--END ERROR MESSAGE DIV-->
    <div class="row ">
        <div class="col-sm-12">
            <div class="tabbable">
                <ul id="myTab" class="nav nav-tabs tab-bricky">
                    <li class="active">
                        <a href="{{url('/earn/create')}}">
                            <i class="green fa fa-bell"></i> Add Earn
                        </a>
                    </li>
                    <li class="">
                        <a href="{{url('/earn/list')}}">
                            <i class="green clip-feed"></i> Earn List
                        </a>
                    </li>
                </ul>
                <div class="tab-content">
                    <!-- PANEL FOR CREATE Blog -->
                    <div id="create_album" class="tab-pane active">
                        <div class="row">
                            <div class="col-md-12">
                                <form role="form" class="form-horizontal" action="{{ url('/earn/save') }}"
                                      id="blog" method="post" role="form" enctype="multipart/form-data">
                                    <input type="hidden" name="_token" value="{{csrf_token()}}">
                                    
                                    <div class="form-group">
                                        <label class="col-sm-2 control-label">
                                            <strong>Player</strong>
                                            <span class="symbol required" aria-required="true"></span>
                                        </label>
                                        <div class="col-sm-8">
                                            <select id="form-field-select-3" class="form-control search-select" name="earn_player_id">
                                                <option value="">&nbsp;Please Select a Player</option>

                                                @if(!empty($all_players))
                                                @foreach($all_players as $key =>$list)
                                                    <option value="{{$list->id}}">{{$list->player_name}}</option>
                                                    <input type="hidden" class="form-control" value="{{$list->players_mobile}}" name="earn_player_mobile_num">
                                                @endforeach
                                                @endif

                                            </select>
                                        </div>
                                    </div>

                                   
                                    <div class="form-group">
                                        <label class="col-sm-2 control-label">
                                            <strong>Campaign</strong>
                                            <span class="symbol required" aria-required="true"></span>
                                        </label>
                                        <div class="col-sm-8">
                                            <select id="form-field-select-3" class="form-control search-select" name="earn_player_campaign_id">
                                                <option value="">&nbsp;Please Select a Player</option>

                                                @if(!empty($all_campaign))
                                                @foreach($all_campaign as $key =>$list)
                                                    <option value="{{$list->id}}">{{$list->campaign_name}}</option>
                                                    <input type="hidden" class="form-control" value="{{$list->campaign_name}}" name="earn_player_campaign_name">

                                                @endforeach
                                                @endif

                                            </select>
                                        </div>
                                    </div>


                                    
                                    <div class="form-group">
                                        <label class="col-sm-2 control-label">
                                            <strong>Question</strong>
                                            <span class="symbol required" aria-required="true"></span>
                                        </label>
                                        <div class="col-sm-8">
                                            <select id="form-field-select-3" class="form-control search-select" name="earn_player_question_id">
                                                <option value="">&nbsp;Please Select a Player</option>

                                                @if(!empty($all_questions))
                                                @foreach($all_questions as $key =>$list)
                                                    <option value="{{$list->id}}">{{$list->question_name}}</option>
                                                @endforeach
                                                @endif

                                            </select>
                                        </div>
                                    </div>

                                    
                                    <div class="form-group">
                                        <label class="col-sm-2 control-label">
                                            <strong>Earn Date</strong>
                                        </label>
                                        <div class="col-sm-4">
                                            <input type="date" class="form-control" name="earn_date">
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="col-sm-2 control-label">
                                            <strong>Earn Amount</strong>
                                        </label>
                                        <div class="col-sm-4">
                                            <input type="text" class="form-control" name="earn_amount">
                                        </div>
                                    </div>


                                    <div class="form-group">
                                        <label class="col-sm-2 control-label">
                                            <strong>Use Life</strong>
                                            <span class="symbol required" aria-required="true"></span>
                                        </label>
                                        <div class="col-sm-6">
                                            <input type="text" class="form-control" name="use_life">
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <div class="col-sm-6">
                                        </div>
                                        <div class="col-sm-3">
                                            <input class="btn btn-danger btn-squared" name="reset" value="Reset" type="reset">
                                            <input class="btn btn-success btn-squared" name="submit" value="Save" type="submit">
                                        </div>
                                        <div class="col-sm-2">
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
@endsection
@section('JScript')
    <script>
        $(function () {
            $('#blog').validate({
                rules: {
                    BLOG_TITLE: {
                        required: true
                    },
                    BLOG_DETAILS: {
                        required: true
                    },
                    BLOG_TAG:{
                        required: true
                    },
                    BLOG_IMAGE:{
                        required: true
                    },
                    BLOG_TYPE:{
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
        })
    </script>
@endsection