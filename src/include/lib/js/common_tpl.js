function $Id(id) {
	return document.getElementById(id) || null;
}

function focusEle(ele) {
	try {
		$Id(ele).focus();
	} catch (e) {}
}

function updateEle(ele, content) {
	$Id(ele).innerHTML = content;
}

function timestamp() {
	return new Date().getTime();
}
var XMLHttp = {
	sendReq: function(method, url, data, callback) {
		var objXMLHttp = new XMLHttpRequest() || new ActiveXObject('Microsoft.XMLHTTP') || null;
		objXMLHttp.open(method, url);
		objXMLHttp.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded; charset=UTF-8');
		objXMLHttp.send(data);
		objXMLHttp.onreadystatechange = function() {
			if (objXMLHttp.readyState == 4 && objXMLHttp.status == 200) {
				callback(objXMLHttp);
			}
		}
	}
};

function sendinfo(url, node) {
	updateEle(node, "<div><span style=\"background-color:#FFFFE5; color:#666666;\">加载中...</span></div>");
	XMLHttp.sendReq('GET', url, '', function(obj) {
		updateEle(node, obj.responseText);
	});
}

function loadr(url, tid) {
	url = url + "&stamp=" + timestamp();
	var r = $Id("r_" + tid),
		rp = $Id("rp_" + tid) || r;;
	if (r.style.display == "block") {
		r.style.display = "none";
		rp.style.display = "none";
	} else {
		r.style.display = "block";
		r.innerHTML = '<span style=\"background-color:#FFFFE5;text-align:center;font-size:12px;color:#666666;\">加载中...</span>';
		XMLHttp.sendReq('GET', url, '', function(obj) {
			r.innerHTML = obj.responseText;
			rp.style.display = "block";
		});
	}
}

function reply(url, tid) {
	var rtext = $Id("rtext_" + tid).value,
		rname = $Id("rname_" + tid).value,
		rcode = $Id("rcode_" + tid).value,
		rmsg = $Id("rmsg_" + tid),
		rn = $Id("rn_" + tid),
		rp = '',
		r = $Id("r_" + tid),
		data = "r=" + rtext + "&rname=" + rname + "&rcode=" + rcode + "&tid=" + tid;
	XMLHttp.sendReq('POST', url, data, function(obj) {
		switch (obj.responseText) {
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
	$Id("rtext_" + tid).value = rp;
	focusEle("rtext_" + tid);
}

function commentReply(pid, c) {
	$Id('comment-pid').value = pid;
	$Id('cancel-reply').style.display = '';
	c.parentNode.parentNode.appendChild($Id('comment-post'));
}

function cancelReply() {
	$Id('comment-pid').value = 0;
	$Id('cancel-reply').style.display = 'none';
	$Id('comment-place').appendChild($Id('comment-post'));
}