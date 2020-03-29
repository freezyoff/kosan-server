if (window.oauth == null){
	window.oauth = {};
}

//in html require below script before calling this script
//<script src="https://apis.google.com/js/api:client.js"></script>
// javascript-obfuscator:disable
window.oauth.google = require("./oauth-google.js");

//in html require below script before calling this script
//<script async defer src="https://connect.facebook.net/en_US/sdk.js"></script>
// javascript-obfuscator:disable
window.oauth.facebook = require('./oauth-facebook.js');