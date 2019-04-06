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
                        <a href="{{url('/campaign/create')}}">
                            <i class="green fa fa-bell"></i> Add Campaign
                        </a>
                    </li>
                    <li class="">
                        <a href="{{url('/campaign/list')}}">
                            <i class="green clip-feed"></i> Campaign List
                        </a>
                    </li>
                </ul>
                <div class="tab-content">
                    <!-- PANEL FOR CREATE Blog -->
                    <div id="create_album" class="tab-pane active">
                        <div class="row">
                            <div class="col-md-12">
                                <form role="form" class="form-horizontal" action="{{ url('/campaign/save') }}"
                                      id="blog" method="post" role="form" enctype="multipart/form-data">
                                    <input type="hidden" name="_token" value="{{csrf_token()}}">
                                    <div class="form-group">
                                        <label class="col-sm-2 control-label">
                                            <strong>Campaign Name</strong>
                                            <span class="symbol required" aria-required="true"></span>
                                        </label>
                                        <div class="col-sm-8">
                                            <input type="text" class="form-control" name="campaign_name">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-sm-2 control-label">
                                            <strong>Service</strong>
                                            <span class="symbol required" aria-required="true"></span>
                                        </label>
                                        <div class="col-sm-8">
                                            <select id="form-field-select-3" class="form-control search-select"
                                                    name="service_id">
                                                <option value="">&nbsp;Please Select a Service</option>

                                                @if(!empty($all_service))
                                                @foreach($all_service as $key =>$list)
                                                    <option value="{{$list->service_name}}">{{$list->service_name}}</option>
                                                @endforeach
                                                @endif

                                            </select>
                                        </div>
                                    </div>

                                    
                                    <div class="form-group">
                                        <label class="col-sm-2 control-label">
                                            <strong>Campaign Start Date</strong>
                                        </label>
                                        <div class="col-sm-4">
                                            <input type="date" class="form-control" name="campaign_start_date">
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="col-sm-2 control-label">
                                            <strong>Campaign End Date</strong>
                                        </label>
                                        <div class="col-sm-4">
                                            <input type="date" class="form-control" name="campaign_end_date">
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="col-sm-2 control-label">
                                            <strong>Campaign Quiz Point</strong>
                                            <span class="symbol required" aria-required="true"></span>
                                        </label>
                                        <div class="col-sm-6">
                                            <input type="number" class="form-control" name="campaign_quiz_points">
                                        </div>
                                    </div>


                                    <div class="form-group">
                                        <label class="col-sm-2 control-label">
                                            <strong>Description</strong>
                                        </label>
                                        <div class="col-sm-9">
                                            <textarea name="campaign_description" class="form-control" cols="10" rows="7"></textarea>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="col-sm-2 control-label">
                                            <strong>Campaign Image </strong>(Ratio: 480x270)
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
                                                        <input type="file" name="BLOG_IMAGE">
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