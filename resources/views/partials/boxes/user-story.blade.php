@if(!empty($list[0]))
    <table class="table table-hover">
        <tbody>
        @each('partials.lists.user-stories', $list->sortByDesc('favorite') , 'list', 'partials.lists.no-items')
        </tbody>
    </table>
    @if(!empty($list->links))
    {{$list->setPath('')->links()}}
    @endif
@else
    @include('errors.notification-message', ['notification' => ['message' => trans('gitscrum.you-are-have-not-user-story'),
        'alert' => 'warning', 'class' => 'padding-none list-user-story-empty']])
@endif
