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

                <!-- PANEL FOR Album LIST -->
                <div id="campaign_list" class="tab-pane active">
                    <div class="row">
                        <div class="col-md-12">
                            <div style="min-height:100px;overflow-x:auto;">
                                <table class="table table-bordered table-hover" id="sample-table-1">
                                    <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Campaign Name</th>
                                        <th>Campaign Title</th>
                                        <th>Start Date</th>
                                        <th>End Date</th>
                                        <th>Total Days</th>
                                        <th>Campaign Status</th>
                                        <th>Active</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @if (isset($all_content)&& count($all_content)>0)
                                        @foreach ($all_content as $key => $list)
                                            <tr>
                                                <td class="text-center">{{($key+1)}}</td>
                                                <td class="text-center">{{ $list->campaign_name }}</td>
                                                <td class="text-center">{{ $list->campaign_title }}</td>
                                                <td class="text-center">{{ $list->campaign_start_date }}</td>
                                                <td class="text-center">{{ $list->campaign_end_date }}</td>
                                                <td class="text-center">{{ $list->campaign_num_of_days }}</td>

                                                <td class="text-center">
                                                    @if($list->campaign_status == 1)
                                                        <span class="label label-success btn-squared">
	                                                        Published
	                                                    </span>
                                                    @else
                                                        <span class="label label-danger btn-squared">Unpublished</span>
                                                    @endif
                                                </td>
                                                @php
                        							$surveyer_id=\Auth::user()->surveyer_id;
                        						@endphp
                        						@if(!empty($surveyer_id))
	                                                <td class="text-center">
	                                                    <span class="btn btn-danger btn-squared">
	                                                    	<a href="{{url('/surveyer/question/answer/'.$surveyer_id.'/'.$list->id.'/1')}}">
	                                                        	Play
	                                                        </a>
	                                                    </span>
	                                                </td>
	                                            @else
                                                	<td class="text-center">No</td>
                                                @endif
                                            </tr>
                                        @endforeach
                                    @else
                                        <tr>
                                            <td colspan="8">
                                                <div class="alert alert-success" role="alert">
                                                    <h4>No Data Available !</h4>
                                                </div>
                                            </td>
                                        </tr>
                                    @endif
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- END PANEL FOR  LIST -->

            </div>
        </div>
    </div>
@endsection
@section('JScript')
    <script>
        $(function () {
            var site_url = $('.site_url').val();

            //publish and unpublish
            $('.status-change').on('click', function (e) {
                e.preventDefault();
                var campaign_publish_status = $(this).data('campaign-publish-status');
                var id = $(this).data('campaign-id');
                if(campaign_publish_status == 0) {
                    bootbox.dialog({
                        message: "Are you sure you want to unpublish ?",
                        title: "<i class='glyphicon glyphicon-eye-close'></i> Unpublish !",
                        buttons: {
                            danger: {
                                label: "No!",
                                className: "btn-danger btn-squared",
                                callback: function() {
                                    $('.bootbox').modal('hide');
                                }
                            },
                            success: {
                                label: "Yes!",
                                className: "btn-success btn-squared",
                                callback: function() {
                                    $.ajax({
                                        type: 'GET',
                                        url: site_url+'/campaign/change/status/'+id+'/'+campaign_publish_status
                                    }).done(function(response){
                                        bootbox.alert(response,
                                            function(){
                                                location.reload(true);
                                            }
                                        );

                                    }).fail(function(response){
                                        bootbox.alert(response);
                                    })
                                }
                            }
                        }
                    });
                } else {
                    bootbox.dialog({
                        message: "Are you sure you want to publish ?",
                        title: "<i class='glyphicon glyphicon-eye-open'></i> Publish !",
                        buttons: {
                            danger: {
                                label: "No!",
                                className: "btn-danger btn-squared",
                                callback: function() {
                                    $('.bootbox').modal('hide');
                                }
                            },
                            success: {
                                label: "Yes!",
                                className: "btn-success btn-squared",
                                callback: function() {
                                    $.ajax({
                                        type: 'GET',
                                        url: site_url+'/campaign/change/status/'+id+'/'+campaign_publish_status
                                    }).done(function(response){
                                        bootbox.alert(response,
                                            function(){
                                                location.reload(true);
                                            }
                                        );
                                    }).fail(function(response){
                                        bootbox.alert(response);
                                    })
                                }
                            }
                        }
                    });
                }
            });

            
        })
    </script>
@endsection