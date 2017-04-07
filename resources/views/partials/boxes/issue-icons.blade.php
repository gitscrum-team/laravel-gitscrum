<span class="issue-icons">
@if($issue->commits->count())
<small title="{{trans('gitscrum.commits')}}"><i class="fa fa-code" aria-hidden="true"></i> {{$issue->commits->count()
}}</small>
&nbsp;&nbsp;
@endif

@if($issue->comments->count())
<small title="{{trans('gitscrum.comments')}}"><i class="fa fa-comment-o" aria-hidden="true"></i>
    {{$issue->comments->count()
}}</small>
&nbsp;&nbsp;
@endif

@if($issue->attachments->count())
<small title="{{trans('gitscrum.attachments')}}"><i class="fa fa-file-o" aria-hidden="true"></i>
    {{$issue->attachments->count()}}</small>
&nbsp;&nbsp;
@endif

@if($issue->effort)
<small title="{{trans('gitscrum.effort')}}"><i class="fa fa-tachometer" aria-hidden="true"></i>
    {{$issue->effort}}</small>
@endif

@if($issue->closed_at)
<small title="{{trans('gitscrum.closed')}}" class="small-issue-closed">{{trans('gitscrum.closed')}}
    {{$issue->dateforHumans
('closed_at')}}</small>
&nbsp;&nbsp;
@endif
</span>
