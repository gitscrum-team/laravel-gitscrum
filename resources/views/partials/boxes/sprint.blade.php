<table class="table-sprint-backlog table table-striped table-hover">
    <thead>
    <tr>
        <th width="10"></th>
        <th width="140"></th>
        <th>{{_('Sprint Backlog')}}</th>
        <th class="text-right">{{_('Product Backlog')}}</th>
    </tr>
    </thead>
    <tbody>
        @each('partials.lists.sprints', $list, 'list', 'partials.lists.no-items')
    </tbody>
</table>

{{ $list->links() }}
