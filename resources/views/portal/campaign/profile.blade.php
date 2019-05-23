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

                        <table>
                            <tbody>

                                <tr>
                                    <th>Name </th>
                                    <td>{{isset($participate_info->participate_name)? $participate_info->participate_name :'' }}</td>
                                </tr>
                                
                                <tr>
                                    <th>Mobile </th>
                                    <td>{{isset($participate_info->participate_mobile)? $participate_info->participate_mobile :'' }}</td>
                                </tr>

                                <tr>
                                    <th>Email </th>
                                    <td>{{isset($participate_info->participate_email)? $participate_info->participate_email :'' }}</td>
                                </tr>

                                <tr>
                                    <th>Age </th>
                                    <td>{{isset($participate_info->participate_age)? $participate_info->participate_age :'' }}</td>
                                </tr>    

                                <tr>
                                    <th>District </th>
                                    <td>{{isset($participate_info->participate_district)? $participate_info->participate_district :'' }}</td>
                                </tr>  

                                <tr>
                                    <th>Post Code </th>
                                    <td>{{isset($participate_info->participate_post_code)? $participate_info->participate_post_code :'' }}</td>
                                </tr> 

                                <tr>
                                    <th>NID </th>
                                    <td>{{isset($participate_info->participate_nid)? $participate_info->participate_nid :'' }}</td>
                                </tr>     

                                <tr>
                                    <th>Gender </th>
                                    <td>{{isset($participate_info->participate_gender)? $participate_info->participate_gender :'' }}</td>
                                </tr>

                                <tr>
                                    <th>Religion </th>
                                    <td>{{isset($participate_info->participate_religion)? $participate_info->participate_religion :'' }}</td>
                                </tr>    

                                <tr>
                                    <th>Occupation </th>
                                    <td>{{isset($participate_info->participate_occupation)? $participate_info->participate_occupation :'' }}</td>
                                </tr>                                

                            </tbody>
                        </table>

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