const Shell = require("./Shell.js"),

	ShellWifiST = {
		key: "#nwst",
		optKeys: [
			//~i=	-> ssid
			"i",
			//~p=	-> pwd
			"p",
			//~F=	-> ip4
			"F",
			//~g=	-> gateway
			"g",
			//~s=	-> subnet
			"s",
			//~d1=	-> dns1
			"d1",
			//~d2=	-> dns2
			"d2"
		],
		
		//@var str (String) - shell string
		fromStr:function (str){
			const shell = new Shell(str);
			if (!shell || !shell.isKey(this.key)){
				return null;
			}
			
			return {
				ssid: shell.opt("i"),
				pwd: shell.opt("p"),
				ip4: shell.opt("F"),
				gateway: shell.opt("g"),
				subnet: shell.opt("s"),
				dns: [shell.opt("d1"), shell.opt("d2")]
			};
		}
	};
	
module.exports = ShellWifiST;