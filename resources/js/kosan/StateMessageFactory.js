/*
State Message OS
#os 
	~m		-> mode 0=boot | 1=serve | 2=update
	~v=		-> version 
	~h=		-> version hash 
	~c=		-> chipset 
	~cs=	-> chipset size
	~cf=	-> chipset free size 
	~hc=	-> current free heap (on serve/publish state) 
	~hh=	-> highest free heap (on serve/publish state) 
	~hl=	-> lowest free heap (on serve/publish state) 
	
	//update mode only
	~us	-> update size
	~ur	-> update remaining
	~up -> update progress
*/
class StateMessage{
	
	//@var payload (String)
	constructor(payload){
		this.payload = payload;
		
		if (!this.canHandlePayload()){
			this.throwError();
		}
	}
	
	canHandlePayload(){ return false; }
	throwError(){ throw new Error('should implemented by subclass'); }
	
	_find(key){
		key += "=";
		let sdx = this.payload.indexOf(key);
		
		//if key not found, return empty string
		if (sdx<0){
			return "";
		}
		
		let edx = this.payload.substring(sdx+key.length);
		
		//find next command
		let ncmd = edx.indexOf(" ~");
		if (ncmd>0){
			edx = ncmd;
		}
		else{
			edx = edx.length;
		}
		
		//get the result and trim empty space
		let res = this.payload.substring(sdx+key.length, sdx+key.length+edx);
		res.trim();
		return res;
	}
	
};

class StateMessageOS extends StateMessage{
	
	canHandlePayload(){ return this.payload.indexOf('#os') == 0; }
	throwError(){ throw new Error('Payload not State Message OS. \n ' + this.payload); }
	
	mode(){ return this._find("~m"); }
	version(){ return this._find("~v"); }
	hash(){ return this._find("~h"); }
	
	chipset(){ return this._find("~c"); }
	
	filesystemInfo(){
		return {
			size: this._find("~fs"),
			used: this._find("~fu"),
			free: this._find("~ff")
		}
	}
	
	firmwareInfo(){
		return {
			size: this._find("~ss"),
			used: this._find("~su"),
			free: this._find("~sf")
		}
	}
	
	ramInfo(){
		let size = this._find("~rs");
		let free = this._find("~rf");
		return {
			size: size,
			free: free,
			used: size - free, 
			fragments: this._find("~rg")
		};
	}
	
	updateInfo(){
		return {
			available: this.mode()==2,
			size: this.mode() == 2? this._find("~us") : 0,
			remaining: this.mode() == 2? this._find("~ur") : 0,
			progress: this.mode() == 2? this._find("~up") : 0
		};
	}
	
};

class StateMessageIO extends StateMessage{
	canHandlePayload(){ return this.payload.indexOf('#os') == 0; }
	throwError(){ throw new Error('Payload not State Message OS. \n ' + this.payload); }
}

if (!window.Kosan) window.Kosan = {};

window.Kosan.StateMessageFactory = {
	make: function(payload){
		if (payload.indexOf("#os") == 0){
			return new StateMessageOS(payload);
		}
		return null;
	}
}