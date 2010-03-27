<?php if(!defined('EMLOG_ROOT')) {exit('error!');}?>
<div id="admindex">
<div id="admindex_main">
你好：<a href="blogger.php" title="点击修改个人资料"><?php if($userData['nickname']):echo $userData['nickname'];else:echo $userData['username'];endif;?></a> 
(你有<span class=care2><b><?php echo ROLE == 'admin' ? $sta_cache['lognum'] : $sta_cache[UID]['lognum']; ?></b></span>篇日志 ，
<span class=care2><b><?php echo ROLE == 'admin' ? $sta_cache['comnum_all'] : $sta_cache[UID]['commentnum']; ?></b></span>条评论，
<span class=care2><b><?php echo ROLE == 'admin' ? $sta_cache['tbnum'] : $sta_cache[UID]['tbnum']; ?></b></span>条引用通告)
</div>
<div class="clear"></div>
<div id="admindex_servinfo">
<h3>服务器信息</h3>
<ul>
	<li>PHP版本：<?php echo $php_ver; ?></li>
	<li>MySQL版本：<?php echo $mysql_ver; ?></li>
	<li>服务器环境：<?php echo $serverapp; ?></li>
	<li>GD图形处理库：<?php echo $gd_ver; ?></li>
	<li>安全模式：<?php echo $safe_mode ? '开启' : '关闭'; ?></li>
	<li>服务器允许上传最大文件：<?php echo $uploadfile_maxsize; ?></li>
	<li><a href="index.php?action=phpinfo">更多信息&raquo;</a></li>
</ul>
<p id="m"><a title="用手机访问你的博客"><?php echo BLOG_URL.'m'; ?></a></p>
</div>
<div id="admindex_msg">
<h3>官方消息</h3>
<ul></ul>
</div>
<div class="clear"></div>
</div>
<script>
$(document).ready(function(){
	$("#admindex_msg ul").html("<span class=\"ajax_remind_1\">正在读取...</span>");
	$.getJSON("http://www.emlog.net/services/messenger.php?callback=?",
	function(data){
		$("#admindex_msg ul").html("");
		$.each(data.items, function(i,item){
			var image = '';
			if (item.image != ''){
				image = "<a href=\""+item.url+"\" target=\"_blank\" title=\""+item.title+"\"><img src=\""+item.image+"\"></a><br />";
			}
			$("#admindex_msg ul").append("<li class=\"msg_type_"+item.type+"\">"+image+"<span>"+item.date+"</span><a href=\""+item.url+"\" target=\"_blank\">"+item.title+"</a></li>");
		});
	});
});
</script>
