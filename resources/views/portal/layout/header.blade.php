<div class="navbar-fixed">

    <nav class="materialize-green" role="navigation">
        <div class="nav-wrapper container center-align" style="width: 97%">
            <a id="logo-container" href="{{ url('/') }}" class="fsize center-align common_color">
                @if(isset($page_title) && !empty($page_title))

                    @if(($page_title == 'নাজাত'))
                        <img src="{{ asset('portal/img/Nazat-Banglalink-Logo.png') }}" height="50px" width="100px" alt="Najat">
                    @else
                        {{$page_title}}
                    @endif

                @else

                    নাজাত

                @endif
            </a>

            <ul class="right hide-on-med-and-down">
                <li>&nbsp;</li>
            </ul>
            <div id="nav-mobile" class="side-nav right-align sidebar_background">
                    <div style="height:120px; padding-top:12px;" class="center-align fixed-sidebar-icon">
                        <a href="{{ url('namaj/time') }}">
                            <img src="{{ url('portal/img/islamic-icon.png') }}" width="35%"
                                 height="auto">
                        </a>
                    </div>

                <ul class="left-align">
                    <li class="{{isset($page_title) && ($page_title=='নামাযের সময়') ? 'active' : ''}}"
                        style="border-bottom: 1px solid #8cc63f; border-top: 1px solid #8cc63f; padding:5px;">
                        <a href="{{ url('namaj/time') }}">
                            <img src="{{ asset('portal/img/Islamic-icon/namaj-timing.png') }}"
                                 style="float: left; margin-top: 1px;:" height="32px" width="32px">
                           <span style="padding-left: 25px;"> নামাযের সময়</span>
                        </a>
                    </li>
                    <li class="{{isset($page_title) && ($page_title=='মসজিদ') ? 'active' : ''}}"
                        style="border-bottom: 1px solid #8cc63f; padding:5px;">
                        <a href="{{ url('mosque') }}">
                            <img src="{{ asset('portal/img/Islamic-icon/mosjid.png') }}"
                                 style="float: left; margin-top: 1px;:" height="32px" width="32px">
                            <span style="padding-left: 25px;"> মসজিদ</span>
                        </a>
                    </li>
                    <li class="{{isset($page_title) && ($page_title=='নামাজ শিক্ষা') ? 'active' : ''}}"
                        style="border-bottom: 1px solid #8cc63f; padding:5px;">
                        <a href="{{ url('namaj/shikkha') }}">
                            <img src="{{ asset('portal/img/Islamic-icon/learn-namaj.png') }}"
                                 style="float: left; margin-top: 1px;:" height="32px" width="32px">
                            <span style="padding-left: 25px;"> নামাজ শিক্ষা</span>
                        </a>
                    </li>
                    <li class="{{isset($page_title) && ($page_title=='কুরআন শিক্ষা') ? 'active' : ''}}"
                        style="border-bottom: 1px solid #8cc63f; padding:5px;">
                        <a href="{{ url('learn/quran') }}">
                            <img src="{{ asset('portal/img/Islamic-icon/learn-quran.png') }}"
                                 style="float: left; margin-top: 1px;:" height="32px" width="32px">
                            <span style="padding-left: 25px;"> কুরআন শিক্ষা</span>
                        </a>
                    </li>
                    <li class="{{isset($page_title) && ($page_title=='কুরআন শরীফ') ? 'active' : ''}}"
                        style="border-bottom: 1px solid #8cc63f; padding:5px;">
                        <a href="{{ url('learn/quran/surah') }}">
                            <img src="{{ asset('portal/img/Islamic-icon/quran_sarif.png') }}"
                                 style="float: left; margin-top: 1px;:" height="32px" width="32px">
                            <span style="padding-left: 25px;"> কুরআন শরীফ</span>
                        </a>
                    </li>
                    <li class="{{isset($page_title) && ($page_title=='হাদিস') ? 'active' : ''}}"
                        style="border-bottom: 1px solid #8cc63f; padding:5px;">
                        <a href="{{ url('hadis') }}">
                            <img src="{{ asset('portal/img/Islamic-icon/hadith.png') }}"
                                 style="float: left; margin-top: 1px;:" height="32px" width="32px">
                            <span style="padding-left: 25px;"> হাদিস</span>
                        </a>
                    </li>
                    <li class="{{isset($page_title) && ($page_title=='আয়াত ও দোয়া') ? 'active' : ''}}"
                        style="border-bottom: 1px solid #8cc63f; padding:5px;">
                        <a href="{{ url('ayat/dua') }}">
                            <img src="{{ asset('portal/img/Islamic-icon/dua.png') }}"
                                 style="float: left; margin-top: 1px;:" height="32px" width="32px">
                            <span style="padding-left: 25px;"> আয়াত ও দোয়া</span>
                        </a>
                    </li>

                    <li class="{{isset($page_title) && ($page_title=='যাকাত') ? 'active' : ''}}"
                        style="border-bottom: 1px solid #8cc63f; padding:5px;">
                        <a href="{{ url('jakat') }}">
                            <img src="{{ asset('portal/img/Islamic-icon/zakat.png') }}"
                                 style="float: left; margin-top: 1px;:" height="32px" width="32px">
                            <span style="padding-left: 25px;"> যাকাত</span>
                        </a>
                    </li>
                    <li class="{{isset($page_title) && ($page_title=='লাইভ') ? 'active' : ''}}"
                        style="border-bottom: 1px solid #8cc63f; padding:5px;">
                        <a href="{{ url('live/streaming') }}">
                            <img src="{{ asset('portal/img/Islamic-icon/live.png') }}"
                                 style="float: left; margin-top: 1px;:" height="32px" width="32px">
                            <span style="padding-left: 25px;"> লাইভ</span>
                        </a>
                    </li>
                    <li class="{{isset($page_title) && ($page_title=='ভিডিও') ? 'active' : ''}}"
                        style="border-bottom: 1px solid #8cc63f; padding:5px;">
                        <a href="{{ url('video') }}">
                            <img src="{{ asset('portal/img/Islamic-icon/video.png') }}"
                                 style="float: left; margin-top: 1px;:" height="32px" width="32px">
                            <span style="padding-left: 25px;"> ভিডিও</span>
                        </a>
                    </li>

                    <li class="{{isset($page_title) && ($page_title=='ওয়াজ') ? 'active' : ''}}"
                        style="border-bottom: 1px solid #8cc63f; padding:5px;">
                        <a href="{{ url('waz') }}">
                            <img src="{{ asset('portal/img/Islamic-icon/wazz.png') }}"
                                 style="float: left; margin-top: 1px;:" height="32px" width="32px">
                            <span style="padding-left: 25px;"> ওয়াজ</span>
                        </a>
                    </li>
                    <li class="{{isset($page_title) && ($page_title=='ক্যালেন্ডার') ? 'active' : ''}}"
                        style="border-bottom: 1px solid #8cc63f; padding:5px;">
                        <a href="{{ url('/calendar') }}">
                            <img src="{{ asset('portal/img/Islamic-icon/calendar.png') }}"
                                 style="float: left; margin-top: 1px;:" height="32px" width="32px">
                            <span style="padding-left: 25px;"> ক্যালেন্ডার</span>
                        </a>
                    </li>
                    <li class="{{isset($page_title) && ($page_title=='ইসলামিক উপলক্ষ') ? 'active' : ''}}"
                        style="border-bottom: 1px solid #8cc63f; padding:5px;">
                        <a href="{{ url('islamic/occasion') }}">
                            <img src="{{ asset('portal/img/Islamic-icon/islamic-occassion.png') }}"
                                 style="float: left; margin-top: 1px;:" height="32px" width="32px">
                            <span style="padding-left: 25px;"> ইসলামিক উপলক্ষ</span>
                        </a>
                    </li>

                    <li class="{{isset($page_title) && ($page_title=='ইসলামিক জীবন') ? 'active' : ''}}"
                        style="border-bottom: 1px solid #8cc63f; padding:5px;">
                        <a href="{{ url('islamic/jibon') }}">
                            <img src="{{ asset('portal/img/Islamic-icon/islamic-life.png') }}"
                                 style="float: left; margin-top: 1px;:" height="32px" width="32px">
                            <span style="padding-left: 25px;"> ইসলামিক জীবন</span>
                        </a>
                    </li>


                    {{--<li class="{{isset($page_title) && ($page_title=='যাকাত তহবিল') ? 'active' : ''}}"
                        style="border-bottom: 1px solid #8cc63f; padding:5px;">
                        <a href="{{ url('jakat/fund') }}">
                            <img src="{{ asset('portal/img/Islamic-icon/zakat-fund.png') }}"
                                 style="float: left; margin-top: 1px;:" height="32px" width="32px">
                            <span style="padding-left: 25px;">  যাকাত তহবিল</span>
                        </a>
                    </li>--}}
                    <li class="{{isset($page_title) && ($page_title=='হামদ নাথ') ? 'active' : ''}}"
                        style="border-bottom: 1px solid #8cc63f; padding:5px;">
                        <a href="{{ url('hamd/naat') }}">
                            <img src="{{ asset('portal/img/Islamic-icon/ham-nath.png') }}"
                                 style="float: left; margin-top: 1px;:" height="32px" width="32px">
                            <span style="padding-left: 25px;"> হামদ নাথ</span>
                        </a>
                    </li>

                   {{-- <li class="{{isset($page_title) && ($page_title=='দান') ? 'active' : ''}}"
                        style="border-bottom: 1px solid #8cc63f; padding:5px;">
                        <a href="{{ url('donate') }}">
                            <img src="{{ asset('portal/img/Islamic-icon/donate.png') }}"
                                 style="float: left; margin-top: 1px;:" height="32px" width="32px">
                            <span style="padding-left: 25px;"> দান</span>
                        </a>
                    </li>--}}

                    {{--<li class="{{isset($page_title) && ($page_title=='কিবলা') ? 'active' : ''}}"
                        style="border-bottom: 1px solid #8cc63f; padding:5px;">
                        <a href="{{ url('/') }}">
                            <img src="{{ asset('portal/img/Islamic-icon/qibla.png') }}"
                                 style="float: left; margin-top: 1px;:" height="32px" width="32px">
                            <span style="padding-left: 25px;"> কিবলা</span>
                        </a>
                    </li>--}}
                    <li class="{{isset($page_title) && ($page_title=='৯৯ নাম') ? 'active' : ''}}"
                        style="border-bottom: 1px solid #8cc63f; padding:5px;">
                        <a href="{{ url('allah/99/name') }}">
                            <img src="{{ asset('portal/img/Islamic-icon/name-of-allah.png') }}"
                                 style="float: left; margin-top: 1px;:" height="32px" width="32px">
                            <span style="padding-left: 25px;">  ৯৯ নাম</span>
                        </a>
                    </li>
                    <li class="{{isset($page_title) && ($page_title=='Subscription') ? 'active' : ''}}"
                        style="border-bottom: 1px solid #8cc63f; padding:5px;">
                        <a href="{{ url('/subscription') }}">
                            <img src="{{ asset('portal/img/Islamic-icon/setting.png') }}"
                                 style="float: left; margin-top: 1px;:" height="32px" width="32px">
                            <span style="padding-left: 25px;">সাবক্রিপশন</span>
                        </a>
                    </li>
                    {{--<li class="{{isset($page_title) && ($page_title=='Settings') ? 'active' : ''}}"--}}
                        {{--style="border-bottom: 1px solid #8cc63f; padding:5px;">--}}
                        {{--<a href="{{ url('allah/99/name') }}">--}}
                            {{--<img src="{{ asset('portal/img/Islamic-icon/setting.png') }}"--}}
                                 {{--style="float: left; margin-top: 1px;:" height="32px" width="32px">--}}
                            {{--<span style="padding-left: 25px;">সেটিংস</span>--}}
                        {{--</a>--}}
                    {{--</li>--}}
                    <br>
                </ul>
            </div>
            @if($page_title == 'নাজাত'
                    || $page_title == 'মেনু'
                    || $page_title == 'মসজিদ'
                    || $page_title == 'নামাযের সময়'
                    || $page_title == 'ভিডিও'
                    || $page_title == 'লাইভ'
                )
<!--                 <img src="{{ url('portal/img/icons/Icon.png') }}" width="45px" height="auto"
                     style="float: left; margin: 4px auto;"> -->
            @else
                <a href="javascript:history.back()">
                    <i class="material-icons"
                       style="float: left; font-size: 32px; font-weight: bold; color: #ffffff;">
                        keyboard_backspace
                    </i>
                </a>
            @endif

            <!-- <a href="#" data-activates="nav-mobile" class="button-collapse"><i class="material-icons">menu</i></a> -->
        </div>
    </nav>
</div>
