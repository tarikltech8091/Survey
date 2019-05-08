@extends('portal.layout.master')
@section('content')
    <div class="common_background  center-align">

        <div class="jakat-fund">

            <div class="row center-align">

                <div class="col s12">
                    <h5> যাকাত তহবিল </h5>
                    <p>I want a donate</p>
                </div>
                <div class ="col s12">

                    <div class="col s3">
                        <div class ="card-panel">
                            <button class = "btn waves-effect waves-teal">100tk</button></td>
                        </div>
                    </div>
                    <div class="col s3">
                        <div class ="card-panel">
                            <button class = "btn waves-effect waves-teal">100tk</button></td>
                        </div>
                    </div>
                    <div class="col s3">
                        <div class ="card-panel">
                            <button class = "btn waves-effect waves-teal">100tk</button></td>
                        </div>
                    </div>
                    <div class="col s3">
                        <div class ="card-panel">
                            <button class = "btn waves-effect waves-teal">100tk</button></td>
                        </div>
                    </div>

                </div>

                <div class ="col s12">
                    <div class ="col s2">
                    </div>
                    <div class ="col s4">
                        <div class ="card-panel">
                            <button class = "btn waves-effect waves-teal">Others</button></td>
                        </div>
                    </div>
                    <div class ="col s4">
                        {{--<div class ="card-panel">--}}
                            {{--<button class = "btn waves-effect waves-teal">1000000</button></td>--}}
                            <input placeholder="0tk" type="text" class="validate">
                        {{--</div>--}}
                    </div>
                    <div class ="col s2">
                    </div>
                </div>


                <form class="col s12">

                    <div class="input-field col s12">
                        <label>Towards</label>
                        <input placeholder="General Donate" type="text" class="validate">
                    </div>

                    <div class="input-field col s12">
                        <label>Duration</label>
                        <input placeholder="One off" type="text" class="validate">
                    </div>


                    <div class="col s12">
                        <div class ="card-panel">
                            <button class = "btn waves-effect waves-teal">Donate</button></td>
                        </div>
                    </div>

                </form>

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