

<div class="row">
    <div class="col s12">
        <strong>Zone Select</strong>
        <select name="participate_zone"  class="browser-default" style="background-color: #cccccc; border: 2px #9e9e9e solid;">
            <option value="">&nbsp;Please Select a Zone</option>

            @if(!empty($zone_info))
            @foreach($zone_info as $key =>$list)
                <option value="{{$list->zone_name}}">{{$list->zone_name}}</option>
            @endforeach
            @endif
    </select>
    </div>
</div>