
                                                <div class="col-md-6">

                                                    <div class="form-group">
                                                        <label class="col-sm-3 control-label">
                                                            <strong>Participate Mobile</strong>
                                                            <span class="symbol required" aria-required="true"></span>
                                                        </label>
                                                        <div class="col-sm-9">
                                                            <input type="text" class="form-control" name="participate_mobile">
                                                        </div>
                                                    </div>

                                                    <div class="form-group">
                                                        <label class="col-sm-3 control-label">
                                                            <strong>Participate Name</strong>
                                                            <span class="symbol required" aria-required="true"></span>
                                                        </label>
                                                        <div class="col-sm-9">
                                                            <input type="text" class="form-control" name="participate_name">
                                                        </div>
                                                    </div>
                                                    
                                                    <div class="form-group">
                                                        <label class="col-sm-3 control-label">
                                                            <strong>Participate Join Date</strong>
                                                            <span class="symbol required" aria-required="true"></span>
                                                        </label>
                                                        <div class="col-sm-9">
                                                            <input type="date" class="form-control" name="participate_join_date">
                                                        </div>
                                                    </div>


                                                    <div class="form-group">
                                                        <label class="col-sm-3 control-label">
                                                            <strong>Participate Email</strong>
                                                        </label>
                                                        <div class="col-sm-9">
                                                            <input type="email" class="form-control" name="participate_email">
                                                        </div>
                                                    </div>


                                                    <div class="form-group">
                                                        <label class="col-sm-3 control-label">
                                                            <strong>Participate District</strong>
                                                            <span class="symbol required" aria-required="true"></span>
                                                        </label>
                                                        <div class="col-sm-9">
                                                            <select id="form-field-select-3" class="form-control search-select"
                                                                    name="participate_district">
                                                                <option value="">&nbsp;Please Select a Type</option>

                                                                @if(!empty($all_district))
                                                                @foreach($all_district as $key =>$list)
                                                                    <option value="{{$list}}">{{$list}}</option>
                                                                @endforeach
                                                                @endif

                                                            </select>
                                                        </div>
                                                    </div>

                                                    <div class="form-group">
                                                        <label class="col-sm-3 control-label">
                                                            <strong> Zone</strong>
                                                            <span class="symbol required" aria-required="true"></span>
                                                        </label>
                                                        <div class="col-sm-9">
                                                            <select id="form-field-select-3" class="form-control search-select" name="participate_zone">
                                                                <option value="">&nbsp;Please Select a Type</option>

                                                                @if(!empty($all_zone))
                                                                @foreach($all_zone as $key =>$list)
                                                                    <option value="{{$list->zone_name}}">{{$list->zone_name}}</option>
                                                                @endforeach
                                                                @endif

                                                            </select>
                                                        </div>
                                                    </div>


                                                    <div class="form-group">
                                                        <label class="col-sm-3 control-label">
                                                            <strong>Participate Address</strong>
                                                        </label>
                                                        <div class="col-sm-9">
                                                            <textarea name="participate_address" class="form-control" cols="10" rows="7"></textarea>
                                                        </div>
                                                    </div>

                                                </div>

                                                <div class="col-md-6">


                                                    <div class="form-group">
                                                        <label class="col-sm-3 control-label">
                                                            <strong>Participate Gender</strong>
                                                            <span class="symbol required" aria-required="true"></span>
                                                        </label>
                                                        <div class="col-sm-9">
                                                            <select id="form-field-select-3" class="form-control search-select"
                                                                    name="participate_gender">
                                                                <option value="">&nbsp;Please Select a Type</option>
                                                                <option value="male">Male</option>
                                                                <option value="female">Female</option>
                                                                <option value="common">Common</option>
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
                                                                <option value="0-18">0-18</option>
                                                                <option value="19-25">19-25</option>
                                                                <option value="26-35">26-35</option>
                                                                <option value="36-50">36-50</option>
                                                                <option value="50-100">50-100</option>
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
                                                                <option {{(old('participate_religion')== "islam") ? "selected" :''}}  value="islam">Islam</option>
                                                                <option {{(old('participate_religion')== "christianity") ? "selected" :''}} value="christianity">Christianity</option>
                                                                <option {{(old('participate_religion')== "hinduism") ? "selected" :''}} value="hinduism">Hinduism</option>
                                                                <option {{(old('participate_religion')== "buddhism") ? "selected" :''}} value="buddhism">Buddhism</option>
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
                                                                <option value="student">Student</option>
                                                                <option value="teacher">Teacher</option>
                                                                <option value="business">Business</option>
                                                                <option value="govt-service">Govt. Service</option>
                                                                <option value="private-service">Private Service</option>
                                                            </select>
                                                        </div>
                                                    </div>


                                                    <div class="form-group">
                                                        <label class="col-sm-3 control-label">
                                                            <strong>Participate Post Code</strong>
                                                        </label>
                                                        <div class="col-sm-9">
                                                            <input type="text" class="form-control" name="participate_post_code">
                                                        </div>
                                                    </div>


                                                    <div class="form-group">
                                                        <label class="col-sm-3 control-label">
                                                            <strong>Participate NID</strong>
                                                        </label>
                                                        <div class="col-sm-9">
                                                            <input type="text" class="form-control" name="participate_nid">
                                                        </div>
                                                    </div>




                                                    <div class="form-group">
                                                        <label class="col-sm-3 control-label">
                                                            <strong>Participate Image</strong>
                                                        </label>
                                                        <div class="col-sm-9">
                                                            <div class="fileupload fileupload-new" data-provides="fileupload">
                                                                <div class="fileupload-new thumbnail" style="width: 150px; height: 150px;"><img src="{{asset('assets/images/profile.png')}}" alt="">
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

                                                </div>