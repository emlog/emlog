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
		case 'page':
		var urlreturn="page.php?action=del&gid="+id;
		var msg = "你确定要删除该页面吗？";
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
	if (t==""){alert("标题不能为空");$("#title").focus();return false;}else return true;
}
//att
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
function insertTag (tag, boxId){
	var targetinput = $("#"+boxId).val();
	if(targetinput == ''){
		targetinput += tag;
	}else{
		var n = ',' + tag;
		targetinput += n;
	}
	$("#"+boxId).val(targetinput);
}
//act:0 auto save,1 click attupload,2 click savedf button, 3 save page, 4 click page attupload
function autosave(act){
	var nodeid = "as_logid";
	if (act == 3 || act == 4){
		var url = "page.php?action=autosave";
		var title = $.trim($("#title").val());
		var logid = $("#as_logid").val();
		var oEditor = FCKeditorAPI.GetInstance('content');
		var content = oEditor.GetXHTML();
		var pageurl = $.trim($("#url").val());
		var allow_remark = $.trim($("table input[name=allow_remark][checked]").val());
		var is_blank = $.trim($("table input[name=is_blank][checked]").val());
		var ishide = $.trim($("#ishide").val());
		var ishide = ishide == "" ? "y" : ishide;
		var querystr = "content="+encodeURIComponent(content)
					+"&title="+encodeURIComponent(title)
					+"&allow_remark="+allow_remark
					+"&is_blank="+is_blank
					+"&url="+pageurl
					+"&ishide="+ishide
					+"&as_logid="+logid;
	}else{
		var url = "save_log.php?action=autosave";
		var title = $.trim($("#title").val());
		var sort = $.trim($("#sort").val());
		var postdate = $.trim($("#postdate").val());
		var date = $.trim($("#date").val());
		var logid = $("#as_logid").val();
		var oEditor = FCKeditorAPI.GetInstance('content');
		var content = oEditor.GetXHTML();
		var oEditor = FCKeditorAPI.GetInstance('excerpt');
		var excerpt = oEditor.GetXHTML();
		var tag = $.trim($("#tag").val());
		var allow_remark = $.trim($("#advset input[name=allow_remark][checked]").val());
		var allow_tb = $.trim($("#advset input[name=allow_tb][checked]").val());
		var password = $.trim($("#password").val());
		var ishide = $.trim($("#ishide").val());
		var ishide = ishide == "" ? "y" : ishide;
		var querystr = "content="+encodeURIComponent(content)
					+"&excerpt="+encodeURIComponent(excerpt)
					+"&title="+encodeURIComponent(title)
					+"&sort="+sort
					+"&postdate="+postdate
					+"&date="+date
					+"&tag="+encodeURIComponent(tag)
					+"&allow_remark="+allow_remark
					+"&allow_tb="+allow_tb
					+"&password="+password
					+"&ishide="+ishide
					+"&as_logid="+logid;
	}
	if(act == 0){
		if(ishide == 'n'){return;}
		if (content == ""){
			setTimeout("autosave(0)",60000);
			return;
		}
	}
	if(act == 1 || act == 4){
		var gid = $("#"+nodeid).val();
		if (gid != -1){return;}
	}
	$("#msg").html("<span class=\"msg_autosave_do\">正在保存...</span>");
	var btname = $("#savedf").val();
	$("#savedf").val("正在保存");
	$("#savedf").attr("disabled", "disabled");
	$.post(url, querystr, function(data){
		if(data.substring(0,9) == "autosave_"){
			var getvar = data.match(/\_gid\:([\d]+)\_df\:([\d]+)\_/);
			var logid = getvar[1];
			if (act != 3){
				var dfnum = getvar[2];
				if(dfnum > 0){$("#dfnum").html("("+dfnum+")")};
			}
		}
		$("#"+nodeid).val(logid);
		var digital = new Date();
		var hours = digital.getHours();
		var mins = digital.getMinutes();
		var secs = digital.getSeconds();
		$("#msg_2").html("<span class=\"ajax_remind_1\">成功保存于 "+hours+":"+mins+":"+secs+" </span>");
		$("#savedf").attr("disabled", "");
		$("#savedf").val(btname);
		$("#msg").html("");
	});
	if(act == 0){
		setTimeout("autosave(0)",60000);
	}
}