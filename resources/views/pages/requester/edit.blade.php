@extends('layout.master')
@section('content')
    <div class="row">
        <div class="col-md-12">
            <!-- start: FORM VALIDATION 2 PANEL -->
            <div class="panel panel-default btn-squared">
                <div class="panel-heading">
                    <i class="fa fa-external-link-square"></i>
                    Edit Requester
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
                            <a href="{{url('/requester/create')}}">
                                <i class="green fa fa-bell"></i> Add Requester
                            </a>
                        </li>
                        <li>
                            <a href="{{url('/requester/list')}}">
                                <i class="green clip-feed"></i> Requester List
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

                    <form role="form" class="form-horizontal" action="{{ url('/requester/update/id-'.$edit->id) }}"
                          id="requester" method="post" role="form" enctype="multipart/form-data">
                        <input type="hidden" name="_token" value="{{csrf_token()}}">

                        <div class="form-group">
                            <label class="col-sm-3 control-label">
                                <strong>Requester Name</strong>
                                <span class="symbol required" aria-required="true"></span>
                            </label>
                            <div class="col-sm-6">
                                <input type="text" class="form-control" name="requester_name" value="{{isset($edit)? $edit->requester_name :''}}">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">
                                <strong>Requester Email</strong>
                                <span class="symbol required" aria-required="true"></span>
                            </label>
                            <div class="col-sm-6">
                                <input type="email" class="form-control" name="requester_email" value="{{isset($edit)? $edit->requester_email :''}}">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">
                                <strong>Requester Mobile</strong>
                                <span class="symbol required" aria-required="true"></span>
                            </label>
                            <div class="col-sm-6">
                                <input type="text" class="form-control" name="requester_mobile" value="{{isset($edit)? $edit->requester_mobile :''}}">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">
                                <strong>Requester Join Date</strong>
                                <span class="symbol required" aria-required="true"></span>
                            </label>
                            <div class="col-sm-4">
                                <input type="date" class="form-control" name="requester_join_date" value="{{isset($edit)? $edit->requester_join_date :''}}">
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-3 control-label">
                                <strong>Requester District</strong>
                                <span class="symbol required" aria-required="true"></span>
                            </label>
                            <div class="col-sm-4">
                                <input type="text" class="form-control" name="requester_district" value="{{isset($edit)? $edit->requester_district :''}}">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">
                                <strong>Requester Post Code</strong>
                                <span class="symbol required" aria-required="true"></span>
                            </label>
                            <div class="col-sm-4">
                                <input type="text" class="form-control" name="requester_post_code" value="{{isset($edit)? $edit->requester_post_code :''}}">
                            </div>
                        </div>


                        <div class="form-group">
                            <label class="col-sm-3 control-label">
                                <strong>Requester NID</strong>
                                <span class="symbol required" aria-required="true"></span>
                            </label>
                            <div class="col-sm-4">
                                <input type="text" class="form-control" name="requester_nid" value="{{isset($edit)? $edit->requester_nid :''}}">
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-3 control-label">
                                <strong>Requester Address</strong>
                            </label>
                            <div class="col-sm-4">
                                <textarea name="requester_address" class="form-control" cols="10" rows="7">{{isset($edit)? $edit->requester_address :''}}</textarea>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-3 control-label">
                                <strong>Requester Image</strong>
                            </label>
                            <div class="col-sm-4">
                                <div class="fileupload fileupload-new" data-provides="fileupload">
                                    <div class="fileupload-new thumbnail" style="width: 150px; height: 150px;">
                                        @if(!empty( $edit->requester_profile_image))
                                            <img src="{{asset($edit->requester_profile_image)}}" alt="">
                                        @else
                                            <img src="{{asset('assets/images/profile.png')}}" alt="">
                                        @endif
                                    </div>
                                    <div class="fileupload-preview fileupload-exists thumbnail" style="max-width: 150px; max-height: 150px; line-height: 20px;"></div>
                                    <div class="user-edit-image-buttons">
                                        <span class="btn btn-light-grey btn-file"><span class="fileupload-new"><i class="fa fa-picture"></i> Select image</span><span class="fileupload-exists"><i class="fa fa-picture"></i> Change</span>
                                            <input type="file" name="requester_profile_image">
                                        </span>
                                        <a href="#" class="btn fileupload-exists btn-light-grey" data-dismiss="fileupload">
                                            <i class="fa fa-times"></i> Remove
                                        </a>
                                    </div>
                                </div>
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
            $('#requester').validate({
                rules: {
                    requester_name: {
                        required: true
                    },
                    requester_mobile: {
                        required: true
                    },
                    requester_email: {
                        required: true
                    },
                    requester_join_date: {
                        required: true
                    },
                    requester_district: {
                        required: true
                    },
                    requester_address: {
                        required: true
                    },
                    requester_post_code: {
                        required: true
                    },
                    requester_nid: {
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