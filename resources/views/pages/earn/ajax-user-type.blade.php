
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
                        <option value="{{$list->id}}">{{$list->surveyer_name}}  {{$list->surveyer_mobile}}</option>
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
                        <option value="{{$value->id}}">{{$value->participate_name}}  {{$value->participate_mobile}}</option>
                    @endforeach
                    @endif

                </select>
            </div>
        </div>

        <div class="form-group">
            <label class="col-sm-3 control-label">
                <strong> Participate Paid Points</strong>
                <span class="symbol required" aria-required="true"></span>
            </label>
            <div class="col-sm-4">
                <input type="number" class="form-control" name="participate_paid_points">
            </div>
        </div>

@endif

