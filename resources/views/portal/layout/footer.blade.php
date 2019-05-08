@php
    if(isset($operator) && !empty($operator)){
        $mobile_operator=$operator;
    }else{
        $mobile_operator='other';
    }
@endphp
<footer class="page-footer" style="position:fixed; bottom: 0px; width:100%">
    
    <div class="footer-copyright">
        <ul class="tabs tabs-fixed-width tab-demo z-depth-1 footer_background" style="height: 49px; position: fixed;">
            
            <li class="tab">
                <a class="{{(isset($page_title) && ($page_title == 'Home'))? 'active' :'' }}" href="{{ url('/') }}" target="_self">
                    <img src="{{ asset('portal/img/islamic/bottom_button/Home.png') }}" style="margin-top: 3px;" height="28px" width="28px">
                    <p class="footer_menu">Home</p>
                </a>
            </li>


            <li class="tab">
                <a class="{{(isset($page_title) && $page_title == 'নামাযের সময়')? 'active' :'' }}" href="{{ url('/namaj/time') }}" target="_self" >
                    <img src="{{ asset('portal/img/islamic/bottom_button/Namaz-Timing.png') }}" style="margin-top: 3px" height="28px" width="28px">
                    <p class="footer_menu">Campaign</p>
                </a>
            </li>



            <li class="tab">
                <a  class="{{(isset($page_title) && ($page_title == 'নামায শিক্ষা') || ($page_title == 'অযু') || ($page_title == 'নামাজের-নিয়ম') || ($page_title == 'নামাজের-দোয়া'))? 'active' :'' }}" href="{{ url('/namaj/shikkha') }}" target="_self" >
                    <img src="{{ asset('portal/img/islamic/bottom_button/namaz-learning.png') }}" style="margin-top: 3px" height="28px" width="28px">
                    <p class="footer_menu">
                        History 
                    </p>
                </a>
            </li>


            <li class="tab">
                <a  class="{{(isset($page_title) && $page_title == 'মেনু')? 'active' :'' }}" href="{{ url('/main/menu') }}" target="_self" >
                    <img src="{{ asset('portal/img/islamic/bottom_button/Menu.png') }}" style="margin-top: 3px" height="28px" width="28px">
                    <p class="footer_menu">Menu</p>
                </a>
            </li>


            <div class="indicator" style="z-index:999; background: red"></div>
        </ul>
    </div>
</footer>