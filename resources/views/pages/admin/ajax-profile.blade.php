
<div class="form-group">
    <label class="col-sm-2 control-label">
        <strong>Requster Select</strong>
        <span class="symbol required" aria-required="true"></span>
    </label>
    <div class="col-sm-8">
        <select id="form-field-select-3" class="form-control search-select"
                name="admin_requester_id">
            <option value="">&nbsp;Please Select a Requster</option>

            @if(!empty($all_requester))
            @foreach($all_requester as $key =>$list)
                <option value="{{$list->id}}">{{$list->requester_name}}  {{$list->requester_mobile}}</option>
            @endforeach
            @endif

        </select>
    </div>
</div>


<div class="form-group">
    <label class="col-sm-2 control-label">
        <strong>Surveyer Select</strong>
        <span class="symbol required" aria-required="true"></span>
    </label>
    <div class="col-sm-8">
        <select id="form-field-select-3" class="form-control search-select"
                name="admin_surveyer_id">
            <option value="">&nbsp;Please Select a Surveyer</option>

            @if(!empty($all_surveyer))
            @foreach($all_surveyer as $key =>$list)
                <option value="{{$list->id}}">{{$list->surveyer_name}}  {{$list->surveyer_mobile}}</option>
            @endforeach
            @endif

        </select>
    </div>
</div>