@extends('layout.master')
@section('content')
    <div class="row">
        <div class="col-md-12">
            <!-- start: FORM VALIDATION 2 PANEL -->
            <div class="panel panel-default btn-squared">
                <div class="panel-heading">
                    <i class="fa fa-external-link-square"></i>
                    Edit Earn
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
                    <form role="form" class="form-horizontal" action="{{ url('/earn/update/id-'.$edit->id) }}"
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
                                        <option {{($edit->earn_player_id == $list->id)?'selected':''}} value="{{$list->id}}">{{$list->player_name}}</option>
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
                                        <option {{($edit->earn_player_campaign_id == $list->id)?'selected':''}}  value="{{$list->id}}">{{$list->campaign_name}}</option>
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
                                        <option {{($edit->earn_player_question_id == $list->id)?'selected':''}} value="{{$list->id}}">{{$list->question_name}}</option>
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
                                <input type="date" class="form-control" value="{{$edit->earn_date}}" name="earn_date">
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-2 control-label">
                                <strong>Earn Amount</strong>
                            </label>
                            <div class="col-sm-4">
                                <input type="text" class="form-control" value="{{$edit->earn_amount}}" name="earn_amount">
                            </div>
                        </div>


                        <div class="form-group">
                            <label class="col-sm-2 control-label">
                                <strong>Use Life</strong>
                                <span class="symbol required" aria-required="true"></span>
                            </label>
                            <div class="col-sm-6">
                                <input type="text" class="form-control" value="{{$edit->use_life}}" name="use_life">
                            </div>
                        </div>

                       
                        <div class="form-group">
                            <div class="col-sm-5">
                            </div>
                            <div class="col-sm-4">
                                <input class="btn btn-danger btn-squared" name="reset" value="Reset" type="reset">
                                <input class="btn btn-success btn-squared" name="submit" value="Update" type="submit">
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
            $('#blog').validate({
                rules: {
                    album_name: {
                        required: true
                    },
                    album_category: {
                        required: true
                    },
                    country:{
                        required: true
                    },
                    /*domain_name:{
                        required: true
                    },*/
                    service_name:{
                        required: true
                    },
                    album_tags: {
                        required: true
                    },
                    imdb_rating: {
                        number: true
                    },
                    album_genres: {
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