@extends('layout.master')
@section('content')
    <div class="row">
        <div class="col-md-12">
            <!-- start: FORM VALIDATION 2 PANEL -->
            <div class="panel panel-default btn-squared">
                <div class="panel-heading">
                    <i class="fa fa-external-link-square"></i>
                    Assign Surveyer
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

                    <div class="tabbable">


                        <ul id="myTab" class="nav nav-tabs tab-bricky">
                            <li class="active">
                                <a href="{{url('/surveyer/assign')}}">
                                    <i class="green fa fa-bell"></i> Assign Surveyer
                                </a>
                            </li>
                            <li class="">
                                <a href="{{url('/surveyer/assign/list')}}">
                                    <i class="green clip-feed"></i> Assign Surveyer List
                                </a>
                            </li>
                        </ul>


                        <div class="tab-content">
                            <div id="create_surveyer_assign" class="tab-pane active">
                                <div class="row">
                                    <div class="col-md-12">

                                        <form role="form" class="form-horizontal" action="{{ url('/surveyer/assign/save') }}"
                                              id="surveyer_assign" method="post" role="form" enctype="multipart/form-data">
                                            <input type="hidden" name="_token" value="{{csrf_token()}}">

                                            <div class="form-group">
                                                <label class="col-sm-3 control-label">
                                                    <strong>Select Campaign</strong>
                                                    <span class="symbol required" aria-required="true"></span>
                                                </label>
                                                <div class="col-sm-4">
                                                    <select id="form-field-select-3" class="form-control search-select"
                                                            name="assign_campaign_id">
                                                        <option value="">&nbsp;Please Select a Type</option>

                                                        @if(!empty($all_campaign))
                                                        @foreach($all_campaign as $key =>$list)
                                                            <option value="{{$list->id}}">{{$list->campaign_name}}</option>
                                                            <input type="hidden" class="form-control" name="assign_campaign_name" value="{{$list->campaign_name}}">
                                                        @endforeach
                                                        @endif

                                                    </select>
                                                </div>
                                            </div>


                                            <div class="form-group">
                                                <label class="col-sm-3 control-label">
                                                    <strong>Select Surveyer</strong>
                                                    <span class="symbol required" aria-required="true"></span>
                                                </label>
                                                <div class="col-sm-4">
                                                    <select id="form-field-select-3" class="form-control search-select"
                                                            name="assign_surveyer_id">
                                                        <option value="">&nbsp;Please Select a Type</option>

                                                        @if(!empty($all_surveyer))
                                                        @foreach($all_surveyer as $key =>$list)
                                                            <option value="{{$list->id}}">{{$list->surveyer_name}}</option>
                                                            <input type="hidden" class="form-control" name="assign_surveyer_name" value="{{$list->surveyer_name}}">
                                                            <input type="hidden" class="form-control" name="assign_surveyer_mobile" value="{{$list->surveyer_mobile}}">
                                                            
                                                        @endforeach
                                                        @endif

                                                    </select>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label class="col-sm-3 control-label">
                                                    <strong> Zone</strong>
                                                    <span class="symbol required" aria-required="true"></span>
                                                </label>
                                                <div class="col-sm-4">
                                                    <select id="form-field-select-3" class="form-control search-select" name="assign_zone">
                                                        <option value="">&nbsp;Please Select a Type</option>

                                                        @if(!empty($all_zone))
                                                        @foreach($all_zone as $key =>$list)
                                                            <option value="{{$list->zone_name}}">{{$list->zone_name}}</option>
                                                        @endforeach
                                                        @endif

                                                    </select>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label class="col-sm-3 control-label">
                                                    <strong>Surveyer Target</strong>
                                                    <span class="symbol required" aria-required="true"></span>
                                                </label>
                                                <div class="col-sm-4">
                                                    <input type="number" class="form-control" name="assign_target">
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-sm-3 control-label">
                                                    <strong>Surveyer Prize Amount</strong>
                                                    <span class="symbol required" aria-required="true"></span>
                                                </label>
                                                <div class="col-sm-4">
                                                    <input type="number" class="form-control" name="surveyer_prize_amount">
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label class="col-sm-3 control-label">
                                                    <strong>Assign Campaign Description</strong>
                                                </label>
                                                <div class="col-sm-4">
                                                    <textarea name="assign_campaign_description" class="form-control" cols="10" rows="7"></textarea>
                                                </div>
                                            </div>


                                            <div class="form-group">
                                                <div class="col-sm-4">
                                                </div>
                                                <div class="col-sm-4">
                                                    <input class="btn btn-danger btn-squared" name="reset" value="Reset" type="reset">
                                                    <input class="btn btn-success btn-squared" name="submit" value="Save" type="submit">
                                                </div>
                                                <div class="col-sm-4">
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
        </div>
    </div>
@endsection
@section('JScript')
    <script>
        $(function () {
            $('#surveyer').validate({
                rules: {
                    assign_campaign_id: {
                        required: true
                    },
                    assign_surveyer_id: {
                        required: true
                    },
                    assign_zone: {
                        required: true
                    },
                    assign_target: {
                        required: true
                    },
                    surveyer_prize_amount: {
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