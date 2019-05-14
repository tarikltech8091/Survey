@extends('portal.layout.master')
@section('content')
    <div class="common_background" style="padding: 10px;">
        <div class="details_common_background2">
            <div class="row" style="margin-bottom: 60px">

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

                    <style>

                            ::placeholder {
                                color: #655a5a;
                            }
                            .submit_button_color{
                                color: #000000; 
                            }

                    </style>

                    <div class="card-content" style="padding-bottom: 0px">
                            @if(!isset(\Auth::user()->id) && empty(\Auth::user()->id))

                                <h5 class="center-align">Login</h5>

                                <form role="form" class="form-horizontal" action="{{ url('/participate/login') }}"  method="post" role="form" enctype="multipart/form-data">

                                    <input type="hidden" name="_token" value="{{csrf_token()}}">


                                        <div class="row" style="margin: 0 3px">
                                            <strong>Participate Email</strong>

                                            <div class="input-field col s12">
                                                <input type="text" name="email" placeholder="Participate Email"/>
                                            </div>
                                        </div>
                                        <div class="row" style="margin: 0 3px">
                                            <strong>Participate Password</strong>

                                            <div class="input-field col s12">
                                                <input type="Password" name="password" placeholder="Participate Password"/>
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

                            @else

                                <h5>Name   : {{isset(\Auth::user()->name)? \Auth::user()->name :'' }}</h5>
                                <h5>Mobile : {{isset(\Auth::user()->user_mobile)? \Auth::user()->user_mobile :'' }}</h5>

                            @endif

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