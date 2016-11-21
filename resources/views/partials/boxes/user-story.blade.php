<div class="project-list">

    <table class="table table-hover">
        <tbody>
        @each('partials.lists.user-stories', $list, 'list', 'partials.lists.no-items')
        </tbody>
    </table>

    {{ $list->links() }}

</div>
