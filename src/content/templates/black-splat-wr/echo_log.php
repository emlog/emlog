<?php
if(!defined('EMLOG_ROOT')) {exit('error!');}
?>
<div class="post">
<h2 class="postTitle"><?php echo $log_title; ?></h2>
<p class="postMeta">filed in <?php if($log_cache_sort[$logid]): ?>
<span class="sort">[<a href="<?php echo BLOG_URL; ?>?sort=<?php echo $sortid; ?>"><?php echo $log_cache_sort[$logid]; ?></a>]</span>
<?php endif;?> on <?php echo date('Y-n-j G:i l', $date); ?></p>
<div class="postContent"><?php echo $log_content; ?>
</div>
<p class="tags"><?php 
	$attachment = !empty($log_cache_atts[$logid]) ? '<b>文件附件</b>:'.$log_cache_atts[$logid] : '';
	echo $attachment;
	?></p>
<p class="tags">	<?php 
	$tag = !empty($log_cache_tags[$logid]) ? '标签:'.$log_cache_tags[$logid] : '';
	echo $tag;
	?></p>
</div> <!-- Closes Post -->

	<div id="trackback">
    <?php if($allow_tb == 'y'):?>	
<div id="tb_list">
<p><b>引用地址：</b> <input type="text" style="width:350px" class="input" value="<?php echo BLOG_URL; ?>tb.php?sc=<?php echo $tbscode; ?>&amp;id=<?php echo $logid; ?>"><a name="tb"></a></p>
</div>
<?php endif; ?>

<?php 
foreach($tb as $key=>$value):
?>
<ul class="trackback">
	<li><a href="<?php echo $value['url'];?>" target="_blank"><?php echo $value['title'];?></a> </li>
	<li>BLOG: <?php echo $value['blog_name'];?></li>
	<li><?php echo $value['date'];?></li>
</ul>
<?php endforeach; ?>
</div>

<div class="comment">

<!-- You can start editing here. -->

<?php if($comments): ?>
<div id="comments">comments</div>
<?php endif; ?> 
	<ol class="commentlist">
<?php
foreach($comments as $key=>$value):
$reply = $value['reply']?"<span><b>博主回复</b>：{$value['reply']}</span>":'';
?>	
		<li class="alt" id="comment-1">
			<div id="commentbody">
			<cite><a name="<?php echo $value['cid']; ?>"></a>
	<b><?php echo $value['poster']; ?> </b></cite> 
						<br />

			<small class="commentmetadata"><?php if($value['mail']):?>
		<a href="mailto:<?php echo $value['mail']; ?>" title="发邮件给<?php echo $value['poster']; ?>">Email</a>
	<?php endif;?>
	<?php if($value['url']):?>
		<a href="<?php echo $value['url']; ?>" title="访问<?php echo $value['poster']; ?>的主页" target="_blank">主页</a>
	<?php endif;?>
		<?php echo $value['date']; ?></small>

			<p>		<?php echo $value['content']; ?>
		<div id="replycomm<?php echo $value['cid']; ?>"><?php echo $reply; ?></div>
	<?php if(ISLOGIN === true): ?>
		<a href="javascript:void(0);" onclick="showhidediv('replybox<?php echo $value['cid']; ?>','reply<?php echo $value['cid']; ?>')">回复</a>
		<div id='replybox<?php echo $value['cid']; ?>' style="display:none;">
		<textarea name="reply<?php echo $value['cid']; ?>" class="input" id="reply<?php echo $value['cid']; ?>" style="overflow-y: hidden;width:360px;height:50px;"><?php echo $value['reply']; ?></textarea>
		<br />
		<a href="javascript:void(0);" onclick="postinfo('<?php echo BLOG_URL; ?>admin/comment.php?action=doreply&cid=<?php echo $value['cid']; ?>&flg=1','reply<?php echo $value['cid']; ?>','replycomm<?php echo $value['cid']; ?>');">提交</a>
		<a href="javascript:void(0);" onclick="showhidediv('replybox<?php echo $value['cid']; ?>')">取消</a>
		</div>
	<?php endif; ?></p>
	</div>
		</li>
		<div class="cleared"></div>
<?php endforeach; ?>	
	
	</ol>
  
  <?php if($allow_remark == 'y'): ?>    
<h3 id="respond">Leave a Reply</h3>


<form method="post"  name="commentform" action="<?php echo BLOG_URL; ?>?action=addcom" id="commentform">


<p>

<input type="hidden" name="gid" value="<?php echo $logid; ?>"  size="22" tabindex="1"/>
<input type="text" name="comname" maxlength="49" value="<?php echo $ckname; ?>"  size="22" tabindex="1">
<label for="author"><small>Name (required)</small></label></p>

<p>
<input type="text" name="commail"  maxlength="128"  value="<?php echo $ckmail; ?>" size="22" tabindex="2"> 

<label for="email"><small>Mail</small></label></p>

<p><input type="text" name="comurl" maxlength="128"  value="<?php echo $ckurl; ?>" size="22" tabindex="3">
<label for="url"><small>Website</small></label></p>

<p>
<textarea name="comment" id="comment" cols="100%" rows="10" tabindex="4"></textarea>
</p>

<p>
<?php echo $cheackimg; ?><input name="Submit" type="submit" id="submit" tabindex="5" value="" onclick="return checkform()" />
</p>

</form>
<?php endif; ?>


</div>
</div></div> <!-- Closes Content -->


<div class="sidebars">
<?php
include getViews('side');
 include getViews('footer'); ?>