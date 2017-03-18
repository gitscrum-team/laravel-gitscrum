@if(!empty($list[0]))

    <table class="ui celled structured table">
        <thead>
        <tr>
            <th rowspan="2" style="width:10px"></th>
            <th colspan="3">{{trans('gitscrum.sprint-backlog')}}</th>
            <th colspan="2">{{trans('gitscrum.issues')}}</th>
            <th rowspan="2">{{trans('gitscrum.organization')}}</th>
            <th rowspan="2">{{trans('gitscrum.type')}}</th>
            <th rowspan="2" style="width:10px"></th>
        </tr>
        <tr>
            <th></th>
            <th>{{trans('gitscrum.user-stories')}}</th>
            <th>{{trans('gitscrum.sprints')}}</th>
            <th>{{trans('gitscrum.open')}}</th>
            <th>{{trans('gitscrum.closed')}}</th>
        </tr>
        </thead>
        <tbody>
        @each('partials.lists.sprints', $list, 'list', 'partials.lists.no-items')
        </tbody>
    </table>

@else
    @include('errors.notification-message', ['notification' => ['message' => trans('gitscrum.you-are-not-a-member-of-any-sprint') .
        '. <a href="'.route('sprints.index').'" class="font-bold">'. trans('gitscrum.list-sprint-backlog') . '</a>',
        'alert' => 'warning', 'class' => 'padding-none list-sprint-empty']])
@endif
