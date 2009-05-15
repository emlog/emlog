<?php
if(!defined('EMLOG_ROOT')) {exit('error!');}
include getViews('side');
?>
<div class="logcontent">
<p id="tit">
<?php echo $log_title; ?>
<?php if($log_cache_sort[$logid]): ?>
<span class="sort">[<a href="<?php echo BLOG_URL; ?>?sort=<?php echo $sortid; ?>"><?php echo $log_cache_sort[$logid]; ?></a>]</span>
<?php endif;?>
</p>
<p id="date"><?php echo date('Y-n-j G:i l', $date); ?></p>

<div class="log_con">
<?php echo $log_content; ?>
<p>
	<?php 
	$attachment = !empty($log_cache_atts[$logid]) ? '<b>文件附件</b>:'.$log_cache_atts[$logid] : '';
	echo $attachment;
	?>
</p>
<p>
	<?php 
	$tag = !empty($log_cache_tags[$logid]) ? '标签:'.$log_cache_tags[$logid] : '';
	echo $tag;
	?>
</p>
</div>

<div class="nextlog">
<?php if($prevLog):?>
	&laquo; <a href="<?php echo BLOG_URL; ?>?post=<?php echo $prevLog['gid']; ?>"><?php echo $prevLog['title'];?></a>
<?php endif;?>
<?php if($nextLog && $prevLog):?>
	|
<?php endif;?>
<?php if($nextLog):?>
	<a href="<?php echo BLOG_URL; ?>?post=<?php echo $nextLog['gid']; ?>"><?php echo $nextLog['title'];?></a>&raquo;
<?php endif;?>
</div>

<?php if($allow_tb == 'y'): ?>	
<div id="tb_list">
<p><b>引用地址：</b> <input type="text" style="width:350px" class="input" value="<?php echo BLOG_URL; ?>tb.php?sc=<?php echo $tbscode; ?>&amp;id=<?php echo $logid; ?>"><a name="tb"></a></p>
</div>

<?php endif; ?>
<?php foreach($tb as $key=>$value): ?>
<div class="trackback">
	<li>来自: <a href="<?php echo $value['url'];?>" target="_blank"><?php echo $value['blog_name'];?></a></li>
    <li>标题: <a href="<?php echo $value['url'];?>" target="_blank"><?php echo $value['title'];?></a> </li>
    <li>摘要:<?php echo $value['excerpt'];?></li>
	<li>引用时间:<?php echo $value['date'];?></li>
</div>
<?php endforeach; ?>
<?php if($comments): ?>
<p><b>评论:</b><a name="comment"></a></p>
<?php endif; ?>
<div id="com_list">
<?php
foreach($comments as $key=>$value):
$reply = $value['reply']?"<span><b>博主回复</b>：{$value['reply']}</span>":'';
?>
<li>
<a name="<?php echo $value['cid']; ?>"></a>
<?php echo $value['poster']; ?> 
<?php if($value['mail']):?>
	<a href="mailto:<?php echo $value['mail']; ?>" title="发邮件给<?php echo $value['poster']; ?>">Email</a>
<?php endif;?>
<?php if($value['url']):?>
	<a href="<?php echo $value['url']; ?>" title="访问<?php echo $value['poster']; ?>的主页" target="_blank">主页</a>
<?php endif;?>
<?php echo $value['date']; ?><br /><?php echo $value['content']; ?><br /><div id="replycomm<?php echo $value['cid']; ?>"><?php echo $reply; ?></div>
	<?php if(ISLOGIN === true): ?>	
		<a href="javascript:void(0);" onclick="showhidediv('replybox<?php echo $value['cid']; ?>','reply<?php echo $value['cid']; ?>')">回复</a>
		<div id='replybox<?php echo $value['cid']; ?>' style="display:none;">
		<textarea name="reply<?php echo $value['cid']; ?>" class="input" id="reply<?php echo $value['cid']; ?>" style="overflow-y: hidden;width:360px;height:50px;"><?php echo $value['reply']; ?></textarea>
		<br />
		<a href="javascript:void(0);" onclick="postinfo('<?php echo BLOG_URL; ?>admin/comment.php?action=doreply&cid=<?php echo $value['cid']; ?>&flg=1','reply<?php echo $value['cid']; ?>','replycomm<?php echo $value['cid']; ?>');">提交</a>
		<a href="javascript:void(0);" onclick="showhidediv('replybox<?php echo $value['cid']; ?>')">取消</a>
		</div>
	<?php endif; ?>	
	</li>
<?php endforeach; ?>
</div>
<?php if($allow_remark == 'y'): ?>
<p><b>发表评论:</b><a name="comment"></a></p>
<form  method="post"  name="commentform" action="<?php echo BLOG_URL; ?>index.php?action=addcom">
<table width="620" border="0" cellspacing="5" cellpadding="0">
<tr>
<td class="f14">姓　 名：</td>
<td>
<input type="hidden" name="gid" value="<?php echo $logid; ?>" />
<input type="text" name="comname" style="width:200px" maxlength="49" value="<?php echo $ckname; ?>"></td>
</tr>
<tr>
<td class="f14">电子邮件:</td>
<td><input type="text" name="commail" style="width:300px" maxlength="128"  value="<?php echo $ckmail; ?>"> (选填)</td>
</tr>
<tr>
<td class="f14">个人主页:</td>
<td><input type="text" name="comurl" style="width:300px" maxlength="128"  value="<?php echo $ckurl; ?>"> (选填)</td>
</tr>
<tr>
<td valign="top" class="f14">内　 容：</td>
<td><textarea name="comment" style="width:520px;height:155px"></textarea>
</td>
</tr>

<tr>
<td valign="top"class="f14">&nbsp;</td>
<td valign="top" class="f14">
<?php echo $cheackimg; ?><input name="Submit" type="submit" value="发表评论" onclick="return checkform()" />
</td>
</tr>
</table>
</form>
<?php endif; ?>
</div>
<?php include getViews('footer'); ?>