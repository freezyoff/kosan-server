
class KosanDeviceAccessibility{
	constructor(gson){
		if (typeof gson === "string"){
			gson = JSON.parse(gson);
		}
		
		if (typeof gson === "object"){
			this._src = gson;
		}
	}
	
	id(){ return this._src.id; }
	name(){ return this._src.name; }
	
	userAccessibilities(){ 
		var result = [];
		for (var i=0; i<this._src.user_accessibilities.length; i++){
			result.push( this.userAccessibility(i) );
		}
		return result;
	}
	
	userAccessibility(index){
		return new KosanUserAccessibility(this._src.user_accessibilities[index]);
	}
}

class KosanUserAccessibility{
	constructor(gson){
		if (typeof gson === "string"){
			gson = JSON.parse(gson);
		}
		
		if (typeof gson === "object"){
			this._src = gson;
		}
	}
	
	id(){ return this._src.id; }
	name(){ return this.__src.name; }
	locationID() { return this._src.location_id; }
	validAfter() { return this._src.valid_after; }
	validBefore() { return this._src.valid_before; }
	
	isValid(){
		return now() > this._src.validAfter() && now() < this._src.validBefore();
	}
	
	doorSignal(signal){ 
		if (signal){
			this._src.door_signal = signal;
		}
		return this._src.door_signal;
	}
	
	doorTriggerSignal(signal){
		if (signal){
			this._src.door_trigger_signal = signal;
		}
		return this._src.door_trigger_signal;
	}
	
	lockSignal(signal){ 
		if (signal){
			this._src.lock_signal = signal;
		}
		return this._src.lock_signal;
	}
	
	lockTriggerSignal(signal){
		if (signal){
			this._src.lock_trigger_signal = signal;
		}
		return this._src.lock_trigger_signal;
	}
};

if (window.Kosan == null){
	window.Kosan = {};
}

window.Kosan.User = null;
window.Kosan.Factory = {};
window.Kosan.Factory.makeUser = function(gson){ return new KosanUser(gson) };