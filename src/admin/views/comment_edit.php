<?php if(!defined('EMLOG_ROOT')) {exit('error!');}?>
<div class=containertitle><b>编辑评论</b>
</div>
<div class=line></div>
<form action="comment.php?action=doedit" method="post">
<div class="item_edit">
	<li><input type="text" value="<?php echo $poster; ?>" name="name" style="width:200px;" /> 评论人</li>
    <li><input type="text"  value="<?php echo $mail; ?>" name="mail" style="width:200px;" /> 电子邮件</li>
	<li><input type="text"  value="<?php echo $url; ?>" name="url" style="width:200px;" /> 主页</li>
    <li>评论内容：<br /><textarea name="comment" rows="8" cols="60"><?php echo $comment; ?></textarea></li>
	<input type="hidden" value="<?php echo $cid; ?>" name="cid" />
	<input type="submit" value="保 存" class="submit" />
	<input type="button" value="取 消" class="submit" onclick="javascript: window.history.back();" /></li>
</div>
</form>
<script>
$("#menu_cm").addClass('sidebarsubmenu1');
</script>