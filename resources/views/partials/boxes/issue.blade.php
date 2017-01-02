@if(!empty($list[0]))
<table class="table table-issue table-hover issue-tracker">
    <tbody>
    @each('partials.lists.issues', $list, 'list', 'partials.lists.no-items')
    </tbody>
</table>
@else
    @include('errors.notification-message', ['notification' => ['message' => $messageEmpty,
        'alert' => 'warning', 'class' => 'padding-none list-issue-empty']])
@endif
