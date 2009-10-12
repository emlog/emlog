/*前台模板共享js*/
function focusEle(ele){
	try {document.getElementById(ele).focus();}
	catch(e){}
}
function displayToggle(ele) {
	var ele = document.getElementById(ele);
	ele.style.display = ele.style.display == 'none' ? '' : 'none' ;
}
function hideEle(ele) {
	document.getElementById(ele).style.display == 'none';
}
function showEle(ele){
	document.getElementById(ele).style.display == '';
}
function updateEle(ele,content){
	document.getElementById(ele).innerHTML = content;
}
function timestamp(){
	return new Date().getTime();
}
function showhidediv(id){
	displayToggle(id);
	var input_id=arguments[1];
	if(input_id){focusEle(input_id);}
}
function keyw(){
	if (document.keyform.keyword.value==""){
		alert("请输入要搜索的关键字");
		document.keyform.keyword.focus();
		return false;
	}
}
function checkEmail (str){
	isEmail1=/^\w+([\.\-]\w+)*\@\w+([\.\-]\w+)*\.\w+$/;
	isEmail2=/^.*@[^_]*$/;
	return (isEmail1.test(str)&&isEmail2.test(str));
}
function checkform(){
	if (document.commentform.comname.value==""){
		alert("名字不能为空");
		document.commentform.comname.focus();
		return false;
	}
	if(document.commentform.comname.value.length>16){
		alert("名字太长");
		document.commentform.comname.focus();
		return false;
	}
	if(document.commentform.comment.value.length==""){
		alert("评论内容不能为空");
		document.commentform.comment.focus();
		return false;
	}
	if(document.commentform.comment.value.length>2000){
		alert("评论内容太长");
		document.commentform.comment.focus();
		return false;
	}
	if(document.commentform.commail.value!=""){
		if(document.commentform.commail.value.length>60){
			alert("邮件地址长度超出系统接受范围");
			document.commentform.commail.focus();
			return false;
		}
		if(!checkEmail(document.commentform.commail.value)){
			alert("邮件地址格式错误！");
			document.commentform.commail.focus();
			return false;
		}
	}
}
function isdel (id,type){
	if(type == 'twitter'){
		var msg = "你确定要删除吗？";
		if(confirm(msg)){sendinfo('twitter.php?action=del&twid='+id,'twitter')}
		else {return;}
	}
}
//ajax
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
function sendinfo(url,nodeid){
	node = nodeid;
	updateEle(node,"<div><span style=\"background-color:#FF8000; color:#FFFFFF;\">加载中...</span></div>");
	createxmlhttp();
	var querystring = url+ "&timetmp=" + timestamp();
	xmlhttp.open("GET", querystring, true);
	xmlhttp.send(null);
	xmlhttp.onreadystatechange = processRequest;
}
function postinfo(url,post_id,show_id){
	node = show_id;
	updateEle(node,"<div><span style=\"background-color:#FF8000; color:#FFFFFF;\">处理中...请稍候!</span></div>");
	createxmlhttp();
	var url2 = url + "&timetmp=" + timestamp();
	xmlhttp.open("POST", url2, true);
	xmlhttp.onreadystatechange = processRequest;
	xmlhttp.setRequestHeader("Content-Type","application/x-www-form-urlencoded;");
	var pdata = document.getElementById(post_id).value;
	var querystring = post_id+"="+encodeURIComponent(pdata);
	xmlhttp.send(querystring);
}
function processRequest(){
	if (xmlhttp.readyState == 4) {
		if (xmlhttp.status == 200) {
			updateEle(node,xmlhttp.responseText);
		}
	}
}