@extends('portal.layout.master')
@section('content')
    <div class="common_background" style="padding: 10px;">
        <div class="details_common_background2">
            <div class="row" style="margin-bottom: 60px">

        	    <style>

                    ::placeholder {
                        color: #655a5a;
                    }
                    .submit_button_color{
                        color: #000000; 
                    }

                </style>

                <div class="col s12" style="color: red;">

                    @if($errors->count() > 0 )
                        <div class="alert alert-danger btn-squared">
                            <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                            <h6>The following errors have occurred:</h6>
                            <ul>
                                @foreach( $errors->all() as $message )
                                    <li>{{ $message }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    @if(Session::has('message'))
                        <div class="alert alert-success btn-squared" role="alert">
                            <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                            {{ Session::get('message') }}
                        </div>
                    @endif
                    @if(Session::has('errormessage'))
                        <div class="alert alert-danger btn-squared" role="alert">
                            <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                            {{ Session::get('errormessage') }}
                        </div>
                    @endif

                </div>

                <div class="card">

                    <div class="card-content" style="padding-bottom: 0px">
                            <h5 class="center-align">Participate</h5>
                        <div class="jakat_calculator">
     

                            <form role="form" class="form-horizontal" action="{{ url('/participate/registration/save') }}" method="post" role="form" enctype="multipart/form-data">

                                <input type="hidden" name="_token" value="{{csrf_token()}}">

                                    <div class="row" style="margin: 0 3px">
                                        <strong>Participate Name</strong>
                                        <i style="color: red;" class="tiny material-icons">star</i>

                                        <div class="input-field col s12">
                                            <input type="text" name="participate_name" placeholder="Participate Name"/>
                                        </div>
                                    </div>
                                    <div class="row" style="margin: 0 3px">
                                        <strong>Participate Join date</strong>

                                        <div class="input-field col s12">
                                            <input type="date" name="participate_join_date" placeholder="Participate Join date"/>
                                        </div>
                                    </div>
                                    <div class="row" style="margin: 0 3px">
                                        <strong>Participate Mobile</strong>

                                        <div class="input-field col s12">
                                            <input type="text" name="participate_mobile" placeholder="Participate Mobile"/>
                                        </div>
                                    </div>
                                    <div class="row" style="margin: 0 3px">
                                        <strong>Participate Email</strong>

                                        <div class="input-field col s12">
                                            <input type="email" name="participate_email" placeholder="Participate Email"/>
                                        </div>
                                    </div>
                                    <div class="row" style="margin: 0 3px">
                                        <strong>Password</strong>

                                        <div class="input-field col s12">
                                            <input type="password" name="password" placeholder="Password"/>
                                        </div>
                                    </div>
                                    <div class="row" style="margin: 0 3px">
                                        <strong>Address</strong>

                                        <div class="input-field col s12">
                                            <input type="text" name="participate_address" placeholder="Address"/>
                                        </div>
                                    </div>
                                    <div class="row" style="margin: 0 3px">
                                        <strong>Post Code</strong>

                                        <div class="input-field col s12">
                                            <input type="text" name="participate_post_code" placeholder="Post Code"/>
                                        </div>
                                    </div>

                                    <div class="row" style="margin: 0 3px">
                                        <strong>NID</strong>
                                        <div class="input-field col s12">
                                            <input type="text" name="participate_nid" placeholder="NID"/>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col s12">
                                            <strong>District Select</strong>
                                            <select name="participate_district"  class="browser-default" style="background-color: #cccccc; border: 2px #9e9e9e solid;">
                                                <option value=""selected>Please Select a District</option>
                                                @if(!empty($all_district))
                                                @foreach($all_district as $key =>$list)
                                                    <option value="{{$list}}">{{$list}}</option>
                                                @endforeach
                                                @endif
                                            </select>
                                        </div>
                                    </div>


                                    <div class="row">
                                        <div class="col s12">
                                            <strong>Zone Select</strong>
                                            <select name="participate_zone"  class="browser-default" style="background-color: #cccccc; border: 2px #9e9e9e solid;">
                                                <option value="">&nbsp;Please Select a Zone</option>

                                                @if(!empty($all_zone))
                                                @foreach($all_zone as $key =>$list)
                                                    <option value="{{$list->zone_name}}">{{$list->zone_name}}</option>
                                                @endforeach
                                                @endif
                                        </select>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col s12">
                                            <strong>Gender</strong>
                                            <select name="participate_gender"  class="browser-default" style="background-color: #cccccc; border: 2px #9e9e9e solid;">
                                                <option value="">&nbsp;Please Select a Gender</option>
                                                <option value="male">Male</option>
                                                <option value="female">Female</option>
                                                <option value="common">Common</option>
                                            </select>
                                        </select>
                                        </div>
                                    </div>


                                    <div class="row">
                                        <div class="col s12">
                                            <strong>Age</strong>
                                            <select name="participate_age"  class="browser-default" style="background-color: #cccccc; border: 2px #9e9e9e solid;">
                                                <option value="">&nbsp;Please Select a Age</option>
                                                <option value="0-18">0-18</option>
                                                <option value="19-25">19-25</option>
                                                <option value="26-35">26-35</option>
                                                <option value="36-50">36-50</option>
                                                <option value="50-100">50-100</option>
                                            </select>
                                        </select>
                                        </div>
                                    </div>



                                    <div class="row">
                                        <div class="col s12">
                                            <strong>Religion</strong>
                                            <select name="participate_religion"  class="browser-default" style="background-color: #cccccc; border: 2px #9e9e9e solid;">
                                                <option value="">&nbsp;Please Select a Religion</option>
                                                <option {{(old('participate_religion')== "islam") ? "selected" :''}}  value="islam">Islam</option>
                                                <option {{(old('participate_religion')== "christianity") ? "selected" :''}} value="christianity">Christianity</option>
                                                <option {{(old('participate_religion')== "hinduism") ? "selected" :''}} value="hinduism">Hinduism</option>
                                                <option {{(old('participate_religion')== "buddhism") ? "selected" :''}} value="buddhism">Buddhism</option>
                                            </select>
                                        </select>
                                        </div>
                                    </div>


                                    <div class="row">
                                        <div class="col s12">
                                            <strong>Occupation</strong>
                                            <select name="participate_occupation"  class="browser-default" style="background-color: #cccccc; border: 2px #9e9e9e solid;">
                                                <option value="">&nbsp;Please Select a Occupation</option>
                                                <option value="student">Student</option>
                                                <option value="teacher">Teacher</option>
                                                <option value="business">Business</option>
                                                <option value="govt-service">Govt. Service</option>
                                                <option value="private-service">Private Service</option>
                                            </select>
                                            </select>
                                        </select>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col s4">
                                        </div>
                                        <div class="col s4">
                                            <input type="submit" class="waves-light btn" value="Submit">
                                        </div>
                                        <div class="col s4">
                                        </div>
                                    </div>


                            </form>

                        </div>

                    </div>

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