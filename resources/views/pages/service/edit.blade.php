@extends('layout.master')
@section('content')
    <div class="row">
        <div class="col-md-12">
            <!-- start: FORM VALIDATION 2 PANEL -->
            <div class="panel panel-default btn-squared">
                <div class="panel-heading">
                    <i class="fa fa-external-link-square"></i>
                    Edit Blog
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
                    <form role="form" class="form-horizontal" action="{{ url('/service/update/id-'.$edit->id) }}"
                          id="service" method="post" role="form" enctype="multipart/form-data">
                        <input type="hidden" name="_token" value="{{csrf_token()}}">

                        <div class="form-group">
                            <label class="col-sm-2 control-label">
                                <strong>Service Name</strong>
                            </label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" value="{{isset($edit->service_name)? $edit->service_name:''}}" name="service_name">
                            </div>
                        </div>


                        <div class="form-group">
                            <label class="col-sm-2 control-label">
                                <strong>Service Start Date</strong>
                            </label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" value="{{isset($edit->service_start_date)? $edit->service_start_date:''}}" name="service_start_date">
                            </div>
                        </div>                        
                        <div class="form-group">
                            <label class="col-sm-2 control-label">
                                <strong>Service End Date</strong>
                            </label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" value="{{isset($edit->service_end_date)? $edit->service_end_date:''}}" name="service_end_date">
                            </div>
                        </div>                        
                        <div class="form-group">
                            <label class="col-sm-2 control-label">
                                <strong>Service Publish Date</strong>
                            </label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" value="{{isset($edit->service_published_date)? $edit->service_published_date:''}}" name="service_published_date">
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <label class="col-sm-2 control-label">
                                <strong>Service Zone</strong>
                            </label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" value="{{isset($edit->service_zone)? $edit->service_zone:''}}" name="service_zone">
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