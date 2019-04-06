@extends('layout.master')
@section('content')
    <div class="row">
        <div class="col-md-12">
            <!-- start: FORM VALIDATION 2 PANEL -->
            <div class="panel panel-default btn-squared">
                <div class="panel-heading">
                    <i class="fa fa-external-link-square"></i>
                    Edit Player
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
                    <form role="form" class="form-horizontal" action="{{ url('/players/update/id-'.$edit->id) }}"
                          id="players" method="post" role="form" enctype="multipart/form-data">

                        <input type="hidden" name="_token" value="{{csrf_token()}}">
                        <div class="form-group">
                            <label class="col-sm-2 control-label">
                                <strong>Player Name</strong>
                                <span class="symbol required" aria-required="true"></span>
                            </label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" value="{{$edit->players_name}}" name="players_name">
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
                                    <option {{($edit->players_type == 'vip') ? 'selected' : ''}} value="vip">VIP</option>
                                    <option {{($edit->players_type == 'general') ?'selected':''}} value="general">General</option>
                                </select>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-2 control-label">
                                <strong>Player District</strong>
                                <span class="symbol required" aria-required="true"></span>
                            </label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" value="{{$edit->players_district}}" name="players_district">
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-2 control-label">
                                <strong>Player Address</strong>
                                <span class="symbol required" aria-required="true"></span>
                            </label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" value="{{$edit->players_address}}" name="players_address">
                            </div>
                        </div>


                        <div class="form-group">
                            <label class="col-sm-2 control-label">
                                <strong>Player Email</strong>
                                <span class="symbol required" aria-required="true"></span>
                            </label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" value="{{$edit->players_email}}" name="players_email">
                            </div>
                        </div>


                        <div class="form-group">
                            <label class="col-sm-2 control-label">
                                <strong>Player Mobile</strong>
                                <span class="symbol required" aria-required="true"></span>
                            </label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" value="{{$edit->players_mobile}}" name="players_mobile">
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
                                        @if(!empty($edit->players_mobile))
                                            <img src="{{$edit->players_profile_image}}" alt="">
                                        @else
                                            <img src="{{asset('images/default.jpg')}}" alt="">
                                        @endif
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