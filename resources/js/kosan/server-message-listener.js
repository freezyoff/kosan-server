if (!window.MQTT) { require('./../vendor/mqtt.js'); }

if (!window.Kosan) { window.Kosan = {} }

require('../utils/datetime.js');
require('../utils/string.js');
require('./StateMessageFactory.js');

Listener = {
	listen: function(url, onConnectCallback, onMessageArriveCallback){
		$.getJSON(url, function( data ) {
			Kosan.ServerMessageListener._listen(data, onConnectCallback, onMessageArriveCallback);
		});
	},
	
	_listen: function(options, onConnectCallback, onMessageArriveCallback){
		let client = MQTT.connect({
			port: options.port,
			host: options.host,
			username: options.username,
			password: options.password,
			ca: options.certificate,
			clean: true,
			protocol: 'mqtts',
			rejectUnauthorized: true
		});
		
		if (onConnectCallback){
			client.on("connect", ()=>{
				onConnectCallback(client)
			});
		}
		
		if (onMessageArriveCallback){
			client.on("message", (topic, message)=>{
				onMessageArriveCallback(client, topic, message)
			});
		}
	}
};

if (!window.Kosan.ServerMessageListener){
	window.Kosan.ServerMessageListener = Listener
}
