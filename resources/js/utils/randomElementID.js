window.generateID = function(prefix){
	rand = Math.random().toString(36).slice(2);
	return prefix? prefix + rand : rand;
}