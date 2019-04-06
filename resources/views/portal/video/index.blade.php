@extends('portal.layout.master')
@section('content')
<div class="common_background">
    <div class="new-common" style="padding-bottom: 10px; padding-left: 2px;">
        <div class="video">
            <div class="video-list" style="margin: -1px; width: 100%; background: none">
                <ul class="collection" style="margin-bottom: 50px">

                        <div class="col s12">
                          <ul class="tabs" style="background: #111111; position: fixed; z-index: 999;">
                            <li class="tab col s3"><a class="active" href="#islamic">ইসলামিক</a></li>
                            <li class="tab col s3"><a href="#hamd">হামদ নাত</a></li>
                            <!-- <li class="tab col s3"><a href="#wazz">ওয়াজ</a></li> -->
                          </ul>
                        </div>
                        <div class="infinite-scroll">

                            <div id="islamic" class="col s12" style=" margin-top: 40px;">

                                @if(count($islamic_videos) > 0)
                                    @foreach($islamic_videos as $key => $value)
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
                            <div id="hamd" class="col s12" style=" margin-top: 40px;">
                                                            
                                @if(count($hamd_naat_videos) > 0)
                                    @foreach($hamd_naat_videos as $key => $value)
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
                            <!-- <div id="wazz" class="col s12" style=" margin-top: 40px;">
                                                            
                                @if(count($waaj_videos) > 0)
                                    @foreach($waaj_videos as $key => $value)
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
                            </div> -->
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