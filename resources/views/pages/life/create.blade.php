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
                        <a href="{{url('/life/create')}}">
                            <i class="green fa fa-bell"></i> Add Life
                        </a>
                    </li>
                    <li class="">
                        <a href="{{url('/life/list')}}">
                            <i class="green clip-feed"></i> Life List
                        </a>
                    </li>
                </ul>
                <div class="tab-content">
                    <!-- PANEL FOR CREATE Life -->
                    <div id="create_album" class="tab-pane active">
                        <div class="row">
                            <div class="col-md-12">
                                <form role="form" class="form-horizontal" action="{{ url('/life/save') }}"
                                      id="Life" method="post" role="form" enctype="multipart/form-data">
                                    <input type="hidden" name="_token" value="{{csrf_token()}}">
                                    <div class="form-group">
                                        <label class="col-sm-2 control-label">
                                            <strong>Life Pack Name</strong>
                                            <span class="symbol required" aria-required="true"></span>
                                        </label>
                                        <div class="col-sm-8">
                                            <input type="text" class="form-control" name="life_pack_name">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-sm-2 control-label">
                                            <strong>Life TYPE</strong>
                                            <span class="symbol required" aria-required="true"></span>
                                        </label>
                                        <div class="col-sm-8">
                                            <select id="form-field-select-3" class="form-control search-select" name="life_buy_type">
                                                <option value="">&nbsp;Please Select a Type</option>
                                                <option value="free">Free</option>
                                                <option value="buy">Buy</option>

                                            </select>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="col-sm-2 control-label">
                                            <strong>Player</strong>
                                            <span class="symbol required" aria-required="true"></span>
                                        </label>
                                        <div class="col-sm-8">
                                            <select id="form-field-select-3" class="form-control search-select" name="player_id">
                                                <option value="">&nbsp;Please Select a Player</option>

                                                @if(!empty($all_player))
                                                @foreach($all_player as $key =>$list)
                                                    <option value="{{$list->id}}">{{$list->player_name}}</option>
                                                @endforeach
                                                @endif

                                            </select>
                                        </div>
                                    </div>

                                    
                                    <div class="form-group">
                                        <label class="col-sm-2 control-label">
                                            <strong>Number Of Life </strong>
                                        </label>
                                        <div class="col-sm-4">
                                            <input type="number" class="form-control" name="num_of_life">
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="col-sm-2 control-label">
                                            <strong>Life Price </strong>
                                        </label>
                                        <div class="col-sm-4">
                                            <input type="number" class="form-control" name="life_price">
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="col-sm-2 control-label">
                                            <strong>Life Payment TYPE</strong>
                                            <span class="symbol required" aria-required="true"></span>
                                        </label>
                                        <div class="col-sm-8">
                                            <select id="form-field-select-3" class="form-control search-select" name="payment_type">
                                                <option value="">&nbsp;Please Select a Type</option>
                                                <option value="bkash">Bkash</option>
                                            </select>
                                        </div>
                                    </div>


                                    <div class="form-group">
                                        <label class="col-sm-2 control-label">
                                            <strong>Payment Transaction Id </strong>
                                        </label>
                                        <div class="col-sm-4">
                                            <input type="text" class="form-control" name="payment_transaction_id">
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="col-sm-2 control-label">
                                            <strong>Life Buy Date</strong>
                                            <span class="symbol required" aria-required="true"></span>
                                        </label>
                                        <div class="col-sm-6">
                                            <input type="date" class="form-control" name="life_buy_date">
                                        </div>
                                    </div>


                                    <div class="form-group">
                                        <label class="col-sm-2 control-label">
                                            <strong>Life Buy End Date</strong>
                                            <span class="symbol required" aria-required="true"></span>
                                        </label>
                                        <div class="col-sm-6">
                                            <input type="date" class="form-control" name="life_buy_end_date">
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
            $('#Life').validate({
                rules: {
                    Life_TITLE: {
                        required: true
                    },
                    Life_DETAILS: {
                        required: true
                    },
                    Life_TAG:{
                        required: true
                    },
                    Life_IMAGE:{
                        required: true
                    },
                    Life_TYPE:{
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