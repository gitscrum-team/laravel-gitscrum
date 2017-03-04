@if(isset($obj->slug))
<a href="{{route('product_backlogs.show', ['slug'=>$obj->productBacklog->slug])}}">{{trans('gitscrum.product-backlog')}}</a> &raquo;
<a href="{{route('sprints.show', ['slug'=>$obj->slug])}}">{{trans('gitscrum.sprint-backlog')}}</a> &raquo;
@endif
