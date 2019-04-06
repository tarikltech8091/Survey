@extends('portal.layout.master')
@section('content')
<div class="common_background">
    <div class="video-details">
        <div class="col s12 m12 l12 xl12">
            <?php
                if($video->url != '') {
                    $url = $host_url.'/hls/'.$video->url . '/index.m3u8';
                } else {
                    $url = asset('football.mp4');
                }
            ?>

            <!-- <video id="my-video" class="vjs-matrix video-js vjs-big-play-centered"
                   controls preload="auto" autoplay data-setup="{}" style="width: 100%">
                <source src="{{ $url }}" type="application/x-mpegURL">
            </video> -->

            <?php
                if($video->url != '') {

                    $file = pathinfo($video->url);
                    if($file['extension'] == 'm3u8') {
                       $video_url = $video->url;
                    } else {
                        $video_url = $host_url.'/hls/'.$video->url. '/index.m3u8';
                    }

                } else {
                    $video_url = asset('football.mp4');
                }
            ?>

            <div id="my-player" style="width: 100%"></div>

        </div>
        <div class="container" style="margin: 0px; width: 100%">
            <ul class="collection" style="margin-bottom: 30px; border: none;">
                @if(count($videos) > 0)
                    @foreach($videos as $key => $value)
                        @if($value->id != $video->id)
                            <li class="collection-item avatar">
                                <a href="{{ url('video/type-'.$value->video_type.'/id-'.$value->id) }}" style="color: #fff">
                                    @if($value->poster_image != '')
                                        <img src="{{ $host_url.'/'.$value->poster_image }}"
                                             alt="{{ $value->poster_image }}" class="thumb_img">
                                    @else
                                        <img src="{{ asset('portal/img/image-not-found.png') }}" class="thumb_img">
                                    @endif
                                    <div class="title">
                                        {{ $value->title }}
                                        <br>
                                        <span style="font-size: 10px; color: #f5f5f0;">
                                        {{ date('D,j M, Y.H:i A', strtotime($value->published_date)) }}
                                        </span>
                                    </div>
                                </a>
                            </li>
                        @endif
                    @endforeach
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
                "hls": '<?php echo isset($video_url)? $video_url :'';  ?>',
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
            });*/
            
        });
    </script>
@endsection