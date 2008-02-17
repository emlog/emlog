// JavaScript Document
var attaIdx = 0;
var IsIE;
function add() {
	addfile("idfilespan",attaIdx);
	attaIdx++;
	return false;
}
function addfile(spanId,index)
{
       var strIndex = "" + index;
	   var fileId = "attachfile"+ strIndex;
	   var brId = "idAttachBr" + strIndex;
	   addInputFile(spanId,fileId);
	   addbr(spanId,brId);
	   return;
}
function addInputFile(spanId,fileId){
	  var span = document.getElementById(spanId);
	  if ( span !=null ) {

					var fileObj = document.createElement("input");
						if ( fileObj != null ) {
							fileObj.type="file";
							fileObj.name = "attach[]";
							fileObj.size="20";  
							fileObj.id="input";  
							span.appendChild(fileObj);
					}
					span.appendChild(document.createTextNode(" 描述："));
					var fileObj = document.createElement("input");
						if ( fileObj != null ) {
							fileObj.type="text";
							fileObj.name = "attdes[]";
							fileObj.size="25";
							fileObj.id="input";  
							span.appendChild(fileObj);
					}
	  }
}
function addbr(spanId,brId){
	  var span = document.getElementById(spanId);
	  if ( span !=null ) {
			var brObj = document.createElement("br");
				span.appendChild(brObj);
     }
	 return;
}
function chekform(){
	if (document.addlog.title.value==""){
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

//ajax
	var xmlhttp = false;
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
			return false;}}
//
function dorequest(url){
		createxmlhttp();
		var url = url + "?timetmp=" + new Date().getTime();
		xmlhttp.open("POST", url, true);
		xmlhttp.onreadystatechange = processRequest;
		xmlhttp.setRequestHeader("Content-Type","multipart/form-data;");
		var att = document.getElementById("attachment").file;
		var querystring = "att=" + att;
		xmlhttp.send(querystring);
}
function processRequest() {
        if (xmlhttp.readyState == 4) { 
            if (xmlhttp.status == 200) {
				document.getElementById("attlist").innerHTML = xmlhttp.responseText;}}
}
function sendinfo(url) {
		document.getElementById("attlist").innerHTML = 
		"<span style=\"background-color:#FF8000; color:#FFFFFF;\">处理中...请稍候!</span>";
		dorequest(url);
}