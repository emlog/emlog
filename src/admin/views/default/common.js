function CheckAll(form) 
{ 
	for (var i=0;i<form.elements.length;i++) 
	{ 
		var e = form.elements[i]; 
		if (e.name != 'chkall') 
		e.checked = form.chkall.checked;
	} 
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