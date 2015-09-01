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
                    <img src="{{ $reply->owner->avatar() }}" alt="User Avatar" class="img-rounded img-responsive avatar">
                </div>
                @if(Auth::check())
                <div class="row">
                    <h3 class="text-center" id="vote-{{ $reply->id }}"><span class="text-primary vote" data-id="{{ $reply->id }}" data-type="up"><i class="fa fa-angle-up @if($reply->userVote()->type == "+") text-success @endif"></i></span> <span class="score">{{ $reply->voteCount() }}</span> <span class="vote text-primary" data-id="{{ $reply->id }}" data-type="down"><i class="fa fa-angle-down @if($reply->userVote()->type == "-") text-danger @endif"></i></span></h3>
                </div>
                @endif
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
        @if(Auth::check())
        <div class="col-md-4">
            <button class="btn btn-primary btn-block btn-lg" id="btn-comment"><i class="fa fa-commenting"></i> Comment</button>
        </div>
        <div class="col-md-4">
            <button class="btn btn-primary btn-block btn-lg" id="btn-modification"><i class="fa fa-pencil"></i> Modify</button>
        </div>
        @else
        <div class="col-md-8">
            <h3 class="text-center">Want to join the discussion? <a href="{{ action('Auth\AuthController@getLogin') }}">Sign in to CodeAid</a></h3>
        </div>
        @endif
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
                    <textarea id="field-message" rows="3" class="form-control"></textarea>
                    <hr>
                    <button class="btn btn-primary btn-block" id="btn-comment-submit"><i class="fa fa-plus"></i> Create</button>
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
                        <textarea id="field-modification-message" class="form-control" rows="3"></textarea>
                        <p class="help-block">A brief summary of what you changed</p>
                    </div>
                    <hr>
                    <div class="panel panel-info">
                        <div class="panel-heading">
                            When will my changes be accepted?
                        </div>
                        <div class="panel-body">
                            Your changes will be accepted when the author marks them as accepted, or the community votes positively.
                        </div>
                        <div class="panel-footer">
                            <a href="http://help.codeaid.xyz/guide/updating-snips.html" target="_blank">More Details <sup><i class="fa fa-external-link"></i></sup></a>
                        </div>
                    </div>
                    <hr>
                    <button class="btn btn-primary btn-block" id="btn-modification-submit"><i class="fa fa-plus"></i> Create</button>
                </div>
            </div>
        </div>

    </div>
@stop

@section('custom_scripts')
    <script src="//cdnjs.cloudflare.com/ajax/libs/ace/1.2.0/ace.js" type="text/javascript"></script>
    <script src="{{ elixir('js/showSnip.js') }}" type="text/javascript"></script>
    <script>
        editor.getSession().setMode("ace/mode/" + "{{ $thread->language->ace_name }}");
    </script>
@stop