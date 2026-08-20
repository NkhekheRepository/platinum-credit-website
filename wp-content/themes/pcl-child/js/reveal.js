/**
 * PCL Reveal — IntersectionObserver reveal, stagger, and counter animations.
 * Respects prefers-reduced-motion.
 */
(function () {
	'use strict';

	var prefersReduced = window.matchMedia('(prefers-reduced-motion: reduce)').matches;

	/* Range slider fill (runs always) */
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

	/* Fallback if no IntersectionObserver */
	if (!('IntersectionObserver' in window)) {
		document.querySelectorAll('.pcl-reveal, .pcl-stagger, .reveal, .stagger').forEach(function (el) {
			el.classList.add('pcl-in');
			el.classList.add('in');
		});
		return;
	}

	var io = new IntersectionObserver(function (entries) {
		entries.forEach(function (e) {
			if (!e.isIntersecting) return;
			e.target.classList.add('pcl-in');
			e.target.classList.add('in');
			if (e.target.hasAttribute('data-count-target')) runCounters(e.target);
			if (e.target.id === 'countersBand') runCountersBand();
			io.unobserve(e.target);
		});
	}, { threshold: 0.14 });

	document.querySelectorAll('.pcl-reveal, .pcl-stagger, .reveal, .stagger, [data-count-target], #countersBand').forEach(function (el) {
		io.observe(el);
	});

	/* Counter animation for PCL stat elements */
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

	/* Counter animation for reference .count elements */
	function runCountersBand() {
		document.querySelectorAll('.count').forEach(function (el) {
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

	/* Pointer tilt on cards — fine pointers only, transform-only */
	if (window.matchMedia('(pointer: fine) and (prefers-reduced-motion: no-preference)').matches) {
		var MAX_TILT = 7;
		document.querySelectorAll('.pcl-card').forEach(function (card) {
			card.addEventListener('pointermove', function (e) {
				var r = card.getBoundingClientRect();
				var px = (e.clientX - r.left) / r.width - 0.5;
				var py = (e.clientY - r.top) / r.height - 0.5;
				card.style.transform = 'perspective(800px) rotateX(' + (-py * MAX_TILT).toFixed(2) + 'deg) rotateY(' + (px * MAX_TILT).toFixed(2) + 'deg) translateY(-4px)';
			});
			card.addEventListener('pointerleave', function () {
				card.style.transform = '';
			});
		});
	}

	/* Subtle magnetic pull on primary CTAs — fine pointers only */
	if (window.matchMedia('(pointer: fine) and (prefers-reduced-motion: no-preference)').matches) {
		document.querySelectorAll('.pcl-btn-brand, .pcl-btn-purple, .pcl-hero-ctas .wp-block-button__link').forEach(function (btn) {
			btn.addEventListener('pointermove', function (e) {
				var r = btn.getBoundingClientRect();
				var dx = (e.clientX - (r.left + r.width / 2)) * 0.14;
				var dy = (e.clientY - (r.top + r.height / 2)) * 0.3;
				btn.style.transform = 'translate(' + dx.toFixed(1) + 'px,' + dy.toFixed(1) + 'px)';
			});
			btn.addEventListener('pointerleave', function () {
				btn.style.transform = '';
			});
		});
	}

	/* Steps: tap-to-expand accordion (visual collapse only below 980px via CSS) */
	var stepsWrap = document.querySelector('.pcl-steps');
	if (stepsWrap) {
		stepsWrap.querySelectorAll('.pcl-step').forEach(function (step) {
			var head = step.querySelector('h3');
			if (!head) return;
			head.setAttribute('role', 'button');
			head.setAttribute('tabindex', '0');
			head.addEventListener('click', function () {
				stepsWrap.querySelectorAll('.pcl-step.active').forEach(function (s) { if (s !== step) s.classList.remove('active'); });
				step.classList.toggle('active');
			});
			head.addEventListener('keydown', function (e) {
				if (e.key === 'Enter' || e.key === ' ') { e.preventDefault(); head.click(); }
			});
		});
	}
})();
