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


// Fonction pour afficher l'image sélectionnée
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

// Fonction pour supprimer l'image
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

//Mise en place listener pour le l'input file

//if (document.getElementById('band_file') !== null){
/*
if (document.querySelector('.form-control-file') !== null){
//selection de l'input file qui a la classe form-control-file




var fileInput = document.querySelector('.form-control-file');




fileInput.addEventListener('change', function (e) {



const fileInput = e.target;
            const files = fileInput.files;
            if (files.length > 0) {
                const file = files[0];
                const reader = new FileReader();
                reader.onload = function(e) {
                    const imagePreview = document.getElementById('imagePreview');
                    imagePreview.innerHTML = `<img src="${e.target.result}" class="previewImage" alt="Preview"><p>${e.target.result}<button type="button" onclick="removeImage">Supprimer</button></p>`;
                };
                reader.readAsDataURL(file);
            } else {
                document.getElementById('imagePreview').innerHTML = '';
            }


});

        

}*/
/*
function removeImage() {
    console.log('removeImage');

            document.querySelector('.form-control-file').value = ''; // Réinitialise l'input file
            document.getElementById('imagePreview').innerHTML = ''; // Supprime le nom de l'image affiché
        }
*/

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
//# sourceMappingURL=data:application/json;charset=utf-8;base64,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d2VicGFjazovLy8uL2Fzc2V0cy9jb250cm9sbGVycy8gc3luYyBcXC5qcyQiLCJ3ZWJwYWNrOi8vLy4vYXNzZXRzL2FwcC5qcyIsIndlYnBhY2s6Ly8vLi9hc3NldHMvYm9vdHN0cmFwLmpzIiwid2VicGFjazovLy8uL2Fzc2V0cy9jb250cm9sbGVycy9oZWxsb19jb250cm9sbGVyLmpzIiwid2VicGFjazovLy8uL2Fzc2V0cy9zdHlsZXMvYXBwLmNzcyJdLCJzb3VyY2VzQ29udGVudCI6WyJ2YXIgbWFwID0ge1xuXHRcIi4vaGVsbG9fY29udHJvbGxlci5qc1wiOiBcIi4vYXNzZXRzL2NvbnRyb2xsZXJzL2hlbGxvX2NvbnRyb2xsZXIuanNcIlxufTtcblxuXG5mdW5jdGlvbiB3ZWJwYWNrQ29udGV4dChyZXEpIHtcblx0dmFyIGlkID0gd2VicGFja0NvbnRleHRSZXNvbHZlKHJlcSk7XG5cdHJldHVybiBfX3dlYnBhY2tfcmVxdWlyZV9fKGlkKTtcbn1cbmZ1bmN0aW9uIHdlYnBhY2tDb250ZXh0UmVzb2x2ZShyZXEpIHtcblx0aWYoIV9fd2VicGFja19yZXF1aXJlX18ubyhtYXAsIHJlcSkpIHtcblx0XHR2YXIgZSA9IG5ldyBFcnJvcihcIkNhbm5vdCBmaW5kIG1vZHVsZSAnXCIgKyByZXEgKyBcIidcIik7XG5cdFx0ZS5jb2RlID0gJ01PRFVMRV9OT1RfRk9VTkQnO1xuXHRcdHRocm93IGU7XG5cdH1cblx0cmV0dXJuIG1hcFtyZXFdO1xufVxud2VicGFja0NvbnRleHQua2V5cyA9IGZ1bmN0aW9uIHdlYnBhY2tDb250ZXh0S2V5cygpIHtcblx0cmV0dXJuIE9iamVjdC5rZXlzKG1hcCk7XG59O1xud2VicGFja0NvbnRleHQucmVzb2x2ZSA9IHdlYnBhY2tDb250ZXh0UmVzb2x2ZTtcbm1vZHVsZS5leHBvcnRzID0gd2VicGFja0NvbnRleHQ7XG53ZWJwYWNrQ29udGV4dC5pZCA9IFwiLi9hc3NldHMvY29udHJvbGxlcnMgc3luYyByZWN1cnNpdmUgXFxcXC5qcyRcIjsiLCJcblxuaW1wb3J0ICcuL2Jvb3RzdHJhcC5qcyc7XG4vKlxuICogV2VsY29tZSB0byB5b3VyIGFwcCdzIG1haW4gSmF2YVNjcmlwdCBmaWxlIVxuICpcbiAqIFRoaXMgZmlsZSB3aWxsIGJlIGluY2x1ZGVkIG9udG8gdGhlIHBhZ2UgdmlhIHRoZSBpbXBvcnRtYXAoKSBUd2lnIGZ1bmN0aW9uLFxuICogd2hpY2ggc2hvdWxkIGFscmVhZHkgYmUgaW4geW91ciBiYXNlLmh0bWwudHdpZy5cbiAqL1xuaW1wb3J0ICcuL3N0eWxlcy9hcHAuY3NzJztcblxuLy8gRm9uY3Rpb24gcG91ciBhZmZpY2hlciBsJ2ltYWdlIHPDqWxlY3Rpb25uw6llXG5mdW5jdGlvbiBkaXNwbGF5SW1hZ2UoZSkge1xuICAgIGNvbnN0IGZpbGVJbnB1dCA9IGUudGFyZ2V0O1xuICAgIGNvbnN0IGZpbGVzID0gZmlsZUlucHV0LmZpbGVzO1xuICAgIGlmIChmaWxlcy5sZW5ndGggPiAwKSB7XG4gICAgICAgIGNvbnN0IGZpbGUgPSBmaWxlc1swXTtcbiAgICAgICAgY29uc3QgcmVhZGVyID0gbmV3IEZpbGVSZWFkZXIoKTtcbiAgICAgICAgcmVhZGVyLm9ubG9hZCA9IGZ1bmN0aW9uKGUpIHtcbiAgICAgICAgICAgIGNvbnN0IGltYWdlUHJldmlldyA9IGRvY3VtZW50LmdldEVsZW1lbnRCeUlkKCdpbWFnZVByZXZpZXcnKTtcbiAgICAgICAgICAgIGltYWdlUHJldmlldy5pbm5lckhUTUwgPSBgPGltZyBzcmM9XCIke2UudGFyZ2V0LnJlc3VsdH1cIiBjbGFzcz1cInByZXZpZXdJbWFnZVwiIGFsdD1cIlByZXZpZXdcIj48YnV0dG9uIHR5cGU9XCJidXR0b25cIiBvbmNsaWNrPVwid2luZG93LnJlbW92ZUltYWdlKClcIj5TdXBwcmltZXIgaW1hZ2U8L2J1dHRvbj5gO1xuICAgICAgICB9O1xuICAgICAgICByZWFkZXIucmVhZEFzRGF0YVVSTChmaWxlKTtcbiAgICB9IGVsc2Uge1xuICAgICAgICBkb2N1bWVudC5nZXRFbGVtZW50QnlJZCgnaW1hZ2VQcmV2aWV3JykuaW5uZXJIVE1MID0gJyc7XG4gICAgfVxufVxuXG4vLyBGb25jdGlvbiBwb3VyIHN1cHByaW1lciBsJ2ltYWdlXG53aW5kb3cucmVtb3ZlSW1hZ2UgPSBmdW5jdGlvbigpIHtcbiAgXG4gICAgZG9jdW1lbnQucXVlcnlTZWxlY3RvcignLmZvcm0tY29udHJvbC1maWxlJykudmFsdWUgPSAnJzsgLy8gUsOpaW5pdGlhbGlzZSBsJ2lucHV0IGZpbGVcbiAgICBkb2N1bWVudC5nZXRFbGVtZW50QnlJZCgnaW1hZ2VQcmV2aWV3JykuaW5uZXJIVE1MID0gJyc7IC8vIFN1cHByaW1lIGxlIG5vbSBkZSBsJ2ltYWdlIGFmZmljaMOpXG59O1xuXG4vLyBWw6lyaWZpZSBzaSB1biBpbnB1dCBmaWxlIGF2ZWMgbGEgY2xhc3NlIC5mb3JtLWNvbnRyb2wtZmlsZSBleGlzdGVcbmNvbnN0IGZpbGVJbnB1dCA9IGRvY3VtZW50LnF1ZXJ5U2VsZWN0b3IoJy5mb3JtLWNvbnRyb2wtZmlsZScpO1xuaWYgKGZpbGVJbnB1dCAhPT0gbnVsbCkge1xuICAgIC8vIEFqb3V0ZSB1biDDqWNvdXRldXIgZCfDqXbDqW5lbWVudHMgb25jaGFuZ2Ugw6AgbCdpbnB1dCBmaWxlXG4gICAgZmlsZUlucHV0LmFkZEV2ZW50TGlzdGVuZXIoJ2NoYW5nZScsIGRpc3BsYXlJbWFnZSk7XG59XG5cbi8vTWlzZSBlbiBwbGFjZSBsaXN0ZW5lciBwb3VyIGxlIGwnaW5wdXQgZmlsZVxuXG4vL2lmIChkb2N1bWVudC5nZXRFbGVtZW50QnlJZCgnYmFuZF9maWxlJykgIT09IG51bGwpe1xuLypcbmlmIChkb2N1bWVudC5xdWVyeVNlbGVjdG9yKCcuZm9ybS1jb250cm9sLWZpbGUnKSAhPT0gbnVsbCl7XG4vL3NlbGVjdGlvbiBkZSBsJ2lucHV0IGZpbGUgcXVpIGEgbGEgY2xhc3NlIGZvcm0tY29udHJvbC1maWxlXG5cblxuXG5cbnZhciBmaWxlSW5wdXQgPSBkb2N1bWVudC5xdWVyeVNlbGVjdG9yKCcuZm9ybS1jb250cm9sLWZpbGUnKTtcblxuXG5cblxuZmlsZUlucHV0LmFkZEV2ZW50TGlzdGVuZXIoJ2NoYW5nZScsIGZ1bmN0aW9uIChlKSB7XG5cblxuXG5jb25zdCBmaWxlSW5wdXQgPSBlLnRhcmdldDtcbiAgICAgICAgICAgIGNvbnN0IGZpbGVzID0gZmlsZUlucHV0LmZpbGVzO1xuICAgICAgICAgICAgaWYgKGZpbGVzLmxlbmd0aCA+IDApIHtcbiAgICAgICAgICAgICAgICBjb25zdCBmaWxlID0gZmlsZXNbMF07XG4gICAgICAgICAgICAgICAgY29uc3QgcmVhZGVyID0gbmV3IEZpbGVSZWFkZXIoKTtcbiAgICAgICAgICAgICAgICByZWFkZXIub25sb2FkID0gZnVuY3Rpb24oZSkge1xuICAgICAgICAgICAgICAgICAgICBjb25zdCBpbWFnZVByZXZpZXcgPSBkb2N1bWVudC5nZXRFbGVtZW50QnlJZCgnaW1hZ2VQcmV2aWV3Jyk7XG4gICAgICAgICAgICAgICAgICAgIGltYWdlUHJldmlldy5pbm5lckhUTUwgPSBgPGltZyBzcmM9XCIke2UudGFyZ2V0LnJlc3VsdH1cIiBjbGFzcz1cInByZXZpZXdJbWFnZVwiIGFsdD1cIlByZXZpZXdcIj48cD4ke2UudGFyZ2V0LnJlc3VsdH08YnV0dG9uIHR5cGU9XCJidXR0b25cIiBvbmNsaWNrPVwicmVtb3ZlSW1hZ2VcIj5TdXBwcmltZXI8L2J1dHRvbj48L3A+YDtcbiAgICAgICAgICAgICAgICB9O1xuICAgICAgICAgICAgICAgIHJlYWRlci5yZWFkQXNEYXRhVVJMKGZpbGUpO1xuICAgICAgICAgICAgfSBlbHNlIHtcbiAgICAgICAgICAgICAgICBkb2N1bWVudC5nZXRFbGVtZW50QnlJZCgnaW1hZ2VQcmV2aWV3JykuaW5uZXJIVE1MID0gJyc7XG4gICAgICAgICAgICB9XG5cblxufSk7XG5cbiAgICAgICAgXG5cbn0qL1xuLypcbmZ1bmN0aW9uIHJlbW92ZUltYWdlKCkge1xuICAgIGNvbnNvbGUubG9nKCdyZW1vdmVJbWFnZScpO1xuXG4gICAgICAgICAgICBkb2N1bWVudC5xdWVyeVNlbGVjdG9yKCcuZm9ybS1jb250cm9sLWZpbGUnKS52YWx1ZSA9ICcnOyAvLyBSw6lpbml0aWFsaXNlIGwnaW5wdXQgZmlsZVxuICAgICAgICAgICAgZG9jdW1lbnQuZ2V0RWxlbWVudEJ5SWQoJ2ltYWdlUHJldmlldycpLmlubmVySFRNTCA9ICcnOyAvLyBTdXBwcmltZSBsZSBub20gZGUgbCdpbWFnZSBhZmZpY2jDqVxuICAgICAgICB9XG4qL1xuXG4vL0dlc3Rpb24gZGUgbGEgY2FydGUgbGVhZmxldFxuXG5cblxuaWYgKGRvY3VtZW50LmdldEVsZW1lbnRCeUlkKFwibWFwXCIpICE9PSBudWxsKXtcbiAgICBjb25zb2xlLmxvZygnb2sgbWFwJyk7XG4gICAgdmFyIG15bWFwID0gTC5tYXAoJ21hcCcpLnNldFZpZXcoWzQ4Ljc2ODksIDIuMDk0NTRdLCAxNCk7XG4gICAgLy9ham91dCBkZSBsYSBjYXJ0ZVxuICAgIEwudGlsZUxheWVyKCdodHRwczovL3tzfS50aWxlLm9wZW5zdHJlZXRtYXAub3JnL3t6fS97eH0ve3l9LnBuZycsIHtcbiAgICAgICAgbWF4Wm9vbTogMTksXG4gICAgfSkuYWRkVG8obXltYXApO1xuXG4vL2Fqb3V0IGQndW4gbWFya2VyXG5cbnZhciBjZW50ZXJNYXJrZXIgPSBMLm1hcmtlcihbNDguNzY4OSwgMi4wOTQ1NF0pLmFkZFRvKG15bWFwKTtcblxuXG5cblxuXG5teW1hcC5vbignY29udGV4dG1lbnUnLCBmdW5jdGlvbihlKSB7XG4gICAgdmFyIGxhdCA9IGUubGF0bG5nLmxhdDtcbiAgICB2YXIgbG5nID0gZS5sYXRsbmcubG5nO1xuXG4gICAgY29uc29sZS5sb2cobGF0ICsgJywgJyArIGxuZyk7XG59KTtcblxuXG4gIFxufVxuLypcblxuZG9jdW1lbnQuZ2V0RWxlbWVudEJ5SWQoJ21hcCcpLmFkZEV2ZW50TGlzdGVuZXIoJ2NvbnRleHRtZW51JywgZnVuY3Rpb24gKGUpIHtcblxuICAgIGUucHJldmVudERlZmF1bHQoKTtcblxudmFyIGxhdGxuZz1tYXAubW91c2VFdmVudFRvTGF0TG5nKGUpO1xuICAvLyAgICB2YXIgbGF0ID0gZS5sYXRsbmcubGF0O1xuICAgIC8vICAgIHZhciBsbmcgPSBlLmxhdGxuZy5sbmc7XG5cbmNvbnNvbGUubG9nKGxhdGxuZyk7XG5cblxufSk7Ki9cbiIsImltcG9ydCB7IEFwcGxpY2F0aW9uIH0gZnJvbSBcInN0aW11bHVzXCI7XG5pbXBvcnQgeyBkZWZpbml0aW9uc0Zyb21Db250ZXh0IH0gZnJvbSBcInN0aW11bHVzL3dlYnBhY2staGVscGVyc1wiO1xuXG5jb25zdCBhcHBsaWNhdGlvbiA9IEFwcGxpY2F0aW9uLnN0YXJ0KCk7XG5jb25zdCBjb250ZXh0ID0gcmVxdWlyZS5jb250ZXh0KFwiLi9jb250cm9sbGVyc1wiLCB0cnVlLCAvXFwuanMkLyk7XG5hcHBsaWNhdGlvbi5sb2FkKGRlZmluaXRpb25zRnJvbUNvbnRleHQoY29udGV4dCkpO1xuXG4iLCJpbXBvcnQgeyBDb250cm9sbGVyIH0gZnJvbSAnQGhvdHdpcmVkL3N0aW11bHVzJztcblxuLypcbiAqIFRoaXMgaXMgYW4gZXhhbXBsZSBTdGltdWx1cyBjb250cm9sbGVyIVxuICpcbiAqIEFueSBlbGVtZW50IHdpdGggYSBkYXRhLWNvbnRyb2xsZXI9XCJoZWxsb1wiIGF0dHJpYnV0ZSB3aWxsIGNhdXNlXG4gKiB0aGlzIGNvbnRyb2xsZXIgdG8gYmUgZXhlY3V0ZWQuIFRoZSBuYW1lIFwiaGVsbG9cIiBjb21lcyBmcm9tIHRoZSBmaWxlbmFtZTpcbiAqIGhlbGxvX2NvbnRyb2xsZXIuanMgLT4gXCJoZWxsb1wiXG4gKlxuICogRGVsZXRlIHRoaXMgZmlsZSBvciBhZGFwdCBpdCBmb3IgeW91ciB1c2UhXG4gKi9cbmV4cG9ydCBkZWZhdWx0IGNsYXNzIGV4dGVuZHMgQ29udHJvbGxlciB7XG4gICAgY29ubmVjdCgpIHtcbiAgICAgICAgdGhpcy5lbGVtZW50LnRleHRDb250ZW50ID0gJ0hlbGxvIFN0aW11bHVzISBFZGl0IG1lIGluIGFzc2V0cy9jb250cm9sbGVycy9oZWxsb19jb250cm9sbGVyLmpzJztcbiAgICB9XG59XG4iLCIvLyBleHRyYWN0ZWQgYnkgbWluaS1jc3MtZXh0cmFjdC1wbHVnaW5cbmV4cG9ydCB7fTsiXSwibmFtZXMiOlsiZGlzcGxheUltYWdlIiwiZSIsImZpbGVJbnB1dCIsInRhcmdldCIsImZpbGVzIiwibGVuZ3RoIiwiZmlsZSIsInJlYWRlciIsIkZpbGVSZWFkZXIiLCJvbmxvYWQiLCJpbWFnZVByZXZpZXciLCJkb2N1bWVudCIsImdldEVsZW1lbnRCeUlkIiwiaW5uZXJIVE1MIiwiY29uY2F0IiwicmVzdWx0IiwicmVhZEFzRGF0YVVSTCIsIndpbmRvdyIsInJlbW92ZUltYWdlIiwicXVlcnlTZWxlY3RvciIsInZhbHVlIiwiYWRkRXZlbnRMaXN0ZW5lciIsImNvbnNvbGUiLCJsb2ciLCJteW1hcCIsIkwiLCJtYXAiLCJzZXRWaWV3IiwidGlsZUxheWVyIiwibWF4Wm9vbSIsImFkZFRvIiwiY2VudGVyTWFya2VyIiwibWFya2VyIiwib24iLCJsYXQiLCJsYXRsbmciLCJsbmciLCJBcHBsaWNhdGlvbiIsImRlZmluaXRpb25zRnJvbUNvbnRleHQiLCJhcHBsaWNhdGlvbiIsInN0YXJ0IiwiY29udGV4dCIsInJlcXVpcmUiLCJsb2FkIiwiQ29udHJvbGxlciIsIl9kZWZhdWx0IiwiX0NvbnRyb2xsZXIiLCJfY2xhc3NDYWxsQ2hlY2siLCJfY2FsbFN1cGVyIiwiYXJndW1lbnRzIiwiX2luaGVyaXRzIiwiX2NyZWF0ZUNsYXNzIiwia2V5IiwiY29ubmVjdCIsImVsZW1lbnQiLCJ0ZXh0Q29udGVudCIsImRlZmF1bHQiXSwic291cmNlUm9vdCI6IiJ9