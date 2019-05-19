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

                    <form role="form" class="form-horizontal" action="{{ url('/requester/campaign/update/id-'.$edit->id) }}"
                          id="campaign" method="post" role="form" enctype="multipart/form-data">
                        <input type="hidden" name="_token" value="{{csrf_token()}}">

                        <div class="form-group">
                            <label class="col-sm-2 control-label">
                                <strong>Campaign Name</strong>
                                <span class="symbol required" aria-required="true"></span>
                            </label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" value="{{isset($edit->campaign_name)? $edit->campaign_name:''}}" name="campaign_name">
                            </div>
                        </div>
            
                        <div class="form-group">
                            <label class="col-sm-2 control-label">
                                <strong>Campaign Title</strong>
                                <span class="symbol required" aria-required="true"></span>
                            </label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" name="campaign_title" value="{{isset($edit->campaign_title)? $edit->campaign_title:''}}">
                            </div>
                        </div>


                        <div class="form-group">
                            <label class="col-sm-2 control-label">
                                <strong>Campaign Category </strong>
                                <span class="symbol required" aria-required="true"></span>
                            </label>
                            <div class="col-sm-4">
                                <select id="form-field-select-3" class="form-control search-select" name="campaign_category">
                                    <option value="">&nbsp;Please Select a Type</option>
                                        @if(!empty($all_category))
                                        @foreach($all_category as $key =>$value)
                                            <option {{($edit->campaign_category == $value->category_name) ? 'selected' : ''}} value="{{$value->category_name}}">{{$value->category_name}}</option>
                                        @endforeach
                                        @endif
                                </select>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-2 control-label">
                                <strong>Requster Select</strong>
                                <span class="symbol required" aria-required="true"></span>
                            </label>
                            <div class="col-sm-8">
                                <select id="form-field-select-3" class="form-control search-select"
                                        name="campaign_requester_id">
                                    <option value="">&nbsp;Please Select a Type</option>

                                    @if(!empty($all_requester))
                                    @foreach($all_requester as $key =>$list)
                                        <option {{($edit->campaign_requester_id == $list->id) ? 'selected' : ''}} value="{{$list->id}}">{{$list->requester_name}}</option>
                                        <input type="hidden" class="form-control" name="campaign_requester_name" value="{{$list->requester_name}}">
                                        <input type="hidden" class="form-control" name="campaign_requester_mobile" value="{{$list->requester_mobile}}">
                                    @endforeach
                                    @endif

                                </select>
                            </div>
                        </div>


                        <div class="form-group">
                            <label class="col-sm-2 control-label">
                                <strong>Campaign Start Date</strong>
                                <span class="symbol required" aria-required="true"></span>
                            </label>
                            <div class="col-sm-4">
                                <input type="date" class="form-control" value="{{isset($edit->campaign_start_date)? $edit->campaign_start_date:''}}" name="campaign_start_date">
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-2 control-label">
                                <strong>Campaign End Date</strong>
                                <span class="symbol required" aria-required="true"></span>
                            </label>
                            <div class="col-sm-4">
                                <input type="date" class="form-control" value="{{isset($edit->campaign_end_date)? $edit->campaign_end_date:''}}" name="campaign_end_date">
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-2 control-label">
                                <strong>Campaign Num of days</strong>
                                <span class="symbol required" aria-required="true"></span>
                            </label>
                            <div class="col-sm-4">
                                <input type="number" class="form-control" value="{{isset($edit->campaign_num_of_days)? $edit->campaign_num_of_days:''}}" name="campaign_num_of_days">
                            </div>
                        </div>


                        <div class="form-group">
                            <label class="col-sm-2 control-label">
                                <strong>Campaign Total Cost</strong>
                                <span class="symbol required" aria-required="true"></span>
                            </label>
                            <div class="col-sm-4">
                                <input type="number" class="form-control" value="{{isset($edit->campaign_total_cost)? $edit->campaign_total_cost:''}}" name="campaign_total_cost">
                            </div>
                        </div>

                        <!-- <div class="form-group">
                            <label class="col-sm-2 control-label">
                                <strong>Campaign Total Paid Cost</strong>
                                <span class="symbol required" aria-required="true"></span>
                            </label>
                            <div class="col-sm-4">
                                <input type="number" class="form-control" name="campaign_total_cost_paid" value="{{isset($edit->campaign_total_cost_paid)? $edit->campaign_total_cost_paid:''}}">
                            </div>
                        </div> -->

                        <!-- <div class="form-group">
                            <label class="col-sm-2 control-label">
                                <strong>Campaign Surveyer Cost</strong>
                            </label>
                            <div class="col-sm-4">
                                <input type="number" class="form-control" value="{{isset($edit->campaign_cost_for_surveyer)? $edit->campaign_cost_for_surveyer:''}}" name="campaign_cost_for_surveyer">
                            </div>
                        </div>


                        <div class="form-group">
                            <label class="col-sm-2 control-label">
                                <strong>Campaign Prize Amount</strong>
                            </label>
                            <div class="col-sm-4">
                                <input type="number" class="form-control" name="campaign_prize_amount" value="{{isset($edit->campaign_prize_amount)? $edit->campaign_prize_amount:''}}">
                            </div>
                        </div> -->


                        <div class="form-group">
                            <label class="col-sm-2 control-label">
                                <strong>Campaign Physical Prize</strong>
                            </label>
                            <div class="col-sm-4">
                                <input type="text" class="form-control" name="campaign_physical_prize" value="{{isset($edit->campaign_physical_prize)? $edit->campaign_physical_prize:''}}">
                            </div>
                        </div>


                        <div class="form-group">
                            <label class="col-sm-2 control-label">
                                <strong>Campaign Zone Dertails</strong>
                            </label>
                            <div class="col-sm-4">
                                <input type="text" class="form-control" value="{{isset($edit->campaign_zone)? $edit->campaign_zone:''}}" name="campaign_zone">
                            </div>
                        </div>


                        <div class="form-group">
                            <label class="col-sm-2 control-label">
                                <strong>Campaign Number Of Zone</strong>
                            </label>
                            <div class="col-sm-4">
                                <input type="number" class="form-control" value="{{isset($edit->campaign_total_num_of_zone)? $edit->campaign_total_num_of_zone:''}}" name="campaign_total_num_of_zone">
                            </div>
                        </div>



                        <div class="form-group">
                            <label class="col-sm-2 control-label">
                                <strong>Description</strong>
                            </label>
                            <div class="col-sm-6">
                                <textarea name="campaign_description" value="{{isset($edit->campaign_description)? $edit->campaign_description:''}}" class="form-control" cols="10" rows="7"></textarea>
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
            $('#campaign').validate({
                rules: {
                    campaign_name: {
                        required: true
                    },
                    campaign_title: {
                        required: true
                    },
                    campaign_category: {
                        required: true
                    },
                    campaign_requester_id:{
                        required: true
                    },
                    campaign_start_date:{
                        required: true
                    },
                    campaign_end_date:{
                        required: true
                    },
                    campaign_num_of_days:{
                        required: true
                    },
                    campaign_total_cost:{
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