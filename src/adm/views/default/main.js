//add or rm attachment
function $(id) {
	return document.getElementById(id);
}
function addattachfrom() {
	var newnode = $('attachbodyhidden').firstChild.cloneNode(true);
	$('attachbody').appendChild(newnode);
}
function removeattachfrom() {
	$('attachbody').childNodes.length > 1 && $('attachbody').lastChild ? $('attachbody').removeChild($('attachbody').lastChild) : 0;
}
//show or hide div
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

String.prototype.Trim = function()
{
return this.replace(/(^\s*)|(\s*$)/g, "");
}
function chekform(){
	var title = document.addlog.title.value.Trim();
	if (title=="")
	{
		alert("日志标题不能为空");
		document.addlog.title.focus();
		return false;
	}else 
	return true;	
}
function inserttag (tag, taginputname) {
	var currenttag=tag;
	var targetinput=document.getElementById(taginputname);
	 if(targetinput.value=='')  {
		 var newvalue= currenttag;
			targetinput.value+=newvalue;
	 }else{
		var newvalue=','+currenttag;
		targetinput.value+=newvalue;
	}
}
function doshow(elementid) {
	if (document.getElementById('switch').checked) 
		document.getElementById(elementid).style.display='block';
	else 
		document.getElementById(elementid).style.display='none';
}
//删除确定
function isdel (id, property) {
	if (property==1) 	{
		var urlreturn="comment.php?action=del_comment&commentid="+id;
		var msg = "你确定要删除该评论吗？";
	} else if (property==2)  {
		var urlreturn="link.php?action=dellink&linkid="+id;
		var msg = "你确定要删除该友情站点吗？";
	} else if (property==3)  {
		var urlreturn="admin_log.php?action=delLog&gid="+id;
		var msg = "你确定要删除该篇日志吗？";
	} else if (property==4)  {
		var urlreturn="trackback.php?action=del_tb&tbid="+id;
		var msg = "你确定要删除该引用吗？";
	}else if (property==5)  {
		var urlreturn="backupdata.php?action=renewdata&sqlfile="+id;
		var msg = "你确定要导入该备份文件吗？";
	}else if (property==6)  {
		var urlreturn="attachment.php?action=del_attach&aid="+id;
		var msg = "你确定要删除该附件吗？";
	}else if (property==7)  {
		var urlreturn="blogger.php?action=delicon";
		var msg = "你确定要删除头像吗？";
	}else {
		var urlreturn="admin.php?go=entry_deletedraft_"+blogid+'';
	}
	if(confirm(msg)){
		window.location=urlreturn;
	}
	else {
		return;
	}
}
function addhtml(content){
	var oEditor = FCKeditorAPI.GetInstance('content');
	if ( oEditor.EditMode == FCK_EDITMODE_WYSIWYG ) {
		oEditor.InsertHtml(content) ;
	} else {
		alert('请先转换到所见即所得模式') ;
	}
}
function addattach(imgurl,imgsrc,des,aid){
	addhtml('<a target=\"_blank\" href=\"'+imgurl+'\"><img src=\"'+imgsrc+'\" alt=\"附件[ematt:'+aid+'] '+des+'\" border=\"0\"></a>');
}

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
	var querystring = "tw=" + tw;
	xmlhttp.send(querystring);
}
function autosave(url,nodeid)
{
	node = nodeid;
	createxmlhttp();
	var url2 = url + "&timetmp=" + new Date().getTime();
	xmlhttp.open("POST", url2, true);
	xmlhttp.onreadystatechange = processRequest;
	xmlhttp.setRequestHeader("Content-Type","application/x-www-form-urlencoded;");
	var title = document.getElementById("title").value.Trim();
	var logid = document.getElementById("as_logid").value;
	var oEditor = FCKeditorAPI.GetInstance('content');
	var content = oEditor.GetXHTML();
	var querystring = "content="+encodeURIComponent(content)+"&title="+encodeURIComponent(title)+"&as_logid="+logid;
	if(logid!=-2 && title!="" && content!="")
	{
		document.getElementById("auto_msg").innerHTML = "<span style=\"background-color:#FF8000; color:#FFFFFF;\">正在自动保存日志……!</span>";
		xmlhttp.send(querystring);
	}
	setTimeout("autosave('add_log.php?action=autosave','asmsg')",30000);
}
function processRequest() {
	if (xmlhttp.readyState == 4) {
		if (xmlhttp.status == 200) {
			var ret = xmlhttp.responseText;
			if(ret.substring(0,9) == "autosave_")
			{
				var getvar = ret.match(/\_gid\:([\d]+)\_df\:([\d]+)\_/);
				var logid = getvar[1];
				var dfnum = getvar[2];
				document.getElementById("dfnum").innerHTML = "("+dfnum+")";
				var iddiv = "<input type=hidden  name=as_logid id=as_logid value="+logid+">";
			}
			document.getElementById(node).innerHTML = iddiv;
			var digital = new Date();
			var hours = digital.getHours();
			var mins = digital.getMinutes();
			var secs = digital.getSeconds();
			document.getElementById("auto_msg").innerHTML = "<span style=\"background-color:#FF8000; color:#FFFFFF;\">草稿自动保存于 "+hours+":"+mins+":"+secs+" </span>";
		}
	}
}