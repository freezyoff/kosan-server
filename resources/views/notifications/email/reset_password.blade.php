@component('mail::message')
# Mengatur Ulang Sandi

Kami menerima permintaan pengaturan ulang sandi. Berikut sandi sementara untuk masuk ke laman Dashboard Kosan:
@component('mail::panel')
{{$password}}
@endcomponent

Jika {{$name}} tidak merasa mengajukan permintaan ulang sandi, Abaikan email ini. Tetap gunakan sandi lama untuk masuk ke laman Dashboard Kosan!

Terimakaih,<br>
{{ config('app.name') }}
@endcomponent
