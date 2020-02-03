class KosanDevice{
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
	
	deviceAccessibilities(){ 
		var result = [];
		for (var i=0; i<this._src.device_accessibilities.length; i++){
			result.push( this.deviceAccessibility(i) );
		}
		return result;
	}
	
	deviceAccessibility(index){
		return new KosanDeviceAccessibility( this._src.device_accessibilities[index] );
	}
};