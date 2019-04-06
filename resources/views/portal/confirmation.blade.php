<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1.0"/>
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <title>{{isset($page_title) ? $page_title : ''}} | নাজাত </title>
    <!-- CSS  -->
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link href="{{ asset('portal/materialize/css/mbox-0.0.3.min.css') }}" rel="stylesheet">
    <link href="{{ asset('portal/materialize/css/materialize-rtl.css') }}" type="text/css" rel="stylesheet"/>
    <link href="{{ asset('portal/materialize/css/materialize.css') }}" type="text/css" rel="stylesheet" media="screen,projection"/>
    <link href="{{ asset('portal/materialize/css/style_v9.css') }}" type="text/css" rel="stylesheet" media="screen,projection"/>
</head>
<body style="background-color: #fff">
<!-- Header-->

<!-- End Header -->
<!-- content-->
<div class="subscription">
    <div class="container">
        <div class="section">
            <div class="row">
                <div class="col s12 m12 l12">
                    <div class="card">
                        <div class="card-content">
                            <div class="unsubscribed">
                                <p class="materialize-red-text center-align" style="font-size: 25px; margin-top: 50px">
                                    হেল্পলাইনঃ : 28155
                                </p>
                                <br>
                                <p style="vertical-align: baseline; color:#000" class="center-align">
                                    @if(isset($_REQUEST['status'])&&$_REQUEST['status']==-2)
                                        অনুগ্রহ করে মোবাইল ইন্টারনেট দিয়ে পুনরায় চেষ্টা করুন !
                                    @elseif(isset($_REQUEST['status'])&&$_REQUEST['status']==0)
                                        ধন্যবাদ।  আপনার অনুরোধটি প্রক্রিয়াধীন আছে।  ব্রাউজিংয়ের জন্য কন্টিনিউ বাটন চাপুন ।
                                    @elseif(isset($_REQUEST['status'])&&$_REQUEST['status']==6)
                                        আপনার অনুরোধটি সফল হয়নি । অনুগ্রহ করে পুনরায় চেষ্টা করুন |
                                    @elseif(isset($_REQUEST['status'])&&$_REQUEST['status']==3)
                                        আপনার অনুরোধটি সফল হয়নি । আপনার সাবস্ক্রিপশন লিমিট অতিক্রম করেছে । অনুগ্রহ করে আগামীকাল চেষ্টা করুন ।
                                    @elseif(isset($_REQUEST['status'])&&$_REQUEST['status']==-1)
                                        ধন্যবাদ । আপনি একজন নিবন্ধিত গ্রাহক ।
                                    @else
                                        আপনার অনুরোধটি সফল হয়নি । অনুগ্রহ করে পুনরায় চেষ্টা করুন |
                                    @endif
                                </p>
                                <br>
                                <br>

                                <div class="center">
                                    <a href="{{url('/home?continue=1')}}" class="waves-effect waves-light btn subscription-request-new"
                                            style="border-radius:20px 20px 20px 20px; min-height: 36px; line-height:36px;" data-pack="5">
                                        &nbsp&nbsp Continue &nbsp&nbsp
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- end content-->
<!-- footer-->
<!-- end footer -->
<!--  Scripts-->
<script src="{{ asset('portal/materialize/js/jquery-3.2.1.min.js')}}"></script>
<script src="{{ asset('portal/materialize/js/materialize.js') }}"></script>
<script src="{{ asset('portal/materialize/js/init.js') }}"></script>
@yield('JScript')
<input type="hidden" class="site_url" value="{{url('/')}}" >
</body>
</html>
