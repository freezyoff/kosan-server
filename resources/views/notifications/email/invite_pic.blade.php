@component('mail::message')
# Penunjukan PIC
Kepada Bpk/Ibu {{ucfirst($picName)}}
Pemilik Kosan <b>{{ucfirst($location->name)}}</b> telah menunjuk anda sebagai PIC (<i>Person In Charge</i>)!

Berikut informasi lokasi Kosan:
@component('mail::panel')
<div>
	<span style="width:6rem;display:inline-block;font-weight:600">Nama Lokasi</span>
	<span style="margin-left:4px">: {{$location->name}}</span>
</div>
<div>
	<span style="width:6rem;display:inline-block;font-weight:600">Alamat</span>
	<span style="margin-left:4px">: {{$location->address}}</span>
</div>
<div>
	<span style="width:6rem;display:inline-block;font-weight:600">Kode Pos</span>
	<span style="margin-left:4px">: {{$location->postcode}}</span>
</div>
<div>
	<span style="width:6rem;display:inline-block;font-weight:600">Telepon</span>
	<span style="margin-left:4px">: {{$location->phone}}</span>
</div>
@endcomponent

Kunjungi laman [Dashboard]({{route('web.my.dashboard')}}), atau Klik tombol untuk mengarahkan.

@component('mail::button', ['url' => route('web.my.dashboard')])
Ke laman dashboard
@endcomponent

Selamat & Sukses!<br>
{{ config('app.name') }}
@endcomponent
