@extends('portal.layout.master')
@section('content')
<div class="common_background pd-10">
    <div class="details_common_background2">

        <div class="container">
            <div class="row">
                <div class="col s12 m12 l12 xl12">
                	@if(count($videos) > 0)
                        @foreach($videos as $key => $value)
                        <?php
                        $category_name=explode('_', $key);
                        $category_name=implode(' ', $category_name);
                        ?>
		                    <a href="{{url('/category/video/'.$key)}}"><h6 class="header collection-title f-20">{{strtoupper(isset($category_name)?$category_name:'')}}</h6></a>
		                    <div class="long-image">
		                        <div class="owl-carousel owl-theme">

		                        	@if(count($value) > 0)
		                                    @foreach($value as $key => $list)

		                                <a href="{{ url('video/type-'.$list['video_type'].'/id-'.$list['id']) }}">

											<div class="card card-background" style="border-radius: 15px;">

												<div class="card-image">

                                                    @if($list['poster_image'] != '')

                                                        <img class="owl-lazy" data-src="{{$CommonPath.'/'.$list['poster_image'] }}" style="width: 100%; height: auto; border-radius: 15px 15px 0px 0px">
                                                    @else
                                                        <img class="owl-lazy" data-src="{{ asset('portal/img/image-not-found.png') }}" style="width: 100%; height: auto; border-radius: 15px 15px 0px 0px">
                                                    @endif
													
												</div>

												<div class="card-action center-align new-poster-title" style="border-radius:  0px 0px 15px 15px;">
														<span class="title">{{isset($list['title'])? str_limit($list['title'], 5) :'Read'}}</span>
												</div>

											</div>
		                                </a>

		                            	@endforeach
		                            @else
										<p class="center-align">No content Available</p>
		                            @endif


		                        </div>
		                    </div>

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
    (function($){
        var site_url = $('.site_url').val();


        if ($(".long-image")[0]){
            $('.long-image .owl-carousel').owlCarousel({
                items: 3,
                margin: 8,
                loop: true,
                /* nav: true,
                 navText: ['',''],*/
                dots: false,
                lazyLoad: true
            });
        }
        if ($(".width-image")[0]){
            $('.width-image .owl-carousel').owlCarousel({
                items: 2,
                margin: 8,
                loop: true,
                /* nav: true,
                 navText: ['',''],*/
                dots: false,
                lazyLoad: true
            });
        }

    })(jQuery); //
</script>
@endsection