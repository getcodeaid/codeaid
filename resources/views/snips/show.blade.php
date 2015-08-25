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
                <div class="row">
                    <img src="{{ $reply->owner->avatar() }}" alt="User Avatar" class="img-circle img-responsive avatar">
                </div>
                <div class="row">
                    <h3 class="text-center"><a href="/vote/{{ $reply->id }}/up"><i class="fa fa-angle-up text-success"></i></a> 12 <a href="/vote/{{ $reply->id }}/down"><i class="fa fa-angle-down"></i></a></h3>
                </div>
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
            <button class="btn btn-primary btn-block btn-lg" id="btn-comment"><i class="fa fa-commenting"></i> Comment</button>
        </div>
        <div class="col-md-4">
            <button class="btn btn-primary btn-block btn-lg" id="btn-modification"><i class="fa fa-pencil"></i> Modify</button>
        </div>
    </div>
    <br>
    <div class="row">
        <div class="col-md-2"></div>
        <div class="col-md-8">
            <div class="panel panel-default" id="panel-comment" style="display:none;">
                <div class="panel-heading">
                    Comment
                </div>
                <div class="panel-body">
                    <p>Comment</p>
                </div>
            </div>
            <div class="panel panel-default" id="panel-modification" style="display:none;">
                <div class="panel-heading">
                    Suggest Modification
                </div>
                <div class="panel-body">
                    <div id="editor"></div>
                    <hr>
                    <div class="form-group">
                        <label for="inputEmail3" class="col-sm-2 control-label">Message</label>
                        <textarea id="field-message" class="form-control" rows="3"></textarea>
                        <p class="help-block">A brief summary of what you changed</p>
                    </div>
                    <button class="btn btn-primary btn-block" id="submitModificationButton"><i class="fa fa-plus"></i> Create</button>
                </div>
            </div>
        </div>
    </div>
@stop

@section('custom_scripts')
    <script src="//cdnjs.cloudflare.com/ajax/libs/ace/1.2.0/ace.js" type="text/javascript"></script>
    <script src="{{ elixir('js/showSnip.js') }}" type="text/javascript"></script>
@stop