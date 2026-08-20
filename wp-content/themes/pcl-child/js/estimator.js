/**
 * PCL Loan Estimator — slider-driven amortisation calculator.
 * Reads #pcl-amt / #pcl-term (or #amt / #term), writes output fields.
 * Exposes window.__pclEstCalc() for cross-module calls.
 */
(function () {
	'use strict';

	var BENCH_RATE = 0.10; // 10% p.a.
	var STORE_KEY = 'pcl-estimator-v1';
	var fmt = function (n) {
		return 'M' + n.toLocaleString('en-US', { minimumFractionDigits: 2, maximumFractionDigits: 2 });
	};

	function paintTrack(el) {
		var min = parseFloat(el.min) || 0;
		var max = parseFloat(el.max) || 100;
		var val = parseFloat(el.value) || 0;
		var pct = ((val - min) / (max - min)) * 100;
		el.style.setProperty('--fill', pct + '%');
	}

	/* Animated number roll (respects reduced motion) */
	var reduceMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;
	function roll(el, to, suffix) {
		if (!el) return;
		var from = parseFloat(String(el.textContent).replace(/[^0-9.-]/g, '')) || 0;
		if (reduceMotion || Math.abs(to - from) < 0.5) { el.textContent = fmt(to) + (suffix || ''); return; }
		var t0 = performance.now();
		var dur = 350;
		function tick(t) {
			var p = Math.min(1, (t - t0) / dur);
			var ease = 1 - Math.pow(1 - p, 3);
			el.textContent = fmt(from + (to - from) * ease) + (suffix || '');
			if (p < 1) requestAnimationFrame(tick);
		}
		requestAnimationFrame(tick);
	}

	function calc() {
		var amtEl = document.getElementById('pcl-amt') || document.getElementById('amt');
		var termEl = document.getElementById('pcl-term') || document.getElementById('term');
		if (!amtEl || !termEl) return;

		var P = parseFloat(amtEl.value) || 0;
		var n = parseInt(termEl.value, 10) || 1;
		var r = BENCH_RATE / 12;
		var m = P > 0 && n > 0 ? P * r / (1 - Math.pow(1 + r, -n)) : 0;

		/* PCL output fields */
		var amtOut = document.getElementById('pcl-amtOut') || document.getElementById('amtOut');
		var termOut = document.getElementById('pcl-termOut') || document.getElementById('termOut');
		var monthlyEl = document.getElementById('pcl-monthly') || document.getElementById('monthly');
		var totalEl = document.getElementById('pcl-total') || document.getElementById('total');
		var princEl = document.getElementById('pcl-sumPrincipal') || document.getElementById('sumPrincipal');
		var costEl = document.getElementById('pcl-sumCost') || document.getElementById('sumCost');

		if (amtOut) amtOut.textContent = fmt(P);
		if (termOut) termOut.textContent = n + (n > 1 ? ' months' : ' month');
		roll(monthlyEl, m);
		if (totalEl) totalEl.textContent = fmt(m * n);
		if (princEl) princEl.textContent = fmt(P);
		if (costEl) costEl.textContent = fmt(m * n - P);

		paintTrack(amtEl);
		paintTrack(termEl);

		/* Expose for affordability module */
		window.__pclInst = m;

		/* Gem intensity callback */
		var ratio = (P - parseFloat(amtEl.min)) / (parseFloat(amtEl.max) - parseFloat(amtEl.min));
		if (window.__setGemIntensity) window.__setGemIntensity(ratio);

		/* Live repayment bar: principal vs interest split */
		var bar = document.getElementById('pcl-repay-bar');
		if (bar) {
			var total = m * n;
			var interest = total - P;
			var pctP = total > 0 ? (P / total) * 100 : 0;
			var pctI = total > 0 ? (interest / total) * 100 : 0;
			var segP = bar.querySelector('.pcl-rb-princ');
			var segI = bar.querySelector('.pcl-rb-int');
			if (segP) { segP.style.width = pctP + '%'; segP.setAttribute('aria-valuenow', pctP.toFixed(1)); }
			if (segI) { segI.style.width = pctI + '%'; segI.setAttribute('aria-valuenow', pctI.toFixed(1)); }
		}

		/* Persist to localStorage (debounced) */
		try {
			localStorage.setItem(STORE_KEY, JSON.stringify({ amt: P, term: n }));
		} catch (e) {}

		/* Trigger affordability recalc */
		if (window.__pclAfford) window.__pclAfford();
	}

	/* Restore persisted values */
	try {
		var saved = JSON.parse(localStorage.getItem(STORE_KEY) || 'null');
		if (saved && saved.amt && saved.term) {
			var amtElR = document.getElementById('pcl-amt') || document.getElementById('amt');
			var termElR = document.getElementById('pcl-term') || document.getElementById('term');
			if (amtElR) amtElR.value = Math.min(parseFloat(amtElR.max), Math.max(parseFloat(amtElR.min), saved.amt));
			if (termElR) termElR.value = Math.min(parseFloat(termElR.max), Math.max(parseFloat(termElR.min), saved.term));
		}
	} catch (e) {}

	/* Stepper buttons */
	function wireStepper(btnId, inputId, delta) {
		var btn = document.getElementById(btnId);
		var input = document.getElementById(inputId) || document.getElementById(inputId.replace('pcl-', ''));
		if (btn && input) {
			btn.addEventListener('click', function () {
				input.value = Math.min(parseFloat(input.max), Math.max(parseFloat(input.min), parseFloat(input.value) + delta));
				calc();
			});
		}
	}

	wireStepper('pcl-amtMinus', 'pcl-amt', -500);
	wireStepper('pcl-amtPlus', 'pcl-amt', 500);
	wireStepper('pcl-termMinus', 'pcl-term', -3);
	wireStepper('pcl-termPlus', 'pcl-term', 3);
	wireStepper('amtMinus', 'amt', -500);
	wireStepper('amtPlus', 'amt', 500);
	wireStepper('termMinus', 'term', -3);
	wireStepper('termPlus', 'term', 3);

	/* Wire range inputs */
	var amtEl = document.getElementById('pcl-amt') || document.getElementById('amt');
	var termEl = document.getElementById('pcl-term') || document.getElementById('term');
	if (amtEl) amtEl.addEventListener('input', calc);
	if (termEl) termEl.addEventListener('input', calc);

	/* Initial calc */
	calc();

	/* Expose for affordability module */
	window.__pclEstCalc = calc;
})();
