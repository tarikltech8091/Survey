@extends('layout.master')
@section('content')
    <div class="row">
        <div class="col-md-12">
            <!-- start: FORM VALIDATION 2 PANEL -->
            <div class="panel panel-default btn-squared">
                <div class="panel-heading">
                    <i class="fa fa-external-link-square"></i>
                    Edit Zone
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
                            <a href="{{url('/zone/create')}}">
                                <i class="green fa fa-bell"></i> Add Zone
                            </a>
                        </li>
                        <li>
                            <a href="{{url('/zone/list')}}">
                                <i class="green clip-feed"></i> Zone List
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

                    <form role="form" class="form-horizontal" action="{{ url('/zone/update/id-'.$edit->id) }}"
                          id="zone" method="post" role="form" enctype="multipart/form-data">
                        <input type="hidden" name="_token" value="{{csrf_token()}}">

                        <div class="form-group">
                            <label class="col-sm-3 control-label">
                                <strong> District</strong>
                                <span class="symbol required" aria-required="true"></span>
                            </label>
                            <div class="col-sm-4">
                                <select id="form-field-select-3" class="form-control search-select" name="zone_district">

                                    @if(!empty($all_district))
                                    @foreach($all_district as $key =>$list)
                                        <option {{ ($edit->zone_district == $list)?'selected' :''}}  value="{{$list}}">{{$list}}</option>
                                    @endforeach
                                    @endif

                                </select>
                            </div>
                        </div>


                        <div class="form-group">
                            <label class="col-sm-3 control-label">
                                <strong>Zone Name</strong>
                                <span class="symbol required" aria-required="true"></span>
                            </label>
                            <div class="col-sm-4">
                                <input type="text" class="form-control" name="zone_name" value="{{isset($edit)? $edit->zone_name :''}}">
                            </div>
                        </div>


                        <div class="form-group">
                            <label class="col-sm-3 control-label">
                                <strong>Zip Code</strong>
                                <span class="symbol required" aria-required="true"></span>
                            </label>
                            <div class="col-sm-4">
                                <input type="number" class="form-control" name="zone_zip_code" value="{{isset($edit)? $edit->zone_zip_code :''}}">
                            </div>
                        </div>


                        <div class="form-group">
                            <label class="col-sm-3 control-label">
                                <strong>Zone Address Details</strong>
                            </label>
                            <div class="col-sm-4">
                                <textarea name="zone_address_details" class="form-control" cols="10" rows="7">{{isset($edit)? $edit->zone_address_details :''}}</textarea>
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
            $('#zone').validate({
                rules: {
                    zone_district: {
                        required: true
                    },
                    zone_name: {
                        required: true
                    },

                    zone_address: {
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