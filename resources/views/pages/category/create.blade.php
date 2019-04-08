@extends('layout.master')
@section('content')
    <div class="row">
        <div class="col-md-12">
            <!-- start: FORM VALIDATION 2 PANEL -->
            <div class="panel panel-default btn-squared">
                <div class="panel-heading">
                    <i class="fa fa-external-link-square"></i>
                    Create Category
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
                                <a href="{{url('/category/create')}}">
                                    <i class="green fa fa-bell"></i> Add Category
                                </a>
                            </li>
                            <li class="">
                                <a href="{{url('/category/list')}}">
                                    <i class="green clip-feed"></i> Category List
                                </a>
                            </li>
                        </ul>


                        <div class="tab-content">
                            <div id="create_category" class="tab-pane active">
                                <div class="row">
                                    <div class="col-md-12">


                                        <form role="form" class="form-horizontal" action="{{ url('/category/save') }}" id="category" method="post" role="form" enctype="multipart/form-data">
                                            <input type="hidden" name="_token" value="{{csrf_token()}}">

                                            <div class="form-group">
                                                <label class="col-sm-3 control-label">
                                                    <strong>Category Name</strong>
                                                    <span class="symbol required" aria-required="true"></span>
                                                </label>
                                                <div class="col-sm-6">
                                                    <input type="text" class="form-control" name="category_name">
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
            $('#category').validate({
                rules: {
                    category_name: {
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