/**
 * PCL Hero — word-by-word headline animation and floating shard particles.
 * Respects prefers-reduced-motion.
 */
(function () {
	'use strict';

	var prefersReduced = window.matchMedia('(prefers-reduced-motion: reduce)').matches;
	if (prefersReduced) return;

	/* Hero headline word-by-word animation */
	var heroTitle = document.getElementById('heroTitle');
	if (heroTitle) {
		var parts = [];
		heroTitle.childNodes.forEach(function (nd) {
			if (nd.nodeType === 3) {
				nd.textContent.split(/\s+/).filter(Boolean).forEach(function (w) {
					parts.push({ w: w });
				});
			} else {
				nd.textContent.split(/\s+/).filter(Boolean).forEach(function (w) {
					parts.push({ w: w, cls: nd.className });
				});
			}
		});
		heroTitle.innerHTML = parts.map(function (p, i) {
			return '<span class="w ' + (p.cls || '') + '" style="animation-delay:' + (0.15 + i * 0.07) + 's">' + p.w + '&nbsp;</span>';
		}).join('');
	}

	/* Floating facet shards */
	var shardBox = document.getElementById('shards') || document.getElementById('pcl-shards');
	if (shardBox) {
		for (var i = 0; i < 14; i++) {
			var s = document.createElement('i');
			s.className = 'shard';
			var sz = 10 + Math.random() * 26;
			s.style.cssText = 'left:' + (Math.random() * 100) + '%;top:' + (Math.random() * 100) + '%;width:' + sz + 'px;height:' + sz + 'px;opacity:' + (0.2 + Math.random() * 0.4) + ';--dur:' + (12 + Math.random() * 14) + 's;--dx:' + (-40 + Math.random() * 80) + 'px;--dy:' + (-70 + Math.random() * 40) + 'px;--rot:' + (-30 + Math.random() * 60) + 'deg';
			shardBox.appendChild(s);
		}
	}

	/* Scroll-linked parallax: gem + shards drift at different rates.
	   Desktop only, transform-only, respects prefers-reduced-motion. */
	if (window.matchMedia('(min-width: 981px) and (prefers-reduced-motion: no-preference)').matches) {
		var gem = document.querySelector('.pcl-hero-gem');
		var hero = document.querySelector('.pcl-hero');
		if (gem && hero) {
			var ticking = false;
			var onScroll = function () {
				if (ticking) return;
				ticking = true;
				requestAnimationFrame(function () {
					var y = window.scrollY;
					if (y < hero.offsetHeight) {
						gem.style.transform = 'translateY(' + (y * 0.16) + 'px)';
						if (shardBox) shardBox.style.transform = 'translateY(' + (y * -0.08) + 'px)';
					}
					ticking = false;
				});
			};
			window.addEventListener('scroll', onScroll, { passive: true });
		}
	}
})();
