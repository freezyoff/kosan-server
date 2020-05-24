/******/ (function(modules) { // webpackBootstrap
/******/ 	// The module cache
/******/ 	var installedModules = {};
/******/
/******/ 	// The require function
/******/ 	function __webpack_require__(moduleId) {
/******/
/******/ 		// Check if module is in cache
/******/ 		if(installedModules[moduleId]) {
/******/ 			return installedModules[moduleId].exports;
/******/ 		}
/******/ 		// Create a new module (and put it into the cache)
/******/ 		var module = installedModules[moduleId] = {
/******/ 			i: moduleId,
/******/ 			l: false,
/******/ 			exports: {}
/******/ 		};
/******/
/******/ 		// Execute the module function
/******/ 		modules[moduleId].call(module.exports, module, module.exports, __webpack_require__);
/******/
/******/ 		// Flag the module as loaded
/******/ 		module.l = true;
/******/
/******/ 		// Return the exports of the module
/******/ 		return module.exports;
/******/ 	}
/******/
/******/
/******/ 	// expose the modules object (__webpack_modules__)
/******/ 	__webpack_require__.m = modules;
/******/
/******/ 	// expose the module cache
/******/ 	__webpack_require__.c = installedModules;
/******/
/******/ 	// define getter function for harmony exports
/******/ 	__webpack_require__.d = function(exports, name, getter) {
/******/ 		if(!__webpack_require__.o(exports, name)) {
/******/ 			Object.defineProperty(exports, name, { enumerable: true, get: getter });
/******/ 		}
/******/ 	};
/******/
/******/ 	// define __esModule on exports
/******/ 	__webpack_require__.r = function(exports) {
/******/ 		if(typeof Symbol !== 'undefined' && Symbol.toStringTag) {
/******/ 			Object.defineProperty(exports, Symbol.toStringTag, { value: 'Module' });
/******/ 		}
/******/ 		Object.defineProperty(exports, '__esModule', { value: true });
/******/ 	};
/******/
/******/ 	// create a fake namespace object
/******/ 	// mode & 1: value is a module id, require it
/******/ 	// mode & 2: merge all properties of value into the ns
/******/ 	// mode & 4: return value when already ns object
/******/ 	// mode & 8|1: behave like require
/******/ 	__webpack_require__.t = function(value, mode) {
/******/ 		if(mode & 1) value = __webpack_require__(value);
/******/ 		if(mode & 8) return value;
/******/ 		if((mode & 4) && typeof value === 'object' && value && value.__esModule) return value;
/******/ 		var ns = Object.create(null);
/******/ 		__webpack_require__.r(ns);
/******/ 		Object.defineProperty(ns, 'default', { enumerable: true, value: value });
/******/ 		if(mode & 2 && typeof value != 'string') for(var key in value) __webpack_require__.d(ns, key, function(key) { return value[key]; }.bind(null, key));
/******/ 		return ns;
/******/ 	};
/******/
/******/ 	// getDefaultExport function for compatibility with non-harmony modules
/******/ 	__webpack_require__.n = function(module) {
/******/ 		var getter = module && module.__esModule ?
/******/ 			function getDefault() { return module['default']; } :
/******/ 			function getModuleExports() { return module; };
/******/ 		__webpack_require__.d(getter, 'a', getter);
/******/ 		return getter;
/******/ 	};
/******/
/******/ 	// Object.prototype.hasOwnProperty.call
/******/ 	__webpack_require__.o = function(object, property) { return Object.prototype.hasOwnProperty.call(object, property); };
/******/
/******/ 	// __webpack_public_path__
/******/ 	__webpack_require__.p = "/";
/******/
/******/
/******/ 	// Load entry module and return exports
/******/ 	return __webpack_require__(__webpack_require__.s = 12);
/******/ })
/************************************************************************/
/******/ ({

/***/ "./resources/js/http/owner/rooms.js":
/*!******************************************!*\
  !*** ./resources/js/http/owner/rooms.js ***!
  \******************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

__webpack_require__(/*! ../../utils/numberOnly.js */ "./resources/js/utils/numberOnly.js");

__webpack_require__(/*! ../../utils/formValidation.js */ "./resources/js/utils/formValidation.js");

if (!window.APP) {
  window.APP = {};
}

APP = {
  prevTableData: "",
  showTableData: function showTableData(tag) {
    //update button label
    $("#btn-location").html("<span class='ml-2 mr-2'>" + $(tag).html().trim() + "</span>"); //hide last table list

    APP.hideTableData(APP.prevTableData); //show new table list

    APP.prevTableData = $(tag).attr('table-data');
    $("#tbody_" + APP.prevTableData).removeClass('d-none');
  },
  hideTableData: function hideTableData(id) {
    $("#tbody_" + id).addClass('d-none');
  },
  hideAllTableData: function hideAllTableData() {
    $(".modal-filter-location").each(function (index, item) {
      APP.hideTableData($(item).attr('table-data'));
    });
  }
};
$(document).ready(function () {
  $('[data-toggle="tooltip"]').tooltip(); //init dropdown location for table data

  APP.hideAllTableData();
  APP.showTableData($(".modal-filter-location")[0]);
});

/***/ }),

/***/ "./resources/js/utils/formValidation.js":
/*!**********************************************!*\
  !*** ./resources/js/utils/formValidation.js ***!
  \**********************************************/
/*! no static exports found */
/***/ (function(module, exports) {

(function ($) {
  var ATTR_VALIDATE_TYPE = "validate";
  var ATTR_VALIDATE_TYPE_SEPARATOR = "|";
  var ATTR_VALIDATE_TOGGLE = "validate-toggle";
  var ATTR_VALIDATE_ERROR = "validate-error";
  var validationFunctions = {
    email: function email(value) {
      return /^(.*)@(.*)\.(.*)$/.test(value);
    },
    phone: function phone(value) {
      return /^(([0-9+\s-]{1,4})(\s|-)){0,}([0-9+\s-]{1,4})$/g.test(value);
    },
    min: function min(digit, value) {
      return value >= parseInt(digit);
    },
    max: function max(digit, value) {
      return value <= parseInt(digit);
    },
    file: function file(value) {
      //we only validate empty or not
      return value.length > 0;
    },
    alphabet: function alphabet(value) {
      return /^[[:alpha:]\s]*$/g.test(value);
    },
    "in": function _in(src, value) {
      return value.length > 0 ? src.indexOf(value) > -1 : false;
    }
  };

  var validationHandler = function validationHandler(element) {
    var t_validation = $(element).attr(ATTR_VALIDATE_TYPE).split(ATTR_VALIDATE_TYPE_SEPARATOR);
    var validationResult = true;

    for (var i = 0; i < t_validation.length; i++) {
      if (t_validation[i].toLowerCase() == "email") {
        validationResult &= validationFunctions.email($(element).val());
      } else if (t_validation[i].toLowerCase() == "phone") {
        validationResult &= validationFunctions.phone($(element).val());
      } else if (t_validation[i].toLowerCase().includes("min:")) {
        var props = t_validation[i].split(":");
        validationResult &= validationFunctions.min(props[1], $(element).val().length);
      } else if (t_validation[i].toLowerCase().includes("max:")) {
        var _props = t_validation[i].split(":"); //check if we should check file size for <input type="file" />


        if ($(element).attr('type').toLowerCase() == "file") {
          //check if file provided
          if (element.files[0]) {
            validationResult &= validationFunctions.max(_props[1], element.files[0].size);
          } else {
            validationResult &= false;
          }
        } else {
          validationResult &= validationFunctions.max(_props[1], $(element).val().length);
        }
      } else if (t_validation[i].toLowerCase().includes("file")) {
        validationResult &= validationFunctions.file($(element).val());
      } else if (t_validation[i].toLowerCase().includes("alphabet")) {
        validationResult &= validationFunctions.file($(element).val());
      } else if (t_validation[i].toLowerCase().includes("in:")) {
        try {
          var _props2 = t_validation[i].split(":");

          validationResult &= validationFunctions["in"](_props2[1], $(element).val());
        } catch (e) {
          validationResult &= false;
        }
      }
    }

    return validationResult;
  };

  $.fn.requireValidation = function (callbacks) {
    var frm = $(this);
    frm.submit(function () {
      //call before validation
      if (callbacks.beforeValidation) {
        callbacks.beforeValidation(frm);
      }

      var valid = true;
      var inputFields = $(this).find("[" + ATTR_VALIDATE_TYPE + "]");
      var focusTarget = false;

      for (var i = 0; i < inputFields.length; i++) {
        if ($(inputFields[i]).attr(ATTR_VALIDATE_TYPE)) {
          var hasErrorMsg = $(inputFields[i]).attr(ATTR_VALIDATE_ERROR);
          var isValid = validationHandler(inputFields[i]);

          if (!isValid) {
            $(inputFields[i]).addClass("invalid");
            $(hasErrorMsg).removeClass('d-none');

            if (callbacks.onInvalidFoundCallback) {
              callbacks.onInvalidFoundCallback(inputFields[i]);
            }
          } else {
            $(inputFields[i]).removeClass("invalid");
            $(hasErrorMsg).addClass('d-none');

            if (callbacks.onValidFoundCallback) {
              callbacks.onValidFoundCallback(inputFields[i]);
            }
          }

          valid &= isValid;

          if (callbacks.onValidateResult) {
            callbacks.onValidateResult(valid);
          }
        }
      }

      if (valid) {
        return true;
      }

      return false;
    });
  };
})(jQuery);

/***/ }),

/***/ "./resources/js/utils/numberOnly.js":
/*!******************************************!*\
  !*** ./resources/js/utils/numberOnly.js ***!
  \******************************************/
/*! no static exports found */
/***/ (function(module, exports) {

(function ($) {
  $.fn.inputFilter = function (inputFilter) {
    return this.on("input keydown keyup mousedown mouseup select contextmenu drop", function () {
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

  $.fn.inputFilterPhoneFormat = function () {
    return this.inputFilter(function (value) {
      if (/\-{2,}/.test(value)) return false;
      return value.length > 0 ? /^([0-9\-]){1,}$/.test(value) : true;
    });
  };

  $.fn.inputFilterPhone = function () {
    var hasNonPhoneChar = function hasNonPhoneChar(value) {
      return /([^0-9-\s+])/g.test(value);
    };

    var isValidPhoneFormat = function isValidPhoneFormat(value) {
      return /^(([0-9+\s-]{1,4})(\s|-)){0,}([0-9+\s-]{1,4})$/g.test(value);
    };

    var applyFormat = function applyFormat(value) {
      //if not reach 4 digit, do nothing
      if (value.length <= 4) return value; //we group each 4 digit including (+)

      trimmed = value.trim().replace(/[\s-]/g, "");
      formatted = "";

      while (trimmed.length > 4) {
        formatted += formatted.length > 0 ? " " : "";
        formatted += trimmed.substring(0, 4);
        trimmed = trimmed.substring(4, trimmed.length);
      }

      formatted += formatted.length > 0 ? " " : "";
      formatted += trimmed;
      return formatted;
    };

    return this.on("input keydown keyup mousedown mouseup select contextmenu drop", function () {
      //check if has non phone characters
      if (hasNonPhoneChar(this.value)) {
        if (this.hasOwnProperty("oldValue")) {
          this.value = this.oldValue;
          this.setSelectionRange(this.oldSelectionStart, this.oldSelectionEnd);
        } else {
          this.value = "";
        }
      } //assume no non-phone characters exists.
      //check its valid phone format
      else if (!isValidPhoneFormat(this.value)) {
          var f_currency = applyFormat(this.value);
          this.oldSelectionStart = f_currency.length;
          this.oldSelectionEnd = f_currency.length;
          this.value = f_currency;
        } //assume valid phone format
        else {
            this.oldValue = this.value;
            this.oldSelectionStart = this.selectionStart;
            this.oldSelectionEnd = this.selectionEnd;
          }
    });
  };

  $.fn.inputFilterNumber = function () {
    return this.on("input keydown keyup mousedown mouseup select contextmenu drop", function () {
      if (/^\d*$/.test(this.value)) {
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

  $.fn.inputFilterCurrency = function () {
    var isValidCurrencyFormat = function isValidCurrencyFormat(value) {
      return /^(?=.*\d)^\$?(([1-9]\d{0,2}(,\d{3})*)|0)?(\.\d{1,})?$/g.test(value);
    };

    var hasNonCurrencyChars = function hasNonCurrencyChars(value) {
      return /([^0-9.,])/g.test(value);
    };

    var formatCurrency = function formatCurrency(value) {
      //if not reach 3 digit, do nothing
      if (value.length <= 3) return value;
      var t_decimal = "";
      var t_float = ""; //check if has float number

      if (/[.]/.test(value)) {
        //split decimal and float number
        var valueArray = value.split(".");
        var _t_decimal = valueArray[0];
        var _t_float = valueArray[1];
      } else {
        t_decimal = value;
        t_float = false;
      } //replace number separator from decimal


      t_decimal = t_decimal.replace(/[,]/g, ""); //add decimal separator

      var t_mask = "";

      while (t_decimal.length > 3) {
        var t_char = t_decimal.substring(t_decimal.length - 3, t_decimal.length);
        t_mask = t_char + (t_mask ? "," + t_mask : "");
        t_decimal = t_decimal.substring(0, t_decimal.length - 3);
      } //combine float


      return t_decimal + "," + t_mask + (t_float ? "." + t_float : "");
    };

    return this.on("input keydown keyup mousedown mouseup select contextmenu drop", function () {
      //check if has non currency characters
      if (hasNonCurrencyChars(this.value)) {
        if (this.hasOwnProperty("oldValue")) {
          this.value = this.oldValue;
          this.setSelectionRange(this.oldSelectionStart, this.oldSelectionEnd);
        } else {
          this.value = "";
        }
      } //assume no non-currency characters exists.
      //check its currency format
      else if (!isValidCurrencyFormat(this.value)) {
          var f_currency = formatCurrency(this.value);
          this.oldSelectionStart = f_currency.length;
          this.oldSelectionEnd = f_currency.length;
          this.value = f_currency;
        } //assume valid currency format
        else {
            this.oldValue = this.value;
            this.oldSelectionStart = this.selectionStart;
            this.oldSelectionEnd = this.selectionEnd;
          }
    });
  };
})(jQuery);

/***/ }),

/***/ 12:
/*!************************************************!*\
  !*** multi ./resources/js/http/owner/rooms.js ***!
  \************************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

module.exports = __webpack_require__(/*! /home/admin/kosan/kosan-server-http/resources/js/http/owner/rooms.js */"./resources/js/http/owner/rooms.js");


/***/ })

/******/ });