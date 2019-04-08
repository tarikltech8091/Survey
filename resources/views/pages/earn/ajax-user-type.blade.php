
@if($user_type == 'surveyer')

        <div class="form-group">
            <label class="col-sm-3 control-label">
                <strong>Select Surveyer</strong>
                <span class="symbol required" aria-required="true"></span>
            </label>
            <div class="col-sm-4">
                <select id="form-field-select-3" class="form-control search-select"
                        name="earn_paid_surveyer_id" style="border: 1px solid #ccc;">
                    <option value="">&nbsp;Please Select a Type</option>

                    @if(!empty($all_surveyer))
                    @foreach($all_surveyer as $key =>$list)
                        <option value="{{$list->id}}">{{$list->surveyer_name}}</option>
                        <input type="hidden" class="form-control" name="earn_paid_surveyer_mobile" value="{{$list->surveyer_mobile}}">
                    @endforeach
                    @endif

                </select>
            </div>
        </div>
        
@elseif($user_type == 'participate')

        <div class="form-group">
            <label class="col-sm-3 control-label">
                <strong>Select Participate Member</strong>
                <span class="symbol required" aria-required="true"></span>
            </label>
            <div class="col-sm-4">
                <select id="form-field-select-3" class="form-control search-select"
                        name="earn_paid_participate_id" style="border: 1px solid #ccc;">
                    <option value="">&nbsp;Please Select a Type</option>

                    @if(!empty($all_participate))
                    @foreach($all_participate as $key =>$value)
                        <option value="{{$value->id}}">{{$value->participate_name}}</option>
                        <input type="hidden" class="form-control" name="earn_paid_participate_mobile" value="{{$value->participate_mobile}}">
                    @endforeach
                    @endif

                </select>
            </div>
        </div>

@endif

