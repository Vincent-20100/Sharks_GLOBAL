/*
 A JavaScript implementation of the SHA family of hashes, as
 defined in FIPS PUB 180-2 as well as the corresponding HMAC implementation
 as defined in FIPS PUB 198a

 Copyright Brian Turek 2008-2016
 Distributed under the BSD License
 See https://caligatio.github.com/jsSHA/ for more information

 Several functions taken from Paul Johnston
*/
'use strict';
(function(J) {
    function w(l, b, c) {
        var d = 0,
            g = [],
            e = 0,
            a, k, m, n, p, r, u, q = !1,
            h = [],
            t = [],
            v, z = !1;
        c = c || {};
        a = c.encoding || "UTF8";
        v = c.numRounds || 1;
        m = A(b, a);
        if (v !== parseInt(v, 10) || 1 > v) throw Error("numRounds must a integer >= 1");
        r = function(b, c) {
            return B(b, c, l)
        };
        u = function(b, c, d, e) {
            var g, a;
            if ("SHA-384" === l || "SHA-512" === l) g = (c + 129 >>> 10 << 5) + 31, a = 32;
            else throw Error("Unexpected error in SHA-2 implementation");
            for (; b.length <= g;) b.push(0);
            b[c >>> 5] |= 128 << 24 - c % 32;
            c = c + d;
            b[g] = c & 4294967295;
            b[g - 1] = c / 4294967296 | 0;
            d = b.length;
            for (c = 0; c < d; c += a) e = B(b.slice(c, c + a), e, l);
            if ("SHA-384" === l) b = [e[0].a, e[0].b, e[1].a, e[1].b, e[2].a, e[2].b, e[3].a, e[3].b, e[4].a, e[4].b, e[5].a, e[5].b];
            else if ("SHA-512" === l) b = [e[0].a, e[0].b, e[1].a, e[1].b, e[2].a, e[2].b, e[3].a, e[3].b, e[4].a, e[4].b, e[5].a, e[5].b, e[6].a, e[6].b, e[7].a, e[7].b];
            else throw Error("Unexpected error in SHA-2 implementation");
            return b
        };
        if ("SHA-384" === l) p = 1024, n = 384;
        else if ("SHA-512" === l) p = 1024, n = 512;
        else throw Error("Chosen SHA variant is not supported");
        k = x(l);
        this.setHMACKey =
            function(b, c, e) {
                var g;
                if (!0 === q) throw Error("HMAC key already set");
                if (!0 === z) throw Error("Cannot set HMAC key after calling update");
                a = (e || {}).encoding || "UTF8";
                c = A(c, a)(b);
                b = c.binLen;
                c = c.value;
                g = p >>> 3;
                e = g / 4 - 1;
                if (g < b / 8) {
                    for (c = u(c, b, 0, x(l)); c.length <= e;) c.push(0);
                    c[e] &= 4294967040
                } else if (g > b / 8) {
                    for (; c.length <= e;) c.push(0);
                    c[e] &= 4294967040
                }
                for (b = 0; b <= e; b += 1) h[b] = c[b] ^ 909522486, t[b] = c[b] ^ 1549556828;
                k = r(h, k);
                d = p;
                q = !0
            };
        this.update = function(b) {
            var c, l, a, f = 0,
                n = p >>> 5;
            c = m(b, g, e);
            b = c.binLen;
            l = c.value;
            c = b >>>
                5;
            for (a = 0; a < c; a += n) f + p <= b && (k = r(l.slice(a, a + n), k), f += p);
            d += f;
            g = l.slice(f >>> 5);
            e = b % p;
            z = !0
        };
        this.getHash = function(b, c) {
            var a, f, p, m;
            if (!0 === q) throw Error("Cannot call getHash after setting HMAC key");
            p = C(c);
            switch (b) {
                case "HEX":
                    a = function(b) {
                        return D(b, p)
                    };
                    break;
                case "B64":
                    a = function(b) {
                        return E(b, p)
                    };
                    break;
                case "BYTES":
                    a = F;
                    break;
                case "ARRAYBUFFER":
                    try {
                        f = new ArrayBuffer(0)
                    } catch (r) {
                        throw Error("ARRAYBUFFER not supported by this environment");
                    }
                    a = G;
                    break;
                default:
                    throw Error("format must be HEX, B64, BYTES, or ARRAYBUFFER");
            }
            m = u(g.slice(), e, d, k.slice());
            for (f = 1; f < v; f += 1) m = u(m, n, 0, x(l));
            return a(m)
        };
        this.getHMAC = function(b, c) {
            var a, f, m, h;
            if (!1 === q) throw Error("Cannot call getHMAC without first setting HMAC key");
            m = C(c);
            switch (b) {
                case "HEX":
                    a = function(b) {
                        return D(b, m)
                    };
                    break;
                case "B64":
                    a = function(b) {
                        return E(b, m)
                    };
                    break;
                case "BYTES":
                    a = F;
                    break;
                case "ARRAYBUFFER":
                    try {
                        a = new ArrayBuffer(0)
                    } catch (v) {
                        throw Error("ARRAYBUFFER not supported by this environment");
                    }
                    a = G;
                    break;
                default:
                    throw Error("outputFormat must be HEX, B64, BYTES, or ARRAYBUFFER");
            }
            f = u(g.slice(), e, d, k.slice());
            h = r(t, x(l));
            h = u(f, n, p, h);
            return a(h)
        }
    }

    function d(l, b) {
        this.a = l;
        this.b = b
    }

    function K(l, b, c) {
        var d = l.length,
            a, e, f, k, m;
        b = b || [0];
        c = c || 0;
        m = c >>> 3;
        if (0 !== d % 2) throw Error("String of HEX type must be in byte increments");
        for (a = 0; a < d; a += 2) {
            e = parseInt(l.substr(a, 2), 16);
            if (isNaN(e)) throw Error("String of HEX type contains invalid characters");
            k = (a >>> 1) + m;
            for (f = k >>> 2; b.length <= f;) b.push(0);
            b[f] |= e << 8 * (3 - k % 4)
        }
        return {
            value: b,
            binLen: 4 * d + c
        }
    }

    function L(l, b, c) {
        var d = [],
            a, e, f, k, d = b || [0];
        c = c || 0;
        e = c >>> 3;
        for (a = 0; a < l.length; a += 1) b = l.charCodeAt(a), k = a + e, f = k >>> 2, d.length <= f && d.push(0), d[f] |= b << 8 * (3 - k % 4);
        return {
            value: d,
            binLen: 8 * l.length + c
        }
    }

    function M(l, b, c) {
        var d = [],
            a = 0,
            e, f, k, m, n, p, d = b || [0];
        c = c || 0;
        b = c >>> 3;
        if (-1 === l.search(/^[a-zA-Z0-9=+\/]+$/)) throw Error("Invalid character in base-64 string");
        f = l.indexOf("=");
        l = l.replace(/\=/g, "");
        if (-1 !== f && f < l.length) throw Error("Invalid '=' found in base-64 string");
        for (f = 0; f < l.length; f += 4) {
            n = l.substr(f, 4);
            for (k = m = 0; k < n.length; k += 1) e = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789+/".indexOf(n[k]),
                m |= e << 18 - 6 * k;
            for (k = 0; k < n.length - 1; k += 1) {
                p = a + b;
                for (e = p >>> 2; d.length <= e;) d.push(0);
                d[e] |= (m >>> 16 - 8 * k & 255) << 8 * (3 - p % 4);
                a += 1
            }
        }
        return {
            value: d,
            binLen: 8 * a + c
        }
    }

    function N(d, b, c) {
        var a = [],
            g, e, f, a = b || [0];
        c = c || 0;
        g = c >>> 3;
        for (b = 0; b < d.byteLength; b += 1) f = b + g, e = f >>> 2, a.length <= e && a.push(0), a[e] |= d[b] << 8 * (3 - f % 4);
        return {
            value: a,
            binLen: 8 * d.byteLength + c
        }
    }

    function D(d, b) {
        var c = "",
            a = 4 * d.length,
            g, e;
        for (g = 0; g < a; g += 1) e = d[g >>> 2] >>> 8 * (3 - g % 4), c += "0123456789abcdef".charAt(e >>> 4 & 15) + "0123456789abcdef".charAt(e & 15);
        return b.outputUpper ?
            c.toUpperCase() : c
    }

    function E(d, b) {
        var c = "",
            a = 4 * d.length,
            g, e, f;
        for (g = 0; g < a; g += 3)
            for (f = g + 1 >>> 2, e = d.length <= f ? 0 : d[f], f = g + 2 >>> 2, f = d.length <= f ? 0 : d[f], f = (d[g >>> 2] >>> 8 * (3 - g % 4) & 255) << 16 | (e >>> 8 * (3 - (g + 1) % 4) & 255) << 8 | f >>> 8 * (3 - (g + 2) % 4) & 255, e = 0; 4 > e; e += 1) 8 * g + 6 * e <= 32 * d.length ? c += "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789+/".charAt(f >>> 6 * (3 - e) & 63) : c += b.b64Pad;
        return c
    }

    function F(d) {
        var b = "",
            c = 4 * d.length,
            a, g;
        for (a = 0; a < c; a += 1) g = d[a >>> 2] >>> 8 * (3 - a % 4) & 255, b += String.fromCharCode(g);
        return b
    }

    function G(d) {
        var b =
            4 * d.length,
            c, a = new ArrayBuffer(b);
        for (c = 0; c < b; c += 1) a[c] = d[c >>> 2] >>> 8 * (3 - c % 4) & 255;
        return a
    }

    function C(d) {
        var b = {
            outputUpper: !1,
            b64Pad: "="
        };
        d = d || {};
        b.outputUpper = d.outputUpper || !1;
        !0 === d.hasOwnProperty("b64Pad") && (b.b64Pad = d.b64Pad);
        if ("boolean" !== typeof b.outputUpper) throw Error("Invalid outputUpper formatting option");
        if ("string" !== typeof b.b64Pad) throw Error("Invalid b64Pad formatting option");
        return b
    }

    function A(d, b) {
        var c;
        switch (b) {
            case "UTF8":
            case "UTF16BE":
            case "UTF16LE":
                break;
            default:
                throw Error("encoding must be UTF8, UTF16BE, or UTF16LE");
        }
        switch (d) {
            case "HEX":
                c = K;
                break;
            case "TEXT":
                c = function(c, d, a) {
                    var l = [],
                        k = [],
                        m = 0,
                        n, p, r, h, q, l = d || [0];
                    d = a || 0;
                    r = d >>> 3;
                    if ("UTF8" === b)
                        for (n = 0; n < c.length; n += 1)
                            for (a = c.charCodeAt(n), k = [], 128 > a ? k.push(a) : 2048 > a ? (k.push(192 | a >>> 6), k.push(128 | a & 63)) : 55296 > a || 57344 <= a ? k.push(224 | a >>> 12, 128 | a >>> 6 & 63, 128 | a & 63) : (n += 1, a = 65536 + ((a & 1023) << 10 | c.charCodeAt(n) & 1023), k.push(240 | a >>> 18, 128 | a >>> 12 & 63, 128 | a >>> 6 & 63, 128 | a & 63)), p = 0; p < k.length; p += 1) {
                                q = m + r;
                                for (h = q >>> 2; l.length <= h;) l.push(0);
                                l[h] |= k[p] << 8 * (3 - q % 4);
                                m += 1
                            } else if ("UTF16BE" ===
                                b || "UTF16LE" === b)
                                for (n = 0; n < c.length; n += 1) {
                                    a = c.charCodeAt(n);
                                    "UTF16LE" === b && (p = a & 255, a = p << 8 | a >>> 8);
                                    q = m + r;
                                    for (h = q >>> 2; l.length <= h;) l.push(0);
                                    l[h] |= a << 8 * (2 - q % 4);
                                    m += 2
                                }
                            return {
                                value: l,
                                binLen: 8 * m + d
                            }
                };
                break;
            case "B64":
                c = M;
                break;
            case "BYTES":
                c = L;
                break;
            case "ARRAYBUFFER":
                try {
                    c = new ArrayBuffer(0)
                } catch (a) {
                    throw Error("ARRAYBUFFER not supported by this environment");
                }
                c = N;
                break;
            default:
                throw Error("format must be HEX, TEXT, B64, BYTES, or ARRAYBUFFER");
        }
        return c
    }

    function h(a, b) {
        var c = null,
            c = new d(a.a, a.b);
        return c =
            32 >= b ? new d(c.a >>> b | c.b << 32 - b & 4294967295, c.b >>> b | c.a << 32 - b & 4294967295) : new d(c.b >>> b - 32 | c.a << 64 - b & 4294967295, c.a >>> b - 32 | c.b << 64 - b & 4294967295)
    }

    function H(a, b) {
        var c = null;
        return c = 32 >= b ? new d(a.a >>> b, a.b >>> b | a.a << 32 - b & 4294967295) : new d(0, a.a >>> b - 32)
    }

    function O(a, b, c) {
        return new d(a.a & b.a ^ ~a.a & c.a, a.b & b.b ^ ~a.b & c.b)
    }

    function P(a, b, c) {
        return new d(a.a & b.a ^ a.a & c.a ^ b.a & c.a, a.b & b.b ^ a.b & c.b ^ b.b & c.b)
    }

    function Q(a) {
        var b = h(a, 28),
            c = h(a, 34);
        a = h(a, 39);
        return new d(b.a ^ c.a ^ a.a, b.b ^ c.b ^ a.b)
    }

    function R(a) {
        var b = h(a,
                14),
            c = h(a, 18);
        a = h(a, 41);
        return new d(b.a ^ c.a ^ a.a, b.b ^ c.b ^ a.b)
    }

    function S(a) {
        var b = h(a, 1),
            c = h(a, 8);
        a = H(a, 7);
        return new d(b.a ^ c.a ^ a.a, b.b ^ c.b ^ a.b)
    }

    function T(a) {
        var b = h(a, 19),
            c = h(a, 61);
        a = H(a, 6);
        return new d(b.a ^ c.a ^ a.a, b.b ^ c.b ^ a.b)
    }

    function U(a, b) {
        var c, h, g;
        c = (a.b & 65535) + (b.b & 65535);
        h = (a.b >>> 16) + (b.b >>> 16) + (c >>> 16);
        g = (h & 65535) << 16 | c & 65535;
        c = (a.a & 65535) + (b.a & 65535) + (h >>> 16);
        h = (a.a >>> 16) + (b.a >>> 16) + (c >>> 16);
        return new d((h & 65535) << 16 | c & 65535, g)
    }

    function V(a, b, c, h) {
        var g, e, f;
        g = (a.b & 65535) + (b.b & 65535) +
            (c.b & 65535) + (h.b & 65535);
        e = (a.b >>> 16) + (b.b >>> 16) + (c.b >>> 16) + (h.b >>> 16) + (g >>> 16);
        f = (e & 65535) << 16 | g & 65535;
        g = (a.a & 65535) + (b.a & 65535) + (c.a & 65535) + (h.a & 65535) + (e >>> 16);
        e = (a.a >>> 16) + (b.a >>> 16) + (c.a >>> 16) + (h.a >>> 16) + (g >>> 16);
        return new d((e & 65535) << 16 | g & 65535, f)
    }

    function W(a, b, c, h, g) {
        var e, f, k;
        e = (a.b & 65535) + (b.b & 65535) + (c.b & 65535) + (h.b & 65535) + (g.b & 65535);
        f = (a.b >>> 16) + (b.b >>> 16) + (c.b >>> 16) + (h.b >>> 16) + (g.b >>> 16) + (e >>> 16);
        k = (f & 65535) << 16 | e & 65535;
        e = (a.a & 65535) + (b.a & 65535) + (c.a & 65535) + (h.a & 65535) + (g.a & 65535) +
            (f >>> 16);
        f = (a.a >>> 16) + (b.a >>> 16) + (c.a >>> 16) + (h.a >>> 16) + (g.a >>> 16) + (e >>> 16);
        return new d((f & 65535) << 16 | e & 65535, k)
    }

    function x(a) {
        var b, c;
        b = [3238371032, 914150663, 812702999, 4144912697, 4290775857, 1750603025, 1694076839, 3204075428];
        c = [1779033703, 3144134277, 1013904242, 2773480762, 1359893119, 2600822924, 528734635, 1541459225];
        switch (a) {
            case "SHA-224":
                a = b;
                break;
            case "SHA-256":
                a = c;
                break;
            case "SHA-384":
                a = [new d(3418070365, b[0]), new d(1654270250, b[1]), new d(2438529370, b[2]), new d(355462360, b[3]), new d(1731405415,
                    b[4]), new d(41048885895, b[5]), new d(3675008525, b[6]), new d(1203062813, b[7])];
                break;
            case "SHA-512":
                a = [new d(c[0], 4089235720), new d(c[1], 2227873595), new d(c[2], 4271175723), new d(c[3], 1595750129), new d(c[4], 2917565137), new d(c[5], 725511199), new d(c[6], 4215389547), new d(c[7], 327033209)];
                break;
            default:
                throw Error("Unknown SHA variant");
        }
        return a
    }

    function B(a, b, c) {
        var h, g, e, f, k, m, n, p, r, u, q, w, t, v, z, x, A, B, C, D, E, F, y = [],
            G;
        if ("SHA-384" === c || "SHA-512" === c) u = 80, w = 2, F = d, t = U, v = V, z = W, x = S, A = T, B = Q, C = R, E = P, D = O, G = I;
        else throw Error("Unexpected error in SHA-2 implementation");
        c = b[0];
        h = b[1];
        g = b[2];
        e = b[3];
        f = b[4];
        k = b[5];
        m = b[6];
        n = b[7];
        for (q = 0; q < u; q += 1) 16 > q ? (r = q * w, p = a.length <= r ? 0 : a[r], r = a.length <= r + 1 ? 0 : a[r + 1], y[q] = new F(p, r)) : y[q] = v(A(y[q - 2]), y[q - 7], x(y[q - 15]), y[q - 16]), p = z(n, C(f), D(f, k, m), G[q], y[q]), r = t(B(c), E(c, h, g)), n = m, m = k, k = f, f = t(e, p), e = g, g = h, h = c, c = t(p, r);
        b[0] = t(c, b[0]);
        b[1] = t(h, b[1]);
        b[2] = t(g, b[2]);
        b[3] = t(e, b[3]);
        b[4] = t(f, b[4]);
        b[5] = t(k, b[5]);
        b[6] = t(m, b[6]);
        b[7] = t(n, b[7]);
        return b
    }
    var a, I;
    a = [1116352408, 1899447441,
        3049323471, 3921009573, 961987163, 1508970993, 2453635748, 2870763221, 3624381080, 310598401, 607225278, 1426881987, 1925078388, 2162078206, 2614888103, 3248222580, 3835390401, 4022224774, 264347078, 604807628, 770255983, 1249150122, 1555081692, 1996064986, 2554220882, 2821834349, 2952996808, 3210313671, 3336571891, 3584528711, 113926993, 338241895, 666307205, 773529912, 1294757372, 1396182291, 1695183700, 1986661051, 2177026350, 2456956037, 2730485921, 2820302411, 3259730800, 3345764771, 3516065817, 3600352804, 4094571909, 275423344, 430227734,
        506948616, 659060556, 883997877, 958139571, 1322822218, 1537002063, 1747873779, 1955562222, 2024104815, 2227730452, 2361852424, 2428436474, 2756734187, 3204031479, 3329325298
    ];
    I = [new d(a[0], 3609767458), new d(a[1], 602891725), new d(a[2], 3964484399), new d(a[3], 2173295548), new d(a[4], 4081628472), new d(a[5], 3053834265), new d(a[6], 2937671579), new d(a[7], 3664609560), new d(a[8], 2734883394), new d(a[9], 1164996542), new d(a[10], 1323610764), new d(a[11], 3590304994), new d(a[12], 4068182383), new d(a[13], 991336113), new d(a[14],
            633803317), new d(a[15], 3479774868), new d(a[16], 2666613458), new d(a[17], 944711139), new d(a[18], 2341262773), new d(a[19], 2007800933), new d(a[20], 1495990901), new d(a[21], 1856431235), new d(a[22], 3175218132), new d(a[23], 2198950837), new d(a[24], 3999719339), new d(a[25], 766784016), new d(a[26], 2566594879), new d(a[27], 3203337956), new d(a[28], 1034457026), new d(a[29], 2466948901), new d(a[30], 3758326383), new d(a[31], 168717936), new d(a[32], 1188179964), new d(a[33], 1546045734), new d(a[34], 1522805485), new d(a[35], 2643833823),
        new d(a[36], 2343527390), new d(a[37], 1014477480), new d(a[38], 1206759142), new d(a[39], 344077627), new d(a[40], 1290863460), new d(a[41], 3158454273), new d(a[42], 3505952657), new d(a[43], 106217008), new d(a[44], 3606008344), new d(a[45], 1432725776), new d(a[46], 1467031594), new d(a[47], 851169720), new d(a[48], 3100823752), new d(a[49], 1363258195), new d(a[50], 3750685593), new d(a[51], 3785050280), new d(a[52], 3318307427), new d(a[53], 3812723403), new d(a[54], 2003034995), new d(a[55], 3602036899), new d(a[56], 1575990012),
        new d(a[57], 1125592928), new d(a[58], 2716904306), new d(a[59], 442776044), new d(a[60], 593698344), new d(a[61], 3733110249), new d(a[62], 2999351573), new d(a[63], 3815920427), new d(3391569614, 3928383900), new d(3515267271, 566280711), new d(3940187606, 3454069534), new d(4118630271, 4000239992), new d(116418474, 1914138554), new d(174292421, 2731055270), new d(289380356, 3203993006), new d(460393269, 320620315), new d(685471733, 587496836), new d(852142971, 1086792851), new d(1017036298, 365543100), new d(1126000580, 2618297676),
        new d(1288033470, 3409855158), new d(1501505948, 4234509866), new d(1607167915, 987167468), new d(1816402316, 1246189591)
    ];
    "function" === typeof define && define.amd ? define(function() {
        return w
    }) : "undefined" !== typeof exports ? "undefined" !== typeof module && module.exports ? module.exports = exports = w : exports = w : J.jsSHA = w
})(this);
