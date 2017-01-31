@extends('layouts.application_full')

@section('content_full')
    <div id="container" class="force-fullwidth">
        <div id="primary">
            <div class="posts">
                <div id="post-9" class="post post-9 page type-page status-publish hentry">
                    <div class="post-inner">
                        <form method="POST" action="{{ url('/password/reset') }}" class="login-form">
                            {{ csrf_field() }}
                            <input type="hidden" name="token" value="{{ $token }}" />

                            <div class="form-group">
                                <label for="email">E-Mail Address</label>
                                <input id="email" type="email" name="email" class="form-control" required="required">
                            </div>

                            <div class="form-group">
                                <label for="password">Password</label>
                                <input id="password" type="password" name="password" class="form-control" required="required">
                            </div>

                            <div class="form-group">
                                <label for="password_confirmation">Password Confirmation</label>
                                <input id="password_confirmation" type="password" name="password_confirmation" class="form-control" required="required">
                            </div>

                            @if ($errors->has('email') || $errors->has('password') || $errors->has('password_confirmation'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('email') }}</strong>
                                    <strong>{{ $errors->first('password') }}</strong>
                                    <strong>{{ $errors->first('password_confirmation') }}</strong>
                                </span>
                            @endif

                            @if (session('status'))
                                <div class="alert alert-success">
                                    {{ session('status') }}
                                </div>
                            @endif

                            <button type="submit" name="login_form" class="button">Change Password</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
