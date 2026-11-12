/* Page reader for the digital magazine: spreads on wide screens, single pages on phones. */
(function () {
    var reader = document.getElementById('magReader');
    if (!reader) return;
    var pages = JSON.parse(reader.getAttribute('data-pages'));
    var total = pages.length;
    var stage = document.getElementById('magStage');
    var count = document.getElementById('magCount');
    var prev = document.getElementById('magPrev');
    var next = document.getElementById('magNext');
    var current = 1;

    function wide() { return window.matchMedia('(min-width: 860px)').matches; }

    // Pages shown together with page n: the cover and back cover alone, then 2-3, 4-5, ...
    function view(n) {
        if (!wide() || n === 1 || (n === total && total % 2 === 0)) return [n];
        var left = n % 2 === 0 ? n : n - 1;
        return left + 1 <= total ? [left, left + 1] : [left];
    }

    function render() {
        var shown = view(current);
        stage.innerHTML = '';
        stage.classList.toggle('is-spread', shown.length === 2);
        shown.forEach(function (n) {
            var a = document.createElement('a');
            a.href = pages[n - 1];
            a.target = '_blank';
            a.rel = 'noopener';
            a.className = 'mag-page';
            var img = document.createElement('img');
            img.src = pages[n - 1];
            img.alt = 'Page ' + n + ' of Kakoma at Sixty';
            a.appendChild(img);
            stage.appendChild(a);
        });
        count.textContent = shown.length === 2
            ? 'Pages ' + shown[0] + '–' + shown[1] + ' of ' + total
            : 'Page ' + shown[0] + ' of ' + total;
        prev.disabled = shown[0] <= 1;
        next.disabled = shown[shown.length - 1] >= total;
        // Preload the next view.
        var after = shown[shown.length - 1] + 1;
        [after, after + 1].forEach(function (n) { if (n <= total) { new Image().src = pages[n - 1]; } });
    }

    function go(n) {
        current = Math.max(1, Math.min(total, n));
        render();
        if (history.replaceState) history.replaceState(null, '', '#page-' + current);
    }

    function step(dir) {
        var shown = view(current);
        go(dir > 0 ? shown[shown.length - 1] + 1 : shown[0] - 1);
    }

    prev.addEventListener('click', function () { step(-1); });
    next.addEventListener('click', function () { step(1); });
    document.addEventListener('keydown', function (e) {
        if (e.target.closest && e.target.closest('input, textarea')) return;
        if (e.key === 'ArrowRight') step(1);
        if (e.key === 'ArrowLeft') step(-1);
    });

    var startX = null;
    stage.addEventListener('touchstart', function (e) { startX = e.touches[0].clientX; }, { passive: true });
    stage.addEventListener('touchend', function (e) {
        if (startX === null) return;
        var dx = e.changedTouches[0].clientX - startX;
        if (Math.abs(dx) > 50) step(dx < 0 ? 1 : -1);
        startX = null;
    });

    document.querySelectorAll('[data-goto]').forEach(function (link) {
        link.addEventListener('click', function (e) {
            e.preventDefault();
            go(parseInt(link.getAttribute('data-goto'), 10));
            reader.scrollIntoView({ behavior: 'smooth', block: 'start' });
        });
    });

    window.addEventListener('resize', render);
    var m = /#page-(\d+)/.exec(location.hash);
    go(m ? parseInt(m[1], 10) : 1);
})();
