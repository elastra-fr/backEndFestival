(self["webpackChunk"] = self["webpackChunk"] || []).push([["app"],{

/***/ "./assets/controllers sync recursive \\.js$":
/*!****************************************!*\
  !*** ./assets/controllers/ sync \.js$ ***!
  \****************************************/
/***/ ((module, __unused_webpack_exports, __webpack_require__) => {

var map = {
	"./hello_controller.js": "./assets/controllers/hello_controller.js"
};


function webpackContext(req) {
	var id = webpackContextResolve(req);
	return __webpack_require__(id);
}
function webpackContextResolve(req) {
	if(!__webpack_require__.o(map, req)) {
		var e = new Error("Cannot find module '" + req + "'");
		e.code = 'MODULE_NOT_FOUND';
		throw e;
	}
	return map[req];
}
webpackContext.keys = function webpackContextKeys() {
	return Object.keys(map);
};
webpackContext.resolve = webpackContextResolve;
module.exports = webpackContext;
webpackContext.id = "./assets/controllers sync recursive \\.js$";

/***/ }),

/***/ "./assets/app.js":
/*!***********************!*\
  !*** ./assets/app.js ***!
  \***********************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var core_js_modules_es_array_map_js__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! core-js/modules/es.array.map.js */ "./node_modules/core-js/modules/es.array.map.js");
/* harmony import */ var core_js_modules_es_array_map_js__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(core_js_modules_es_array_map_js__WEBPACK_IMPORTED_MODULE_0__);
/* harmony import */ var _bootstrap_js__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./bootstrap.js */ "./assets/bootstrap.js");
/* harmony import */ var _styles_app_css__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ./styles/app.css */ "./assets/styles/app.css");


/*
 * Welcome to your app's main JavaScript file!
 *
 * This file will be included onto the page via the importmap() Twig function,
 * which should already be in your base.html.twig.
 */


//Mise en place listener pour le l'input file

//if (document.getElementById('band_file') !== null){

if (document.querySelector('.form-control-file') !== null) {
  //selection de l'input file qui a la classe form-control-file

  var fileInput = document.querySelector('.form-control-file');
  fileInput.addEventListener('change', function (e) {
    var fileInput = e.target;
    var files = fileInput.files;
    if (files.length > 0) {
      var file = files[0];
      var reader = new FileReader();
      reader.onload = function (e) {
        var imagePreview = document.getElementById('imagePreview');
        imagePreview.innerHTML = "<img src=\"".concat(e.target.result, "\" class=\"previewImage\" alt=\"Preview\">");
      };
      reader.readAsDataURL(file);
    } else {
      document.getElementById('imagePreview').innerHTML = '';
    }
  });
}

//Gestion de la carte leaflet

if (document.getElementById("map") !== null) {
  console.log('ok map');
  var mymap = L.map('map').setView([48.7689, 2.09454], 14);
  //ajout de la carte
  L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
    maxZoom: 19
  }).addTo(mymap);

  //ajout d'un marker

  var centerMarker = L.marker([48.7689, 2.09454]).addTo(mymap);
  mymap.on('contextmenu', function (e) {
    var lat = e.latlng.lat;
    var lng = e.latlng.lng;
    console.log(lat + ', ' + lng);
  });
}
/*

document.getElementById('map').addEventListener('contextmenu', function (e) {

    e.preventDefault();

var latlng=map.mouseEventToLatLng(e);
  //    var lat = e.latlng.lat;
    //    var lng = e.latlng.lng;

console.log(latlng);


});*/

/***/ }),

/***/ "./assets/bootstrap.js":
/*!*****************************!*\
  !*** ./assets/bootstrap.js ***!
  \*****************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var stimulus__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! stimulus */ "./node_modules/stimulus/dist/stimulus.js");
/* harmony import */ var stimulus_webpack_helpers__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! stimulus/webpack-helpers */ "./node_modules/stimulus/dist/webpack-helpers.js");


var application = stimulus__WEBPACK_IMPORTED_MODULE_0__.Application.start();
var context = __webpack_require__("./assets/controllers sync recursive \\.js$");
application.load((0,stimulus_webpack_helpers__WEBPACK_IMPORTED_MODULE_1__.definitionsFromContext)(context));

/***/ }),

/***/ "./assets/controllers/hello_controller.js":
/*!************************************************!*\
  !*** ./assets/controllers/hello_controller.js ***!
  \************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (/* binding */ _default)
/* harmony export */ });
/* harmony import */ var core_js_modules_es_symbol_js__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! core-js/modules/es.symbol.js */ "./node_modules/core-js/modules/es.symbol.js");
/* harmony import */ var core_js_modules_es_symbol_js__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(core_js_modules_es_symbol_js__WEBPACK_IMPORTED_MODULE_0__);
/* harmony import */ var core_js_modules_es_symbol_description_js__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! core-js/modules/es.symbol.description.js */ "./node_modules/core-js/modules/es.symbol.description.js");
/* harmony import */ var core_js_modules_es_symbol_description_js__WEBPACK_IMPORTED_MODULE_1___default = /*#__PURE__*/__webpack_require__.n(core_js_modules_es_symbol_description_js__WEBPACK_IMPORTED_MODULE_1__);
/* harmony import */ var core_js_modules_es_symbol_iterator_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! core-js/modules/es.symbol.iterator.js */ "./node_modules/core-js/modules/es.symbol.iterator.js");
/* harmony import */ var core_js_modules_es_symbol_iterator_js__WEBPACK_IMPORTED_MODULE_2___default = /*#__PURE__*/__webpack_require__.n(core_js_modules_es_symbol_iterator_js__WEBPACK_IMPORTED_MODULE_2__);
/* harmony import */ var core_js_modules_es_symbol_to_primitive_js__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! core-js/modules/es.symbol.to-primitive.js */ "./node_modules/core-js/modules/es.symbol.to-primitive.js");
/* harmony import */ var core_js_modules_es_symbol_to_primitive_js__WEBPACK_IMPORTED_MODULE_3___default = /*#__PURE__*/__webpack_require__.n(core_js_modules_es_symbol_to_primitive_js__WEBPACK_IMPORTED_MODULE_3__);
/* harmony import */ var core_js_modules_es_error_cause_js__WEBPACK_IMPORTED_MODULE_4__ = __webpack_require__(/*! core-js/modules/es.error.cause.js */ "./node_modules/core-js/modules/es.error.cause.js");
/* harmony import */ var core_js_modules_es_error_cause_js__WEBPACK_IMPORTED_MODULE_4___default = /*#__PURE__*/__webpack_require__.n(core_js_modules_es_error_cause_js__WEBPACK_IMPORTED_MODULE_4__);
/* harmony import */ var core_js_modules_es_error_to_string_js__WEBPACK_IMPORTED_MODULE_5__ = __webpack_require__(/*! core-js/modules/es.error.to-string.js */ "./node_modules/core-js/modules/es.error.to-string.js");
/* harmony import */ var core_js_modules_es_error_to_string_js__WEBPACK_IMPORTED_MODULE_5___default = /*#__PURE__*/__webpack_require__.n(core_js_modules_es_error_to_string_js__WEBPACK_IMPORTED_MODULE_5__);
/* harmony import */ var core_js_modules_es_array_iterator_js__WEBPACK_IMPORTED_MODULE_6__ = __webpack_require__(/*! core-js/modules/es.array.iterator.js */ "./node_modules/core-js/modules/es.array.iterator.js");
/* harmony import */ var core_js_modules_es_array_iterator_js__WEBPACK_IMPORTED_MODULE_6___default = /*#__PURE__*/__webpack_require__.n(core_js_modules_es_array_iterator_js__WEBPACK_IMPORTED_MODULE_6__);
/* harmony import */ var core_js_modules_es_date_to_primitive_js__WEBPACK_IMPORTED_MODULE_7__ = __webpack_require__(/*! core-js/modules/es.date.to-primitive.js */ "./node_modules/core-js/modules/es.date.to-primitive.js");
/* harmony import */ var core_js_modules_es_date_to_primitive_js__WEBPACK_IMPORTED_MODULE_7___default = /*#__PURE__*/__webpack_require__.n(core_js_modules_es_date_to_primitive_js__WEBPACK_IMPORTED_MODULE_7__);
/* harmony import */ var core_js_modules_es_function_bind_js__WEBPACK_IMPORTED_MODULE_8__ = __webpack_require__(/*! core-js/modules/es.function.bind.js */ "./node_modules/core-js/modules/es.function.bind.js");
/* harmony import */ var core_js_modules_es_function_bind_js__WEBPACK_IMPORTED_MODULE_8___default = /*#__PURE__*/__webpack_require__.n(core_js_modules_es_function_bind_js__WEBPACK_IMPORTED_MODULE_8__);
/* harmony import */ var core_js_modules_es_number_constructor_js__WEBPACK_IMPORTED_MODULE_9__ = __webpack_require__(/*! core-js/modules/es.number.constructor.js */ "./node_modules/core-js/modules/es.number.constructor.js");
/* harmony import */ var core_js_modules_es_number_constructor_js__WEBPACK_IMPORTED_MODULE_9___default = /*#__PURE__*/__webpack_require__.n(core_js_modules_es_number_constructor_js__WEBPACK_IMPORTED_MODULE_9__);
/* harmony import */ var core_js_modules_es_object_create_js__WEBPACK_IMPORTED_MODULE_10__ = __webpack_require__(/*! core-js/modules/es.object.create.js */ "./node_modules/core-js/modules/es.object.create.js");
/* harmony import */ var core_js_modules_es_object_create_js__WEBPACK_IMPORTED_MODULE_10___default = /*#__PURE__*/__webpack_require__.n(core_js_modules_es_object_create_js__WEBPACK_IMPORTED_MODULE_10__);
/* harmony import */ var core_js_modules_es_object_define_property_js__WEBPACK_IMPORTED_MODULE_11__ = __webpack_require__(/*! core-js/modules/es.object.define-property.js */ "./node_modules/core-js/modules/es.object.define-property.js");
/* harmony import */ var core_js_modules_es_object_define_property_js__WEBPACK_IMPORTED_MODULE_11___default = /*#__PURE__*/__webpack_require__.n(core_js_modules_es_object_define_property_js__WEBPACK_IMPORTED_MODULE_11__);
/* harmony import */ var core_js_modules_es_object_get_prototype_of_js__WEBPACK_IMPORTED_MODULE_12__ = __webpack_require__(/*! core-js/modules/es.object.get-prototype-of.js */ "./node_modules/core-js/modules/es.object.get-prototype-of.js");
/* harmony import */ var core_js_modules_es_object_get_prototype_of_js__WEBPACK_IMPORTED_MODULE_12___default = /*#__PURE__*/__webpack_require__.n(core_js_modules_es_object_get_prototype_of_js__WEBPACK_IMPORTED_MODULE_12__);
/* harmony import */ var core_js_modules_es_object_set_prototype_of_js__WEBPACK_IMPORTED_MODULE_13__ = __webpack_require__(/*! core-js/modules/es.object.set-prototype-of.js */ "./node_modules/core-js/modules/es.object.set-prototype-of.js");
/* harmony import */ var core_js_modules_es_object_set_prototype_of_js__WEBPACK_IMPORTED_MODULE_13___default = /*#__PURE__*/__webpack_require__.n(core_js_modules_es_object_set_prototype_of_js__WEBPACK_IMPORTED_MODULE_13__);
/* harmony import */ var core_js_modules_es_object_to_string_js__WEBPACK_IMPORTED_MODULE_14__ = __webpack_require__(/*! core-js/modules/es.object.to-string.js */ "./node_modules/core-js/modules/es.object.to-string.js");
/* harmony import */ var core_js_modules_es_object_to_string_js__WEBPACK_IMPORTED_MODULE_14___default = /*#__PURE__*/__webpack_require__.n(core_js_modules_es_object_to_string_js__WEBPACK_IMPORTED_MODULE_14__);
/* harmony import */ var core_js_modules_es_reflect_construct_js__WEBPACK_IMPORTED_MODULE_15__ = __webpack_require__(/*! core-js/modules/es.reflect.construct.js */ "./node_modules/core-js/modules/es.reflect.construct.js");
/* harmony import */ var core_js_modules_es_reflect_construct_js__WEBPACK_IMPORTED_MODULE_15___default = /*#__PURE__*/__webpack_require__.n(core_js_modules_es_reflect_construct_js__WEBPACK_IMPORTED_MODULE_15__);
/* harmony import */ var core_js_modules_es_string_iterator_js__WEBPACK_IMPORTED_MODULE_16__ = __webpack_require__(/*! core-js/modules/es.string.iterator.js */ "./node_modules/core-js/modules/es.string.iterator.js");
/* harmony import */ var core_js_modules_es_string_iterator_js__WEBPACK_IMPORTED_MODULE_16___default = /*#__PURE__*/__webpack_require__.n(core_js_modules_es_string_iterator_js__WEBPACK_IMPORTED_MODULE_16__);
/* harmony import */ var core_js_modules_web_dom_collections_iterator_js__WEBPACK_IMPORTED_MODULE_17__ = __webpack_require__(/*! core-js/modules/web.dom-collections.iterator.js */ "./node_modules/core-js/modules/web.dom-collections.iterator.js");
/* harmony import */ var core_js_modules_web_dom_collections_iterator_js__WEBPACK_IMPORTED_MODULE_17___default = /*#__PURE__*/__webpack_require__.n(core_js_modules_web_dom_collections_iterator_js__WEBPACK_IMPORTED_MODULE_17__);
/* harmony import */ var _hotwired_stimulus__WEBPACK_IMPORTED_MODULE_18__ = __webpack_require__(/*! @hotwired/stimulus */ "./node_modules/@hotwired/stimulus/dist/stimulus.js");
function _typeof(o) { "@babel/helpers - typeof"; return _typeof = "function" == typeof Symbol && "symbol" == typeof Symbol.iterator ? function (o) { return typeof o; } : function (o) { return o && "function" == typeof Symbol && o.constructor === Symbol && o !== Symbol.prototype ? "symbol" : typeof o; }, _typeof(o); }


















function _classCallCheck(a, n) { if (!(a instanceof n)) throw new TypeError("Cannot call a class as a function"); }
function _defineProperties(e, r) { for (var t = 0; t < r.length; t++) { var o = r[t]; o.enumerable = o.enumerable || !1, o.configurable = !0, "value" in o && (o.writable = !0), Object.defineProperty(e, _toPropertyKey(o.key), o); } }
function _createClass(e, r, t) { return r && _defineProperties(e.prototype, r), t && _defineProperties(e, t), Object.defineProperty(e, "prototype", { writable: !1 }), e; }
function _toPropertyKey(t) { var i = _toPrimitive(t, "string"); return "symbol" == _typeof(i) ? i : i + ""; }
function _toPrimitive(t, r) { if ("object" != _typeof(t) || !t) return t; var e = t[Symbol.toPrimitive]; if (void 0 !== e) { var i = e.call(t, r || "default"); if ("object" != _typeof(i)) return i; throw new TypeError("@@toPrimitive must return a primitive value."); } return ("string" === r ? String : Number)(t); }
function _callSuper(t, o, e) { return o = _getPrototypeOf(o), _possibleConstructorReturn(t, _isNativeReflectConstruct() ? Reflect.construct(o, e || [], _getPrototypeOf(t).constructor) : o.apply(t, e)); }
function _possibleConstructorReturn(t, e) { if (e && ("object" == _typeof(e) || "function" == typeof e)) return e; if (void 0 !== e) throw new TypeError("Derived constructors may only return object or undefined"); return _assertThisInitialized(t); }
function _assertThisInitialized(e) { if (void 0 === e) throw new ReferenceError("this hasn't been initialised - super() hasn't been called"); return e; }
function _isNativeReflectConstruct() { try { var t = !Boolean.prototype.valueOf.call(Reflect.construct(Boolean, [], function () {})); } catch (t) {} return (_isNativeReflectConstruct = function _isNativeReflectConstruct() { return !!t; })(); }
function _getPrototypeOf(t) { return _getPrototypeOf = Object.setPrototypeOf ? Object.getPrototypeOf.bind() : function (t) { return t.__proto__ || Object.getPrototypeOf(t); }, _getPrototypeOf(t); }
function _inherits(t, e) { if ("function" != typeof e && null !== e) throw new TypeError("Super expression must either be null or a function"); t.prototype = Object.create(e && e.prototype, { constructor: { value: t, writable: !0, configurable: !0 } }), Object.defineProperty(t, "prototype", { writable: !1 }), e && _setPrototypeOf(t, e); }
function _setPrototypeOf(t, e) { return _setPrototypeOf = Object.setPrototypeOf ? Object.setPrototypeOf.bind() : function (t, e) { return t.__proto__ = e, t; }, _setPrototypeOf(t, e); }


/*
 * This is an example Stimulus controller!
 *
 * Any element with a data-controller="hello" attribute will cause
 * this controller to be executed. The name "hello" comes from the filename:
 * hello_controller.js -> "hello"
 *
 * Delete this file or adapt it for your use!
 */
var _default = /*#__PURE__*/function (_Controller) {
  function _default() {
    _classCallCheck(this, _default);
    return _callSuper(this, _default, arguments);
  }
  _inherits(_default, _Controller);
  return _createClass(_default, [{
    key: "connect",
    value: function connect() {
      this.element.textContent = 'Hello Stimulus! Edit me in assets/controllers/hello_controller.js';
    }
  }]);
}(_hotwired_stimulus__WEBPACK_IMPORTED_MODULE_18__.Controller);


/***/ }),

/***/ "./assets/styles/app.css":
/*!*******************************!*\
  !*** ./assets/styles/app.css ***!
  \*******************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
// extracted by mini-css-extract-plugin


/***/ })

},
/******/ __webpack_require__ => { // webpackRuntimeModules
/******/ var __webpack_exec__ = (moduleId) => (__webpack_require__(__webpack_require__.s = moduleId))
/******/ __webpack_require__.O(0, ["vendors-node_modules_hotwired_stimulus_dist_stimulus_js-node_modules_stimulus_dist_stimulus_j-971377"], () => (__webpack_exec__("./assets/app.js")));
/******/ var __webpack_exports__ = __webpack_require__.O();
/******/ }
]);
//# sourceMappingURL=data:application/json;charset=utf-8;base64,eyJ2ZXJzaW9uIjozLCJmaWxlIjoiYXBwLmpzIiwibWFwcGluZ3MiOiI7Ozs7Ozs7O0FBQUE7QUFDQTtBQUNBOzs7QUFHQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7Ozs7Ozs7Ozs7Ozs7Ozs7O0FDcEJ3QjtBQUN4QjtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDMEI7O0FBRTFCOztBQUVBOztBQUVBLElBQUlBLFFBQVEsQ0FBQ0MsYUFBYSxDQUFDLG9CQUFvQixDQUFDLEtBQUssSUFBSSxFQUFDO0VBQzFEOztFQUVBLElBQUlDLFNBQVMsR0FBR0YsUUFBUSxDQUFDQyxhQUFhLENBQUMsb0JBQW9CLENBQUM7RUFHNURDLFNBQVMsQ0FBQ0MsZ0JBQWdCLENBQUMsUUFBUSxFQUFFLFVBQVVDLENBQUMsRUFBRTtJQUVsRCxJQUFNRixTQUFTLEdBQUdFLENBQUMsQ0FBQ0MsTUFBTTtJQUNkLElBQU1DLEtBQUssR0FBR0osU0FBUyxDQUFDSSxLQUFLO0lBQzdCLElBQUlBLEtBQUssQ0FBQ0MsTUFBTSxHQUFHLENBQUMsRUFBRTtNQUNsQixJQUFNQyxJQUFJLEdBQUdGLEtBQUssQ0FBQyxDQUFDLENBQUM7TUFDckIsSUFBTUcsTUFBTSxHQUFHLElBQUlDLFVBQVUsQ0FBQyxDQUFDO01BQy9CRCxNQUFNLENBQUNFLE1BQU0sR0FBRyxVQUFTUCxDQUFDLEVBQUU7UUFDeEIsSUFBTVEsWUFBWSxHQUFHWixRQUFRLENBQUNhLGNBQWMsQ0FBQyxjQUFjLENBQUM7UUFDNURELFlBQVksQ0FBQ0UsU0FBUyxpQkFBQUMsTUFBQSxDQUFnQlgsQ0FBQyxDQUFDQyxNQUFNLENBQUNXLE1BQU0sK0NBQXVDO01BQ2hHLENBQUM7TUFDRFAsTUFBTSxDQUFDUSxhQUFhLENBQUNULElBQUksQ0FBQztJQUM5QixDQUFDLE1BQU07TUFDSFIsUUFBUSxDQUFDYSxjQUFjLENBQUMsY0FBYyxDQUFDLENBQUNDLFNBQVMsR0FBRyxFQUFFO0lBQzFEO0VBR1osQ0FBQyxDQUFDO0FBRUY7O0FBR0E7O0FBSUEsSUFBSWQsUUFBUSxDQUFDYSxjQUFjLENBQUMsS0FBSyxDQUFDLEtBQUssSUFBSSxFQUFDO0VBQ3hDSyxPQUFPLENBQUNDLEdBQUcsQ0FBQyxRQUFRLENBQUM7RUFDckIsSUFBSUMsS0FBSyxHQUFHQyxDQUFDLENBQUNDLEdBQUcsQ0FBQyxLQUFLLENBQUMsQ0FBQ0MsT0FBTyxDQUFDLENBQUMsT0FBTyxFQUFFLE9BQU8sQ0FBQyxFQUFFLEVBQUUsQ0FBQztFQUN4RDtFQUNBRixDQUFDLENBQUNHLFNBQVMsQ0FBQyxvREFBb0QsRUFBRTtJQUM5REMsT0FBTyxFQUFFO0VBQ2IsQ0FBQyxDQUFDLENBQUNDLEtBQUssQ0FBQ04sS0FBSyxDQUFDOztFQUVuQjs7RUFFQSxJQUFJTyxZQUFZLEdBQUdOLENBQUMsQ0FBQ08sTUFBTSxDQUFDLENBQUMsT0FBTyxFQUFFLE9BQU8sQ0FBQyxDQUFDLENBQUNGLEtBQUssQ0FBQ04sS0FBSyxDQUFDO0VBTTVEQSxLQUFLLENBQUNTLEVBQUUsQ0FBQyxhQUFhLEVBQUUsVUFBU3pCLENBQUMsRUFBRTtJQUNoQyxJQUFJMEIsR0FBRyxHQUFHMUIsQ0FBQyxDQUFDMkIsTUFBTSxDQUFDRCxHQUFHO0lBQ3RCLElBQUlFLEdBQUcsR0FBRzVCLENBQUMsQ0FBQzJCLE1BQU0sQ0FBQ0MsR0FBRztJQUV0QmQsT0FBTyxDQUFDQyxHQUFHLENBQUNXLEdBQUcsR0FBRyxJQUFJLEdBQUdFLEdBQUcsQ0FBQztFQUNqQyxDQUFDLENBQUM7QUFJRjtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7Ozs7Ozs7Ozs7Ozs7O0FDdEZ1QztBQUMyQjtBQUVsRSxJQUFNRyxXQUFXLEdBQUdGLGlEQUFXLENBQUNHLEtBQUssQ0FBQyxDQUFDO0FBQ3ZDLElBQU1DLE9BQU8sR0FBR0MsaUVBQStDO0FBQy9ESCxXQUFXLENBQUNJLElBQUksQ0FBQ0wsZ0ZBQXNCLENBQUNHLE9BQU8sQ0FBQyxDQUFDOzs7Ozs7Ozs7Ozs7Ozs7Ozs7Ozs7Ozs7Ozs7Ozs7Ozs7Ozs7Ozs7Ozs7Ozs7Ozs7Ozs7Ozs7Ozs7Ozs7Ozs7Ozs7Ozs7Ozs7Ozs7Ozs7Ozs7OztBQ0xEOztBQUVoRDtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFSQSxJQUFBSSxRQUFBLDBCQUFBQyxXQUFBO0VBQUEsU0FBQUQsU0FBQTtJQUFBRSxlQUFBLE9BQUFGLFFBQUE7SUFBQSxPQUFBRyxVQUFBLE9BQUFILFFBQUEsRUFBQUksU0FBQTtFQUFBO0VBQUFDLFNBQUEsQ0FBQUwsUUFBQSxFQUFBQyxXQUFBO0VBQUEsT0FBQUssWUFBQSxDQUFBTixRQUFBO0lBQUFPLEdBQUE7SUFBQUMsS0FBQSxFQVVJLFNBQUFDLFFBQUEsRUFBVTtNQUNOLElBQUksQ0FBQ0MsT0FBTyxDQUFDQyxXQUFXLEdBQUcsbUVBQW1FO0lBQ2xHO0VBQUM7QUFBQSxFQUh3QlosMkRBQVU7Ozs7Ozs7Ozs7Ozs7QUNYdkMiLCJzb3VyY2VzIjpbIndlYnBhY2s6Ly8vLi9hc3NldHMvY29udHJvbGxlcnMvIHN5bmMgXFwuanMkIiwid2VicGFjazovLy8uL2Fzc2V0cy9hcHAuanMiLCJ3ZWJwYWNrOi8vLy4vYXNzZXRzL2Jvb3RzdHJhcC5qcyIsIndlYnBhY2s6Ly8vLi9hc3NldHMvY29udHJvbGxlcnMvaGVsbG9fY29udHJvbGxlci5qcyIsIndlYnBhY2s6Ly8vLi9hc3NldHMvc3R5bGVzL2FwcC5jc3M/M2ZiYSJdLCJzb3VyY2VzQ29udGVudCI6WyJ2YXIgbWFwID0ge1xuXHRcIi4vaGVsbG9fY29udHJvbGxlci5qc1wiOiBcIi4vYXNzZXRzL2NvbnRyb2xsZXJzL2hlbGxvX2NvbnRyb2xsZXIuanNcIlxufTtcblxuXG5mdW5jdGlvbiB3ZWJwYWNrQ29udGV4dChyZXEpIHtcblx0dmFyIGlkID0gd2VicGFja0NvbnRleHRSZXNvbHZlKHJlcSk7XG5cdHJldHVybiBfX3dlYnBhY2tfcmVxdWlyZV9fKGlkKTtcbn1cbmZ1bmN0aW9uIHdlYnBhY2tDb250ZXh0UmVzb2x2ZShyZXEpIHtcblx0aWYoIV9fd2VicGFja19yZXF1aXJlX18ubyhtYXAsIHJlcSkpIHtcblx0XHR2YXIgZSA9IG5ldyBFcnJvcihcIkNhbm5vdCBmaW5kIG1vZHVsZSAnXCIgKyByZXEgKyBcIidcIik7XG5cdFx0ZS5jb2RlID0gJ01PRFVMRV9OT1RfRk9VTkQnO1xuXHRcdHRocm93IGU7XG5cdH1cblx0cmV0dXJuIG1hcFtyZXFdO1xufVxud2VicGFja0NvbnRleHQua2V5cyA9IGZ1bmN0aW9uIHdlYnBhY2tDb250ZXh0S2V5cygpIHtcblx0cmV0dXJuIE9iamVjdC5rZXlzKG1hcCk7XG59O1xud2VicGFja0NvbnRleHQucmVzb2x2ZSA9IHdlYnBhY2tDb250ZXh0UmVzb2x2ZTtcbm1vZHVsZS5leHBvcnRzID0gd2VicGFja0NvbnRleHQ7XG53ZWJwYWNrQ29udGV4dC5pZCA9IFwiLi9hc3NldHMvY29udHJvbGxlcnMgc3luYyByZWN1cnNpdmUgXFxcXC5qcyRcIjsiLCJcblxuaW1wb3J0ICcuL2Jvb3RzdHJhcC5qcyc7XG4vKlxuICogV2VsY29tZSB0byB5b3VyIGFwcCdzIG1haW4gSmF2YVNjcmlwdCBmaWxlIVxuICpcbiAqIFRoaXMgZmlsZSB3aWxsIGJlIGluY2x1ZGVkIG9udG8gdGhlIHBhZ2UgdmlhIHRoZSBpbXBvcnRtYXAoKSBUd2lnIGZ1bmN0aW9uLFxuICogd2hpY2ggc2hvdWxkIGFscmVhZHkgYmUgaW4geW91ciBiYXNlLmh0bWwudHdpZy5cbiAqL1xuaW1wb3J0ICcuL3N0eWxlcy9hcHAuY3NzJztcblxuLy9NaXNlIGVuIHBsYWNlIGxpc3RlbmVyIHBvdXIgbGUgbCdpbnB1dCBmaWxlXG5cbi8vaWYgKGRvY3VtZW50LmdldEVsZW1lbnRCeUlkKCdiYW5kX2ZpbGUnKSAhPT0gbnVsbCl7XG5cbmlmIChkb2N1bWVudC5xdWVyeVNlbGVjdG9yKCcuZm9ybS1jb250cm9sLWZpbGUnKSAhPT0gbnVsbCl7XG4vL3NlbGVjdGlvbiBkZSBsJ2lucHV0IGZpbGUgcXVpIGEgbGEgY2xhc3NlIGZvcm0tY29udHJvbC1maWxlXG5cbnZhciBmaWxlSW5wdXQgPSBkb2N1bWVudC5xdWVyeVNlbGVjdG9yKCcuZm9ybS1jb250cm9sLWZpbGUnKTtcblxuXG5maWxlSW5wdXQuYWRkRXZlbnRMaXN0ZW5lcignY2hhbmdlJywgZnVuY3Rpb24gKGUpIHtcblxuY29uc3QgZmlsZUlucHV0ID0gZS50YXJnZXQ7XG4gICAgICAgICAgICBjb25zdCBmaWxlcyA9IGZpbGVJbnB1dC5maWxlcztcbiAgICAgICAgICAgIGlmIChmaWxlcy5sZW5ndGggPiAwKSB7XG4gICAgICAgICAgICAgICAgY29uc3QgZmlsZSA9IGZpbGVzWzBdO1xuICAgICAgICAgICAgICAgIGNvbnN0IHJlYWRlciA9IG5ldyBGaWxlUmVhZGVyKCk7XG4gICAgICAgICAgICAgICAgcmVhZGVyLm9ubG9hZCA9IGZ1bmN0aW9uKGUpIHtcbiAgICAgICAgICAgICAgICAgICAgY29uc3QgaW1hZ2VQcmV2aWV3ID0gZG9jdW1lbnQuZ2V0RWxlbWVudEJ5SWQoJ2ltYWdlUHJldmlldycpO1xuICAgICAgICAgICAgICAgICAgICBpbWFnZVByZXZpZXcuaW5uZXJIVE1MID0gYDxpbWcgc3JjPVwiJHtlLnRhcmdldC5yZXN1bHR9XCIgY2xhc3M9XCJwcmV2aWV3SW1hZ2VcIiBhbHQ9XCJQcmV2aWV3XCI+YDtcbiAgICAgICAgICAgICAgICB9O1xuICAgICAgICAgICAgICAgIHJlYWRlci5yZWFkQXNEYXRhVVJMKGZpbGUpO1xuICAgICAgICAgICAgfSBlbHNlIHtcbiAgICAgICAgICAgICAgICBkb2N1bWVudC5nZXRFbGVtZW50QnlJZCgnaW1hZ2VQcmV2aWV3JykuaW5uZXJIVE1MID0gJyc7XG4gICAgICAgICAgICB9XG5cblxufSk7XG5cbn1cblxuXG4vL0dlc3Rpb24gZGUgbGEgY2FydGUgbGVhZmxldFxuXG5cblxuaWYgKGRvY3VtZW50LmdldEVsZW1lbnRCeUlkKFwibWFwXCIpICE9PSBudWxsKXtcbiAgICBjb25zb2xlLmxvZygnb2sgbWFwJyk7XG4gICAgdmFyIG15bWFwID0gTC5tYXAoJ21hcCcpLnNldFZpZXcoWzQ4Ljc2ODksIDIuMDk0NTRdLCAxNCk7XG4gICAgLy9ham91dCBkZSBsYSBjYXJ0ZVxuICAgIEwudGlsZUxheWVyKCdodHRwczovL3tzfS50aWxlLm9wZW5zdHJlZXRtYXAub3JnL3t6fS97eH0ve3l9LnBuZycsIHtcbiAgICAgICAgbWF4Wm9vbTogMTksXG4gICAgfSkuYWRkVG8obXltYXApO1xuXG4vL2Fqb3V0IGQndW4gbWFya2VyXG5cbnZhciBjZW50ZXJNYXJrZXIgPSBMLm1hcmtlcihbNDguNzY4OSwgMi4wOTQ1NF0pLmFkZFRvKG15bWFwKTtcblxuXG5cblxuXG5teW1hcC5vbignY29udGV4dG1lbnUnLCBmdW5jdGlvbihlKSB7XG4gICAgdmFyIGxhdCA9IGUubGF0bG5nLmxhdDtcbiAgICB2YXIgbG5nID0gZS5sYXRsbmcubG5nO1xuXG4gICAgY29uc29sZS5sb2cobGF0ICsgJywgJyArIGxuZyk7XG59KTtcblxuXG4gIFxufVxuLypcblxuZG9jdW1lbnQuZ2V0RWxlbWVudEJ5SWQoJ21hcCcpLmFkZEV2ZW50TGlzdGVuZXIoJ2NvbnRleHRtZW51JywgZnVuY3Rpb24gKGUpIHtcblxuICAgIGUucHJldmVudERlZmF1bHQoKTtcblxudmFyIGxhdGxuZz1tYXAubW91c2VFdmVudFRvTGF0TG5nKGUpO1xuICAvLyAgICB2YXIgbGF0ID0gZS5sYXRsbmcubGF0O1xuICAgIC8vICAgIHZhciBsbmcgPSBlLmxhdGxuZy5sbmc7XG5cbmNvbnNvbGUubG9nKGxhdGxuZyk7XG5cblxufSk7Ki9cbiIsImltcG9ydCB7IEFwcGxpY2F0aW9uIH0gZnJvbSBcInN0aW11bHVzXCI7XG5pbXBvcnQgeyBkZWZpbml0aW9uc0Zyb21Db250ZXh0IH0gZnJvbSBcInN0aW11bHVzL3dlYnBhY2staGVscGVyc1wiO1xuXG5jb25zdCBhcHBsaWNhdGlvbiA9IEFwcGxpY2F0aW9uLnN0YXJ0KCk7XG5jb25zdCBjb250ZXh0ID0gcmVxdWlyZS5jb250ZXh0KFwiLi9jb250cm9sbGVyc1wiLCB0cnVlLCAvXFwuanMkLyk7XG5hcHBsaWNhdGlvbi5sb2FkKGRlZmluaXRpb25zRnJvbUNvbnRleHQoY29udGV4dCkpO1xuXG4iLCJpbXBvcnQgeyBDb250cm9sbGVyIH0gZnJvbSAnQGhvdHdpcmVkL3N0aW11bHVzJztcblxuLypcbiAqIFRoaXMgaXMgYW4gZXhhbXBsZSBTdGltdWx1cyBjb250cm9sbGVyIVxuICpcbiAqIEFueSBlbGVtZW50IHdpdGggYSBkYXRhLWNvbnRyb2xsZXI9XCJoZWxsb1wiIGF0dHJpYnV0ZSB3aWxsIGNhdXNlXG4gKiB0aGlzIGNvbnRyb2xsZXIgdG8gYmUgZXhlY3V0ZWQuIFRoZSBuYW1lIFwiaGVsbG9cIiBjb21lcyBmcm9tIHRoZSBmaWxlbmFtZTpcbiAqIGhlbGxvX2NvbnRyb2xsZXIuanMgLT4gXCJoZWxsb1wiXG4gKlxuICogRGVsZXRlIHRoaXMgZmlsZSBvciBhZGFwdCBpdCBmb3IgeW91ciB1c2UhXG4gKi9cbmV4cG9ydCBkZWZhdWx0IGNsYXNzIGV4dGVuZHMgQ29udHJvbGxlciB7XG4gICAgY29ubmVjdCgpIHtcbiAgICAgICAgdGhpcy5lbGVtZW50LnRleHRDb250ZW50ID0gJ0hlbGxvIFN0aW11bHVzISBFZGl0IG1lIGluIGFzc2V0cy9jb250cm9sbGVycy9oZWxsb19jb250cm9sbGVyLmpzJztcbiAgICB9XG59XG4iLCIvLyBleHRyYWN0ZWQgYnkgbWluaS1jc3MtZXh0cmFjdC1wbHVnaW5cbmV4cG9ydCB7fTsiXSwibmFtZXMiOlsiZG9jdW1lbnQiLCJxdWVyeVNlbGVjdG9yIiwiZmlsZUlucHV0IiwiYWRkRXZlbnRMaXN0ZW5lciIsImUiLCJ0YXJnZXQiLCJmaWxlcyIsImxlbmd0aCIsImZpbGUiLCJyZWFkZXIiLCJGaWxlUmVhZGVyIiwib25sb2FkIiwiaW1hZ2VQcmV2aWV3IiwiZ2V0RWxlbWVudEJ5SWQiLCJpbm5lckhUTUwiLCJjb25jYXQiLCJyZXN1bHQiLCJyZWFkQXNEYXRhVVJMIiwiY29uc29sZSIsImxvZyIsIm15bWFwIiwiTCIsIm1hcCIsInNldFZpZXciLCJ0aWxlTGF5ZXIiLCJtYXhab29tIiwiYWRkVG8iLCJjZW50ZXJNYXJrZXIiLCJtYXJrZXIiLCJvbiIsImxhdCIsImxhdGxuZyIsImxuZyIsIkFwcGxpY2F0aW9uIiwiZGVmaW5pdGlvbnNGcm9tQ29udGV4dCIsImFwcGxpY2F0aW9uIiwic3RhcnQiLCJjb250ZXh0IiwicmVxdWlyZSIsImxvYWQiLCJDb250cm9sbGVyIiwiX2RlZmF1bHQiLCJfQ29udHJvbGxlciIsIl9jbGFzc0NhbGxDaGVjayIsIl9jYWxsU3VwZXIiLCJhcmd1bWVudHMiLCJfaW5oZXJpdHMiLCJfY3JlYXRlQ2xhc3MiLCJrZXkiLCJ2YWx1ZSIsImNvbm5lY3QiLCJlbGVtZW50IiwidGV4dENvbnRlbnQiLCJkZWZhdWx0Il0sInNvdXJjZVJvb3QiOiIifQ==