const Shell = require("./Shell.js"),
	ShellOS = {
		key: "#os",
		optKeys: [
			"m",	//-> mode 0=boot | 1=serve | 2=update
			"c",	//-> chipset name 
			"d",	//-> device uuid
			"ta",	//-> api token
			"te",	//-> api token expired
			
			//heap/ram info
			"rs",	//-> heap size (on serve/publish state) 
			"rf",	//-> current free heap (on serve/publish state) 
			"rg",	//-> heap fragment %(on serve/publish state) 
			
			//firmware info
			"ss",	//-> installed sketch/firmware space size
			"su",	//-> installed sketch/firmware size used
			"sf",	//-> installed sketch/firmware free space
			"sh",	//-> installed sketch/firmware version hash 
			"sv",	//-> installed compile version 
			"suh",	//-> latest sketch/firmware hash
			"sus",	//-> latest sketch/firmware size
		
			//filesystem info
			"fs",	//-> filesystem space size in bytes
			"fu",	//-> filesystem used space in bytes
			"ff",	//-> filesystem free space in bytes
		
			//UPDATE PROGRESS, 
			//available when mode == 2 (update in progress)
			"us",	//-> update size
			"ur",	//-> update remaining
			"up",	//-> update progress
			"ut",	//-> update start unix timestamp
		],
		varGroups:{
			nonGroup: ["m", "c", "d", "ta", "te"],
			ram: ["rs", "rf", "rg"],
			firmware: ["ss","su", "sf", "sh", "sv", "suh", "sus"],
			filesystem: ["fs", "fu", "ff"],
			update: ["us", "ur", "up", "ut"]
		},
		varKeys:{
			m: 	"mode",				//-> mode 0=boot | 1=serve | 2=update
			c: 	"name",				//-> chipset name 
			d: 	"uuid",				//-> device uuid
			ta:	"apiToken",			//-> api token
			te:	"apiTokenExpired",	//-> api token expired
			
			//heap/ram info
			rs:	"size",				//-> heap size (on serve/publish state) 
			rf:	"free",				//-> current free heap (on serve/publish state) 
			rg:	"fragments",		//-> heap fragment %(on serve/publish state) 
			
			//firmware info
			ss:	"size",				//-> installed sketch/firmware space size
			su:	"used",				//-> installed sketch/firmware size used
			sf:	"free",				//-> installed sketch/firmware free space
			sh:	"version",			//-> installed sketch/firmware version hash 
			sv:	"compile",			//-> installed compile version 
			suh:"updateVersion",	//-> latest sketch/firmware hash
			sus:"updateSize",		//-> latest sketch/firmware size
			
			//filesystem info
			fs:	"size",				//-> filesystem space size in bytes
			fu:	"used", 			//-> filesystem used space in bytes
			ff:	"free", 			//-> filesystem free space in bytes
			
			//UPDATE PROGRESS, 
			//available when mode == 2 (update in progress)
			us:	"size",				//-> update size
			ur:	"remaining",		//-> update remaining
			up:	"progress",			//-> update progress
			ut:	"started"			//-> update start unix timestamp
		},
		
		//@var str (String) - shell string
		//@return shell represent Shell OS
		fromStr: function(str){
			//console.log(this);
			//return;
			
			let shell = new Shell(str);
			if (!shell || !shell.isKey(this.key)){
				return null;
			}
			
			let result = {};
			this.varGroups.nonGroup.forEach(key=>{
				result[this.varKeys[key]] = shell.opt(key);
			});
			
			//make ram()
			let ram = {};
			this.varGroups.ram.forEach(key=>{
				ram[this.varKeys[key]] = shell.opt(key);
			});
			ram["used"] = ram.size - ram.free;
			result["ram"] = ram;
			
			//make firmware()
			let firmware = {};
			this.varGroups.firmware.forEach(key=>{
				firmware[this.varKeys[key]] = shell.opt(key);
			});
			result["firmware"] = firmware;
			
			//make filesystem()
			let filesystem = {};
			this.varGroups.filesystem.forEach(key=>{
				filesystem[this.varKeys[key]] = shell.opt(key);
			});
			result["filesystem"] = filesystem;
			
			//make update()
			let update = {};
			this.varGroups.update.forEach(key=>{
				update[this.varKeys[key]] = result.mode == 2? shell.opt(key) : null;
			});
			update["available"] = update.size > 0;
			result["update"] = update;
			
			return result;
		}
		
	};

//test
/*
const tValue = {
	m: 	"2",				//-> mode 0=boot | 1=serve | 2=update
	c: 	"name",				//-> chipset name 
	d: 	"uuid",				//-> device uuid
	ta:	"apiToken",			//-> api token
	te:	"apiTokenExpired",	//-> api token expired
	
	//heap/ram info
	rs:	"ram size",				//-> heap size (on serve/publish state) 
	rf:	"ram free",				//-> current free heap (on serve/publish state) 
	rg:	"ram fragments",		//-> heap fragment %(on serve/publish state) 
	
	//firmware info
	ss:	"firmw size",				//-> installed sketch/firmware space size
	su:	"firmw used",				//-> installed sketch/firmware size used
	sf:	"firmw free",				//-> installed sketch/firmware free space
	sh:	"firmw version",			//-> installed sketch/firmware version hash 
	sv:	"firmw compile",			//-> installed compile version 
	suh:"firmw updateVersion",	//-> latest sketch/firmware hash
	sus:"firmw updateSize",		//-> latest sketch/firmware size
	
	//filesystem info
	fs:	"fs size",				//-> filesystem space size in bytes
	fu:	"fs used", 			//-> filesystem used space in bytes
	ff:	"fs free", 			//-> filesystem free space in bytes
	
	//UPDATE PROGRESS, 
	//available when mode == 2 (update in progress)
	us:	"update size",				//-> update size
	ur:	"update remaining",		//-> update remaining
	up:	"update progress",			//-> update progress
	ut:	"update started"			//-> update start unix timestamp
};

let tShell = "#os";
for (let key in tValue) {
	tShell += " ~"+key+"="+tValue[key];
}

let shellOS = ShellOS.fromShell(tShell);
console.log(shellOS);
*/
module.exports = ShellOS;