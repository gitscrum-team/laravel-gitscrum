<form action="{{route($route, ['slug'=>@$productBacklog->slug])}}" method="post" class="form-horizontal">
    {{ csrf_field() }}
    <input type="hidden" name="is_api" value="1" />
    <div class="form-group">
        <label class="col-sm-12">{{_('Organization')}}</label>
        <div class="col-sm-12">
            @if(isset($productBacklog->organization_id))
                <input type="hidden" name="organization_id" value="{{$productBacklog->organization->id}}" />
                <strong>{{$productBacklog->organization->title}}</strong>
            @else
            <select name="organization_id" class="form-control m-b">
                @foreach (Auth::user()->organizations as $organization)
                <option value="{{$organization->id}}">{{$organization->title}}</option>
                @endforeach
            </select>
            @endif
        </div>
    </div>
    <div class="hr-line-dashed"></div>
    <div class="form-group">
        <label class="col-sm-12">{{_('Title')}}</label>
        <div class="col-sm-12">
            <input name="title" type="text" class="form-control" value="{{ @$productBacklog->title }}"
                pattern=".{2,255}" title="{{_('Title must be between 2 and 255 characters')}}"
                autocomplete="off" maxlength="255" required>
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-12">{{_('Description')}}</label>
        <div class="col-sm-12">
            <textarea name="description" type="text" class="form-control">{{ @$productBacklog->description }}</textarea>
            <span class="help-block m-b-none">A block of help text that breaks onto a new line and may extend beyond one line.</span>
        </div>
    </div>
    <div class="hr-line-dashed"></div>
    @include('partials.includes.form-btn-submit', ['action' => @$action])
</form>
