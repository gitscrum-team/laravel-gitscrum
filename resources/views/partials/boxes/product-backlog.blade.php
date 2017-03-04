<table class="table-product-backlog table table-striped table-hover">
    <thead>
    <tr>
        <th></th>
        <th></th>
        <th>{{trans('Product Backlog')}}</th>
        <th>{{trans('Organization')}} </th>
        <th></th>
    </tr>
    </thead>
    <tbody>
        @each('partials.lists.product-backlogs', $list, 'list', 'partials.lists.no-items')
    </tbody>
</table>
