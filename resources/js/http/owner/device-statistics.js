const ShellFactory = Kosan.ShellFactory,

	Server = Kosan.Server,

	Listener = {
		isConnected: function(){ return Time.now() - _lastRecievedMessage > 60; },
		init: function(url){
			Server.listen(url, this.onMessageArrive.bind(Listener));
			setInterval(this.updateTimestamp, 3000);
		},
		onMessageArrive: function(client, topic, message){
			//topic: "kosan/user/<email-md5>/device/<mac-md5>/state/<os|io|config>"
			topic = topic.split("/");
			
			_lastRecievedMessage = Time.now();
			
			if 		(topic[6] == 'os')this.updateStateOS(message.toString());
			else if (topic[6] == 'config') this.updateStateConfig(message.toString());
		},
		updateStateOS: function(msgStr){
			const shellOS = ShellFactory.makeOS(msgStr);
			SysUpdate.updateProperties(shellOS);
			SysRAM.updateProperties(shellOS);
			SysFirmware.updateProperties(shellOS);
			SysFS.updateProperties(shellOS);
			SysGeneral.updateProperties(shellOS);
		},
		updateStateConfig: function(msgStr){
			//SysWan.updateProperties(config);
			msgStr.split(/\r?\n/).forEach( line => {
				if 		(line.startsWith("#ntp")) 	SysNTP.updateProperties(ShellFactory.makeNTP(line));
				else if (line.startsWith("#nwst")) 	SysWan.updateProperties(ShellFactory.makeWifiST(line));
				else if (line.startsWith("#nwap")) 	Wifi.updateProperties(ShellFactory.makeWifiAP(line));
			});
			
		},
		updateTimestamp:function(){
			SysUpdate.updateTimestamp();
			SysRAM.updateTimestamp();
			SysFS.updateTimestamp();
			SysFirmware.updateTimestamp();
		}
	},

	SysRAM = {
		theChart: null,
		updateTimer: Time.now(),
		data: {
			labels: ['-12s', '-9s', '-6s', '-3s', '0s'],
			series: [
				[0,0,0,0,0,],	//current free heap
				[0,0,0,0,0,],	//current free heap
			]
		},
		options:{
			lineSmooth: Chartist.Interpolation.cardinal({
				tension: 0
			}),
			fullWidth: true,
			low: 0,
			high: 0,
			chartPadding: {
				right: 40
			}
		},
		init: function(chartCollection){
			chartCollection['ram'] = new Chartist.Line('#system-health-chart', this.data, this.options);
			this.theChart = chartCollection['ram'];
		},
		updateProperties: function(osState){
			if (!this.theChart){
				this.init(Charts);
			}
			
			//used heap
			let info = osState.ram;
			this.data.series[0].push(info.used/1000);
			this.data.series[0] = this.data.series[0].length > 5? this.data.series[0].slice(1) : this.data.series[0];
			
			this.data.series[1].push(info.fragments*info.size/100/1000);
			this.data.series[1] = this.data.series[1].length > 5? this.data.series[1].slice(1) : this.data.series[1];
			
			let iteration = 0;
			while (this.options.high < Math.round(info.size/1000)){
				this.options.high = 10^(iteration++);
			}
			//this.options.high = Math.round(info.size/1000);
			this.theChart.update(this.data, this.options, true);
			
			$('#sys-ram-size').html(numberSeparator(info.size) + " Bytes");
			$('#sys-ram-usage').html(numberSeparator(info.used) + " Bytes");
			$('#sys-ram-free').html(numberSeparator(info.free) + " Bytes");
			$('#sys-ram-fragments').html(info.fragments + "%");
			
			this.updateTimer = Time.now();
		},
		updateTimestamp: function(){
			$('#sys-ram-timestamp').html(`data ${toHumanElapsedTime(this.updateTimer)}`);
		}
	},

	SysFirmware = {
		theChart: null,
		updateTimer: Time.now(),
		data: { series: [] },
		options:{ chartPadding: 0 },
		init: function(chartCollections){
			let chartKey = "firmware";
			let chartEL = '#sys-firmware-chart';
			
			chartCollections[chartKey] = new Chartist.Pie(chartEL, this.data, this.options);
			this.theChart = chartCollections[chartKey];
		},
		updateProperties: function(stateOS){
			let iUpdate = stateOS.update;
			let iFirmware = stateOS.firmware;
			let iType = iUpdate.available? 'update' : 'info'
			
			//init chart
			if (!this.theChart){
				this.init(Charts);
			}
			
			$('#sys-firmware-version-device').html(iFirmware.version);
			$('#sys-firmware-info-size').html(numberSeparator(iFirmware.size) + " Bytes");
			$('#sys-firmware-info-used').html(numberSeparator(iFirmware.used) + " Bytes");
			$('#sys-firmware-info-free').html(numberSeparator(iFirmware.free) + " Bytes");
			$('#sys-firmware-progress').html("0 Bytes");
			this.data.series[0] = (iFirmware.used/iFirmware.size*100).toFixed(2);
			this.data.series[1] = (iFirmware.free/iFirmware.size*100).toFixed(2);
				
			//update in progress
			if (iType == 'update'){
				
				//add data series
				this.data.series[2] = (iUpdate.progress/iFirmware.size*100).toFixed(2);
				
				//change the free
				$('#sys-firmware-info-free').html(numberSeparator(iFirmware.free - iUpdate.progress) + " Bytes");
				this.data.series[1] = ((iFirmware.free - iUpdate.progress)/iFirmware.size*100).toFixed(2);
				
				//set the update
				$('#sys-firmware-progress').html(numberSeparator(iUpdate.progress) + " Bytes");
			}
			
			this.theChart.update(this.data, this.options, true);
			this.updateTimer = Time.now();
		},
		updateTimestamp: function(){
			$('#sys-firmware-timestamp').html(`data ${toHumanElapsedTime(this.updateTimer)}`);
		}
	},

	SysFS = {
		theChart: null,
		updateTimer: Time.now(),
		data: {series: []},
		options:{chartPadding: 0},
		init: function(chartCollections){
			chartCollections['storage'] = new Chartist.Pie('#sys-fs-chart', this.data, this.options);
			this.theChart = chartCollections['storage'];
		},
		updateProperties: function(stateOS){
			if (!this.theChart){
				this.init(Charts);
			}
			
			let info = stateOS.filesystem;
			$('#sys-fs-size').html(numberSeparator(info.size) + " Bytes");
			$('#sys-fs-usage').html(numberSeparator(info.used) + " Bytes");
			$('#sys-fs-free').html(numberSeparator(info.free) + " Bytes");
			
			this.data.series[0] = (info.used/info.size*100).toFixed(2);
			this.data.series[1] = (info.free/info.size*100).toFixed(2);
			this.theChart.update(this.data, this.options, true);
			this.updateTimer = Time.now();
		},
		updateTimestamp: function(){
			$('#sys-fs-timestamp').html(`data ${toHumanElapsedTime(this.updateTimer)}`);
		}
	},

	SysUpdate = {
		updateTimer: Time.now(),
		updateProperties:function(stateOS){
			this.updateTimer = Time.now();
			
			//check if update in progress (download started), 
			let iUpdate = stateOS.update;
			
			//check if update available, if not do nothing
			$("#sys-update-available").addClass(iUpdate.available? '' : 'd-none')
									  .removeClass(iUpdate.available? 'd-none' : '');
			$("#sys-update-unavailable").addClass(iUpdate.available? 'd-none' : 'd-flex')
									    .removeClass(iUpdate.available? 'd-flex' : 'd-none');
			
			if (!iUpdate.available){
				return;
			}
			
			let iFirmware = stateOS.firmware;
			$("#sys-update-server-hash").html(iFirmware.updateVersion);
			$("#sys-update-server-hash-tooltips").html(iFirmware.updateVersion).attr('data-original-title', iFirmware.updateVersion);
			/*
			$("#sys-update-device-size").html(numberSeparator(iFirmware.used) + " Bytes");
			$("#sys-update-server-size").html(numberSeparator(iFirmware.updateSize) + " Bytes");
			*/
			
			//device will info no update yet, because device not check it yet
			let isUpdateInProgress = iUpdate.available;
			
			//if update in progress
			if (isUpdateInProgress){
				//show progress info
				$("#sys-update-download-info").removeClass('d-none');
				
				//update percentage
				let percent = Math.round(iUpdate.progress/iUpdate.size*100);
				$("#sys-update-download-info-progressbar").attr('data-percentage', percent);
				$("#sys-update-download-info-label").html(`${percent}%`);
				$("#sys-update-download-info-progress").html(numberSeparator(iUpdate.progress) + " Bytes");
				$("#sys-update-download-info-remaining").html(numberSeparator(iUpdate.remaining) + " Bytes");
			}
			else{
				//show download button
				$("#sys-update-download-info").addClass('d-none');
			}
		},
		updateTimestamp: function(){
			$('#sys-update-timestamp').html(`data ${toHumanElapsedTime(this.updateTimer)}`);
		}
	},
	
	SysGeneral = {
		updateProperties:function(stateOS){
			let iFirmware = stateOS.firmware;
			$("#sys-general-device-hash").html(iFirmware.version);
			$("#sys-general-device-hash-tooltips").html(iFirmware.version).attr('data-original-title', iFirmware.version);
			
		}
	},

	SysWan = {
		updateTimer: Time.now(),
		_init_: false,
		addSwapListener: function(){
			this._init_ = true;
			let inp = $("#sys-wan-ssid-inp").focusout(function(){
				labelContainer.removeClass('d-none')
				inpContainer.addClass('d-none');
			});
			let label = $("#sys-wan-ssid");
			let inpContainer = $(".sys-wan-ssid-lp");
			let labelContainer = $(".sys-wan-ssid-lb").click(function(){
				console.log(label.html().trim());
				inp.val(label.html().trim());
				labelContainer.addClass('d-none')
				inpContainer.removeClass('d-none');
				setTimeout(function(){
					inp.focus();
				}, 200);
			});
		},
		sendConfig:function(shellConfig){
			
		},
		updateProperties:function(wifist){
			if (!this._init_) this.addSwapListener();
			
			$("#sys-wan-ssid").html(wifist.ssid);
			
			let pwdMask = "";
			for(let i=0; i<wifist.pwd.length; i++) pwdMask+="*";
			$("#sys-wan-pwd").html(pwdMask);
		},
		updateTimestamp: function(){
			
		}
	},

	SysNTP = {
		updateTimer: Time.now(),
		updateProperties:function(ntp){
			$("#sys-ntp-server1").html(ntp.servers[0]);
			$("#sys-ntp-server2").html(ntp.servers[1]);
			$("#sys-ntp-server3").html(ntp.servers[2]);
		}
	},
	
	Wifi = {
		updateProperties:function(wifist){
			$("#wifi-ssid").html(wifist.ssid);
			//$("#wifi-pwd").html(wifist.pwd);
			$("#wifi-ip").html(wifist.ip4);
			$("#wifi-gateway").html(wifist.gateway);
			$("#wifi-subnet").html(wifist.subnet);
			$("#wifi-hidden").html(wifist.hidden);
			$("#wifi-maxclient").html(wifist.maxClient);
		}
	},
	
	Command = {
		topics: {
			cmd: "kosan/owner/<email-md5>/device/<mac-md5>/command"
		},
		restart: function(owner, device){
			let topic = this.topics.cmd
							.replace("<email-md5>", owner)
							.replace("<mac-md5>", device);
			Server.send(topic, "#restart");
		},
		//javascript-obfuscator:disable
		init: function(){
			$("#restart").click(function(){
				let owner = $(this).attr('owner');
				let device = $(this).attr('device');
				Command.restart(owner, device);
			});
		}
	};

if (!window.Kosan){
	window.Kosan = {};
}

Kosan.Owner = {
	deviceStatistics:function(configUrl){
		Listener.init(configUrl);
		Command.init();
	}
};