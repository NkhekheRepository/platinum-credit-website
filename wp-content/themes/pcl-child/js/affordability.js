/**
 * PCL Affordability Self-Assessment — 30% of gross benchmark, 10% p.a. rate.
 * Bank statement parser (browser-only, never uploaded).
 */
(function () {
	'use strict';

	var AF_BENCHMARK = 0.30;
	var AF_RATE = 0.10 / 12;
	var fmt = function (n) {
		return 'M' + n.toLocaleString('en-US', { minimumFractionDigits: 2, maximumFractionDigits: 2 });
	};
	var pct = function (n) {
		return (n * 100).toLocaleString('en-US', { minimumFractionDigits: 1, maximumFractionDigits: 1 }) + '%';
	};

	/* Map PCL-prefixed IDs or original IDs */
	function el(id) {
		return document.getElementById('pcl-' + id) || document.getElementById(id);
	}

	function afford() {
		var basicEl = el('afBasic');
		var nettEl = el('afNett');
		var debitsEl = el('afDebits');
		var livingEl = el('afLiving');
		var termEl = el('afTerm');
		if (!basicEl || !nettEl) return;

		var basic = parseFloat(basicEl.value) || 0;
		var nett = parseFloat(nettEl.value) || 0;
		var debits = debitsEl ? parseFloat(debitsEl.value) || 0 : 0;
		var living = livingEl ? parseFloat(livingEl.value) || 0 : 0;
		var n = termEl ? parseInt(termEl.value, 10) || 12 : 12;
		var req = window.__pclInst || window.__inst || 0;

		var badge = el('afBadge');
		var maxEl = el('afMax');
		var loanEl = el('afLoan');
		var newNettEl = el('afNew');
		var pctEl = el('afPct');
		var reqEl = el('afReq');

		if (reqEl) reqEl.textContent = fmt(req);

		if (basic <= 0 || nett <= 0) {
			if (badge) { badge.dataset.state = 'idle'; badge.textContent = 'Enter your figures'; }
			if (maxEl) maxEl.textContent = 'M0.00';
			if (loanEl) loanEl.textContent = 'M0.00';
			if (newNettEl) newNettEl.textContent = 'M0.00';
			if (pctEl) pctEl.textContent = '0.0%';
			return;
		}

		var disposable = nett - debits - living;
		var cap = AF_BENCHMARK * basic;
		var maxInst = Math.max(0, Math.min(disposable, cap));
		var loan = maxInst > 0 ? maxInst * (1 - Math.pow(1 + AF_RATE, -n)) / AF_RATE : 0;

		if (maxEl) maxEl.textContent = fmt(maxInst);
		if (loanEl) loanEl.textContent = fmt(loan);
		if (newNettEl) newNettEl.textContent = fmt(nett - maxInst);
		if (pctEl) pctEl.textContent = pct(basic > 0 ? maxInst / basic : 0);

		if (badge) {
			if (maxInst <= 0) {
				badge.dataset.state = 'review';
				badge.textContent = 'Needs review \u2014 talk to us';
			} else if (req <= maxInst) {
				badge.dataset.state = 'pass';
				badge.textContent = 'Affordable \u2014 your estimator loan fits';
			} else if (req <= maxInst * 1.15) {
				badge.dataset.state = 'watch';
				badge.textContent = 'Close \u2014 trim the amount or extend the term';
			} else {
				badge.dataset.state = 'review';
				badge.textContent = 'Estimator loan exceeds your capacity \u2014 adjust it above';
			}
		}
	}

	window.__pclAfford = afford;
	window.__afford = afford;

	var STORE_KEY = 'pcl-afford-v1';

	/* Persist inputs (debounced) */
	var persistTimer = null;
	function persist() {
		clearTimeout(persistTimer);
		persistTimer = setTimeout(function () {
			try {
				var data = {};
				['afBasic', 'afNett', 'afDebits', 'afLiving', 'afTerm'].forEach(function (id) {
					var e = el(id);
					if (e) data[id] = e.value;
				});
				localStorage.setItem(STORE_KEY, JSON.stringify(data));
			} catch (e) {}
		}, 300);
	}

	/* Restore persisted inputs */
	try {
		var saved = JSON.parse(localStorage.getItem(STORE_KEY) || 'null');
		if (saved) {
			['afBasic', 'afNett', 'afDebits', 'afLiving', 'afTerm'].forEach(function (id) {
				var e = el(id);
				if (e && saved[id] !== undefined) e.value = saved[id];
			});
		}
	} catch (e) {}

	/* Wire inputs */
	['afBasic', 'afNett', 'afDebits', 'afLiving', 'afTerm'].forEach(function (id) {
		var e = el(id);
		if (e) { e.addEventListener('input', afford); e.addEventListener('input', persist); }
	});

	afford();

	/* Statement auto-scan (browser-only, never uploaded) */
	(function () {
		var dz = el('dropzone') || document.getElementById('dropzone');
		var fi = el('statementInput') || document.getElementById('statementInput');
		var fn = el('fname') || document.getElementById('fname');
		if (!dz || !fi) return;

		dz.addEventListener('click', function () { fi.click(); });
		dz.addEventListener('keydown', function (e) {
			if (e.key === 'Enter' || e.key === ' ') { e.preventDefault(); fi.click(); }
		});
		['dragenter', 'dragover'].forEach(function (ev) {
			dz.addEventListener(ev, function (e) { e.preventDefault(); dz.classList.add('drag'); });
		});
		['dragleave', 'drop'].forEach(function (ev) {
			dz.addEventListener(ev, function (e) { e.preventDefault(); dz.classList.remove('drag'); });
		});
		dz.addEventListener('drop', function (e) { var f = e.dataTransfer.files[0]; if (f) read(f); });
		fi.addEventListener('change', function (e) { var f = e.target.files[0]; if (f) read(f); });

		function read(file) {
			if (fn) fn.textContent = 'Reading ' + file.name + ' \u2026';
			var r = new FileReader();
			r.onload = function (e) {
				var res = parse(e.target.result);
				if (!res.credits.length) {
					if (fn) fn.textContent = file.name + ' \u2014 no clear income lines found. Please enter figures manually.';
					return;
				}
				var nettEl2 = el('afNett');
				var debitsEl2 = el('afDebits');
				if (nettEl2) nettEl2.value = res.income.toFixed(2);
				if (res.commitments > 0 && debitsEl2) debitsEl2.value = res.commitments.toFixed(2);
				if (fn) fn.textContent = file.name + ' \u2014 detected avg monthly inflow ' + fmt(res.income) + '. Confirm and complete the remaining fields.';
				afford();
			};
			r.readAsText(file);
		}

		function parse(text) {
			var lines = text.split(/\r?\n/).filter(function (l) { return l.trim(); });
			var credits = [], debits = [];
			var amountRe = /(-?\d[\d,]*\.\d{2})/g;
			lines.forEach(function (line) {
				var lower = line.toLowerCase();
				var m = line.match(amountRe);
				if (!m) return;
				var v = parseFloat(m[m.length - 1].replace(/,/g, ''));
				if (isNaN(v) || v === 0) return;
				if (/debit order|loan|instal|repayment|\bdr\b/.test(lower)) {
					debits.push(Math.abs(v));
				} else if (/salary|deposit|credit|received|\bcr\b/.test(lower) || (v > 0 && !/withdraw|purchase|fee/.test(lower))) {
					credits.push(Math.abs(v));
				}
			});
			var months = Math.max(1, Math.round(lines.length / 30));
			var sum = function (a) { return a.reduce(function (x, y) { return x + y; }, 0); };
			return {
				credits: credits,
				debits: debits,
				income: credits.length ? sum(credits) / Math.min(months, credits.length) : 0,
				commitments: debits.length ? sum(debits) / Math.min(months, debits.length) : 0
			};
		}
	})();
})();
