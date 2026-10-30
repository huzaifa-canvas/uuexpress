/* ==========================================================================
   UU Express — global UI helpers
   - Disables the submit button + shows a spinner on every form submit
     (prevents double-click / double-submit).
   - Shows a thin top progress bar on page navigation and form posts.
   Exposes window.UUUI = { setBusy, reset, navStart, navDone } for the
   AJAX handlers (booking modal, checkout, cart) to reuse.
   ========================================================================== */
(function () {
    'use strict';

    function makeSpinner() {
        var s = document.createElement('span');
        s.className = 'uu-spin';
        s.setAttribute('aria-hidden', 'true');
        return s;
    }

    // Put a button into a loading state: disable it, keep its width, swap in a spinner.
    function setBusy(btn, label) {
        if (!btn || btn.getAttribute('data-uu-busy') === '1') return;
        try {
            var w = btn.getBoundingClientRect().width;
            if (w) { btn.style.minWidth = Math.ceil(w) + 'px'; }
        } catch (e) {}
        btn.setAttribute('data-uu-busy', '1');
        btn.setAttribute('data-uu-label', btn.innerHTML);
        var text = label || btn.getAttribute('data-loading-text') || '';
        btn.innerHTML = '';
        btn.appendChild(makeSpinner());
        if (text) {
            var t = document.createElement('span');
            t.className = 'uu-spin-text';
            t.textContent = text;
            btn.appendChild(t);
        }
        btn.classList.add('is-loading');
        btn.setAttribute('aria-busy', 'true');
        btn.disabled = true;
    }

    // Restore a button that was put into a loading state.
    function reset(btn) {
        if (!btn || btn.getAttribute('data-uu-busy') !== '1') return;
        btn.disabled = false;
        btn.classList.remove('is-loading');
        btn.removeAttribute('aria-busy');
        var label = btn.getAttribute('data-uu-label');
        if (label !== null) { btn.innerHTML = label; }
        btn.style.minWidth = '';
        btn.removeAttribute('data-uu-busy');
        btn.removeAttribute('data-uu-label');
    }

    /* ---- Top progress bar ---- */
    var bar = null, timer = null, prog = 0;

    function ensureBar() {
        if (bar) return bar;
        bar = document.createElement('div');
        bar.className = 'uu-topbar';
        (document.body || document.documentElement).appendChild(bar);
        return bar;
    }

    function navStart() {
        var b = ensureBar();
        clearInterval(timer);
        prog = 10;
        b.className = 'uu-topbar uu-topbar--active';
        b.style.width = prog + '%';
        timer = setInterval(function () {
            prog += (92 - prog) * 0.14;          // ease toward 92% but never finish
            b.style.width = prog.toFixed(1) + '%';
        }, 180);
    }

    function navDone() {
        if (!bar) return;
        clearInterval(timer);
        bar.style.width = '100%';
        bar.className = 'uu-topbar uu-topbar--done';
        setTimeout(function () { if (bar) { bar.style.width = '0'; } }, 350);
    }

    window.UUUI = { setBusy: setBusy, reset: reset, navStart: navStart, navDone: navDone };

    /* ---- Remember the control that triggered a submit ---- */
    var lastSubmitter = null;
    document.addEventListener('click', function (e) {
        var t = e.target.closest ? e.target.closest('button, input[type="submit"], input[type="image"]') : null;
        if (t && (t.type === 'submit' || t.type === 'image')) { lastSubmitter = t; }
    }, true);

    /* ---- Global form submit guard ---- */
    document.addEventListener('submit', function (e) {
        var form = e.target;
        if (!form || form.nodeName !== 'FORM') return;
        if (e.defaultPrevented) return;                  // a custom/AJAX handler owns this form
        if (form.hasAttribute('data-no-loader')) return; // opt-out

        var btn = (lastSubmitter && form.contains(lastSubmitter))
            ? lastSubmitter
            : form.querySelector('button[type="submit"], button:not([type]), input[type="submit"]');

        navStart();
        if (btn) {
            // Defer so the clicked button's value is still serialized before we disable it.
            setTimeout(function () { setBusy(btn); }, 0);
        }
    }, false);

    /* ---- Internal link navigation: show the progress bar ---- */
    document.addEventListener('click', function (e) {
        if (e.defaultPrevented || e.button !== 0 || e.metaKey || e.ctrlKey || e.shiftKey || e.altKey) return;
        var a = e.target.closest ? e.target.closest('a') : null;
        if (!a) return;
        var href = a.getAttribute('href');
        if (!href || a.target === '_blank' || a.hasAttribute('download')) return;
        if (href.charAt(0) === '#' || /^(mailto:|tel:|sms:|javascript:)/i.test(href)) return;
        var url;
        try { url = new URL(a.href, location.href); } catch (err) { return; }
        if (url.origin !== location.origin) return;
        // in-page anchor on the same URL — not a navigation
        if (url.pathname === location.pathname && url.search === location.search && url.hash) return;
        navStart();
    }, false);

    /* ---- Reset on show, including bfcache back/forward restores ---- */
    window.addEventListener('pageshow', function () {
        navDone();
        var busy = document.querySelectorAll('[data-uu-busy="1"]');
        for (var i = 0; i < busy.length; i++) { reset(busy[i]); }
    });
})();
