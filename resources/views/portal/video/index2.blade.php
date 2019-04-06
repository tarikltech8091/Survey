@extends('portal.layout.master')
@section('content')
<div class="common_background">
    <div class="new-common" style="padding-bottom: 10px; padding-left: 2px;">
        <div class="video">
            <div class="video-list" style="margin: 0px; width: 100%; background: none">
                <ul class="collection" style="margin-bottom: 50px">

                        <div class="infinite-scroll">

                                @if(count($videos) > 0)
                                    @foreach($videos as $key => $value)
                                        <li class="collection-item">
                                            <a href="{{ url('video/type-'.$value->video_type.'/id-'.$value->id) }}" style="color: #fff">
                                                <h2>{{$value->title}}</h2>
                                                <div class="card">
                                                    <div class="card-image">
                                                        @if($value->poster_image != '')
                                                            <img src="{{ $host_url.'/'.$value->poster_image }}"
                                                                 alt="{{ $value->poster_image }}">
                                                        @else
                                                            <img src="{{ asset('portal/img/image-not-found.png') }}">
                                                        @endif
                                                        <div class="centered">
                                                            <i class="material-icons medium" style="color: #f0f0f0">play_circle_outline</i>
                                                        </div>
                                                    </div>
                                                </div>
                                            </a>
                                        </li>
                                    @endforeach
                                @else
                                    <li class="collection-item">
                                        <a href="javascript:void(0);" style="color: #fff">
                                            <p style="margin-left: 10px; font-size: 20px">
                                                দুঃখিত, কোন ভিডিও কনটেন্ট পাওয়া যায়নি।
                                            </p>
                                        </a>
                                    </li>
                                @endif
                        </div>



                </ul>
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