@extends('layouts.application_full')

@section('content_full')
<div id="container" class="force-fullwidth">
  <div id="primary">
    <div class="posts">
      <div id="post-9" class="post post-9 page type-page status-publish hentry">
        <div class="post-inner">
          <form method="POST" action="{{ url('/register') }}" class="login-form">
            {{ csrf_field() }}
            <div class="form-group">
             @if ($errors->has('name'))
             <span class="help-block">
                <strong>{{ $errors->first('name') }}</strong>
            </span>
            @endif
            <label for="username">Username
            </label>
            <input id="username" type="text" name="name" class="form-control" required="required">
        </div>

            <div class="form-group">
             @if ($errors->has('email'))
             <span class="help-block">
                <strong>{{ $errors->first('email') }}</strong>
            </span>
            @endif
            <label for="login-form-username">E-Mail Address
            </label>
            <input id="login-form-username" type="email" name="email" class="form-control" required="required">
        </div>
        <div class="form-group">
         @if ($errors->has('password'))
         <span class="help-block">
            <strong>{{ $errors->first('password') }}</strong>
        </span>
        @endif
        <label for="login-form-password">Password
        </label>
        <input id="login-form-password" type="password" name="password" class="form-control" required="required">
    </div>

      <div class="form-group">
         @if ($errors->has('password_confirmation'))
         <span class="help-block">
            <strong>{{ $errors->first('password_confirmation') }}</strong>
        </span>
        @endif
        <label for="login-form-password-c">Password Confirmation
        </label>
        <input id="login-form-password-c" type="password" name="password_confirmation" class="form-control" required="required">
    </div>
<button type="submit" name="login_form" class="button">Register
</button>
</form>
</div>
</div>
</div>
</div>
</div>
@endsection
