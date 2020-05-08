if (!window.APP){
	window.APP = {};
}

window.APP = {
	init: function(url){
		Kosan.Server.listen(url, OnMessageArrive);
	},
	add: function(item){
		this.devices.push(item);
	},
	restart: function(owner, device){
		let cmd = "kosan/owner/<email-md5>/device/<mac-md5>/command";
		let topic = cmd.replace("<email-md5>", owner)
						.replace("<mac-md5>", device);
		Kosan.Server.send(topic, "#restart");
	},
	devices: [],
	devices_touch_timer: {},
	devices_state_mode: {}
};

const OnMessageArrive = function(client, topic, message){
	topic = topic.split("/");
	
	//record arrive time
	this.devices_touch_timer[topic[4]] = now();
	
	//record mode
	let shellOS = Kosan.ShellFactory.makeOS(message.toString());
	this.devices_state_mode[topic[4]] = shellOS? shellOS.mode : 0;
}.bind(APP);

const Loop = function(){ 
	for (let i=0; i<this.devices.length; i++){
		let cdevice = this.devices[i];
		
		let isConnected = false;
		if (this.devices_touch_timer){
			isConnected = now() - this.devices_touch_timer[cdevice] < 3;
		}
		
		$('#'+this.devices[i]+'-icon').html( isConnected? 'router' : 'sync_problem')
			.parent()
			.parent()
			.removeClass( isConnected? 'card-header-secondary' : 'card-header-success')
			.addClass( isConnected? 'card-header-success' : 'card-header-secondary');
		
		UpdateLastConnected(i, isConnected);
		UpdateStateMode(i, isConnected);
	}
}.bind(APP);

const UpdateLastConnected = function(idx, isConnected){
	let timestamp = this.devices_touch_timer[this.devices[idx]];
	let span = $("<span></span>").addClass('badge ' + (isConnected? 'badge-success' : "badge-secondary"));
	let div = $('#'+this.devices[idx]+'-con-last').empty();
	
	let t = Time.elapsed(timestamp);
	if (t.diff <=3) {
		div.append( span.html("baru saja") );
	}
	else if (!isConnected){
		div.append( span.html("tidak terkoneksi") );
	}
	else{		
		let str= "";
		if (t.days) 	str	 = t.days + " hari ";
		if (t.hours) 	str += t.hours + " jam ";
		if (t.minutes) 	str += t.minutes + " menit ";
		if (t.seconds) 	str += t.seconds + " detik ";
		div.append( span.html(str + " yang lalu") );
	}
	
}.bind(APP);

const UpdateStateMode = function(idx, isConnected){
	let mode = ["tidak diketahui", "melayani", "melayani & download update"];
	let modeIdx = isConnected? this.devices_state_mode[this.devices[idx]] : 0;
	$('#'+this.devices[idx]+'-con-mode').empty().append(
		$("<span></span>").html(mode[modeIdx])
			.addClass('badge ' + (isConnected? 'badge-success' : 'badge-secondary'))
	);
}.bind(APP);

$(document).ready(function(){
	setInterval(Loop, 3000);
});