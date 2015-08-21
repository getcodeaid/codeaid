@extends('_layout')

@section('title')
    Create Snip
@stop

@section('content')
        <div class="row">
            <div class="alert alert-danger" style="display: none;" id="errors">

            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <input type="text" class="form-control input-lg" name="title" id="field-title" placeholder="Name your Snip" autofocus required>
                <hr>
            </div>
        </div>
        <div class="row">
            <div class="col-md-8">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h2 class="panel-title">Code</h2>
                    </div>
                    <div class="panel-body">
                        <div id="editor"></div>
                    </div>
                    <div class="panel-footer">
                        <p class="help-block">You can customise the editor <a href="/preferences" target="_blank">in your preferences</a>.</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h2 class="panel-title">About</h2>
                    </div>
                    <div class="panel-body">
                        <div class="form-group">
                            <select class="form-control" id="field-language">
                                <option selected disabled>Select Language</option>
                                <option value="1" data-ace-name="python" >Python</option>
                                <option value="2" data-ace-name="javascript">JavaScript</option>
                                <option>4</option>
                                <option>5</option>
                            </select>
                        </div>
                        <select class="form-control" id="field-category">
                            <option selected disabled>Select Category</option>
                            <option value="1">Help Needed</option>
                            <option value="2">Tutorial</option>
                        </select>
                        <hr>
                        <div class="form-group">
                            <label for="description">Describe your Snip</label>
                            <textarea name="description" id="field-message" class="form-control" rows="10"></textarea>
                            <p class="help-block">If there's something wrong with your code, say what</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-1"></div>
            <div class="col-md-10">
                <button type="button" class="btn btn-primary btn-lg btn-block" id="snipcreatebutton"><i class="fa fa-plus"></i> Create</button>
            </div>
        </div>
        {{ csrf_field() }}
@stop

@section('custom_scripts')
    <script src="//cdnjs.cloudflare.com/ajax/libs/ace/1.2.0/ace.js" type="text/javascript"></script>
@stop