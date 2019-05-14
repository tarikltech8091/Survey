@extends('portal.layout.master')
@section('content')
    <div class="common_background pd-10">
        <div class="details_common_background2" style="padding-bottom: 0px !important;">

            <div class="col s12" style="color: red;">

                @if($errors->count() > 0 )
                    <div class="alert alert-danger btn-squared">
                        <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                        <h6>The following errors have occurred:</h6>
                        <ul>
                            @foreach( $errors->all() as $message )
                                <li>{{ $message }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                @if(Session::has('message'))
                    <div class="alert alert-success btn-squared" role="alert">
                        <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                        {{ Session::get('message') }}
                    </div>
                @endif
                @if(Session::has('errormessage'))
                    <div class="alert alert-danger btn-squared" role="alert">
                        <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                        {{ Session::get('errormessage') }}
                    </div>
                @endif

            </div>


             @if(!empty($all_content))
                @foreach($all_content as $key => $campaign)

                    <div style="border: 1px #cccccc solid; margin: 5px; border-radius: 10px; background-color:#ffffff; ">
                        <div class="row" style="margin-bottom: 0px;">
                            <a href="{{url('/campaign/question/answer/'.$campaign->id.'/1')}}">
                                <div class="col s1 m1 l1 xl1">
                                    &nbsp;
                                </div>
                                <div class="col s9 m9 l9 xl9">
                                    <div style="font-size: 16px; padding: 15px 0 15px 0;">
                                        {{$campaign->campaign_name}}
                                    </div>
                                </div>
                                <div class="col s2 m2 l2 xl2">
                                    <i class="material-icons icon-details" style="float: left; font-size: 30px; padding: 10px 0 10px 0;">
                                        chevron_right
                                    </i>
                                </div>
                            </a>

                        </div>
                    </div>
                    @endforeach
                @endif



            <!-- <div class="romjan" style="border: 1px #cccccc solid; margin: 5px; border-radius: 10px; background-color:#ffffff; ">
                <div class="row romjan-row" style="margin-bottom: 0px;">
                    <a href="{{url('/campaign/details')}}">
                        <div class="col s1 m1 l1 xl1">
                            &nbsp;
                        </div>
                        <div class="col s9 m9 l9 xl9">
                            <div class="romjan-title" style="font-size: 16px; padding: 15px 0 15px 0;">
                                Camapaign 1
                            </div>
                        </div>
                        <div class="col s2 m2 l2 xl2">
                            <i class="material-icons icon-details" style="float: left; font-size: 30px; padding: 10px 0 10px 0;">
                                chevron_right
                            </i>
                        </div>
                    </a>

                </div>
            </div> -->


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