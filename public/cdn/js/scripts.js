/*!
 hey, [be]Lazy.js - v1.5.2 - 2015.12.01
 A lazy loading and multi-serving image script
 (c) Bjoern Klinggaard - @bklinggaard - http://dinbror.dk/blazy
 */
(function (k, f) {
    "function" === typeof define && define.amd ? define(f) : "object" === typeof exports ? module.exports = f() : k.Blazy = f()
})(this, function () {
    function k(b) {
        var c = b._util;
        c.elements = v(b.options.selector);
        c.count = c.elements.length;
        c.destroyed && (c.destroyed = !1, b.options.container && h(b.options.container, function (a) {
            l(a, "scroll", c.validateT)
        }), l(window, "resize", c.saveViewportOffsetT), l(window, "resize", c.validateT), l(window, "scroll", c.validateT));
        f(b)
    }

    function f(b) {
        for (var c = b._util, a = 0; a < c.count; a++) {
            var d = c.elements[a], g = d.getBoundingClientRect();
            if (g.right >= e.left && g.bottom >= e.top && g.left <= e.right && g.top <= e.bottom || n(d, b.options.successClass)) b.load(d), c.elements.splice(a, 1), c.count--, a--
        }
        0 === c.count && b.destroy()
    }

    function q(b, c, a) {
        if (!n(b, a.successClass) && (c || a.loadInvisible || 0 < b.offsetWidth && 0 < b.offsetHeight)) if (c = b.getAttribute(p) || b.getAttribute(a.src)) {
            c = c.split(a.separator);
            var d = c[r && 1 < c.length ? 1 : 0], g = "img" === b.nodeName.toLowerCase();
            h(a.breakpoints, function (a) {
                b.removeAttribute(a.src)
            });
            b.removeAttribute(a.src);
            g || void 0 === b.src ? (c = new Image, c.onerror = function () {
                a.error && a.error(b, "invalid");
                b.className = b.className + " " + a.errorClass
            }, c.onload = function () {
                g ? b.src = d : b.style.backgroundImage = 'url("' + d + '")';
                b.className = b.className + " " + a.successClass;
                a.success && a.success(b)
            }, c.src = d) : (b.src = d, b.className = b.className + " " + a.successClass)
        } else a.error && a.error(b, "missing"), n(b, a.errorClass) || (b.className = b.className + " " + a.errorClass)
    }

    function n(b, c) {
        return -1 !== (" " + b.className + " ").indexOf(" " + c + " ")
    }

    function v(b) {
        var c = [];
        b = document.querySelectorAll(b);
        for (var a = b.length; a--; c.unshift(b[a])) ;
        return c
    }

    function t(b) {
        e.bottom = (window.innerHeight || document.documentElement.clientHeight) + b;
        e.right = (window.innerWidth || document.documentElement.clientWidth) + b
    }

    function l(b, c, a) {
        b.attachEvent ? b.attachEvent && b.attachEvent("on" + c, a) : b.addEventListener(c, a, !1)
    }

    function m(b, c, a) {
        b.detachEvent ? b.detachEvent && b.detachEvent("on" + c, a) : b.removeEventListener(c, a, !1)
    }

    function h(b, c) {
        if (b && c) for (var a = b.length, d = 0; d < a && !1 !== c(b[d], d); d++) ;
    }

    function u(b, c, a) {
        var d = 0;
        return function () {
            var g = +new Date;
            g - d < c || (d = g, b.apply(a, arguments))
        }
    }

    var p, e, r;
    return function (b) {
        if (!document.querySelectorAll) {
            var c = document.createStyleSheet();
            document.querySelectorAll = function (a, b, d, e, f) {
                f = document.all;
                b = [];
                a = a.replace(/\[for\b/gi, "[htmlFor").split(",");
                for (d = a.length; d--;) {
                    c.addRule(a[d], "k:v");
                    for (e = f.length; e--;) f[e].currentStyle.k && b.push(f[e]);
                    c.removeRule(0)
                }
                return b
            }
        }
        var a = this, d = a._util = {};
        d.elements = [];
        d.destroyed = !0;
        a.options = b || {};
        a.options.error = a.options.error || !1;
        a.options.offset = a.options.offset || 100;
        a.options.success = a.options.success || !1;
        a.options.selector = a.options.selector || ".b-lazy";
        a.options.separator = a.options.separator || "|";
        a.options.container = a.options.container ? document.querySelectorAll(a.options.container) : !1;
        a.options.errorClass = a.options.errorClass || "b-error";
        a.options.breakpoints = a.options.breakpoints || !1;
        a.options.loadInvisible = a.options.loadInvisible || !1;
        a.options.successClass = a.options.successClass || "b-loaded";
        a.options.validateDelay = a.options.validateDelay || 25;
        a.options.saveViewportOffsetDelay = a.options.saveViewportOffsetDelay || 50;
        a.options.src = p = a.options.src || "data-src";
        r = 1 < window.devicePixelRatio;
        e = {};
        e.top = 0 - a.options.offset;
        e.left = 0 - a.options.offset;
        a.revalidate = function () {
            k(this)
        };
        a.load = function (a, b) {
            var c = this.options;
            void 0 === a.length ? q(a, b, c) : h(a, function (a) {
                q(a, b, c)
            })
        };
        a.destroy = function () {
            var a = this._util;
            this.options.container && h(this.options.container, function (b) {
                m(b, "scroll", a.validateT)
            });
            m(window, "scroll", a.validateT);
            m(window, "resize", a.validateT);
            m(window, "resize", a.saveViewportOffsetT);
            a.count = 0;
            a.elements.length = 0;
            a.destroyed = !0
        };
        d.validateT = u(function () {
            f(a)
        }, a.options.validateDelay, a);
        d.saveViewportOffsetT = u(function () {
            t(a.options.offset)
        }, a.options.saveViewportOffsetDelay, a);
        t(a.options.offset);
        h(a.options.breakpoints, function (a) {
            if (a.width >= window.screen.width) return p = a.src, !1
        });
        k(a)
    }
});


document.addEventListener('DOMContentLoaded', function () {

    /** lazy load of images */
    var bLazy = new Blazy({
        src: 'data-src',
        selector: '*[data-src]',
        offset: 100
    });

    /** modal control */
    var iframe_wrapper = document.getElementById('iframe--modal');

    /* close modal */
    iframe_wrapper.getElementsByTagName('a')[0].addEventListener('click', function () {
        this.classList.remove('iframe--modal-active');

        /* reset iframe */
        iframe_wrapper.getElementsByTagName('iframe')[0].remove();

    }.bind(iframe_wrapper));

    /* open modal */
    var chicas_link_list = document.querySelectorAll('.listado-chicas .chica a');
    var count_chicas_link_list = chicas_link_list.length;

    for (var i = 0; i < count_chicas_link_list; i++) {
        chicas_link_list[i].addEventListener('click', function (event) {
            event.preventDefault();

            var iframe = document.createElement('iframe');
            iframe.setAttribute('src', this.getAttribute('href'));
            iframe_wrapper.appendChild( iframe );

            iframe_wrapper.classList.add('iframe--modal-active');

            return false;
        });
    }

    var techPump_analytics = 'pending';

    /**
     * Load Google Analytics: https://trasweb.net/snippets/google-analytics-y-analizadores-wpo
     */
    window.addEventListener("scroll", function () {
        if('pending' !== techPump_analytics) {
            return ;
        }

        if (document.documentElement.scrollTop !== 0 || document.body.scrollTop !== 0) {
            (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
                (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
                m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
            })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

            ga('create',  document.body.getAttribute('data-analytics'), 'auto');
            ga('send', 'pageview');

            techPump_analytics = 'loaded';
        }
    }, true);
});


