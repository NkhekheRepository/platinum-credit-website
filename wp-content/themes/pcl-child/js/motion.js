/**
 * PCL Motion — reveal animations, scroll progress, counters, nav glass, preloader.
 * Respects prefers-reduced-motion.
 */
(function () {
	'use strict';

	var prefersReduced = window.matchMedia('(prefers-reduced-motion: reduce)').matches;

	// ===== Preloader fade-out =====
	var loader = document.getElementById('pcl-loader');
	if (loader) {
		window.addEventListener('load', function () {
			setTimeout(function () {
				loader.classList.add('done');
				setTimeout(function () { loader.remove(); }, 700);
			}, 400);
		});
	}

	// ===== Scroll progress bar =====
	var progress = document.getElementById('pcl-progress');
	if (progress) {
		window.addEventListener('scroll', function () {
			var d = document.documentElement;
			progress.style.width = (scrollY / (d.scrollHeight - innerHeight) * 100) + '%';
		}, { passive: true });
	}

	// ===== Nav scroll glass =====
	var header = document.querySelector('.site-header');
	if (header) {
		var lastY = 0;
		window.addEventListener('scroll', function () {
			var y = window.scrollY;
			if (y > 40) {
				header.classList.add('pcl-scrolled');
			} else {
				header.classList.remove('pcl-scrolled');
			}
			lastY = y;
		}, { passive: true });
	}

	// ===== Range slider fill =====
	function updateSliderFill(el) {
		var min = parseFloat(el.min) || 0;
		var max = parseFloat(el.max) || 100;
		var val = parseFloat(el.value) || 0;
		var pct = ((val - min) / (max - min)) * 100;
		el.style.setProperty('--fill', pct + '%');
	}
	document.querySelectorAll('input[type=range]').forEach(function (el) {
		updateSliderFill(el);
		el.addEventListener('input', function () { updateSliderFill(el); });
	});

	if (prefersReduced) return;

	// ===== Reveal + stagger via IntersectionObserver =====
	if (!('IntersectionObserver' in window)) {
		document.querySelectorAll('.pcl-reveal, .pcl-stagger').forEach(function (el) {
			el.classList.add('pcl-in');
		});
		return;
	}

	var io = new IntersectionObserver(function (entries) {
		entries.forEach(function (e) {
			if (!e.isIntersecting) return;
			e.target.classList.add('pcl-in');
			if (e.target.hasAttribute('data-count-target')) runCounters(e.target);
			io.unobserve(e.target);
		});
	}, { threshold: 0.14 });

	document.querySelectorAll('.pcl-reveal, .pcl-stagger, [data-count-target]').forEach(function (el) {
		io.observe(el);
	});

	// ===== Counter animation =====
	function runCounters(band) {
		var counters = band.querySelectorAll('.pcl-count');
		counters.forEach(function (el) {
			var to = parseInt(el.getAttribute('data-to'), 10);
			if (isNaN(to)) return;
			var t0 = performance.now();
			var dur = 1400;
			function tick(t) {
				var p = Math.min(1, (t - t0) / dur);
				el.textContent = Math.round(to * (1 - Math.pow(1 - p, 3)));
				if (p < 1) requestAnimationFrame(tick);
			}
			requestAnimationFrame(tick);
		});
	}

	// ===== Smooth scroll for anchor links =====
	document.querySelectorAll('a[href^="#"]').forEach(function (a) {
		a.addEventListener('click', function (e) {
			var id = a.getAttribute('href');
			if (!id || id === '#') return;
			var target = document.querySelector(id);
			if (target) {
				e.preventDefault();
				target.scrollIntoView({ behavior: 'smooth', block: 'start' });
			}
		});
	});
})();
