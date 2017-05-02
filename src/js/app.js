'use strict';

class $ {
	constructor($domElement) {
		if (typeof $domElement !== 'string') {
			throw new Error('The value should be a string');
		}

		if ($domElement[0] === '#') {
			this.el = document.querySelector($domElement);
		}
		if ($domElement[0] === '.') {
			this.el = document.querySelectorAll($domElement);
		}

	}
}

/*
if (el.classList)
  el.classList.remove(className);
else
  el.className = el.className.replace(new RegExp('(^|\\b)' + className.split(' ').join('|') + '(\\b|$)', 'gi'), ' ');
 */
