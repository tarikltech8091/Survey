@extends('portal.layout.master')
@section('content')
    <div class="common_background jakat-fund  center-align">

        <div class="row jakat-fund-details">

            <div class="col s12">
                <H5 class="center-align">Enter Card Details</H5>
                <img class="responsive-img" src="{{asset('portal/img/Bank.png')}}">
            </div>
            <form class="col s12">

                <div class="input-field col s12">
                    <input type="text" class="validate">
                    <label for="first_name">Name On Card</label>
                </div>

                <div class="input-field col s12">
                    <input type="text" class="validate">
                    <label for="password">Card Number</label>
                </div>

                <div class="input-field col s2">
                    <input type="text" class="validate">
                    <label for="MM">MM</label>
                </div>
                <div class="input-field col s2">
                    <input type="text" class="validate">
                    <label for="YY">YY</label>
                </div>
                <div class="input-field col s4">
                    <input type="text" class="validate">
                    <label for="CVC">CVC</label>
                </div>
                <div class="input-field col s4">
                    <input type="text" class="validate">
                    <label for="Post Code">Post Code</label>
                </div>

                <div class="col s12">
                    <div class ="card-panel">
                        <button class = "btn waves-effect waves-large full-btn">Review payment</button></td>
                    </div>
                </div>
                <div class="col s12 ">
                    <div class ="card-panel">
                        <button class = "btn waves-effect waves-teal full-btn">Back</button></td>
                    </div>
                </div>

            </form>
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