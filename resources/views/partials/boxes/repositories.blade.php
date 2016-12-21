<table class="table table-repository table-striped table-hover">
    <tbody>
        @foreach ($list as $value)
        <tr>

            @if(in_array('checkbox', $columns))
            <td width="30px">
                  <input type="checkbox" name="repos[]" value="{{$value->provider_id}}" id="{{$value->provider_id}}"
                    @if( $currentRepositories->where('provider_id', $value->provider_id)->first() ) checked disabled @endif />
            </td>
            @endif

            @if(in_array('repository', $columns))
            <td>
                <p>
                <a href="{{$value->html_url}}" target="_blank"><i class="fa fa-github" aria-hidden="true"></i></a>
                <strong>{{$value->title}}</strong></p>
                <small>{{str_limit($value->description, 120)}}</small>
            </td>
            @endif

            @if(in_array('organization', $columns))
            <td align="right"><p>{{$value->organization_title}}</p></td>
            @endif

        </tr>
        @endforeach
    </tbody>
</table>
