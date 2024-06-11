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
/* harmony import */ var core_js_modules_es_symbol_js__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! core-js/modules/es.symbol.js */ "./node_modules/core-js/modules/es.symbol.js");
/* harmony import */ var core_js_modules_es_symbol_js__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(core_js_modules_es_symbol_js__WEBPACK_IMPORTED_MODULE_0__);
/* harmony import */ var core_js_modules_es_symbol_description_js__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! core-js/modules/es.symbol.description.js */ "./node_modules/core-js/modules/es.symbol.description.js");
/* harmony import */ var core_js_modules_es_symbol_description_js__WEBPACK_IMPORTED_MODULE_1___default = /*#__PURE__*/__webpack_require__.n(core_js_modules_es_symbol_description_js__WEBPACK_IMPORTED_MODULE_1__);
/* harmony import */ var core_js_modules_es_array_concat_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! core-js/modules/es.array.concat.js */ "./node_modules/core-js/modules/es.array.concat.js");
/* harmony import */ var core_js_modules_es_array_concat_js__WEBPACK_IMPORTED_MODULE_2___default = /*#__PURE__*/__webpack_require__.n(core_js_modules_es_array_concat_js__WEBPACK_IMPORTED_MODULE_2__);
/* harmony import */ var core_js_modules_es_array_for_each_js__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! core-js/modules/es.array.for-each.js */ "./node_modules/core-js/modules/es.array.for-each.js");
/* harmony import */ var core_js_modules_es_array_for_each_js__WEBPACK_IMPORTED_MODULE_3___default = /*#__PURE__*/__webpack_require__.n(core_js_modules_es_array_for_each_js__WEBPACK_IMPORTED_MODULE_3__);
/* harmony import */ var core_js_modules_es_array_map_js__WEBPACK_IMPORTED_MODULE_4__ = __webpack_require__(/*! core-js/modules/es.array.map.js */ "./node_modules/core-js/modules/es.array.map.js");
/* harmony import */ var core_js_modules_es_array_map_js__WEBPACK_IMPORTED_MODULE_4___default = /*#__PURE__*/__webpack_require__.n(core_js_modules_es_array_map_js__WEBPACK_IMPORTED_MODULE_4__);
/* harmony import */ var core_js_modules_es_number_to_fixed_js__WEBPACK_IMPORTED_MODULE_5__ = __webpack_require__(/*! core-js/modules/es.number.to-fixed.js */ "./node_modules/core-js/modules/es.number.to-fixed.js");
/* harmony import */ var core_js_modules_es_number_to_fixed_js__WEBPACK_IMPORTED_MODULE_5___default = /*#__PURE__*/__webpack_require__.n(core_js_modules_es_number_to_fixed_js__WEBPACK_IMPORTED_MODULE_5__);
/* harmony import */ var core_js_modules_es_object_to_string_js__WEBPACK_IMPORTED_MODULE_6__ = __webpack_require__(/*! core-js/modules/es.object.to-string.js */ "./node_modules/core-js/modules/es.object.to-string.js");
/* harmony import */ var core_js_modules_es_object_to_string_js__WEBPACK_IMPORTED_MODULE_6___default = /*#__PURE__*/__webpack_require__.n(core_js_modules_es_object_to_string_js__WEBPACK_IMPORTED_MODULE_6__);
/* harmony import */ var core_js_modules_es_parse_float_js__WEBPACK_IMPORTED_MODULE_7__ = __webpack_require__(/*! core-js/modules/es.parse-float.js */ "./node_modules/core-js/modules/es.parse-float.js");
/* harmony import */ var core_js_modules_es_parse_float_js__WEBPACK_IMPORTED_MODULE_7___default = /*#__PURE__*/__webpack_require__.n(core_js_modules_es_parse_float_js__WEBPACK_IMPORTED_MODULE_7__);
/* harmony import */ var core_js_modules_web_dom_collections_for_each_js__WEBPACK_IMPORTED_MODULE_8__ = __webpack_require__(/*! core-js/modules/web.dom-collections.for-each.js */ "./node_modules/core-js/modules/web.dom-collections.for-each.js");
/* harmony import */ var core_js_modules_web_dom_collections_for_each_js__WEBPACK_IMPORTED_MODULE_8___default = /*#__PURE__*/__webpack_require__.n(core_js_modules_web_dom_collections_for_each_js__WEBPACK_IMPORTED_MODULE_8__);
/* harmony import */ var _bootstrap_js__WEBPACK_IMPORTED_MODULE_9__ = __webpack_require__(/*! ./bootstrap.js */ "./assets/bootstrap.js");
/* harmony import */ var _styles_app_css__WEBPACK_IMPORTED_MODULE_10__ = __webpack_require__(/*! ./styles/app.css */ "./assets/styles/app.css");












// Fonction pour afficher l'image sélectionnée dans les formulaires groupes/artistes et partenaires
function displayImage(e) {
  var fileInput = e.target;
  var files = fileInput.files;
  if (files.length > 0) {
    var file = files[0];
    var reader = new FileReader();
    reader.onload = function (e) {
      var imagePreview = document.getElementById('imagePreview');
      imagePreview.innerHTML = "<img src=\"".concat(e.target.result, "\" class=\"previewImage\" alt=\"Preview\"><button type=\"button\" onclick=\"window.removeImage()\">Supprimer image</button>");
    };
    reader.readAsDataURL(file);
  } else {
    document.getElementById('imagePreview').innerHTML = '';
  }
}

// Fonction pour supprimer l'affichage de l'image
window.removeImage = function () {
  document.querySelector('.form-control-file').value = ''; // Réinitialise l'input file
  document.getElementById('imagePreview').innerHTML = ''; // Supprime le nom de l'image affiché
};

// Vérifie si un input file avec la classe .form-control-file existe
var fileInput = document.querySelector('.form-control-file');
if (fileInput !== null) {
  // Ajoute un écouteur d'événements onchange à l'input file
  fileInput.addEventListener('change', displayImage);
}

/**********************Gestion de la carte leaflet**********************/

console.log(mapPoints);
if (document.getElementById("map") !== null) {
  console.log('ok map');
  var mymap = L.map('map').setView([48.7689, 2.09454], 14);
  //ajout de la carte
  L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
    maxZoom: 19
  }).addTo(mymap);

  //ajout d'un marker

  var centerMarker = L.marker([48.7689, 2.09454]).addTo(mymap);
  centerMarker.bindPopup('Site du festival').openPopup();

  //ajout de tous les markers avec les coordonnées de mapPoints

  // Ajouter des marqueurs à la carte
  mapPoints.forEach(function (point) {
    var lat = parseFloat(point.latitude);
    var lng = parseFloat(point.longitude);
    var marker = L.marker([lat, lng]).addTo(mymap);
    // Ajouter un popup au marqueur avec titre et description
    marker.bindPopup("<b>".concat(point.title, "</b><br>").concat(point.description)).openPopup();
  });
  mymap.on('contextmenu', function (e) {
    var lat = parseFloat(e.latlng.lat).toFixed(7);
    var lng = parseFloat(e.latlng.lng).toFixed(7);
    console.log(lat + ', ' + lng);
    var latInput = document.getElementById('map_point_entity_Latitude');
    var lngInput = document.getElementById('map_point_entity_Longitude');
    latInput.value = lat;
    lngInput.value = lng;
  });
}

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
/******/ __webpack_require__.O(0, ["vendors-node_modules_hotwired_stimulus_dist_stimulus_js-node_modules_stimulus_dist_stimulus_j-d6c005"], () => (__webpack_exec__("./assets/app.js")));
/******/ var __webpack_exports__ = __webpack_require__.O();
/******/ }
]);
//# sourceMappingURL=data:application/json;charset=utf-8;base64,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QUFzQixDQUFDRyxPQUFPLENBQUMsQ0FBQzs7Ozs7Ozs7Ozs7Ozs7Ozs7Ozs7Ozs7Ozs7Ozs7Ozs7Ozs7Ozs7Ozs7Ozs7Ozs7Ozs7Ozs7Ozs7Ozs7Ozs7Ozs7Ozs7Ozs7Ozs7Ozs7Ozs7Ozs7QUNMRDs7QUFFaEQ7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBUkEsSUFBQUksUUFBQSwwQkFBQUMsV0FBQTtFQUFBLFNBQUFELFNBQUE7SUFBQUUsZUFBQSxPQUFBRixRQUFBO0lBQUEsT0FBQUcsVUFBQSxPQUFBSCxRQUFBLEVBQUFJLFNBQUE7RUFBQTtFQUFBQyxTQUFBLENBQUFMLFFBQUEsRUFBQUMsV0FBQTtFQUFBLE9BQUFLLFlBQUEsQ0FBQU4sUUFBQTtJQUFBTyxHQUFBO0lBQUE3QyxLQUFBLEVBVUksU0FBQThDLFFBQUEsRUFBVTtNQUNOLElBQUksQ0FBQ0MsT0FBTyxDQUFDQyxXQUFXLEdBQUcsbUVBQW1FO0lBQ2xHO0VBQUM7QUFBQSxFQUh3QlgsMkRBQVU7Ozs7Ozs7Ozs7Ozs7QUNYdkMiLCJzb3VyY2VzIjpbIndlYnBhY2s6Ly8vLi9hc3NldHMvY29udHJvbGxlcnMvIHN5bmMgXFwuanMkIiwid2VicGFjazovLy8uL2Fzc2V0cy9hcHAuanMiLCJ3ZWJwYWNrOi8vLy4vYXNzZXRzL2Jvb3RzdHJhcC5qcyIsIndlYnBhY2s6Ly8vLi9hc3NldHMvY29udHJvbGxlcnMvaGVsbG9fY29udHJvbGxlci5qcyIsIndlYnBhY2s6Ly8vLi9hc3NldHMvc3R5bGVzL2FwcC5jc3MiXSwic291cmNlc0NvbnRlbnQiOlsidmFyIG1hcCA9IHtcblx0XCIuL2hlbGxvX2NvbnRyb2xsZXIuanNcIjogXCIuL2Fzc2V0cy9jb250cm9sbGVycy9oZWxsb19jb250cm9sbGVyLmpzXCJcbn07XG5cblxuZnVuY3Rpb24gd2VicGFja0NvbnRleHQocmVxKSB7XG5cdHZhciBpZCA9IHdlYnBhY2tDb250ZXh0UmVzb2x2ZShyZXEpO1xuXHRyZXR1cm4gX193ZWJwYWNrX3JlcXVpcmVfXyhpZCk7XG59XG5mdW5jdGlvbiB3ZWJwYWNrQ29udGV4dFJlc29sdmUocmVxKSB7XG5cdGlmKCFfX3dlYnBhY2tfcmVxdWlyZV9fLm8obWFwLCByZXEpKSB7XG5cdFx0dmFyIGUgPSBuZXcgRXJyb3IoXCJDYW5ub3QgZmluZCBtb2R1bGUgJ1wiICsgcmVxICsgXCInXCIpO1xuXHRcdGUuY29kZSA9ICdNT0RVTEVfTk9UX0ZPVU5EJztcblx0XHR0aHJvdyBlO1xuXHR9XG5cdHJldHVybiBtYXBbcmVxXTtcbn1cbndlYnBhY2tDb250ZXh0LmtleXMgPSBmdW5jdGlvbiB3ZWJwYWNrQ29udGV4dEtleXMoKSB7XG5cdHJldHVybiBPYmplY3Qua2V5cyhtYXApO1xufTtcbndlYnBhY2tDb250ZXh0LnJlc29sdmUgPSB3ZWJwYWNrQ29udGV4dFJlc29sdmU7XG5tb2R1bGUuZXhwb3J0cyA9IHdlYnBhY2tDb250ZXh0O1xud2VicGFja0NvbnRleHQuaWQgPSBcIi4vYXNzZXRzL2NvbnRyb2xsZXJzIHN5bmMgcmVjdXJzaXZlIFxcXFwuanMkXCI7IiwiXG5cbmltcG9ydCAnLi9ib290c3RyYXAuanMnO1xuXG5pbXBvcnQgJy4vc3R5bGVzL2FwcC5jc3MnO1xuXG4vLyBGb25jdGlvbiBwb3VyIGFmZmljaGVyIGwnaW1hZ2Ugc8OpbGVjdGlvbm7DqWUgZGFucyBsZXMgZm9ybXVsYWlyZXMgZ3JvdXBlcy9hcnRpc3RlcyBldCBwYXJ0ZW5haXJlc1xuZnVuY3Rpb24gZGlzcGxheUltYWdlKGUpIHtcbiAgICBjb25zdCBmaWxlSW5wdXQgPSBlLnRhcmdldDtcbiAgICBjb25zdCBmaWxlcyA9IGZpbGVJbnB1dC5maWxlcztcbiAgICBpZiAoZmlsZXMubGVuZ3RoID4gMCkge1xuICAgICAgICBjb25zdCBmaWxlID0gZmlsZXNbMF07XG4gICAgICAgIGNvbnN0IHJlYWRlciA9IG5ldyBGaWxlUmVhZGVyKCk7XG4gICAgICAgIHJlYWRlci5vbmxvYWQgPSBmdW5jdGlvbihlKSB7XG4gICAgICAgICAgICBjb25zdCBpbWFnZVByZXZpZXcgPSBkb2N1bWVudC5nZXRFbGVtZW50QnlJZCgnaW1hZ2VQcmV2aWV3Jyk7XG4gICAgICAgICAgICBpbWFnZVByZXZpZXcuaW5uZXJIVE1MID0gYDxpbWcgc3JjPVwiJHtlLnRhcmdldC5yZXN1bHR9XCIgY2xhc3M9XCJwcmV2aWV3SW1hZ2VcIiBhbHQ9XCJQcmV2aWV3XCI+PGJ1dHRvbiB0eXBlPVwiYnV0dG9uXCIgb25jbGljaz1cIndpbmRvdy5yZW1vdmVJbWFnZSgpXCI+U3VwcHJpbWVyIGltYWdlPC9idXR0b24+YDtcbiAgICAgICAgfTtcbiAgICAgICAgcmVhZGVyLnJlYWRBc0RhdGFVUkwoZmlsZSk7XG4gICAgfSBlbHNlIHtcbiAgICAgICAgZG9jdW1lbnQuZ2V0RWxlbWVudEJ5SWQoJ2ltYWdlUHJldmlldycpLmlubmVySFRNTCA9ICcnO1xuICAgIH1cbn1cblxuLy8gRm9uY3Rpb24gcG91ciBzdXBwcmltZXIgbCdhZmZpY2hhZ2UgZGUgbCdpbWFnZVxud2luZG93LnJlbW92ZUltYWdlID0gZnVuY3Rpb24oKSB7XG4gIFxuICAgIGRvY3VtZW50LnF1ZXJ5U2VsZWN0b3IoJy5mb3JtLWNvbnRyb2wtZmlsZScpLnZhbHVlID0gJyc7IC8vIFLDqWluaXRpYWxpc2UgbCdpbnB1dCBmaWxlXG4gICAgZG9jdW1lbnQuZ2V0RWxlbWVudEJ5SWQoJ2ltYWdlUHJldmlldycpLmlubmVySFRNTCA9ICcnOyAvLyBTdXBwcmltZSBsZSBub20gZGUgbCdpbWFnZSBhZmZpY2jDqVxufTtcblxuLy8gVsOpcmlmaWUgc2kgdW4gaW5wdXQgZmlsZSBhdmVjIGxhIGNsYXNzZSAuZm9ybS1jb250cm9sLWZpbGUgZXhpc3RlXG5jb25zdCBmaWxlSW5wdXQgPSBkb2N1bWVudC5xdWVyeVNlbGVjdG9yKCcuZm9ybS1jb250cm9sLWZpbGUnKTtcbmlmIChmaWxlSW5wdXQgIT09IG51bGwpIHtcbiAgICAvLyBBam91dGUgdW4gw6ljb3V0ZXVyIGQnw6l2w6luZW1lbnRzIG9uY2hhbmdlIMOgIGwnaW5wdXQgZmlsZVxuICAgIGZpbGVJbnB1dC5hZGRFdmVudExpc3RlbmVyKCdjaGFuZ2UnLCBkaXNwbGF5SW1hZ2UpO1xufVxuXG5cblxuLyoqKioqKioqKioqKioqKioqKioqKipHZXN0aW9uIGRlIGxhIGNhcnRlIGxlYWZsZXQqKioqKioqKioqKioqKioqKioqKioqL1xuXG5jb25zb2xlLmxvZyhtYXBQb2ludHMpO1xuXG5pZiAoZG9jdW1lbnQuZ2V0RWxlbWVudEJ5SWQoXCJtYXBcIikgIT09IG51bGwpe1xuICAgIGNvbnNvbGUubG9nKCdvayBtYXAnKTtcbiAgICB2YXIgbXltYXAgPSBMLm1hcCgnbWFwJykuc2V0VmlldyhbNDguNzY4OSwgMi4wOTQ1NF0sIDE0KTtcbiAgICAvL2Fqb3V0IGRlIGxhIGNhcnRlXG4gICAgTC50aWxlTGF5ZXIoJ2h0dHBzOi8ve3N9LnRpbGUub3BlbnN0cmVldG1hcC5vcmcve3p9L3t4fS97eX0ucG5nJywge1xuICAgICAgICBtYXhab29tOiAxOSxcbiAgICB9KS5hZGRUbyhteW1hcCk7XG5cbi8vYWpvdXQgZCd1biBtYXJrZXJcblxudmFyIGNlbnRlck1hcmtlciA9IEwubWFya2VyKFs0OC43Njg5LCAyLjA5NDU0XSkuYWRkVG8obXltYXApO1xuY2VudGVyTWFya2VyLmJpbmRQb3B1cCgnU2l0ZSBkdSBmZXN0aXZhbCcpLm9wZW5Qb3B1cCgpO1xuXG5cblxuLy9ham91dCBkZSB0b3VzIGxlcyBtYXJrZXJzIGF2ZWMgbGVzIGNvb3Jkb25uw6llcyBkZSBtYXBQb2ludHNcblxuICAgIC8vIEFqb3V0ZXIgZGVzIG1hcnF1ZXVycyDDoCBsYSBjYXJ0ZVxuICAgIG1hcFBvaW50cy5mb3JFYWNoKGZ1bmN0aW9uKHBvaW50KSB7XG5cbmxldCBsYXQgPSBwYXJzZUZsb2F0KHBvaW50LmxhdGl0dWRlKTtcbmxldCBsbmcgPSBwYXJzZUZsb2F0KHBvaW50LmxvbmdpdHVkZSk7XG5cbiAgICAgICBcbiAgICAgICAgdmFyIG1hcmtlciA9IEwubWFya2VyKFtsYXQsIGxuZ10pLmFkZFRvKG15bWFwKTtcbiAgICAgICAgLy8gQWpvdXRlciB1biBwb3B1cCBhdSBtYXJxdWV1ciBhdmVjIHRpdHJlIGV0IGRlc2NyaXB0aW9uXG4gICAgICAgIG1hcmtlci5iaW5kUG9wdXAoYDxiPiR7cG9pbnQudGl0bGV9PC9iPjxicj4ke3BvaW50LmRlc2NyaXB0aW9ufWApLm9wZW5Qb3B1cCgpO1xuICAgICAgICBcbiAgICB9KTtcblxuXG5cblxuXG5teW1hcC5vbignY29udGV4dG1lbnUnLCBmdW5jdGlvbihlKSB7XG52YXIgbGF0ID0gcGFyc2VGbG9hdChlLmxhdGxuZy5sYXQpLnRvRml4ZWQoNyk7XG52YXIgbG5nID0gcGFyc2VGbG9hdChlLmxhdGxuZy5sbmcpLnRvRml4ZWQoNyk7XG5cbiAgICBjb25zb2xlLmxvZyhsYXQgKyAnLCAnICsgbG5nKTtcblxuICAgIGxldCBsYXRJbnB1dCA9IGRvY3VtZW50LmdldEVsZW1lbnRCeUlkKCdtYXBfcG9pbnRfZW50aXR5X0xhdGl0dWRlJyk7XG4gICAgbGV0IGxuZ0lucHV0ID0gZG9jdW1lbnQuZ2V0RWxlbWVudEJ5SWQoJ21hcF9wb2ludF9lbnRpdHlfTG9uZ2l0dWRlJyk7XG5cbiAgICBsYXRJbnB1dC52YWx1ZSA9IGxhdDtcbiAgICBsbmdJbnB1dC52YWx1ZSA9IGxuZztcblxuXG5cblxufSk7XG5cblxuICBcbn1cblxuIiwiaW1wb3J0IHsgQXBwbGljYXRpb24gfSBmcm9tIFwic3RpbXVsdXNcIjtcbmltcG9ydCB7IGRlZmluaXRpb25zRnJvbUNvbnRleHQgfSBmcm9tIFwic3RpbXVsdXMvd2VicGFjay1oZWxwZXJzXCI7XG5cbmNvbnN0IGFwcGxpY2F0aW9uID0gQXBwbGljYXRpb24uc3RhcnQoKTtcbmNvbnN0IGNvbnRleHQgPSByZXF1aXJlLmNvbnRleHQoXCIuL2NvbnRyb2xsZXJzXCIsIHRydWUsIC9cXC5qcyQvKTtcbmFwcGxpY2F0aW9uLmxvYWQoZGVmaW5pdGlvbnNGcm9tQ29udGV4dChjb250ZXh0KSk7XG5cbiIsImltcG9ydCB7IENvbnRyb2xsZXIgfSBmcm9tICdAaG90d2lyZWQvc3RpbXVsdXMnO1xuXG4vKlxuICogVGhpcyBpcyBhbiBleGFtcGxlIFN0aW11bHVzIGNvbnRyb2xsZXIhXG4gKlxuICogQW55IGVsZW1lbnQgd2l0aCBhIGRhdGEtY29udHJvbGxlcj1cImhlbGxvXCIgYXR0cmlidXRlIHdpbGwgY2F1c2VcbiAqIHRoaXMgY29udHJvbGxlciB0byBiZSBleGVjdXRlZC4gVGhlIG5hbWUgXCJoZWxsb1wiIGNvbWVzIGZyb20gdGhlIGZpbGVuYW1lOlxuICogaGVsbG9fY29udHJvbGxlci5qcyAtPiBcImhlbGxvXCJcbiAqXG4gKiBEZWxldGUgdGhpcyBmaWxlIG9yIGFkYXB0IGl0IGZvciB5b3VyIHVzZSFcbiAqL1xuZXhwb3J0IGRlZmF1bHQgY2xhc3MgZXh0ZW5kcyBDb250cm9sbGVyIHtcbiAgICBjb25uZWN0KCkge1xuICAgICAgICB0aGlzLmVsZW1lbnQudGV4dENvbnRlbnQgPSAnSGVsbG8gU3RpbXVsdXMhIEVkaXQgbWUgaW4gYXNzZXRzL2NvbnRyb2xsZXJzL2hlbGxvX2NvbnRyb2xsZXIuanMnO1xuICAgIH1cbn1cbiIsIi8vIGV4dHJhY3RlZCBieSBtaW5pLWNzcy1leHRyYWN0LXBsdWdpblxuZXhwb3J0IHt9OyJdLCJuYW1lcyI6WyJkaXNwbGF5SW1hZ2UiLCJlIiwiZmlsZUlucHV0IiwidGFyZ2V0IiwiZmlsZXMiLCJsZW5ndGgiLCJmaWxlIiwicmVhZGVyIiwiRmlsZVJlYWRlciIsIm9ubG9hZCIsImltYWdlUHJldmlldyIsImRvY3VtZW50IiwiZ2V0RWxlbWVudEJ5SWQiLCJpbm5lckhUTUwiLCJjb25jYXQiLCJyZXN1bHQiLCJyZWFkQXNEYXRhVVJMIiwid2luZG93IiwicmVtb3ZlSW1hZ2UiLCJxdWVyeVNlbGVjdG9yIiwidmFsdWUiLCJhZGRFdmVudExpc3RlbmVyIiwiY29uc29sZSIsImxvZyIsIm1hcFBvaW50cyIsIm15bWFwIiwiTCIsIm1hcCIsInNldFZpZXciLCJ0aWxlTGF5ZXIiLCJtYXhab29tIiwiYWRkVG8iLCJjZW50ZXJNYXJrZXIiLCJtYXJrZXIiLCJiaW5kUG9wdXAiLCJvcGVuUG9wdXAiLCJmb3JFYWNoIiwicG9pbnQiLCJsYXQiLCJwYXJzZUZsb2F0IiwibGF0aXR1ZGUiLCJsbmciLCJsb25naXR1ZGUiLCJ0aXRsZSIsImRlc2NyaXB0aW9uIiwib24iLCJsYXRsbmciLCJ0b0ZpeGVkIiwibGF0SW5wdXQiLCJsbmdJbnB1dCIsIkFwcGxpY2F0aW9uIiwiZGVmaW5pdGlvbnNGcm9tQ29udGV4dCIsImFwcGxpY2F0aW9uIiwic3RhcnQiLCJjb250ZXh0IiwicmVxdWlyZSIsImxvYWQiLCJDb250cm9sbGVyIiwiX2RlZmF1bHQiLCJfQ29udHJvbGxlciIsIl9jbGFzc0NhbGxDaGVjayIsIl9jYWxsU3VwZXIiLCJhcmd1bWVudHMiLCJfaW5oZXJpdHMiLCJfY3JlYXRlQ2xhc3MiLCJrZXkiLCJjb25uZWN0IiwiZWxlbWVudCIsInRleHRDb250ZW50IiwiZGVmYXVsdCJdLCJzb3VyY2VSb290IjoiIn0=