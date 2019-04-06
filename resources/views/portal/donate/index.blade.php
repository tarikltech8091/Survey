@extends('portal.layout.master')
@section('content')
    <div class="common_background center-align">

        <div class="doante">

            <div class="row center-align">

                <div class="col s12">
                    <h5>দান</h5>
                    <p>I want a donate</p>
                </div>
                <div class ="col s12">

                    <form method="post" action="">

                        <table>
                            <tr><td colspan="5">What is your favourite database?</td></tr>
                            <tr class ="col s12">
                                <td>
                                    <label>
                                        <input name="group1" type="radio"/>
                                        <span>Red</span>
                                    </label>
                                </td>

                                <td>
                                    <label>
                                        <input name="group1" type="radio"/>
                                        <span>Green</span>
                                    </label>
                                </td>

                                <td>
                                    <label>
                                        <input name="group1" type="radio"/>
                                        <span>Yellow</span>
                                    </label>
                                </td>


                                <td>
                                    <label>
                                        <input name="group1" type="radio"/>
                                        <span>Black</span>
                                    </label>
                                </td>


                                <td>
                                    <label>
                                        <input name="group1" type="radio"/>
                                        <span>Blue</span>
                                    </label>
                                </td>

                            </tr>

                            <tr class="col s2 right">
                                <td class="center-align">
                                    <input type="text" class = "btn waves-effect waves-teal" name="submit" value="Save"/>
                                </td>
                            </tr>
                        </table>




                    </form>
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