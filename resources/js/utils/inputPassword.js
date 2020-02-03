if (window.input == undefined){
	window.input = {
		
	}	
}

input.password = {
	toggleView: function (icon, button, buttonMaskIcon, buttonPlainIcon){
		if (buttonMaskIcon == undefined){
			buttonMaskIcon = "fa-eye-slash";
		}
		
		if (buttonPlainIcon == undefined){
			buttonPlainIcon = "fa-eye";
		}
		
		icon.toggleClass(buttonMaskIcon)
			.toggleClass(buttonPlainIcon);
			
		button.attr("type", icon.hasClass(buttonPlainIcon)? "password":"text");
	}
}