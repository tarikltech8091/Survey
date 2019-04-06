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
                    <li class="">
                        <a href="{{url('/life/create')}}">
                            <i class="green fa fa-bell"></i> Add Life
                        </a>
                    </li>
                    <li class="active">
                        <a href="{{url('/life/list')}}">
                            <i class="green clip-feed"></i> Life List
                        </a>
                    </li>
                </ul>
                <div class="panel-body">
                    <form method="get"  action="{{url('/life/list')}}">
                    
                        <div class="col-md-2">
                            <div class="form-group has-feedback ">
                                <label for="search_from">
                                    <strong>Search by status : </strong>
                                </label>
                                <select class="form-control search-select" name="life_status">
                                    <option {{(isset($_GET['life_status']) && ($_GET['life_status']==1)) ? 'selected' : ''}} value="1">Publish</option>
                                    <option {{(isset($_GET['life_status']) && ($_GET['life_status']==0)) ? 'selected' : ''}} value="0">Unpublish</option>
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
                <div class="tab-content">
                    <!-- PANEL FOR Album LIST -->
                    <div id="album_list" class="tab-pane active">
                        <div class="row">
                            <div class="col-md-12">
                                <div style="min-height:100px;overflow-x:auto;">
                                    <table class="table table-bordered table-hover" id="sample-table-1">
                                        <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Life Pack Name</th>
                                            <th>Life Type</th>
                                            <th>Player Id</th>
                                            <th>No of Life</th>
                                            <th>Price</th>
                                            <th>Payment type</th>
                                            <th>Tran Id</th>
                                            <th>Buy Date</th>
                                            <th>End Date</th>
                                            <th>Status</th>
                                            <th>Action</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @if (isset($all_content)&& count($all_content)>0)
                                            <?php $page=isset($_GET['page'])? ($_GET['page']-1):0;?>
                                            @foreach ($all_content as $key => $list)
                                                <tr>
                                                    <td>{{($key+1+($perPage*$page))}}</td>
                                                    <td>{{ $list->life_pack_name }}</td>
                                                    <td>{{ $list->life_buy_type }}</td>
                                                    <td>{{ $list->player_id }}</td>
                                                    <td>{{ $list->num_of_life }}</td>
                                                    <td>{{ $list->life_price }}</td>
                                                    <td>{{ $list->payment_type }}</td>
                                                    <td>{{ $list->payment_transaction_id }}</td>
                                                    <td>{{ $list->life_buy_date }}</td>
                                                    <td>{{ $list->life_buy_end_date }}</td>

                                                    <td>
                                                        @if($list->life_buy_status == 1)
                                                            <span class="label label-success btn-squared">Published</span>
                                                        @else
                                                            <span class="label label-danger btn-squared">Unpublished</span>
                                                        @endif
                                                    </td>
                                                    <td style="width:14%">
                                                        <div class="btn-group">
                                                            <button type="button" class="btn btn-purple"><i class="fa fa-wrench"></i> Action</button><button data-toggle="dropdown" class="btn btn-purple dropdown-toggle"><span class="caret"></span></button><ul class="dropdown-menu" role="menu">
                                                                <li>
                                                                    <a href="{{url('/life/edit/id-'.$list->id)}}">
                                                                        <i class="fa fa-pencil"></i> Edit
                                                                    </a>
                                                                </li>
                                                                <li>
                                                                    @if($list->life_buy_status == 1)
                                                                        <a class="status-change" data-life-publish-status="0" data-life-id="{{ $list->id}}" title="Click for unpublish">
                                                                            <i class="fa fa-lock"></i> Unpublish
                                                                        </a>
                                                                    @else
                                                                        <a class="status-change " title="Click for publish" data-life-publish-status="1" data-life-id="{{ $list->id}}">
                                                                            <i class="fa fa-unlock"></i> Publish
                                                                        </a>
                                                                    @endif
                                                                </li>
                                                                
                                                                <li>
                                                                    <a class="life-delete" data-Life-id="{{$list->id}}">
                                                                        <i class="fa fa-trash-o" aria-hidden="true"></i> Delete
                                                                    </a>
                                                                </li>
                                                            </ul>
                                                        </div>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        @else
                                            <tr>
                                                <td colspan="12">
                                                    <div class="alert alert-success" role="alert">
                                                        <h4>No Data Available !</h4>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endif
                                        </tbody>
                                    </table>
                                </div>
                                {{isset($pagination)?$pagination:''}}
                            </div>
                        </div>
                    </div>
                    <!-- END PANEL FOR Album LIST -->
                    {{--<div class="text-center">
                        {!!$Life_all->links()!!}
                    </div>--}}
                </div>
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
                var life_publish_status = $(this).data('life-publish-status');
                var id = $(this).data('life-id');
                if(life_publish_status == 0) {
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
                                        url: site_url+'/life/change/status/'+id+'/'+life_publish_status
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
                                        url: site_url+'/life/change/status/'+id+'/'+life_publish_status
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


            // Life delete
            $('.life-delete').on('click', function (e) {
                e.preventDefault();
                var id = $(this).data('life-id');
                bootbox.dialog({
                    message: "Are you sure you want to delete this Life ?",
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
                                    url: site_url+'/life/delete/id-'+id,
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
        })
    </script>
@endsection