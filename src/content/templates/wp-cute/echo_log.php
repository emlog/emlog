<?php if(!defined('EMLOG_ROOT')) {exit('error!');} ?>
<div class=post id=post-1>
<h2>
<b><?php echo $log_title;?></b>
<?php if($log_cache_sort[$logid]): ?>
<span class="sort">[<a href="<?php echo BLOG_URL; ?>?sort=<?php echo $sortid; ?>"><?php echo $log_cache_sort[$logid]; ?></a>]</span>
<?php endif;?>
</h2>
<div class=entry>
<p><?php echo $log_content;?></p>
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
<p>
<?php if($prevLog):?>
	&laquo; <a href="<?php echo BLOG_URL; ?>?post=<?php echo $prevLog['gid']; ?>"><?php echo $prevLog['title'];?></a>
<?php endif;?>
<?php if($nextLog && $prevLog):?>
	|
<?php endif;?>
<?php if($nextLog):?>
	<a href="<?php echo BLOG_URL; ?>?post=<?php echo $nextLog['gid']; ?>"><?php echo $nextLog['title'];?></a>&raquo;
<?php endif;?>
</p>
</div></div>
<p><?php echo date('Y-n-j G:i l', $date); ?> <?php echo $log_author;?></p>
<?php if($allow_tb == 'y'): ?>
<h5>引用地址:<a name="tb"></a></h5>
<input type="text" id="input" style="width:350px" value="<?php echo BLOG_URL;?>tb.php?sc=<?php echo $tbscode;?>&amp;id=<?php echo $logid;?>" /><a name="tb"></a>
<?php endif; ?>
<?php foreach($tb as $key=>$value): ?>
<ul class="trackback">
	<li>来自: <a href="<?php echo $value['url'];?>" target="_blank"><?php echo $value['blog_name'];?></a></li>
    <li>标题: <a href="<?php echo $value['url'];?>" target="_blank"><?php echo $value['title'];?></a> </li>
    <li>摘要: <?php echo $value['excerpt'];?></li>
	<li>引用时间: <?php echo $value['date'];?></li>
</ul>
<?php endforeach; ?>
<h5>评论<a name="comment" id="comment"></a></h5>
<?php
foreach($comments as $key=>$value):
$reply = $value['reply']?"<span style=\"color:green;\"><b>博主回复</b>：{$value['reply']}</span>":'';
?>
<p><a name="<?php echo $value['cid'];?>"></a></p>
<div class="commentlist">
<cite><?php echo $value['poster'];?></cite> 
<?php if($value['mail']):?>
	<a href="mailto:<?php echo $value['mail']; ?>" title="发邮件给<?php echo $value['poster']; ?>">Email</a>
<?php endif;?>
<?php if($value['url']):?>
	<a href="<?php echo $value['url']; ?>" title="访问<?php echo $value['poster']; ?>的主页" target="_blank">主页</a>
<?php endif;?>
Says:<br />
<small class="commentmetadata"><?php echo $value['date'];?></small>
<p><?php echo $value['content'];?></p>
<p><div id="replycomm<?php echo $value['cid']; ?>"><?php echo $reply;?></div></p>
	<?php if(ISLOGIN === true): ?>	
		<a href="javascript:void(0);" onclick="showhidediv('replybox<?php echo $value['cid']; ?>','reply<?php echo $value['cid']; ?>')">回复</a>
		<div id='replybox<?php echo $value['cid']; ?>' style="display:none;">
		<textarea name="reply<?php echo $value['cid']; ?>" class="input" id="reply<?php echo $value['cid']; ?>" style="overflow-y: hidden;width:360px;height:50px;"><?php echo $value['reply']; ?></textarea>
		<br />
		<a href="javascript:void(0);" onclick="postinfo('<?php echo BLOG_URL; ?>admin/comment.php?action=doreply&cid=<?php echo $value['cid']; ?>&flg=1','reply<?php echo $value['cid']; ?>','replycomm<?php echo $value['cid']; ?>');">提交</a>
		<a href="javascript:void(0);" onclick="showhidediv('replybox<?php echo $value['cid']; ?>')">取消</a>
		</div>
	<?php endif; ?>
</div>
<?php endforeach; ?>
<?php if($allow_remark == 'y'): ?>
<h3 id=respond>参与评论</h3>
<form  method="post"  name="commentform" action="<?php echo BLOG_URL; ?>?action=addcom" onsubmit="return checkcomment(this)">
    <p>
        <input type="hidden" name="gid" value="<?php echo $logid;?>" />
      <br />
      <input name="comname"  type="text" value="<?php echo $ckname;?>" />
      <font color="red">姓名</font><br />
      <br />
	<input name="commail" type="text" size="45" value="<?php echo $ckmail;?>" maxlength="100" />
  电子邮件地址<br />      <br />
  <input name="comurl" type="text" size="45" value="<?php echo $ckurl;?>" maxlength="100" />
  个人主页<br />
  <br />
          <textarea name="comment" cols="45" rows="10" ></textarea>
  </p>
    <p><br />
          <?php echo $cheackimg;?>
          <input name="Submit" type="submit" value="提交我的评论" onclick="return checkform()" />
    </p>
</form>
<?php endif; ?>
<?php include getViews('footer'); ?>