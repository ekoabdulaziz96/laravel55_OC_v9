
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
    <p class="login-box-msg">Silahkan masuk terlebih dahulu</p>
    @if (session('success'))
     <div class="alert alert-default  alert-dismissible alert-respon" align="center" style="height: 2%;background-color: #91DC97;color: white">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
        <i class=" fa fa-check"></i><span> {{ session('success') }}</span>
    </div>
    @endif    
    @if (session('warning'))
     <div class="alert alert-default  alert-dismissible alert-respon" align="center" style="height: 2%;background-color: #FCC773;color: white">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
        <i class=" fa fa-check"></i><span> {{ session('warning') }}</span>
    </div>
    @endif
    @if ($errors->has('email'))
              <span class="invalid-feedback text-center" style="color: red">
                <strong>
                  @php
                    if ($errors->first('email')=='These credentials do not match our records.'){
                      echo' <div  align="center" class="alert alert-danger alert-dismissible alert-respon" style="height: 2%;background-color: #EC6868">
                          <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                          <i class=" fa fa-times fa-2x"></i>
                          <span>password salah</span>
                      </div>';
               
                    }else if ($errors->first('email')=='the selected email invalid or you need to active your account'){
                      echo' <div align="center" class="alert alert-danger  alert-dismissible alert-respon" style="height: 2%;background-color: #EC6868">
                          <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                          <i class=" fa fa-times fa-2x"></i>
                          <div>Email yang anda masukkan belum terdaftar atau belum terktivasi. silahkan aktivasi email terlebih dahulu</div>
                      </div>';
                    }else{
                     
                      echo $errors->first('email');
                    }
                  @endphp
                </strong>
            </span>
        @endif

    <form method="POST" action="{{ route('login') }}">
         @csrf
      <div class="form-group has-feedback">
        <input id="email" type="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ old('email') }}" placeholder="Email" required autofocus >
        <span class="glyphicon glyphicon-envelope form-control-feedback"></span>


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
      <div class="row">
        <div class="col-xs-8">
        
        </div>
        <!-- /.col -->
        <div class="col-xs-4">
          <button type="submit" class="btn btn-primary  btn-flat pull-right">Masuk</button>
        </div>
        <!-- /.col -->
      </div>
    </form>
<br>
    <div class="social-auth-links text-center">
      <a href="{{ route('password.request') }}" class="btn btn-danger btn-sm btn-flat" style="width: 100%; margin-bottom: 3px"> 
        <span class="glyphicon glyphicon-2x glyphicon-floppy-remove pull-left"></span> 
        Lupa Password
        <span class="glyphicon glyphicon-2x glyphicon-floppy-remove pull-right"></span>  
      </a>      
      <a href="{{ route('auth.activate.resend') }}" class="btn btn-warning btn-sm btn-flat" style="width: 100%"> 
        <span class="glyphicon  glyphicon-send pull-left"></span> 
        Kirim Ulang Aktivasi Email
        <span class="glyphicon  glyphicon-send pull-right"></span>  
      </a>     

    </div>

  </div>
  <!-- /.login-box-body -->
<br>
<p class="text-center">©2018-OneCareIndonesia </p>

</div>
<!-- /.login-box -->



@include('layouts/partials/_script')
<script type="text/javascript">
  window.setTimeout(function() {
  $(".alert-respon").fadeTo(1000,0).slideUp(500, function(){
      $(this).remove();
  });
  }, 5000);
</script>
</body>
</html>