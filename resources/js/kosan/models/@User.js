class KosanUser{
	constructor(gson){
		if (typeof gson === "string"){
			gson = JSON.parse(gson)
		}
		
		if (typeof gson === "object"){
			this._src = gson;
		}
	}
	
	isApiTokenExpired(){ return this._src.api_token_expired - now() <= 0; }
	apiToken(){ return this._src.api_token; }
	email(){ return this._src.email; }
	id(){ return this._src.id; }
	
	hasAccessibility(){ return this._src.accessibilities.length>0; }
	
	accessibilities(){ 
		var result=[];
		for (var i=0; i<this._src.accessibilities.length; i++){
			result.push( this.accessibility(i) );
		}
		return result;
	}
	
	accessibility(index){ 
		return new KosanUserAccessibility(this._src.accessibilities[index]); 
	}
	
	findAccessibility(targetID){
		for(var i=0; i<this._src.accessibilities.length; i++){
			if (this.accessibility(i).id() == targetID){
				return this.accessibility(i);
			}
		}
		return false;
	}
	
	hasOwnedLocations(){ return this._src.owned_locations.length>0; }
	
	ownedLocations(){ 
		var result = [];
		for (var i=0;i<this._src.owned_locations.length; i++){
			result.push(this.ownedLocation(i));
		}
		return result;
	}
	
	ownedLocation(index){
		return new KosanLocation(this._src.owned_locations[index]);
	}
};