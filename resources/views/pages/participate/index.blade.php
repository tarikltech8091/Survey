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
                    Participate
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
                                    <a href="{{url('/participate/create')}}">
                                        <i class="fa fa-plus-square"></i> Add Participate
                                    </a>
                                </li>
                                <li class="active">
                                    <a href="{{url('/participate/list')}}">
                                        <i class="fa fa-th-list"></i> Participate List
                                    </a>
                                </li>
                            </ul>


                            <div class="tab-content">
                                <div id="create_Participate" class="tab-pane active">
                                    <div class="row">
                                        <div class="col-md-12">

                                            <form method="get"  action="{{url('/participate/list')}}">
                                                
                                                <div class="col-md-3">
                                                    <div class="form-group has-feedback ">
                                                        <label for="search_from">
                                                            <strong>Search by status : </strong>
                                                        </label>
                                                        <select class="form-control search-select" name="participate_status">
                                                            <option {{(isset($_GET['participate_status']) && ($_GET['participate_status']==1)) ? 'selected' : ''}} value="1">Publish</option>
                                                            <option {{(isset($_GET['participate_status']) && ($_GET['participate_status']==0)) ? 'selected' : ''}} value="0">Unpublish</option>
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
                                <th>Name</th>
                                <th>Email</th>
                                <th>Mobile</th>
                                <th>Age</th>
                                <th>Religion</th>
                                <th>Gender</th>
                                <th>Occupation</th>
                                <th>Join date</th>
                                <th>District</th>
                                <th>Zone</th>
                                <th>NID</th>
                                <th>Status</th>
                                <th>Every_Type_Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            @if(!empty($all_content) && count($all_content) > 0)
                                <?php $page=isset($_GET['page'])? ($_GET['page']-1):0;?>
                                @foreach($all_content as $key => $Participate)
                                    <tr>
                                        <td>{{($key+1+($perPage*$page))}}</td>
                                        <td>{{$Participate->participate_name}}</td>
                                        <td>{{$Participate->participate_email}}</td>
                                        <td>{{$Participate->participate_mobile}}</td>
                                        <td>{{$Participate->participate_age}}</td>
                                        <td>{{$Participate->participate_religion}}</td>
                                        <td>{{$Participate->participate_gender}}</td>
                                        <td>{{$Participate->participate_occupation}}</td>
                                        <td>{{$Participate->participate_join_date}}</td>
                                        <td>{{$Participate->participate_district}}</td>
                                        <td>{{$Participate->participate_zone}}</td>
                                        <td>{{$Participate->participate_nid}}</td>
                                        <td>
                                            @if($Participate->participate_status == 1)
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
                                                <button type="button" class="btn btn-purple"><i class="fa fa-wrench"></i> Action</button><button data-toggle="dropdown" class="btn btn-purple dropdown-toggle"><span class="caret"></span></button><ul class="dropdown-menu" role="menu">
                                                    <li><a href="{{url('/participate/edit/id-'.$Participate->id)}}"><i class="fa fa-pencil"></i> Edit</a></li>
                                                    <li>
                                                        @if($Participate->participate_status == 1)
                                                            <a class="status-change"
                                                               data-publish-status="0" data-participate-id="{{ $Participate->id}}" title="Click for unpublish">
                                                                <i class="fa fa-unlock"></i> Un Publish
                                                            </a>
                                                        @else
                                                            <a class="status-change " title="Click for publish"
                                                               data-publish-status="1" data-participate-id="{{ $Participate->id}}">
                                                                <i class="fa fa-lock"></i> Publish
                                                            </a>
                                                        @endif
                                                    </li>
                                                    <li>
                                                        <a class="participate-delete" data-participate-id="{{ $Participate->id}}">
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
                                    <td colspan="14">No Data available</td>
                                </tr>
                            @endif
                            </tbody>
                        </table>
                        {{isset($pagination)? $pagination:""}}
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

            //publish and unpublish
            $('.status-change').on('click', function (e) {
                e.preventDefault();
                var status = $(this).data('publish-status');
                var id = $(this).data('participate-id');
                if(status == 0) {
                    bootbox.dialog({
                        message: "Are you sure you want to unpublish this Participate ?",
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
                                        url: site_url+'/participate/change/status/'+id+'/'+status
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
                        message: "Are you sure you want to publish this Participate?",
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
                                        url: site_url+'/participate/change/status/'+id+'/'+status
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
            // Participate delete
            $('.participate-delete').on('click', function (e) {
                e.preventDefault();
                var id = $(this).data('participate-id');
                bootbox.dialog({
                    message: "Are you sure to delete this Participate ?",
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
                                    url: site_url+'/participate/delete/id-'+id,
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