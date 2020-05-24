(function($) {
	const ATTR_VALIDATE_TYPE = "validate";
	const ATTR_VALIDATE_TYPE_SEPARATOR = "|";
	const ATTR_VALIDATE_TOGGLE = "validate-toggle";
	const ATTR_VALIDATE_ERROR = "validate-error";
	
	const validationFunctions = {
		email: function(value){
			return /^(.*)@(.*)\.(.*)$/.test(value);
		},
		phone: function(value){
			return /^(([0-9+\s-]{1,4})(\s|-)){0,}([0-9+\s-]{1,4})$/g.test(value);
		},
		min: function(digit, value){
			return value >= parseInt(digit);
		},
		max: function(digit, value){
			return value <= parseInt(digit);
		},
		file: function(value){
			//we only validate empty or not
			return value.length>0;
		},
		alphabet: function(value){
			return /^[[:alpha:]\s]*$/g.test(value);
		},
		in: function(src, value){
			return value.length > 0? src.indexOf(value) > -1 : false;
		}
	};
	
	const validationHandler = function(element){
		let t_validation = $(element).attr(ATTR_VALIDATE_TYPE)
									.split(ATTR_VALIDATE_TYPE_SEPARATOR);
		let validationResult = true;
		for(let i=0; i<t_validation.length; i++){
			if (t_validation[i].toLowerCase() == "email"){
				validationResult &= validationFunctions.email( $(element).val() );
			}
			else if (t_validation[i].toLowerCase() == "phone"){
				validationResult &= validationFunctions.phone( $(element).val() );
			}
			else if (t_validation[i].toLowerCase().includes("min:")){
				let props = t_validation[i].split(":");
				validationResult &= validationFunctions.min( props[1], $(element).val().length );
			}
			else if (t_validation[i].toLowerCase().includes("max:")){
				let props = t_validation[i].split(":");
				
				//check if we should check file size for <input type="file" />
				if ( $(element).attr('type').toLowerCase() == "file" ){
					
					//check if file provided
					if (element.files[0]){						
						validationResult &= validationFunctions.max( props[1], element.files[0].size );
					}
					else{
						validationResult &= false;
					}
				}
				else{					
					validationResult &= validationFunctions.max( props[1], $(element).val().length );
				}
			}
			else if (t_validation[i].toLowerCase().includes("file")){
				validationResult &= validationFunctions.file( $(element).val() );
			}
			else if (t_validation[i].toLowerCase().includes("alphabet")){
				validationResult &= validationFunctions.file( $(element).val() );
			}
			else if (t_validation[i].toLowerCase().includes("in:")){
				try{
					let props = t_validation[i].split(":");
					validationResult &= validationFunctions.in( props[1], $(element).val() );
				}
				catch(e){
					validationResult &= false;
				}
			}
		}
		
		return validationResult;
	}
	
	$.fn.requireValidation = function(callbacks){
		let frm = $(this);
				
		frm.submit(function(){
			
			//call before validation
			if (callbacks.beforeValidation){
				callbacks.beforeValidation(frm);
			}
			
			let valid = true;
			let inputFields = $(this).find("["+ ATTR_VALIDATE_TYPE +"]");
			let focusTarget = false;
			for(let i=0; i<inputFields.length; i++){
				if ( $(inputFields[i]).attr(ATTR_VALIDATE_TYPE) ){
					
					const hasErrorMsg = $(inputFields[i]).attr(ATTR_VALIDATE_ERROR);
					const isValid = validationHandler(inputFields[i]);
					if (!isValid){
						$(inputFields[i]).addClass("invalid");
						$(hasErrorMsg).removeClass('d-none');
						
						if (callbacks.onInvalidFoundCallback){
							callbacks.onInvalidFoundCallback(inputFields[i]);
						}
					}
					else{
						$(inputFields[i]).removeClass("invalid");
						$(hasErrorMsg).addClass('d-none');
						
						if (callbacks.onValidFoundCallback){
							callbacks.onValidFoundCallback(inputFields[i]);
						}
					}
					
					valid &= isValid;
					if (callbacks.onValidateResult){
						callbacks.onValidateResult(valid);
					}
				}
			}
			
			if (valid){
				return true;
			}
			return false;
		});
		
	};
	
}(jQuery));