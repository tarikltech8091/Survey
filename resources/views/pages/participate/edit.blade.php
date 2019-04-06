@extends('layout.master')
@section('content')
    <div class="row">
        <div class="col-md-12">
            <!-- start: FORM VALIDATION 2 PANEL -->
            <div class="panel panel-default btn-squared">
                <div class="panel-heading">
                    <i class="fa fa-external-link-square"></i>
                    Edit Participate
                    <div class="panel-tools">
                        <a class="btn btn-xs btn-link panel-collapse collapses" href="#">
                        </a>
                        <a class="btn btn-xs btn-link panel-close" href="#">
                            <i class="fa fa-times"></i>
                        </a>
                    </div>
                </div>

                <div class="panel-body">

                    <ul class="nav nav-tabs tab-bricky">
                        <li>
                            <a href="{{url('/participate/create')}}">
                                <i class="fa fa-plus-square"></i> Add Participate
                            </a>
                        </li>
                        <li>
                            <a href="{{url('/participate/list')}}">
                                <i class="fa fa-th-list"></i> Participate List
                            </a>
                        </li>
                    </ul>
                </div>

                <div class="panel-body">

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

                    <form role="form" class="form-horizontal" action="{{ url('/participate/update/id-'.$edit->id) }}"
                          id="participate" method="post" role="form" enctype="multipart/form-data">
                        <input type="hidden" name="_token" value="{{csrf_token()}}">

                        <div class="form-group">
                            <label class="col-sm-3 control-label">
                                <strong>Participate Name</strong>
                                <span class="symbol required" aria-required="true"></span>
                            </label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" name="participate_name" value="{{isset($edit)? $edit->participate_name :''}}">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">
                                <strong>Participate Email</strong>
                                <span class="symbol required" aria-required="true"></span>
                            </label>
                            <div class="col-sm-9">
                                <input type="email" class="form-control" name="participate_email" value="{{isset($edit)? $edit->participate_email :''}}">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">
                                <strong>Participate Mobile</strong>
                                <span class="symbol required" aria-required="true"></span>
                            </label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" name="participate_mobile" value="{{isset($edit)? $edit->participate_mobile :''}}">
                            </div>
                        </div>


                        <div class="form-group">
                            <label class="col-sm-3 control-label">
                                <strong>Participate Gender</strong>
                                <span class="symbol required" aria-required="true"></span>
                            </label>
                            <div class="col-sm-9">
                                <select id="form-field-select-3" class="form-control search-select"
                                        name="participate_gender">
                                    <option value="">&nbsp;Please Select a Type</option>
                                    <option {{($edit->participate_gender == 'male')? 'selected' :''}} value="male">Male</option>
                                    <option {{($edit->participate_gender == 'female')? 'selected' :''}}  value="female">Female</option>
                                    <option {{($edit->participate_gender == 'common')? 'selected' :''}}  value="common">Common</option>
                                </select>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-3 control-label">
                                <strong>Participate Age</strong>
                                <span class="symbol required" aria-required="true"></span>
                            </label>
                            <div class="col-sm-9">
                                <select id="form-field-select-3" class="form-control search-select" name="participate_age">
                                    <option value="">&nbsp;Please Select a Type</option>
                                    <option {{($edit->participate_age == '0-18')? 'selected' :''}}   value="0-18">0-18</option>
                                    <option {{($edit->participate_age == '19-25')? 'selected' :''}}   value="19-25">19-25</option>
                                    <option {{($edit->participate_age == '26-35')? 'selected' :''}}   value="26-35">26-35</option>
                                    <option {{($edit->participate_age == '36-50')? 'selected' :''}}   value="36-50">36-50</option>
                                    <option {{($edit->participate_age == '50-100')? 'selected' :''}}   value="50-100">50-100</option>
                                </select>
                            </div>
                        </div>


                        <div class="form-group">
                            <label class="col-sm-3 control-label">
                                <strong>Participate Religion</strong>
                                <span class="symbol required" aria-required="true"></span>
                            </label>
                            <div class="col-sm-9">
                                <select id="form-field-select-3" class="form-control search-select"
                                        name="participate_religion">
                                    <option value="">&nbsp;Please Select a Type</option>
                                    <option {{($edit->participate_religion == "islam") ? "selected" :''}}  value="islam">Islam</option>
                                    <option {{($edit->participate_religion == "christianity") ? "selected" :''}} value="christianity">Christianity</option>
                                    <option {{($edit->participate_religion == "hinduism") ? "selected" :''}} value="hinduism">Hinduism</option>
                                    <option {{($edit->participate_religion == "buddhism") ? "selected" :''}} value="buddhism">Buddhism</option>
                                </select>
                            </div>
                        </div>


                        <div class="form-group">
                            <label class="col-sm-3 control-label">
                                <strong>Participate Occupation</strong>
                                <span class="symbol required" aria-required="true"></span>
                            </label>
                            <div class="col-sm-9">
                                <select id="form-field-select-3" class="form-control search-select"
                                        name="participate_occupation">
                                    <option value="">&nbsp;Please Select a Type</option>
                                    <option {{($edit->participate_occupation == 'student')? 'selected' :''}}  value="student">Student</option>
                                    <option {{($edit->participate_occupation == 'teacher')? 'selected' :''}}  value="teacher">Teacher</option>
                                    <option {{($edit->participate_occupation == 'business')? 'selected' :''}}  value="business">Business</option>
                                    <option {{($edit->participate_occupation == 'govt-service')? 'selected' :''}}  value="govt-service">Govt. Service</option>
                                    <option {{($edit->participate_occupation == 'private-service')? 'selected' :''}}  value="private-service">Private Service</option>
                                </select>
                            </div>
                        </div>


                        <div class="form-group">
                            <label class="col-sm-3 control-label">
                                <strong>Participate Join Date</strong>
                                <span class="symbol required" aria-required="true"></span>
                            </label>
                            <div class="col-sm-9">
                                <input type="date" class="form-control" name="participate_join_date" value="{{isset($edit)? $edit->participate_join_date :''}}">
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-3 control-label">
                                <strong>Participate District</strong>
                                <span class="symbol required" aria-required="true"></span>
                            </label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" name="participate_district" value="{{isset($edit)? $edit->participate_district :''}}">
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-3 control-label">
                                <strong>Participate Zone</strong>
                                <span class="symbol required" aria-required="true"></span>
                            </label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" name="participate_zone" value="{{isset($edit)? $edit->participate_zone :''}}">
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-3 control-label">
                                <strong>Participate Post Code</strong>
                                <span class="symbol required" aria-required="true"></span>
                            </label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" name="participate_post_code" value="{{isset($edit)? $edit->participate_post_code :''}}">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">
                                <strong>Participate Address</strong>
                                <span class="symbol required" aria-required="true"></span>
                            </label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" name="participate_address" value="{{isset($edit)? $edit->participate_address :''}}">
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-3 control-label">
                                <strong>Participate NID</strong>
                                <span class="symbol required" aria-required="true"></span>
                            </label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" name="participate_nid" value="{{isset($edit)? $edit->participate_nid :''}}">
                            </div>
                        </div>



                        <div class="form-group">
                            <label class="col-sm-3 control-label">
                                <strong>Participate Image</strong>
                            </label>
                            <div class="col-sm-9">
                                <div class="fileupload fileupload-new" data-provides="fileupload">
                                    <div class="fileupload-new thumbnail" style="width: 150px; height: 150px;">
                                        @if(!empty( $edit->participate_profile_image))
                                            <img src="{{asset($edit->participate_profile_image)}}" alt="">
                                        @else
                                            <img src="{{asset('assets/images/profile.png')}}" alt="">
                                        @endif
                                    </div>
                                    <div class="fileupload-preview fileupload-exists thumbnail" style="max-width: 150px; max-height: 150px; line-height: 20px;"></div>
                                    <div class="user-edit-image-buttons">
                                        <span class="btn btn-light-grey btn-file"><span class="fileupload-new"><i class="fa fa-picture"></i> Select image</span><span class="fileupload-exists"><i class="fa fa-picture"></i> Change</span>
                                            <input type="file" name="participate_profile_image">
                                        </span>
                                        <a href="#" class="btn fileupload-exists btn-light-grey" data-dismiss="fileupload">
                                            <i class="fa fa-times"></i> Remove
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>


                        <div class="form-group">
                            <div class="col-sm-4">
                            </div>
                            <div class="col-sm-4">
                                <input class="btn btn-danger btn-squared" name="reset" value="Reset" type="reset">
                                <input class="btn btn-success btn-squared" name="submit" value="Update" type="submit">
                            </div>
                            <div class="col-sm-4">
                            </div>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('JScript')
    <script>
        $(function () {
            $('#participate').validate({
                rules: {
                    participate_name: {
                        required: true
                    },
                    participate_mobile: {
                        required: true
                    },
                    participate_email: {
                        required: true
                    },
                    participate_join_date: {
                        required: true
                    },
                    participate_district: {
                        required: true
                    },
                    participate_address: {
                        required: true
                    },
                    participate_post_code: {
                        required: true
                    },
                    participate_nid: {
                        required: true
                    }
                },
                highlight: function (element) {
                    $(element).closest('.form-group').removeClass('has-success').addClass('has-error');
                },
                unhighlight: function (element) {
                    $(element).closest('.form-group').removeClass('has-error').addClass('has-success');
                },
                errorElement: 'span',
                errorClass: 'help-block',
                errorPlacement: function (error, element) {
                    if (element.parent('.input-group').length) {
                        error.insertAfter(element.parent());
                    } else {
                        error.insertAfter(element);
                        element.attr("placeholder",error.text());
                    }
                }
            });

        })
    </script>
@endsection