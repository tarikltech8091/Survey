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

                    <form role="form" class="form-horizontal" action="{{ url('/campaign/payment/update/id-'.$edit->id) }}"
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
                                        <option {{($edit->payment_campaign_id == $list->id) ? 'selected' : ''}} value="{{$list->id}}">{{$list->campaign_name}}</option>
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
                                <input type="date" class="form-control" name="payment_date" value="{{isset($edit->payment_date)? $edit->payment_date:''}}">
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
                                        <option {{($edit->payment_type == 'bkash') ? 'selected' : ''}} value="bkash">BKash</option>
                                        <option {{($edit->payment_type == 'rocket') ? 'selected' : ''}} value="rocket">Rocket</option>
                                        <option {{($edit->payment_type == 'cash') ? 'selected' : ''}} value="cash">Cash</option>
                                </select>
                            </div>
                        </div>


                        <div class="form-group">
                            <label class="col-sm-3 control-label">
                                <strong>Campaign Payment Amount</strong>
                                <span class="symbol required" aria-required="true"></span>
                            </label>
                            <div class="col-sm-4">
                                <input type="text" class="form-control" name="payment_amount" value="{{isset($edit->payment_amount)? $edit->payment_amount:''}}">
                            </div>
                        </div>


                        <div class="form-group">
                            <label class="col-sm-3 control-label">
                                <strong>Campaign Tranaction Id</strong>
                                <span class="symbol required" aria-required="true"></span>
                            </label>
                            <div class="col-sm-4">
                                <input type="text" class="form-control" name="payment_transaction_id" value="{{isset($edit->payment_transaction_id)? $edit->payment_transaction_id:''}}">
                            </div>
                        </div>


                        <div class="form-group">
                            <label class="col-sm-3 control-label">
                                <strong>Payment Description</strong>
                            </label>
                            <div class="col-sm-4">
                                <textarea name="payment_description" class="form-control" cols="10" rows="7">{{isset($edit->payment_description)? $edit->payment_description:''}}</textarea>
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