// ==== HEADER ==== //

// A simple wrapper for all your custom jQuery that belongs in the header
;(function($){
  $(function(){
    // Initialize svg4everybody 2.0.0+, which is supposed to be done in the header
    svg4everybody();
  });
}(jQuery));

// function toggleDropdown(el) {
// 	// el.preventDefault();
// 	var parent = el.parentNode;
// 	if (!parent.classList.contains('open')) {
// 		parent.classList.add('open');
// 	} else {
// 		parent.classList.remove('open');
// 	}
// 	console.log(parent);
// }
