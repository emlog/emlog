/*
	emlog前台模板共享js
*/

//元素隐藏
function showhidediv(id){
	try{
		var panel=document.getElementById(id);
		if(panel){
			if(panel.style.display=='none'){
				panel.style.display='block';
				var input_id= arguments[1]
				if(input_id)
				{
					document.getElementById(input_id).focus();
				}
			}else{
				panel.style.display='none';
			}
		}
	}catch(e){}
}
//搜索验证
function keyw()
{
	if (document.keyform.keyword.value=="")
	{
		alert("关键字不能为空");
		document.keyform.keyword.focus();
		return false;
	}
	if (document.keyform.keyword.value.length<3)
	{
		alert("关键字太短");
		document.keyform.keyword.focus();
		return false;
	}
	if (document.keyform.keyword.value.length>31)
	{
		alert("关键字太长");
		document.keyform.keyword.focus();
		return false;
	}
}
//验证email格式
function checkEmail (str){
	isEmail1=/^\w+([\.\-]\w+)*\@\w+([\.\-]\w+)*\.\w+$/;
	isEmail2=/^.*@[^_]*$/;
	return (isEmail1.test(str)&&isEmail2.test(str));
}

//评论验证
function checkform(){
	if (document.commentform.comname.value=="")
	{
		alert("名字不能为空");
		document.commentform.comname.focus();
		return false;
	}
	if(document.commentform.comname.value.length>16)
	{
		alert("名字太长");
		document.commentform.comname.focus();
		return false;
	}
	if(document.commentform.comment.value.length=="")
	{
		alert("评论内容不能为空");
		document.commentform.comment.focus();
		return false;
	}
	if(document.commentform.comment.value.length>2000)
	{
		alert("评论内容太长");
		document.commentform.comment.focus();
		return false;
	}
	if(document.commentform.commail.value!="")
	{
		if(document.commentform.commail.value.length>60)
		{
			alert("邮件地址长度超出系统接受范围");
			document.commentform.commail.focus();
			return false;
		}
		if(!checkEmail(document.commentform.commail.value))
		{
			alert("邮件地址格式不正确！");
			document.commentform.commail.focus();
			return false;
		}
	}
}
//删除确认
function isdel (id,type){
	if(type == 'twitter')
	{
		var msg = "你确定要删除吗？";
		if(confirm(msg)){
			sendinfo('twitter.php?action=del&twid='+id,'twitter')
		}
		else {
			return;
		}
	}
}
/*ajax*/
var xmlhttp = false;
var node = '';
function createxmlhttp() {
	xmlhttp = false;
	if(window.XMLHttpRequest) {
		xmlhttp = new XMLHttpRequest();
		if (xmlhttp.overrideMimeType) {
			xmlhttp.overrideMimeType('text/xml');
		}
	}
	else if (window.ActiveXObject) {
		try {
			xmlhttp = new ActiveXObject("Msxml2.XMLHTTP");
		} catch (e) {
			try {
				xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
			} catch (e) {}
		}
	}
	if (!xmlhttp) {
		window.alert("不能创建XMLHttpRequest对象实例.");
		return false;
	}
}
//get
function sendinfo(url,nodeid){
	node = nodeid;
	document.getElementById(node).innerHTML = "<div><span style=\"background-color:#FF8000; color:#FFFFFF;\">加载中...</span></div>";
	createxmlhttp();
	var querystring = url+ "&timetmp=" + new Date().getTime();;
	xmlhttp.open("GET", querystring, true);
	xmlhttp.send(null);
	xmlhttp.onreadystatechange = processRequest;
}
//post
function postinfo(url,post_id,show_id){
	node = show_id;
	document.getElementById(node).innerHTML = "<div><span style=\"background-color:#FF8000; color:#FFFFFF;\">处理中...请稍候!</span></div>";
	createxmlhttp();
	var url2 = url + "&timetmp=" + new Date().getTime();
	xmlhttp.open("POST", url2, true);
	xmlhttp.onreadystatechange = processRequest;
	xmlhttp.setRequestHeader("Content-Type","application/x-www-form-urlencoded;");
	var pdata = document.getElementById(post_id).value;
	var querystring = post_id+"="+encodeURIComponent(pdata);
	xmlhttp.send(querystring);
}
//
function processRequest() {
	//alert(node+xmlhttp.readyState);
	if (xmlhttp.readyState == 4) {
		if (xmlhttp.status == 200) {
			document.getElementById(node).innerHTML = xmlhttp.responseText;
		}
	}
}