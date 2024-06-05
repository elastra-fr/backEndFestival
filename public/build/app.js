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
//# sourceMappingURL=data:application/json;charset=utf-8;base64,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Q0FBQ0wsZ0ZBQXNCLENBQUNHLE9BQU8sQ0FBQyxDQUFDOzs7Ozs7Ozs7Ozs7Ozs7Ozs7Ozs7Ozs7Ozs7Ozs7Ozs7Ozs7Ozs7Ozs7Ozs7Ozs7Ozs7Ozs7Ozs7Ozs7Ozs7Ozs7Ozs7Ozs7Ozs7Ozs7Ozs7OztBQ0xEOztBQUVoRDtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFSQSxJQUFBSSxRQUFBLDBCQUFBQyxXQUFBO0VBQUEsU0FBQUQsU0FBQTtJQUFBRSxlQUFBLE9BQUFGLFFBQUE7SUFBQSxPQUFBRyxVQUFBLE9BQUFILFFBQUEsRUFBQUksU0FBQTtFQUFBO0VBQUFDLFNBQUEsQ0FBQUwsUUFBQSxFQUFBQyxXQUFBO0VBQUEsT0FBQUssWUFBQSxDQUFBTixRQUFBO0lBQUFPLEdBQUE7SUFBQUMsS0FBQSxFQVVJLFNBQUFDLFFBQUEsRUFBVTtNQUNOLElBQUksQ0FBQ0MsT0FBTyxDQUFDQyxXQUFXLEdBQUcsbUVBQW1FO0lBQ2xHO0VBQUM7QUFBQSxFQUh3QlosMkRBQVU7Ozs7Ozs7Ozs7Ozs7QUNYdkMiLCJzb3VyY2VzIjpbIndlYnBhY2s6Ly8vLi9hc3NldHMvY29udHJvbGxlcnMvIHN5bmMgXFwuanMkIiwid2VicGFjazovLy8uL2Fzc2V0cy9hcHAuanMiLCJ3ZWJwYWNrOi8vLy4vYXNzZXRzL2Jvb3RzdHJhcC5qcyIsIndlYnBhY2s6Ly8vLi9hc3NldHMvY29udHJvbGxlcnMvaGVsbG9fY29udHJvbGxlci5qcyIsIndlYnBhY2s6Ly8vLi9hc3NldHMvc3R5bGVzL2FwcC5jc3MiXSwic291cmNlc0NvbnRlbnQiOlsidmFyIG1hcCA9IHtcblx0XCIuL2hlbGxvX2NvbnRyb2xsZXIuanNcIjogXCIuL2Fzc2V0cy9jb250cm9sbGVycy9oZWxsb19jb250cm9sbGVyLmpzXCJcbn07XG5cblxuZnVuY3Rpb24gd2VicGFja0NvbnRleHQocmVxKSB7XG5cdHZhciBpZCA9IHdlYnBhY2tDb250ZXh0UmVzb2x2ZShyZXEpO1xuXHRyZXR1cm4gX193ZWJwYWNrX3JlcXVpcmVfXyhpZCk7XG59XG5mdW5jdGlvbiB3ZWJwYWNrQ29udGV4dFJlc29sdmUocmVxKSB7XG5cdGlmKCFfX3dlYnBhY2tfcmVxdWlyZV9fLm8obWFwLCByZXEpKSB7XG5cdFx0dmFyIGUgPSBuZXcgRXJyb3IoXCJDYW5ub3QgZmluZCBtb2R1bGUgJ1wiICsgcmVxICsgXCInXCIpO1xuXHRcdGUuY29kZSA9ICdNT0RVTEVfTk9UX0ZPVU5EJztcblx0XHR0aHJvdyBlO1xuXHR9XG5cdHJldHVybiBtYXBbcmVxXTtcbn1cbndlYnBhY2tDb250ZXh0LmtleXMgPSBmdW5jdGlvbiB3ZWJwYWNrQ29udGV4dEtleXMoKSB7XG5cdHJldHVybiBPYmplY3Qua2V5cyhtYXApO1xufTtcbndlYnBhY2tDb250ZXh0LnJlc29sdmUgPSB3ZWJwYWNrQ29udGV4dFJlc29sdmU7XG5tb2R1bGUuZXhwb3J0cyA9IHdlYnBhY2tDb250ZXh0O1xud2VicGFja0NvbnRleHQuaWQgPSBcIi4vYXNzZXRzL2NvbnRyb2xsZXJzIHN5bmMgcmVjdXJzaXZlIFxcXFwuanMkXCI7IiwiXG5cbmltcG9ydCAnLi9ib290c3RyYXAuanMnO1xuLypcbiAqIFdlbGNvbWUgdG8geW91ciBhcHAncyBtYWluIEphdmFTY3JpcHQgZmlsZSFcbiAqXG4gKiBUaGlzIGZpbGUgd2lsbCBiZSBpbmNsdWRlZCBvbnRvIHRoZSBwYWdlIHZpYSB0aGUgaW1wb3J0bWFwKCkgVHdpZyBmdW5jdGlvbixcbiAqIHdoaWNoIHNob3VsZCBhbHJlYWR5IGJlIGluIHlvdXIgYmFzZS5odG1sLnR3aWcuXG4gKi9cbmltcG9ydCAnLi9zdHlsZXMvYXBwLmNzcyc7XG5cbi8vTWlzZSBlbiBwbGFjZSBsaXN0ZW5lciBwb3VyIGxlIGwnaW5wdXQgZmlsZVxuXG4vL2lmIChkb2N1bWVudC5nZXRFbGVtZW50QnlJZCgnYmFuZF9maWxlJykgIT09IG51bGwpe1xuXG5pZiAoZG9jdW1lbnQucXVlcnlTZWxlY3RvcignLmZvcm0tY29udHJvbC1maWxlJykgIT09IG51bGwpe1xuLy9zZWxlY3Rpb24gZGUgbCdpbnB1dCBmaWxlIHF1aSBhIGxhIGNsYXNzZSBmb3JtLWNvbnRyb2wtZmlsZVxuXG52YXIgZmlsZUlucHV0ID0gZG9jdW1lbnQucXVlcnlTZWxlY3RvcignLmZvcm0tY29udHJvbC1maWxlJyk7XG5cblxuZmlsZUlucHV0LmFkZEV2ZW50TGlzdGVuZXIoJ2NoYW5nZScsIGZ1bmN0aW9uIChlKSB7XG5cbmNvbnN0IGZpbGVJbnB1dCA9IGUudGFyZ2V0O1xuICAgICAgICAgICAgY29uc3QgZmlsZXMgPSBmaWxlSW5wdXQuZmlsZXM7XG4gICAgICAgICAgICBpZiAoZmlsZXMubGVuZ3RoID4gMCkge1xuICAgICAgICAgICAgICAgIGNvbnN0IGZpbGUgPSBmaWxlc1swXTtcbiAgICAgICAgICAgICAgICBjb25zdCByZWFkZXIgPSBuZXcgRmlsZVJlYWRlcigpO1xuICAgICAgICAgICAgICAgIHJlYWRlci5vbmxvYWQgPSBmdW5jdGlvbihlKSB7XG4gICAgICAgICAgICAgICAgICAgIGNvbnN0IGltYWdlUHJldmlldyA9IGRvY3VtZW50LmdldEVsZW1lbnRCeUlkKCdpbWFnZVByZXZpZXcnKTtcbiAgICAgICAgICAgICAgICAgICAgaW1hZ2VQcmV2aWV3LmlubmVySFRNTCA9IGA8aW1nIHNyYz1cIiR7ZS50YXJnZXQucmVzdWx0fVwiIGNsYXNzPVwicHJldmlld0ltYWdlXCIgYWx0PVwiUHJldmlld1wiPmA7XG4gICAgICAgICAgICAgICAgfTtcbiAgICAgICAgICAgICAgICByZWFkZXIucmVhZEFzRGF0YVVSTChmaWxlKTtcbiAgICAgICAgICAgIH0gZWxzZSB7XG4gICAgICAgICAgICAgICAgZG9jdW1lbnQuZ2V0RWxlbWVudEJ5SWQoJ2ltYWdlUHJldmlldycpLmlubmVySFRNTCA9ICcnO1xuICAgICAgICAgICAgfVxuXG5cbn0pO1xuXG59XG5cblxuLy9HZXN0aW9uIGRlIGxhIGNhcnRlIGxlYWZsZXRcblxuXG5cbmlmIChkb2N1bWVudC5nZXRFbGVtZW50QnlJZChcIm1hcFwiKSAhPT0gbnVsbCl7XG4gICAgY29uc29sZS5sb2coJ29rIG1hcCcpO1xuICAgIHZhciBteW1hcCA9IEwubWFwKCdtYXAnKS5zZXRWaWV3KFs0OC43Njg5LCAyLjA5NDU0XSwgMTQpO1xuICAgIC8vYWpvdXQgZGUgbGEgY2FydGVcbiAgICBMLnRpbGVMYXllcignaHR0cHM6Ly97c30udGlsZS5vcGVuc3RyZWV0bWFwLm9yZy97en0ve3h9L3t5fS5wbmcnLCB7XG4gICAgICAgIG1heFpvb206IDE5LFxuICAgIH0pLmFkZFRvKG15bWFwKTtcblxuLy9ham91dCBkJ3VuIG1hcmtlclxuXG52YXIgY2VudGVyTWFya2VyID0gTC5tYXJrZXIoWzQ4Ljc2ODksIDIuMDk0NTRdKS5hZGRUbyhteW1hcCk7XG5cblxuXG5cblxubXltYXAub24oJ2NvbnRleHRtZW51JywgZnVuY3Rpb24oZSkge1xuICAgIHZhciBsYXQgPSBlLmxhdGxuZy5sYXQ7XG4gICAgdmFyIGxuZyA9IGUubGF0bG5nLmxuZztcblxuICAgIGNvbnNvbGUubG9nKGxhdCArICcsICcgKyBsbmcpO1xufSk7XG5cblxuICBcbn1cbi8qXG5cbmRvY3VtZW50LmdldEVsZW1lbnRCeUlkKCdtYXAnKS5hZGRFdmVudExpc3RlbmVyKCdjb250ZXh0bWVudScsIGZ1bmN0aW9uIChlKSB7XG5cbiAgICBlLnByZXZlbnREZWZhdWx0KCk7XG5cbnZhciBsYXRsbmc9bWFwLm1vdXNlRXZlbnRUb0xhdExuZyhlKTtcbiAgLy8gICAgdmFyIGxhdCA9IGUubGF0bG5nLmxhdDtcbiAgICAvLyAgICB2YXIgbG5nID0gZS5sYXRsbmcubG5nO1xuXG5jb25zb2xlLmxvZyhsYXRsbmcpO1xuXG5cbn0pOyovXG4iLCJpbXBvcnQgeyBBcHBsaWNhdGlvbiB9IGZyb20gXCJzdGltdWx1c1wiO1xuaW1wb3J0IHsgZGVmaW5pdGlvbnNGcm9tQ29udGV4dCB9IGZyb20gXCJzdGltdWx1cy93ZWJwYWNrLWhlbHBlcnNcIjtcblxuY29uc3QgYXBwbGljYXRpb24gPSBBcHBsaWNhdGlvbi5zdGFydCgpO1xuY29uc3QgY29udGV4dCA9IHJlcXVpcmUuY29udGV4dChcIi4vY29udHJvbGxlcnNcIiwgdHJ1ZSwgL1xcLmpzJC8pO1xuYXBwbGljYXRpb24ubG9hZChkZWZpbml0aW9uc0Zyb21Db250ZXh0KGNvbnRleHQpKTtcblxuIiwiaW1wb3J0IHsgQ29udHJvbGxlciB9IGZyb20gJ0Bob3R3aXJlZC9zdGltdWx1cyc7XG5cbi8qXG4gKiBUaGlzIGlzIGFuIGV4YW1wbGUgU3RpbXVsdXMgY29udHJvbGxlciFcbiAqXG4gKiBBbnkgZWxlbWVudCB3aXRoIGEgZGF0YS1jb250cm9sbGVyPVwiaGVsbG9cIiBhdHRyaWJ1dGUgd2lsbCBjYXVzZVxuICogdGhpcyBjb250cm9sbGVyIHRvIGJlIGV4ZWN1dGVkLiBUaGUgbmFtZSBcImhlbGxvXCIgY29tZXMgZnJvbSB0aGUgZmlsZW5hbWU6XG4gKiBoZWxsb19jb250cm9sbGVyLmpzIC0+IFwiaGVsbG9cIlxuICpcbiAqIERlbGV0ZSB0aGlzIGZpbGUgb3IgYWRhcHQgaXQgZm9yIHlvdXIgdXNlIVxuICovXG5leHBvcnQgZGVmYXVsdCBjbGFzcyBleHRlbmRzIENvbnRyb2xsZXIge1xuICAgIGNvbm5lY3QoKSB7XG4gICAgICAgIHRoaXMuZWxlbWVudC50ZXh0Q29udGVudCA9ICdIZWxsbyBTdGltdWx1cyEgRWRpdCBtZSBpbiBhc3NldHMvY29udHJvbGxlcnMvaGVsbG9fY29udHJvbGxlci5qcyc7XG4gICAgfVxufVxuIiwiLy8gZXh0cmFjdGVkIGJ5IG1pbmktY3NzLWV4dHJhY3QtcGx1Z2luXG5leHBvcnQge307Il0sIm5hbWVzIjpbImRvY3VtZW50IiwicXVlcnlTZWxlY3RvciIsImZpbGVJbnB1dCIsImFkZEV2ZW50TGlzdGVuZXIiLCJlIiwidGFyZ2V0IiwiZmlsZXMiLCJsZW5ndGgiLCJmaWxlIiwicmVhZGVyIiwiRmlsZVJlYWRlciIsIm9ubG9hZCIsImltYWdlUHJldmlldyIsImdldEVsZW1lbnRCeUlkIiwiaW5uZXJIVE1MIiwiY29uY2F0IiwicmVzdWx0IiwicmVhZEFzRGF0YVVSTCIsImNvbnNvbGUiLCJsb2ciLCJteW1hcCIsIkwiLCJtYXAiLCJzZXRWaWV3IiwidGlsZUxheWVyIiwibWF4Wm9vbSIsImFkZFRvIiwiY2VudGVyTWFya2VyIiwibWFya2VyIiwib24iLCJsYXQiLCJsYXRsbmciLCJsbmciLCJBcHBsaWNhdGlvbiIsImRlZmluaXRpb25zRnJvbUNvbnRleHQiLCJhcHBsaWNhdGlvbiIsInN0YXJ0IiwiY29udGV4dCIsInJlcXVpcmUiLCJsb2FkIiwiQ29udHJvbGxlciIsIl9kZWZhdWx0IiwiX0NvbnRyb2xsZXIiLCJfY2xhc3NDYWxsQ2hlY2siLCJfY2FsbFN1cGVyIiwiYXJndW1lbnRzIiwiX2luaGVyaXRzIiwiX2NyZWF0ZUNsYXNzIiwia2V5IiwidmFsdWUiLCJjb25uZWN0IiwiZWxlbWVudCIsInRleHRDb250ZW50IiwiZGVmYXVsdCJdLCJzb3VyY2VSb290IjoiIn0=