@component('mail::message')
# Registerasi Akun
Kepada Bpk/Ibu {{ucfirst($name)}}

Terimakasih telah bergabung dengan Kosan.
Berikut informasi Akun anda:
@component('mail::panel')
<div>
	<span style="width:5rem;display:inline-block;font-weight:600">Username</span>
	<span style="margin-left:4px">: {{$email}}</span>
</div>
<div>&nbsp;</div>
<div>
	<span style="width:5rem;display:inline-block;font-weight:600">Password</span>
	<span style="margin-left:4px">: {{$password}}</span>
</div>
@endcomponent

@if (!isset($activationToken) || !$activationToken)
Segera Aktivasi Akun dengan klik Tombol Aktivasi. Apabila Tombol Aktivasi tidak mengarahkan adan ke laman Aktivasi, gunakan Link Aktivasi untuk mengarahkan laman.
Untuk Aktivasi Akun,  dengan mengunjungi laman berikut:

@component('mail::button', ['url' => route('web.service.auth.activation',['token'=>$activationToken])])
Ke laman Aktivasi Akun
@endcomponent

@component('mail::panel')
<div>
	<span>Link Aktivasi : </span>
	<span>{{ route('web.service.auth.activation',['token'=>$activationToken]) }}</span>
</div>
@endcomponent
@endif

Segera kunjungi laman Dashboard. Klik tombol / link dibawah ini untuk mengarahkan.
@component('mail::button', ['url' => route('web.my.dashboard')])
Ke laman Dashboard
@endcomponent

@component('mail::panel')
<div>
	<span>Ke laman Dashboard : </span>
	<span>{{ route('web.my.dashboard') }}</span>
</div>
@endcomponent

Warm Regard,<br>
<b>Team {{ config('app.name') }}</b>
@endcomponent
