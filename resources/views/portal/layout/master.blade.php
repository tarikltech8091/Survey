<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1.0"/>
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />

    <!-- Open Graph url property -->
    <meta property="og:url" content="{{url('/')}}" />
     
    <!-- Open Graph title property -->
    <meta property="og:title" content="Survey" />
     
    <!-- Open Graph description property -->
    <meta property="og:description" content="DESCRIPTION" /> 

    <!-- Open Graph image property -->
    <!-- <meta property="og:image" content="{{asset('portal/img/Icon.png')}}" /> -->
     
    <!-- Open Graph type property -->
    <meta property="og:type" content="website" />
     
    <!-- Open Graph site_name property -->
    <meta property="og:site_name" content="Survey" />

    <title>{{isset($page_title) ? $page_title : ''}} | Survey</title>
    <!-- CSS  -->
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link href="{{ asset('portal/materialize/css/mbox-0.0.3.min.css') }}" rel="stylesheet">
    @if(isset($page_title) && ($page_title != 'Survey'))
        <link href="{{ asset('portal/materialize/css/materialize-rtl.css') }}" type="text/css" rel="stylesheet"/>
    @endif
    <link href="{{ asset('portal/materialize/css/materialize.css') }}" type="text/css" rel="stylesheet" media="screen,projection"/>
    <!-- <link href="{{ asset('video.js/video-js.css') }}" rel="stylesheet"> -->
    <link href="{{ asset('portal/plugins/fullcalendar/css/fullcalendar.min.css') }}" type="text/css" rel="stylesheet" media="screen,projection">
    <link href="{{ asset('portal/audio/css/jquery.fullwidthAudioPlayer.css') }}" type="text/css" rel="stylesheet" media="screen,projection">

    <link rel="stylesheet" href="{{ asset('portal/owlcarousel/owl.carousel.min.css') }}">
    <link rel="stylesheet" href="{{ asset('portal/owlcarousel/owl.theme.default.min.css') }}">

    <!-- <link rel="icon" href="{{url('/portal/img/favicon.png')}}"> -->
    <link href="{{ asset('portal/materialize/css/style_v1.css') }}" type="text/css" rel="stylesheet" media="screen,projection"/>


    <style>
        #map {
            height: 100%;
        }
        body {
            -webkit-overflow-scrolling: touch;
        }
    </style>
    <script src="{{ asset('portal/materialize/js/jquery-3.2.1.min.js')}}"></script>
    <script src="{{ asset('portal/materialize/js/materialize.js') }}"></script>
</head>
<body>
    <!-- Header-->
    @php
        $subpage = isset($_REQUEST['channel']) && (strtoupper($_REQUEST['channel'])=='APP')? 'APP': 'WAP';
    @endphp

    @if((isset($page_title) ? $page_title : '') == 'Web Home')
    @elseif(isset($page_title) && ($page_title =='On Demand Consent'))
        @include('portal.layout.consent-header')
    @else
        @if($subpage !='APP')
            @include('portal.layout.header')

        @endif
    @endif
    <!-- End Header -->
    <!-- content-->
    @yield('content')
    <!-- end content-->
    @if(
        (isset($page_title) ? $page_title : '') != 'Web Home' &&
        (isset($page_title) ? $page_title : '') != 'On Demand Consent'
       )
        <!-- footer-->

        @if($subpage !='APP')
            @include('portal.layout.footer')
        @endif

        <!-- end footer -->
    @endif
<!--  Scripts-->
<script src="{{ asset('portal/materialize/js/init.js') }}"></script>
<script src="{{ asset('portal/materialize/js/mbox-0.0.3.min.js') }}"></script>
<script src="{{ asset('portal/js/jquery.jscroll.min.js') }}"></script>
<script src="{{ asset('portal/js/custom_v1.js') }}"></script>

<!-- <script src="{{ asset('video.js/video.js') }}"></script>
<script src="{{ asset('video.js/videojs-contrib-hls.min.js') }}"></script>
<script src="{{ asset('video.js/videojs-ie8.min.js') }}"></script> -->

<script src="{{ asset('portal/owlcarousel/owl.carousel.min.js') }}"></script>

<script type="text/javascript" src="https://bitmovin-a.akamaihd.net/bitmovin-player/stable/7.7/bitmovinplayer.js"></script>

<link rel="stylesheet" href="{{asset('portal/materialize/css/bitmovin_style.css')}}"/>


@if((isset($fullAudio) ? $fullAudio : '') == 'fullAudio'))
<!-- Audio -->
<script type="text/javascript" src="{{ asset('portal/audio/js/jquery.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('portal/audio/js/jquery-ui.js') }}"></script>
{{--<script type="text/javascript" src="{{ asset('portal/audio/js/jquery.fullwidthAudioPlayer.min.js') }}"></script>--}}
<script type="text/javascript" src="{{ asset('portal/audio/js/jquery.fullwidthAudioPlayer.js') }}"></script>
@endif
<!-- Calendar Script -->
<script type="text/javascript" src="{{ asset('portal/plugins/fullcalendar/lib/jquery-ui.custom.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('portal/plugins/fullcalendar/lib/moment.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('portal/plugins/fullcalendar/js/fullcalendar.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('portal/plugins/fullcalendar/fullcalendar-script.js')  }}"></script>


@yield('JScript')
<input type="hidden" class="site_url" value="{{url('/')}}" >
</body>
</html>
