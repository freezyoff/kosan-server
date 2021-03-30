require('../../kosan/server-message-listener.js');

const ShellFactory = Kosan.ShellFactory,
	
	Server = Kosan.Server,
	
	Listener = {
		callback: [],
		init: function(url, listenerCallback){
			Server.listen(url, this.onMessageArrive.bind(Listener));
			this.callback = listenerCallback;
		},
		onMessageArrive: function(client, topic, message){
			if (topic.includes("executed")){
				return;
			}
			
			let signals = ShellFactory.makeAccessControlSignal(message.toString());
			this.callback( signals.lock, signals.door );
			
		}
	},
	
	Sender = {
		configs: {},
		init: function(url){
			this.config = Server.loadConfig(url, function(data){
				Sender.configs = data;
			});
		},
		send: function(){
			Server.send(Sender.configs.publishes[0], "0");
		}
	},
	
	AccessControlState = {
		lock: -1,
		door: -1
	};
	
if (!window.APP){
	window.APP = {};
}

/**
 *	@param ConfigUrl - url to pull the configurations
 *	@param
 */
APP.init = function(configUrl, listenerCallback){
	Listener.init(configUrl, listenerCallback);
	Sender.init(configUrl);
};

APP.sendCommand = function(){
	Sender.send();
};

APP.subscriptionProgress = function(startTimestamp, endTimestamp, gracePeriodeInDays){
	let now = new Date().getTime()/1000;
	let seconds = endTimestamp - now;
	let isGracePeriode = seconds < 0;
	
	if (isGracePeriode){
		seconds *= -1;
		seconds += (gracePeriodeInDays*(24*60*60));
	}
	
	let days = Math.floor(seconds / (60*60*24));
	seconds -= (60*60*24*days);
	let hours = Math.floor(seconds / (60*60));
	seconds -= (60*60*hours);
	let minutes = Math.floor(seconds / (60));
	seconds = Math.floor(seconds - (60*minutes));
	
	let progress = (now-startTimestamp) / (endTimestamp - startTimestamp);
	
	return {
		isGracePeriode: isGracePeriode,
		progress: progress*100,
		days: days,
		hours: hours,
		minutes: minutes,
		seconds: seconds,
	};
}