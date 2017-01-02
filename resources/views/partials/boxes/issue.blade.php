<table class="table table-issue table-hover issue-tracker">
    <tbody>
    @each('partials.lists.issues', $sprint->issues, 'list', 'partials.lists.no-items')
    </tbody>
</table>
