<table class="ui definition table">
    <thead>
    <tr><th></th>
        <th>{{trans('gitscrum.repository')}}</th>
        <th>{{trans('gitscrum.organization')}}</th>
    </tr></thead>
    <tbody>
    @foreach ($list as $value)
        <tr>

            @if(in_array('checkbox', $columns))
            <td width="30px">
                <input type="checkbox" name="repos[]" value="{{$value->provider_id}}" id="{{$value->provider_id}}"
                       @if( $currentRepositories->where('provider_id', $value->provider_id)->first() ) checked disabled @endif />
            </td>
            @else
            <td></td>
            @endif

            @if(in_array('repository', $columns))
                <td>
                    <div class="content">
                        <div class="header"><a href="{{$value->html_url}}" target="_blank">
                            <strong>{{$value->title}}</strong></a></div>
                        <div class="description">{{str_limit($value->description, 120)}}</div>
                    </div>
                </td>
            @endif

            @if(in_array('organization', $columns))
                <td align="right"><p>{{$value->organization_title}}</p></td>
            @endif

        </tr>
    @endforeach
    </tbody>
</table>