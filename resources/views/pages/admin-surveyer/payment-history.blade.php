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


	<div class="row page_row">

		<div class="col-md-12 alert alert-success dash_pad_0">
			<div class="row page_row_dash">

				<div class="col-md-3">
					<div class="report_view reprt_color_1 cursor dashborad_menus centered">
						<p class="report_name">	
							<a href="#">Total Amount</a>
						</p><br>
						<p class="report_name">	
							<a href="#">{{isset($surveyer_info->surveyer_total_earn)? $surveyer_info->surveyer_total_earn : '0'}}</a>
						</p>
					</div>
				</div>

				<div class="col-md-3">
					<div class="report_view reprt_color_1 cursor dashborad_menus centered">
						<p class="report_name">	
							<a href="#">Paid Amount</a>
						</p><br>
						<p class="report_name">	
							<a href="#">{{isset($surveyer_info->surveyer_total_paid)? $surveyer_info->surveyer_total_paid : '0'}}</a>
						</p>
					</div>
				</div>

				<div class="col-md-3">
					<div class="report_view reprt_color_1 cursor dashborad_menus centered">
						<p class="report_name">	
							<a href="#">Due Amount</a>
						</p><br>
						<p class="report_name">	
							<a href="#">{{(isset($surveyer_info->surveyer_total_earn)? $surveyer_info->surveyer_total_earn : '0') - (isset($surveyer_info->surveyer_total_paid)? $surveyer_info->surveyer_total_paid : '0')}}</a>
						</p>
					</div>
				</div>


                <div class="col-md-3">
                    <div class="report_view reprt_color_1 cursor dashborad_menus centered">
                        <p class="report_name"> 
                            <a href="#">Success Participate</a>
                        </p><br>
                        <p class="report_name"> 
                            <a href="#">{{isset($surveyer_info->surveyer_total_success_participate)? $surveyer_info->surveyer_total_success_participate : '0'}}</a>
                        </p>
                    </div>
                </div>



			</div>
				

		</div>

	</div>

    <div class="row ">
        <div class="col-sm-12">
            <div class="tabbable">

                <div class="panel-body">

                </div>

                <div class="tab-content">
                    <!-- PANEL LIST -->
                    <div id="album_list" class="tab-pane active">
                        <div class="row">
                            <div class="col-md-12">
                                <div style="min-height:100px;overflow-x:auto;">
                                    <table class="table table-bordered table-hover" id="sample-table-1">
                                        <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Campaign Name</th>
                                            <th>Requester Number</th>
                                            <th>Payment Date</th>
                                            <th>Payment Type</th>
                                            <th>Payment Amount</th>
                                            <th>Tranaction Id</th>
                                            <th>Description</th>
                                            <th>Status</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @if (isset($all_content)&& count($all_content)>0)
                                            <?php $page=isset($_GET['page'])? ($_GET['page']-1):0;?>
                                            @foreach ($all_content as $key => $list)
                                                <tr>
                                                    <td>{{($key+1+($perPage*$page))}}</td>
                                                    <td>{{ $list->payment_campaign_name }}</td>
                                                    <td>{{ $list->payment_requester_id }}</td>
                                                    <td>{{ $list->payment_date }}</td>
                                                    <td>{{ $list->payment_type }}</td>
                                                    <td>{{ $list->payment_amount }}</td>
                                                    <td>{{ $list->payment_transaction_id }}</td>
                                                    <td>{{ str_limit($list->payment_description, 15)  }}</td>

                                                    <td>
                                                        @if($list->payment_status == 1)
                                                            <span class="label label-success btn-squared">Published</span>
                                                        @else
                                                            <span class="label label-danger btn-squared">Unpublished</span>
                                                        @endif
                                                    </td>

                                                </tr>
                                            @endforeach
                                        @else
                                            <tr>
                                                <td colspan="13" class="text-center">
                                                    <h4>No Data Available !</h4>
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

                </div>
            </div>
        </div>
    </div>
@endsection
@section('JScript')
    <script>
        $(function () {
            var site_url = $('.site_url').val();
        })
    </script>
@endsection