@extends('portal.layout.master')
@section('content')
    <div class="common_background" style="padding: 10px;">
        <div class="details_common_background2">
            <div class="row" style="margin-bottom: 60px">

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

                <div class="card">

                    <div class="card-content" style="padding-bottom: 0px">

                        <h5 class="center-align">Earn History</h5>
 
                        <div class="row" style="margin: 0 3px">
                            <div class="col s8">
                            	<strong>Total Earn Points </strong>
                            </div>
                            <div class="col s4">
                                {{isset($participate_info->participate_total_earn_points)? $participate_info->participate_total_earn_points :'0'}} 
                            </div>
                        </div>


                        <div class="row" style="margin: 0 3px">
                            <div class="col s8">
                            	<strong>Total Paid Points </strong>
                            </div>
                            <div class="col s4">
                                {{isset($participate_info->participate_total_paid_points)? $participate_info->participate_total_paid_points :'0'}}
                            </div>
                        </div>


                        <div class="row" style="margin: 0 3px">
                            <div class="col s8">
                            	<strong>Total Remain Points</strong>
                            </div>
                            <div class="col s4">
                                {{(isset($participate_info->participate_total_earn_points)? $participate_info->participate_total_earn_points : 0) - (isset($participate_info->participate_total_paid_points)? $participate_info->participate_total_paid_points : 0)}}
                            </div>
                        </div>


                        <div class="row" style="margin: 0 3px">
                            <div class="col s8">
                                <strong>Total Paid Amount</strong>
                            </div>
                            <div class="col s4">
                                {{isset($participate_info->participate_total_paid_earn)? $participate_info->participate_total_paid_earn :'0'}}
                            </div>
                        </div>

                        <!-- <h5 class="center-align">Physical Gifts</h5>


                        <div class="row" style="margin: 0 3px">
                            <div class="col s8">
                            	<strong>Campaign name</strong>
                            </div>
                            <div class="col s4">
                                Gent Watch
                            </div>
                        </div> -->


                    </div>

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