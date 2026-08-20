/**
 * PCL Spotlight — pointer-tracked glow on [data-spotlight] elements.
 * Injects <i class="pcl-spot"> overlay, tracks cursor via CSS custom
 * properties (--sp-x / --sp-y). Fine pointers + no reduced motion only.
 * Paint-only; rAF-throttled; transform/opacity safe envelope.
 */
(function () {
	'use strict';

	if (window.matchMedia('(pointer: fine)').matches &&
		!window.matchMedia('(prefers-reduced-motion: reduce)').matches) {

		document.querySelectorAll('[data-spotlight]').forEach(function (host) {
			var spot = document.createElement('i');
			spot.className = 'pcl-spot' + (host.getAttribute('data-spotlight') === 'hot' ? ' hot' : '');
			spot.setAttribute('aria-hidden', 'true');
			host.appendChild(spot);

			var ticking = false;
			host.addEventListener('pointermove', function (e) {
				if (ticking) return;
				ticking = true;
				requestAnimationFrame(function () {
					var r = host.getBoundingClientRect();
					var x = ((e.clientX - r.left) / r.width) * 100;
					var y = ((e.clientY - r.top) / r.height) * 100;
					host.style.setProperty('--sp-x', x + '%');
					host.style.setProperty('--sp-y', y + '%');
					ticking = false;
				});
			});
		});
	}
})();