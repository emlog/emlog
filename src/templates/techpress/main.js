function DoMenu(emid)
{
	var obj = document.getElementById(emid);	
	obj.className = (obj.className.toLowerCase() == "expanded"?"collapsed":"expanded");
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
/*ajax*/

//初始化xmlhttp对象
	var xmlhttp = false;
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
function sendinfo(url)	{
		createxmlhttp();
		xmlhttp.onreadystatechange = processRequest;
		var querystring = url;
		xmlhttp.open("GET", querystring, true);
		xmlhttp.send(null);
	}
// 处理返回信息的函数
function processRequest() {
        if (xmlhttp.readyState == 4) { // 判断对象状态
            if (xmlhttp.status == 200) { // 信息已经成功返回，开始处理信息
				document.getElementById("calendar").innerHTML = xmlhttp.responseText;
            }
        }
    }


