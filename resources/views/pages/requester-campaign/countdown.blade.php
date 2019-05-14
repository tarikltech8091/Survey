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


    <style type="text/css">
    	  .page_row_dash{
			   margin: 15px 15px;
			   padding: 5px;
			 }


			/*search width*/
			.page_row .search_width{
			  width: 70%;
			}



			.page_row{
			  margin-left: 5px;
			  margin-right: 5px;
			  margin-top: 8px;
			}

			.page_row .panel .panel-heading {
			  height: 30px;
			  padding: 5px 15px;
			}

			.dash_pad_0{
			  padding:0;
			}


			/*dashborad_menus*/
			.dashborad_menus{
			  height: 100px;
			  padding-top: 8px;
			}


			/*cursor pointer*/
			.cursor{
			  cursor:pointer;
			}


			  .report_view {
			    border-radius: 3px;
			    box-shadow: 0 1px 1px rgba(0, 0, 0, 0.05);
			    text-align: center;
			    width: 80%;
			  }
			  .report_view.reprt_color_1{
			    background: #569099 none repeat scroll 0 0;
			    border-color:  #569099;

			  }

			  .report_view.reprt_color_2{
			    background: #1f6f43 none repeat scroll 0 0;
			    border-color:  #1f6f43;

			  }

			  .report_view.reprt_color_3{
			    background: #f4731d none repeat scroll 0 0;
			    border-color:  #f4731d;

			  }


			  .report_view .report_name{
			    color: white;
			    margin-bottom: 0;
			    padding-bottom: 6px;
			    text-align: center;
			  }

			  .report_name a{

			    color: #ffffff;
			    text-decoration: none;
			    text-transform: uppercase;
			  }
    </style>

    <div class="row ">
        <div class="col-sm-12">
            <div class="tabbable">

                <div class="panel-body">
                    <form method="get"  action="{{url('/campaign/participate/countdown')}}">

                        <div class="col-md-3">
                            <div class="form-group has-feedback ">
                                <label for="search_from">
                                    <strong>Search by Campaign : </strong>
                                </label>
                                <select class="form-control search-select" name="search_campaign_id">
                                    <option {{(isset($_GET['search_campaign_id']) && ($_GET['search_campaign_id']==0)) ? 'selected' : ''}} value="0">All</option>

                                    @if(!empty($all_campaign) && count($all_campaign) > 0)
                                    @foreach($all_campaign as $key => $list)
                                        <option {{(isset($_GET['search_campaign_id']) && ($_GET['search_campaign_id'] == $list->id)) ? 'selected' : ''}} value="{{$list->id}}">{{$list->campaign_name}}</option>
                                    @endforeach
                                    @endif
                                </select>
                            </div>
                        </div>

                        <div class="col-md-1" style="margin-top:25px;">
                            <div class="form-group">
                                <input type="submit" class="btn btn-primary btn-squared" value="Search">
                            </div>
                        </div>
                    </form>
                </div>

            </div>
        </div>
    </div>



	<div class="row page_row">
		<div class="col-md-12">
			<div class="col-md-12 alert alert-success dash_pad_0">
				<div class="row page_row_dash">

					<div class="col-md-3" style="margin-top: 20px;">
						<div class="report_view reprt_color_1 cursor dashborad_menus centered">
							<!-- <p>
								<a href="#" style="color: #ffffff;">
									<i class="fa fa-list" aria-hidden="true"></i>
								</a>
							</p> -->
							<p class="report_name">	
								<a href="#">Total Participate</a>
							</p><br>
							<p class="report_name">	
								<a href="#">{{isset($total_participate)? $total_participate : '0'}}</a>
							</p>
						</div>
					</div>

					@if(!empty($numberOfQuestions))
					@foreach($numberOfQuestions as $key => $list)

						<div class="col-md-3" style="margin-top: 20px;">
							<div class="report_view reprt_color_1 cursor dashborad_menus centered">
								<!-- <p>	
									<a href="#" style="color: #ffffff;"><i class="fa fa-list" aria-hidden="true"></i>
									</a>
								</p> -->

								<p class="report_name">	
									<a href="{{url('/campaign/participate/question-'.$list->answer_question_id)}}">{{$list->question_answer_title}} </a>
								</p><br>

								<p class="report_name">	
									<a href="#">{{$list->num}}</a>
								</p>
							</div>
						</div>

					@endforeach
					@endif



				</div>
					

			</div>
		</div>
	</div>




    <div class="row ">
        <div class="col-sm-12">
            <div class="tabbable">

                <div class="panel-body">
                    <form method="get"  action="{{url('/campaign/participate/countdown')}}">

                        <div class="col-md-3">
                            <div class="form-group has-feedback ">
                                <label for="search_from">
                                    <strong>Search by Campaign : </strong>
                                </label>
                                <select class="form-control search-select" name="search_campaign_id">
                                    <option {{(isset($_GET['search_campaign_id']) && ($_GET['search_campaign_id']==0)) ? 'selected' : ''}} value="0">All</option>

                                    @if(!empty($all_campaign) && count($all_campaign) > 0)
                                    @foreach($all_campaign as $key => $list)
                                        <option {{(isset($_GET['search_campaign_id']) && ($_GET['search_campaign_id'] == $list->id)) ? 'selected' : ''}} value="{{$list->id}}">{{$list->campaign_name}}</option>
                                    @endforeach
                                    @endif
                                </select>
                            </div>
                        </div>

                        <div class="col-md-1" style="margin-top:25px;">
                            <div class="form-group">
                                <input type="submit" class="btn btn-primary btn-squared" value="Search">
                            </div>
                        </div>
                    </form>
                </div>

            </div>
        </div>
    </div>



    <div class="row">
        <div class="col-md-12">
            <div style="min-height:100px;overflow-x:auto;">
                <table class="table table-bordered table-hover" id="sample-table-1">
                    <thead>
	                    <tr>
	                        <th>#</th>
	                        <th>Campaign Name</th>
	                        <th>Participate Number</th>
	                        <th>Question Title</th>
	                        <th>Option 1</th>
	                        <th>Option 2</th>
	                        <th>Option 3</th>
	                        <th>Option 4</th>
	                        <th>Optional Option</th>
	                    </tr>
                    </thead>
                    <tbody>
                    @if (isset($all_content)&& count($all_content)>0)
                        <?php $page=isset($_GET['page'])? ($_GET['page']-1):0;?>
                        @foreach ($all_content as $key => $list)
                            <tr>
                                <td>{{($key+1+($perPage*$page))}}</td>
                                <td>{{ $list->campaign_name }}</td>
                                <td>{{ $list->answer_participate_mobile }}</td>
                                <td>{{ $list->question_title }}</td>
                                <td>{{ $list->question_answer_option_1 }}</td>
                                <td>{{ $list->question_answer_option_2 }}</td>
                                <td>{{ $list->question_answer_option_3 }}</td>
                                <td>{{ $list->question_answer_option_4 }}</td>
                                <td>{{ $list->question_answer_text_value }}</td>
                            </tr>
                        @endforeach
                    @else
                        <tr>
                            <td colspan="9">
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

        <!-- END PANEL FOR Album LIST -->
        {{--<div class="text-center">
            {!!$content_all->links()!!}
        </div>--}}



@endsection
@section('JScript')
    <script>
        $(function () {
            var site_url = $('.site_url').val();
        })
    </script>
@endsection