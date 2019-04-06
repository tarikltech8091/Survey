@extends('layout.master')
@section('content')
    <div class="row">
        <div class="col-md-12">
            <!-- start: FORM VALIDATION 2 PANEL -->
            <div class="panel panel-default btn-squared">
                <div class="panel-heading">
                    <i class="fa fa-external-link-square"></i>
                    Edit Campaign
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

                    <form role="form" class="form-horizontal" action="{{ url('/campaign/update/id-'.$edit->id) }}"
                          id="campaign" method="post" role="form" enctype="multipart/form-data">
                        <input type="hidden" name="_token" value="{{csrf_token()}}">

                        <div class="form-group">
                            <label class="col-sm-2 control-label">
                                <strong>Campaign Name</strong>
                            </label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" value="{{isset($edit->campaign_name)? $edit->campaign_name:''}}" name="campaign_name">
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
                                        <option {{($edit->service_id == $list->service_name) ? 'selected' : ''}} value="{{$list->service_name}}">{{$list->service_name}}</option>
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
                                <input type="date" class="form-control" value="{{isset($edit->campaign_start_date)? $edit->campaign_start_date:''}}" name="campaign_start_date">
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-2 control-label">
                                <strong>Campaign End Date</strong>
                            </label>
                            <div class="col-sm-4">
                                <input type="date" class="form-control" value="{{isset($edit->campaign_end_date)? $edit->campaign_end_date:''}}" name="campaign_end_date">
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-2 control-label">
                                <strong>Campaign Quiz Point</strong>
                                <span class="symbol required" aria-required="true"></span>
                            </label>
                            <div class="col-sm-6">
                                <input type="number" class="form-control" value="{{isset($edit->campaign_quiz_points)? $edit->campaign_quiz_points:''}}" name="campaign_quiz_points">
                            </div>
                        </div>


                        <div class="form-group">
                            <label class="col-sm-2 control-label">
                                <strong>Description</strong>
                            </label>
                            <div class="col-sm-9">
                                <textarea name="campaign_description" class="form-control" cols="10" rows="7">{{isset($edit->campaign_description)? $edit->campaign_description:''}}</textarea>
                            </div>
                        </div>

                    
                        <div class="form-group">
                            <label class="col-sm-2 control-label">
                                <strong>Campaign Image</strong>(Ratio: 480x270)
                            </label>
                            <div class="col-sm-9">
                                <div class="fileupload fileupload-new" data-provides="fileupload">
                                    <?php
                                    if ($edit->campaign_banner_image != '') {
                                        $campaign_image = $edit->campaign_banner_image;
                                    } else {
                                        $campaign_image = '/images/default.jpg';
                                    }
                                    ?>
                                    <div class="fileupload-new thumbnail" style="width: 170px; height: 100px;">
                                        <img width="150px" height="150px" src="{{asset($campaign_image)}}" alt="">
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
                                            <input type="file" name="campaign_banner_image" value="{{ $edit->campaign_banner_image }}">
                                        </span>
                                        <a href="#" class="btn fileupload-exists btn-light-grey" data-dismiss="fileupload">
                                            <i class="fa fa-times"></i> Remove
                                        </a>
                                    </div>
                                </div>
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