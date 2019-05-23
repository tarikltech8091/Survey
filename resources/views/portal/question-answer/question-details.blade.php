@extends('portal.layout.master')
@section('content')
    <div class="common_background" style="padding: 10px;">
        <div class="details_common_background2">
            <div class="row" style="margin-bottom: 60px">

                <div class="col s12" style="color: red;">

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

                </div>

                <div class="card">
                    <style>

                            ::placeholder {
                                color: #655a5a;
                            }
                            .submit_button_color{
                                color: #000000; 
                            }

                    </style>

                    <div class="card-content" style="padding-bottom: 0px">
                            <h5 class="center-align">Question Answer ({{isset($select_question)? $select_question->question_position :''}} / {{isset($total_question)? $total_question :'0'}})</h5>
                        <div>
     

                            <form role="form" class="form-horizontal" action="{{ url('/participate/answer/save/'.$campaign_participate_mobile.'/'.$campaign_id) }}" id="question_answer" method="post" role="form" enctype="multipart/form-data">

                                <input type="hidden" name="_token" value="{{csrf_token()}}">

                                <input type="hidden" class="form-control" name="answer_campaign_id" value="{{$campaign_id}}">
                                <input type="hidden" class="form-control" name="answer_question_id" value="{{isset($question_id)?$question_id:''}}">
                                <input type="hidden" class="form-control" name="answer_question_position" value="{{isset($question_position)?$question_position:''}}">
                                <input type="hidden" class="form-control" name="campaign_participate_mobile" value="{{isset($campaign_participate_mobile)?$campaign_participate_mobile:''}}">
                                <input type="hidden" class="form-control" name="participate_prize_amount" value="{{isset($select_campaign->participate_prize_amount)?$select_campaign->participate_prize_amount:''}}">
                                   
                                    <div class="row" style="margin: 0 3px">
                                        <div class="input-field col s12">
                                            <strong>Question {{isset($select_question)? $select_question->question_position :''}}<span class="symbol required" aria-required="true"></span> : {{isset($select_question)? $select_question->question_title :''}} </strong>
                                            <input type="hidden" name="question_answer_title" value="{{$select_question->question_title}}">
                                        </div>
                                    </div>

                                    <div class="row" style="margin: 0 3px">


                                        @if(isset($select_question) && !empty($select_question->question_option_1))
                                            <div class="col s12">

                                                <p>
                                                  <input type="checkbox" id="question_option_1"  name="question_option_1" value="{{$select_question->question_option_1}}" />
                                                  <label for="question_option_1" style="color: #000;">{{$select_question->question_option_1}}</label>
                                                </p>
                                            </div>

                                        @endif


                                        @if(isset($select_question) && !empty($select_question->question_option_2))
                                            <div class="col s12">

                                                <p>
                                                  <input type="checkbox" id="question_option_2"  name="question_option_2" value="{{$select_question->question_option_2}}" />
                                                  <label for="question_option_2" style="color: #000;">{{$select_question->question_option_2}}</label>
                                                </p>
                                            </div>

                                        @endif


                                        @if(isset($select_question) && !empty($select_question->question_option_3))
                                            <div class="col s12">

                                                <p>
                                                  <input type="checkbox" id="question_option_3"  name="question_option_3" value="{{$select_question->question_option_3}}" />
                                                  <label for="question_option_3" style="color: #000;">{{$select_question->question_option_3}}</label>
                                                </p>
                                            </div>

                                        @endif


                                        @if(isset($select_question) && !empty($select_question->question_option_4))
                                            <div class="col s12">

                                                <p>
                                                  <input type="checkbox" id="question_option_4"  name="question_option_4" value="{{$select_question->question_option_4}}" />
                                                  <label for="question_option_4" style="color: #000;">{{$select_question->question_option_4}}</label>
                                                </p>
                                            </div>

                                        @endif

                                    </div><br>


                                    <div class="row" style="margin: 0 3px">

                                        <strong> Optional Question Answer: </strong>

                                        <div class="input-field col s12">

                                            <input type="text" name="question_option_new" placeholder="Optional Answer">
                                        </div>
                                    </div>



                                    <div class="row">
                                        <div class="col s4">
                                        </div>
                                        <div class="col s4">
                                            <input type="submit" class="waves-light btn" value="Submit">
                                        </div>
                                        <div class="col s4">
                                        </div>
                                    </div>





                            </form>

                        </div>

                    </div>

                </div>
            </div>
        </div>
    </div>
@endsection
@section('JScript')
    <script type="text/javascript">
        $(document).ready(function(){
            var site_url = $('.site_url').val();
        });
        
    </script>
@endsection