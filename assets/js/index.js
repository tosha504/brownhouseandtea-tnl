/******/ (() => { // webpackBootstrap
/******/ 	var __webpack_modules__ = ({

/***/ "./src/index.js":
/*!**********************!*\
  !*** ./src/index.js ***!
  \**********************/
/***/ (() => {

(function () {
  console.log('ready');
  var burger = jQuery(".burger"),
    burgerSpan = jQuery(".burger span"),
    nav = jQuery('.header__nav'),
    body = jQuery('body');
  burger.on("click", function () {
    burgerSpan.toggleClass("active");
    nav.toggleClass("active");
    body.toggleClass("fixed-page");
  });
  if (body.hasClass('home')) {
    jQuery(window).scroll(function () {
      var scrollTop = jQuery(window).scrollTop();
      if (scrollTop > 40) {
        jQuery(".header").css({
          "background": "var(--white)"
        });
      } else {
        jQuery(".header").css({
          "background": "transparent"
        });
      }
    });
  }
  setTimeout(function () {
    if (getCookie('popupCookie') != 'submited') {
      jQuery('.cookies').css("display", "block").hide().fadeIn(2000);
    }
    jQuery('a.submit').click(function () {
      jQuery('.cookies').fadeOut();
      //sets the coookie to five minutes if the popup is submited (whole numbers = days)
      setCookie('popupCookie', 'submited', 7);
    });
  }, 5000);
  function getCookie(cname) {
    var name = cname + "=";
    var ca = document.cookie.split(';');
    for (var i = 0; i < ca.length; i++) {
      var c = ca[i];
      while (c.charAt(0) == ' ') {
        c = c.substring(1);
      }
      if (c.indexOf(name) == 0) {
        return c.substring(name.length, c.length);
      }
    }
    return "";
  }
  function setCookie(cname, cvalue, exdays) {
    var d = new Date();
    d.setTime(d.getTime() + exdays * 24 * 60 * 60 * 1000);
    var expires = "expires=" + d.toUTCString();
    document.cookie = cname + "=" + cvalue + ";" + expires + ";path=/";
  }
  if (getCookie('ageVerification') !== 'submited') {
    jQuery('.age-verefication').css('display', 'block');
  }
})(jQuery);

/***/ }),

/***/ "./gutenberg-styles/refill-bht.scss":
/*!******************************************!*\
  !*** ./gutenberg-styles/refill-bht.scss ***!
  \******************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
// extracted by mini-css-extract-plugin


/***/ }),

/***/ "./gutenberg-styles/tea-best-bht.scss":
/*!********************************************!*\
  !*** ./gutenberg-styles/tea-best-bht.scss ***!
  \********************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
// extracted by mini-css-extract-plugin


/***/ }),

/***/ "./sass/index.scss":
/*!*************************!*\
  !*** ./sass/index.scss ***!
  \*************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
// extracted by mini-css-extract-plugin


/***/ }),

/***/ "./gutenberg-styles/banner-bht.scss":
/*!******************************************!*\
  !*** ./gutenberg-styles/banner-bht.scss ***!
  \******************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
// extracted by mini-css-extract-plugin


/***/ }),

/***/ "./gutenberg-styles/image-content-bht.scss":
/*!*************************************************!*\
  !*** ./gutenberg-styles/image-content-bht.scss ***!
  \*************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
// extracted by mini-css-extract-plugin


/***/ }),

/***/ "./gutenberg-styles/inspirations-bht.scss":
/*!************************************************!*\
  !*** ./gutenberg-styles/inspirations-bht.scss ***!
  \************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
// extracted by mini-css-extract-plugin


/***/ }),

/***/ "./gutenberg-styles/marquee-bht.scss":
/*!*******************************************!*\
  !*** ./gutenberg-styles/marquee-bht.scss ***!
  \*******************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
// extracted by mini-css-extract-plugin


/***/ }),

/***/ "./gutenberg-styles/quiz-bht.scss":
/*!****************************************!*\
  !*** ./gutenberg-styles/quiz-bht.scss ***!
  \****************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
// extracted by mini-css-extract-plugin


/***/ })

/******/ 	});
/************************************************************************/
/******/ 	// The module cache
/******/ 	var __webpack_module_cache__ = {};
/******/ 	
/******/ 	// The require function
/******/ 	function __webpack_require__(moduleId) {
/******/ 		// Check if module is in cache
/******/ 		var cachedModule = __webpack_module_cache__[moduleId];
/******/ 		if (cachedModule !== undefined) {
/******/ 			return cachedModule.exports;
/******/ 		}
/******/ 		// Create a new module (and put it into the cache)
/******/ 		var module = __webpack_module_cache__[moduleId] = {
/******/ 			// no module.id needed
/******/ 			// no module.loaded needed
/******/ 			exports: {}
/******/ 		};
/******/ 	
/******/ 		// Execute the module function
/******/ 		__webpack_modules__[moduleId](module, module.exports, __webpack_require__);
/******/ 	
/******/ 		// Return the exports of the module
/******/ 		return module.exports;
/******/ 	}
/******/ 	
/******/ 	// expose the modules object (__webpack_modules__)
/******/ 	__webpack_require__.m = __webpack_modules__;
/******/ 	
/************************************************************************/
/******/ 	/* webpack/runtime/chunk loaded */
/******/ 	(() => {
/******/ 		var deferred = [];
/******/ 		__webpack_require__.O = (result, chunkIds, fn, priority) => {
/******/ 			if(chunkIds) {
/******/ 				priority = priority || 0;
/******/ 				for(var i = deferred.length; i > 0 && deferred[i - 1][2] > priority; i--) deferred[i] = deferred[i - 1];
/******/ 				deferred[i] = [chunkIds, fn, priority];
/******/ 				return;
/******/ 			}
/******/ 			var notFulfilled = Infinity;
/******/ 			for (var i = 0; i < deferred.length; i++) {
/******/ 				var [chunkIds, fn, priority] = deferred[i];
/******/ 				var fulfilled = true;
/******/ 				for (var j = 0; j < chunkIds.length; j++) {
/******/ 					if ((priority & 1 === 0 || notFulfilled >= priority) && Object.keys(__webpack_require__.O).every((key) => (__webpack_require__.O[key](chunkIds[j])))) {
/******/ 						chunkIds.splice(j--, 1);
/******/ 					} else {
/******/ 						fulfilled = false;
/******/ 						if(priority < notFulfilled) notFulfilled = priority;
/******/ 					}
/******/ 				}
/******/ 				if(fulfilled) {
/******/ 					deferred.splice(i--, 1)
/******/ 					var r = fn();
/******/ 					if (r !== undefined) result = r;
/******/ 				}
/******/ 			}
/******/ 			return result;
/******/ 		};
/******/ 	})();
/******/ 	
/******/ 	/* webpack/runtime/hasOwnProperty shorthand */
/******/ 	(() => {
/******/ 		__webpack_require__.o = (obj, prop) => (Object.prototype.hasOwnProperty.call(obj, prop))
/******/ 	})();
/******/ 	
/******/ 	/* webpack/runtime/make namespace object */
/******/ 	(() => {
/******/ 		// define __esModule on exports
/******/ 		__webpack_require__.r = (exports) => {
/******/ 			if(typeof Symbol !== 'undefined' && Symbol.toStringTag) {
/******/ 				Object.defineProperty(exports, Symbol.toStringTag, { value: 'Module' });
/******/ 			}
/******/ 			Object.defineProperty(exports, '__esModule', { value: true });
/******/ 		};
/******/ 	})();
/******/ 	
/******/ 	/* webpack/runtime/jsonp chunk loading */
/******/ 	(() => {
/******/ 		// no baseURI
/******/ 		
/******/ 		// object to store loaded and loading chunks
/******/ 		// undefined = chunk not loaded, null = chunk preloaded/prefetched
/******/ 		// [resolve, reject, Promise] = chunk loading, 0 = chunk loaded
/******/ 		var installedChunks = {
/******/ 			"/assets/js/index": 0,
/******/ 			"css-blocks/quiz-bht": 0,
/******/ 			"css-blocks/marquee-bht": 0,
/******/ 			"css-blocks/inspirations-bht": 0,
/******/ 			"css-blocks/image-content-bht": 0,
/******/ 			"css-blocks/banner-bht": 0,
/******/ 			"src/index": 0,
/******/ 			"css-blocks/tea-best-bht": 0,
/******/ 			"css-blocks/refill-bht": 0
/******/ 		};
/******/ 		
/******/ 		// no chunk on demand loading
/******/ 		
/******/ 		// no prefetching
/******/ 		
/******/ 		// no preloaded
/******/ 		
/******/ 		// no HMR
/******/ 		
/******/ 		// no HMR manifest
/******/ 		
/******/ 		__webpack_require__.O.j = (chunkId) => (installedChunks[chunkId] === 0);
/******/ 		
/******/ 		// install a JSONP callback for chunk loading
/******/ 		var webpackJsonpCallback = (parentChunkLoadingFunction, data) => {
/******/ 			var [chunkIds, moreModules, runtime] = data;
/******/ 			// add "moreModules" to the modules object,
/******/ 			// then flag all "chunkIds" as loaded and fire callback
/******/ 			var moduleId, chunkId, i = 0;
/******/ 			if(chunkIds.some((id) => (installedChunks[id] !== 0))) {
/******/ 				for(moduleId in moreModules) {
/******/ 					if(__webpack_require__.o(moreModules, moduleId)) {
/******/ 						__webpack_require__.m[moduleId] = moreModules[moduleId];
/******/ 					}
/******/ 				}
/******/ 				if(runtime) var result = runtime(__webpack_require__);
/******/ 			}
/******/ 			if(parentChunkLoadingFunction) parentChunkLoadingFunction(data);
/******/ 			for(;i < chunkIds.length; i++) {
/******/ 				chunkId = chunkIds[i];
/******/ 				if(__webpack_require__.o(installedChunks, chunkId) && installedChunks[chunkId]) {
/******/ 					installedChunks[chunkId][0]();
/******/ 				}
/******/ 				installedChunks[chunkId] = 0;
/******/ 			}
/******/ 			return __webpack_require__.O(result);
/******/ 		}
/******/ 		
/******/ 		var chunkLoadingGlobal = self["webpackChunk"] = self["webpackChunk"] || [];
/******/ 		chunkLoadingGlobal.forEach(webpackJsonpCallback.bind(null, 0));
/******/ 		chunkLoadingGlobal.push = webpackJsonpCallback.bind(null, chunkLoadingGlobal.push.bind(chunkLoadingGlobal));
/******/ 	})();
/******/ 	
/************************************************************************/
/******/ 	
/******/ 	// startup
/******/ 	// Load entry module and return exports
/******/ 	// This entry module depends on other loaded chunks and execution need to be delayed
/******/ 	__webpack_require__.O(undefined, ["css-blocks/quiz-bht","css-blocks/marquee-bht","css-blocks/inspirations-bht","css-blocks/image-content-bht","css-blocks/banner-bht","src/index","css-blocks/tea-best-bht","css-blocks/refill-bht"], () => (__webpack_require__("./src/index.js")))
/******/ 	__webpack_require__.O(undefined, ["css-blocks/quiz-bht","css-blocks/marquee-bht","css-blocks/inspirations-bht","css-blocks/image-content-bht","css-blocks/banner-bht","src/index","css-blocks/tea-best-bht","css-blocks/refill-bht"], () => (__webpack_require__("./gutenberg-styles/banner-bht.scss")))
/******/ 	__webpack_require__.O(undefined, ["css-blocks/quiz-bht","css-blocks/marquee-bht","css-blocks/inspirations-bht","css-blocks/image-content-bht","css-blocks/banner-bht","src/index","css-blocks/tea-best-bht","css-blocks/refill-bht"], () => (__webpack_require__("./gutenberg-styles/image-content-bht.scss")))
/******/ 	__webpack_require__.O(undefined, ["css-blocks/quiz-bht","css-blocks/marquee-bht","css-blocks/inspirations-bht","css-blocks/image-content-bht","css-blocks/banner-bht","src/index","css-blocks/tea-best-bht","css-blocks/refill-bht"], () => (__webpack_require__("./gutenberg-styles/inspirations-bht.scss")))
/******/ 	__webpack_require__.O(undefined, ["css-blocks/quiz-bht","css-blocks/marquee-bht","css-blocks/inspirations-bht","css-blocks/image-content-bht","css-blocks/banner-bht","src/index","css-blocks/tea-best-bht","css-blocks/refill-bht"], () => (__webpack_require__("./gutenberg-styles/marquee-bht.scss")))
/******/ 	__webpack_require__.O(undefined, ["css-blocks/quiz-bht","css-blocks/marquee-bht","css-blocks/inspirations-bht","css-blocks/image-content-bht","css-blocks/banner-bht","src/index","css-blocks/tea-best-bht","css-blocks/refill-bht"], () => (__webpack_require__("./gutenberg-styles/quiz-bht.scss")))
/******/ 	__webpack_require__.O(undefined, ["css-blocks/quiz-bht","css-blocks/marquee-bht","css-blocks/inspirations-bht","css-blocks/image-content-bht","css-blocks/banner-bht","src/index","css-blocks/tea-best-bht","css-blocks/refill-bht"], () => (__webpack_require__("./gutenberg-styles/refill-bht.scss")))
/******/ 	__webpack_require__.O(undefined, ["css-blocks/quiz-bht","css-blocks/marquee-bht","css-blocks/inspirations-bht","css-blocks/image-content-bht","css-blocks/banner-bht","src/index","css-blocks/tea-best-bht","css-blocks/refill-bht"], () => (__webpack_require__("./gutenberg-styles/tea-best-bht.scss")))
/******/ 	var __webpack_exports__ = __webpack_require__.O(undefined, ["css-blocks/quiz-bht","css-blocks/marquee-bht","css-blocks/inspirations-bht","css-blocks/image-content-bht","css-blocks/banner-bht","src/index","css-blocks/tea-best-bht","css-blocks/refill-bht"], () => (__webpack_require__("./sass/index.scss")))
/******/ 	__webpack_exports__ = __webpack_require__.O(__webpack_exports__);
/******/ 	
/******/ })()
;