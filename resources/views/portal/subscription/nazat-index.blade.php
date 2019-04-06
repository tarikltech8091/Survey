@extends('portal.layout.master')
@section('content')
<div class="subscription">
    <div class="container">
        <div class="section">
            <div class="row">
                <div class="col s12 m12 l12">
                    @if(\Session::has('message'))
                        {{--  <p class="white-text">
                              {{ Session::get('message') }}
                          </p>--}}
                        <script type="text/javascript">
                            var message = '<?php echo \Session::get('message')  ?>';
                            Materialize.toast(
                                message,
                                5000,
                                'red'
                            );
                        </script>
                    @endif
                    <div class="card">
                        <div class="card-content">
                            @if(isset($msisdn_status['sub_status'])&&$msisdn_status['sub_status'] == 'subscribed')


                                <div class="subscribed">
                                    <p class="materialize-red-text center-align" style="font-size: 25px; margin-top: 50px">
                                        Help Line: 8155 (Free)
                                    </p>
                                    <br>
                                    <p style="vertical-align: baseline; color: #000" class="center-align">
                                        You are a subscribed user of this service. To deactivate the
                                        service please click on the button below
                                    </p>
                                    <br>
                                    <div class="center">
                                        <button type="button"  id="SubmitId" data-msisdn="{{ $msisdn_status['msisdn'] }}" class="waves-effect waves-light btn unsubscription-request"
                                                 style="border-radius:20px 20px 20px 20px; min-height: 36px; line-height:36px;">
                                            &nbsp&nbsp UNSUBSCRIBE &nbsp&nbsp
                                        </button>
                                    </div>
                                </div>

                            @elseif(isset($msisdn_status['sub_status'])&&$msisdn_status['sub_status'] == 'unsubscribed')
                                <div class="unsubscribed">
                                    <p class="materialize-red-text center-align" style="font-size: 25px; margin-top: 50px">
                                        Help Line: 8155 (Free)
                                    </p>
                                    <br>
                                    <p style="vertical-align: baseline; color:#000" class="center-align">
                                        Learn Quran, hadith, jakat etc and & watch videos, get SMS updates at BDT 2.44 daily subscription.
                                        The service will be auto-renewable.
                                    </p>
                                    <h1 style="font-size: 36px; margin-top:20px; color: #000;
                                    margin-bottom: 10px" class="center-align">
                                        Daily
                                    </h1>
                                    <br>
                                    <div class="center">
                                        <button type="button" id="SubmitId" class="waves-effect waves-light btn subscription-request-new"
                                                style="border-radius:20px 20px 20px 20px;;
                                            min-height: 36px; line-height:36px; " data-pack="1" data-msisdn="{{ $msisdn_status['msisdn'] }}" data-channel="{{(isset($channel)?$channel:'WAP')}}" data-operator="{{(isset($operator)?$operator:'blink')}}">
                                            &nbsp&nbsp SUBSCRIBE &nbsp&nbsp
                                        </button>
                                    </div>
                                    <br>
                                </div>
                            @else
                                <div class="unsubscribed">
                                    <p class="materialize-red-text center-align" style="font-size: 25px; margin-top: 50px">
                                        Help Line: 8155 (Free)
                                    </p>
                                    <br>
                                    <p style="vertical-align: baseline; color:#000" class="center-align">
                                        Learn Quran, hadith, jakat etc and & watch videos, get SMS updates at BDT 2.44 daily subscription.
                                        The service will be auto-renewable.
                                    </p>

                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('JScript')

    <script>
        $(function(){
            $('.subscription-request-new').on('click', function () {
                var site_url = $('.site_url').val();
                var pack = $(this).data('pack');
                var msisdn = $(this).data('msisdn');
                var channel = $(this).data('channel');
                var operator = $(this).data('operator');
                console.log(msisdn);

                $('.preloader-background').css('display', 'flex');
                $('.preloader-wrapper').addClass('active');

                if((msisdn !== 'NO_MSISDN') && (pack != '') && (operator =='blink')) {
                    var redirectUrl = site_url+"/subscription/consent?pack="+pack+"&channel="+channel;
                    console.log(redirectUrl);
                    window.location.href = redirectUrl;
                }else {
                    $('.preloader-background').css('display', 'none');
                    $('.preloader-wrapper').removeClass('active');
                    mbox.custom({
                        message: '<div class="center">Please try from Banglalink network !!<br></div>',
                        options: {}, // see Options below for options and defaults
                        buttons: [
                            {
                                label: 'OK',
                                color: 'custom-green alert-button-center'
                            }
                        ]
                    });
                }

            });
        });


        $('.unsubscription-request').on('click', function () {
            $('.preloader-background').css('display', 'flex');
            $('.preloader-wrapper').addClass('active');
            var site_url = $('.site_url').val();
            var msisdn = $(this).data('msisdn');
            if(msisdn != 'NO_MSISDN') {
                $.get(
                    site_url+'/unsubscription/'+msisdn,
                    function (data, status) {
                        if (status == 'success') {
                            console.log('deactivating request');
                            $('.preloader-background').css('display', 'flex');
                            $('.preloader-wrapper').addClass('active');
                            mbox.custom({
                                message: '<div class="center">The service is deactivated!<br></div>',
                                options: {}, // see Options below for options and defaults
                                buttons: [
                                    {
                                        label: 'OK',
                                        color: 'custom-green alert-button-center',
                                        callback: function() {
                                            location.reload();
                                        }
                                    }
                                ]
                            });
                        } else {
                            $('.preloader-background').css('display', 'flex');
                            $('.preloader-wrapper').addClass('active');
                            mbox.custom({
                                message: '<div class="center">Service deactivation failed. Please try again!!<br></div>',
                                options: {}, // see Options below for options and defaults
                                buttons: [
                                    {
                                        label: 'OK',
                                        color: 'custom-green alert-button-center'
                                    }
                                ]
                            });
                            //console.log(data);
                        }
                    }
                );
                //console.log(msisdn);
            } else {
                $('.preloader-background').css('display', 'flex');
                $('.preloader-wrapper').addClass('active');
                mbox.custom({
                    message: '<div class="center">Slow internet! Please try again<br></div>',
                    options: {}, // see Options below for options and defaults
                    buttons: [
                        {
                            label: 'OK',
                            color: 'custom-green alert-button-center'
                        }
                    ]
                });
                //console.log(data);
            }
        });

        $(document).ready(function()
            {
            $('#SubmitId').click(function()
            {
                $(this).attr('disabled',true);
                return false;
            });
        });

    </script>
@endsection