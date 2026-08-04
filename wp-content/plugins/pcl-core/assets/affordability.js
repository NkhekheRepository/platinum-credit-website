/**
 * PCL Affordability — self-assessment.
 * Math: 30% of gross salary benchmark, 10% APR monthly rate.
 * Statement parser: browser-only, never uploaded.
 * Matches reference file afford() + parse() exactly.
 */
(function () {
	'use strict';

	var AF_BENCHMARK = 0.30;
	var AF_RATE = 0.10 / 12;

	var ids = ['pcl-af-basic', 'pcl-af-nett', 'pcl-af-debits', 'pcl-af-living', 'pcl-af-term'];
	var els = {};
	ids.forEach(function (id) { els[id] = document.getElementById(id); });

	if (!els['pcl-af-basic']) return;

	function fmt(n) {
		return 'M' + n.toLocaleString('en-US', { minimumFractionDigits: 2, maximumFractionDigits: 2 });
	}

	function pct(n) {
		return (n * 100).toLocaleString('en-US', { minimumFractionDigits: 1, maximumFractionDigits: 1 }) + '%';
	}

	function afford() {
		var basic = +els['pcl-af-basic'].value || 0;
		var nett = +els['pcl-af-nett'].value || 0;
		var debits = +els['pcl-af-debits'].value || 0;
		var living = +els['pcl-af-living'].value || 0;
		var n = +els['pcl-af-term'].value;
		var req = window.__pclInst || 0;

		var badge = document.getElementById('pcl-af-badge');
		var reqEl = document.getElementById('pcl-af-req');
		var maxEl = document.getElementById('pcl-af-max');
		var loanEl = document.getElementById('pcl-af-loan');
		var newEl = document.getElementById('pcl-af-new');
		var pctEl = document.getElementById('pcl-af-pct');

		if (reqEl) reqEl.textContent = fmt(req);

		if (basic <= 0 || nett <= 0) {
			if (badge) { badge.dataset.state = 'idle'; badge.textContent = 'Enter your figures'; }
			['pcl-af-max', 'pcl-af-loan', 'pcl-af-new'].forEach(function (id) {
				var el = document.getElementById(id);
				if (el) el.textContent = 'M0.00';
			});
			if (pctEl) pctEl.textContent = '0.0%';
			return;
		}

		var disposable = nett - debits - living;
		var cap = AF_BENCHMARK * basic;
		var maxInst = Math.max(0, Math.min(disposable, cap));
		var loan = maxInst > 0 ? maxInst * (1 - Math.pow(1 + AF_RATE, -n)) / AF_RATE : 0;

		if (maxEl) maxEl.textContent = fmt(maxInst);
		if (loanEl) loanEl.textContent = fmt(loan);
		if (newEl) newEl.textContent = fmt(nett - maxInst);
		if (pctEl) pctEl.textContent = pct(basic > 0 ? maxInst / basic : 0);

		if (maxInst <= 0) {
			if (badge) { badge.dataset.state = 'review'; badge.textContent = 'Needs review — talk to us'; }
		} else if (req <= maxInst) {
			if (badge) { badge.dataset.state = 'pass'; badge.textContent = 'Affordable — your estimator loan fits'; }
		} else if (req <= maxInst * 1.15) {
			if (badge) { badge.dataset.state = 'watch'; badge.textContent = 'Close — trim the amount or extend the term'; }
		} else {
			if (badge) { badge.dataset.state = 'review'; badge.textContent = 'Estimator loan exceeds your capacity — adjust it above'; }
		}
	}

	ids.forEach(function (id) {
		if (els[id]) els[id].addEventListener('input', afford);
	});
	afford();

	// ===== Statement auto-scan (browser-only, never uploaded) =====
	var dz = document.getElementById('pcl-dropzone');
	var fi = document.getElementById('pcl-statement-input');
	var fn = document.getElementById('pcl-fname');

	if (dz && fi) {
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
		dz.addEventListener('drop', function (e) {
			var f = e.dataTransfer.files[0];
			if (f) readFile(f);
		});
		fi.addEventListener('change', function (e) {
			var f = e.target.files[0];
			if (f) readFile(f);
		});

		function readFile(file) {
			if (fn) fn.textContent = 'Reading ' + file.name + ' …';
			var r = new FileReader();
			r.onload = function (e) {
				var res = parseText(e.target.result);
				if (!res.credits.length) {
					if (fn) fn.textContent = file.name + ' — no clear income lines found. Please enter figures manually.';
					return;
				}
				els['pcl-af-nett'].value = res.income.toFixed(2);
				if (res.commitments > 0) els['pcl-af-debits'].value = res.commitments.toFixed(2);
				if (fn) fn.textContent = file.name + ' — detected avg monthly inflow ' + fmt(res.income) + '. Confirm and complete the remaining fields.';
				afford();
			};
			r.readAsText(file);
		}

		function parseText(text) {
			var lines = text.split(/\r?\n/).filter(function (l) { return l.trim(); });
			var credits = [];
			var debits = [];
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
			function sum(a) { return a.reduce(function (x, y) { return x + y; }, 0); }
			return {
				credits: credits,
				debits: debits,
				income: credits.length ? sum(credits) / Math.min(months, credits.length) : 0,
				commitments: debits.length ? sum(debits) / Math.min(months, debits.length) : 0
			};
		}
	}
})();
