@extends('blogs.app')

@section('css')
    <title>{{ $post->title }} - @lang('view.Posts')</title>
    <link rel="stylesheet" href="{{ URL::asset('vendor/side-comments/side-comments.css') }}">
    <link rel="stylesheet" href="{{ URL::asset('vendor/side-comments/themes/default-theme.css') }}">
@endsection


@section('menus')
@if(Auth::id()==$post->user_id)
    <a class="blog-nav-item" href="{{ route('tasks.edit',$id) }}">
        <b>@lang('view.Edit')</b>
    </a>
@endif
@endsection

@section('content')
    <div class="row">
        <div class="col-sm-9 container commentable-container" id="commentable-container" >
            <h2 class="blog-post-title commentable-section" data-section-id="{{ $post->id }}" >{{ $post->title }}</h2>
            <p class="blog-post-meta" >{{ $post->created_at }} by
                <a href="{{ route('index.user',$post->user_id) }}">{{ @$userresume['name'] }}</a></p>
            <div class="box">
                <ul class="tags" id="tags">
                    @foreach($post->tags as $tag)
                    <li class="tag{{ $tag->id }}"><a href="{{ route('index.tag',['price',$tag->id]) }}">{{ $tag->topic }}</a>
                        @if(Auth::check())
                        <i class="removetag fa fa-times" onclick="remove_tag({{ $tag->id }})"></i>
                        @endif
                    </li>
                    @endforeach
                </ul>
                @if(Auth::check())
                <span class="add_tag" ><a href="javascript:$('.tag_select').toggle()"><i class="fa fa-plus fa-1x"></i> @lang('view.Tag')</a>
                    <div class="tag_select" >{!! Form::select('tag',[0=>trans('view.Enter Tags')],  0, ['class' => 'select2-ajax-tag form-control','onchange'=>"add_tag($(this).val())"]) !!}</div>
                </span>
                @endif
                {!! $post->content !!}
            </div>
        </div>
        @include('blogs.posts')
        <div class="col-md-3 blog-sidebar">
            <div class="sidebar-module sidebar-module-inset">
                <h4>@lang('view.Tag')</h4>
                {!! $tagHtml !!}
            </div>
        </div>
    </div>
    @include('blogs.about')
@endsection

@section('scripts')
<script src="{{ URL::asset('vendor/side-comments/side-comments.js') }}"></script>
<script type="text/javascript">
    select2(".select2-ajax-tag", "/tasks/tagajax",true);

    var tags = Object.keys({!! json_encode(array_column($post->tags->toArray(),'topic','id')) !!});
    function add_tag(id){
        if ($.inArray(id,tags)<0){
            $.ajax({
                url: '{{ url('tasks/tagcreateajax') }}/{{ $post->id }}/'+id,
                error: function(XMLHttpRequest, textStatus, errorThrown) {
                    alert(errorThrown);
                },
                success: function(doc) {
//                    console.log(doc);
                    if (doc){
                        var removeable = '';
                        @if(Auth::check())
                            removeable = '<i class="removetag fa fa-times" onclick="remove_tag()"></i>';
                        @endif
                        $('#tags').append('<li class="tag'+ doc.id +'"><a href="{{ url('tag') }}/'+ doc.id +'">'+ doc.topic +'</a>'+removeable+'</li>');
                    }
                }
            });
        }
    }
    function remove_tag(id){
        $.ajax({
            url: '{{ url('tasks/tagremoveajax') }}/{{ $post->id }}/'+id,
            error: function(XMLHttpRequest, textStatus, errorThrown) {
                alert(errorThrown);
            },
            success: function(doc) {
//                    console.log(doc);
                if (doc){
                    $('.tag'+ doc).remove();
                }
            }
        });
    }

    $(document).ready(function(){
        $.ajax({
            url: '{{ route('tasks.showcomment',$post->id) }}',
            type: 'GET',
            success: function( data ) {
                var existingComments = [
                    {
                        "sectionId": "{{ $post->id }}",
                        "comments": data
                    }
                ];
                var currentUser = {
                    "id": {{ \Auth::id() }},
                    "avatarUrl": "/images/blue_logo_150x150.jpg",
                    "authorUrl": "{{ route('index.user',\Auth::id()) }}",
                    "name": "{{ \Auth::id() ? \Auth::user()->name : '' }}"
                };
                var SideComments = require('side-comments');
                window.sideComments = new SideComments('#commentable-container', currentUser, existingComments);
                window.sideComments.on('commentPosted', function( comment ) {
                    $.ajax({
                        url: '{{ route('tasks.createcomment') }}',
                        type: 'POST',
                        data: comment,
                        success: function( savedComment ) {
//                            console.log(savedComment,comment);
                            sideComments.insertComment(savedComment);
                        }
                    });
                });
                window.sideComments.on('commentDeleted', function( comment ) {
                    $.ajax({
                        url: '{{ route('tasks.createcomment') }}/delete/' + comment.id,
                        type: 'DELETE',
                        success: function( success ) {
                            sideComments.removeComment(comment.sectionId, comment.id);
                        }
                    });
                });
            }
        });

    });

</script>
@endsection