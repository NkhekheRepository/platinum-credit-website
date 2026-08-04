/**
 * PCL Preloader — fade-out on load.
 */
(function () {
	'use strict';
	var loader = document.getElementById('pcl-loader');
	if (!loader) return;
	window.addEventListener('load', function () {
		setTimeout(function () {
			loader.classList.add('done');
			setTimeout(function () { loader.remove(); }, 700);
		}, 400);
	});
})();
