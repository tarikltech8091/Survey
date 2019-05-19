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


                @if(!empty($question_answer_option_1))

                    <div class="col-md-3" style="margin-top: 20px;">
                        <div class="report_view reprt_color_1 cursor dashborad_menus centered">

                            <p class="report_name"> 
                                <a href="#">Question Answer Option 1</a>
                            </p><br>

                            <p class="report_name"> 
                                <a href="#">{{$question_answer_option_1}}</a>
                            </p>
                        </div>
                    </div>

                @endif


                @if(!empty($question_answer_option_2))

                    <div class="col-md-3" style="margin-top: 20px;">
                        <div class="report_view reprt_color_1 cursor dashborad_menus centered">

                            <p class="report_name"> 
                                <a href="#">Question Answer Option 2</a>
                            </p><br>

                            <p class="report_name"> 
                                <a href="#">{{$question_answer_option_2}}</a>
                            </p>
                        </div>
                    </div>

                @endif


                @if(!empty($question_answer_option_3))

                    <div class="col-md-3" style="margin-top: 20px;">
                        <div class="report_view reprt_color_1 cursor dashborad_menus centered">

                            <p class="report_name"> 
                                <a href="#">Question Answer Option 3</a>
                            </p><br>

                            <p class="report_name"> 
                                <a href="#">{{$question_answer_option_3}}</a>
                            </p>
                        </div>
                    </div>

                @endif


                @if(!empty($question_answer_option_4))

                    <div class="col-md-3" style="margin-top: 20px;">
                        <div class="report_view reprt_color_1 cursor dashborad_menus centered">

                            <p class="report_name"> 
                                <a href="#">Question Answer Option 4</a>
                            </p><br>

                            <p class="report_name"> 
                                <a href="#">{{$question_answer_option_4}}</a>
                            </p>
                        </div>
                    </div>

                @endif



                @if(!empty($question_answer_text_value))

                    <div class="col-md-3" style="margin-top: 20px;">
                        <div class="report_view reprt_color_1 cursor dashborad_menus centered">

                            <p class="report_name"> 
                                <a href="#">Question Answer Text Option</a>
                            </p><br>

                            <p class="report_name"> 
                                <a href="#">{{$question_answer_text_value}}</a>
                            </p>
                        </div>
                    </div>

                @endif




            </div>
                

        </div>
    </div>



    <div class="row">
        <div class="col-md-12">
            <div style="min-height:100px;overflow-x:auto;">
                <table class="table table-bordered table-hover" id="sample-table-1">
                	<h4 class="text-center">Total Participate {{isset($total_content)? $total_content:''}}</h4>
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