@extends('layout.master')
@section('content')
    <div class="row">
        <div class="col-md-12">
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
            <div class="panel panel-default btn-squared">
                <div class="panel-heading">
                    <i class="fa fa-external-link-square"></i>
                    Surveyer
                    <div class="panel-tools">
                        <a class="btn btn-xs btn-link panel-collapse collapses" href="#">
                        </a>
                        <a class="btn btn-xs btn-link panel-close" href="#">
                            <i class="fa fa-times"></i>
                        </a>
                    </div>
                </div>
                <div class="panel-body">


                    <div class="tabbable">


                        <ul id="myTab" class="nav nav-tabs tab-bricky">
                            <li>
                                <a href="{{url('/surveyer/assign')}}">
                                    <i class="green fa fa-bell"></i> Assign Surveyer
                                </a>
                            </li>
                            <li class="active">
                                <a href="{{url('/surveyer/assign/list')}}">
                                    <i class="green clip-feed"></i>Assign Surveyer List
                                </a>
                            </li>
                        </ul>


                        <div class="tab-content">
                            <div id="create_surveyer" class="tab-pane active">
                                <div class="row">
                                    <div class="col-md-12">

                                        <form method="get"  action="{{url('/surveyer/assign/list')}}">
                                            
                                            <div class="col-md-3">
                                                <div class="form-group has-feedback ">
                                                    <label for="search_from">
                                                        <strong>Search by status : </strong>
                                                    </label>
                                                    <select class="form-control search-select" name="assign_status">
                                                        <option {{(isset($_GET['assign_status']) && ($_GET['assign_status']==1)) ? 'selected' : ''}} value="1">Publish</option>
                                                        <option {{(isset($_GET['assign_status']) && ($_GET['assign_status']==0)) ? 'selected' : ''}} value="0">Unpublish</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-1" style="margin-top:22px;">
                                                <div class="form-group">
                                                    <input type="submit" class="btn btn-primary btn-squared" value="Search">
                                                </div>
                                            </div>

                                        </form>
                                        
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>


                    <div class="table-responsive">
                        <table class="table table-hover table-bordered table-striped nopadding">
                            <thead>
                            <tr>
                                <th>#</th>
                                <th>Surveyer Name</th>
                                <th>Surveyer Mobile</th>
                                <th>Campaign Name</th>
                                <th>Zone</th>
                                <th>Target</th>
                                <th>Prize</th>
                                <th>Description</th>
                                <th>Prize</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            @if(!empty($all_content) && count($all_content) > 0)
                                <?php $page=isset($_GET['page'])? ($_GET['page']-1):0;?>
                                @foreach($all_content as $key => $surveyer)
                                    <tr>
                                        <td>{{($key+1+($perPage*$page))}}</td>
                                        <td>{{$surveyer->assign_surveyer_name}}</td>
                                        <td>{{$surveyer->assign_surveyer_name}}</td>
                                        <td>{{$surveyer->assign_campaign_name}}</td>
                                        <td>{{$surveyer->assign_zone}}</td>
                                        <td>{{$surveyer->assign_target}}</td>
                                        <td>{{$surveyer->surveyer_prize_amount}}</td>
                                        <td>{{ str_limit($surveyer->assign_campaign_description, 15)  }}</td>
                                        <td>
                                            @if($surveyer->success_status == 1)
                                                <span class="label label-success">
                                                    Complete
                                                </span>
                                            @elseif($surveyer->success_status == -1)
                                                <span class="label label-danger">
                                                    Reject
                                                </span>
                                            @else
                                                <span class="label label-warning">
                                                    Waiting
                                                </span>
                                            @endif
                                        </td>
                                        <td>
                                            @if($surveyer->assign_status == 1)
                                                <span class="label label-success">
                                                    Published
                                                </span>
                                            @else
                                                <span class="label label-danger">
                                                    Un-published
                                                </span>
                                            @endif
                                        </td>
                                        <td style="width:14%">
                                            <div class="btn-group">
                                                <button type="button" class="btn btn-purple"><i class="fa fa-wrench"></i> Action</button><button data-toggle="dropdown" class="btn btn-purple dropdown-toggle"><span class="caret"></span></button>
                                                <ul class="dropdown-menu" role="menu">
                                                    <li><a href="{{url('/surveyer/assign/edit/id-'.$surveyer->id)}}"><i class="fa fa-pencil"></i> Edit</a></li>
                                                    <li>
                                                        @if($surveyer->assign_status == 1)
                                                            <a class="status-change"
                                                               data-publish-status="0" data-surveyer-id="{{ $surveyer->id}}" title="Click for unpublish">
                                                                <i class="fa fa-unlock"></i> Un Publish
                                                            </a>
                                                        @else
                                                            <a class="status-change " title="Click for publish"
                                                               data-publish-status="1" data-surveyer-id="{{ $surveyer->id}}">
                                                                <i class="fa fa-lock"></i> Publish
                                                            </a>
                                                        @endif
                                                    </li>
                                                    <li>
                                                        <a class="success-status" data-success-status="1" data-surveyer-id="{{ $surveyer->id}}" title="Click for unpublish"><i class="fa fa-pencil"></i> Prize Confirm</a>
                                                    </li>
                                                    <li>
                                                        <a data-toggle="modal" data-target="#RejectDetailsModal"  data-id="" class="text_none" href=""><i class="fa fa-external-link"></i> Prize Reject</a>
                                                    </li>
                                                    <li>
                                                        <a class="surveyer-delete" data-surveyer-id="{{ $surveyer->id}}">
                                                            <i class="fa fa-trash-o" aria-hidden="true"></i> Delete
                                                        </a>
                                                    </li>
                                                </ul>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            @else
                                <tr class="text-center">
                                    <td colspan="12">No Data available</td>
                                </tr>
                            @endif
                            </tbody>
                        </table>
                        {{isset($pagination)? $pagination:""}}
                    </div>




                    <!-- Modal -->
                    <div id="RejectDetailsModal" class="modal fade" role="dialog">
                         <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                            <h4 class="modal-title">Reject Details</h4>
                        </div>

                        <div class="modal-body">

                            <div class="coupon_details">

                            </div>

                        </div>
                        
                    </div>



                </div>
            </div>
        </div>
    </div>





    <style type="text/css">
        .table .tbl_image {
            width: 10%;
        }
        .table .tbl_image img {
            width: 50%;
        }
    </style>
@endsection

@section('JScript')
    <script>

        $(function () {
            var site_url = $('.site_url').val();



            // model view
            $('.coupon_details_show').click(function(){

                var coupon_id = jQuery(this).data('id');

                var site_url = jQuery('.site_url').val();

                var request_url  = site_url+'/dashboard/coupon-details/id-'+coupon_id;

                jQuery.ajax({

                  url: request_url,

                  aysnc:false,

                  type: 'get',

                  success:function(data){

                      jQuery('.coupon_details').html(data);

                       // $("#CouponDetailsModal").modal('toggle');
                  }

                });

            });



            //publish and unpublish
            $('.status-change').on('click', function (e) {
                e.preventDefault();
                var status = $(this).data('publish-status');
                var id = $(this).data('surveyer-id');
                if(status == 0) {
                    bootbox.dialog({
                        message: "Are you sure you want to unpublish this surveyer ?",
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
                                        url: site_url+'/surveyer/assign/change/status/'+id+'/'+status
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
                        message: "Are you sure you want to publish this surveyer?",
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
                                        url: site_url+'/surveyer/assign/change/status/'+id+'/'+status
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



            //Prize publish and unpublish
            $('.success-status').on('click', function (e) {
                e.preventDefault();
                var status = $(this).data('success-status');
                var id = $(this).data('surveyer-id');
                    bootbox.dialog({
                        message: "Are you sure to confirm surveyer prize?",
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
                                        url: site_url+'/surveyer/success/confirm/'+id+'/'+status
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

            });




            // surveyer delete
            $('.surveyer-delete').on('click', function (e) {
                e.preventDefault();
                var id = $(this).data('surveyer-id');
                bootbox.dialog({
                    message: "Are you sure to delete this surveyer ?",
                    title: "<i class='glyphicon glyphicon-trash'></i> Delete !",
                    buttons: {
                        success: {
                            label: "No",
                            className: "btn-success btn-squared",
                            callback: function() {
                                $('.bootbox').modal('hide');
                            }
                        },
                        danger: {
                            label: "Delete!",
                            className: "btn-danger btn-squared",
                            callback: function() {
                                $.ajax({
                                    type: 'GET',
                                    url: site_url+'/surveyer/assign/delete/id-'+id,
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
            });
        });
    </script>
@endsection