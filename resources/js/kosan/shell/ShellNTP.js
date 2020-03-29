const Shell = require("./Shell.js"),

	ShellNTP = {
		key: "#ntp",
		optKeys: ["t","d","s1","s2","s3"],
		
		//@var str (String) - shell string
		fromStr:function (str){
			const shell = new Shell(str);
			if (!shell || !shell.isKey(this.key)){
				return null;
			}
			
			return {
				timezone: shell.opt("t"),
				daylightOffset: shell.opt("d"),
				servers: [shell.opt("s1"), shell.opt("s2"), shell.opt("s3")]
			};
		}
	};
	
module.exports = ShellNTP;