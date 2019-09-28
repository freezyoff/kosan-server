@component('mail::message')
# Terimakasih {{$name}}, telah bergabung dengan Kosan!

Informasi akses Dashboard kamu sebagai berikut:
@component('mail::panel')
Username: {{$email}} <br>
Password: {{$password}}
@endcomponent

Segera aktivasi email kamu untuk menjangkau seluruh fitur layanan Kosan!
Berikut kode aktivasi email:
@component('mail::panel')
{{$token}}
@endcomponent


Terimakasih telah bergabung,<br>
{{ config('app.name') }}
@endcomponent
