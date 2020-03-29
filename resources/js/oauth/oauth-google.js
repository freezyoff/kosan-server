module.exports = {
	options: [],
	start: function(options){
		gapi.load('auth2', function(){
		  auth2 = gapi.auth2.init({
			client_id: options.google_client_id,
			cookiepolicy: 'single_host_origin'
		  });
		  
		  options.buttons.forEach(oauth.google.attach);
		  
		  //set options
		  oauth.google.options = options;
		});
	},
	attach: function(button){
		auth2.attachClickHandler(
			button, 
			{},
			function(googleUser){ 
				oauth.google.checkGoogleAccountToken(googleUser.getAuthResponse().id_token);
			}
		);
	},
	checkGoogleAccountToken: function(googleAccountToken){
		var options  = oauth.google.options;
		window.location = options["verify_url"] + "/" + googleAccountToken;
	}
};