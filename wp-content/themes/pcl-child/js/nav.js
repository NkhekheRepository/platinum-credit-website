/**
 * PCL Nav — scroll glass, mobile menu toggle, progress bar.
 */
(function () {
	'use strict';

	/* Scroll progress bar */
	var progress = document.getElementById('pcl-progress');
	if (progress) {
		window.addEventListener('scroll', function () {
			var d = document.documentElement;
			progress.style.width = (scrollY / (d.scrollHeight - innerHeight) * 100) + '%';
		}, { passive: true });
	}

	/* Nav scroll glass */
	var header = document.querySelector('.site-header');
	if (header) {
		window.addEventListener('scroll', function () {
			if (window.scrollY > 40) {
				header.classList.add('pcl-scrolled');
			} else {
				header.classList.remove('pcl-scrolled');
			}
		}, { passive: true });
	}

	/* Custom nav scroll glass (for reference nav) */
	var mainNav = document.getElementById('mainNav');
	if (mainNav) {
		window.addEventListener('scroll', function () {
			mainNav.classList.toggle('scrolled', scrollY > 30);
		}, { passive: true });
	}

	/* Mobile menu toggle */
	var menuBtn = document.querySelector('.menu-btn');
	var navLinks = document.getElementById('navlinks');
	if (menuBtn && navLinks) {
		menuBtn.addEventListener('click', function () {
			var open = navLinks.classList.toggle('open');
			menuBtn.setAttribute('aria-expanded', open);
		});
		navLinks.querySelectorAll('a').forEach(function (a) {
			a.addEventListener('click', function () {
				navLinks.classList.remove('open');
				menuBtn.setAttribute('aria-expanded', 'false');
			});
		});
	}

	/* Smooth scroll for anchor links */
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
