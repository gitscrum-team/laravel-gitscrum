<table class="table-sprint-backlog table table-striped table-hover">
    <thead>
    <tr>
        <th width="10"></th>
        <th>{{_('Branch')}}</th>
        <th></th>
    </tr>
    </thead>
    <tbody>
    @foreach ($list as $value)
        <tr>
            <td></td>
            <td>{{$value->title}}</td>
            <td></td>
        </tr>
    @endforeach
    </tbody>
</table>
