function showhidediv(id){
	try{
		var panel=document.getElementById(id);
		if(panel){
			if(panel.style.display=='none'){
				panel.style.display='block';
			}else{
				panel.style.display='none';
			}
		}
	}catch(e){}
}
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
function checkEmail (str){
	isEmail1=/^\w+([\.\-]\w+)*\@\w+([\.\-]\w+)*\.\w+$/;
	isEmail2=/^.*@[^_]*$/;
	return (isEmail1.test(str)&&isEmail2.test(str));
}
function texttest(){
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
}
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
	if(document.commentform.commail.value=="")
	{
		return texttest();
	}
	else{
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
	return texttest();
}
//删除确定
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
//初始化xmlhttp对象
var xmlhttp = false;
var node = '';
function createxmlhttp() {//初始化、指定处理函数、发送请求的函数
	xmlhttp = false;
	//开始初始化XMLHttpRequest对象
	if(window.XMLHttpRequest) { //Mozilla 浏览器
		xmlhttp = new XMLHttpRequest();
		if (xmlhttp.overrideMimeType) {//设置MiME类别
			xmlhttp.overrideMimeType('text/xml');
		}
	}
	else if (window.ActiveXObject) { // IE浏览器
		try {
			xmlhttp = new ActiveXObject("Msxml2.XMLHTTP");
		} catch (e) {
			try {
				xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
			} catch (e) {}
		}
	}
	if (!xmlhttp) { // 异常，创建对象实例失败
		window.alert("不能创建XMLHttpRequest对象实例.");
		return false;
	}
}
//get提交链接请求
function sendinfo(url,nodeid){
	node = nodeid;
	document.getElementById(node).innerHTML = "<div><span style=\"background-color:#FF8000; color:#FFFFFF;\">处理中...请稍候!</span></div>";
	createxmlhttp();
	var querystring = url+ "&timetmp=" + new Date().getTime();;
	xmlhttp.open("GET", querystring, true);
	xmlhttp.send(null);
	xmlhttp.onreadystatechange = processRequest;
}
function postinfo(url,nodeid){
	node = nodeid;
	document.getElementById(node).innerHTML = "<div><span style=\"background-color:#FF8000; color:#FFFFFF;\">处理中...请稍候!</span></div>";
	createxmlhttp();
	var url2 = url + "&timetmp=" + new Date().getTime();
	xmlhttp.open("POST", url2, true);
	xmlhttp.onreadystatechange = processRequest;
	xmlhttp.setRequestHeader("Content-Type","application/x-www-form-urlencoded;");
	var tw = document.getElementById("tw").value;
	var querystring = "tw="+encodeURIComponent(tw);
	xmlhttp.send(querystring);
}
// 处理返回信息的函数
function processRequest() {
	//alert(node+xmlhttp.readyState);
	if (xmlhttp.readyState == 4) { // 判断对象状态
		if (xmlhttp.status == 200) { // 信息已经成功返回，开始处理信息
			document.getElementById(node).innerHTML = xmlhttp.responseText;
		}
	}
}