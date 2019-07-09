 <!DOCTYPE html>
<html>
@include('layouts/partials/_head')

<body class="hold-transition login-page">
<div class="login-box">
  <div class="login-logo">
    <img src="{{ asset('image/logo.png') }}" alt="" style="width: 15%" >
    <u><b>OneCare</b></u><span style="font-size: 75%">Indonesia</span>
    <div style="font-size: 40%;margin-top: -4%;margin-left: -12%;">One Heart One Solutin</div>
  </div>
  <!-- /.login-logo -->
  <div class="login-box-body">
    <p class="login-box-msg">Reset Password</p>

   <form method="POST" action="{{ route('password.request') }}">
         @csrf
       <input type="hidden" name="token" value="{{ $token }}">

      <div class="form-group has-feedback">
        <input id="email" type="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ old('email') }}" placeholder="Email" required autofocus >
        <span class="glyphicon glyphicon-envelope form-control-feedback"></span>

        @if ($errors->has('email'))
              <span class="invalid-feedback text-center" style="color: red">
                <strong>{{ $errors->first('email') }}</strong>
            </span>
        @endif
      </div>
      <div class="form-group has-feedback">
         <input id="password" type="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password" required placeholder="Password">
        <span class="glyphicon glyphicon-lock form-control-feedback"></span>
        @if ($errors->has('password'))
            <span class="invalid-feedback text-center" style="color: red">
                <strong>{{ $errors->first('password') }}</strong>
            </span>
        @endif
      </div>      
      <div class="form-group has-feedback">
         <input id="password-confirm" type="password" class="form-control{{ $errors->has('password_confirmation') ? ' is-invalid' : '' }}" name="password_confirmation" required placeholder=" Confirm Password">
        <span class="glyphicon glyphicon-lock form-control-feedback"></span>
        @if ($errors->has('password_confirmation'))
            <span class="invalid-feedback text-center" style="color: red">
                <strong>{{ $errors->first('password_confirmation') }}</strong>
            </span>
        @endif
      </div>

      <div class="row">
         <div class="col-xs-4 col-xs-offset-8">
          <button type="submit" class="btn btn-info btn-sm btn-flat pull-right">Reset Password 
        </div>
      </div>
    </form>

  </div>
  <!-- /.login-box-body -->
<br>
<p class="text-center">©2018-OneCareIndonesia </p>

</div>
<!-- /.login-box -->



@include('layouts/partials/_script')

</body>
</html>