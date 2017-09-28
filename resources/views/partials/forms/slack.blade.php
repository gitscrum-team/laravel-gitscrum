<form action="{{ route('slack.update') }}" method="POST">
    {{ csrf_field() }}
    <input type="hidden" name="_method" value="PUT">
    <div class="form-group mbx pbx">
        <div class="input-group">
            <input class="form-control" name="slack_username" value="{{ $user->slack_username }}" placeholder="Slack username" type="text" autocomplete="off">
            <span class="input-group-btn">
                <button class="btn btn-default btn-loader" type="submit">{{trans('gitscrum.save')}}</button>
            </span>
        </div>
    </div>
</form>
