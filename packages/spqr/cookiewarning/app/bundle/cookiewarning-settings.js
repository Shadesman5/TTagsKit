/******/ (function(modules) { // webpackBootstrap
/******/ 	// The module cache
/******/ 	var installedModules = {};

/******/ 	// The require function
/******/ 	function __webpack_require__(moduleId) {

/******/ 		// Check if module is in cache
/******/ 		if(installedModules[moduleId])
/******/ 			return installedModules[moduleId].exports;

/******/ 		// Create a new module (and put it into the cache)
/******/ 		var module = installedModules[moduleId] = {
/******/ 			exports: {},
/******/ 			id: moduleId,
/******/ 			loaded: false
/******/ 		};

/******/ 		// Execute the module function
/******/ 		modules[moduleId].call(module.exports, module, module.exports, __webpack_require__);

/******/ 		// Flag the module as loaded
/******/ 		module.loaded = true;

/******/ 		// Return the exports of the module
/******/ 		return module.exports;
/******/ 	}


/******/ 	// expose the modules object (__webpack_modules__)
/******/ 	__webpack_require__.m = modules;

/******/ 	// expose the module cache
/******/ 	__webpack_require__.c = installedModules;

/******/ 	// __webpack_public_path__
/******/ 	__webpack_require__.p = "";

/******/ 	// Load entry module and return exports
/******/ 	return __webpack_require__(0);
/******/ })
/************************************************************************/
/******/ ([
/* 0 */
/***/ function(module, exports, __webpack_require__) {

	var __vue_script__, __vue_template__
	var __vue_styles__ = {}
	__vue_script__ = __webpack_require__(1)
	if (Object.keys(__vue_script__).some(function (key) { return key !== "default" && key !== "__esModule" })) {
	  console.warn("[vue-loader] app/components/cookiewarning-settings.vue: named exports in *.vue files are ignored.")}
	__vue_template__ = __webpack_require__(2)
	module.exports = __vue_script__ || {}
	if (module.exports.__esModule) module.exports = module.exports.default
	var __vue_options__ = typeof module.exports === "function" ? (module.exports.options || (module.exports.options = {})) : module.exports
	if (__vue_template__) {
	__vue_options__.template = __vue_template__
	}
	if (!__vue_options__.computed) __vue_options__.computed = {}
	Object.keys(__vue_styles__).forEach(function (key) {
	var module = __vue_styles__[key]
	__vue_options__.computed[key] = function () { return module }
	})
	if (false) {(function () {  module.hot.accept()
	  var hotAPI = require("vue-hot-reload-api")
	  hotAPI.install(require("vue"), false)
	  if (!hotAPI.compatible) return
	  var id = "_v-c8ab4332/cookiewarning-settings.vue"
	  if (!module.hot.data) {
	    hotAPI.createRecord(id, module.exports)
	  } else {
	    hotAPI.update(id, module.exports, __vue_template__)
	  }
	})()}

/***/ },
/* 1 */
/***/ function(module, exports) {

	'use strict';

	module.exports = {

		settings: true,

		props: ['package'],

		methods: {
			save: function save() {
				this.$http.post('admin/system/settings/config', {
					name: 'spqr/cookiewarning',
					config: this.package.config
				}).then(function () {
					this.$notify('Settings saved.', '');
				}).catch(function (response) {
					this.$notify(response.message, 'danger');
				}).finally(function () {
					this.$parent.close();
				});
			}
		}
	};

	window.Extensions.components['cookiewarning-settings'] = module.exports;

/***/ },
/* 2 */
/***/ function(module, exports) {

	module.exports = "\n<div class=\"uk-form uk-form-horizontal\">\n    <h1>{{ 'Cookiewarning Settings' | trans }}</h1>\n    <div class=\"uk-form-row\">\n        <label for=\"form-position\" class=\"uk-form-label\">{{ 'Position' | trans }}</label>\n        <div class=\"uk-form-controls\">\n            <select id=\"form-position\" class=\"uk-form-width-medium\" v-model=\"package.config.position\">\n                <option value=\"bottom\">{{ 'Bottom' | trans }}</option>\n                <option value=\"top\">{{ 'Top' | trans }}</option>\n                <option value=\"bottom-left\">{{ 'Bottom-Left' | trans }}</option>\n                <option value=\"bottom-right\">{{ 'Bottom-Right' | trans }}</option>\n            </select>\n        </div>\n    </div>\n    <div class=\"uk-form-row\">\n        <label for=\"form-theme\" class=\"uk-form-label\">{{ 'Theme' | trans }}</label>\n        <div class=\"uk-form-controls\">\n            <select id=\"form-theme\" class=\"uk-form-width-medium\" v-model=\"package.config.theme\">\n                <option value=\"classic\">{{ 'Classic' | trans }}</option>\n                <option value=\"block\">{{ 'Block' | trans }}</option>\n                <option value=\"edgeless\">{{ 'Edgeless' | trans }}</option>\n            </select>\n        </div>\n    </div>\n    <div class=\"uk-form-row\">\n        <label class=\"uk-form-label\">{{ 'Popup-Background-Colour' | trans }}</label>\n        <div class=\"uk-form-controls uk-form-controls-text\">\n            <p class=\"uk-form-controls-condensed\">\n                <input type=\"text\" class=\"uk-form-width-medium\" placeholder=\"#000000\" v-model=\"package.config.popup.backgroundcolour\">\n            </p>\n        </div>\n    </div>\n    <div class=\"uk-form-row\">\n        <label class=\"uk-form-label\">{{ 'Popup-Text-Colour' | trans }}</label>\n        <div class=\"uk-form-controls uk-form-controls-text\">\n            <p class=\"uk-form-controls-condensed\">\n                <input type=\"text\" class=\"uk-form-width-medium\" placeholder=\"#000000\" v-model=\"package.config.popup.textcolour\">\n            </p>\n        </div>\n    </div>\n    <div class=\"uk-form-row\">\n        <label class=\"uk-form-label\">{{ 'Button-Background-Colour' | trans }}</label>\n        <div class=\"uk-form-controls uk-form-controls-text\">\n            <p class=\"uk-form-controls-condensed\">\n                <input type=\"text\" class=\"uk-form-width-medium\" placeholder=\"#000000\" v-model=\"package.config.button.backgroundcolour\">\n            </p>\n        </div>\n    </div>\n    <div class=\"uk-form-row\">\n        <label class=\"uk-form-label\">{{ 'Button-Text-Colour' | trans }}</label>\n        <div class=\"uk-form-controls uk-form-controls-text\">\n            <p class=\"uk-form-controls-condensed\">\n                <input type=\"text\" class=\"uk-form-width-medium\" placeholder=\"#000000\" v-model=\"package.config.button.textcolour\">\n            </p>\n        </div>\n    </div>\n    <div class=\"uk-form-row\">\n        <label class=\"uk-form-label\">{{ 'Message' | trans }}</label>\n        <div class=\"uk-form-controls uk-form-controls-text\">\n            <p class=\"uk-form-controls-condensed\">\n                <input type=\"text\" class=\"uk-form-width-medium\" placeholder=\"{{ 'Overwrite message' | trans }}\" v-model=\"package.config.message\">\n            </p>\n        </div>\n    </div>\n    <div class=\"uk-form-row\">\n        <label class=\"uk-form-label\">{{ 'Dismiss-Button-Text' | trans }}</label>\n        <div class=\"uk-form-controls uk-form-controls-text\">\n            <p class=\"uk-form-controls-condensed\">\n                <input type=\"text\" class=\"uk-form-width-medium\" placeholder=\"{{ 'Overwrite dismiss-button' | trans }}\"v-model=\"package.config.dismissbuttontext\">\n            </p>\n        </div>\n    </div>\n    <div class=\"uk-form-row\">\n        <label class=\"uk-form-label\">{{ 'Policy URL' | trans }}</label>\n        <div class=\"uk-form-controls uk-form-controls-text\">\n            <p class=\"uk-form-controls-condensed\">\n                <input-link id=\"form-redirect\" class=\"uk-form-width-medium\" :link.sync=\"package.config.url\"></input-link>\n            </p>\n        </div>\n    </div>\n    <div class=\"uk-form-row\">\n        <label class=\"uk-form-label\">{{ 'Policy-Link-Text' | trans }}</label>\n        <div class=\"uk-form-controls uk-form-controls-text\">\n            <p class=\"uk-form-controls-condensed\">\n                <input type=\"text\" class=\"uk-form-width-medium\" placeholder=\"{{ 'Overwrite Policy-Link-Text' | trans }}\" v-model=\"package.config.policytext\">\n            </p>\n        </div>\n    </div>\n    <div class=\"uk-form-row uk-margin-top\">\n        <div class=\"uk-form-controls\">\n            <button class=\"uk-button uk-button-primary\" @click=\"save\">{{ 'Save' | trans }}</button>\n        </div>\n    </div>\n</div>\n";

/***/ }
/******/ ]);