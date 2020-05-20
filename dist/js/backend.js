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
/******/ 	__webpack_require__.p = "";
/******/
/******/
/******/ 	// Load entry module and return exports
/******/ 	return __webpack_require__(__webpack_require__.s = "./src/backend/app.js");
/******/ })
/************************************************************************/
/******/ ({

/***/ "./src/backend/app.js":
/*!****************************!*\
  !*** ./src/backend/app.js ***!
  \****************************/
/*! no static exports found */
/***/ (function(module, exports) {

eval("jQuery(document).ready(function ($) {\n  get_tasks();\n  var tasks_container = $('#tasks-container')[0]; // Get tasks container element.\n  // Get tasks.\n\n  function get_tasks() {\n    jQuery.ajax({\n      url: ajaxurl,\n      type: 'POST',\n      data: {\n        action: 'get_tasks'\n      },\n      success: function success(response) {\n        var tasks = JSON.parse(response);\n        tasks.forEach(function (task) {\n          if (task['status'] == 1) {\n            // Check if task is done.\n            var status = 'checked';\n          } else {\n            var status = '';\n          }\n\n          var listItem = '<li class=\"item list-hover\">' + '<label class=\"item-checkbox\" style=\"padding-right: 4px;\">' + // These 4 pixels literally vanished, I don't have the slightest clue what happened.\n          '<input class=\"checkbox\" id=\"' + task['id'] + '\" type=\"checkbox\" ' + status + '>' + '</label>' + '<label class=\"item-text list-hover\" id=\"task-' + task['id'] + '\" contenteditable=\"true\">' + task['task'] + '</label>' + '<span class=\"dashicons dashicons-trash trash\" id=\"trash-' + task['id'] + '\"></span>' + '</li>';\n          tasks_container.innerHTML += listItem; // Display tasks.\n        });\n      },\n      error: function error() {\n        console.log('AJAX error getting tasks.');\n      }\n    });\n  } // Refresh list.\n\n\n  function refresh() {\n    tasks_container.innerHTML = \"\"; // Empty the container before displaying tasks.\n\n    get_tasks();\n  } // Add new task.\n\n\n  jQuery('#new_task_form').submit(function (event) {\n    // Trigger on submit.\n    event.preventDefault();\n    jQuery.ajax({\n      url: ajaxurl,\n      type: 'POST',\n      data: {\n        action: 'add_task',\n        task: $('#new_task').val()\n      },\n      success: function success() {\n        refresh();\n      },\n      error: function error() {\n        console.log('Error addding task.');\n      }\n    });\n    $('#new_task_form')[0].reset(); // Clear input in form.\n  }); // Change task status (mark as done or not).\n\n  jQuery(document).on('click', '.checkbox', function () {\n    // Trigger on click.\n    jQuery.ajax({\n      url: ajaxurl,\n      type: 'POST',\n      data: {\n        action: 'mark_task',\n        task_id: $(this).attr('id'),\n        checked: $(this).attr('checked')\n      },\n      error: function error() {\n        console.log('Error updating task status.');\n      }\n    });\n  }); // Edit task.\n\n  jQuery(document).on('keypress', '.item-text', function (event) {\n    // Trigger on pressing the key.\n    var task_id = $(this).attr('id');\n    var text = $('#' + task_id)[0].textContent; // Get text.\n\n    if (event.keyCode == 13) {\n      // Key 13 is Enter.\n      event.preventDefault(); // Prevent new line.\n\n      jQuery.ajax({\n        url: ajaxurl,\n        type: 'POST',\n        data: {\n          action: 'edit_task',\n          task_id: task_id,\n          text: text\n        },\n        error: function error() {\n          console.log('Error editing task.');\n        }\n      });\n    }\n  }); // Delete task.\n\n  jQuery(document).on('click', '.trash', function () {\n    // Trigger on click.\n    jQuery.ajax({\n      url: ajaxurl,\n      type: 'POST',\n      data: {\n        action: 'delete_task',\n        task_id: $(this).attr('id')\n      },\n      success: function success() {\n        refresh();\n      },\n      error: function error() {\n        console.log('Error deleting task.');\n      }\n    });\n  });\n});\n\n//# sourceURL=webpack:///./src/backend/app.js?");

/***/ })

/******/ });