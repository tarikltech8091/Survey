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
                    <!-- <div style="height:120px; padding-top:12px;" class="center-align fixed-sidebar-icon">
                        <a href="{{ url('namaj/time') }}">
                            <img src="{{ url('portal/img/islamic-icon.png') }}" width="35%"
                                 height="auto">
                        </a>
                    </div>

                <ul class="left-align">
                    <li class="{{isset($page_title) && ($page_title=='Hello') ? 'active' : ''}}"
                        style="border-bottom: 1px solid #8cc63f; border-top: 1px solid #8cc63f; padding:5px;">
                        <a href="{{ url('namaj/time') }}">
                            <img src="{{ asset('portal/img/Islamic-icon/namaj-timing.png') }}"
                                 style="float: left; margin-top: 1px;:" height="32px" width="32px">
                           <span style="padding-left: 25px;"> Hello </span>
                        </a>
                    </li>
           
                </ul> -->
            </div>
            @if($page_title == 'Home'
                    || $page_title == 'Menu'
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
