// Kakoma S.S. — shared front-end behavior (no build step, no dependencies).
document.addEventListener('DOMContentLoaded', function () {

    // --- Mobile nav toggle ---
    var toggle = document.getElementById('navToggle');
    var nav = document.getElementById('siteNav');
    if (toggle && nav) {
        toggle.addEventListener('click', function () {
            var isOpen = nav.classList.toggle('is-open');
            toggle.setAttribute('aria-expanded', isOpen ? 'true' : 'false');
            toggle.setAttribute('aria-label', isOpen ? 'Close menu' : 'Open menu');
        });
        nav.querySelectorAll('a').forEach(function (link) {
            link.addEventListener('click', function () {
                nav.classList.remove('is-open');
                toggle.setAttribute('aria-expanded', 'false');
            });
        });
    }

    // --- "More" menu (desktop) ---
    var more = document.getElementById('navMore');
    if (more) {
        var moreBtn = more.querySelector('.nav-more__toggle');
        moreBtn.addEventListener('click', function (e) {
            e.stopPropagation();
            var open = more.classList.toggle('is-open');
            moreBtn.setAttribute('aria-expanded', open ? 'true' : 'false');
        });
        document.addEventListener('click', function (e) {
            if (!more.contains(e.target)) { more.classList.remove('is-open'); moreBtn.setAttribute('aria-expanded', 'false'); }
        });
        document.addEventListener('keydown', function (e) {
            if (e.key === 'Escape') { more.classList.remove('is-open'); moreBtn.setAttribute('aria-expanded', 'false'); }
        });
    }

    var reduceMotion = window.matchMedia && window.matchMedia('(prefers-reduced-motion: reduce)').matches;

    // --- Hero slideshow (photos load one ahead, small files on phones) ---
    var heroSlides = document.querySelectorAll('.hero-slide');
    if (heroSlides.length > 1) {
        var small = window.innerWidth < 900;
        var caption = document.getElementById('heroCaption');
        var dots = document.querySelectorAll('#heroDots button');
        var activeSlide = 0;
        var timer = null;
        var load = function (i) {
            var el = heroSlides[i];
            if (el && !el.dataset.loaded) {
                el.style.backgroundImage = "url('" + (small ? el.dataset.srcSmall : el.dataset.src) + "')";
                el.dataset.loaded = '1';
            }
        };
        heroSlides[0].dataset.loaded = '1';
        load(1);
        var show = function (i) {
            heroSlides[activeSlide].classList.remove('is-active');
            if (dots[activeSlide]) dots[activeSlide].classList.remove('is-active');
            activeSlide = (i + heroSlides.length) % heroSlides.length;
            load(activeSlide);
            heroSlides[activeSlide].classList.add('is-active');
            if (dots[activeSlide]) dots[activeSlide].classList.add('is-active');
            if (caption) {
                caption.style.opacity = 0;
                setTimeout(function () { caption.textContent = heroSlides[activeSlide].dataset.caption; caption.style.opacity = 1; }, 400);
            }
            load(activeSlide + 1);
        };
        var start = function () { clearInterval(timer); timer = setInterval(function () { show(activeSlide + 1); }, 6500); };
        dots.forEach(function (dot, i) { dot.addEventListener('click', function () { show(i); start(); }); });
        start();
    }

    // --- Jubilee confetti in the hero ---
    var confetti = document.getElementById('heroConfetti');
    if (confetti && !reduceMotion) {
        var colours = ['#F0C93B', '#D4A017', '#F6DE8D', '#FFFFFF', '#4095D9', '#FFF3C4'];
        var shapes = ['', 'is-round', 'is-diamond'];
        var count = window.innerWidth < 600 ? 16 : 30;
        for (var c = 0; c < count; c++) {
            var piece = document.createElement('span');
            piece.className = 'confetti-piece ' + shapes[c % shapes.length];
            piece.style.left = (Math.random() * 100) + '%';
            piece.style.background = colours[c % colours.length];
            piece.style.animationDuration = (9 + Math.random() * 9) + 's';
            piece.style.animationDelay = (-Math.random() * 18) + 's';
            piece.style.opacity = (0.55 + Math.random() * 0.4).toFixed(2);
            confetti.appendChild(piece);
        }
    }

    // --- Jubilee countdown ---
    var countdownEl = document.getElementById('jubileeCountdown');
    if (countdownEl) {
        var target = countdownEl.dataset.target;
        var targetDate = new Date(target.indexOf('T') > -1 ? target : target + 'T00:00:00');
        var daysEl = countdownEl.querySelector('[data-unit="days"]');
        var hoursEl = countdownEl.querySelector('[data-unit="hours"]');
        var minsEl = countdownEl.querySelector('[data-unit="minutes"]');
        var secsEl = countdownEl.querySelector('[data-unit="seconds"]');

        function tick() {
            var now = new Date();
            var diff = targetDate - now;
            if (diff <= 0) {
                if (daysEl) daysEl.textContent = '0';
                if (hoursEl) hoursEl.textContent = '0';
                if (minsEl) minsEl.textContent = '0';
                if (secsEl) secsEl.textContent = '0';
                return;
            }
            var days = Math.floor(diff / (1000 * 60 * 60 * 24));
            var hours = Math.floor((diff / (1000 * 60 * 60)) % 24);
            var minutes = Math.floor((diff / (1000 * 60)) % 60);
            var seconds = Math.floor((diff / 1000) % 60);
            if (daysEl) daysEl.textContent = days;
            if (hoursEl) hoursEl.textContent = hours;
            if (minsEl) minsEl.textContent = minutes;
            if (secsEl) secsEl.textContent = seconds;
        }
        tick();
        setInterval(tick, 1000);
    }

    // --- Gallery filters ---
    var filterButtons = document.querySelectorAll('.gallery-filters button');
    var galleryItems = document.querySelectorAll('.gallery-item');
    filterButtons.forEach(function (btn) {
        btn.addEventListener('click', function () {
            filterButtons.forEach(function (b) { b.classList.remove('is-active'); });
            btn.classList.add('is-active');
            var filter = btn.dataset.filter;
            galleryItems.forEach(function (item) {
                var show = filter === 'all' || item.dataset.album === filter;
                item.style.display = show ? '' : 'none';
            });
        });
    });

    // --- Lightbox ---
    var lightbox = document.getElementById('lightbox');
    if (lightbox) {
        var lightboxImg = lightbox.querySelector('img');
        var lightboxCaption = lightbox.querySelector('figcaption');
        var visibleItems = [];
        var currentIndex = 0;

        function openLightbox(index) {
            visibleItems = Array.prototype.filter.call(galleryItems, function (item) {
                return item.style.display !== 'none';
            });
            currentIndex = visibleItems.indexOf(index);
            showCurrent();
            lightbox.classList.add('is-open');
        }

        function showCurrent() {
            var item = visibleItems[currentIndex];
            if (!item) return;
            lightboxImg.src = item.dataset.full || item.querySelector('img').src;
            lightboxCaption.textContent = item.dataset.caption || '';
        }

        galleryItems.forEach(function (item) {
            item.addEventListener('click', function () { openLightbox(item); });
        });

        var closeBtn = lightbox.querySelector('.lightbox-close');
        if (closeBtn) closeBtn.addEventListener('click', function () { lightbox.classList.remove('is-open'); });
        lightbox.addEventListener('click', function (e) {
            if (e.target === lightbox) lightbox.classList.remove('is-open');
        });

        var prevBtn = lightbox.querySelector('.lightbox-prev');
        var nextBtn = lightbox.querySelector('.lightbox-next');
        if (prevBtn) prevBtn.addEventListener('click', function () {
            currentIndex = (currentIndex - 1 + visibleItems.length) % visibleItems.length;
            showCurrent();
        });
        if (nextBtn) nextBtn.addEventListener('click', function () {
            currentIndex = (currentIndex + 1) % visibleItems.length;
            showCurrent();
        });

        document.addEventListener('keydown', function (e) {
            if (!lightbox.classList.contains('is-open')) return;
            if (e.key === 'Escape') lightbox.classList.remove('is-open');
            if (e.key === 'ArrowLeft' && prevBtn) prevBtn.click();
            if (e.key === 'ArrowRight' && nextBtn) nextBtn.click();
        });
    }
});
