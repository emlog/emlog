<?php if(!defined('EMLOG_ROOT')) {exit('error!');}?>
<div id="admindex">
<div id="admindex_main">
<? echo $lang['there_are'];?>: <span class=care2><b><?php echo ROLE == 'admin' ? $sta_cache['lognum'] : $user_cache[UID]['lognum']; ?></b></span> <? echo $lang['blog_posts'];?>,
<span class=care2><b><?php echo ROLE == 'admin' ? $sta_cache['comnum_all'] : $user_cache[UID]['commentnum']; ?></b></span> <? echo $lang['comments'];?>
<?php
$hidecmnum = ROLE == 'admin' ? $sta_cache['hidecomnum'] : $user_cache[UID]['hidecommentnum'];
if ($hidecmnum > 0):
?>
(<? echo $lang['unapproved'];?>: <b><a href="./comment.php?hide=y"><?php echo $hidecmnum; ?></a></b>)
<?php endif; ?>
, <span class=care2><b><?php echo ROLE == 'admin' ? $sta_cache['tbnum'] : $user_cache[UID]['tbnum']; ?></b></span> <? echo $lang['trackbacks'];?>
</div>
<div class="clear"></div>
<div id="admindex_servinfo">
<h3><? echo $lang['server_info'];?></h3>
<ul>
	<li><? echo $lang['php_version'];?>: <?php echo $php_ver; ?></li>
	<li><? echo $lang['mysql_version'];?>: <?php echo $mysql_ver; ?></li>
	<li><? echo $lang['server_environment'];?>: <?php echo $serverapp; ?></li>
	<li><? echo $lang['server_time'];?>: <?php echo $serverdate; ?></li>
	<li><? echo $lang['gd_library'];?>: <?php echo $gd_ver; ?></li>
	<li><? echo $lang['safe_mode'];?>: <?php echo $safe_mode ? $lang['enabled'] : $lang['disabled']; ?></li>
	<li><? echo $lang['attachment_max_size'];?>: <?php echo $uploadfile_maxsize; ?></li>
	<li><a href="index.php?action=phpinfo"><? echo $lang['php_info'];?> &raquo;</a></li>
</ul>
</div>
<div id="admindex_msg">
<h3><? echo $lang['official_info'];?></h3>
<ul></ul>
</div>
<div class="clear"></div>
</div>
<script>
$(document).ready(function(){
	$("#admindex_msg ul").html("<span class=\"ajax_remind_1\"><? echo $lang['loading'];?></span>");
	$.getJSON("http://www.emlog.net/services/messenger.php?callback=?",
	function(data){
		$("#admindex_msg ul").html("");
		$.each(data.items, function(i,item){
			var image = '';
			if (item.image != ''){
				image = "<a href=\""+item.url+"\" target=\"_blank\" title=\""+item.title+"\"><img src=\""+item.image+"\"></a><br />";
			}
			//!!! ToDo: Convert item.date to international standard!!!
			$("#admindex_msg ul").append("<li class=\"msg_type_"+item.type+"\">"+image+"<span>"+item.date+"</span><a href=\""+item.url+"\" target=\"_blank\">"+item.title+"</a></li>");
		});
	});
});
</script>
