<div class="col-lg-8">

    <div class="ibox">

        <div class="ibox-content">

            <form action="{{route($route, ['slug'=>@$issue->slug])}}" method="post" class="form-horizontal">
                {{ csrf_field() }}

                @if ( isset($userStory) )
                <input type="hidden" name="user_story_id" value="{{$userStory->id}}">
                <div class="form-group">
                    <label class="col-sm-3 control-label">{{_('User Story')}}</label>
                    <div class="col-sm-9"><h3><a href="{{route('user_stories.show', ['slug' => $userStory->slug])}}"
                        target="_blank" class="text-success">{{$userStory->title}}</a></h3></div>
                </div>
                <div class="hr-line-dashed"></div>
                @endif

                @if ( isset($productBacklogs) )
                <div class="form-group">
                    <label class="col-sm-3 control-label">{{_('Sprint')}}</label>
                    <div class="col-sm-9">
                        <select name="sprint_id" class="form-control">
                            @foreach ($productBacklogs as $backlog)

                                @if ( $backlog->sprints->count() )
                                <optgroup label="{{$backlog->title}}">
                                @endif

                                @foreach ($backlog->sprints as $productBacklog_sprint)
                                <option value="{{$backlog->id}}">{{$productBacklog_sprint->title}}</option>
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
                    <label class="col-sm-3 control-label">{{_('Type')}}</label>
                    <div class="col-sm-9">
                        <select name="issue_type_id" class="form-control">
                            @foreach ($issue_types as $type)
                            <option value="{{$type->id}}">{{$type->title}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="hr-line-dashed"></div>
                <div class="form-group">
                    <label class="col-sm-3 control-label">{{_('Title')}}</label>
                    <div class="col-sm-9">
                        <input name="title" type="text" class="form-control" value="{{ $issue->title or '' }}" required>
                    </div>
                </div>
                <div class="hr-line-dashed"></div>
                <div class="form-group">
                    <label class="col-sm-3 control-label">{{_('Description')}}</label>
                    <div class="col-sm-9">
                        <textarea name="description" type="text" class="form-control" required>{{ $issue->description or '' }}</textarea>
                    </div>
                </div>
                <div class="hr-line-dashed"></div>
                <div class="form-group">
                    <label class="col-sm-3 control-label">{{_('Avg Effort')}}</label>
                    <div class="col-sm-9">
                        <select name="issue_effort_id" class="form-control m-b">
                            @foreach ($issue_efforts as $effort)
                            <option value="{{$effort->id}}">{{$effort->title}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="hr-line-dashed"></div>
                <div class="form-group">
                    <label class="col-sm-3 control-label">{{_('Assigned to')}}</label>
                    <div class="col-sm-9">
                        @include('partials.select-issue-assigned')
                    </div>
                </div>
                <div class="hr-line-dashed"></div>
                <div class="form-group">
                    <label class="col-sm-3 control-label">{{_('Planning Pocker')}}</label>
                    <div class="col-sm-9">
                        <div class="i-checks"><input type="checkbox" value="" checked=""> <i></i></div>
                        <span class="help-block m-b-none">{{_('Collaborative Estimation')}}</span>
                    </div>
                </div>
                <div class="hr-line-dashed"></div>
                @include('partials.includes.form-btn-submit', ['action' => @$action])
            </form>

        </div>
    </div>
</div>
