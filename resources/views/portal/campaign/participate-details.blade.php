@extends('portal.layout.master')
@section('content')
    <div class="common_background" style="padding: 10px;">
        <div class="details_common_background2">
            <div class="row" style="margin-bottom: 60px">


                <div class="card">

                    <div class="card-content" style="padding-bottom: 0px">
                        <h5 class="center-align">
                        	<!-- Participate Camapaign Answer  -->
                        	{{isset($campaign_info)? $campaign_info->campaign_name :''}}
                        </h5>

                        @if(!empty($all_content))
							@foreach($all_content as $key => $select_question)                          
	                            <div class="row" style="margin: 0 3px">
	                                <div class="input-field col s12">
	                                    <strong>Question <span class="symbol required" aria-required="true"></span> : {{isset($select_question)? $select_question->question_answer_title :''}} </strong>
	                                    <!-- <input type="hidden" name="question_answer_title" value="{{$select_question->question_answer_title}}"> -->
	                                </div>
	                            </div>

	                            <div class="row" style="margin: 0 3px">

	                                <strong>Answer :</strong>

	                                @if(isset($select_question) && !empty($select_question->question_answer_option_1))
	                                    <div class="col s12">

	                                        <p>
	                                          <!-- <input type="checkbox" id="question_answer_option_1"  name="question_answer_option_1" value="{{$select_question->question_answer_option_1}}" /> -->
	                                          <label for="question_answer_option_1" style="color: #000;">{{$select_question->question_answer_option_1}}</label>
	                                        </p>
	                                    </div>

	                                @endif


	                                @if(isset($select_question) && !empty($select_question->question_answer_option_2))
	                                    <div class="col s12">

	                                        <p>
	                                          <!-- <input type="checkbox" id="question_answer_option_2"  name="question_answer_option_2" value="{{$select_question->question_answer_option_2}}" /> -->
	                                          <label for="question_answer_option_2" style="color: #000;">{{$select_question->question_answer_option_2}}</label>
	                                        </p>
	                                    </div>

	                                @endif


	                                @if(isset($select_question) && !empty($select_question->question_answer_option_3))
	                                    <div class="col s12">

	                                        <p>
	                                          <!-- <input type="checkbox" id="question_answer_option_3"  name="question_answer_option_3" value="{{$select_question->question_answer_option_3}}" /> -->
	                                          <label for="question_answer_option_3" style="color: #000;">{{$select_question->question_answer_option_3}}</label>
	                                        </p>
	                                    </div>

	                                @endif


	                                @if(isset($select_question) && !empty($select_question->question_answer_option_4))
	                                    <div class="col s12">

	                                        <p>
	                                          <!-- <input type="checkbox" id="question_answer_option_4"  name="question_answer_option_4" value="{{$select_question->question_answer_option_4}}" /> -->
	                                          <label for="question_answer_option_4" style="color: #000;">{{$select_question->question_answer_option_4}}</label>
	                                        </p>
	                                    </div>

	                                @endif

	                                @if(isset($select_question) && !empty($select_question->question_answer_text_value))

		                                <div class="col s12">

		                                    <!-- <input type="text" name="question_option_new" placeholder="Optional Answer" value="{{$select_question->question_answer_text_value}}"> -->
		                                    <label for="question_answer_option_1" style="color: #000;">{{$select_question->question_answer_text_value}}</label>

		                                </div>

	                                @endif

	                            </div><br>


	                            <!-- <div class="row" style="margin: 0 3px">

	                                <div class="input-field col s12">

	                                    <input type="text" name="question_option_new" placeholder="Optional Answer" value="{{$select_question->question_answer_text_value}}">

	                                </div>

	                            </div> -->
	                        @endforeach
                        @endif

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