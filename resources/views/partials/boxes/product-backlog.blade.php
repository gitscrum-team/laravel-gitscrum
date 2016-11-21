<table class="table table-striped">
    <thead>
    <tr>
        <th></th>
        <th></th>
        <th>{{_('Product Backlog')}}</th>
        <th>{{_('Organization')}} </th>
        <th class="text-right">{{_('Sprints')}}</th>
        <th class="text-right">{{_('Issues')}}</th>
    </tr>
    </thead>
    <tbody>
        @each('partials.lists.product-backlogs', $list, 'list', 'partials.lists.no-items')
    </tbody>
</table>
