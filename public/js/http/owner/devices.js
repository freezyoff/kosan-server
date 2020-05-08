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
/******/ 	return __webpack_require__(__webpack_require__.s = 9);
/******/ })
/************************************************************************/
/******/ ({

/***/ "./resources/js/http/owner/devices.js":
/*!********************************************!*\
  !*** ./resources/js/http/owner/devices.js ***!
  \********************************************/
/*! no static exports found */
/***/ (function(module, exports) {

if (!window.APP) {
  window.APP = {};
}

window.APP = {
  init: function init(url) {
    Kosan.Server.listen(url, OnMessageArrive);
  },
  add: function add(item) {
    this.devices.push(item);
  },
  restart: function restart(owner, device) {
    var cmd = "kosan/owner/<email-md5>/device/<mac-md5>/command";
    var topic = cmd.replace("<email-md5>", owner).replace("<mac-md5>", device);
    Kosan.Server.send(topic, "#restart");
  },
  devices: [],
  devices_touch_timer: {},
  devices_state_mode: {}
};

var OnMessageArrive = function (client, topic, message) {
  topic = topic.split("/"); //record arrive time

  this.devices_touch_timer[topic[4]] = now(); //record mode

  var shellOS = Kosan.ShellFactory.makeOS(message.toString());
  this.devices_state_mode[topic[4]] = shellOS ? shellOS.mode : 0;
}.bind(APP);

var Loop = function () {
  for (var i = 0; i < this.devices.length; i++) {
    var cdevice = this.devices[i];
    var isConnected = false;

    if (this.devices_touch_timer) {
      isConnected = now() - this.devices_touch_timer[cdevice] < 3;
    }

    $('#' + this.devices[i] + '-icon').html(isConnected ? 'router' : 'sync_problem').parent().parent().removeClass(isConnected ? 'card-header-secondary' : 'card-header-success').addClass(isConnected ? 'card-header-success' : 'card-header-secondary');
    UpdateLastConnected(i, isConnected);
    UpdateStateMode(i, isConnected);
  }
}.bind(APP);

var UpdateLastConnected = function (idx, isConnected) {
  var timestamp = this.devices_touch_timer[this.devices[idx]];
  var span = $("<span></span>").addClass('badge ' + (isConnected ? 'badge-success' : "badge-secondary"));
  var div = $('#' + this.devices[idx] + '-con-last').empty();
  var t = Time.elapsed(timestamp);

  if (t.diff <= 3) {
    div.append(span.html("baru saja"));
  } else if (!isConnected) {
    div.append(span.html("tidak terkoneksi"));
  } else {
    var str = "";
    if (t.days) str = t.days + " hari ";
    if (t.hours) str += t.hours + " jam ";
    if (t.minutes) str += t.minutes + " menit ";
    if (t.seconds) str += t.seconds + " detik ";
    div.append(span.html(str + " yang lalu"));
  }
}.bind(APP);

var UpdateStateMode = function (idx, isConnected) {
  var mode = ["tidak diketahui", "melayani", "melayani & download update"];
  var modeIdx = isConnected ? this.devices_state_mode[this.devices[idx]] : 0;
  $('#' + this.devices[idx] + '-con-mode').empty().append($("<span></span>").html(mode[modeIdx]).addClass('badge ' + (isConnected ? 'badge-success' : 'badge-secondary')));
}.bind(APP);

$(document).ready(function () {
  setInterval(Loop, 3000);
});

/***/ }),

/***/ 9:
/*!**************************************************!*\
  !*** multi ./resources/js/http/owner/devices.js ***!
  \**************************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

module.exports = __webpack_require__(/*! /home/admin/kosan/kosan-server-http/resources/js/http/owner/devices.js */"./resources/js/http/owner/devices.js");


/***/ })

/******/ });