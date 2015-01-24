function id(id) {
	return document.getElementById(id) || null;
}

function focusEle(ele) {
	try {
		id(ele).focus();
	} catch(e) {}
}

function updateEle(ele, content) {
	id(ele).innerHTML = content;
}

function timestamp() {
	return new Date().getTime();
}

var XMLHttp = {
	_createObj: function() {
		if(window.XMLHttpRequest) {
			return new XMLHttpRequest();
		} else if(window.ActiveXObject) {
			return new ActiveXObject('Microsoft.XMLHTTP');
		}
		return false;
	},
	sendReq: function(method, url, data, callback) {
		var objXMLHttp = this._createObj();
		//url += (url.indexOf('?') > 0 ? '&' : '?') + 'randnum=' + Math.random();
		objXMLHttp.open(method, url);
		objXMLHttp.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded; charset=UTF-8');
		objXMLHttp.send(data);
		objXMLHttp.onreadystatechange = function() {
			if(objXMLHttp.readyState == 4 && objXMLHttp.status == 200) {
				callback(objXMLHttp);
			}
		}
	}
};

function sendinfo(url, node) {
	updateEle(node, '<div><span style="background-color:#FFFFE5; color:#666666;">加载中...</span></div>');
	XMLHttp.sendReq('GET', url, '', function(obj) {
		updateEle(node, obj.responseText);
	});
}

function loadr(url, tid) {
	url = url + '&stamp=' + timestamp();
	var r = id('r_' + tid),
		rp = id('rp_' + tid);
	if(r.style.display == 'block') {
		r.style.display = 'none';
		rp.style.display = 'none';
	} else {
		r.style.display = 'block';
		r.innerHTML = '<span style="background-color:#FFFFE5;text-align:center;font-size:12px;color:#666666;">加载中...</span>';
		XMLHttp.sendReq('GET', url, '', function(obj) {
			r.innerHTML = obj.responseText;
			rp.style.display = 'block';
		});
	}
}

function reply(url, tid) {
	var rtext = id('rtext_' + tid).value,
		rname = id('rname_' + tid).value,
		rcode = id('rcode_' + tid).value,
		rmsg = id('rmsg_' + tid),
		rn = id('rn_' + tid),
		rp = '',
		r = id('r_' + tid),
		data = 'r=' + rtext + '&rname=' + rname + '&rcode=' + rcode + '&tid=' + tid;
	XMLHttp.sendReq('POST', url, data, function(obj) {
		switch(obj.responseText) {
			case 'err1':
				rp = '(回复长度需在140个字内)';
				break;
			case 'err2':
				rp = '(昵称不能为空)';
				break;
			case 'err3':
				rp = '(验证码错误)';
				break;
			case 'err4':
				rp = '(不允许使用该昵称)';
				break;
			case 'err5':
				rp = '(已存在该回复)';
				break;
			case 'err0':
				rp = '(禁止回复)';
				break;
			case 'succ1':
				rp = '(回复成功，等待管理员审核)';
				break;
			default:
				r.innerHTML += obj.responseText;
				rn.innerHTML = Number(rn.innerHTML) + 1;
				break;
		}
		rmsg.innerHTML = rp;
	});
}

function re(tid, rp) {
	id('rtext_' + tid).value = rp;
	focusEle('rtext_' + tid);
}

function commentReply(pid, c) {
	id('comment-pid').value = pid;
	id('cancel-reply').style.display = '';
	c.parentNode.parentNode.appendChild(id('comment-post'));
}

function cancelReply() {
	id('comment-pid').value = 0;
	id('cancel-reply').style.display = 'none';
	id('comment-place').appendChild(id('comment-post'));
}