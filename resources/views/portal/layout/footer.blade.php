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
                <a class="{{(isset($page_title) && ($page_title == 'Home'))? 'active' :'' }}" href="{{ url('/participate/home') }}" target="_self">
                    <img src="{{ asset('portal/img/icon/home.png') }}" style="margin-top: 3px;" height="28px" width="28px">
                    <p class="footer_menu">Home</p>
                </a>
            </li>




            <li class="tab">
                <a  class="{{(isset($page_title) && ($page_title == 'History'))? 'active' :'' }}" href="{{ url('/portal/participate/list') }}" target="_self" >
                    <img src="{{ asset('portal/img/icon/menu.png') }}" style="margin-top: 3px" height="28px" width="28px">
                    <p class="footer_menu">
                        History 
                    </p>
                </a>
            </li>

            
            <li class="tab">
                <a class="{{(isset($page_title) && $page_title == '')? 'active' :'' }}" href="{{ url('/participate/earn') }}" target="_self" >
                    <img src="{{ asset('portal/img/icon/calculate.png') }}" style="margin-top: 3px" height="28px" width="28px">
                    <p class="footer_menu">Earn</p>
                </a>
            </li>


            <li class="tab">
                <a  class="{{(isset($page_title) && $page_title == 'login')? 'active' :'' }}" href="{{ url('/participate/login') }}" target="_self" >
                    <img src="{{ asset('portal/img/icon/settings.png') }}" style="margin-top: 3px" height="28px" width="28px">
                    <p class="footer_menu">Login</p>
                </a>
            </li>


            <!-- <div class="indicator" style="z-index:999; background: red"></div> -->
            
        </ul>
    </div>
</footer>