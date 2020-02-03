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
}(jQuery));