@extends('_layout')

@section('title')
    Reset Password
@stop

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-6 col-md-offset-3">
                <div class="panel panel-login">
                    <div class="panel-heading">
                        <div class="row">
                            <div class="col-xs-12">
                                <h3 id="login-form-link">Forgot Password?</h3>
                            </div>
                        </div>
                        <hr>
                    </div>
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-lg-12">
                                <form id="login-form" action="/password/email" method="post" role="form">
                                    {!! csrf_field() !!}
                                    @include('_formerrors')
                                    <div class="form-group">
                                        <input type="text" name="email" id="email" tabindex="1" class="form-control" placeholder="Email" value="">
                                    </div>
                                    <div class="form-group">
                                        <div class="row">
                                            <div class="col-sm-6 col-sm-offset-3">
                                                <input type="submit" name="login-submit" id="login-submit" tabindex="2" class="form-control btn btn-login" value="Send Reminder">
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop

@section('custom_scripts')
    @if(Session::has('status'))
        <script type="text/javascript">
            swal({
                title: "Sent!",
                text: "Your reset email has been sent!",
                type: "success",
                showConfirmButton: false
            });
        </script>
    @endif
@stop