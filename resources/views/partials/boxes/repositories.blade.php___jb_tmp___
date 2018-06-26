<table class="table table-repository">
    <tbody>
        @foreach ($list as $value)
        <tr>

            @if(in_array('checkbox', $columns))
            <td class="checkbox-switch">
                @if( !$currentRepositories->where('provider_id', $value->provider_id)->first() )
                <div class="material-switch">
                    <input type="checkbox" name="repos[]" value="{{$value->provider_id}}" id="{{$value->provider_id}}" />
                    <label for="{{$value->provider_id}}" class="label-info"></label>
                </div>
                @else
                <i class="fa fa-check text-success"></i>
                @endif
            </td>
            @endif

            @if(in_array('repository', $columns))
            <td class="information">
                <p>
                <a href="{{$value->html_url}}" target="_blank">
                <strong>{{$value->title}}</strong></a></p>
                @if(in_array('organization', $columns))
                    <p> <small>{{trans('gitscrum.organization')}}: {{$value->organization_title}}</small></p>
                @endif
                <small>{{str_limit($value->description, 120)}}</small>
            </td>
            @endif



        </tr>
        @endforeach
    </tbody>
</table>
