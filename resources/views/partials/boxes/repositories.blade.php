<table class="table table-striped table-hover">
    <tbody>
        @foreach ($list as $value)
        <tr>

            @if(in_array('checkbox', $columns))
            <td width="80px">
                <div class="bootstrap-switch-square mts">
                  <input type="checkbox" data-toggle="switch" name="repos[]" value="{{$value->provider_id}}" id="{{$value->provider_id}}"
                    @if( $currentRepositories->where('provider_id', $value->provider_id)->first() ) checked disabled @endif />
                </div>
            </td>
            @endif

            @if(in_array('repository', $columns))
            <td>
                <p class="mbn pbn">
                <a href="{{$value->html_url}}" target="_blank" class="mhs"><i class="fa fa-github" aria-hidden="true"></i></a>
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
