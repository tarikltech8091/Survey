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
                        <a href="{{url('/earn/payment')}}">
                            <i class="green fa fa-bell"></i> Paid Payment
                        </a>
                    </li>
                    <li class="">
                        <a href="{{url('/earn/payment/list')}}">
                            <i class="green clip-feed"></i> Paid Payment List
                        </a>
                    </li>
                </ul>
                <div class="tab-content">
                    <!-- PANEL FOR CREATE Blog -->
                    <div id="create_paid_payment" class="tab-pane active">
                        <div class="row">
                            <div class="col-md-12">
                                <form role="form" class="form-horizontal" action="{{ url('/earn/payment/save') }}"
                                      id="earn_payment" method="post" role="form" enctype="multipart/form-data">
                                    <input type="hidden" name="_token" value="{{csrf_token()}}">


                                    <div class="form-group">
                                        <label class="col-sm-3 control-label">
                                            <strong>User Type</strong>
                                            <span class="symbol required" aria-required="true"></span>
                                        </label>
                                        <div class="col-sm-4">
                                            <select id="form-field-select-3" class="form-control search-select user_type" name="earn_paid_user_type">
                                                <option value="">&nbsp;Please Select a Type</option>
                                                    <option value="surveyer">Surveyer</option>
                                                    <option value="participate">Participater</option>
                                            </select>
                                        </div>
                                    </div>


                                    <div class="user_type_details">
                                        

                                    </div>


                                    <div class="form-group">
                                        <label class="col-sm-3 control-label">
                                            <strong>Paid date</strong>
                                            <span class="symbol required" aria-required="true"></span>
                                        </label>
                                        <div class="col-sm-4">
                                            <input type="date" class="form-control" name="earn_paid_date">
                                        </div>
                                    </div>


                                    <div class="form-group">
                                        <label class="col-sm-3 control-label">
                                            <strong>Paid Type</strong>
                                            <span class="symbol required" aria-required="true"></span>
                                        </label>
                                        <div class="col-sm-4">
                                            <select id="form-field-select-3" class="form-control search-select"
                                                    name="earn_paid_payment_type">
                                                <option value="">&nbsp;Please Select a Type</option>
                                                    <option value="cash">Cash</option>
                                                    <option value="bkash">BKash</option>
                                                    <option value="rocket">Rocket</option>
                                            </select>
                                        </div>
                                    </div>


                                    <div class="form-group">
                                        <label class="col-sm-3 control-label">
                                            <strong>Paid Amount</strong>
                                            <span class="symbol required" aria-required="true"></span>
                                        </label>
                                        <div class="col-sm-4">
                                            <input type="text" class="form-control" name="earn_paid_amount">
                                        </div>
                                    </div>


                                    <div class="form-group">
                                        <label class="col-sm-3 control-label">
                                            <strong>Paid Tranaction Id</strong>
                                            <span class="symbol required" aria-required="true"></span>
                                        </label>
                                        <div class="col-sm-4">
                                            <input type="text" class="form-control" name="payment_transaction_id">
                                        </div>
                                    </div>


                                    <div class="form-group">
                                        <label class="col-sm-3 control-label">
                                            <strong>Paid Description</strong>
                                        </label>
                                        <div class="col-sm-4">
                                            <textarea name="earn_paid_description" class="form-control" cols="10" rows="7"></textarea>
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


            /* ===============================
                User Type view Ajax
           * ============================= */

            jQuery('.user_type').change(function(){

                var user_type = jQuery(this).val();
                var site_url = jQuery('.site_url').val();
                if(user_type.length !=0){

                    var request_url = site_url+'/ajax/payment/user/'+user_type;

                    jQuery.ajax({
                        url: request_url,
                        type: "get",
                        success:function(data){

                            jQuery('.user_type_details').html(data);
                        }
                    });

                }else alert("Please Select User Type");

            });



            $('#earn_payment').validate({
                rules: {
                    earn_paid_user_type: {
                        required: true
                    },
                    earn_paid_date: {
                        required: true
                    },
                    earn_paid_payment_type:{
                        required: true
                    },
                    earn_paid_amount:{
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