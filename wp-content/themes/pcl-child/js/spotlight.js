/**
 * PCL Spotlight — pointer-tracked glow on [data-spotlight] elements.
 * Injects <i class="pcl-spot"> overlay, tracks cursor via CSS custom
 * properties (--sp-x / --sp-y). Fine pointers + no reduced motion only.
 * Paint-only; rAF-throttled; transform/opacity safe envelope.
 * Also supports tap-triggered spotlight on coarse pointers (mobile).
 */
(function () {
	'use strict';

	var reduced = window.matchMedia('(prefers-reduced-motion: reduce)').matches;

	// Desktop: fine pointer tracking
	if (window.matchMedia('(pointer: fine)').matches && !reduced) {
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

	// Mobile: tap-triggered spotlight
	if (window.matchMedia('(pointer: coarse)').matches && !reduced) {
		document.querySelectorAll('[data-spotlight]').forEach(function (host) {
			var spot = document.createElement('i');
			spot.className = 'pcl-spot' + (host.getAttribute('data-spotlight') === 'hot' ? ' hot' : '');
			spot.setAttribute('aria-hidden', 'true');
			host.style.position = 'relative';
			host.style.overflow = 'visible';
			host.appendChild(spot);

			var timeoutId = null;
			host.addEventListener('pointerdown', function (e) {
				if (timeoutId) clearTimeout(timeoutId);
				var rect = host.getBoundingClientRect();
				var x = ((e.clientX - rect.left) / rect.width) * 100;
				var y = ((e.clientY - rect.top) / rect.height) * 100;
				spot.style.setProperty('--sp-x', x + '%');
				spot.style.setProperty('--sp-y', y + '%');
				spot.style.opacity = '1';
				timeoutId = setTimeout(function () {
					spot.style.opacity = '0';
				}, 800);
			});
		});
	}
})();