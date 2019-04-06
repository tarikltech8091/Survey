@extends('portal.layout.master')
@section('content')
    <div class="common_background pd-10">
        <div class="namaj-shikkha">
            <div class="details_common_background2">
                <div class="row border-bottom "
                     style="margin-bottom: 0px; ">
                    <a href="{{ url('namaj/shikkha/details/ozu') }}">
                        <div class="col s1 m1 l1 xl1">
                            &nbsp;
                        </div>
                        <div class="col s9 m9 l9 xl9">
                            <div class="title">
                                অযু
                            </div>
                        </div>
                        <div class="col s2 m2 l2 xl2">
                            <i class="material-icons icon-details">
                                chevron_right
                            </i>
                        </div>
                    </a>

                </div>
                <div class="row border-bottom " style="margin-bottom: 0px">
                    <a href="{{ url('namaj/shikkha/details/namaj-rule') }}">
                        <div class="col s1 m1 l1 xl1">
                            &nbsp;
                        </div>
                        <div class="col s9 m9 l9 xl9">
                            <div class="title">
                                নামাজের নিয়ম
                            </div>
                        </div>
                        <div class="col s2 m2 l2 xl2">
                            <i class="material-icons icon-details">
                                chevron_right
                            </i>
                        </div>
                    </a>

                </div>
                <div class="row border-bottom " style="margin-bottom: 0px">
                    <a href="{{ url('namaj/shikkha/details/namaj-duya') }}">
                        <div class="col s1 m1 l1 xl1">
                            &nbsp;
                        </div>
                        <div class="col s9 m9 l9 xl9">
                            <div class="title">
                                নামাজের দোয়া
                            </div>
                        </div>
                        <div class="col s2 m2 l2 xl2">
                            <i class="material-icons icon-details">
                                chevron_right
                            </i>
                        </div>
                    </a>
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