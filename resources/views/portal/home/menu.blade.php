@extends('portal.layout.master')
@section('content')
    <div class="common_background operator_base_background">
    	<div class="new-common">

		  	<div class="row" style="padding-bottom: 0px; margin-bottom: 0px; line-height: 1;">

	    		<div class="col s12 m12" style="border-bottom: 0;  padding-top: 5px;">

	    			<div class="col s3 center-align">
	    				 <a  href="{{ url('/namaj/time') }}" target="_self" >
		                    <img src="{{ asset('portal/img/islamic/Islamic_Button/namaj-timing.png') }}" style="margin-top: 5px" height="60px" width="60px">
		                </a><br>
	                	<span class="menu-text-color">নামাযের সময়</span>
	    			</div>

	    			<div class="col s3 center-align">
	    				 <a  href="{{ url('/namaj/shikkha') }}" target="_self" >
		                    <img src="{{ asset('portal/img/islamic/Islamic_Button/namaz-leaning.png') }}" style="margin-top: 5px" height="60px" width="60px">
		                </a><br>
	                	<span class="menu-text-color">নামায শিক্ষা</span>
	    			</div>

	    			<div class="col s3 center-align">
	    				 <a  href="{{ url('/islamic/jibon') }}" target="_self" >
		                    <img src="{{ asset('portal/img/islamic/Islamic_Button/islamic-lifestyle.png') }}"  style="margin-top: 5px" height="60px" width="60px" >
		                </a><br>
	                	<span class="menu-text-color">ইসলামিক জীবন</span>
	    			</div>

	    			<div class="col s3 center-align">
	    				 <a  href="{{ url('/hadis') }}" target="_self" >
		                    <img src="{{ asset('portal/img/islamic/Islamic_Button/hadith.png') }}" style="margin-top: 5px" height="60px" width="60px">
		                </a><br>
	                	<span class="menu-text-color">হাদিস</span>
	    			</div>


	    		</div>

	    		<div class="col s12 m12" style="border-bottom: 0;">

	    			<div class="col s3 center-align">
	    				 <a  href="{{ url('/ayat/dua') }}" target="_self" >
		                    <img src="{{ asset('portal/img/islamic/Islamic_Button/aayat-&-doya.png') }}"   style="margin-top: 5px" height="60px" width="60px">
		                </a><br>
	                	<span class="menu-text-color">আয়াত ও দোয়া</span>
	    			</div>

	    			<div class="col s3 center-align">
	    				 <a  href="{{ url('/mosque') }}" target="_self" >
		                    <img src="{{ asset('portal/img/islamic/Islamic_Button/mosque.png') }}"   style="margin-top: 5px" height="60px" width="60px" >
		                </a><br>
	                	<span class="menu-text-color">মসজিদ</span>
	    			</div>


	    			<div class="col s3 center-align">
	    				 <a  href="{{ url('/allah/99/name') }}" target="_self" >
		                    <img src="{{ asset('portal/img/islamic/Islamic_Button/name.png') }}" style="margin-top: 5px" height="60px" width="60px">
		                </a><br>
	                	<span class="menu-text-color">আল্লাহর ৯৯ নাম</span>
	    			</div>

	    			<div class="col s3 center-align">
	    				 <a  href="{{ url('/islamic/occasion') }}" target="_self" >
		                    <img src="{{ asset('portal/img/islamic/Islamic_Button/islamic-occasion.png') }}" style="margin-top: 5px" height="60px" width="60px">
		                </a><br>
	                	<span class="menu-text-color">ইসলামিক উপলক্ষ</span>
	    			</div>


	    		</div>


	    		<div class="col s12 m12" style="border-bottom: 0;">

	    			<div class="col s3 center-align">
	    				 <a  href="{{ url('/waz') }}" target="_self" >
		                    <img src="{{ asset('portal/img/islamic/Islamic_Button/wazz.png') }}" style="margin-top: 5px" height="60px" width="60px">
		                </a><br>
	                	<span class="menu-text-color">ওয়াজ</span>
	    			</div>


	    			
	    			<div class="col s3 center-align">
	    				 <a  href="{{ url('learn/quran/surah') }}" target="_self" >
		                    <img src="{{ asset('portal/img/islamic/Islamic_Button/quran-sharif.png') }}" style="margin-top: 5px" height="60px" width="60px">
		                </a><br>
	                	<span class="menu-text-color">কুরআন শরীফ</span>
	    			</div>


	    			<div class="col s3 center-align">
	    				 <a  href="{{ url('/live/streaming') }}" target="_self" >
		                    <img src="{{ asset('portal/img/islamic/Islamic_Button/live-streaming.png') }}" style="margin-top: 5px" height="60px" width="60px">
		                </a><br>
	                	<span class="menu-text-color">লাইভ</span>
	    			</div>


	    			<div class="col s3 center-align">
	    				 <a  href="{{ url('/learn/quran') }}" target="_self" >
		                    <img src="{{ asset('portal/img/islamic/Islamic_Button/learning-quran.png') }}" style="margin-top: 5px" height="60px" width="60px">
		                </a><br>
	                	<span class="menu-text-color">কুরআন শিক্ষা</span>
	    			</div>


	    		</div>



	    		<div class="col s12 m12" style="border-bottom: 0;">


	    			<div class="col s3 center-align">
	    				 <a  href="{{ url('/video') }}" target="_self" >
		                    <img src="{{ asset('portal/img/islamic/Islamic_Button/video.png') }}" style="margin-top: 5px" height="60px" width="60px" >
		                </a><br>
	                	<span class="menu-text-color">ভিডিও</span>
	    			</div>

	    			<div class="col s3 center-align">
	    				 <a  href="{{ url('/calendar') }}" target="_self" >
		                    <img src="{{ asset('portal/img/islamic/Islamic_Button/calendar.png') }}" style="margin-top: 5px" height="60px" width="60px">
		                </a><br>
	                	<span class="menu-text-color">ক্যালেন্ডার</span>
	    			</div>



	    			<div class="col s3 center-align">
	    				 <a  href="{{ url('/jakat') }}" target="_self" >
		                    <img src="{{ asset('portal/img/islamic/Islamic_Button/zakat.png') }}" style="margin-top: 5px" height="60px" width="60px">
		                </a><br>
	                	<span class="menu-text-color">যাকাত</span>
	    			</div>


	    			<div class="col s3 center-align">
                        <a href="{{ url('learn/quran/common/surah') }}" target="_self" >
                        	<img src="{{ asset('portal/img/islamic/Islamic_Button/Choto-Sura.png') }}" style="margin-top: 5px" height="60px" width="60px" >
                        </a><br>
	                	<span class="menu-text-color">ছোট সূরা</span>
	    			</div>
	    			
	    		</div>



	    		<div class="col s12 m12" style="border-bottom: 0;">

	    			<div class="col s3 center-align">
	    				 <a  href="{{ url('/tasbih') }}" target="_self" >
		                    <img src="{{ asset('portal/img/islamic/Islamic_Button/tashbee.png') }}" style="margin-top: 5px" height="60px" width="60px">
		                </a><br>
	                	<span class="menu-text-color">তাসবীহ</span>
	    			</div>

	    			<div class="col s3 center-align">
	    				 <a  href="{{ url('/hamd/naat') }}" target="_self" >
		                    <img src="{{ asset('portal/img/islamic/Islamic_Button/ham-nath.png') }}" style="margin-top: 5px" height="60px" width="60px">
		                </a><br>
	                	<span class="menu-text-color">হামদ নাত</span>
	    			</div>

	    			<div class="col s3 center-align">
                        <a href="{{ url('islamic/inspiration') }}" target="_self" >
                        	<img src="{{ asset('portal/img/islamic/Islamic_Button/Daily-Inspiration.png') }}" style="margin-top: 5px" height="60px" width="60px" >
                        </a><br>
	                	<span class="menu-text-color">দৈনিক অনুপ্রেরণা</span>
	    			</div>


	    			<div class="col s3 center-align">
                        <a href="{{ url('/privacy-policy') }}" target="_self" >
                        	<img src="{{ asset('portal/img/islamic/Islamic_Button/privacy.png') }}" style="margin-top: 5px" height="60px" width="60px" >
                        </a><br>
	                	<span class="menu-text-color">প্রাইভেসী পলিসি</span>
	    			</div>


	    		</div>


	    		<div class="col s12 m12" style="border-bottom: 0; padding-bottom: 35px;">

	    			<div class="col s3 center-align">
	                        <a href="{{ url('/najat/subscription') }}" target="_self" >
	                        	<img src="{{ asset('portal/img/islamic/Islamic_Button/settings.png') }}" style="margin-top: 5px" height="60px" width="60px" >
	                        </a><br>
	                	<span class="menu-text-color">সাবক্রিপশন</span>
	    			</div>

	    		</div>


			           
			</div><br>


		</div>

    </div>
@endsection
@section('JScript')
    <script type="text/javascript">


        $(function(){ $('.carousel.carousel-slider').carousel({full_width: true}); });


  		


    </script>
@endsection