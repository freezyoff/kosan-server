const Shell = require("./Shell.js"),
	
	/**
	 * #nwap	
	 *	~i=		-> ssid
	 *	~p=		-> password
	 *	~F=		-> ip4
	 *	~g=		-> gateway
	 *	~s=		-> subnet
	 *	~h=		-> hidden
	 *	~c=		-> channel
	 *	~m		-> max-client
	 **/
	ShellWifiAP = {
		key: "#nwap",
		optKeys: ["i","p","F","g","s", "h", "c", "m"],
		varKeys: ["ssid", "pwd", "ip4", "gateway", "subnet", "hidden", "channel", "maxClient"],
		
		//@var str (String) - shell string
		fromStr:function (str){
			const shell = new Shell(str);
			if (!shell || !shell.isKey(this.key)){
				return null;
			}
			
			let result = {};
			for(let idx=0; idx<this.optKeys.length; idx++){
				result[this.varKeys[idx]] = shell.opt(this.optKeys[idx]);
			}
			
			return result;
		}
	};
	
module.exports = ShellWifiAP;