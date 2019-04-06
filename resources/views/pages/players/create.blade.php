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
                        <a href="{{url('/players/create')}}">
                            <i class="green fa fa-bell"></i> Add Player
                        </a>
                    </li>
                    <li class="">
                        <a href="{{url('/players/list')}}">
                            <i class="green clip-feed"></i> Player List
                        </a>
                    </li>
                </ul>
                <div class="tab-content">
                    <!-- PANEL FOR CREATE Player -->
                    <div id="create_player" class="tab-pane active">
                        <div class="row">
                            <div class="col-md-12">
                                <form role="form" class="form-horizontal" action="{{ url('/players/save') }}"
                                      id="player" method="post" role="form" enctype="multipart/form-data">
                                    <input type="hidden" name="_token" value="{{csrf_token()}}">
                                    <div class="form-group">
                                        <label class="col-sm-2 control-label">
                                            <strong>Player Name</strong>
                                            <span class="symbol required" aria-required="true"></span>
                                        </label>
                                        <div class="col-sm-8">
                                            <input type="text" class="form-control" name="players_name">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-sm-2 control-label">
                                            <strong>Player TYPE</strong>
                                            <span class="symbol required" aria-required="true"></span>
                                        </label>
                                        <div class="col-sm-8">
                                            <select id="form-field-select-3" class="form-control search-select"
                                                    name="players_type">
                                                <option value="">&nbsp;Please Select a Type</option>
                                                <option value="vip">VIP</option>
                                                <option value="general">General</option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="col-sm-2 control-label">
                                            <strong>Player District</strong>
                                            <span class="symbol required" aria-required="true"></span>
                                        </label>
                                        <div class="col-sm-8">
                                            <input type="text" class="form-control" name="players_district">
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="col-sm-2 control-label">
                                            <strong>Player Address</strong>
                                            <span class="symbol required" aria-required="true"></span>
                                        </label>
                                        <div class="col-sm-8">
                                            <input type="text" class="form-control" name="players_address">
                                        </div>
                                    </div>


                                    <div class="form-group">
                                        <label class="col-sm-2 control-label">
                                            <strong>Player Email</strong>
                                            <span class="symbol required" aria-required="true"></span>
                                        </label>
                                        <div class="col-sm-8">
                                            <input type="text" class="form-control" name="players_email">
                                        </div>
                                    </div>


                                    <div class="form-group">
                                        <label class="col-sm-2 control-label">
                                            <strong>Player Mobile</strong>
                                            <span class="symbol required" aria-required="true"></span>
                                        </label>
                                        <div class="col-sm-8">
                                            <input type="text" class="form-control" name="players_mobile">
                                        </div>
                                    </div>
                                    


                                    <div class="form-group">
                                        <label class="col-sm-2 control-label">
                                            <strong>Player Image </strong>(Ratio: 480x270)
                                            <span class="symbol required" aria-required="true"></span>
                                        </label>
                                        <div class="col-sm-9">
                                            <div class="fileupload fileupload-new" data-provides="fileupload">
                                                <div class="fileupload-new thumbnail" style="width: 170px; height: 100px;">
                                                    <img src="{{asset('images/default.jpg')}}" alt="">
                                                </div>
                                                <div class="fileupload-preview fileupload-exists"
                                                     style="max-width: 150px; max-height: 150px; line-height: 20px;">
                                                </div>
                                                <div class="user-edit-image-buttons">
                                                    <span class="btn btn-light-grey btn-file">
                                                        <span class="fileupload-new"><i class="fa fa-picture"></i>
                                                            Select image
                                                        </span>
                                                        <span class="fileupload-exists"><i class="fa fa-picture"></i>
                                                            Change
                                                        </span>
                                                        <input type="file" name="players_profile_image">
                                                    </span>
                                                    <a href="#" class="btn fileupload-exists btn-light-grey" data-dismiss="fileupload">
                                                        <i class="fa fa-times"></i> Remove
                                                    </a>
                                                </div>
                                            </div>
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
            $('#Player').validate({
                rules: {
                    Player_TITLE: {
                        required: true
                    },
                    Player_DETAILS: {
                        required: true
                    },
                    Player_TAG:{
                        required: true
                    },
                    Player_IMAGE:{
                        required: true
                    },
                    Player_TYPE:{
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