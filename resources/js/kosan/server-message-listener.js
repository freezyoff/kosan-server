if (!window.MQTT) { require('./../vendor/mqtt.js'); }

if (!window.Kosan) { window.Kosan = {} }

require('../utils/datetime.js');
require('../utils/string.js');

let ServerMQTTClient = null;
const Shell = require("./shell/Shell.js"),
	ShellOS 	= require("./shell/ShellOS.js"),
	ShellNTP 	= require("./shell/ShellNTP.js"),
	ShellWifiST = require("./shell/ShellWifiST.js"),
	ShellWifiAP = require("./shell/ShellWifiAP.js"),
	ServerListenerImpl = function(options, onMessageArriveCallback){
		ServerMQTTClient = MQTT.connect({
			port: options.port,
			host: options.host,
			username: options.username,
			password: options.password,
			ca: options.certificate,
			clean: true,
			protocol: 'mqtts',
			rejectUnauthorized: true
		});
		
		ServerMQTTClient.on('connect', ()=>{
			if (options.subscribes){
				options.subscribes.forEach( idx => {
					ServerMQTTClient.subscribe(idx);
				});
			}
		});
		
		if (onMessageArriveCallback){
			ServerMQTTClient.on("message", (topic, message)=>{
				onMessageArriveCallback(ServerMQTTClient, topic, message);
			});
		}
	};
	
if (!window.Kosan){
	window.Kosan = {
		Server: null,
		ShellFactory: null
	};
}

Kosan.ShellFactory = {
	makeOS: 	function(str){ return ShellOS.fromStr(str); },
	makeNTP: 	function(str){ return ShellNTP.fromStr(str); },
	makeWifiST: function(str){ return ShellWifiST.fromStr(str); },
	makeWifiAP: function(str){ return ShellWifiAP.fromStr(str); }
};

Kosan.Server = {
	listen: function(url, onMessageArriveCallback){
		$.getJSON(url, function( data ) {
			ServerListenerImpl(data, onMessageArriveCallback);
		});
	},
	send: function(topic, message){
		console.log("topic\n",">>" +topic);
		console.log("message\n",">>" +message);
		ServerMQTTClient.publish(topic, message, 1);
	}
};