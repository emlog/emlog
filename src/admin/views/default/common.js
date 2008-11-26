function CheckAll(form) {
	for (var i=0;i<form.elements.length;i++) {
		var e = form.elements[i];
		if (e.name != 'chkall')
		e.checked = form.chkall.checked;
	}
}
function em_confirm (id, property) {
	switch (property){
		case 'comment':
		var urlreturn="comment.php?action=del_comment&commentid="+id;
		var msg = "你确定要删除该评论吗？";
		break;
		case 'link':
		var urlreturn="link.php?action=dellink&linkid="+id;
		var msg = "你确定要删除该友情站点吗？";
		break;
		case 'log':
		var urlreturn="admin_log.php?action=dellog&gid="+id;
		var msg = "你确定要删除该篇日志吗？";
		break;
		case 'draft':
		var urlreturn="admin_log.php?action=deldraft&gid="+id;
		var msg = "你确定要删除该篇草稿吗？";
		break;
		case 'trackback':
		var urlreturn="trackback.php?action=del_tb&tbid="+id;
		var msg = "你确定要删除该引用吗？";
		break;
		case 'backup':
		var urlreturn="backup.php?action=renewdata&sqlfile="+id;
		var msg = "你确定要导入该备份文件吗？";
		break;
		case 'attachment':
		var urlreturn="attachment.php?action=del_attach&aid="+id;
		var msg = "你确定要删除该附件吗？";
		break;
		case 'avatar':
		var urlreturn="blogger.php?action=delicon";
		var msg = "你确定要删除头像吗？";
		break;
		case 'sort':
		var urlreturn="sort.php?action=del&sid="+id;
		var msg = "你确定要删除该分类吗？";
		break;
	}
	if(confirm(msg)){window.location = urlreturn;}else {return;}
}
function focusEle(id){try{document.getElementById(id).focus();}catch(e){}}
function hideActived(){
	$(".actived").hide();
	$(".error").hide();
}
function displayToggle(id){
	$("#"+id).toggle();
}
function chekform(){
	var t = $.trim($("#title").val());
	if (t==""){alert("日志标题不能为空");$("#title").focus();return false;}else return true;
}
//att^
function addhtml(content){
	var oEditor = FCKeditorAPI.GetInstance('content');
	if ( oEditor.EditMode == FCK_EDITMODE_WYSIWYG ) {
		oEditor.InsertHtml(content) ;
	} else {
		alert('请先转换到所见即所得模式') ;
	}
}
function addattach(imgurl,imgsrc,aid){
	addhtml('<a target=\"_blank\" href=\"'+imgurl+'\" id=\"ematt:'+aid+'\"><img src=\"'+imgsrc+'\" alt=\"点击查看原图\" border=\"0\"></a>');
}
//autosave
function autosave(url,nodeid){
	var title = $.trim($("#title").val());
	var logid = $("#as_logid").val();
	var oEditor = FCKeditorAPI.GetInstance('content');
	var content = oEditor.GetXHTML();
	var querystr = "content="+encodeURIComponent(content)+"&title="+encodeURIComponent(title)+"&as_logid="+logid;
	$("#auto_msg").html("<span style=\"background-color:#FF8000; color:#FFFFFF;\">正在自动保存日志……!</span>");
	$.post(url, querystr, function(data){
		if(data.substring(0,9) == "autosave_"){
			var getvar = data.match(/\_gid\:([\d]+)\_df\:([\d]+)\_/);
			var logid = getvar[1];
			var dfnum = getvar[2];
			$("#dfnum").html("("+dfnum+")");
			var iddiv = "<input type=hidden  name=as_logid id=as_logid value="+logid+">";
		}
		$("#"+nodeid).html(iddiv);
		var digital = new Date();
		var hours = digital.getHours();
		var mins = digital.getMinutes();
		var secs = digital.getSeconds();
		$("#auto_msg").html("<span style=\"background-color:#FF8000; color:#FFFFFF;\">草稿自动保存,于"+hours+":"+mins+":"+secs+" </span>");
	});
	setTimeout("autosave('add_log.php?action=autosave','asmsg')",30000);
}