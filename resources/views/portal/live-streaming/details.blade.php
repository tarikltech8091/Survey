@extends('portal.layout.master')
@section('content')
    <div class="common_background">
        <div class="video-details pdt-4">
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

                        <!-- <video id="my-video" class="vjs-matrix video-js vjs-big-play-centered"
                               controls preload="auto" autoplay data-setup="{}" style="width: 100%">
                            <source src="{{ $url }}" type="application/x-mpegURL">
                        </video> -->

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

                    </div>
                @endif
            <div class="container" style="margin: 0px; width: 100%">
                <ul class="collection" style="margin-bottom: 30px; border: none;">
                    @if(!empty($contents) && count($contents) > 0)
                        @foreach($contents as $key => $value)
                            @if($value->id != $content->id)
                                <a href="{{url('live/streaming/details/'.$value->id)}}" style="color: #fff">
                                    <li class="collection-item avatar">
                                        @if($value->streaming_poster_image != '')
                                            <img src="{{asset($value->streaming_poster_image) }}"
                                                     alt="Najat Live Image" class="thumb_img">
                                        @else
                                            <img src="{{ asset('portal/img/image-not-found.png') }}" class="thumb_img">
                                        @endif
                                        <div class="title">
                                            {{ $value->streaming_title }}
                                            <br>
                                            <span style="font-size: 10px; color: #f5f5f0;">{{ $value->created_at }}</span>
                                        </div>
                                    </li>
                                </a>
                            @endif
                        @endforeach
                    @else
                    @endif
                </ul>
                <br>
            </div>
        </div>
    </div>
@endsection
@section('JScript')
    <script type="text/javascript">
        $(document).ready(function(){
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


            /*videojs('my-video').ready(function() {
                this.play();
            })*/;

        });
    </script>
@endsection