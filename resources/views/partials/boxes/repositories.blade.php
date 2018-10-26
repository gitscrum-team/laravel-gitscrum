<table class="table table-repository" id="repoTable">
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
<script type="application/javascript">
    function filterFunction () {
        var input, filter, table, tr, td, i;
        input = document.getElementById("liveSearch");
        filter = input.value.toUpperCase();
        table = document.getElementById("repoTable");
        tr = table.getElementsByTagName("tr");
        for (i = 0; i < tr.length; i++) {
            td = tr[i].getElementsByTagName("td")[1];
            if (td) {
                if (td.innerHTML.toUpperCase().indexOf(filter) > -1) {
                    tr[i].style.display = "";
                } else {
                    tr[i].style.display = "none";
                }
            }
        }
    }
</script>
