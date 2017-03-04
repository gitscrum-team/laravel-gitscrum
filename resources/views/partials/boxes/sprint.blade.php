@if(!empty($list[0]))
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
@else
    @include('errors.notification-message', ['notification' => ['message' => trans('You are not a member of any sprint') .
        '. <a href="'.route('sprints.index').'" class="font-bold">'. trans('List Sprint Backlog') . '</a>',
        'alert' => 'warning', 'class' => 'padding-none list-sprint-empty']])
@endif
