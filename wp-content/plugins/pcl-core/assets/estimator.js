/**
 * PCL Estimator — loan calculator.
 * Math: P*r/(1-(1+r)^-n) where r = 0.10/12 (10% APR monthly)
 * Matches reference file calc() exactly.
 */
(function () {
	'use strict';

	var amt = document.getElementById('pcl-amt');
	var term = document.getElementById('pcl-term');
	if (!amt || !term) return;

	var RATE = 0.10 / 12; // 10% APR monthly

	function fmt(n) {
		return 'M' + n.toLocaleString('en-US', { minimumFractionDigits: 2, maximumFractionDigits: 2 });
	}

	function calc() {
		var P = +amt.value;
		var n = +term.value;
		var r = RATE;
		var m = P * r / (1 - Math.pow(1 + r, -n));
		var total = m * n;

		var amtOut = document.getElementById('pcl-amt-out');
		var termOut = document.getElementById('pcl-term-out');
		var monthly = document.getElementById('pcl-monthly');
		var totalEl = document.getElementById('pcl-total');
		var sumPrincipal = document.getElementById('pcl-sum-principal');
		var sumCost = document.getElementById('pcl-sum-cost');

		if (amtOut) amtOut.textContent = fmt(P);
		if (termOut) termOut.textContent = n + (n > 1 ? ' months' : ' month');
		if (monthly) monthly.textContent = fmt(m);
		if (totalEl) totalEl.textContent = 'Total: ' + fmt(total) + ' over ' + n + ' months';
		if (sumPrincipal) sumPrincipal.textContent = fmt(P);
		if (sumCost) sumCost.textContent = fmt(total - P);

		// Expose for affordability block
		window.__pclInst = m;
	}

	function stepBtn(id, el, d) {
		var btn = document.getElementById(id);
		if (!btn) return;
		btn.addEventListener('click', function () {
			el.value = Math.min(+el.max, Math.max(+el.min, +el.value + d));
			calc();
		});
	}

	stepBtn('pcl-amt-minus', amt, -500);
	stepBtn('pcl-amt-plus', amt, 500);
	stepBtn('pcl-term-minus', term, -3);
	stepBtn('pcl-term-plus', term, 3);

	amt.addEventListener('input', calc);
	term.addEventListener('input', calc);
	calc();
})();
