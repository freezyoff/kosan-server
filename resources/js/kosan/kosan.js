if (window.Crypt == null){
	window.Crypt = require('crypto-js');
}

if (window.MQTT == null){
	window.MQTT = require('./../vendor/mqtt.js');
}

if (window.Kosan == null){
	window.Kosan = {};
}

require('./KosanMqtt.js');

window.Kosan.MQTT = new KosanMQTT();

window.Kosan.MD5 = function(str){
	return MD5(  typeof str === "string"? str : str+"");
}

window.Kosan.Crypt = {
	decrypt: function(salt, encryptedStr){
		var props = JSON.parse(atob(encryptedStr));
		var plain = Crypt.AES.decrypt(props.value, Crypt.enc.Base64.parse(salt), {iv : Crypt.enc.Base64.parse(props.iv)});
		var split = plain.toString(Crypt.enc.Utf8).split(":");
		if (typeof split[2] === 'undefined'){ return ""; }
		return split[2].replace(/[\"\;]/g,"");
	}
}