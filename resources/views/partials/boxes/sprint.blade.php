<table class="table-sprint-backlog table table-striped table-hover">
    <thead>
    <tr>
        @if(isset($column['thead_sprintFavorite']))
        <th width="10"></th>
        @endif

        @if(isset($column['thead_sprintLabels']))
        <th width="140"></th>
        @endif

        @if(isset($column['thead_sprintBacklog']))
        <th>{{trans('Sprint Backlog')}}</th>
        @endif

        @if(isset($column['thead_sprintProductBacklog']))
        <th class="text-right">{{trans('Product Backlog')}}</th>
        @endif
    </tr>
    </thead>
    <tbody>
        @each('partials.lists.sprints', $list, 'list', 'partials.lists.no-items')
    </tbody>
</table>

@if(!empty($list->links))
{{ $list->links() }}
@endif
