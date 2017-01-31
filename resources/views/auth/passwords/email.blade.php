@extends('layouts.application_full')

@section('content_full')
    <div id="container" class="force-fullwidth">
        <div id="primary">
            <div class="posts">
                <div id="post-9" class="post post-9 page type-page status-publish hentry">
                    <div class="post-inner">
                        <form method="POST" action="{{ url('/password/email') }}" class="login-form">
                            {{ csrf_field() }}

                            <div class="form-group">
                                <label for="login-form-username">E-Mail Address</label>
                                <input id="login-form-username" type="email" name="email" class="form-control" required="required">
                            </div>

                            @if ($errors->has('email'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('email') }}</strong>
                                </span>
                            @endif

                            @if (session('status'))
                                <div class="alert alert-success">
                                    {{ session('status') }}
                                </div>
                            @endif

                            <button type="submit" name="login_form" class="button">Reset Password</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
