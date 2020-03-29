/**
 *	abstraction of Single Line shell
 */
class Shell{
	
	static __preserveKey__(key){ return key.startsWith("#")? key : "#"+key; }
	static __preserveOpt__(opt){
		opt= opt.startsWith("~")? opt : "~"+opt;
		opt= opt.endsWith("=")? opt : opt+"=";
        return opt;
	}
	
	static __hasKey__(str){ return str.startsWith("#"); }
	
	constructor (str){
		if (str.match(/\r?\n/)){
			throw new Error('Require single line string, multiline string provided');
		}
		
		if (!Shell.__hasKey__(str)){
			throw new Error('Require key with # as key identifier');
		}
		
		this.__payload__ = str;
	}
	
	key(){ 
		//Constructor has check if __payload__ has key
		//we assume already has key
		let sdx = 0;
		let edx = this.__payload__.indexOf("~");
		let key = this.__payload__.substring(0, edx>=0? edx : this.__payload__.length);
		return key.trim();
	}
	
	isKey(key){ 
		return Shell.__preserveKey__(key) == this.key(); 
	}
	
	opt(opt){
		//constructor already check if single line, 
		//we assume __payload__ is single line & has preferred key
		//find option
		opt = Shell.__preserveOpt__(opt);
		let result = this.__payload__.substring(this.__payload__.indexOf(opt)+opt.length);
        let edx = result.indexOf("~");
		result = result.substring(0, edx>=0? edx : result.length);
		return result.trim();
	}
};

/*
//test multiline
//const shell = new Shell("#os ~m=233 ~d=32232 ~s=23123232\n");
//console.log(shell);

//test no key
//const shell = new Shell("~m=233 ~d=32232 ~s=23123232");
//console.log(shell);

const shell = new Shell("#os ~m=233 sdsdsd ~d=111 222 ~s=33 33 33");
console.log("key() => ", shell.key());
console.log("isKey('#os') => ", shell.isKey("#os"));
console.log("isKey('#ntp') => ", shell.isKey("#ntp"));
console.log("opt('m') => ", shell.opt("m"));
console.log("opt('m') => ", shell.opt("d"));
console.log("opt('m') => ", shell.opt("s"));
*/

module.exports = Shell;