@extends('portal.layout.master')
@section('content')
    <div class="common_background pd-10">
        <div class="ayat-dua">
            <div class="details_common_background2">

                                
                <div class="row border-bottom"
                     style="margin-bottom: 0px; margin-top: 5px">
                    <a href="{{ url('video/type-islamic') }}">
                        <div class="col s1 m1 l1 xl1">
                            &nbsp;
                        </div>
                        <div class="col s9 m9 l9 xl9">
                            <div class="title">
                                ইসলামিক
                            </div>
                        </div>
                        <div class="col s2 m2 l2 xl2">
                            <i class="material-icons icon-details">
                                chevron_right
                            </i>
                        </div>
                    </a>
                </div>
                
                <div class="row border-bottom"
                     style="margin-bottom: 0px; margin-top: 5px">
                    <a href="{{ url('video/type-hamd_naat') }}">
                        <div class="col s1 m1 l1 xl1">
                            &nbsp;
                        </div>
                        <div class="col s9 m9 l9 xl9">
                            <div class="title">
                                হামদ নাত
                            </div>
                        </div>
                        <div class="col s2 m2 l2 xl2">
                            <i class="material-icons icon-details">
                                chevron_right
                            </i>
                        </div>
                    </a>
                </div>


                <!-- <div class="row border-bottom"
                     style="margin-bottom: 0px; margin-top: 0px">
                    <a href="{{ url('video/type-waaj') }}">
                        <div class="col s1 m1 l1 xl1">
                            &nbsp;
                        </div>
                        <div class="col s9 m9 l9 xl9">
                            <div class="title">
                                ওয়াজ
                            </div>
                        </div>
                        <div class="col s2 m2 l2 xl2">
                            <i class="material-icons icon-details">
                                chevron_right
                            </i>
                        </div>
                    </a>
                </div> -->

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