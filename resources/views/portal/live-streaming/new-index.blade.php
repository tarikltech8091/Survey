@extends('portal.layout.master')
@section('content')
    <div class="common_background" style="background: #fff; height: 95%; padding-bottom: 20px;">
    	<div class="new-common" style="background: #fff; color: #000;">

    		<div class="video-details">
                @if(($content->streaming_source_type) == "embed")
                    <div class="col s12 m12 l12 xl12" align="center">
                        <iframe width="100%" height="100%" src="https://www.youtube.com/embed/{{($content->streaming_embed_code)? $content->streaming_embed_code: ''}}" frameborder="0" allow="autoplay; encrypted-media" allowfullscreen></iframe>
                    </div>
                @else
                    <div class="col s12 m12 l12 xl12">

                        <?php
                            if($content->streaming_url != '') {
                                $url = ($content->streaming_url)? $content->streaming_url : '';
                            } else {
                                $url = asset('football.mp4');
                            }
                        ?>


                        <?php
                            if($content->streaming_url != '') {

                                $file = pathinfo($content->streaming_url);
                                if($file['extension'] == 'm3u8') {
                                   $live_url = $content->streaming_url;
                                } else {
                                    $live_url = $host_url.'/hls/'.$content->streaming_ur. '/index.m3u8';
                                }

                            } else {
                                $live_url = asset('football.mp4');
                            }
                        ?>

                        <div id="my-player" style="width: 100%"></div>
                        <div style="padding-left: 5px; padding-right: 5px;">
	                        <ul>
	                        	<h5 class="left">{{isset($content->streaming_title)? $content->streaming_title:''}}</h5>
	                        	<a href="{{url('live/streaming')}}"><h5 class="right"><span style="background: #142a39; color: #fff; padding: 5px; border-radius: 5px;">See More</span></h5></a>
	                        </ul>
	        
	                    </div>
	                    <br><br>
	                    <hr>
                    </div>
                @endif
	            <div class="container">

	                <div class="row" style="margin-bottom: 0px">
	                    <div class="col s12 m12 l12 xl12">
	                        <a href="#"><p class="header collection-title" style="font-size: 16px; font-weight: bold; padding: 0px; margin: 0px;">{{strtoupper($type)}}</p></a>
	                        <div class="long-image">
	                            <div class="owl-carousel owl-theme">
				                    @if(!empty($videos) && count($videos) > 0)
				                        @foreach($videos as $key => $value)
				                                <a href="{{ url('video/type-'.$value->video_type.'/id-'.$value->id) }}">
				                                    <div class="card card-background" style="border-radius: 5px;">
				                                        <div class="card-image">

				                                            <?php
				                                        		if($value['poster_image'] != ''){
				                                                	$image = $host_url.'/'.isset($value['poster_image'])? $value['poster_image']:'';
				                                                }else{
				                                                	$image = "https://lorempixel.com/800/400/food/1";
							                                    }
				                                                	$image = "https://lorempixel.com/800/400/food/1";
				                                            ?>

				                                            <img class="owl-lazy"  data-src="{{ $image }}" style="width: 100%; height: auto">
				                                        </div>
				                                       
												        <div class="card-content" style="padding: 7px;">
												          <p style="color: #000; line-height: 1;">{{$value['title']}}</p>
												        </div>

				                                    </div>
				                                </a>
				                        @endforeach
				                    @endif
	                            </div>
	                        </div>
	                    </div>
	                </div>

	            </div>

        	</div>

			@if(!empty($events) && count($events) > 0)
				@foreach($events as $key => $list)
		            <div style="border-radius: 10px; border:1px solid #cccccc; padding: 5px; margin: 5px;">
		                <div class="row "
		                     style="margin-bottom: 0px; ">
		                    <a href="{{url('islamic/occasion/details/'.$list['id'])}}" style="color: #000;">
		                        <div class="col s1 m1 l1 xl1">
		                            &nbsp;
		                        </div>
		                        <div class="col s9 m9 l9 xl9">
		                            <div class="title">
		                                {{$list['event_title']}}
		                            </div>
		                        </div>
		                        <div class="col s2 m2 l2 xl2">
		                            <i class="material-icons icon-details">
		                                chevron_right
		                            </i>
		                        </div>
		                    </a>

		                </div>
		            </div>
                @endforeach
            @endif


		</div>
    </div>
@endsection
@section('JScript')
    <script type="text/javascript">
        (function($){
            var site_url = $('.site_url').val();

            var key = "94452f78-8dfd-4d3b-9b47-59cad553a664";
            var poster_image = '';
            var conf = {
                "key": key,
                "source": {
                "hls": '<?php echo isset($live_url)? $live_url :'';  ?>',
                "poster": ''
                },
                "cast": {
                "enable": true
                },
                "playback": {
                "autoplay": true
                }
            };


            function InitPlayer() {
                var player = bitmovin.player('my-player');
                    player.setup(conf).then(
                        function(value) {
                        // Success
                        console.log('Successfully created bitmovin player instance');
                        console.log(player);
                        },
                        function(reason) {
                        // Error!
                        console.log('Error while creating bitmovin player instance');
                    }
                );
            }

            InitPlayer();

            $('.long-image .owl-carousel').owlCarousel({
                items: 3,
                margin: 8,
                loop: true,
                /* nav: true,
                 navText: ['',''],*/
                dots: false,
                lazyLoad: true
            });

        })(jQuery); //
    </script>
@endsection