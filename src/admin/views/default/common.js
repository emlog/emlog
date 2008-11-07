function CheckAll(form) {
	for (var i=0;i<form.elements.length;i++) {
		var e = form.elements[i];
		if (e.name != 'chkall')
		e.checked = form.chkall.checked;}
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
	}
	if(confirm(msg)){
		window.location = urlreturn;
	}else {
		return;
	}
}
function focusEle(id){
	try{document.getElementById(id).focus();}catch(e){}
}