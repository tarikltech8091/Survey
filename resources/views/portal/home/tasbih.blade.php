@extends('portal.layout.master')
@section('content')
    <div class="common_background center-align">

        <div class="doante">

            <div class="row center-align">
            	<br><br><br>

                <div class="col s12">
                    <h5>তাসবীহ</h5>
                </div>

                    <div class="input-field col s12">
                    <div class="col s2"></div>
                    <div class="col s8">
                        <button class ="btn waves-effect waves-teal common_btn"><span id="displayCount" class="total_count">{{isset($number_of_count)?$number_of_count:0}}</span></button>

                	</div><br>

                    <div class="col s2"></div>
                    </div>

                    <div class="col s12" style="margin-top: 15px;">
                    	<div class="col s2">
                    	</div>
                    	<div class="col s4">
	                        <input class = "btn waves-teal common_btn" type="button" value="Count" id="countButton" />
	                    </div>
	                    <div class="col s4">
                        	<input class = "btn waves-teal common_btn" type="button" value="Reset" id="reset" />
                        </div>
                    	<div class="col s2"></div>

                    </div>

            </div>

        </div>

    </div>
@endsection
@section('JScript')
    <script type="text/javascript">
        $(document).ready(function(){

        	var site_url = $('.site_url').val();
            var count = <?php echo isset($number_of_count)?$number_of_count:0; ?>;

	      	var button = document.getElementById("countButton");
	      	var display = document.getElementById("displayCount");
	      	var reset = document.getElementById("reset");

	      	button.onclick = function(){
		        count++;
                // display.innerHTML = count;
                 var request_url = site_url+'/tasbih/'+count;
                 jQuery.ajax({
                    url: request_url,
                    type: 'get',
                    success:function(data){
                        jQuery('.total_count').html(data);
                    }
                });

		    }

	      	reset.onclick = function(){
		        count= 0;
		        // display.innerHTML = count;

                var request_url = site_url+'/tasbih/'+count;
                 jQuery.ajax({
                    url: request_url,
                    type: 'get',
                    success:function(data){
                        jQuery('.total_count').html(data);
                    }
                });

		    }



        });

    </script>
@endsection