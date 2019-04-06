@extends('portal.layout.master')
@section('content')
<div class="subscription">
    <div class="container">
        <div class="section" style="padding-top: 0px;">
            <div class="row">
                <div class="col s12 m12 l12">
                    <div class="preloader-background" style="display: none">
                        <div class="preloader-wrapper big">
                            <div class="spinner-layer spinner-blue-only">
                                <div class="circle-clipper left">
                                    <div class="circle"></div>
                                </div>
                                <div class="gap-patch">
                                    <div class="circle"></div>
                                </div>
                                <div class="circle-clipper right">
                                    <div class="circle"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card" style="margin-top: 80px;">
                        <div class="card-content">
                            <div class="subscribed">
                                <p class="center-align" style="font-size: 20px;">
                                    Service Name
                                </p>
                                <br>
                                <p style="vertical-align: baseline" class="center-align">
                                    Islamic Kotha On Demand
                                </p>
                                <br>
                                <p class="center-align" style="font-size: 20px;">
                                    Charge:
                                </p>
                                <br>
                                <p style="vertical-align: baseline" class="center-align">
                                    Are you sure you want to activate Islamic Kotha on demand at TK. 14.61 for 15 Days?
                                </p>
                                <br>
                                <div class="center">
                                    <a href="{{ (isset($query_data) && !empty($query_data))? url('/on-demand/consent/confirmation?').$query_data:url('/on-demand/consent/confirmation') }}" class="waves-effect waves-light btn"
                                       style="
                                        min-height: 40px;
                                        line-height:40px;
                                        min-width: 60%;
                                        background-color: #00ee00;
                                        font-size: 16px;
                                        -webkit-border-radius: 0px;
                                        -moz-border-radius: 0px;
                                        border-radius: 0px;">
                                        OK
                                    </a>
                                </div>
                                <br>
                                <div class="center">
                                    @if(isset($_REQUEST['channel'])&&(strtolower($_REQUEST['channel'])=='app'))
                                        <a href="{{ url('/subscription/confirmation?').\Request::getQueryString().'&error=on-demand request cancel'}}" class="waves-effect waves-light btn"
                                           style="
                                        min-height: 40px;
                                        line-height:40px;
                                        min-width: 60%;
                                        background-color: #adadad;
                                        color: #000;
                                        font-size: 16px;
                                        -webkit-border-radius: 0px;
                                        -moz-border-radius: 0px;
                                        border-radius: 0px;">
                                            Cancel
                                        </a>
                                    @else
                                        <a href="{{ url('/subscription') }}" class="waves-effect waves-light btn"
                                           style="
                                        min-height: 40px;
                                        line-height:40px;
                                        min-width: 60%;
                                        background-color: #adadad;
                                        color: #000;
                                        font-size: 16px;
                                        -webkit-border-radius: 0px;
                                        -moz-border-radius: 0px;
                                        border-radius: 0px;">
                                            Cancel
                                        </a>
                                    @endif

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('JScript')

@endsection