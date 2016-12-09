@if($issue->commits->count())
<small title="{{_('Commits')}}"><i class="fa fa-code" aria-hidden="true"></i> {{$issue->commits->count()}}</small>
&nbsp;&nbsp;
@endif

@if($issue->comments->count())
<small title="{{_('Comments')}}"><i class="fa fa-comment-o" aria-hidden="true"></i> {{$issue->comments->count()}}</small>
&nbsp;&nbsp;
@endif

@if($issue->attachments->count())
<small title="{{_('Attachments')}}"><i class="fa fa-file-o" aria-hidden="true"></i> {{$issue->attachments->count()}}</small>
&nbsp;&nbsp;
@endif

@if($issue->effort)
<small title="{{_('Effort')}}"><i class="fa fa-tachometer" aria-hidden="true"></i> {{$issue->effort}}</small>
@endif

@if($issue->closed_at)
<small title="{{_('Closed')}}" class="small-issue-closed">{{_('closed')}} {{$issue->dateforhumans('closed_at')}}</small>
&nbsp;&nbsp;
@endif
