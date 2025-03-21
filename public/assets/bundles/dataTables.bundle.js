var $jscomp = $jscomp || {};
$jscomp.scope = {}, $jscomp.findInternal = function (t, e, n) {
    for (var r = (t = t instanceof String ? String(t) : t).length, a = 0; a < r; a++) {
        var o = t[a];
        if (e.call(n, o, a, t)) return {
            i: a,
            v: o
        }
    }
    return {
        i: -1,
        v: void 0
    }
}, $jscomp.ASSUME_ES5 = !1, $jscomp.ASSUME_NO_NATIVE_MAP = !1, $jscomp.ASSUME_NO_NATIVE_SET = !1, $jscomp.SIMPLE_FROUND_POLYFILL = !1, $jscomp.ISOLATE_POLYFILLS = !1, $jscomp.defineProperty = $jscomp.ASSUME_ES5 || "function" == typeof Object.defineProperties ? Object.defineProperty : function (t, e, n) {
    return t == Array.prototype || t == Object.prototype || (t[e] = n.value), t
}, $jscomp.getGlobal = function (t) {
    t = ["object" == typeof globalThis && globalThis, t, "object" == typeof window && window, "object" == typeof self && self, "object" == typeof global && global];
    for (var e = 0; e < t.length; ++e) {
        var n = t[e];
        if (n && n.Math == Math) return n
    }
    throw Error("Cannot find global object")
}, $jscomp.global = $jscomp.getGlobal(this), $jscomp.IS_SYMBOL_NATIVE = "function" == typeof Symbol && "symbol" == typeof Symbol("x"), $jscomp.TRUST_ES6_POLYFILLS = !$jscomp.ISOLATE_POLYFILLS || $jscomp.IS_SYMBOL_NATIVE, $jscomp.polyfills = {}, $jscomp.propertyToPolyfillSymbol = {}, $jscomp.POLYFILL_PREFIX = "$jscp$";
var $jscomp$lookupPolyfilledValue = function (t, e) {
    var n = $jscomp.propertyToPolyfillSymbol[e];
    return null != n && void 0 !== (n = t[n]) ? n : t[e]
};
$jscomp.polyfill = function (t, e, n, r) {
        e && ($jscomp.ISOLATE_POLYFILLS ? $jscomp.polyfillIsolated(t, e, n, r) : $jscomp.polyfillUnisolated(t, e, n, r))
    }, $jscomp.polyfillUnisolated = function (t, e, n, r) {
        for (n = $jscomp.global, t = t.split("."), r = 0; r < t.length - 1; r++) {
            var a = t[r];
            if (!(a in n)) return;
            n = n[a]
        }(e = e(r = n[t = t[t.length - 1]])) != r && null != e && $jscomp.defineProperty(n, t, {
            configurable: !0,
            writable: !0,
            value: e
        })
    }, $jscomp.polyfillIsolated = function (t, e, n, r) {
        var a = t.split(".");
        t = 1 === a.length, r = a[0], r = !t && r in $jscomp.polyfills ? $jscomp.polyfills : $jscomp.global;
        for (var o = 0; o < a.length - 1; o++) {
            var i = a[o];
            if (!(i in r)) return;
            r = r[i]
        }
        a = a[a.length - 1], null != (e = e(n = $jscomp.IS_SYMBOL_NATIVE && "es6" === n ? r[a] : null)) && (t ? $jscomp.defineProperty($jscomp.polyfills, a, {
            configurable: !0,
            writable: !0,
            value: e
        }) : e !== n && ($jscomp.propertyToPolyfillSymbol[a] = $jscomp.IS_SYMBOL_NATIVE ? $jscomp.global.Symbol(a) : $jscomp.POLYFILL_PREFIX + a, a = $jscomp.propertyToPolyfillSymbol[a], $jscomp.defineProperty(r, a, {
            configurable: !0,
            writable: !0,
            value: e
        })))
    }, $jscomp.polyfill("Array.prototype.find", function (t) {
        return t || function (t, e) {
            return $jscomp.findInternal(this, t, e).v
        }
    }, "es6", "es3"),
    function (n) {
        "function" == typeof define && define.amd ? define(["jquery"], function (t) {
            return n(t, window, document)
        }) : "object" == typeof exports ? module.exports = function (t, e) {
            return t = t || window, e = e || ("undefined" != typeof window ? require("jquery") : require("jquery")(t)), n(e, t, t.document)
        } : n(jQuery, window, document)
    }(function (P, m, y, R) {
        function i(n) {
            var r, a, o = {};
            P.each(n, function (t, e) {
                (r = t.match(/^([^A-Z]+?)([A-Z])/)) && -1 !== "a aa ai ao as b fn i m o s ".indexOf(r[1] + " ") && (a = t.replace(r[0], r[2].toLowerCase()), o[a] = t, "o" === r[1] && i(n[t]))
            }), n._hungarianMap = o
        }

        function S(n, r, a) {
            var o;
            n._hungarianMap || i(n), P.each(r, function (t, e) {
                (o = n._hungarianMap[t]) === R || !a && r[o] !== R || ("o" === o.charAt(0) ? (r[o] || (r[o] = {}), P.extend(!0, r[o], r[t]), S(n[o], r[o], a)) : r[o] = r[t])
            })
        }

        function _(t) {
            var e, n = Kt.defaults.oLanguage,
                r = n.sDecimal;
            r && Wt(r), t && (e = t.sZeroRecords, !t.sEmptyTable && e && "No data available in table" === n.sEmptyTable && Pt(t, t, "sZeroRecords", "sEmptyTable"), !t.sLoadingRecords && e && "Loading..." === n.sLoadingRecords && Pt(t, t, "sZeroRecords", "sLoadingRecords"), t.sInfoThousands && (t.sThousands = t.sInfoThousands), (t = t.sDecimal) && r !== t && Wt(t))
        }

        function D(t) {
            if (ce(t, "ordering", "bSort"), ce(t, "orderMulti", "bSortMulti"), ce(t, "orderClasses", "bSortClasses"), ce(t, "orderCellsTop", "bSortCellsTop"), ce(t, "order", "aaSorting"), ce(t, "orderFixed", "aaSortingFixed"), ce(t, "paging", "bPaginate"), ce(t, "pagingType", "sPaginationType"), ce(t, "pageLength", "iDisplayLength"), ce(t, "searching", "bFilter"), "boolean" == typeof t.sScrollX && (t.sScrollX = t.sScrollX ? "100%" : ""), "boolean" == typeof t.scrollX && (t.scrollX = t.scrollX ? "100%" : ""), t = t.aoSearchCols)
                for (var e = 0, n = t.length; e < n; e++) t[e] && S(Kt.models.oSearch, t[e])
        }

        function w(t) {
            ce(t, "orderable", "bSortable"), ce(t, "orderData", "aDataSort"), ce(t, "orderSequence", "asSorting"), ce(t, "orderDataType", "sortDataType");
            var e = t.aDataSort;
            "number" != typeof e || Array.isArray(e) || (t.aDataSort = [e])
        }

        function T(t) {
            var e, n, r, a;
            Kt.__browser || (Kt.__browser = e = {}, a = (r = (n = P("<div/>").css({
                position: "fixed",
                top: 0,
                left: -1 * P(m).scrollLeft(),
                height: 1,
                width: 1,
                overflow: "hidden"
            }).append(P("<div/>").css({
                position: "absolute",
                top: 1,
                left: 1,
                width: 100,
                overflow: "scroll"
            }).append(P("<div/>").css({
                width: "100%",
                height: 10
            }))).appendTo("body")).children()).children(), e.barWidth = r[0].offsetWidth - r[0].clientWidth, e.bScrollOversize = 100 === a[0].offsetWidth && 100 !== r[0].clientWidth, e.bScrollbarLeft = 1 !== Math.round(a.offset().left), e.bBounding = !!n[0].getBoundingClientRect().width, n.remove()), P.extend(t.oBrowser, Kt.__browser), t.oScroll.iBarWidth = Kt.__browser.barWidth
        }

        function n(t, e, n, r, a, o) {
            var i, s = !1;
            for (n !== R && (i = n, s = !0); r !== a;) t.hasOwnProperty(r) && (i = s ? e(i, t[r], r, t) : t[r], s = !0, r += o);
            return i
        }

        function x(t, e) {
            var n = Kt.defaults.column,
                r = t.aoColumns.length,
                n = P.extend({}, Kt.models.oColumn, n, {
                    nTh: e || y.createElement("th"),
                    sTitle: n.sTitle || (e ? e.innerHTML : ""),
                    aDataSort: n.aDataSort || [r],
                    mData: n.mData || r,
                    idx: r
                });
            t.aoColumns.push(n), (n = t.aoPreSearchCols)[r] = P.extend({}, Kt.models.oSearch, n[r]), C(t, r, P(e).data())
        }

        function C(t, e, n) {
            e = t.aoColumns[e];
            var r, a = t.oClasses,
                o = P(e.nTh);
            e.sWidthOrig || (e.sWidthOrig = o.attr("width") || null, (r = (o.attr("style") || "").match(/width:\s*(\d+[pxem%]+)/)) && (e.sWidthOrig = r[1])), n !== R && null !== n && (w(n), S(Kt.defaults.column, n, !0), n.mDataProp === R || n.mData || (n.mData = n.mDataProp), n.sType && (e._sManualType = n.sType), n.className && !n.sClass && (n.sClass = n.className), n.sClass && o.addClass(n.sClass), P.extend(e, n), Pt(e, n, "sWidth", "sWidthOrig"), n.iDataSort !== R && (e.aDataSort = [n.iDataSort]), Pt(e, n, "aDataSort"));
            var i = e.mData,
                s = k(i),
                l = e.mRender ? k(e.mRender) : null;
            n = function (t) {
                return "string" == typeof t && -1 !== t.indexOf("@")
            }, e._bAttrSrc = P.isPlainObject(i) && (n(i.sort) || n(i.type) || n(i.filter)), e._setter = null, e.fnGetData = function (t, e, n) {
                var r = s(t, e, R, n);
                return l && e ? l(r, e, t, n) : r
            }, e.fnSetData = function (t, e, n) {
                return p(i)(t, e, n)
            }, "number" != typeof i && (t._rowReadObject = !0), t.oFeatures.bSort || (e.bSortable = !1, o.addClass(a.sSortableNone)), t = -1 !== P.inArray("asc", e.asSorting), n = -1 !== P.inArray("desc", e.asSorting), e.bSortable && (t || n) ? t && !n ? (e.sSortingClass = a.sSortableAsc, e.sSortingClassJUI = a.sSortJUIAscAllowed) : !t && n ? (e.sSortingClass = a.sSortableDesc, e.sSortingClassJUI = a.sSortJUIDescAllowed) : (e.sSortingClass = a.sSortable, e.sSortingClassJUI = a.sSortJUI) : (e.sSortingClass = a.sSortableNone, e.sSortingClassJUI = "")
        }

        function O(t) {
            if (!1 !== t.oFeatures.bAutoWidth) {
                var e = t.aoColumns;
                bt(t);
                for (var n = 0, r = e.length; n < r; n++) e[n].nTh.style.width = e[n].sWidth
            }
            "" === (e = t.oScroll).sY && "" === e.sX || pt(t), kt(t, null, "column-sizing", [t])
        }

        function N(t, e) {
            return "number" == typeof (t = I(t, "bVisible"))[e] ? t[e] : null
        }

        function c(t, e) {
            return t = I(t, "bVisible"), -1 !== (e = P.inArray(e, t)) ? e : null
        }

        function v(t) {
            var n = 0;
            return P.each(t.aoColumns, function (t, e) {
                e.bVisible && "none" !== P(e.nTh).css("display") && n++
            }), n
        }

        function I(t, n) {
            var r = [];
            return P.map(t.aoColumns, function (t, e) {
                t[n] && r.push(e)
            }), r
        }

        function s(t) {
            for (var e = t.aoColumns, n = t.aoData, r = Kt.ext.type.detect, a = 0, o = e.length; a < o; a++) {
                var i = e[a],
                    s = [];
                if (!i.sType && i._sManualType) i.sType = i._sManualType;
                else if (!i.sType) {
                    for (var l = 0, c = r.length; l < c; l++) {
                        for (var u = 0, d = n.length; u < d; u++) {
                            s[u] === R && (s[u] = F(t, u, a, "type"));
                            var f = r[l](s[u], t);
                            if (!f && l !== r.length - 1) break;
                            if ("html" === f) break
                        }
                        if (f) {
                            i.sType = f;
                            break
                        }
                    }
                    i.sType || (i.sType = "string")
                }
            }
        }

        function A(t, e, n, r) {
            var a, o = t.aoColumns;
            if (e)
                for (a = e.length - 1; 0 <= a; a--)
                    for (var i = e[a], s = i.targets !== R ? i.targets : i.aTargets, l = 0, c = (s = !Array.isArray(s) ? [s] : s).length; l < c; l++)
                        if ("number" == typeof s[l] && 0 <= s[l]) {
                            for (; o.length <= s[l];) x(t);
                            r(s[l], i)
                        } else if ("number" == typeof s[l] && s[l] < 0) r(o.length + s[l], i);
            else if ("string" == typeof s[l])
                for (var u = 0, d = o.length; u < d; u++) "_all" != s[l] && !P(o[u].nTh).hasClass(s[l]) || r(u, i);
            if (n)
                for (a = 0, t = n.length; a < t; a++) r(a, n[a])
        }

        function j(t, e, n, r) {
            var a = t.aoData.length,
                o = P.extend(!0, {}, Kt.models.oRow, {
                    src: n ? "dom" : "data",
                    idx: a
                });
            o._aData = e, t.aoData.push(o);
            for (var i = t.aoColumns, s = 0, l = i.length; s < l; s++) i[s].sType = null;
            return t.aiDisplayMaster.push(a), (e = t.rowIdFn(e)) !== R && (t.aIds[e] = o), !n && t.oFeatures.bDeferRender || b(t, a, n, r), a
        }

        function L(n, t) {
            var r;
            return (t = !(t instanceof P) ? P(t) : t).map(function (t, e) {
                return r = f(n, e), j(n, r.data, e, r.cells)
            })
        }

        function F(t, e, n, r) {
            var a = t.iDraw,
                o = t.aoColumns[n],
                i = t.aoData[e]._aData,
                s = o.sDefaultContent,
                l = o.fnGetData(i, r, {
                    settings: t,
                    row: e,
                    col: n
                });
            if (l === R) return t.iDrawError != a && null === s && (Ft(t, 0, "Requested unknown parameter " + ("function" == typeof o.mData ? "{function}" : "'" + o.mData + "'") + " for row " + e + ", column " + n, 4), t.iDrawError = a), s;
            if (l !== i && null !== l || null === s || r === R) {
                if ("function" == typeof l) return l.call(i)
            } else l = s;
            return null === l && "display" == r ? "" : l
        }

        function r(t, e, n, r) {
            t.aoColumns[n].fnSetData(t.aoData[e]._aData, r, {
                settings: t,
                row: e,
                col: n
            })
        }

        function u(t) {
            return P.map(t.match(/(\\.|[^\.])+/g) || [""], function (t) {
                return t.replace(/\\\./g, ".")
            })
        }

        function k(a) {
            if (P.isPlainObject(a)) {
                var o = {};
                return P.each(a, function (t, e) {
                        e && (o[t] = k(e))
                    }),
                    function (t, e, n, r) {
                        var a = o[e] || o._;
                        return a !== R ? a(t, e, n, r) : t
                    }
            }
            if (null === a) return function (t) {
                return t
            };
            if ("function" == typeof a) return function (t, e, n, r) {
                return a(t, e, n, r)
            };
            if ("string" != typeof a || -1 === a.indexOf(".") && -1 === a.indexOf("[") && -1 === a.indexOf("(")) return function (t, e) {
                return t[a]
            };
            var s = function (t, e, n) {
                if ("" !== n)
                    for (var r = u(n), a = 0, o = r.length; a < o; a++) {
                        n = r[a].match(ue);
                        var i = r[a].match(de);
                        if (n) {
                            if (r[a] = r[a].replace(ue, ""), "" !== r[a] && (t = t[r[a]]), i = [], r.splice(0, a + 1), r = r.join("."), Array.isArray(t))
                                for (a = 0, o = t.length; a < o; a++) i.push(s(t[a], e, r));
                            t = "" === (t = n[0].substring(1, n[0].length - 1)) ? i : i.join(t);
                            break
                        }
                        if (i) r[a] = r[a].replace(de, ""), t = t[r[a]]();
                        else {
                            if (null === t || t[r[a]] === R) return R;
                            t = t[r[a]]
                        }
                    }
                return t
            };
            return function (t, e) {
                return s(t, e, a)
            }
        }

        function p(r) {
            if (P.isPlainObject(r)) return p(r._);
            if (null === r) return function () {};
            if ("function" == typeof r) return function (t, e, n) {
                r(t, "set", e, n)
            };
            if ("string" != typeof r || -1 === r.indexOf(".") && -1 === r.indexOf("[") && -1 === r.indexOf("(")) return function (t, e) {
                t[r] = e
            };
            var l = function (t, e, n) {
                for (var r, a, o = (n = u(n))[n.length - 1], i = 0, s = n.length - 1; i < s; i++) {
                    if ("__proto__" === n[i]) throw Error("Cannot set prototype values");
                    if (r = n[i].match(ue), a = n[i].match(de), r) {
                        if (n[i] = n[i].replace(ue, ""), t[n[i]] = [], (o = n.slice()).splice(0, i + 1), r = o.join("."), Array.isArray(e))
                            for (a = 0, s = e.length; a < s; a++) l(o = {}, e[a], r), t[n[i]].push(o);
                        else t[n[i]] = e;
                        return
                    }
                    a && (n[i] = n[i].replace(de, ""), t = t[n[i]](e)), null !== t[n[i]] && t[n[i]] !== R || (t[n[i]] = {}), t = t[n[i]]
                }
                o.match(de) ? t[o.replace(de, "")](e) : t[o.replace(ue, "")] = e
            };
            return function (t, e) {
                return l(t, e, r)
            }
        }

        function g(t) {
            return ie(t.aoData, "_aData")
        }

        function l(t) {
            t.aoData.length = 0, t.aiDisplayMaster.length = 0, t.aiDisplay.length = 0, t.aIds = {}
        }

        function d(t, e, n) {
            for (var r = -1, a = 0, o = t.length; a < o; a++) t[a] == e ? r = a : t[a] > e && t[a]--; - 1 != r && n === R && t.splice(r, 1)
        }

        function a(n, r, t, e) {
            var a, o = n.aoData[r],
                i = function (t, e) {
                    for (; t.childNodes.length;) t.removeChild(t.firstChild);
                    t.innerHTML = F(n, r, e, "display")
                };
            if ("dom" !== t && (t && "auto" !== t || "dom" !== o.src)) {
                var s = o.anCells;
                if (s)
                    if (e !== R) i(s[e], e);
                    else
                        for (t = 0, a = s.length; t < a; t++) i(s[t], t)
            } else o._aData = f(n, o, e, e === R ? R : o._aData).data;
            if (o._aSortData = null, o._aFilterData = null, i = n.aoColumns, e !== R) i[e].sType = null;
            else {
                for (t = 0, a = i.length; t < a; t++) i[t].sType = null;
                h(n, o)
            }
        }

        function f(t, e, n, r) {
            var a, o, i = [],
                s = e.firstChild,
                l = 0,
                c = t.aoColumns,
                u = t._rowReadObject;
            r = r !== R ? r : u ? {} : [];

            function d(t, e) {
                var n;
                "string" != typeof t || -1 !== (n = t.indexOf("@")) && (n = t.substring(n + 1), p(t)(r, e.getAttribute(n)))
            }

            function f(t) {
                n !== R && n !== l || (a = c[l], o = t.innerHTML.trim(), a && a._bAttrSrc ? (p(a.mData._)(r, o), d(a.mData.sort, t), d(a.mData.type, t), d(a.mData.filter, t)) : u ? (a._setter || (a._setter = p(a.mData)), a._setter(r, o)) : r[l] = o), l++
            }
            if (s)
                for (; s;) {
                    var h = s.nodeName.toUpperCase();
                    "TD" != h && "TH" != h || (f(s), i.push(s)), s = s.nextSibling
                } else
                    for (s = 0, h = (i = e.anCells).length; s < h; s++) f(i[s]);
            return (e = e.firstChild ? e : e.nTr) && (e = e.getAttribute("id")) && p(t.rowId)(r, e), {
                data: r,
                cells: i
            }
        }

        function b(t, e, n, r) {
            var a, o = t.aoData[e],
                i = o._aData,
                s = [];
            if (null === o.nTr) {
                var l = n || y.createElement("tr");
                o.nTr = l, o.anCells = s, l._DT_RowIndex = e, h(t, o);
                for (var c = 0, u = t.aoColumns.length; c < u; c++) {
                    var d = t.aoColumns[c],
                        f = (a = !n) ? y.createElement(d.sCellType) : r[c];
                    f._DT_CellIndex = {
                        row: e,
                        column: c
                    }, s.push(f), !a && (n && !d.mRender && d.mData === c || P.isPlainObject(d.mData) && d.mData._ === c + ".display") || (f.innerHTML = F(t, e, c, "display")), d.sClass && (f.className += " " + d.sClass), d.bVisible && !n ? l.appendChild(f) : !d.bVisible && n && f.parentNode.removeChild(f), d.fnCreatedCell && d.fnCreatedCell.call(t.oInstance, f, F(t, e, c), i, e, c)
                }
                kt(t, "aoRowCreatedCallback", null, [l, i, e, s])
            }
            o.nTr.setAttribute("role", "row")
        }

        function h(t, e) {
            var n = e.nTr,
                r = e._aData;
            n && ((t = t.rowIdFn(r)) && (n.id = t), r.DT_RowClass && (t = r.DT_RowClass.split(" "), e.__rowc = e.__rowc ? se(e.__rowc.concat(t)) : t, P(n).removeClass(e.__rowc.join(" ")).addClass(r.DT_RowClass)), r.DT_RowAttr && P(n).attr(r.DT_RowAttr), r.DT_RowData && P(n).data(r.DT_RowData))
        }

        function $(t) {
            var e, n = t.nTHead,
                r = t.nTFoot,
                a = 0 === P("th, td", n).length,
                o = t.oClasses,
                i = t.aoColumns;
            a && (e = P("<tr/>").appendTo(n));
            for (var s = 0, l = i.length; s < l; s++) {
                var c = i[s],
                    u = P(c.nTh).addClass(c.sClass);
                a && u.appendTo(e), t.oFeatures.bSort && (u.addClass(c.sSortingClass), !1 !== c.bSortable && (u.attr("tabindex", t.iTabIndex).attr("aria-controls", t.sTableId), xt(t, c.nTh, s))), c.sTitle != u[0].innerHTML && u.html(c.sTitle), Et(t, "header")(t, u, c, o)
            }
            if (a && B(t.aoHeader, n), P(n).children("tr").attr("role", "row"), P(n).children("tr").children("th, td").addClass(o.sHeaderTH), P(r).children("tr").children("th, td").addClass(o.sFooterTH), null !== r)
                for (l = (t = t.aoFooter[s = 0]).length; s < l; s++)(c = i[s]).nTf = t[s].cell, c.sClass && P(c.nTf).addClass(c.sClass)
        }

        function E(t, e, n) {
            var r, a = [],
                o = [],
                i = t.aoColumns.length;
            if (e) {
                n === R && (n = !1);
                for (var s = 0, l = e.length; s < l; s++) {
                    for (a[s] = e[s].slice(), a[s].nTr = e[s].nTr, r = i - 1; 0 <= r; r--) t.aoColumns[r].bVisible || n || a[s].splice(r, 1);
                    o.push([])
                }
                for (s = 0, l = a.length; s < l; s++) {
                    if (t = a[s].nTr)
                        for (; r = t.firstChild;) t.removeChild(r);
                    for (r = 0, e = a[s].length; r < e; r++) {
                        var c = i = 1;
                        if (o[s][r] === R) {
                            for (t.appendChild(a[s][r].cell), o[s][r] = 1; a[s + i] !== R && a[s][r].cell == a[s + i][r].cell;) o[s + i][r] = 1, i++;
                            for (; a[s][r + c] !== R && a[s][r].cell == a[s][r + c].cell;) {
                                for (n = 0; n < i; n++) o[s + n][r + c] = 1;
                                c++
                            }
                            P(a[s][r].cell).attr("rowspan", i).attr("colspan", c)
                        }
                    }
                }
            }
        }

        function H(t) {
            var e = kt(t, "aoPreDrawCallback", "preDraw", [t]);
            if (-1 !== P.inArray(!1, e)) ft(t, !1);
            else {
                var e = [],
                    n = 0,
                    r = t.asStripeClasses,
                    a = r.length,
                    o = t.oLanguage,
                    i = t.iInitDisplayStart,
                    s = "ssp" == Ht(t),
                    l = t.aiDisplay;
                t.bDrawing = !0, i !== R && -1 !== i && (t._iDisplayStart = !s && i >= t.fnRecordsDisplay() ? 0 : i, t.iInitDisplayStart = -1);
                var i = t._iDisplayStart,
                    c = t.fnDisplayEnd();
                if (t.bDeferLoading) t.bDeferLoading = !1, t.iDraw++, ft(t, !1);
                else if (s) {
                    if (!t.bDestroying && !X(t)) return
                } else t.iDraw++;
                if (0 !== l.length)
                    for (o = s ? t.aoData.length : c, s = s ? 0 : i; s < o; s++) {
                        var u = l[s],
                            d = t.aoData[u];
                        null === d.nTr && b(t, u);
                        var f, h = d.nTr;
                        0 !== a && (f = r[n % a], d._sRowStripe != f && (P(h).removeClass(d._sRowStripe).addClass(f), d._sRowStripe = f)), kt(t, "aoRowCallback", null, [h, d._aData, n, s, u]), e.push(h), n++
                    } else n = o.sZeroRecords, 1 == t.iDraw && "ajax" == Ht(t) ? n = o.sLoadingRecords : o.sEmptyTable && 0 === t.fnRecordsTotal() && (n = o.sEmptyTable), e[0] = P("<tr/>", {
                        class: a ? r[0] : ""
                    }).append(P("<td />", {
                        valign: "top",
                        colSpan: v(t),
                        class: t.oClasses.sRowEmpty
                    }).html(n))[0];
                kt(t, "aoHeaderCallback", "header", [P(t.nTHead).children("tr")[0], g(t), i, c, l]), kt(t, "aoFooterCallback", "footer", [P(t.nTFoot).children("tr")[0], g(t), i, c, l]), (r = P(t.nTBody)).children().detach(), r.append(P(e)), kt(t, "aoDrawCallback", "draw", [t]), t.bSorted = !1, t.bFiltered = !1, t.bDrawing = !1
            }
        }

        function M(t, e) {
            var n = t.oFeatures,
                r = n.bFilter;
            n.bSort && Dt(t), r ? Y(t, t.oPreviousSearch) : t.aiDisplay = t.aiDisplayMaster.slice(), !0 !== e && (t._iDisplayStart = 0), t._drawHold = e, H(t), t._drawHold = !1
        }

        function W(t) {
            var e = t.oClasses,
                n = P(t.nTable),
                n = P("<div/>").insertBefore(n),
                r = t.oFeatures,
                a = P("<div/>", {
                    id: t.sTableId + "_wrapper",
                    class: e.sWrapper + (t.nTFoot ? "" : " " + e.sNoFooter)
                });
            t.nHolding = n[0], t.nTableWrapper = a[0], t.nTableReinsertBefore = t.nTable.nextSibling;
            for (var o, i, s, l, c, u, d = t.sDom.split(""), f = 0; f < d.length; f++) {
                if (o = null, "<" == (i = d[f])) {
                    if (s = P("<div/>")[0], "'" == (l = d[f + 1]) || '"' == l) {
                        for (c = "", u = 2; d[f + u] != l;) c += d[f + u], u++;
                        "H" == c ? c = e.sJUIHeader : "F" == c && (c = e.sJUIFooter), -1 != c.indexOf(".") ? (l = c.split("."), s.id = l[0].substr(1, l[0].length - 1), s.className = l[1]) : "#" == c.charAt(0) ? s.id = c.substr(1, c.length - 1) : s.className = c, f += u
                    }
                    a.append(s), a = P(s)
                } else if (">" == i) a = a.parent();
                else if ("l" == i && r.bPaginate && r.bLengthChange) o = lt(t);
                else if ("f" == i && r.bFilter) o = z(t);
                else if ("r" == i && r.bProcessing) o = dt(t);
                else if ("t" == i) o = ht(t);
                else if ("i" == i && r.bInfo) o = nt(t);
                else if ("p" == i && r.bPaginate) o = ct(t);
                else if (0 !== Kt.ext.feature.length)
                    for (u = 0, l = (s = Kt.ext.feature).length; u < l; u++)
                        if (i == s[u].cFeature) {
                            o = s[u].fnInit(t);
                            break
                        } o && ((s = t.aanFeatures)[i] || (s[i] = []), s[i].push(o), a.append(o))
            }
            n.replaceWith(a), t.nHolding = null
        }

        function B(t, e) {
            e = P(e).children("tr"), t.splice(0, t.length);
            for (var n = 0, r = e.length; n < r; n++) t.push([]);
            for (n = 0, r = e.length; n < r; n++)
                for (var a = e[n], o = a.firstChild; o;) {
                    if ("TD" == o.nodeName.toUpperCase() || "TH" == o.nodeName.toUpperCase()) {
                        for (var i = (i = +o.getAttribute("colspan")) && 0 !== i && 1 !== i ? i : 1, s = (s = +o.getAttribute("rowspan")) && 0 !== s && 1 !== s ? s : 1, l = 0, c = t[n]; c[l];) l++;
                        var u = l,
                            d = 1 === i;
                        for (c = 0; c < i; c++)
                            for (l = 0; l < s; l++) t[n + l][u + c] = {
                                cell: o,
                                unique: d
                            }, t[n + l].nTr = a
                    }
                    o = o.nextSibling
                }
        }

        function U(t, e, n) {
            var r = [];
            n || (n = t.aoHeader, e && B(n = [], e)), e = 0;
            for (var a = n.length; e < a; e++)
                for (var o = 0, i = n[e].length; o < i; o++) !n[e][o].unique || r[o] && t.bSortCellsTop || (r[o] = n[e][o].cell);
            return r
        }

        function V(r, t, e) {
            var n, a;
            kt(r, "aoServerParams", "serverParams", [t]), t && Array.isArray(t) && (n = {}, a = /(.*?)\[\]$/, P.each(t, function (t, e) {
                (t = e.name.match(a)) ? (t = t[0], n[t] || (n[t] = []), n[t].push(e.value)) : n[e.name] = e.value
            }), t = n);

            function o(t) {
                kt(r, null, "xhr", [r, t, r.jqXHR]), e(t)
            }
            var i, s, l = r.ajax,
                c = r.oInstance;
            P.isPlainObject(l) && l.data && (s = "function" == typeof (i = l.data) ? i(t, r) : i, t = "function" == typeof i && s ? s : P.extend(!0, t, s), delete l.data), s = {
                data: t,
                success: function (t) {
                    var e = t.error || t.sError;
                    e && Ft(r, 0, e), r.json = t, o(t)
                },
                dataType: "json",
                cache: !1,
                type: r.sServerMethod,
                error: function (t, e, n) {
                    n = kt(r, null, "xhr", [r, null, r.jqXHR]), -1 === P.inArray(!0, n) && ("parsererror" == e ? Ft(r, 0, "Invalid JSON response", 1) : 4 === t.readyState && Ft(r, 0, "Ajax error", 7)), ft(r, !1)
                }
            }, r.oAjaxData = t, kt(r, null, "preXhr", [r, t]), r.fnServerData ? r.fnServerData.call(c, r.sAjaxSource, P.map(t, function (t, e) {
                return {
                    name: e,
                    value: t
                }
            }), o, r) : r.sAjaxSource || "string" == typeof l ? r.jqXHR = P.ajax(P.extend(s, {
                url: l || r.sAjaxSource
            })) : "function" == typeof l ? r.jqXHR = l.call(c, t, o, r) : (r.jqXHR = P.ajax(P.extend(s, l)), l.data = i)
        }

        function X(e) {
            return !e.bAjaxDataGet || (e.iDraw++, ft(e, !0), V(e, t(e), function (t) {
                o(e, t)
            }), !1)
        }

        function t(t) {
            function n(t, e) {
                s.push({
                    name: t,
                    value: e
                })
            }
            var e = t.aoColumns,
                r = e.length,
                a = t.oFeatures,
                o = t.oPreviousSearch,
                i = t.aoPreSearchCols,
                s = [],
                l = _t(t),
                c = t._iDisplayStart,
                u = !1 !== a.bPaginate ? t._iDisplayLength : -1;
            n("sEcho", t.iDraw), n("iColumns", r), n("sColumns", ie(e, "sName").join(",")), n("iDisplayStart", c), n("iDisplayLength", u);
            for (var d = {
                    draw: t.iDraw,
                    columns: [],
                    order: [],
                    start: c,
                    length: u,
                    search: {
                        value: o.sSearch,
                        regex: o.bRegex
                    }
                }, c = 0; c < r; c++) {
                var f = e[c],
                    h = i[c],
                    u = "function" == typeof f.mData ? "function" : f.mData;
                d.columns.push({
                    data: u,
                    name: f.sName,
                    searchable: f.bSearchable,
                    orderable: f.bSortable,
                    search: {
                        value: h.sSearch,
                        regex: h.bRegex
                    }
                }), n("mDataProp_" + c, u), a.bFilter && (n("sSearch_" + c, h.sSearch), n("bRegex_" + c, h.bRegex), n("bSearchable_" + c, f.bSearchable)), a.bSort && n("bSortable_" + c, f.bSortable)
            }
            return a.bFilter && (n("sSearch", o.sSearch), n("bRegex", o.bRegex)), a.bSort && (P.each(l, function (t, e) {
                d.order.push({
                    column: e.col,
                    dir: e.dir
                }), n("iSortCol_" + t, e.col), n("sSortDir_" + t, e.dir)
            }), n("iSortingCols", l.length)), null === (e = Kt.ext.legacy.ajax) ? t.sAjaxSource ? s : d : e ? s : d
        }

        function o(t, n) {
            var e = function (t, e) {
                    return n[t] !== R ? n[t] : n[e]
                },
                r = q(t, n),
                a = e("sEcho", "draw"),
                o = e("iTotalRecords", "recordsTotal"),
                e = e("iTotalDisplayRecords", "recordsFiltered");
            if (a !== R) {
                if (+a < t.iDraw) return;
                t.iDraw = +a
            }
            for (l(t), t._iRecordsTotal = parseInt(o, 10), t._iRecordsDisplay = parseInt(e, 10), a = 0, o = r.length; a < o; a++) j(t, r[a]);
            t.aiDisplay = t.aiDisplayMaster.slice(), t.bAjaxDataGet = !1, H(t), t._bInitComplete || it(t, n), t.bAjaxDataGet = !0, ft(t, !1)
        }

        function q(t, e) {
            return "data" === (t = P.isPlainObject(t.ajax) && t.ajax.dataSrc !== R ? t.ajax.dataSrc : t.sAjaxDataProp) ? e.aaData || e[t] : "" !== t ? k(t)(e) : e
        }

        function z(n) {
            function e() {
                var t = this.value || "";
                t != o.sSearch && (Y(n, {
                    sSearch: t,
                    bRegex: o.bRegex,
                    bSmart: o.bSmart,
                    bCaseInsensitive: o.bCaseInsensitive
                }), n._iDisplayStart = 0, H(n))
            }
            var t = n.oClasses,
                r = n.sTableId,
                a = n.oLanguage,
                o = n.oPreviousSearch,
                i = n.aanFeatures,
                s = '<input type="search" class="' + t.sFilterInput + '"/>',
                l = (l = a.sSearch).match(/_INPUT_/) ? l.replace("_INPUT_", s) : l + s,
                t = P("<div/>", {
                    id: i.f ? null : r + "_filter",
                    class: t.sFilter
                }).append(P("<label/>").append(l)),
                i = null !== n.searchDelay ? n.searchDelay : "ssp" === Ht(n) ? 400 : 0,
                c = P("input", t).val(o.sSearch).attr("placeholder", a.sSearchPlaceholder).on("keyup.DT search.DT input.DT paste.DT cut.DT", i ? be(e, i) : e).on("mouseup", function (t) {
                    setTimeout(function () {
                        e.call(c[0])
                    }, 10)
                }).on("keypress.DT", function (t) {
                    if (13 == t.keyCode) return !1
                }).attr("aria-controls", r);
            return P(n.nTable).on("search.dt.DT", function (t, e) {
                if (n === e) try {
                    c[0] !== y.activeElement && c.val(o.sSearch)
                } catch (t) {}
            }), t[0]
        }

        function Y(t, e, n) {
            function r(t) {
                o.sSearch = t.sSearch, o.bRegex = t.bRegex, o.bSmart = t.bSmart, o.bCaseInsensitive = t.bCaseInsensitive
            }

            function a(t) {
                return t.bEscapeRegex !== R ? !t.bEscapeRegex : t.bRegex
            }
            var o = t.oPreviousSearch,
                i = t.aoPreSearchCols;
            if (s(t), "ssp" != Ht(t)) {
                for (Z(t, e.sSearch, n, a(e), e.bSmart, e.bCaseInsensitive), r(e), e = 0; e < i.length; e++) G(t, i[e].sSearch, e, a(i[e]), i[e].bSmart, i[e].bCaseInsensitive);
                J(t)
            } else r(e);
            t.bFiltered = !0, kt(t, null, "search", [t])
        }

        function J(t) {
            for (var e, n, r = Kt.ext.search, a = t.aiDisplay, o = 0, i = r.length; o < i; o++) {
                for (var s = [], l = 0, c = a.length; l < c; l++) n = a[l], e = t.aoData[n], r[o](t, e._aFilterData, n, e._aData, l) && s.push(n);
                a.length = 0, P.merge(a, s)
            }
        }

        function G(t, e, n, r, a, o) {
            if ("" !== e) {
                var i = [],
                    s = t.aiDisplay;
                for (r = Q(e, r, a, o), a = 0; a < s.length; a++) e = t.aoData[s[a]]._aFilterData[n], r.test(e) && i.push(s[a]);
                t.aiDisplay = i
            }
        }

        function Z(t, e, n, r, a, o) {
            a = Q(e, r, a, o);
            var i = t.oPreviousSearch.sSearch,
                s = t.aiDisplayMaster;
            o = [], 0 !== Kt.ext.search.length && (n = !0);
            var l = K(t);
            if (e.length <= 0) t.aiDisplay = s.slice();
            else {
                for ((l || n || r || i.length > e.length || 0 !== e.indexOf(i) || t.bSorted) && (t.aiDisplay = s.slice()), e = t.aiDisplay, n = 0; n < e.length; n++) a.test(t.aoData[e[n]]._sFilterRow) && o.push(e[n]);
                t.aiDisplay = o
            }
        }

        function Q(t, e, n, r) {
            return t = e ? t : fe(t), n && (t = "^(?=.*?" + P.map(t.match(/"[^"]+"|[^ ]+/g) || [""], function (t) {
                var e;
                return (t = '"' === t.charAt(0) ? (e = t.match(/^"(.*)"$/)) ? e[1] : t : t).replace('"', "")
            }).join(")(?=.*?") + ").*$"), new RegExp(t, r ? "i" : "")
        }

        function K(t) {
            for (var e = t.aoColumns, n = Kt.ext.type.search, r = !1, a = 0, o = t.aoData.length; a < o; a++) {
                var i = t.aoData[a];
                if (!i._aFilterData) {
                    for (var s, l = [], c = 0, u = e.length; c < u; c++)(r = e[c]).bSearchable ? (s = F(t, a, c, "filter"), "string" != typeof (s = null === (s = n[r.sType] ? n[r.sType](s) : s) ? "" : s) && s.toString && (s = s.toString())) : s = "", s.indexOf && -1 !== s.indexOf("&") && (he.innerHTML = s, s = pe ? he.textContent : he.innerText), s.replace && (s = s.replace(/[\r\n\u2028]/g, "")), l.push(s);
                    i._aFilterData = l, i._sFilterRow = l.join("  "), r = !0
                }
            }
            return r
        }

        function tt(t) {
            return {
                search: t.sSearch,
                smart: t.bSmart,
                regex: t.bRegex,
                caseInsensitive: t.bCaseInsensitive
            }
        }

        function et(t) {
            return {
                sSearch: t.search,
                bSmart: t.smart,
                bRegex: t.regex,
                bCaseInsensitive: t.caseInsensitive
            }
        }

        function nt(t) {
            var e = t.sTableId,
                n = t.aanFeatures.i,
                r = P("<div/>", {
                    class: t.oClasses.sInfo,
                    id: n ? null : e + "_info"
                });
            return n || (t.aoDrawCallback.push({
                fn: rt,
                sName: "information"
            }), r.attr("role", "status").attr("aria-live", "polite"), P(t.nTable).attr("aria-describedby", e + "_info")), r[0]
        }

        function rt(t) {
            var e, n, r, a, o, i, s = t.aanFeatures.i;
            0 !== s.length && (e = t.oLanguage, n = t._iDisplayStart + 1, r = t.fnDisplayEnd(), a = t.fnRecordsTotal(), i = (o = t.fnRecordsDisplay()) ? e.sInfo : e.sInfoEmpty, o !== a && (i += " " + e.sInfoFiltered), i = at(t, i += e.sInfoPostFix), null !== (e = e.fnInfoCallback) && (i = e.call(t.oInstance, t, n, r, a, o, i)), P(s).html(i))
        }

        function at(t, e) {
            var n = t.fnFormatNumber,
                r = t._iDisplayStart + 1,
                a = t._iDisplayLength,
                o = t.fnRecordsDisplay(),
                i = -1 === a;
            return e.replace(/_START_/g, n.call(t, r)).replace(/_END_/g, n.call(t, t.fnDisplayEnd())).replace(/_MAX_/g, n.call(t, t.fnRecordsTotal())).replace(/_TOTAL_/g, n.call(t, o)).replace(/_PAGE_/g, n.call(t, i ? 1 : Math.ceil(r / a))).replace(/_PAGES_/g, n.call(t, i ? 1 : Math.ceil(o / a)))
        }

        function ot(n) {
            var r = n.iInitDisplayStart,
                t = n.aoColumns,
                e = n.oFeatures,
                a = n.bDeferLoading;
            if (n.bInitialised) {
                W(n), $(n), E(n, n.aoHeader), E(n, n.aoFooter), ft(n, !0), e.bAutoWidth && bt(n);
                for (var o = 0, e = t.length; o < e; o++) {
                    var i = t[o];
                    i.sWidth && (i.nTh.style.width = St(i.sWidth))
                }
                kt(n, null, "preInit", [n]), M(n), "ssp" == (t = Ht(n)) && !a || ("ajax" == t ? V(n, [], function (t) {
                    var e = q(n, t);
                    for (o = 0; o < e.length; o++) j(n, e[o]);
                    n.iInitDisplayStart = r, M(n), ft(n, !1), it(n, t)
                }) : (ft(n, !1), it(n)))
            } else setTimeout(function () {
                ot(n)
            }, 200)
        }

        function it(t, e) {
            t._bInitComplete = !0, (e || t.oInit.aaData) && O(t), kt(t, null, "plugin-init", [t, e]), kt(t, "aoInitComplete", "init", [t, e])
        }

        function st(t, e) {
            e = parseInt(e, 10), t._iDisplayLength = e, $t(t), kt(t, null, "length", [t, e])
        }

        function lt(r) {
            for (var t = r.oClasses, e = r.sTableId, n = r.aLengthMenu, a = (o = Array.isArray(n[0])) ? n[0] : n, n = o ? n[1] : n, o = P("<select/>", {
                    name: e + "_length",
                    "aria-controls": e,
                    class: t.sLengthSelect
                }), i = 0, s = a.length; i < s; i++) o[0][i] = new Option("number" == typeof n[i] ? r.fnFormatNumber(n[i]) : n[i], a[i]);
            var l = P("<div><label/></div>").addClass(t.sLength);
            return r.aanFeatures.l || (l[0].id = e + "_length"), l.children().append(r.oLanguage.sLengthMenu.replace("_MENU_", o[0].outerHTML)), P("select", l).val(r._iDisplayLength).on("change.DT", function (t) {
                st(r, P(this).val()), H(r)
            }), P(r.nTable).on("length.dt.DT", function (t, e, n) {
                r === e && P("select", l).val(n)
            }), l[0]
        }

        function ct(t) {
            function i(t) {
                H(t)
            }
            var e = t.sPaginationType,
                s = Kt.ext.pager[e],
                l = "function" == typeof s,
                e = P("<div/>").addClass(t.oClasses.sPaging + e)[0],
                c = t.aanFeatures;
            return l || s.fnInit(t, e, i), c.p || (e.id = t.sTableId + "_paginate", t.aoDrawCallback.push({
                fn: function (t) {
                    if (l)
                        for (var e = t._iDisplayStart, n = t._iDisplayLength, r = t.fnRecordsDisplay(), e = (a = -1 === n) ? 0 : Math.ceil(e / n), n = a ? 1 : Math.ceil(r / n), r = s(e, n), a = 0, o = c.p.length; a < o; a++) Et(t, "pageButton")(t, c.p[a], a, r, e, n);
                    else s.fnUpdate(t, i)
                },
                sName: "pagination"
            })), e
        }

        function ut(t, e, n) {
            var r = t._iDisplayStart,
                a = t._iDisplayLength,
                o = t.fnRecordsDisplay();
            return 0 === o || -1 === a ? r = 0 : "number" == typeof e ? o < (r = e * a) && (r = 0) : "first" == e ? r = 0 : "previous" == e ? (r = 0 <= a ? r - a : 0) < 0 && (r = 0) : "next" == e ? r + a < o && (r += a) : "last" == e ? r = Math.floor((o - 1) / a) * a : Ft(t, 0, "Unknown paging action: " + e, 5), e = t._iDisplayStart !== r, t._iDisplayStart = r, e && (kt(t, null, "page", [t]), n && H(t)), e
        }

        function dt(t) {
            return P("<div/>", {
                id: t.aanFeatures.r ? null : t.sTableId + "_processing",
                class: t.oClasses.sProcessing
            }).html(t.oLanguage.sProcessing).insertBefore(t.nTable)[0]
        }

        function ft(t, e) {
            t.oFeatures.bProcessing && P(t.aanFeatures.r).css("display", e ? "block" : "none"), kt(t, null, "processing", [t, e])
        }

        function ht(t) {
            var e = P(t.nTable);
            e.attr("role", "grid");
            var n = t.oScroll;
            if ("" === n.sX && "" === n.sY) return t.nTable;
            var r = n.sX,
                a = n.sY,
                o = t.oClasses,
                i = e.children("caption"),
                s = i.length ? i[0]._captionSide : null,
                l = P(e[0].cloneNode(!1)),
                c = P(e[0].cloneNode(!1)),
                u = e.children("tfoot");
            u.length || (u = null), l = P("<div/>", {
                class: o.sScrollWrapper
            }).append(P("<div/>", {
                class: o.sScrollHead
            }).css({
                overflow: "hidden",
                position: "relative",
                border: 0,
                width: r ? r ? St(r) : null : "100%"
            }).append(P("<div/>", {
                class: o.sScrollHeadInner
            }).css({
                "box-sizing": "content-box",
                width: n.sXInner || "100%"
            }).append(l.removeAttr("id").css("margin-left", 0).append("top" === s ? i : null).append(e.children("thead"))))).append(P("<div/>", {
                class: o.sScrollBody
            }).css({
                position: "relative",
                overflow: "auto",
                width: r ? St(r) : null
            }).append(e)), u && l.append(P("<div/>", {
                class: o.sScrollFoot
            }).css({
                overflow: "hidden",
                border: 0,
                width: r ? r ? St(r) : null : "100%"
            }).append(P("<div/>", {
                class: o.sScrollFootInner
            }).append(c.removeAttr("id").css("margin-left", 0).append("bottom" === s ? i : null).append(e.children("tfoot")))));
            var d = (e = l.children())[0],
                o = e[1],
                f = u ? e[2] : null;
            return r && P(o).on("scroll.DT", function (t) {
                t = this.scrollLeft, d.scrollLeft = t, u && (f.scrollLeft = t)
            }), P(o).css("max-height", a), n.bCollapse || P(o).css("height", a), t.nScrollHead = d, t.nScrollBody = o, t.nScrollFoot = f, t.aoDrawCallback.push({
                fn: pt,
                sName: "scrolling"
            }), l[0]
        }

        function pt(n) {
            function t(t) {
                (t = t.style).paddingTop = "0", t.paddingBottom = "0", t.borderTopWidth = "0", t.borderBottomWidth = "0", t.height = 0
            }
            var r, e, a, o, i = (c = n.oScroll).sX,
                s = c.sXInner,
                l = c.sY,
                c = c.iBarWidth,
                u = P(n.nScrollHead),
                d = u[0].style,
                f = (p = u.children("div"))[0].style,
                h = p.children("table"),
                p = n.nScrollBody,
                g = P(p),
                b = p.style,
                m = P(n.nScrollFoot).children("div"),
                v = m.children("table"),
                y = P(n.nTHead),
                S = P(n.nTable),
                _ = S[0],
                D = _.style,
                w = n.nTFoot ? P(n.nTFoot) : null,
                T = n.oBrowser,
                x = T.bScrollOversize,
                C = ie(n.aoColumns, "nTh"),
                I = [],
                A = [],
                j = [],
                L = [],
                F = p.scrollHeight > p.clientHeight;
            n.scrollBarVis !== F && n.scrollBarVis !== R ? (n.scrollBarVis = F, O(n)) : (n.scrollBarVis = F, S.children("thead, tfoot").remove(), w && (a = w.clone().prependTo(S), e = w.find("tr"), a = a.find("tr")), o = y.clone().prependTo(S), y = y.find("tr"), F = o.find("tr"), o.find("th, td").removeAttr("tabindex"), i || (b.width = "100%", u[0].style.width = "100%"), P.each(U(n, o), function (t, e) {
                r = N(n, t), e.style.width = n.aoColumns[r].sWidth
            }), w && gt(function (t) {
                t.style.width = ""
            }, a), u = S.outerWidth(), "" === i ? (D.width = "100%", x && (S.find("tbody").height() > p.offsetHeight || "scroll" == g.css("overflow-y")) && (D.width = St(S.outerWidth() - c)), u = S.outerWidth()) : "" !== s && (D.width = St(s), u = S.outerWidth()), gt(t, F), gt(function (t) {
                j.push(t.innerHTML), I.push(St(P(t).css("width")))
            }, F), gt(function (t, e) {
                -1 !== P.inArray(t, C) && (t.style.width = I[e])
            }, y), P(F).height(0), w && (gt(t, a), gt(function (t) {
                L.push(t.innerHTML), A.push(St(P(t).css("width")))
            }, a), gt(function (t, e) {
                t.style.width = A[e]
            }, e), P(a).height(0)), gt(function (t, e) {
                t.innerHTML = '<div class="dataTables_sizing">' + j[e] + "</div>", t.childNodes[0].style.height = "0", t.childNodes[0].style.overflow = "hidden", t.style.width = I[e]
            }, F), w && gt(function (t, e) {
                t.innerHTML = '<div class="dataTables_sizing">' + L[e] + "</div>", t.childNodes[0].style.height = "0", t.childNodes[0].style.overflow = "hidden", t.style.width = A[e]
            }, a), S.outerWidth() < u ? (e = p.scrollHeight > p.offsetHeight || "scroll" == g.css("overflow-y") ? u + c : u, x && (p.scrollHeight > p.offsetHeight || "scroll" == g.css("overflow-y")) && (D.width = St(e - c)), "" !== i && "" === s || Ft(n, 1, "Possible column misalignment", 6)) : e = "100%", b.width = St(e), d.width = St(e), w && (n.nScrollFoot.style.width = St(e)), !l && x && (b.height = St(_.offsetHeight + c)), i = S.outerWidth(), h[0].style.width = St(i), f.width = St(i), s = S.height() > p.clientHeight || "scroll" == g.css("overflow-y"), f[l = "padding" + (T.bScrollbarLeft ? "Left" : "Right")] = s ? c + "px" : "0px", w && (v[0].style.width = St(i), m[0].style.width = St(i), m[0].style[l] = s ? c + "px" : "0px"), S.children("colgroup").insertBefore(S.children("thead")), g.trigger("scroll"), !n.bSorted && !n.bFiltered || n._drawHold || (p.scrollTop = 0))
        }

        function gt(t, e, n) {
            for (var r, a, o = 0, i = 0, s = e.length; i < s;) {
                for (r = e[i].firstChild, a = n ? n[i].firstChild : null; r;) 1 === r.nodeType && (n ? t(r, a, o) : t(r, o), o++), r = r.nextSibling, a = n ? a.nextSibling : null;
                i++
            }
        }

        function bt(t) {
            var e, n = t.nTable,
                r = t.aoColumns,
                a = (p = t.oScroll).sY,
                o = p.sX,
                i = p.sXInner,
                s = r.length,
                l = I(t, "bVisible"),
                c = P("th", t.nTHead),
                u = n.getAttribute("width"),
                d = n.parentNode,
                f = !1,
                h = t.oBrowser,
                p = h.bScrollOversize;
            for ((e = n.style.width) && -1 !== e.indexOf("%") && (u = e), e = 0; e < l.length; e++) {
                var g = r[l[e]];
                null !== g.sWidth && (g.sWidth = mt(g.sWidthOrig, d), f = !0)
            }
            if (p || !f && !o && !a && s == v(t) && s == c.length)
                for (e = 0; e < s; e++) null !== (l = N(t, e)) && (r[l].sWidth = St(c.eq(e).width()));
            else {
                (s = P(n).clone().css("visibility", "hidden").removeAttr("id")).find("tbody tr").remove();
                var b = P("<tr/>").appendTo(s.find("tbody"));
                for (s.find("thead, tfoot").remove(), s.append(P(t.nTHead).clone()).append(P(t.nTFoot).clone()), s.find("tfoot th, tfoot td").css("width", ""), c = U(t, s.find("thead")[0]), e = 0; e < l.length; e++) g = r[l[e]], c[e].style.width = null !== g.sWidthOrig && "" !== g.sWidthOrig ? St(g.sWidthOrig) : "", g.sWidthOrig && o && P(c[e]).append(P("<div/>").css({
                    width: g.sWidthOrig,
                    margin: 0,
                    padding: 0,
                    border: 0,
                    height: 1
                }));
                if (t.aoData.length)
                    for (e = 0; e < l.length; e++) g = r[f = l[e]], P(vt(t, f)).clone(!1).append(g.sContentPadding).appendTo(b);
                for (P("[name]", s).removeAttr("name"), g = P("<div/>").css(o || a ? {
                        position: "absolute",
                        top: 0,
                        left: 0,
                        height: 1,
                        right: 0,
                        overflow: "hidden"
                    } : {}).append(s).appendTo(d), o && i ? s.width(i) : o ? (s.css("width", "auto"), s.removeAttr("width"), s.width() < d.clientWidth && u && s.width(d.clientWidth)) : a ? s.width(d.clientWidth) : u && s.width(u), e = a = 0; e < l.length; e++) i = (d = P(c[e])).outerWidth() - d.width(), a += d = h.bBounding ? Math.ceil(c[e].getBoundingClientRect().width) : d.outerWidth(), r[l[e]].sWidth = St(d - i);
                n.style.width = St(a), g.remove()
            }
            u && (n.style.width = St(u)), !u && !o || t._reszEvt || (n = function () {
                P(m).on("resize.DT-" + t.sInstance, be(function () {
                    O(t)
                }))
            }, p ? setTimeout(n, 1e3) : n(), t._reszEvt = !0)
        }

        function mt(t, e) {
            return t ? (e = (t = P("<div/>").css("width", St(t)).appendTo(e || y.body))[0].offsetWidth, t.remove(), e) : 0
        }

        function vt(t, e) {
            var n = yt(t, e);
            if (n < 0) return null;
            var r = t.aoData[n];
            return r.nTr ? r.anCells[e] : P("<td/>").html(F(t, n, e, "display"))[0]
        }

        function yt(t, e) {
            for (var n, r = -1, a = -1, o = 0, i = t.aoData.length; o < i; o++)(n = (n = (n = F(t, o, e, "display") + "").replace(ge, "")).replace(/&nbsp;/g, " ")).length > r && (r = n.length, a = o);
            return a
        }

        function St(t) {
            return null === t ? "0px" : "number" == typeof t ? t < 0 ? "0px" : t + "px" : t.match(/\d$/) ? t + "px" : t
        }

        function _t(t) {
            var e = [],
                n = t.aoColumns,
                r = t.aaSortingFixed,
                a = P.isPlainObject(r),
                o = [],
                i = function (t) {
                    t.length && !Array.isArray(t[0]) ? o.push(t) : P.merge(o, t)
                };
            for (Array.isArray(r) && i(r), a && r.pre && i(r.pre), i(t.aaSorting), a && r.post && i(r.post), t = 0; t < o.length; t++)
                for (var s = o[t][0], r = 0, a = (i = n[s].aDataSort).length; r < a; r++) {
                    var l = i[r],
                        c = n[l].sType || "string";
                    o[t]._idx === R && (o[t]._idx = P.inArray(o[t][1], n[l].asSorting)), e.push({
                        src: s,
                        col: l,
                        dir: o[t][1],
                        index: o[t]._idx,
                        type: c,
                        formatter: Kt.ext.type.order[c + "-pre"]
                    })
                }
            return e
        }

        function Dt(t) {
            var c = [],
                u = Kt.ext.type.order,
                d = t.aoData,
                e = 0,
                n = t.aiDisplayMaster;
            s(t);
            for (var f = _t(t), r = 0, a = f.length; r < a; r++) {
                var o = f[r];
                o.formatter && e++, It(t, o.col)
            }
            if ("ssp" != Ht(t) && 0 !== f.length) {
                for (r = 0, a = n.length; r < a; r++) c[n[r]] = r;
                e === f.length ? n.sort(function (t, e) {
                    for (var n = f.length, r = d[t]._aSortData, a = d[e]._aSortData, o = 0; o < n; o++) {
                        var i = f[o],
                            s = r[i.col],
                            l = a[i.col];
                        if (0 !== (s = s < l ? -1 : l < s ? 1 : 0)) return "asc" === i.dir ? s : -s
                    }
                    return (s = c[t]) < (l = c[e]) ? -1 : l < s ? 1 : 0
                }) : n.sort(function (t, e) {
                    for (var n = f.length, r = d[t]._aSortData, a = d[e]._aSortData, o = 0; o < n; o++) {
                        var i = f[o],
                            s = r[i.col],
                            l = a[i.col];
                        if (0 !== (s = (i = u[i.type + "-" + i.dir] || u["string-" + i.dir])(s, l))) return s
                    }
                    return (s = c[t]) < (l = c[e]) ? -1 : l < s ? 1 : 0
                })
            }
            t.bSorted = !0
        }

        function wt(t) {
            var e = t.aoColumns,
                n = _t(t);
            t = t.oLanguage.oAria;
            for (var r = 0, a = e.length; r < a; r++) {
                var o = e[r],
                    i = o.asSorting,
                    s = o.sTitle.replace(/<.*?>/g, ""),
                    l = o.nTh;
                l.removeAttribute("aria-sort"), o.bSortable && (s += "asc" === (o = 0 < n.length && n[0].col == r ? (l.setAttribute("aria-sort", "asc" == n[0].dir ? "ascending" : "descending"), i[n[0].index + 1] || i[0]) : i[0]) ? t.sSortAscending : t.sSortDescending), l.setAttribute("aria-label", s)
            }
        }

        function Tt(t, e, n, r) {
            function a(t, e) {
                var n = t._idx;
                return (n = n === R ? P.inArray(t[1], i) : n) + 1 < i.length ? n + 1 : e ? null : 0
            }
            var o = t.aaSorting,
                i = t.aoColumns[e].asSorting;
            "number" == typeof o[0] && (o = t.aaSorting = [o]), n && t.oFeatures.bSortMulti ? -1 !== (n = P.inArray(e, ie(o, "0"))) ? null === (e = null === (e = a(o[n], !0)) && 1 === o.length ? 0 : e) ? o.splice(n, 1) : (o[n][1] = i[e], o[n]._idx = e) : (o.push([e, i[0], 0]), o[o.length - 1]._idx = 0) : o.length && o[0][0] == e ? (e = a(o[0]), o.length = 1, o[0][1] = i[e], o[0]._idx = e) : (o.length = 0, o.push([e, i[0]]), o[0]._idx = 0), M(t), "function" == typeof r && r(t)
        }

        function xt(e, t, n, r) {
            var a = e.aoColumns[n];
            Ot(t, {}, function (t) {
                !1 !== a.bSortable && (e.oFeatures.bProcessing ? (ft(e, !0), setTimeout(function () {
                    Tt(e, n, t.shiftKey, r), "ssp" !== Ht(e) && ft(e, !1)
                }, 0)) : Tt(e, n, t.shiftKey, r))
            })
        }

        function Ct(t) {
            var e, n = t.aLastSort,
                r = t.oClasses.sSortColumn,
                a = _t(t),
                o = t.oFeatures;
            if (o.bSort && o.bSortClasses) {
                for (o = 0, e = n.length; o < e; o++) {
                    var i = n[o].src;
                    P(ie(t.aoData, "anCells", i)).removeClass(r + (o < 2 ? o + 1 : 3))
                }
                for (o = 0, e = a.length; o < e; o++) i = a[o].src, P(ie(t.aoData, "anCells", i)).addClass(r + (o < 2 ? o + 1 : 3))
            }
            t.aLastSort = a
        }

        function It(t, e) {
            var n, r = t.aoColumns[e],
                a = Kt.ext.order[r.sSortDataType];
            a && (n = a.call(t.oInstance, t, e, c(t, e)));
            for (var o, i = Kt.ext.type.order[r.sType + "-pre"], s = 0, l = t.aoData.length; s < l; s++)(r = t.aoData[s])._aSortData || (r._aSortData = []), r._aSortData[e] && !a || (o = a ? n[s] : F(t, s, e, "sort"), r._aSortData[e] = i ? i(o) : o)
        }

        function At(n) {
            var t;
            n.oFeatures.bStateSave && !n.bDestroying && (t = {
                time: +new Date,
                start: n._iDisplayStart,
                length: n._iDisplayLength,
                order: P.extend(!0, [], n.aaSorting),
                search: tt(n.oPreviousSearch),
                columns: P.map(n.aoColumns, function (t, e) {
                    return {
                        visible: t.bVisible,
                        search: tt(n.aoPreSearchCols[e])
                    }
                })
            }, kt(n, "aoStateSaveParams", "stateSaveParams", [n, t]), n.oSavedState = t, n.fnStateSaveCallback.call(n.oInstance, n, t))
        }

        function jt(n, t, r) {
            var a, o, e, i = n.aoColumns;
            t = function (t) {
                if (t && t.time) {
                    var e = kt(n, "aoStateLoadParams", "stateLoadParams", [n, t]);
                    if (-1 === P.inArray(!1, e) && !(0 < (e = n.iStateDuration) && t.time < +new Date - 1e3 * e || t.columns && i.length !== t.columns.length)) {
                        if (n.oLoadedState = P.extend(!0, {}, t), t.start !== R && (n._iDisplayStart = t.start, n.iInitDisplayStart = t.start), t.length !== R && (n._iDisplayLength = t.length), t.order !== R && (n.aaSorting = [], P.each(t.order, function (t, e) {
                                n.aaSorting.push(e[0] >= i.length ? [0, e[1]] : e)
                            })), t.search !== R && P.extend(n.oPreviousSearch, et(t.search)), t.columns)
                            for (a = 0, o = t.columns.length; a < o; a++)(e = t.columns[a]).visible !== R && (i[a].bVisible = e.visible), e.search !== R && P.extend(n.aoPreSearchCols[a], et(e.search));
                        kt(n, "aoStateLoaded", "stateLoaded", [n, t])
                    }
                }
                r()
            }, n.oFeatures.bStateSave ? (e = n.fnStateLoadCallback.call(n.oInstance, n, t)) !== R && t(e) : r()
        }

        function Lt(t) {
            var e = Kt.settings;
            return -1 !== (t = P.inArray(t, ie(e, "nTable"))) ? e[t] : null
        }

        function Ft(t, e, n, r) {
            if (n = "DataTables warning: " + (t ? "table id=" + t.sTableId + " - " : "") + n, r && (n += ". For more information about this error, please see http://datatables.net/tn/" + r), e) m.console && console.log && console.log(n);
            else if (e = (e = Kt.ext).sErrMode || e.errMode, t && kt(t, null, "error", [t, r, n]), "alert" == e) alert(n);
            else {
                if ("throw" == e) throw Error(n);
                "function" == typeof e && e(t, r, n)
            }
        }

        function Pt(n, r, t, e) {
            Array.isArray(t) ? P.each(t, function (t, e) {
                Array.isArray(e) ? Pt(n, r, e[0], e[1]) : Pt(n, r, e)
            }) : (e === R && (e = t), r[t] !== R && (n[e] = r[t]))
        }

        function Rt(t, e, n) {
            var r, a;
            for (r in e) e.hasOwnProperty(r) && (a = e[r], P.isPlainObject(a) ? (P.isPlainObject(t[r]) || (t[r] = {}), P.extend(!0, t[r], a)) : n && "data" !== r && "aaData" !== r && Array.isArray(a) ? t[r] = a.slice() : t[r] = a);
            return t
        }

        function Ot(e, t, n) {
            P(e).on("click.DT", t, function (t) {
                P(e).trigger("blur"), n(t)
            }).on("keypress.DT", t, function (t) {
                13 === t.which && (t.preventDefault(), n(t))
            }).on("selectstart.DT", function () {
                return !1
            })
        }

        function Nt(t, e, n, r) {
            n && t[e].push({
                fn: n,
                sName: r
            })
        }

        function kt(n, t, e, r) {
            var a = [];
            return t && (a = P.map(n[t].slice().reverse(), function (t, e) {
                return t.fn.apply(n.oInstance, r)
            })), null !== e && (t = P.Event(e + ".dt"), P(n.nTable).trigger(t, r), a.push(t.result)), a
        }

        function $t(t) {
            var e = t._iDisplayStart,
                n = t.fnDisplayEnd(),
                r = t._iDisplayLength;
            n <= e && (e = n - r), e -= e % r, t._iDisplayStart = e = -1 === r || e < 0 ? 0 : e
        }

        function Et(t, e) {
            t = t.renderer;
            var n = Kt.ext.renderer[e];
            return P.isPlainObject(t) && t[e] ? n[t[e]] || n._ : "string" == typeof t && n[t] || n._
        }

        function Ht(t) {
            return t.oFeatures.bServerSide ? "ssp" : t.ajax || t.sAjaxSource ? "ajax" : "dom"
        }

        function Mt(t, e) {
            var n = Fe.numbers_length,
                r = Math.floor(n / 2);
            return e <= n ? t = Yt(0, e) : t <= r ? ((t = Yt(0, n - 2)).push("ellipsis"), t.push(e - 1)) : (e - 1 - r <= t ? t = Yt(e - (n - 2), e) : ((t = Yt(t - r + 2, t + r - 1)).push("ellipsis"), t.push(e - 1)), t.splice(0, 0, "ellipsis"), t.splice(0, 0, 0)), t.DT_el = "span", t
        }

        function Wt(n) {
            P.each({
                num: function (t) {
                    return Pe(t, n)
                },
                "num-fmt": function (t) {
                    return Pe(t, n, oe)
                },
                "html-num": function (t) {
                    return Pe(t, n, ne)
                },
                "html-num-fmt": function (t) {
                    return Pe(t, n, ne, oe)
                }
            }, function (t, e) {
                Gt.type.order[t + n + "-pre"] = e, t.match(/^html\-/) && (Gt.type.search[t + n] = Gt.type.search.html)
            })
        }

        function e(e) {
            return function () {
                var t = [Lt(this[Kt.ext.iApiIndex])].concat(Array.prototype.slice.call(arguments));
                return Kt.ext.internal[e].apply(this, t)
            }
        }

        function Bt(t) {
            return !t || !0 === t || "-" === t
        }

        function Ut(t) {
            var e = parseInt(t, 10);
            return !isNaN(e) && isFinite(t) ? e : null
        }

        function Vt(t, e) {
            return te[e] || (te[e] = new RegExp(fe(e), "g")), "string" == typeof t && "." !== e ? t.replace(/\./g, "").replace(te[e], ".") : t
        }

        function Xt(t, e, n) {
            var r = "string" == typeof t;
            return !!Bt(t) || (e && r && (t = Vt(t, e)), n && r && (t = t.replace(oe, "")), !isNaN(parseFloat(t)) && isFinite(t))
        }

        function qt(t, e, n) {
            return !!Bt(t) || ((Bt(t) || "string" == typeof t) && !!Xt(t.replace(ne, ""), e, n) || null)
        }

        function zt(t, e, n, r) {
            var a = [],
                o = 0,
                i = e.length;
            if (r !== R)
                for (; o < i; o++) t[e[o]][n] && a.push(t[e[o]][n][r]);
            else
                for (; o < i; o++) a.push(t[e[o]][n]);
            return a
        }

        function Yt(t, e) {
            var n, r = [];
            for (e === R ? (e = 0, n = t) : (n = e, e = t), t = e; t < n; t++) r.push(t);
            return r
        }

        function Jt(t) {
            for (var e = [], n = 0, r = t.length; n < r; n++) t[n] && e.push(t[n]);
            return e
        }
        var Gt, Zt, Qt, Kt = function (b) {
                this.$ = function (t, e) {
                    return this.api(!0).$(t, e)
                }, this._ = function (t, e) {
                    return this.api(!0).rows(t, e).data()
                }, this.api = function (t) {
                    return new ye(t ? Lt(this[Gt.iApiIndex]) : this)
                }, this.fnAddData = function (t, e) {
                    var n = this.api(!0);
                    return t = (Array.isArray(t) && (Array.isArray(t[0]) || P.isPlainObject(t[0])) ? n.rows : n.row).add(t), e !== R && !e || n.draw(), t.flatten().toArray()
                }, this.fnAdjustColumnSizing = function (t) {
                    var e = this.api(!0).columns.adjust(),
                        n = e.settings()[0],
                        r = n.oScroll;
                    t === R || t ? e.draw(!1) : "" === r.sX && "" === r.sY || pt(n)
                }, this.fnClearTable = function (t) {
                    var e = this.api(!0).clear();
                    t !== R && !t || e.draw()
                }, this.fnClose = function (t) {
                    this.api(!0).row(t).child.hide()
                }, this.fnDeleteRow = function (t, e, n) {
                    var r = this.api(!0),
                        a = (t = r.rows(t)).settings()[0],
                        o = a.aoData[t[0][0]];
                    return t.remove(), e && e.call(this, a, o), n !== R && !n || r.draw(), o
                }, this.fnDestroy = function (t) {
                    this.api(!0).destroy(t)
                }, this.fnDraw = function (t) {
                    this.api(!0).draw(t)
                }, this.fnFilter = function (t, e, n, r, a, o) {
                    a = this.api(!0), (null === e || e === R ? a : a.column(e)).search(t, n, r, o), a.draw()
                }, this.fnGetData = function (t, e) {
                    var n = this.api(!0);
                    if (t === R) return n.data().toArray();
                    var r = t.nodeName ? t.nodeName.toLowerCase() : "";
                    return e !== R || "td" == r || "th" == r ? n.cell(t, e).data() : n.row(t).data() || null
                }, this.fnGetNodes = function (t) {
                    var e = this.api(!0);
                    return t !== R ? e.row(t).node() : e.rows().nodes().flatten().toArray()
                }, this.fnGetPosition = function (t) {
                    var e = this.api(!0),
                        n = t.nodeName.toUpperCase();
                    return "TR" == n ? e.row(t).index() : "TD" == n || "TH" == n ? [(t = e.cell(t).index()).row, t.columnVisible, t.column] : null
                }, this.fnIsOpen = function (t) {
                    return this.api(!0).row(t).child.isShown()
                }, this.fnOpen = function (t, e, n) {
                    return this.api(!0).row(t).child(e, n).show().child()[0]
                }, this.fnPageChange = function (t, e) {
                    t = this.api(!0).page(t), e !== R && !e || t.draw(!1)
                }, this.fnSetColumnVis = function (t, e, n) {
                    t = this.api(!0).column(t).visible(e), n !== R && !n || t.columns.adjust().draw()
                }, this.fnSettings = function () {
                    return Lt(this[Gt.iApiIndex])
                }, this.fnSort = function (t) {
                    this.api(!0).order(t).draw()
                }, this.fnSortListener = function (t, e, n) {
                    this.api(!0).order.listener(t, e, n)
                }, this.fnUpdate = function (t, e, n, r, a) {
                    var o = this.api(!0);
                    return (n === R || null === n ? o.row(e) : o.cell(e, n)).data(t), a !== R && !a || o.columns.adjust(), r !== R && !r || o.draw(), 0
                }, this.fnVersionCheck = Gt.fnVersionCheck;
                var t, m = this,
                    v = b === R,
                    y = this.length;
                for (t in v && (b = {}), this.oApi = this.internal = Gt.internal, Kt.ext.internal) t && (this[t] = e(t));
                return this.each(function () {
                    var t = {},
                        n = 1 < y ? Rt(t, b, !0) : b,
                        r = 0;
                    t = this.getAttribute("id");
                    var a = !1,
                        e = Kt.defaults,
                        o = P(this);
                    if ("table" != this.nodeName.toLowerCase()) Ft(null, 0, "Non-table node initialisation (" + this.nodeName + ")", 2);
                    else {
                        D(e), w(e.column), S(e, e, !0), S(e.column, e.column, !0), S(e, P.extend(n, o.data()), !0);
                        for (var i = Kt.settings, r = 0, s = i.length; r < s; r++) {
                            var l = i[r];
                            if (l.nTable == this || l.nTHead && l.nTHead.parentNode == this || l.nTFoot && l.nTFoot.parentNode == this) {
                                var c = (n.bRetrieve !== R ? n : e).bRetrieve;
                                if (v || c) return l.oInstance;
                                if ((n.bDestroy !== R ? n : e).bDestroy) {
                                    l.oInstance.fnDestroy();
                                    break
                                }
                                return void Ft(l, 0, "Cannot reinitialise DataTable", 3)
                            }
                            if (l.sTableId == this.id) {
                                i.splice(r, 1);
                                break
                            }
                        }
                        null !== t && "" !== t || (this.id = t = "DataTables_Table_" + Kt.ext._unique++);
                        var u = P.extend(!0, {}, Kt.models.oSettings, {
                            sDestroyWidth: o[0].style.width,
                            sInstance: t,
                            sTableId: t
                        });
                        u.nTable = this, u.oApi = m.internal, u.oInit = n, i.push(u), u.oInstance = 1 === m.length ? m : o.dataTable(), D(n), _(n.oLanguage), n.aLengthMenu && !n.iDisplayLength && (n.iDisplayLength = (Array.isArray(n.aLengthMenu[0]) ? n.aLengthMenu[0] : n.aLengthMenu)[0]), n = Rt(P.extend(!0, {}, e), n), Pt(u.oFeatures, n, "bPaginate bLengthChange bFilter bSort bSortMulti bInfo bProcessing bAutoWidth bSortClasses bServerSide bDeferRender".split(" ")), Pt(u, n, ["asStripeClasses", "ajax", "fnServerData", "fnFormatNumber", "sServerMethod", "aaSorting", "aaSortingFixed", "aLengthMenu", "sPaginationType", "sAjaxSource", "sAjaxDataProp", "iStateDuration", "sDom", "bSortCellsTop", "iTabIndex", "fnStateLoadCallback", "fnStateSaveCallback", "renderer", "searchDelay", "rowId", ["iCookieDuration", "iStateDuration"],
                            ["oSearch", "oPreviousSearch"],
                            ["aoSearchCols", "aoPreSearchCols"],
                            ["iDisplayLength", "_iDisplayLength"]
                        ]), Pt(u.oScroll, n, [
                            ["sScrollX", "sX"],
                            ["sScrollXInner", "sXInner"],
                            ["sScrollY", "sY"],
                            ["bScrollCollapse", "bCollapse"]
                        ]), Pt(u.oLanguage, n, "fnInfoCallback"), Nt(u, "aoDrawCallback", n.fnDrawCallback, "user"), Nt(u, "aoServerParams", n.fnServerParams, "user"), Nt(u, "aoStateSaveParams", n.fnStateSaveParams, "user"), Nt(u, "aoStateLoadParams", n.fnStateLoadParams, "user"), Nt(u, "aoStateLoaded", n.fnStateLoaded, "user"), Nt(u, "aoRowCallback", n.fnRowCallback, "user"), Nt(u, "aoRowCreatedCallback", n.fnCreatedRow, "user"), Nt(u, "aoHeaderCallback", n.fnHeaderCallback, "user"), Nt(u, "aoFooterCallback", n.fnFooterCallback, "user"), Nt(u, "aoInitComplete", n.fnInitComplete, "user"), Nt(u, "aoPreDrawCallback", n.fnPreDrawCallback, "user"), u.rowIdFn = k(n.rowId), T(u);
                        var d = u.oClasses;
                        P.extend(d, Kt.ext.classes, n.oClasses), o.addClass(d.sTable), u.iInitDisplayStart === R && (u.iInitDisplayStart = n.iDisplayStart, u._iDisplayStart = n.iDisplayStart), null !== n.iDeferLoading && (u.bDeferLoading = !0, t = Array.isArray(n.iDeferLoading), u._iRecordsDisplay = t ? n.iDeferLoading[0] : n.iDeferLoading, u._iRecordsTotal = t ? n.iDeferLoading[1] : n.iDeferLoading);
                        var f = u.oLanguage;
                        P.extend(!0, f, n.oLanguage), f.sUrl && (P.ajax({
                            dataType: "json",
                            url: f.sUrl,
                            success: function (t) {
                                _(t), S(e.oLanguage, t), P.extend(!0, f, t), ot(u)
                            },
                            error: function () {
                                ot(u)
                            }
                        }), a = !0), null === n.asStripeClasses && (u.asStripeClasses = [d.sStripeOdd, d.sStripeEven]);
                        var h, t = u.asStripeClasses,
                            p = o.children("tbody").find("tr").eq(0);
                        if (-1 !== P.inArray(!0, P.map(t, function (t, e) {
                                return p.hasClass(t)
                            })) && (P("tbody tr", this).removeClass(t.join(" ")), u.asDestroyStripes = t.slice()), t = [], 0 !== (i = this.getElementsByTagName("thead")).length && (B(u.aoHeader, i[0]), t = U(u)), null === n.aoColumns)
                            for (i = [], r = 0, s = t.length; r < s; r++) i.push(null);
                        else i = n.aoColumns;
                        for (r = 0, s = i.length; r < s; r++) x(u, t ? t[r] : null);
                        A(u, n.aoColumnDefs, i, function (t, e) {
                            C(u, t, e)
                        }), p.length && (h = function (t, e) {
                            return null !== t.getAttribute("data-" + e) ? e : null
                        }, P(p[0]).children("th, td").each(function (t, e) {
                            var n, r = u.aoColumns[t];
                            r.mData === t && (n = h(e, "sort") || h(e, "order"), e = h(e, "filter") || h(e, "search"), null === n && null === e || (r.mData = {
                                _: t + ".display",
                                sort: null !== n ? t + ".@data-" + n : R,
                                type: null !== n ? t + ".@data-" + n : R,
                                filter: null !== e ? t + ".@data-" + e : R
                            }, C(u, t)))
                        }));
                        var g = u.oFeatures;
                        t = function () {
                            if (n.aaSorting === R) {
                                var t = u.aaSorting;
                                for (r = 0, s = t.length; r < s; r++) t[r][1] = u.aoColumns[r].asSorting[0]
                            }
                            Ct(u), g.bSort && Nt(u, "aoDrawCallback", function () {
                                var t, n;
                                u.bSorted && (t = _t(u), n = {}, P.each(t, function (t, e) {
                                    n[e.src] = e.dir
                                }), kt(u, null, "order", [u, t, n]), wt(u))
                            }), Nt(u, "aoDrawCallback", function () {
                                (u.bSorted || "ssp" === Ht(u) || g.bDeferRender) && Ct(u)
                            }, "sc");
                            var t = o.children("caption").each(function () {
                                    this._captionSide = P(this).css("caption-side")
                                }),
                                e = o.children("thead");
                            if (0 === e.length && (e = P("<thead/>").appendTo(o)), u.nTHead = e[0], 0 === (e = o.children("tbody")).length && (e = P("<tbody/>").appendTo(o)), u.nTBody = e[0], 0 === (e = 0 === (e = o.children("tfoot")).length && 0 < t.length && ("" !== u.oScroll.sX || "" !== u.oScroll.sY) ? P("<tfoot/>").appendTo(o) : e).length || 0 === e.children().length ? o.addClass(d.sNoFooter) : 0 < e.length && (u.nTFoot = e[0], B(u.aoFooter, u.nTFoot)), n.aaData)
                                for (r = 0; r < n.aaData.length; r++) j(u, n.aaData[r]);
                            else !u.bDeferLoading && "dom" != Ht(u) || L(u, P(u.nTBody).children("tr"));
                            u.aiDisplay = u.aiDisplayMaster.slice(), !(u.bInitialised = !0) === a && ot(u)
                        }, n.bStateSave ? (g.bStateSave = !0, Nt(u, "aoDrawCallback", At, "state_save"), jt(u, 0, t)) : t()
                    }
                }), m = null, this
            },
            te = {},
            ee = /[\r\n\u2028]/g,
            ne = /<.*?>/g,
            re = /^\d{2,4}[\.\/\-]\d{1,2}[\.\/\-]\d{1,2}([T ]{1}\d{1,2}[:\.]\d{2}([\.:]\d{2})?)?$/,
            ae = /(\/|\.|\*|\+|\?|\||\(|\)|\[|\]|\{|\}|\\|\$|\^|\-)/g,
            oe = /['\u00A0,$£€¥%\u2009\u202F\u20BD\u20a9\u20BArfkɃΞ]/gi,
            ie = function (t, e, n) {
                var r = [],
                    a = 0,
                    o = t.length;
                if (n !== R)
                    for (; a < o; a++) t[a] && t[a][e] && r.push(t[a][e][n]);
                else
                    for (; a < o; a++) t[a] && r.push(t[a][e]);
                return r
            },
            se = function (t) {
                t: {
                    if (!(t.length < 2))
                        for (var e = t.slice().sort(), n = e[0], r = 1, a = e.length; r < a; r++) {
                            if (e[r] === n) {
                                e = !1;
                                break t
                            }
                            n = e[r]
                        }
                    e = !0
                }
                if (e) return t.slice();
                var o, e = [],
                    a = t.length,
                    i = 0,
                    r = 0;t: for (; r < a; r++) {
                    for (n = t[r], o = 0; o < i; o++)
                        if (e[o] === n) continue t;
                    e.push(n), i++
                }
                return e
            },
            le = function (t, e) {
                if (Array.isArray(e))
                    for (var n = 0; n < e.length; n++) le(t, e[n]);
                else t.push(e);
                return t
            };
        Array.isArray || (Array.isArray = function (t) {
            return "[object Array]" === Object.prototype.toString.call(t)
        }), String.prototype.trim || (String.prototype.trim = function () {
            return this.replace(/^[\s\uFEFF\xA0]+|[\s\uFEFF\xA0]+$/g, "")
        }), Kt.util = {
            throttle: function (r, t) {
                var a, o, i = t !== R ? t : 200;
                return function () {
                    var t = this,
                        e = +new Date,
                        n = arguments;
                    a && e < a + i ? (clearTimeout(o), o = setTimeout(function () {
                        a = R, r.apply(t, n)
                    }, i)) : (a = e, r.apply(t, n))
                }
            },
            escapeRegex: function (t) {
                return t.replace(ae, "\\$1")
            }
        };
        var ce = function (t, e, n) {
                t[e] !== R && (t[n] = t[e])
            },
            ue = /\[.*?\]$/,
            de = /\(\)$/,
            fe = Kt.util.escapeRegex,
            he = P("<div>")[0],
            pe = he.textContent !== R,
            ge = /<.*?>/g,
            be = Kt.util.throttle,
            me = [],
            ve = Array.prototype,
            ye = function (t, e) {
                if (!(this instanceof ye)) return new ye(t, e);

                function n(t) {
                    (t = function (t) {
                        var e, n = Kt.settings,
                            r = P.map(n, function (t, e) {
                                return t.nTable
                            });
                        if (!t) return [];
                        if (t.nTable && t.oApi) return [t];
                        if (t.nodeName && "table" === t.nodeName.toLowerCase()) {
                            var a = P.inArray(t, r);
                            return -1 !== a ? [n[a]] : null
                        }
                        return t && "function" == typeof t.settings ? t.settings().toArray() : ("string" == typeof t ? e = P(t) : t instanceof P && (e = t), e ? e.map(function (t) {
                            return -1 !== (a = P.inArray(this, r)) ? n[a] : null
                        }).toArray() : void 0)
                    }(t)) && r.push.apply(r, t)
                }
                var r = [];
                if (Array.isArray(t))
                    for (var a = 0, o = t.length; a < o; a++) n(t[a]);
                else n(t);
                this.context = se(r), e && P.merge(this, e), this.selector = {
                    rows: null,
                    cols: null,
                    opts: null
                }, ye.extend(this, this, me)
            };
        Kt.Api = ye, P.extend(ye.prototype, {
            any: function () {
                return 0 !== this.count()
            },
            concat: ve.concat,
            context: [],
            count: function () {
                return this.flatten().length
            },
            each: function (t) {
                for (var e = 0, n = this.length; e < n; e++) t.call(this, this[e], e, this);
                return this
            },
            eq: function (t) {
                var e = this.context;
                return e.length > t ? new ye(e[t], this[t]) : null
            },
            filter: function (t) {
                var e = [];
                if (ve.filter) e = ve.filter.call(this, t, this);
                else
                    for (var n = 0, r = this.length; n < r; n++) t.call(this, this[n], n, this) && e.push(this[n]);
                return new ye(this.context, e)
            },
            flatten: function () {
                var t = [];
                return new ye(this.context, t.concat.apply(t, this.toArray()))
            },
            join: ve.join,
            indexOf: ve.indexOf || function (t, e) {
                e = e || 0;
                for (var n = this.length; e < n; e++)
                    if (this[e] === t) return e;
                return -1
            },
            iterator: function (t, e, n, r) {
                var a, o = [],
                    i = this.context,
                    s = this.selector;
                "string" == typeof t && (r = n, n = e, e = t, t = !1);
                for (var l = 0, c = i.length; l < c; l++) {
                    var u = new ye(i[l]);
                    if ("table" === e) {
                        var d = n.call(u, i[l], l);
                        d !== R && o.push(d)
                    } else if ("columns" === e || "rows" === e)(d = n.call(u, i[l], this[l], l)) !== R && o.push(d);
                    else if ("column" === e || "column-rows" === e || "row" === e || "cell" === e) {
                        var f = this[l];
                        "column-rows" === e && (a = xe(i[l], s.opts));
                        for (var h = 0, p = f.length; h < p; h++) d = f[h], (d = "cell" === e ? n.call(u, i[l], d.row, d.column, l, h) : n.call(u, i[l], d, l, h, a)) !== R && o.push(d)
                    }
                }
                return o.length || r ? ((e = (t = new ye(i, t ? o.concat.apply([], o) : o)).selector).rows = s.rows, e.cols = s.cols, e.opts = s.opts, t) : this
            },
            lastIndexOf: ve.lastIndexOf || function (t, e) {
                return this.indexOf.apply(this.toArray.reverse(), arguments)
            },
            length: 0,
            map: function (t) {
                var e = [];
                if (ve.map) e = ve.map.call(this, t, this);
                else
                    for (var n = 0, r = this.length; n < r; n++) e.push(t.call(this, this[n], n));
                return new ye(this.context, e)
            },
            pluck: function (e) {
                return this.map(function (t) {
                    return t[e]
                })
            },
            pop: ve.pop,
            push: ve.push,
            reduce: ve.reduce || function (t, e) {
                return n(this, t, e, 0, this.length, 1)
            },
            reduceRight: ve.reduceRight || function (t, e) {
                return n(this, t, e, this.length - 1, -1, -1)
            },
            reverse: ve.reverse,
            selector: null,
            shift: ve.shift,
            slice: function () {
                return new ye(this.context, this)
            },
            sort: ve.sort,
            splice: ve.splice,
            toArray: function () {
                return ve.slice.call(this)
            },
            to$: function () {
                return P(this)
            },
            toJQuery: function () {
                return P(this)
            },
            unique: function () {
                return new ye(this.context, se(this))
            },
            unshift: ve.unshift
        }), ye.extend = function (t, e, n) {
            if (n.length && e && (e instanceof ye || e.__dt_wrapper))
                for (var r = 0, a = n.length; r < a; r++) {
                    var o = n[r];
                    e[o.name] = "function" === o.type ? function (e, n, r) {
                        return function () {
                            var t = n.apply(e, arguments);
                            return ye.extend(t, t, r.methodExt), t
                        }
                    }(t, o.val, o) : "object" === o.type ? {} : o.val, e[o.name].__dt_wrapper = !0, ye.extend(t, e[o.name], o.propExt)
                }
        }, ye.register = Zt = function (t, e) {
            if (Array.isArray(t))
                for (var n = 0, r = t.length; n < r; n++) ye.register(t[n], e);
            else {
                var a, r = t.split("."),
                    o = me;
                for (t = 0, n = r.length; t < n; t++) {
                    var i = (a = -1 !== r[t].indexOf("()")) ? r[t].replace("()", "") : r[t];
                    t: {
                        for (var s = 0, l = o.length; s < l; s++)
                            if (o[s].name === i) {
                                s = o[s];
                                break t
                            } s = null
                    }
                    s || o.push(s = {
                        name: i,
                        val: {},
                        methodExt: [],
                        propExt: [],
                        type: "object"
                    }), t === n - 1 ? (s.val = e, s.type = "function" == typeof e ? "function" : P.isPlainObject(e) ? "object" : "other") : o = a ? s.methodExt : s.propExt
                }
            }
        }, ye.registerPlural = Qt = function (t, e, n) {
            ye.register(t, n), ye.register(e, function () {
                var t = n.apply(this, arguments);
                return t === this ? this : t instanceof ye ? t.length ? Array.isArray(t[0]) ? new ye(t.context, t[0]) : t[0] : R : t
            })
        };
        var Se = function (t, e) {
            if (Array.isArray(t)) return P.map(t, function (t) {
                return Se(t, e)
            });
            if ("number" == typeof t) return [e[t]];
            var n = P.map(e, function (t, e) {
                return t.nTable
            });
            return P(n).filter(t).map(function (t) {
                return t = P.inArray(this, n), e[t]
            }).toArray()
        };
        Zt("tables()", function (t) {
            return t !== R && null !== t ? new ye(Se(t, this.context)) : this
        }), Zt("table()", function (t) {
            var e = (t = this.tables(t)).context;
            return e.length ? new ye(e[0]) : t
        }), Qt("tables().nodes()", "table().node()", function () {
            return this.iterator("table", function (t) {
                return t.nTable
            }, 1)
        }), Qt("tables().body()", "table().body()", function () {
            return this.iterator("table", function (t) {
                return t.nTBody
            }, 1)
        }), Qt("tables().header()", "table().header()", function () {
            return this.iterator("table", function (t) {
                return t.nTHead
            }, 1)
        }), Qt("tables().footer()", "table().footer()", function () {
            return this.iterator("table", function (t) {
                return t.nTFoot
            }, 1)
        }), Qt("tables().containers()", "table().container()", function () {
            return this.iterator("table", function (t) {
                return t.nTableWrapper
            }, 1)
        }), Zt("draw()", function (e) {
            return this.iterator("table", function (t) {
                "page" === e ? H(t) : M(t, !1 === (e = "string" == typeof e ? "full-hold" !== e : e))
            })
        }), Zt("page()", function (e) {
            return e === R ? this.page.info().page : this.iterator("table", function (t) {
                ut(t, e)
            })
        }), Zt("page.info()", function (t) {
            if (0 === this.context.length) return R;
            var e = (t = this.context[0])._iDisplayStart,
                n = t.oFeatures.bPaginate ? t._iDisplayLength : -1,
                r = t.fnRecordsDisplay(),
                a = -1 === n;
            return {
                page: a ? 0 : Math.floor(e / n),
                pages: a ? 1 : Math.ceil(r / n),
                start: e,
                end: t.fnDisplayEnd(),
                length: n,
                recordsTotal: t.fnRecordsTotal(),
                recordsDisplay: r,
                serverSide: "ssp" === Ht(t)
            }
        }), Zt("page.len()", function (e) {
            return e === R ? 0 !== this.context.length ? this.context[0]._iDisplayLength : R : this.iterator("table", function (t) {
                st(t, e)
            })
        });

        function _e(r, a, t) {
            var e, n;
            t && (e = new ye(r)).one("draw", function () {
                t(e.ajax.json())
            }), "ssp" == Ht(r) ? M(r, a) : (ft(r, !0), (n = r.jqXHR) && 4 !== n.readyState && n.abort(), V(r, [], function (t) {
                l(r);
                for (var e = 0, n = (t = q(r, t)).length; e < n; e++) j(r, t[e]);
                M(r, a), ft(r, !1)
            }))
        }
        Zt("ajax.json()", function () {
            var t = this.context;
            if (0 < t.length) return t[0].json
        }), Zt("ajax.params()", function () {
            var t = this.context;
            if (0 < t.length) return t[0].oAjaxData
        }), Zt("ajax.reload()", function (e, n) {
            return this.iterator("table", function (t) {
                _e(t, !1 === n, e)
            })
        }), Zt("ajax.url()", function (e) {
            var t = this.context;
            return e === R ? 0 === t.length ? R : (t = t[0]).ajax ? P.isPlainObject(t.ajax) ? t.ajax.url : t.ajax : t.sAjaxSource : this.iterator("table", function (t) {
                P.isPlainObject(t.ajax) ? t.ajax.url = e : t.ajax = e
            })
        }), Zt("ajax.url().load()", function (e, n) {
            return this.iterator("table", function (t) {
                _e(t, !1 === n, e)
            })
        });

        function De(t, e, n, r, a) {
            var o, i, s = [],
                l = typeof e;
            for (e && "string" !== l && "function" !== l && e.length !== R || (e = [e]), l = 0, i = e.length; l < i; l++)
                for (var c = e[l] && e[l].split && !e[l].match(/[\[\(:]/) ? e[l].split(",") : [e[l]], u = 0, d = c.length; u < d; u++)(o = n("string" == typeof c[u] ? c[u].trim() : c[u])) && o.length && (s = s.concat(o));
            if ((t = Gt.selector[t]).length)
                for (l = 0, i = t.length; l < i; l++) s = t[l](r, a, s);
            return se(s)
        }

        function we(t) {
            return (t = t || {}).filter && t.search === R && (t.search = t.filter), P.extend({
                search: "none",
                order: "current",
                page: "all"
            }, t)
        }

        function Te(t) {
            for (var e = 0, n = t.length; e < n; e++)
                if (0 < t[e].length) return t[0] = t[e], t[0].length = 1, t.length = 1, t.context = [t.context[e]], t;
            return t.length = 0, t
        }
        var xe = function (t, e) {
            var n = [],
                r = t.aiDisplay,
                a = t.aiDisplayMaster,
                o = e.search,
                i = e.order;
            if (e = e.page, "ssp" == Ht(t)) return "removed" === o ? [] : Yt(0, a.length);
            if ("current" == e)
                for (i = t._iDisplayStart, t = t.fnDisplayEnd(); i < t; i++) n.push(r[i]);
            else if ("current" == i || "applied" == i) {
                if ("none" == o) n = a.slice();
                else if ("applied" == o) n = r.slice();
                else if ("removed" == o) {
                    var s = {},
                        i = 0;
                    for (t = r.length; i < t; i++) s[r[i]] = null;
                    n = P.map(a, function (t) {
                        return s.hasOwnProperty(t) ? null : t
                    })
                }
            } else if ("index" == i || "original" == i)
                for (i = 0, t = t.aoData.length; i < t; i++) "none" == o ? n.push(i) : (-1 === (a = P.inArray(i, r)) && "removed" == o || 0 <= a && "applied" == o) && n.push(i);
            return n
        };
        Zt("rows()", function (e, n) {
            e === R ? e = "" : P.isPlainObject(e) && (n = e, e = ""), n = we(n);
            var t = this.iterator("table", function (t) {
                return De("row", e, function (n) {
                    var t = Ut(n),
                        r = a.aoData;
                    if (null !== t && !o) return [t];
                    if (i = i || xe(a, o), null !== t && -1 !== P.inArray(t, i)) return [t];
                    if (null === n || n === R || "" === n) return i;
                    if ("function" == typeof n) return P.map(i, function (t) {
                        var e = r[t];
                        return n(t, e._aData, e.nTr) ? t : null
                    });
                    if (n.nodeName) {
                        var t = n._DT_RowIndex,
                            e = n._DT_CellIndex;
                        return t !== R ? r[t] && r[t].nTr === n ? [t] : [] : e ? r[e.row] && r[e.row].nTr === n.parentNode ? [e.row] : [] : (t = P(n).closest("*[data-dt-row]")).length ? [t.data("dt-row")] : []
                    }
                    return "string" == typeof n && "#" === n.charAt(0) && (t = a.aIds[n.replace(/^#/, "")]) !== R ? [t.idx] : (t = Jt(zt(a.aoData, i, "nTr")), P(t).filter(n).map(function () {
                        return this._DT_RowIndex
                    }).toArray())
                }, a = t, o = n);
                var a, o, i
            }, 1);
            return t.selector.rows = e, t.selector.opts = n, t
        }), Zt("rows().nodes()", function () {
            return this.iterator("row", function (t, e) {
                return t.aoData[e].nTr || R
            }, 1)
        }), Zt("rows().data()", function () {
            return this.iterator(!0, "rows", function (t, e) {
                return zt(t.aoData, e, "_aData")
            }, 1)
        }), Qt("rows().cache()", "row().cache()", function (n) {
            return this.iterator("row", function (t, e) {
                return t = t.aoData[e], "search" === n ? t._aFilterData : t._aSortData
            }, 1)
        }), Qt("rows().invalidate()", "row().invalidate()", function (n) {
            return this.iterator("row", function (t, e) {
                a(t, e, n)
            })
        }), Qt("rows().indexes()", "row().index()", function () {
            return this.iterator("row", function (t, e) {
                return e
            }, 1)
        }), Qt("rows().ids()", "row().id()", function (t) {
            for (var e = [], n = this.context, r = 0, a = n.length; r < a; r++)
                for (var o = 0, i = this[r].length; o < i; o++) {
                    var s = n[r].rowIdFn(n[r].aoData[this[r][o]]._aData);
                    e.push((!0 === t ? "#" : "") + s)
                }
            return new ye(n, e)
        }), Qt("rows().remove()", "row().remove()", function () {
            var u = this;
            return this.iterator("row", function (t, e, n) {
                var r, a = t.aoData,
                    o = a[e];
                a.splice(e, 1);
                for (var i = 0, s = a.length; i < s; i++) {
                    var l = a[i],
                        c = l.anCells;
                    if (null !== l.nTr && (l.nTr._DT_RowIndex = i), null !== c)
                        for (l = 0, r = c.length; l < r; l++) c[l]._DT_CellIndex.row = i
                }
                d(t.aiDisplayMaster, e), d(t.aiDisplay, e), d(u[n], e, !1), 0 < t._iRecordsDisplay && t._iRecordsDisplay--, $t(t), (e = t.rowIdFn(o._aData)) !== R && delete t.aIds[e]
            }), this.iterator("table", function (t) {
                for (var e = 0, n = t.aoData.length; e < n; e++) t.aoData[e].idx = e
            }), this
        }), Zt("rows.add()", function (o) {
            var t = this.iterator("table", function (t) {
                    for (var e = [], n = 0, r = o.length; n < r; n++) {
                        var a = o[n];
                        a.nodeName && "TR" === a.nodeName.toUpperCase() ? e.push(L(t, a)[0]) : e.push(j(t, a))
                    }
                    return e
                }, 1),
                e = this.rows(-1);
            return e.pop(), P.merge(e, t), e
        }), Zt("row()", function (t, e) {
            return Te(this.rows(t, e))
        }), Zt("row().data()", function (t) {
            var e = this.context;
            if (t === R) return e.length && this.length ? e[0].aoData[this[0]]._aData : R;
            var n = e[0].aoData[this[0]];
            return n._aData = t, Array.isArray(t) && n.nTr && n.nTr.id && p(e[0].rowId)(t, n.nTr.id), a(e[0], this[0], "data"), this
        }), Zt("row().node()", function () {
            var t = this.context;
            return t.length && this.length && t[0].aoData[this[0]].nTr || null
        }), Zt("row.add()", function (e) {
            e instanceof P && e.length && (e = e[0]);
            var t = this.iterator("table", function (t) {
                return e.nodeName && "TR" === e.nodeName.toUpperCase() ? L(t, e)[0] : j(t, e)
            });
            return this.row(t[0])
        });

        function Ce(t, e) {
            var n = t.context;
            n.length && (t = n[0].aoData[e !== R ? e : t[0]]) && t._details && (t._details.remove(), t._detailsShow = R, t._details = R)
        }

        function Ie(t, e) {
            var n = t.context;
            n.length && t.length && ((t = n[0].aoData[t[0]])._details && ((t._detailsShow = e) ? t._details.insertAfter(t.nTr) : t._details.detach(), Ae(n[0])))
        }
        var Ae = function (a) {
            var n = new ye(a),
                o = a.aoData;
            n.off("draw.dt.DT_details column-visibility.dt.DT_details destroy.dt.DT_details"), 0 < ie(o, "_details").length && (n.on("draw.dt.DT_details", function (t, e) {
                a === e && n.rows({
                    page: "current"
                }).eq(0).each(function (t) {
                    (t = o[t])._detailsShow && t._details.insertAfter(t.nTr)
                })
            }), n.on("column-visibility.dt.DT_details", function (t, e, n, r) {
                if (a === e)
                    for (e = v(e), n = 0, r = o.length; n < r; n++)(t = o[n])._details && t._details.children("td[colspan]").attr("colspan", e)
            }), n.on("destroy.dt.DT_details", function (t, e) {
                if (a === e)
                    for (t = 0, e = o.length; t < e; t++) o[t]._details && Ce(n, t)
            }))
        };
        Zt("row().child()", function (t, e) {
            var a, o, i, n = this.context;
            return t === R ? n.length && this.length ? n[0].aoData[this[0]]._details : R : (!0 === t ? this.child.show() : !1 === t ? Ce(this) : n.length && this.length && (a = n[0], n = n[0].aoData[this[0]], o = [], (i = function (t, e) {
                if (Array.isArray(t) || t instanceof P)
                    for (var n = 0, r = t.length; n < r; n++) i(t[n], e);
                else t.nodeName && "tr" === t.nodeName.toLowerCase() ? o.push(t) : (n = P("<tr><td></td></tr>").addClass(e), P("td", n).addClass(e).html(t)[0].colSpan = v(a), o.push(n[0]))
            })(t, e), n._details && n._details.detach(), n._details = P(o), n._detailsShow && n._details.insertAfter(n.nTr)), this)
        }), Zt(["row().child.show()", "row().child().show()"], function (t) {
            return Ie(this, !0), this
        }), Zt(["row().child.hide()", "row().child().hide()"], function () {
            return Ie(this, !1), this
        }), Zt(["row().child.remove()", "row().child().remove()"], function () {
            return Ce(this), this
        }), Zt("row().child.isShown()", function () {
            var t = this.context;
            return t.length && this.length && t[0].aoData[this[0]]._detailsShow || !1
        });

        function je(t, e, n, r, a) {
            n = [], r = 0;
            for (var o = a.length; r < o; r++) n.push(F(t, a[r], e));
            return n
        }
        var Le = /^([^:]+):(name|visIdx|visible)$/;
        Zt("columns()", function (n, r) {
            n === R ? n = "" : P.isPlainObject(n) && (r = n, n = ""), r = we(r);
            var t = this.iterator("table", function (t) {
                return e = n, i = r, s = (o = t).aoColumns, l = ie(s, "sName"), c = ie(s, "nTh"), De("column", e, function (n) {
                    var t = Ut(n);
                    if ("" === n) return Yt(s.length);
                    if (null !== t) return [0 <= t ? t : s.length + t];
                    if ("function" == typeof n) {
                        var r = xe(o, i);
                        return P.map(s, function (t, e) {
                            return n(e, je(o, e, 0, 0, r), c[e]) ? e : null
                        })
                    }
                    var a = "string" == typeof n ? n.match(Le) : "";
                    if (a) switch (a[2]) {
                        case "visIdx":
                        case "visible":
                            if ((t = parseInt(a[1], 10)) < 0) {
                                var e = P.map(s, function (t, e) {
                                    return t.bVisible ? e : null
                                });
                                return [e[e.length + t]]
                            }
                            return [N(o, t)];
                        case "name":
                            return P.map(l, function (t, e) {
                                return t === a[1] ? e : null
                            });
                        default:
                            return []
                    }
                    return n.nodeName && n._DT_CellIndex ? [n._DT_CellIndex.column] : (t = P(c).filter(n).map(function () {
                        return P.inArray(this, c)
                    }).toArray()).length || !n.nodeName ? t : (t = P(n).closest("*[data-dt-column]")).length ? [t.data("dt-column")] : []
                }, o, i);
                var o, e, i, s, l, c
            }, 1);
            return t.selector.cols = n, t.selector.opts = r, t
        }), Qt("columns().header()", "column().header()", function (t, e) {
            return this.iterator("column", function (t, e) {
                return t.aoColumns[e].nTh
            }, 1)
        }), Qt("columns().footer()", "column().footer()", function (t, e) {
            return this.iterator("column", function (t, e) {
                return t.aoColumns[e].nTf
            }, 1)
        }), Qt("columns().data()", "column().data()", function () {
            return this.iterator("column-rows", je, 1)
        }), Qt("columns().dataSrc()", "column().dataSrc()", function () {
            return this.iterator("column", function (t, e) {
                return t.aoColumns[e].mData
            }, 1)
        }), Qt("columns().cache()", "column().cache()", function (o) {
            return this.iterator("column-rows", function (t, e, n, r, a) {
                return zt(t.aoData, a, "search" === o ? "_aFilterData" : "_aSortData", e)
            }, 1)
        }), Qt("columns().nodes()", "column().nodes()", function () {
            return this.iterator("column-rows", function (t, e, n, r, a) {
                return zt(t.aoData, a, "anCells", e)
            }, 1)
        }), Qt("columns().visible()", "column().visible()", function (l, n) {
            var e = this,
                t = this.iterator("column", function (t, e) {
                    if (l === R) return t.aoColumns[e].bVisible;
                    var n = (o = t.aoColumns)[e],
                        r = t.aoData;
                    if (l !== R && n.bVisible !== l) {
                        if (l)
                            for (var a = P.inArray(!0, ie(o, "bVisible"), e + 1), o = 0, i = r.length; o < i; o++) {
                                var s = r[o].nTr;
                                t = r[o].anCells, s && s.insertBefore(t[e], t[a] || null)
                            } else P(ie(t.aoData, "anCells", e)).detach();
                        n.bVisible = l
                    }
                });
            return l !== R && this.iterator("table", function (t) {
                E(t, t.aoHeader), E(t, t.aoFooter), t.aiDisplay.length || P(t.nTBody).find("td[colspan]").attr("colspan", v(t)), At(t), e.iterator("column", function (t, e) {
                    kt(t, null, "column-visibility", [t, e, l, n])
                }), n !== R && !n || e.columns.adjust()
            }), t
        }), Qt("columns().indexes()", "column().index()", function (n) {
            return this.iterator("column", function (t, e) {
                return "visible" === n ? c(t, e) : e
            }, 1)
        }), Zt("columns.adjust()", function () {
            return this.iterator("table", function (t) {
                O(t)
            }, 1)
        }), Zt("column.index()", function (t, e) {
            if (0 !== this.context.length) {
                var n = this.context[0];
                return "fromVisible" === t || "toData" === t ? N(n, e) : "fromData" === t || "toVisible" === t ? c(n, e) : void 0
            }
        }), Zt("column()", function (t, e) {
            return Te(this.columns(t, e))
        });
        Zt("cells()", function (g, t, b) {
            if (P.isPlainObject(g) && (g.row === R ? (b = g, g = null) : (b = t, t = null)), P.isPlainObject(t) && (b = t, t = null), null === t || t === R) return this.iterator("table", function (t) {
                return n = t, e = g, r = we(b), d = n.aoData, f = xe(n, r), t = Jt(zt(d, f, "anCells")), h = P(le([], t)), p = n.aoColumns.length, De("cell", e, function (t) {
                    var e = "function" == typeof t;
                    if (null === t || t === R || e) {
                        for (o = [], i = 0, s = f.length; i < s; i++)
                            for (a = f[i], l = 0; l < p; l++) c = {
                                row: a,
                                column: l
                            }, e ? (u = d[a], t(c, F(n, a, l), u.anCells ? u.anCells[l] : null) && o.push(c)) : o.push(c);
                        return o
                    }
                    return P.isPlainObject(t) ? t.column !== R && t.row !== R && -1 !== P.inArray(t.row, f) ? [t] : [] : (e = h.filter(t).map(function (t, e) {
                        return {
                            row: e._DT_CellIndex.row,
                            column: e._DT_CellIndex.column
                        }
                    }).toArray()).length || !t.nodeName ? e : (u = P(t).closest("*[data-dt-row]")).length ? [{
                        row: u.data("dt-row"),
                        column: u.data("dt-column")
                    }] : []
                }, n, r);
                var n, e, r, a, o, i, s, l, c, u, d, f, h, p
            });
            var n, r, a, o, e = b ? {
                    page: b.page,
                    order: b.order,
                    search: b.search
                } : {},
                i = this.columns(t, e),
                s = this.rows(g, e),
                e = this.iterator("table", function (t, e) {
                    for (t = [], n = 0, r = s[e].length; n < r; n++)
                        for (a = 0, o = i[e].length; a < o; a++) t.push({
                            row: s[e][n],
                            column: i[e][a]
                        });
                    return t
                }, 1);
            return e = b && b.selected ? this.cells(e, b) : e, P.extend(e.selector, {
                cols: t,
                rows: g,
                opts: b
            }), e
        }), Qt("cells().nodes()", "cell().node()", function () {
            return this.iterator("cell", function (t, e, n) {
                return (t = t.aoData[e]) && t.anCells ? t.anCells[n] : R
            }, 1)
        }), Zt("cells().data()", function () {
            return this.iterator("cell", function (t, e, n) {
                return F(t, e, n)
            }, 1)
        }), Qt("cells().cache()", "cell().cache()", function (r) {
            return r = "search" === r ? "_aFilterData" : "_aSortData", this.iterator("cell", function (t, e, n) {
                return t.aoData[e][r][n]
            }, 1)
        }), Qt("cells().render()", "cell().render()", function (r) {
            return this.iterator("cell", function (t, e, n) {
                return F(t, e, n, r)
            }, 1)
        }), Qt("cells().indexes()", "cell().index()", function () {
            return this.iterator("cell", function (t, e, n) {
                return {
                    row: e,
                    column: n,
                    columnVisible: c(t, n)
                }
            }, 1)
        }), Qt("cells().invalidate()", "cell().invalidate()", function (r) {
            return this.iterator("cell", function (t, e, n) {
                a(t, e, r, n)
            })
        }), Zt("cell()", function (t, e, n) {
            return Te(this.cells(t, e, n))
        }), Zt("cell().data()", function (t) {
            var e = this.context,
                n = this[0];
            return t === R ? e.length && n.length ? F(e[0], n[0].row, n[0].column) : R : (r(e[0], n[0].row, n[0].column, t), a(e[0], n[0].row, "data", n[0].column), this)
        }), Zt("order()", function (e, t) {
            var n = this.context;
            return e === R ? 0 !== n.length ? n[0].aaSorting : R : ("number" == typeof e ? e = [
                [e, t]
            ] : e.length && !Array.isArray(e[0]) && (e = Array.prototype.slice.call(arguments)), this.iterator("table", function (t) {
                t.aaSorting = e.slice()
            }))
        }), Zt("order.listener()", function (e, n, r) {
            return this.iterator("table", function (t) {
                xt(t, e, n, r)
            })
        }), Zt("order.fixed()", function (e) {
            if (e) return this.iterator("table", function (t) {
                t.aaSortingFixed = P.extend(!0, {}, e)
            });
            var t = (t = this.context).length ? t[0].aaSortingFixed : R;
            return Array.isArray(t) ? {
                pre: t
            } : t
        }), Zt(["columns().order()", "column().order()"], function (r) {
            var a = this;
            return this.iterator("table", function (t, e) {
                var n = [];
                P.each(a[e], function (t, e) {
                    n.push([e, r])
                }), t.aaSorting = n
            })
        }), Zt("search()", function (e, n, r, a) {
            var t = this.context;
            return e === R ? 0 !== t.length ? t[0].oPreviousSearch.sSearch : R : this.iterator("table", function (t) {
                t.oFeatures.bFilter && Y(t, P.extend({}, t.oPreviousSearch, {
                    sSearch: e + "",
                    bRegex: null !== n && n,
                    bSmart: null === r || r,
                    bCaseInsensitive: null === a || a
                }), 1)
            })
        }), Qt("columns().search()", "column().search()", function (r, a, o, i) {
            return this.iterator("column", function (t, e) {
                var n = t.aoPreSearchCols;
                if (r === R) return n[e].sSearch;
                t.oFeatures.bFilter && (P.extend(n[e], {
                    sSearch: r + "",
                    bRegex: null !== a && a,
                    bSmart: null === o || o,
                    bCaseInsensitive: null === i || i
                }), Y(t, t.oPreviousSearch, 1))
            })
        }), Zt("state()", function () {
            return this.context.length ? this.context[0].oSavedState : null
        }), Zt("state.clear()", function () {
            return this.iterator("table", function (t) {
                t.fnStateSaveCallback.call(t.oInstance, t, {})
            })
        }), Zt("state.loaded()", function () {
            return this.context.length ? this.context[0].oLoadedState : null
        }), Zt("state.save()", function () {
            return this.iterator("table", function (t) {
                At(t)
            })
        }), Kt.versionCheck = Kt.fnVersionCheck = function (t) {
            for (var e, n, r = Kt.version.split("."), a = 0, o = (t = t.split(".")).length; a < o; a++)
                if ((e = parseInt(r[a], 10) || 0) !== (n = parseInt(t[a], 10) || 0)) return n < e;
            return !0
        }, Kt.isDataTable = Kt.fnIsDataTable = function (t) {
            var r = P(t).get(0),
                a = !1;
            return t instanceof Kt.Api || (P.each(Kt.settings, function (t, e) {
                t = e.nScrollHead ? P("table", e.nScrollHead)[0] : null;
                var n = e.nScrollFoot ? P("table", e.nScrollFoot)[0] : null;
                e.nTable !== r && t !== r && n !== r || (a = !0)
            }), a)
        }, Kt.tables = Kt.fnTables = function (e) {
            var t = !1;
            P.isPlainObject(e) && (t = e.api, e = e.visible);
            var n = P.map(Kt.settings, function (t) {
                if (!e || e && P(t.nTable).is(":visible")) return t.nTable
            });
            return t ? new ye(n) : n
        }, Kt.camelToHungarian = S, Zt("$()", function (t, e) {
            return e = this.rows(e).nodes(), e = P(e), P([].concat(e.filter(t).toArray(), e.find(t).toArray()))
        }), P.each(["on", "one", "off"], function (t, n) {
            Zt(n + "()", function () {
                var t = Array.prototype.slice.call(arguments);
                t[0] = P.map(t[0].split(/\s/), function (t) {
                    return t.match(/\.dt\b/) ? t : t + ".dt"
                }).join(" ");
                var e = P(this.tables().nodes());
                return e[n].apply(e, t), this
            })
        }), Zt("clear()", function () {
            return this.iterator("table", function (t) {
                l(t)
            })
        }), Zt("settings()", function () {
            return new ye(this.context, this.context)
        }), Zt("init()", function () {
            var t = this.context;
            return t.length ? t[0].oInit : null
        }), Zt("data()", function () {
            return this.iterator("table", function (t) {
                return ie(t.aoData, "_aData")
            }).flatten()
        }), Zt("destroy()", function (d) {
            return d = d || !1, this.iterator("table", function (e) {
                var n, t = e.nTableWrapper.parentNode,
                    r = e.oClasses,
                    a = e.nTable,
                    o = e.nTBody,
                    i = e.nTHead,
                    s = e.nTFoot,
                    l = P(a),
                    o = P(o),
                    c = P(e.nTableWrapper),
                    u = P.map(e.aoData, function (t) {
                        return t.nTr
                    });
                e.bDestroying = !0, kt(e, "aoDestroyCallback", "destroy", [e]), d || new ye(e).columns().visible(!0), c.off(".DT").find(":not(tbody *)").off(".DT"), P(m).off(".DT-" + e.sInstance), a != i.parentNode && (l.children("thead").detach(), l.append(i)), s && a != s.parentNode && (l.children("tfoot").detach(), l.append(s)), e.aaSorting = [], e.aaSortingFixed = [], Ct(e), P(u).removeClass(e.asStripeClasses.join(" ")), P("th, td", i).removeClass(r.sSortable + " " + r.sSortableAsc + " " + r.sSortableDesc + " " + r.sSortableNone), o.children().detach(), o.append(u), l[i = d ? "remove" : "detach"](), c[i](), !d && t && (t.insertBefore(a, e.nTableReinsertBefore), l.css("width", e.sDestroyWidth).removeClass(r.sTable), (n = e.asDestroyStripes.length) && o.children().each(function (t) {
                    P(this).addClass(e.asDestroyStripes[t % n])
                })), -1 !== (t = P.inArray(e, Kt.settings)) && Kt.settings.splice(t, 1)
            })
        }), P.each(["column", "row", "cell"], function (t, l) {
            Zt(l + "s().every()", function (o) {
                var i = this.selector.opts,
                    s = this;
                return this.iterator(l, function (t, e, n, r, a) {
                    o.call(s[l](e, "cell" === l ? n : i, "cell" === l ? i : R), e, n, r, a)
                })
            })
        }), Zt("i18n()", function (t, e, n) {
            var r = this.context[0];
            return (t = k(t)(r.oLanguage)) === R && (t = e), (t = n !== R && P.isPlainObject(t) ? t[n] !== R ? t[n] : t._ : t).replace("%d", n)
        }), Kt.version = "1.10.22", Kt.settings = [], Kt.models = {}, Kt.models.oSearch = {
            bCaseInsensitive: !0,
            sSearch: "",
            bRegex: !1,
            bSmart: !0
        }, Kt.models.oRow = {
            nTr: null,
            anCells: null,
            _aData: [],
            _aSortData: null,
            _aFilterData: null,
            _sFilterRow: null,
            _sRowStripe: "",
            src: null,
            idx: -1
        }, Kt.models.oColumn = {
            idx: null,
            aDataSort: null,
            asSorting: null,
            bSearchable: null,
            bSortable: null,
            bVisible: null,
            _sManualType: null,
            _bAttrSrc: !1,
            fnCreatedCell: null,
            fnGetData: null,
            fnSetData: null,
            mData: null,
            mRender: null,
            nTh: null,
            nTf: null,
            sClass: null,
            sContentPadding: null,
            sDefaultContent: null,
            sName: null,
            sSortDataType: "std",
            sSortingClass: null,
            sSortingClassJUI: null,
            sTitle: null,
            sType: null,
            sWidth: null,
            sWidthOrig: null
        }, Kt.defaults = {
            aaData: null,
            aaSorting: [
                [0, "asc"]
            ],
            aaSortingFixed: [],
            ajax: null,
            aLengthMenu: [10, 25, 50, 100],
            aoColumns: null,
            aoColumnDefs: null,
            aoSearchCols: [],
            asStripeClasses: null,
            bAutoWidth: !0,
            bDeferRender: !1,
            bDestroy: !1,
            bFilter: !0,
            bInfo: !0,
            bLengthChange: !0,
            bPaginate: !0,
            bProcessing: !1,
            bRetrieve: !1,
            bScrollCollapse: !1,
            bServerSide: !1,
            bSort: !0,
            bSortMulti: !0,
            bSortCellsTop: !1,
            bSortClasses: !0,
            bStateSave: !1,
            fnCreatedRow: null,
            fnDrawCallback: null,
            fnFooterCallback: null,
            fnFormatNumber: function (t) {
                return t.toString().replace(/\B(?=(\d{3})+(?!\d))/g, this.oLanguage.sThousands)
            },
            fnHeaderCallback: null,
            fnInfoCallback: null,
            fnInitComplete: null,
            fnPreDrawCallback: null,
            fnRowCallback: null,
            fnServerData: null,
            fnServerParams: null,
            fnStateLoadCallback: function (t) {
                try {
                    return JSON.parse((-1 === t.iStateDuration ? sessionStorage : localStorage).getItem("DataTables_" + t.sInstance + "_" + location.pathname))
                } catch (t) {
                    return {}
                }
            },
            fnStateLoadParams: null,
            fnStateLoaded: null,
            fnStateSaveCallback: function (t, e) {
                try {
                    (-1 === t.iStateDuration ? sessionStorage : localStorage).setItem("DataTables_" + t.sInstance + "_" + location.pathname, JSON.stringify(e))
                } catch (t) {}
            },
            fnStateSaveParams: null,
            iStateDuration: 7200,
            iDeferLoading: null,
            iDisplayLength: 10,
            iDisplayStart: 0,
            iTabIndex: 0,
            oClasses: {},
            oLanguage: {
                oAria: {
                    sSortAscending: ": activate to sort column ascending",
                    sSortDescending: ": activate to sort column descending"
                },
                oPaginate: {
                    sFirst: "First",
                    sLast: "Last",
                    sNext: "Next",
                    sPrevious: "Previous"
                },
                sEmptyTable: "No data available in table",
                sInfo: "Showing _START_ to _END_ of _TOTAL_ entries",
                sInfoEmpty: "Showing 0 to 0 of 0 entries",
                sInfoFiltered: "(filtered from _MAX_ total entries)",
                sInfoPostFix: "",
                sDecimal: "",
                sThousands: ",",
                sLengthMenu: "Show _MENU_ entries",
                sLoadingRecords: "Loading...",
                sProcessing: "Processing...",
                sSearch: "Search:",
                sSearchPlaceholder: "",
                sUrl: "",
                sZeroRecords: "No matching records found"
            },
            oSearch: P.extend({}, Kt.models.oSearch),
            sAjaxDataProp: "data",
            sAjaxSource: null,
            sDom: "lfrtip",
            searchDelay: null,
            sPaginationType: "simple_numbers",
            sScrollX: "",
            sScrollXInner: "",
            sScrollY: "",
            sServerMethod: "GET",
            renderer: null,
            rowId: "DT_RowId"
        }, i(Kt.defaults), Kt.defaults.column = {
            aDataSort: null,
            iDataSort: -1,
            asSorting: ["asc", "desc"],
            bSearchable: !0,
            bSortable: !0,
            bVisible: !0,
            fnCreatedCell: null,
            mData: null,
            mRender: null,
            sCellType: "td",
            sClass: "",
            sContentPadding: "",
            sDefaultContent: null,
            sName: "",
            sSortDataType: "std",
            sTitle: null,
            sType: null,
            sWidth: null
        }, i(Kt.defaults.column), Kt.models.oSettings = {
            oFeatures: {
                bAutoWidth: null,
                bDeferRender: null,
                bFilter: null,
                bInfo: null,
                bLengthChange: null,
                bPaginate: null,
                bProcessing: null,
                bServerSide: null,
                bSort: null,
                bSortMulti: null,
                bSortClasses: null,
                bStateSave: null
            },
            oScroll: {
                bCollapse: null,
                iBarWidth: 0,
                sX: null,
                sXInner: null,
                sY: null
            },
            oLanguage: {
                fnInfoCallback: null
            },
            oBrowser: {
                bScrollOversize: !1,
                bScrollbarLeft: !1,
                bBounding: !1,
                barWidth: 0
            },
            ajax: null,
            aanFeatures: [],
            aoData: [],
            aiDisplay: [],
            aiDisplayMaster: [],
            aIds: {},
            aoColumns: [],
            aoHeader: [],
            aoFooter: [],
            oPreviousSearch: {},
            aoPreSearchCols: [],
            aaSorting: null,
            aaSortingFixed: [],
            asStripeClasses: null,
            asDestroyStripes: [],
            sDestroyWidth: 0,
            aoRowCallback: [],
            aoHeaderCallback: [],
            aoFooterCallback: [],
            aoDrawCallback: [],
            aoRowCreatedCallback: [],
            aoPreDrawCallback: [],
            aoInitComplete: [],
            aoStateSaveParams: [],
            aoStateLoadParams: [],
            aoStateLoaded: [],
            sTableId: "",
            nTable: null,
            nTHead: null,
            nTFoot: null,
            nTBody: null,
            nTableWrapper: null,
            bDeferLoading: !1,
            bInitialised: !1,
            aoOpenRows: [],
            sDom: null,
            searchDelay: null,
            sPaginationType: "two_button",
            iStateDuration: 0,
            aoStateSave: [],
            aoStateLoad: [],
            oSavedState: null,
            oLoadedState: null,
            sAjaxSource: null,
            sAjaxDataProp: null,
            bAjaxDataGet: !0,
            jqXHR: null,
            json: R,
            oAjaxData: R,
            fnServerData: null,
            aoServerParams: [],
            sServerMethod: null,
            fnFormatNumber: null,
            aLengthMenu: null,
            iDraw: 0,
            bDrawing: !1,
            iDrawError: -1,
            _iDisplayLength: 10,
            _iDisplayStart: 0,
            _iRecordsTotal: 0,
            _iRecordsDisplay: 0,
            oClasses: {},
            bFiltered: !1,
            bSorted: !1,
            bSortCellsTop: null,
            oInit: null,
            aoDestroyCallback: [],
            fnRecordsTotal: function () {
                return "ssp" == Ht(this) ? +this._iRecordsTotal : this.aiDisplayMaster.length
            },
            fnRecordsDisplay: function () {
                return "ssp" == Ht(this) ? +this._iRecordsDisplay : this.aiDisplay.length
            },
            fnDisplayEnd: function () {
                var t = this._iDisplayLength,
                    e = this._iDisplayStart,
                    n = e + t,
                    r = this.aiDisplay.length,
                    a = this.oFeatures,
                    o = a.bPaginate;
                return a.bServerSide ? !1 === o || -1 === t ? e + r : Math.min(e + t, this._iRecordsDisplay) : !o || r < n || -1 === t ? r : n
            },
            oInstance: null,
            sInstance: null,
            iTabIndex: 0,
            nScrollHead: null,
            nScrollFoot: null,
            aLastSort: [],
            oPlugins: {},
            rowIdFn: null,
            rowId: null
        }, Kt.ext = Gt = {
            buttons: {},
            classes: {},
            builder: "-source-",
            errMode: "alert",
            feature: [],
            search: [],
            selector: {
                cell: [],
                column: [],
                row: []
            },
            internal: {},
            legacy: {
                ajax: null
            },
            pager: {},
            renderer: {
                pageButton: {},
                header: {}
            },
            order: {},
            type: {
                detect: [],
                search: {},
                order: {}
            },
            _unique: 0,
            fnVersionCheck: Kt.fnVersionCheck,
            iApiIndex: 0,
            oJUIClasses: {},
            sVersion: Kt.version
        }, P.extend(Gt, {
            afnFiltering: Gt.search,
            aTypes: Gt.type.detect,
            ofnSearch: Gt.type.search,
            oSort: Gt.type.order,
            afnSortData: Gt.order,
            aoFeatures: Gt.feature,
            oApi: Gt.internal,
            oStdClasses: Gt.classes,
            oPagination: Gt.pager
        }), P.extend(Kt.ext.classes, {
            sTable: "dataTable",
            sNoFooter: "no-footer",
            sPageButton: "paginate_button",
            sPageButtonActive: "current",
            sPageButtonDisabled: "disabled",
            sStripeOdd: "odd",
            sStripeEven: "even",
            sRowEmpty: "dataTables_empty",
            sWrapper: "dataTables_wrapper",
            sFilter: "dataTables_filter",
            sInfo: "dataTables_info",
            sPaging: "dataTables_paginate paging_",
            sLength: "dataTables_length",
            sProcessing: "dataTables_processing",
            sSortAsc: "sorting_asc",
            sSortDesc: "sorting_desc",
            sSortable: "sorting",
            sSortableAsc: "sorting_asc_disabled",
            sSortableDesc: "sorting_desc_disabled",
            sSortableNone: "sorting_disabled",
            sSortColumn: "sorting_",
            sFilterInput: "",
            sLengthSelect: "",
            sScrollWrapper: "dataTables_scroll",
            sScrollHead: "dataTables_scrollHead",
            sScrollHeadInner: "dataTables_scrollHeadInner",
            sScrollBody: "dataTables_scrollBody",
            sScrollFoot: "dataTables_scrollFoot",
            sScrollFootInner: "dataTables_scrollFootInner",
            sHeaderTH: "",
            sFooterTH: "",
            sSortJUIAsc: "",
            sSortJUIDesc: "",
            sSortJUI: "",
            sSortJUIAscAllowed: "",
            sSortJUIDescAllowed: "",
            sSortJUIWrapper: "",
            sSortIcon: "",
            sJUIHeader: "",
            sJUIFooter: ""
        });
        var Fe = Kt.ext.pager;
        P.extend(Fe, {
            simple: function (t, e) {
                return ["previous", "next"]
            },
            full: function (t, e) {
                return ["first", "previous", "next", "last"]
            },
            numbers: function (t, e) {
                return [Mt(t, e)]
            },
            simple_numbers: function (t, e) {
                return ["previous", Mt(t, e), "next"]
            },
            full_numbers: function (t, e) {
                return ["first", "previous", Mt(t, e), "next", "last"]
            },
            first_last_numbers: function (t, e) {
                return ["first", Mt(t, e), "last"]
            },
            _numbers: Mt,
            numbers_length: 7
        }), P.extend(!0, Kt.ext.renderer, {
            pageButton: {
                _: function (l, t, c, e, u, d) {
                    var f, h, p = l.oClasses,
                        g = l.oLanguage.oPaginate,
                        b = l.oLanguage.oAria.paginate || {},
                        m = 0,
                        v = function (t, e) {
                            function n(t) {
                                ut(l, t.data.action, !0)
                            }
                            for (var r = p.sPageButtonDisabled, a = 0, o = e.length; a < o; a++) {
                                var i = e[a];
                                if (Array.isArray(i)) {
                                    var s = P("<" + (i.DT_el || "div") + "/>").appendTo(t);
                                    v(s, i)
                                } else {
                                    switch (f = null, h = i, s = l.iTabIndex, i) {
                                        case "ellipsis":
                                            t.append('<span class="ellipsis">&#x2026;</span>');
                                            break;
                                        case "first":
                                            f = g.sFirst, 0 === u && (s = -1, h += " " + r);
                                            break;
                                        case "previous":
                                            f = g.sPrevious, 0 === u && (s = -1, h += " " + r);
                                            break;
                                        case "next":
                                            f = g.sNext, 0 !== d && u !== d - 1 || (s = -1, h += " " + r);
                                            break;
                                        case "last":
                                            f = g.sLast, 0 !== d && u !== d - 1 || (s = -1, h += " " + r);
                                            break;
                                        default:
                                            f = l.fnFormatNumber(i + 1), h = u === i ? p.sPageButtonActive : ""
                                    }
                                    null !== f && (Ot(s = P("<a>", {
                                        class: p.sPageButton + " " + h,
                                        "aria-controls": l.sTableId,
                                        "aria-label": b[i],
                                        "data-dt-idx": m,
                                        tabindex: s,
                                        id: 0 === c && "string" == typeof i ? l.sTableId + "_" + i : null
                                    }).html(f).appendTo(t), {
                                        action: i
                                    }, n), m++)
                                }
                            }
                        };
                    try {
                        var n = P(t).find(y.activeElement).data("dt-idx")
                    } catch (t) {}
                    v(P(t).empty(), e), n !== R && P(t).find("[data-dt-idx=" + n + "]").trigger("focus")
                }
            }
        }), P.extend(Kt.ext.type.detect, [function (t, e) {
            return e = e.oLanguage.sDecimal, Xt(t, e) ? "num" + e : null
        }, function (t, e) {
            return (!t || t instanceof Date || re.test(t)) && (null !== (e = Date.parse(t)) && !isNaN(e) || Bt(t)) ? "date" : null
        }, function (t, e) {
            return e = e.oLanguage.sDecimal, Xt(t, e, !0) ? "num-fmt" + e : null
        }, function (t, e) {
            return e = e.oLanguage.sDecimal, qt(t, e) ? "html-num" + e : null
        }, function (t, e) {
            return e = e.oLanguage.sDecimal, qt(t, e, !0) ? "html-num-fmt" + e : null
        }, function (t, e) {
            return Bt(t) || "string" == typeof t && -1 !== t.indexOf("<") ? "html" : null
        }]), P.extend(Kt.ext.type.search, {
            html: function (t) {
                return Bt(t) ? t : "string" == typeof t ? t.replace(ee, " ").replace(ne, "") : ""
            },
            string: function (t) {
                return !Bt(t) && "string" == typeof t ? t.replace(ee, " ") : t
            }
        });
        var Pe = function (t, e, n, r) {
            return 0 === t || t && "-" !== t ? ((t = e ? Vt(t, e) : t).replace && (n && (t = t.replace(n, "")), r && (t = t.replace(r, ""))), +t) : -1 / 0
        };
        P.extend(Gt.type.order, {
            "date-pre": function (t) {
                return t = Date.parse(t), isNaN(t) ? -1 / 0 : t
            },
            "html-pre": function (t) {
                return Bt(t) ? "" : t.replace ? t.replace(/<.*?>/g, "").toLowerCase() : t + ""
            },
            "string-pre": function (t) {
                return Bt(t) ? "" : "string" == typeof t ? t.toLowerCase() : t.toString ? t.toString() : ""
            },
            "string-asc": function (t, e) {
                return t < e ? -1 : e < t ? 1 : 0
            },
            "string-desc": function (t, e) {
                return t < e ? 1 : e < t ? -1 : 0
            }
        }), Wt(""), P.extend(!0, Kt.ext.renderer, {
            header: {
                _: function (a, o, i, s) {
                    P(a.nTable).on("order.dt.DT", function (t, e, n, r) {
                        a === e && (t = i.idx, o.removeClass(i.sSortingClass + " " + s.sSortAsc + " " + s.sSortDesc).addClass("asc" == r[t] ? s.sSortAsc : "desc" == r[t] ? s.sSortDesc : i.sSortingClass))
                    })
                },
                jqueryui: function (a, o, i, s) {
                    P("<div/>").addClass(s.sSortJUIWrapper).append(o.contents()).append(P("<span/>").addClass(s.sSortIcon + " " + i.sSortingClassJUI)).appendTo(o), P(a.nTable).on("order.dt.DT", function (t, e, n, r) {
                        a === e && (t = i.idx, o.removeClass(s.sSortAsc + " " + s.sSortDesc).addClass("asc" == r[t] ? s.sSortAsc : "desc" == r[t] ? s.sSortDesc : i.sSortingClass), o.find("span." + s.sSortIcon).removeClass(s.sSortJUIAsc + " " + s.sSortJUIDesc + " " + s.sSortJUI + " " + s.sSortJUIAscAllowed + " " + s.sSortJUIDescAllowed).addClass("asc" == r[t] ? s.sSortJUIAsc : "desc" == r[t] ? s.sSortJUIDesc : i.sSortingClassJUI))
                    })
                }
            }
        });

        function Re(t) {
            return "string" == typeof t ? t.replace(/&/g, "&amp;").replace(/</g, "&lt;").replace(/>/g, "&gt;").replace(/"/g, "&quot;") : t
        }
        return Kt.render = {
            number: function (r, a, o, i, s) {
                return {
                    display: function (t) {
                        if ("number" != typeof t && "string" != typeof t) return t;
                        var e = t < 0 ? "-" : "",
                            n = parseFloat(t);
                        return isNaN(n) ? Re(t) : (n = n.toFixed(o), t = Math.abs(n), n = parseInt(t, 10), t = o ? a + (t - n).toFixed(o).substring(2) : "", e + (i || "") + n.toString().replace(/\B(?=(\d{3})+(?!\d))/g, r) + t + (s || ""))
                    }
                }
            },
            text: function () {
                return {
                    display: Re,
                    filter: Re
                }
            }
        }, P.extend(Kt.ext.internal, {
            _fnExternApiFunc: e,
            _fnBuildAjax: V,
            _fnAjaxUpdate: X,
            _fnAjaxParameters: t,
            _fnAjaxUpdateDraw: o,
            _fnAjaxDataSrc: q,
            _fnAddColumn: x,
            _fnColumnOptions: C,
            _fnAdjustColumnSizing: O,
            _fnVisibleToColumnIndex: N,
            _fnColumnIndexToVisible: c,
            _fnVisbleColumns: v,
            _fnGetColumns: I,
            _fnColumnTypes: s,
            _fnApplyColumnDefs: A,
            _fnHungarianMap: i,
            _fnCamelToHungarian: S,
            _fnLanguageCompat: _,
            _fnBrowserDetect: T,
            _fnAddData: j,
            _fnAddTr: L,
            _fnNodeToDataIndex: function (t, e) {
                return e._DT_RowIndex !== R ? e._DT_RowIndex : null
            },
            _fnNodeToColumnIndex: function (t, e, n) {
                return P.inArray(n, t.aoData[e].anCells)
            },
            _fnGetCellData: F,
            _fnSetCellData: r,
            _fnSplitObjNotation: u,
            _fnGetObjectDataFn: k,
            _fnSetObjectDataFn: p,
            _fnGetDataMaster: g,
            _fnClearTable: l,
            _fnDeleteIndex: d,
            _fnInvalidate: a,
            _fnGetRowElements: f,
            _fnCreateTr: b,
            _fnBuildHead: $,
            _fnDrawHead: E,
            _fnDraw: H,
            _fnReDraw: M,
            _fnAddOptionsHtml: W,
            _fnDetectHeader: B,
            _fnGetUniqueThs: U,
            _fnFeatureHtmlFilter: z,
            _fnFilterComplete: Y,
            _fnFilterCustom: J,
            _fnFilterColumn: G,
            _fnFilter: Z,
            _fnFilterCreateSearch: Q,
            _fnEscapeRegex: fe,
            _fnFilterData: K,
            _fnFeatureHtmlInfo: nt,
            _fnUpdateInfo: rt,
            _fnInfoMacros: at,
            _fnInitialise: ot,
            _fnInitComplete: it,
            _fnLengthChange: st,
            _fnFeatureHtmlLength: lt,
            _fnFeatureHtmlPaginate: ct,
            _fnPageChange: ut,
            _fnFeatureHtmlProcessing: dt,
            _fnProcessingDisplay: ft,
            _fnFeatureHtmlTable: ht,
            _fnScrollDraw: pt,
            _fnApplyToChildren: gt,
            _fnCalculateColumnWidths: bt,
            _fnThrottle: be,
            _fnConvertToWidth: mt,
            _fnGetWidestNode: vt,
            _fnGetMaxLenString: yt,
            _fnStringToCss: St,
            _fnSortFlatten: _t,
            _fnSort: Dt,
            _fnSortAria: wt,
            _fnSortListener: Tt,
            _fnSortAttachListener: xt,
            _fnSortingClasses: Ct,
            _fnSortData: It,
            _fnSaveState: At,
            _fnLoadState: jt,
            _fnSettingsFromNode: Lt,
            _fnLog: Ft,
            _fnMap: Pt,
            _fnBindAction: Ot,
            _fnCallbackReg: Nt,
            _fnCallbackFire: kt,
            _fnLengthOverflow: $t,
            _fnRenderer: Et,
            _fnDataSource: Ht,
            _fnRowAttributes: h,
            _fnExtend: Rt,
            _fnCalculateEnd: function () {}
        }), ((P.fn.dataTable = Kt).$ = P).fn.dataTableSettings = Kt.settings, P.fn.dataTableExt = Kt.ext, P.fn.DataTable = function (t) {
            return P(this).dataTable(t).api()
        }, P.each(Kt, function (t, e) {
            P.fn.DataTable[t] = e
        }), P.fn.dataTable
    }), ($jscomp = $jscomp || {}).scope = {}, $jscomp.findInternal = function (t, e, n) {
        for (var r = (t = t instanceof String ? String(t) : t).length, a = 0; a < r; a++) {
            var o = t[a];
            if (e.call(n, o, a, t)) return {
                i: a,
                v: o
            }
        }
        return {
            i: -1,
            v: void 0
        }
    }, $jscomp.ASSUME_ES5 = !1, $jscomp.ASSUME_NO_NATIVE_MAP = !1, $jscomp.ASSUME_NO_NATIVE_SET = !1, $jscomp.SIMPLE_FROUND_POLYFILL = !1, $jscomp.ISOLATE_POLYFILLS = !1, $jscomp.defineProperty = $jscomp.ASSUME_ES5 || "function" == typeof Object.defineProperties ? Object.defineProperty : function (t, e, n) {
        return t == Array.prototype || t == Object.prototype || (t[e] = n.value), t
    }, $jscomp.getGlobal = function (t) {
        t = ["object" == typeof globalThis && globalThis, t, "object" == typeof window && window, "object" == typeof self && self, "object" == typeof global && global];
        for (var e = 0; e < t.length; ++e) {
            var n = t[e];
            if (n && n.Math == Math) return n
        }
        throw Error("Cannot find global object")
    }, $jscomp.global = $jscomp.getGlobal(this), $jscomp.IS_SYMBOL_NATIVE = "function" == typeof Symbol && "symbol" == typeof Symbol("x"), $jscomp.TRUST_ES6_POLYFILLS = !$jscomp.ISOLATE_POLYFILLS || $jscomp.IS_SYMBOL_NATIVE, $jscomp.polyfills = {}, $jscomp.propertyToPolyfillSymbol = {}, $jscomp.POLYFILL_PREFIX = "$jscp$";
$jscomp$lookupPolyfilledValue = function (t, e) {
    var n = $jscomp.propertyToPolyfillSymbol[e];
    return null != n && void 0 !== (n = t[n]) ? n : t[e]
};
$jscomp.polyfill = function (t, e, n, r) {
        e && ($jscomp.ISOLATE_POLYFILLS ? $jscomp.polyfillIsolated(t, e, n, r) : $jscomp.polyfillUnisolated(t, e, n, r))
    }, $jscomp.polyfillUnisolated = function (t, e, n, r) {
        for (n = $jscomp.global, t = t.split("."), r = 0; r < t.length - 1; r++) {
            var a = t[r];
            if (!(a in n)) return;
            n = n[a]
        }(e = e(r = n[t = t[t.length - 1]])) != r && null != e && $jscomp.defineProperty(n, t, {
            configurable: !0,
            writable: !0,
            value: e
        })
    }, $jscomp.polyfillIsolated = function (t, e, n, r) {
        var a = t.split(".");
        t = 1 === a.length, r = a[0], r = !t && r in $jscomp.polyfills ? $jscomp.polyfills : $jscomp.global;
        for (var o = 0; o < a.length - 1; o++) {
            var i = a[o];
            if (!(i in r)) return;
            r = r[i]
        }
        a = a[a.length - 1], null != (e = e(n = $jscomp.IS_SYMBOL_NATIVE && "es6" === n ? r[a] : null)) && (t ? $jscomp.defineProperty($jscomp.polyfills, a, {
            configurable: !0,
            writable: !0,
            value: e
        }) : e !== n && ($jscomp.propertyToPolyfillSymbol[a] = $jscomp.IS_SYMBOL_NATIVE ? $jscomp.global.Symbol(a) : $jscomp.POLYFILL_PREFIX + a, a = $jscomp.propertyToPolyfillSymbol[a], $jscomp.defineProperty(r, a, {
            configurable: !0,
            writable: !0,
            value: e
        })))
    }, $jscomp.polyfill("Array.prototype.find", function (t) {
        return t || function (t, e) {
            return $jscomp.findInternal(this, t, e).v
        }
    }, "es6", "es3"),
    function (n) {
        "function" == typeof define && define.amd ? define(["jquery", "datatables.net"], function (t) {
            return n(t, window, document)
        }) : "object" == typeof exports ? module.exports = function (t, e) {
            return t = t || window, e && e.fn.dataTable || (e = require("datatables.net")(t, e).$), n(e, 0, t.document)
        } : n(jQuery, window, document)
    }(function (y, t, r, a) {
        var o = y.fn.dataTable;
        return y.extend(!0, o.defaults, {
            dom: "<'row'<'col-sm-12 col-md-6'l><'col-sm-12 col-md-6'f>><'row'<'col-sm-12'tr>><'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7'p>>",
            renderer: "bootstrap"
        }), y.extend(o.ext.classes, {
            sWrapper: "dataTables_wrapper dt-bootstrap5",
            sFilterInput: "form-control form-control-sm",
            sLengthSelect: "form-select form-select-sm",
            sProcessing: "dataTables_processing card",
            sPageButton: "paginate_button page-item"
        }), o.ext.renderer.pageButton.bootstrap = function (s, t, l, e, c, u) {
            var d, f, h = new o.Api(s),
                p = s.oClasses,
                g = s.oLanguage.oPaginate,
                b = s.oLanguage.oAria.paginate || {},
                m = 0,
                v = function (t, e) {
                    function n(t) {
                        t.preventDefault(), y(t.currentTarget).hasClass("disabled") || h.page() == t.data.action || h.page(t.data.action).draw("page")
                    }
                    for (var r = 0, a = e.length; r < a; r++) {
                        var o, i = e[r];
                        if (Array.isArray(i)) v(t, i);
                        else {
                            switch (f = d = "", i) {
                                case "ellipsis":
                                    d = "&#x2026;", f = "disabled";
                                    break;
                                case "first":
                                    d = g.sFirst, f = i + (0 < c ? "" : " disabled");
                                    break;
                                case "previous":
                                    d = g.sPrevious, f = i + (0 < c ? "" : " disabled");
                                    break;
                                case "next":
                                    d = g.sNext, f = i + (c < u - 1 ? "" : " disabled");
                                    break;
                                case "last":
                                    d = g.sLast, f = i + (c < u - 1 ? "" : " disabled");
                                    break;
                                default:
                                    d = i + 1, f = c === i ? "active" : ""
                            }
                            d && (o = y("<li>", {
                                class: p.sPageButton + " " + f,
                                id: 0 === l && "string" == typeof i ? s.sTableId + "_" + i : null
                            }).append(y("<a>", {
                                href: "#",
                                "aria-controls": s.sTableId,
                                "aria-label": b[i],
                                "data-dt-idx": m,
                                tabindex: s.iTabIndex,
                                class: "page-link"
                            }).html(d)).appendTo(t), s.oApi._fnBindAction(o, {
                                action: i
                            }, n), m++)
                        }
                    }
                };
            try {
                var n = y(t).find(r.activeElement).data("dt-idx")
            } catch (t) {}
            v(y(t).empty().html('<ul class="pagination"/>').children("ul"), e), n !== a && y(t).find("[data-dt-idx=" + n + "]").trigger("focus")
        }, o
    }),
    function (n) {
        "function" == typeof define && define.amd ? define(["jquery", "datatables.net"], function (t) {
            return n(t, window, document)
        }) : "object" == typeof exports ? module.exports = function (t, e) {
            return t = t || window, e && e.fn.dataTable || (e = require("datatables.net")(t, e).$), n(e, t, t.document)
        } : n(jQuery, window, document)
    }(function (d, f, i, c) {
        function s(t, e, n) {
            var r = e + "-" + n;
            if (l[r]) {
                for (var t = t.cell(e, n).node(), e = [], a = 0, o = (n = l[r][0].parentNode.childNodes).length; a < o; a++) e.push(n[a]);
                for (n = 0, a = e.length; n < a; n++) t.appendChild(e[n]);
                l[r] = c
            }
        }
        var r = d.fn.dataTable,
            n = function (t, e) {
                if (!r.versionCheck || !r.versionCheck("1.10.10")) throw "DataTables Responsive requires DataTables 1.10.10 or newer";
                this.s = {
                    dt: new r.Api(t),
                    columns: [],
                    current: []
                }, this.s.dt.settings()[0].responsive || (e && "string" == typeof e.details ? e.details = {
                    type: e.details
                } : e && !1 === e.details ? e.details = {
                    type: !1
                } : e && !0 === e.details && (e.details = {
                    type: "inline"
                }), this.c = d.extend(!0, {}, n.defaults, r.defaults.responsive, e), (t.responsive = this)._constructor())
            };
        d.extend(n.prototype, {
            _constructor: function () {
                var o = this,
                    e = this.s.dt,
                    t = e.settings()[0],
                    n = d(f).width();
                e.settings()[0]._responsive = this, d(f).on("resize.dtr orientationchange.dtr", r.util.throttle(function () {
                    var t = d(f).width();
                    t !== n && (o._resize(), n = t)
                })), t.oApi._fnCallbackReg(t, "aoRowCreatedCallback", function (t) {
                    -1 !== d.inArray(!1, o.s.current) && d(">td, >th", t).each(function (t) {
                        t = e.column.index("toData", t), !1 === o.s.current[t] && d(this).css("display", "none")
                    })
                }), e.on("destroy.dtr", function () {
                    e.off(".dtr"), d(e.table().body()).off(".dtr"), d(f).off("resize.dtr orientationchange.dtr"), d.each(o.s.current, function (t, e) {
                        !1 === e && o._setColumnVis(t, !0)
                    })
                }), this.c.breakpoints.sort(function (t, e) {
                    return t.width < e.width ? 1 : t.width > e.width ? -1 : 0
                }), this._classLogic(), this._resizeAuto(), !1 !== (t = this.c.details).type && (o._detailsInit(), e.on("column-visibility.dtr", function (t, e, n, r, a) {
                    a && (o._classLogic(), o._resizeAuto(), o._resize())
                }), e.on("draw.dtr", function () {
                    o._redrawChildren()
                }), d(e.table().node()).addClass("dtr-" + t.type)), e.on("column-reorder.dtr", function () {
                    o._classLogic(), o._resizeAuto(), o._resize()
                }), e.on("column-sizing.dtr", function () {
                    o._resizeAuto(), o._resize()
                }), e.on("preXhr.dtr", function () {
                    var t = [];
                    e.rows().every(function () {
                        this.child.isShown() && t.push(this.id(!0))
                    }), e.one("draw.dtr", function () {
                        o._resizeAuto(), o._resize(), e.rows(t).every(function () {
                            o._detailsDisplay(this, !1)
                        })
                    })
                }), e.on("init.dtr", function () {
                    o._resizeAuto(), o._resize(), d.inArray(!1, o.s.current) && e.columns.adjust()
                }), this._resize()
            },
            _columnsVisiblity: function (e) {
                for (var t = this.s.dt, n = this.s.columns, r = n.map(function (t, e) {
                        return {
                            columnIdx: e,
                            priority: t.priority
                        }
                    }).sort(function (t, e) {
                        return t.priority !== e.priority ? t.priority - e.priority : t.columnIdx - e.columnIdx
                    }), a = d.map(n, function (t) {
                        return (!t.auto || null !== t.minWidth) && (!0 === t.auto ? "-" : -1 !== d.inArray(e, t.includeIn))
                    }), o = 0, i = 0, s = a.length; i < s; i++) !0 === a[i] && (o += n[i].minWidth);
                for (i = (i = t.settings()[0].oScroll).sY || i.sX ? i.iBarWidth : 0, t = t.table().container().offsetWidth - i - o, i = 0, s = a.length; i < s; i++) n[i].control && (t -= n[i].minWidth);
                for (o = !1, i = 0, s = r.length; i < s; i++) {
                    var l = r[i].columnIdx;
                    "-" === a[l] && !n[l].control && n[l].minWidth && (o || t - n[l].minWidth < 0 ? a[l] = !(o = !0) : a[l] = !0, t -= n[l].minWidth)
                }
                for (r = !1, i = 0, s = n.length; i < s; i++)
                    if (!n[i].control && !n[i].never && !a[i]) {
                        r = !0;
                        break
                    } for (i = 0, s = n.length; i < s; i++) n[i].control && (a[i] = r);
                return -1 === d.inArray(!0, a) && (a[0] = !0), a
            },
            _classLogic: function () {
                function a(t, e) {
                    t = i[t].includeIn, -1 === d.inArray(e, t) && t.push(e)
                }

                function s(t, e, n, r) {
                    if (n) {
                        if ("max-" === n)
                            for (r = o._find(e).width, e = 0, n = l.length; e < n; e++) l[e].width <= r && a(t, l[e].name);
                        else if ("min-" === n)
                            for (r = o._find(e).width, e = 0, n = l.length; e < n; e++) l[e].width >= r && a(t, l[e].name);
                        else if ("not-" === n)
                            for (e = 0, n = l.length; e < n; e++) - 1 === l[e].name.indexOf(r) && a(t, l[e].name)
                    } else i[t].includeIn.push(e)
                }
                var o = this,
                    l = this.c.breakpoints,
                    r = this.s.dt,
                    i = r.columns().eq(0).map(function (t) {
                        var e = this.column(t),
                            n = e.header().className;
                        return (t = r.settings()[0].aoColumns[t].responsivePriority) === c && (t = (e = d(e.header()).data("priority")) !== c ? +e : 1e4), {
                            className: n,
                            includeIn: [],
                            auto: !1,
                            control: !1,
                            never: !!n.match(/\bnever\b/),
                            priority: t
                        }
                    });
                i.each(function (t, a) {
                    for (var e = t.className.split(" "), o = !1, n = 0, r = e.length; n < r; n++) {
                        var i = d.trim(e[n]);
                        if ("all" === i) return o = !0, void(t.includeIn = d.map(l, function (t) {
                            return t.name
                        }));
                        if ("none" === i || t.never) return void(o = !0);
                        if ("control" === i) return void(t.control = o = !0);
                        d.each(l, function (t, e) {
                            var n = e.name.split("-"),
                                r = i.match(RegExp("(min\\-|max\\-|not\\-)?(" + n[0] + ")(\\-[_a-zA-Z0-9])?"));
                            r && (o = !0, r[2] === n[0] && r[3] === "-" + n[1] ? s(a, e.name, r[1], r[2] + r[3]) : r[2] !== n[0] || r[3] || s(a, e.name, r[1], r[2]))
                        })
                    }
                    o || (t.auto = !0)
                }), this.s.columns = i
            },
            _detailsDisplay: function (t, e) {
                var n, r = this,
                    a = this.s.dt,
                    o = this.c.details;
                o && !1 !== o.type && (!0 !== (n = o.display(t, e, function () {
                    return o.renderer(a, t[0], r._detailsObj(t[0]))
                })) && !1 !== n || d(a.table().node()).triggerHandler("responsive-display.dt", [a, t, n, e]))
            },
            _detailsInit: function () {
                var n = this,
                    r = this.s.dt,
                    t = this.c.details;
                "inline" === t.type && (t.target = "td:first-child, th:first-child"), r.on("draw.dtr", function () {
                    n._tabIndexes()
                }), n._tabIndexes(), d(r.table().body()).on("keyup.dtr", "td, th", function (t) {
                    13 === t.keyCode && d(this).data("dtr-keyboard") && d(this).click()
                });
                var a = t.target;
                d(r.table().body()).on("click.dtr mousedown.dtr mouseup.dtr", "string" == typeof a ? a : "td, th", function (t) {
                    if (d(r.table().node()).hasClass("collapsed") && -1 !== d.inArray(d(this).closest("tr").get(0), r.rows().nodes().toArray())) {
                        if ("number" == typeof a) {
                            var e = a < 0 ? r.columns().eq(0).length + a : a;
                            if (r.cell(this).index().column !== e) return
                        }
                        e = r.row(d(this).closest("tr")), "click" === t.type ? n._detailsDisplay(e, !1) : "mousedown" === t.type ? d(this).css("outline", "none") : "mouseup" === t.type && d(this).blur().css("outline", "")
                    }
                })
            },
            _detailsObj: function (n) {
                var r = this,
                    a = this.s.dt;
                return d.map(this.s.columns, function (t, e) {
                    if (!t.never && !t.control) return {
                        title: a.settings()[0].aoColumns[e].sTitle,
                        data: a.cell(n, e).render(r.c.orthogonal),
                        hidden: a.column(e).visible() && !r.s.current[e],
                        columnIndex: e,
                        rowIndex: n
                    }
                })
            },
            _find: function (t) {
                for (var e = this.c.breakpoints, n = 0, r = e.length; n < r; n++)
                    if (e[n].name === t) return e[n]
            },
            _redrawChildren: function () {
                var n = this,
                    r = this.s.dt;
                r.rows({
                    page: "current"
                }).iterator("row", function (t, e) {
                    r.row(e), n._detailsDisplay(r.row(e), !0)
                })
            },
            _resize: function () {
                for (var n = this, t = this.s.dt, e = d(f).width(), r = this.c.breakpoints, a = r[0].name, o = this.s.columns, i = this.s.current.slice(), s = r.length - 1; 0 <= s; s--)
                    if (e <= r[s].width) {
                        a = r[s].name;
                        break
                    } var l = this._columnsVisiblity(a);
                for (this.s.current = l, r = !1, s = 0, e = o.length; s < e; s++)
                    if (!1 === l[s] && !o[s].never && !o[s].control) {
                        r = !0;
                        break
                    } d(t.table().node()).toggleClass("collapsed", r);
                var c = !1,
                    u = 0;
                t.columns().eq(0).each(function (t, e) {
                    !0 === l[e] && u++, l[e] !== i[e] && (c = !0, n._setColumnVis(t, l[e]))
                }), c && (this._redrawChildren(), d(t.table().node()).trigger("responsive-resize.dt", [t, this.s.current]), 0 === t.page.info().recordsDisplay && d("td", t.table().body()).eq(0).attr("colspan", u))
            },
            _resizeAuto: function () {
                var t, e, n, r, a, o = this.s.dt,
                    i = this.s.columns;
                this.c.auto && -1 !== d.inArray(!0, d.map(i, function (t) {
                    return t.auto
                })) && (d.isEmptyObject(l) || d.each(l, function (t) {
                    t = t.split("-"), s(o, +t[0], +t[1])
                }), o.table().node(), t = o.table().node().cloneNode(!1), e = d(o.table().header().cloneNode(!1)).appendTo(t), r = d(o.table().body()).clone(!1, !1).empty().appendTo(t), n = o.columns().header().filter(function (t) {
                    return o.column(t).visible()
                }).to$().clone(!1).css("display", "table-cell").css("min-width", 0), d(r).append(d(o.rows({
                    page: "current"
                }).nodes()).clone(!1)).find("th, td").css("display", ""), (r = o.table().footer()) && (r = d(r.cloneNode(!1)).appendTo(t), a = o.columns().footer().filter(function (t) {
                    return o.column(t).visible()
                }).to$().clone(!1).css("display", "table-cell"), d("<tr/>").append(a).appendTo(r)), d("<tr/>").append(n).appendTo(e), "inline" === this.c.details.type && d(t).addClass("dtr-inline collapsed"), d(t).find("[name]").removeAttr("name"), (t = d("<div/>").css({
                    width: 1,
                    height: 1,
                    overflow: "hidden",
                    clear: "both"
                }).append(t)).insertBefore(o.table().node()), n.each(function (t) {
                    t = o.column.index("fromVisible", t), i[t].minWidth = this.offsetWidth || 0
                }), t.remove())
            },
            _setColumnVis: function (t, e) {
                var n = this.s.dt,
                    e = e ? "" : "none";
                d(n.column(t).header()).css("display", e), d(n.column(t).footer()).css("display", e), n.column(t).nodes().to$().css("display", e), d.isEmptyObject(l) || n.cells(null, t).indexes().each(function (t) {
                    s(n, t.row, t.column)
                })
            },
            _tabIndexes: function () {
                var t = this.s.dt,
                    e = t.cells({
                        page: "current"
                    }).nodes().to$(),
                    n = t.settings()[0],
                    r = this.c.details.target;
                e.filter("[data-dtr-keyboard]").removeData("[data-dtr-keyboard]"), d(e = "td:first-child, th:first-child" === (e = "number" == typeof r ? ":eq(" + r + ")" : r) ? ">td:first-child, >th:first-child" : e, t.rows({
                    page: "current"
                }).nodes()).attr("tabIndex", n.iTabIndex).data("dtr-keyboard", 1)
            }
        }), n.breakpoints = [{
            name: "desktop",
            width: 1 / 0
        }, {
            name: "tablet-l",
            width: 1024
        }, {
            name: "tablet-p",
            width: 768
        }, {
            name: "mobile-l",
            width: 480
        }, {
            name: "mobile-p",
            width: 320
        }], n.display = {
            childRow: function (t, e, n) {
                return e ? d(t.node()).hasClass("parent") ? (t.child(n(), "child").show(), !0) : void 0 : t.child.isShown() ? (t.child(!1), d(t.node()).removeClass("parent"), !1) : (t.child(n(), "child").show(), d(t.node()).addClass("parent"), !0)
            },
            childRowImmediate: function (t, e, n) {
                return !e && t.child.isShown() || !t.responsive.hasHidden() ? (t.child(!1), d(t.node()).removeClass("parent"), !1) : (t.child(n(), "child").show(), d(t.node()).addClass("parent"), !0)
            },
            modal: function (o) {
                return function (t, e, n) {
                    var r, a;
                    e ? d("div.dtr-modal-content").empty().append(n()) : (r = function () {
                        a.remove(), d(i).off("keypress.dtr")
                    }, a = d('<div class="dtr-modal"/>').append(d('<div class="dtr-modal-display"/>').append(d('<div class="dtr-modal-content"/>').append(n())).append(d('<div class="dtr-modal-close">&times;</div>').click(function () {
                        r()
                    }))).append(d('<div class="dtr-modal-background"/>').click(function () {
                        r()
                    })).appendTo("body"), d(i).on("keyup.dtr", function (t) {
                        27 === t.keyCode && (t.stopPropagation(), r())
                    })), o && o.header && d("div.dtr-modal-content").prepend("<h2>" + o.header(t) + "</h2>")
                }
            }
        };
        var l = {};
        n.renderer = {
            listHiddenNodes: function () {
                return function (n, t, e) {
                    var r = d('<ul data-dtr-index="' + t + '" class="dtr-details"/>'),
                        a = !1;
                    return d.each(e, function (t, e) {
                        e.hidden && (d('<li data-dtr-index="' + e.columnIndex + '" data-dt-row="' + e.rowIndex + '" data-dt-column="' + e.columnIndex + '"><span class="dtr-title">' + e.title + "</span> </li>").append(d('<span class="dtr-data"/>').append(function (t, e, n) {
                            var r = e + "-" + n;
                            if (l[r]) return l[r];
                            for (var a = [], t = t.cell(e, n).node().childNodes, e = 0, n = t.length; e < n; e++) a.push(t[e]);
                            return l[r] = a
                        }(n, e.rowIndex, e.columnIndex))).appendTo(r), a = !0)
                    }), !!a && r
                }
            },
            listHidden: function () {
                return function (t, e, n) {
                    return !!(t = d.map(n, function (t) {
                        return t.hidden ? '<li data-dtr-index="' + t.columnIndex + '" data-dt-row="' + t.rowIndex + '" data-dt-column="' + t.columnIndex + '"><span class="dtr-title">' + t.title + '</span> <span class="dtr-data">' + t.data + "</span></li>" : ""
                    }).join("")) && d('<ul data-dtr-index="' + e + '" class="dtr-details"/>').append(t)
                }
            },
            tableAll: function (r) {
                return r = d.extend({
                        tableClass: ""
                    }, r),
                    function (t, e, n) {
                        return t = d.map(n, function (t) {
                            return '<tr data-dt-row="' + t.rowIndex + '" data-dt-column="' + t.columnIndex + '"><td>' + t.title + ":</td> <td>" + t.data + "</td></tr>"
                        }).join(""), d('<table class="' + r.tableClass + ' dtr-details" width="100%"/>').append(t)
                    }
            }
        }, n.defaults = {
            breakpoints: n.breakpoints,
            auto: !0,
            details: {
                display: n.display.childRow,
                renderer: n.renderer.listHidden(),
                target: 0,
                type: "inline"
            },
            orthogonal: "display"
        };
        var t = d.fn.dataTable.Api;
        return t.register("responsive()", function () {
            return this
        }), t.register("responsive.index()", function (t) {
            return {
                column: (t = d(t)).data("dtr-index"),
                row: t.parent().data("dtr-index")
            }
        }), t.register("responsive.rebuild()", function () {
            return this.iterator("table", function (t) {
                t._responsive && t._responsive._classLogic()
            })
        }), t.register("responsive.recalc()", function () {
            return this.iterator("table", function (t) {
                t._responsive && (t._responsive._resizeAuto(), t._responsive._resize())
            })
        }), t.register("responsive.hasHidden()", function () {
            var t = this.context[0];
            return !!t._responsive && -1 !== d.inArray(!1, t._responsive.s.current)
        }), t.registerPlural("columns().responsiveHidden()", "column().responsiveHidden()", function () {
            return this.iterator("column", function (t, e) {
                return !!t._responsive && t._responsive.s.current[e]
            }, 1)
        }), n.version = "2.2.1", d.fn.dataTable.Responsive = n, d.fn.DataTable.Responsive = n, d(i).on("preInit.dt.dtr", function (t, e) {
            "dt" !== t.namespace || !(d(e.nTable).hasClass("responsive") || d(e.nTable).hasClass("dt-responsive") || e.oInit.responsive || r.defaults.responsive) || !1 !== (t = e.oInit.responsive) && new n(e, d.isPlainObject(t) ? t : {})
        }), n
    });
