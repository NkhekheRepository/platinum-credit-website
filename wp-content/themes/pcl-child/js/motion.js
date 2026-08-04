/**
 * PCL Motion — orchestrator. Loads all PCL JS modules.
 * Individual modules are self-executing; this file ensures load order.
 * Modules: preloader → nav → reveal → hero → estimator → affordability.
 */
(function () {
	'use strict';
	/* All modules are IIFE and self-contained.
	   This file exists as a single enqueue target for functions.php.
	   Load order in the DOM:
	     1. preloader.js  (earliest — hides loader)
	     2. nav.js        (scroll glass, progress, mobile menu)
	     3. reveal.js     (IntersectionObserver, counters, range fill)
	     4. hero.js       (word-by-word, shards)
	     5. estimator.js  (loan calculator)
	     6. affordability.js (self-assessment + statement parser)
	   All are loaded via individual <script> tags or concatenated.
	   This orchestrator is kept for backward compatibility. */
})();
