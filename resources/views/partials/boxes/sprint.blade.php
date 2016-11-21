<table class="table table-striped">
    <thead>
    <tr>
        <th></th>
        <th> </th>
        <th>Name </th>
        <th>Phone </th>
        <th>Company </th>
        <th>Completed </th>
    </tr>
    </thead>
    <tbody>
        @each('partials.lists.sprints', $list, 'list', 'partials.lists.no-items')
    </tbody>
</table>

{{ $list->links() }}
