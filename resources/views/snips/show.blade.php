@extends('_layout')

@section('title')
    {{ $thread->title }}
@stop

@section('content')
    <div class="page-header">
        <h1>{{ $thread->title }} <small> {!!  $thread->badges() !!}  by <a href="/u/{{ $thread->firstPost()->owner->slug }}">{{ $thread->firstPost()->owner->name }}</a></small></h1>
    </div>

    @foreach ($thread->replies as $reply)
        <div class="row">
            <div class="col-md-1">
                <img src="{{ $reply->owner->avatar() }}" alt="User Avatar" class="img-circle">
            </div>
            <div class="col-md-11">
                <div class="panel panel-default">
                    <div class="panel-body">
                        <a href="/u/{{ $thread->firstPost()->owner->slug }}"><p class="text-muted">by {{ $reply->owner->name }} {{ $reply->created_at->diffForHumans() }}</p></a>
                        <p>{{ $reply->message }}</p>
                        @if($reply->code != null)
                            <pre><code class="{{ $thread->language->highlighter_name }}">{{ $reply->code }}</code></pre>
                        @endif
                    </div>
                </div>
            </div>
        </div>

    @endforeach
    <div class="row">
        <div class="col-md-2"></div>
        <div class="col-md-4">
            <button class="btn btn-primary btn-block btn-lg"><i class="fa fa-commenting"></i> New Comment</button>
        </div>
        <div class="col-md-4">
            <button class="btn btn-primary btn-block btn-lg"><i class="fa fa-pencil"></i> Create Modification</button>
        </div>
    </div>
@stop