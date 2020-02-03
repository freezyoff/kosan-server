@component('mail::message')
# Atur Ulang Sandi

Kami menerima permintaan pengaturan ulang sandi. Tombol dan link berikut mengarahkan laman ke pengaturan ulang sandi:
@component('mail::button', ['url' => route('web.service.auth.reset', ['token'=>$token])])
Atur ulang sandi
@endcomponent

@component('mail::panel')
<div>
	<span>Atur ulang sandi : </span>
	<span>{{ route('web.service.auth.reset', ['token'=>$token]) }}</span>
</div>
@endcomponent

Jika and tidak merasa mengajukan permintaan ulang sandi, Abaikan email ini. Tetap gunakan sandi lama untuk masuk ke laman Dashboard Kosan!

Warm Regard,<br>
<b>Team {{ config('app.name') }}</b>
@endcomponent