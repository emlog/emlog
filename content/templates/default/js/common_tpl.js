function focusEle(ele) {
    try {
        document.getElementById(ele).focus();
    } catch (e) {
    }
}

function updateEle(ele, content) {
    document.getElementById(ele).innerHTML = content;
}

function timestamp() {
    return new Date().getTime();
}

var XMLHttp = {
    _objPool: [],
    _getInstance: function () {
        for (var i = 0; i < this._objPool.length; i++) {
            if (this._objPool[i].readyState == 0 || this._objPool[i].readyState == 4) {
                return this._objPool[i];
            }
        }
        this._objPool[this._objPool.length] = this._createObj();
        return this._objPool[this._objPool.length - 1];
    },
    _createObj: function () {
        if (window.XMLHttpRequest) {
            var objXMLHttp = new XMLHttpRequest();
        } else {
            var MSXML = ['MSXML2.XMLHTTP.5.0', 'MSXML2.XMLHTTP.4.0', 'MSXML2.XMLHTTP.3.0', 'MSXML2.XMLHTTP', 'Microsoft.XMLHTTP'];
            for (var n = 0; n < MSXML.length; n++) {
                try {
                    var objXMLHttp = new ActiveXObject(MSXML[n]);
                    break;
                } catch (e) {
                }
            }
        }
        if (objXMLHttp.readyState == null) {
            objXMLHttp.readyState = 0;
            objXMLHttp.addEventListener('load', function () {
                objXMLHttp.readyState = 4;
                if (typeof objXMLHttp.onreadystatechange == "function") {
                    objXMLHttp.onreadystatechange();
                }
            }, false);
        }
        return objXMLHttp;
    },
    sendReq: function (method, url, data, callback) {
        var objXMLHttp = this._getInstance();
        with (objXMLHttp) {
            try {
                if (url.indexOf("?") > 0) {
                    url += "&randnum=" + Math.random();
                } else {
                    url += "?randnum=" + Math.random();
                }
                open(method, url, true);
                setRequestHeader('Content-Type', 'application/x-www-form-urlencoded; charset=UTF-8');
                send(data);
                onreadystatechange = function () {
                    if (objXMLHttp.readyState == 4 && (objXMLHttp.status == 200 || objXMLHttp.status == 304)) {
                        callback(objXMLHttp);
                    }
                }
            } catch (e) {
                alert('emria:error');
            }
        }
    }
};

function sendinfo(url, node) {
    updateEle(node, "<div class='cal_loading'>&nbsp;</div>");
    XMLHttp.sendReq('GET', url, '', function (obj) {
        updateEle(node, obj.responseText);
    });
}

function loadr(url, tid) {
    url = url + "&stamp=" + timestamp();
    var r = document.getElementById("r_" + tid);
    var rp = document.getElementById("rp_" + tid);
    if (r.style.display == "block") {
        r.style.display = "none";
        rp.style.display = "none";
    } else {
        r.style.display = "block";
/*vot*/	r.innerHTML = '<span style=\"background-color:#FFFFE5;text-align:center;font-size:12px;color:#666666;\">'+lang('loading')+'</span>';
        XMLHttp.sendReq('GET', url, '', function (obj) {
            r.innerHTML = obj.responseText;
            rp.style.display = "block";
        });
    }
}

function reply(url, tid) {
    var rtext = document.getElementById("rtext_" + tid).value;
    var rname = document.getElementById("rname_" + tid).value;
    var rcode = document.getElementById("rcode_" + tid).value;
    var rmsg = document.getElementById("rmsg_" + tid);
    var rn = document.getElementById("rn_" + tid);
    var r = document.getElementById("r_" + tid);
    var data = "r=" + rtext + "&rname=" + rname + "&rcode=" + rcode + "&tid=" + tid;
    XMLHttp.sendReq('POST', url, data, function (obj) {
        if (obj.responseText == 'err1') {
/*vot*/     rmsg.innerHTML = lang('max_140_bytes');
        } else if (obj.responseText == 'err2') {
/*vot*/     rmsg.innerHTML = lang('nickname_empty');
        } else if (obj.responseText == 'err3') {
/*vot*/     rmsg.innerHTML = lang('captcha_error');
        } else if (obj.responseText == 'err4') {
/*vot*/     rmsg.innerHTML = lang('nickname_disabled');
        } else if (obj.responseText == 'err5') {
/*vot*/     rmsg.innerHTML = lang('nickname_exists');
        } else if (obj.responseText == 'err0') {
/*vot*/     rmsg.innerHTML = lang('comments_disabled');
        } else if (obj.responseText == 'succ1') {
/*vot*/     rmsg.innerHTML = lang('comment_ok_moderation');
        } else {
            r.innerHTML += obj.responseText;
            rn.innerHTML = Number(rn.innerHTML) + 1;
            rmsg.innerHTML = ''
        }
    });
}

function re(tid, rp) {
    var rtext = document.getElementById("rtext_" + tid).value = rp;
    focusEle("rtext_" + tid);
}

function commentReply(pid, c) {
    var response = document.getElementById('comment-post');
    document.getElementById('comment-pid').value = pid;
    document.getElementById('cancel-reply').style.display = '';
    c.parentNode.parentNode.appendChild(response);
}

function cancelReply() {
    var commentPlace = document.getElementById('comment-place'), response = document.getElementById('comment-post');
    document.getElementById('comment-pid').value = 0;
    document.getElementById('cancel-reply').style.display = 'none';
    commentPlace.appendChild(response);
}

function cal_margin(links, dp_id) {
    if (window.outerWidth > 991) {
        console.log(window.outerWidth);
        var count, menus, cal_width;
/*vot*/	cal_width = 85; //The width of the initial sub-navigation (px), can be modified as needed
        menus = document.getElementById('dropmenus' + dp_id);
        count = links.offsetWidth - cal_width;
        menus.style.width = cal_width + 'px';
        menus.style.marginLeft = count / 2 + 'px';
    }
}

