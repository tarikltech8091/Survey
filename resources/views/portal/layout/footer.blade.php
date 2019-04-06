@php
    if(isset($operator) && !empty($operator)){
        $mobile_operator=$operator;
    }else{
        $mobile_operator='other';
    }
@endphp
<footer class="page-footer" style="position:fixed; bottom: 0px; width:100%">
    @if((isset($page_title) ? $page_title : '') == 'ওয়াজ'
            ||(isset($page_title) ? $page_title : '') == 'হামদ নাত'
            )
        @if(!empty($hamd_nath) && count($hamd_nath) > 0)
            <audio id="audio" preload="auto" controlsList="nodownload"
                   tabindex="0" controls=""
                   style="width: 100%;height: 58px; padding: 0px; margin-bottom: -10px">
                <source src="{{ isset($hamd_nath[0])? asset($hamd_nath[0]->hamd_nath_content_path) :'' }}">
                Your Fallback goes here
            </audio>
        @endif
        @if(!empty($waj) && count($waj) > 0)
            <audio id="audio" preload="auto" controlsList="nodownload"
                   tabindex="0" controls=""
                   style="width: 100%;height: 58px; padding: 0px; margin-bottom: -10px">
                <source src="{{  isset($waj[0])? asset($waj[0]->waaj_content_path) :'' }}">
                Your Fallback goes here
            </audio>
        @endif
    @endif
    
    <div class="footer-copyright">
        <ul class="tabs tabs-fixed-width tab-demo z-depth-1 footer_background" style="height: 49px; position: fixed;">
            
            <li class="tab">
                <a class="{{(isset($page_title) && ($page_title == 'ইসলামিক কথা'))? 'active' :'' }}" href="{{ url('/') }}" target="_self">
                    <img src="{{ asset('portal/img/islamic/bottom_button/Home.png') }}" style="margin-top: 3px;" height="28px" width="28px">
                    <p class="footer_menu">হোম</p>
                </a>
            </li>


            <li class="tab">
                <a class="{{(isset($page_title) && $page_title == 'নামাযের সময়')? 'active' :'' }}" href="{{ url('/namaj/time') }}" target="_self" >
                    <img src="{{ asset('portal/img/islamic/bottom_button/Namaz-Timing.png') }}" style="margin-top: 3px" height="28px" width="28px">
                    <p class="footer_menu">সময়</p>
                </a>
            </li>

            <!-- 
            <li class="tab">
                <a  class="{{(isset($page_title) && $page_title == 'মসজিদ')? 'active' :'' }}" href="{{ url('/mosque') }}" target="_self" >
                    <img src="{{ asset('portal/img/islamic/bottom_button/mosque.png') }}" style="margin-top: 3px" height="28px" width="28px">
                    <p class="footer_menu">মসজিদ</p>
                </a>
            </li> -->


            <li class="tab">
                <a  class="{{(isset($page_title) && ($page_title == 'নামায শিক্ষা') || ($page_title == 'অযু') || ($page_title == 'নামাজের-নিয়ম') || ($page_title == 'নামাজের-দোয়া'))? 'active' :'' }}" href="{{ url('/namaj/shikkha') }}" target="_self" >
                    <img src="{{ asset('portal/img/islamic/bottom_button/namaz-learning.png') }}" style="margin-top: 3px" height="28px" width="28px">
                    <p class="footer_menu">
                        নামায 
                        <!-- শিক্ষা -->
                    </p>
                </a>
            </li>

            <li class="tab">
                <a class="{{(isset($page_title) && (($page_title == 'কুরআন শরীফ') || (isset($page_main_title) && $page_main_title == 'সূরা বর্ননা')))? 'active' :'' }}" href="{{ url('learn/quran/surah') }}" target="_self" >
                    <img src="{{ asset('portal/img/islamic/bottom_button/Quran-Sharif.png') }}" style="margin-top: 3px" height="28px" width="28px">
                    <p class="footer_menu">
                        কুরআন 
                        <!-- শরীফ -->
                    </p>
                </a>
            </li>

            <li class="tab">
                <a  class="{{(isset($page_title) && ($page_title == 'মেনু' || $page_title != 'কুরআন শরীফ' || ( isset($page_main_title) && $page_main_title != 'সূরা বর্ননা' ) || $page_title != 'নামাযের সময়' || $page_title != 'নামায শিক্ষা' || $page_title != 'অযু' || $page_title != 'নামাজের-নিয়ম' || $page_title != 'তাসবীহ' || $page_title != 'নামাজের-দোয়া' ))? 'active' :'' }}" href="{{ url('/main/menu') }}" target="_self" >
                <!-- <a  class="{{(isset($page_title) && $page_title == 'মেনু')? 'active' :'' }}" href="{{ url('/main/menu') }}" target="_self" > -->
                    <img src="{{ asset('portal/img/islamic/bottom_button/Menu.png') }}" style="margin-top: 3px" height="28px" width="28px">
                    <p class="footer_menu">মেনু</p>
                </a>
            </li>


            <div class="indicator" style="z-index:999; background: red"></div>
        </ul>
    </div>
</footer>