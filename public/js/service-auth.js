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
/******/ 	return __webpack_require__(__webpack_require__.s = 6);
/******/ })
/************************************************************************/
/******/ ({

/***/ "./resources/js/oauth/oauth-facebook.js":
/*!**********************************************!*\
  !*** ./resources/js/oauth/oauth-facebook.js ***!
  \**********************************************/
/*! no static exports found */
/***/ (function(module, exports) {

if (window.oauth == null) {
  window.oauth = {};
}

window.oauth.facebook = {
  options: [],
  start: function start(options) {
    FB.init({
      appId: options.app.id,
      cookie: options.app.cookie,
      xfbml: options.app.xfbml,
      version: options.app.version
    });
    oauth.facebook.options = options;
    options.buttons.forEach(oauth.facebook.attachClickHandler);
  },
  attachClickHandler: function attachClickHandler(button) {
    $(button).click(function () {
      FB.login(function (response) {
        if (response.authResponse) {
          oauth.facebook.checkAuthToken(response.authResponse.accessToken);
        }
      }, {
        scope: 'email'
      });
    });
  },
  checkAuthToken: function checkAuthToken(authToken) {
    var options = oauth.facebook.options;
    window.location = options["verify_url"] + "/" + authToken;
  }
};

/***/ }),

/***/ "./resources/js/oauth/oauth-google.js":
/*!********************************************!*\
  !*** ./resources/js/oauth/oauth-google.js ***!
  \********************************************/
/*! no static exports found */
/***/ (function(module, exports) {

if (window.oauth == null) {
  window.oauth = {};
}

window.oauth.google = {
  options: [],
  start: function start(options) {
    gapi.load('auth2', function () {
      auth2 = gapi.auth2.init({
        client_id: options.google_client_id,
        cookiepolicy: 'single_host_origin'
      });
      options.buttons.forEach(oauth.google.attach); //set options

      oauth.google.options = options;
    });
  },
  attach: function attach(button) {
    auth2.attachClickHandler(button, {}, function (googleUser) {
      oauth.google.checkGoogleAccountToken(googleUser.getAuthResponse().id_token);
    });
  },
  checkGoogleAccountToken: function checkGoogleAccountToken(googleAccountToken) {
    var options = oauth.google.options;
    window.location = options["verify_url"] + "/" + googleAccountToken;
  }
};

/***/ }),

/***/ "./resources/js/oauth/oauth.js":
/*!*************************************!*\
  !*** ./resources/js/oauth/oauth.js ***!
  \*************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

//in html require below script before calling this script
//<script src="https://apis.google.com/js/api:client.js"></script>
__webpack_require__(/*! ./oauth-google.js */ "./resources/js/oauth/oauth-google.js"); //in html require below script before calling this script
//<script async defer src="https://connect.facebook.net/en_US/sdk.js"></script>


__webpack_require__(/*! ./oauth-facebook.js */ "./resources/js/oauth/oauth-facebook.js");

/***/ }),

/***/ "./resources/js/service-auth.js":
/*!**************************************!*\
  !*** ./resources/js/service-auth.js ***!
  \**************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

__webpack_require__(/*! ./oauth/oauth.js */ "./resources/js/oauth/oauth.js");

/***/ }),

/***/ 6:
/*!********************************************!*\
  !*** multi ./resources/js/service-auth.js ***!
  \********************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

module.exports = __webpack_require__(/*! /home/admin/kosan/kosan-server-http/resources/js/service-auth.js */"./resources/js/service-auth.js");


/***/ })

/******/ });