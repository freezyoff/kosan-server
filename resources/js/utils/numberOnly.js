(function($) {
	$.fn.inputFilter = function(inputFilter) {
		return this.on("input keydown keyup mousedown mouseup select contextmenu drop", function() {
			if (inputFilter(this.value)) {
				this.oldValue = this.value;
				this.oldSelectionStart = this.selectionStart;
				this.oldSelectionEnd = this.selectionEnd;
			} else if (this.hasOwnProperty("oldValue")) {
				this.value = this.oldValue;
				this.setSelectionRange(this.oldSelectionStart, this.oldSelectionEnd);
			} else {
				this.value = "";
			}
		});
	};
  
	$.fn.inputFilterPhoneFormat = function(){
		return this.inputFilter(function(value){
			if (/\-{2,}/.test(value)) return false;
			return value.length > 0? /^([0-9\-]){1,}$/.test(value) : true;
		});
	};
	
	$.fn.inputFilterCurrency = function(){
		let isValidCurrencyFormat = function(value){
			return /^(?=.*\d)^\$?(([1-9]\d{0,2}(,\d{3})*)|0)?(\.\d{1,})?$/g.test(value);
		};
		
		let hasNonCurrencyChars = function(value){
			return /([^0-9.,])/g.test(value);
		}
		
		let formatCurrency = function(value){
			//if not reach 3 digit, do nothing
			if (value.length <=3) return value;
			
			let t_decimal = "";
			let t_float = "";
			
			//check if has float number
			if (/[.]/.test(value)){
				//split decimal and float number
				let valueArray = value.split(".");
				let t_decimal = valueArray[0];
				let t_float = valueArray[1];
			}
			else{
				t_decimal = value;
				t_float = false;
			}
			
			
			//replace number separator from decimal
			t_decimal = t_decimal.replace(/[,]/g, "");
			
			//add decimal separator
			let t_mask = "";
			while (t_decimal.length > 3){
				let t_char = t_decimal.substring(t_decimal.length-3, t_decimal.length);
				t_mask = t_char + (t_mask? "," + t_mask : "");
				t_decimal = t_decimal.substring(0, t_decimal.length-3);
			}
			
			//combine float
			return t_decimal + "," + t_mask + (t_float? "." + t_float : "");
		};
		
		return this.on("input keydown keyup mousedown mouseup select contextmenu drop", function() {
			
			//check if has non currency characters
			if (hasNonCurrencyChars(this.value)){
				if (this.hasOwnProperty("oldValue")) {
					this.value = this.oldValue;
					this.setSelectionRange(this.oldSelectionStart, this.oldSelectionEnd);
				} else {
					this.value = "";
				}
			}
			
			//assume no non-currency characters exists.
			//check its currency format
			else if (!isValidCurrencyFormat(this.value)){
				let f_currency = formatCurrency(this.value);
				this.oldSelectionStart = f_currency.length;
				this.oldSelectionEnd = f_currency.length;
				this.value = f_currency;
			}
			
			//assume valid currency format
			else{
				this.oldValue = this.value;
				this.oldSelectionStart = this.selectionStart;
				this.oldSelectionEnd = this.selectionEnd;
			}
			
		});
	};
	
}(jQuery));