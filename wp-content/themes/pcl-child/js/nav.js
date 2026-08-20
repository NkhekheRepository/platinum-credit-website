/**
 * PCL Nav — scroll glass, mobile menu toggle, progress bar, scroll-spy.
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
	var menuBtn = document.querySelector('.pcl-menu-btn') || document.querySelector('.menu-btn');
	var navLinks = document.getElementById('pcl-navlinks') || document.getElementById('navlinks');
	if (menuBtn && navLinks) {
		var lockScroll = function (lock) {
			if (lock) {
				document.body.style.overflow = 'hidden';
			} else {
				document.body.style.overflow = '';
			}
		};
		var setOpen = function (open) {
			navLinks.classList.toggle('open', open);
			menuBtn.setAttribute('aria-expanded', String(open));
			menuBtn.classList.toggle('open', open);
			lockScroll(open);
		};
		menuBtn.addEventListener('click', function () {
			setOpen(!navLinks.classList.contains('open'));
		});
		// Outside-tap-to-close
		navLinks.addEventListener('click', function (e) {
			if (e.target !== e.currentTarget) return;
			setOpen(false);
		});
		// Staggered link animation
		var NavLinks = navLinks.querySelectorAll('a');
		var stagger = 0;
		NavLinks.forEach(function (a) {
			a.style.transitionDelay = stagger + 'ms';
			stagger += 60;
		});
		navLinks.querySelectorAll('a').forEach(function (a) {
			a.addEventListener('click', function () {
				setOpen(false);
			});
		});
		document.addEventListener('keydown', function (e) {
			if (e.key === 'Escape' && navLinks.classList.contains('open')) {
				setOpen(false);
				menuBtn.focus();
			}
		});
		window.addEventListener('resize', function () {
			if (innerWidth > 980) setOpen(false);
		}, { passive: true });
	}

	/* Scroll-spy: highlight active section link */
	var spyLinks = document.querySelectorAll('.pcl-nav-links a[href^="#"]');
	var sections = [];
	spyLinks.forEach(function (a) {
		var id = a.getAttribute('href');
		if (!id || id === '#') return;
		var sec = document.querySelector(id);
		if (sec) sections.push({ link: a, sec: sec });
	});
	if (sections.length && 'IntersectionObserver' in window) {
		var spy = new IntersectionObserver(function (entries) {
			entries.forEach(function (e) {
				if (!e.isIntersecting) return;
				sections.forEach(function (s) { s.link.classList.remove('active'); });
				var current = sections.filter(function (s) { return s.sec === e.target; })[0];
				if (current) current.link.classList.add('active');
			});
		}, { rootMargin: '-40% 0px -55% 0px' });
		sections.forEach(function (s) { spy.observe(s.sec); });
	}

	/* Smooth scroll for anchor links */
	document.querySelectorAll('a[href^="#"]').forEach(function (a) {
		a.addEventListener('click', function (e) {
			var id = a.getAttribute('href');
			if (!id || id === '#') return;
			var target = document.querySelector(id);
			if (target) {
				e.preventDefault();
				var navOffset = (mainNav ? mainNav.offsetHeight : 84) + 4;
				var top = target.getBoundingClientRect().top + window.scrollY - navOffset;
				window.scrollTo({ top: top, behavior: 'smooth' });
			}
		});
	});

	/* Back to top */
	var toTop = document.querySelector('.pcl-to-top');
	if (toTop) {
		toTop.addEventListener('click', function () {
			window.scrollTo({ top: 0, behavior: 'smooth' });
		});
	}
})();