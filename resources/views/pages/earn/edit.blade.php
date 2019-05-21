@extends('layout.master')
@section('content')
    <div class="row">
        <div class="col-md-12">
            <!-- start: FORM VALIDATION 2 PANEL -->
            <div class="panel panel-default btn-squared">
                <div class="panel-heading">
                    <i class="fa fa-external-link-square"></i>
                    Edit Paid Payment
                    <div class="panel-tools">
                        <a class="btn btn-xs btn-link panel-collapse collapses" href="#">
                        </a>
                        <a class="btn btn-xs btn-link panel-close" href="#">
                            <i class="fa fa-times"></i>
                        </a>
                    </div>
                </div>

                <div class="panel-body">
                    <ul id="myTab" class="nav nav-tabs tab-bricky">
                        <li>
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

                    <form role="form" class="form-horizontal" action="{{ url('/earn/payment/update/id-'.$edit->id) }}"
                          id="earn_payment" method="post" role="form" enctype="multipart/form-data">
                        <input type="hidden" name="_token" value="{{csrf_token()}}">

                        <div class="form-group">
                            <label class="col-sm-3 control-label">
                                <strong>User Type</strong>
                                <span class="symbol required" aria-required="true"></span>
                            </label>
                            <div class="col-sm-4">
                                <input type="text" class="form-control" name="earn_paid_user_type" value="{{isset($edit->earn_paid_user_type)? $edit->earn_paid_user_type:''}}" readonly="">
                            </div>
                        </div>

                        <!-- <div class="form-group">
                            <label class="col-sm-3 control-label">
                                <strong>User Type</strong>
                                <span class="symbol required" aria-required="true"></span>
                            </label>
                            <div class="col-sm-4">
                                <select id="form-field-select-3" class="form-control search-select user_type"
                                        name="earn_paid_user_type">
                                    <option value="">&nbsp;Please Select a Type</option>
                                        <option {{($edit->earn_paid_user_type == 'surveyer') ? 'selected' : ''}} value="surveyer">Surveyer</option>
                                        <option {{($edit->earn_paid_user_type == 'participate') ? 'selected' : ''}} value="participate">Participater</option>
                                </select>
                            </div>
                        </div>

                        <div class="user_type_details">
                            

                        </div> -->

                        @if($edit->earn_paid_user_type == "surveyer")
                            <div class="form-group">
                                <label class="col-sm-3 control-label">
                                    <strong>Select Surveyer</strong>
                                    <span class="symbol required" aria-required="true"></span>
                                </label>
                                <div class="col-sm-4">
                                    <select id="form-field-select-3" class="form-control search-select"
                                            name="earn_paid_surveyer_id">
                                        <option value="">&nbsp;Please Select a Type</option>

                                        @if(!empty($all_surveyer))
                                        @foreach($all_surveyer as $key =>$list)
                                            <option {{($edit->earn_paid_surveyer_id == ($list->id)) ? 'selected' : ''}} value="{{$list->id}}">{{$list->surveyer_name}}</option>
                                        @endforeach
                                        @endif

                                    </select>
                                </div>
                            </div>
                        @elseif($edit->earn_paid_user_type == "participate")
                            <div class="form-group">
                                <label class="col-sm-3 control-label">
                                    <strong>Select Participate Member</strong>
                                    <span class="symbol required" aria-required="true"></span>
                                </label>
                                <div class="col-sm-4">
                                    <select id="form-field-select-3" class="form-control search-select"
                                            name="earn_paid_participate_id">
                                        <option value="">&nbsp;Please Select a Type</option>

                                        @if(!empty($all_participate))
                                        @foreach($all_participate as $key =>$value)
                                            <option {{($edit->earn_paid_participate_id == $value->id) ? 'selected' : ''}} value="{{$value->id}}">{{$value->participate_name}}</option>
                                        @endforeach
                                        @endif

                                    </select>
                                </div>
                            </div>


                            <div class="form-group">
                                <label class="col-sm-3 control-label">
                                    <strong> Participate Paid Points</strong>
                                    <span class="symbol required" aria-required="true"></span>
                                </label>
                                <div class="col-sm-4">
                                    <input type="number" class="form-control" value="{{isset($edit->participate_paid_points)? $edit->participate_paid_points:''}}" name="participate_paid_points">
                                </div>
                            </div>

                        @endif


                        <div class="form-group">
                            <label class="col-sm-3 control-label">
                                <strong>Paid date</strong>
                                <span class="symbol required" aria-required="true"></span>
                            </label>
                            <div class="col-sm-4">
                                <input type="date" class="form-control" name="earn_paid_date" value="{{isset($edit->earn_paid_date)? $edit->earn_paid_date:''}}">
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
                                        <option {{($edit->earn_paid_payment_type == 'bkash') ? 'selected' : ''}} value="bkash">BKash</option>
                                        <option {{($edit->earn_paid_payment_type == 'rocket') ? 'selected' : ''}} value="rocket">Rocket</option>
                                        <option {{($edit->earn_paid_payment_type == 'cash') ? 'selected' : ''}} value="cash">Cash</option>
                                </select>
                            </div>
                        </div>


                        <div class="form-group">
                            <label class="col-sm-3 control-label">
                                <strong>Paid Amount</strong>
                                <span class="symbol required" aria-required="true"></span>
                            </label>
                            <div class="col-sm-4">
                                <input type="text" class="form-control" name="earn_paid_amount" value="{{isset($edit->earn_paid_amount)? $edit->earn_paid_amount:''}}">
                            </div>
                        </div>


                        <div class="form-group">
                            <label class="col-sm-3 control-label">
                                <strong>Paid Tranaction Id</strong>
                                <span class="symbol required" aria-required="true"></span>
                            </label>
                            <div class="col-sm-4">
                                <input type="text" class="form-control" name="payment_transaction_id" value="{{isset($edit->payment_transaction_id)? $edit->payment_transaction_id:''}}">
                            </div>
                        </div>


                        <div class="form-group">
                            <label class="col-sm-3 control-label">
                                <strong>Paid Description</strong>
                            </label>
                            <div class="col-sm-4">
                                <textarea name="earn_paid_description" class="form-control" cols="10" rows="7">{{isset($edit->earn_paid_description)? $edit->earn_paid_description:''}}</textarea>
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


            /* ===============================
                User Type view Ajax
           * ============================= */

            /*jQuery('.user_type').change(function(){

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

            });*/



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