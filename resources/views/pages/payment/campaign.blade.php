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
                        <a href="{{url('/campaign/payment')}}">
                            <i class="green fa fa-bell"></i> Add Campaign Payment
                        </a>
                    </li>
                    <li class="">
                        <a href="{{url('/campaign/payment/list')}}">
                            <i class="green clip-feed"></i> Campaign Payment List
                        </a>
                    </li>
                </ul>
                <div class="tab-content">
                    <!-- PANEL FOR CREATE Blog -->
                    <div id="create_campaign_payment" class="tab-pane active">
                        <div class="row">
                            <div class="col-md-12">
                                <form role="form" class="form-horizontal" action="{{ url('/campaign/payment/save') }}"
                                      id="campaign_payment" method="post" role="form" enctype="multipart/form-data">
                                    <input type="hidden" name="_token" value="{{csrf_token()}}">

                                    <div class="form-group">
                                        <label class="col-sm-3 control-label">
                                            <strong>Select Payment Campaign</strong>
                                            <span class="symbol required" aria-required="true"></span>
                                        </label>
                                        <div class="col-sm-4">
                                            <select id="form-field-select-3" class="form-control search-select"
                                                    name="payment_campaign_id">
                                                <option value="">&nbsp;Please Select a Type</option>

                                                @if(!empty($all_campaign))
                                                @foreach($all_campaign as $key =>$list)
                                                    <option value="{{$list->id}}">{{$list->campaign_name}}</option>
                                                    <input type="hidden" class="form-control" name="payment_campaign_name" value="{{$list->campaign_name}}">
                                                    <input type="hidden" class="form-control" name="payment_requester_id" value="{{$list->campaign_requester_id}}">
                                                @endforeach
                                                @endif

                                            </select>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="col-sm-3 control-label">
                                            <strong>Campaign Payment Date</strong>
                                            <span class="symbol required" aria-required="true"></span>
                                        </label>
                                        <div class="col-sm-4">
                                            <input type="date" class="form-control" name="payment_date">
                                        </div>
                                    </div>


                                    <div class="form-group">
                                        <label class="col-sm-3 control-label">
                                            <strong>Campaign Payment Type</strong>
                                            <span class="symbol required" aria-required="true"></span>
                                        </label>
                                        <div class="col-sm-4">
                                            <select id="form-field-select-3" class="form-control search-select"
                                                    name="payment_type">
                                                <option value="">&nbsp;Please Select a Type</option>
                                                    <option value="bkash">BKash</option>
                                                    <option value="rocket">Rocket</option>
                                                    <option value="cash">Cash</option>
                                            </select>
                                        </div>
                                    </div>


                                    <div class="form-group">
                                        <label class="col-sm-3 control-label">
                                            <strong>Campaign Payment Amount</strong>
                                            <span class="symbol required" aria-required="true"></span>
                                        </label>
                                        <div class="col-sm-4">
                                            <input type="text" class="form-control" name="payment_amount">
                                        </div>
                                    </div>


                                    <div class="form-group">
                                        <label class="col-sm-3 control-label">
                                            <strong>Campaign Tranaction Id</strong>
                                            <span class="symbol required" aria-required="true"></span>
                                        </label>
                                        <div class="col-sm-4">
                                            <input type="text" class="form-control" name="payment_transaction_id">
                                        </div>
                                    </div>


                                    <div class="form-group">
                                        <label class="col-sm-3 control-label">
                                            <strong>Payment Description</strong>
                                        </label>
                                        <div class="col-sm-4">
                                            <textarea name="payment_description" class="form-control" cols="10" rows="7"></textarea>
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
@endsection
@section('JScript')
    <script>
        $(function () {
            $('#campaign_payment').validate({
                rules: {
                    payment_campaign_id: {
                        required: true
                    },
                    payment_date: {
                        required: true
                    },
                    payment_type:{
                        required: true
                    },
                    payment_amount:{
                        required: true
                    },
                    payment_transaction_id:{
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