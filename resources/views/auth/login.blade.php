@extends('layouts.application_full')

@section('content_full')
<div id="container" class="force-fullwidth">
  <div id="primary">
    <div class="posts">
      <div id="post-9" class="post post-9 page type-page status-publish hentry">
        <div class="post-inner">
          <form method="POST" action="{{ url('/login') }}" class="login-form">
            {{ csrf_field() }}
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
    <div class="form-group terms-conditions-input">
      <div class="checkbox">
        <label for="register-form-conditions">
          <div class="ez-checkbox ez-checked">
            <input id="register-form-conditions" type="checkbox" name="remember" class="ez-hide" checked="" />
        </div>
        <span>Remember Me
        </span>
    </label>
</div>
</div>
<div class="form-group">
    <div class="foot-lnk">
    <a href="{{ url('/password/reset') }}">Forgot Password?</a>
</div>
</div>
<button type="submit" name="login_form" class="button">Log in
</button>
</form>

</div>
</div>
</div>
</div>
</div>
@endsection
