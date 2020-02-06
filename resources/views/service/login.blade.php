@extends('layout-root')

@push('meta')
<meta name="google-signin-client_id" content="{{env('GOOGLE_CLIENT_ID')}}">
@endpush

@push('style')
<style>
div.l-space{ text-align:center }
div.l-space>div.line { position:relative; border-bottom: 1px solid #343a40 !important }
div.l-space>div.label { position:relative; background-color: #1e1e1e; padding: 0 1em; top: -1em; display: inline-block }
</style>
@endpush

@push('script')
<script src="https://apis.google.com/js/platform.js" async defer></script>
<script src="https://connect.facebook.net/en_US/sdk.js"></script>
<script src="{{url('js/service-auth.js')}}"></script>
@endpush

@push("script.ready")
oauth.google.start({
	buttons: ["oauth-google-xs-sm"],
	google_client_id: "{{env("GOOGLE_CLIENT_ID")}}",
	csrf_token: "{{csrf_token()}}",
	verify_url: "{{ route("web.service.redirector").'?url='.route("web.service.oauth.verify.google",["googleToken"=>false]) }}",
});	
oauth.facebook.start({
	app: {
		id: "{{env("FACEBOOK_APP_ID")}}",
		version: "v5.0",
		cookie: true,
		xfbml: true,
	},
	buttons:$(".btn-oauth-facebook").toArray(),
	verify_url: "{{ route("web.service.redirector").'?url='.route("web.service.oauth.verify.facebook",["facebookToken"=>false]) }}",
});
@endpush

@section('body')
<div class="container">
    @include('service.login.login-xs-sm')
</div>
@endsection