const Shell = require("./Shell.js"),

	ShellNTP = {
		key: "#acs",
		optKeys: ["ds", "ls"],
		
		//@var str (String) - shell string
		fromStr:function (str){
			
			const shell = new Shell("#acs " + str);
			if (!shell || !shell.isKey(this.key)){
				return null;
			}
			
			return {
				door: parseInt(shell.opt("ds")),
				lock: parseInt(shell.opt("ls"))
			};
		}
	};
	
module.exports = ShellNTP;