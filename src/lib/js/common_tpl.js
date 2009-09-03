/*Foreground template js*/
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
		alert(l_keyword_empty);
		document.keyform.keyword.focus();
		return false;
	}
	if (document.keyform.keyword.value.length<3){
		alert(l_keyword_short);
		document.keyform.keyword.focus();
		return false;
	}
	if (document.keyform.keyword.value.length>31){
		alert(l_keyword_long);
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
		alert(l_name_empty);
		document.commentform.comname.focus();
		return false;
	}
	if(document.commentform.comname.value.length>16){
		alert(l_key_too_long);
		document.commentform.comname.focus();
		return false;
	}
	if(document.commentform.comment.value.length==""){
		alert(l_comment_empty);
		document.commentform.comment.focus();
		return false;
	}
	if(document.commentform.comment.value.length>2000){
		alert(l_comment_too_long);
		document.commentform.comment.focus();
		return false;
	}
	if(document.commentform.commail.value!=""){
		if(document.commentform.commail.value.length>60){
			alert(l_email_long);
			document.commentform.commail.focus();
			return false;
		}
		if(!checkEmail(document.commentform.commail.value)){
			alert(l_email_invalid);
			document.commentform.commail.focus();
			return false;
		}
	}
}
function isdel (id,type){
	if(type == 'twitter'){
		var msg = l_sure_delete;
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
		window.alert(l_not_supported);
		return false;
	}
}
function sendinfo(url,nodeid){
	node = nodeid;
	updateEle(node,"<div><span style=\"background-color:#FF8000; color:#FFFFFF;\">"+l_loading+"...</span></div>");
	createxmlhttp();
	var querystring = url+ "&timetmp=" + timestamp();
	xmlhttp.open("GET", querystring, true);
	xmlhttp.send(null);
	xmlhttp.onreadystatechange = processRequest;
}
function postinfo(url,post_id,show_id){
	node = show_id;
	updateEle(node,"<div><span style=\"background-color:#FF8000; color:#FFFFFF;\">"+l_processing+"</span></div>");
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