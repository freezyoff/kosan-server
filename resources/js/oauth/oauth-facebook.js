module.exports = {
	options: [],
	start: function(options){
		FB.init({
			appId      : options.app.id,
			cookie     : options.app.cookie,
			xfbml      : options.app.xfbml,
			version    : options.app.version
		});
		
		oauth.facebook.options = options;
		options.buttons.forEach(oauth.facebook.attachClickHandler);
	},
	attachClickHandler: function(button){
		$(button).click(function(){
			FB.login(function(response){
				if (response.authResponse) {
					oauth.facebook.checkAuthToken(response.authResponse.accessToken);
				}
			}, {scope: 'email'});
		});
	},
	checkAuthToken: function(authToken){
		var options  = oauth.facebook.options;
		window.location = options["verify_url"] + "/" + authToken;
	}
};