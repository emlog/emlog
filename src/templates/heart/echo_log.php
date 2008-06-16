<?php
if(!defined('EMLOG_ROOT')) {exit('error!');}
include getViews('side');
//$att_img = getAttachment($att_img,600,500);
?>
<div class="logcontent">
<p id="tit"><?php echo $log_title; ?></p>
<p id="date"><?php echo $post_time; ?></p>

<div class="log_con">
<?php echo $log_content; ?>
<p><?php echo $att_img; ?></p>
<p><?php echo $attachment; ?></p>	
<p><?php echo $tag; ?></p>
</div>

<div class="nextlog"><?php echo $neighborLog; ?></div>

<?php if($allow_tb == 'y'){ ?>	
<div id="tb_list">
<p class="other"><b>引用地址：</b> <input type="text" style="width:350px" class="input" value="<?php echo $blogurl; ?>tb.php?sc=<?php echo $tbscode; ?>&amp;id=<?php echo $logid; ?>"><a name="tb"></a></p>
</div>

<?php 
} 
foreach($tb as $key=>$value){
?>
<div class="trackback">
	<li>来自: <a href="<?php echo $value['url'];?>" target="_blank"><?php echo $value['blog_name'];?></a></li>
    <li>标题: <a href="<?php echo $value['url'];?>" target="_blank"><?php echo $value['title'];?></a> </li>
    <li>摘要:<?php echo $value['excerpt'];?></li>
	<li>引用时间:<?php echo $value['excerpt'];?></li>
</div>
<?php
}if($com){
?>
<p class="other"><b>评论:</b><a name="comment"></a></p>
<?php } ?>
<div id="com_list">
<?php
foreach($com as $key=>$value){
$value['reply'] = $value['reply']?"<span><b>博主回复</b>：{$value['reply']}</span>":'';
?>
<li><a name="<?php echo $value['cid']; ?>"></a><?php echo $value['poster']; ?> <?php echo $value['addtime']; ?><br /><?php echo $value['content']; ?><br /><?php echo $value['reply']; ?></li>
<?php } ?>
</div>
<?php if($allow_remark == 'y'){ ?>
<p class="other"><b>发表评论:</b><a name="comment"></a></p>
<form  method="post"  name="commentform" action="index.php?action=addcom">
<table width="500" border="0" cellspacing="5" cellpadding="0">
<tr>
<td class="other">姓　 名：</td>
<td>
<input type="hidden" name="gid" value="<?php echo $logid; ?>" />
<input type="text" name="comname" style="width:200px; background:#c2f5f9;color:#fbab9c" maxlength="49" value="<?php echo $ckname; ?>"></td>
</tr>
<tr>
<td class="other">电子邮件:</td>
<td class="other"><input type="text" name="commail" style="width:300px; background:#c2f5f9;color:#fbab9c" maxlength="128"  value="<?php echo $ckmail; ?>"> (选填)</td>
</tr>
<tr>
<td class="other">个人主页:</td>
<td class="other"><input type="text" name="comurl" style="width:300px; background:#c2f5f9;color:#fbab9c" maxlength="128"  value="<?php echo $ckurl; ?>"> (选填)</td>
</tr>
<tr>
<td valign="top" class="other">内　 容：</td>
<td><textarea name="comment" style="width:420px;height:155px; background:#c2f5f9;color:#fbab9c"></textarea>
</td>
</tr>

<tr>
<td valign="top"class="other">&nbsp;</td>
<td valign="top" class="other"><?php echo $cheackimg; ?><input name="Submit" type="submit" style="background:#c2f5f9;color:#fbab9c" value="发表评论" onclick="return checkform()" />
<input type="checkbox" name="remember" value="1" checked="checked" style="border:2px #fbab9c" />记住我</td>
</tr>
</table>
</form>
<?php } ?>
</div>
<?php include getViews('footer'); ?>