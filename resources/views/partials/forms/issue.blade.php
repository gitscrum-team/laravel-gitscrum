<form id="storeIssueForm" action="{{route($route, ['slug'=>@$issue->slug])}}" method="post" class="form-horizontal">
    {{ csrf_field() }}
    <input type="hidden" name="product_backlog_id" value="{{$obj->productBacklog->id or $issue->productBacklog->id}}">

    @if($relation == 'user_stories')
    <input type="hidden" name="user_story_id" value="{{$obj->id}}">
    @endif

    @if(!is_null($obj->user_story_id))
    <div class="form-group">
        <label class="col-sm-12 mbn pbn">{{trans('gitscrum.user-story')}}</label>
        <div class="col-sm-12">
                <a href="{{route('user_stories.show', ['slug' => $obj->userStory->slug])}}"
                    target="_blank" class="text-success">
            {{$obj->userStory->title}}</a></div>
    </div>
    <div class="hr-line-dashed"></div>
    @endif

    <div class="form-group">
        <label class="col-sm-12">{{trans('gitscrum.sprint-backlog')}}</label>
        <div class="col-sm-12">
            @if( $obj->productBacklog->sprints()->count() )
            <select name="sprint_id" class="form-control">
                @foreach ($obj->productBacklog->sprints()->get() as $sprint)
                    <option 
                    	@if(isset($issue->sprint_id) && $issue->sprint_id == $sprint->id) selected="selected" 
                    	@elseif(isset($obj->id) && $obj->id == $sprint->id) selected = "selected"
                    	@endif
                        value="{{$sprint->id}}">{{$sprint->title}} - {{$sprint->timebox}}</option>
                @endforeach
            </select>
            @else
                {{trans('gitscrum.create-a-sprint')}}
            @endif
        </div>
    </div>
    <div class="hr-line-dashed"></div>

    @if ( isset($parent_id) )
    <input type="hidden" name="parent_id" value="{{$parent_id}}">
    @endif

    <div class="form-group">
        <label class="col-sm-12">{{trans('gitscrum.type')}}</label>
        <div class="col-sm-12">
            <select name="issue_type_id" class="form-control">
                @foreach (Helper::issueTypes() as $type)
                <option value="{{$type->id}}" @if( isset($issue->type) && $issue->type->id == $type->id )
                    selected="selected" @endif >{{$type->title}}</option>
                @endforeach
            </select>
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-12">{{trans('gitscrum.issue')}}</label>
        <div class="col-sm-12">
            <input name="title" type="text" class="form-control" value="{{ $issue->title or '' }}"
                pattern=".{2,255}" title="{{trans('gitscrum.title-must-be-between-2-and-255-characters')}}"
                autocomplete="off" maxlength="255" required>
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-12">{{trans('gitscrum.description')}} ({{trans('gitscrum.optional')}})</label>
        <div class="col-sm-12">
            <textarea name="description" class="form-control" data-provide="markdown" style="padding:10px;">{{ $issue->markdownDescription or '' }}</textarea>
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-12">{{trans('gitscrum.avg-effort')}}</label>
        <div class="col-sm-12">
            <select name="config_issue_effort_id" class="form-control m-b">
                @foreach (Helper::issueEfforts() as $effort)
                <option value="{{$effort->id}}"  @if( isset($issue->config_issue_effort_id) && $issue->config_issue_effort_id == $effort->id )
                    selected="selected" @endif>{{$effort->title}}</option>
                @endforeach
            </select>
        </div>
    </div>
    <div class="hr-line-dashed"></div>
    <div class="form-group">
        <label class="col-sm-12">{{trans('gitscrum.assigned-to')}}</label>
        <div class="col-sm-12">
            @include('partials.select-issue-assigned', ['users' => $organization->users])
        </div>
    </div>
    <div class="hr-line-dashed"></div>
    <div class="form-group">
        <label class="col-sm-2">{{trans('gitscrum.planning-pocker')}}</label>
        <div class="col-sm-3">
            <div class="i-checks"><input type="checkbox" value="" checked=""> <i></i></div>
            <span class="help-block m-b-none">{{trans('gitscrum.collaborative-estimation')}}</span>
        </div>
        <div class="col-sm-3"></div>
        <label class="col-sm-2">{{trans('gitscrum.keep-adding')}}</label>
        <div class="col-sm-2">
            <div class="i-checks"><input id="keepAddingIssue" type="checkbox" value="" checked=""> <i></i></div>
        </div>
    </div>
    <div class="hr-line-dashed"></div>
    <div id="issueModalMessage" style="display: none;"  class="alert alert-success">

    </div>
    @include('partials.includes.form-btn-submit', ['action' => @$action])
</form>

<script>
$(function(){
    $('[data-provide="markdown"]').markdown({autofocus:false,savable:false});

    $( "#storeIssueForm" ).on('submit',function( event ) {

        if (!$('#keepAddingIssue').is(':checked'))
        {
            $(this).submit();
        }

        event.preventDefault();

        $.ajax({
            'url' : $(this).attr('action'),
            'method' : 'POST',
            'data' : $(this).serialize(),
            'success' : function (response) {

                for(classSelector in response.data)
                {
                    $('.'+classSelector).html(response.data[classSelector]);
                }

                $('#storeIssueForm').find("input[type=text], textarea").val("");

                $('#issueModalMessage').show().text('').attr('class','alert alert-success').text(response.message);
            },
            'error' : function(response){

                errorMessages = [];

                for (errorKey in response.responseJSON)
                {
                    errorMessages.push(response.responseJSON[errorKey]);
                }

                $('#issueModalMessage').show().text('').attr('class','alert alert-danger').text(errorMessages.join(' , '));
            }
        });

    });
});
</script>
