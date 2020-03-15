class KosanMQTT{
	constructor(clientid){
		this.port = 9883;
		this.host = "mqtt.kosan.co.id";
		this.certificate = "http://www.tbs-x509.com/USERTrustRSACertificationAuthority.crt";
		this.username = "kosan-server";
		this.password = "kosan-server";
		this.clientid = clientid;
	}
	
	connect(onConnectCallback, onMessageArriveCallback){
		this.connected = true;
		this.client = MQTT.connect({
			port: this.port,
			host: this.host,
			username: this.username,
			password: this.password,
			ca: this.certificate,
			clean: true,
			protocol: 'mqtts',
			rejectUnauthorized: true
		});
		
		if (onConnectCallback){
			this.client.on("connect", onConnectCallback);
		}
		if (onMessageArriveCallback){
			this.client.on("message", onMessageArriveCallback);
		}
	}
	
	isConnected(){ return this.client.connected }
	
	end(){ this.client.end(); }
	
	publish(topic, message, options, callback){ this.client.publish(topic, message, options, callback); }
	subscribe(topics, options, callback){ this.client.subscribe(topics, options, callback); }
	unsubscribe(topics, options, callback){ this.client.unsubscribe(topics, options, callback); }
	
};