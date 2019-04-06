@extends('portal.layout.master')
@section('content')
    <div class="common_background" style="height: 95%">
    	<div class="new-common" style="background: #cccccc;">
		  	<div class="row mb">

		        <div class="col s12 m12">
		          <div class="card mb mt">
		            <div class="card-content white-text home-top" style="background: url({{isset($image)?$image :''}});  background-position: center; background-repeat: no-repeat; background-size: cover;">
			        	<br>
			        	<div class="col s12 m12">
							<div class="col s4"></div>
							<div class="col s4 center-align">{{isset($time)?$time:''}} <br>{{isset($wakt)?$wakt:''}}</div>
							<div class="col s4"></div>
						</div><br><br><br>
			        	<div class="col s12 m12">
							<div class="col s4"></div>
							<div class="col s4"></div>
							<div class="col s4 left-align" style="font-size: 15px;">
								<a href="{{url('/namaj/time')}}" style="color: #ffffff;">
									<!-- <i class="material-icons" style="font-size: 14px;">access_time</i> -->
									<div class="col s2 center-align">
										<img src="{{asset('portal/img/See-More.png')}}" style="height: 20px; width:20px;"> 
									</div>
									<div class="col s10 center-align">
										<span>View More</span>
									</div>
								</a>
							</div>
						</div>
		            </div>

		          </div>
		        </div>
		    </div>

			@if(\Session::has('errormessage'))
				{{--<p class="red-text center-align">
					{{ Session::get('errormessage') }}
				</p>--}}
				<script type="text/javascript">
				var message = '<?php echo \Session::get('errormessage') ?>';
				Materialize.toast(
				message,
				5000,
				'red rounded'
				);
				</script>
			@endif

		  	<div class="row footer home-list-area">
		  		
		  		<div class="carousel carousel-slider">
				    <div class="carousel-fixed-item center middle-indicator" >

						<div class="left">
					      <a href="Previo" class="movePrevCarousel middle-indicator-text waves-effect waves-light content-indicator"><i class="material-icons left  middle-indicator-text">chevron_left</i></a>
					     </div>
					     
					    <div class="right">
					     <a href="Siguiente" class=" moveNextCarousel middle-indicator-text waves-effect waves-light content-indicator"><i class="material-icons right middle-indicator-text">chevron_right</i></a>
					    </div>

					</div>

				    <a class="carousel-item" href="#one!"> 
				    	
		                <table class="home-slider">

				    		<tr>

				    			<td class="center-align" style="padding-top: 10px;">
				    				 <a  href="{{ url('learn/quran/surah') }}" target="_self" >
					                    <img src="{{ asset('portal/img/islamic/Islamic_Button/quran-sharif.png') }}" height="45px" width="45px">
					                </a><br>
				                	<span>কুরআন শরীফ</span>
				    			</td>

				    			<td class="center-align" style="padding-top: 10px;">
				    				 <a  href="{{ url('/learn/quran') }}" target="_self" >
					                    <img src="{{ asset('portal/img/islamic/Islamic_Button/learning-quran.png') }}" height="45px" width="45px">
					                </a><br>
				                	<span>কুরআন শিক্ষা</span>
				    			</td>

				    			<td class="center-align" style="padding-top: 10px;">
				    				 <a  href="{{ url('/namaj/time') }}" target="_self" >
					                    <img src="{{ asset('portal/img/islamic/Islamic_Button/namaj-timing.png') }}" height="45px" width="45px">
					                </a><br>
				                	<span>নামাযের সময়</span>
				    			</td>


				    			<td class="center-align" style="padding-top: 10px;">
				    				 <a  href="{{ url('/namaj/shikkha') }}" target="_self" >
					                    <img src="{{ asset('portal/img/islamic/Islamic_Button/namaz-leaning.png') }}" height="45px" width="45px">
					                </a><br>
				                	<span>নামায শিক্ষা</span>
				    			</td>


				    		</tr>

				    		<tr>

				    			
				    			<td class="center-align">
				    				 <a  href="{{ url('learn/quran/common/surah') }}" target="_self" >
					                    <img src="{{ asset('portal/img/islamic/Islamic_Button/Choto-Sura.png') }}" height="45px" width="45px">
					                </a><br>
				                	<span>ছোট সূরা</span>
				    			</td>


				    			<td class="center-align">
				    				 <a  href="{{ url('/mosque') }}" target="_self" >
					                    <img src="{{ asset('portal/img/islamic/Islamic_Button/mosque.png') }}" height="45px" width="45px" >
					                </a><br>
				                	<span>মসজিদ</span>
				    			</td>


				    			<td class="center-align">
				    				 <a  href="{{ url('/jakat') }}" target="_self" >
					                    <img src="{{ asset('portal/img/islamic/Islamic_Button/zakat.png') }}" height="45px" width="45px">
					                </a><br>
				                	<span>যাকাত</span>
				    			</td>


				    			<td class="center-align">
				    				 <a  href="{{ url('/islamic/occasion') }}" target="_self" >
					                    <img src="{{ asset('portal/img/islamic/Islamic_Button/islamic-occasion.png') }}" height="45px" width="45px">
					                </a><br>
				                	<span>ইসলামিক উপলক্ষ</span>
				    			</td>


				    		</tr>


				    		<tr>

				    			<td class="center-align">
				    				 <a  href="{{ url('/video') }}" target="_self" >
					                    <img src="{{ asset('portal/img/islamic/Islamic_Button/video.png') }}" height="45px" width="45px">
					                </a><br>
				                	<span>ভিডিও</span>
				    			</td>


				    			<td class="center-align">
				    				 <a  href="{{ url('/allah/99/name') }}" target="_self" >
					                    <img src="{{ asset('portal/img/islamic/Islamic_Button/name.png') }}" height="45px" width="45px">
					                </a><br>
				                	<span>আল্লাহর ৯৯ নাম</span>
				    			</td>

				    			<td class="center-align">
				    				 <a  href="{{ url('/live/streaming') }}" target="_self" >
					                    <img src="{{ asset('portal/img/islamic/Islamic_Button/live-streaming.png') }}" height="45px" width="45px">
					                </a><br>
				                	<span>লাইভ</span>
				    			</td>




				    			<td class="center-align">
				    				 <a  href="{{ url('/ayat/dua') }}" target="_self" >
					                    <img src="{{ asset('portal/img/islamic/Islamic_Button/aayat-&-doya.png') }}" height="45px" width="45px">
					                </a><br>
				                	<span>আয়াত ও দোয়া</span>
				    			</td>


				    		</tr>

				    	</table>

				    </a>
				    <a class="carousel-item" href="#two!">
				    	
				    	<table class="home-slider">
				    		<tr>

				    			<td class="center-align" style="padding-top: 10px;">
				    				 <a  href="{{ url('/hadis') }}" target="_self" >
					                    <img src="{{ asset('portal/img/islamic/Islamic_Button/hadith.png') }}" height="45px" width="45px">
					                </a><br>
				                	<span>হাদিস</span>
				    			</td>


								<td class="center-align" style="padding-top: 10px;">
									<a  href="{{ url('/tasbih') }}" target="_self" >
										<img src="{{ asset('portal/img/islamic/Islamic_Button/tashbee.png') }}" height="45px" width="45px">
									</a><br>
									<span>তাসবীহ</span>
								</td>


				    			<td class="center-align" style="padding-top: 10px;">
				    				 <a  href="{{ url('/waz') }}" target="_self" >
					                    <img src="{{ asset('portal/img/islamic/Islamic_Button/wazz.png') }}" height="45px" width="45px">
					                </a><br>
				                	<span>ওয়াজ</span>
				    			</td>




				    		</tr>

				    		<tr>

				    			<td class="center-align">
				    				 <a  href="{{ url('/hamd/naat') }}" target="_self" >
					                    <img src="{{ asset('portal/img/islamic/Islamic_Button/ham-nath.png') }}" height="45px" width="45px">
					                </a><br>
				                	<span>হামদ নাত</span>
				    			</td>

				    			<td class="center-align">
				    				 <a  href="{{ url('islamic/inspiration') }}" target="_self" >
					                    <img src="{{ asset('portal/img/islamic/Islamic_Button/Daily-Inspiration.png') }}" height="45px" width="45px">
					                </a><br>
				                	<span>দৈনিক অনুপ্রেরণা</span>
				    			</td>


								<td class="center-align">
									<a  href="{{ url('/subscription') }}" target="_self" >
										<img src="{{ asset('portal/img/islamic/Islamic_Button/settings.png') }}" height="45px" width="45px">
									</a><br>
									<span>সাবক্রিপশন</span>
								</td>



							</tr>


				    		<tr>

				    			<td class="center-align">
				    				 <a  href="{{ url('/islamic/jibon') }}" target="_self" >
					                    <img src="{{ asset('portal/img/islamic/Islamic_Button/islamic-lifestyle.png') }}"  height="45px" width="45px" >
					                </a><br>
				                	<span>ইসলামিক জীবন</span>
				    			</td>



				    			<td class="center-align">
				    				 <a  href="{{ url('/calendar') }}" target="_self" >
					                    <img src="{{ asset('portal/img/islamic/Islamic_Button/calendar.png') }}" height="45px" width="45px">
					                </a><br>
				                	<span>ক্যালেন্ডার</span>
				    			</td>

								<td class="center-align">
									<a  href="{{ url('/privacy-policy') }}" target="_self" >
										<img src="{{ asset('portal/img/islamic/Islamic_Button/privacy.png') }}" height="45px" width="45px">
									</a><br>
									<span>প্রাইভেসী পলিসি</span>
								</td>

				    		</tr>

				    	</table>
				    </a>
				</div>

			    <!-- <div class="col s12 m12">

					<ul id="tabs-swipe-demo" class="tabs tabs-fixed-width" style="padding: 0px; margin: 0px;" >
			            <li class="tab home-slider" style="padding-left: 0px;">

			                <table class="home-slider">

					    		<tr>

					    			<td class="center-align" style="padding-top: 10px;">
					    				 <a  href="{{ url('learn/quran/surah') }}" target="_self" >
						                    <img src="{{ asset('portal/img/islamic/Islamic_Button/quran-sharif.png') }}" height="45px" width="45px">
						                </a>
					                	<span>কুরআন শরীফ</span>
					    			</td>

					    			<td class="center-align" style="padding-top: 10px;">
					    				 <a  href="{{ url('/learn/quran') }}" target="_self" >
						                    <img src="{{ asset('portal/img/islamic/Islamic_Button/learning-quran.png') }}" height="45px" width="45px">
						                </a>
					                	<span>কুরআন শিক্ষা</span>
					    			</td>

					    			<td class="center-align" style="padding-top: 10px;">
					    				 <a  href="{{ url('/namaj/time') }}" target="_self" >
						                    <img src="{{ asset('portal/img/islamic/Islamic_Button/namaj-timing.png') }}" height="45px" width="45px">
						                </a>
					                	<span>নামাযের সময়</span>
					    			</td>


					    			<td class="center-align" style="padding-top: 10px;">
					    				 <a  href="{{ url('/namaj/shikkha') }}" target="_self" >
						                    <img src="{{ asset('portal/img/islamic/Islamic_Button/namaz-leaning.png') }}" height="45px" width="45px">
						                </a>
					                	<span>নামায শিক্ষা</span>
					    			</td>


					    		</tr>

					    		<tr>

					    			
					    			<td class="center-align">
					    				 <a  href="{{ url('learn/quran/common/surah') }}" target="_self" >
						                    <img src="{{ asset('portal/img/islamic/Islamic_Button/Choto-Sura.png') }}" height="45px" width="45px">
						                </a>
					                	<span>ছোট সূরা</span>
					    			</td>


					    			<td class="center-align">
					    				 <a  href="{{ url('/mosque') }}" target="_self" >
						                    <img src="{{ asset('portal/img/islamic/Islamic_Button/mosque.png') }}" height="45px" width="45px" >
						                </a>
					                	<span>মসজিদ</span>
					    			</td>


					    			<td class="center-align">
					    				 <a  href="{{ url('/jakat') }}" target="_self" >
						                    <img src="{{ asset('portal/img/islamic/Islamic_Button/zakat.png') }}" height="45px" width="45px">
						                </a>
					                	<span>যাকাত</span>
					    			</td>


					    			<td class="center-align">
					    				 <a  href="{{ url('/islamic/occasion') }}" target="_self" >
						                    <img src="{{ asset('portal/img/islamic/Islamic_Button/islamic-occasion.png') }}" height="45px" width="45px">
						                </a>
					                	<span>ইসলামিক উপলক্ষ</span>
					    			</td>


					    		</tr>


					    		<tr>

					    			<td class="center-align">
					    				 <a  href="{{ url('/video') }}" target="_self" >
						                    <img src="{{ asset('portal/img/islamic/Islamic_Button/video.png') }}" height="45px" width="45px">
						                </a>
					                	<span>ভিডিও</span>
					    			</td>


					    			<td class="center-align">
					    				 <a  href="{{ url('/allah/99/name') }}" target="_self" >
						                    <img src="{{ asset('portal/img/islamic/Islamic_Button/name.png') }}" height="45px" width="45px">
						                </a>
					                	<span>আল্লাহর ৯৯ নাম</span>
					    			</td>

					    			<td class="center-align">
					    				 <a  href="{{ url('/live/streaming') }}" target="_self" >
						                    <img src="{{ asset('portal/img/islamic/Islamic_Button/live-streaming.png') }}" height="45px" width="45px">
						                </a>
					                	<span>লাইভ</span>
					    			</td>




					    			<td class="center-align">
					    				 <a  href="{{ url('/ayat/dua') }}" target="_self" >
						                    <img src="{{ asset('portal/img/islamic/Islamic_Button/aayat-&-doya.png') }}" height="45px" width="45px">
						                </a>
					                	<span>আয়াত ও দোয়া</span>
					    			</td>


					    		</tr>

					    	</table>
			            </li>

			            <li class="tab home-slider" style="padding-left: 0px;">


					    	<table class="home-slider">
					    		<tr>

					    			<td class="center-align" style="padding-top: 10px;">
					    				 <a  href="{{ url('/hadis') }}" target="_self" >
						                    <img src="{{ asset('portal/img/islamic/Islamic_Button/hadith.png') }}" height="45px" width="45px">
						                </a>
					                	<span>হাদিস</span>
					    			</td>


									<td class="center-align" style="padding-top: 10px;">
										<a  href="{{ url('/tasbih') }}" target="_self" >
											<img src="{{ asset('portal/img/islamic/Islamic_Button/tashbee.png') }}" height="45px" width="45px">
										</a>
										<span>তাসবীহ</span>
									</td>


					    			<td class="center-align" style="padding-top: 10px;">
					    				 <a  href="{{ url('/waz') }}" target="_self" >
						                    <img src="{{ asset('portal/img/islamic/Islamic_Button/wazz.png') }}" height="45px" width="45px">
						                </a>
					                	<span>ওয়াজ</span>
					    			</td>




					    		</tr>

					    		<tr>

					    			<td class="center-align">
					    				 <a  href="{{ url('/hamd/naat') }}" target="_self" >
						                    <img src="{{ asset('portal/img/islamic/Islamic_Button/ham-nath.png') }}" height="45px" width="45px">
						                </a>
					                	<span>হামদ নাত</span>
					    			</td>

					    			<td class="center-align">
					    				 <a  href="{{ url('islamic/inspiration') }}" target="_self" >
						                    <img src="{{ asset('portal/img/islamic/Islamic_Button/Daily-Inspiration.png') }}" height="45px" width="45px">
						                </a>
					                	<span>দৈনিক অনুপ্রেরণা</span>
					    			</td>


									<td class="center-align">
										<a  href="{{ url('/subscription') }}" target="_self" >
											<img src="{{ asset('portal/img/islamic/Islamic_Button/settings.png') }}" height="45px" width="45px">
										</a>
										<span>সাবক্রিপশন</span>
									</td>



								</tr>


					    		<tr>

					    			<td class="center-align">
					    				 <a  href="{{ url('/islamic/jibon') }}" target="_self" >
						                    <img src="{{ asset('portal/img/islamic/Islamic_Button/islamic-lifestyle.png') }}"  height="45px" width="45px" >
						                </a>
					                	<span>ইসলামিক জীবন</span>
					    			</td>



					    			<td class="center-align">
					    				 <a  href="{{ url('/calendar') }}" target="_self" >
						                    <img src="{{ asset('portal/img/islamic/Islamic_Button/calendar.png') }}" height="45px" width="45px">
						                </a>
					                	<span>ক্যালেন্ডার</span>
					    			</td>

									<td class="center-align">
										<a  href="{{ url('/privacy-policy') }}" target="_self" >
											<img src="{{ asset('portal/img/islamic/Islamic_Button/privacy.png') }}" height="45px" width="45px">
										</a>
										<span>প্রাইভেসী পলিসি</span>
									</td>

					    		</tr>

					    	</table>
			            </li>
            			<li class="indicator" style="z-index:999;"></li>

			        </ul>
			        <a href="{{url('main/menu')}}" class="right"><div class="center-align" style="padding: 5px; color: #222222;">See more >></div></a>

			           
			    </div> -->

			</div>


     

			<div class="row home-category">
				@if(!empty($hadith_contents))
					<div class="col s12 m12 l12">
						<div class="card">

							<div class="home-category-title">
								<div class="card-action">
									<table class="rml">
										<tr class="left-align">
											<td class="left pd-0">
												<img src="{{asset('portal/img/islamic/Islamic_Button/hadith.png')}}" height="30px" width="30px">
											</td>
											<td class="left pd-0">
												<span>&nbsp হাদিস</span>
											</td>
										</tr>
									</table>
								</div>
							</div>

							<a href="{{url('hadis')}}" class="">
								<div class="card-image">

									<img src="{{$CommonPath.'/'.$hadith_contents['hadith_attachment'] }}"
										 style="width: 100%; height: auto">
								</div>
							</a>

							<div class="card-action">
								<a href="{{url('hadis')}}" class="">
									<img src="{{asset('/portal/img/islamic/inner_button/read.png')}}" style="padding-top: 5px;" height="18px" width="18px">
									<span class="title" style="color: green;">Read</span>
								</a>
								<a href="{{url('hadis')}}" class="right">
									<img src="{{asset('/portal/img/islamic/inner_button/share.png')}}" style="padding-top: 3px;"
										 height="15px" width="15px">
									<span class="title" style="color: red;">Share</span>
								</a>
							</div>
						</div>
					</div>
			    @endif
				@if(!empty($allah_name))
					<div class="col s12 m12">
						<div class="card">

							<div class="home-category-title">
								<div class="card-action">
									<table class="rml">
										<tr class="left-align">
											<td class="left pd-0">
												<img src="{{asset('portal/img/islamic/Islamic_Button/name.png')}}" height="30px" width="30px">
											</td>
											<td class="left pd-0">
												<span>&nbsp আল্লাহর ৯৯ নাম</span>
											</td>
										</tr>
									</table>
								</div>
							</div>

							<a href="{{url('/allah/99/name')}}" class="">
								<div class="card-image">
									<img src="{{ $allah_name['image'] }}"
										 style="width: 100%; height: auto; border-radius: 5px;">
								</div>
							</a>
							<div class="card-action">
								<a href="{{url('/allah/99/name')}}" class="">
									<img src="{{asset('/portal/img/islamic/inner_button/view-more-colorful.png')}}" style="padding-top: 5px;"
										 height="15px" width="15px">
									<span class="title" style="color: #9900ff;">View More</span>
								</a>
								<a href="{{url('/allah/99/name')}}" class="right">
									<img src="{{asset('/portal/img/islamic/inner_button/share.png')}}" style="padding-top: 3px;" height="15px" width="15px" >
									<span class="title" style="color: red;">Share</span>
								</a>
							</div>
						</div>
					</div>
			    @endif
				@if(!empty($auahdua_contents))
					<div class="col s12 m12 l12">
						<div class="card">

							<div class="home-category-title">
								<div class="card-action">
									<table class="rml">
										<tr class="left-align">
											<td class="left pd-0">
												<img src="{{asset('portal/img/islamic/Islamic_Button/aayat-&-doya.png')}}" height="30px" width="30px">
											</td>
											<td class="left pd-0">
												<span>&nbsp দোয়া</span>
											</td>
										</tr>
									</table>
								</div>
							</div>

							<a href="{{url('/ayat/dua')}}" class="">
								<div class="card-image">
									<img src="{{ $CommonPath.'/'.$auahdua_contents['ayah_dua_attachment'] }} "style="width: 100%; height: auto">
								</div>
							</a>
							<div class="card-action">
								<a href="{{url('/ayat/dua')}}" class="">
									<img src="{{asset('/portal/img/islamic/inner_button/read.png')}}" style="padding-top: 5px;" height="18px" width="18px">
									<span class="title" style="color: green;">Read</span>
								</a>
								<a href="{{url('/ayat/dua')}}" class="right">
									<img src="{{asset('/portal/img/islamic/inner_button/share.png')}}" style="padding-top: 3px;" height="15px" width="15px">
									<span class="title" style="color: red;">Share</span>
								</a>
							</div>
						</div>
					</div>
			    @endif

				@if(!empty($islamicjibon_contents))
					<div class="col s12 m12 l12">
						<div class="card">

							<div class="home-category-title">
								<div class="card-action">
									<table class="rml">
										<tr class="left-align">
											<td class="left pd-0">
												<img src="{{asset('portal/img/islamic/Islamic_Button/islamic-lifestyle.png')}}" height="30px" width="30px">
											</td>
											<td class="left pd-0">
												<span>&nbsp ইসলামিক জীবন</span>
											</td>
										</tr>
									</table>
								</div>
							</div>

							<a href="{{url('islamic/jibon')}}" class="">
								<div class="card-image">
									<img src="{{ $CommonPath.'/'.$islamicjibon_contents['content_attachment'] }}" style="width: 100%; height: auto">
								</div>
							</a>
							<div class="card-action">
								<a href="{{url('islamic/jibon')}}" class="">
									<img src="{{asset('/portal/img/islamic/inner_button/view-more-colorful.png')}}" style="padding-top: 5px;" height="15px" width="15px">
									<span class="title" style="color: #9900ff;">View More</span>
								</a>
								<a href="{{url('islamic/jibon')}}" class="right">
									<img src="{{asset('/portal/img/islamic/inner_button/share.png')}}" style="padding-top: 3px;" height="15px" width="15px">
									<span class="title" style="color: red;">Share</span>
								</a>
							</div>
						</div>
					</div>
			    @endif

				@if(!empty($inspiration_contents))
					<div class="col s12 m12 l12">
						<div class="card">

							<div class="home-category-title">
								<div class="card-action">
									<table class="rml">
										<tr class="left-align">
											<td class="left pd-0">
												<img src="{{asset('portal/img/islamic/Islamic_Button/Daily-Inspiration.png')}}" height="30px" width="30px">
											</td>
											<td class="left pd-0">
												<span>&nbsp দৈনিক অনুপ্রেরণা</span>
											</td>
										</tr>
									</table>
								</div>
							</div>


							<a href="{{url('islamic/inspiration')}}" class="">
								<div class="card-image">
									<img src="{{ $CommonPath.'/'.$inspiration_contents['inspiration_attachment'] }}" style="width: 100%; height: auto">
								</div>
							</a>
							<div class="card-action">
								<a href="{{url('islamic/inspiration')}}" class="">
									<img src="{{asset('/portal/img/islamic/inner_button/read.png')}}" style="padding-top: 5px;" height="18px" width="18px">
									<span class="title" style="color: green;">Read</span>
								</a>
								<!-- <a  href="https://www.facebook.com/sharer/sharer.php?u={{URL::current()}}" target="_blank" class="right"> -->
								<a href="{{url('islamic/inspiration')}}" class="right">
									<img src="{{asset('/portal/img/islamic/inner_button/share.png')}}" style="padding-top: 3px;" height="15px" width="15px">
									 <span class="title" style="color: red;">
									 	<!-- <i class="tiny material-icons">share</i>   -->
									 Share</span>
								</a>
							</div>
						</div>
					</div>
			    @endif
			</div>
		</div>
    </div>
@endsection
@section('JScript')
    <script type="text/javascript">
        $(document).ready(function(){
            var site_url = $('.site_url').val();
			$('ul.tabs').tabs();

	      	$('.carousel.carousel-slider').carousel({
	      		fullWidth: true
	      		// indicators: false
	      	});
	    });

	   // move next carousel
	   $('.moveNextCarousel').click(function(e){
	      e.preventDefault();
	      e.stopPropagation();
	      $('.carousel').carousel('next');
	   });

	   // move prev carousel
	   $('.movePrevCarousel').click(function(e){
	      e.preventDefault();
	      e.stopPropagation();
	      $('.carousel').carousel('prev');
	   });


    </script>
@endsection