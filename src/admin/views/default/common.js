function CheckAll(form) {
	for (var i=0;i<form.elements.length;i++) {
		var e = form.elements[i];
		if (e.name != 'chkall')
		e.checked = form.chkall.checked;
	}
}
function getChecked(node) {
	var re = false;
	$('input.'+node).each(function(i){
		if (this.checked) {
			re = true;
		}
	});
	return re;
}
function em_confirm (id, property) {
	switch (property){
		case 'link':
		var urlreturn="link.php?action=dellink&linkid="+id;
		var msg = l_sure_delete_link;break;
		case 'backup':
		var urlreturn="data.php?action=renewdata&sqlfile="+id;
		var msg = l_sure_import;break;
		case 'attachment':
		var urlreturn="attachment.php?action=del_attach&aid="+id;
		var msg = l_sure_delete_attach;break;
		case 'avatar':
		var urlreturn="blogger.php?action=delicon";
		var msg = l_sure_delete_image;break;
		case 'sort':
		var urlreturn="sort.php?action=del&sid="+id;
		var msg = l_sure_delete_category;break;
		case 'page':
		var urlreturn="page.php?action=del&gid="+id;
		var msg = l_sure_delete_page;break;
		case 'user':
		var urlreturn="user.php?action=del&uid="+id;
		var msg = l_sure_delete_user;break;
	}
	if(confirm(msg)){window.location = urlreturn;}else {return;}
}
function focusEle(id){try{document.getElementById(id).focus();}catch(e){}}
function hideActived(){
	$(".actived").hide();
	$(".error").hide();
}
function displayToggle(id, keep){
	$("#"+id).toggle();
	if (keep == 1){$.cookie('em_'+id,$("#"+id).css('display'),{expires:365});}
	if (keep == 2){$.cookie('em_'+id,$("#"+id).css('display'));}
}
function chekform(){
	var t = $.trim($("#title").val());
	if (t==""){alert(l_title_empty);$("#title").focus();return false;}else return true;
}
//att
function addhtml(content){
	var oEditor = FCKeditorAPI.GetInstance('content');
	if ( oEditor.EditMode == FCK_EDITMODE_WYSIWYG ) {
		oEditor.InsertHtml(content) ;
	} else {
		alert(l_switch_wysiwyg) ;
	}
}
function addattach(imgurl,imgsrc,aid){
	addhtml('<a target=\"_blank\" href=\"'+imgurl+'\" id=\"ematt:'+aid+'\"><img src=\"'+imgsrc+'\" alt=\"'+l_show_orig_img+'\"" border=\"0\"></a>');
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
		var author = $("#author").val();
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
					+"&author="+author
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
	$("#msg").html("<span class=\"msg_autosave_do\">"+l_saving+"...</span>");
	var btname = $("#savedf").val();
	$("#savedf").val(l_saving);
	$("#savedf").attr("disabled", "disabled");
	$.post(url, querystr, function(data){
		data = $.trim(data);
		if(data.substring(0,9) == "autosave_"){
			var getvar = data.match(/\_gid\:([\d]+)\_df\:([\d]*)\_/);
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
		$("#msg_2").html("<span class=\"ajax_remind_1\">"+l_saved_at+hours+":"+mins+":"+secs+"</span>");
		$("#savedf").attr("disabled", "");
		$("#savedf").val(btname);
		$("#msg").html("");
	});
	if(act == 0){
		setTimeout("autosave(0)",60000);
	}
}