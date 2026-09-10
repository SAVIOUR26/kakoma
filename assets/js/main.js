// Kakoma S.S. — shared front-end behavior (no build step, no dependencies).
document.addEventListener('DOMContentLoaded', function () {

    // --- Mobile nav toggle ---
    var toggle = document.getElementById('navToggle');
    var nav = document.getElementById('siteNav');
    if (toggle && nav) {
        toggle.addEventListener('click', function () {
            var isOpen = nav.classList.toggle('is-open');
            toggle.setAttribute('aria-expanded', isOpen ? 'true' : 'false');
        });
        nav.querySelectorAll('a').forEach(function (link) {
            link.addEventListener('click', function () {
                nav.classList.remove('is-open');
                toggle.setAttribute('aria-expanded', 'false');
            });
        });
    }

    // --- Jubilee countdown ---
    var countdownEl = document.getElementById('jubileeCountdown');
    if (countdownEl) {
        var targetDate = new Date(countdownEl.dataset.target + 'T00:00:00');
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
