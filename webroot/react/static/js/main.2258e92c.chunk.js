(this["webpackJsonpbookshop-frontend"]=this["webpackJsonpbookshop-frontend"]||[]).push([[0],{24:function(e,t,n){},45:function(e,t,n){"use strict";n.r(t);var o=n(2),c=n.n(o),s=n(14),r=n.n(s),a=(n(24),n(15)),i=n(16),l=n(19),u=n(18),p=n(3),h=n.n(p),b=n(5),d=n(17),j=n.n(d),f=n(0),g=function(){var e=function(){var e=Object(b.a)(h.a.mark((function e(t){var n;return h.a.wrap((function(e){for(;;)switch(e.prev=e.next){case 0:return t.preventDefault(),console.log("function ran"),e.next=4,j.a.get("http://localhost/bookshop/books");case 4:n=e.sent,console.log("response is"),console.log(n),console.log("data is"),console.log(n.data.books);case 9:case"end":return e.stop()}}),e)})));return function(t){return e.apply(this,arguments)}}(),t=function(){var e=Object(b.a)(h.a.mark((function e(t){var n,o;return h.a.wrap((function(e){for(;;)switch(e.prev=e.next){case 0:return t.preventDefault(),console.log("function ran"),e.next=4,fetch("http://localhost/bookshop/books",{mode:"cors",method:"POST",cache:"no-cache",headers:{"X-Requested-With":"XMLHttpRequest",Accept:"application/json","Content-Type":"application/json"},body:JSON.stringify({title:"another test from react",pages:110,publish_year:2020,author_id:2})});case 4:return n=e.sent,console.log("response is"),console.log(n),e.next=9,n.json();case 9:o=e.sent,console.log("data is"),console.log(o);case 12:case"end":return e.stop()}}),e)})));return function(t){return e.apply(this,arguments)}}();return Object(f.jsxs)(f.Fragment,{children:[Object(f.jsx)("div",{children:"new books"}),Object(f.jsx)("div",{className:"",children:Object(f.jsx)("button",{onClick:e,children:"Get test"})}),Object(f.jsx)("div",{className:"",children:Object(f.jsx)("button",{onClick:t,children:"Post test"})})]})},O=function(e){Object(l.a)(n,e);var t=Object(u.a)(n);function n(){return Object(a.a)(this,n),t.apply(this,arguments)}return Object(i.a)(n,[{key:"render",value:function(){return Object(f.jsx)(f.Fragment,{children:Object(f.jsx)(g,{})})}}]),n}(o.Component),v=function(e){e&&e instanceof Function&&n.e(3).then(n.bind(null,46)).then((function(t){var n=t.getCLS,o=t.getFID,c=t.getFCP,s=t.getLCP,r=t.getTTFB;n(e),o(e),c(e),s(e),r(e)}))};r.a.render(Object(f.jsx)(c.a.StrictMode,{children:Object(f.jsx)(O,{})}),document.getElementById("root")),v()}},[[45,1,2]]]);
//# sourceMappingURL=main.2258e92c.chunk.js.map