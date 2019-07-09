@component('mail::message')

# Aktivasi account

Silahkan Klik tombol Aktivasi, untuk mengaktifkan account (email) anda.

@component('mail::button', ['url' => route('auth.activate',[
								'token'=> $user->activation_token,
								'email'=>$user->email
								])
					])
Aktivasi
@endcomponent

Terimakasih,<br>
  <div class="login-logo">
    <img src="{{ asset('image/logo.png') }}" alt="" style="width: 15%" >
    <u><b>OneCare</b></u><span style="font-size: 75%">Indonesia</span>
    <div style="font-size: 40%;margin-top: -4%;margin-left: -12%;">One Heart One Solutin</div>
  </div>
@endcomponent
