<form action="{{route($route, ['slug'=>@$issue->slug])}}" method="post" class="form-horizontal">
    {{ csrf_field() }}

    @if ( isset($parent_id) )
    <input type="hidden" name="parent_id" value="{{$parent_id}}">
    @endif

    @if ( isset($userStory) )
    <input type="hidden" name="user_story_id" value="{{$userStory->id}}">
    <div class="form-group">
        <label class="col-sm-12 mbn pbn">{{trans('User Story')}}</label>
        <div class="col-sm-12"><a href="{{route('user_stories.show', ['slug' => $userStory->slug])}}"
            target="_blank" class="text-success">{{$userStory->title}}</a></div>
    </div>
    <div class="hr-line-dashed"></div>
    @endif

    @if (is_int($productBacklogs))
    <input type="hidden" name="product_backlog_id" value="{{$productBacklogs}}">
    @endif

    @if ( isset($productBacklogs) && !is_int($productBacklogs) )
    <div class="form-group">
        <label class="col-sm-12">{{trans('Sprint Backlog')}}</label>
        <div class="col-sm-12">
            <select name="sprint_id" class="form-control">
                @foreach ($productBacklogs as $backlog)

                    @if ( $backlog->sprints->count() )
                    <optgroup label="{{$backlog->title}}">
                    @endif

                    @foreach ($backlog->sprints as $productBacklog_sprint)
                    <option value="{{$productBacklog_sprint->id}}">{{$productBacklog_sprint->title}}</option>
                    @endforeach

                    @if ($backlog->sprints->count())
                    </optgroup>
                    @endif

                @endforeach
            </select>
        </div>
    </div>
    <div class="hr-line-dashed"></div>
    @else
    <input type="hidden" name="slug_sprint" value="{{ $slug }}">
    @endif

    <div class="form-group">
        <label class="col-sm-12">{{trans('Type')}}</label>
        <div class="col-sm-12">
            <select name="issue_type_id" class="form-control">
                @foreach ($issue_types as $type)
                <option value="{{$type->id}}" @if( isset($issue->type) && $issue->type->id == $type->id )
                    selected="selected" @endif >{{$type->title}}</option>
                @endforeach
            </select>
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-12">{{trans('Issue')}}</label>
        <div class="col-sm-12">
            <input name="title" type="text" class="form-control" value="{{ $issue->title or '' }}"
                pattern=".{2,255}" title="{{trans('Title must be between 2 and 255 characters')}}"
                autocomplete="off" maxlength="255" required>
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-12">{{trans('Description')}} ({{trans('optional')}})</label>
        <div class="col-sm-12">
            <textarea name="description" type="text" class="form-control" data-provide="markdown" style="padding:10px;">{{ $issue->markdownDescription or '' }}</textarea>
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-12">{{trans('Avg Effort')}}</label>
        <div class="col-sm-12">
            <select name="config_issue_effort_id" class="form-control m-b">
                @foreach ($issue_efforts as $effort)
                <option value="{{$effort->id}}">{{$effort->title}}</option>
                @endforeach
            </select>
        </div>
    </div>
    <div class="hr-line-dashed"></div>
    <div class="form-group">
        <label class="col-sm-12">{{trans('Assigned to')}}</label>
        <div class="col-sm-12">
            @include('partials.select-issue-assigned')
        </div>
    </div>
    <div class="hr-line-dashed"></div>
    <div class="form-group">
        <label class="col-sm-3 control-label">{{trans('Planning Pocker')}}</label>
        <div class="col-sm-9">
            <div class="i-checks"><input type="checkbox" value="" checked=""> <i></i></div>
            <span class="help-block m-b-none">{{trans('Collaborative Estimation')}}</span>
        </div>
    </div>
    <div class="hr-line-dashed"></div>
    @include('partials.includes.form-btn-submit', ['action' => @$action])
</form>

<script>
$(function(){
    $('[data-provide="markdown"]').markdown({autofocus:false,savable:false})
})
</script>
