
<div class="col-sm-3 sidebar-offcanvas" id="sidebar">
    <div class="box box-solid sidebar-module">
        <h2><i class="fa fa-list"></i> @lang('view.Posts')</h2>
        @foreach($posts as $pt)
            <a href="{{ route('index.post',$pt->id) }}"
               class="list-group-item {{ $pt->id==$id?'active':'' }}" >{{ $pt->title }}</a>
        @endforeach
        {!! $posts->render() !!}
    </div>
</div>
