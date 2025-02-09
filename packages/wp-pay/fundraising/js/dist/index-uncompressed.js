!(function () {
    var e = {
            184: function (e, t) {
                var r;
                !(function () {
                    "use strict";
                    var n = {}.hasOwnProperty;
                    function a() {
                        for (var e = [], t = 0; t < arguments.length; t++) {
                            var r = arguments[t];
                            if (r) {
                                var o = typeof r;
                                if ("string" === o || "number" === o) e.push(r);
                                else if (Array.isArray(r)) {
                                    if (r.length) {
                                        var i = a.apply(null, r);
                                        i && e.push(i);
                                    }
                                } else if ("object" === o)
                                    if (r.toString === Object.prototype.toString) for (var c in r) n.call(r, c) && r[c] && e.push(c);
                                    else e.push(r.toString());
                            }
                        }
                        return e.join(" ");
                    }
                    e.exports
                        ? ((a.default = a), (e.exports = a))
                        : void 0 ===
                              (r = function () {
                                  return a;
                              }.apply(t, [])) || (e.exports = r);
                })();
            },
        },
        t = {};
    function r(n) {
        var a = t[n];
        if (void 0 !== a) return a.exports;
        var o = (t[n] = { exports: {} });
        return e[n](o, o.exports, r), o.exports;
    }
    (r.n = function (e) {
        var t =
            e && e.__esModule
                ? function () {
                      return e.default;
                  }
                : function () {
                      return e;
                  };
        return r.d(t, { a: t }), t;
    }),
        (r.d = function (e, t) {
            for (var n in t) r.o(t, n) && !r.o(e, n) && Object.defineProperty(e, n, { enumerable: !0, get: t[n] });
        }),
        (r.o = function (e, t) {
            return Object.prototype.hasOwnProperty.call(e, t);
        }),
        (r.r = function (e) {
            "undefined" != typeof Symbol && Symbol.toStringTag && Object.defineProperty(e, Symbol.toStringTag, { value: "Module" }), Object.defineProperty(e, "__esModule", { value: !0 });
        }),
        (function () {
            "use strict";
            var e = {};
            r.r(e),
                r.d(e, {
                    metadata: function () {
                        return k;
                    },
                    name: function () {
                        return M;
                    },
                    settings: function () {
                        return F;
                    },
                });
            var t = {};
            r.r(t),
                r.d(t, {
                    metadata: function () {
                        return I;
                    },
                    name: function () {
                        return $;
                    },
                    settings: function () {
                        return H;
                    },
                });
            var n = {};
            r.r(n),
                r.d(n, {
                    metadata: function () {
                        return K;
                    },
                    name: function () {
                        return ee;
                    },
                    settings: function () {
                        return te;
                    },
                });
            var a = window.wp.blocks,
                o = window.wp.components,
                i = window.wp.i18n,
                c = React.createElement(
                    o.SVG,
                    { xmlns: "http://www.w3.org/2000/svg", viewBox: "0 0 24 24" },
                    React.createElement(o.Path, {
                        d:
                            "M10.9989003,2.04948449 L10.9991931,6.08309386 C8.16187679,6.55950437 6,9.02728549 6,12 C6,15.3137085 8.6862915,18 12,18 C14.9727145,18 17.4404956,15.8381232 17.9169061,13.0008069 L21.9505155,13.0010997 C21.4482817,18.0538953 17.1849719,22 12,22 C6.4771525,22 2,17.5228475 2,12 C2,6.81502805 5.94610473,2.55171825 10.9989003,2.04948449 Z M21.9506147,10.9998991 L17.9170737,11.0001915 C17.495595,8.48742361 15.5122967,6.50421563 12.9994831,6.08287175 L12.9999709,2.04937235 C17.7243674,2.51842511 21.4815017,6.27552034 21.9506147,10.9998991 Z",
                    })
                ),
                l = window.wp.blockEditor,
                s = [
                    { name: "orange", color: "#f9461c" },
                    { name: "purple", color: "#6355ff" },
                    { name: "green", color: "#2ce3be" },
                ];
            function u(e, t) {
                return (e = parseFloat(e || 0)), 0 == (t = parseFloat(t || 0)) && (0 == e || e > t) && (t = 100), Math.floor((e / t) * 100);
            }
            function p(e, t, r, n) {
                var a = e.lastIndexOf(".");
                if (a > -1) {
                    var o = e
                        .substring(a + 1)
                        .replace(/[0]+$/g, "")
                        .padEnd(r, "0");
                    e = e.substring(0, a).replace(/\./g, "") + "." + o;
                }
                var i = r;
                return 0 == (100 * (e = parseFloat(e))) % 100 && (i = 0), e.toLocaleString(n, { style: "currency", currency: t, minimumFractionDigits: i, maximumFractionDigits: i });
            }
            var f = window.wp.element;
            function d(e) {
                return (
                    (d =
                        "function" == typeof Symbol && "symbol" == typeof Symbol.iterator
                            ? function (e) {
                                  return typeof e;
                              }
                            : function (e) {
                                  return e && "function" == typeof Symbol && e.constructor === Symbol && e !== Symbol.prototype ? "symbol" : typeof e;
                              }),
                    d(e)
                );
            }
            function m(e, t) {
                if (!(e instanceof t)) throw new TypeError("Cannot call a class as a function");
            }
            function y(e, t) {
                for (var r = 0; r < t.length; r++) {
                    var n = t[r];
                    (n.enumerable = n.enumerable || !1), (n.configurable = !0), "value" in n && (n.writable = !0), Object.defineProperty(e, n.key, n);
                }
            }
            function g(e, t) {
                return (
                    (g = Object.setPrototypeOf
                        ? Object.setPrototypeOf.bind()
                        : function (e, t) {
                              return (e.__proto__ = t), e;
                          }),
                    g(e, t)
                );
            }
            function b(e, t) {
                if (t && ("object" === d(t) || "function" == typeof t)) return t;
                if (void 0 !== t) throw new TypeError("Derived constructors may only return object or undefined");
                return (function (e) {
                    if (void 0 === e) throw new ReferenceError("this hasn't been initialised - super() hasn't been called");
                    return e;
                })(e);
            }
            function v(e) {
                return (
                    (v = Object.setPrototypeOf
                        ? Object.getPrototypeOf.bind()
                        : function (e) {
                              return e.__proto__ || Object.getPrototypeOf(e);
                          }),
                    v(e)
                );
            }
            var _ = (function (e) {
                    !(function (e, t) {
                        if ("function" != typeof t && null !== t) throw new TypeError("Super expression must either be null or a function");
                        (e.prototype = Object.create(t && t.prototype, { constructor: { value: e, writable: !0, configurable: !0 } })), Object.defineProperty(e, "prototype", { writable: !1 }), t && g(e, t);
                    })(i, e);
                    var t,
                        r,
                        n,
                        a,
                        o =
                            ((n = i),
                            (a = (function () {
                                if ("undefined" == typeof Reflect || !Reflect.construct) return !1;
                                if (Reflect.construct.sham) return !1;
                                if ("function" == typeof Proxy) return !0;
                                try {
                                    return Boolean.prototype.valueOf.call(Reflect.construct(Boolean, [], function () {})), !0;
                                } catch (e) {
                                    return !1;
                                }
                            })()),
                            function () {
                                var e,
                                    t = v(n);
                                if (a) {
                                    var r = v(this).constructor;
                                    e = Reflect.construct(t, arguments, r);
                                } else e = t.apply(this, arguments);
                                return b(this, e);
                            });
                    function i() {
                        return m(this, i), o.apply(this, arguments);
                    }
                    return (
                        (t = i),
                        (r = [
                            {
                                key: "render",
                                value: function () {
                                    var e = this.props,
                                        t = e.colors,
                                        r = e.currencyCode,
                                        n = e.currencyDecimals,
                                        a = e.locale,
                                        o = e.raisedLabel,
                                        i = e.raisedAmount,
                                        c = e.targetLabel,
                                        s = e.targetAmount,
                                        u = e.contributionsLabel,
                                        f = e.contributionsValue,
                                        d = e.setAttributes;
                                    return (
                                        (t = t || {}),
                                        (r = r || "EUR"),
                                        (n = n || "2"),
                                        (a = a || "nl-NL"),
                                        React.createElement(
                                            "dl",
                                            { className: "ppfr-dl-list" },
                                            React.createElement(l.RichText, {
                                                tagName: "dt",
                                                className: "ppfr-dl-list__label",
                                                multiline: "false",
                                                value: o,
                                                onChange: function (e) {
                                                    d({ raisedLabel: e });
                                                },
                                                style: (t.hasOwnProperty("raisedLabel") && { color: t.raisedLabel }) || {},
                                            }),
                                            React.createElement(l.RichText, {
                                                tagName: "dd",
                                                className: "ppfr-dl-list__value",
                                                multiline: "false",
                                                value: p(i || "0", r, n, a),
                                                onChange: function (e) {
                                                    var t = (e = e.replace(/,/g, ".").replace(/[^\d.-]/g, "")).lastIndexOf(".");
                                                    if (t > -1) {
                                                        var r = e
                                                            .substring(t + 1)
                                                            .replace(/[0]+$/g, "")
                                                            .padEnd(n, "0");
                                                        e = e.substring(0, t).replace(/\./g, "") + "." + r;
                                                    }
                                                    d({ raisedAmount: e });
                                                },
                                                style: (t.hasOwnProperty("raisedAmount") && { color: t.raisedAmount }) || {},
                                            }),
                                            s &&
                                                React.createElement(
                                                    React.Fragment,
                                                    null,
                                                    React.createElement(l.RichText, {
                                                        tagName: "dt",
                                                        className: "ppfr-dl-list__label",
                                                        multiline: "false",
                                                        value: c,
                                                        onChange: function (e) {
                                                            d({ targetLabel: e });
                                                        },
                                                    }),
                                                    React.createElement(l.RichText, {
                                                        tagName: "dd",
                                                        className: "ppfr-dl-list__value",
                                                        multiline: "false",
                                                        value: p(s || "0", r, n, a),
                                                        onChange: function (e) {
                                                            d({ targetAmount: e.replace(/,/g, ".").replace(/[^\d.-]/g, "") });
                                                        },
                                                    })
                                                ),
                                            f &&
                                                React.createElement(
                                                    React.Fragment,
                                                    null,
                                                    React.createElement(l.RichText, {
                                                        tagName: "dt",
                                                        className: "ppfr-dl-list__label",
                                                        multiline: "false",
                                                        value: u,
                                                        onChange: function (e) {
                                                            d({ contributionsLabel: e });
                                                        },
                                                    }),
                                                    React.createElement(l.RichText, {
                                                        tagName: "dd",
                                                        className: "ppfr-dl-list__value",
                                                        multiline: "false",
                                                        value: parseInt(f || 0).toString(),
                                                        onChange: function (e) {
                                                            d({ contributionsValue: e ? e.replace(/[^\d]/g, "") : "0" });
                                                        },
                                                        style: (t.hasOwnProperty("contributionsValue") && { color: t.contributionsValue }) || {},
                                                    })
                                                )
                                        )
                                    );
                                },
                            },
                        ]) && y(t.prototype, r),
                        Object.defineProperty(t, "prototype", { writable: !1 }),
                        i
                    );
                })(f.Component),
                h = r(184),
                w = r.n(h);
            function C(e, t) {
                for (var r = 0; r < t.length; r++) {
                    var n = t[r];
                    (n.enumerable = n.enumerable || !1), (n.configurable = !0), "value" in n && (n.writable = !0), Object.defineProperty(e, n.key, n);
                }
            }
            var R = (function () {
                function e(t, r) {
                    !(function (e, t) {
                        if (!(e instanceof t)) throw new TypeError("Cannot call a class as a function");
                    })(this, e),
                        (this.value = t),
                        (this.color = r);
                }
                var t, r;
                return (
                    (t = e),
                    (r = [
                        {
                            key: "render",
                            value: function () {
                                var e = this.value,
                                    t = this.color,
                                    r = (e / 100) * 360,
                                    n = { borderColor: t, transform: "rotate( " + Math.min(r, 360).toFixed(2) + "deg )" },
                                    a = {};
                                e > 50 && (a = { borderColor: t });
                                var o = w()({ "ppfr-circle": !0, "ppfr-circle--50": e > 50 });
                                return React.createElement(
                                    "div",
                                    { className: o },
                                    React.createElement("span", { className: "ppfr-circle__label" }, e, "%"),
                                    React.createElement(
                                        "div",
                                        { className: "ppfr-circle__slice" },
                                        React.createElement("div", { className: "ppfr-circle__slice__bar", style: n }),
                                        React.createElement("div", { className: "ppfr-circle__slice__fill", style: a })
                                    )
                                );
                            },
                        },
                    ]) && C(t.prototype, r),
                    Object.defineProperty(t, "prototype", { writable: !1 }),
                    e
                );
            })();
            function E(e, t) {
                for (var r = 0; r < t.length; r++) {
                    var n = t[r];
                    (n.enumerable = n.enumerable || !1), (n.configurable = !0), "value" in n && (n.writable = !0), Object.defineProperty(e, n.key, n);
                }
            }
            var L = (function () {
                function e(t, r) {
                    !(function (e, t) {
                        if (!(e instanceof t)) throw new TypeError("Cannot call a class as a function");
                    })(this, e),
                        (this.value = t),
                        (this.color = r);
                }
                var t, r;
                return (
                    (t = e),
                    (r = [
                        {
                            key: "render",
                            value: function () {
                                var e = this.value,
                                    t = { background: this.color, width: Math.min(e, 100) + "%" };
                                return React.createElement(
                                    "div",
                                    { className: "ppfr-progress" },
                                    React.createElement("div", { className: "ppfr-progress__bar", style: t }, React.createElement("span", { className: "ppfr-progress__bar__status" }, e, "%"))
                                );
                            },
                        },
                    ]) && E(t.prototype, r),
                    Object.defineProperty(t, "prototype", { writable: !1 }),
                    e
                );
            })();
            function x(e) {
                return (
                    (x =
                        "function" == typeof Symbol && "symbol" == typeof Symbol.iterator
                            ? function (e) {
                                  return typeof e;
                              }
                            : function (e) {
                                  return e && "function" == typeof Symbol && e.constructor === Symbol && e !== Symbol.prototype ? "symbol" : typeof e;
                              }),
                    x(e)
                );
            }
            function O(e, t) {
                if (!(e instanceof t)) throw new TypeError("Cannot call a class as a function");
            }
            function P(e, t) {
                for (var r = 0; r < t.length; r++) {
                    var n = t[r];
                    (n.enumerable = n.enumerable || !1), (n.configurable = !0), "value" in n && (n.writable = !0), Object.defineProperty(e, n.key, n);
                }
            }
            function A(e, t) {
                return (
                    (A = Object.setPrototypeOf
                        ? Object.setPrototypeOf.bind()
                        : function (e, t) {
                              return (e.__proto__ = t), e;
                          }),
                    A(e, t)
                );
            }
            function j(e, t) {
                if (t && ("object" === x(t) || "function" == typeof t)) return t;
                if (void 0 !== t) throw new TypeError("Derived constructors may only return object or undefined");
                return (function (e) {
                    if (void 0 === e) throw new ReferenceError("this hasn't been initialised - super() hasn't been called");
                    return e;
                })(e);
            }
            function N(e) {
                return (
                    (N = Object.setPrototypeOf
                        ? Object.getPrototypeOf.bind()
                        : function (e) {
                              return e.__proto__ || Object.getPrototypeOf(e);
                          }),
                    N(e)
                );
            }
            var S = (function (e) {
                    !(function (e, t) {
                        if ("function" != typeof t && null !== t) throw new TypeError("Super expression must either be null or a function");
                        (e.prototype = Object.create(t && t.prototype, { constructor: { value: e, writable: !0, configurable: !0 } })), Object.defineProperty(e, "prototype", { writable: !1 }), t && A(e, t);
                    })(i, e);
                    var t,
                        r,
                        n,
                        a,
                        o =
                            ((n = i),
                            (a = (function () {
                                if ("undefined" == typeof Reflect || !Reflect.construct) return !1;
                                if (Reflect.construct.sham) return !1;
                                if ("function" == typeof Proxy) return !0;
                                try {
                                    return Boolean.prototype.valueOf.call(Reflect.construct(Boolean, [], function () {})), !0;
                                } catch (e) {
                                    return !1;
                                }
                            })()),
                            function () {
                                var e,
                                    t = N(n);
                                if (a) {
                                    var r = N(this).constructor;
                                    e = Reflect.construct(t, arguments, r);
                                } else e = t.apply(this, arguments);
                                return j(this, e);
                            });
                    function i() {
                        return O(this, i), o.apply(this, arguments);
                    }
                    return (
                        (t = i),
                        (r = [
                            {
                                key: "render",
                                value: function () {
                                    var e = this.props,
                                        t = e.color,
                                        r = e.style,
                                        n = e.value;
                                    return ("circle" === r ? new R(n, t) : new L(n, t)).render();
                                },
                            },
                        ]) && P(t.prototype, r),
                        Object.defineProperty(t, "prototype", { writable: !1 }),
                        i
                    );
                })(f.Component),
                k = JSON.parse(
                    '{"name":"pronamic-pay/fundraising-progress-circle","title":"Fundraising Progress Circle","category":"pronamic-pay","attributes":{"raisedLabel":{"type":"string"},"raisedAmount":{"type":"string","default":"0"},"targetLabel":{"type":"string"},"targetAmount":{"type":"string","default":"0"},"contributionsLabel":{"type":"string"},"contributionsValue":{"type":"string","default":"0"},"currencyCode":{"type":"string","default":"EUR"},"currencyDecimals":{"type":"string","default":"2"},"locale":{"type":"string"},"color":{"type":"string","default":"#f9461c"}},"supports":{"__experimentalBorder":{"color":true,"radius":true,"style":true,"width":true,"__experimentalDefaultControls":{"color":true,"radius":true,"style":true,"width":true}}},"editorScript":"file:../../index.js","style":"pronamic-pay-fundraising","textdomain":"pronamic-pay-fundraising"}'
                ),
                T = {
                    from: [
                        {
                            type: "block",
                            blocks: ["pronamic-pay/fundraising-progress-bar", "pronamic-pay/fundraising-progress-text"],
                            transform: function (e) {
                                return (0, a.createBlock)("pronamic-pay/fundraising-progress-circle", e);
                            },
                        },
                    ],
                },
                B = T,
                D = k.attributes,
                V = k.category,
                M = k.name,
                F = {
                    title: (0, i.__)("Fundraising Progress Circle", "pronamic-pay-fundraising"),
                    description: (0, i.__)("Displays fundraising information with circular progress chart.", "pronamic-pay-fundraising"),
                    category: V,
                    icon: c,
                    example: {},
                    attributes: D,
                    edit: function (e) {
                        var t = e.attributes,
                            r = e.setAttributes,
                            n = (e.className, t.targetLabel),
                            a = t.targetAmount,
                            c = t.raisedLabel,
                            p = t.raisedAmount,
                            f = t.contributionsLabel,
                            d = t.contributionsValue,
                            m = t.color,
                            y = t.currencyCode,
                            g = t.currencyDecimals,
                            b = t.locale;
                        c || r({ raisedLabel: (0, i.__)("Raised", "pronamic-pay-fundraising") }),
                            n || r({ targetLabel: (0, i.__)("Target", "pronamic-pay-fundraising") }),
                            f || r({ contributionsLabel: (0, i.__)("Contributions", "pronamic-pay-fundraising") }),
                            (p = p || ""),
                            (a = a || ""),
                            (d = d || "");
                        var v = React.createElement(
                            l.InspectorControls,
                            null,
                            React.createElement(
                                o.PanelBody,
                                null,
                                React.createElement(o.TextControl, {
                                    label: (0, i.__)("Target", "pronamic-pay-fundraising"),
                                    value: a,
                                    onChange: function (e) {
                                        r({ targetAmount: e.replace(/,/g, ".") });
                                    },
                                }),
                                React.createElement(o.TextControl, {
                                    label: (0, i.__)("Raised", "pronamic-pay-fundraising"),
                                    value: p,
                                    onChange: function (e) {
                                        r({ raisedAmount: e.replace(/,/g, ".") });
                                    },
                                }),
                                React.createElement(o.TextControl, {
                                    label: (0, i.__)("Contributions", "pronamic-pay-fundraising"),
                                    value: d,
                                    onChange: function (e) {
                                        r({ contributionsValue: e.replace(/[^\d]/g, "") });
                                    },
                                }),
                                React.createElement(l.ColorPalette, {
                                    colors: s,
                                    value: m,
                                    onChange: function (e) {
                                        r({ color: e });
                                    },
                                })
                            )
                        );
                        return React.createElement(
                            "div",
                            { className: "ppfr-block ppfr-block-circle" },
                            v,
                            React.createElement(
                                "div",
                                { className: "ppfr-block-circle__container" },
                                React.createElement("div", { className: "ppfr-block__container__col" }, React.createElement(S, { style: "circle", color: m, value: u(p, a) })),
                                React.createElement(
                                    "div",
                                    { className: "ppfr-block__container__col" },
                                    React.createElement(_, {
                                        setAttributes: r,
                                        raisedLabel: c,
                                        raisedAmount: p,
                                        targetLabel: n,
                                        targetAmount: a,
                                        contributionsLabel: f,
                                        contributionsValue: d || "0",
                                        locale: b,
                                        currencyCode: y,
                                        currencyDecimals: g,
                                    })
                                )
                            )
                        );
                    },
                    save: function (e) {
                        return e.attributes, null;
                    },
                    transforms: B,
                },
                Z = React.createElement(
                    o.SVG,
                    { xmlns: "http://www.w3.org/2000/svg", viewBox: "0 0 24 24" },
                    React.createElement(o.Path, {
                        d:
                            "M19 7 C21.761 7 24 9.239 24 12 24 14.761 21.761 17 19 17 L5 17 C2.239 17 0 14.761 0 12 0 9.239 2.239 7 5 7 Z M19 9 L5 9 C3.343 9 2 10.343 2 12 2 13.598 3.249 14.904 4.824 14.995 L5 15 19 15 C20.657 15 22 13.657 22 12 22 10.402 20.751 9.096 19.176 9.005 Z M13 10 C14.105 10 15 10.895 15 12 15 13.105 14.105 14 13 14 L5 14 C3.895 14 3 13.105 3 12 3 10.895 3.895 10 5 10 Z",
                    })
                ),
                I = JSON.parse(
                    '{"name":"pronamic-pay/fundraising-progress-bar","title":"Fundraising Progress Bar","category":"pronamic-pay","attributes":{"raisedLabel":{"type":"string"},"raisedAmount":{"type":"string","default":"0"},"targetLabel":{"type":"string"},"targetAmount":{"type":"string","default":"0"},"contributionsLabel":{"type":"string"},"contributionsValue":{"type":"string","default":"0"},"currencyCode":{"type":"string","default":"EUR"},"currencyDecimals":{"type":"string","default":"2"},"locale":{"type":"string"},"color":{"type":"string","default":"#f9461c"}},"supports":{"__experimentalBorder":{"color":true,"radius":true,"style":true,"width":true,"__experimentalDefaultControls":{"color":true,"radius":true,"style":true,"width":true}}},"editorScript":"file:../../index.js","style":"pronamic-pay-fundraising","textdomain":"pronamic-pay-fundraising"}'
                ),
                G = {
                    from: [
                        {
                            type: "block",
                            blocks: ["pronamic-pay/fundraising-progress-circle", "pronamic-pay/fundraising-progress-text"],
                            transform: function (e) {
                                return (0, a.createBlock)("pronamic-pay/fundraising-progress-bar", e);
                            },
                        },
                    ],
                },
                U = G,
                J = I.attributes,
                z = I.category,
                $ = I.name,
                H = {
                    title: (0, i.__)("Fundraising Progress Bar", "pronamic-pay-fundraising"),
                    description: (0, i.__)("Displays fundraising raised and target amount with progress bar.", "pronamic-pay-fundraising"),
                    category: z,
                    icon: Z,
                    example: {},
                    attributes: J,
                    edit: function (e) {
                        var t = e.attributes,
                            r = e.setAttributes,
                            n = e.className,
                            a = t.targetLabel,
                            c = t.targetAmount,
                            p = t.raisedLabel,
                            f = t.raisedAmount,
                            d = t.color,
                            m = t.currencyCode,
                            y = t.currencyDecimals,
                            g = t.locale;
                        p || r({ raisedLabel: (0, i.__)("Raised:", "pronamic-pay-fundraising") }), a || r({ targetLabel: (0, i.__)("Target:", "pronamic-pay-fundraising") }), (f = f || ""), (c = c || "");
                        var b = React.createElement(
                                l.InspectorControls,
                                null,
                                React.createElement(
                                    o.PanelBody,
                                    null,
                                    React.createElement(o.TextControl, {
                                        label: (0, i.__)("Target", "pronamic-pay-fundraising"),
                                        value: c,
                                        onChange: function (e) {
                                            r({ targetAmount: e.replace(/,/g, ".") });
                                        },
                                    }),
                                    React.createElement(o.TextControl, {
                                        label: (0, i.__)("Raised", "pronamic-pay-fundraising"),
                                        value: f,
                                        onChange: function (e) {
                                            r({ raisedAmount: e.replace(/,/g, ".") });
                                        },
                                    }),
                                    React.createElement(l.ColorPalette, {
                                        colors: s,
                                        value: d,
                                        onChange: function (e) {
                                            r({ color: e });
                                        },
                                    })
                                )
                            ),
                            v = n + " ppfr-block ppfr-block-bar",
                            h = { raisedLabel: d, raisedAmount: d };
                        return React.createElement(
                            "div",
                            { className: v },
                            b,
                            React.createElement(S, { color: d, value: u(f, c) }),
                            React.createElement(_, { setAttributes: r, colors: h, raisedLabel: p, raisedAmount: f, targetLabel: a, targetAmount: c, locale: g, currencyCode: m, currencyDecimals: y })
                        );
                    },
                    save: function (e) {
                        return e.attributes, null;
                    },
                    transforms: U,
                },
                q = React.createElement(
                    o.SVG,
                    { xmlns: "http://www.w3.org/2000/svg", viewBox: "0 0 24 24" },
                    React.createElement(o.Path, {
                        d:
                            "M23,16 C23.5522847,16 24,16.4477153 24,17 C24,17.5522847 23.5522847,18 23,18 L1,18 C0.44771525,18 6.76353751e-17,17.5522847 0,17 C-6.76353751e-17,16.4477153 0.44771525,16 1,16 L23,16 Z M23,12 C23.5522847,12 24,12.4477153 24,13 C24,13.5522847 23.5522847,14 23,14 L1,14 C0.44771525,14 6.76353751e-17,13.5522847 0,13 C-6.76353751e-17,12.4477153 0.44771525,12 1,12 L23,12 Z M9,6 C10.1045695,6 11,6.8954305 11,8 C11,9.1045695 10.1045695,10 9,10 L2,10 C0.8954305,10 1.3527075e-16,9.1045695 0,8 C-1.3527075e-16,6.8954305 0.8954305,6 2,6 L9,6 Z",
                    })
                ),
                K = JSON.parse(
                    '{"name":"pronamic-pay/fundraising-progress-text","title":"Fundraising Progress","category":"pronamic-pay","attributes":{"raisedLabel":{"type":"string"},"raisedAmount":{"type":"string","default":"0"},"targetLabel":{"type":"string"},"targetAmount":{"type":"string","default":"0"},"contributionsLabel":{"type":"string"},"contributionsValue":{"type":"string","default":"0"},"currencyCode":{"type":"string","default":"EUR"},"currencyDecimals":{"type":"string","default":"2"},"locale":{"type":"string"},"color":{"type":"string","default":"#f9461c"}},"supports":{"__experimentalBorder":{"color":true,"radius":true,"style":true,"width":true,"__experimentalDefaultControls":{"color":true,"radius":true,"style":true,"width":true}}},"editorScript":"file:../../index.js","style":"pronamic-pay-fundraising","textdomain":"pronamic-pay-fundraising"}'
                ),
                Q = {
                    from: [
                        {
                            type: "block",
                            blocks: ["pronamic-pay/fundraising-progress-circle", "pronamic-pay/fundraising-progress-bar"],
                            transform: function (e) {
                                return (0, a.createBlock)("pronamic-pay/fundraising-progress-text", e);
                            },
                        },
                    ],
                },
                W = Q,
                X = K.attributes,
                Y = K.category,
                ee = K.name,
                te = {
                    title: (0, i.__)("Fundraising Progress", "pronamic-pay-fundraising"),
                    description: (0, i.__)("Displays fundraising raised amount and number of contributions.", "pronamic-pay-fundraising"),
                    category: Y,
                    icon: q,
                    example: {},
                    attributes: X,
                    edit: function (e) {
                        var t = e.attributes,
                            r = e.setAttributes,
                            n = e.className,
                            a = t.raisedLabel,
                            c = t.raisedAmount,
                            u = t.contributionsLabel,
                            p = t.contributionsValue,
                            f = t.color,
                            d = t.currencyCode,
                            m = t.currencyDecimals,
                            y = t.locale;
                        a || r({ raisedLabel: (0, i.__)("Raised", "pronamic-pay-fundraising") }), u || r({ contributionsLabel: (0, i.__)("contributions", "pronamic-pay-fundraising") }), (c = c || ""), (p = p || "");
                        var g = React.createElement(
                                l.InspectorControls,
                                null,
                                React.createElement(
                                    o.PanelBody,
                                    null,
                                    React.createElement(o.TextControl, {
                                        label: (0, i.__)("Raised", "pronamic-pay-fundraising"),
                                        value: c,
                                        onChange: function (e) {
                                            r({ raisedAmount: e.replace(/,/g, ".") });
                                        },
                                    }),
                                    React.createElement(o.TextControl, {
                                        label: (0, i.__)("Contributions", "pronamic-pay-fundraising"),
                                        value: p,
                                        onChange: function (e) {
                                            r({ contributionsValue: e.replace(/[^\d]/g, "") });
                                        },
                                    }),
                                    React.createElement(l.ColorPalette, {
                                        colors: s,
                                        value: f,
                                        onChange: function (e) {
                                            r({ color: e });
                                        },
                                    })
                                )
                            ),
                            b = n + " ppfr-block ppfr-block-compact",
                            v = { raisedAmount: f };
                        return React.createElement(
                            "div",
                            { className: b },
                            g,
                            React.createElement(_, { setAttributes: r, colors: v, raisedLabel: a, raisedAmount: c, contributionsLabel: u, contributionsValue: p, locale: y, currencyCode: d, currencyDecimals: m })
                        );
                    },
                    save: function (e) {
                        return e.attributes, null;
                    },
                    transforms: W,
                };
            [e, t, n].forEach(function (e) {
                if (e) {
                    var t = e.name,
                        r = e.settings;
                    (0, a.registerBlockType)(t, r);
                }
            }),
                (0, a.updateCategory)("pronamic-pay", {
                    icon: React.createElement(
                        o.SVG,
                        { width: "24", height: "24", viewBox: "0 0 512 512", xmlns: "http://www.w3.org/2000/svg" },
                        React.createElement(o.Path, {
                            d:
                                "M256 0c141.385 0 256 114.615 256 256S397.385 512 256 512c-48.85 0-94.504-13.682-133.34-37.424L174.558 384h92.988c70.693 0 128-57.308 128-128 0-70.692-57.307-128-128-128h-46.682c-15.248 0-27.608 12.36-27.608 27.608 0 15.247 12.36 27.608 27.608 27.608h46.682c40.198 0 72.784 32.586 72.784 72.784 0 40.198-32.586 72.784-72.784 72.784H167.153c-12.869 0-23.681 8.805-26.741 20.72a28 28 0 00-.606 1.966l-30.622 114.273C43.161 419.443 0 342.762 0 256 0 114.615 114.615 0 256 0zm11.545 220.863h-65.757c-19.406 0-35.137 15.731-35.137 35.137s15.731 35.137 35.137 35.137h65.757c19.406 0 35.137-15.731 35.137-35.137s-15.731-35.137-35.137-35.137z",
                            fill: "#A0A5AA",
                        })
                    ),
                });
        })();
})();
