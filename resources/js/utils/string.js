window.ucfirst = function(str, force){
	str=force ? str.toLowerCase() : str;
	return str.replace(/(\b)([a-zA-Z])/,
		function(firstLetter){
			return firstLetter.toUpperCase();
		}
	);
}

window.ucwords = function(str, force){
	str=force ? str.toLowerCase() : str;  
	return str.replace(/(\b)([a-zA-Z])/g,
		function(firstLetter){
			return firstLetter.toUpperCase();
		}
	);
}