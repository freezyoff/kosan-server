class KosanLocation{
	constructor(gson){
		if (typeof gson === "string"){
			gson = JSON.parse(gson);
		}
		
		if (typeof gson === "object"){
			this._src = gson;
		}
	}
	
	id(){ return this._src.id; }
	uuid(){ return this._src.uuid; }
	name(){ return this._src.name; }
	phone(){ return this._src.phone; }
	postcode(){ return this._src.postcode; }
	address(){ return this._src.address; }
	owner(){ return this._src.owner; }
	hasPIC(){ return typeof this._src.pic !== 'undefined';}
	pic(){ return this._src.pic; }
	
	devices(){ 
		var result = [];
		for (var i=0; i<this._src.devices.length; i++){
			result.push(this.device(i));
		}
		return result;
	}
	
	device(index){ return new KosanDevice(this._src.devices[index]); }
};