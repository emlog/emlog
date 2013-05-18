/* KindEditor 4.1.7 (2013-04-21), Copyright (C) kindsoft.net, Licence: http://www.kindsoft.net/license.php */(function(A,o){function Y(a){if(!a)return!1;return Object.prototype.toString.call(a)==="[object Array]"}function bb(a){if(!a)return!1;return Object.prototype.toString.call(a)==="[object Function]"}function N(a,b){for(var c=0,d=b.length;c<d;c++)if(a===b[c])return c;return-1}function m(a,b){if(Y(a))for(var c=0,d=a.length;c<d;c++){if(b.call(a[c],c,a[c])===!1)break}else for(c in a)if(a.hasOwnProperty(c)&&b.call(a[c],c,a[c])===!1)break}function B(a){return a.replace(/(?:^[ \t\n\r]+)|(?:[ \t\n\r]+$)/g,
"")}function ua(a,b,c){c=c===o?",":c;return(c+b+c).indexOf(c+a+c)>=0}function s(a,b){b=b||"px";return a&&/^\d+$/.test(a)?a+b:a}function t(a){var b;return a&&(b=/(\d+)/.exec(a))?parseInt(b[1],10):0}function C(a){return a.replace(/&/g,"&amp;").replace(/</g,"&lt;").replace(/>/g,"&gt;").replace(/"/g,"&quot;")}function fa(a){return a.replace(/&lt;/g,"<").replace(/&gt;/g,">").replace(/&quot;/g,'"').replace(/&amp;/g,"&")}function ga(a){var b=a.split("-"),a="";m(b,function(b,d){a+=b>0?d.charAt(0).toUpperCase()+
d.substr(1):d});return a}function va(a){function b(a){a=parseInt(a,10).toString(16).toUpperCase();return a.length>1?a:"0"+a}return a.replace(/rgb\s*\(\s*(\d+)\s*,\s*(\d+)\s*,\s*(\d+)\s*\)/ig,function(a,d,e,g){return"#"+b(d)+b(e)+b(g)})}function u(a,b){var b=b===o?",":b,c={},d=Y(a)?a:a.split(b),e;m(d,function(a,b){if(e=/^(\d+)\.\.(\d+)$/.exec(b))for(var d=parseInt(e[1],10);d<=parseInt(e[2],10);d++)c[d.toString()]=!0;else c[b]=!0});return c}function Fa(a,b){return Array.prototype.slice.call(a,b||0)}
function j(a,b){return a===o?b:a}function E(a,b,c){c||(c=b,b=null);var d;if(b){var e=function(){};e.prototype=b.prototype;d=new e;m(c,function(a,b){d[a]=b})}else d=c;d.constructor=a;a.prototype=d;a.parent=b?b.prototype:null}function cb(a){var b;if(b=/\{[\s\S]*\}|\[[\s\S]*\]/.exec(a))a=b[0];b=/[\u0000\u00ad\u0600-\u0604\u070f\u17b4\u17b5\u200c-\u200f\u2028-\u202f\u2060-\u206f\ufeff\ufff0-\uffff]/g;b.lastIndex=0;b.test(a)&&(a=a.replace(b,function(a){return"\\u"+("0000"+a.charCodeAt(0).toString(16)).slice(-4)}));
if(/^[\],:{}\s]*$/.test(a.replace(/\\(?:["\\\/bfnrt]|u[0-9a-fA-F]{4})/g,"@").replace(/"[^"\\\n\r]*"|true|false|null|-?\d+(?:\.\d*)?(?:[eE][+\-]?\d+)?/g,"]").replace(/(?:^|:|,)(?:\s*\[)+/g,"")))return eval("("+a+")");throw"JSON parse error";}function Pb(a,b,c){a.addEventListener?a.addEventListener(b,c,db):a.attachEvent&&a.attachEvent("on"+b,c)}function wa(a,b,c){a.removeEventListener?a.removeEventListener(b,c,db):a.detachEvent&&a.detachEvent("on"+b,c)}function eb(a,b){this.init(a,b)}function fb(a){try{delete a[Z]}catch(b){a.removeAttribute&&
a.removeAttribute(Z)}}function $(a,b,c){if(b.indexOf(",")>=0)m(b.split(","),function(){$(a,this,c)});else{var d=a[Z]||null;d||(a[Z]=++gb,d=gb);v[d]===o&&(v[d]={});var e=v[d][b];e&&e.length>0?wa(a,b,e[0]):(v[d][b]=[],v[d].el=a);e=v[d][b];e.length===0&&(e[0]=function(b){var c=b?new eb(a,b):o;m(e,function(b,d){b>0&&d&&d.call(a,c)})});N(c,e)<0&&e.push(c);Pb(a,b,e[0])}}function ha(a,b,c){if(b&&b.indexOf(",")>=0)m(b.split(","),function(){ha(a,this,c)});else{var d=a[Z]||null;if(d)if(b===o)d in v&&(m(v[d],
function(b,c){b!="el"&&c.length>0&&wa(a,b,c[0])}),delete v[d],fb(a));else if(v[d]){var e=v[d][b];if(e&&e.length>0){c===o?(wa(a,b,e[0]),delete v[d][b]):(m(e,function(a,b){a>0&&b===c&&e.splice(a,1)}),e.length==1&&(wa(a,b,e[0]),delete v[d][b]));var g=0;m(v[d],function(){g++});g<2&&(delete v[d],fb(a))}}}}function hb(a,b){if(b.indexOf(",")>=0)m(b.split(","),function(){hb(a,this)});else{var c=a[Z]||null;if(c){var d=v[c][b];if(v[c]&&d&&d.length>0)d[0]()}}}function Ga(a,b,c){b=/^\d{2,}$/.test(b)?b:b.toUpperCase().charCodeAt(0);
$(a,"keydown",function(d){d.ctrlKey&&d.which==b&&!d.shiftKey&&!d.altKey&&(c.call(a),d.stop())})}function aa(a){for(var b={},c=/\s*([\w\-]+)\s*:([^;]*)(;|$)/g,d;d=c.exec(a);){var e=B(d[1].toLowerCase());d=B(va(d[2]));b[e]=d}return b}function H(a){for(var b={},c=/\s+(?:([\w\-:]+)|(?:([\w\-:]+)=([^\s"'<>]+))|(?:([\w\-:"]+)="([^"]*)")|(?:([\w\-:"]+)='([^']*)'))(?=(?:\s|\/|>)+)/g,d;d=c.exec(a);){var e=(d[1]||d[2]||d[4]||d[6]).toLowerCase();b[e]=(d[2]?d[3]:d[4]?d[5]:d[7])||""}return b}function Qb(a,b){return a=
/\s+class\s*=/.test(a)?a.replace(/(\s+class=["']?)([^"']*)(["']?[\s>])/,function(a,d,e,g){return(" "+e+" ").indexOf(" "+b+" ")<0?e===""?d+b+g:d+e+" "+b+g:a}):a.substr(0,a.length-1)+' class="'+b+'">'}function Rb(a){var b="";m(aa(a),function(a,d){b+=a+":"+d+";"});return b}function ia(a,b,c,d){function e(a){for(var a=a.split("/"),b=[],c=0,d=a.length;c<d;c++){var e=a[c];e==".."?b.length>0&&b.pop():e!==""&&e!="."&&b.push(e)}return"/"+b.join("/")}function g(b,c){if(a.substr(0,b.length)===b){for(var e=[],
h=0;h<c;h++)e.push("..");h=".";e.length>0&&(h+="/"+e.join("/"));d=="/"&&(h+="/");return h+a.substr(b.length)}else if(f=/^(.*)\//.exec(b))return g(f[1],++c)}b=j(b,"").toLowerCase();a.substr(0,5)!="data:"&&(a=a.replace(/([^:])\/\//g,"$1/"));if(N(b,["absolute","relative","domain"])<0)return a;c=c||location.protocol+"//"+location.host;if(d===o)var h=location.pathname.match(/^(\/.*)\//),d=h?h[1]:"";var f;if(f=/^(\w+:\/\/[^\/]*)/.exec(a)){if(f[1]!==c)return a}else if(/^\w+:/.test(a))return a;/^\//.test(a)?
a=c+e(a.substr(1)):/^\w+:\/\//.test(a)||(a=c+e(d+"/"+a));b==="relative"?a=g(c+d,0).substr(2):b==="absolute"&&a.substr(0,c.length)===c&&(a=a.substr(c.length));return a}function S(a,b,c,d,e){var c=c||"",d=j(d,!1),e=j(e,"\t"),g="xx-small,x-small,small,medium,large,x-large,xx-large".split(","),a=a.replace(/(<(?:pre|pre\s[^>]*)>)([\s\S]*?)(<\/pre>)/ig,function(a,b,c,d){return b+c.replace(/<(?:br|br\s[^>]*)>/ig,"\n")+d}),a=a.replace(/<(?:br|br\s[^>]*)\s*\/?>\s*<\/p>/ig,"</p>"),a=a.replace(/(<(?:p|p\s[^>]*)>)\s*(<\/p>)/ig,
"$1<br />$2"),a=a.replace(/\u200B/g,""),a=a.replace(/\u00A9/g,"&copy;"),h={};b&&(m(b,function(a,b){for(var c=a.split(","),d=0,e=c.length;d<e;d++)h[c[d]]=u(b)}),h.script||(a=a.replace(/(<(?:script|script\s[^>]*)>)([\s\S]*?)(<\/script>)/ig,"")),h.style||(a=a.replace(/(<(?:style|style\s[^>]*)>)([\s\S]*?)(<\/style>)/ig,"")));var f=[],a=a.replace(/([ \t\n\r]*)<(\/)?([\w\-:]+)((?:\s+|(?:\s+[\w\-:]+)|(?:\s+[\w\-:]+=[^\s"'<>]+)|(?:\s+[\w\-:"]+="[^"]*")|(?:\s+[\w\-:"]+='[^']*'))*)(\/)?>([ \t\n\r]*)/g,function(a,
n,r,p,I,o,j){var n=n||"",r=r||"",l=p.toLowerCase(),J=I||"",p=o?" "+o:"",j=j||"";if(b&&!h[l])return"";p===""&&ib[l]&&(p=" /");jb[l]&&(n&&(n=" "),j&&(j=" "));Ha[l]&&(r?j="\n":n="\n");d&&l=="br"&&(j="\n");if(kb[l]&&!Ha[l])if(d){r&&f.length>0&&f[f.length-1]===l?f.pop():f.push(l);j=n="\n";I=0;for(o=r?f.length:f.length-1;I<o;I++)n+=e,r||(j+=e);p?f.pop():r||(j+=e)}else n=j="";if(J!==""){var w=H(a);if(l==="font"){var K={},F="";m(w,function(a,b){if(a==="color")K.color=b,delete w[a];a==="size"&&(K["font-size"]=
g[parseInt(b,10)-1]||"",delete w[a]);a==="face"&&(K["font-family"]=b,delete w[a]);a==="style"&&(F=b)});F&&!/;$/.test(F)&&(F+=";");m(K,function(a,b){b!==""&&(/\s/.test(b)&&(b="'"+b+"'"),F+=a+":"+b+";")});w.style=F}m(w,function(a,d){Sb[a]&&(w[a]=a);N(a,["src","href"])>=0&&(w[a]=ia(d,c));(b&&a!=="style"&&!h[l]["*"]&&!h[l][a]||l==="body"&&a==="contenteditable"||/^kindeditor_\d+$/.test(a))&&delete w[a];if(a==="style"&&d!==""){var e=aa(d);m(e,function(a){b&&!h[l].style&&!h[l]["."+a]&&delete e[a]});var g=
"";m(e,function(a,b){g+=a+":"+b+";"});w.style=g}});J="";m(w,function(a,b){a==="style"&&b===""||(b=b.replace(/"/g,"&quot;"),J+=" "+a+'="'+b+'"')})}l==="font"&&(l="span");return n+"<"+r+l+J+p+">"+j}),a=a.replace(/(<(?:pre|pre\s[^>]*)>)([\s\S]*?)(<\/pre>)/ig,function(a,b,c,d){return b+c.replace(/\n/g,'<span id="__kindeditor_pre_newline__">\n')+d}),a=a.replace(/\n\s*\n/g,"\n"),a=a.replace(/<span id="__kindeditor_pre_newline__">\n/g,"\n");return B(a)}function lb(a,b){a=a.replace(/<meta[\s\S]*?>/ig,"").replace(/<![\s\S]*?>/ig,
"").replace(/<style[^>]*>[\s\S]*?<\/style>/ig,"").replace(/<script[^>]*>[\s\S]*?<\/script>/ig,"").replace(/<w:[^>]+>[\s\S]*?<\/w:[^>]+>/ig,"").replace(/<o:[^>]+>[\s\S]*?<\/o:[^>]+>/ig,"").replace(/<xml>[\s\S]*?<\/xml>/ig,"").replace(/<(?:table|td)[^>]*>/ig,function(a){return a.replace(/border-bottom:([#\w\s]+)/ig,"border:$1")});return S(a,b)}function mb(a){if(/\.(rm|rmvb)(\?|$)/i.test(a))return"audio/x-pn-realaudio-plugin";if(/\.(swf|flv)(\?|$)/i.test(a))return"application/x-shockwave-flash";return"video/x-ms-asf-plugin"}
function nb(a){return H(unescape(a))}function Ia(a){var b="<embed ";m(a,function(a,d){b+=a+'="'+d+'" '});b+="/>";return b}function ob(a,b){var c=b.width,d=b.height,e=b.type||mb(b.src),g=Ia(b),h="";c>0&&(h+="width:"+c+"px;");d>0&&(h+="height:"+d+"px;");c=/realaudio/i.test(e)?"ke-rm":/flash/i.test(e)?"ke-flash":"ke-media";c='<img class="'+c+'" src="'+a+'" ';h!==""&&(c+='style="'+h+'" ');c+='data-ke-tag="'+escape(g)+'" alt="" />';return c}function xa(a,b){if(a.nodeType==9&&b.nodeType!=9)return!0;for(;b=
b.parentNode;)if(b==a)return!0;return!1}function ya(a,b){var b=b.toLowerCase(),c=null;if(!Tb&&a.nodeName.toLowerCase()!="script"){var d=a.ownerDocument.createElement("div");d.appendChild(a.cloneNode(!1));d=H(fa(d.innerHTML));b in d&&(c=d[b])}else try{c=a.getAttribute(b,2)}catch(e){c=a.getAttribute(b,1)}b==="style"&&c!==null&&(c=Rb(c));return c}function za(a,b){function c(a){if(typeof a!="string")return a;return a.replace(/([^\w\-])/g,"\\$1")}function d(a,b){return a==="*"||a.toLowerCase()===c(b.toLowerCase())}
function e(a,b,c){var e=[];(a=(c.ownerDocument||c).getElementById(a.replace(/\\/g,"")))&&d(b,a.nodeName)&&xa(c,a)&&e.push(a);return e}function g(a,b,c){var e=c.ownerDocument||c,g=[],h,f,i;if(c.getElementsByClassName){e=c.getElementsByClassName(a.replace(/\\/g,""));h=0;for(f=e.length;h<f;h++)i=e[h],d(b,i.nodeName)&&g.push(i)}else if(e.querySelectorAll){e=e.querySelectorAll((c.nodeName!=="#document"?c.nodeName+" ":"")+b+"."+a);h=0;for(f=e.length;h<f;h++)i=e[h],xa(c,i)&&g.push(i)}else{e=c.getElementsByTagName(b);
a=" "+a+" ";h=0;for(f=e.length;h<f;h++)if(i=e[h],i.nodeType==1)(b=i.className)&&(" "+b+" ").indexOf(a)>-1&&g.push(i)}return g}function h(a,b,d,e){for(var g=[],d=e.getElementsByTagName(d),h=0,f=d.length;h<f;h++)e=d[h],e.nodeType==1&&(b===null?ya(e,a)!==null&&g.push(e):b===c(ya(e,a))&&g.push(e));return g}function f(a,b){var c=[],i,k=(i=/^((?:\\.|[^.#\s\[<>])+)/.exec(a))?i[1]:"*";if(i=/#((?:[\w\-]|\\.)+)$/.exec(a))c=e(i[1],k,b);else if(i=/\.((?:[\w\-]|\\.)+)$/.exec(a))c=g(i[1],k,b);else if(i=/\[((?:[\w\-]|\\.)+)\]/.exec(a))c=
h(i[1].toLowerCase(),null,k,b);else if(i=/\[((?:[\w\-]|\\.)+)\s*=\s*['"]?((?:\\.|[^'"]+)+)['"]?\]/.exec(a)){c=i[1].toLowerCase();i=i[2];if(c==="id")k=e(i,k,b);else if(c==="class")k=g(i,k,b);else if(c==="name"){c=[];i=(b.ownerDocument||b).getElementsByName(i.replace(/\\/g,""));for(var n,p=0,r=i.length;p<r;p++)n=i[p],d(k,n.nodeName)&&xa(b,n)&&n.getAttributeNode("name")&&c.push(n);k=c}else k=h(c,i,k,b);c=k}else{k=b.getElementsByTagName(k);n=0;for(p=k.length;n<p;n++)i=k[n],i.nodeType==1&&c.push(i)}return c}
var k=a.split(",");if(k.length>1){var n=[];m(k,function(){m(za(this,b),function(){N(this,n)<0&&n.push(this)})});return n}for(var b=b||document,k=[],r,p=/((?:\\.|[^\s>])+|[\s>])/g;r=p.exec(a);)r[1]!==" "&&k.push(r[1]);r=[];if(k.length==1)return f(k[0],b);var p=!1,I,l,j,o,J,w,K,F,q,s;w=0;for(lenth=k.length;w<lenth;w++)if(I=k[w],I===">")p=!0;else{if(w>0){l=[];K=0;for(q=r.length;K<q;K++){o=r[K];j=f(I,o);F=0;for(s=j.length;F<s;F++)J=j[F],p?o===J.parentNode&&l.push(J):l.push(J)}r=l}else r=f(I,b);if(r.length===
0)return[]}return r}function T(a){if(!a)return document;return a.ownerDocument||a.document||a}function U(a){if(!a)return A;a=T(a);return a.parentWindow||a.defaultView}function Ub(a,b){if(a.nodeType==1){var c=T(a);try{a.innerHTML='<img id="__kindeditor_temp_tag__" width="0" height="0" style="display:none;" />'+b;var d=c.getElementById("__kindeditor_temp_tag__");d.parentNode.removeChild(d)}catch(e){f(a).empty(),f("@"+b,c).each(function(){a.appendChild(this)})}}}function Ja(a,b,c){l&&z<8&&b.toLowerCase()==
"class"&&(b="className");a.setAttribute(b,""+c)}function Ka(a){if(!a||!a.nodeName)return"";return a.nodeName.toLowerCase()}function Vb(a,b){var c=U(a),d=ga(b),e="";c.getComputedStyle?(c=c.getComputedStyle(a,null),e=c[d]||c.getPropertyValue(b)||a.style[d]):a.currentStyle&&(e=a.currentStyle[d]||a.style[d]);return e}function G(a){a=a||document;return O?a.body:a.documentElement}function ba(a){var a=a||document,b;l||La?(b=G(a).scrollLeft,a=G(a).scrollTop):(b=U(a).scrollX,a=U(a).scrollY);return{x:b,y:a}}
function D(a){this.init(a)}function pb(a){a.collapsed=a.startContainer===a.endContainer&&a.startOffset===a.endOffset;return a}function Ma(a,b,c){function d(d,e,g){var h=d.nodeValue.length,k;b&&(k=d.cloneNode(!0),k=e>0?k.splitText(e):k,g<h&&k.splitText(g-e));if(c){var n=d;e>0&&(n=d.splitText(e),a.setStart(d,e));g<h&&(d=n.splitText(g-e),a.setEnd(d,0));f.push(n)}return k}function e(){c&&a.up().collapse(!0);for(var b=0,d=f.length;b<d;b++){var e=f[b];e.parentNode&&e.parentNode.removeChild(e)}}function g(e,
l){for(var j=e.firstChild,o;j;){o=(new L(h)).selectNode(j);n=o.compareBoundaryPoints(ja,a);n>=0&&r<=0&&(r=o.compareBoundaryPoints(ka,a));r>=0&&p<=0&&(p=o.compareBoundaryPoints(ca,a));p>=0&&m<=0&&(m=o.compareBoundaryPoints(la,a));if(m>=0)return!1;o=j.nextSibling;if(n>0)if(j.nodeType==1)if(r>=0&&p<=0)b&&l.appendChild(j.cloneNode(!0)),c&&f.push(j);else{var q;b&&(q=j.cloneNode(!1),l.appendChild(q));if(g(j,q)===!1)return!1}else if(j.nodeType==3&&(j=j==k.startContainer?d(j,k.startOffset,j.nodeValue.length):
j==k.endContainer?d(j,0,k.endOffset):d(j,0,j.nodeValue.length),b))try{l.appendChild(j)}catch(s){}j=o}}var h=a.doc,f=[],k=a.cloneRange().down(),n=-1,r=-1,p=-1,m=-1,l=a.commonAncestor(),j=h.createDocumentFragment();if(l.nodeType==3)return l=d(l,a.startOffset,a.endOffset),b&&j.appendChild(l),e(),b?j:a;g(l,j);c&&a.up().collapse(!0);for(var l=0,o=f.length;l<o;l++){var q=f[l];q.parentNode&&q.parentNode.removeChild(q)}return b?j:a}function ma(a,b){for(var c=b;c;){var d=f(c);if(d.name=="marquee"||d.name==
"select")return;c=c.parentNode}try{a.moveToElementText(b)}catch(e){}}function qb(a,b){var c=a.parentElement().ownerDocument,d=a.duplicate();d.collapse(b);var e=d.parentElement(),g=e.childNodes;if(g.length===0)return{node:e.parentNode,offset:f(e).index()};var h=c,i=0,k=-1,n=a.duplicate();ma(n,e);for(var r=0,p=g.length;r<p;r++){var j=g[r],k=n.compareEndPoints("StartToStart",d);if(k===0)return{node:j.parentNode,offset:r};if(j.nodeType==1){var l=a.duplicate(),m,o=f(j),q=j;o.isControl()&&(m=c.createElement("span"),
o.after(m),q=m,i+=o.text().replace(/\r\n|\n|\r/g,"").length);ma(l,q);n.setEndPoint("StartToEnd",l);k>0?i+=l.text.replace(/\r\n|\n|\r/g,"").length:i=0;m&&f(m).remove()}else j.nodeType==3&&(n.moveStart("character",j.nodeValue.length),i+=j.nodeValue.length);k<0&&(h=j)}if(k<0&&h.nodeType==1)return{node:e,offset:f(e.lastChild).index()+1};if(k>0)for(;h.nextSibling&&h.nodeType==1;)h=h.nextSibling;n=a.duplicate();ma(n,e);n.setEndPoint("StartToEnd",d);i-=n.text.replace(/\r\n|\n|\r/g,"").length;if(k>0&&h.nodeType==
3)for(c=h.previousSibling;c&&c.nodeType==3;)i-=c.nodeValue.length,c=c.previousSibling;return{node:h,offset:i}}function rb(a,b){var c=a.ownerDocument||a,d=c.body.createTextRange();if(c==a)return d.collapse(!0),d;if(a.nodeType==1&&a.childNodes.length>0){var e=a.childNodes,g;b===0?(g=e[0],e=!0):(g=e[b-1],e=!1);if(!g)return d;if(f(g).name==="head")return b===1&&(e=!0),b===2&&(e=!1),d.collapse(e),d;if(g.nodeType==1){var h=f(g),i;h.isControl()&&(i=c.createElement("span"),e?h.before(i):h.after(i),g=i);ma(d,
g);d.collapse(e);i&&f(i).remove();return d}a=g;b=e?0:g.nodeValue.length}c=c.createElement("span");f(a).before(c);ma(d,c);d.moveStart("character",b);f(c).remove();return d}function sb(a){function b(a){if(f(a.node).name=="tr")a.node=a.node.cells[a.offset],a.offset=0}var c;if(l){if(a.item)return c=T(a.item(0)),c=new L(c),c.selectNode(a.item(0)),c;c=a.parentElement().ownerDocument;var d=qb(a,!0),a=qb(a,!1);b(d);b(a);c=new L(c);c.setStart(d.node,d.offset);c.setEnd(a.node,a.offset);return c}d=a.startContainer;
c=d.ownerDocument||d;c=new L(c);c.setStart(d,a.startOffset);c.setEnd(a.endContainer,a.endOffset);return c}function L(a){this.init(a)}function Na(a){if(!a.nodeName)return a.constructor===L?a:sb(a);return new L(a)}function P(a,b,c){try{a.execCommand(b,!1,c)}catch(d){}}function tb(a,b){var c="";try{c=a.queryCommandValue(b)}catch(d){}typeof c!=="string"&&(c="");return c}function Oa(a){var b=U(a);return a.selection||b.getSelection()}function ub(a){var b={},c,d;m(a,function(a,g){c=a.split(",");for(var h=
0,f=c.length;h<f;h++)d=c[h],b[d]=g});return b}function Pa(a,b){return vb(a,b,"*")||vb(a,b)}function vb(a,b,c){c=c||a.name;if(a.type!==1)return!1;b=ub(b);if(!b[c])return!1;for(var c=b[c].split(","),b=0,d=c.length;b<d;b++){var e=c[b];if(e==="*")return!0;var g=/^(\.?)([^=]+)(?:=([^=]*))?$/.exec(e),h=g[1]?"css":"attr",e=g[2],g=g[3]||"";if(g===""&&a[h](e)!=="")return!0;if(g!==""&&a[h](e)===g)return!0}return!1}function Qa(a,b){a.type==1&&(wb(a,b,"*"),wb(a,b))}function wb(a,b,c){c=c||a.name;if(a.type===
1&&(b=ub(b),b[c])){for(var c=b[c].split(","),b=!1,d=0,e=c.length;d<e;d++){var g=c[d];if(g==="*"){b=!0;break}var h=/^(\.?)([^=]+)(?:=([^=]*))?$/.exec(g),g=h[2];h[1]?(g=ga(g),a[0].style[g]&&(a[0].style[g]="")):a.removeAttr(g)}b&&a.remove(!0)}}function Ra(a){for(;a.first();)a=a.first();return a}function da(a){if(a.type!=1||a.isSingle())return!1;return a.html().replace(/<[^>]+>/g,"")===""}function Wb(a,b,c){m(b,function(b,c){b!=="style"&&a.attr(b,c)});m(c,function(b,c){a.css(b,c)})}function na(a){this.init(a)}
function xb(a){a.nodeName&&(a=T(a),a=Na(a).selectNodeContents(a.body).collapse(!1));return new na(a)}function Sa(a){var b=a.moveEl,c=a.moveFn,d=a.clickEl||b,e=a.beforeDrag,g=[document];(a.iframeFix===o||a.iframeFix)&&f("iframe").each(function(){if(!/^https?:\/\//.test(ia(this.src||"","absolute"))){var a;try{a=Ta(this)}catch(b){}if(a){var c=f(this).pos();f(a).data("pos-x",c.x);f(a).data("pos-y",c.y);g.push(a)}}});d.mousedown(function(a){function i(a){a.preventDefault();var b=f(T(a.target)),e=Q((b.data("pos-x")||
0)+a.pageX-q),a=Q((b.data("pos-y")||0)+a.pageY-s);c.call(d,p,l,m,o,e,a)}function k(a){a.preventDefault()}function n(a){a.preventDefault();f(g).unbind("mousemove",i).unbind("mouseup",n).unbind("selectstart",k);j.releaseCapture&&j.releaseCapture()}a.stopPropagation();var j=d.get(),p=t(b.css("left")),l=t(b.css("top")),m=b.width(),o=b.height(),q=a.pageX,s=a.pageY;e&&e();f(g).mousemove(i).mouseup(n).bind("selectstart",k);j.setCapture&&j.setCapture()})}function R(a){this.init(a)}function Ua(a){return new R(a)}
function Ta(a){a=f(a)[0];return a.contentDocument||a.contentWindow.document}function Xb(a,b,c,d){var e=[Va===""?"<html>":'<html dir="'+Va+'">','<head><meta charset="utf-8" /><title></title>',"<style>","html {margin:0;padding:0;}","body {margin:0;padding:5px;}",'body, td {font:12px/1.5 "sans serif",tahoma,verdana,helvetica;}',"body, p, div {word-wrap: break-word;}","p {margin:5px 0;}","table {border-collapse:collapse;}","img {border:0;}","noscript {display:none;}","table.ke-zeroborder td {border:1px dotted #AAA;}",
"img.ke-flash {","\tborder:1px solid #AAA;","\tbackground-image:url("+a+"common/flash.gif);","\tbackground-position:center center;","\tbackground-repeat:no-repeat;","\twidth:100px;","\theight:100px;","}","img.ke-rm {","\tborder:1px solid #AAA;","\tbackground-image:url("+a+"common/rm.gif);","\tbackground-position:center center;","\tbackground-repeat:no-repeat;","\twidth:100px;","\theight:100px;","}","img.ke-media {","\tborder:1px solid #AAA;","\tbackground-image:url("+a+"common/media.gif);","\tbackground-position:center center;",
"\tbackground-repeat:no-repeat;","\twidth:100px;","\theight:100px;","}","img.ke-anchor {","\tborder:1px dashed #666;","\twidth:16px;","\theight:16px;","}",".ke-script, .ke-noscript, .ke-display-none {","\tdisplay:none;","\tfont-size:0;","\twidth:0;","\theight:0;","}",".ke-pagebreak {","\tborder:1px dotted #AAA;","\tfont-size:0;","\theight:2px;","}","</style>"];Y(c)||(c=[c]);m(c,function(a,b){b&&e.push('<link href="'+b+'" rel="stylesheet" />')});d&&e.push("<style>"+d+"</style>");e.push("</head><body "+
(b?'class="'+b+'"':"")+"></body></html>");return e.join("\n")}function oa(a,b){if(a.hasVal()){if(b===o){var c=a.val();return c=c.replace(/(<(?:p|p\s[^>]*)>) *(<\/p>)/ig,"")}return a.val(b)}return a.html(b)}function pa(a){this.init(a)}function yb(a){return new pa(a)}function zb(a,b){var c=this.get(a);c&&!c.hasClass("ke-disabled")&&b(c)}function Aa(a){this.init(a)}function Ab(a){return new Aa(a)}function qa(a){this.init(a)}function Wa(a){return new qa(a)}function ra(a){this.init(a)}function Bb(a){return new ra(a)}
function Xa(a){this.init(a)}function sa(a){this.init(a)}function Cb(a){return new sa(a)}function Ya(a,b){var c=document.getElementsByTagName("head")[0]||(O?document.body:document.documentElement),d=document.createElement("script");c.appendChild(d);d.src=a;d.charset="utf-8";d.onload=d.onreadystatechange=function(){if(!this.readyState||this.readyState==="loaded")b&&b(),d.onload=d.onreadystatechange=null,c.removeChild(d)}}function Db(a){var b=a.indexOf("?");return b>0?a.substr(0,b):a}function Za(a){for(var b=
document.getElementsByTagName("head")[0]||(O?document.body:document.documentElement),c=document.createElement("link"),d=Db(ia(a,"absolute")),e=f('link[rel="stylesheet"]',b),g=0,h=e.length;g<h;g++)if(Db(ia(e[g].href,"absolute"))===d)return;b.appendChild(c);c.href=a;c.rel="stylesheet"}function Eb(a,b){if(a===o)return V;if(!b)return V[a];V[a]=b}function Fb(a){var b,c="core";if(b=/^(\w+)\.(\w+)$/.exec(a))c=b[1],a=b[2];return{ns:c,key:a}}function Gb(a,b){b=b===o?f.options.langType:b;if(typeof a==="string"){if(!M[b])return"no language";
var c=a.length-1;if(a.substr(c)===".")return M[b][a.substr(0,c)];c=Fb(a);return M[b][c.ns][c.key]}m(a,function(a,c){var g=Fb(a);M[b]||(M[b]={});M[b][g.ns]||(M[b][g.ns]={});M[b][g.ns][g.key]=c})}function Ba(a,b){if(!a.collapsed){var a=a.cloneRange().up(),c=a.startContainer,d=a.startOffset;if(W||a.isControl())if((c=f(c.childNodes[d]))&&c.name=="img"&&b(c))return c}}function Yb(){var a=this;f(a.edit.doc).contextmenu(function(b){a.menu&&a.hideMenu();if(a.useContextmenu){if(a._contextmenus.length!==0){var c=
0,d=[];for(m(a._contextmenus,function(){if(this.title=="-")d.push(this);else if(this.cond&&this.cond()&&(d.push(this),this.width&&this.width>c))c=this.width});d.length>0&&d[0].title=="-";)d.shift();for(;d.length>0&&d[d.length-1].title=="-";)d.pop();var e=null;m(d,function(a){this.title=="-"&&e.title=="-"&&delete d[a];e=this});if(d.length>0){b.preventDefault();var g=f(a.edit.iframe).pos(),h=Wa({x:g.x+b.clientX,y:g.y+b.clientY,width:c,css:{visibility:"hidden"},shadowMode:a.shadowMode});m(d,function(){this.title&&
h.addItem(this)});var g=G(h.doc),i=h.div.height();b.clientY+i>=g.clientHeight-100&&h.pos(h.x,t(h.y)-i);h.div.css("visibility","visible");a.menu=h}}}else b.preventDefault()})}function Zb(){function a(a){for(a=f(a.commonAncestor());a;){if(a.type==1&&!a.isStyle())break;a=a.parent()}return a.name}var b=this,c=b.edit.doc,d=b.newlineTag;if(!(l&&d!=="br")&&(!ea||!(z<3&&d!=="p"))&&!(La&&z<9)){var e=u("h1,h2,h3,h4,h5,h6,pre,li"),g=u("p,h1,h2,h3,h4,h5,h6,pre,li,blockquote");f(c).keydown(function(f){if(!(f.which!=
13||f.shiftKey||f.ctrlKey||f.altKey)){b.cmd.selection();var i=a(b.cmd.range);i=="marquee"||i=="select"||(d==="br"&&!e[i]?(f.preventDefault(),b.insertHtml("<br />"+(l&&z<9?"":"\u200b"))):g[i]||P(c,"formatblock","<p>"))}});f(c).keyup(function(e){if(!(e.which!=13||e.shiftKey||e.ctrlKey||e.altKey)&&d!="br")if(ea){var e=b.cmd.commonAncestor("p"),i=b.cmd.commonAncestor("a");i&&i.text()==""&&(i.remove(!0),b.cmd.range.selectNodeContents(e[0]).collapse(!0),b.cmd.select())}else if(b.cmd.selection(),e=a(b.cmd.range),
!(e=="marquee"||e=="select"))if(g[e]||P(c,"formatblock","<p>"),e=b.cmd.commonAncestor("div")){for(var i=f("<p></p>"),k=e[0].firstChild;k;){var n=k.nextSibling;i.append(k);k=n}e.before(i);e.remove();b.cmd.range.selectNodeContents(i[0]);b.cmd.select()}})}}function $b(){var a=this,b=a.edit.doc;f(b).keydown(function(c){if(c.which==9)if(c.preventDefault(),a.afterTab)a.afterTab.call(a,c);else{var c=a.cmd,d=c.range;d.shrink();d.collapsed&&d.startContainer.nodeType==1&&(d.insertNode(f("@&nbsp;",b)[0]),c.select());
a.insertHtml("&nbsp;&nbsp;&nbsp;&nbsp;")}})}function ac(){var a=this;f(a.edit.textarea[0],a.edit.win).focus(function(b){a.afterFocus&&a.afterFocus.call(a,b)}).blur(function(b){a.afterBlur&&a.afterBlur.call(a,b)})}function X(a){return B(a.replace(/<span [^>]*id="?__kindeditor_bookmark_\w+_\d+__"?[^>]*><\/span>/ig,""))}function $a(a){return a.replace(/<div[^>]+class="?__kindeditor_paste__"?[^>]*>[\s\S]*?<\/div>/ig,"")}function Hb(a,b){if(a.length===0)a.push(b);else{var c=a[a.length-1];X(b.html)!==X(c.html)&&
a.push(b)}}function Ib(a,b){var c=this.edit,d=c.doc.body,e,g;if(a.length===0)return this;c.designMode?(e=this.cmd.range,g=e.createBookmark(!0),g.html=d.innerHTML):g={html:d.innerHTML};Hb(b,g);var h=a.pop();X(g.html)===X(h.html)&&a.length>0&&(h=a.pop());c.designMode?(c.html(h.html),h.start&&(e.moveToBookmark(h),this.select())):f(d).html(X(h.html));return this}function ta(a){function b(a,b){ta.prototype[a]===o&&(c[a]=b);c.options[a]=b}var c=this;c.options={};m(a,function(c){b(c,a[c])});m(f.options,
function(a,d){c[a]===o&&b(a,d)});var d=f(c.srcElement||"<textarea/>");if(!c.width)c.width=d[0].style.width||d.width();if(!c.height)c.height=d[0].style.height||d.height();b("width",j(c.width,c.minWidth));b("height",j(c.height,c.minHeight));b("width",s(c.width));b("height",s(c.height));if(bc&&(!cc||z<534))c.designMode=!1;c.srcElement=d;c.initContent="";c.plugin={};c.isCreated=!1;c.isLoading=!1;c._handlers={};c._contextmenus=[];c._undoStack=[];c._redoStack=[];c._calledPlugins={};c._firstAddBookmark=
!0;c.menu=c.contextmenu=null;c.dialogs=[]}function Jb(a,b){function c(a){m(V,function(b,c){c.call(a,KindEditor)});return a.create()}b=b||{};b.basePath=j(b.basePath,f.basePath);b.themesPath=j(b.themesPath,b.basePath+"themes/");b.langPath=j(b.langPath,b.basePath+"lang/");b.pluginsPath=j(b.pluginsPath,b.basePath+"plugins/");if(j(b.loadStyleMode,f.options.loadStyleMode)){var d=j(b.themeType,f.options.themeType);Za(b.themesPath+"default/default.css");Za(b.themesPath+d+"/"+d+".css")}if((d=f(a))&&d.length!==
0){if(d.length>1)return d.each(function(){Jb(this,b)}),_instances[0];b.srcElement=d[0];var e=new ta(b);_instances.push(e);if(M[e.langType])return c(e);Ya(e.langPath+e.langType+".js?ver="+encodeURIComponent(f.DEBUG?Ca:Da),function(){c(e)});return e}}function Kb(a,b){f(a).each(function(a,d){f.each(_instances,function(a,c){if(c&&c.srcElement[0]==d)return b.call(c,a,c),!1})})}if(!A.KindEditor){if(!A.console)A.console={};if(!console.log)console.log=function(){};var Da="4.1.7 (2013-04-21)",q=navigator.userAgent.toLowerCase(),
l=q.indexOf("msie")>-1&&q.indexOf("opera")==-1,ea=q.indexOf("gecko")>-1&&q.indexOf("khtml")==-1,W=q.indexOf("applewebkit")>-1,La=q.indexOf("opera")>-1,bc=q.indexOf("mobile")>-1,cc=/ipad|iphone|ipod/.test(q),O=document.compatMode!="CSS1Compat",z=(q=/(?:msie|firefox|webkit|opera)[\/:\s](\d+)/.exec(q))?q[1]:"0",Ca=(new Date).getTime(),Q=Math.round,f={DEBUG:!1,VERSION:Da,IE:l,GECKO:ea,WEBKIT:W,OPERA:La,V:z,TIME:Ca,each:m,isArray:Y,isFunction:bb,inArray:N,inString:ua,trim:B,addUnit:s,removeUnit:t,escape:C,
unescape:fa,toCamel:ga,toHex:va,toMap:u,toArray:Fa,undef:j,invalidUrl:function(a){return!a||/[<>"]/.test(a)},addParam:function(a,b){return a.indexOf("?")>=0?a+"&"+b:a+"?"+b},extend:E,json:cb},jb=u("a,abbr,acronym,b,basefont,bdo,big,br,button,cite,code,del,dfn,em,font,i,img,input,ins,kbd,label,map,q,s,samp,select,small,span,strike,strong,sub,sup,textarea,tt,u,var"),kb=u("address,applet,blockquote,body,center,dd,dir,div,dl,dt,fieldset,form,frameset,h1,h2,h3,h4,h5,h6,head,hr,html,iframe,ins,isindex,li,map,menu,meta,noframes,noscript,object,ol,p,pre,script,style,table,tbody,td,tfoot,th,thead,title,tr,ul"),
ib=u("area,base,basefont,br,col,frame,hr,img,input,isindex,link,meta,param,embed"),Lb=u("b,basefont,big,del,em,font,i,s,small,span,strike,strong,sub,sup,u"),dc=u("img,table,input,textarea,button"),Ha=u("pre,style,script"),Ea=u("html,head,body,td,tr,table,ol,ul,li");u("colgroup,dd,dt,li,options,p,td,tfoot,th,thead,tr");var Sb=u("checked,compact,declare,defer,disabled,ismap,multiple,nohref,noresize,noshade,nowrap,readonly,selected"),Mb=u("input,button,textarea,select");f.basePath=function(){for(var a=
document.getElementsByTagName("script"),b,c=0,d=a.length;c<d;c++)if(b=a[c].src||"",/kindeditor[\w\-\.]*\.js/.test(b))return b.substring(0,b.lastIndexOf("/")+1);return""}();f.options={designMode:!0,fullscreenMode:!1,filterMode:!0,wellFormatMode:!0,shadowMode:!0,loadStyleMode:!0,basePath:f.basePath,themesPath:f.basePath+"themes/",langPath:f.basePath+"lang/",pluginsPath:f.basePath+"plugins/",themeType:"default",langType:"zh_CN",urlType:"",newlineTag:"p",resizeType:2,syncType:"form",pasteType:2,dialogAlignType:"page",
useContextmenu:!0,fullscreenShortcut:!1,bodyClass:"ke-content",indentChar:"\t",cssPath:"",cssData:"",minWidth:650,minHeight:100,minChangeSize:50,zIndex:811213,items:["source","|","undo","redo","|","preview","print","template","code","cut","copy","paste","plainpaste","wordpaste","|","justifyleft","justifycenter","justifyright","justifyfull","insertorderedlist","insertunorderedlist","indent","outdent","subscript","superscript","clearhtml","quickformat","selectall","|","fullscreen","/","formatblock",
"fontname","fontsize","|","forecolor","hilitecolor","bold","italic","underline","strikethrough","lineheight","removeformat","|","image","multiimage","flash","media","insertfile","table","hr","emoticons","baidumap","pagebreak","anchor","link","unlink","|","about"],noDisableItems:["source","fullscreen"],colorTable:[["#E53333","#E56600","#FF9900","#64451D","#DFC5A4","#FFE500"],["#009900","#006600","#99BB00","#B8D100","#60D978","#00D5FF"],["#337FE5","#003399","#4C33E5","#9933E5","#CC33E5","#EE33EE"],
["#FFFFFF","#CCCCCC","#999999","#666666","#333333","#000000"]],fontSizeTable:["9px","10px","12px","14px","16px","18px","24px","32px"],htmlTags:{font:["id","class","color","size","face",".background-color"],span:["id","class",".color",".background-color",".font-size",".font-family",".background",".font-weight",".font-style",".text-decoration",".vertical-align",".line-height"],div:["id","class","align",".border",".margin",".padding",".text-align",".color",".background-color",".font-size",".font-family",
".font-weight",".background",".font-style",".text-decoration",".vertical-align",".margin-left"],table:["id","class","border","cellspacing","cellpadding","width","height","align","bordercolor",".padding",".margin",".border","bgcolor",".text-align",".color",".background-color",".font-size",".font-family",".font-weight",".font-style",".text-decoration",".background",".width",".height",".border-collapse"],"td,th":["id","class","align","valign","width","height","colspan","rowspan","bgcolor",".text-align",
".color",".background-color",".font-size",".font-family",".font-weight",".font-style",".text-decoration",".vertical-align",".background",".border"],a:["id","class","href","target","name"],embed:["id","class","src","width","height","type","loop","autostart","quality",".width",".height","align","allowscriptaccess"],img:["id","class","src","width","height","border","alt","title","align",".width",".height",".border"],"p,ol,ul,li,blockquote,h1,h2,h3,h4,h5,h6":["id","class","align",".text-align",".color",
".background-color",".font-size",".font-family",".background",".font-weight",".font-style",".text-decoration",".vertical-align",".text-indent",".margin-left"],pre:["id","class"],hr:["id","class",".page-break-after"],"br,tbody,tr,strong,b,sub,sup,em,i,u,strike,s,del":["id","class"],iframe:["id","class","src","frameborder","width","height",".width",".height"]},layout:'<div class="container"><div class="toolbar"></div><div class="edit"></div><div class="statusbar"></div></div>'};var db=!1,Nb=u("8,9,13,32,46,48..57,59,61,65..90,106,109..111,188,190..192,219..222"),
q=u("33..40"),ab={};m(Nb,function(a,b){ab[a]=b});m(q,function(a,b){ab[a]=b});var ec="altKey,attrChange,attrName,bubbles,button,cancelable,charCode,clientX,clientY,ctrlKey,currentTarget,data,detail,eventPhase,fromElement,handler,keyCode,metaKey,newValue,offsetX,offsetY,originalTarget,pageX,pageY,prevValue,relatedNode,relatedTarget,screenX,screenY,shiftKey,srcElement,target,toElement,view,wheelDelta,which".split(",");E(eb,{init:function(a,b){var c=this,d=a.ownerDocument||a.document||a;c.event=b;m(ec,
function(a,d){c[d]=b[d]});if(!c.target)c.target=c.srcElement||d;if(c.target.nodeType===3)c.target=c.target.parentNode;if(!c.relatedTarget&&c.fromElement)c.relatedTarget=c.fromElement===c.target?c.toElement:c.fromElement;if(c.pageX==null&&c.clientX!=null){var e=d.documentElement,d=d.body;c.pageX=c.clientX+(e&&e.scrollLeft||d&&d.scrollLeft||0)-(e&&e.clientLeft||d&&d.clientLeft||0);c.pageY=c.clientY+(e&&e.scrollTop||d&&d.scrollTop||0)-(e&&e.clientTop||d&&d.clientTop||0)}if(!c.which&&(c.charCode||c.charCode===
0?c.charCode:c.keyCode))c.which=c.charCode||c.keyCode;if(!c.metaKey&&c.ctrlKey)c.metaKey=c.ctrlKey;if(!c.which&&c.button!==o)c.which=c.button&1?1:c.button&2?3:c.button&4?2:0;switch(c.which){case 186:c.which=59;break;case 187:case 107:case 43:c.which=61;break;case 189:case 45:c.which=109;break;case 42:c.which=106;break;case 47:c.which=111;break;case 78:c.which=110}c.which>=96&&c.which<=105&&(c.which-=48)},preventDefault:function(){var a=this.event;a.preventDefault&&a.preventDefault();a.returnValue=
!1},stopPropagation:function(){var a=this.event;a.stopPropagation&&a.stopPropagation();a.cancelBubble=!0},stop:function(){this.preventDefault();this.stopPropagation()}});var Z="kindeditor_"+Ca,gb=0,v={};l&&A.attachEvent("onunload",function(){m(v,function(a,b){b.el&&ha(b.el)})});f.ctrl=Ga;f.ready=function(a){function b(){e||(e=!0,a(KindEditor))}function c(){if(!e){try{document.documentElement.doScroll("left")}catch(a){setTimeout(c,100);return}b()}}function d(){document.readyState==="complete"&&b()}
var e=!1;if(document.addEventListener)$(document,"DOMContentLoaded",b);else if(document.attachEvent){$(document,"readystatechange",d);var g=!1;try{g=A.frameElement==null}catch(f){}document.documentElement.doScroll&&g&&c()}$(A,"load",b)};f.formatUrl=ia;f.formatHtml=S;f.getCssList=aa;f.getAttrList=H;f.mediaType=mb;f.mediaAttrs=nb;f.mediaEmbed=Ia;f.mediaImg=ob;f.clearMsWord=lb;f.tmpl=function(a,b){var c=new Function("obj","var p=[],print=function(){p.push.apply(p,arguments);};with(obj){p.push('"+a.replace(/[\r\t\n]/g,
" ").split("<%").join("\t").replace(/((^|%>)[^\t]*)'/g,"$1\r").replace(/\t=(.*?)%>/g,"',$1,'").split("\t").join("');").split("%>").join("p.push('").split("\r").join("\\'")+"');}return p.join('');");return b?c(b):c};q=document.createElement("div");q.setAttribute("className","t");var Tb=q.className!=="t";f.query=function(a,b){var c=za(a,b);return c.length>0?c[0]:null};f.queryAll=za;E(D,{init:function(a){for(var a=Y(a)?a:[a],b=0,c=0,d=a.length;c<d;c++)a[c]&&(this[c]=a[c].constructor===D?a[c][0]:a[c],
b++);this.length=b;this.doc=T(this[0]);this.name=Ka(this[0]);this.type=this.length>0?this[0].nodeType:null;this.win=U(this[0])},each:function(a){for(var b=0;b<this.length;b++)if(a.call(this[b],b,this[b])===!1)break;return this},bind:function(a,b){this.each(function(){$(this,a,b)});return this},unbind:function(a,b){this.each(function(){ha(this,a,b)});return this},fire:function(a){if(this.length<1)return this;hb(this[0],a);return this},hasAttr:function(a){if(this.length<1)return!1;return!!ya(this[0],
a)},attr:function(a,b){var c=this;if(a===o)return H(c.outer());if(typeof a==="object")return m(a,function(a,b){c.attr(a,b)}),c;if(b===o)return b=c.length<1?null:ya(c[0],a),b===null?"":b;c.each(function(){Ja(this,a,b)});return c},removeAttr:function(a){this.each(function(){var b=a;l&&z<8&&b.toLowerCase()=="class"&&(b="className");Ja(this,b,"");this.removeAttribute(b)});return this},get:function(a){if(this.length<1)return null;return this[a||0]},eq:function(a){if(this.length<1)return null;return this[a]?
new D(this[a]):null},hasClass:function(a){if(this.length<1)return!1;return ua(a,this[0].className," ")},addClass:function(a){this.each(function(){if(!ua(a,this.className," "))this.className=B(this.className+" "+a)});return this},removeClass:function(a){this.each(function(){if(ua(a,this.className," "))this.className=B(this.className.replace(RegExp("(^|\\s)"+a+"(\\s|$)")," "))});return this},html:function(a){if(a===o){if(this.length<1||this.type!=1)return"";return S(this[0].innerHTML)}this.each(function(){Ub(this,
a)});return this},text:function(){if(this.length<1)return"";return l?this[0].innerText:this[0].textContent},hasVal:function(){if(this.length<1)return!1;return!!Mb[Ka(this[0])]},val:function(a){if(a===o){if(this.length<1)return"";return this.hasVal()?this[0].value:this.attr("value")}else return this.each(function(){Mb[Ka(this)]?this.value=a:Ja(this,"value",a)}),this},css:function(a,b){var c=this;if(a===o)return aa(c.attr("style"));if(typeof a==="object")return m(a,function(a,b){c.css(a,b)}),c;if(b===
o){if(c.length<1)return"";return c[0].style[ga(a)]||Vb(c[0],a)||""}c.each(function(){this.style[ga(a)]=b});return c},width:function(a){if(a===o){if(this.length<1)return 0;return this[0].offsetWidth}return this.css("width",s(a))},height:function(a){if(a===o){if(this.length<1)return 0;return this[0].offsetHeight}return this.css("height",s(a))},opacity:function(a){this.each(function(){this.style.opacity===o?this.style.filter=a==1?"":"alpha(opacity="+a*100+")":this.style.opacity=a==1?"":a});return this},
data:function(a,b){a="kindeditor_data_"+a;if(b===o){if(this.length<1)return null;return this[0][a]}this.each(function(){this[a]=b});return this},pos:function(){var a=this[0],b=0,c=0;if(a)if(a.getBoundingClientRect)a=a.getBoundingClientRect(),c=ba(this.doc),b=a.left+c.x,c=a.top+c.y;else for(;a;)b+=a.offsetLeft,c+=a.offsetTop,a=a.offsetParent;return{x:Q(b),y:Q(c)}},clone:function(a){if(this.length<1)return new D([]);return new D(this[0].cloneNode(a))},append:function(a){this.each(function(){this.appendChild&&
this.appendChild(f(a)[0])});return this},appendTo:function(a){this.each(function(){f(a)[0].appendChild(this)});return this},before:function(a){this.each(function(){this.parentNode.insertBefore(f(a)[0],this)});return this},after:function(a){this.each(function(){this.nextSibling?this.parentNode.insertBefore(f(a)[0],this.nextSibling):this.parentNode.appendChild(f(a)[0])});return this},replaceWith:function(a){var b=[];this.each(function(c,d){ha(d);var e=f(a)[0];d.parentNode.replaceChild(e,d);b.push(e)});
return f(b)},empty:function(){this.each(function(a,b){for(var c=b.firstChild;c;){if(!b.parentNode)break;var d=c.nextSibling;c.parentNode.removeChild(c);c=d}});return this},remove:function(a){var b=this;b.each(function(c,d){if(d.parentNode){ha(d);if(a)for(var e=d.firstChild;e;){var g=e.nextSibling;d.parentNode.insertBefore(e,d);e=g}d.parentNode.removeChild(d);delete b[c]}});b.length=0;return b},show:function(a){a===o&&(a=this._originDisplay||"");if(this.css("display")!="none")return this;return this.css("display",
a)},hide:function(){if(this.length<1)return this;this._originDisplay=this[0].style.display;return this.css("display","none")},outer:function(){if(this.length<1)return"";var a=this.doc.createElement("div");a.appendChild(this[0].cloneNode(!0));return S(a.innerHTML)},isSingle:function(){return!!ib[this.name]},isInline:function(){return!!jb[this.name]},isBlock:function(){return!!kb[this.name]},isStyle:function(){return!!Lb[this.name]},isControl:function(){return!!dc[this.name]},contains:function(a){if(this.length<
1)return!1;return xa(this[0],f(a)[0])},parent:function(){if(this.length<1)return null;var a=this[0].parentNode;return a?new D(a):null},children:function(){if(this.length<1)return new D([]);for(var a=[],b=this[0].firstChild;b;)(b.nodeType!=3||B(b.nodeValue)!=="")&&a.push(b),b=b.nextSibling;return new D(a)},first:function(){var a=this.children();return a.length>0?a.eq(0):null},last:function(){var a=this.children();return a.length>0?a.eq(a.length-1):null},index:function(){if(this.length<1)return-1;for(var a=
-1,b=this[0];b;)a++,b=b.previousSibling;return a},prev:function(){if(this.length<1)return null;var a=this[0].previousSibling;return a?new D(a):null},next:function(){if(this.length<1)return null;var a=this[0].nextSibling;return a?new D(a):null},scan:function(a,b){function c(d){for(d=b?d.firstChild:d.lastChild;d;){var e=b?d.nextSibling:d.previousSibling;if(a(d)===!1)return!1;if(c(d)===!1)return!1;d=e}}if(!(this.length<1))return b=b===o?!0:b,c(this[0]),this}});m("blur,focus,focusin,focusout,load,resize,scroll,unload,click,dblclick,mousedown,mouseup,mousemove,mouseover,mouseout,mouseenter,mouseleave,change,select,submit,keydown,keypress,keyup,error,contextmenu".split(","),
function(a,b){D.prototype[b]=function(a){return a?this.bind(b,a):this.fire(b)}});q=f;f=function(a,b){function c(a){a[0]||(a=[]);return new D(a)}if(!(a===o||a===null)){if(typeof a==="string"){b&&(b=f(b)[0]);var d=a.length;a.charAt(0)==="@"&&(a=a.substr(1));if(a.length!==d||/<.+>/.test(a)){var d=(b?b.ownerDocument||b:document).createElement("div"),e=[];d.innerHTML='<img id="__kindeditor_temp_tag__" width="0" height="0" style="display:none;" />'+a;for(var g=0,h=d.childNodes.length;g<h;g++){var i=d.childNodes[g];
i.id!="__kindeditor_temp_tag__"&&e.push(i)}return c(e)}return c(za(a,b))}if(a&&a.constructor===D)return a;a.toArray&&(a=a.toArray());if(Y(a))return c(a);return c(Fa(arguments))}};m(q,function(a,b){f[a]=b});f.NodeClass=D;A.KindEditor=f;var ka=0,ja=1,ca=2,la=3,Ob=0;E(L,{init:function(a){this.startContainer=a;this.startOffset=0;this.endContainer=a;this.endOffset=0;this.collapsed=!0;this.doc=a},commonAncestor:function(){function a(a){for(var b=[];a;)b.push(a),a=a.parentNode;return b}for(var b=a(this.startContainer),
c=a(this.endContainer),d=0,e=b.length,g=c.length,f,i;++d;)if(f=b[e-d],i=c[g-d],!f||!i||f!==i)break;return b[e-d+1]},setStart:function(a,b){var c=this.doc;this.startContainer=a;this.startOffset=b;if(this.endContainer===c)this.endContainer=a,this.endOffset=b;return pb(this)},setEnd:function(a,b){var c=this.doc;this.endContainer=a;this.endOffset=b;if(this.startContainer===c)this.startContainer=a,this.startOffset=b;return pb(this)},setStartBefore:function(a){return this.setStart(a.parentNode||this.doc,
f(a).index())},setStartAfter:function(a){return this.setStart(a.parentNode||this.doc,f(a).index()+1)},setEndBefore:function(a){return this.setEnd(a.parentNode||this.doc,f(a).index())},setEndAfter:function(a){return this.setEnd(a.parentNode||this.doc,f(a).index()+1)},selectNode:function(a){return this.setStartBefore(a).setEndAfter(a)},selectNodeContents:function(a){var b=f(a);if(b.type==3||b.isSingle())return this.selectNode(a);b=b.children();if(b.length>0)return this.setStartBefore(b[0]).setEndAfter(b[b.length-
1]);return this.setStart(a,0).setEnd(a,0)},collapse:function(a){if(a)return this.setEnd(this.startContainer,this.startOffset);return this.setStart(this.endContainer,this.endOffset)},compareBoundaryPoints:function(a,b){var c=this.get(),d=b.get();if(l){var e={};e[ka]="StartToStart";e[ja]="EndToStart";e[ca]="EndToEnd";e[la]="StartToEnd";c=c.compareEndPoints(e[a],d);if(c!==0)return c;var g,h,i,k;if(a===ka||a===la)g=this.startContainer,i=this.startOffset;if(a===ja||a===ca)g=this.endContainer,i=this.endOffset;
if(a===ka||a===ja)h=b.startContainer,k=b.startOffset;if(a===ca||a===la)h=b.endContainer,k=b.endOffset;if(g===h)return g=i-k,g>0?1:g<0?-1:0;for(c=h;c&&c.parentNode!==g;)c=c.parentNode;if(c)return f(c).index()>=i?-1:1;for(c=g;c&&c.parentNode!==h;)c=c.parentNode;if(c)return f(c).index()>=k?1:-1;if((c=f(h).next())&&c.contains(g))return 1;if((c=f(g).next())&&c.contains(h))return-1}else return c.compareBoundaryPoints(a,d)},cloneRange:function(){return(new L(this.doc)).setStart(this.startContainer,this.startOffset).setEnd(this.endContainer,
this.endOffset)},toString:function(){var a=this.get();return(l?a.text:a.toString()).replace(/\r\n|\n|\r/g,"")},cloneContents:function(){return Ma(this,!0,!1)},deleteContents:function(){return Ma(this,!1,!0)},extractContents:function(){return Ma(this,!0,!0)},insertNode:function(a){var b=this.startContainer,c=this.startOffset,d=this.endContainer,e=this.endOffset,g,f,i,k=1;if(a.nodeName.toLowerCase()==="#document-fragment")g=a.firstChild,f=a.lastChild,k=a.childNodes.length;b.nodeType==1?(i=b.childNodes[c])?
(b.insertBefore(a,i),b===d&&(e+=k)):b.appendChild(a):b.nodeType==3&&(c===0?(b.parentNode.insertBefore(a,b),b.parentNode===d&&(e+=k)):c>=b.nodeValue.length?b.nextSibling?b.parentNode.insertBefore(a,b.nextSibling):b.parentNode.appendChild(a):(i=c>0?b.splitText(c):b,b.parentNode.insertBefore(a,i),b===d&&(d=i,e-=c)));g?this.setStartBefore(g).setEndAfter(f):this.selectNode(a);if(this.compareBoundaryPoints(ca,this.cloneRange().setEnd(d,e))>=1)return this;return this.setEnd(d,e)},surroundContents:function(a){a.appendChild(this.extractContents());
return this.insertNode(a).selectNode(a)},isControl:function(){var a=this.startContainer,b=this.startOffset,c=this.endContainer,d=this.endOffset;return a.nodeType==1&&a===c&&b+1===d&&f(a.childNodes[b]).isControl()},get:function(a){var b=this.doc;if(!l){b=b.createRange();try{b.setStart(this.startContainer,this.startOffset),b.setEnd(this.endContainer,this.endOffset)}catch(c){}return b}if(a&&this.isControl())return b=b.body.createControlRange(),b.addElement(this.startContainer.childNodes[this.startOffset]),
b;a=this.cloneRange().down();b=b.body.createTextRange();b.setEndPoint("StartToStart",rb(a.startContainer,a.startOffset));b.setEndPoint("EndToStart",rb(a.endContainer,a.endOffset));return b},html:function(){return f(this.cloneContents()).outer()},down:function(){function a(a,d,e){if(a.nodeType==1&&(a=f(a).children(),a.length!==0)){var g,h,i,k;d>0&&(g=a.eq(d-1));d<a.length&&(h=a.eq(d));if(g&&g.type==3)i=g[0],k=i.nodeValue.length;h&&h.type==3&&(i=h[0],k=0);i&&(e?b.setStart(i,k):b.setEnd(i,k))}}var b=
this;a(b.startContainer,b.startOffset,!0);a(b.endContainer,b.endOffset,!1);return b},up:function(){function a(a,d,e){a.nodeType==3&&(d===0?e?b.setStartBefore(a):b.setEndBefore(a):d==a.nodeValue.length&&(e?b.setStartAfter(a):b.setEndAfter(a)))}var b=this;a(b.startContainer,b.startOffset,!0);a(b.endContainer,b.endOffset,!1);return b},enlarge:function(a){function b(b,e,g){b=f(b);if(!(b.type==3||Ea[b.name]||!a&&b.isBlock()))if(e===0){for(;!b.prev();){e=b.parent();if(!e||Ea[e.name]||!a&&e.isBlock())break;
b=e}g?c.setStartBefore(b[0]):c.setEndBefore(b[0])}else if(e==b.children().length){for(;!b.next();){e=b.parent();if(!e||Ea[e.name]||!a&&e.isBlock())break;b=e}g?c.setStartAfter(b[0]):c.setEndAfter(b[0])}}var c=this;c.up();b(c.startContainer,c.startOffset,!0);b(c.endContainer,c.endOffset,!1);return c},shrink:function(){for(var a,b=this.collapsed;this.startContainer.nodeType==1&&(a=this.startContainer.childNodes[this.startOffset])&&a.nodeType==1&&!f(a).isSingle();)this.setStart(a,0);if(b)return this.collapse(b);
for(;this.endContainer.nodeType==1&&this.endOffset>0&&(a=this.endContainer.childNodes[this.endOffset-1])&&a.nodeType==1&&!f(a).isSingle();)this.setEnd(a,a.childNodes.length);return this},createBookmark:function(a){var b,c=f('<span style="display:none;"></span>',this.doc)[0];c.id="__kindeditor_bookmark_start_"+Ob++ +"__";if(!this.collapsed)b=c.cloneNode(!0),b.id="__kindeditor_bookmark_end_"+Ob++ +"__";b&&this.cloneRange().collapse(!1).insertNode(b).setEndBefore(b);this.insertNode(c).setStartAfter(c);
return{start:a?"#"+c.id:c,end:b?a?"#"+b.id:b:null}},moveToBookmark:function(a){var b=this.doc,c=f(a.start,b),a=a.end?f(a.end,b):null;if(!c||c.length<1)return this;this.setStartBefore(c[0]);c.remove();a&&a.length>0?(this.setEndBefore(a[0]),a.remove()):this.collapse(!0);return this},dump:function(){console.log("--------------------");console.log(this.startContainer.nodeType==3?this.startContainer.nodeValue:this.startContainer,this.startOffset);console.log(this.endContainer.nodeType==3?this.endContainer.nodeValue:
this.endContainer,this.endOffset)}});f.RangeClass=L;f.range=Na;f.START_TO_START=ka;f.START_TO_END=ja;f.END_TO_END=ca;f.END_TO_START=la;E(na,{init:function(a){var b=a.doc;this.doc=b;this.win=U(b);this.sel=Oa(b);this.range=a},selection:function(a){var b=this.doc,c;c=Oa(b);var d;try{d=c.rangeCount>0?c.getRangeAt(0):c.createRange()}catch(e){}c=l&&(!d||!d.item&&d.parentElement().ownerDocument!==b)?null:d;this.sel=Oa(b);if(c)return this.range=Na(c),f(this.range.startContainer).name=="html"&&this.range.selectNodeContents(b.body).collapse(!1),
this;a&&this.range.selectNodeContents(b.body).collapse(!1);return this},select:function(a){var a=j(a,!0),b=this.sel,c=this.range.cloneRange().shrink(),d=c.startContainer,e=c.startOffset,g=T(d),h=this.win,i,k=!1;if(a&&d.nodeType==1&&c.collapsed){if(l){b=f("<span>&nbsp;</span>",g);c.insertNode(b[0]);i=g.body.createTextRange();try{i.moveToElementText(b[0])}catch(n){}i.collapse(!1);i.select();b.remove();h.focus();return this}if(W&&(a=d.childNodes,f(d).isInline()||e>0&&f(a[e-1]).isInline()||a[e]&&f(a[e]).isInline()))c.insertNode(g.createTextNode("\u200b")),
k=!0}if(l)try{i=c.get(!0),i.select()}catch(r){}else k&&c.collapse(!1),i=c.get(!0),b.removeAllRanges(),b.addRange(i),g!==document&&(c=f(i.endContainer).pos(),h.scrollTo(c.x,c.y));h.focus();return this},wrap:function(a){var b=this.range,c;c=f(a,this.doc);if(b.collapsed)return b.shrink(),b.insertNode(c[0]).selectNodeContents(c[0]),this;if(c.isBlock()){for(var d=a=c.clone(!0);d.first();)d=d.first();d.append(b.extractContents());b.insertNode(a[0]).selectNode(a[0]);return this}b.enlarge();var e=b.createBookmark(),
a=b.commonAncestor(),g=!1;f(a).scan(function(a){if(!g&&a==e.start)g=!0;else if(g){if(a==e.end)return!1;var b=f(a),d;a:{for(d=b;d&&d.name!="body";){if(Ha[d.name]||d.name=="div"&&d.hasClass("ke-script")){d=!0;break a}d=d.parent()}d=!1}if(!d&&b.type==3&&B(a.nodeValue).length>0){for(var n;(n=b.parent())&&n.isStyle()&&n.children().length==1;)b=n;n=c;n=n.clone(!0);if(b.type==3)Ra(n).append(b.clone(!1)),b.replaceWith(n);else{for(var a=b,j;(j=b.first())&&j.children().length==1;)b=j;j=b.first();for(b=b.doc.createDocumentFragment();j;)b.appendChild(j[0]),
j=j.next();j=a.clone(!0);d=Ra(j);for(var p=j,l=!1;n;){for(;p;)p.name===n.name&&(Wb(p,n.attr(),n.css()),l=!0),p=p.first();l||d.append(n.clone(!1));l=!1;n=n.first()}n=j;b.firstChild&&Ra(n).append(b);a.replaceWith(n)}}}});b.moveToBookmark(e);return this},split:function(a,b){for(var c=this.range,d=c.doc,e=c.cloneRange().collapse(a),g=e.startContainer,h=e.startOffset,i=g.nodeType==3?g.parentNode:g,k=!1,n;i&&i.parentNode;){n=f(i);if(b){if(!n.isStyle())break;if(!Pa(n,b))break}else if(Ea[n.name])break;k=
!0;i=i.parentNode}if(k)d=d.createElement("span"),c.cloneRange().collapse(!a).insertNode(d),a?e.setStartBefore(i.firstChild).setEnd(g,h):e.setStart(g,h).setEndAfter(i.lastChild),g=e.extractContents(),h=g.firstChild,k=g.lastChild,a?(e.insertNode(g),c.setStartAfter(k).setEndBefore(d)):(i.appendChild(g),c.setStartBefore(d).setEndBefore(h)),e=d.parentNode,e==c.endContainer&&(i=f(d).prev(),g=f(d).next(),i&&g&&i.type==3&&g.type==3?c.setEnd(i[0],i[0].nodeValue.length):a||c.setEnd(c.endContainer,c.endOffset-
1)),e.removeChild(d);return this},remove:function(a){var b=this.doc,c=this.range;c.enlarge();if(c.startOffset===0){for(var d=f(c.startContainer),e;(e=d.parent())&&e.isStyle()&&e.children().length==1;)d=e;c.setStart(d[0],0);d=f(c.startContainer);d.isBlock()&&Qa(d,a);(d=d.parent())&&d.isBlock()&&Qa(d,a)}if(c.collapsed){this.split(!0,a);b=c.startContainer;d=c.startOffset;if(d>0&&(e=f(b.childNodes[d-1]))&&da(e))e.remove(),c.setStart(b,d-1);(d=f(b.childNodes[d]))&&da(d)&&d.remove();da(b)&&(c.startBefore(b),
b.remove());c.collapse(!0);return this}this.split(!0,a);this.split(!1,a);var g=b.createElement("span"),h=b.createElement("span");c.cloneRange().collapse(!1).insertNode(h);c.cloneRange().collapse(!0).insertNode(g);var i=[],k=!1;f(c.commonAncestor()).scan(function(a){if(!k&&a==g)k=!0;else{if(a==h)return!1;k&&i.push(a)}});f(g).remove();f(h).remove();b=c.startContainer;d=c.startOffset;e=c.endContainer;var n=c.endOffset;if(d>0){var j=f(b.childNodes[d-1]);j&&da(j)&&(j.remove(),c.setStart(b,d-1),b==e&&c.setEnd(e,
n-1));if((d=f(b.childNodes[d]))&&da(d))d.remove(),b==e&&c.setEnd(e,n-1)}(b=f(e.childNodes[c.endOffset]))&&da(b)&&b.remove();b=c.createBookmark(!0);m(i,function(b,c){Qa(f(c),a)});c.moveToBookmark(b);return this},commonNode:function(a){function b(b){for(var c=b;b;){if(Pa(f(b),a))return f(b);b=b.parentNode}for(;c&&(c=c.lastChild);)if(Pa(f(c),a))return f(c);return null}var c=this.range,d=c.endContainer,c=c.endOffset,e=d.nodeType==3||c===0?d:d.childNodes[c-1],g=b(e);if(g)return g;if(e.nodeType==1||d.nodeType==
3&&c===0)if(d=f(e).prev())return b(d);return null},commonAncestor:function(a){function b(b){for(;b;){if(b.nodeType==1&&b.tagName.toLowerCase()===a)return b;b=b.parentNode}return null}var c=this.range,d=c.startContainer,e=c.startOffset,g=c.endContainer,c=c.endOffset,g=g.nodeType==3||c===0?g:g.childNodes[c-1],d=b(d.nodeType==3||e===0?d:d.childNodes[e-1]),e=b(g);if(d&&e&&d===e)return f(d);return null},state:function(a){var b=this.doc,c=!1;try{c=b.queryCommandState(a)}catch(d){}return c},val:function(a){var b=
this.doc,a=a.toLowerCase(),c="";if(a==="fontfamily"||a==="fontname")return c=tb(b,"fontname"),c=c.replace(/['"]/g,""),c.toLowerCase();if(a==="formatblock"){c=tb(b,a);if(c===""&&(a=this.commonNode({"h1,h2,h3,h4,h5,h6,p,div,pre,address":"*"})))c=a.name;c==="Normal"&&(c="p");return c.toLowerCase()}if(a==="fontsize")return(a=this.commonNode({"*":".font-size"}))&&(c=a.css("font-size")),c.toLowerCase();if(a==="forecolor")return(a=this.commonNode({"*":".color"}))&&(c=a.css("color")),c=va(c),c===""&&(c="default"),
c.toLowerCase();if(a==="hilitecolor")return(a=this.commonNode({"*":".background-color"}))&&(c=a.css("background-color")),c=va(c),c===""&&(c="default"),c.toLowerCase();return c},toggle:function(a,b){this.commonNode(b)?this.remove(b):this.wrap(a);return this.select()},bold:function(){return this.toggle("<strong></strong>",{span:".font-weight=bold",strong:"*",b:"*"})},italic:function(){return this.toggle("<em></em>",{span:".font-style=italic",em:"*",i:"*"})},underline:function(){return this.toggle("<u></u>",
{span:".text-decoration=underline",u:"*"})},strikethrough:function(){return this.toggle("<s></s>",{span:".text-decoration=line-through",s:"*"})},forecolor:function(a){return this.toggle('<span style="color:'+a+';"></span>',{span:".color="+a,font:"color"})},hilitecolor:function(a){return this.toggle('<span style="background-color:'+a+';"></span>',{span:".background-color="+a})},fontsize:function(a){return this.toggle('<span style="font-size:'+a+';"></span>',{span:".font-size="+a,font:"size"})},fontname:function(a){return this.fontfamily(a)},
fontfamily:function(a){return this.toggle('<span style="font-family:'+a+';"></span>',{span:".font-family="+a,font:"face"})},removeformat:function(){var a={"*":".font-weight,.font-style,.text-decoration,.color,.background-color,.font-size,.font-family,.text-indent"};m(Lb,function(b){a[b]="*"});this.remove(a);return this.select()},inserthtml:function(a,b){function c(a,b){var b='<img id="__kindeditor_temp_tag__" width="0" height="0" style="display:none;" />'+b,c=a.get();c.item?c.item(0).outerHTML=b:
c.pasteHTML(b);var d=a.doc.getElementById("__kindeditor_temp_tag__");d.parentNode.removeChild(d);c=sb(c);a.setEnd(c.endContainer,c.endOffset);a.collapse(!1);e.select(!1)}function d(a,b){var c=a.doc,d=c.createDocumentFragment();f("@"+b,c).each(function(){d.appendChild(this)});a.deleteContents();a.insertNode(d);a.collapse(!1);e.select(!1)}var e=this,g=e.range;if(a==="")return e;if(l&&b){try{c(g,a)}catch(h){d(g,a)}return e}d(g,a);return e},hr:function(){return this.inserthtml("<hr />")},print:function(){this.win.print();
return this},insertimage:function(a,b,c,d,e,g){b=j(b,"");j(e,0);a='<img src="'+C(a)+'" data-ke-src="'+C(a)+'" ';c&&(a+='width="'+C(c)+'" ');d&&(a+='height="'+C(d)+'" ');b&&(a+='title="'+C(b)+'" ');g&&(a+='align="'+C(g)+'" ');a+='alt="'+C(b)+'" ';a+="/>";return this.inserthtml(a)},createlink:function(a,b){var c=this.doc,d=this.range;this.select();var e=this.commonNode({a:"*"});e&&!d.isControl()&&(d.selectNode(e.get()),this.select());e='<a href="'+C(a)+'" data-ke-src="'+C(a)+'" ';b&&(e+=' target="'+
C(b)+'"');if(d.collapsed)return e+=">"+C(a)+"</a>",this.inserthtml(e);if(d.isControl()){var g=f(d.startContainer.childNodes[d.startOffset]);e+="></a>";g.after(f(e,c));g.next().append(g);d.selectNode(g[0]);return this.select()}P(c,"createlink","__kindeditor_temp_url__");f('a[href="__kindeditor_temp_url__"]',c).each(function(){f(this).attr("href",a).attr("data-ke-src",a);b?f(this).attr("target",b):f(this).removeAttr("target")});return this},unlink:function(){var a=this.doc,b=this.range;this.select();
if(b.collapsed){var c=this.commonNode({a:"*"});c&&(b.selectNode(c.get()),this.select());P(a,"unlink",null);W&&f(b.startContainer).name==="img"&&(a=f(b.startContainer).parent(),a.name==="a"&&a.remove(!0))}else P(a,"unlink",null);return this}});m("formatblock,selectall,justifyleft,justifycenter,justifyright,justifyfull,insertorderedlist,insertunorderedlist,indent,outdent,subscript,superscript".split(","),function(a,b){na.prototype[b]=function(a){this.select();P(this.doc,b,a);(!l||N(b,"formatblock,selectall,insertorderedlist,insertunorderedlist".split(","))>=
0)&&this.selection();return this}});m("cut,copy,paste".split(","),function(a,b){na.prototype[b]=function(){if(!this.doc.queryCommandSupported(b))throw"not supported";this.select();P(this.doc,b,null);return this}});f.CmdClass=na;f.cmd=xb;E(R,{init:function(a){var b=this;b.name=a.name||"";b.doc=a.doc||document;b.win=U(b.doc);b.x=s(a.x);b.y=s(a.y);b.z=a.z;b.width=s(a.width);b.height=s(a.height);b.div=f('<div style="display:block;"></div>');b.options=a;b._alignEl=a.alignEl;b.width&&b.div.css("width",
b.width);b.height&&b.div.css("height",b.height);b.z&&b.div.css({position:"absolute",left:b.x,top:b.y,"z-index":b.z});b.z&&(b.x===o||b.y===o)&&b.autoPos(b.width,b.height);a.cls&&b.div.addClass(a.cls);a.shadowMode&&b.div.addClass("ke-shadow");a.css&&b.div.css(a.css);a.src?f(a.src).replaceWith(b.div):f(b.doc.body).append(b.div);a.html&&b.div.html(a.html);if(a.autoScroll)if(l&&z<7||O){var c=ba();f(b.win).bind("scroll",function(){var a=ba(),e=a.x-c.x,a=a.y-c.y;b.pos(t(b.x)+e,t(b.y)+a,!1)})}else b.div.css("position",
"fixed")},pos:function(a,b,c){c=j(c,!0);if(a!==null&&(a=a<0?0:s(a),this.div.css("left",a),c))this.x=a;if(b!==null&&(b=b<0?0:s(b),this.div.css("top",b),c))this.y=b;return this},autoPos:function(a,b){var c=t(a)||0,d=t(b)||0,e=ba();if(this._alignEl){var g=f(this._alignEl),h=g.pos(),c=Q(g[0].clientWidth/2-c/2),d=Q(g[0].clientHeight/2-d/2);x=c<0?h.x:h.x+c;y=d<0?h.y:h.y+d}else h=G(this.doc),x=Q(e.x+(h.clientWidth-c)/2),y=Q(e.y+(h.clientHeight-d)/2);l&&z<7||O||(x-=e.x,y-=e.y);return this.pos(x,y)},remove:function(){var a=
this;(l&&z<7||O)&&f(a.win).unbind("scroll");a.div.remove();m(a,function(b){a[b]=null});return this},show:function(){this.div.show();return this},hide:function(){this.div.hide();return this},draggable:function(a){var b=this,a=a||{};a.moveEl=b.div;a.moveFn=function(a,d,e,g,f,i){if((a+=f)<0)a=0;if((d+=i)<0)d=0;b.pos(a,d)};Sa(a);return b}});f.WidgetClass=R;f.widget=Ua;var Va="";if(q=document.getElementsByTagName("html"))Va=q[0].dir;E(pa,R,{init:function(a){function b(){var b=Ta(c.iframe);b.open();if(i)b.domain=
document.domain;b.write(Xb(d,e,g,h));b.close();c.win=c.iframe[0].contentWindow;c.doc=b;var k=xb(b);c.afterChange(function(){k.selection()});W&&f(b).click(function(a){f(a.target).name==="img"&&(k.selection(!0),k.range.selectNode(a.target),k.select())});if(l)c._mousedownHandler=function(){var a=k.range.cloneRange();a.shrink();a.isControl()&&c.blur()},f(document).mousedown(c._mousedownHandler),f(b).keydown(function(a){if(a.which==8){k.selection();var b=k.range;b.isControl()&&(b.collapse(!0),f(b.startContainer.childNodes[b.startOffset]).remove(),
a.preventDefault())}});c.cmd=k;c.html(oa(c.srcElement));l?(b.body.disabled=!0,b.body.contentEditable=!0,b.body.removeAttribute("disabled")):b.designMode="on";a.afterCreate&&a.afterCreate.call(c)}var c=this;pa.parent.init.call(c,a);c.srcElement=f(a.srcElement);c.div.addClass("ke-edit");c.designMode=j(a.designMode,!0);c.beforeGetHtml=a.beforeGetHtml;c.beforeSetHtml=a.beforeSetHtml;c.afterSetHtml=a.afterSetHtml;var d=j(a.themesPath,""),e=a.bodyClass,g=a.cssPath,h=a.cssData,i=location.host.replace(/:\d+/,
"")!==document.domain,k="document.open();"+(i?'document.domain="'+document.domain+'";':"")+"document.close();",k=l?' src="javascript:void(function(){'+encodeURIComponent(k)+'}())"':"";c.iframe=f('<iframe class="ke-edit-iframe" hidefocus="true" frameborder="0"'+k+"></iframe>").css("width","100%");c.textarea=f('<textarea class="ke-edit-textarea" hidefocus="true"></textarea>').css("width","100%");c.width&&c.setWidth(c.width);c.height&&c.setHeight(c.height);c.designMode?c.textarea.hide():c.iframe.hide();
i&&c.iframe.bind("load",function(){c.iframe.unbind("load");l?b():setTimeout(b,0)});c.div.append(c.iframe);c.div.append(c.textarea);c.srcElement.hide();!i&&b()},setWidth:function(a){this.div.css("width",s(a));return this},setHeight:function(a){a=s(a);this.div.css("height",a);this.iframe.css("height",a);if(l&&z<8||O)a=s(t(a)-2);this.textarea.css("height",a);return this},remove:function(){var a=this.doc;f(a.body).unbind();f(a).unbind();f(this.win).unbind();this._mousedownHandler&&f(document).unbind("mousedown",
this._mousedownHandler);oa(this.srcElement,this.html());this.srcElement.show();a.write("");this.iframe.unbind();this.textarea.unbind();pa.parent.remove.call(this)},html:function(a,b){var c=this.doc;if(this.designMode){c=c.body;if(a===o)return a=b?"<!doctype html><html>"+c.parentNode.innerHTML+"</html>":c.innerHTML,this.beforeGetHtml&&(a=this.beforeGetHtml(a)),ea&&a=="<br />"&&(a=""),a;this.beforeSetHtml&&(a=this.beforeSetHtml(a));l&&z>=9&&(a=a.replace(/(<.*?checked=")checked(".*>)/ig,"$1$2"));f(c).html(a);
this.afterSetHtml&&this.afterSetHtml();return this}if(a===o)return this.textarea.val();this.textarea.val(a);return this},design:function(a){if(a===o?!this.designMode:a){if(!this.designMode)a=this.html(),this.designMode=!0,this.html(a),this.textarea.hide(),this.iframe.show()}else if(this.designMode)a=this.html(),this.designMode=!1,this.html(a),this.iframe.hide(),this.textarea.show();return this.focus()},focus:function(){this.designMode?this.win.focus():this.textarea[0].focus();return this},blur:function(){if(l){var a=
f('<input type="text" style="float:left;width:0;height:0;padding:0;margin:0;border:0;" value="" />',this.div);this.div.append(a);a[0].focus();a.remove()}else this.designMode?this.win.blur():this.textarea[0].blur();return this},afterChange:function(a){function b(b){setTimeout(function(){a(b)},1)}var c=this.doc,d=c.body;f(c).keyup(function(b){!b.ctrlKey&&!b.altKey&&ab[b.which]&&a(b)});f(c).mouseup(a).contextmenu(a);f(this.win).blur(a);f(d).bind("paste",b);f(d).bind("cut",b);return this}});f.EditClass=
pa;f.edit=yb;f.iframeDoc=Ta;E(Aa,R,{init:function(a){function b(a){a=f(a);if(a.hasClass("ke-outline"))return a;if(a.hasClass("ke-toolbar-icon"))return a.parent()}function c(a,c){var d=b(a.target);if(d&&!d.hasClass("ke-disabled")&&!d.hasClass("ke-selected"))d[c]("ke-on")}var d=this;Aa.parent.init.call(d,a);d.disableMode=j(a.disableMode,!1);d.noDisableItemMap=u(j(a.noDisableItems,[]));d._itemMap={};d.div.addClass("ke-toolbar").bind("contextmenu,mousedown,mousemove",function(a){a.preventDefault()}).attr("unselectable",
"on");d.div.mouseover(function(a){c(a,"addClass")}).mouseout(function(a){c(a,"removeClass")}).click(function(a){var c=b(a.target);c&&!c.hasClass("ke-disabled")&&d.options.click.call(this,a,c.attr("data-name"))})},get:function(a){if(this._itemMap[a])return this._itemMap[a];return this._itemMap[a]=f("span.ke-icon-"+a,this.div).parent()},select:function(a){zb.call(this,a,function(a){a.addClass("ke-selected")});return self},unselect:function(a){zb.call(this,a,function(a){a.removeClass("ke-selected").removeClass("ke-on")});
return self},enable:function(a){if(a=a.get?a:this.get(a))a.removeClass("ke-disabled"),a.opacity(1);return this},disable:function(a){if(a=a.get?a:this.get(a))a.removeClass("ke-selected").addClass("ke-disabled"),a.opacity(0.5);return this},disableAll:function(a,b){var c=this,d=c.noDisableItemMap;b&&(d=u(b));(a===o?!c.disableMode:a)?(f("span.ke-outline",c.div).each(function(){var a=f(this),b=a[0].getAttribute("data-name",2);d[b]||c.disable(a)}),c.disableMode=!0):(f("span.ke-outline",c.div).each(function(){var a=
f(this),b=a[0].getAttribute("data-name",2);d[b]||c.enable(a)}),c.disableMode=!1);return c}});f.ToolbarClass=Aa;f.toolbar=Ab;E(qa,R,{init:function(a){a.z=a.z||811213;qa.parent.init.call(this,a);this.centerLineMode=j(a.centerLineMode,!0);this.div.addClass("ke-menu").bind("click,mousedown",function(a){a.stopPropagation()}).attr("unselectable","on")},addItem:function(a){if(a.title==="-")this.div.append(f('<div class="ke-menu-separator"></div>'));else{var b=f('<div class="ke-menu-item" unselectable="on"></div>'),
c=f('<div class="ke-inline-block ke-menu-item-left"></div>'),d=f('<div class="ke-inline-block ke-menu-item-right"></div>'),e=s(a.height),g=j(a.iconClass,"");this.div.append(b);e&&(b.css("height",e),d.css("line-height",e));var h;this.centerLineMode&&(h=f('<div class="ke-inline-block ke-menu-item-center"></div>'),e&&h.css("height",e));b.mouseover(function(){f(this).addClass("ke-menu-item-on");h&&h.addClass("ke-menu-item-center-on")}).mouseout(function(){f(this).removeClass("ke-menu-item-on");h&&h.removeClass("ke-menu-item-center-on")}).click(function(b){a.click.call(f(this));
b.stopPropagation()}).append(c);h&&b.append(h);b.append(d);a.checked&&(g="ke-icon-checked");g!==""&&c.html('<span class="ke-inline-block ke-toolbar-icon ke-toolbar-icon-url '+g+'"></span>');d.html(a.title);return this}},remove:function(){this.options.beforeRemove&&this.options.beforeRemove.call(this);f(".ke-menu-item",this.div[0]).unbind();qa.parent.remove.call(this);return this}});f.MenuClass=qa;f.menu=Wa;E(ra,R,{init:function(a){a.z=a.z||811213;ra.parent.init.call(this,a);var b=a.colors||[["#E53333",
"#E56600","#FF9900","#64451D","#DFC5A4","#FFE500"],["#009900","#006600","#99BB00","#B8D100","#60D978","#00D5FF"],["#337FE5","#003399","#4C33E5","#9933E5","#CC33E5","#EE33EE"],["#FFFFFF","#CCCCCC","#999999","#666666","#333333","#000000"]];this.selectedColor=(a.selectedColor||"").toLowerCase();this._cells=[];this.div.addClass("ke-colorpicker").bind("click,mousedown",function(a){a.stopPropagation()}).attr("unselectable","on");a=this.doc.createElement("table");this.div.append(a);a.className="ke-colorpicker-table";
a.cellPadding=0;a.cellSpacing=0;a.border=0;var c=a.insertRow(0),d=c.insertCell(0);d.colSpan=b[0].length;this._addAttr(d,"","ke-colorpicker-cell-top");for(var e=0;e<b.length;e++)for(var c=a.insertRow(e+1),g=0;g<b[e].length;g++)d=c.insertCell(g),this._addAttr(d,b[e][g],"ke-colorpicker-cell")},_addAttr:function(a,b,c){var d=this,a=f(a).addClass(c);d.selectedColor===b.toLowerCase()&&a.addClass("ke-colorpicker-cell-selected");a.attr("title",b||d.options.noColor);a.mouseover(function(){f(this).addClass("ke-colorpicker-cell-on")});
a.mouseout(function(){f(this).removeClass("ke-colorpicker-cell-on")});a.click(function(a){a.stop();d.options.click.call(f(this),b)});b?a.append(f('<div class="ke-colorpicker-cell-color" unselectable="on"></div>').css("background-color",b)):a.html(d.options.noColor);f(a).attr("unselectable","on");d._cells.push(a)},remove:function(){m(this._cells,function(){this.unbind()});ra.parent.remove.call(this);return this}});f.ColorPickerClass=ra;f.colorpicker=Bb;E(Xa,{init:function(a){var b=f(a.button),c=a.fieldName||
"file",d=a.url||"",e=b.val(),g=a.extraParams||{},h=b[0].className||"",i=a.target||"kindeditor_upload_iframe_"+(new Date).getTime();a.afterError=a.afterError||function(a){alert(a)};var k=[],j;for(j in g)k.push('<input type="hidden" name="'+j+'" value="'+g[j]+'" />');c=['<div class="ke-inline-block '+h+'">',a.target?"":'<iframe name="'+i+'" style="display:none;"></iframe>',a.form?'<div class="ke-upload-area">':'<form class="ke-upload-area ke-form" method="post" enctype="multipart/form-data" target="'+
i+'" action="'+d+'">','<span class="ke-button-common">',k.join(""),'<input type="button" class="ke-button-common ke-button" value="'+e+'" />',"</span>",'<input type="file" class="ke-upload-file" name="'+c+'" tabindex="-1" />',a.form?"</div>":"</form>","</div>"].join("");c=f(c,b.doc);b.hide();b.before(c);this.div=c;this.button=b;this.iframe=a.target?f('iframe[name="'+i+'"]'):f("iframe",c);this.form=a.form?f(a.form):f("form",c);b=a.width||f(".ke-button-common",c).width();this.fileBox=f(".ke-upload-file",
c).width(b);this.options=a},submit:function(){var a=this,b=a.iframe;b.bind("load",function(){b.unbind();var c=document.createElement("form");a.fileBox.before(c);f(c).append(a.fileBox);c.reset();f(c).remove(!0);var c=f.iframeDoc(b),d=c.getElementsByTagName("pre")[0],e="",g,e=d?d.innerHTML:c.body.innerHTML,e=fa(e);b[0].src="javascript:false";try{g=f.json(e)}catch(h){a.options.afterError.call(a,"<!doctype html><html>"+c.body.parentNode.innerHTML+"</html>")}g&&a.options.afterUpload.call(a,g)});a.form[0].submit();
return a},remove:function(){this.fileBox&&this.fileBox.unbind();this.iframe.remove();this.div.remove();this.button.show();return this}});f.UploadButtonClass=Xa;f.uploadbutton=function(a){return new Xa(a)};E(sa,R,{init:function(a){var b=j(a.shadowMode,!0);a.z=a.z||811213;a.shadowMode=!1;a.autoScroll=j(a.autoScroll,!0);sa.parent.init.call(this,a);var c=a.title,d=f(a.body,this.doc),e=a.previewBtn,g=a.yesBtn,h=a.noBtn,i=a.closeBtn,k=j(a.showMask,!0);this.div.addClass("ke-dialog").bind("click,mousedown",
function(a){a.stopPropagation()});var n=f('<div class="ke-dialog-content"></div>').appendTo(this.div);l&&z<7?this.iframeMask=f('<iframe src="about:blank" class="ke-dialog-shadow"></iframe>').appendTo(this.div):b&&f('<div class="ke-dialog-shadow"></div>').appendTo(this.div);b=f('<div class="ke-dialog-header"></div>');n.append(b);b.html(c);this.closeIcon=f('<span class="ke-dialog-icon-close" title="'+i.name+'"></span>').click(i.click);b.append(this.closeIcon);this.draggable({clickEl:b,beforeDrag:a.beforeDrag});
a=f('<div class="ke-dialog-body"></div>');n.append(a);a.append(d);var o=f('<div class="ke-dialog-footer"></div>');(e||g||h)&&n.append(o);m([{btn:e,name:"preview"},{btn:g,name:"yes"},{btn:h,name:"no"}],function(){if(this.btn){var a=this.btn,a=a||{},b=a.name||"",c=f('<span class="ke-button-common ke-button-outer" title="'+b+'"></span>'),b=f('<input class="ke-button-common ke-button" type="button" value="'+b+'" />');a.click&&b.click(a.click);c.append(b);c.addClass("ke-dialog-"+this.name);o.append(c)}});
this.height&&a.height(t(this.height)-b.height()-o.height());this.div.width(this.div.width());this.div.height(this.div.height());this.mask=null;if(k)d=G(this.doc),this.mask=Ua({x:0,y:0,z:this.z-1,cls:"ke-dialog-mask",width:Math.max(d.scrollWidth,d.clientWidth),height:Math.max(d.scrollHeight,d.clientHeight)});this.autoPos(this.div.width(),this.div.height());this.footerDiv=o;this.bodyDiv=a;this.headerDiv=b;this.isLoading=!1},setMaskIndex:function(a){this.mask.div.css("z-index",a)},showLoading:function(a){var a=
j(a,""),b=this.bodyDiv;this.loading=f('<div class="ke-dialog-loading"><div class="ke-inline-block ke-dialog-loading-content" style="margin-top:'+Math.round(b.height()/3)+'px;">'+a+"</div></div>").width(b.width()).height(b.height()).css("top",this.headerDiv.height()+"px");b.css("visibility","hidden").after(this.loading);this.isLoading=!0;return this},hideLoading:function(){this.loading&&this.loading.remove();this.bodyDiv.css("visibility","visible");this.isLoading=!1;return this},remove:function(){this.options.beforeRemove&&
this.options.beforeRemove.call(this);this.mask&&this.mask.remove();this.iframeMask&&this.iframeMask.remove();this.closeIcon.unbind();f("input",this.div).unbind();f("button",this.div).unbind();this.footerDiv.unbind();this.bodyDiv.unbind();this.headerDiv.unbind();f("iframe",this.div).each(function(){f(this).remove()});sa.parent.remove.call(this);return this}});f.DialogClass=sa;f.dialog=Cb;f.tabs=function(a){var b=Ua(a),c=b.remove,d=a.afterSelect,a=b.div,e=[];a.addClass("ke-tabs").bind("contextmenu,mousedown,mousemove",
function(a){a.preventDefault()});var g=f('<ul class="ke-tabs-ul ke-clearfix"></ul>');a.append(g);b.add=function(a){var b=f('<li class="ke-tabs-li">'+a.title+"</li>");b.data("tab",a);e.push(b);g.append(b)};b.selectedIndex=0;b.select=function(a){b.selectedIndex=a;m(e,function(c,d){d.unbind();c===a?(d.addClass("ke-tabs-li-selected"),f(d.data("tab").panel).show("")):(d.removeClass("ke-tabs-li-selected").removeClass("ke-tabs-li-on").mouseover(function(){f(this).addClass("ke-tabs-li-on")}).mouseout(function(){f(this).removeClass("ke-tabs-li-on")}).click(function(){b.select(c)}),
f(d.data("tab").panel).hide())});d&&d.call(b,a)};b.remove=function(){m(e,function(){this.remove()});g.remove();c.call(b)};return b};f.loadScript=Ya;f.loadStyle=Za;f.ajax=function(a,b,c,d,e){var c=c||"GET",e=e||"json",g=A.XMLHttpRequest?new A.XMLHttpRequest:new ActiveXObject("Microsoft.XMLHTTP");g.open(c,a,!0);g.onreadystatechange=function(){if(g.readyState==4&&g.status==200&&b){var a=B(g.responseText);e=="json"&&(a=cb(a));b(a)}};if(c=="POST"){var f=[];m(d,function(a,b){f.push(encodeURIComponent(a)+
"="+encodeURIComponent(b))});try{g.setRequestHeader("Content-Type","application/x-www-form-urlencoded")}catch(i){}g.send(f.join("&"))}else g.send(null)};var V={},M={};ta.prototype={lang:function(a){return Gb(a,this.langType)},loadPlugin:function(a,b){var c=this;if(V[a]){if(c._calledPlugins[a])return b&&b.call(c),c;V[a].call(c,KindEditor);b&&b.call(c);c._calledPlugins[a]=!0;return c}if(c.isLoading)return c;c.isLoading=!0;Ya(c.pluginsPath+a+"/"+a+".js?ver="+encodeURIComponent(f.DEBUG?Ca:Da),function(){c.isLoading=
!1;V[a]&&c.loadPlugin(a,b)});return c},handler:function(a,b){var c=this;c._handlers[a]||(c._handlers[a]=[]);if(bb(b))return c._handlers[a].push(b),c;m(c._handlers[a],function(){b=this.call(c,b)});return b},clickToolbar:function(a,b){var c=this,d="clickToolbar"+a;if(b===o){if(c._handlers[d])return c.handler(d);c.loadPlugin(a,function(){c.handler(d)});return c}return c.handler(d,b)},updateState:function(){var a=this;m("justifyleft,justifycenter,justifyright,justifyfull,insertorderedlist,insertunorderedlist,subscript,superscript,bold,italic,underline,strikethrough".split(","),
function(b,c){a.cmd.state(c)?a.toolbar.select(c):a.toolbar.unselect(c)});return a},addContextmenu:function(a){this._contextmenus.push(a);return this},afterCreate:function(a){return this.handler("afterCreate",a)},beforeRemove:function(a){return this.handler("beforeRemove",a)},beforeGetHtml:function(a){return this.handler("beforeGetHtml",a)},beforeSetHtml:function(a){return this.handler("beforeSetHtml",a)},afterSetHtml:function(a){return this.handler("afterSetHtml",a)},create:function(){function a(){k.height()===
0?setTimeout(a,100):b.resize(d,e,!1)}var b=this,c=b.fullscreenMode;if(b.isCreated)return b;if(b.srcElement.data("kindeditor"))return b;b.srcElement.data("kindeditor","true");c?G().style.overflow="hidden":G().style.overflow="";var d=c?G().clientWidth+"px":b.width,e=c?G().clientHeight+"px":b.height;if(l&&z<8||O)e=s(t(e)+2);var g=b.container=f(b.layout);c?f(document.body).append(g):b.srcElement.before(g);var h=f(".toolbar",g),i=f(".edit",g),k=b.statusbar=f(".statusbar",g);g.removeClass("container").addClass("ke-container ke-container-"+
b.themeType).css("width",d);if(c){g.css({position:"absolute",left:0,top:0,"z-index":811211});if(!ea)b._scrollPos=ba();A.scrollTo(0,0);f(document.body).css({height:"1px",overflow:"hidden"});f(document.body.parentNode).css("overflow","hidden");b._fullscreenExecuted=!0}else b._fullscreenExecuted&&(f(document.body).css({height:"",overflow:""}),f(document.body.parentNode).css("overflow","")),b._scrollPos&&A.scrollTo(b._scrollPos.x,b._scrollPos.y);var j=[];f.each(b.items,function(a,c){c=="|"?j.push('<span class="ke-inline-block ke-separator"></span>'):
c=="/"?j.push('<div class="ke-hr"></div>'):(j.push('<span class="ke-outline" data-name="'+c+'" title="'+b.lang(c)+'" unselectable="on">'),j.push('<span class="ke-toolbar-icon ke-toolbar-icon-url ke-icon-'+c+'" unselectable="on"></span></span>'))});var h=b.toolbar=Ab({src:h,html:j.join(""),noDisableItems:b.noDisableItems,click:function(a,c){a.stop();if(b.menu){var d=b.menu.name;b.hideMenu();if(d===c)return}b.clickToolbar(c)}}),m=t(e)-h.div.height(),p=b.edit=yb({height:m>0&&t(e)>b.minHeight?m:b.minHeight,
src:i,srcElement:b.srcElement,designMode:b.designMode,themesPath:b.themesPath,bodyClass:b.bodyClass,cssPath:b.cssPath,cssData:b.cssData,beforeGetHtml:function(a){a=b.beforeGetHtml(a);return S(a,b.filterMode?b.htmlTags:null,b.urlType,b.wellFormatMode,b.indentChar)},beforeSetHtml:function(a){a=S(a,b.filterMode?b.htmlTags:null,"",!1);return b.beforeSetHtml(a)},afterSetHtml:function(){b.edit=p=this;b.afterSetHtml()},afterCreate:function(){b.edit=p=this;b.cmd=p.cmd;b._docMousedownFn=function(){b.menu&&
b.hideMenu()};f(p.doc,document).mousedown(b._docMousedownFn);Yb.call(b);Zb.call(b);$b.call(b);ac.call(b);p.afterChange(function(){p.designMode&&(b.updateState(),b.addBookmark(),b.options.afterChange&&b.options.afterChange.call(b))});p.textarea.keyup(function(a){!a.ctrlKey&&!a.altKey&&Nb[a.which]&&b.options.afterChange&&b.options.afterChange.call(b)});b.readonlyMode&&b.readonly();b.isCreated=!0;if(b.initContent==="")b.initContent=b.html();b.afterCreate();b.options.afterCreate&&b.options.afterCreate.call(b)}});
k.removeClass("statusbar").addClass("ke-statusbar").append('<span class="ke-inline-block ke-statusbar-center-icon"></span>').append('<span class="ke-inline-block ke-statusbar-right-icon"></span>');if(b._fullscreenResizeHandler)f(A).unbind("resize",b._fullscreenResizeHandler),b._fullscreenResizeHandler=null;a();c?(b._fullscreenResizeHandler=function(){b.isCreated&&b.resize(G().clientWidth,G().clientHeight,!1)},f(A).bind("resize",b._fullscreenResizeHandler),h.select("fullscreen"),k.first().css("visibility",
"hidden"),k.last().css("visibility","hidden")):(ea&&f(A).bind("scroll",function(){b._scrollPos=ba()}),b.resizeType>0?Sa({moveEl:g,clickEl:k,moveFn:function(a,c,d,e,g,f){e+=f;b.resize(null,e)}}):k.first().css("visibility","hidden"),b.resizeType===2?Sa({moveEl:g,clickEl:k.last(),moveFn:function(a,c,d,e,g,f){d+=g;e+=f;b.resize(d,e)}}):k.last().css("visibility","hidden"));return b},remove:function(){var a=this;if(!a.isCreated)return a;a.beforeRemove();a.srcElement.data("kindeditor","");a.menu&&a.hideMenu();
m(a.dialogs,function(){a.hideDialog()});f(document).unbind("mousedown",a._docMousedownFn);a.toolbar.remove();a.edit.remove();a.statusbar.last().unbind();a.statusbar.unbind();a.container.remove();a.container=a.toolbar=a.edit=a.menu=null;a.dialogs=[];a.isCreated=!1;return a},resize:function(a,b,c){c=j(c,!0);if(a&&(/%/.test(a)||(a=t(a),a=a<this.minWidth?this.minWidth:a),this.container.css("width",s(a)),c))this.width=s(a);if(b&&(b=t(b),editHeight=t(b)-this.toolbar.div.height()-this.statusbar.height(),
editHeight=editHeight<this.minHeight?this.minHeight:editHeight,this.edit.setHeight(editHeight),c))this.height=s(b);return this},select:function(){this.isCreated&&this.cmd.select();return this},html:function(a){if(a===o)return this.isCreated?this.edit.html():oa(this.srcElement);this.isCreated?this.edit.html(a):oa(this.srcElement,a);this.isCreated&&this.cmd.selection();return this},fullHtml:function(){return this.isCreated?this.edit.html(o,!0):""},text:function(a){return a===o?B(this.html().replace(/<(?!img|embed).*?>/ig,
"").replace(/&nbsp;/ig," ")):this.html(C(a))},isEmpty:function(){return B(this.text().replace(/\r\n|\n|\r/,""))===""},isDirty:function(){return B(this.initContent.replace(/\r\n|\n|\r|t/g,""))!==B(this.html().replace(/\r\n|\n|\r|t/g,""))},selectedHtml:function(){return this.isCreated?this.cmd.range.html():""},count:function(a){a=(a||"html").toLowerCase();if(a==="html")return X($a(this.html())).length;if(a==="text")return this.text().replace(/<(?:img|embed).*?>/ig,"K").replace(/\r\n|\n|\r/g,"").length;
return 0},exec:function(a){var a=a.toLowerCase(),b=this.cmd,c=N(a,"selectall,copy,paste,print".split(","))<0;c&&this.addBookmark(!1);b[a].apply(b,Fa(arguments,1));c&&(this.updateState(),this.addBookmark(!1),this.options.afterChange&&this.options.afterChange.call(this));return this},insertHtml:function(a,b){if(!this.isCreated)return this;a=this.beforeSetHtml(a);this.exec("inserthtml",a,b);return this},appendHtml:function(a){this.html(this.html()+a);if(this.isCreated)a=this.cmd,a.range.selectNodeContents(a.doc.body).collapse(!1),
a.select();return this},sync:function(){oa(this.srcElement,this.html());return this},focus:function(){this.isCreated?this.edit.focus():this.srcElement[0].focus();return this},blur:function(){this.isCreated?this.edit.blur():this.srcElement[0].blur();return this},addBookmark:function(a){var a=j(a,!0),b=this.edit,c=b.doc.body,d=$a(c.innerHTML);if(a&&this._undoStack.length>0&&Math.abs(d.length-X(this._undoStack[this._undoStack.length-1].html).length)<this.minChangeSize)return this;b.designMode&&!this._firstAddBookmark?
(b=this.cmd.range,a=b.createBookmark(!0),a.html=$a(c.innerHTML),b.moveToBookmark(a)):a={html:d};this._firstAddBookmark=!1;Hb(this._undoStack,a);return this},undo:function(){return Ib.call(this,this._undoStack,this._redoStack)},redo:function(){return Ib.call(this,this._redoStack,this._undoStack)},fullscreen:function(a){this.fullscreenMode=a===o?!this.fullscreenMode:a;return this.remove().create()},readonly:function(a){var a=j(a,!0),b=this,c=b.edit,d=c.doc;b.designMode?b.toolbar.disableAll(a,[]):m(b.noDisableItems,
function(){b.toolbar[a?"disable":"enable"](this)});l?d.body.contentEditable=!a:d.designMode=a?"off":"on";c.textarea[0].disabled=a},createMenu:function(a){var b=this.toolbar.get(a.name),c=b.pos();a.x=c.x;a.y=c.y+b.height();a.z=this.options.zIndex;a.shadowMode=j(a.shadowMode,this.shadowMode);a.selectedColor!==o?(a.cls="ke-colorpicker-"+this.themeType,a.noColor=this.lang("noColor"),this.menu=Bb(a)):(a.cls="ke-menu-"+this.themeType,a.centerLineMode=!1,this.menu=Wa(a));return this.menu},hideMenu:function(){this.menu.remove();
this.menu=null;return this},hideContextmenu:function(){this.contextmenu.remove();this.contextmenu=null;return this},createDialog:function(a){var b=this;a.z=b.options.zIndex;a.shadowMode=j(a.shadowMode,b.shadowMode);a.closeBtn=j(a.closeBtn,{name:b.lang("close"),click:function(){b.hideDialog();l&&b.cmd&&b.cmd.select()}});a.noBtn=j(a.noBtn,{name:b.lang(a.yesBtn?"no":"close"),click:function(){b.hideDialog();l&&b.cmd&&b.cmd.select()}});if(b.dialogAlignType!="page")a.alignEl=b.container;a.cls="ke-dialog-"+
b.themeType;if(b.dialogs.length>0){var c=b.dialogs[b.dialogs.length-1];b.dialogs[0].setMaskIndex(c.z+2);a.z=c.z+3;a.showMask=!1}a=Cb(a);b.dialogs.push(a);return a},hideDialog:function(){this.dialogs.length>0&&this.dialogs.pop().remove();this.dialogs.length>0&&this.dialogs[0].setMaskIndex(this.dialogs[this.dialogs.length-1].z-1);return this},errorDialog:function(a){var b=this.createDialog({width:750,title:this.lang("uploadError"),body:'<div style="padding:10px 20px;"><iframe frameborder="0" style="width:708px;height:400px;"></iframe></div>'}),
b=f("iframe",b.div),c=f.iframeDoc(b);c.open();c.write(a);c.close();f(c.body).css("background-color","#FFF");b[0].contentWindow.focus();return this}};_instances=[];f.remove=function(a){Kb(a,function(a){this.remove();_instances.splice(a,1)})};f.sync=function(a){Kb(a,function(){this.sync()})};l&&z<7&&P(document,"BackgroundImageCache",!0);f.EditorClass=ta;f.editor=function(a){return new ta(a)};f.create=Jb;f.instances=_instances;f.plugin=Eb;f.lang=Gb;Eb("core",function(a){var b=this,c={undo:"Z",redo:"Y",
bold:"B",italic:"I",underline:"U",print:"P",selectall:"A"};b.afterSetHtml(function(){b.options.afterChange&&b.options.afterChange.call(b)});b.afterCreate(function(){if(b.syncType=="form"){for(var c=a(b.srcElement),d=!1;c=c.parent();)if(c.name=="form"){d=!0;break}if(d){c.bind("submit",function(){b.sync();a(A).bind("unload",function(){b.edit.textarea.remove()})});var f=a('[type="reset"]',c);f.click(function(){b.html(b.initContent);b.cmd.selection()});b.beforeRemove(function(){c.unbind();f.unbind()})}}});
b.clickToolbar("source",function(){b.edit.designMode?(b.toolbar.disableAll(!0),b.edit.design(!1),b.toolbar.select("source")):(b.toolbar.disableAll(!1),b.edit.design(!0),b.toolbar.unselect("source"),b.cmd.selection());b.designMode=b.edit.designMode});b.afterCreate(function(){b.designMode||b.toolbar.disableAll(!0).select("source")});b.clickToolbar("fullscreen",function(){b.fullscreen()});if(b.fullscreenShortcut){var d=!1;b.afterCreate(function(){a(b.edit.doc,b.edit.textarea).keyup(function(a){a.which==
27&&setTimeout(function(){b.fullscreen()},0)});if(d){if(l&&!b.designMode)return;b.focus()}d||(d=!0)})}m("undo,redo".split(","),function(a,d){c[d]&&b.afterCreate(function(){Ga(this.edit.doc,c[d],function(){b.clickToolbar(d)})});b.clickToolbar(d,function(){b[d]()})});b.clickToolbar("formatblock",function(){var a=b.lang("formatblock.formatBlock"),c={h1:28,h2:24,h3:18,H4:14,p:12},d=b.cmd.val("formatblock"),f=b.createMenu({name:"formatblock",width:b.langType=="en"?200:150});m(a,function(a,e){var j="font-size:"+
c[a]+"px;";a.charAt(0)==="h"&&(j+="font-weight:bold;");f.addItem({title:'<span style="'+j+'" unselectable="on">'+e+"</span>",height:c[a]+12,checked:d===a||d===e,click:function(){b.select().exec("formatblock","<"+a+">").hideMenu()}})})});b.clickToolbar("fontname",function(){var a=b.cmd.val("fontname"),c=b.createMenu({name:"fontname",width:150});m(b.lang("fontname.fontName"),function(d,f){c.addItem({title:'<span style="font-family: '+d+';" unselectable="on">'+f+"</span>",checked:a===d.toLowerCase()||
a===f.toLowerCase(),click:function(){b.exec("fontname",d).hideMenu()}})})});b.clickToolbar("fontsize",function(){var a=b.cmd.val("fontsize"),c=b.createMenu({name:"fontsize",width:150});m(b.fontSizeTable,function(d,f){c.addItem({title:'<span style="font-size:'+f+';" unselectable="on">'+f+"</span>",height:t(f)+12,checked:a===f,click:function(){b.exec("fontsize",f).hideMenu()}})})});m("forecolor,hilitecolor".split(","),function(a,c){b.clickToolbar(c,function(){b.createMenu({name:c,selectedColor:b.cmd.val(c)||
"default",colors:b.colorTable,click:function(a){b.exec(c,a).hideMenu()}})})});m("cut,copy,paste".split(","),function(a,c){b.clickToolbar(c,function(){b.focus();try{b.exec(c,null)}catch(a){alert(b.lang(c+"Error"))}})});b.clickToolbar("about",function(){var a='<div style="margin:20px;"><div>KindEditor '+Da+'</div><div>Copyright &copy; <a href="http://www.kindsoft.net/" target="_blank">kindsoft.net</a> All rights reserved.</div></div>';b.createDialog({name:"about",width:350,title:b.lang("about"),body:a})});
b.plugin.getSelectedLink=function(){return b.cmd.commonAncestor("a")};b.plugin.getSelectedImage=function(){return Ba(b.edit.cmd.range,function(a){return!/^ke-\w+$/i.test(a[0].className)})};b.plugin.getSelectedFlash=function(){return Ba(b.edit.cmd.range,function(a){return a[0].className=="ke-flash"})};b.plugin.getSelectedMedia=function(){return Ba(b.edit.cmd.range,function(a){return a[0].className=="ke-media"||a[0].className=="ke-rm"})};b.plugin.getSelectedAnchor=function(){return Ba(b.edit.cmd.range,
function(a){return a[0].className=="ke-anchor"})};m("link,image,flash,media,anchor".split(","),function(a,c){var d=c.charAt(0).toUpperCase()+c.substr(1);m("edit,delete".split(","),function(a,e){b.addContextmenu({title:b.lang(e+d),click:function(){b.loadPlugin(c,function(){b.plugin[c][e]();b.hideMenu()})},cond:b.plugin["getSelected"+d],width:150,iconClass:e=="edit"?"ke-icon-"+c:o})});b.addContextmenu({title:"-"})});b.plugin.getSelectedTable=function(){return b.cmd.commonAncestor("table")};b.plugin.getSelectedRow=
function(){return b.cmd.commonAncestor("tr")};b.plugin.getSelectedCell=function(){return b.cmd.commonAncestor("td")};m("prop,cellprop,colinsertleft,colinsertright,rowinsertabove,rowinsertbelow,rowmerge,colmerge,rowsplit,colsplit,coldelete,rowdelete,insert,delete".split(","),function(a,c){var d=N(c,["prop","delete"])<0?b.plugin.getSelectedCell:b.plugin.getSelectedTable;b.addContextmenu({title:b.lang("table"+c),click:function(){b.loadPlugin("table",function(){b.plugin.table[c]();b.hideMenu()})},cond:d,
width:170,iconClass:"ke-icon-table"+c})});b.addContextmenu({title:"-"});m("selectall,justifyleft,justifycenter,justifyright,justifyfull,insertorderedlist,insertunorderedlist,indent,outdent,subscript,superscript,hr,print,bold,italic,underline,strikethrough,removeformat,unlink".split(","),function(a,d){c[d]&&b.afterCreate(function(){Ga(this.edit.doc,c[d],function(){b.cmd.selection();b.clickToolbar(d)})});b.clickToolbar(d,function(){b.focus().exec(d,null)})});b.afterCreate(function(){function c(){f.range.moveToBookmark(i);
f.select();W&&(a("div."+n,j).each(function(){a(this).after("<br />").remove(!0)}),a("span.Apple-style-span",j).remove(!0),a("span.Apple-tab-span",j).remove(!0),a("span[style]",j).each(function(){a(this).css("white-space")=="nowrap"&&a(this).remove(!0)}),a("meta",j).remove());var d=j[0].innerHTML;j.remove();d!==""&&(W&&(d=d.replace(/(<br>)\1/ig,"$1")),b.pasteType===2&&(d=d.replace(/(<(?:p|p\s[^>]*)>) *(<\/p>)/ig,""),/schemas-microsoft-com|worddocument|mso-\w+/i.test(d)?d=lb(d,b.filterMode?b.htmlTags:
a.options.htmlTags):(d=S(d,b.filterMode?b.htmlTags:null),d=b.beforeSetHtml(d))),b.pasteType===1&&(d=d.replace(/&nbsp;/ig," "),d=d.replace(/\n\s*\n/g,"\n"),d=d.replace(/<br[^>]*>/ig,"\n"),d=d.replace(/<\/p><p[^>]*>/ig,"\n"),d=d.replace(/<[^>]+>/g,""),d=d.replace(/ {2}/g," &nbsp;"),b.newlineTag=="p"?/\n/.test(d)&&(d=d.replace(/^/,"<p>").replace(/$/,"<br /></p>").replace(/\n/g,"<br /></p><p>")):d=d.replace(/\n/g,"<br />$&")),b.insertHtml(d,!0))}var d=b.edit.doc,f,i,j,n="__kindeditor_paste__",m=!1;a(d.body).bind("paste",
function(o){if(b.pasteType===0)o.stop();else if(!m){m=!0;a("div."+n,d).remove();f=b.cmd.selection();i=f.range.createBookmark();j=a('<div class="'+n+'"></div>',d).css({position:"absolute",width:"1px",height:"1px",overflow:"hidden",left:"-1981px",top:a(i.start).pos().y+"px","white-space":"nowrap"});a(d.body).append(j);if(l){var q=f.range.get(!0);q.moveToElementText(j[0]);q.select();q.execCommand("paste");o.preventDefault()}else f.range.selectNodeContents(j[0]),f.select();setTimeout(function(){c();m=
!1},0)}})});b.beforeGetHtml(function(a){l&&z<=8&&(a=a.replace(/<div\s+[^>]*data-ke-input-tag="([^"]*)"[^>]*>([\s\S]*?)<\/div>/ig,function(a,b){return unescape(b)}),a=a.replace(/(<input)((?:\s+[^>]*)?>)/ig,function(a,b,c){if(!/\s+type="[^"]+"/i.test(a))return b+' type="text"'+c;return a}));return a.replace(/(<(?:noscript|noscript\s[^>]*)>)([\s\S]*?)(<\/noscript>)/ig,function(a,b,c,d){return b+fa(c).replace(/\s+/g," ")+d}).replace(/<img[^>]*class="?ke-(flash|rm|media)"?[^>]*>/ig,function(a){var a=H(a),
b=aa(a.style||""),c=nb(a["data-ke-tag"]);c.width=j(a.width,t(j(b.width,"")));c.height=j(a.height,t(j(b.height,"")));return Ia(c)}).replace(/<img[^>]*class="?ke-anchor"?[^>]*>/ig,function(a){a=H(a);return'<a name="'+unescape(a["data-ke-name"])+'"></a>'}).replace(/<div\s+[^>]*data-ke-script-attr="([^"]*)"[^>]*>([\s\S]*?)<\/div>/ig,function(a,b,c){return"<script"+unescape(b)+">"+unescape(c)+"<\/script>"}).replace(/<div\s+[^>]*data-ke-noscript-attr="([^"]*)"[^>]*>([\s\S]*?)<\/div>/ig,function(a,b,c){return"<noscript"+
unescape(b)+">"+unescape(c)+"</noscript>"}).replace(/(<[^>]*)data-ke-src="([^"]*)"([^>]*>)/ig,function(a,b,c){a=a.replace(/(\s+(?:href|src)=")[^"]*(")/i,function(a,b,d){return b+fa(c)+d});return a=a.replace(/\s+data-ke-src="[^"]*"/i,"")}).replace(/(<[^>]+\s)data-ke-(on\w+="[^"]*"[^>]*>)/ig,function(a,b,c){return b+c})});b.beforeSetHtml(function(a){l&&z<=8&&(a=a.replace(/<input[^>]*>|<(select|button)[^>]*>[\s\S]*?<\/\1>/ig,function(a){var b=H(a);if(aa(b.style||"").display=="none")return'<div class="ke-display-none" data-ke-input-tag="'+
escape(a)+'"></div>';return a}));return a.replace(/<embed[^>]*type="([^"]+)"[^>]*>(?:<\/embed>)?/ig,function(a){a=H(a);a.src=j(a.src,"");a.width=j(a.width,0);a.height=j(a.height,0);return ob(b.themesPath+"common/blank.gif",a)}).replace(/<a[^>]*name="([^"]+)"[^>]*>(?:<\/a>)?/ig,function(a){var c=H(a);if(c.href!==o)return a;return'<img class="ke-anchor" src="'+b.themesPath+'common/anchor.gif" data-ke-name="'+escape(c.name)+'" />'}).replace(/<script([^>]*)>([\s\S]*?)<\/script>/ig,function(a,b,c){return'<div class="ke-script" data-ke-script-attr="'+
escape(b)+'">'+escape(c)+"</div>"}).replace(/<noscript([^>]*)>([\s\S]*?)<\/noscript>/ig,function(a,b,c){return'<div class="ke-noscript" data-ke-noscript-attr="'+escape(b)+'">'+escape(c)+"</div>"}).replace(/(<[^>]*)(href|src)="([^"]*)"([^>]*>)/ig,function(a,b,c,d,e){if(a.match(/\sdata-ke-src="[^"]*"/i))return a;return a=b+c+'="'+d+'" data-ke-src="'+C(d)+'"'+e}).replace(/(<[^>]+\s)(on\w+="[^"]*"[^>]*>)/ig,function(a,b,c){return b+"data-ke-"+c}).replace(/<table[^>]*\s+border="0"[^>]*>/ig,function(a){if(a.indexOf("ke-zeroborder")>=
0)return a;return Qb(a,"ke-zeroborder")})})})}})(window);
window.editorMap = {};
function loadEditor(id) {
	editorMap[id] = editorMap[id] || KindEditor.create('#'+id, {
		resizeMode:1,
		allowUpload:false,
		allowImageUpload:false,
		allowFlashUpload:false,
		allowPreviewEmoticons:false,
		urlType:'domain',
		items:['bold','italic','underline','strikethrough','forecolor','hilitecolor','fontname','fontsize','lineheight','removeformat','plainpaste','quickformat','insertorderedlist','insertunorderedlist','indent','outdent','justifyleft','justifycenter','justifyright','link','unlink','image','flash','table','emoticons','code','fullscreen','source','|','about']
	});
}
		var readyFunc = function() {
			if (loaded) return;
			loaded = true;
			func();
		};
		if (doc.addEventListener) {
			this.add(doc, "DOMContentLoaded", readyFunc, id);
		} else if (doc.attachEvent){
			this.add(doc, "readystatechange", function() {
				if (doc.readyState == "complete") readyFunc();
			}, id);
			if ( doc.documentElement.doScroll && typeof win.frameElement === "undefined" ) {
				var ieReadyFunc = function() {
					if (loaded) return;
					try {
						doc.documentElement.doScroll("left");
					} catch(e) {
						window.setTimeout(ieReadyFunc, 0);
						return;
					}
					readyFunc();
				};
				ieReadyFunc();
			}
		}
		this.add(win, 'load', readyFunc, id);
	}
};

KE.each = function(obj, func) {
	for (var key in obj) {
		if (obj.hasOwnProperty(key)) func(key, obj[key]);
	}
};

KE.eachNode = function(node, func) {
	var walkNodes = function(parent) {
		if (KE.util.getNodeType(parent) != 1) return true;
		var n = parent.firstChild;
		while (n) {
			var next = n.nextSibling;
			if (!func(n)) return false;
			if (!walkNodes(n)) return false;
			n = next;
		}
		return true;
	};
	walkNodes(node);
};

KE.selection = function(doc) {
	this.sel = null;
	this.range = null;
	this.keRange = null;
	this.isControl = false;
	var win = doc.parentWindow || doc.defaultView;
	this.init = function() {
		var sel = doc.selection ? doc.selection : win.getSelection();
		var range;
		try {
			if (sel.rangeCount > 0) range = sel.getRangeAt(0);
			else range = sel.createRange();
		} catch(e) {}
		if (!range) range = KE.util.createRange(doc);
		this.sel = sel;
		this.range = range;
		var startNode, startPos, endNode, endPos;
		if (KE.browser.IE) {
			if (range.item) {
				this.isControl = true;
				var el = range.item(0);
				startNode = endNode = el;
				startPos = endPos = 0;
			} else {
				this.isControl = false;
				var getStartEnd = function(isStart) {
					var pointRange = range.duplicate();
					pointRange.collapse(isStart);
					var parentNode = pointRange.parentElement();
					var nodes = parentNode.childNodes;
					if (nodes.length == 0) return {node: parentNode, pos: 0};
					var startNode;
					var endElement;
					var startPos = 0;
					var isEnd = false;
					var testRange = range.duplicate();
					KE.util.moveToElementText(testRange, parentNode);
					for (var i = 0, len = nodes.length; i < len; i++) {
						var node = nodes[i];
						var cmp = testRange.compareEndPoints('StartToStart', pointRange);
						if (cmp > 0) {
							isEnd = true;
						} else if (cmp == 0) {
							if (node.nodeType == 1) {
								var keRange = new KE.range(doc);
								keRange.selectTextNode(node);
								return {node: keRange.startNode, pos: 0};
							} else {
								return {node: node, pos: 0};
							}
						}
						if (node.nodeType == 1) {
							var nodeRange = range.duplicate();
							KE.util.moveToElementText(nodeRange, node);
							testRange.setEndPoint('StartToEnd', nodeRange);
							if (isEnd) startPos += nodeRange.text.replace(/\r\n|\n|\r/g, '').length;
							else startPos = 0;
						} else if (node.nodeType == 3) {
							//fix bug: typeof node.nodeValue can return "unknown" in IE.
							if (typeof node.nodeValue === 'string') {
								testRange.moveStart('character', node.nodeValue.length);
								startPos += node.nodeValue.length;
							}
						}
						if (!isEnd) startNode = node;
					}
					if (!isEnd && startNode.nodeType == 1) {
						var startNode = parentNode.lastChild;
						return {node: startNode, pos: startNode.nodeType == 1 ? 1 : startNode.nodeValue.length};
					}
					testRange = range.duplicate();
					KE.util.moveToElementText(testRange, parentNode);
					testRange.setEndPoint('StartToEnd', pointRange);
					startPos -= testRange.text.replace(/\r\n|\n|\r/g, '').length;
					return {node: startNode, pos: startPos};
				};
				var start = getStartEnd(true);
				var end = getStartEnd(false);
				startNode = start.node;
				startPos = start.pos;
				endNode = end.node;
				endPos = end.pos;
			}
		} else {
			startNode = range.startContainer;
			startPos = range.startOffset;
			endNode = range.endContainer;
			endPos = range.endOffset;
			if (startNode.nodeType == 1 && typeof startNode.childNodes[startPos] != 'undefined') {
				startNode = startNode.childNodes[startPos];
				startPos = 0;
			}
			if (endNode.nodeType == 1) {
				endPos = endPos == 0 ? 1 : endPos;
				if (typeof endNode.childNodes[endPos - 1] != 'undefined') {
					endNode = endNode.childNodes[endPos - 1];
					endPos = (endNode.nodeType == 1) ? 0 : endNode.nodeValue.length;
				}
			}
			this.isControl = (startNode.nodeType == 1 && startNode === endNode && range.startOffset + 1 == range.endOffset);
			if (startNode.nodeType == 1 && endNode.nodeType == 3 && endPos == 0 && endNode.previousSibling) {
				var node = endNode.previousSibling;
				while (node) {
					if (node === startNode) {
						endNode = startNode;
						break;
					}
					if (node.childNodes.length != 1) break;
					node = node.childNodes[0];
				}
			}
			if (range.collapsed) {
				var keRange = new KE.range(doc);
				keRange.setTextStart(startNode, startPos);
				endNode = keRange.startNode;
				endPos = keRange.startPos;
			}
		}
		var keRange = new KE.range(doc);
		keRange.setTextStart(startNode, startPos);
		keRange.setTextEnd(endNode, endPos);
		this.keRange = keRange;
	};
	this.init();
	this.addRange = function(keRange) {
		if (KE.browser.GECKO && KE.browser.VERSION < 3) return;
		this.keRange = keRange;
		if (KE.browser.IE) {
			var getEndRange = function(isStart) {
				var range = KE.util.createRange(doc);
				var node = isStart ? keRange.startNode : keRange.endNode;
				if (node.nodeType == 1) {
					KE.util.moveToElementText(range, node);
					range.collapse(isStart);
				} else if (node.nodeType == 3) {
					range = KE.util.getNodeStartRange(doc, node);
					var pos = isStart ? keRange.startPos : keRange.endPos;
					range.moveStart('character', pos);
				}
				return range;
			}
			if (!this.range.item) {
				var node = keRange.startNode;
				if (node == keRange.endNode && KE.util.getNodeType(node) == 1 && KE.util.getNodeTextLength(node) == 0) {
					var temp = doc.createTextNode(" ");
					node.appendChild(temp);
					KE.util.moveToElementText(this.range, node);
					this.range.collapse(false);
					this.range.select();
					node.removeChild(temp);
				} else {
					if (node.nodeType == 3 && keRange.collapsed()) {
						this.range = getEndRange(true);
						this.range.collapse(true);
					} else {
						this.range.setEndPoint('StartToStart', getEndRange(true));
						this.range.setEndPoint('EndToStart', getEndRange(false));
					}
					this.range.select();
				}
			}
		} else {
			var getNodePos = function(node) {
				var pos = 0;
				while (node) {
					node = node.previousSibling;
					pos++;
				}
				return --pos;
			};
			var range = new KE.range(doc);
			range.setTextStart(keRange.startNode, keRange.startPos);
			range.setTextEnd(keRange.endNode, keRange.endPos);
			var startNode = range.startNode;
			var endNode = range.endNode;
			if (KE.util.getNodeType(startNode) == 88) {
				this.range.setStart(startNode.parentNode, getNodePos(range.startNode));
			} else {
				this.range.setStart(startNode, range.startPos);
			}
			if (KE.util.getNodeType(endNode) == 88) {
				this.range.setEnd(endNode.parentNode, getNodePos(range.endNode) + 1);
			} else {
				this.range.setEnd(endNode, range.endPos);
			}
			this.sel.removeAllRanges();
			this.sel.addRange(this.range);
		}
	};
	this.focus = function() {
		if (KE.browser.IE && this.range != null) this.range.select();
	}
};

KE.range = function(doc) {
	this.startNode = null;
	this.startPos = null;
	this.endNode = null;
	this.endPos = null;
	this.getParentElement = function() {
		var scanParent = function(node, func) {
			while (node && (!node.tagName || node.tagName.toLowerCase() != 'body')) {
				node = node.parentNode;
				if (func(node)) return;
			}
		}
		var nodeList = [];
		scanParent(this.startNode, function(node) {
			nodeList.push(node);
		});
		var parentNode;
		scanParent(this.endNode, function(node) {
			if (KE.util.inArray(node, nodeList)) {
				parentNode = node;
				return true;
			}
		});
		return parentNode ? parentNode : doc.body;
	};
	this.getNodeList = function() {
		var self = this;
		var parentNode = this.getParentElement();
		var nodeList = [];
		var isStarted = false;
		if (parentNode == self.startNode) isStarted = true;
		if (isStarted) nodeList.push(parentNode);
		KE.eachNode(parentNode, function(node) {
			if (node == self.startNode) isStarted = true;
			var range = new KE.range(doc);
			range.selectTextNode(node);
			var cmp = range.comparePoints('START_TO_END', self);
			if (cmp > 0) {
				return false;
			} else if (cmp == 0) {
				if (range.startNode !== range.endNode || range.startPos !== range.endPos) return false;
			}
			if (isStarted) nodeList.push(node);
			return true;
		});
		return nodeList;
	};
	this.comparePoints = function(how, range) {
		var compareNodes = function(nodeA, posA, nodeB, posB) {
			var cmp;
			if (KE.browser.IE) {
				var getStartRange = function(node, pos, isStart) {
					var range = KE.util.createRange(doc);
					var type = KE.util.getNodeType(node);
					if (type == 1) {
						KE.util.moveToElementText(range, node);
						range.collapse(isStart);
					} else if (type == 3) {
						range = KE.util.getNodeStartRange(doc, node);
						range.moveStart('character', pos);
						range.collapse(true);
					}
					return range;
				}
				var rangeA, rangeB;
				if (how == 'START_TO_START' || how == 'START_TO_END') rangeA = getStartRange(nodeA, posA, true);
				else rangeA = getStartRange(nodeA, posA, false);
				if (how == 'START_TO_START' || how == 'END_TO_START') rangeB = getStartRange(nodeB, posB, true);
				else rangeB = getStartRange(nodeB, posB, false);
				return rangeA.compareEndPoints('StartToStart', rangeB);
			} else {
				var rangeA = KE.util.createRange(doc);
				rangeA.selectNode(nodeA);
				if (how == 'START_TO_START' || how == 'START_TO_END') rangeA.collapse(true);
				else rangeA.collapse(false);
				var rangeB = KE.util.createRange(doc);
				rangeB.selectNode(nodeB);
				if (how == 'START_TO_START' || how == 'END_TO_START') rangeB.collapse(true);
				else rangeB.collapse(false);
				if (rangeA.compareBoundaryPoints(Range.START_TO_START, rangeB) > 0) {
					cmp = 1;
				} else if (rangeA.compareBoundaryPoints(Range.START_TO_START, rangeB) == 0) {
					if (posA > posB) cmp = 1;
					else if (posA == posB) cmp = 0;
					else cmp = -1;
				} else {
					cmp = -1;
				}
			}
			return cmp;
		}
		if (how == 'START_TO_START') return compareNodes(this.startNode, this.startPos, range.startNode, range.startPos);
		if (how == 'START_TO_END') return compareNodes(this.startNode, this.startPos, range.endNode, range.endPos);
		if (how == 'END_TO_START') return compareNodes(this.endNode, this.endPos, range.startNode, range.startPos);
		if (how == 'END_TO_END') return compareNodes(this.endNode, this.endPos, range.endNode, range.endPos);
	};
	this.collapsed = function() {
		return (this.startNode === this.endNode && this.startPos === this.endPos);
	};
	this.collapse = function(toStart) {
		if (toStart) {
			this.setEnd(this.startNode, this.startPos);
		} else {
			this.setStart(this.endNode, this.endPos);
		}
	};
	this.setTextStart = function(node, pos) {
		var textNode = node;
		KE.eachNode(node, function(n) {
			if (KE.util.getNodeType(n) == 3 && n.nodeValue.length > 0 || KE.util.getNodeType(n) == 88) {
				textNode = n;
				pos = 0;
				return false;
			}
			return true;
		});
		this.setStart(textNode, pos);
	};
	this.setStart = function(node, pos) {
		this.startNode = node;
		this.startPos = pos;
		if (this.endNode === null) {
			this.endNode = node;
			this.endPos = pos;
		}
	};
	this.setTextEnd = function(node, pos) {
		var textNode = node;
		KE.eachNode(node, function(n) {
			if (KE.util.getNodeType(n) == 3 && n.nodeValue.length > 0 || KE.util.getNodeType(n) == 88) {
				textNode = n;
				pos = KE.util.getNodeType(n) == 3 ? n.nodeValue.length : 0;
			}
			return true;
		});
		this.setEnd(textNode, pos);
	};
	this.setEnd = function(node, pos) {
		this.endNode = node;
		this.endPos = pos;
		if (this.startNode === null) {
			this.startNode = node;
			this.startPos = pos;
		}
	};
	this.selectNode = function(node) {
		this.setStart(node, 0);
		this.setEnd(node, node.nodeType == 1 ? 0 : node.nodeValue.length);
	};
	this.selectTextNode = function(node) {
		this.setTextStart(node, 0);
		this.setTextEnd(node, node.nodeType == 1 ? 0 : node.nodeValue.length);
	};
	this.extractContents = function(isDelete) {
		isDelete = (isDelete === undefined) ? true : isDelete;
		var thisRange = this;
		var startNode = this.startNode;
		var startPos = this.startPos;
		var endNode = this.endNode;
		var endPos = this.endPos;
		var extractTextNode = function(node, startPos, endPos) {
			var length = node.nodeValue.length;
			var cloneNode = node.cloneNode(true);
			var centerNode = cloneNode.splitText(startPos);
			centerNode.splitText(endPos - startPos);
			if (isDelete) {
				var center = node;
				if (startPos > 0) center = node.splitText(startPos);
				if (endPos < length) center.splitText(endPos - startPos);
				center.parentNode.removeChild(center);
			}
			return centerNode;
		};
		var noEndTagHash = KE.util.arrayToHash(KE.setting.noEndTags);
		var isStarted = false;
		var isEnd = false;
		var extractNodes = function(parent, frag) {
			if (KE.util.getNodeType(parent) != 1) return true;
			var node = parent.firstChild;
			while (node) {
				if (node == startNode) isStarted = true;
				if (node == endNode) isEnd = true;
				var nextNode = node.nextSibling;
				var type = node.nodeType;
				if (type == 1) {
					var range = new KE.range(doc);
					range.selectNode(node);
					var cmp = range.comparePoints('END_TO_END', thisRange);
					if (isStarted && (cmp < 0 || (cmp == 0 && noEndTagHash[node.nodeName.toLowerCase()] !== undefined))) {
						var cloneNode = node.cloneNode(true);
						frag.appendChild(cloneNode);
						if (isDelete) {
							node.parentNode.removeChild(node);
						}
					} else {
						var childFlag = node.cloneNode(false);
						if (noEndTagHash[childFlag.nodeName.toLowerCase()] === undefined) {
							frag.appendChild(childFlag);
							if (!extractNodes(node, childFlag)) return false;
						}
					}
				} else if (type == 3) {
					if (isStarted) {
						var textNode;
						if (node == startNode && node == endNode) {
							textNode = extractTextNode(node, startPos, endPos);
							frag.appendChild(textNode);
							return false;
						} else if (node == startNode) {
							textNode = extractTextNode(node, startPos, node.nodeValue.length);
							frag.appendChild(textNode);
						} else if (node == endNode) {
							textNode = extractTextNode(node, 0, endPos);
							frag.appendChild(textNode);
							return false;
						} else {
							textNode = extractTextNode(node, 0, node.nodeValue.length);
							frag.appendChild(textNode);
						}
					}
				}
				node = nextNode;
				if (isEnd) return false;
			}
			if (frag.innerHTML.replace(/<.*?>/g, '') === '' && frag.parentNode) {
				frag.parentNode.removeChild(frag);
			}
			return true;
		}
		var parentNode = this.getParentElement();
		var docFrag = parentNode.cloneNode(false);
		extractNodes(parentNode, docFrag);
		return docFrag;
	};
	this.cloneContents = function() {
		return this.extractContents(false);
	};
	this.getText = function() {
		var html = this.cloneContents().innerHTML;
		return html.replace(/<.*?>/g, "");
	};
};

KE.cmd = function(id) {
	this.doc = KE.g[id].iframeDoc;
	this.keSel = KE.g[id].keSel;
	this.keRange = KE.g[id].keRange;
	this.mergeAttributes = function(el, attr) {
		for (var i = 0, len = attr.length; i < len; i++) {
			KE.each(attr[i], function(key, value) {
				if (key.charAt(0) == '.') {
					var jsKey = KE.util.getJsKey(key.substr(1));
					el.style[jsKey] = value;
				} else {
					if (KE.browser.IE && KE.browser.VERSION < 8 && key == 'class') key = 'className';
					el.setAttribute(key, value);
				}
			});
		}
		return el;
	};
	this.wrapTextNode = function(node, startPos, endPos, element, attributes) {
		var length = node.nodeValue.length;
		var isFull = (startPos == 0 && endPos == length);
		var range = new KE.range(this.doc);
		range.selectTextNode(node.parentNode);
		if (isFull &&
			node.parentNode.tagName == element.tagName &&
			range.comparePoints('END_TO_END', this.keRange) <= 0 &&
			range.comparePoints('START_TO_START', this.keRange) >= 0) {
			this.mergeAttributes(node.parentNode, attributes);
			return node;
		} else {
			var el = element.cloneNode(true);
			if (isFull) {
				var cloneNode = node.cloneNode(true);
				el.appendChild(cloneNode);
				node.parentNode.replaceChild(el, node);
				return cloneNode;
			} else {
				var centerNode = node;
				if (startPos < endPos) {
					if (startPos > 0) centerNode = node.splitText(startPos);
					if (endPos < length) centerNode.splitText(endPos - startPos);
					var cloneNode = centerNode.cloneNode(true);
					el.appendChild(cloneNode);
					centerNode.parentNode.replaceChild(el, centerNode);
					return cloneNode;
				} else {
					if (startPos < length) {
						centerNode = node.splitText(startPos);
						centerNode.parentNode.insertBefore(el, centerNode);
					} else {
						if (centerNode.nextSibling) {
							centerNode.parentNode.insertBefore(el, centerNode.nextSibling);
						} else {
							centerNode.parentNode.appendChild(el);
						}
					}
					return el;
				}
			}
		}
	};
	this.wrap = function(tagName, attributes) {
		attributes = attributes || [];
		var self = this;
		this.keSel.focus();
		var element = KE.$$(tagName, this.doc);
		this.mergeAttributes(element, attributes);
		var keRange = this.keRange;
		var startNode = keRange.startNode;
		var startPos = keRange.startPos;
		var endNode = keRange.endNode;
		var endPos = keRange.endPos;
		var parentNode = keRange.getParentElement();
		if (KE.util.inMarquee(parentNode)) return;
		var isStarted = false;
		KE.eachNode(parentNode, function(node) {
			if (node == startNode) isStarted = true;
			if (node.nodeType == 1) {
				if (node == startNode && node == endNode) {
					if (KE.util.inArray(node.tagName.toLowerCase(), KE.g[id].noEndTags)) {
						if (startPos > 0) node.parentNode.appendChild(element);
						else node.parentNode.insertBefore(element, node);
					} else {
						node.appendChild(element);
					}
					keRange.selectNode(element);
					return false;
				} else if (node == startNode) {
					keRange.setStart(node, 0);
				} else if (node == endNode) {
					keRange.setEnd(node, 0);
					return false;
				}
			} else if (node.nodeType == 3) {
				if (isStarted) {
					if (node == startNode && node == endNode) {
						var rangeNode = self.wrapTextNode(node, startPos, endPos, element, attributes);
						keRange.selectNode(rangeNode);
						return false;
					} else if (node == startNode) {
						var rangeNode = self.wrapTextNode(node, startPos, node.nodeValue.length, element, attributes);
						keRange.setStart(rangeNode, 0);
					} else if (node == endNode) {
						var rangeNode = self.wrapTextNode(node, 0, endPos, element, attributes);
						keRange.setEnd(rangeNode, rangeNode.nodeType == 1 ? 0 : rangeNode.nodeValue.length);
						return false;
					} else {
						self.wrapTextNode(node, 0, node.nodeValue.length, element, attributes);
					}
				}
			}
			return true;
		});
		this.keSel.addRange(keRange);
	};
	this.getTopParent = function(tagNames, node) {
		var parent = null;
		while (node) {
			node = node.parentNode;
			if (KE.util.inArray(node.tagName.toLowerCase(), tagNames)) {
				parent = node;
			} else {
				break;
			}
		}
		return parent;
	};
	this.splitNodeParent = function(parent, node, pos) {
		var leftRange = new KE.range(this.doc);
		leftRange.selectNode(parent.firstChild);
		leftRange.setEnd(node, pos);
		var leftFrag = leftRange.extractContents();
		parent.parentNode.insertBefore(leftFrag, parent);
		return {left : leftFrag, right : parent};
	};
	this.remove = function(tags) {
		var self = this;
		var keRange = this.keRange;
		var startNode = keRange.startNode;
		var startPos = keRange.startPos;
		var endNode = keRange.endNode;
		var endPos = keRange.endPos;
		this.keSel.focus();
		if (KE.util.inMarquee(keRange.getParentElement())) return;
		var isCollapsed = (keRange.getText().replace(/\s+/g, '') === '');
		if (isCollapsed && !KE.browser.IE) return;
		var tagNames = [];
		KE.each(tags, function(key, val) {
			if (key != '*') tagNames.push(key);
		});
		var startParent = this.getTopParent(tagNames, startNode);
		var endParent = this.getTopParent(tagNames, endNode);
		if (startParent) {
			var startFrags = this.splitNodeParent(startParent, startNode, startPos);
			keRange.setStart(startFrags.right, 0);
			if (startNode == endNode && KE.util.getNodeTextLength(startFrags.right) > 0) {
				keRange.selectNode(startFrags.right);
				var range = new KE.range(this.doc);
				range.selectTextNode(startFrags.left);
				if (startPos > 0) endPos -= range.endNode.nodeValue.length;
				range.selectTextNode(startFrags.right);
				endNode = range.startNode;
			}
		}
		if (isCollapsed) {
			var node = keRange.startNode;
			if (node.nodeType == 1) {
				if (node.nodeName.toLowerCase() == 'br') return;
				keRange.selectNode(node);
			} else {
				return;
			}
		} else if (endParent) {
			var endFrags = this.splitNodeParent(endParent, endNode, endPos);
			keRange.setEnd(endFrags.left, 0);
			if (startParent == endParent) {
				keRange.setStart(endFrags.left, 0);
			}
		}
		var removeAttr = function(node, attr) {
			if (attr.charAt(0) == '.') {
				var jsKey = KE.util.getJsKey(attr.substr(1));
				node.style[jsKey] = '';
			} else {
				if (KE.browser.IE && KE.browser.VERSION < 8 && attr == 'class') attr = 'className';
				node.removeAttribute(attr);
			}
		};
		var nodeList = keRange.getNodeList();
		keRange.setTextStart(keRange.startNode, keRange.startPos);
		keRange.setTextEnd(keRange.endNode, keRange.endPos);
		for (var i = 0, length = nodeList.length; i < length; i++) {
			var node = nodeList[i];
			if (node.nodeType == 1) {
				var tagName = node.tagName.toLowerCase();
				if (tags[tagName]) {
					var attr = tags[tagName];
					for (var j = 0, len = attr.length; j < len; j++) {
						if (attr[j] == '*') {
							KE.util.removeParent(node);
							break;
						} else {
							removeAttr(node, attr[j]);
							var attrs = [];
							if (node.outerHTML) {
								attrHash = KE.util.getAttrList(node.outerHTML);
								KE.each(attrHash, function(key, val) {
									attrs.push({
										name : key,
										value : val
									});
								});
							} else {
								attrs = node.attributes;
							}
							if (attrs.length == 0) {
								KE.util.removeParent(node);
								break;
							} else if (attrs[0].name == 'style' && attrs[0].value === '') {
								KE.util.removeParent(node);
								break;
							}
						}
					}
				}
				if (tags['*']) {
					var attr = tags['*'];
					for (var j = 0, len = attr.length; j < len; j++) {
						removeAttr(node, attr[j]);
					}
				}
			}
		}
		try {
			this.keSel.addRange(keRange);
		} catch(e) {}
	};
};

KE.format = {
	getUrl : function(url, mode, host, pathname) {
		if (!mode) return url;
		mode = mode.toLowerCase();
		if (!KE.util.inArray(mode, ['absolute', 'relative', 'domain'])) return url;
		host = host || location.protocol + '//' + location.host;
		if (pathname === undefined) {
			var m = location.pathname.match(/^(\/.*)\//);
			pathname = m ? m[1] : '';
		}
		var matches = url.match(/^(\w+:\/\/[^\/]*)/);
		if (matches) {
			if (matches[1] !== host) return url;
		} else if (url.match(/^\w+:/)) {
			return url;
		}
		var getRealPath = function(path) {
			var parts = path.split('/');
			paths = [];
			for (var i = 0, len = parts.length; i < len; i++) {
				var part = parts[i];
				if (part == '..') {
					if (paths.length > 0) paths.pop();
				} else if (part !== '' && part != '.') {
					paths.push(part);
				}
			}
			return '/' + paths.join('/');
		};
		if (url.match(/^\//)) {
			url = host + getRealPath(url.substr(1));
		} else if (!url.match(/^\w+:\/\//)) {
			url = host + getRealPath(pathname + '/' + url);
		}
		if (mode == 'relative') {
			var getRelativePath = function(path, depth) {
				if (url.substr(0, path.length) === path) {
					var arr = [];
					for (var i = 0; i < depth; i++) {
						arr.push('..');
					}
					var prefix = '.';
					if (arr.length > 0) prefix += '/' + arr.join('/');
					if (pathname == '/') prefix += '/';
					return prefix + url.substr(path.length);
				} else {
					var m = path.match(/^(.*)\//);
					if (m) {
						return getRelativePath(m[1], ++depth);
					}
				}
			};
			url = getRelativePath(host + pathname, 0).substr(2);
		} else if (mode == 'absolute') {
			if (url.substr(0, host.length) === host) {
				url = url.substr(host.length);
			}
		}
		return url;
	},
	getHtml : function(html, htmlTags, urlType) {
		var isFilter = htmlTags ? true : false;
		html = html.replace(/(<pre[^>]*>)([\s\S]*?)(<\/pre>)/ig, function($0, $1, $2, $3){
			return $1 + $2.replace(/<br[^>]*>/ig, '\n') + $3;
		});
		var htmlTagHash = {};
		var fontSizeHash = ['xx-small', 'x-small', 'small', 'medium', 'large', 'x-large', 'xx-large'];
		if (isFilter) {
			KE.each(htmlTags, function(key, val) {
				var arr = key.split(',');
				for (var i = 0, len = arr.length; i < len; i++) htmlTagHash[arr[i]] = KE.util.arrayToHash(val);
			});
		}
		var skipFlag = false;
		var noEndTagHash = KE.util.arrayToHash(KE.setting.noEndTags);
		var inlineTagHash = KE.util.arrayToHash(KE.setting.inlineTags);
		var endlineTagHash = KE.util.arrayToHash(KE.setting.endlineTags);
		var re = /((?:\r\n|\n|\r)*)<(\/)?([\w\-:]+)((?:\s+|(?:\s+[\w\-:]+)|(?:\s+[\w\-:]+=[^\s"'<>]+)|(?:\s+[\w\-:]+="[^"]*")|(?:\s+[\w\-:]+='[^']*'))*)(\/)?>((?:\r\n|\n|\r)*)/g;
		html = html.replace(re, function($0, $1, $2, $3, $4, $5, $6) {
			var startNewline = $1 || '';
			var startSlash = $2 || '';
			var tagName = $3.toLowerCase();
			var attr = $4 || '';
			var endSlash = $5 ? ' ' + $5 : '';
			var endNewline = $6 || '';
			if (tagName === 'script' && startSlash !== '') skipFlag = false;
			if (skipFlag) return $0;
			if (tagName === 'script' && startSlash === '') skipFlag = true;
			if (isFilter && typeof htmlTagHash[tagName] == "undefined") return '';
			if (endSlash === '' && typeof noEndTagHash[tagName] != "undefined") endSlash = ' /';
			if (tagName in endlineTagHash) {
				if (startSlash || endSlash) endNewline = '\n';
			} else {
				if (endNewline) endNewline = ' ';
			}
			if (tagName !== 'script' && tagName !== 'style') {
				startNewline = '';
			}
			if (tagName === 'font') {
				var style = {}, styleStr = '';
				attr = attr.replace(/\s*([\w\-:]+)=([^\s"'<>]+|"[^"]*"|'[^']*')/g, function($0, $1, $2) {
					var key = $1.toLowerCase();
					var val = $2 || '';
					val = val.replace(/^["']|["']$/g, '');
					if (key === 'color') {
						style['color'] = val;
						return ' ';
					}
					if (key === 'size') {
						style['font-size'] = fontSizeHash[parseInt(val) - 1] || '';
						return ' ';
					}
					if (key === 'face') {
						style['font-family'] = val;
						return ' ';
					}
					if (key === 'style') {
						styleStr = val;
						return ' ';
					}
					return $0;
				});
				if (styleStr && !/;$/.test(styleStr)) styleStr += ';';
				KE.each(style, function(key, val) {
					if (val !== '') { 
						if (/\s/.test(val)) val = "'" + val + "'";
						styleStr += key + ':' + val + ';';
					}
				});
				if (styleStr) attr += ' style="' + styleStr + '"';
				tagName = 'span';
			}
			if (attr !== '') {
				attr = attr.replace(/\s*([\w\-:]+)=([^\s"'<>]+|"[^"]*"|'[^']*')/g, function($0, $1, $2) {
					var key = $1.toLowerCase();
					var val = $2 || '';
					if (isFilter) {
						if (key.charAt(0) === "." || (key !== "style" && typeof htmlTagHash[tagName][key] == "undefined")) return ' ';
					}
					if (val === '') {
						val = '""';
					} else {
						if (key === "style") {
							val = val.substr(1, val.length - 2);
							val = val.replace(/\s*([^\s]+?)\s*:(.*?)(;|$)/g, function($0, $1, $2) {
								var k = $1.toLowerCase();
								if (isFilter) {
									if (typeof htmlTagHash[tagName]['style'] == "undefined" && typeof htmlTagHash[tagName]['.' + k] == "undefined") return '';
								}
								var v = KE.util.trim($2);
								v = KE.util.rgbToHex(v);
								return k + ':' + v + ';';
							});
							val = KE.util.trim(val);
							if (val === '') return '';
							val = '"' + val + '"';
						}
						if (KE.util.inArray(key, ['src', 'href'])) {
							if (val.charAt(0) === '"') {
								val = val.substr(1, val.length - 2);
							}
							val = KE.format.getUrl(val, urlType);
						}
						if (val.charAt(0) !== '"') val = '"' + val + '"';
					}
					return ' ' + key + '=' + val + ' ';
				});
				attr = attr.replace(/\s+(checked|selected|disabled|readonly)(\s+|$)/ig, function($0, $1) {
					var key = $1.toLowerCase();
					if (isFilter) {
						if (key.charAt(0) === "." || typeof htmlTagHash[tagName][key] == "undefined") return ' ';
					}
					return ' ' + key + '="' + key + '"' + ' ';
				});
				attr = KE.util.trim(attr);
				attr = attr.replace(/\s+/g, ' ');
				if (attr) attr = ' ' + attr;
				return startNewline + '<' + startSlash + tagName + attr + endSlash + '>' + endNewline;
			} else {
				return startNewline + '<' + startSlash + tagName + endSlash + '>' + endNewline;
			}
		});
		if (!KE.browser.IE) {
			html = html.replace(/<p><br\s+\/>\n<\/p>/ig, '<p>&nbsp;</p>');
			html = html.replace(/<br\s+\/>\n<\/p>/ig, '</p>');
		}
		html = html.replace(/\u200B/g, '');
		var reg = KE.setting.inlineTags.join('|');
		var trimHtml = function(inHtml) {
			var outHtml = inHtml.replace(new RegExp('<(' + reg + ')[^>]*><\\/(' + reg + ')>', 'ig'), function($0, $1, $2) {
				if ($1 == $2) return '';
				else return $0;
			});
			if (inHtml !== outHtml) outHtml = trimHtml(outHtml);
			return outHtml;
		};
		return KE.util.trim(trimHtml(html));
	}
};

KE.addClass = function(el, className) {
	if (typeof el == 'object') {
		var cls = el.className;
		if (cls) {
			if ((' ' + cls + ' ').indexOf(' ' + className + ' ') < 0) {
				el.className = cls + ' ' + className;
			}
		} else {
			el.className = className;
		}
	} else if (typeof el == 'string') {
		if (/\s+class\s*=/.test(el)) {
			el = el.replace(/(\s+class=["']?)([^"']*)(["']?[\s>])/, function($0, $1, $2, $3) {
				if ((' ' + $2 + ' ').indexOf(' ' + className + ' ') < 0) {
					return $2 === '' ? $1 + className + $3 : $1 + $2 + ' ' + className + $3;
				} else {
					return $0;
				}
			});
		} else {
			el = el.substr(0, el.length - 1) + ' class="' + className + '">';
		}
	}
	return el;
};

KE.removeClass = function(el, className) {
	var cls = el.className || '';
	cls = ' ' + cls + ' ';
	className = ' ' + className + ' ';
	if (cls.indexOf(className) >= 0) {
		cls = KE.util.trim(cls.replace(new RegExp(className, 'ig'), ''));
		if (cls === '') {
			var key = el.getAttribute('class') ? 'class' : 'className';
			el.removeAttribute(key);
		} else {
			el.className = cls;
		}
	}
	return el;
};

KE.getComputedStyle = function(el, key) {
	var doc = el.ownerDocument,
		win = doc.parentWindow || doc.defaultView,
		jsKey = KE.util.getJsKey(key),
		val = '';
	if (win.getComputedStyle) {
		var style = win.getComputedStyle(el, null);
		val = style[jsKey] || style.getPropertyValue(key) || el.style[jsKey];
	} else if (el.currentStyle) {
		val = el.currentStyle[jsKey] || el.style[jsKey];
	}
	return val;
};

KE.getCommonAncestor = function(keSel, tagName) {
	var range = keSel.range,
		keRange = keSel.keRange,
		startNode = keRange.startNode,
		endNode = keRange.endNode;
	if (KE.util.inArray(tagName, ['table', 'td', 'tr'])) {
		if (KE.browser.IE) {
			if (range.item) {
				if (range.item(0).nodeName.toLowerCase() === tagName) {
					startNode = endNode = range.item(0);
				}
			} else {
				var rangeA = range.duplicate();
				rangeA.collapse(true);
				var rangeB = range.duplicate();
				rangeB.collapse(false);
				startNode = rangeA.parentElement();
				endNode = rangeB.parentElement();
			}
		} else {
			var rangeA = range.cloneRange();
			rangeA.collapse(true);
			var rangeB = range.cloneRange();
			rangeB.collapse(false);
			startNode = rangeA.startContainer;
			endNode = rangeB.startContainer;
		}
	}
	function find(node) {
		while (node) {
			if (node.nodeType == 1) {
				if (node.tagName.toLowerCase() === tagName) return node;
			}
			node = node.parentNode;
		}
		return null;
	};
	var start = find(startNode),
		end = find(endNode);
	if (start && end && start === end) {
		return start;
	}
	return null;
};

KE.queryCommandValue = function(doc, cmd) {
	cmd = cmd.toLowerCase();
	function commandValue() {
		var val = doc.queryCommandValue(cmd);
		if (typeof val !== 'string') val = '';
		return val;
	}
	var val = '';
	if (cmd === 'fontname') {
		val = commandValue();
		val = val.replace(/['"]/g, '');
	} else if (cmd === 'formatblock') {
		val = commandValue();
		if (val === '') {
			var keSel = new KE.selection(doc);
			var el = KE.getCommonAncestor(keSel, 'h1');
			if (!el) el = KE.getCommonAncestor(keSel, 'h2');
			if (!el) el = KE.getCommonAncestor(keSel, 'h3');
			if (!el) el = KE.getCommonAncestor(keSel, 'h4');
			if (!el) el = KE.getCommonAncestor(keSel, 'p');
			if (el) val = el.nodeName;
		}
		if (val === 'Normal') val = 'p';
	} else if (cmd === 'fontsize') {
		var keSel = new KE.selection(doc);
		var el = KE.getCommonAncestor(keSel, 'span');
		if (el) val = KE.getComputedStyle(el, 'font-size');
	} else if (cmd === 'textcolor') {
		var keSel = new KE.selection(doc);
		var el = KE.getCommonAncestor(keSel, 'span');
		if (el) val = KE.getComputedStyle(el, 'color');
		val = KE.util.rgbToHex(val);
		if (val === '') val = 'default';
	} else if (cmd === 'bgcolor') {
		var keSel = new KE.selection(doc);
		var el = KE.getCommonAncestor(keSel, 'span');
		if (el) val = KE.getComputedStyle(el, 'background-color');
		val = KE.util.rgbToHex(val);
		if (val === '') val = 'default';
	}
	return val.toLowerCase();
};

KE.util = {
	getDocumentElement : function(doc) {
		doc = doc || document;
		return (doc.compatMode != "CSS1Compat") ? doc.body : doc.documentElement;
	},
	getDocumentHeight : function(doc) {
		var el = this.getDocumentElement(doc);
		return Math.max(el.scrollHeight, el.clientHeight);
	},
	getDocumentWidth : function(doc) {
		var el = this.getDocumentElement(doc);
		return Math.max(el.scrollWidth, el.clientWidth);
	},
	createTable : function(doc) {
		var table = KE.$$('table', doc);
		table.cellPadding = 0;
		table.cellSpacing = 0;
		table.border = 0;
		return {table: table, cell: table.insertRow(0).insertCell(0)};
	},
	loadStyle : function(path) {
		var link = KE.$$('link');
		link.setAttribute('type', 'text/css');
		link.setAttribute('rel', 'stylesheet');
		link.setAttribute('href', path);
		document.getElementsByTagName("head")[0].appendChild(link);
	},
	getAttrList : function(tag) {
		var re = /\s+(?:([\w\-:]+)|(?:([\w\-:]+)=([\w\-:]+))|(?:([\w\-:]+)="([^"]*)")|(?:([\w\-:]+)='([^']*)'))(?=(?:\s|\/|>)+)/g;
		var arr, key, val, list = {};
		while ((arr = re.exec(tag))) {
			key = arr[1] || arr[2] || arr[4] || arr[6];
			val = arr[1] || (arr[2] ? arr[3] : (arr[4] ? arr[5] : arr[7]));
			list[key] = val;
		}
		return list;
	},
	inArray : function(str, arr) {
		for (var i = 0; i < arr.length; i++) {if (str == arr[i]) return true;}
		return false;
	},
	trim : function(str) {
		return str.replace(/^\s+|\s+$/g, "");
	},
	getJsKey : function(key) {
		var arr = key.split('-');
		key = '';
		for (var i = 0, len = arr.length; i < len; i++) {
			key += (i > 0) ? arr[i].charAt(0).toUpperCase() + arr[i].substr(1) : arr[i];
		}
		return key;
	},
	arrayToHash : function(arr) {
		var hash = {};
		for (var i = 0, len = arr.length; i < len; i++) hash[arr[i]] = 1;
		return hash;
	},
	escape : function(str) {
		str = str.replace(/&/g, '&amp;');
		str = str.replace(/</g, '&lt;');
		str = str.replace(/>/g, '&gt;');
		str = str.replace(/"/g, '&quot;');
		return str;
	},
	unescape : function(str) {
		str = str.replace(/&lt;/g, '<');
		str = str.replace(/&gt;/g, '>');
		str = str.replace(/&quot;/g, '"');
		str = str.replace(/&amp;/g, '&');
		return str;
	},
	getScrollPos : function() {
		var x, y;
		if (KE.browser.IE || KE.browser.OPERA) {
			var el = this.getDocumentElement();
			x = el.scrollLeft;
			y = el.scrollTop;
		} else {
			x = window.scrollX;
			y = window.scrollY;
		}
		return {x : x, y : y};
	},
	getElementPos : function(el) {
		var x = 0, y = 0;
		if (el.getBoundingClientRect) {
			var box = el.getBoundingClientRect();
			var pos = this.getScrollPos();
			x = box.left + pos.x;
			y = box.top + pos.y;
		} else {
            x = el.offsetLeft;
            y = el.offsetTop;
            var parent = el.offsetParent;
            while (parent) {
                x += parent.offsetLeft;
                y += parent.offsetTop;
                parent = parent.offsetParent;
            }
		}
		return {x : x, y : y};
	},
	getCoords : function(ev) {
		ev = ev || window.event;
		return {
			x : ev.clientX,
			y : ev.clientY
		};
	},
	setOpacity : function(el, opacity) {
		if (typeof el.style.opacity == "undefined") {
			el.style.filter = (opacity == 100) ? "" : "alpha(opacity=" + opacity + ")";
		} else {
			el.style.opacity = (opacity == 100) ? "" : (opacity / 100);
		}
	},
	getIframeDoc : function(iframe) {
		return iframe.contentDocument || iframe.contentWindow.document;
	},
	rgbToHex : function(str) {
		function hex(s) {
			s = parseInt(s).toString(16);
			return s.length > 1 ? s : '0' + s;
		};
		return str.replace(/rgb\s*?\(\s*?(\d+)\s*?,\s*?(\d+)\s*?,\s*?(\d+)\s*?\)/ig,
			function($0, $1, $2, $3) {
				return '#' + hex($1) + hex($2) + hex($3);
			}
		);
	},
	parseJson : function (text) {
		//extract JSON string
		var match;
		if ((match = /\{[\s\S]*\}|\[[\s\S]*\]/.exec(text))) {
			text = match[0];
		}
		var cx = /[\u0000\u00ad\u0600-\u0604\u070f\u17b4\u17b5\u200c-\u200f\u2028-\u202f\u2060-\u206f\ufeff\ufff0-\uffff]/g;
		cx.lastIndex = 0;
		if (cx.test(text)) {
			text = text.replace(cx, function (a) {
				return '\\u' + ('0000' + a.charCodeAt(0).toString(16)).slice(-4);
			});
		}
		if (/^[\],:{}\s]*$/.
		test(text.replace(/\\(?:["\\\/bfnrt]|u[0-9a-fA-F]{4})/g, '@').
		replace(/"[^"\\\n\r]*"|true|false|null|-?\d+(?:\.\d*)?(?:[eE][+\-]?\d+)?/g, ']').
		replace(/(?:^|:|,)(?:\s*\[)+/g, ''))) {
			return eval('(' + text + ')');
		}
		throw 'JSON parse error';
	},
	getParam : function(url, name) {
		return url.match(new RegExp('[?&]' + name + '=([^?&]+)', 'i')) ? unescape(RegExp.$1) : '';
	},
	createRange : function(doc) {
		return doc.body.createTextRange ? doc.body.createTextRange() : doc.createRange();
	},
	getNodeType : function(node) {
		return (node.nodeType == 1 && KE.util.inArray(node.tagName.toLowerCase(), KE.setting.noEndTags)) ? 88 : node.nodeType;
	},
	inMarquee : function(node) {
		var n = node, nodeName;
		while (n) {
			nodeName = n.nodeName.toLowerCase();
			if (nodeName == 'marquee' || nodeName == 'select') return true;
			n = n.parentNode;
		}
		return false;
	},
	moveToElementText : function (range, el) {
		if (!this.inMarquee(el)) range.moveToElementText(el);
	},
	getNodeTextLength : function(node) {
		var type = KE.util.getNodeType(node);
		if (type == 1) {
			var html = node.innerHTML;
			return html.replace(/<.*?>/ig, "").length;
		} else if (type == 3) {
			return node.nodeValue.length;
		}
	},
	getNodeStartRange : function(doc, node) {
		var range = KE.util.createRange(doc);
		var type = node.nodeType;
		if (type == 1) {
			KE.util.moveToElementText(range, node);
			return range;
		} else if (type == 3) {
			var offset = 0;
			var sibling = node.previousSibling;
			while (sibling) {
				if (sibling.nodeType == 1) {
					var nodeRange = KE.util.createRange(doc);
					KE.util.moveToElementText(nodeRange, sibling);
					range.setEndPoint('StartToEnd', nodeRange);
					range.moveStart('character', offset);
					return range;
				} else if (sibling.nodeType == 3) {
					offset += sibling.nodeValue.length;
				}
				sibling = sibling.previousSibling;
			}
			KE.util.moveToElementText(range, node.parentNode);
			range.moveStart('character', offset);
			return range;
		}
	},
	removeParent : function(parent) {
		if (parent.hasChildNodes) {
			var node = parent.firstChild;
			while (node) {
				var nextNode = node.nextSibling;
				parent.parentNode.insertBefore(node, parent);
				node = nextNode;
			}
		}
		parent.parentNode.removeChild(parent);
	},
	pluginLang : function(pluginName, doc) {
		KE.each(KE.lang.plugins[pluginName], function (key, val) {
			var span = KE.$('lang.' + key, doc);
			if (span) {
				span.parentNode.insertBefore(doc.createTextNode(val), span);
				span.parentNode.removeChild(span);
			}
		});
	},
	drag : function(id, mousedownObj, moveObj, func) {
		var g = KE.g[id];
		mousedownObj.onmousedown = function(e) {
			var self = this;
			e = e || window.event;
			var pos = KE.util.getCoords(e);
			var objTop = parseInt(moveObj.style.top);
			var objLeft = parseInt(moveObj.style.left);
			var objWidth = moveObj.style.width;
			var objHeight = moveObj.style.height;
			if (objWidth.match(/%$/)) objWidth = moveObj.offsetWidth + 'px';
			if (objHeight.match(/%$/)) objHeight = moveObj.offsetHeight + 'px';
			objWidth = parseInt(objWidth);
			objHeight = parseInt(objHeight);
			var mouseTop = pos.y;
			var mouseLeft = pos.x;
			var scrollPos = KE.util.getScrollPos();
			var scrollTop = scrollPos.y;
			var scrollLeft = scrollPos.x;
			var dragFlag = true;
			function moveListener(e) {
				if (dragFlag) {
					var pos = KE.util.getCoords(e);
					var scrollPos = KE.util.getScrollPos();
					var top = parseInt(pos.y - mouseTop - scrollTop + scrollPos.y);
					var left = parseInt(pos.x - mouseLeft - scrollLeft + scrollPos.x);
					func(objTop, objLeft, objWidth, objHeight, top, left);
				}
			}
			var iframePos = KE.util.getElementPos(g.iframe);
			function iframeMoveListener(e) {
				if (dragFlag) {
					var pos = KE.util.getCoords(e, g.iframeDoc);
					var top = parseInt(iframePos.y + pos.y - mouseTop - scrollTop);
					var left = parseInt(iframePos.x + pos.x - mouseLeft - scrollLeft);
					func(objTop, objLeft, objWidth, objHeight, top, left);
				}
			}
			var selectListener = function() { return false; };
			function upListener(e) {
				dragFlag = false;
				if (self.releaseCapture) self.releaseCapture();
				KE.event.remove(document, 'mousemove', moveListener);
				KE.event.remove(document, 'mouseup', upListener);
				KE.event.remove(g.iframeDoc, 'mousemove', iframeMoveListener);
				KE.event.remove(g.iframeDoc, 'mouseup', upListener);
				KE.event.remove(document, 'selectstart', selectListener);
				KE.event.stop(e);
				return false;
			}
			KE.event.add(document, 'mousemove', moveListener);
			KE.event.add(document, 'mouseup', upListener);
			KE.event.add(g.iframeDoc, 'mousemove', iframeMoveListener);
			KE.event.add(g.iframeDoc, 'mouseup', upListener);
			KE.event.add(document, 'selectstart', selectListener);
			if (self.setCapture) self.setCapture();
			KE.event.stop(e);
			return false;
		};
	},
	resize : function(id, width, height, isCheck, isResizeWidth) {
		isResizeWidth = (typeof isResizeWidth == "undefined") ? true : isResizeWidth;
		var g = KE.g[id];
		if (!g.container) return;
		if (isCheck && (parseInt(width) <= g.minWidth || parseInt(height) <= g.minHeight)) return;
		if (isResizeWidth) g.container.style.width = width;
		if (KE.browser.IE) {
			//improve IE performance (issue #126)
			var temp = g.toolbarTable && g.toolbarTable.offsetHeight;
		}
		g.container.style.height = height;
		var diff = parseInt(height) - g.toolbarHeight - g.statusbarHeight;
		if (diff >= 0) {
			g.iframe.style.height = diff + 'px';
			g.newTextarea.style.height = (((KE.browser.IE && KE.browser.VERSION < 8 || document.compatMode != 'CSS1Compat') && diff >= 2) ? diff - 2 : diff) + 'px';
		}
	},
	hideLoadingPage : function(id) {
		var stack = KE.g[id].dialogStack;
		var dialog = stack[stack.length - 1];
		dialog.loading.style.display = 'none';
		dialog.iframe.style.display = '';
	},
	showLoadingPage : function(id) {
		var stack = KE.g[id].dialogStack;
		var dialog = stack[stack.length - 1];
		dialog.loading.style.display = '';
		dialog.iframe.style.display = 'none';
	},
	setDefaultPlugin : function(id) {
		var items = [
			'selectall', 'justifyleft', 'justifycenter', 'justifyright', 'justifyfull',
			'insertorderedlist', 'insertunorderedlist', 'indent', 'outdent', 'subscript',
			'superscript', 'bold', 'italic', 'underline', 'strikethrough'
		];
		var shortcuts = {
			bold : 'B',
			italic : 'I',
			underline : 'U'
		};
		for (var i = 0; i < items.length; i++) {
			var item = items[i],
				plugin = {};
			if (item in shortcuts) {
				plugin.init = (function(item) {
					return function(id) {
						KE.event.ctrl(KE.g[id].iframeDoc, shortcuts[item], function(e) {
							KE.plugin[item].click(id);
							KE.util.focus(id);
						}, id);
					};
				})(item);
			}
			plugin.click = (function(item) {
				return function(id) {
					KE.util.execCommand(id, item, null);
				};
			})(item);
			KE.plugin[item] = plugin;
		}
	},
	getFullHtml : function(id) {
		var html = '<html>';
		html += '<head>';
		html += '<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />';
		html += '<title>KindEditor</title>';
		html += '<link href="' + KE.g[id].skinsPath + 'common/editor.css?ver=' + escape(KE.version) + '" rel="stylesheet" type="text/css" />';
		var cssPath = KE.g[id].cssPath;
		if (typeof cssPath == 'string') cssPath = [cssPath];
		for (var i = 0, len = cssPath.length; i < len; i++) {
			if (cssPath[i] !== '') html += '<link href="' + cssPath[i] + '" rel="stylesheet" type="text/css" />';
		}
		html += '</head>';
		html += '<body class="ke-content"></body>';
		html += '</html>';
		return html;
	},
	getMediaType : function(src) {
		if (src.match(/\.(rm|rmvb)(\?|$)/i)) return 'rm';
		else if (src.match(/\.(swf|flv)(\?|$)/i)) return 'flash';
		else return 'media';
	},
	getMediaImage : function(id, type, attrs) {
		var width = attrs.width;
		var height = attrs.height;
		type = type || this.getMediaType(attrs.src);
		var srcTag = this.getMediaEmbed(attrs);
		var style = '';
		if (width > 0) style += 'width:' + width + 'px;';
		if (height > 0) style += 'height:' + height + 'px;';
		var className = 'ke-' + type;
		var html = '<img class="' + className + '" src="' + KE.g[id].skinsPath + 'common/blank.gif" ';
		if (style !== '') html += 'style="' + style + '" ';
		html += 'kesrctag="' + escape(srcTag) + '" alt="" />';
		return html;
	},
	getMediaEmbed : function(attrs) {
		var html = '<embed ';
		KE.each(attrs, function(key, val) {
			html += key + '="' + val + '" ';
		});
		html += '/>';
		return html;
	},
	execGetHtmlHooks : function(id, html) {
		var hooks = KE.g[id].getHtmlHooks;
		for (var i = 0, len = hooks.length; i < len; i++) {
			html = hooks[i](html);
		}
		return html;
	},
	execSetHtmlHooks : function(id, html) {
		var hooks = KE.g[id].setHtmlHooks;
		for (var i = 0, len = hooks.length; i < len; i++) {
			html = hooks[i](html);
		}
		return html;
	},
	execOnchangeHandler : function(id) {
		var handlers = KE.g[id].onchangeHandlerStack;
		for (var i = 0, len = handlers.length; i < len; i++) {
			handlers[i]();
		}
	},
	toData : function(id, srcData) {
		var g = KE.g[id];
		var html = this.execGetHtmlHooks(id, srcData);
		html = html.replace(/^\s*<br[^>]*>\s*$/ig, '');
		html = html.replace(/^\s*<p>\s*&nbsp;\s*<\/p>\s*$/ig, '');
		if (g.filterMode) {
			return KE.format.getHtml(html, g.htmlTags, g.urlType);
		} else {
			return KE.format.getHtml(html, null, g.urlType);
		}
	},
	getData : function(id, wyswygMode) {
		var g = KE.g[id];
		wyswygMode = (wyswygMode === undefined) ? g.wyswygMode : wyswygMode;
		if (!wyswygMode) {
			this.innerHtml(g.iframeDoc.body, KE.util.execSetHtmlHooks(id, g.newTextarea.value));
		}
		return this.toData(id, g.iframeDoc.body.innerHTML);
	},
	getSrcData : function(id) {
		var g = KE.g[id];
		if (!g.wyswygMode) {
			this.innerHtml(g.iframeDoc.body, KE.util.execSetHtmlHooks(id, g.newTextarea.value));
		}
		return g.iframeDoc.body.innerHTML;
	},
	getPureData : function(id) {
		return this.extractText(this.getData(id));
	},
	extractText : function(str) {
		str = str.replace(/<(?!img|embed).*?>/ig, '');
		str = str.replace(/&nbsp;/ig, ' ');
		return str;
	},
	isEmpty : function(id) {
		return this.getPureData(id).replace(/\r\n|\n|\r/, '').replace(/^\s+|\s+$/, '') === '';
	},
	setData : function(id) {
		var g = KE.g[id];
		if (g.srcTextarea) g.srcTextarea.value = this.getData(id);
	},
	focus : function(id) {
		var g = KE.g[id];
		if (g.wyswygMode) {
			g.iframeWin.focus();
		} else {
			g.newTextarea.focus();
		}
	},
	click : function(id, cmd) {
		this.focus(id);
		KE.hideMenu(id);
		KE.plugin[cmd].click(id);
	},
	selection : function(id) {
		if (!KE.browser.IE || !KE.g[id].keRange) {
			this.setSelection(id);
		}
	},
	setSelection : function(id) {
		var g = KE.g[id];
		var keSel = new KE.selection(g.iframeDoc);
		if (!KE.browser.IE || keSel.range.item || keSel.range.parentElement().ownerDocument === g.iframeDoc) {
			g.keSel = keSel;
			g.keRange = g.keSel.keRange;
			g.sel = g.keSel.sel;
			g.range = g.keSel.range;
		}
	},
	select : function(id) {
		if (KE.browser.IE && KE.g[id].wyswygMode && KE.g[id].range) KE.g[id].range.select();
	},
	execCommand : function(id, cmd, value) {
		KE.util.focus(id);
		KE.util.select(id);
		try {
			KE.g[id].iframeDoc.execCommand(cmd, false, value);
		} catch(e) {}
		KE.toolbar.updateState(id);
		KE.util.execOnchangeHandler(id);
	},
	innerHtml : function(el, html) {
		if (KE.browser.IE) {
			el.innerHTML = '<img id="__ke_temp_tag__" width="0" height="0" />' + html;
			var temp = KE.$('__ke_temp_tag__', el.ownerDocument);
			if (temp) temp.parentNode.removeChild(temp);
		} else {
			el.innerHTML = html;
		}
	},
	pasteHtml : function(id, html, isStart) {
		var g = KE.g[id];
		var imgStr = '<img id="__ke_temp_tag__" width="0" height="0" />';
		if (isStart) html = imgStr + html;
		else html += imgStr;
		if (KE.browser.IE) {
			if (g.range.item) g.range.item(0).outerHTML = html;
			else g.range.pasteHTML('\u200B' + html);
		} else {
			g.range.deleteContents();
			var frag = g.range.createContextualFragment(html);
			g.range.insertNode(frag);
		}
		var node = KE.$('__ke_temp_tag__', g.iframeDoc);
		var blank = g.iframeDoc.createTextNode('');
		node.parentNode.replaceChild(blank, node);
		g.keRange.selectNode(blank);
		g.keSel.addRange(g.keRange);
	},
	insertHtml : function(id, html) {
		if (html === '') return;
		var g = KE.g[id];
		if (!g.wyswygMode) return;
		if (!g.range) return;
		html = this.execSetHtmlHooks(id, html);
		if (KE.browser.IE) {
			this.select(id);
			if (g.range.item) {
				try {
					g.range.item(0).outerHTML = html;
				} catch(e) {
					var el = g.range.item(0);
					var parent = el.parentNode;
					parent.removeChild(el);
					if (parent.nodeName.toLowerCase() != 'body') parent = parent.parentNode;
					this.innerHtml(parent, html + parent.innerHTML);
				}
			} else {
				g.range.pasteHTML('\u200B' + html);
			}
		} else if (KE.browser.GECKO && KE.browser.VERSION < 3) {
			this.execCommand(id, 'inserthtml', html);
			return;
		} else {
			this.pasteHtml(id, html);
		}
		KE.util.execOnchangeHandler(id);
	},
	setFullHtml : function(id, html) {
		var g = KE.g[id];
		if (!KE.browser.IE && html === '') html = '<br />';
		var html = KE.util.execSetHtmlHooks(id, html);
		this.innerHtml(g.iframeDoc.body, html);
		if (!g.wyswygMode) g.newTextarea.value = KE.util.getData(id, true);
		KE.util.execOnchangeHandler(id);
	},
	selectImageWebkit : function(id, e, isSelection) {
		if (KE.browser.WEBKIT) {
			var target = e.srcElement || e.target;
			if (target.tagName.toLowerCase() == 'img') {
				if (isSelection) KE.util.selection(id);
				var range = KE.g[id].keRange;
				range.selectNode(target);
				KE.g[id].keSel.addRange(range);
			}
		}
	},
	addTabEvent : function(id) {
		var g = KE.g[id];
		KE.event.add(g.iframeDoc, 'keydown', function(e) {
			if (e.keyCode == 9) {
				if (g.afterTab) g.afterTab(id);
				KE.event.stop(e);
				return false;
			}
		}, id);
	},
	addContextmenuEvent : function(id) {
		var g = KE.g[id];
		if (g.contextmenuItems.length == 0) return;
		if (!g.useContextmenu) return;
		KE.event.add(g.iframeDoc, 'contextmenu', function(e){
			KE.hideMenu(id);
			KE.util.setSelection(id);
			KE.util.selectImageWebkit(id, e, false);
			var maxWidth = 0;
			var items = [];
			for (var i = 0, len = g.contextmenuItems.length; i < len; i++) {
				var item = g.contextmenuItems[i];
				if (item === '-') {
					items.push(item);
				} else if (item.cond && item.cond(id)) {
					items.push(item);
					if (item.options) {
						var width = parseInt(item.options.width) || 0;
						if (width > maxWidth) maxWidth = width;
					}
				}
				prevItem = item;
			}
			while (items.length > 0 && items[0] === '-') {
				items.shift();
			}
			while (items.length > 0 && items[items.length - 1] === '-') {
				items.pop();
			}
			var prevItem = null;
			for (var i = 0, len = items.length; i < len; i++) {
				if (items[i] === '-' && prevItem === '-') delete items[i];
				prevItem = items[i] || null;
			}
			if (items.length > 0) {
				var menu = new KE.menu({
					id : id,
					event : e,
					type : 'contextmenu',
					width : maxWidth
				});
				for (var i = 0, len = items.length; i < len; i++) {
					var item = items[i];
					if (!item) continue;
					if (item === '-') {
						if (i < len - 1) menu.addSeparator();
					} else {
						menu.add(item.text, (function(item) {
							return function() {
								item.click(id, menu);
							};
						})(item), item.options);
					}
				}
				menu.show();
				KE.event.stop(e);
				return false;
			}
			return true;
		}, id);
	},
	addNewlineEvent : function(id) {
		var g = KE.g[id];
		if (KE.browser.IE && g.newlineTag.toLowerCase() != 'br') return;
		if (KE.browser.GECKO && KE.browser.VERSION < 3 && g.newlineTag.toLowerCase() != 'p') return;
		if (KE.browser.OPERA) return;
		KE.event.add(g.iframeDoc, 'keydown', function(e) {
			if (e.keyCode != 13 || e.shiftKey || e.ctrlKey || e.altKey) return true;
			KE.util.setSelection(id);
			var parent = g.keRange.getParentElement();
			if (KE.util.inMarquee(parent)) return;
			var tagName = parent.tagName.toLowerCase();
			if (g.newlineTag.toLowerCase() == 'br') {
				if (!KE.util.inArray(tagName, ['h1', 'h2', 'h3', 'h4', 'h5', 'h6', 'li'])) {
					KE.util.pasteHtml(id, '<br />');
					var nextNode = g.keRange.startNode.nextSibling;
					if (KE.browser.IE) {
						if (!nextNode) KE.util.pasteHtml(id, '<br />', true);
					} else if (KE.browser.WEBKIT) {
						if (!nextNode) {
							KE.util.pasteHtml(id, '<br />', true);
						} else {
							var range = new KE.range(g.iframeDoc);
							range.selectNode(nextNode.parentNode);
							range.setStart(nextNode, 0);
							if (range.cloneContents().innerHTML.replace(/<(?!img|embed).*?>/ig, '') === '') {
								KE.util.pasteHtml(id, '<br />', true);
							}
						}
					}
					KE.event.stop(e);
					return false;
				}
			} else {
				if (!KE.util.inArray(tagName, ['p', 'h1', 'h2', 'h3', 'h4', 'h5', 'h6', 'pre', 'div', 'li'])) {
					KE.util.execCommand(id, 'formatblock', '<P>');
				}
			}
			return true;
		}, id);
	}
};

KE.layout = {
	hide : function(id) {
		var g = KE.g[id];
		KE.hideMenu(id);
		var stack = g.dialogStack;
		while (stack.length > 0) {
			var dialog = stack[stack.length - 1];
			dialog.hide();
		}
		g.maskDiv.style.display = 'none';
	}
};

KE.hideMenu = function(id) {
	var g = KE.g[id];
	g.hideDiv.innerHTML = '';
	g.hideDiv.style.display = 'none';
};

KE.colorpicker = function(arg) {
	var wrapper;
	var x = arg.x || 0;
	var y = arg.y || 0;
	var z = arg.z || 0;
	var colors = arg.colors || KE.setting.colorTable;
	var doc = arg.doc || document;
	var onclick = arg.onclick;
	var selectedColor = (arg.selectedColor || '').toLowerCase();
	function init() {
		wrapper = KE.$$('div');
		wrapper.className = 'ke-colorpicker';
		wrapper.style.top = y + 'px';
		wrapper.style.left = x + 'px';
		wrapper.style.zIndex = z;
	}
	init.call(this);
	this.remove = function() {
		doc.body.removeChild(wrapper);
	};
	this.getElement = function() {
		function addAttr(cell, color, cls) {
			if (selectedColor === color.toLowerCase()) cls += ' ke-colorpicker-cell-selected';
			cell.className = cls;
			cell.title = color || KE.lang['noColor'];
			cell.onmouseover = function() { this.className = cls + ' ke-colorpicker-cell-on'; };
			cell.onmouseout = function() { this.className = cls; };
			cell.onclick = function() { onclick(color); };
			if (color) {
				var div = KE.$$('div');
				div.className = 'ke-colorpicker-cell-color';
				div.style.backgroundColor = color;
				cell.appendChild(div);
			} else {
				cell.innerHTML = KE.lang['noColor'];
			}
		}
		var table = KE.$$('table');
		table.className = 'ke-colorpicker-table';
		table.cellPadding = 0;
		table.cellSpacing = 0;
		table.border = 0;
		var row = table.insertRow(0),
			cell = row.insertCell(0);
		cell.colSpan = colors[0].length;
		addAttr(cell, '', 'ke-colorpicker-cell-top');
		for (var i = 0; i < colors.length; i++) {
			var row = table.insertRow(i + 1);
			for (var j = 0; j < colors[i].length; j++) {
				var color = colors[i][j],
					cell = row.insertCell(j);
				addAttr(cell, color, 'ke-colorpicker-cell');
			}
		}
		return table;
	};
	this.create = function() {
		wrapper.appendChild(this.getElement());
		KE.event.bind(wrapper, 'click', function(e){});
		KE.event.bind(wrapper, 'mousedown', function(e){});
		doc.body.appendChild(wrapper);
	};
};

KE.menu = function(arg){
	function getPos(width, height) {
		var id = arg.id;
		var x = 0;
		var y = 0;
		if (this.type == 'menu') {
			var obj = KE.g[id].toolbarIcon[arg.cmd];
			var pos = KE.util.getElementPos(obj[0]);
			x = pos.x;
			y = pos.y + obj[0].offsetHeight;
		} else {
			var pos = KE.util.getCoords(arg.event);
			var iframePos = KE.util.getElementPos(KE.g[id].iframe);
			x = pos.x + iframePos.x;
			y = pos.y + iframePos.y + 5;
		}
		if (width > 0 || height > 0) {
			var scrollPos = KE.util.getScrollPos();
			var docEl = KE.util.getDocumentElement();
			var maxLeft = scrollPos.x + docEl.clientWidth - width - 2;
			if (x > maxLeft) x = maxLeft;
		}
		return {x : x, y : y};
	};
	function init() {
		var width = arg.width;
		this.type = (arg.type && arg.type == 'contextmenu') ? arg.type : 'menu';
		var div = KE.$$('div');
		div.className = 'ke-' + this.type;
		div.setAttribute('name', arg.cmd);
		var pos = getPos.call(this, 0, 0);
		div.style.top = pos.y + 'px';
		div.style.left = pos.x + 'px';
		if (arg.width) div.style.width = (/^\d+$/.test(width)) ? width + 'px' : width;
		KE.event.bind(div, 'click', function(e){}, arg.id);
		KE.event.bind(div, 'mousedown', function(e){}, arg.id);
		this.div = div;
	};
	init.call(this);
	this.add = function(html, event, options) {
		var height, iconHtml, checked = false;
		if (options !== undefined) {
			height = options.height;
			iconHtml = options.iconHtml;
			checked = options.checked;
		}
		var self = this;
		var cDiv = KE.$$('div');
		cDiv.className = 'ke-' + self.type + '-item';
		if (height) cDiv.style.height = height;
		var left = KE.$$('div');
		left.className = 'ke-' + this.type + '-left';
		var center = KE.$$('div');
		center.className = 'ke-' + self.type + '-center';
		if (height) center.style.height = height;
		var right = KE.$$('div');
		right.className = 'ke-' + this.type + '-right';
		if (height) right.style.lineHeight = height;
		cDiv.onmouseover = function() {
			this.className = 'ke-' + self.type + '-item ke-' + self.type + '-item-on';
			center.className = 'ke-' + self.type + '-center ke-' + self.type + '-center-on';
		};
		cDiv.onmouseout = function() {
			this.className = 'ke-' + self.type + '-item';
			center.className = 'ke-' + self.type + '-center';
		};
		cDiv.onclick = event;
		cDiv.appendChild(left);
		cDiv.appendChild(center);
		cDiv.appendChild(right);
		if (checked) {
			KE.util.innerHtml(left, '<span class="ke-common-icon ke-common-icon-url ke-icon-checked"></span>');
		} else {
			if (iconHtml) KE.util.innerHtml(left, iconHtml);
		}
		KE.util.innerHtml(right, html);
		this.append(cDiv);
	};
	this.addSeparator = function() {
		var div = KE.$$('div');
		div.className = 'ke-' + this.type + '-separator';
		this.append(div);
	};
	this.append = function(el) {
		this.div.appendChild(el);
	};
	this.insert = function(html) {
		KE.util.innerHtml(this.div, html);
	};
	this.hide = function() {
		KE.hideMenu(arg.id);
	};
	this.show = function() {
		this.hide();
		var id = arg.id;
		KE.g[id].hideDiv.style.display = '';
		KE.g[id].hideDiv.appendChild(this.div);
		var pos = getPos.call(this, this.div.clientWidth, this.div.clientHeight);
		this.div.style.top = pos.y + 'px';
		this.div.style.left = pos.x + 'px';
	};
	this.picker = function(color) {
		var colorTable = KE.g[arg.id].colorTable;
		var picker = new KE.colorpicker({
			colors : colorTable,
			onclick : function(color) { KE.plugin[arg.cmd].exec(arg.id, color); },
			selectedColor : color
		});
		this.append(picker.getElement());
		this.show();
	};
};

KE.dialog = function(arg){
	var self = this;
	this.widthMargin = 30;
	this.heightMargin = 100;
	this.zIndex = 19811214;
	this.width = arg.width;
	this.height = arg.height;
	var minTop, minLeft;
	function setLimitNumber() {
		var docEl = KE.util.getDocumentElement();
		var pos = KE.util.getScrollPos();
		minTop = pos.y;
		minLeft = pos.x;
	}
	function init() {
		this.beforeHide = arg.beforeHide;
		this.afterHide = arg.afterHide;
		this.beforeShow = arg.beforeShow;
		this.afterShow = arg.afterShow;
		this.ondrag = arg.ondrag;
	}
	init.call(this);
	function getPos() {
		var width = this.width + this.widthMargin;
		var height = this.height + this.heightMargin;
		var id = arg.id;
		var g = KE.g[id];
		var x = 0, y = 0;
		if (g.dialogAlignType == 'page') {
			var el = KE.util.getDocumentElement();
			var scrollPos = KE.util.getScrollPos();
			x = Math.round(scrollPos.x + (el.clientWidth - width) / 2);
			y = Math.round(scrollPos.y + (el.clientHeight - height) / 2);
		} else {
			var pos = KE.util.getElementPos(KE.g[id].container);
			var el = g.container;
			var xDiff = Math.round(el.clientWidth / 2) - Math.round(width / 2);
			var yDiff = Math.round(el.clientHeight / 2) - Math.round(height / 2);
			x = xDiff < 0 ? pos.x : pos.x + xDiff;
			y = yDiff < 0 ? pos.y : pos.y + yDiff;
		}
		x = x < 0 ? 0 : x;
		y = y < 0 ? 0 : y;
		return {x : x, y : y};
	};
	this.resize = function(width, height) {
		if (width) this.width = width;
		if (height) this.height = height;
		this.hide();
		this.show();
	};
	this.hide = function() {
		if (this.beforeHide) this.beforeHide(id);
		var id = arg.id;
		var stack = KE.g[id].dialogStack;
		if (stack[stack.length - 1] != this) return;
		var dialog = stack.pop();
		var iframe = dialog.iframe;
		iframe.src = 'javascript:false';
		iframe.parentNode.removeChild(iframe);
		document.body.removeChild(this.div);
		if (stack.length < 1) {
			KE.g[id].maskDiv.style.display = 'none';
		}
		KE.event.remove(window, 'resize', setLimitNumber);
		KE.event.remove(window, 'scroll', setLimitNumber);
		if (this.afterHide) this.afterHide(id);
		KE.util.focus(id);
	};
	this.show = function() {
		if (this.beforeShow) this.beforeShow(id);
		var self = this;
		var id = arg.id;
		var div = KE.$$('div');
		div.className = 'ke-dialog';
		KE.event.bind(div, 'click', function(e){}, id);
		var stack = KE.g[id].dialogStack;
		if (stack.length > 0) {
			this.zIndex = stack[stack.length - 1].zIndex + 1;
		}
		div.style.zIndex = this.zIndex;
		var pos = getPos.call(this);
		div.style.top = pos.y + 'px';
		div.style.left = pos.x + 'px';
		var contentCell;
		if (KE.g[id].shadowMode) {
			var table = KE.$$('table');
			table.className = 'ke-dialog-table';
			table.cellPadding = 0;
			table.cellSpacing = 0;
			table.border = 0;
			var rowNames = ['t', 'm', 'b'];
			var colNames = ['l', 'c', 'r'];
			for (var i = 0, len = 3; i < len; i++) {
				var row = table.insertRow(i);
				for (var j = 0, l = 3; j < l; j++) {
					var cell = row.insertCell(j);
					cell.className = 'ke-' + rowNames[i] + colNames[j];
					if (i == 1 && j == 1) contentCell = cell;
					else cell.innerHTML = '<span class="ke-dialog-empty"></span>';
				}
			}
			div.appendChild(table);
		} else {
			KE.addClass(div, 'ke-dialog-no-shadow');
			contentCell = div;
		}
		var titleDiv = KE.$$('div');
		titleDiv.className = 'ke-dialog-title';
		titleDiv.innerHTML = arg.title;
		var span = KE.$$('span');
		span.className = 'ke-dialog-close';
		if (KE.g[id].shadowMode) KE.addClass(span, 'ke-dialog-close-shadow');
		else KE.addClass(span, 'ke-dialog-close-no-shadow');
		span.alt = KE.lang['close'];
		span.title = KE.lang['close'];
		span.onclick = function () {
			self.hide();
			KE.util.select(id);
		};
		titleDiv.appendChild(span);
		setLimitNumber();
		KE.event.add(window, 'resize', setLimitNumber);
		KE.event.add(window, 'scroll', setLimitNumber);
		KE.util.drag(id, titleDiv, div, function(objTop, objLeft, objWidth, objHeight, top, left) {
			if (self.ondrag) self.ondrag(id);
			setLimitNumber();
			top = objTop + top;
			left = objLeft + left;
			if (top < minTop) top = minTop;
			if (left < minLeft) left = minLeft;
			div.style.top = top + 'px';
			div.style.left = left + 'px';
		});
		contentCell.appendChild(titleDiv);
		var bodyDiv = KE.$$('div');
		bodyDiv.className = 'ke-dialog-body';
		var loadingTable = KE.util.createTable();
		loadingTable.table.className = 'ke-loading-table';
		loadingTable.table.style.width = this.width + 'px';
		loadingTable.table.style.height = this.height + 'px';
		var loadingImg = KE.$$('span');
		loadingImg.className = 'ke-loading-img';
		loadingTable.cell.appendChild(loadingImg);
		var iframe = (KE.g[id].dialogStack.length == 0 && KE.g[id].dialog) ? KE.g[id].dialog : KE.$$('iframe');
		if (arg.useFrameCSS) {
			iframe.className = 'ke-dialog-iframe ke-dialog-iframe-border';
		} else {
			iframe.className = 'ke-dialog-iframe';
		}
		iframe.setAttribute("frameBorder", "0");
		iframe.style.width = this.width + 'px';
		iframe.style.height = this.height + 'px';
		iframe.style.display = 'none';
		bodyDiv.appendChild(iframe);
		bodyDiv.appendChild(loadingTable.table);
		contentCell.appendChild(bodyDiv);

		var bottomDiv = KE.$$('div');
		bottomDiv.className = 'ke-dialog-bottom';
		var noButton = null;
		var yesButton = null;
		var previewButton = null;
		if (arg.previewButton) {
			previewButton = KE.$$('input');
			previewButton.className = 'ke-button ke-dialog-preview';
			previewButton.type = 'button';
			previewButton.name = 'previewButton';
			previewButton.value = arg.previewButton;
			previewButton.onclick = function() {
				var stack = KE.g[id].dialogStack;
				if (stack[stack.length - 1] == self) {
					KE.plugin[arg.cmd].preview(id);
				}
			};
			bottomDiv.appendChild(previewButton);
		}
		if (arg.yesButton) {
			yesButton = KE.$$('input');
			yesButton.className = 'ke-button ke-dialog-yes';
			yesButton.type = 'button';
			yesButton.name = 'yesButton';
			yesButton.value = arg.yesButton;
			yesButton.onclick = function() {
				var stack = KE.g[id].dialogStack;
				if (stack[stack.length - 1] == self) {
					KE.plugin[arg.cmd].exec(id);
				}
			};
			bottomDiv.appendChild(yesButton);
		}
		if (arg.noButton) {
			noButton = KE.$$('input');
			noButton.className = 'ke-button ke-dialog-no';
			noButton.type = 'button';
			noButton.name = 'noButton';
			noButton.value = arg.noButton;
			noButton.onclick = function () {
				self.hide();
				KE.util.select(id);
			};
			bottomDiv.appendChild(noButton);
		}
		if (arg.yesButton || arg.noButton || arg.previewButton) {
			contentCell.appendChild(bottomDiv);
		}
		document.body.appendChild(div);
		window.focus();
		if (yesButton) yesButton.focus();
		else if (noButton) noButton.focus();
		if (arg.html !== undefined) {
			var dialogDoc = KE.util.getIframeDoc(iframe);
			var html = KE.util.getFullHtml(id);
			dialogDoc.open();
			dialogDoc.write(html);
			dialogDoc.close();
			KE.util.innerHtml(dialogDoc.body, arg.html);
		} else if (arg.url !== undefined) {
			iframe.src = arg.url;
		} else {
			var param = 'id=' + escape(id) + '&ver=' + escape(KE.version);
			if (arg.file === undefined) {
				iframe.src = KE.g[id].pluginsPath + arg.cmd + '.html?' + param;
			} else {
				param = (/\?/.test(arg.file) ? '&' : '?') + param;
				iframe.src = KE.g[id].pluginsPath + arg.file + param;
			}
		}
		KE.g[id].maskDiv.style.width = KE.util.getDocumentWidth() + 'px';
		KE.g[id].maskDiv.style.height = KE.util.getDocumentHeight() + 'px';
		KE.g[id].maskDiv.style.display = 'block';
		this.iframe = iframe;
		this.loading = loadingTable.table;
		this.noButton = noButton;
		this.yesButton = yesButton;
		this.previewButton = previewButton;
		this.div = div;
		KE.g[id].dialogStack.push(this);
		KE.g[id].dialog = iframe;
		KE.g[id].yesButton = yesButton;
		KE.g[id].noButton = noButton;
		KE.g[id].previewButton = previewButton;
		if (!arg.loadingMode) KE.util.hideLoadingPage(id);
		if (this.afterShow) this.afterShow(id);
		if (KE.g[id].afterDialogCreate) KE.g[id].afterDialogCreate(id);
	};
};

KE.toolbar = {
	updateState : function(id) {
		var cmdList = [
			'justifyleft', 'justifycenter', 'justifyright',
			'justifyfull', 'insertorderedlist', 'insertunorderedlist', 'indent', 'outdent', 'subscript','superscript',
			'bold', 'italic', 'underline', 'strikethrough'
		];
		for (var i = 0; i < cmdList.length; i++) {
			var cmd = cmdList[i];
			var state = false;
			try {
				state = KE.g[id].iframeDoc.queryCommandState(cmd);
			} catch(e) {}
			if (state) {
				KE.toolbar.select(id, cmd);
			} else {
				KE.toolbar.unselect(id, cmd);
			}
		}
	},
	isSelected : function(id, cmd) {
		if (KE.plugin[cmd] && KE.plugin[cmd].isSelected) return true;
		else return false;
	},
	select : function(id, cmd) {
		if (KE.g[id].toolbarIcon[cmd]) {
			var a = KE.g[id].toolbarIcon[cmd][0];
			a.className = 'ke-icon ke-icon-selected';
			a.onmouseover = null;
			a.onmouseout = null;
		}
	},
	unselect : function(id, cmd) {
		if (KE.g[id].toolbarIcon[cmd]) {
			var a = KE.g[id].toolbarIcon[cmd][0];
			a.className = 'ke-icon';
			a.onmouseover = function(){ this.className = 'ke-icon ke-icon-on'; };
			a.onmouseout = function(){ this.className = 'ke-icon'; };
		}
	},
	_setAttr : function(id, a, cmd) {
		a.className = 'ke-icon';
		a.href = 'javascript:;';
		a.onclick = function(e) {
			e = e || window.event;
			var div = KE.g[id].hideDiv.firstChild;
			if (div && div.getAttribute('name') == cmd) {
				KE.hideMenu(id);
			} else {
				KE.util.click(id, cmd);
			}
			if (e.preventDefault) e.preventDefault();
			if (e.stopPropagation) e.stopPropagation();
			if (e.cancelBubble !== undefined) e.cancelBubble = true;
			return false;
		};
		a.onmouseover = function(){ this.className = 'ke-icon ke-icon-on'; };
		a.onmouseout = function(){ this.className = 'ke-icon'; };
		a.hidefocus = true;
		a.title = KE.lang[cmd];
	},
	able : function(id, arr) {
		var self = this;
		KE.each(KE.g[id].toolbarIcon, function(cmd, obj) {
			if (!KE.util.inArray(cmd, arr)) {
				var a = obj[0];
				var span = obj[1];
				self._setAttr(id, a, cmd);
				KE.util.setOpacity(span, 100);
			}
		});
	},
	disable : function(id, arr) {
		KE.each(KE.g[id].toolbarIcon, function(cmd, obj) {
			if (!KE.util.inArray(cmd, arr)) {
				var a = obj[0];
				var span = obj[1];
				a.className = 'ke-icon ke-icon-disabled';
				KE.util.setOpacity(span, 50);
				a.onclick = null;
				a.onmouseover = null;
				a.onmouseout = null;
			}
		});
	},
	create : function(id) {
		var self = this;
		var defaultItemHash = KE.util.arrayToHash(KE.setting.items);
		KE.g[id].toolbarIcon = [];
		var tableObj = KE.util.createTable();
		var toolbar = tableObj.table;
		toolbar.className = 'ke-toolbar';
		toolbar.oncontextmenu = function() { return false; };
		toolbar.onmousedown = function() { return false; };
		toolbar.onmousemove = function() { return false; };
		var toolbarCell = tableObj.cell;
		var length = KE.g[id].items.length;
		var cellNum = 0;
		var row;
		KE.g[id].toolbarHeight = KE.g[id].toolbarLineHeight;
		for (var i = 0; i < length; i++) {
			var cmd = KE.g[id].items[i];
			if (i == 0 || cmd == '-') {
				var table = KE.util.createTable().table;
				table.className = 'ke-toolbar-table';
				row = table.insertRow(0);
				cellNum = 0;
				toolbarCell.appendChild(table);
				if (cmd == '-') {
					KE.g[id].toolbarHeight += KE.g[id].toolbarLineHeight;
					continue;
				}
			}
			var cell = row.insertCell(cellNum);
			cell.hideforcus = true;
			cellNum++;
			if (cmd == '|') {
				var div = KE.$$('div');
				div.className = 'ke-toolbar-separator';
				cell.appendChild(div);
				continue;
			}
			var a = KE.$$('a');
			a.tabIndex = -1;
			self._setAttr(id, a, cmd);
			var span = KE.$$('span');
			if (typeof defaultItemHash[cmd] == 'undefined') {
				span.className = 'ke-common-icon ke-icon-' + cmd;
			} else {
				span.className = 'ke-common-icon ke-common-icon-url ke-icon-' + cmd;
			}
			a.appendChild(span);
			cell.appendChild(a);
			KE.g[id].toolbarIcon[cmd] = [a, span];
			if (KE.toolbar.isSelected(id, cmd)) KE.toolbar.select(id, cmd);
		}
		return toolbar;
	}
};

KE.history = {
	addStackData : function(stack, data) {
		var prev = '';
		if (stack.length > 0) {
			prev = stack[stack.length - 1];
		}
		if (stack.length == 0 || data !== prev) stack.push(data);
	},
	add : function(id, minChangeSize) {
		var g = KE.g[id];
		var html = KE.util.getSrcData(id);
		if (g.undoStack.length > 0) {
			var prevHtml = g.undoStack[g.undoStack.length - 1];
			if (Math.abs(html.length - prevHtml.length) < minChangeSize) return;
		}
		this.addStackData(g.undoStack, html);
	},
	undo : function(id) {
		var g = KE.g[id];
		if (g.undoStack.length == 0) return;
		var html = KE.util.getSrcData(id);
		this.addStackData(g.redoStack, html);
		var prevHtml = g.undoStack.pop();
		if (html === prevHtml && g.undoStack.length > 0) {
			prevHtml = g.undoStack.pop();
		}
		prevHtml = KE.util.toData(id, prevHtml);
		if (g.wyswygMode) {
			KE.util.innerHtml(g.iframeDoc.body, KE.util.execSetHtmlHooks(id, prevHtml));
		} else {
			g.newTextarea.value = prevHtml;
		}
	},
	redo : function(id) {
		var g = KE.g[id];
		if (g.redoStack.length == 0) return;
		var html = KE.util.getSrcData(id);
		this.addStackData(g.undoStack, html);
		var nextHtml = g.redoStack.pop();
		nextHtml = KE.util.toData(id, nextHtml);
		if (g.wyswygMode) {
			KE.util.innerHtml(g.iframeDoc.body, KE.util.execSetHtmlHooks(id, nextHtml));
		} else {
			g.newTextarea.value = nextHtml;
		}
	}
};

KE.readonly = function(id, isReadonly) {
	isReadonly = isReadonly == undefined ? true : isReadonly;
	var g = KE.g[id];
	if (KE.browser.IE) g.iframeDoc.body.contentEditable = isReadonly ? 'false' : 'true';
	else g.iframeDoc.designMode = isReadonly ? 'off' : 'on';
};

KE.focus = function(id, position) {
	position = (position || '').toLowerCase();
	if (!KE.g[id].container) return;
	KE.util.focus(id);
	if (position === 'end') {
		KE.util.setSelection(id);
		if (!KE.g[id].sel) return; //issue #120: Sometimes Firefox does not get selection
		var sel = KE.g[id].keSel,
			range = KE.g[id].keRange,
			doc = KE.g[id].iframeDoc;
		range.selectTextNode(doc.body);
		range.collapse(false);
		sel.addRange(range);
	}
};

KE.blur = function(id) {
	var g = KE.g[id];
	if (!g.container) return;
	if (KE.browser.IE) {
		var input = KE.$$('input');
		input.type = 'text';
		g.container.appendChild(input);
		input.focus();
		g.container.removeChild(input);
	} else {
		g.wyswygMode ? g.iframeWin.blur() : g.newTextarea.blur();
	}
};

KE.html = function(id, val) {
	if (val === undefined) {
		return KE.util.getData(id);
	} else {
		if (!KE.g[id].container) return;
		KE.util.setFullHtml(id, val);
		KE.focus(id);
	}
};

KE.text = function(id, val) {
	if (val === undefined) {
		val = KE.html(id);
		val = val.replace(/<.*?>/ig, '');
		val = val.replace(/&nbsp;/ig, ' ');
		val = KE.util.trim(val);
		return val;
	} else {
		KE.html(id, KE.util.escape(val));
	}
};

KE.insertHtml = function(id, val) {
	if (!KE.g[id].container) return;
	var range = KE.g[id].range;
	if (!range) {
		KE.appendHtml(id, val);
	} else {
		KE.focus(id);
		KE.util.selection(id);
		KE.util.insertHtml(id, val);
	}
};

KE.appendHtml = function(id, val) {
	KE.html(id, KE.html(id) + val);
};

KE.isEmpty = function(id) {
	return KE.util.isEmpty(id);
};

KE.selectedHtml = function(id) {
	var range = KE.g[id].range;
	if (!range) return '';
	var html = '';
	if (KE.browser.IE) {
		if (range.item) {
			html = range.item(0).outerHTML;
		} else {
			html = range.htmlText;
		}
	} else {
		var temp = KE.$$('div', KE.g[id].iframeDoc);
		temp.appendChild(range.cloneContents());
		html = temp.innerHTML;
	}
	return KE.util.toData(id, html);
};

KE.count = function(id, mode) {
	mode = (mode || 'html').toLowerCase();
	if (mode === 'html') {
		return KE.html(id).length;
	} else if (mode === 'text') {
		var data = KE.util.getPureData(id);
		data = data.replace(/<(?:img|embed).*?>/ig, 'K');
		data = data.replace(/\r\n|\n|\r/g, '');
		data = KE.util.trim(data);
		return data.length;
	}
	return 0;
};

KE.sync = function(id) {
	return KE.util.setData(id);
};

KE.remove = function(id, mode) {
	var g = KE.g[id];
	if (!g.container) return false;
	mode = (typeof mode == "undefined") ? 0 : mode;
	KE.util.setData(id);
	var container = g.container;
	var eventStack = g.eventStack;
	for (var i = 0, len = eventStack.length; i < len; i++) {
		var item = eventStack[i];
		if (item) KE.event.remove(item.el, item.type, item.fn, id);
	}
	g.iframeDoc.src = 'javascript:false';
	g.iframe.parentNode.removeChild(g.iframe);
	if (mode == 1) {
		document.body.removeChild(container);
	} else {
		var srcTextarea = g.srcTextarea;
		srcTextarea.parentNode.removeChild(container);
		if (mode == 0) srcTextarea.style.display = '';
	}
	document.body.removeChild(g.hideDiv);
	document.body.removeChild(g.maskDiv);
	g.container = null;
	g.dialogStack = [];
	g.contextmenuItems = [];
	g.getHtmlHooks = [];
	g.setHtmlHooks = [];
	g.onchangeHandlerStack = [];
	g.eventStack = [];
};

KE.create = function(id, mode) {
	if (KE.g[id].beforeCreate) KE.g[id].beforeCreate(id);
	if (KE.browser.IE && KE.browser.VERSION < 7) try { document.execCommand('BackgroundImageCache', false, true); }catch(e){}
	var srcTextarea = KE.$(id) || document.getElementsByName(id)[0];
	mode = (typeof mode == "undefined") ? 0 : mode;
	if (mode == 0 && KE.g[id].container) return;
	var width = KE.g[id].width || srcTextarea.style.width || srcTextarea.offsetWidth + 'px';
	var height = KE.g[id].height || srcTextarea.style.height || srcTextarea.offsetHeight + 'px';
	var tableObj = KE.util.createTable();
	var container = tableObj.table;
	container.className = 'ke-container';
	container.style.width = width;
	container.style.height = height;
	var toolbarOuter = tableObj.cell;
	toolbarOuter.className = 'ke-toolbar-outer';
	var textareaOuter = container.insertRow(1).insertCell(0);
	textareaOuter.className = 'ke-textarea-outer';
	tableObj = KE.util.createTable();
	var textareaTable = tableObj.table;
	textareaTable.className = 'ke-textarea-table';
	var textareaCell = tableObj.cell;
	textareaOuter.appendChild(textareaTable);
	var bottomOuter = container.insertRow(2).insertCell(0);
	bottomOuter.className = 'ke-bottom-outer';
	srcTextarea.style.display = 'none';
	if (mode == 1) document.body.appendChild(container);
	else srcTextarea.parentNode.insertBefore(container, srcTextarea);
	var toolbarTable = KE.toolbar.create(id);
	toolbarTable.style.height = KE.g[id].toolbarHeight + 'px';
	toolbarOuter.appendChild(toolbarTable);
	var iframe = KE.g[id].iframe || KE.$$('iframe');
	iframe.tabIndex = KE.g[id].tabIndex || srcTextarea.tabIndex;
	iframe.className = 'ke-iframe';
	iframe.setAttribute("frameBorder", "0");
	var newTextarea = KE.$$('textarea');
	newTextarea.tabIndex = iframe.tabIndex;
	newTextarea.className = 'ke-textarea';
	newTextarea.style.display = 'none';
	KE.g[id].container = container;
	KE.g[id].iframe = iframe;
	KE.g[id].newTextarea = newTextarea;
	KE.util.resize(id, width, height);
	textareaCell.appendChild(iframe);
	textareaCell.appendChild(newTextarea);
	var bottom = KE.$$('table');
	bottom.className = 'ke-bottom';
	bottom.cellPadding = 0;
	bottom.cellSpacing = 0;
	bottom.border = 0;
	bottom.style.height = KE.g[id].statusbarHeight + 'px';
	var row = bottom.insertRow(0);
	var bottomLeft = row.insertCell(0);
	bottomLeft.className = 'ke-bottom-left';
	var leftImg = KE.$$('span');
	leftImg.className = 'ke-bottom-left-img';
	if (KE.g[id].config.resizeMode == 0 || mode == 1) {
		bottomLeft.style.cursor = 'default';
		leftImg.style.visibility = 'hidden';
	}
	bottomLeft.appendChild(leftImg);
	var bottomRight = row.insertCell(1);
	bottomRight.className = 'ke-bottom-right';
	var rightImg = KE.$$('span');
	rightImg.className = 'ke-bottom-right-img';
	if (KE.g[id].config.resizeMode == 0 || mode == 1) {
		bottomRight.style.cursor = 'default';
		rightImg.style.visibility = 'hidden';
	} else if (KE.g[id].config.resizeMode == 1) {
		bottomRight.style.cursor = 's-resize';
		rightImg.style.visibility = 'hidden';
	}
	bottomRight.appendChild(rightImg);
	bottomOuter.appendChild(bottom);
	var hideDiv = KE.$$('div');
	hideDiv.className = 'ke-reset';
	hideDiv.style.display = 'none';
	var maskDiv = KE.$$('div');
	maskDiv.className = 'ke-mask';
	KE.util.setOpacity(maskDiv, 50);
	KE.event.bind(maskDiv, 'click', function(e){}, id);
	KE.event.bind(maskDiv, 'mousedown', function(e){}, id);
	document.body.appendChild(hideDiv);
	document.body.appendChild(maskDiv);
	KE.util.setDefaultPlugin(id);
	var iframeWin = iframe.contentWindow;
	var iframeDoc = KE.util.getIframeDoc(iframe);
	if (!KE.browser.IE) iframeDoc.designMode = 'on';
	var html = KE.util.getFullHtml(id);
	iframeDoc.open();
	iframeDoc.write(html);
	iframeDoc.close();
	if (!KE.g[id].wyswygMode) {
		newTextarea.value = KE.util.execSetHtmlHooks(id, srcTextarea.value);
		newTextarea.style.display = 'block';
		iframe.style.display = 'none';
		KE.toolbar.disable(id, ['source', 'fullscreen']);
		KE.toolbar.select(id, 'source');
	}
	if (KE.g[id].syncType == 'form') {
		var el = srcTextarea;
		while ((el = el.parentNode)) {
			if (el.nodeName.toLowerCase() == 'form') {
				KE.event.add(el, 'submit', function() { KE.sync(id); }, id);
				break;
			}
		}
	}
	function hideMenu() {
		KE.hideMenu(id);
	}
	function updateToolbar() {
		KE.toolbar.updateState(id);
	}
	if (KE.browser.WEBKIT) {
		KE.event.add(iframeDoc, 'click', function(e) {
			KE.util.selectImageWebkit(id, e, true);
		}, id);
	}
	if (KE.browser.IE) {
		KE.event.add(iframeDoc, 'keydown', function(e) {
			if (e.keyCode == 8) {
				var range = KE.g[id].range;
				if (range.item) {
					var item = range.item(0);
					item.parentNode.removeChild(item);
					KE.util.execOnchangeHandler(id);
					KE.event.stop(id);
					return false;
				}
			}
		}, id);
	}
	function afterFocus() {
		if (KE.g[id].afterFocus) KE.g[id].afterFocus(id);
	}
	function afterBlur() {
		if (KE.g[id].afterBlur) KE.g[id].afterBlur(id);
	}
	KE.event.add(iframeDoc, 'mousedown', hideMenu, id);
	KE.event.add(iframeDoc, 'click', updateToolbar, id);
	KE.event.input(iframeDoc, updateToolbar, id);
	KE.event.bind(newTextarea, 'click', hideMenu, id);
	KE.event.add(document, 'click', hideMenu, id);
	KE.event.add(iframeWin, 'focus', afterFocus);
	KE.event.add(newTextarea, 'focus', afterFocus);
	KE.event.add(iframeWin, 'blur', afterBlur);
	KE.event.add(newTextarea, 'blur', afterBlur);
	KE.g[id].toolbarTable = toolbarTable;
	KE.g[id].textareaTable = textareaTable;
	KE.g[id].srcTextarea = srcTextarea;
	KE.g[id].bottom = bottom;
	KE.g[id].hideDiv = hideDiv;
	KE.g[id].maskDiv = maskDiv;
	KE.g[id].iframeWin = iframeWin;
	KE.g[id].iframeDoc = iframeDoc;
	KE.g[id].width = width;
	KE.g[id].height = height;
	KE.util.drag(id, bottomRight, container, function(objTop, objLeft, objWidth, objHeight, top, left) {
		if (KE.g[id].resizeMode == 2) KE.util.resize(id, (objWidth + left) + 'px', (objHeight + top) + 'px', true);
		else if (KE.g[id].resizeMode == 1) KE.util.resize(id, objWidth + 'px', (objHeight + top) + 'px', true, false);
	});
	KE.util.drag(id, bottomLeft, container, function(objTop, objLeft, objWidth, objHeight, top, left) {
		if (KE.g[id].resizeMode > 0) KE.util.resize(id, objWidth + 'px', (objHeight + top) + 'px', true, false);
	});
	KE.each(KE.plugin, function(cmd, plugin) {
		if (plugin.init) plugin.init(id);
	});
	KE.g[id].getHtmlHooks.push(function(html) {
		html = html.replace(/(<[^>]*)kesrc="([^"]+)"([^>]*>)/ig, function(full, start, src, end) {
			full = full.replace(/(\s+(?:href|src)=")[^"]+(")/i, '$1' + src + '$2');
			full = full.replace(/\s+kesrc="[^"]+"/i, '');
			return full;
		});
		html = html.replace(/(<[^>]+\s)ke-(on\w+="[^"]+"[^>]*>)/ig, function(full, start, end) {
			return start + end;
		});
		return html;
	});
	KE.g[id].setHtmlHooks.push(function(html) {
		html = html.replace(/(<[^>]*)(href|src)="([^"]+)"([^>]*>)/ig, function(full, start, key, src, end) {
			if (full.match(/\skesrc="[^"]+"/i)) return full;
			full = start + key + '="' + src + '"' + ' kesrc="' + src + '"' + end;
			return full;
		});
		html = html.replace(/(<[^>]+\s)(on\w+="[^"]+"[^>]*>)/ig, function(full, start, end) {
			return start + 'ke-' + end;
		});
		return html;
	});
	KE.util.addContextmenuEvent(id);
	KE.util.addNewlineEvent(id);
	KE.util.addTabEvent(id);
	function setSelectionHandler() {
		KE.util.setSelection(id);
	}
	KE.event.input(iframeDoc, setSelectionHandler, id);
	KE.event.add(iframeDoc, 'mouseup', setSelectionHandler, id);
	KE.event.add(document, 'mousedown', setSelectionHandler, id);
	KE.onchange(id, function(id) {
		if (KE.g[id].autoSetDataMode || KE.g[id].syncType == 'auto') {
			KE.util.setData(id);
			if (KE.g[id].afterSetData) KE.g[id].afterSetData(id);
		}
		if (KE.g[id].afterChange) KE.g[id].afterChange(id);
		KE.history.add(id, KE.g[id].minChangeSize);
	});
	if (KE.browser.IE) {
		iframeDoc.body.disabled = true;
		KE.readonly(id, false);
		iframeDoc.body.removeAttribute('disabled');
	}
	KE.util.setFullHtml(id, srcTextarea.value);
	KE.history.add(id, 0);
	if (mode > 0) KE.util.focus(id);
	if (KE.g[id].afterCreate) KE.g[id].afterCreate(id);
};

KE.onchange = function(id, func) {
	var g = KE.g[id];
	function handler() {
		func(id);
	};
	g.onchangeHandlerStack.push(handler);
	KE.event.input(g.iframeDoc, handler, id);
	KE.event.input(g.newTextarea, handler, id);
	KE.event.add(g.iframeDoc, 'mouseup', function(e) {
		window.setTimeout(function() {
			func(id);
		}, 0);
	}, id);
};

var _needStyle = true;

KE.init = function(args) {
	var g = KE.g[args.id] = args;
	g.config = {};
	g.undoStack = [];
	g.redoStack = [];
	g.dialogStack = [];
	g.contextmenuItems = [];
	g.getHtmlHooks = [];
	g.setHtmlHooks = [];
	g.onchangeHandlerStack = [];
	g.eventStack = [];
	KE.each(KE.setting, function(key, val) {
		g[key] = (typeof args[key] == 'undefined') ? val : args[key];
		g.config[key] = g[key];
	});
	if (g.loadStyleMode && _needStyle) {
		KE.util.loadStyle(g.skinsPath + g.skinType + '.css');
		_needStyle = false;
	}
}

KE.show = function(args) {
	KE.init(args);
	KE.event.ready(function() { KE.create(args.id); });
};

if (window.KE === undefined) window.KE = KE;
window.KindEditor = KE;

})();

(function (KE, undefined) {

KE.langType = 'zh_CN';

KE.lang = {
	source : 'HTML代码',
	undo : '后退(Ctrl+Z)',
	redo : '前进(Ctrl+Y)',
	cut : '剪切(Ctrl+X)',
	copy : '复制(Ctrl+C)',
	paste : '粘贴(Ctrl+V)',
	plainpaste : '粘贴为无格式文本',
	wordpaste : '从Word粘贴',
	selectall : '全选',
	justifyleft : '左对齐',
	justifycenter : '居中',
	justifyright : '右对齐',
	justifyfull : '两端对齐',
	insertorderedlist : '编号',
	insertunorderedlist : '项目符号',
	indent : '增加缩进',
	outdent : '减少缩进',
	subscript : '下标',
	superscript : '上标',
	title : '标题',
	fontname : '字体',
	fontsize : '文字大小',
	textcolor : '文字颜色',
	bgcolor : '文字背景',
	bold : '粗体(Ctrl+B)',
	italic : '斜体(Ctrl+I)',
	underline : '下划线(Ctrl+U)',
	strikethrough : '删除线',
	removeformat : '删除格式',
	image : '图片',
	flash : '插入Flash',
	media : '插入多媒体',
	table : '插入表格',
	hr : '插入横线',
	emoticons : '插入表情',
	link : '超级链接',
	unlink : '取消超级链接',
	fullscreen : '全屏显示',
	about : '关于',
	print : '打印',
	fileManager : '浏览服务器',
	advtable : '表格',
	yes : '确定',
	no : '取消',
	close : '关闭',
	editImage : '图片属性',
	deleteImage : '删除图片',
	editLink : '超级链接属性',
	deleteLink : '取消超级链接',
	tableprop : '表格属性',
	tableinsert : '插入表格',
	tabledelete : '删除表格',
	tablecolinsertleft : '左侧插入列',
	tablecolinsertright : '右侧插入列',
	tablerowinsertabove : '上方插入行',
	tablerowinsertbelow : '下方插入行',
	tablecoldelete : '删除列',
	tablerowdelete : '删除行',
	noColor : '无颜色',
	invalidImg : "请输入有效的URL地址。\n只允许jpg,gif,bmp,png格式。",
	invalidMedia : "请输入有效的URL地址。\n只允许swf,flv,mp3,wav,wma,wmv,mid,avi,mpg,asf,rm,rmvb格式。",
	invalidWidth : "宽度必须为数字。",
	invalidHeight : "高度必须为数字。",
	invalidBorder : "边框必须为数字。",
	invalidUrl : "请输入有效的URL地址。",
	invalidRows : '行数为必选项，只允许输入大于0的数字。',
	invalidCols : '列数为必选项，只允许输入大于0的数字。',
	invalidPadding : '边距必须为数字。',
	invalidSpacing : '间距必须为数字。',
	invalidBorder : '边框必须为数字。',
	pleaseInput : "请输入内容。",
	invalidJson : '服务器发生故障。',
	cutError : '您的浏览器安全设置不允许使用剪切操作，请使用快捷键(Ctrl+X)来完成。',
	copyError : '您的浏览器安全设置不允许使用复制操作，请使用快捷键(Ctrl+C)来完成。',
	pasteError : '您的浏览器安全设置不允许使用粘贴操作，请使用快捷键(Ctrl+V)来完成。'
};

var plugins = KE.lang.plugins = {};

plugins.about = {
	version : KE.version,
	title : 'HTML可视化编辑器'
};

plugins.plainpaste = {
	comment : '请使用快捷键(Ctrl+V)把内容粘贴到下面的方框里。'
};

plugins.wordpaste = {
	comment : '请使用快捷键(Ctrl+V)把内容粘贴到下面的方框里。'
};

plugins.link = {
	url : 'URL地址',
	linkType : '打开类型',
	newWindow : '新窗口',
	selfWindow : '当前窗口'
};

plugins.flash = {
	url : 'Flash地址',
	width : '宽度',
	height : '高度'
};

plugins.media = {
	url : '媒体文件地址',
	width : '宽度',
	height : '高度',
	autostart : '自动播放'
};

plugins.image = {
	remoteImage : '远程图片',
	localImage : '本地上传',
	remoteUrl : '图片地址',
	localUrl : '图片地址',
	size : '图片大小',
	width : '宽',
	height : '高',
	resetSize : '重置大小',
	align : '对齐方式',
	defaultAlign : '默认方式',
	leftAlign : '左对齐',
	rightAlign : '右对齐',
	imgTitle : '图片说明',
	viewServer : '浏览...'
};

plugins.file_manager = {
	emptyFolder : '空文件夹',
	moveup : '移到上一级文件夹',
	viewType : '显示方式：',
	viewImage : '缩略图',
	listImage : '详细信息',
	orderType : '排序方式：',
	fileName : '名称',
	fileSize : '大小',
	fileType : '类型'
};

plugins.advtable = {
	cells : '单元格数',
	rows : '行数',
	cols : '列数',
	size : '表格大小',
	width : '宽度',
	height : '高度',
	percent : '%',
	px : 'px',
	space : '边距间距',
	padding : '边距',
	spacing : '间距',
	align : '对齐方式',
	alignDefault : '默认',
	alignLeft : '左对齐',
	alignCenter : '居中',
	alignRight : '右对齐',
	border : '表格边框',
	borderWidth : '边框',
	borderColor : '颜色',
	backgroundColor : '背景颜色'
};

plugins.title = {
	h1 : '标题 1',
	h2 : '标题 2',
	h3 : '标题 3',
	h4 : '标题 4',
	p : '正 文'
};

plugins.fontname = {
	fontName : {
		'SimSun' : '宋体',
		'NSimSun' : '新宋体',
		'FangSong_GB2312' : '仿宋_GB2312',
		'KaiTi_GB2312' : '楷体_GB2312',
		'SimHei' : '黑体',
		'Microsoft YaHei' : '微软雅黑',
		'Arial' : 'Arial',
		'Arial Black' : 'Arial Black',
		'Times New Roman' : 'Times New Roman',
		'Courier New' : 'Courier New',
		'Tahoma' : 'Tahoma',
		'Verdana' : 'Verdana'
	}
};

})(KindEditor);

(function (KE, undefined) {

KE.plugin['about'] = {
	click : function(id) {
		KE.util.selection(id);
		var dialog = new KE.dialog({
			id : id,
			cmd : 'about',
			file : 'about.html',
			width : 300,
			height : 70,
			loadingMode : true,
			title : KE.lang['about'],
			noButton : KE.lang['close']
		});
		dialog.show();
	}
};

KE.plugin['undo'] = {
	init : function(id) {
		KE.event.ctrl(KE.g[id].iframeDoc, 'Z', function(e) {
			KE.plugin['undo'].click(id);
			KE.util.focus(id);
		}, id);
		KE.event.ctrl(KE.g[id].newTextarea, 'Z', function(e) {
			KE.plugin['undo'].click(id);
			KE.util.focus(id);
		}, id);
	},
	click : function(id) {
		KE.history.undo(id);
		KE.util.execOnchangeHandler(id);
	}
};

KE.plugin['redo'] = {
	init : function(id) {
		KE.event.ctrl(KE.g[id].iframeDoc, 'Y', function(e) {
			KE.plugin['redo'].click(id);
			KE.util.focus(id);
		}, id);
		KE.event.ctrl(KE.g[id].newTextarea, 'Y', function(e) {
			KE.plugin['redo'].click(id);
			KE.util.focus(id);
		}, id);
	},
	click : function(id) {
		KE.history.redo(id);
		KE.util.execOnchangeHandler(id);
	}
};

KE.plugin['cut'] = {
	click : function(id) {
		try {
			if (!KE.g[id].iframeDoc.queryCommandSupported('cut')) throw 'e';
		} catch(e) {
			alert(KE.lang.cutError);
			return;
		}
		KE.util.execCommand(id, 'cut', null);
	}
};

KE.plugin['copy'] = {
	click : function(id) {
		try {
			if (!KE.g[id].iframeDoc.queryCommandSupported('copy')) throw 'e';
		} catch(e) {
			alert(KE.lang.copyError);
			return;
		}
		KE.util.execCommand(id, 'copy', null);
	}
};

KE.plugin['paste'] = {
	click : function(id) {
		try {
			if (!KE.g[id].iframeDoc.queryCommandSupported('paste')) throw 'e';
		} catch(e) {
			alert(KE.lang.pasteError);
			return;
		}
		KE.util.execCommand(id, 'paste', null);
	}
};

KE.plugin['plainpaste'] = {
	click : function(id) {
		KE.util.selection(id);
		this.dialog = new KE.dialog({
			id : id,
			cmd : 'plainpaste',
			file : 'plainpaste.html',
			width : 450,
			height : 300,
			loadingMode : true,
			title : KE.lang['plainpaste'],
			yesButton : KE.lang['yes'],
			noButton : KE.lang['no']
		});
		this.dialog.show();
	},
	exec : function(id) {
		var dialogDoc = KE.util.getIframeDoc(this.dialog.iframe);
		var html = KE.$('textArea', dialogDoc).value;
		html = KE.util.escape(html);
		html = html.replace(/ /g, '&nbsp;');
		if (KE.g[id].newlineTag == 'p') {
			html = html.replace(/^/, '<p>').replace(/$/, '</p>').replace(/\r\n|\n|\r/g, '</p><p>');
		} else {
			html = html.replace(/\r\n|\n|\r/g, '<br />$&');
		}
		KE.util.insertHtml(id, html);
		this.dialog.hide();
		KE.util.focus(id);
	}
};

KE.plugin['wordpaste'] = {
	click : function(id) {
		KE.util.selection(id);
		this.dialog = new KE.dialog({
			id : id,
			cmd : 'wordpaste',
			file : 'wordpaste.html',
			width : 450,
			height : 300,
			loadingMode : true,
			title : KE.lang['wordpaste'],
			yesButton : KE.lang['yes'],
			noButton : KE.lang['no']
		});
		this.dialog.show();
	},
	exec : function(id) {
		var dialogDoc = KE.util.getIframeDoc(this.dialog.iframe);
		var wordIframe = KE.$('wordIframe', dialogDoc);
		var str = KE.util.getIframeDoc(wordIframe).body.innerHTML;
		str = str.replace(/<meta(\n|.)*?>/ig, "");
		str = str.replace(/<!(\n|.)*?>/ig, "");
		str = str.replace(/<style[^>]*>(\n|.)*?<\/style>/ig, "");
		str = str.replace(/<script[^>]*>(\n|.)*?<\/script>/ig, "");
		str = str.replace(/<w:[^>]+>(\n|.)*?<\/w:[^>]+>/ig, "");
		str = str.replace(/<xml>(\n|.)*?<\/xml>/ig, "");
		str = str.replace(/\r\n|\n|\r/ig, "");
		str = KE.util.execGetHtmlHooks(id, str);
		str = KE.format.getHtml(str, KE.g[id].htmlTags, KE.g[id].urlType);
		KE.util.insertHtml(id, str);
		this.dialog.hide();
		KE.util.focus(id);
	}
};

KE.plugin['fullscreen'] = {
	click : function(id) {
		var g = KE.g[id];
		var self = this;
		var resetSize = function() {
			var el = KE.util.getDocumentElement();
			g.width = el.clientWidth + 'px';
			g.height = el.clientHeight + 'px';
		};
		var windowSize = '';
		var resizeListener = function() {
			if (!self.isSelected) return;
			var el = KE.util.getDocumentElement();
			var size = [el.clientWidth, el.clientHeight].join('');
			if (windowSize != size) {
				windowSize = size;
				resetSize();
				KE.util.resize(id, g.width, g.height);
			}
		}
		if (this.isSelected) {
			this.isSelected = false;
			KE.util.setData(id);
			KE.remove(id, 1);
			g.width = this.width;
			g.height = this.height;
			KE.create(id, 2);
			document.body.parentNode.style.overflow = 'auto';
			KE.event.remove(window, 'resize', resizeListener);
			g.resizeMode = g.config.resizeMode;
			KE.toolbar.unselect(id, "fullscreen");
		} else {
			this.isSelected = true;
			this.width = g.container.style.width;
			this.height = g.container.style.height;
			KE.util.setData(id);
			KE.remove(id, 2);
			document.body.parentNode.style.overflow = 'hidden';
			resetSize();
			KE.create(id, 1);
			var pos = KE.util.getScrollPos();
			var div = g.container;
			div.style.position = 'absolute';
			div.style.left = pos.x + 'px';
			div.style.top = pos.y + 'px';
			div.style.zIndex = 19811211;
			KE.event.add(window, 'resize', resizeListener);
			g.resizeMode = 0;
			KE.toolbar.select(id, "fullscreen");
		}
	}
};

KE.plugin['bgcolor'] = {
	click : function(id) {
		KE.util.selection(id);
		var color = KE.queryCommandValue(KE.g[id].iframeDoc, 'bgcolor');
		this.menu = new KE.menu({
			id : id,
			cmd : 'bgcolor'
		});
		this.menu.picker(color);
	},
	exec : function(id, value) {
		var cmd = new KE.cmd(id);
		if (value == '') {
			cmd.remove({
				'span' : ['.background-color']
			});
		} else {
			cmd.wrap('span', [{'.background-color': value}]);
		}
		KE.util.execOnchangeHandler(id);
		this.menu.hide();
		KE.util.focus(id);
	}
};

KE.plugin['fontname'] = {
	click : function(id) {
		var fontName = KE.lang.plugins.fontname.fontName;
		var cmd = 'fontname';
		KE.util.selection(id);
		var menu = new KE.menu({
			id : id,
			cmd : cmd,
			width : 150
		});
		var font = KE.queryCommandValue(KE.g[id].iframeDoc, cmd);
		KE.each(fontName, function(key, value) {
			var html = '<span class="ke-reset" style="font-family: ' + key + ';">' + value + '</span>';
			menu.add(
				html,
				function() { KE.plugin[cmd].exec(id, key); },
				{ checked : (font === key.toLowerCase() || font === value.toLowerCase()) }
			);
		});
		menu.show();
		this.menu = menu;
	},
	exec : function(id, value) {
		var cmd = new KE.cmd(id);
		cmd.wrap('span', [{'.font-family': value}]);
		KE.util.execOnchangeHandler(id);
		this.menu.hide();
		KE.util.focus(id);
	}
};

KE.plugin['fontsize'] = {
	click : function(id) {
		var fontSize = ['9px', '10px', '12px', '14px', '16px', '18px', '24px', '32px'];
		var cmd = 'fontsize';
		KE.util.selection(id);
		var size = KE.queryCommandValue(KE.g[id].iframeDoc, 'fontsize');
		var menu = new KE.menu({
			id : id,
			cmd : cmd,
			width : 120
		});
		for (var i = 0, len = fontSize.length; i < len; i++) {
			var value = fontSize[i];
			var html = '<span class="ke-reset" style="font-size: ' + value + ';">' + value + '</span>';
			menu.add(
				html,
				(function(value) {
					return function() {
						KE.plugin[cmd].exec(id, value);
					};
				})(value),
				{
					height : (parseInt(value) + 12) + 'px',
					checked : (size === value)
				}
			);
		}
		menu.show();
		this.menu = menu;
	},
	exec : function(id, value) {
		var cmd = new KE.cmd(id);
		cmd.wrap('span', [{'.font-size': value}]);
		KE.util.execOnchangeHandler(id);
		this.menu.hide();
		KE.util.focus(id);
	}
};

KE.plugin['hr'] = {
	click : function(id) {
		KE.util.selection(id);
		KE.util.insertHtml(id, '<hr />');
		KE.util.focus(id);
	}
};

KE.plugin['print'] = {
	click : function(id) {
		KE.util.selection(id);
		KE.g[id].iframeWin.print();
	}
};

KE.plugin['removeformat'] = {
	click : function(id) {
		KE.util.selection(id);
		var cmd = new KE.cmd(id);
		var tags = {
			'*' : ['class', 'style']
		};
		for (var i = 0, len = KE.g[id].inlineTags.length; i < len; i++) {
			tags[KE.g[id].inlineTags[i]] = ['*'];
		}
		cmd.remove(tags);
		KE.util.execOnchangeHandler(id);
		KE.toolbar.updateState(id);
		KE.util.focus(id);
	}
};

KE.plugin['source'] = {
	click : function(id) {
		var g = KE.g[id];
		if (!g.wyswygMode) {
			KE.util.setFullHtml(id, g.newTextarea.value);
			g.iframe.style.display = 'block';
			g.newTextarea.style.display = 'none';
			KE.toolbar.able(id, ['source', 'fullscreen']);
			g.wyswygMode = true;
			this.isSelected = false;
			KE.toolbar.unselect(id, "source");
		} else {
			KE.hideMenu(id);
			g.newTextarea.value = KE.util.getData(id);
			g.iframe.style.display = 'none';
			g.newTextarea.style.display = 'block';
			KE.toolbar.disable(id, ['source', 'fullscreen']);
			g.wyswygMode = false;
			this.isSelected = true;
			KE.toolbar.select(id, "source");
		}
		KE.util.focus(id);
	}
};

KE.plugin['textcolor'] = {
	click : function(id) {
		KE.util.selection(id);
		var color = KE.queryCommandValue(KE.g[id].iframeDoc, 'textcolor');
		this.menu = new KE.menu({
			id : id,
			cmd : 'textcolor'
		});
		this.menu.picker(color);
	},
	exec : function(id, value) {
		var cmd = new KE.cmd(id);
		if (value == '') {
			cmd.remove({
				'span' : ['.color'],
				'font' : ['color']
			});
		} else {
			cmd.wrap('span', [{'.color': value}]);
		}
		KE.util.execOnchangeHandler(id);
		this.menu.hide();
		KE.util.focus(id);
	}
};

KE.plugin['title'] = {
	click : function(id) {
		var lang = KE.lang.plugins.title;
		var title = {
			'H1' : lang.h1,
			'H2' : lang.h2,
			'H3' : lang.h3,
			'H4' : lang.h4,
			'P' : lang.p
		};
		var sizeHash = {
			'H1' : 28,
			'H2' : 24,
			'H3' : 18,
			'H4' : 14,
			'P' : 12
		};
		var cmd = 'title';
		KE.util.selection(id);
		var block = KE.queryCommandValue(KE.g[id].iframeDoc, 'formatblock');
		var menu = new KE.menu({
			id : id,
			cmd : cmd,
			width : (KE.langType == 'en' ? 200 : 150)
		});
		KE.each(title, function(key, value) {
			var style = 'font-size:' + sizeHash[key] + 'px;'
			if (key !== 'P') style += 'font-weight:bold;';
			var html = '<span class="ke-reset" style="' + style + '">' + value + '</span>';
			menu.add(html, function() {
				KE.plugin[cmd].exec(id, '<' + key + '>'); },
				{
					height : (sizeHash[key] + 12) + 'px',
					checked : (block === key.toLowerCase() || block === value.toLowerCase() )
				}
			);
		});
		menu.show();
		this.menu = menu;
	},
	exec : function(id, value) {
		KE.util.select(id);
		KE.util.execCommand(id, 'formatblock', value);
		this.menu.hide();
		KE.util.focus(id);
	}
};

KE.plugin['emoticons'] = {
	click : function(id) {
		var self = this,
			cmd = 'emoticons',
			rows = 5,
			cols = 9,
			total = 135,
			startNum = 0,
			cells = rows * cols,
			pages = Math.ceil(total / cells),
			colsHalf = Math.floor(cols / 2),
			g = KE.g[id],
			path = g.pluginsPath + 'emoticons/',
			allowPreview = (g.allowPreviewEmoticons === undefined) ? true : g.allowPreviewEmoticons;
		KE.util.selection(id);
		var wrapperDiv = KE.$$('div');
		wrapperDiv.className = 'ke-plugin-emoticons-wrapper';
		var previewDiv, previewImg;
		if (allowPreview) {
			previewDiv = KE.$$('div');
			previewDiv.className = 'ke-plugin-emoticons-preview';
			previewDiv.style.right = 0;
			var previewImg = KE.$$('img');
			previewImg.className = 'ke-reset';
			previewImg.src = path + '0.gif';
			previewImg.border = 0;
			previewDiv.appendChild(previewImg);
			wrapperDiv.appendChild(previewDiv);
		}
		function createEmoticonsTable(pageNum) {
			var table = KE.$$('table');
			if (previewDiv) {
				table.onmouseover = function() { previewDiv.style.display = 'block'; };
				table.onmouseout = function() { previewDiv.style.display = 'none'; };
			}
			table.className = 'ke-plugin-emoticons-table';
			table.cellPadding = 0;
			table.cellSpacing = 0;
			table.border = 0;
			var num = (pageNum - 1) * cells + startNum;
			for (var i = 0; i < rows; i++) {
				var row = table.insertRow(i);
				for (var j = 0; j < cols; j++) {
					var cell = row.insertCell(j);
					cell.className = 'ke-plugin-emoticons-cell';
					if (previewDiv) {
						cell.onmouseover = (function(j, num) {
							return function() {
								if (j > colsHalf) {
									previewDiv.style.left = 0;
									previewDiv.style.right = '';
								} else {
									previewDiv.style.left = '';
									previewDiv.style.right = 0;
								}
								previewImg.src = path + num + '.gif';;
								this.className = 'ke-plugin-emoticons-cell ke-plugin-emoticons-cell-on';
							};
						})(j, num);
					} else {
						cell.onmouseover = function() {
							this.className = 'ke-plugin-emoticons-cell ke-plugin-emoticons-cell-on';
						};
					}
					cell.onmouseout = function() { this.className = 'ke-plugin-emoticons-cell'; };
					cell.onclick = (function(num) {
						return function() {
							self.exec(id, num);
							return false;
						};
					})(num);
					var span = KE.$$('span');
					span.className = 'ke-plugin-emoticons-img';
					span.style.backgroundPosition = '-' + (24 * num) + 'px 0px';
					cell.appendChild(span);
					num++;
				}
			}
			return table;
		}
		var table = createEmoticonsTable(1);
		wrapperDiv.appendChild(table);
		var pageDiv = KE.$$('div');
		pageDiv.className = 'ke-plugin-emoticons-page';
		wrapperDiv.appendChild(pageDiv);
		function createPageTable(currentPageNum) {
			for (var pageNum = 1; pageNum <= pages; pageNum++) {
				if (currentPageNum !== pageNum) {
					var a = KE.$$('a');
					a.href = 'javascript:;';
					a.innerHTML = '[' + pageNum + ']';
					a.onclick = (function(pageNum) {
						return function() {
							wrapperDiv.removeChild(table);
							var newTable = createEmoticonsTable(pageNum);
							wrapperDiv.insertBefore(newTable, pageDiv);
							table = newTable;
							pageDiv.innerHTML = '';
							createPageTable(pageNum);
							return false;
						};
					})(pageNum);
					pageDiv.appendChild(a);
				} else {
					pageDiv.appendChild(document.createTextNode('[' + pageNum + ']'));
				}
				pageDiv.appendChild(document.createTextNode(' '));
			}
		}
		createPageTable(1);
		var menu = new KE.menu({
			id : id,
			cmd : cmd
		});
		menu.append(wrapperDiv);
		menu.show();
		this.menu = menu;
	},
	exec : function(id, num) {
		var src = KE.g[id].pluginsPath + 'emoticons/' + num + '.gif';
		var html = '<img src="' + src + '" kesrc="' + src + '" border="0" alt="" />';
		KE.util.insertHtml(id, html);
		this.menu.hide();
		KE.util.focus(id);
	}
};

KE.plugin['flash'] = {
	init : function(id) {
		var self = this;
		KE.g[id].getHtmlHooks.push(function(html) {
			return html.replace(/<img[^>]*class="?ke-flash"?[^>]*>/ig, function(imgStr) {
				var width = imgStr.match(/style="[^"]*;?\s*width:\s*(\d+)/i) ? RegExp.$1 : 0;
				var height = imgStr.match(/style="[^"]*;?\s*height:\s*(\d+)/i) ? RegExp.$1 : 0;
				width = width || (imgStr.match(/width="([^"]+)"/i) ? RegExp.$1 : 0);
				height = height || (imgStr.match(/height="([^"]+)"/i) ? RegExp.$1 : 0);
				if (imgStr.match(/kesrctag="([^"]+)"/i)) {
					var attrs = KE.util.getAttrList(unescape(RegExp.$1));
					attrs.width = width || attrs.width || 0;
					attrs.height = height || attrs.height || 0;
					attrs.kesrc = attrs.src;
					return KE.util.getMediaEmbed(attrs);
				}
			});
		});
		KE.g[id].setHtmlHooks.push(function(html) {
			return html.replace(/<embed[^>]*type="application\/x-shockwave-flash"[^>]*>(?:<\/embed>)?/ig, function($0) {
				var src = $0.match(/\s+src="([^"]+)"/i) ? RegExp.$1 : '';
				if ($0.match(/\s+kesrc="([^"]+)"/i)) src = RegExp.$1;
				var width = $0.match(/\s+width="([^"]+)"/i) ? RegExp.$1 : 0;
				var height = $0.match(/\s+height="([^"]+)"/i) ? RegExp.$1 : 0;
				var attrs = KE.util.getAttrList($0);
				attrs.src = src;
				attrs.width = width;
				attrs.height = height;
				return KE.util.getMediaImage(id, 'flash', attrs);
			});
		});
	},
	click : function(id) {
		KE.util.selection(id);
		this.dialog = new KE.dialog({
			id : id,
			cmd : 'flash',
			file : 'flash.html',
			width : 400,
			height : 140,
			loadingMode : true,
			title : KE.lang['flash'],
			yesButton : KE.lang['yes'],
			noButton : KE.lang['no']
		});
		this.dialog.show();
	},
	check : function(id, url, width, height) {
		var dialogDoc = KE.util.getIframeDoc(this.dialog.iframe);
		if (!url.match(/^.{3,}$/)) {
			alert(KE.lang['invalidUrl']);
			KE.$('url', dialogDoc).focus();
			return false;
		}
		if (!width.match(/^\d*$/)) {
			alert(KE.lang['invalidWidth']);
			KE.$('width', dialogDoc).focus();
			return false;
		}
		if (!height.match(/^\d*$/)) {
			alert(KE.lang['invalidHeight']);
			KE.$('height', dialogDoc).focus();
			return false;
		}
		return true;
	},
	exec : function(id) {
		var dialogDoc = KE.util.getIframeDoc(this.dialog.iframe);
		var url = KE.$('url', dialogDoc).value;
		var width = KE.$('width', dialogDoc).value;
		var height = KE.$('height', dialogDoc).value;
		if (!this.check(id, url, width, height)) return false;
		var html = KE.util.getMediaImage(id, 'flash', {
			src : url,
			type : KE.g[id].mediaTypes['flash'],
			width : width,
			height : height,
			quality : 'high'
		});
		KE.util.insertHtml(id, html);
		this.dialog.hide();
		KE.util.focus(id);
	}
};

KE.plugin['image'] = {
	getSelectedNode : function(id) {
		var g = KE.g[id];
		var startNode = g.keRange.startNode;
		var endNode = g.keRange.endNode;
		if (!KE.browser.WEBKIT && !g.keSel.isControl) return;
		if (startNode.nodeType != 1) return;
		if (startNode.tagName.toLowerCase() != 'img') return;
		if (startNode != endNode) return;
		if (!startNode.className.match(/^ke-\w+/i)) return startNode;
	},
	init : function(id) {
		var self = this;
		var g = KE.g[id];
		g.contextmenuItems.push({
			text : KE.lang['editImage'],
			click : function(id, menu) {
				KE.util.select(id);
				menu.hide();
				self.click(id);
			},
			cond : function(id) {
				return self.getSelectedNode(id);
			},
			options : {
				width : '150px',
				iconHtml : '<span class="ke-common-icon ke-common-icon-url ke-icon-image"></span>'
			}
		});
		g.contextmenuItems.push({
			text : KE.lang['deleteImage'],
			click : function(id, menu) {
				KE.util.select(id);
				menu.hide();
				var img = self.getSelectedNode(id);
				img.parentNode.removeChild(img);
				KE.util.execOnchangeHandler(id);
			},
			cond : function(id) {
				return self.getSelectedNode(id);
			},
			options : {
				width : '150px'
			}
		});
		g.contextmenuItems.push('-');
	},
	click : function(id) {
		KE.util.selection(id);
		this.dialog = new KE.dialog({
			id : id,
			cmd : 'image',
			file : 'image/image.html',
			width : 400,
			height : 220,
			loadingMode : true,
			title : KE.lang['image'],
			yesButton : KE.lang['yes'],
			noButton : KE.lang['no']
		});
		this.dialog.show();
	},
	check : function(id) {
		var dialogDoc = KE.util.getIframeDoc(this.dialog.iframe);
		var type = KE.$('type', dialogDoc).value;
		var width = KE.$('imgWidth', dialogDoc).value;
		var height = KE.$('imgHeight', dialogDoc).value;
		var title = KE.$('imgTitle', dialogDoc).value;
		var urlBox;
		if (type == 2) {
			urlBox = KE.$('imgFile', dialogDoc);
		} else {
			urlBox = KE.$('url', dialogDoc);
		}
		if (!urlBox.value.match(/\.(jpg|jpeg|gif|bmp|png)(\s|\?|$)/i)) {
			alert(KE.lang['invalidImg']);
			urlBox.focus();
			return false;
		}
		if (!width.match(/^\d*$/)) {
			alert(KE.lang['invalidWidth']);
			KE.$('imgWidth', dialogDoc).focus();
			return false;
		}
		if (!height.match(/^\d*$/)) {
			alert(KE.lang['invalidHeight']);
			KE.$('imgHeight', dialogDoc).focus();
			return false;
		}
		return true;
	},
	exec : function(id) {
		var self = this;
		var dialogDoc = KE.util.getIframeDoc(this.dialog.iframe);
		var type = KE.$('type', dialogDoc).value;
		var width = KE.$('imgWidth', dialogDoc).value;
		var height = KE.$('imgHeight', dialogDoc).value;
		var title = KE.$('imgTitle', dialogDoc).value;
		var alignElements = dialogDoc.getElementsByName('align');
		var align = '';
		for (var i = 0, len = alignElements.length; i < len; i++) {
			if (alignElements[i].checked) {
				align = alignElements[i].value;
				break;
			}
		}
		if (!this.check(id)) return false;
		if (type == 2) {
			KE.$('editorId', dialogDoc).value = id;
			var uploadIframe = KE.$('uploadIframe', dialogDoc);
			KE.util.showLoadingPage(id);
			var onloadFunc = function() {
				KE.event.remove(uploadIframe, 'load', onloadFunc);
				KE.util.hideLoadingPage(id);
				var uploadDoc = KE.util.getIframeDoc(uploadIframe);
				var data = '';
				try {
					data = KE.util.parseJson(uploadDoc.body.innerHTML);
				} catch(e) {
					alert(KE.lang.invalidJson);
				}
				if (typeof data === 'object' && 'error' in data) {
					if (data.error === 0) {
						var url = KE.format.getUrl(data.url, 'absolute');
						self.insert(id, url, title, width, height, 0, align);
					} else {
						alert(data.message);
						return false;
					}
				}
			};
			KE.event.add(uploadIframe, 'load', onloadFunc);
			dialogDoc.uploadForm.submit();
			return;
		} else {
			var url = KE.$('url', dialogDoc).value;
			this.insert(id, url, title, width, height, 0, align);
		}
	},
	insert : function(id, url, title, width, height, border, align) {
		var html = '<img src="' + url + '" kesrc="' + url + '" ';
		if (width > 0) html += 'width="' + width + '" ';
		if (height > 0) html += 'height="' + height + '" ';
		if (title) html += 'title="' + title + '" ';
		if (align) html += 'align="' + align + '" ';
		html += 'alt="' + title + '" ';
		html += 'border="' + border + '" />';
		KE.util.insertHtml(id, html);
		this.dialog.hide();
		KE.util.focus(id);
	}
};

KE.plugin['link'] = {
	getSelectedNode : function(id) {
		return KE.getCommonAncestor(KE.g[id].keSel, 'a');
	},
	init : function(id) {
		var self = this;
		KE.g[id].contextmenuItems.push({
			text : KE.lang['editLink'],
			click : function(id, menu) {
				KE.util.select(id);
				menu.hide();
				self.click(id);
			},
			cond : function(id) {
				return self.getSelectedNode(id);
			},
			options : {
				width : '150px',
				iconHtml : '<span class="ke-common-icon ke-common-icon-url ke-icon-link"></span>'
			}
		});
	},
	click : function(id) {
		KE.util.selection(id);
		this.dialog = new KE.dialog({
			id : id,
			cmd : 'link',
			file : 'link/link.html',
			width : 400,
			height : 90,
			loadingMode : true,
			title : KE.lang['link'],
			yesButton : KE.lang['yes'],
			noButton : KE.lang['no']
		});
		this.dialog.show();
	},
	exec : function(id) {
		var g = KE.g[id];
		KE.util.select(id);
		var range = g.keRange;
		var startNode = range.startNode;
		var endNode = range.endNode;
		var iframeDoc = g.iframeDoc;
		var dialogDoc = KE.util.getIframeDoc(this.dialog.iframe);
		var url = KE.$('hyperLink', dialogDoc).value;
		var target = KE.$('linkType', dialogDoc).value;
		if (!url.match(/.+/) || url.match(/^\w+:\/\/\/?$/)) {
			alert(KE.lang['invalidUrl']);
			KE.$('hyperLink', dialogDoc).focus();
			return false;
		}
		var node = range.getParentElement();
		while (node) {
			if (node.tagName.toLowerCase() == 'a' || node.tagName.toLowerCase() == 'body') break;
			node = node.parentNode;
		}
		node = node.parentNode;
		var isItem;
		if (KE.browser.IE) {
			isItem = !!g.range.item;
		} else {
			isItem = (startNode.nodeType == 1 && startNode === endNode && startNode.nodeName.toLowerCase() != 'br');
		}
		var isEmpty = !isItem;
		if (!isItem) isEmpty = KE.browser.IE ? g.range.text === '' : g.range.toString() === '';
		if (isEmpty || KE.util.isEmpty(id)) {
			var html = '<a href="' + url + '"';
			if (target) html += ' target="' + target + '"';
			html += '>' + url + '</a>';
			KE.util.insertHtml(id, html);
		} else {
			iframeDoc.execCommand('createlink', false, '__ke_temp_url__');
			var arr = node.getElementsByTagName('a');
			for (var i = 0, l = arr.length; i < l; i++) {
				if (arr[i].href.match(/\/?__ke_temp_url__$/)) {
					arr[i].href = url;
					arr[i].setAttribute('kesrc', url);
					if (target) arr[i].target = target;
					else arr[i].removeAttribute('target');
				}
			}
			if (KE.browser.WEBKIT && isItem && startNode.tagName.toLowerCase() == 'img') {
				var parent = startNode.parentNode;
				if (parent.tagName.toLowerCase() != 'a') {
					var a = KE.$$('a', iframeDoc);
					parent.insertBefore(a, startNode);
					a.appendChild(startNode);
					parent = a;
				}
				parent.href = url;
				parent.setAttribute('kesrc', url);
				if (target) parent.target = target;
				else parent.removeAttribute('target');
				g.keSel.addRange(range);
			}
		}
		KE.util.execOnchangeHandler(id);
		this.dialog.hide();
		KE.util.focus(id);
	}
};

KE.plugin['unlink'] = {
	init : function(id) {
		var self = this;
		KE.g[id].contextmenuItems.push({
			text : KE.lang['deleteLink'],
			click : function(id, menu) {
				KE.util.select(id);
				menu.hide();
				self.click(id);
			},
			cond : function(id) {
				return KE.plugin['link'].getSelectedNode(id);
			},
			options : {
				width : '150px',
				iconHtml : '<span class="ke-common-icon ke-common-icon-url ke-icon-unlink"></span>'
			}
		});
		KE.g[id].contextmenuItems.push('-');
	},
	click : function(id) {
		var g = KE.g[id];
		var iframeDoc = g.iframeDoc;
		KE.util.selection(id);
		var range = g.keRange;
		var startNode = range.startNode;
		var endNode = range.endNode;
		var isItem = (startNode.nodeType == 1 && startNode === endNode);
		var isEmpty = !isItem;
		if (!isItem) isEmpty = KE.browser.IE ? g.range.text === '' : g.range.toString() === '';
		if (isEmpty) {
			var linkNode = KE.plugin['link'].getSelectedNode(id);
			if (!linkNode) return;
			var range = g.keRange;
			range.selectTextNode(linkNode);
			g.keSel.addRange(range);
			KE.util.select(id);
			iframeDoc.execCommand('unlink', false, null);
			if (KE.browser.WEBKIT && startNode.tagName.toLowerCase() == 'img') {
				var parent = startNode.parentNode;
				if (parent.tagName.toLowerCase() == 'a') {
					KE.util.removeParent(parent);
					g.keSel.addRange(range);
				}
			}
		} else {
			iframeDoc.execCommand('unlink', false, null);
		}
		KE.util.execOnchangeHandler(id);
		KE.toolbar.updateState(id);
		KE.util.focus(id);
	}
};

KE.plugin['media'] = {
	init : function(id) {
		var self = this;
		var typeHash = {};
		KE.each(KE.g[id].mediaTypes, function(key, val) {
			typeHash[val] = key;
		});
		KE.g[id].getHtmlHooks.push(function(html) {
			return html.replace(/<img[^>]*class="?ke-\w+"?[^>]*>/ig, function($0) {
				var width = $0.match(/style="[^"]*;?\s*width:\s*(\d+)/i) ? RegExp.$1 : 0;
				var height = $0.match(/style="[^"]*;?\s*height:\s*(\d+)/i) ? RegExp.$1 : 0;
				width = width || ($0.match(/width="([^"]+)"/i) ? RegExp.$1 : 0);
				height = height || ($0.match(/height="([^"]+)"/i) ? RegExp.$1 : 0);
				if ($0.match(/\s+kesrctag="([^"]+)"/i)) {
					var attrs = KE.util.getAttrList(unescape(RegExp.$1));
					attrs.width = width || attrs.width || 0;
					attrs.height = height || attrs.height || 0;
					attrs.kesrc = attrs.src;
					return KE.util.getMediaEmbed(attrs);
				}
			});
		});
		KE.g[id].setHtmlHooks.push(function(html) {
			return html.replace(/<embed[^>]*type="([^"]+)"[^>]*>(?:<\/embed>)?/ig, function($0, $1) {
				if (typeof typeHash[$1] == 'undefined') return $0;
				var src = $0.match(/\s+src="([^"]+)"/i) ? RegExp.$1 : '';
				if ($0.match(/\s+kesrc="([^"]+)"/i)) src = RegExp.$1;
				var width = $0.match(/\s+width="([^"]+)"/i) ? RegExp.$1 : 0;
				var height = $0.match(/\s+height="([^"]+)"/i) ? RegExp.$1 : 0;
				var attrs = KE.util.getAttrList($0);
				attrs.src = src;
				attrs.width = width;
				attrs.height = height;
				return KE.util.getMediaImage(id, '', attrs);
			});
		});
	},
	click : function(id) {
		KE.util.selection(id);
		this.dialog = new KE.dialog({
			id : id,
			cmd : 'media',
			file : 'media.html',
			width : 400,
			height : 170,
			loadingMode : true,
			title : KE.lang['media'],
			yesButton : KE.lang['yes'],
			noButton : KE.lang['no']
		});
		this.dialog.show();
	},
	check : function(id, url, width, height) {
		var dialogDoc = KE.util.getIframeDoc(this.dialog.iframe);
		if (!url.match(/^.{3,}\.(swf|flv|mp3|wav|wma|wmv|mid|avi|mpg|mpeg|asf|rm|rmvb)(\?|$)/i)) {
			alert(KE.lang['invalidMedia']);
			KE.$('url', dialogDoc).focus();
			return false;
		}
		if (!width.match(/^\d*$/)) {
			alert(KE.lang['invalidWidth']);
			KE.$('width', dialogDoc).focus();
			return false;
		}
		if (!height.match(/^\d*$/)) {
			alert(KE.lang['invalidHeight']);
			KE.$('height', dialogDoc).focus();
			return false;
		}
		return true;
	},
	exec : function(id) {
		var dialogDoc = KE.util.getIframeDoc(this.dialog.iframe);
		var url = KE.$('url', dialogDoc).value;
		var width = KE.$('width', dialogDoc).value;
		var height = KE.$('height', dialogDoc).value;
		if (!this.check(id, url, width, height)) return false;
		var autostart = KE.$('autostart', dialogDoc).checked ? 'true' : 'false';
		var html = KE.util.getMediaImage(id, '', {
			src : url,
			type : KE.g[id].mediaTypes[KE.util.getMediaType(url)],
			width : width,
			height : height,
			autostart : autostart,
			loop : 'true'
		});
		KE.util.insertHtml(id, html);
		this.dialog.hide();
		KE.util.focus(id);
	}
};

KE.plugin['advtable'] = {
	getSelectedTable : function(id) {
		return KE.getCommonAncestor(KE.g[id].keSel, 'table');
	},
	getSelectedRow : function(id) {
		return KE.getCommonAncestor(KE.g[id].keSel, 'tr');
	},
	getSelectedCell : function(id) {
		return KE.getCommonAncestor(KE.g[id].keSel, 'td');
	},
	tableprop : function(id) {
		this.click(id);
	},
	tableinsert : function(id) {
		this.click(id, 'insert');
	},
	tabledelete : function(id) {
		var table = this.getSelectedTable(id);
		table.parentNode.removeChild(table);
	},
	tablecolinsert : function(id, offset) {
		var table = this.getSelectedTable(id),
			cell = this.getSelectedCell(id),
			index = cell.cellIndex + offset;
		for (var i = 0, len = table.rows.length; i < len; i++) {
			var newCell = table.rows[i].insertCell(index);
			newCell.innerHTML = '&nbsp;';
		}
	},
	tablecolinsertleft : function(id) {
		this.tablecolinsert(id, 0);
	},
	tablecolinsertright : function(id) {
		this.tablecolinsert(id, 1);
	},
	tablerowinsert : function(id, offset) {
		var table = this.getSelectedTable(id),
			row = this.getSelectedRow(id),
			newRow = table.insertRow(row.rowIndex + offset);
		for (var i = 0, len = row.cells.length; i < len; i++) {
			var cell = newRow.insertCell(i);
			cell.innerHTML = '&nbsp;';
		}
	},
	tablerowinsertabove : function(id) {
		this.tablerowinsert(id, 0);
	},
	tablerowinsertbelow : function(id) {
		this.tablerowinsert(id, 1);
	},
	tablecoldelete : function(id) {
		var table = this.getSelectedTable(id),
			cell = this.getSelectedCell(id),
			index = cell.cellIndex;
		for (var i = 0, len = table.rows.length; i < len; i++) {
			table.rows[i].deleteCell(index);
		}
	},
	tablerowdelete : function(id) {
		var table = this.getSelectedTable(id);
		var row = this.getSelectedRow(id);
		table.deleteRow(row.rowIndex);
	},
	init : function(id) {
		var self = this;
		var zeroborder = 'ke-zeroborder';
		var tableCmds = 'prop,colinsertleft,colinsertright,rowinsertabove,rowinsertbelow,coldelete,rowdelete,insert,delete'.split(',');
		for (var i = 0, len = tableCmds.length; i < len; i++) {
			var name = 'table' + tableCmds[i];
			KE.g[id].contextmenuItems.push({
				text : KE.lang[name],
				click : (function(name) {
					return function(id, menu) {
						KE.util.select(id);
						menu.hide();
						if (self[name] !== undefined) self[name](id);
						if (!/prop/.test(name)) {
							KE.util.execOnchangeHandler(id);
						}
					};
				})(name),
				cond : (function(name) {
					if (KE.util.inArray(name, ['tableprop', 'tabledelete'])) {
						return function(id) {
							return self.getSelectedTable(id);
						};
					} else {
						return function(id) {
							return self.getSelectedCell(id);
						};
					}
				})(name),
				options : {
					width : '170px',
					iconHtml : '<span class="ke-common-icon ke-common-icon-url ke-icon-' + name + '"></span>'
				}
			});
		}
		KE.g[id].contextmenuItems.push('-');
		KE.g[id].setHtmlHooks.push(function(html) {
			return html.replace(/<table([^>]*)>/ig, function($0, $1) {
				if ($1.match(/\s+border=["']?(\d*)["']?/ig)) {
					var border = RegExp.$1;
					if ($1.indexOf(zeroborder) < 0 && (border === '' || border === '0')) {
						return KE.addClass($0, zeroborder);
					} else {
						return $0;
					}
				} else {
					return KE.addClass($0, zeroborder);
				}
			});
		});
	},
	click : function(id, mode) {
		mode = mode || 'default';
		var cmd = 'advtable';
		KE.util.selection(id);
		this.dialog = new KE.dialog({
			id : id,
			cmd : cmd,
			file : 'advtable/advtable.html?mode=' + mode,
			width : 420,
			height : 220,
			loadingMode : true,
			title : KE.lang['advtable'],
			yesButton : KE.lang['yes'],
			noButton : KE.lang['no']
		});
		this.dialog.show();
	},
	exec : function(id) {
		var zeroborder = 'ke-zeroborder';
		var dialogDoc = KE.util.getIframeDoc(this.dialog.iframe);
		var modeBox = KE.$('mode', dialogDoc);
		var rowsBox = KE.$('rows', dialogDoc);
		var colsBox = KE.$('cols', dialogDoc);
		var widthBox = KE.$('width', dialogDoc);
		var heightBox = KE.$('height', dialogDoc);
		var widthTypeBox = KE.$('widthType', dialogDoc);
		var heightTypeBox = KE.$('heightType', dialogDoc);
		var paddingBox = KE.$('padding', dialogDoc);
		var spacingBox = KE.$('spacing', dialogDoc);
		var alignBox = KE.$('align', dialogDoc);
		var borderBox = KE.$('border', dialogDoc);
		var borderColorBox = KE.$('borderColor', dialogDoc);
		var backgroundColorBox = KE.$('backgroundColor', dialogDoc);
		var rows = rowsBox.value;
		var cols = colsBox.value;
		var width = widthBox.value;
		var height = heightBox.value;
		var widthType = widthTypeBox.value;
		var heightType = heightTypeBox.value;
		var padding = paddingBox.value;
		var spacing = spacingBox.value;
		var align = alignBox.value;
		var border = borderBox.value;
		var borderColor = borderColorBox.innerHTML;
		var backgroundColor = backgroundColorBox.innerHTML;
		if (rows == '' || rows == 0 || !rows.match(/^\d*$/)) {
			alert(KE.lang['invalidRows']);
			rowsBox.focus();
			return false;
		}
		if (cols == '' || cols == 0 || !cols.match(/^\d*$/)) {
			alert(KE.lang['invalidCols']);
			colsBox.focus();
			return false;
		}
		if (!width.match(/^\d*$/)) {
			alert(KE.lang['invalidWidth']);
			widthBox.focus();
			return false;
		}
		if (!height.match(/^\d*$/)) {
			alert(KE.lang['invalidHeight']);
			heightBox.focus();
			return false;
		}
		if (!padding.match(/^\d*$/)) {
			alert(KE.lang['invalidPadding']);
			paddingBox.focus();
			return false;
		}
		if (!spacing.match(/^\d*$/)) {
			alert(KE.lang['invalidSpacing']);
			spacingBox.focus();
			return false;
		}
		if (!border.match(/^\d*$/)) {
			alert(KE.lang['invalidBorder']);
			borderBox.focus();
			return false;
		}
		if (modeBox.value === 'update') {
			var table = this.getSelectedTable(id);
			if (width !== '') {
				table.style.width = width + widthType;
			} else if (table.style.width) {
				table.style.width = '';
			}
			if (table.width !== undefined) {
				table.removeAttribute('width');
			}
			if (height !== '') {
				table.style.height = height + heightType;
			} else if (table.style.height) {
				table.style.height = '';
			}
			if (table.height !== undefined) {
				table.removeAttribute('height');
			}
			if (backgroundColor !== '') {
				table.style.backgroundColor = backgroundColor;
			} else if (table.style.backgroundColor) {
				table.style.backgroundColor = '';
			}
			if (table.bgColor !== undefined) {
				table.removeAttribute('bgColor');
			}
			if (padding !== '') {
				table.cellPadding = padding;
			} else {
				table.removeAttribute('cellPadding');
			}
			if (spacing !== '') {
				table.cellSpacing = spacing;
			} else {
				table.removeAttribute('cellSpacing');
			}
			if (align !== '') {
				table.align = align;
			} else {
				table.removeAttribute('align');
			}
			if (border === '' || border === '0') {
				KE.addClass(table, zeroborder);
			} else {
				KE.removeClass(table, zeroborder);
			}
			if (border !== '') {
				table.setAttribute('border', border);
			} else {
				table.removeAttribute('border');
			}
			if (borderColor !== '') {
				table.setAttribute('borderColor', borderColor);
			} else {
				table.removeAttribute('borderColor');
			}
			KE.util.execOnchangeHandler(id);
		} else {
			var style = '';
			if (width !== '') style += 'width:' + width + widthType + ';';
			if (height !== '') style += 'height:' + height + heightType + ';';
			if (backgroundColor !== '') style += 'background-color:' + backgroundColor + ';';
			var html = '<table';
			if (style !== '') html += ' style="' + style + '"';
			if (padding !== '') html += ' cellpadding="' + padding + '"';
			if (spacing !== '') html += ' cellspacing="' + spacing + '"';
			if (align !== '') html += ' align="' + align + '"';
			if (border === '' || border === '0') html += ' class="' + zeroborder + '"';
			if (border !== '') html += ' border="' + border + '"';
			if (borderColor !== '') html += ' bordercolor="' + borderColor + '"';
			html += '>';
			for (var i = 0; i < rows; i++) {
				html += '<tr>';
				for (var j = 0; j < cols; j++) {
					html += '<td>&nbsp;</td>';
				}
				html += '</tr>';
			}
			html += '</table>';
			KE.util.insertHtml(id, html);
		}
		this.dialog.hide();
		KE.util.focus(id);
	}
};

})(KindEditor);

function loadEditor(id) {
	KE.show({
		id: id,
		resizeMode: 1,
		allowUpload: false,
		urlType: 'domain',
		items: ['bold', 'italic', 'underline', 'strikethrough', 'textcolor', 'bgcolor', 'fontname', 'fontsize', 'removeformat', 'wordpaste', 'insertorderedlist', 'insertunorderedlist', 'indent', 'outdent', 'justifyleft', 'justifycenter', 'justifyright', 'link', 'unlink', 'image', 'flash', 'advtable', 'emoticons', 'source', 'fullscreen', '|', 'about']
	});
}
