<?php if(!defined('EMLOG_ROOT')) {exit('error!');}?>
<div class="container_title"><b>编辑评论</b>
</div>
<div class=line></div>
<form action="comment.php?action=doedit" method="post">
<div class="item_edit">
	<li><input type="text" value="<?php echo $poster; ?>" name="name" style="width:200px;" class="input" /> 评论人</li>
    <li><input type="text"  value="<?php echo $mail; ?>" name="mail" style="width:200px;" class="input" /> 电子邮件</li>
	<li><input type="text"  value="<?php echo $url; ?>" name="url" style="width:200px;" class="input" /> 主页</li>
    <li>评论内容：<br /><textarea name="comment" rows="8" cols="60" class="textarea"><?php echo $comment; ?></textarea></li>
	<input type="hidden" value="<?php echo $cid; ?>" name="cid" />
	<input type="submit" value="保 存" class="button" />
	<input type="button" value="取 消" class="button" onclick="javascript: window.history.back();" /></li>
</div>
</form>
<script>
$("#menu_cm").addClass('active');
</script>
