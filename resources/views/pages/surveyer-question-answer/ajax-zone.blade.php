
<div class="form-group">
    <label class="col-sm-3 control-label">
        <strong> Zone</strong>
        <span class="symbol required" aria-required="true"></span>
    </label>
    <div class="col-sm-9">
        <select id="form-field-select-3" class="form-control search-select" name="participate_zone" style="border: 1px solid #ccc;">
            <option value="">&nbsp;Please Select a Type</option>

            @if(!empty($zone_info))
            @foreach($zone_info as $key =>$list)
                <option value="{{$list->zone_name}}">{{$list->zone_name}}</option>
            @endforeach
            @endif

        </select>
    </div>
</div>