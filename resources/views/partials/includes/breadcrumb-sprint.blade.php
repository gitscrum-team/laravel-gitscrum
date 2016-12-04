@if(isset($obj->slug))
<a href="{{route('product_backlogs.show', ['slug'=>$obj->productBacklog->slug])}}">{{_('Product Backlog')}}</a> &raquo;
<a href="{{route('sprints.show', ['slug'=>$obj->slug])}}">{{_('Sprint Backlog')}}</a> &raquo;
@endif
