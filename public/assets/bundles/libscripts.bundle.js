! function (e, t) {
    "use strict";
    "object" == typeof module && "object" == typeof module.exports ? module.exports = e.document ? t(e, !0) : function (e) {
        if (!e.document) throw new Error("jQuery requires a window with a document");
        return t(e)
    } : t(e)
}("undefined" != typeof window ? window : this, function (x, e) {
    "use strict";

    function g(e) {
        return null != e && e === e.window
    }
    var t = [],
        n = Object.getPrototypeOf,
        a = t.slice,
        m = t.flat ? function (e) {
            return t.flat.call(e)
        } : function (e) {
            return t.concat.apply([], e)
        },
        l = t.push,
        r = t.indexOf,
        i = {},
        o = i.toString,
        v = i.hasOwnProperty,
        s = v.toString,
        c = s.call(Object),
        y = {},
        b = function (e) {
            return "function" == typeof e && "number" != typeof e.nodeType && "function" != typeof e.item
        },
        E = x.document,
        u = {
            type: !0,
            src: !0,
            nonce: !0,
            noModule: !0
        };

    function _(e, t, n) {
        var i, r, o = (n = n || E).createElement("script");
        if (o.text = e, t)
            for (i in u)(r = t[i] || t.getAttribute && t.getAttribute(i)) && o.setAttribute(i, r);
        n.head.appendChild(o).parentNode.removeChild(o)
    }

    function p(e) {
        return null == e ? e + "" : "object" == typeof e || "function" == typeof e ? i[o.call(e)] || "object" : typeof e
    }
    var d = "3.6.0",
        T = function (e, t) {
            return new T.fn.init(e, t)
        };

    function f(e) {
        var t = !!e && "length" in e && e.length,
            n = p(e);
        return !b(e) && !g(e) && ("array" === n || 0 === t || "number" == typeof t && 0 < t && t - 1 in e)
    }
    T.fn = T.prototype = {
        jquery: d,
        constructor: T,
        length: 0,
        toArray: function () {
            return a.call(this)
        },
        get: function (e) {
            return null == e ? a.call(this) : e < 0 ? this[e + this.length] : this[e]
        },
        pushStack: function (e) {
            e = T.merge(this.constructor(), e);
            return e.prevObject = this, e
        },
        each: function (e) {
            return T.each(this, e)
        },
        map: function (n) {
            return this.pushStack(T.map(this, function (e, t) {
                return n.call(e, t, e)
            }))
        },
        slice: function () {
            return this.pushStack(a.apply(this, arguments))
        },
        first: function () {
            return this.eq(0)
        },
        last: function () {
            return this.eq(-1)
        },
        even: function () {
            return this.pushStack(T.grep(this, function (e, t) {
                return (t + 1) % 2
            }))
        },
        odd: function () {
            return this.pushStack(T.grep(this, function (e, t) {
                return t % 2
            }))
        },
        eq: function (e) {
            var t = this.length,
                e = +e + (e < 0 ? t : 0);
            return this.pushStack(0 <= e && e < t ? [this[e]] : [])
        },
        end: function () {
            return this.prevObject || this.constructor()
        },
        push: l,
        sort: t.sort,
        splice: t.splice
    }, T.extend = T.fn.extend = function () {
        var e, t, n, i, r, o = arguments[0] || {},
            s = 1,
            a = arguments.length,
            l = !1;
        for ("boolean" == typeof o && (l = o, o = arguments[s] || {}, s++), "object" == typeof o || b(o) || (o = {}), s === a && (o = this, s--); s < a; s++)
            if (null != (e = arguments[s]))
                for (t in e) n = e[t], "__proto__" !== t && o !== n && (l && n && (T.isPlainObject(n) || (i = Array.isArray(n))) ? (r = o[t], r = i && !Array.isArray(r) ? [] : i || T.isPlainObject(r) ? r : {}, i = !1, o[t] = T.extend(l, r, n)) : void 0 !== n && (o[t] = n));
        return o
    }, T.extend({
        expando: "jQuery" + (d + Math.random()).replace(/\D/g, ""),
        isReady: !0,
        error: function (e) {
            throw new Error(e)
        },
        noop: function () {},
        isPlainObject: function (e) {
            return !(!e || "[object Object]" !== o.call(e)) && (!(e = n(e)) || "function" == typeof (e = v.call(e, "constructor") && e.constructor) && s.call(e) === c)
        },
        isEmptyObject: function (e) {
            for (var t in e) return !1;
            return !0
        },
        globalEval: function (e, t, n) {
            _(e, {
                nonce: t && t.nonce
            }, n)
        },
        each: function (e, t) {
            var n, i = 0;
            if (f(e))
                for (n = e.length; i < n && !1 !== t.call(e[i], i, e[i]); i++);
            else
                for (i in e)
                    if (!1 === t.call(e[i], i, e[i])) break;
            return e
        },
        makeArray: function (e, t) {
            t = t || [];
            return null != e && (f(Object(e)) ? T.merge(t, "string" == typeof e ? [e] : e) : l.call(t, e)), t
        },
        inArray: function (e, t, n) {
            return null == t ? -1 : r.call(t, e, n)
        },
        merge: function (e, t) {
            for (var n = +t.length, i = 0, r = e.length; i < n; i++) e[r++] = t[i];
            return e.length = r, e
        },
        grep: function (e, t, n) {
            for (var i = [], r = 0, o = e.length, s = !n; r < o; r++) !t(e[r], r) != s && i.push(e[r]);
            return i
        },
        map: function (e, t, n) {
            var i, r, o = 0,
                s = [];
            if (f(e))
                for (i = e.length; o < i; o++) null != (r = t(e[o], o, n)) && s.push(r);
            else
                for (o in e) null != (r = t(e[o], o, n)) && s.push(r);
            return m(s)
        },
        guid: 1,
        support: y
    }), "function" == typeof Symbol && (T.fn[Symbol.iterator] = t[Symbol.iterator]), T.each("Boolean Number String Function Array Date RegExp Object Error Symbol".split(" "), function (e, t) {
        i["[object " + t + "]"] = t.toLowerCase()
    });
    var h = function (n) {
        function d(e, t) {
            return e = "0x" + e.slice(1) - 65536, t || (e < 0 ? String.fromCharCode(65536 + e) : String.fromCharCode(e >> 10 | 55296, 1023 & e | 56320))
        }

        function i() {
            x()
        }
        var e, f, _, o, r, h, p, g, w, l, c, x, E, s, T, m, a, u, v, C = "sizzle" + +new Date,
            y = n.document,
            A = 0,
            b = 0,
            k = le(),
            S = le(),
            D = le(),
            L = le(),
            O = function (e, t) {
                return e === t && (c = !0), 0
            },
            N = {}.hasOwnProperty,
            t = [],
            j = t.pop,
            P = t.push,
            H = t.push,
            $ = t.slice,
            I = function (e, t) {
                for (var n = 0, i = e.length; n < i; n++)
                    if (e[n] === t) return n;
                return -1
            },
            q = "checked|selected|async|autofocus|autoplay|controls|defer|disabled|hidden|ismap|loop|multiple|open|readonly|required|scoped",
            M = "[\\x20\\t\\r\\n\\f]",
            R = "(?:\\\\[\\da-fA-F]{1,6}" + M + "?|\\\\[^\\r\\n\\f]|[\\w-]|[^\0-\\x7f])+",
            W = "\\[" + M + "*(" + R + ")(?:" + M + "*([*^$|!~]?=)" + M + "*(?:'((?:\\\\.|[^\\\\'])*)'|\"((?:\\\\.|[^\\\\\"])*)\"|(" + R + "))|)" + M + "*\\]",
            B = ":(" + R + ")(?:\\((('((?:\\\\.|[^\\\\'])*)'|\"((?:\\\\.|[^\\\\\"])*)\")|((?:\\\\.|[^\\\\()[\\]]|" + W + ")*)|.*)\\)|)",
            F = new RegExp(M + "+", "g"),
            z = new RegExp("^" + M + "+|((?:^|[^\\\\])(?:\\\\.)*)" + M + "+$", "g"),
            U = new RegExp("^" + M + "*," + M + "*"),
            X = new RegExp("^" + M + "*([>+~]|" + M + ")" + M + "*"),
            Y = new RegExp(M + "|>"),
            V = new RegExp(B),
            K = new RegExp("^" + R + "$"),
            Q = {
                ID: new RegExp("^#(" + R + ")"),
                CLASS: new RegExp("^\\.(" + R + ")"),
                TAG: new RegExp("^(" + R + "|[*])"),
                ATTR: new RegExp("^" + W),
                PSEUDO: new RegExp("^" + B),
                CHILD: new RegExp("^:(only|first|last|nth|nth-last)-(child|of-type)(?:\\(" + M + "*(even|odd|(([+-]|)(\\d*)n|)" + M + "*(?:([+-]|)" + M + "*(\\d+)|))" + M + "*\\)|)", "i"),
                bool: new RegExp("^(?:" + q + ")$", "i"),
                needsContext: new RegExp("^" + M + "*[>+~]|:(even|odd|eq|gt|lt|nth|first|last)(?:\\(" + M + "*((?:-\\d)?\\d*)" + M + "*\\)|)(?=[^-]|$)", "i")
            },
            G = /HTML$/i,
            J = /^(?:input|select|textarea|button)$/i,
            Z = /^h\d$/i,
            ee = /^[^{]+\{\s*\[native \w/,
            te = /^(?:#([\w-]+)|(\w+)|\.([\w-]+))$/,
            ne = /[+~]/,
            ie = new RegExp("\\\\[\\da-fA-F]{1,6}" + M + "?|\\\\([^\\r\\n\\f])", "g"),
            re = /([\0-\x1f\x7f]|^-?\d)|^-$|[^\0-\x1f\x7f-\uFFFF\w-]/g,
            oe = function (e, t) {
                return t ? "\0" === e ? "�" : e.slice(0, -1) + "\\" + e.charCodeAt(e.length - 1).toString(16) + " " : "\\" + e
            },
            se = ye(function (e) {
                return !0 === e.disabled && "fieldset" === e.nodeName.toLowerCase()
            }, {
                dir: "parentNode",
                next: "legend"
            });
        try {
            H.apply(t = $.call(y.childNodes), y.childNodes), t[y.childNodes.length].nodeType
        } catch (e) {
            H = {
                apply: t.length ? function (e, t) {
                    P.apply(e, $.call(t))
                } : function (e, t) {
                    for (var n = e.length, i = 0; e[n++] = t[i++];);
                    e.length = n - 1
                }
            }
        }

        function ae(t, e, n, i) {
            var r, o, s, a, l, c, u = e && e.ownerDocument,
                d = e ? e.nodeType : 9;
            if (n = n || [], "string" != typeof t || !t || 1 !== d && 9 !== d && 11 !== d) return n;
            if (!i && (x(e), e = e || E, T)) {
                if (11 !== d && (a = te.exec(t)))
                    if (c = a[1]) {
                        if (9 === d) {
                            if (!(o = e.getElementById(c))) return n;
                            if (o.id === c) return n.push(o), n
                        } else if (u && (o = u.getElementById(c)) && v(e, o) && o.id === c) return n.push(o), n
                    } else {
                        if (a[2]) return H.apply(n, e.getElementsByTagName(t)), n;
                        if ((c = a[3]) && f.getElementsByClassName && e.getElementsByClassName) return H.apply(n, e.getElementsByClassName(c)), n
                    } if (f.qsa && !L[t + " "] && (!m || !m.test(t)) && (1 !== d || "object" !== e.nodeName.toLowerCase())) {
                    if (c = t, u = e, 1 === d && (Y.test(t) || X.test(t))) {
                        for ((u = ne.test(t) && ge(e.parentNode) || e) === e && f.scope || ((s = e.getAttribute("id")) ? s = s.replace(re, oe) : e.setAttribute("id", s = C)), r = (l = h(t)).length; r--;) l[r] = (s ? "#" + s : ":scope") + " " + ve(l[r]);
                        c = l.join(",")
                    }
                    try {
                        return H.apply(n, u.querySelectorAll(c)), n
                    } catch (e) {
                        L(t, !0)
                    } finally {
                        s === C && e.removeAttribute("id")
                    }
                }
            }
            return g(t.replace(z, "$1"), e, n, i)
        }

        function le() {
            var n = [];

            function i(e, t) {
                return n.push(e + " ") > _.cacheLength && delete i[n.shift()], i[e + " "] = t
            }
            return i
        }

        function ce(e) {
            return e[C] = !0, e
        }

        function ue(e) {
            var t = E.createElement("fieldset");
            try {
                return !!e(t)
            } catch (e) {
                return !1
            } finally {
                t.parentNode && t.parentNode.removeChild(t), t = null
            }
        }

        function de(e, t) {
            for (var n = e.split("|"), i = n.length; i--;) _.attrHandle[n[i]] = t
        }

        function fe(e, t) {
            var n = t && e,
                i = n && 1 === e.nodeType && 1 === t.nodeType && e.sourceIndex - t.sourceIndex;
            if (i) return i;
            if (n)
                for (; n = n.nextSibling;)
                    if (n === t) return -1;
            return e ? 1 : -1
        }

        function he(t) {
            return function (e) {
                return "form" in e ? e.parentNode && !1 === e.disabled ? "label" in e ? "label" in e.parentNode ? e.parentNode.disabled === t : e.disabled === t : e.isDisabled === t || e.isDisabled !== !t && se(e) === t : e.disabled === t : "label" in e && e.disabled === t
            }
        }

        function pe(s) {
            return ce(function (o) {
                return o = +o, ce(function (e, t) {
                    for (var n, i = s([], e.length, o), r = i.length; r--;) e[n = i[r]] && (e[n] = !(t[n] = e[n]))
                })
            })
        }

        function ge(e) {
            return e && void 0 !== e.getElementsByTagName && e
        }
        for (e in f = ae.support = {}, r = ae.isXML = function (e) {
                var t = e && e.namespaceURI,
                    e = e && (e.ownerDocument || e).documentElement;
                return !G.test(t || e && e.nodeName || "HTML")
            }, x = ae.setDocument = function (e) {
                var t, e = e ? e.ownerDocument || e : y;
                return e != E && 9 === e.nodeType && e.documentElement && (s = (E = e).documentElement, T = !r(E), y != E && (t = E.defaultView) && t.top !== t && (t.addEventListener ? t.addEventListener("unload", i, !1) : t.attachEvent && t.attachEvent("onunload", i)), f.scope = ue(function (e) {
                    return s.appendChild(e).appendChild(E.createElement("div")), void 0 !== e.querySelectorAll && !e.querySelectorAll(":scope fieldset div").length
                }), f.attributes = ue(function (e) {
                    return e.className = "i", !e.getAttribute("className")
                }), f.getElementsByTagName = ue(function (e) {
                    return e.appendChild(E.createComment("")), !e.getElementsByTagName("*").length
                }), f.getElementsByClassName = ee.test(E.getElementsByClassName), f.getById = ue(function (e) {
                    return s.appendChild(e).id = C, !E.getElementsByName || !E.getElementsByName(C).length
                }), f.getById ? (_.filter.ID = function (e) {
                    var t = e.replace(ie, d);
                    return function (e) {
                        return e.getAttribute("id") === t
                    }
                }, _.find.ID = function (e, t) {
                    if (void 0 !== t.getElementById && T) {
                        e = t.getElementById(e);
                        return e ? [e] : []
                    }
                }) : (_.filter.ID = function (e) {
                    var t = e.replace(ie, d);
                    return function (e) {
                        e = void 0 !== e.getAttributeNode && e.getAttributeNode("id");
                        return e && e.value === t
                    }
                }, _.find.ID = function (e, t) {
                    if (void 0 !== t.getElementById && T) {
                        var n, i, r, o = t.getElementById(e);
                        if (o) {
                            if ((n = o.getAttributeNode("id")) && n.value === e) return [o];
                            for (r = t.getElementsByName(e), i = 0; o = r[i++];)
                                if ((n = o.getAttributeNode("id")) && n.value === e) return [o]
                        }
                        return []
                    }
                }), _.find.TAG = f.getElementsByTagName ? function (e, t) {
                    return void 0 !== t.getElementsByTagName ? t.getElementsByTagName(e) : f.qsa ? t.querySelectorAll(e) : void 0
                } : function (e, t) {
                    var n, i = [],
                        r = 0,
                        o = t.getElementsByTagName(e);
                    if ("*" !== e) return o;
                    for (; n = o[r++];) 1 === n.nodeType && i.push(n);
                    return i
                }, _.find.CLASS = f.getElementsByClassName && function (e, t) {
                    if (void 0 !== t.getElementsByClassName && T) return t.getElementsByClassName(e)
                }, a = [], m = [], (f.qsa = ee.test(E.querySelectorAll)) && (ue(function (e) {
                    var t;
                    s.appendChild(e).innerHTML = "<a id='" + C + "'></a><select id='" + C + "-\r\\' msallowcapture=''><option selected=''></option></select>", e.querySelectorAll("[msallowcapture^='']").length && m.push("[*^$]=" + M + "*(?:''|\"\")"), e.querySelectorAll("[selected]").length || m.push("\\[" + M + "*(?:value|" + q + ")"), e.querySelectorAll("[id~=" + C + "-]").length || m.push("~="), (t = E.createElement("input")).setAttribute("name", ""), e.appendChild(t), e.querySelectorAll("[name='']").length || m.push("\\[" + M + "*name" + M + "*=" + M + "*(?:''|\"\")"), e.querySelectorAll(":checked").length || m.push(":checked"), e.querySelectorAll("a#" + C + "+*").length || m.push(".#.+[+~]"), e.querySelectorAll("\\\f"), m.push("[\\r\\n\\f]")
                }), ue(function (e) {
                    e.innerHTML = "<a href='' disabled='disabled'></a><select disabled='disabled'><option/></select>";
                    var t = E.createElement("input");
                    t.setAttribute("type", "hidden"), e.appendChild(t).setAttribute("name", "D"), e.querySelectorAll("[name=d]").length && m.push("name" + M + "*[*^$|!~]?="), 2 !== e.querySelectorAll(":enabled").length && m.push(":enabled", ":disabled"), s.appendChild(e).disabled = !0, 2 !== e.querySelectorAll(":disabled").length && m.push(":enabled", ":disabled"), e.querySelectorAll("*,:x"), m.push(",.*:")
                })), (f.matchesSelector = ee.test(u = s.matches || s.webkitMatchesSelector || s.mozMatchesSelector || s.oMatchesSelector || s.msMatchesSelector)) && ue(function (e) {
                    f.disconnectedMatch = u.call(e, "*"), u.call(e, "[s!='']:x"), a.push("!=", B)
                }), m = m.length && new RegExp(m.join("|")), a = a.length && new RegExp(a.join("|")), t = ee.test(s.compareDocumentPosition), v = t || ee.test(s.contains) ? function (e, t) {
                    var n = 9 === e.nodeType ? e.documentElement : e,
                        t = t && t.parentNode;
                    return e === t || !(!t || 1 !== t.nodeType || !(n.contains ? n.contains(t) : e.compareDocumentPosition && 16 & e.compareDocumentPosition(t)))
                } : function (e, t) {
                    if (t)
                        for (; t = t.parentNode;)
                            if (t === e) return !0;
                    return !1
                }, O = t ? function (e, t) {
                    if (e === t) return c = !0, 0;
                    var n = !e.compareDocumentPosition - !t.compareDocumentPosition;
                    return n || (1 & (n = (e.ownerDocument || e) == (t.ownerDocument || t) ? e.compareDocumentPosition(t) : 1) || !f.sortDetached && t.compareDocumentPosition(e) === n ? e == E || e.ownerDocument == y && v(y, e) ? -1 : t == E || t.ownerDocument == y && v(y, t) ? 1 : l ? I(l, e) - I(l, t) : 0 : 4 & n ? -1 : 1)
                } : function (e, t) {
                    if (e === t) return c = !0, 0;
                    var n, i = 0,
                        r = e.parentNode,
                        o = t.parentNode,
                        s = [e],
                        a = [t];
                    if (!r || !o) return e == E ? -1 : t == E ? 1 : r ? -1 : o ? 1 : l ? I(l, e) - I(l, t) : 0;
                    if (r === o) return fe(e, t);
                    for (n = e; n = n.parentNode;) s.unshift(n);
                    for (n = t; n = n.parentNode;) a.unshift(n);
                    for (; s[i] === a[i];) i++;
                    return i ? fe(s[i], a[i]) : s[i] == y ? -1 : a[i] == y ? 1 : 0
                }), E
            }, ae.matches = function (e, t) {
                return ae(e, null, null, t)
            }, ae.matchesSelector = function (e, t) {
                if (x(e), f.matchesSelector && T && !L[t + " "] && (!a || !a.test(t)) && (!m || !m.test(t))) try {
                    var n = u.call(e, t);
                    if (n || f.disconnectedMatch || e.document && 11 !== e.document.nodeType) return n
                } catch (e) {
                    L(t, !0)
                }
                return 0 < ae(t, E, null, [e]).length
            }, ae.contains = function (e, t) {
                return (e.ownerDocument || e) != E && x(e), v(e, t)
            }, ae.attr = function (e, t) {
                (e.ownerDocument || e) != E && x(e);
                var n = _.attrHandle[t.toLowerCase()],
                    n = n && N.call(_.attrHandle, t.toLowerCase()) ? n(e, t, !T) : void 0;
                return void 0 !== n ? n : f.attributes || !T ? e.getAttribute(t) : (n = e.getAttributeNode(t)) && n.specified ? n.value : null
            }, ae.escape = function (e) {
                return (e + "").replace(re, oe)
            }, ae.error = function (e) {
                throw new Error("Syntax error, unrecognized expression: " + e)
            }, ae.uniqueSort = function (e) {
                var t, n = [],
                    i = 0,
                    r = 0;
                if (c = !f.detectDuplicates, l = !f.sortStable && e.slice(0), e.sort(O), c) {
                    for (; t = e[r++];) t === e[r] && (i = n.push(r));
                    for (; i--;) e.splice(n[i], 1)
                }
                return l = null, e
            }, o = ae.getText = function (e) {
                var t, n = "",
                    i = 0,
                    r = e.nodeType;
                if (r) {
                    if (1 === r || 9 === r || 11 === r) {
                        if ("string" == typeof e.textContent) return e.textContent;
                        for (e = e.firstChild; e; e = e.nextSibling) n += o(e)
                    } else if (3 === r || 4 === r) return e.nodeValue
                } else
                    for (; t = e[i++];) n += o(t);
                return n
            }, (_ = ae.selectors = {
                cacheLength: 50,
                createPseudo: ce,
                match: Q,
                attrHandle: {},
                find: {},
                relative: {
                    ">": {
                        dir: "parentNode",
                        first: !0
                    },
                    " ": {
                        dir: "parentNode"
                    },
                    "+": {
                        dir: "previousSibling",
                        first: !0
                    },
                    "~": {
                        dir: "previousSibling"
                    }
                },
                preFilter: {
                    ATTR: function (e) {
                        return e[1] = e[1].replace(ie, d), e[3] = (e[3] || e[4] || e[5] || "").replace(ie, d), "~=" === e[2] && (e[3] = " " + e[3] + " "), e.slice(0, 4)
                    },
                    CHILD: function (e) {
                        return e[1] = e[1].toLowerCase(), "nth" === e[1].slice(0, 3) ? (e[3] || ae.error(e[0]), e[4] = +(e[4] ? e[5] + (e[6] || 1) : 2 * ("even" === e[3] || "odd" === e[3])), e[5] = +(e[7] + e[8] || "odd" === e[3])) : e[3] && ae.error(e[0]), e
                    },
                    PSEUDO: function (e) {
                        var t, n = !e[6] && e[2];
                        return Q.CHILD.test(e[0]) ? null : (e[3] ? e[2] = e[4] || e[5] || "" : n && V.test(n) && (t = h(n, !0)) && (t = n.indexOf(")", n.length - t) - n.length) && (e[0] = e[0].slice(0, t), e[2] = n.slice(0, t)), e.slice(0, 3))
                    }
                },
                filter: {
                    TAG: function (e) {
                        var t = e.replace(ie, d).toLowerCase();
                        return "*" === e ? function () {
                            return !0
                        } : function (e) {
                            return e.nodeName && e.nodeName.toLowerCase() === t
                        }
                    },
                    CLASS: function (e) {
                        var t = k[e + " "];
                        return t || (t = new RegExp("(^|" + M + ")" + e + "(" + M + "|$)")) && k(e, function (e) {
                            return t.test("string" == typeof e.className && e.className || void 0 !== e.getAttribute && e.getAttribute("class") || "")
                        })
                    },
                    ATTR: function (t, n, i) {
                        return function (e) {
                            e = ae.attr(e, t);
                            return null == e ? "!=" === n : !n || (e += "", "=" === n ? e === i : "!=" === n ? e !== i : "^=" === n ? i && 0 === e.indexOf(i) : "*=" === n ? i && -1 < e.indexOf(i) : "$=" === n ? i && e.slice(-i.length) === i : "~=" === n ? -1 < (" " + e.replace(F, " ") + " ").indexOf(i) : "|=" === n && (e === i || e.slice(0, i.length + 1) === i + "-"))
                        }
                    },
                    CHILD: function (p, e, t, g, m) {
                        var v = "nth" !== p.slice(0, 3),
                            y = "last" !== p.slice(-4),
                            b = "of-type" === e;
                        return 1 === g && 0 === m ? function (e) {
                            return !!e.parentNode
                        } : function (e, t, n) {
                            var i, r, o, s, a, l, c = v != y ? "nextSibling" : "previousSibling",
                                u = e.parentNode,
                                d = b && e.nodeName.toLowerCase(),
                                f = !n && !b,
                                h = !1;
                            if (u) {
                                if (v) {
                                    for (; c;) {
                                        for (s = e; s = s[c];)
                                            if (b ? s.nodeName.toLowerCase() === d : 1 === s.nodeType) return !1;
                                        l = c = "only" === p && !l && "nextSibling"
                                    }
                                    return !0
                                }
                                if (l = [y ? u.firstChild : u.lastChild], y && f) {
                                    for (h = (a = (i = (r = (o = (s = u)[C] || (s[C] = {}))[s.uniqueID] || (o[s.uniqueID] = {}))[p] || [])[0] === A && i[1]) && i[2], s = a && u.childNodes[a]; s = ++a && s && s[c] || (h = a = 0) || l.pop();)
                                        if (1 === s.nodeType && ++h && s === e) {
                                            r[p] = [A, a, h];
                                            break
                                        }
                                } else if (!1 === (h = f ? a = (i = (r = (o = (s = e)[C] || (s[C] = {}))[s.uniqueID] || (o[s.uniqueID] = {}))[p] || [])[0] === A && i[1] : h))
                                    for (;
                                        (s = ++a && s && s[c] || (h = a = 0) || l.pop()) && ((b ? s.nodeName.toLowerCase() !== d : 1 !== s.nodeType) || !++h || (f && ((r = (o = s[C] || (s[C] = {}))[s.uniqueID] || (o[s.uniqueID] = {}))[p] = [A, h]), s !== e)););
                                return (h -= m) === g || h % g == 0 && 0 <= h / g
                            }
                        }
                    },
                    PSEUDO: function (e, o) {
                        var t, s = _.pseudos[e] || _.setFilters[e.toLowerCase()] || ae.error("unsupported pseudo: " + e);
                        return s[C] ? s(o) : 1 < s.length ? (t = [e, e, "", o], _.setFilters.hasOwnProperty(e.toLowerCase()) ? ce(function (e, t) {
                            for (var n, i = s(e, o), r = i.length; r--;) e[n = I(e, i[r])] = !(t[n] = i[r])
                        }) : function (e) {
                            return s(e, 0, t)
                        }) : s
                    }
                },
                pseudos: {
                    not: ce(function (e) {
                        var i = [],
                            r = [],
                            a = p(e.replace(z, "$1"));
                        return a[C] ? ce(function (e, t, n, i) {
                            for (var r, o = a(e, null, i, []), s = e.length; s--;)(r = o[s]) && (e[s] = !(t[s] = r))
                        }) : function (e, t, n) {
                            return i[0] = e, a(i, null, n, r), i[0] = null, !r.pop()
                        }
                    }),
                    has: ce(function (t) {
                        return function (e) {
                            return 0 < ae(t, e).length
                        }
                    }),
                    contains: ce(function (t) {
                        return t = t.replace(ie, d),
                            function (e) {
                                return -1 < (e.textContent || o(e)).indexOf(t)
                            }
                    }),
                    lang: ce(function (n) {
                        return K.test(n || "") || ae.error("unsupported lang: " + n), n = n.replace(ie, d).toLowerCase(),
                            function (e) {
                                var t;
                                do {
                                    if (t = T ? e.lang : e.getAttribute("xml:lang") || e.getAttribute("lang")) return (t = t.toLowerCase()) === n || 0 === t.indexOf(n + "-")
                                } while ((e = e.parentNode) && 1 === e.nodeType);
                                return !1
                            }
                    }),
                    target: function (e) {
                        var t = n.location && n.location.hash;
                        return t && t.slice(1) === e.id
                    },
                    root: function (e) {
                        return e === s
                    },
                    focus: function (e) {
                        return e === E.activeElement && (!E.hasFocus || E.hasFocus()) && !!(e.type || e.href || ~e.tabIndex)
                    },
                    enabled: he(!1),
                    disabled: he(!0),
                    checked: function (e) {
                        var t = e.nodeName.toLowerCase();
                        return "input" === t && !!e.checked || "option" === t && !!e.selected
                    },
                    selected: function (e) {
                        return e.parentNode && e.parentNode.selectedIndex, !0 === e.selected
                    },
                    empty: function (e) {
                        for (e = e.firstChild; e; e = e.nextSibling)
                            if (e.nodeType < 6) return !1;
                        return !0
                    },
                    parent: function (e) {
                        return !_.pseudos.empty(e)
                    },
                    header: function (e) {
                        return Z.test(e.nodeName)
                    },
                    input: function (e) {
                        return J.test(e.nodeName)
                    },
                    button: function (e) {
                        var t = e.nodeName.toLowerCase();
                        return "input" === t && "button" === e.type || "button" === t
                    },
                    text: function (e) {
                        return "input" === e.nodeName.toLowerCase() && "text" === e.type && (null == (e = e.getAttribute("type")) || "text" === e.toLowerCase())
                    },
                    first: pe(function () {
                        return [0]
                    }),
                    last: pe(function (e, t) {
                        return [t - 1]
                    }),
                    eq: pe(function (e, t, n) {
                        return [n < 0 ? n + t : n]
                    }),
                    even: pe(function (e, t) {
                        for (var n = 0; n < t; n += 2) e.push(n);
                        return e
                    }),
                    odd: pe(function (e, t) {
                        for (var n = 1; n < t; n += 2) e.push(n);
                        return e
                    }),
                    lt: pe(function (e, t, n) {
                        for (var i = n < 0 ? n + t : t < n ? t : n; 0 <= --i;) e.push(i);
                        return e
                    }),
                    gt: pe(function (e, t, n) {
                        for (var i = n < 0 ? n + t : n; ++i < t;) e.push(i);
                        return e
                    })
                }
            }).pseudos.nth = _.pseudos.eq, {
                radio: !0,
                checkbox: !0,
                file: !0,
                password: !0,
                image: !0
            }) _.pseudos[e] = function (t) {
            return function (e) {
                return "input" === e.nodeName.toLowerCase() && e.type === t
            }
        }(e);
        for (e in {
                submit: !0,
                reset: !0
            }) _.pseudos[e] = function (n) {
            return function (e) {
                var t = e.nodeName.toLowerCase();
                return ("input" === t || "button" === t) && e.type === n
            }
        }(e);

        function me() {}

        function ve(e) {
            for (var t = 0, n = e.length, i = ""; t < n; t++) i += e[t].value;
            return i
        }

        function ye(s, e, t) {
            var a = e.dir,
                l = e.next,
                c = l || a,
                u = t && "parentNode" === c,
                d = b++;
            return e.first ? function (e, t, n) {
                for (; e = e[a];)
                    if (1 === e.nodeType || u) return s(e, t, n);
                return !1
            } : function (e, t, n) {
                var i, r, o = [A, d];
                if (n) {
                    for (; e = e[a];)
                        if ((1 === e.nodeType || u) && s(e, t, n)) return !0
                } else
                    for (; e = e[a];)
                        if (1 === e.nodeType || u)
                            if (i = (r = e[C] || (e[C] = {}))[e.uniqueID] || (r[e.uniqueID] = {}), l && l === e.nodeName.toLowerCase()) e = e[a] || e;
                            else {
                                if ((r = i[c]) && r[0] === A && r[1] === d) return o[2] = r[2];
                                if ((i[c] = o)[2] = s(e, t, n)) return !0
                            } return !1
            }
        }

        function be(r) {
            return 1 < r.length ? function (e, t, n) {
                for (var i = r.length; i--;)
                    if (!r[i](e, t, n)) return !1;
                return !0
            } : r[0]
        }

        function _e(e, t, n, i, r) {
            for (var o, s = [], a = 0, l = e.length, c = null != t; a < l; a++)(o = e[a]) && (n && !n(o, i, r) || (s.push(o), c && t.push(a)));
            return s
        }

        function we(h, p, g, m, v, e) {
            return m && !m[C] && (m = we(m)), v && !v[C] && (v = we(v, e)), ce(function (e, t, n, i) {
                var r, o, s, a = [],
                    l = [],
                    c = t.length,
                    u = e || function (e, t, n) {
                        for (var i = 0, r = t.length; i < r; i++) ae(e, t[i], n);
                        return n
                    }(p || "*", n.nodeType ? [n] : n, []),
                    d = !h || !e && p ? u : _e(u, a, h, n, i),
                    f = g ? v || (e ? h : c || m) ? [] : t : d;
                if (g && g(d, f, n, i), m)
                    for (r = _e(f, l), m(r, [], n, i), o = r.length; o--;)(s = r[o]) && (f[l[o]] = !(d[l[o]] = s));
                if (e) {
                    if (v || h) {
                        if (v) {
                            for (r = [], o = f.length; o--;)(s = f[o]) && r.push(d[o] = s);
                            v(null, f = [], r, i)
                        }
                        for (o = f.length; o--;)(s = f[o]) && -1 < (r = v ? I(e, s) : a[o]) && (e[r] = !(t[r] = s))
                    }
                } else f = _e(f === t ? f.splice(c, f.length) : f), v ? v(null, t, f, i) : H.apply(t, f)
            })
        }

        function xe(m, v) {
            function e(e, t, n, i, r) {
                var o, s, a, l = 0,
                    c = "0",
                    u = e && [],
                    d = [],
                    f = w,
                    h = e || b && _.find.TAG("*", r),
                    p = A += null == f ? 1 : Math.random() || .1,
                    g = h.length;
                for (r && (w = t == E || t || r); c !== g && null != (o = h[c]); c++) {
                    if (b && o) {
                        for (s = 0, t || o.ownerDocument == E || (x(o), n = !T); a = m[s++];)
                            if (a(o, t || E, n)) {
                                i.push(o);
                                break
                            } r && (A = p)
                    }
                    y && ((o = !a && o) && l--, e && u.push(o))
                }
                if (l += c, y && c !== l) {
                    for (s = 0; a = v[s++];) a(u, d, t, n);
                    if (e) {
                        if (0 < l)
                            for (; c--;) u[c] || d[c] || (d[c] = j.call(i));
                        d = _e(d)
                    }
                    H.apply(i, d), r && !e && 0 < d.length && 1 < l + v.length && ae.uniqueSort(i)
                }
                return r && (A = p, w = f), u
            }
            var y = 0 < v.length,
                b = 0 < m.length;
            return y ? ce(e) : e
        }
        return me.prototype = _.filters = _.pseudos, _.setFilters = new me, h = ae.tokenize = function (e, t) {
            var n, i, r, o, s, a, l, c = S[e + " "];
            if (c) return t ? 0 : c.slice(0);
            for (s = e, a = [], l = _.preFilter; s;) {
                for (o in n && !(i = U.exec(s)) || (i && (s = s.slice(i[0].length) || s), a.push(r = [])), n = !1, (i = X.exec(s)) && (n = i.shift(), r.push({
                        value: n,
                        type: i[0].replace(z, " ")
                    }), s = s.slice(n.length)), _.filter) !(i = Q[o].exec(s)) || l[o] && !(i = l[o](i)) || (n = i.shift(), r.push({
                    value: n,
                    type: o,
                    matches: i
                }), s = s.slice(n.length));
                if (!n) break
            }
            return t ? s.length : s ? ae.error(e) : S(e, a).slice(0)
        }, p = ae.compile = function (e, t) {
            var n, i = [],
                r = [],
                o = D[e + " "];
            if (!o) {
                for (n = (t = t || h(e)).length; n--;)((o = function e(t) {
                    for (var i, n, r, o = t.length, s = _.relative[t[0].type], a = s || _.relative[" "], l = s ? 1 : 0, c = ye(function (e) {
                            return e === i
                        }, a, !0), u = ye(function (e) {
                            return -1 < I(i, e)
                        }, a, !0), d = [function (e, t, n) {
                            return n = !s && (n || t !== w) || ((i = t).nodeType ? c : u)(e, t, n), i = null, n
                        }]; l < o; l++)
                        if (n = _.relative[t[l].type]) d = [ye(be(d), n)];
                        else {
                            if ((n = _.filter[t[l].type].apply(null, t[l].matches))[C]) {
                                for (r = ++l; r < o && !_.relative[t[r].type]; r++);
                                return we(1 < l && be(d), 1 < l && ve(t.slice(0, l - 1).concat({
                                    value: " " === t[l - 2].type ? "*" : ""
                                })).replace(z, "$1"), n, l < r && e(t.slice(l, r)), r < o && e(t = t.slice(r)), r < o && ve(t))
                            }
                            d.push(n)
                        } return be(d)
                }(t[n]))[C] ? i : r).push(o);
                (o = D(e, xe(r, i))).selector = e
            }
            return o
        }, g = ae.select = function (e, t, n, i) {
            var r, o, s, a, l, c = "function" == typeof e && e,
                u = !i && h(e = c.selector || e);
            if (n = n || [], 1 === u.length) {
                if (2 < (o = u[0] = u[0].slice(0)).length && "ID" === (s = o[0]).type && 9 === t.nodeType && T && _.relative[o[1].type]) {
                    if (!(t = (_.find.ID(s.matches[0].replace(ie, d), t) || [])[0])) return n;
                    c && (t = t.parentNode), e = e.slice(o.shift().value.length)
                }
                for (r = Q.needsContext.test(e) ? 0 : o.length; r-- && (s = o[r], !_.relative[a = s.type]);)
                    if ((l = _.find[a]) && (i = l(s.matches[0].replace(ie, d), ne.test(o[0].type) && ge(t.parentNode) || t))) {
                        if (o.splice(r, 1), !(e = i.length && ve(o))) return H.apply(n, i), n;
                        break
                    }
            }
            return (c || p(e, u))(i, t, !T, n, !t || ne.test(e) && ge(t.parentNode) || t), n
        }, f.sortStable = C.split("").sort(O).join("") === C, f.detectDuplicates = !!c, x(), f.sortDetached = ue(function (e) {
            return 1 & e.compareDocumentPosition(E.createElement("fieldset"))
        }), ue(function (e) {
            return e.innerHTML = "<a href='#'></a>", "#" === e.firstChild.getAttribute("href")
        }) || de("type|href|height|width", function (e, t, n) {
            if (!n) return e.getAttribute(t, "type" === t.toLowerCase() ? 1 : 2)
        }), f.attributes && ue(function (e) {
            return e.innerHTML = "<input/>", e.firstChild.setAttribute("value", ""), "" === e.firstChild.getAttribute("value")
        }) || de("value", function (e, t, n) {
            if (!n && "input" === e.nodeName.toLowerCase()) return e.defaultValue
        }), ue(function (e) {
            return null == e.getAttribute("disabled")
        }) || de(q, function (e, t, n) {
            if (!n) return !0 === e[t] ? t.toLowerCase() : (t = e.getAttributeNode(t)) && t.specified ? t.value : null
        }), ae
    }(x);
    T.find = h, T.expr = h.selectors, T.expr[":"] = T.expr.pseudos, T.uniqueSort = T.unique = h.uniqueSort, T.text = h.getText, T.isXMLDoc = h.isXML, T.contains = h.contains, T.escapeSelector = h.escape;

    function w(e, t, n) {
        for (var i = [], r = void 0 !== n;
            (e = e[t]) && 9 !== e.nodeType;)
            if (1 === e.nodeType) {
                if (r && T(e).is(n)) break;
                i.push(e)
            } return i
    }

    function C(e, t) {
        for (var n = []; e; e = e.nextSibling) 1 === e.nodeType && e !== t && n.push(e);
        return n
    }
    var A = T.expr.match.needsContext;

    function k(e, t) {
        return e.nodeName && e.nodeName.toLowerCase() === t.toLowerCase()
    }
    var S = /^<([a-z][^\/\0>:\x20\t\r\n\f]*)[\x20\t\r\n\f]*\/?>(?:<\/\1>|)$/i;

    function D(e, n, i) {
        return b(n) ? T.grep(e, function (e, t) {
            return !!n.call(e, t, e) !== i
        }) : n.nodeType ? T.grep(e, function (e) {
            return e === n !== i
        }) : "string" != typeof n ? T.grep(e, function (e) {
            return -1 < r.call(n, e) !== i
        }) : T.filter(n, e, i)
    }
    T.filter = function (e, t, n) {
        var i = t[0];
        return n && (e = ":not(" + e + ")"), 1 === t.length && 1 === i.nodeType ? T.find.matchesSelector(i, e) ? [i] : [] : T.find.matches(e, T.grep(t, function (e) {
            return 1 === e.nodeType
        }))
    }, T.fn.extend({
        find: function (e) {
            var t, n, i = this.length,
                r = this;
            if ("string" != typeof e) return this.pushStack(T(e).filter(function () {
                for (t = 0; t < i; t++)
                    if (T.contains(r[t], this)) return !0
            }));
            for (n = this.pushStack([]), t = 0; t < i; t++) T.find(e, r[t], n);
            return 1 < i ? T.uniqueSort(n) : n
        },
        filter: function (e) {
            return this.pushStack(D(this, e || [], !1))
        },
        not: function (e) {
            return this.pushStack(D(this, e || [], !0))
        },
        is: function (e) {
            return !!D(this, "string" == typeof e && A.test(e) ? T(e) : e || [], !1).length
        }
    });
    var L = /^(?:\s*(<[\w\W]+>)[^>]*|#([\w-]+))$/;
    (T.fn.init = function (e, t, n) {
        if (!e) return this;
        if (n = n || O, "string" != typeof e) return e.nodeType ? (this[0] = e, this.length = 1, this) : b(e) ? void 0 !== n.ready ? n.ready(e) : e(T) : T.makeArray(e, this);
        if (!(i = "<" === e[0] && ">" === e[e.length - 1] && 3 <= e.length ? [null, e, null] : L.exec(e)) || !i[1] && t) return (!t || t.jquery ? t || n : this.constructor(t)).find(e);
        if (i[1]) {
            if (t = t instanceof T ? t[0] : t, T.merge(this, T.parseHTML(i[1], t && t.nodeType ? t.ownerDocument || t : E, !0)), S.test(i[1]) && T.isPlainObject(t))
                for (var i in t) b(this[i]) ? this[i](t[i]) : this.attr(i, t[i]);
            return this
        }
        return (e = E.getElementById(i[2])) && (this[0] = e, this.length = 1), this
    }).prototype = T.fn;
    var O = T(E),
        N = /^(?:parents|prev(?:Until|All))/,
        j = {
            children: !0,
            contents: !0,
            next: !0,
            prev: !0
        };

    function P(e, t) {
        for (;
            (e = e[t]) && 1 !== e.nodeType;);
        return e
    }
    T.fn.extend({
        has: function (e) {
            var t = T(e, this),
                n = t.length;
            return this.filter(function () {
                for (var e = 0; e < n; e++)
                    if (T.contains(this, t[e])) return !0
            })
        },
        closest: function (e, t) {
            var n, i = 0,
                r = this.length,
                o = [],
                s = "string" != typeof e && T(e);
            if (!A.test(e))
                for (; i < r; i++)
                    for (n = this[i]; n && n !== t; n = n.parentNode)
                        if (n.nodeType < 11 && (s ? -1 < s.index(n) : 1 === n.nodeType && T.find.matchesSelector(n, e))) {
                            o.push(n);
                            break
                        } return this.pushStack(1 < o.length ? T.uniqueSort(o) : o)
        },
        index: function (e) {
            return e ? "string" == typeof e ? r.call(T(e), this[0]) : r.call(this, e.jquery ? e[0] : e) : this[0] && this[0].parentNode ? this.first().prevAll().length : -1
        },
        add: function (e, t) {
            return this.pushStack(T.uniqueSort(T.merge(this.get(), T(e, t))))
        },
        addBack: function (e) {
            return this.add(null == e ? this.prevObject : this.prevObject.filter(e))
        }
    }), T.each({
        parent: function (e) {
            e = e.parentNode;
            return e && 11 !== e.nodeType ? e : null
        },
        parents: function (e) {
            return w(e, "parentNode")
        },
        parentsUntil: function (e, t, n) {
            return w(e, "parentNode", n)
        },
        next: function (e) {
            return P(e, "nextSibling")
        },
        prev: function (e) {
            return P(e, "previousSibling")
        },
        nextAll: function (e) {
            return w(e, "nextSibling")
        },
        prevAll: function (e) {
            return w(e, "previousSibling")
        },
        nextUntil: function (e, t, n) {
            return w(e, "nextSibling", n)
        },
        prevUntil: function (e, t, n) {
            return w(e, "previousSibling", n)
        },
        siblings: function (e) {
            return C((e.parentNode || {}).firstChild, e)
        },
        children: function (e) {
            return C(e.firstChild)
        },
        contents: function (e) {
            return null != e.contentDocument && n(e.contentDocument) ? e.contentDocument : (k(e, "template") && (e = e.content || e), T.merge([], e.childNodes))
        }
    }, function (i, r) {
        T.fn[i] = function (e, t) {
            var n = T.map(this, r, e);
            return (t = "Until" !== i.slice(-5) ? e : t) && "string" == typeof t && (n = T.filter(t, n)), 1 < this.length && (j[i] || T.uniqueSort(n), N.test(i) && n.reverse()), this.pushStack(n)
        }
    });
    var H = /[^\x20\t\r\n\f]+/g;

    function $(e) {
        return e
    }

    function I(e) {
        throw e
    }

    function q(e, t, n, i) {
        var r;
        try {
            e && b(r = e.promise) ? r.call(e).done(t).fail(n) : e && b(r = e.then) ? r.call(e, t, n) : t.apply(void 0, [e].slice(i))
        } catch (e) {
            n.apply(void 0, [e])
        }
    }
    T.Callbacks = function (i) {
        var e, n;
        i = "string" == typeof i ? (e = i, n = {}, T.each(e.match(H) || [], function (e, t) {
            n[t] = !0
        }), n) : T.extend({}, i);

        function r() {
            for (a = a || i.once, s = o = !0; c.length; u = -1)
                for (t = c.shift(); ++u < l.length;) !1 === l[u].apply(t[0], t[1]) && i.stopOnFalse && (u = l.length, t = !1);
            i.memory || (t = !1), o = !1, a && (l = t ? [] : "")
        }
        var o, t, s, a, l = [],
            c = [],
            u = -1,
            d = {
                add: function () {
                    return l && (t && !o && (u = l.length - 1, c.push(t)), function n(e) {
                        T.each(e, function (e, t) {
                            b(t) ? i.unique && d.has(t) || l.push(t) : t && t.length && "string" !== p(t) && n(t)
                        })
                    }(arguments), t && !o && r()), this
                },
                remove: function () {
                    return T.each(arguments, function (e, t) {
                        for (var n; - 1 < (n = T.inArray(t, l, n));) l.splice(n, 1), n <= u && u--
                    }), this
                },
                has: function (e) {
                    return e ? -1 < T.inArray(e, l) : 0 < l.length
                },
                empty: function () {
                    return l = l && [], this
                },
                disable: function () {
                    return a = c = [], l = t = "", this
                },
                disabled: function () {
                    return !l
                },
                lock: function () {
                    return a = c = [], t || o || (l = t = ""), this
                },
                locked: function () {
                    return !!a
                },
                fireWith: function (e, t) {
                    return a || (t = [e, (t = t || []).slice ? t.slice() : t], c.push(t), o || r()), this
                },
                fire: function () {
                    return d.fireWith(this, arguments), this
                },
                fired: function () {
                    return !!s
                }
            };
        return d
    }, T.extend({
        Deferred: function (e) {
            var o = [
                    ["notify", "progress", T.Callbacks("memory"), T.Callbacks("memory"), 2],
                    ["resolve", "done", T.Callbacks("once memory"), T.Callbacks("once memory"), 0, "resolved"],
                    ["reject", "fail", T.Callbacks("once memory"), T.Callbacks("once memory"), 1, "rejected"]
                ],
                r = "pending",
                s = {
                    state: function () {
                        return r
                    },
                    always: function () {
                        return a.done(arguments).fail(arguments), this
                    },
                    catch: function (e) {
                        return s.then(null, e)
                    },
                    pipe: function () {
                        var r = arguments;
                        return T.Deferred(function (i) {
                            T.each(o, function (e, t) {
                                var n = b(r[t[4]]) && r[t[4]];
                                a[t[1]](function () {
                                    var e = n && n.apply(this, arguments);
                                    e && b(e.promise) ? e.promise().progress(i.notify).done(i.resolve).fail(i.reject) : i[t[0] + "With"](this, n ? [e] : arguments)
                                })
                            }), r = null
                        }).promise()
                    },
                    then: function (t, n, i) {
                        var l = 0;

                        function c(r, o, s, a) {
                            return function () {
                                function e() {
                                    var e, t;
                                    if (!(r < l)) {
                                        if ((e = s.apply(n, i)) === o.promise()) throw new TypeError("Thenable self-resolution");
                                        t = e && ("object" == typeof e || "function" == typeof e) && e.then, b(t) ? a ? t.call(e, c(l, o, $, a), c(l, o, I, a)) : (l++, t.call(e, c(l, o, $, a), c(l, o, I, a), c(l, o, $, o.notifyWith))) : (s !== $ && (n = void 0, i = [e]), (a || o.resolveWith)(n, i))
                                    }
                                }
                                var n = this,
                                    i = arguments,
                                    t = a ? e : function () {
                                        try {
                                            e()
                                        } catch (e) {
                                            T.Deferred.exceptionHook && T.Deferred.exceptionHook(e, t.stackTrace), l <= r + 1 && (s !== I && (n = void 0, i = [e]), o.rejectWith(n, i))
                                        }
                                    };
                                r ? t() : (T.Deferred.getStackHook && (t.stackTrace = T.Deferred.getStackHook()), x.setTimeout(t))
                            }
                        }
                        return T.Deferred(function (e) {
                            o[0][3].add(c(0, e, b(i) ? i : $, e.notifyWith)), o[1][3].add(c(0, e, b(t) ? t : $)), o[2][3].add(c(0, e, b(n) ? n : I))
                        }).promise()
                    },
                    promise: function (e) {
                        return null != e ? T.extend(e, s) : s
                    }
                },
                a = {};
            return T.each(o, function (e, t) {
                var n = t[2],
                    i = t[5];
                s[t[1]] = n.add, i && n.add(function () {
                    r = i
                }, o[3 - e][2].disable, o[3 - e][3].disable, o[0][2].lock, o[0][3].lock), n.add(t[3].fire), a[t[0]] = function () {
                    return a[t[0] + "With"](this === a ? void 0 : this, arguments), this
                }, a[t[0] + "With"] = n.fireWith
            }), s.promise(a), e && e.call(a, a), a
        },
        when: function (e) {
            function t(t) {
                return function (e) {
                    r[t] = this, o[t] = 1 < arguments.length ? a.call(arguments) : e, --n || s.resolveWith(r, o)
                }
            }
            var n = arguments.length,
                i = n,
                r = Array(i),
                o = a.call(arguments),
                s = T.Deferred();
            if (n <= 1 && (q(e, s.done(t(i)).resolve, s.reject, !n), "pending" === s.state() || b(o[i] && o[i].then))) return s.then();
            for (; i--;) q(o[i], t(i), s.reject);
            return s.promise()
        }
    });
    var M = /^(Eval|Internal|Range|Reference|Syntax|Type|URI)Error$/;
    T.Deferred.exceptionHook = function (e, t) {
        x.console && x.console.warn && e && M.test(e.name) && x.console.warn("jQuery.Deferred exception: " + e.message, e.stack, t)
    }, T.readyException = function (e) {
        x.setTimeout(function () {
            throw e
        })
    };
    var R = T.Deferred();

    function W() {
        E.removeEventListener("DOMContentLoaded", W), x.removeEventListener("load", W), T.ready()
    }
    T.fn.ready = function (e) {
        return R.then(e).catch(function (e) {
            T.readyException(e)
        }), this
    }, T.extend({
        isReady: !1,
        readyWait: 1,
        ready: function (e) {
            (!0 === e ? --T.readyWait : T.isReady) || (T.isReady = !0) !== e && 0 < --T.readyWait || R.resolveWith(E, [T])
        }
    }), T.ready.then = R.then, "complete" === E.readyState || "loading" !== E.readyState && !E.documentElement.doScroll ? x.setTimeout(T.ready) : (E.addEventListener("DOMContentLoaded", W), x.addEventListener("load", W));
    var B = function (e, t, n, i, r, o, s) {
            var a = 0,
                l = e.length,
                c = null == n;
            if ("object" === p(n))
                for (a in r = !0, n) B(e, t, a, n[a], !0, o, s);
            else if (void 0 !== i && (r = !0, b(i) || (s = !0), t = c ? s ? (t.call(e, i), null) : (c = t, function (e, t, n) {
                    return c.call(T(e), n)
                }) : t))
                for (; a < l; a++) t(e[a], n, s ? i : i.call(e[a], a, t(e[a], n)));
            return r ? e : c ? t.call(e) : l ? t(e[0], n) : o
        },
        F = /^-ms-/,
        z = /-([a-z])/g;

    function U(e, t) {
        return t.toUpperCase()
    }

    function X(e) {
        return e.replace(F, "ms-").replace(z, U)
    }

    function Y(e) {
        return 1 === e.nodeType || 9 === e.nodeType || !+e.nodeType
    }

    function V() {
        this.expando = T.expando + V.uid++
    }
    V.uid = 1, V.prototype = {
        cache: function (e) {
            var t = e[this.expando];
            return t || (t = {}, Y(e) && (e.nodeType ? e[this.expando] = t : Object.defineProperty(e, this.expando, {
                value: t,
                configurable: !0
            }))), t
        },
        set: function (e, t, n) {
            var i, r = this.cache(e);
            if ("string" == typeof t) r[X(t)] = n;
            else
                for (i in t) r[X(i)] = t[i];
            return r
        },
        get: function (e, t) {
            return void 0 === t ? this.cache(e) : e[this.expando] && e[this.expando][X(t)]
        },
        access: function (e, t, n) {
            return void 0 === t || t && "string" == typeof t && void 0 === n ? this.get(e, t) : (this.set(e, t, n), void 0 !== n ? n : t)
        },
        remove: function (e, t) {
            var n, i = e[this.expando];
            if (void 0 !== i) {
                if (void 0 !== t) {
                    n = (t = Array.isArray(t) ? t.map(X) : (t = X(t)) in i ? [t] : t.match(H) || []).length;
                    for (; n--;) delete i[t[n]]
                }
                void 0 !== t && !T.isEmptyObject(i) || (e.nodeType ? e[this.expando] = void 0 : delete e[this.expando])
            }
        },
        hasData: function (e) {
            e = e[this.expando];
            return void 0 !== e && !T.isEmptyObject(e)
        }
    };
    var K = new V,
        Q = new V,
        G = /^(?:\{[\w\W]*\}|\[[\w\W]*\])$/,
        J = /[A-Z]/g;

    function Z(e, t, n) {
        var i, r;
        if (void 0 === n && 1 === e.nodeType)
            if (i = "data-" + t.replace(J, "-$&").toLowerCase(), "string" == typeof (n = e.getAttribute(i))) {
                try {
                    n = "true" === (r = n) || "false" !== r && ("null" === r ? null : r === +r + "" ? +r : G.test(r) ? JSON.parse(r) : r)
                } catch (e) {}
                Q.set(e, t, n)
            } else n = void 0;
        return n
    }
    T.extend({
        hasData: function (e) {
            return Q.hasData(e) || K.hasData(e)
        },
        data: function (e, t, n) {
            return Q.access(e, t, n)
        },
        removeData: function (e, t) {
            Q.remove(e, t)
        },
        _data: function (e, t, n) {
            return K.access(e, t, n)
        },
        _removeData: function (e, t) {
            K.remove(e, t)
        }
    }), T.fn.extend({
        data: function (n, e) {
            var t, i, r, o = this[0],
                s = o && o.attributes;
            if (void 0 !== n) return "object" == typeof n ? this.each(function () {
                Q.set(this, n)
            }) : B(this, function (e) {
                var t;
                return o && void 0 === e ? void 0 !== (t = Q.get(o, n)) || void 0 !== (t = Z(o, n)) ? t : void 0 : void this.each(function () {
                    Q.set(this, n, e)
                })
            }, null, e, 1 < arguments.length, null, !0);
            if (this.length && (r = Q.get(o), 1 === o.nodeType && !K.get(o, "hasDataAttrs"))) {
                for (t = s.length; t--;) s[t] && 0 === (i = s[t].name).indexOf("data-") && (i = X(i.slice(5)), Z(o, i, r[i]));
                K.set(o, "hasDataAttrs", !0)
            }
            return r
        },
        removeData: function (e) {
            return this.each(function () {
                Q.remove(this, e)
            })
        }
    }), T.extend({
        queue: function (e, t, n) {
            var i;
            if (e) return i = K.get(e, t = (t || "fx") + "queue"), n && (!i || Array.isArray(n) ? i = K.access(e, t, T.makeArray(n)) : i.push(n)), i || []
        },
        dequeue: function (e, t) {
            var n = T.queue(e, t = t || "fx"),
                i = n.length,
                r = n.shift(),
                o = T._queueHooks(e, t);
            "inprogress" === r && (r = n.shift(), i--), r && ("fx" === t && n.unshift("inprogress"), delete o.stop, r.call(e, function () {
                T.dequeue(e, t)
            }, o)), !i && o && o.empty.fire()
        },
        _queueHooks: function (e, t) {
            var n = t + "queueHooks";
            return K.get(e, n) || K.access(e, n, {
                empty: T.Callbacks("once memory").add(function () {
                    K.remove(e, [t + "queue", n])
                })
            })
        }
    }), T.fn.extend({
        queue: function (t, n) {
            var e = 2;
            return "string" != typeof t && (n = t, t = "fx", e--), arguments.length < e ? T.queue(this[0], t) : void 0 === n ? this : this.each(function () {
                var e = T.queue(this, t, n);
                T._queueHooks(this, t), "fx" === t && "inprogress" !== e[0] && T.dequeue(this, t)
            })
        },
        dequeue: function (e) {
            return this.each(function () {
                T.dequeue(this, e)
            })
        },
        clearQueue: function (e) {
            return this.queue(e || "fx", [])
        },
        promise: function (e, t) {
            function n() {
                --r || o.resolveWith(s, [s])
            }
            var i, r = 1,
                o = T.Deferred(),
                s = this,
                a = this.length;
            for ("string" != typeof e && (t = e, e = void 0), e = e || "fx"; a--;)(i = K.get(s[a], e + "queueHooks")) && i.empty && (r++, i.empty.add(n));
            return n(), o.promise(t)
        }
    });
    var ee = /[+-]?(?:\d*\.|)\d+(?:[eE][+-]?\d+|)/.source,
        te = new RegExp("^(?:([+-])=|)(" + ee + ")([a-z%]*)$", "i"),
        ne = ["Top", "Right", "Bottom", "Left"],
        ie = E.documentElement,
        re = function (e) {
            return T.contains(e.ownerDocument, e)
        },
        oe = {
            composed: !0
        };
    ie.getRootNode && (re = function (e) {
        return T.contains(e.ownerDocument, e) || e.getRootNode(oe) === e.ownerDocument
    });
    var se = function (e, t) {
        return "none" === (e = t || e).style.display || "" === e.style.display && re(e) && "none" === T.css(e, "display")
    };

    function ae(e, t, n, i) {
        var r, o, s = 20,
            a = i ? function () {
                return i.cur()
            } : function () {
                return T.css(e, t, "")
            },
            l = a(),
            c = n && n[3] || (T.cssNumber[t] ? "" : "px"),
            u = e.nodeType && (T.cssNumber[t] || "px" !== c && +l) && te.exec(T.css(e, t));
        if (u && u[3] !== c) {
            for (c = c || u[3], u = +(l /= 2) || 1; s--;) T.style(e, t, u + c), (1 - o) * (1 - (o = a() / l || .5)) <= 0 && (s = 0), u /= o;
            T.style(e, t, (u *= 2) + c), n = n || []
        }
        return n && (u = +u || +l || 0, r = n[1] ? u + (n[1] + 1) * n[2] : +n[2], i && (i.unit = c, i.start = u, i.end = r)), r
    }
    var le = {};

    function ce(e, t) {
        for (var n, i, r, o, s, a = [], l = 0, c = e.length; l < c; l++)(i = e[l]).style && (n = i.style.display, t ? ("none" === n && (a[l] = K.get(i, "display") || null, a[l] || (i.style.display = "")), "" === i.style.display && se(i) && (a[l] = (s = o = void 0, o = (r = i).ownerDocument, s = r.nodeName, (r = le[s]) || (o = o.body.appendChild(o.createElement(s)), r = T.css(o, "display"), o.parentNode.removeChild(o), le[s] = r = "none" === r ? "block" : r)))) : "none" !== n && (a[l] = "none", K.set(i, "display", n)));
        for (l = 0; l < c; l++) null != a[l] && (e[l].style.display = a[l]);
        return e
    }
    T.fn.extend({
        show: function () {
            return ce(this, !0)
        },
        hide: function () {
            return ce(this)
        },
        toggle: function (e) {
            return "boolean" == typeof e ? e ? this.show() : this.hide() : this.each(function () {
                se(this) ? T(this).show() : T(this).hide()
            })
        }
    });
    var ue = /^(?:checkbox|radio)$/i,
        de = /<([a-z][^\/\0>\x20\t\r\n\f]*)/i,
        fe = /^$|^module$|\/(?:java|ecma)script/i;
    d = E.createDocumentFragment().appendChild(E.createElement("div")), (h = E.createElement("input")).setAttribute("type", "radio"), h.setAttribute("checked", "checked"), h.setAttribute("name", "t"), d.appendChild(h), y.checkClone = d.cloneNode(!0).cloneNode(!0).lastChild.checked, d.innerHTML = "<textarea>x</textarea>", y.noCloneChecked = !!d.cloneNode(!0).lastChild.defaultValue, d.innerHTML = "<option></option>", y.option = !!d.lastChild;
    var he = {
        thead: [1, "<table>", "</table>"],
        col: [2, "<table><colgroup>", "</colgroup></table>"],
        tr: [2, "<table><tbody>", "</tbody></table>"],
        td: [3, "<table><tbody><tr>", "</tr></tbody></table>"],
        _default: [0, "", ""]
    };

    function pe(e, t) {
        var n = void 0 !== e.getElementsByTagName ? e.getElementsByTagName(t || "*") : void 0 !== e.querySelectorAll ? e.querySelectorAll(t || "*") : [];
        return void 0 === t || t && k(e, t) ? T.merge([e], n) : n
    }

    function ge(e, t) {
        for (var n = 0, i = e.length; n < i; n++) K.set(e[n], "globalEval", !t || K.get(t[n], "globalEval"))
    }
    he.tbody = he.tfoot = he.colgroup = he.caption = he.thead, he.th = he.td, y.option || (he.optgroup = he.option = [1, "<select multiple='multiple'>", "</select>"]);
    var me = /<|&#?\w+;/;

    function ve(e, t, n, i, r) {
        for (var o, s, a, l, c, u = t.createDocumentFragment(), d = [], f = 0, h = e.length; f < h; f++)
            if ((o = e[f]) || 0 === o)
                if ("object" === p(o)) T.merge(d, o.nodeType ? [o] : o);
                else if (me.test(o)) {
            for (s = s || u.appendChild(t.createElement("div")), a = (de.exec(o) || ["", ""])[1].toLowerCase(), a = he[a] || he._default, s.innerHTML = a[1] + T.htmlPrefilter(o) + a[2], c = a[0]; c--;) s = s.lastChild;
            T.merge(d, s.childNodes), (s = u.firstChild).textContent = ""
        } else d.push(t.createTextNode(o));
        for (u.textContent = "", f = 0; o = d[f++];)
            if (i && -1 < T.inArray(o, i)) r && r.push(o);
            else if (l = re(o), s = pe(u.appendChild(o), "script"), l && ge(s), n)
            for (c = 0; o = s[c++];) fe.test(o.type || "") && n.push(o);
        return u
    }
    var ye = /^([^.]*)(?:\.(.+)|)/;

    function be() {
        return !0
    }

    function _e() {
        return !1
    }

    function we(e, t) {
        return e === function () {
            try {
                return E.activeElement
            } catch (e) {}
        }() == ("focus" === t)
    }

    function xe(e, t, n, i, r, o) {
        var s, a;
        if ("object" == typeof t) {
            for (a in "string" != typeof n && (i = i || n, n = void 0), t) xe(e, a, n, i, t[a], o);
            return e
        }
        if (null == i && null == r ? (r = n, i = n = void 0) : null == r && ("string" == typeof n ? (r = i, i = void 0) : (r = i, i = n, n = void 0)), !1 === r) r = _e;
        else if (!r) return e;
        return 1 === o && (s = r, (r = function (e) {
            return T().off(e), s.apply(this, arguments)
        }).guid = s.guid || (s.guid = T.guid++)), e.each(function () {
            T.event.add(this, t, r, i, n)
        })
    }

    function Ee(e, r, o) {
        o ? (K.set(e, r, !1), T.event.add(e, r, {
            namespace: !1,
            handler: function (e) {
                var t, n, i = K.get(this, r);
                if (1 & e.isTrigger && this[r]) {
                    if (i.length)(T.event.special[r] || {}).delegateType && e.stopPropagation();
                    else if (i = a.call(arguments), K.set(this, r, i), t = o(this, r), this[r](), i !== (n = K.get(this, r)) || t ? K.set(this, r, !1) : n = {}, i !== n) return e.stopImmediatePropagation(), e.preventDefault(), n && n.value
                } else i.length && (K.set(this, r, {
                    value: T.event.trigger(T.extend(i[0], T.Event.prototype), i.slice(1), this)
                }), e.stopImmediatePropagation())
            }
        })) : void 0 === K.get(e, r) && T.event.add(e, r, be)
    }
    T.event = {
        global: {},
        add: function (t, e, n, i, r) {
            var o, s, a, l, c, u, d, f, h, p = K.get(t);
            if (Y(t))
                for (n.handler && (n = (o = n).handler, r = o.selector), r && T.find.matchesSelector(ie, r), n.guid || (n.guid = T.guid++), (a = p.events) || (a = p.events = Object.create(null)), (s = p.handle) || (s = p.handle = function (e) {
                        return void 0 !== T && T.event.triggered !== e.type ? T.event.dispatch.apply(t, arguments) : void 0
                    }), l = (e = (e || "").match(H) || [""]).length; l--;) d = h = (c = ye.exec(e[l]) || [])[1], f = (c[2] || "").split(".").sort(), d && (u = T.event.special[d] || {}, d = (r ? u.delegateType : u.bindType) || d, u = T.event.special[d] || {}, c = T.extend({
                    type: d,
                    origType: h,
                    data: i,
                    handler: n,
                    guid: n.guid,
                    selector: r,
                    needsContext: r && T.expr.match.needsContext.test(r),
                    namespace: f.join(".")
                }, o), (h = a[d]) || ((h = a[d] = []).delegateCount = 0, u.setup && !1 !== u.setup.call(t, i, f, s) || t.addEventListener && t.addEventListener(d, s)), u.add && (u.add.call(t, c), c.handler.guid || (c.handler.guid = n.guid)), r ? h.splice(h.delegateCount++, 0, c) : h.push(c), T.event.global[d] = !0)
        },
        remove: function (e, t, n, i, r) {
            var o, s, a, l, c, u, d, f, h, p, g, m = K.hasData(e) && K.get(e);
            if (m && (l = m.events)) {
                for (c = (t = (t || "").match(H) || [""]).length; c--;)
                    if (h = g = (a = ye.exec(t[c]) || [])[1], p = (a[2] || "").split(".").sort(), h) {
                        for (d = T.event.special[h] || {}, f = l[h = (i ? d.delegateType : d.bindType) || h] || [], a = a[2] && new RegExp("(^|\\.)" + p.join("\\.(?:.*\\.|)") + "(\\.|$)"), s = o = f.length; o--;) u = f[o], !r && g !== u.origType || n && n.guid !== u.guid || a && !a.test(u.namespace) || i && i !== u.selector && ("**" !== i || !u.selector) || (f.splice(o, 1), u.selector && f.delegateCount--, d.remove && d.remove.call(e, u));
                        s && !f.length && (d.teardown && !1 !== d.teardown.call(e, p, m.handle) || T.removeEvent(e, h, m.handle), delete l[h])
                    } else
                        for (h in l) T.event.remove(e, h + t[c], n, i, !0);
                T.isEmptyObject(l) && K.remove(e, "handle events")
            }
        },
        dispatch: function (e) {
            var t, n, i, r, o, s = new Array(arguments.length),
                a = T.event.fix(e),
                l = (K.get(this, "events") || Object.create(null))[a.type] || [],
                e = T.event.special[a.type] || {};
            for (s[0] = a, t = 1; t < arguments.length; t++) s[t] = arguments[t];
            if (a.delegateTarget = this, !e.preDispatch || !1 !== e.preDispatch.call(this, a)) {
                for (o = T.event.handlers.call(this, a, l), t = 0;
                    (i = o[t++]) && !a.isPropagationStopped();)
                    for (a.currentTarget = i.elem, n = 0;
                        (r = i.handlers[n++]) && !a.isImmediatePropagationStopped();) a.rnamespace && !1 !== r.namespace && !a.rnamespace.test(r.namespace) || (a.handleObj = r, a.data = r.data, void 0 !== (r = ((T.event.special[r.origType] || {}).handle || r.handler).apply(i.elem, s)) && !1 === (a.result = r) && (a.preventDefault(), a.stopPropagation()));
                return e.postDispatch && e.postDispatch.call(this, a), a.result
            }
        },
        handlers: function (e, t) {
            var n, i, r, o, s, a = [],
                l = t.delegateCount,
                c = e.target;
            if (l && c.nodeType && !("click" === e.type && 1 <= e.button))
                for (; c !== this; c = c.parentNode || this)
                    if (1 === c.nodeType && ("click" !== e.type || !0 !== c.disabled)) {
                        for (o = [], s = {}, n = 0; n < l; n++) void 0 === s[r = (i = t[n]).selector + " "] && (s[r] = i.needsContext ? -1 < T(r, this).index(c) : T.find(r, this, null, [c]).length), s[r] && o.push(i);
                        o.length && a.push({
                            elem: c,
                            handlers: o
                        })
                    } return c = this, l < t.length && a.push({
                elem: c,
                handlers: t.slice(l)
            }), a
        },
        addProp: function (t, e) {
            Object.defineProperty(T.Event.prototype, t, {
                enumerable: !0,
                configurable: !0,
                get: b(e) ? function () {
                    if (this.originalEvent) return e(this.originalEvent)
                } : function () {
                    if (this.originalEvent) return this.originalEvent[t]
                },
                set: function (e) {
                    Object.defineProperty(this, t, {
                        enumerable: !0,
                        configurable: !0,
                        writable: !0,
                        value: e
                    })
                }
            })
        },
        fix: function (e) {
            return e[T.expando] ? e : new T.Event(e)
        },
        special: {
            load: {
                noBubble: !0
            },
            click: {
                setup: function (e) {
                    e = this || e;
                    return ue.test(e.type) && e.click && k(e, "input") && Ee(e, "click", be), !1
                },
                trigger: function (e) {
                    e = this || e;
                    return ue.test(e.type) && e.click && k(e, "input") && Ee(e, "click"), !0
                },
                _default: function (e) {
                    e = e.target;
                    return ue.test(e.type) && e.click && k(e, "input") && K.get(e, "click") || k(e, "a")
                }
            },
            beforeunload: {
                postDispatch: function (e) {
                    void 0 !== e.result && e.originalEvent && (e.originalEvent.returnValue = e.result)
                }
            }
        }
    }, T.removeEvent = function (e, t, n) {
        e.removeEventListener && e.removeEventListener(t, n)
    }, T.Event = function (e, t) {
        if (!(this instanceof T.Event)) return new T.Event(e, t);
        e && e.type ? (this.originalEvent = e, this.type = e.type, this.isDefaultPrevented = e.defaultPrevented || void 0 === e.defaultPrevented && !1 === e.returnValue ? be : _e, this.target = e.target && 3 === e.target.nodeType ? e.target.parentNode : e.target, this.currentTarget = e.currentTarget, this.relatedTarget = e.relatedTarget) : this.type = e, t && T.extend(this, t), this.timeStamp = e && e.timeStamp || Date.now(), this[T.expando] = !0
    }, T.Event.prototype = {
        constructor: T.Event,
        isDefaultPrevented: _e,
        isPropagationStopped: _e,
        isImmediatePropagationStopped: _e,
        isSimulated: !1,
        preventDefault: function () {
            var e = this.originalEvent;
            this.isDefaultPrevented = be, e && !this.isSimulated && e.preventDefault()
        },
        stopPropagation: function () {
            var e = this.originalEvent;
            this.isPropagationStopped = be, e && !this.isSimulated && e.stopPropagation()
        },
        stopImmediatePropagation: function () {
            var e = this.originalEvent;
            this.isImmediatePropagationStopped = be, e && !this.isSimulated && e.stopImmediatePropagation(), this.stopPropagation()
        }
    }, T.each({
        altKey: !0,
        bubbles: !0,
        cancelable: !0,
        changedTouches: !0,
        ctrlKey: !0,
        detail: !0,
        eventPhase: !0,
        metaKey: !0,
        pageX: !0,
        pageY: !0,
        shiftKey: !0,
        view: !0,
        char: !0,
        code: !0,
        charCode: !0,
        key: !0,
        keyCode: !0,
        button: !0,
        buttons: !0,
        clientX: !0,
        clientY: !0,
        offsetX: !0,
        offsetY: !0,
        pointerId: !0,
        pointerType: !0,
        screenX: !0,
        screenY: !0,
        targetTouches: !0,
        toElement: !0,
        touches: !0,
        which: !0
    }, T.event.addProp), T.each({
        focus: "focusin",
        blur: "focusout"
    }, function (e, t) {
        T.event.special[e] = {
            setup: function () {
                return Ee(this, e, we), !1
            },
            trigger: function () {
                return Ee(this, e), !0
            },
            _default: function () {
                return !0
            },
            delegateType: t
        }
    }), T.each({
        mouseenter: "mouseover",
        mouseleave: "mouseout",
        pointerenter: "pointerover",
        pointerleave: "pointerout"
    }, function (e, r) {
        T.event.special[e] = {
            delegateType: r,
            bindType: r,
            handle: function (e) {
                var t, n = e.relatedTarget,
                    i = e.handleObj;
                return n && (n === this || T.contains(this, n)) || (e.type = i.origType, t = i.handler.apply(this, arguments), e.type = r), t
            }
        }
    }), T.fn.extend({
        on: function (e, t, n, i) {
            return xe(this, e, t, n, i)
        },
        one: function (e, t, n, i) {
            return xe(this, e, t, n, i, 1)
        },
        off: function (e, t, n) {
            var i, r;
            if (e && e.preventDefault && e.handleObj) return i = e.handleObj, T(e.delegateTarget).off(i.namespace ? i.origType + "." + i.namespace : i.origType, i.selector, i.handler), this;
            if ("object" != typeof e) return !1 !== t && "function" != typeof t || (n = t, t = void 0), !1 === n && (n = _e), this.each(function () {
                T.event.remove(this, e, n, t)
            });
            for (r in e) this.off(r, t, e[r]);
            return this
        }
    });
    var Te = /<script|<style|<link/i,
        Ce = /checked\s*(?:[^=]|=\s*.checked.)/i,
        Ae = /^\s*<!(?:\[CDATA\[|--)|(?:\]\]|--)>\s*$/g;

    function ke(e, t) {
        return k(e, "table") && k(11 !== t.nodeType ? t : t.firstChild, "tr") && T(e).children("tbody")[0] || e
    }

    function Se(e) {
        return e.type = (null !== e.getAttribute("type")) + "/" + e.type, e
    }

    function De(e) {
        return "true/" === (e.type || "").slice(0, 5) ? e.type = e.type.slice(5) : e.removeAttribute("type"), e
    }

    function Le(e, t) {
        var n, i, r, o;
        if (1 === t.nodeType) {
            if (K.hasData(e) && (o = K.get(e).events))
                for (r in K.remove(t, "handle events"), o)
                    for (n = 0, i = o[r].length; n < i; n++) T.event.add(t, r, o[r][n]);
            Q.hasData(e) && (e = Q.access(e), e = T.extend({}, e), Q.set(t, e))
        }
    }

    function Oe(n, i, r, o) {
        i = m(i);
        var e, t, s, a, l, c, u = 0,
            d = n.length,
            f = d - 1,
            h = i[0],
            p = b(h);
        if (p || 1 < d && "string" == typeof h && !y.checkClone && Ce.test(h)) return n.each(function (e) {
            var t = n.eq(e);
            p && (i[0] = h.call(this, e, t.html())), Oe(t, i, r, o)
        });
        if (d && (t = (e = ve(i, n[0].ownerDocument, !1, n, o)).firstChild, 1 === e.childNodes.length && (e = t), t || o)) {
            for (a = (s = T.map(pe(e, "script"), Se)).length; u < d; u++) l = e, u !== f && (l = T.clone(l, !0, !0), a && T.merge(s, pe(l, "script"))), r.call(n[u], l, u);
            if (a)
                for (c = s[s.length - 1].ownerDocument, T.map(s, De), u = 0; u < a; u++) l = s[u], fe.test(l.type || "") && !K.access(l, "globalEval") && T.contains(c, l) && (l.src && "module" !== (l.type || "").toLowerCase() ? T._evalUrl && !l.noModule && T._evalUrl(l.src, {
                    nonce: l.nonce || l.getAttribute("nonce")
                }, c) : _(l.textContent.replace(Ae, ""), l, c))
        }
        return n
    }

    function Ne(e, t, n) {
        for (var i, r = t ? T.filter(t, e) : e, o = 0; null != (i = r[o]); o++) n || 1 !== i.nodeType || T.cleanData(pe(i)), i.parentNode && (n && re(i) && ge(pe(i, "script")), i.parentNode.removeChild(i));
        return e
    }
    T.extend({
        htmlPrefilter: function (e) {
            return e
        },
        clone: function (e, t, n) {
            var i, r, o, s, a, l, c, u = e.cloneNode(!0),
                d = re(e);
            if (!(y.noCloneChecked || 1 !== e.nodeType && 11 !== e.nodeType || T.isXMLDoc(e)))
                for (s = pe(u), i = 0, r = (o = pe(e)).length; i < r; i++) a = o[i], l = s[i], c = void 0, "input" === (c = l.nodeName.toLowerCase()) && ue.test(a.type) ? l.checked = a.checked : "input" !== c && "textarea" !== c || (l.defaultValue = a.defaultValue);
            if (t)
                if (n)
                    for (o = o || pe(e), s = s || pe(u), i = 0, r = o.length; i < r; i++) Le(o[i], s[i]);
                else Le(e, u);
            return 0 < (s = pe(u, "script")).length && ge(s, !d && pe(e, "script")), u
        },
        cleanData: function (e) {
            for (var t, n, i, r = T.event.special, o = 0; void 0 !== (n = e[o]); o++)
                if (Y(n)) {
                    if (t = n[K.expando]) {
                        if (t.events)
                            for (i in t.events) r[i] ? T.event.remove(n, i) : T.removeEvent(n, i, t.handle);
                        n[K.expando] = void 0
                    }
                    n[Q.expando] && (n[Q.expando] = void 0)
                }
        }
    }), T.fn.extend({
        detach: function (e) {
            return Ne(this, e, !0)
        },
        remove: function (e) {
            return Ne(this, e)
        },
        text: function (e) {
            return B(this, function (e) {
                return void 0 === e ? T.text(this) : this.empty().each(function () {
                    1 !== this.nodeType && 11 !== this.nodeType && 9 !== this.nodeType || (this.textContent = e)
                })
            }, null, e, arguments.length)
        },
        append: function () {
            return Oe(this, arguments, function (e) {
                1 !== this.nodeType && 11 !== this.nodeType && 9 !== this.nodeType || ke(this, e).appendChild(e)
            })
        },
        prepend: function () {
            return Oe(this, arguments, function (e) {
                var t;
                1 !== this.nodeType && 11 !== this.nodeType && 9 !== this.nodeType || (t = ke(this, e)).insertBefore(e, t.firstChild)
            })
        },
        before: function () {
            return Oe(this, arguments, function (e) {
                this.parentNode && this.parentNode.insertBefore(e, this)
            })
        },
        after: function () {
            return Oe(this, arguments, function (e) {
                this.parentNode && this.parentNode.insertBefore(e, this.nextSibling)
            })
        },
        empty: function () {
            for (var e, t = 0; null != (e = this[t]); t++) 1 === e.nodeType && (T.cleanData(pe(e, !1)), e.textContent = "");
            return this
        },
        clone: function (e, t) {
            return e = null != e && e, t = null == t ? e : t, this.map(function () {
                return T.clone(this, e, t)
            })
        },
        html: function (e) {
            return B(this, function (e) {
                var t = this[0] || {},
                    n = 0,
                    i = this.length;
                if (void 0 === e && 1 === t.nodeType) return t.innerHTML;
                if ("string" == typeof e && !Te.test(e) && !he[(de.exec(e) || ["", ""])[1].toLowerCase()]) {
                    e = T.htmlPrefilter(e);
                    try {
                        for (; n < i; n++) 1 === (t = this[n] || {}).nodeType && (T.cleanData(pe(t, !1)), t.innerHTML = e);
                        t = 0
                    } catch (e) {}
                }
                t && this.empty().append(e)
            }, null, e, arguments.length)
        },
        replaceWith: function () {
            var n = [];
            return Oe(this, arguments, function (e) {
                var t = this.parentNode;
                T.inArray(this, n) < 0 && (T.cleanData(pe(this)), t && t.replaceChild(e, this))
            }, n)
        }
    }), T.each({
        appendTo: "append",
        prependTo: "prepend",
        insertBefore: "before",
        insertAfter: "after",
        replaceAll: "replaceWith"
    }, function (e, s) {
        T.fn[e] = function (e) {
            for (var t, n = [], i = T(e), r = i.length - 1, o = 0; o <= r; o++) t = o === r ? this : this.clone(!0), T(i[o])[s](t), l.apply(n, t.get());
            return this.pushStack(n)
        }
    });

    function je(e, t, n) {
        var i, r = {};
        for (i in t) r[i] = e.style[i], e.style[i] = t[i];
        for (i in n = n.call(e), t) e.style[i] = r[i];
        return n
    }
    var Pe, He, $e, Ie, qe, Me, Re, We, Be = new RegExp("^(" + ee + ")(?!px)[a-z%]+$", "i"),
        Fe = function (e) {
            var t = e.ownerDocument.defaultView;
            return (t = !t || !t.opener ? x : t).getComputedStyle(e)
        },
        ze = new RegExp(ne.join("|"), "i");

    function Ue() {
        var e;
        We && (Re.style.cssText = "position:absolute;left:-11111px;width:60px;margin-top:1px;padding:0;border:0", We.style.cssText = "position:relative;display:block;box-sizing:border-box;overflow:scroll;margin:auto;border:1px;padding:1px;width:60%;top:1%", ie.appendChild(Re).appendChild(We), e = x.getComputedStyle(We), Pe = "1%" !== e.top, Me = 12 === Xe(e.marginLeft), We.style.right = "60%", Ie = 36 === Xe(e.right), He = 36 === Xe(e.width), We.style.position = "absolute", $e = 12 === Xe(We.offsetWidth / 3), ie.removeChild(Re), We = null)
    }

    function Xe(e) {
        return Math.round(parseFloat(e))
    }

    function Ye(e, t, n) {
        var i, r, o = e.style;
        return (n = n || Fe(e)) && ("" !== (r = n.getPropertyValue(t) || n[t]) || re(e) || (r = T.style(e, t)), !y.pixelBoxStyles() && Be.test(r) && ze.test(t) && (i = o.width, e = o.minWidth, t = o.maxWidth, o.minWidth = o.maxWidth = o.width = r, r = n.width, o.width = i, o.minWidth = e, o.maxWidth = t)), void 0 !== r ? r + "" : r
    }

    function Ve(e, t) {
        return {
            get: function () {
                if (!e()) return (this.get = t).apply(this, arguments);
                delete this.get
            }
        }
    }
    Re = E.createElement("div"), (We = E.createElement("div")).style && (We.style.backgroundClip = "content-box", We.cloneNode(!0).style.backgroundClip = "", y.clearCloneStyle = "content-box" === We.style.backgroundClip, T.extend(y, {
        boxSizingReliable: function () {
            return Ue(), He
        },
        pixelBoxStyles: function () {
            return Ue(), Ie
        },
        pixelPosition: function () {
            return Ue(), Pe
        },
        reliableMarginLeft: function () {
            return Ue(), Me
        },
        scrollboxSize: function () {
            return Ue(), $e
        },
        reliableTrDimensions: function () {
            var e, t, n;
            return null == qe && (e = E.createElement("table"), t = E.createElement("tr"), n = E.createElement("div"), e.style.cssText = "position:absolute;left:-11111px;border-collapse:separate", t.style.cssText = "border:1px solid", t.style.height = "1px", n.style.height = "9px", n.style.display = "block", ie.appendChild(e).appendChild(t).appendChild(n), n = x.getComputedStyle(t), qe = parseInt(n.height, 10) + parseInt(n.borderTopWidth, 10) + parseInt(n.borderBottomWidth, 10) === t.offsetHeight, ie.removeChild(e)), qe
        }
    }));
    var Ke = ["Webkit", "Moz", "ms"],
        Qe = E.createElement("div").style,
        Ge = {};

    function Je(e) {
        var t = T.cssProps[e] || Ge[e];
        return t || (e in Qe ? e : Ge[e] = function (e) {
            for (var t = e[0].toUpperCase() + e.slice(1), n = Ke.length; n--;)
                if ((e = Ke[n] + t) in Qe) return e
        }(e) || e)
    }
    var Ze = /^(none|table(?!-c[ea]).+)/,
        et = /^--/,
        tt = {
            position: "absolute",
            visibility: "hidden",
            display: "block"
        },
        nt = {
            letterSpacing: "0",
            fontWeight: "400"
        };

    function it(e, t, n) {
        var i = te.exec(t);
        return i ? Math.max(0, i[2] - (n || 0)) + (i[3] || "px") : t
    }

    function rt(e, t, n, i, r, o) {
        var s = "width" === t ? 1 : 0,
            a = 0,
            l = 0;
        if (n === (i ? "border" : "content")) return 0;
        for (; s < 4; s += 2) "margin" === n && (l += T.css(e, n + ne[s], !0, r)), i ? ("content" === n && (l -= T.css(e, "padding" + ne[s], !0, r)), "margin" !== n && (l -= T.css(e, "border" + ne[s] + "Width", !0, r))) : (l += T.css(e, "padding" + ne[s], !0, r), "padding" !== n ? l += T.css(e, "border" + ne[s] + "Width", !0, r) : a += T.css(e, "border" + ne[s] + "Width", !0, r));
        return !i && 0 <= o && (l += Math.max(0, Math.ceil(e["offset" + t[0].toUpperCase() + t.slice(1)] - o - l - a - .5)) || 0), l
    }

    function ot(e, t, n) {
        var i = Fe(e),
            r = (!y.boxSizingReliable() || n) && "border-box" === T.css(e, "boxSizing", !1, i),
            o = r,
            s = Ye(e, t, i),
            a = "offset" + t[0].toUpperCase() + t.slice(1);
        if (Be.test(s)) {
            if (!n) return s;
            s = "auto"
        }
        return (!y.boxSizingReliable() && r || !y.reliableTrDimensions() && k(e, "tr") || "auto" === s || !parseFloat(s) && "inline" === T.css(e, "display", !1, i)) && e.getClientRects().length && (r = "border-box" === T.css(e, "boxSizing", !1, i), (o = a in e) && (s = e[a])), (s = parseFloat(s) || 0) + rt(e, t, n || (r ? "border" : "content"), o, i, s) + "px"
    }

    function st(e, t, n, i, r) {
        return new st.prototype.init(e, t, n, i, r)
    }
    T.extend({
        cssHooks: {
            opacity: {
                get: function (e, t) {
                    if (t) {
                        e = Ye(e, "opacity");
                        return "" === e ? "1" : e
                    }
                }
            }
        },
        cssNumber: {
            animationIterationCount: !0,
            columnCount: !0,
            fillOpacity: !0,
            flexGrow: !0,
            flexShrink: !0,
            fontWeight: !0,
            gridArea: !0,
            gridColumn: !0,
            gridColumnEnd: !0,
            gridColumnStart: !0,
            gridRow: !0,
            gridRowEnd: !0,
            gridRowStart: !0,
            lineHeight: !0,
            opacity: !0,
            order: !0,
            orphans: !0,
            widows: !0,
            zIndex: !0,
            zoom: !0
        },
        cssProps: {},
        style: function (e, t, n, i) {
            if (e && 3 !== e.nodeType && 8 !== e.nodeType && e.style) {
                var r, o, s, a = X(t),
                    l = et.test(t),
                    c = e.style;
                if (l || (t = Je(a)), s = T.cssHooks[t] || T.cssHooks[a], void 0 === n) return s && "get" in s && void 0 !== (r = s.get(e, !1, i)) ? r : c[t];
                "string" === (o = typeof n) && (r = te.exec(n)) && r[1] && (n = ae(e, t, r), o = "number"), null != n && n == n && ("number" !== o || l || (n += r && r[3] || (T.cssNumber[a] ? "" : "px")), y.clearCloneStyle || "" !== n || 0 !== t.indexOf("background") || (c[t] = "inherit"), s && "set" in s && void 0 === (n = s.set(e, n, i)) || (l ? c.setProperty(t, n) : c[t] = n))
            }
        },
        css: function (e, t, n, i) {
            var r, o = X(t);
            return et.test(t) || (t = Je(o)), "normal" === (r = void 0 === (r = (o = T.cssHooks[t] || T.cssHooks[o]) && "get" in o ? o.get(e, !0, n) : r) ? Ye(e, t, i) : r) && t in nt && (r = nt[t]), "" === n || n ? (t = parseFloat(r), !0 === n || isFinite(t) ? t || 0 : r) : r
        }
    }), T.each(["height", "width"], function (e, a) {
        T.cssHooks[a] = {
            get: function (e, t, n) {
                if (t) return !Ze.test(T.css(e, "display")) || e.getClientRects().length && e.getBoundingClientRect().width ? ot(e, a, n) : je(e, tt, function () {
                    return ot(e, a, n)
                })
            },
            set: function (e, t, n) {
                var i, r = Fe(e),
                    o = !y.scrollboxSize() && "absolute" === r.position,
                    s = (o || n) && "border-box" === T.css(e, "boxSizing", !1, r),
                    n = n ? rt(e, a, n, s, r) : 0;
                return s && o && (n -= Math.ceil(e["offset" + a[0].toUpperCase() + a.slice(1)] - parseFloat(r[a]) - rt(e, a, "border", !1, r) - .5)), n && (i = te.exec(t)) && "px" !== (i[3] || "px") && (e.style[a] = t, t = T.css(e, a)), it(0, t, n)
            }
        }
    }), T.cssHooks.marginLeft = Ve(y.reliableMarginLeft, function (e, t) {
        if (t) return (parseFloat(Ye(e, "marginLeft")) || e.getBoundingClientRect().left - je(e, {
            marginLeft: 0
        }, function () {
            return e.getBoundingClientRect().left
        })) + "px"
    }), T.each({
        margin: "",
        padding: "",
        border: "Width"
    }, function (r, o) {
        T.cssHooks[r + o] = {
            expand: function (e) {
                for (var t = 0, n = {}, i = "string" == typeof e ? e.split(" ") : [e]; t < 4; t++) n[r + ne[t] + o] = i[t] || i[t - 2] || i[0];
                return n
            }
        }, "margin" !== r && (T.cssHooks[r + o].set = it)
    }), T.fn.extend({
        css: function (e, t) {
            return B(this, function (e, t, n) {
                var i, r, o = {},
                    s = 0;
                if (Array.isArray(t)) {
                    for (i = Fe(e), r = t.length; s < r; s++) o[t[s]] = T.css(e, t[s], !1, i);
                    return o
                }
                return void 0 !== n ? T.style(e, t, n) : T.css(e, t)
            }, e, t, 1 < arguments.length)
        }
    }), (T.Tween = st).prototype = {
        constructor: st,
        init: function (e, t, n, i, r, o) {
            this.elem = e, this.prop = n, this.easing = r || T.easing._default, this.options = t, this.start = this.now = this.cur(), this.end = i, this.unit = o || (T.cssNumber[n] ? "" : "px")
        },
        cur: function () {
            var e = st.propHooks[this.prop];
            return (e && e.get ? e : st.propHooks._default).get(this)
        },
        run: function (e) {
            var t, n = st.propHooks[this.prop];
            return this.options.duration ? this.pos = t = T.easing[this.easing](e, this.options.duration * e, 0, 1, this.options.duration) : this.pos = t = e, this.now = (this.end - this.start) * t + this.start, this.options.step && this.options.step.call(this.elem, this.now, this), (n && n.set ? n : st.propHooks._default).set(this), this
        }
    }, st.prototype.init.prototype = st.prototype, st.propHooks = {
        _default: {
            get: function (e) {
                return 1 !== e.elem.nodeType || null != e.elem[e.prop] && null == e.elem.style[e.prop] ? e.elem[e.prop] : (e = T.css(e.elem, e.prop, "")) && "auto" !== e ? e : 0
            },
            set: function (e) {
                T.fx.step[e.prop] ? T.fx.step[e.prop](e) : 1 !== e.elem.nodeType || !T.cssHooks[e.prop] && null == e.elem.style[Je(e.prop)] ? e.elem[e.prop] = e.now : T.style(e.elem, e.prop, e.now + e.unit)
            }
        }
    }, st.propHooks.scrollTop = st.propHooks.scrollLeft = {
        set: function (e) {
            e.elem.nodeType && e.elem.parentNode && (e.elem[e.prop] = e.now)
        }
    }, T.easing = {
        linear: function (e) {
            return e
        },
        swing: function (e) {
            return .5 - Math.cos(e * Math.PI) / 2
        },
        _default: "swing"
    }, T.fx = st.prototype.init, T.fx.step = {};
    var at, lt, ct = /^(?:toggle|show|hide)$/,
        ut = /queueHooks$/;

    function dt() {
        lt && (!1 === E.hidden && x.requestAnimationFrame ? x.requestAnimationFrame(dt) : x.setTimeout(dt, T.fx.interval), T.fx.tick())
    }

    function ft() {
        return x.setTimeout(function () {
            at = void 0
        }), at = Date.now()
    }

    function ht(e, t) {
        var n, i = 0,
            r = {
                height: e
            };
        for (t = t ? 1 : 0; i < 4; i += 2 - t) r["margin" + (n = ne[i])] = r["padding" + n] = e;
        return t && (r.opacity = r.width = e), r
    }

    function pt(e, t, n) {
        for (var i, r = (gt.tweeners[t] || []).concat(gt.tweeners["*"]), o = 0, s = r.length; o < s; o++)
            if (i = r[o].call(n, t, e)) return i
    }

    function gt(r, e, t) {
        var n, o, i = 0,
            s = gt.prefilters.length,
            a = T.Deferred().always(function () {
                delete l.elem
            }),
            l = function () {
                if (o) return !1;
                for (var e = at || ft(), e = Math.max(0, c.startTime + c.duration - e), t = 1 - (e / c.duration || 0), n = 0, i = c.tweens.length; n < i; n++) c.tweens[n].run(t);
                return a.notifyWith(r, [c, t, e]), t < 1 && i ? e : (i || a.notifyWith(r, [c, 1, 0]), a.resolveWith(r, [c]), !1)
            },
            c = a.promise({
                elem: r,
                props: T.extend({}, e),
                opts: T.extend(!0, {
                    specialEasing: {},
                    easing: T.easing._default
                }, t),
                originalProperties: e,
                originalOptions: t,
                startTime: at || ft(),
                duration: t.duration,
                tweens: [],
                createTween: function (e, t) {
                    e = T.Tween(r, c.opts, e, t, c.opts.specialEasing[e] || c.opts.easing);
                    return c.tweens.push(e), e
                },
                stop: function (e) {
                    var t = 0,
                        n = e ? c.tweens.length : 0;
                    if (o) return this;
                    for (o = !0; t < n; t++) c.tweens[t].run(1);
                    return e ? (a.notifyWith(r, [c, 1, 0]), a.resolveWith(r, [c, e])) : a.rejectWith(r, [c, e]), this
                }
            }),
            u = c.props;
        for (! function (e, t) {
                var n, i, r, o, s;
                for (n in e)
                    if (r = t[i = X(n)], o = e[n], Array.isArray(o) && (r = o[1], o = e[n] = o[0]), n !== i && (e[i] = o, delete e[n]), (s = T.cssHooks[i]) && "expand" in s)
                        for (n in o = s.expand(o), delete e[i], o) n in e || (e[n] = o[n], t[n] = r);
                    else t[i] = r
            }(u, c.opts.specialEasing); i < s; i++)
            if (n = gt.prefilters[i].call(c, r, u, c.opts)) return b(n.stop) && (T._queueHooks(c.elem, c.opts.queue).stop = n.stop.bind(n)), n;
        return T.map(u, pt, c), b(c.opts.start) && c.opts.start.call(r, c), c.progress(c.opts.progress).done(c.opts.done, c.opts.complete).fail(c.opts.fail).always(c.opts.always), T.fx.timer(T.extend(l, {
            elem: r,
            anim: c,
            queue: c.opts.queue
        })), c
    }
    T.Animation = T.extend(gt, {
        tweeners: {
            "*": [function (e, t) {
                var n = this.createTween(e, t);
                return ae(n.elem, e, te.exec(t), n), n
            }]
        },
        tweener: function (e, t) {
            for (var n, i = 0, r = (e = b(e) ? (t = e, ["*"]) : e.match(H)).length; i < r; i++) n = e[i], gt.tweeners[n] = gt.tweeners[n] || [], gt.tweeners[n].unshift(t)
        },
        prefilters: [function (e, t, n) {
            var i, r, o, s, a, l, c, u = "width" in t || "height" in t,
                d = this,
                f = {},
                h = e.style,
                p = e.nodeType && se(e),
                g = K.get(e, "fxshow");
            for (i in n.queue || (null == (s = T._queueHooks(e, "fx")).unqueued && (s.unqueued = 0, a = s.empty.fire, s.empty.fire = function () {
                    s.unqueued || a()
                }), s.unqueued++, d.always(function () {
                    d.always(function () {
                        s.unqueued--, T.queue(e, "fx").length || s.empty.fire()
                    })
                })), t)
                if (r = t[i], ct.test(r)) {
                    if (delete t[i], o = o || "toggle" === r, r === (p ? "hide" : "show")) {
                        if ("show" !== r || !g || void 0 === g[i]) continue;
                        p = !0
                    }
                    f[i] = g && g[i] || T.style(e, i)
                } if ((l = !T.isEmptyObject(t)) || !T.isEmptyObject(f))
                for (i in u && 1 === e.nodeType && (n.overflow = [h.overflow, h.overflowX, h.overflowY], null == (c = g && g.display) && (c = K.get(e, "display")), "none" === (u = T.css(e, "display")) && (c ? u = c : (ce([e], !0), c = e.style.display || c, u = T.css(e, "display"), ce([e]))), ("inline" === u || "inline-block" === u && null != c) && "none" === T.css(e, "float") && (l || (d.done(function () {
                        h.display = c
                    }), null == c && (u = h.display, c = "none" === u ? "" : u)), h.display = "inline-block")), n.overflow && (h.overflow = "hidden", d.always(function () {
                        h.overflow = n.overflow[0], h.overflowX = n.overflow[1], h.overflowY = n.overflow[2]
                    })), l = !1, f) l || (g ? "hidden" in g && (p = g.hidden) : g = K.access(e, "fxshow", {
                    display: c
                }), o && (g.hidden = !p), p && ce([e], !0), d.done(function () {
                    for (i in p || ce([e]), K.remove(e, "fxshow"), f) T.style(e, i, f[i])
                })), l = pt(p ? g[i] : 0, i, d), i in g || (g[i] = l.start, p && (l.end = l.start, l.start = 0))
        }],
        prefilter: function (e, t) {
            t ? gt.prefilters.unshift(e) : gt.prefilters.push(e)
        }
    }), T.speed = function (e, t, n) {
        var i = e && "object" == typeof e ? T.extend({}, e) : {
            complete: n || !n && t || b(e) && e,
            duration: e,
            easing: n && t || t && !b(t) && t
        };
        return T.fx.off ? i.duration = 0 : "number" != typeof i.duration && (i.duration in T.fx.speeds ? i.duration = T.fx.speeds[i.duration] : i.duration = T.fx.speeds._default), null != i.queue && !0 !== i.queue || (i.queue = "fx"), i.old = i.complete, i.complete = function () {
            b(i.old) && i.old.call(this), i.queue && T.dequeue(this, i.queue)
        }, i
    }, T.fn.extend({
        fadeTo: function (e, t, n, i) {
            return this.filter(se).css("opacity", 0).show().end().animate({
                opacity: t
            }, e, n, i)
        },
        animate: function (t, e, n, i) {
            var r = T.isEmptyObject(t),
                o = T.speed(e, n, i),
                i = function () {
                    var e = gt(this, T.extend({}, t), o);
                    (r || K.get(this, "finish")) && e.stop(!0)
                };
            return i.finish = i, r || !1 === o.queue ? this.each(i) : this.queue(o.queue, i)
        },
        stop: function (r, e, o) {
            function s(e) {
                var t = e.stop;
                delete e.stop, t(o)
            }
            return "string" != typeof r && (o = e, e = r, r = void 0), e && this.queue(r || "fx", []), this.each(function () {
                var e = !0,
                    t = null != r && r + "queueHooks",
                    n = T.timers,
                    i = K.get(this);
                if (t) i[t] && i[t].stop && s(i[t]);
                else
                    for (t in i) i[t] && i[t].stop && ut.test(t) && s(i[t]);
                for (t = n.length; t--;) n[t].elem !== this || null != r && n[t].queue !== r || (n[t].anim.stop(o), e = !1, n.splice(t, 1));
                !e && o || T.dequeue(this, r)
            })
        },
        finish: function (s) {
            return !1 !== s && (s = s || "fx"), this.each(function () {
                var e, t = K.get(this),
                    n = t[s + "queue"],
                    i = t[s + "queueHooks"],
                    r = T.timers,
                    o = n ? n.length : 0;
                for (t.finish = !0, T.queue(this, s, []), i && i.stop && i.stop.call(this, !0), e = r.length; e--;) r[e].elem === this && r[e].queue === s && (r[e].anim.stop(!0), r.splice(e, 1));
                for (e = 0; e < o; e++) n[e] && n[e].finish && n[e].finish.call(this);
                delete t.finish
            })
        }
    }), T.each(["toggle", "show", "hide"], function (e, i) {
        var r = T.fn[i];
        T.fn[i] = function (e, t, n) {
            return null == e || "boolean" == typeof e ? r.apply(this, arguments) : this.animate(ht(i, !0), e, t, n)
        }
    }), T.each({
        slideDown: ht("show"),
        slideUp: ht("hide"),
        slideToggle: ht("toggle"),
        fadeIn: {
            opacity: "show"
        },
        fadeOut: {
            opacity: "hide"
        },
        fadeToggle: {
            opacity: "toggle"
        }
    }, function (e, i) {
        T.fn[e] = function (e, t, n) {
            return this.animate(i, e, t, n)
        }
    }), T.timers = [], T.fx.tick = function () {
        var e, t = 0,
            n = T.timers;
        for (at = Date.now(); t < n.length; t++)(e = n[t])() || n[t] !== e || n.splice(t--, 1);
        n.length || T.fx.stop(), at = void 0
    }, T.fx.timer = function (e) {
        T.timers.push(e), T.fx.start()
    }, T.fx.interval = 13, T.fx.start = function () {
        lt || (lt = !0, dt())
    }, T.fx.stop = function () {
        lt = null
    }, T.fx.speeds = {
        slow: 600,
        fast: 200,
        _default: 400
    }, T.fn.delay = function (i, e) {
        return i = T.fx && T.fx.speeds[i] || i, this.queue(e = e || "fx", function (e, t) {
            var n = x.setTimeout(e, i);
            t.stop = function () {
                x.clearTimeout(n)
            }
        })
    }, d = E.createElement("input"), ee = E.createElement("select").appendChild(E.createElement("option")), d.type = "checkbox", y.checkOn = "" !== d.value, y.optSelected = ee.selected, (d = E.createElement("input")).value = "t", d.type = "radio", y.radioValue = "t" === d.value;
    var mt, vt = T.expr.attrHandle;
    T.fn.extend({
        attr: function (e, t) {
            return B(this, T.attr, e, t, 1 < arguments.length)
        },
        removeAttr: function (e) {
            return this.each(function () {
                T.removeAttr(this, e)
            })
        }
    }), T.extend({
        attr: function (e, t, n) {
            var i, r, o = e.nodeType;
            if (3 !== o && 8 !== o && 2 !== o) return void 0 === e.getAttribute ? T.prop(e, t, n) : (1 === o && T.isXMLDoc(e) || (r = T.attrHooks[t.toLowerCase()] || (T.expr.match.bool.test(t) ? mt : void 0)), void 0 !== n ? null === n ? void T.removeAttr(e, t) : r && "set" in r && void 0 !== (i = r.set(e, n, t)) ? i : (e.setAttribute(t, n + ""), n) : !(r && "get" in r && null !== (i = r.get(e, t))) && null == (i = T.find.attr(e, t)) ? void 0 : i)
        },
        attrHooks: {
            type: {
                set: function (e, t) {
                    if (!y.radioValue && "radio" === t && k(e, "input")) {
                        var n = e.value;
                        return e.setAttribute("type", t), n && (e.value = n), t
                    }
                }
            }
        },
        removeAttr: function (e, t) {
            var n, i = 0,
                r = t && t.match(H);
            if (r && 1 === e.nodeType)
                for (; n = r[i++];) e.removeAttribute(n)
        }
    }), mt = {
        set: function (e, t, n) {
            return !1 === t ? T.removeAttr(e, n) : e.setAttribute(n, n), n
        }
    }, T.each(T.expr.match.bool.source.match(/\w+/g), function (e, t) {
        var s = vt[t] || T.find.attr;
        vt[t] = function (e, t, n) {
            var i, r, o = t.toLowerCase();
            return n || (r = vt[o], vt[o] = i, i = null != s(e, t, n) ? o : null, vt[o] = r), i
        }
    });
    var yt = /^(?:input|select|textarea|button)$/i,
        bt = /^(?:a|area)$/i;

    function _t(e) {
        return (e.match(H) || []).join(" ")
    }

    function wt(e) {
        return e.getAttribute && e.getAttribute("class") || ""
    }

    function xt(e) {
        return Array.isArray(e) ? e : "string" == typeof e && e.match(H) || []
    }
    T.fn.extend({
        prop: function (e, t) {
            return B(this, T.prop, e, t, 1 < arguments.length)
        },
        removeProp: function (e) {
            return this.each(function () {
                delete this[T.propFix[e] || e]
            })
        }
    }), T.extend({
        prop: function (e, t, n) {
            var i, r, o = e.nodeType;
            if (3 !== o && 8 !== o && 2 !== o) return 1 === o && T.isXMLDoc(e) || (t = T.propFix[t] || t, r = T.propHooks[t]), void 0 !== n ? r && "set" in r && void 0 !== (i = r.set(e, n, t)) ? i : e[t] = n : r && "get" in r && null !== (i = r.get(e, t)) ? i : e[t]
        },
        propHooks: {
            tabIndex: {
                get: function (e) {
                    var t = T.find.attr(e, "tabindex");
                    return t ? parseInt(t, 10) : yt.test(e.nodeName) || bt.test(e.nodeName) && e.href ? 0 : -1
                }
            }
        },
        propFix: {
            for: "htmlFor",
            class: "className"
        }
    }), y.optSelected || (T.propHooks.selected = {
        get: function (e) {
            e = e.parentNode;
            return e && e.parentNode && e.parentNode.selectedIndex, null
        },
        set: function (e) {
            e = e.parentNode;
            e && (e.selectedIndex, e.parentNode && e.parentNode.selectedIndex)
        }
    }), T.each(["tabIndex", "readOnly", "maxLength", "cellSpacing", "cellPadding", "rowSpan", "colSpan", "useMap", "frameBorder", "contentEditable"], function () {
        T.propFix[this.toLowerCase()] = this
    }), T.fn.extend({
        addClass: function (t) {
            var e, n, i, r, o, s, a = 0;
            if (b(t)) return this.each(function (e) {
                T(this).addClass(t.call(this, e, wt(this)))
            });
            if ((e = xt(t)).length)
                for (; n = this[a++];)
                    if (s = wt(n), i = 1 === n.nodeType && " " + _t(s) + " ") {
                        for (o = 0; r = e[o++];) i.indexOf(" " + r + " ") < 0 && (i += r + " ");
                        s !== (s = _t(i)) && n.setAttribute("class", s)
                    } return this
        },
        removeClass: function (t) {
            var e, n, i, r, o, s, a = 0;
            if (b(t)) return this.each(function (e) {
                T(this).removeClass(t.call(this, e, wt(this)))
            });
            if (!arguments.length) return this.attr("class", "");
            if ((e = xt(t)).length)
                for (; n = this[a++];)
                    if (s = wt(n), i = 1 === n.nodeType && " " + _t(s) + " ") {
                        for (o = 0; r = e[o++];)
                            for (; - 1 < i.indexOf(" " + r + " ");) i = i.replace(" " + r + " ", " ");
                        s !== (s = _t(i)) && n.setAttribute("class", s)
                    } return this
        },
        toggleClass: function (r, t) {
            var o = typeof r,
                s = "string" == o || Array.isArray(r);
            return "boolean" == typeof t && s ? t ? this.addClass(r) : this.removeClass(r) : b(r) ? this.each(function (e) {
                T(this).toggleClass(r.call(this, e, wt(this), t), t)
            }) : this.each(function () {
                var e, t, n, i;
                if (s)
                    for (t = 0, n = T(this), i = xt(r); e = i[t++];) n.hasClass(e) ? n.removeClass(e) : n.addClass(e);
                else void 0 !== r && "boolean" != o || ((e = wt(this)) && K.set(this, "__className__", e), this.setAttribute && this.setAttribute("class", !e && !1 !== r && K.get(this, "__className__") || ""))
            })
        },
        hasClass: function (e) {
            for (var t, n = 0, i = " " + e + " "; t = this[n++];)
                if (1 === t.nodeType && -1 < (" " + _t(wt(t)) + " ").indexOf(i)) return !0;
            return !1
        }
    });
    var Et = /\r/g;
    T.fn.extend({
        val: function (t) {
            var n, e, i, r = this[0];
            return arguments.length ? (i = b(t), this.each(function (e) {
                1 === this.nodeType && (null == (e = i ? t.call(this, e, T(this).val()) : t) ? e = "" : "number" == typeof e ? e += "" : Array.isArray(e) && (e = T.map(e, function (e) {
                    return null == e ? "" : e + ""
                })), (n = T.valHooks[this.type] || T.valHooks[this.nodeName.toLowerCase()]) && "set" in n && void 0 !== n.set(this, e, "value") || (this.value = e))
            })) : r ? (n = T.valHooks[r.type] || T.valHooks[r.nodeName.toLowerCase()]) && "get" in n && void 0 !== (e = n.get(r, "value")) ? e : "string" == typeof (e = r.value) ? e.replace(Et, "") : null == e ? "" : e : void 0
        }
    }), T.extend({
        valHooks: {
            option: {
                get: function (e) {
                    var t = T.find.attr(e, "value");
                    return null != t ? t : _t(T.text(e))
                }
            },
            select: {
                get: function (e) {
                    for (var t, n = e.options, i = e.selectedIndex, r = "select-one" === e.type, o = r ? null : [], s = r ? i + 1 : n.length, a = i < 0 ? s : r ? i : 0; a < s; a++)
                        if (((t = n[a]).selected || a === i) && !t.disabled && (!t.parentNode.disabled || !k(t.parentNode, "optgroup"))) {
                            if (t = T(t).val(), r) return t;
                            o.push(t)
                        } return o
                },
                set: function (e, t) {
                    for (var n, i, r = e.options, o = T.makeArray(t), s = r.length; s--;)((i = r[s]).selected = -1 < T.inArray(T.valHooks.option.get(i), o)) && (n = !0);
                    return n || (e.selectedIndex = -1), o
                }
            }
        }
    }), T.each(["radio", "checkbox"], function () {
        T.valHooks[this] = {
            set: function (e, t) {
                if (Array.isArray(t)) return e.checked = -1 < T.inArray(T(e).val(), t)
            }
        }, y.checkOn || (T.valHooks[this].get = function (e) {
            return null === e.getAttribute("value") ? "on" : e.value
        })
    }), y.focusin = "onfocusin" in x;

    function Tt(e) {
        e.stopPropagation()
    }
    var Ct = /^(?:focusinfocus|focusoutblur)$/;
    T.extend(T.event, {
        trigger: function (e, t, n, i) {
            var r, o, s, a, l, c, u, d = [n || E],
                f = v.call(e, "type") ? e.type : e,
                h = v.call(e, "namespace") ? e.namespace.split(".") : [],
                p = u = o = n = n || E;
            if (3 !== n.nodeType && 8 !== n.nodeType && !Ct.test(f + T.event.triggered) && (-1 < f.indexOf(".") && (f = (h = f.split(".")).shift(), h.sort()), a = f.indexOf(":") < 0 && "on" + f, (e = e[T.expando] ? e : new T.Event(f, "object" == typeof e && e)).isTrigger = i ? 2 : 3, e.namespace = h.join("."), e.rnamespace = e.namespace ? new RegExp("(^|\\.)" + h.join("\\.(?:.*\\.|)") + "(\\.|$)") : null, e.result = void 0, e.target || (e.target = n), t = null == t ? [e] : T.makeArray(t, [e]), c = T.event.special[f] || {}, i || !c.trigger || !1 !== c.trigger.apply(n, t))) {
                if (!i && !c.noBubble && !g(n)) {
                    for (s = c.delegateType || f, Ct.test(s + f) || (p = p.parentNode); p; p = p.parentNode) d.push(p), o = p;
                    o === (n.ownerDocument || E) && d.push(o.defaultView || o.parentWindow || x)
                }
                for (r = 0;
                    (p = d[r++]) && !e.isPropagationStopped();) u = p, e.type = 1 < r ? s : c.bindType || f, (l = (K.get(p, "events") || Object.create(null))[e.type] && K.get(p, "handle")) && l.apply(p, t), (l = a && p[a]) && l.apply && Y(p) && (e.result = l.apply(p, t), !1 === e.result && e.preventDefault());
                return e.type = f, i || e.isDefaultPrevented() || c._default && !1 !== c._default.apply(d.pop(), t) || !Y(n) || a && b(n[f]) && !g(n) && ((o = n[a]) && (n[a] = null), T.event.triggered = f, e.isPropagationStopped() && u.addEventListener(f, Tt), n[f](), e.isPropagationStopped() && u.removeEventListener(f, Tt), T.event.triggered = void 0, o && (n[a] = o)), e.result
            }
        },
        simulate: function (e, t, n) {
            e = T.extend(new T.Event, n, {
                type: e,
                isSimulated: !0
            });
            T.event.trigger(e, null, t)
        }
    }), T.fn.extend({
        trigger: function (e, t) {
            return this.each(function () {
                T.event.trigger(e, t, this)
            })
        },
        triggerHandler: function (e, t) {
            var n = this[0];
            if (n) return T.event.trigger(e, t, n, !0)
        }
    }), y.focusin || T.each({
        focus: "focusin",
        blur: "focusout"
    }, function (n, i) {
        function r(e) {
            T.event.simulate(i, e.target, T.event.fix(e))
        }
        T.event.special[i] = {
            setup: function () {
                var e = this.ownerDocument || this.document || this,
                    t = K.access(e, i);
                t || e.addEventListener(n, r, !0), K.access(e, i, (t || 0) + 1)
            },
            teardown: function () {
                var e = this.ownerDocument || this.document || this,
                    t = K.access(e, i) - 1;
                t ? K.access(e, i, t) : (e.removeEventListener(n, r, !0), K.remove(e, i))
            }
        }
    });
    var At = x.location,
        kt = {
            guid: Date.now()
        },
        St = /\?/;
    T.parseXML = function (e) {
        var t, n;
        if (!e || "string" != typeof e) return null;
        try {
            t = (new x.DOMParser).parseFromString(e, "text/xml")
        } catch (e) {}
        return n = t && t.getElementsByTagName("parsererror")[0], t && !n || T.error("Invalid XML: " + (n ? T.map(n.childNodes, function (e) {
            return e.textContent
        }).join("\n") : e)), t
    };
    var Dt = /\[\]$/,
        Lt = /\r?\n/g,
        Ot = /^(?:submit|button|image|reset|file)$/i,
        Nt = /^(?:input|select|textarea|keygen)/i;
    T.param = function (e, t) {
        function n(e, t) {
            t = b(t) ? t() : t, r[r.length] = encodeURIComponent(e) + "=" + encodeURIComponent(null == t ? "" : t)
        }
        var i, r = [];
        if (null == e) return "";
        if (Array.isArray(e) || e.jquery && !T.isPlainObject(e)) T.each(e, function () {
            n(this.name, this.value)
        });
        else
            for (i in e) ! function n(i, e, r, o) {
                if (Array.isArray(e)) T.each(e, function (e, t) {
                    r || Dt.test(i) ? o(i, t) : n(i + "[" + ("object" == typeof t && null != t ? e : "") + "]", t, r, o)
                });
                else if (r || "object" !== p(e)) o(i, e);
                else
                    for (var t in e) n(i + "[" + t + "]", e[t], r, o)
            }(i, e[i], t, n);
        return r.join("&")
    }, T.fn.extend({
        serialize: function () {
            return T.param(this.serializeArray())
        },
        serializeArray: function () {
            return this.map(function () {
                var e = T.prop(this, "elements");
                return e ? T.makeArray(e) : this
            }).filter(function () {
                var e = this.type;
                return this.name && !T(this).is(":disabled") && Nt.test(this.nodeName) && !Ot.test(e) && (this.checked || !ue.test(e))
            }).map(function (e, t) {
                var n = T(this).val();
                return null == n ? null : Array.isArray(n) ? T.map(n, function (e) {
                    return {
                        name: t.name,
                        value: e.replace(Lt, "\r\n")
                    }
                }) : {
                    name: t.name,
                    value: n.replace(Lt, "\r\n")
                }
            }).get()
        }
    });
    var jt = /%20/g,
        Pt = /#.*$/,
        Ht = /([?&])_=[^&]*/,
        $t = /^(.*?):[ \t]*([^\r\n]*)$/gm,
        It = /^(?:GET|HEAD)$/,
        qt = /^\/\//,
        Mt = {},
        Rt = {},
        Wt = "*/".concat("*"),
        Bt = E.createElement("a");

    function Ft(o) {
        return function (e, t) {
            "string" != typeof e && (t = e, e = "*");
            var n, i = 0,
                r = e.toLowerCase().match(H) || [];
            if (b(t))
                for (; n = r[i++];) "+" === n[0] ? (n = n.slice(1) || "*", (o[n] = o[n] || []).unshift(t)) : (o[n] = o[n] || []).push(t)
        }
    }

    function zt(t, i, r, o) {
        var s = {},
            a = t === Rt;

        function l(e) {
            var n;
            return s[e] = !0, T.each(t[e] || [], function (e, t) {
                t = t(i, r, o);
                return "string" != typeof t || a || s[t] ? a ? !(n = t) : void 0 : (i.dataTypes.unshift(t), l(t), !1)
            }), n
        }
        return l(i.dataTypes[0]) || !s["*"] && l("*")
    }

    function Ut(e, t) {
        var n, i, r = T.ajaxSettings.flatOptions || {};
        for (n in t) void 0 !== t[n] && ((r[n] ? e : i = i || {})[n] = t[n]);
        return i && T.extend(!0, e, i), e
    }
    Bt.href = At.href, T.extend({
        active: 0,
        lastModified: {},
        etag: {},
        ajaxSettings: {
            url: At.href,
            type: "GET",
            isLocal: /^(?:about|app|app-storage|.+-extension|file|res|widget):$/.test(At.protocol),
            global: !0,
            processData: !0,
            async: !0,
            contentType: "application/x-www-form-urlencoded; charset=UTF-8",
            accepts: {
                "*": Wt,
                text: "text/plain",
                html: "text/html",
                xml: "application/xml, text/xml",
                json: "application/json, text/javascript"
            },
            contents: {
                xml: /\bxml\b/,
                html: /\bhtml/,
                json: /\bjson\b/
            },
            responseFields: {
                xml: "responseXML",
                text: "responseText",
                json: "responseJSON"
            },
            converters: {
                "* text": String,
                "text html": !0,
                "text json": JSON.parse,
                "text xml": T.parseXML
            },
            flatOptions: {
                url: !0,
                context: !0
            }
        },
        ajaxSetup: function (e, t) {
            return t ? Ut(Ut(e, T.ajaxSettings), t) : Ut(T.ajaxSettings, e)
        },
        ajaxPrefilter: Ft(Mt),
        ajaxTransport: Ft(Rt),
        ajax: function (e, t) {
            "object" == typeof e && (t = e, e = void 0);
            var l, c, u, n, d, f, h, i, r, p = T.ajaxSetup({}, t = t || {}),
                g = p.context || p,
                m = p.context && (g.nodeType || g.jquery) ? T(g) : T.event,
                v = T.Deferred(),
                y = T.Callbacks("once memory"),
                b = p.statusCode || {},
                o = {},
                s = {},
                a = "canceled",
                _ = {
                    readyState: 0,
                    getResponseHeader: function (e) {
                        var t;
                        if (f) {
                            if (!n)
                                for (n = {}; t = $t.exec(u);) n[t[1].toLowerCase() + " "] = (n[t[1].toLowerCase() + " "] || []).concat(t[2]);
                            t = n[e.toLowerCase() + " "]
                        }
                        return null == t ? null : t.join(", ")
                    },
                    getAllResponseHeaders: function () {
                        return f ? u : null
                    },
                    setRequestHeader: function (e, t) {
                        return null == f && (e = s[e.toLowerCase()] = s[e.toLowerCase()] || e, o[e] = t), this
                    },
                    overrideMimeType: function (e) {
                        return null == f && (p.mimeType = e), this
                    },
                    statusCode: function (e) {
                        if (e)
                            if (f) _.always(e[_.status]);
                            else
                                for (var t in e) b[t] = [b[t], e[t]];
                        return this
                    },
                    abort: function (e) {
                        e = e || a;
                        return l && l.abort(e), w(0, e), this
                    }
                };
            if (v.promise(_), p.url = ((e || p.url || At.href) + "").replace(qt, At.protocol + "//"), p.type = t.method || t.type || p.method || p.type, p.dataTypes = (p.dataType || "*").toLowerCase().match(H) || [""], null == p.crossDomain) {
                r = E.createElement("a");
                try {
                    r.href = p.url, r.href = r.href, p.crossDomain = Bt.protocol + "//" + Bt.host != r.protocol + "//" + r.host
                } catch (e) {
                    p.crossDomain = !0
                }
            }
            if (p.data && p.processData && "string" != typeof p.data && (p.data = T.param(p.data, p.traditional)), zt(Mt, p, t, _), f) return _;
            for (i in (h = T.event && p.global) && 0 == T.active++ && T.event.trigger("ajaxStart"), p.type = p.type.toUpperCase(), p.hasContent = !It.test(p.type), c = p.url.replace(Pt, ""), p.hasContent ? p.data && p.processData && 0 === (p.contentType || "").indexOf("application/x-www-form-urlencoded") && (p.data = p.data.replace(jt, "+")) : (r = p.url.slice(c.length), p.data && (p.processData || "string" == typeof p.data) && (c += (St.test(c) ? "&" : "?") + p.data, delete p.data), !1 === p.cache && (c = c.replace(Ht, "$1"), r = (St.test(c) ? "&" : "?") + "_=" + kt.guid++ + r), p.url = c + r), p.ifModified && (T.lastModified[c] && _.setRequestHeader("If-Modified-Since", T.lastModified[c]), T.etag[c] && _.setRequestHeader("If-None-Match", T.etag[c])), (p.data && p.hasContent && !1 !== p.contentType || t.contentType) && _.setRequestHeader("Content-Type", p.contentType), _.setRequestHeader("Accept", p.dataTypes[0] && p.accepts[p.dataTypes[0]] ? p.accepts[p.dataTypes[0]] + ("*" !== p.dataTypes[0] ? ", " + Wt + "; q=0.01" : "") : p.accepts["*"]), p.headers) _.setRequestHeader(i, p.headers[i]);
            if (p.beforeSend && (!1 === p.beforeSend.call(g, _, p) || f)) return _.abort();
            if (a = "abort", y.add(p.complete), _.done(p.success), _.fail(p.error), l = zt(Rt, p, t, _)) {
                if (_.readyState = 1, h && m.trigger("ajaxSend", [_, p]), f) return _;
                p.async && 0 < p.timeout && (d = x.setTimeout(function () {
                    _.abort("timeout")
                }, p.timeout));
                try {
                    f = !1, l.send(o, w)
                } catch (e) {
                    if (f) throw e;
                    w(-1, e)
                }
            } else w(-1, "No Transport");

            function w(e, t, n, i) {
                var r, o, s, a = t;
                f || (f = !0, d && x.clearTimeout(d), l = void 0, u = i || "", _.readyState = 0 < e ? 4 : 0, i = 200 <= e && e < 300 || 304 === e, n && (s = function (e, t, n) {
                    for (var i, r, o, s, a = e.contents, l = e.dataTypes;
                        "*" === l[0];) l.shift(), void 0 === i && (i = e.mimeType || t.getResponseHeader("Content-Type"));
                    if (i)
                        for (r in a)
                            if (a[r] && a[r].test(i)) {
                                l.unshift(r);
                                break
                            } if (l[0] in n) o = l[0];
                    else {
                        for (r in n) {
                            if (!l[0] || e.converters[r + " " + l[0]]) {
                                o = r;
                                break
                            }
                            s = s || r
                        }
                        o = o || s
                    }
                    if (o) return o !== l[0] && l.unshift(o), n[o]
                }(p, _, n)), !i && -1 < T.inArray("script", p.dataTypes) && T.inArray("json", p.dataTypes) < 0 && (p.converters["text script"] = function () {}), s = function (e, t, n, i) {
                    var r, o, s, a, l, c = {},
                        u = e.dataTypes.slice();
                    if (u[1])
                        for (s in e.converters) c[s.toLowerCase()] = e.converters[s];
                    for (o = u.shift(); o;)
                        if (e.responseFields[o] && (n[e.responseFields[o]] = t), !l && i && e.dataFilter && (t = e.dataFilter(t, e.dataType)), l = o, o = u.shift())
                            if ("*" === o) o = l;
                            else if ("*" !== l && l !== o) {
                        if (!(s = c[l + " " + o] || c["* " + o]))
                            for (r in c)
                                if (a = r.split(" "), a[1] === o && (s = c[l + " " + a[0]] || c["* " + a[0]])) {
                                    !0 === s ? s = c[r] : !0 !== c[r] && (o = a[0], u.unshift(a[1]));
                                    break
                                } if (!0 !== s)
                            if (s && e.throws) t = s(t);
                            else try {
                                t = s(t)
                            } catch (e) {
                                return {
                                    state: "parsererror",
                                    error: s ? e : "No conversion from " + l + " to " + o
                                }
                            }
                    }
                    return {
                        state: "success",
                        data: t
                    }
                }(p, s, _, i), i ? (p.ifModified && ((n = _.getResponseHeader("Last-Modified")) && (T.lastModified[c] = n), (n = _.getResponseHeader("etag")) && (T.etag[c] = n)), 204 === e || "HEAD" === p.type ? a = "nocontent" : 304 === e ? a = "notmodified" : (a = s.state, r = s.data, i = !(o = s.error))) : (o = a, !e && a || (a = "error", e < 0 && (e = 0))), _.status = e, _.statusText = (t || a) + "", i ? v.resolveWith(g, [r, a, _]) : v.rejectWith(g, [_, a, o]), _.statusCode(b), b = void 0, h && m.trigger(i ? "ajaxSuccess" : "ajaxError", [_, p, i ? r : o]), y.fireWith(g, [_, a]), h && (m.trigger("ajaxComplete", [_, p]), --T.active || T.event.trigger("ajaxStop")))
            }
            return _
        },
        getJSON: function (e, t, n) {
            return T.get(e, t, n, "json")
        },
        getScript: function (e, t) {
            return T.get(e, void 0, t, "script")
        }
    }), T.each(["get", "post"], function (e, r) {
        T[r] = function (e, t, n, i) {
            return b(t) && (i = i || n, n = t, t = void 0), T.ajax(T.extend({
                url: e,
                type: r,
                dataType: i,
                data: t,
                success: n
            }, T.isPlainObject(e) && e))
        }
    }), T.ajaxPrefilter(function (e) {
        for (var t in e.headers) "content-type" === t.toLowerCase() && (e.contentType = e.headers[t] || "")
    }), T._evalUrl = function (e, t, n) {
        return T.ajax({
            url: e,
            type: "GET",
            dataType: "script",
            cache: !0,
            async: !1,
            global: !1,
            converters: {
                "text script": function () {}
            },
            dataFilter: function (e) {
                T.globalEval(e, t, n)
            }
        })
    }, T.fn.extend({
        wrapAll: function (e) {
            return this[0] && (b(e) && (e = e.call(this[0])), e = T(e, this[0].ownerDocument).eq(0).clone(!0), this[0].parentNode && e.insertBefore(this[0]), e.map(function () {
                for (var e = this; e.firstElementChild;) e = e.firstElementChild;
                return e
            }).append(this)), this
        },
        wrapInner: function (n) {
            return b(n) ? this.each(function (e) {
                T(this).wrapInner(n.call(this, e))
            }) : this.each(function () {
                var e = T(this),
                    t = e.contents();
                t.length ? t.wrapAll(n) : e.append(n)
            })
        },
        wrap: function (t) {
            var n = b(t);
            return this.each(function (e) {
                T(this).wrapAll(n ? t.call(this, e) : t)
            })
        },
        unwrap: function (e) {
            return this.parent(e).not("body").each(function () {
                T(this).replaceWith(this.childNodes)
            }), this
        }
    }), T.expr.pseudos.hidden = function (e) {
        return !T.expr.pseudos.visible(e)
    }, T.expr.pseudos.visible = function (e) {
        return !!(e.offsetWidth || e.offsetHeight || e.getClientRects().length)
    }, T.ajaxSettings.xhr = function () {
        try {
            return new x.XMLHttpRequest
        } catch (e) {}
    };
    var Xt = {
            0: 200,
            1223: 204
        },
        Yt = T.ajaxSettings.xhr();
    y.cors = !!Yt && "withCredentials" in Yt, y.ajax = Yt = !!Yt, T.ajaxTransport(function (r) {
        var o, s;
        if (y.cors || Yt && !r.crossDomain) return {
            send: function (e, t) {
                var n, i = r.xhr();
                if (i.open(r.type, r.url, r.async, r.username, r.password), r.xhrFields)
                    for (n in r.xhrFields) i[n] = r.xhrFields[n];
                for (n in r.mimeType && i.overrideMimeType && i.overrideMimeType(r.mimeType), r.crossDomain || e["X-Requested-With"] || (e["X-Requested-With"] = "XMLHttpRequest"), e) i.setRequestHeader(n, e[n]);
                o = function (e) {
                    return function () {
                        o && (o = s = i.onload = i.onerror = i.onabort = i.ontimeout = i.onreadystatechange = null, "abort" === e ? i.abort() : "error" === e ? "number" != typeof i.status ? t(0, "error") : t(i.status, i.statusText) : t(Xt[i.status] || i.status, i.statusText, "text" !== (i.responseType || "text") || "string" != typeof i.responseText ? {
                            binary: i.response
                        } : {
                            text: i.responseText
                        }, i.getAllResponseHeaders()))
                    }
                }, i.onload = o(), s = i.onerror = i.ontimeout = o("error"), void 0 !== i.onabort ? i.onabort = s : i.onreadystatechange = function () {
                    4 === i.readyState && x.setTimeout(function () {
                        o && s()
                    })
                }, o = o("abort");
                try {
                    i.send(r.hasContent && r.data || null)
                } catch (e) {
                    if (o) throw e
                }
            },
            abort: function () {
                o && o()
            }
        }
    }), T.ajaxPrefilter(function (e) {
        e.crossDomain && (e.contents.script = !1)
    }), T.ajaxSetup({
        accepts: {
            script: "text/javascript, application/javascript, application/ecmascript, application/x-ecmascript"
        },
        contents: {
            script: /\b(?:java|ecma)script\b/
        },
        converters: {
            "text script": function (e) {
                return T.globalEval(e), e
            }
        }
    }), T.ajaxPrefilter("script", function (e) {
        void 0 === e.cache && (e.cache = !1), e.crossDomain && (e.type = "GET")
    }), T.ajaxTransport("script", function (n) {
        var i, r;
        if (n.crossDomain || n.scriptAttrs) return {
            send: function (e, t) {
                i = T("<script>").attr(n.scriptAttrs || {}).prop({
                    charset: n.scriptCharset,
                    src: n.url
                }).on("load error", r = function (e) {
                    i.remove(), r = null, e && t("error" === e.type ? 404 : 200, e.type)
                }), E.head.appendChild(i[0])
            },
            abort: function () {
                r && r()
            }
        }
    });
    var Vt = [],
        Kt = /(=)\?(?=&|$)|\?\?/;
    T.ajaxSetup({
        jsonp: "callback",
        jsonpCallback: function () {
            var e = Vt.pop() || T.expando + "_" + kt.guid++;
            return this[e] = !0, e
        }
    }), T.ajaxPrefilter("json jsonp", function (e, t, n) {
        var i, r, o, s = !1 !== e.jsonp && (Kt.test(e.url) ? "url" : "string" == typeof e.data && 0 === (e.contentType || "").indexOf("application/x-www-form-urlencoded") && Kt.test(e.data) && "data");
        if (s || "jsonp" === e.dataTypes[0]) return i = e.jsonpCallback = b(e.jsonpCallback) ? e.jsonpCallback() : e.jsonpCallback, s ? e[s] = e[s].replace(Kt, "$1" + i) : !1 !== e.jsonp && (e.url += (St.test(e.url) ? "&" : "?") + e.jsonp + "=" + i), e.converters["script json"] = function () {
            return o || T.error(i + " was not called"), o[0]
        }, e.dataTypes[0] = "json", r = x[i], x[i] = function () {
            o = arguments
        }, n.always(function () {
            void 0 === r ? T(x).removeProp(i) : x[i] = r, e[i] && (e.jsonpCallback = t.jsonpCallback, Vt.push(i)), o && b(r) && r(o[0]), o = r = void 0
        }), "script"
    }), y.createHTMLDocument = ((d = E.implementation.createHTMLDocument("").body).innerHTML = "<form></form><form></form>", 2 === d.childNodes.length), T.parseHTML = function (e, t, n) {
        return "string" != typeof e ? [] : ("boolean" == typeof t && (n = t, t = !1), t || (y.createHTMLDocument ? ((i = (t = E.implementation.createHTMLDocument("")).createElement("base")).href = E.location.href, t.head.appendChild(i)) : t = E), i = !n && [], (n = S.exec(e)) ? [t.createElement(n[1])] : (n = ve([e], t, i), i && i.length && T(i).remove(), T.merge([], n.childNodes)));
        var i
    }, T.fn.load = function (e, t, n) {
        var i, r, o, s = this,
            a = e.indexOf(" ");
        return -1 < a && (i = _t(e.slice(a)), e = e.slice(0, a)), b(t) ? (n = t, t = void 0) : t && "object" == typeof t && (r = "POST"), 0 < s.length && T.ajax({
            url: e,
            type: r || "GET",
            dataType: "html",
            data: t
        }).done(function (e) {
            o = arguments, s.html(i ? T("<div>").append(T.parseHTML(e)).find(i) : e)
        }).always(n && function (e, t) {
            s.each(function () {
                n.apply(this, o || [e.responseText, t, e])
            })
        }), this
    }, T.expr.pseudos.animated = function (t) {
        return T.grep(T.timers, function (e) {
            return t === e.elem
        }).length
    }, T.offset = {
        setOffset: function (e, t, n) {
            var i, r, o, s, a = T.css(e, "position"),
                l = T(e),
                c = {};
            "static" === a && (e.style.position = "relative"), o = l.offset(), i = T.css(e, "top"), s = T.css(e, "left"), s = ("absolute" === a || "fixed" === a) && -1 < (i + s).indexOf("auto") ? (r = (a = l.position()).top, a.left) : (r = parseFloat(i) || 0, parseFloat(s) || 0), null != (t = b(t) ? t.call(e, n, T.extend({}, o)) : t).top && (c.top = t.top - o.top + r), null != t.left && (c.left = t.left - o.left + s), "using" in t ? t.using.call(e, c) : l.css(c)
        }
    }, T.fn.extend({
        offset: function (t) {
            if (arguments.length) return void 0 === t ? this : this.each(function (e) {
                T.offset.setOffset(this, t, e)
            });
            var e, n = this[0];
            return n ? n.getClientRects().length ? (e = n.getBoundingClientRect(), n = n.ownerDocument.defaultView, {
                top: e.top + n.pageYOffset,
                left: e.left + n.pageXOffset
            }) : {
                top: 0,
                left: 0
            } : void 0
        },
        position: function () {
            if (this[0]) {
                var e, t, n, i = this[0],
                    r = {
                        top: 0,
                        left: 0
                    };
                if ("fixed" === T.css(i, "position")) t = i.getBoundingClientRect();
                else {
                    for (t = this.offset(), n = i.ownerDocument, e = i.offsetParent || n.documentElement; e && (e === n.body || e === n.documentElement) && "static" === T.css(e, "position");) e = e.parentNode;
                    e && e !== i && 1 === e.nodeType && ((r = T(e).offset()).top += T.css(e, "borderTopWidth", !0), r.left += T.css(e, "borderLeftWidth", !0))
                }
                return {
                    top: t.top - r.top - T.css(i, "marginTop", !0),
                    left: t.left - r.left - T.css(i, "marginLeft", !0)
                }
            }
        },
        offsetParent: function () {
            return this.map(function () {
                for (var e = this.offsetParent; e && "static" === T.css(e, "position");) e = e.offsetParent;
                return e || ie
            })
        }
    }), T.each({
        scrollLeft: "pageXOffset",
        scrollTop: "pageYOffset"
    }, function (t, r) {
        var o = "pageYOffset" === r;
        T.fn[t] = function (e) {
            return B(this, function (e, t, n) {
                var i;
                return g(e) ? i = e : 9 === e.nodeType && (i = e.defaultView), void 0 === n ? i ? i[r] : e[t] : void(i ? i.scrollTo(o ? i.pageXOffset : n, o ? n : i.pageYOffset) : e[t] = n)
            }, t, e, arguments.length)
        }
    }), T.each(["top", "left"], function (e, n) {
        T.cssHooks[n] = Ve(y.pixelPosition, function (e, t) {
            if (t) return t = Ye(e, n), Be.test(t) ? T(e).position()[n] + "px" : t
        })
    }), T.each({
        Height: "height",
        Width: "width"
    }, function (s, a) {
        T.each({
            padding: "inner" + s,
            content: a,
            "": "outer" + s
        }, function (i, o) {
            T.fn[o] = function (e, t) {
                var n = arguments.length && (i || "boolean" != typeof e),
                    r = i || (!0 === e || !0 === t ? "margin" : "border");
                return B(this, function (e, t, n) {
                    var i;
                    return g(e) ? 0 === o.indexOf("outer") ? e["inner" + s] : e.document.documentElement["client" + s] : 9 === e.nodeType ? (i = e.documentElement, Math.max(e.body["scroll" + s], i["scroll" + s], e.body["offset" + s], i["offset" + s], i["client" + s])) : void 0 === n ? T.css(e, t, r) : T.style(e, t, n, r)
                }, a, n ? e : void 0, n)
            }
        })
    }), T.each(["ajaxStart", "ajaxStop", "ajaxComplete", "ajaxError", "ajaxSuccess", "ajaxSend"], function (e, t) {
        T.fn[t] = function (e) {
            return this.on(t, e)
        }
    }), T.fn.extend({
        bind: function (e, t, n) {
            return this.on(e, null, t, n)
        },
        unbind: function (e, t) {
            return this.off(e, null, t)
        },
        delegate: function (e, t, n, i) {
            return this.on(t, e, n, i)
        },
        undelegate: function (e, t, n) {
            return 1 === arguments.length ? this.off(e, "**") : this.off(t, e || "**", n)
        },
        hover: function (e, t) {
            return this.mouseenter(e).mouseleave(t || e)
        }
    }), T.each("blur focus focusin focusout resize scroll click dblclick mousedown mouseup mousemove mouseover mouseout mouseenter mouseleave change select submit keydown keypress keyup contextmenu".split(" "), function (e, n) {
        T.fn[n] = function (e, t) {
            return 0 < arguments.length ? this.on(n, null, e, t) : this.trigger(n)
        }
    });
    var Qt = /^[\s\uFEFF\xA0]+|[\s\uFEFF\xA0]+$/g;
    T.proxy = function (e, t) {
        var n, i;
        if ("string" == typeof t && (i = e[t], t = e, e = i), b(e)) return n = a.call(arguments, 2), (i = function () {
            return e.apply(t || this, n.concat(a.call(arguments)))
        }).guid = e.guid = e.guid || T.guid++, i
    }, T.holdReady = function (e) {
        e ? T.readyWait++ : T.ready(!0)
    }, T.isArray = Array.isArray, T.parseJSON = JSON.parse, T.nodeName = k, T.isFunction = b, T.isWindow = g, T.camelCase = X, T.type = p, T.now = Date.now, T.isNumeric = function (e) {
        var t = T.type(e);
        return ("number" === t || "string" === t) && !isNaN(e - parseFloat(e))
    }, T.trim = function (e) {
        return null == e ? "" : (e + "").replace(Qt, "")
    }, "function" == typeof define && define.amd && define("jquery", [], function () {
        return T
    });
    var Gt = x.jQuery,
        Jt = x.$;
    return T.noConflict = function (e) {
        return x.$ === T && (x.$ = Jt), e && x.jQuery === T && (x.jQuery = Gt), T
    }, void 0 === e && (x.jQuery = x.$ = T), T
}),
function (e, t) {
    "object" == typeof exports && "undefined" != typeof module ? module.exports = t() : "function" == typeof define && define.amd ? define(t) : (e = "undefined" != typeof globalThis ? globalThis : e || self).bootstrap = t()
}(this, function () {
    "use strict";
    const i = "transitionend",
        s = e => {
            for (; e += Math.floor(1e6 * Math.random()), document.getElementById(e););
            return e
        },
        t = t => {
            let n = t.getAttribute("data-bs-target");
            if (!n || "#" === n) {
                let e = t.getAttribute("href");
                if (!e || !e.includes("#") && !e.startsWith(".")) return null;
                e.includes("#") && !e.startsWith("#") && (e = "#" + e.split("#")[1]), n = e && "#" !== e ? e.trim() : null
            }
            return n
        },
        a = e => {
            e = t(e);
            return e && document.querySelector(e) ? e : null
        },
        r = e => {
            e = t(e);
            return e ? document.querySelector(e) : null
        },
        u = e => {
            if (!e) return 0;
            let {
                transitionDuration: t,
                transitionDelay: n
            } = window.getComputedStyle(e);
            var i = Number.parseFloat(t),
                e = Number.parseFloat(n);
            return i || e ? (t = t.split(",")[0], n = n.split(",")[0], 1e3 * (Number.parseFloat(t) + Number.parseFloat(n))) : 0
        },
        o = e => {
            e.dispatchEvent(new Event(i))
        },
        l = e => (e[0] || e).nodeType,
        d = (t, e) => {
            let n = !1;
            e += 5;
            t.addEventListener(i, function e() {
                n = !0, t.removeEventListener(i, e)
            }), setTimeout(() => {
                n || o(t)
            }, e)
        },
        n = (r, o, s) => {
            Object.keys(s).forEach(e => {
                var t, n = s[e],
                    i = o[e],
                    t = i && l(i) ? "element" : null == (t = i) ? `${t}` : {}.toString.call(t).match(/\s([a-z]+)/i)[1].toLowerCase();
                if (!new RegExp(n).test(t)) throw new TypeError(`${r.toUpperCase()}: ` + `Option "${e}" provided type "${t}" ` + `but expected type "${n}".`)
            })
        },
        c = e => {
            if (!e) return !1;
            if (e.style && e.parentNode && e.parentNode.style) {
                var t = getComputedStyle(e),
                    e = getComputedStyle(e.parentNode);
                return "none" !== t.display && "none" !== e.display && "hidden" !== t.visibility
            }
            return !1
        },
        f = e => !e || e.nodeType !== Node.ELEMENT_NODE || (!!e.classList.contains("disabled") || (void 0 !== e.disabled ? e.disabled : e.hasAttribute("disabled") && "false" !== e.getAttribute("disabled"))),
        h = e => {
            if (!document.documentElement.attachShadow) return null;
            if ("function" != typeof e.getRootNode) return e instanceof ShadowRoot ? e : e.parentNode ? h(e.parentNode) : null;
            e = e.getRootNode();
            return e instanceof ShadowRoot ? e : null
        },
        p = () => function () {},
        g = e => e.offsetHeight,
        m = () => {
            var {
                jQuery: e
            } = window;
            return e && !document.body.hasAttribute("data-bs-no-jquery") ? e : null
        },
        v = () => "rtl" === document.documentElement.dir;
    var e = (n, i) => {
        var e;
        e = () => {
            const e = m();
            if (e) {
                const t = e.fn[n];
                e.fn[n] = i.jQueryInterface, e.fn[n].Constructor = i, e.fn[n].noConflict = () => (e.fn[n] = t, i.jQueryInterface)
            }
        }, "loading" === document.readyState ? document.addEventListener("DOMContentLoaded", e) : e()
    };
    const y = new Map;
    var b = function (e, t, n) {
            y.has(e) || y.set(e, new Map);
            const i = y.get(e);
            i.has(t) || 0 === i.size ? i.set(t, n) : console.error(`Bootstrap doesn't allow more than one instance per element. Bound instance: ${Array.from(i.keys())[0]}.`)
        },
        _ = function (e, t) {
            return y.has(e) && y.get(e).get(t) || null
        },
        w = function (e, t) {
            if (y.has(e)) {
                const n = y.get(e);
                n.delete(t), 0 === n.size && y.delete(e)
            }
        };
    const x = /[^.]*(?=\..*)\.|.*/,
        E = /\..*/,
        T = /::\d+$/,
        C = {};
    let A = 1;
    const k = {
            mouseenter: "mouseover",
            mouseleave: "mouseout"
        },
        S = new Set(["click", "dblclick", "mouseup", "mousedown", "contextmenu", "mousewheel", "DOMMouseScroll", "mouseover", "mouseout", "mousemove", "selectstart", "selectend", "keydown", "keypress", "keyup", "orientationchange", "touchstart", "touchmove", "touchend", "touchcancel", "pointerdown", "pointermove", "pointerup", "pointerleave", "pointercancel", "gesturestart", "gesturechange", "gestureend", "focus", "blur", "change", "reset", "select", "submit", "focusin", "focusout", "load", "unload", "beforeunload", "resize", "move", "DOMContentLoaded", "readystatechange", "error", "abort", "scroll"]);

    function D(e, t) {
        return t && `${t}::${A++}` || e.uidEvent || A++
    }

    function L(e) {
        var t = D(e);
        return e.uidEvent = t, C[t] = C[t] || {}, C[t]
    }

    function O(n, i, r = null) {
        var o = Object.keys(n);
        for (let e = 0, t = o.length; e < t; e++) {
            var s = n[o[e]];
            if (s.originalHandler === i && s.delegationSelector === r) return s
        }
        return null
    }

    function N(e, t, n) {
        var i = "string" == typeof t,
            n = i ? n : t;
        let r = e.replace(E, "");
        t = k[r];
        return t && (r = t), S.has(r) || (r = e), [i, n, r]
    }

    function j(e, t, n, i, r) {
        if ("string" == typeof t && e) {
            n || (n = i, i = null);
            var [o, s, a] = N(t, n, i);
            const h = L(e),
                p = h[a] || (h[a] = {}),
                g = O(p, s, o ? n : null);
            if (g) g.oneOff = g.oneOff && r;
            else {
                var l, c, u, d, f, t = D(s, t.replace(x, ""));
                const m = o ? (u = e, d = n, f = i, function n(i) {
                    var r = u.querySelectorAll(d);
                    for (let {
                            target: t
                        } = i; t && t !== this; t = t.parentNode)
                        for (let e = r.length; e--;)
                            if (r[e] === t) return i.delegateTarget = t, n.oneOff && H.off(u, i.type, f), f.apply(t, [i]);
                    return null
                }) : (l = e, c = n, function e(t) {
                    return t.delegateTarget = l, e.oneOff && H.off(l, t.type, c), c.apply(l, [t])
                });
                m.delegationSelector = o ? n : null, m.originalHandler = s, m.oneOff = r, m.uidEvent = t, p[t] = m, e.addEventListener(a, m, o)
            }
        }
    }

    function P(e, t, n, i, r) {
        i = O(t[n], i, r);
        i && (e.removeEventListener(n, i, Boolean(r)), delete t[n][i.uidEvent])
    }
    const H = {
        on(e, t, n, i) {
            j(e, t, n, i, !1)
        },
        one(e, t, n, i) {
            j(e, t, n, i, !0)
        },
        off(n, i, e, t) {
            if ("string" == typeof i && n) {
                const [r, o, s] = N(i, e, t), a = s !== i, l = L(n);
                t = i.startsWith(".");
                if (void 0 !== o) return l && l[s] ? void P(n, l, s, o, r ? e : null) : void 0;
                t && Object.keys(l).forEach(e => {
                    ! function (t, n, i, r) {
                        const o = n[i] || {};
                        Object.keys(o).forEach(e => {
                            e.includes(r) && (e = o[e], P(t, n, i, e.originalHandler, e.delegationSelector))
                        })
                    }(n, l, e, i.slice(1))
                });
                const c = l[s] || {};
                Object.keys(c).forEach(e => {
                    var t = e.replace(T, "");
                    a && !i.includes(t) || (e = c[e], P(n, l, s, e.originalHandler, e.delegationSelector))
                })
            }
        },
        trigger(e, t, n) {
            if ("string" != typeof t || !e) return null;
            const i = m();
            var r = t.replace(E, ""),
                o = t !== r,
                s = S.has(r);
            let a, l = !0,
                c = !0,
                u = !1,
                d = null;
            return o && i && (a = i.Event(t, n), i(e).trigger(a), l = !a.isPropagationStopped(), c = !a.isImmediatePropagationStopped(), u = a.isDefaultPrevented()), s ? (d = document.createEvent("HTMLEvents"), d.initEvent(r, l, !0)) : d = new CustomEvent(t, {
                bubbles: l,
                cancelable: !0
            }), void 0 !== n && Object.keys(n).forEach(e => {
                Object.defineProperty(d, e, {
                    get() {
                        return n[e]
                    }
                })
            }), u && d.preventDefault(), c && e.dispatchEvent(d), d.defaultPrevented && void 0 !== a && a.preventDefault(), d
        }
    };
    class $ {
        constructor(e) {
            (e = "string" == typeof e ? document.querySelector(e) : e) && (this._element = e, b(this._element, this.constructor.DATA_KEY, this))
        }
        dispose() {
            w(this._element, this.constructor.DATA_KEY), this._element = null
        }
        static getInstance(e) {
            return _(e, this.DATA_KEY)
        }
        static get VERSION() {
            return "5.0.0-beta3"
        }
    }
    const I = "bs.alert";
    I;
    class q extends $ {
        static get DATA_KEY() {
            return I
        }
        close(e) {
            var t = e ? this._getRootElement(e) : this._element,
                e = this._triggerCloseEvent(t);
            null === e || e.defaultPrevented || this._removeElement(t)
        }
        _getRootElement(e) {
            return r(e) || e.closest(".alert")
        }
        _triggerCloseEvent(e) {
            return H.trigger(e, "close.bs.alert")
        }
        _removeElement(e) {
            var t;
            e.classList.remove("show"), e.classList.contains("fade") ? (t = u(e), H.one(e, "transitionend", () => this._destroyElement(e)), d(e, t)) : this._destroyElement(e)
        }
        _destroyElement(e) {
            e.parentNode && e.parentNode.removeChild(e), H.trigger(e, "closed.bs.alert")
        }
        static jQueryInterface(t) {
            return this.each(function () {
                let e = _(this, I);
                e = e || new q(this), "close" === t && e[t](this)
            })
        }
        static handleDismiss(t) {
            return function (e) {
                e && e.preventDefault(), t.close(this)
            }
        }
    }
    H.on(document, "click.bs.alert.data-api", '[data-bs-dismiss="alert"]', q.handleDismiss(new q)), e("alert", q);
    const M = "bs.button";
    M;
    const R = '[data-bs-toggle="button"]';
    class W extends $ {
        static get DATA_KEY() {
            return M
        }
        toggle() {
            this._element.setAttribute("aria-pressed", this._element.classList.toggle("active"))
        }
        static jQueryInterface(t) {
            return this.each(function () {
                let e = _(this, M);
                e = e || new W(this), "toggle" === t && e[t]()
            })
        }
    }

    function B(e) {
        return "true" === e || "false" !== e && (e === Number(e).toString() ? Number(e) : "" === e || "null" === e ? null : e)
    }

    function F(e) {
        return e.replace(/[A-Z]/g, e => `-${e.toLowerCase()}`)
    }
    H.on(document, "click.bs.button.data-api", R, e => {
        e.preventDefault();
        e = e.target.closest(R);
        let t = _(e, M);
        t = t || new W(e), t.toggle()
    }), e("button", W);
    const z = {
            setDataAttribute(e, t, n) {
                e.setAttribute(`data-bs-${F(t)}`, n)
            },
            removeDataAttribute(e, t) {
                e.removeAttribute(`data-bs-${F(t)}`)
            },
            getDataAttributes(n) {
                if (!n) return {};
                const i = {};
                return Object.keys(n.dataset).filter(e => e.startsWith("bs")).forEach(e => {
                    let t = e.replace(/^bs/, "");
                    t = t.charAt(0).toLowerCase() + t.slice(1, t.length), i[t] = B(n.dataset[e])
                }), i
            },
            getDataAttribute(e, t) {
                return B(e.getAttribute(`data-bs-${F(t)}`))
            },
            offset(e) {
                e = e.getBoundingClientRect();
                return {
                    top: e.top + document.body.scrollTop,
                    left: e.left + document.body.scrollLeft
                }
            },
            position(e) {
                return {
                    top: e.offsetTop,
                    left: e.offsetLeft
                }
            }
        },
        U = {
            find(e, t = document.documentElement) {
                return [].concat(...Element.prototype.querySelectorAll.call(t, e))
            },
            findOne(e, t = document.documentElement) {
                return Element.prototype.querySelector.call(t, e)
            },
            children(e, t) {
                return [].concat(...e.children).filter(e => e.matches(t))
            },
            parents(e, t) {
                const n = [];
                let i = e.parentNode;
                for (; i && i.nodeType === Node.ELEMENT_NODE && 3 !== i.nodeType;) i.matches(t) && n.push(i), i = i.parentNode;
                return n
            },
            prev(e, t) {
                let n = e.previousElementSibling;
                for (; n;) {
                    if (n.matches(t)) return [n];
                    n = n.previousElementSibling
                }
                return []
            },
            next(e, t) {
                let n = e.nextElementSibling;
                for (; n;) {
                    if (n.matches(t)) return [n];
                    n = n.nextElementSibling
                }
                return []
            }
        },
        X = "carousel",
        Y = "bs.carousel",
        V = `.${Y}`;
    var K = ".data-api";
    const Q = {
            interval: 5e3,
            keyboard: !0,
            slide: !1,
            pause: "hover",
            wrap: !0,
            touch: !0
        },
        G = {
            interval: "(number|boolean)",
            keyboard: "boolean",
            slide: "(boolean|string)",
            pause: "(string|boolean)",
            wrap: "boolean",
            touch: "boolean"
        },
        J = "next",
        Z = "prev",
        ee = "left",
        te = "right",
        ne = (V, `slid${V}`);
    V, V, V, V, V, V, V, V, V;
    V, V;
    const ie = "active",
        re = ".active.carousel-item";
    class oe extends $ {
        constructor(e, t) {
            super(e), this._items = null, this._interval = null, this._activeElement = null, this._isPaused = !1, this._isSliding = !1, this.touchTimeout = null, this.touchStartX = 0, this.touchDeltaX = 0, this._config = this._getConfig(t), this._indicatorsElement = U.findOne(".carousel-indicators", this._element), this._touchSupported = "ontouchstart" in document.documentElement || 0 < navigator.maxTouchPoints, this._pointerEvent = Boolean(window.PointerEvent), this._addEventListeners()
        }
        static get Default() {
            return Q
        }
        static get DATA_KEY() {
            return Y
        }
        next() {
            this._isSliding || this._slide(J)
        }
        nextWhenVisible() {
            !document.hidden && c(this._element) && this.next()
        }
        prev() {
            this._isSliding || this._slide(Z)
        }
        pause(e) {
            e || (this._isPaused = !0), U.findOne(".carousel-item-next, .carousel-item-prev", this._element) && (o(this._element), this.cycle(!0)), clearInterval(this._interval), this._interval = null
        }
        cycle(e) {
            e || (this._isPaused = !1), this._interval && (clearInterval(this._interval), this._interval = null), this._config && this._config.interval && !this._isPaused && (this._updateInterval(), this._interval = setInterval((document.visibilityState ? this.nextWhenVisible : this.next).bind(this), this._config.interval))
        }
        to(e) {
            this._activeElement = U.findOne(re, this._element);
            var t = this._getItemIndex(this._activeElement);
            if (!(e > this._items.length - 1 || e < 0))
                if (this._isSliding) H.one(this._element, ne, () => this.to(e));
                else {
                    if (t === e) return this.pause(), void this.cycle();
                    t = t < e ? J : Z;
                    this._slide(t, this._items[e])
                }
        }
        dispose() {
            H.off(this._element, V), this._items = null, this._config = null, this._interval = null, this._isPaused = null, this._isSliding = null, this._activeElement = null, this._indicatorsElement = null, super.dispose()
        }
        _getConfig(e) {
            return e = {
                ...Q,
                ...e
            }, n(X, e, G), e
        }
        _handleSwipe() {
            var e = Math.abs(this.touchDeltaX);
            e <= 40 || (e = e / this.touchDeltaX, this.touchDeltaX = 0, e && this._slide(0 < e ? te : ee))
        }
        _addEventListeners() {
            this._config.keyboard && H.on(this._element, "keydown.bs.carousel", e => this._keydown(e)), "hover" === this._config.pause && (H.on(this._element, "mouseenter.bs.carousel", e => this.pause(e)), H.on(this._element, "mouseleave.bs.carousel", e => this.cycle(e))), this._config.touch && this._touchSupported && this._addTouchEventListeners()
        }
        _addTouchEventListeners() {
            const t = e => {
                    !this._pointerEvent || "pen" !== e.pointerType && "touch" !== e.pointerType ? this._pointerEvent || (this.touchStartX = e.touches[0].clientX) : this.touchStartX = e.clientX
                },
                n = e => {
                    this.touchDeltaX = e.touches && 1 < e.touches.length ? 0 : e.touches[0].clientX - this.touchStartX
                },
                i = e => {
                    !this._pointerEvent || "pen" !== e.pointerType && "touch" !== e.pointerType || (this.touchDeltaX = e.clientX - this.touchStartX), this._handleSwipe(), "hover" === this._config.pause && (this.pause(), this.touchTimeout && clearTimeout(this.touchTimeout), this.touchTimeout = setTimeout(e => this.cycle(e), 500 + this._config.interval))
                };
            U.find(".carousel-item img", this._element).forEach(e => {
                H.on(e, "dragstart.bs.carousel", e => e.preventDefault())
            }), this._pointerEvent ? (H.on(this._element, "pointerdown.bs.carousel", e => t(e)), H.on(this._element, "pointerup.bs.carousel", e => i(e)), this._element.classList.add("pointer-event")) : (H.on(this._element, "touchstart.bs.carousel", e => t(e)), H.on(this._element, "touchmove.bs.carousel", e => n(e)), H.on(this._element, "touchend.bs.carousel", e => i(e)))
        }
        _keydown(e) {
            /input|textarea/i.test(e.target.tagName) || ("ArrowLeft" === e.key ? (e.preventDefault(), this._slide(ee)) : "ArrowRight" === e.key && (e.preventDefault(), this._slide(te)))
        }
        _getItemIndex(e) {
            return this._items = e && e.parentNode ? U.find(".carousel-item", e.parentNode) : [], this._items.indexOf(e)
        }
        _getItemByOrder(e, t) {
            var n = e === J,
                i = e === Z,
                r = this._getItemIndex(t),
                e = this._items.length - 1;
            if ((i && 0 === r || n && r === e) && !this._config.wrap) return t;
            i = (r + (i ? -1 : 1)) % this._items.length;
            return -1 == i ? this._items[this._items.length - 1] : this._items[i]
        }
        _triggerSlideEvent(e, t) {
            var n = this._getItemIndex(e),
                i = this._getItemIndex(U.findOne(re, this._element));
            return H.trigger(this._element, "slide.bs.carousel", {
                relatedTarget: e,
                direction: t,
                from: i,
                to: n
            })
        }
        _setActiveIndicatorElement(t) {
            if (this._indicatorsElement) {
                const e = U.findOne(".active", this._indicatorsElement);
                e.classList.remove(ie), e.removeAttribute("aria-current");
                const n = U.find("[data-bs-target]", this._indicatorsElement);
                for (let e = 0; e < n.length; e++)
                    if (Number.parseInt(n[e].getAttribute("data-bs-slide-to"), 10) === this._getItemIndex(t)) {
                        n[e].classList.add(ie), n[e].setAttribute("aria-current", "true");
                        break
                    }
            }
        }
        _updateInterval() {
            const e = this._activeElement || U.findOne(re, this._element);
            var t;
            e && ((t = Number.parseInt(e.getAttribute("data-bs-interval"), 10)) ? (this._config.defaultInterval = this._config.defaultInterval || this._config.interval, this._config.interval = t) : this._config.interval = this._config.defaultInterval || this._config.interval)
        }
        _slide(e, t) {
            var n = this._directionToOrder(e);
            const i = U.findOne(re, this._element),
                r = this._getItemIndex(i),
                o = t || this._getItemByOrder(n, i),
                s = this._getItemIndex(o);
            e = Boolean(this._interval), t = n === J;
            const a = t ? "carousel-item-start" : "carousel-item-end",
                l = t ? "carousel-item-next" : "carousel-item-prev",
                c = this._orderToDirection(n);
            o && o.classList.contains(ie) ? this._isSliding = !1 : this._triggerSlideEvent(o, c).defaultPrevented || i && o && (this._isSliding = !0, e && this.pause(), this._setActiveIndicatorElement(o), this._activeElement = o, this._element.classList.contains("slide") ? (o.classList.add(l), g(o), i.classList.add(a), o.classList.add(a), n = u(i), H.one(i, "transitionend", () => {
                o.classList.remove(a, l), o.classList.add(ie), i.classList.remove(ie, l, a), this._isSliding = !1, setTimeout(() => {
                    H.trigger(this._element, ne, {
                        relatedTarget: o,
                        direction: c,
                        from: r,
                        to: s
                    })
                }, 0)
            }), d(i, n)) : (i.classList.remove(ie), o.classList.add(ie), this._isSliding = !1, H.trigger(this._element, ne, {
                relatedTarget: o,
                direction: c,
                from: r,
                to: s
            })), e && this.cycle())
        }
        _directionToOrder(e) {
            return [te, ee].includes(e) ? v() ? e === te ? Z : J : e === te ? J : Z : e
        }
        _orderToDirection(e) {
            return [J, Z].includes(e) ? v() ? e === J ? ee : te : e === J ? te : ee : e
        }
        static carouselInterface(e, t) {
            let n = _(e, Y),
                i = {
                    ...Q,
                    ...z.getDataAttributes(e)
                };
            "object" == typeof t && (i = {
                ...i,
                ...t
            });
            var r = "string" == typeof t ? t : i.slide;
            if (n = n || new oe(e, i), "number" == typeof t) n.to(t);
            else if ("string" == typeof r) {
                if (void 0 === n[r]) throw new TypeError(`No method named "${r}"`);
                n[r]()
            } else i.interval && i.ride && (n.pause(), n.cycle())
        }
        static jQueryInterface(e) {
            return this.each(function () {
                oe.carouselInterface(this, e)
            })
        }
        static dataApiClickHandler(e) {
            const t = r(this);
            if (t && t.classList.contains("carousel")) {
                const i = {
                    ...z.getDataAttributes(t),
                    ...z.getDataAttributes(this)
                };
                var n = this.getAttribute("data-bs-slide-to");
                n && (i.interval = !1), oe.carouselInterface(t, i), n && _(t, Y).to(n), e.preventDefault()
            }
        }
    }
    H.on(document, "click.bs.carousel.data-api", "[data-bs-slide], [data-bs-slide-to]", oe.dataApiClickHandler), H.on(window, "load.bs.carousel.data-api", () => {
        var n = U.find('[data-bs-ride="carousel"]');
        for (let e = 0, t = n.length; e < t; e++) oe.carouselInterface(n[e], _(n[e], Y))
    }), e(X, oe);
    const se = "collapse",
        ae = "bs.collapse";
    ae;
    const le = {
            toggle: !0,
            parent: ""
        },
        ce = {
            toggle: "boolean",
            parent: "(string|element)"
        };
    const ue = "show",
        de = "collapse",
        fe = "collapsing",
        he = "collapsed",
        pe = '[data-bs-toggle="collapse"]';
    class ge extends $ {
        constructor(e, t) {
            super(e), this._isTransitioning = !1, this._config = this._getConfig(t), this._triggerArray = U.find(`${pe}[href="#${this._element.id}"],` + `${pe}[data-bs-target="#${this._element.id}"]`);
            var n = U.find(pe);
            for (let e = 0, t = n.length; e < t; e++) {
                var i = n[e],
                    r = a(i),
                    o = U.find(r).filter(e => e === this._element);
                null !== r && o.length && (this._selector = r, this._triggerArray.push(i))
            }
            this._parent = this._config.parent ? this._getParent() : null, this._config.parent || this._addAriaAndCollapsedClass(this._element, this._triggerArray), this._config.toggle && this.toggle()
        }
        static get Default() {
            return le
        }
        static get DATA_KEY() {
            return ae
        }
        toggle() {
            this._element.classList.contains(ue) ? this.hide() : this.show()
        }
        show() {
            if (!this._isTransitioning && !this._element.classList.contains(ue)) {
                let e, t;
                this._parent && (e = U.find(".show, .collapsing", this._parent).filter(e => "string" == typeof this._config.parent ? e.getAttribute("data-bs-parent") === this._config.parent : e.classList.contains(de)), 0 === e.length && (e = null));
                const r = U.findOne(this._selector);
                if (e) {
                    var n = e.find(e => r !== e);
                    if (t = n ? _(n, ae) : null, t && t._isTransitioning) return
                }
                if (!H.trigger(this._element, "show.bs.collapse").defaultPrevented) {
                    e && e.forEach(e => {
                        r !== e && ge.collapseInterface(e, "hide"), t || b(e, ae, null)
                    });
                    const o = this._getDimension();
                    this._element.classList.remove(de), this._element.classList.add(fe), this._element.style[o] = 0, this._triggerArray.length && this._triggerArray.forEach(e => {
                        e.classList.remove(he), e.setAttribute("aria-expanded", !0)
                    }), this.setTransitioning(!0);
                    var i = `scroll${o[0].toUpperCase()+o.slice(1)}`,
                        n = u(this._element);
                    H.one(this._element, "transitionend", () => {
                        this._element.classList.remove(fe), this._element.classList.add(de, ue), this._element.style[o] = "", this.setTransitioning(!1), H.trigger(this._element, "shown.bs.collapse")
                    }), d(this._element, n), this._element.style[o] = `${this._element[i]}px`
                }
            }
        }
        hide() {
            if (!this._isTransitioning && this._element.classList.contains(ue) && !H.trigger(this._element, "hide.bs.collapse").defaultPrevented) {
                var e = this._getDimension();
                this._element.style[e] = `${this._element.getBoundingClientRect()[e]}px`, g(this._element), this._element.classList.add(fe), this._element.classList.remove(de, ue);
                var t = this._triggerArray.length;
                if (0 < t)
                    for (let e = 0; e < t; e++) {
                        const n = this._triggerArray[e],
                            i = r(n);
                        i && !i.classList.contains(ue) && (n.classList.add(he), n.setAttribute("aria-expanded", !1))
                    }
                this.setTransitioning(!0);
                this._element.style[e] = "";
                e = u(this._element);
                H.one(this._element, "transitionend", () => {
                    this.setTransitioning(!1), this._element.classList.remove(fe), this._element.classList.add(de), H.trigger(this._element, "hidden.bs.collapse")
                }), d(this._element, e)
            }
        }
        setTransitioning(e) {
            this._isTransitioning = e
        }
        dispose() {
            super.dispose(), this._config = null, this._parent = null, this._triggerArray = null, this._isTransitioning = null
        }
        _getConfig(e) {
            return (e = {
                ...le,
                ...e
            }).toggle = Boolean(e.toggle), n(se, e, ce), e
        }
        _getDimension() {
            return this._element.classList.contains("width") ? "width" : "height"
        }
        _getParent() {
            let {
                parent: e
            } = this._config;
            l(e) ? void 0 === e.jquery && void 0 === e[0] || (e = e[0]) : e = U.findOne(e);
            var t = `${pe}[data-bs-parent="${e}"]`;
            return U.find(t, e).forEach(e => {
                var t = r(e);
                this._addAriaAndCollapsedClass(t, [e])
            }), e
        }
        _addAriaAndCollapsedClass(e, t) {
            if (e && t.length) {
                const n = e.classList.contains(ue);
                t.forEach(e => {
                    n ? e.classList.remove(he) : e.classList.add(he), e.setAttribute("aria-expanded", n)
                })
            }
        }
        static collapseInterface(e, t) {
            let n = _(e, ae);
            const i = {
                ...le,
                ...z.getDataAttributes(e),
                ..."object" == typeof t && t ? t : {}
            };
            if (!n && i.toggle && "string" == typeof t && /show|hide/.test(t) && (i.toggle = !1), n = n || new ge(e, i), "string" == typeof t) {
                if (void 0 === n[t]) throw new TypeError(`No method named "${t}"`);
                n[t]()
            }
        }
        static jQueryInterface(e) {
            return this.each(function () {
                ge.collapseInterface(this, e)
            })
        }
    }
    H.on(document, "click.bs.collapse.data-api", pe, function (e) {
        ("A" === e.target.tagName || e.delegateTarget && "A" === e.delegateTarget.tagName) && e.preventDefault();
        const i = z.getDataAttributes(this);
        e = a(this);
        const t = U.find(e);
        t.forEach(e => {
            const t = _(e, ae);
            let n;
            n = t ? (null === t._parent && "string" == typeof i.parent && (t._config.parent = i.parent, t._parent = t._getParent()), "toggle") : i, ge.collapseInterface(e, n)
        })
    }), e(se, ge);
    var me = "top",
        ve = "bottom",
        ye = "right",
        be = "left",
        _e = "auto",
        we = [me, ve, ye, be],
        xe = "start",
        Ee = "end",
        Te = "clippingParents",
        Ce = "viewport",
        Ae = "popper",
        ke = "reference",
        Se = we.reduce(function (e, t) {
            return e.concat([t + "-" + xe, t + "-" + Ee])
        }, []),
        De = [].concat(we, [_e]).reduce(function (e, t) {
            return e.concat([t, t + "-" + xe, t + "-" + Ee])
        }, []),
        Le = "beforeRead",
        Oe = "afterRead",
        Ne = "beforeMain",
        je = "afterMain",
        Pe = "beforeWrite",
        He = "afterWrite",
        $e = [Le, "read", Oe, Ne, "main", je, Pe, "write", He];

    function Ie(e) {
        return e ? (e.nodeName || "").toLowerCase() : null
    }

    function qe(e) {
        if (null == e) return window;
        if ("[object Window]" === e.toString()) return e;
        e = e.ownerDocument;
        return e && e.defaultView || window
    }

    function Me(e) {
        return e instanceof qe(e).Element || e instanceof Element
    }

    function Re(e) {
        return e instanceof qe(e).HTMLElement || e instanceof HTMLElement
    }

    function We(e) {
        return "undefined" != typeof ShadowRoot && (e instanceof qe(e).ShadowRoot || e instanceof ShadowRoot)
    }
    var Be = {
        name: "applyStyles",
        enabled: !0,
        phase: "write",
        fn: function (e) {
            var r = e.state;
            Object.keys(r.elements).forEach(function (e) {
                var t = r.styles[e] || {},
                    n = r.attributes[e] || {},
                    i = r.elements[e];
                Re(i) && Ie(i) && (Object.assign(i.style, t), Object.keys(n).forEach(function (e) {
                    var t = n[e];
                    !1 === t ? i.removeAttribute(e) : i.setAttribute(e, !0 === t ? "" : t)
                }))
            })
        },
        effect: function (e) {
            var i = e.state,
                r = {
                    popper: {
                        position: i.options.strategy,
                        left: "0",
                        top: "0",
                        margin: "0"
                    },
                    arrow: {
                        position: "absolute"
                    },
                    reference: {}
                };
            return Object.assign(i.elements.popper.style, r.popper), i.styles = r, i.elements.arrow && Object.assign(i.elements.arrow.style, r.arrow),
                function () {
                    Object.keys(i.elements).forEach(function (e) {
                        var t = i.elements[e],
                            n = i.attributes[e] || {},
                            e = Object.keys((i.styles.hasOwnProperty(e) ? i.styles : r)[e]).reduce(function (e, t) {
                                return e[t] = "", e
                            }, {});
                        Re(t) && Ie(t) && (Object.assign(t.style, e), Object.keys(n).forEach(function (e) {
                            t.removeAttribute(e)
                        }))
                    })
                }
        },
        requires: ["computeStyles"]
    };

    function Fe(e) {
        return e.split("-")[0]
    }

    function ze(e) {
        e = e.getBoundingClientRect();
        return {
            width: e.width,
            height: e.height,
            top: e.top,
            right: e.right,
            bottom: e.bottom,
            left: e.left,
            x: e.left,
            y: e.top
        }
    }

    function Ue(e) {
        var t = ze(e),
            n = e.offsetWidth,
            i = e.offsetHeight;
        return Math.abs(t.width - n) <= 1 && (n = t.width), Math.abs(t.height - i) <= 1 && (i = t.height), {
            x: e.offsetLeft,
            y: e.offsetTop,
            width: n,
            height: i
        }
    }

    function Xe(e, t) {
        var n = t.getRootNode && t.getRootNode();
        if (e.contains(t)) return !0;
        if (n && We(n)) {
            var i = t;
            do {
                if (i && e.isSameNode(i)) return !0
            } while (i = i.parentNode || i.host)
        }
        return !1
    }

    function Ye(e) {
        return qe(e).getComputedStyle(e)
    }

    function Ve(e) {
        return ((Me(e) ? e.ownerDocument : e.document) || window.document).documentElement
    }

    function Ke(e) {
        return "html" === Ie(e) ? e : e.assignedSlot || e.parentNode || (We(e) ? e.host : null) || Ve(e)
    }

    function Qe(e) {
        return Re(e) && "fixed" !== Ye(e).position ? e.offsetParent : null
    }

    function Ge(e) {
        for (var t = qe(e), n = Qe(e); n && 0 <= ["table", "td", "th"].indexOf(Ie(n)) && "static" === Ye(n).position;) n = Qe(n);
        return (!n || "html" !== Ie(n) && ("body" !== Ie(n) || "static" !== Ye(n).position)) && (n || function (e) {
            for (var t = -1 !== navigator.userAgent.toLowerCase().indexOf("firefox"), n = Ke(e); Re(n) && ["html", "body"].indexOf(Ie(n)) < 0;) {
                var i = Ye(n);
                if ("none" !== i.transform || "none" !== i.perspective || "paint" === i.contain || -1 !== ["transform", "perspective"].indexOf(i.willChange) || t && "filter" === i.willChange || t && i.filter && "none" !== i.filter) return n;
                n = n.parentNode
            }
            return null
        }(e)) || t
    }

    function Je(e) {
        return 0 <= ["top", "bottom"].indexOf(e) ? "x" : "y"
    }
    var Ze = Math.max,
        et = Math.min,
        tt = Math.round;

    function nt(e, t, n) {
        return Ze(e, et(t, n))
    }

    function it() {
        return {
            top: 0,
            right: 0,
            bottom: 0,
            left: 0
        }
    }

    function rt(e) {
        return Object.assign({}, it(), e)
    }

    function ot(n, e) {
        return e.reduce(function (e, t) {
            return e[t] = n, e
        }, {})
    }
    var st = {
            name: "arrow",
            enabled: !0,
            phase: "main",
            fn: function (e) {
                var t, n, i = e.state,
                    r = e.name,
                    o = e.options,
                    s = i.elements.arrow,
                    a = i.modifiersData.popperOffsets,
                    l = Fe(i.placement),
                    c = Je(l),
                    u = 0 <= [be, ye].indexOf(l) ? "height" : "width";
                s && a && (t = o.padding, n = i, e = rt("number" != typeof (t = "function" == typeof t ? t(Object.assign({}, n.rects, {
                    placement: n.placement
                })) : t) ? t : ot(t, we)), l = Ue(s), o = "y" === c ? me : be, n = "y" === c ? ve : ye, t = i.rects.reference[u] + i.rects.reference[c] - a[c] - i.rects.popper[u], a = a[c] - i.rects.reference[c], s = (s = Ge(s)) ? "y" === c ? s.clientHeight || 0 : s.clientWidth || 0 : 0, o = e[o], n = s - l[u] - e[n], n = nt(o, a = s / 2 - l[u] / 2 + (t / 2 - a / 2), n), i.modifiersData[r] = ((r = {})[c] = n, r.centerOffset = n - a, r))
            },
            effect: function (e) {
                var t = e.state;
                null != (e = void 0 === (e = e.options.element) ? "[data-popper-arrow]" : e) && ("string" != typeof e || (e = t.elements.popper.querySelector(e))) && Xe(t.elements.popper, e) && (t.elements.arrow = e)
            },
            requires: ["popperOffsets"],
            requiresIfExists: ["preventOverflow"]
        },
        at = {
            top: "auto",
            right: "auto",
            bottom: "auto",
            left: "auto"
        };

    function lt(e) {
        var t = e.popper,
            n = e.popperRect,
            i = e.placement,
            r = e.offsets,
            o = e.position,
            s = e.gpuAcceleration,
            a = e.adaptive,
            l = e.roundOffsets,
            c = !0 === l ? (h = (g = r).x, p = g.y, g = window.devicePixelRatio || 1, {
                x: tt(tt(h * g) / g) || 0,
                y: tt(tt(p * g) / g) || 0
            }) : "function" == typeof l ? l(r) : r,
            u = c.x,
            d = void 0 === u ? 0 : u,
            f = c.y,
            e = void 0 === f ? 0 : f,
            h = r.hasOwnProperty("x"),
            p = r.hasOwnProperty("y"),
            g = be,
            l = me,
            u = window;
        a && (c = "clientHeight", f = "clientWidth", (r = Ge(t)) === qe(t) && "static" !== Ye(r = Ve(t)).position && (c = "scrollHeight", f = "scrollWidth"), i === me && (l = ve, e -= r[c] - n.height, e *= s ? 1 : -1), i === be && (g = ye, d -= r[f] - n.width, d *= s ? 1 : -1));
        var a = Object.assign({
            position: o
        }, a && at);
        return s ? Object.assign({}, a, ((s = {})[l] = p ? "0" : "", s[g] = h ? "0" : "", s.transform = (u.devicePixelRatio || 1) < 2 ? "translate(" + d + "px, " + e + "px)" : "translate3d(" + d + "px, " + e + "px, 0)", s)) : Object.assign({}, a, ((a = {})[l] = p ? e + "px" : "", a[g] = h ? d + "px" : "", a.transform = "", a))
    }
    var ct = {
            name: "computeStyles",
            enabled: !0,
            phase: "beforeWrite",
            fn: function (e) {
                var t = e.state,
                    n = e.options,
                    e = void 0 === (i = n.gpuAcceleration) || i,
                    i = void 0 === (i = n.adaptive) || i,
                    n = void 0 === (n = n.roundOffsets) || n,
                    e = {
                        placement: Fe(t.placement),
                        popper: t.elements.popper,
                        popperRect: t.rects.popper,
                        gpuAcceleration: e
                    };
                null != t.modifiersData.popperOffsets && (t.styles.popper = Object.assign({}, t.styles.popper, lt(Object.assign({}, e, {
                    offsets: t.modifiersData.popperOffsets,
                    position: t.options.strategy,
                    adaptive: i,
                    roundOffsets: n
                })))), null != t.modifiersData.arrow && (t.styles.arrow = Object.assign({}, t.styles.arrow, lt(Object.assign({}, e, {
                    offsets: t.modifiersData.arrow,
                    position: "absolute",
                    adaptive: !1,
                    roundOffsets: n
                })))), t.attributes.popper = Object.assign({}, t.attributes.popper, {
                    "data-popper-placement": t.placement
                })
            },
            data: {}
        },
        ut = {
            passive: !0
        };
    var dt = {
            name: "eventListeners",
            enabled: !0,
            phase: "write",
            fn: function () {},
            effect: function (e) {
                var t = e.state,
                    n = e.instance,
                    i = e.options,
                    r = void 0 === (e = i.scroll) || e,
                    o = void 0 === (i = i.resize) || i,
                    s = qe(t.elements.popper),
                    a = [].concat(t.scrollParents.reference, t.scrollParents.popper);
                return r && a.forEach(function (e) {
                        e.addEventListener("scroll", n.update, ut)
                    }), o && s.addEventListener("resize", n.update, ut),
                    function () {
                        r && a.forEach(function (e) {
                            e.removeEventListener("scroll", n.update, ut)
                        }), o && s.removeEventListener("resize", n.update, ut)
                    }
            },
            data: {}
        },
        ft = {
            left: "right",
            right: "left",
            bottom: "top",
            top: "bottom"
        };

    function ht(e) {
        return e.replace(/left|right|bottom|top/g, function (e) {
            return ft[e]
        })
    }
    var pt = {
        start: "end",
        end: "start"
    };

    function gt(e) {
        return e.replace(/start|end/g, function (e) {
            return pt[e]
        })
    }

    function mt(e) {
        e = qe(e);
        return {
            scrollLeft: e.pageXOffset,
            scrollTop: e.pageYOffset
        }
    }

    function vt(e) {
        return ze(Ve(e)).left + mt(e).scrollLeft
    }

    function yt(e) {
        var t = Ye(e),
            n = t.overflow,
            e = t.overflowX,
            t = t.overflowY;
        return /auto|scroll|overlay|hidden/.test(n + t + e)
    }

    function bt(e, t) {
        void 0 === t && (t = []);
        var n = function e(t) {
                return 0 <= ["html", "body", "#document"].indexOf(Ie(t)) ? t.ownerDocument.body : Re(t) && yt(t) ? t : e(Ke(t))
            }(e),
            e = n === (null == (i = e.ownerDocument) ? void 0 : i.body),
            i = qe(n),
            n = e ? [i].concat(i.visualViewport || [], yt(n) ? n : []) : n,
            t = t.concat(n);
        return e ? t : t.concat(bt(Ke(n)))
    }

    function _t(e) {
        return Object.assign({}, e, {
            left: e.x,
            top: e.y,
            right: e.x + e.width,
            bottom: e.y + e.height
        })
    }

    function wt(e, t) {
        return t === Ce ? _t((o = qe(r = e), s = Ve(r), a = o.visualViewport, l = s.clientWidth, c = s.clientHeight, s = o = 0, a && (l = a.width, c = a.height, /^((?!chrome|android).)*safari/i.test(navigator.userAgent) || (o = a.offsetLeft, s = a.offsetTop)), {
            width: l,
            height: c,
            x: o + vt(r),
            y: s
        })) : Re(t) ? ((i = ze(n = t)).top = i.top + n.clientTop, i.left = i.left + n.clientLeft, i.bottom = i.top + n.clientHeight, i.right = i.left + n.clientWidth, i.width = n.clientWidth, i.height = n.clientHeight, i.x = i.left, i.y = i.top, i) : _t((r = Ve(e), s = Ve(r), t = mt(r), i = null == (n = r.ownerDocument) ? void 0 : n.body, e = Ze(s.scrollWidth, s.clientWidth, i ? i.scrollWidth : 0, i ? i.clientWidth : 0), n = Ze(s.scrollHeight, s.clientHeight, i ? i.scrollHeight : 0, i ? i.clientHeight : 0), r = -t.scrollLeft + vt(r), t = -t.scrollTop, "rtl" === Ye(i || s).direction && (r += Ze(s.clientWidth, i ? i.clientWidth : 0) - e), {
            width: e,
            height: n,
            x: r,
            y: t
        }));
        var n, i, r, o, s, a, l, c
    }

    function xt(n, e, t) {
        var i, r, o, e = "clippingParents" === e ? (r = bt(Ke(i = n)), Me(o = 0 <= ["absolute", "fixed"].indexOf(Ye(i).position) && Re(i) ? Ge(i) : i) ? r.filter(function (e) {
                return Me(e) && Xe(e, o) && "body" !== Ie(e)
            }) : []) : [].concat(e),
            e = [].concat(e, [t]),
            t = e[0],
            t = e.reduce(function (e, t) {
                t = wt(n, t);
                return e.top = Ze(t.top, e.top), e.right = et(t.right, e.right), e.bottom = et(t.bottom, e.bottom), e.left = Ze(t.left, e.left), e
            }, wt(n, t));
        return t.width = t.right - t.left, t.height = t.bottom - t.top, t.x = t.left, t.y = t.top, t
    }

    function Et(e) {
        return e.split("-")[1]
    }

    function Tt(e) {
        var t, n = e.reference,
            i = e.element,
            r = e.placement,
            e = r ? Fe(r) : null,
            r = r ? Et(r) : null,
            o = n.x + n.width / 2 - i.width / 2,
            s = n.y + n.height / 2 - i.height / 2;
        switch (e) {
            case me:
                t = {
                    x: o,
                    y: n.y - i.height
                };
                break;
            case ve:
                t = {
                    x: o,
                    y: n.y + n.height
                };
                break;
            case ye:
                t = {
                    x: n.x + n.width,
                    y: s
                };
                break;
            case be:
                t = {
                    x: n.x - i.width,
                    y: s
                };
                break;
            default:
                t = {
                    x: n.x,
                    y: n.y
                }
        }
        var a = e ? Je(e) : null;
        if (null != a) {
            var l = "y" === a ? "height" : "width";
            switch (r) {
                case xe:
                    t[a] = t[a] - (n[l] / 2 - i[l] / 2);
                    break;
                case Ee:
                    t[a] = t[a] + (n[l] / 2 - i[l] / 2)
            }
        }
        return t
    }

    function Ct(e, t) {
        var i, n = (t = void 0 === t ? {} : t).placement,
            r = void 0 === n ? e.placement : n,
            o = t.boundary,
            s = void 0 === o ? Te : o,
            a = t.rootBoundary,
            l = void 0 === a ? Ce : a,
            c = t.elementContext,
            n = void 0 === c ? Ae : c,
            o = t.altBoundary,
            a = void 0 !== o && o,
            c = t.padding,
            o = void 0 === c ? 0 : c,
            t = rt("number" != typeof o ? o : ot(o, we)),
            c = e.elements.reference,
            o = e.rects.popper,
            a = e.elements[a ? n === Ae ? ke : Ae : n],
            s = xt(Me(a) ? a : a.contextElement || Ve(e.elements.popper), s, l),
            l = ze(c),
            c = Tt({
                reference: l,
                element: o,
                strategy: "absolute",
                placement: r
            }),
            c = _t(Object.assign({}, o, c)),
            l = n === Ae ? c : l,
            u = {
                top: s.top - l.top + t.top,
                bottom: l.bottom - s.bottom + t.bottom,
                left: s.left - l.left + t.left,
                right: l.right - s.right + t.right
            },
            e = e.modifiersData.offset;
        return n === Ae && e && (i = e[r], Object.keys(u).forEach(function (e) {
            var t = 0 <= [ye, ve].indexOf(e) ? 1 : -1,
                n = 0 <= [me, ve].indexOf(e) ? "y" : "x";
            u[e] += i[n] * t
        })), u
    }
    var At = {
        name: "flip",
        enabled: !0,
        phase: "main",
        fn: function (e) {
            var d = e.state,
                t = e.options,
                n = e.name;
            if (!d.modifiersData[n]._skip) {
                for (var i = t.mainAxis, r = void 0 === i || i, e = t.altAxis, o = void 0 === e || e, i = t.fallbackPlacements, f = t.padding, h = t.boundary, p = t.rootBoundary, s = t.altBoundary, e = t.flipVariations, g = void 0 === e || e, m = t.allowedAutoPlacements, e = d.options.placement, t = Fe(e), t = i || (t === e || !g ? [ht(e)] : function (e) {
                        if (Fe(e) === _e) return [];
                        var t = ht(e);
                        return [gt(e), t, gt(t)]
                    }(e)), a = [e].concat(t).reduce(function (e, t) {
                        return e.concat(Fe(t) === _e ? (n = d, r = (i = void 0 === (i = {
                            placement: t,
                            boundary: h,
                            rootBoundary: p,
                            padding: f,
                            flipVariations: g,
                            allowedAutoPlacements: m
                        }) ? {} : i).placement, o = i.boundary, s = i.rootBoundary, a = i.padding, e = i.flipVariations, l = void 0 === (i = i.allowedAutoPlacements) ? De : i, c = Et(r), r = c ? e ? Se : Se.filter(function (e) {
                            return Et(e) === c
                        }) : we, u = (e = 0 === (e = r.filter(function (e) {
                            return 0 <= l.indexOf(e)
                        })).length ? r : e).reduce(function (e, t) {
                            return e[t] = Ct(n, {
                                placement: t,
                                boundary: o,
                                rootBoundary: s,
                                padding: a
                            })[Fe(t)], e
                        }, {}), Object.keys(u).sort(function (e, t) {
                            return u[e] - u[t]
                        })) : t);
                        var n, i, r, o, s, a, l, c, u
                    }, []), l = d.rects.reference, c = d.rects.popper, u = new Map, v = !0, y = a[0], b = 0; b < a.length; b++) {
                    var _ = a[b],
                        w = Fe(_),
                        x = Et(_) === xe,
                        E = 0 <= [me, ve].indexOf(w),
                        T = E ? "width" : "height",
                        C = Ct(d, {
                            placement: _,
                            boundary: h,
                            rootBoundary: p,
                            altBoundary: s,
                            padding: f
                        }),
                        E = E ? x ? ye : be : x ? ve : me;
                    l[T] > c[T] && (E = ht(E));
                    x = ht(E), T = [];
                    if (r && T.push(C[w] <= 0), o && T.push(C[E] <= 0, C[x] <= 0), T.every(function (e) {
                            return e
                        })) {
                        y = _, v = !1;
                        break
                    }
                    u.set(_, T)
                }
                if (v)
                    for (var A = g ? 3 : 1; 0 < A; A--)
                        if ("break" === function (t) {
                                var e = a.find(function (e) {
                                    e = u.get(e);
                                    if (e) return e.slice(0, t).every(function (e) {
                                        return e
                                    })
                                });
                                if (e) return y = e, "break"
                            }(A)) break;
                d.placement !== y && (d.modifiersData[n]._skip = !0, d.placement = y, d.reset = !0)
            }
        },
        requiresIfExists: ["offset"],
        data: {
            _skip: !1
        }
    };

    function kt(e, t, n) {
        return {
            top: e.top - t.height - (n = void 0 === n ? {
                x: 0,
                y: 0
            } : n).y,
            right: e.right - t.width + n.x,
            bottom: e.bottom - t.height + n.y,
            left: e.left - t.width - n.x
        }
    }

    function St(t) {
        return [me, ye, ve, be].some(function (e) {
            return 0 <= t[e]
        })
    }
    var Dt = {
        name: "hide",
        enabled: !0,
        phase: "main",
        requiresIfExists: ["preventOverflow"],
        fn: function (e) {
            var t = e.state,
                n = e.name,
                i = t.rects.reference,
                r = t.rects.popper,
                o = t.modifiersData.preventOverflow,
                s = Ct(t, {
                    elementContext: "reference"
                }),
                e = Ct(t, {
                    altBoundary: !0
                }),
                i = kt(s, i),
                e = kt(e, r, o),
                r = St(i),
                o = St(e);
            t.modifiersData[n] = {
                referenceClippingOffsets: i,
                popperEscapeOffsets: e,
                isReferenceHidden: r,
                hasPopperEscaped: o
            }, t.attributes.popper = Object.assign({}, t.attributes.popper, {
                "data-popper-reference-hidden": r,
                "data-popper-escaped": o
            })
        }
    };
    var Lt = {
        name: "offset",
        enabled: !0,
        phase: "main",
        requires: ["popperOffsets"],
        fn: function (e) {
            var s = e.state,
                t = e.options,
                n = e.name,
                a = void 0 === (i = t.offset) ? [0, 0] : i,
                e = De.reduce(function (e, t) {
                    var n, i, r, o;
                    return e[t] = (n = t, i = s.rects, r = a, o = Fe(n), t = 0 <= [be, me].indexOf(o) ? -1 : 1, r = (r = (n = "function" == typeof r ? r(Object.assign({}, i, {
                        placement: n
                    })) : r)[0]) || 0, n = ((n = n[1]) || 0) * t, 0 <= [be, ye].indexOf(o) ? {
                        x: n,
                        y: r
                    } : {
                        x: r,
                        y: n
                    }), e
                }, {}),
                i = (t = e[s.placement]).x,
                t = t.y;
            null != s.modifiersData.popperOffsets && (s.modifiersData.popperOffsets.x += i, s.modifiersData.popperOffsets.y += t), s.modifiersData[n] = e
        }
    };
    K = {
        name: "popperOffsets",
        enabled: !0,
        phase: "read",
        fn: function (e) {
            var t = e.state,
                e = e.name;
            t.modifiersData[e] = Tt({
                reference: t.rects.reference,
                element: t.rects.popper,
                strategy: "absolute",
                placement: t.placement
            })
        },
        data: {}
    };
    var Ot = {
        name: "preventOverflow",
        enabled: !0,
        phase: "main",
        fn: function (e) {
            var t = e.state,
                n = e.options,
                i = e.name,
                r = void 0 === (x = n.mainAxis) || x,
                o = void 0 !== (E = n.altAxis) && E,
                s = n.boundary,
                a = n.rootBoundary,
                l = n.altBoundary,
                c = n.padding,
                u = n.tether,
                d = void 0 === u || u,
                f = n.tetherOffset,
                h = void 0 === f ? 0 : f,
                p = Ct(t, {
                    boundary: s,
                    rootBoundary: a,
                    padding: c,
                    altBoundary: l
                }),
                g = Fe(t.placement),
                m = Et(t.placement),
                v = !m,
                y = Je(g),
                b = "x" === y ? "y" : "x",
                _ = t.modifiersData.popperOffsets,
                w = t.rects.reference,
                e = t.rects.popper,
                x = "function" == typeof h ? h(Object.assign({}, t.rects, {
                    placement: t.placement
                })) : h,
                E = {
                    x: 0,
                    y: 0
                };
            _ && ((r || o) && (u = "y" === y ? "height" : "width", n = _[y], s = _[y] + p[f = "y" === y ? me : be], c = _[y] - p[a = "y" === y ? ve : ye], l = d ? -e[u] / 2 : 0, g = (m === xe ? w : e)[u], h = m === xe ? -e[u] : -w[u], m = t.elements.arrow, e = d && m ? Ue(m) : {
                width: 0,
                height: 0
            }, f = (m = t.modifiersData["arrow#persistent"] ? t.modifiersData["arrow#persistent"].padding : it())[f], a = m[a], e = nt(0, w[u], e[u]), f = v ? w[u] / 2 - l - e - f - x : g - e - f - x, e = v ? -w[u] / 2 + l + e + a + x : h + e + a + x, x = (a = t.elements.arrow && Ge(t.elements.arrow)) ? "y" === y ? a.clientTop || 0 : a.clientLeft || 0 : 0, a = t.modifiersData.offset ? t.modifiersData.offset[t.placement][y] : 0, x = _[y] + f - a - x, a = _[y] + e - a, r && (c = nt(d ? et(s, x) : s, n, d ? Ze(c, a) : c), _[y] = c, E[y] = c - n), o && (o = (n = _[b]) + p["x" === y ? me : be], y = n - p["x" === y ? ve : ye], y = nt(d ? et(o, x) : o, n, d ? Ze(y, a) : y), _[b] = y, E[b] = y - n)), t.modifiersData[i] = E)
        },
        requiresIfExists: ["offset"]
    };

    function Nt(e, t, n) {
        void 0 === n && (n = !1);
        var i = Ve(t),
            r = ze(e),
            o = Re(t),
            s = {
                scrollLeft: 0,
                scrollTop: 0
            },
            e = {
                x: 0,
                y: 0
            };
        return !o && (o || n) || ("body" === Ie(t) && !yt(i) || (s = (o = t) !== qe(o) && Re(o) ? {
            scrollLeft: (n = o).scrollLeft,
            scrollTop: n.scrollTop
        } : mt(o)), Re(t) ? ((e = ze(t)).x += t.clientLeft, e.y += t.clientTop) : i && (e.x = vt(i))), {
            x: r.left + s.scrollLeft - e.x,
            y: r.top + s.scrollTop - e.y,
            width: r.width,
            height: r.height
        }
    }

    function jt(e) {
        var n = new Map,
            i = new Set,
            r = [];
        return e.forEach(function (e) {
            n.set(e.name, e)
        }), e.forEach(function (e) {
            i.has(e.name) || ! function t(e) {
                i.add(e.name), [].concat(e.requires || [], e.requiresIfExists || []).forEach(function (e) {
                    i.has(e) || (e = n.get(e)) && t(e)
                }), r.push(e)
            }(e)
        }), r
    }
    var Pt = {
        placement: "bottom",
        modifiers: [],
        strategy: "absolute"
    };

    function Ht() {
        for (var e = arguments.length, t = new Array(e), n = 0; n < e; n++) t[n] = arguments[n];
        return !t.some(function (e) {
            return !(e && "function" == typeof e.getBoundingClientRect)
        })
    }

    function $t(e) {
        var t = (e = void 0 === e ? {} : e).defaultModifiers,
            d = void 0 === t ? [] : t,
            e = e.defaultOptions,
            f = void 0 === e ? Pt : e;
        return function (i, r, t) {
            void 0 === t && (t = f);
            var n, o, s = {
                    placement: "bottom",
                    orderedModifiers: [],
                    options: Object.assign({}, Pt, f),
                    modifiersData: {},
                    elements: {
                        reference: i,
                        popper: r
                    },
                    attributes: {},
                    styles: {}
                },
                a = [],
                l = !1,
                c = {
                    state: s,
                    setOptions: function (e) {
                        u(), s.options = Object.assign({}, f, s.options, e), s.scrollParents = {
                            reference: Me(i) ? bt(i) : i.contextElement ? bt(i.contextElement) : [],
                            popper: bt(r)
                        };
                        var n, t, e = (e = [].concat(d, s.options.modifiers), t = e.reduce(function (e, t) {
                            var n = e[t.name];
                            return e[t.name] = n ? Object.assign({}, n, t, {
                                options: Object.assign({}, n.options, t.options),
                                data: Object.assign({}, n.data, t.data)
                            }) : t, e
                        }, {}), e = Object.keys(t).map(function (e) {
                            return t[e]
                        }), n = jt(e), $e.reduce(function (e, t) {
                            return e.concat(n.filter(function (e) {
                                return e.phase === t
                            }))
                        }, []));
                        return s.orderedModifiers = e.filter(function (e) {
                            return e.enabled
                        }), s.orderedModifiers.forEach(function (e) {
                            var t = e.name,
                                n = e.options,
                                e = e.effect;
                            "function" == typeof e && (n = e({
                                state: s,
                                name: t,
                                instance: c,
                                options: void 0 === n ? {} : n
                            }), a.push(n || function () {}))
                        }), c.update()
                    },
                    forceUpdate: function () {
                        if (!l) {
                            var e = s.elements,
                                t = e.reference,
                                e = e.popper;
                            if (Ht(t, e)) {
                                s.rects = {
                                    reference: Nt(t, Ge(e), "fixed" === s.options.strategy),
                                    popper: Ue(e)
                                }, s.reset = !1, s.placement = s.options.placement, s.orderedModifiers.forEach(function (e) {
                                    return s.modifiersData[e.name] = Object.assign({}, e.data)
                                });
                                for (var n, i, r, o = 0; o < s.orderedModifiers.length; o++) !0 !== s.reset ? (n = (r = s.orderedModifiers[o]).fn, i = r.options, r = r.name, "function" == typeof n && (s = n({
                                    state: s,
                                    options: void 0 === i ? {} : i,
                                    name: r,
                                    instance: c
                                }) || s)) : (s.reset = !1, o = -1)
                            }
                        }
                    },
                    update: (n = function () {
                        return new Promise(function (e) {
                            c.forceUpdate(), e(s)
                        })
                    }, function () {
                        return o = o || new Promise(function (e) {
                            Promise.resolve().then(function () {
                                o = void 0, e(n())
                            })
                        })
                    }),
                    destroy: function () {
                        u(), l = !0
                    }
                };
            return Ht(i, r) && c.setOptions(t).then(function (e) {
                !l && t.onFirstUpdate && t.onFirstUpdate(e)
            }), c;

            function u() {
                a.forEach(function (e) {
                    return e()
                }), a = []
            }
        }
    }
    var It = $t({
            defaultModifiers: [dt, K, ct, Be, Lt, At, Ot, st, Dt]
        }),
        qt = Object.freeze({
            __proto__: null,
            popperGenerator: $t,
            detectOverflow: Ct,
            createPopperBase: $t(),
            createPopper: It,
            createPopperLite: $t({
                defaultModifiers: [dt, K, ct, Be]
            }),
            top: me,
            bottom: ve,
            right: ye,
            left: be,
            auto: _e,
            basePlacements: we,
            start: xe,
            end: Ee,
            clippingParents: Te,
            viewport: Ce,
            popper: Ae,
            reference: ke,
            variationPlacements: Se,
            placements: De,
            beforeRead: Le,
            read: "read",
            afterRead: Oe,
            beforeMain: Ne,
            main: "main",
            afterMain: je,
            beforeWrite: Pe,
            write: "write",
            afterWrite: He,
            modifierPhases: $e,
            applyStyles: Be,
            arrow: st,
            computeStyles: ct,
            eventListeners: dt,
            flip: At,
            hide: Dt,
            offset: Lt,
            popperOffsets: K,
            preventOverflow: Ot
        });
    const Mt = "dropdown",
        Rt = "bs.dropdown",
        Wt = `.${Rt}`;
    Lt = ".data-api";
    const Bt = "Escape",
        Ft = "ArrowUp",
        zt = "ArrowDown",
        Ut = new RegExp(`${Ft}|${zt}|${Bt}`),
        Xt = `hide${Wt}`,
        Yt = `hidden${Wt}`;
    Wt, Wt, Wt;
    K = `click${Wt}${Lt}`, Ot = `keydown${Wt}${Lt}`, Wt;
    const Vt = "disabled",
        Kt = "show",
        Qt = '[data-bs-toggle="dropdown"]',
        Gt = ".dropdown-menu",
        Jt = v() ? "top-end" : "top-start",
        Zt = v() ? "top-start" : "top-end",
        en = v() ? "bottom-end" : "bottom-start",
        tn = v() ? "bottom-start" : "bottom-end",
        nn = v() ? "left-start" : "right-start",
        rn = v() ? "right-start" : "left-start",
        on = {
            offset: [0, 2],
            boundary: "clippingParents",
            reference: "toggle",
            display: "dynamic",
            popperConfig: null
        },
        sn = {
            offset: "(array|string|function)",
            boundary: "(string|element)",
            reference: "(string|element|object)",
            display: "string",
            popperConfig: "(null|object|function)"
        };
    class an extends $ {
        constructor(e, t) {
            super(e), this._popper = null, this._config = this._getConfig(t), this._menu = this._getMenuElement(), this._inNavbar = this._detectNavbar(), this._addEventListeners()
        }
        static get Default() {
            return on
        }
        static get DefaultType() {
            return sn
        }
        static get DATA_KEY() {
            return Rt
        }
        toggle() {
            var e;
            this._element.disabled || this._element.classList.contains(Vt) || (e = this._element.classList.contains(Kt), an.clearMenus(), e || this.show())
        }
        show() {
            if (!(this._element.disabled || this._element.classList.contains(Vt) || this._menu.classList.contains(Kt))) {
                const n = an.getParentFromElement(this._element);
                var e = {
                    relatedTarget: this._element
                };
                if (!H.trigger(this._element, "show.bs.dropdown", e).defaultPrevented) {
                    if (this._inNavbar) z.setDataAttribute(this._menu, "popper", "none");
                    else {
                        if (void 0 === qt) throw new TypeError("Bootstrap's dropdowns require Popper (https://popper.js.org)");
                        let e = this._element;
                        "parent" === this._config.reference ? e = n : l(this._config.reference) ? (e = this._config.reference, void 0 !== this._config.reference.jquery && (e = this._config.reference[0])) : "object" == typeof this._config.reference && (e = this._config.reference);
                        const i = this._getPopperConfig();
                        var t = i.modifiers.find(e => "applyStyles" === e.name && !1 === e.enabled);
                        this._popper = It(e, this._menu, i), t && z.setDataAttribute(this._menu, "popper", "static")
                    }
                    "ontouchstart" in document.documentElement && !n.closest(".navbar-nav") && [].concat(...document.body.children).forEach(e => H.on(e, "mouseover", null, p())), this._element.focus(), this._element.setAttribute("aria-expanded", !0), this._menu.classList.toggle(Kt), this._element.classList.toggle(Kt), H.trigger(this._element, "shown.bs.dropdown", e)
                }
            }
        }
        hide() {
            var e;
            this._element.disabled || this._element.classList.contains(Vt) || !this._menu.classList.contains(Kt) || (e = {
                relatedTarget: this._element
            }, H.trigger(this._element, Xt, e).defaultPrevented || (this._popper && this._popper.destroy(), this._menu.classList.toggle(Kt), this._element.classList.toggle(Kt), z.removeDataAttribute(this._menu, "popper"), H.trigger(this._element, Yt, e)))
        }
        dispose() {
            H.off(this._element, Wt), this._menu = null, this._popper && (this._popper.destroy(), this._popper = null), super.dispose()
        }
        update() {
            this._inNavbar = this._detectNavbar(), this._popper && this._popper.update()
        }
        _addEventListeners() {
            H.on(this._element, "click.bs.dropdown", e => {
                e.preventDefault(), this.toggle()
            })
        }
        _getConfig(e) {
            if (e = {
                    ...this.constructor.Default,
                    ...z.getDataAttributes(this._element),
                    ...e
                }, n(Mt, e, this.constructor.DefaultType), "object" == typeof e.reference && !l(e.reference) && "function" != typeof e.reference.getBoundingClientRect) throw new TypeError(`${Mt.toUpperCase()}: Option "reference" provided type "object" without a required "getBoundingClientRect" method.`);
            return e
        }
        _getMenuElement() {
            return U.next(this._element, Gt)[0]
        }
        _getPlacement() {
            const e = this._element.parentNode;
            if (e.classList.contains("dropend")) return nn;
            if (e.classList.contains("dropstart")) return rn;
            var t = "end" === getComputedStyle(this._menu).getPropertyValue("--bs-position").trim();
            return e.classList.contains("dropup") ? t ? Zt : Jt : t ? tn : en
        }
        _detectNavbar() {
            return null !== this._element.closest(".navbar")
        }
        _getOffset() {
            const {
                offset: t
            } = this._config;
            return "string" == typeof t ? t.split(",").map(e => Number.parseInt(e, 10)) : "function" == typeof t ? e => t(e, this._element) : t
        }
        _getPopperConfig() {
            const e = {
                placement: this._getPlacement(),
                modifiers: [{
                    name: "preventOverflow",
                    options: {
                        boundary: this._config.boundary
                    }
                }, {
                    name: "offset",
                    options: {
                        offset: this._getOffset()
                    }
                }]
            };
            return "static" === this._config.display && (e.modifiers = [{
                name: "applyStyles",
                enabled: !1
            }]), {
                ...e,
                ..."function" == typeof this._config.popperConfig ? this._config.popperConfig(e) : this._config.popperConfig
            }
        }
        static dropdownInterface(e, t) {
            let n = _(e, Rt);
            var i = "object" == typeof t ? t : null;
            if (n = n || new an(e, i), "string" == typeof t) {
                if (void 0 === n[t]) throw new TypeError(`No method named "${t}"`);
                n[t]()
            }
        }
        static jQueryInterface(e) {
            return this.each(function () {
                an.dropdownInterface(this, e)
            })
        }
        static clearMenus(n) {
            if (n) {
                if (2 === n.button || "keyup" === n.type && "Tab" !== n.key) return;
                if (/input|select|textarea|form/i.test(n.target.tagName)) return
            }
            const i = U.find(Qt);
            for (let e = 0, t = i.length; e < t; e++) {
                const r = _(i[e], Rt),
                    o = {
                        relatedTarget: i[e]
                    };
                if (n && "click" === n.type && (o.clickEvent = n), r) {
                    const s = r._menu;
                    if (i[e].classList.contains(Kt)) {
                        if (n) {
                            if ([r._element].some(e => n.composedPath().includes(e))) continue;
                            if ("keyup" === n.type && "Tab" === n.key && s.contains(n.target)) continue
                        }
                        H.trigger(i[e], Xt, o).defaultPrevented || ("ontouchstart" in document.documentElement && [].concat(...document.body.children).forEach(e => H.off(e, "mouseover", null, p())), i[e].setAttribute("aria-expanded", "false"), r._popper && r._popper.destroy(), s.classList.remove(Kt), i[e].classList.remove(Kt), z.removeDataAttribute(s, "popper"), H.trigger(i[e], Yt, o))
                    }
                }
            }
        }
        static getParentFromElement(e) {
            return r(e) || e.parentNode
        }
        static dataApiKeydownHandler(t) {
            if ((/input|textarea/i.test(t.target.tagName) ? !("Space" === t.key || t.key !== Bt && (t.key !== zt && t.key !== Ft || t.target.closest(Gt))) : Ut.test(t.key)) && (t.preventDefault(), t.stopPropagation(), !this.disabled && !this.classList.contains(Vt))) {
                var e = an.getParentFromElement(this),
                    n = this.classList.contains(Kt);
                if (t.key === Bt) {
                    const i = this.matches(Qt) ? this : U.prev(this, Qt)[0];
                    return i.focus(), void an.clearMenus()
                }
                if (n || t.key !== Ft && t.key !== zt)
                    if (n && "Space" !== t.key) {
                        const r = U.find(".dropdown-menu .dropdown-item:not(.disabled):not(:disabled)", e).filter(c);
                        if (r.length) {
                            let e = r.indexOf(t.target);
                            t.key === Ft && 0 < e && e--, t.key === zt && e < r.length - 1 && e++, e = -1 === e ? 0 : e, r[e].focus()
                        }
                    } else an.clearMenus();
                else {
                    const o = this.matches(Qt) ? this : U.prev(this, Qt)[0];
                    o.click()
                }
            }
        }
    }
    H.on(document, Ot, Qt, an.dataApiKeydownHandler), H.on(document, Ot, Gt, an.dataApiKeydownHandler), H.on(document, K, an.clearMenus), H.on(document, "keyup.bs.dropdown.data-api", an.clearMenus), H.on(document, K, Qt, function (e) {
        e.preventDefault(), an.dropdownInterface(this)
    }), e(Mt, an);
    const ln = "bs.modal",
        cn = `.${ln}`;
    const un = {
            backdrop: !0,
            keyboard: !0,
            focus: !0
        },
        dn = {
            backdrop: "(boolean|string)",
            keyboard: "boolean",
            focus: "boolean"
        },
        fn = (cn, cn, `hidden${cn}`),
        hn = `show${cn}`,
        pn = (cn, `focusin${cn}`),
        gn = `resize${cn}`,
        mn = `click.dismiss${cn}`,
        vn = `keydown.dismiss${cn}`,
        yn = (cn, `mousedown.dismiss${cn}`);
    cn;
    const bn = "modal-open",
        _n = "show",
        wn = "modal-static";
    const xn = ".fixed-top, .fixed-bottom, .is-fixed, .sticky-top",
        En = ".sticky-top";
    class Tn extends $ {
        constructor(e, t) {
            super(e), this._config = this._getConfig(t), this._dialog = U.findOne(".modal-dialog", this._element), this._backdrop = null, this._isShown = !1, this._isBodyOverflowing = !1, this._ignoreBackdropClick = !1, this._isTransitioning = !1, this._scrollbarWidth = 0
        }
        static get Default() {
            return un
        }
        static get DATA_KEY() {
            return ln
        }
        toggle(e) {
            return this._isShown ? this.hide() : this.show(e)
        }
        show(e) {
            var t;
            this._isShown || this._isTransitioning || (this._isAnimated() && (this._isTransitioning = !0), t = H.trigger(this._element, hn, {
                relatedTarget: e
            }), this._isShown || t.defaultPrevented || (this._isShown = !0, this._checkScrollbar(), this._setScrollbar(), this._adjustDialog(), this._setEscapeEvent(), this._setResizeEvent(), H.on(this._element, mn, '[data-bs-dismiss="modal"]', e => this.hide(e)), H.on(this._dialog, yn, () => {
                H.one(this._element, "mouseup.dismiss.bs.modal", e => {
                    e.target === this._element && (this._ignoreBackdropClick = !0)
                })
            }), this._showBackdrop(() => this._showElement(e))))
        }
        hide(e) {
            e && e.preventDefault(), this._isShown && !this._isTransitioning && (H.trigger(this._element, "hide.bs.modal").defaultPrevented || (this._isShown = !1, (e = this._isAnimated()) && (this._isTransitioning = !0), this._setEscapeEvent(), this._setResizeEvent(), H.off(document, pn), this._element.classList.remove(_n), H.off(this._element, mn), H.off(this._dialog, yn), e ? (e = u(this._element), H.one(this._element, "transitionend", e => this._hideModal(e)), d(this._element, e)) : this._hideModal()))
        }
        dispose() {
            [window, this._element, this._dialog].forEach(e => H.off(e, cn)), super.dispose(), H.off(document, pn), this._config = null, this._dialog = null, this._backdrop = null, this._isShown = null, this._isBodyOverflowing = null, this._ignoreBackdropClick = null, this._isTransitioning = null, this._scrollbarWidth = null
        }
        handleUpdate() {
            this._adjustDialog()
        }
        _getConfig(e) {
            return e = {
                ...un,
                ...e
            }, n("modal", e, dn), e
        }
        _showElement(e) {
            var t = this._isAnimated();
            const n = U.findOne(".modal-body", this._dialog);
            this._element.parentNode && this._element.parentNode.nodeType === Node.ELEMENT_NODE || document.body.appendChild(this._element), this._element.style.display = "block", this._element.removeAttribute("aria-hidden"), this._element.setAttribute("aria-modal", !0), this._element.setAttribute("role", "dialog"), this._element.scrollTop = 0, n && (n.scrollTop = 0), t && g(this._element), this._element.classList.add(_n), this._config.focus && this._enforceFocus();
            var i = () => {
                this._config.focus && this._element.focus(), this._isTransitioning = !1, H.trigger(this._element, "shown.bs.modal", {
                    relatedTarget: e
                })
            };
            t ? (t = u(this._dialog), H.one(this._dialog, "transitionend", i), d(this._dialog, t)) : i()
        }
        _enforceFocus() {
            H.off(document, pn), H.on(document, pn, e => {
                document === e.target || this._element === e.target || this._element.contains(e.target) || this._element.focus()
            })
        }
        _setEscapeEvent() {
            this._isShown ? H.on(this._element, vn, e => {
                this._config.keyboard && "Escape" === e.key ? (e.preventDefault(), this.hide()) : this._config.keyboard || "Escape" !== e.key || this._triggerBackdropTransition()
            }) : H.off(this._element, vn)
        }
        _setResizeEvent() {
            this._isShown ? H.on(window, gn, () => this._adjustDialog()) : H.off(window, gn)
        }
        _hideModal() {
            this._element.style.display = "none", this._element.setAttribute("aria-hidden", !0), this._element.removeAttribute("aria-modal"), this._element.removeAttribute("role"), this._isTransitioning = !1, this._showBackdrop(() => {
                document.body.classList.remove(bn), this._resetAdjustments(), this._resetScrollbar(), H.trigger(this._element, fn)
            })
        }
        _removeBackdrop() {
            this._backdrop.parentNode.removeChild(this._backdrop), this._backdrop = null
        }
        _showBackdrop(e) {
            var t, n = this._isAnimated();
            this._isShown && this._config.backdrop ? (this._backdrop = document.createElement("div"), this._backdrop.className = "modal-backdrop", n && this._backdrop.classList.add("fade"), document.body.appendChild(this._backdrop), H.on(this._element, mn, e => {
                this._ignoreBackdropClick ? this._ignoreBackdropClick = !1 : e.target === e.currentTarget && ("static" === this._config.backdrop ? this._triggerBackdropTransition() : this.hide())
            }), n && g(this._backdrop), this._backdrop.classList.add(_n), n ? (t = u(this._backdrop), H.one(this._backdrop, "transitionend", e), d(this._backdrop, t)) : e()) : !this._isShown && this._backdrop ? (this._backdrop.classList.remove(_n), t = () => {
                this._removeBackdrop(), e()
            }, n ? (n = u(this._backdrop), H.one(this._backdrop, "transitionend", t), d(this._backdrop, n)) : t()) : e()
        }
        _isAnimated() {
            return this._element.classList.contains("fade")
        }
        _triggerBackdropTransition() {
            if (!H.trigger(this._element, "hidePrevented.bs.modal").defaultPrevented) {
                const e = this._element.scrollHeight > document.documentElement.clientHeight;
                e || (this._element.style.overflowY = "hidden"), this._element.classList.add(wn);
                const t = u(this._dialog);
                H.off(this._element, "transitionend"), H.one(this._element, "transitionend", () => {
                    this._element.classList.remove(wn), e || (H.one(this._element, "transitionend", () => {
                        this._element.style.overflowY = ""
                    }), d(this._element, t))
                }), d(this._element, t), this._element.focus()
            }
        }
        _adjustDialog() {
            var e = this._element.scrollHeight > document.documentElement.clientHeight;
            (!this._isBodyOverflowing && e && !v() || this._isBodyOverflowing && !e && v()) && (this._element.style.paddingLeft = `${this._scrollbarWidth}px`), (this._isBodyOverflowing && !e && !v() || !this._isBodyOverflowing && e && v()) && (this._element.style.paddingRight = `${this._scrollbarWidth}px`)
        }
        _resetAdjustments() {
            this._element.style.paddingLeft = "", this._element.style.paddingRight = ""
        }
        _checkScrollbar() {
            var e = document.body.getBoundingClientRect();
            this._isBodyOverflowing = Math.round(e.left + e.right) < window.innerWidth, this._scrollbarWidth = this._getScrollbarWidth()
        }
        _setScrollbar() {
            this._isBodyOverflowing && (this._setElementAttributes(xn, "paddingRight", e => e + this._scrollbarWidth), this._setElementAttributes(En, "marginRight", e => e - this._scrollbarWidth), this._setElementAttributes("body", "paddingRight", e => e + this._scrollbarWidth)), document.body.classList.add(bn)
        }
        _setElementAttributes(e, i, r) {
            U.find(e).forEach(e => {
                var t, n;
                e !== document.body && window.innerWidth > e.clientWidth + this._scrollbarWidth || (t = e.style[i], n = window.getComputedStyle(e)[i], z.setDataAttribute(e, i, t), e.style[i] = r(Number.parseFloat(n)) + "px")
            })
        }
        _resetScrollbar() {
            this._resetElementAttributes(xn, "paddingRight"), this._resetElementAttributes(En, "marginRight"), this._resetElementAttributes("body", "paddingRight")
        }
        _resetElementAttributes(e, n) {
            U.find(e).forEach(e => {
                var t = z.getDataAttribute(e, n);
                void 0 === t && e === document.body ? e.style[n] = "" : (z.removeDataAttribute(e, n), e.style[n] = t)
            })
        }
        _getScrollbarWidth() {
            const e = document.createElement("div");
            e.className = "modal-scrollbar-measure", document.body.appendChild(e);
            var t = e.getBoundingClientRect().width - e.clientWidth;
            return document.body.removeChild(e), t
        }
        static jQueryInterface(n, i) {
            return this.each(function () {
                let e = _(this, ln);
                var t = {
                    ...un,
                    ...z.getDataAttributes(this),
                    ..."object" == typeof n && n ? n : {}
                };
                if (e = e || new Tn(this, t), "string" == typeof n) {
                    if (void 0 === e[n]) throw new TypeError(`No method named "${n}"`);
                    e[n](i)
                }
            })
        }
    }
    H.on(document, "click.bs.modal.data-api", '[data-bs-toggle="modal"]', function (e) {
        const t = r(this);
        "A" !== this.tagName && "AREA" !== this.tagName || e.preventDefault(), H.one(t, hn, e => {
            e.defaultPrevented || H.one(t, fn, () => {
                c(this) && this.focus()
            })
        });
        let n = _(t, ln);
        n || (e = {
            ...z.getDataAttributes(t),
            ...z.getDataAttributes(this)
        }, n = new Tn(t, e)), n.toggle(this)
    }), e("modal", Tn);
    const Cn = ".fixed-top, .fixed-bottom, .is-fixed",
        An = ".sticky-top",
        kn = () => {
            var e = document.documentElement.clientWidth;
            return Math.abs(window.innerWidth - e)
        },
        Sn = (e, i, r) => {
            const o = kn();
            U.find(e).forEach(e => {
                var t, n;
                e !== document.body && window.innerWidth > e.clientWidth + o || (t = e.style[i], n = window.getComputedStyle(e)[i], z.setDataAttribute(e, i, t), e.style[i] = r(Number.parseFloat(n)) + "px")
            })
        },
        Dn = (e, n) => {
            U.find(e).forEach(e => {
                var t = z.getDataAttribute(e, n);
                void 0 === t && e === document.body ? e.style.removeProperty(n) : (z.removeDataAttribute(e, n), e.style[n] = t)
            })
        },
        Ln = "offcanvas",
        On = "bs.offcanvas";
    Ot = `.${On}`, K = ".data-api";
    const Nn = {
            backdrop: !0,
            keyboard: !0,
            scroll: !1
        },
        jn = {
            backdrop: "boolean",
            keyboard: "boolean",
            scroll: "boolean"
        },
        Pn = "offcanvas-backdrop",
        Hn = "offcanvas-toggling",
        $n = ".offcanvas.show",
        In = ($n, Hn, `hidden${Ot}`),
        qn = `focusin${Ot}`,
        Mn = `click${Ot}${K}`;
    class Rn extends $ {
        constructor(e, t) {
            super(e), this._config = this._getConfig(t), this._isShown = !1, this._addEventListeners()
        }
        static get Default() {
            return Nn
        }
        static get DATA_KEY() {
            return On
        }
        toggle(e) {
            return this._isShown ? this.hide() : this.show(e)
        }
        show(e) {
            var t;
            this._isShown || H.trigger(this._element, "show.bs.offcanvas", {
                relatedTarget: e
            }).defaultPrevented || (this._isShown = !0, this._element.style.visibility = "visible", this._config.backdrop && document.body.classList.add(Pn), this._config.scroll || (t = kn(), document.body.style.overflow = "hidden", Sn(Cn, "paddingRight", e => e + t), Sn(An, "marginRight", e => e - t), Sn("body", "paddingRight", e => e + t)), this._element.classList.add(Hn), this._element.removeAttribute("aria-hidden"), this._element.setAttribute("aria-modal", !0), this._element.setAttribute("role", "dialog"), this._element.classList.add("show"), setTimeout(() => {
                this._element.classList.remove(Hn), H.trigger(this._element, "shown.bs.offcanvas", {
                    relatedTarget: e
                }), this._enforceFocusOnElement(this._element)
            }, u(this._element)))
        }
        hide() {
            this._isShown && (H.trigger(this._element, "hide.bs.offcanvas").defaultPrevented || (this._element.classList.add(Hn), H.off(document, qn), this._element.blur(), this._isShown = !1, this._element.classList.remove("show"), setTimeout(() => {
                this._element.setAttribute("aria-hidden", !0), this._element.removeAttribute("aria-modal"), this._element.removeAttribute("role"), this._element.style.visibility = "hidden", this._config.backdrop && document.body.classList.remove(Pn), this._config.scroll || (document.body.style.overflow = "auto", Dn(Cn, "paddingRight"), Dn(An, "marginRight"), Dn("body", "paddingRight")), H.trigger(this._element, In), this._element.classList.remove(Hn)
            }, u(this._element))))
        }
        _getConfig(e) {
            return e = {
                ...Nn,
                ...z.getDataAttributes(this._element),
                ..."object" == typeof e ? e : {}
            }, n(Ln, e, jn), e
        }
        _enforceFocusOnElement(t) {
            H.off(document, qn), H.on(document, qn, e => {
                document === e.target || t === e.target || t.contains(e.target) || t.focus()
            }), t.focus()
        }
        _addEventListeners() {
            H.on(this._element, "click.dismiss.bs.offcanvas", '[data-bs-dismiss="offcanvas"]', () => this.hide()), H.on(document, "keydown", e => {
                this._config.keyboard && "Escape" === e.key && this.hide()
            }), H.on(document, Mn, e => {
                var t = U.findOne(a(e.target));
                this._element.contains(e.target) || t === this._element || this.hide()
            })
        }
        static jQueryInterface(t) {
            return this.each(function () {
                const e = _(this, On) || new Rn(this, "object" == typeof t ? t : {});
                if ("string" == typeof t) {
                    if (void 0 === e[t] || t.startsWith("_") || "constructor" === t) throw new TypeError(`No method named "${t}"`);
                    e[t](this)
                }
            })
        }
    }
    H.on(document, Mn, '[data-bs-toggle="offcanvas"]', function (e) {
        var t = r(this);
        if (["A", "AREA"].includes(this.tagName) && e.preventDefault(), !f(this)) {
            H.one(t, In, () => {
                c(this) && this.focus()
            });
            e = U.findOne(".offcanvas.show, .offcanvas-toggling");
            if (!e || e === t) {
                const n = _(t, On) || new Rn(t);
                n.toggle(this)
            }
        }
    }), H.on(window, "load.bs.offcanvas.data-api", () => {
        U.find($n).forEach(e => (_(e, On) || new Rn(e)).show())
    }), e(Ln, Rn);
    const Wn = new Set(["background", "cite", "href", "itemtype", "longdesc", "poster", "src", "xlink:href"]);
    const Bn = /^(?:(?:https?|mailto|ftp|tel|file):|[^#&/:?]*(?:[#/?]|$))/i,
        Fn = /^data:(?:image\/(?:bmp|gif|jpeg|jpg|png|tiff|webp)|video\/(?:mpeg|mp4|ogg|webm)|audio\/(?:mp3|oga|ogg|opus));base64,[\d+/a-z]+=*$/i;
    Ot = {
        "*": ["class", "dir", "id", "lang", "role", /^aria-[\w-]*$/i],
        a: ["target", "href", "title", "rel"],
        area: [],
        b: [],
        br: [],
        col: [],
        code: [],
        div: [],
        em: [],
        hr: [],
        h1: [],
        h2: [],
        h3: [],
        h4: [],
        h5: [],
        h6: [],
        i: [],
        img: ["src", "srcset", "alt", "title", "width", "height"],
        li: [],
        ol: [],
        p: [],
        pre: [],
        s: [],
        small: [],
        span: [],
        sub: [],
        sup: [],
        strong: [],
        u: [],
        ul: []
    };

    function zn(e, n, t) {
        if (!e.length) return e;
        if (t && "function" == typeof t) return t(e);
        const i = new window.DOMParser,
            r = i.parseFromString(e, "text/html"),
            o = Object.keys(n);
        var s = [].concat(...r.body.querySelectorAll("*"));
        for (let e = 0, t = s.length; e < t; e++) {
            const l = s[e];
            var a = l.nodeName.toLowerCase();
            if (o.includes(a)) {
                const c = [].concat(...l.attributes),
                    u = [].concat(n["*"] || [], n[a] || []);
                c.forEach(e => {
                    ((e, t) => {
                        var n = e.nodeName.toLowerCase();
                        if (t.includes(n)) return !Wn.has(n) || Boolean(Bn.test(e.nodeValue) || Fn.test(e.nodeValue));
                        const i = t.filter(e => e instanceof RegExp);
                        for (let e = 0, t = i.length; e < t; e++)
                            if (i[e].test(n)) return !0;
                        return !1
                    })(e, u) || l.removeAttribute(e.nodeName)
                })
            } else l.parentNode.removeChild(l)
        }
        return r.body.innerHTML
    }
    const Un = "tooltip",
        Xn = "bs.tooltip",
        Yn = `.${Xn}`,
        Vn = "bs-tooltip",
        Kn = new RegExp(`(^|\\s)${Vn}\\S+`, "g"),
        Qn = new Set(["sanitize", "allowList", "sanitizeFn"]),
        Gn = {
            animation: "boolean",
            template: "string",
            title: "(string|element|function)",
            trigger: "string",
            delay: "(number|object)",
            html: "boolean",
            selector: "(string|boolean)",
            placement: "(string|function)",
            offset: "(array|string|function)",
            container: "(string|element|boolean)",
            fallbackPlacements: "array",
            boundary: "(string|element)",
            customClass: "(string|function)",
            sanitize: "boolean",
            sanitizeFn: "(null|function)",
            allowList: "object",
            popperConfig: "(null|object|function)"
        },
        Jn = {
            AUTO: "auto",
            TOP: "top",
            RIGHT: v() ? "left" : "right",
            BOTTOM: "bottom",
            LEFT: v() ? "right" : "left"
        },
        Zn = {
            animation: !0,
            template: '<div class="tooltip" role="tooltip"><div class="tooltip-arrow"></div><div class="tooltip-inner"></div></div>',
            trigger: "hover focus",
            title: "",
            delay: 0,
            html: !1,
            selector: !1,
            placement: "top",
            offset: [0, 0],
            container: !1,
            fallbackPlacements: ["top", "right", "bottom", "left"],
            boundary: "clippingParents",
            customClass: "",
            sanitize: !0,
            sanitizeFn: null,
            allowList: Ot,
            popperConfig: null
        },
        ei = {
            HIDE: `hide${Yn}`,
            HIDDEN: `hidden${Yn}`,
            SHOW: `show${Yn}`,
            SHOWN: `shown${Yn}`,
            INSERTED: `inserted${Yn}`,
            CLICK: `click${Yn}`,
            FOCUSIN: `focusin${Yn}`,
            FOCUSOUT: `focusout${Yn}`,
            MOUSEENTER: `mouseenter${Yn}`,
            MOUSELEAVE: `mouseleave${Yn}`
        },
        ti = "fade",
        ni = "show",
        ii = "show",
        ri = "hover",
        oi = "focus";
    class si extends $ {
        constructor(e, t) {
            if (void 0 === qt) throw new TypeError("Bootstrap's tooltips require Popper (https://popper.js.org)");
            super(e), this._isEnabled = !0, this._timeout = 0, this._hoverState = "", this._activeTrigger = {}, this._popper = null, this.config = this._getConfig(t), this.tip = null, this._setListeners()
        }
        static get Default() {
            return Zn
        }
        static get NAME() {
            return Un
        }
        static get DATA_KEY() {
            return Xn
        }
        static get Event() {
            return ei
        }
        static get EVENT_KEY() {
            return Yn
        }
        static get DefaultType() {
            return Gn
        }
        enable() {
            this._isEnabled = !0
        }
        disable() {
            this._isEnabled = !1
        }
        toggleEnabled() {
            this._isEnabled = !this._isEnabled
        }
        toggle(e) {
            if (this._isEnabled)
                if (e) {
                    const t = this._initializeOnDelegatedTarget(e);
                    t._activeTrigger.click = !t._activeTrigger.click, t._isWithActiveTrigger() ? t._enter(null, t) : t._leave(null, t)
                } else this.getTipElement().classList.contains(ni) ? this._leave(null, this) : this._enter(null, this)
        }
        dispose() {
            clearTimeout(this._timeout), H.off(this._element, this.constructor.EVENT_KEY), H.off(this._element.closest(".modal"), "hide.bs.modal", this._hideModalHandler), this.tip && this.tip.parentNode && this.tip.parentNode.removeChild(this.tip), this._isEnabled = null, this._timeout = null, this._hoverState = null, this._activeTrigger = null, this._popper && this._popper.destroy(), this._popper = null, this.config = null, this.tip = null, super.dispose()
        }
        show() {
            if ("none" === this._element.style.display) throw new Error("Please use show on visible elements");
            if (this.isWithContent() && this._isEnabled) {
                var e = H.trigger(this._element, this.constructor.Event.SHOW);
                const n = h(this._element);
                var t = (null === n ? this._element.ownerDocument.documentElement : n).contains(this._element);
                if (!e.defaultPrevented && t) {
                    const i = this.getTipElement();
                    e = s(this.constructor.NAME);
                    i.setAttribute("id", e), this._element.setAttribute("aria-describedby", e), this.setContent(), this.config.animation && i.classList.add(ti);
                    t = "function" == typeof this.config.placement ? this.config.placement.call(this, i, this._element) : this.config.placement, e = this._getAttachment(t);
                    this._addAttachmentClass(e);
                    const r = this._getContainer();
                    b(i, this.constructor.DATA_KEY, this), this._element.ownerDocument.documentElement.contains(this.tip) || (r.appendChild(i), H.trigger(this._element, this.constructor.Event.INSERTED)), this._popper ? this._popper.update() : this._popper = It(this._element, i, this._getPopperConfig(e)), i.classList.add(ni);
                    const o = "function" == typeof this.config.customClass ? this.config.customClass() : this.config.customClass;
                    o && i.classList.add(...o.split(" ")), "ontouchstart" in document.documentElement && [].concat(...document.body.children).forEach(e => {
                        H.on(e, "mouseover", p())
                    });
                    t = () => {
                        var e = this._hoverState;
                        this._hoverState = null, H.trigger(this._element, this.constructor.Event.SHOWN), "out" === e && this._leave(null, this)
                    };
                    this.tip.classList.contains(ti) ? (e = u(this.tip), H.one(this.tip, "transitionend", t), d(this.tip, e)) : t()
                }
            }
        }
        hide() {
            if (this._popper) {
                const n = this.getTipElement();
                var e, t = () => {
                    this._isWithActiveTrigger() || (this._hoverState !== ii && n.parentNode && n.parentNode.removeChild(n), this._cleanTipClass(), this._element.removeAttribute("aria-describedby"), H.trigger(this._element, this.constructor.Event.HIDDEN), this._popper && (this._popper.destroy(), this._popper = null))
                };
                H.trigger(this._element, this.constructor.Event.HIDE).defaultPrevented || (n.classList.remove(ni), "ontouchstart" in document.documentElement && [].concat(...document.body.children).forEach(e => H.off(e, "mouseover", p)), this._activeTrigger.click = !1, this._activeTrigger[oi] = !1, this._activeTrigger[ri] = !1, this.tip.classList.contains(ti) ? (e = u(n), H.one(n, "transitionend", t), d(n, e)) : t(), this._hoverState = "")
            }
        }
        update() {
            null !== this._popper && this._popper.update()
        }
        isWithContent() {
            return Boolean(this.getTitle())
        }
        getTipElement() {
            if (this.tip) return this.tip;
            const e = document.createElement("div");
            return e.innerHTML = this.config.template, this.tip = e.children[0], this.tip
        }
        setContent() {
            const e = this.getTipElement();
            this.setElementContent(U.findOne(".tooltip-inner", e), this.getTitle()), e.classList.remove(ti, ni)
        }
        setElementContent(e, t) {
            if (null !== e) return "object" == typeof t && l(t) ? (t.jquery && (t = t[0]), void(this.config.html ? t.parentNode !== e && (e.innerHTML = "", e.appendChild(t)) : e.textContent = t.textContent)) : void(this.config.html ? (this.config.sanitize && (t = zn(t, this.config.allowList, this.config.sanitizeFn)), e.innerHTML = t) : e.textContent = t)
        }
        getTitle() {
            let e = this._element.getAttribute("data-bs-original-title");
            return e = e || ("function" == typeof this.config.title ? this.config.title.call(this._element) : this.config.title), e
        }
        updateAttachment(e) {
            return "right" === e ? "end" : "left" === e ? "start" : e
        }
        _initializeOnDelegatedTarget(e, t) {
            var n = this.constructor.DATA_KEY;
            return (t = t || _(e.delegateTarget, n)) || (t = new this.constructor(e.delegateTarget, this._getDelegateConfig()), b(e.delegateTarget, n, t)), t
        }
        _getOffset() {
            const {
                offset: t
            } = this.config;
            return "string" == typeof t ? t.split(",").map(e => Number.parseInt(e, 10)) : "function" == typeof t ? e => t(e, this._element) : t
        }
        _getPopperConfig(e) {
            e = {
                placement: e,
                modifiers: [{
                    name: "flip",
                    options: {
                        altBoundary: !0,
                        fallbackPlacements: this.config.fallbackPlacements
                    }
                }, {
                    name: "offset",
                    options: {
                        offset: this._getOffset()
                    }
                }, {
                    name: "preventOverflow",
                    options: {
                        boundary: this.config.boundary
                    }
                }, {
                    name: "arrow",
                    options: {
                        element: `.${this.constructor.NAME}-arrow`
                    }
                }, {
                    name: "onChange",
                    enabled: !0,
                    phase: "afterWrite",
                    fn: e => this._handlePopperPlacementChange(e)
                }],
                onFirstUpdate: e => {
                    e.options.placement !== e.placement && this._handlePopperPlacementChange(e)
                }
            };
            return {
                ...e,
                ..."function" == typeof this.config.popperConfig ? this.config.popperConfig(e) : this.config.popperConfig
            }
        }
        _addAttachmentClass(e) {
            this.getTipElement().classList.add(`${Vn}-${this.updateAttachment(e)}`)
        }
        _getContainer() {
            return !1 === this.config.container ? document.body : l(this.config.container) ? this.config.container : U.findOne(this.config.container)
        }
        _getAttachment(e) {
            return Jn[e.toUpperCase()]
        }
        _setListeners() {
            const e = this.config.trigger.split(" ");
            e.forEach(e => {
                var t;
                "click" === e ? H.on(this._element, this.constructor.Event.CLICK, this.config.selector, e => this.toggle(e)) : "manual" !== e && (t = e === ri ? this.constructor.Event.MOUSEENTER : this.constructor.Event.FOCUSIN, e = e === ri ? this.constructor.Event.MOUSELEAVE : this.constructor.Event.FOCUSOUT, H.on(this._element, t, this.config.selector, e => this._enter(e)), H.on(this._element, e, this.config.selector, e => this._leave(e)))
            }), this._hideModalHandler = () => {
                this._element && this.hide()
            }, H.on(this._element.closest(".modal"), "hide.bs.modal", this._hideModalHandler), this.config.selector ? this.config = {
                ...this.config,
                trigger: "manual",
                selector: ""
            } : this._fixTitle()
        }
        _fixTitle() {
            var e = this._element.getAttribute("title"),
                t = typeof this._element.getAttribute("data-bs-original-title");
            !e && "string" == t || (this._element.setAttribute("data-bs-original-title", e || ""), !e || this._element.getAttribute("aria-label") || this._element.textContent || this._element.setAttribute("aria-label", e), this._element.setAttribute("title", ""))
        }
        _enter(e, t) {
            t = this._initializeOnDelegatedTarget(e, t), e && (t._activeTrigger["focusin" === e.type ? oi : ri] = !0), t.getTipElement().classList.contains(ni) || t._hoverState === ii ? t._hoverState = ii : (clearTimeout(t._timeout), t._hoverState = ii, t.config.delay && t.config.delay.show ? t._timeout = setTimeout(() => {
                t._hoverState === ii && t.show()
            }, t.config.delay.show) : t.show())
        }
        _leave(e, t) {
            t = this._initializeOnDelegatedTarget(e, t), e && (t._activeTrigger["focusout" === e.type ? oi : ri] = t._element.contains(e.relatedTarget)), t._isWithActiveTrigger() || (clearTimeout(t._timeout), t._hoverState = "out", t.config.delay && t.config.delay.hide ? t._timeout = setTimeout(() => {
                "out" === t._hoverState && t.hide()
            }, t.config.delay.hide) : t.hide())
        }
        _isWithActiveTrigger() {
            for (const e in this._activeTrigger)
                if (this._activeTrigger[e]) return !0;
            return !1
        }
        _getConfig(e) {
            const t = z.getDataAttributes(this._element);
            return Object.keys(t).forEach(e => {
                Qn.has(e) && delete t[e]
            }), e && "object" == typeof e.container && e.container.jquery && (e.container = e.container[0]), "number" == typeof (e = {
                ...this.constructor.Default,
                ...t,
                ..."object" == typeof e && e ? e : {}
            }).delay && (e.delay = {
                show: e.delay,
                hide: e.delay
            }), "number" == typeof e.title && (e.title = e.title.toString()), "number" == typeof e.content && (e.content = e.content.toString()), n(Un, e, this.constructor.DefaultType), e.sanitize && (e.template = zn(e.template, e.allowList, e.sanitizeFn)), e
        }
        _getDelegateConfig() {
            const e = {};
            if (this.config)
                for (const t in this.config) this.constructor.Default[t] !== this.config[t] && (e[t] = this.config[t]);
            return e
        }
        _cleanTipClass() {
            const t = this.getTipElement(),
                e = t.getAttribute("class").match(Kn);
            null !== e && 0 < e.length && e.map(e => e.trim()).forEach(e => t.classList.remove(e))
        }
        _handlePopperPlacementChange(e) {
            var {
                state: e
            } = e;
            e && (this.tip = e.elements.popper, this._cleanTipClass(), this._addAttachmentClass(this._getAttachment(e.placement)))
        }
        static jQueryInterface(n) {
            return this.each(function () {
                let e = _(this, Xn);
                var t = "object" == typeof n && n;
                if ((e || !/dispose|hide/.test(n)) && (e = e || new si(this, t), "string" == typeof n)) {
                    if (void 0 === e[n]) throw new TypeError(`No method named "${n}"`);
                    e[n]()
                }
            })
        }
    }
    e(Un, si);
    const ai = "popover",
        li = "bs.popover",
        ci = `.${li}`,
        ui = "bs-popover",
        di = new RegExp(`(^|\\s)${ui}\\S+`, "g"),
        fi = {
            ...si.Default,
            placement: "right",
            offset: [0, 8],
            trigger: "click",
            content: "",
            template: '<div class="popover" role="tooltip"><div class="popover-arrow"></div><h3 class="popover-header"></h3><div class="popover-body"></div></div>'
        },
        hi = {
            ...si.DefaultType,
            content: "(string|element|function)"
        },
        pi = {
            HIDE: `hide${ci}`,
            HIDDEN: `hidden${ci}`,
            SHOW: `show${ci}`,
            SHOWN: `shown${ci}`,
            INSERTED: `inserted${ci}`,
            CLICK: `click${ci}`,
            FOCUSIN: `focusin${ci}`,
            FOCUSOUT: `focusout${ci}`,
            MOUSEENTER: `mouseenter${ci}`,
            MOUSELEAVE: `mouseleave${ci}`
        };
    class gi extends si {
        static get Default() {
            return fi
        }
        static get NAME() {
            return ai
        }
        static get DATA_KEY() {
            return li
        }
        static get Event() {
            return pi
        }
        static get EVENT_KEY() {
            return ci
        }
        static get DefaultType() {
            return hi
        }
        isWithContent() {
            return this.getTitle() || this._getContent()
        }
        setContent() {
            const e = this.getTipElement();
            this.setElementContent(U.findOne(".popover-header", e), this.getTitle());
            let t = this._getContent();
            "function" == typeof t && (t = t.call(this._element)), this.setElementContent(U.findOne(".popover-body", e), t), e.classList.remove("fade", "show")
        }
        _addAttachmentClass(e) {
            this.getTipElement().classList.add(`${ui}-${this.updateAttachment(e)}`)
        }
        _getContent() {
            return this._element.getAttribute("data-bs-content") || this.config.content
        }
        _cleanTipClass() {
            const t = this.getTipElement(),
                e = t.getAttribute("class").match(di);
            null !== e && 0 < e.length && e.map(e => e.trim()).forEach(e => t.classList.remove(e))
        }
        static jQueryInterface(n) {
            return this.each(function () {
                let e = _(this, li);
                var t = "object" == typeof n ? n : null;
                if ((e || !/dispose|hide/.test(n)) && (e || (e = new gi(this, t), b(this, li, e)), "string" == typeof n)) {
                    if (void 0 === e[n]) throw new TypeError(`No method named "${n}"`);
                    e[n]()
                }
            })
        }
    }
    e(ai, gi);
    const mi = "scrollspy",
        vi = "bs.scrollspy",
        yi = `.${vi}`;
    const bi = {
            offset: 10,
            method: "auto",
            target: ""
        },
        _i = {
            offset: "number",
            method: "string",
            target: "(string|element)"
        };
    yi, yi;
    yi;
    const wi = "dropdown-item",
        xi = "active",
        Ei = ".nav-link",
        Ti = ".list-group-item",
        Ci = "position";
    class Ai extends $ {
        constructor(e, t) {
            super(e), this._scrollElement = "BODY" === this._element.tagName ? window : this._element, this._config = this._getConfig(t), this._selector = `${this._config.target} ${Ei}, ${this._config.target} ${Ti}, ${this._config.target} .${wi}`, this._offsets = [], this._targets = [], this._activeTarget = null, this._scrollHeight = 0, H.on(this._scrollElement, "scroll.bs.scrollspy", () => this._process()), this.refresh(), this._process()
        }
        static get Default() {
            return bi
        }
        static get DATA_KEY() {
            return vi
        }
        refresh() {
            var e = this._scrollElement === this._scrollElement.window ? "offset" : Ci;
            const i = "auto" === this._config.method ? e : this._config.method,
                r = i === Ci ? this._getScrollTop() : 0;
            this._offsets = [], this._targets = [], this._scrollHeight = this._getScrollHeight();
            const t = U.find(this._selector);
            t.map(e => {
                var t = a(e);
                const n = t ? U.findOne(t) : null;
                if (n) {
                    e = n.getBoundingClientRect();
                    if (e.width || e.height) return [z[i](n).top + r, t]
                }
                return null
            }).filter(e => e).sort((e, t) => e[0] - t[0]).forEach(e => {
                this._offsets.push(e[0]), this._targets.push(e[1])
            })
        }
        dispose() {
            super.dispose(), H.off(this._scrollElement, yi), this._scrollElement = null, this._config = null, this._selector = null, this._offsets = null, this._targets = null, this._activeTarget = null, this._scrollHeight = null
        }
        _getConfig(t) {
            if ("string" != typeof (t = {
                    ...bi,
                    ..."object" == typeof t && t ? t : {}
                }).target && l(t.target)) {
                let {
                    id: e
                } = t.target;
                e || (e = s(mi), t.target.id = e), t.target = `#${e}`
            }
            return n(mi, t, _i), t
        }
        _getScrollTop() {
            return this._scrollElement === window ? this._scrollElement.pageYOffset : this._scrollElement.scrollTop
        }
        _getScrollHeight() {
            return this._scrollElement.scrollHeight || Math.max(document.body.scrollHeight, document.documentElement.scrollHeight)
        }
        _getOffsetHeight() {
            return this._scrollElement === window ? window.innerHeight : this._scrollElement.getBoundingClientRect().height
        }
        _process() {
            var t = this._getScrollTop() + this._config.offset,
                e = this._getScrollHeight(),
                n = this._config.offset + e - this._getOffsetHeight();
            if (this._scrollHeight !== e && this.refresh(), n <= t) {
                n = this._targets[this._targets.length - 1];
                this._activeTarget !== n && this._activate(n)
            } else {
                if (this._activeTarget && t < this._offsets[0] && 0 < this._offsets[0]) return this._activeTarget = null, void this._clear();
                for (let e = this._offsets.length; e--;) this._activeTarget !== this._targets[e] && t >= this._offsets[e] && (void 0 === this._offsets[e + 1] || t < this._offsets[e + 1]) && this._activate(this._targets[e])
            }
        }
        _activate(t) {
            this._activeTarget = t, this._clear();
            const e = this._selector.split(",").map(e => `${e}[data-bs-target="${t}"],${e}[href="${t}"]`),
                n = U.findOne(e.join(","));
            n.classList.contains(wi) ? (U.findOne(".dropdown-toggle", n.closest(".dropdown")).classList.add(xi), n.classList.add(xi)) : (n.classList.add(xi), U.parents(n, ".nav, .list-group").forEach(e => {
                U.prev(e, `${Ei}, ${Ti}`).forEach(e => e.classList.add(xi)), U.prev(e, ".nav-item").forEach(e => {
                    U.children(e, Ei).forEach(e => e.classList.add(xi))
                })
            })), H.trigger(this._scrollElement, "activate.bs.scrollspy", {
                relatedTarget: t
            })
        }
        _clear() {
            U.find(this._selector).filter(e => e.classList.contains(xi)).forEach(e => e.classList.remove(xi))
        }
        static jQueryInterface(n) {
            return this.each(function () {
                let e = _(this, vi);
                var t = "object" == typeof n && n;
                if (e = e || new Ai(this, t), "string" == typeof n) {
                    if (void 0 === e[n]) throw new TypeError(`No method named "${n}"`);
                    e[n]()
                }
            })
        }
    }
    H.on(window, "load.bs.scrollspy.data-api", () => {
        U.find('[data-bs-spy="scroll"]').forEach(e => new Ai(e, z.getDataAttributes(e)))
    }), e(mi, Ai);
    const ki = "bs.tab";
    ki;
    const Si = "active",
        Di = ".active",
        Li = ":scope > li > .active";
    class Oi extends $ {
        static get DATA_KEY() {
            return ki
        }
        show() {
            if (!(this._element.parentNode && this._element.parentNode.nodeType === Node.ELEMENT_NODE && this._element.classList.contains(Si) || f(this._element))) {
                let e;
                var t = r(this._element),
                    n = this._element.closest(".nav, .list-group");
                n && (i = "UL" === n.nodeName || "OL" === n.nodeName ? Li : Di, e = U.find(i, n), e = e[e.length - 1]);
                var i = e ? H.trigger(e, "hide.bs.tab", {
                    relatedTarget: this._element
                }) : null;
                H.trigger(this._element, "show.bs.tab", {
                    relatedTarget: e
                }).defaultPrevented || null !== i && i.defaultPrevented || (this._activate(this._element, n), n = () => {
                    H.trigger(e, "hidden.bs.tab", {
                        relatedTarget: this._element
                    }), H.trigger(this._element, "shown.bs.tab", {
                        relatedTarget: e
                    })
                }, t ? this._activate(t, t.parentNode, n) : n())
            }
        }
        _activate(e, t, n) {
            const i = (!t || "UL" !== t.nodeName && "OL" !== t.nodeName ? U.children(t, Di) : U.find(Li, t))[0];
            var r = n && i && i.classList.contains("fade"),
                t = () => this._transitionComplete(e, i, n);
            i && r ? (r = u(i), i.classList.remove("show"), H.one(i, "transitionend", t), d(i, r)) : t()
        }
        _transitionComplete(e, t, n) {
            if (t) {
                t.classList.remove(Si);
                const i = U.findOne(":scope > .dropdown-menu .active", t.parentNode);
                i && i.classList.remove(Si), "tab" === t.getAttribute("role") && t.setAttribute("aria-selected", !1)
            }
            e.classList.add(Si), "tab" === e.getAttribute("role") && e.setAttribute("aria-selected", !0), g(e), e.classList.contains("fade") && e.classList.add("show"), e.parentNode && e.parentNode.classList.contains("dropdown-menu") && (e.closest(".dropdown") && U.find(".dropdown-toggle").forEach(e => e.classList.add(Si)), e.setAttribute("aria-expanded", !0)), n && n()
        }
        static jQueryInterface(t) {
            return this.each(function () {
                const e = _(this, ki) || new Oi(this);
                if ("string" == typeof t) {
                    if (void 0 === e[t]) throw new TypeError(`No method named "${t}"`);
                    e[t]()
                }
            })
        }
    }
    H.on(document, "click.bs.tab.data-api", '[data-bs-toggle="tab"], [data-bs-toggle="pill"], [data-bs-toggle="list"]', function (e) {
        e.preventDefault();
        const t = _(this, ki) || new Oi(this);
        t.show()
    }), e("tab", Oi);
    const Ni = "bs.toast";
    Ot = `.${Ni}`;
    const ji = `click.dismiss${Ot}`,
        Pi = "show",
        Hi = "showing",
        $i = {
            animation: "boolean",
            autohide: "boolean",
            delay: "number"
        },
        Ii = {
            animation: !0,
            autohide: !0,
            delay: 5e3
        };
    class qi extends $ {
        constructor(e, t) {
            super(e), this._config = this._getConfig(t), this._timeout = null, this._setListeners()
        }
        static get DefaultType() {
            return $i
        }
        static get Default() {
            return Ii
        }
        static get DATA_KEY() {
            return Ni
        }
        show() {
            var e, t;
            H.trigger(this._element, "show.bs.toast").defaultPrevented || (this._clearTimeout(), this._config.animation && this._element.classList.add("fade"), e = () => {
                this._element.classList.remove(Hi), this._element.classList.add(Pi), H.trigger(this._element, "shown.bs.toast"), this._config.autohide && (this._timeout = setTimeout(() => {
                    this.hide()
                }, this._config.delay))
            }, this._element.classList.remove("hide"), g(this._element), this._element.classList.add(Hi), this._config.animation ? (t = u(this._element), H.one(this._element, "transitionend", e), d(this._element, t)) : e())
        }
        hide() {
            var e, t;
            this._element.classList.contains(Pi) && (H.trigger(this._element, "hide.bs.toast").defaultPrevented || (e = () => {
                this._element.classList.add("hide"), H.trigger(this._element, "hidden.bs.toast")
            }, this._element.classList.remove(Pi), this._config.animation ? (t = u(this._element), H.one(this._element, "transitionend", e), d(this._element, t)) : e()))
        }
        dispose() {
            this._clearTimeout(), this._element.classList.contains(Pi) && this._element.classList.remove(Pi), H.off(this._element, ji), super.dispose(), this._config = null
        }
        _getConfig(e) {
            return e = {
                ...Ii,
                ...z.getDataAttributes(this._element),
                ..."object" == typeof e && e ? e : {}
            }, n("toast", e, this.constructor.DefaultType), e
        }
        _setListeners() {
            H.on(this._element, ji, '[data-bs-dismiss="toast"]', () => this.hide())
        }
        _clearTimeout() {
            clearTimeout(this._timeout), this._timeout = null
        }
        static jQueryInterface(n) {
            return this.each(function () {
                let e = _(this, Ni);
                var t = "object" == typeof n && n;
                if (e = e || new qi(this, t), "string" == typeof n) {
                    if (void 0 === e[n]) throw new TypeError(`No method named "${n}"`);
                    e[n](this)
                }
            })
        }
    }
    return e("toast", qi), {
        Alert: q,
        Button: W,
        Carousel: oe,
        Collapse: ge,
        Dropdown: an,
        Modal: Tn,
        Offcanvas: Rn,
        Popover: gi,
        ScrollSpy: Ai,
        Tab: Oi,
        Toast: qi,
        Tooltip: si
    }
});
