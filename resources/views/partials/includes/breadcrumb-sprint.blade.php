@if(isset($obj->slug))
<a href="{{route('product_backlogs.show', ['slug'=>$obj->productBacklog->slug])}}">{{trans('Product Backlog')}}</a> &raquo;
<a href="{{route('sprints.show', ['slug'=>$obj->slug])}}">{{trans('Sprint Backlog')}}</a> &raquo;
@endif
