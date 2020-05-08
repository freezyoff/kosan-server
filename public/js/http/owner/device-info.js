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
/******/ 	return __webpack_require__(__webpack_require__.s = 8);
/******/ })
/************************************************************************/
/******/ ({

/***/ "./resources/js/http/owner/device-info.js":
/*!************************************************!*\
  !*** ./resources/js/http/owner/device-info.js ***!
  \************************************************/
/*! no static exports found */
/***/ (function(module, exports) {

var ShellFactory = Kosan.ShellFactory,
    Server = Kosan.Server,
    Listener = {
  isConnected: function isConnected() {
    return Time.now() - _lastRecievedMessage > 60;
  },
  init: function init(url) {
    Server.listen(url, this.onMessageArrive.bind(Listener));
    setInterval(this.updateTimestamp, 3000);
  },
  onMessageArrive: function onMessageArrive(client, topic, message) {
    //topic: "kosan/user/<email-md5>/device/<mac-md5>/state/<os|io|config>"
    topic = topic.split("/");
    _lastRecievedMessage = Time.now();
    if (topic[6] == 'os') this.updateStateOS(message.toString());else if (topic[6] == 'config') this.updateStateConfig(message.toString());else if (topic[6] == 'io') {
      var pp = message.toString().split("\n");
      console.log(pp);
    }
  },
  updateStateOS: function updateStateOS(msgStr) {
    var shellOS = ShellFactory.makeOS(msgStr);
    SysUpdate.updateProperties(shellOS);
    SysRAM.updateProperties(shellOS);
    SysFirmware.updateProperties(shellOS);
    SysFS.updateProperties(shellOS);
    SysGeneral.updateProperties(shellOS);
  },
  updateStateConfig: function updateStateConfig(msgStr) {
    //SysWan.updateProperties(config);
    msgStr.split(/\r?\n/).forEach(function (line) {
      if (line.startsWith("#ntp")) SysNTP.updateProperties(ShellFactory.makeNTP(line));else if (line.startsWith("#nwst")) SysWan.updateProperties(ShellFactory.makeWifiST(line));else if (line.startsWith("#nwap")) Wifi.updateProperties(ShellFactory.makeWifiAP(line));
    });
  },
  updateTimestamp: function updateTimestamp() {
    SysUpdate.updateTimestamp();
    SysRAM.updateTimestamp();
    SysFS.updateTimestamp();
    SysFirmware.updateTimestamp();
  }
},
    SysRAM = {
  theChart: null,
  updateTimer: Time.now(),
  data: {
    labels: ['-12s', '-9s', '-6s', '-3s', '0s'],
    series: [[0, 0, 0, 0, 0], //current free heap
    [0, 0, 0, 0, 0] //current free heap
    ]
  },
  options: {
    lineSmooth: Chartist.Interpolation.cardinal({
      tension: 0
    }),
    fullWidth: true,
    low: 0,
    high: 0,
    chartPadding: {
      right: 40
    }
  },
  init: function init(chartCollection) {
    chartCollection['ram'] = new Chartist.Line('#system-health-chart', this.data, this.options);
    this.theChart = chartCollection['ram'];
  },
  updateProperties: function updateProperties(osState) {
    if (!this.theChart) {
      this.init(Charts);
    } //used heap


    var info = osState.ram;
    this.data.series[0].push(info.used / 1000);
    this.data.series[0] = this.data.series[0].length > 5 ? this.data.series[0].slice(1) : this.data.series[0];
    this.data.series[1].push(info.fragments * info.size / 100 / 1000);
    this.data.series[1] = this.data.series[1].length > 5 ? this.data.series[1].slice(1) : this.data.series[1];
    var iteration = 0;

    while (this.options.high < Math.round(info.size / 1000)) {
      this.options.high = 10 ^ iteration++;
    } //this.options.high = Math.round(info.size/1000);


    this.theChart.update(this.data, this.options, true);
    $('#sys-ram-size').html(numberSeparator(info.size) + " Bytes");
    $('#sys-ram-usage').html(numberSeparator(info.used) + " Bytes");
    $('#sys-ram-free').html(numberSeparator(info.free) + " Bytes");
    $('#sys-ram-fragments').html(info.fragments + "%");
    this.updateTimer = Time.now();
  },
  updateTimestamp: function updateTimestamp() {
    $('#sys-ram-timestamp').html("data ".concat(toHumanElapsedTime(this.updateTimer)));
  }
},
    SysFirmware = {
  theChart: null,
  updateTimer: Time.now(),
  data: {
    series: []
  },
  options: {
    chartPadding: 0
  },
  init: function init(chartCollections) {
    var chartKey = "firmware";
    var chartEL = '#sys-firmware-chart';
    chartCollections[chartKey] = new Chartist.Pie(chartEL, this.data, this.options);
    this.theChart = chartCollections[chartKey];
  },
  updateProperties: function updateProperties(stateOS) {
    var iUpdate = stateOS.update;
    var iFirmware = stateOS.firmware;
    var iType = iUpdate.available ? 'update' : 'info'; //init chart

    if (!this.theChart) {
      this.init(Charts);
    }

    $('#sys-firmware-version-device').html(iFirmware.version);
    $('#sys-firmware-info-size').html(numberSeparator(iFirmware.size) + " Bytes");
    $('#sys-firmware-info-used').html(numberSeparator(iFirmware.used) + " Bytes");
    $('#sys-firmware-info-free').html(numberSeparator(iFirmware.free) + " Bytes");
    $('#sys-firmware-progress').html("0 Bytes");
    this.data.series[0] = (iFirmware.used / iFirmware.size * 100).toFixed(2);
    this.data.series[1] = (iFirmware.free / iFirmware.size * 100).toFixed(2); //update in progress

    if (iType == 'update') {
      //add data series
      this.data.series[2] = (iUpdate.progress / iFirmware.size * 100).toFixed(2); //change the free

      $('#sys-firmware-info-free').html(numberSeparator(iFirmware.free - iUpdate.progress) + " Bytes");
      this.data.series[1] = ((iFirmware.free - iUpdate.progress) / iFirmware.size * 100).toFixed(2); //set the update

      $('#sys-firmware-progress').html(numberSeparator(iUpdate.progress) + " Bytes");
    }

    this.theChart.update(this.data, this.options, true);
    this.updateTimer = Time.now();
  },
  updateTimestamp: function updateTimestamp() {
    $('#sys-firmware-timestamp').html("data ".concat(toHumanElapsedTime(this.updateTimer)));
  }
},
    SysFS = {
  theChart: null,
  updateTimer: Time.now(),
  data: {
    series: []
  },
  options: {
    chartPadding: 0
  },
  init: function init(chartCollections) {
    chartCollections['storage'] = new Chartist.Pie('#sys-fs-chart', this.data, this.options);
    this.theChart = chartCollections['storage'];
  },
  updateProperties: function updateProperties(stateOS) {
    if (!this.theChart) {
      this.init(Charts);
    }

    var info = stateOS.filesystem;
    $('#sys-fs-size').html(numberSeparator(info.size) + " Bytes");
    $('#sys-fs-usage').html(numberSeparator(info.used) + " Bytes");
    $('#sys-fs-free').html(numberSeparator(info.free) + " Bytes");
    this.data.series[0] = (info.used / info.size * 100).toFixed(2);
    this.data.series[1] = (info.free / info.size * 100).toFixed(2);
    this.theChart.update(this.data, this.options, true);
    this.updateTimer = Time.now();
  },
  updateTimestamp: function updateTimestamp() {
    $('#sys-fs-timestamp').html("data ".concat(toHumanElapsedTime(this.updateTimer)));
  }
},
    SysUpdate = {
  updateTimer: Time.now(),
  updateProperties: function updateProperties(stateOS) {
    this.updateTimer = Time.now(); //check if update in progress (download started), 

    var iUpdate = stateOS.update; //check if update available, if not do nothing

    $("#sys-update-available").addClass(iUpdate.available ? '' : 'd-none').removeClass(iUpdate.available ? 'd-none' : '');
    $("#sys-update-unavailable").addClass(iUpdate.available ? 'd-none' : 'd-flex').removeClass(iUpdate.available ? 'd-flex' : 'd-none');

    if (!iUpdate.available) {
      return;
    }

    var iFirmware = stateOS.firmware;
    $("#sys-update-server-hash").html(iFirmware.updateVersion);
    $("#sys-update-server-hash-tooltips").html(iFirmware.updateVersion).attr('data-original-title', iFirmware.updateVersion);
    /*
    $("#sys-update-device-size").html(numberSeparator(iFirmware.used) + " Bytes");
    $("#sys-update-server-size").html(numberSeparator(iFirmware.updateSize) + " Bytes");
    */
    //device will info no update yet, because device not check it yet

    var isUpdateInProgress = iUpdate.available; //if update in progress

    if (isUpdateInProgress) {
      //show progress info
      $("#sys-update-download-info").removeClass('d-none'); //update percentage

      var percent = Math.round(iUpdate.progress / iUpdate.size * 100);
      $("#sys-update-download-info-progressbar").attr('data-percentage', percent);
      $("#sys-update-download-info-label").html("".concat(percent, "%"));
      $("#sys-update-download-info-progress").html(numberSeparator(iUpdate.progress) + " Bytes");
      $("#sys-update-download-info-remaining").html(numberSeparator(iUpdate.remaining) + " Bytes");
    } else {
      //show download button
      $("#sys-update-download-info").addClass('d-none');
    }
  },
  updateTimestamp: function updateTimestamp() {
    $('#sys-update-timestamp').html("data ".concat(toHumanElapsedTime(this.updateTimer)));
  }
},
    SysGeneral = {
  updateProperties: function updateProperties(stateOS) {
    var iFirmware = stateOS.firmware;
    $("#sys-general-device-hash").html(iFirmware.version);
    $("#sys-general-device-hash-tooltips").html(iFirmware.version).attr('data-original-title', iFirmware.version);
  }
},
    SysWan = {
  updateTimer: Time.now(),
  _init_: false,
  addSwapListener: function addSwapListener() {
    this._init_ = true;
    var inp = $("#sys-wan-ssid-inp").focusout(function () {
      labelContainer.removeClass('d-none');
      inpContainer.addClass('d-none');
    });
    var label = $("#sys-wan-ssid");
    var inpContainer = $(".sys-wan-ssid-lp");
    var labelContainer = $(".sys-wan-ssid-lb").click(function () {
      console.log(label.html().trim());
      inp.val(label.html().trim());
      labelContainer.addClass('d-none');
      inpContainer.removeClass('d-none');
      setTimeout(function () {
        inp.focus();
      }, 200);
    });
  },
  sendConfig: function sendConfig(shellConfig) {},
  updateProperties: function updateProperties(wifist) {
    if (!this._init_) this.addSwapListener();
    $("#sys-wan-ssid").html(wifist.ssid);
    var pwdMask = "";

    for (var i = 0; i < wifist.pwd.length; i++) {
      pwdMask += "*";
    }

    $("#sys-wan-pwd").html(pwdMask);
  },
  updateTimestamp: function updateTimestamp() {}
},
    SysNTP = {
  updateTimer: Time.now(),
  updateProperties: function updateProperties(ntp) {
    $("#sys-ntp-server1").html(ntp.servers[0]);
    $("#sys-ntp-server2").html(ntp.servers[1]);
    $("#sys-ntp-server3").html(ntp.servers[2]);
  }
},
    Wifi = {
  updateProperties: function updateProperties(wifist) {
    $("#wifi-ssid").html(wifist.ssid); //$("#wifi-pwd").html(wifist.pwd);

    $("#wifi-ip").html(wifist.ip4);
    $("#wifi-gateway").html(wifist.gateway);
    $("#wifi-subnet").html(wifist.subnet);
    $("#wifi-hidden").html(wifist.hidden);
    $("#wifi-maxclient").html(wifist.maxClient);
  }
},
    Command = {
  topics: {
    cmd: "kosan/owner/<email-md5>/device/<mac-md5>/command"
  },
  restart: function restart(owner, device) {
    var topic = this.topics.cmd.replace("<email-md5>", owner).replace("<mac-md5>", device);
    Server.send(topic, "#restart");
  },
  //javascript-obfuscator:disable
  init: function init() {
    $("#restart").click(function () {
      var owner = $(this).attr('owner');
      var device = $(this).attr('device');
      Command.restart(owner, device);
    });
  }
};

if (!window.Kosan) {
  window.Kosan = {};
}

Kosan.Owner = {
  deviceStatistics: function deviceStatistics(configUrl) {
    Listener.init(configUrl);
    Command.init();
  }
};

/***/ }),

/***/ 8:
/*!******************************************************!*\
  !*** multi ./resources/js/http/owner/device-info.js ***!
  \******************************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

module.exports = __webpack_require__(/*! /home/admin/kosan/kosan-server-http/resources/js/http/owner/device-info.js */"./resources/js/http/owner/device-info.js");


/***/ })

/******/ });