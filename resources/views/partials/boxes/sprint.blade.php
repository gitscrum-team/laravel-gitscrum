<table class="table table-striped table-sprint">
    <thead>
    <tr>
        <th width="10"></th>
        <th width="140"></th>
        <th>Name </th>
        <th width="220">Timebox </th>
        <th>Progress </th>
        <th align="right">Team </th>
    </tr>
    </thead>
    <tbody>
        @each('partials.lists.sprints', $list, 'list', 'partials.lists.no-items')
    </tbody>
</table>

{{ $list->links() }}
