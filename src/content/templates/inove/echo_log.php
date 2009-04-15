<?php
if(!defined('EMLOG_ROOT')) {exit('error!');}
?>
<div class="post" id="post-1">
		<h2><?php echo $log_title; ?></h2>
		<div class="info">
			<span class="date"><?php echo date('Y-n-j G:i l', $date); ?></span>
			<div class="act">
									<span class="comments"><a href="#comments">评论</a></span>
					<span class="addcomment"><a href="#respond">发表评论</a></span>
												<div class="fixed"></div>
			</div>
			<div class="fixed"></div>
		</div>
		<div class="content">
			<?php echo $log_content; ?>
<p>
	<?php 
	$attachment = !empty($log_cache_atts[$logid]) ? '<b>文件附件</b>:'.$log_cache_atts[$logid] : '';
	echo $attachment;
	?>
</p>
			<p class="under">				<span class="categories"><?php if($log_cache_sort[$logid]): ?>
[<a href="./?sort=<?php echo $sortid; ?>"><?php echo $log_cache_sort[$logid]; ?></a>]
<?php endif;?></span>				<span class="tags"><?php 
	$tag = !empty($log_cache_tags[$logid]) ? '标签:'.$log_cache_tags[$logid] : '';
	echo $tag;
	?></span>			</p>
		</div>
	</div>


<div id="comments">

<div id="cmtswitcher">
<?php if($prevLog):?>
	&laquo; <a href="./?action=showlog&gid=<?php echo $prevLog['gid']; ?>"><?php echo $prevLog['title'];?></a>
<?php endif;?>
<?php if($nextLog && $prevLog):?>
	|
<?php endif;?>
<?php if($nextLog):?>
	 <a href="./?action=showlog&gid=<?php echo $nextLog['gid']; ?>"><?php echo $nextLog['title'];?></a>&raquo;
<?php endif;?>
		<div class="fixed"></div>
		<?php if($allow_tb == 'y'):?>	
<div id="tb_list">
<p><b>引用地址：</b>
<input class="textfield" type="text" style="width:350px" class="input" value="<?php echo $blogurl; ?>tb.php?sc=<?php echo $tbscode; ?>&amp;id=<?php echo $logid; ?>"><a name="tb"></a></p>
</div>
<?php endif; ?>
<?php 
foreach($tb as $key=>$value):
?>
<ul>
	<li><a href="<?php echo $value['url'];?>" target="_blank"><?php echo $value['title'];?></a> </li>
	<li>BLOG: <?php echo $value['blog_name'];?></li>
	<li><?php echo $value['date'];?></li>
</ul>
<?php endforeach; ?>
</div>

<div id="commentlist">
<?php
foreach($comments as $key=>$value):
$reply = $value['reply']?"<span><b>博主回复</b>：{$value['reply']}</span>":'';
?>
	<!-- comments START -->
	<ol id="thecomments">
		<li class="comment regularcomment" id="comment-1">
		<div class="author">
			<div class="name">
			<a name="<?php echo $value['cid']; ?>"></a>
	<b><?php echo $value['poster']; ?> </b>
	<div style="font-size:12px; font-weight:300;">
	<?php if($value['mail']):?>
		<a href="mailto:<?php echo $value['mail']; ?>" title="发邮件给<?php echo $value['poster']; ?>">Email</a>
	<?php endif;?><br />
	<?php if($value['url']):?>
		<a href="<?php echo $value['url']; ?>" title="访问<?php echo $value['poster']; ?>的主页" target="_blank">主页</a>
	<?php endif;?>
		
	</div>
							</div>
		</div>

		<div class="info">
			<div class="date">
			<?php echo $value['date']; ?>
			</div>
			<div class="act">
			
				<?php if(ISLOGIN === true): ?>
		<a href="javascript:void(0);" onclick="showhidediv('replybox<?php echo $value['cid']; ?>','reply<?php echo $value['cid']; ?>')">回复</a>
		<div id='replybox<?php echo $value['cid']; ?>' style="display:none;">
		<textarea name="reply<?php echo $value['cid']; ?>" class="input" id="reply<?php echo $value['cid']; ?>" style="overflow-y: hidden;width:360px;height:50px;"><?php echo $value['reply']; ?></textarea>
		<br />
		<a href="javascript:void(0);" onclick="postinfo('./admin/comment.php?action=doreply&cid=<?php echo $value['cid']; ?>&flg=1','reply<?php echo $value['cid']; ?>','replycomm<?php echo $value['cid']; ?>');">提交</a>
		<a href="javascript:void(0);" onclick="showhidediv('replybox<?php echo $value['cid']; ?>')">取消</a>
		</div>
	<?php endif; ?>
							</div>
			<div class="fixed"></div>
			<div class="content">
				
				<div id="commentbody-1">
					<?php echo $value['content']; ?>
		<div id="replycomm<?php echo $value['cid']; ?>"><?php echo $reply; ?></div>
	
				</div>
			</div>
		</div>
		<div class="fixed"></div>
	</li>
</li>
	</ol>
	<?php endforeach; ?>
	<!-- comments END -->
</div>

<?php if($allow_remark == 'y'): ?>
<p style="margin:10px 0px 3px;"><b>评论:</b></p>
<form  method="post"  name="commentform" action="index.php?action=addcom">
	<div id="respond">

					
			<div id="author_info">
				<div class="row">
					<input type="hidden" name="gid" value="<?php echo $logid; ?>" />
					<input type="text" name="comname" id="author" class="textfield" value="<?php echo $ckname; ?>" size="24" tabindex="1" />
					<label for="author" class="small">昵称 (必填)</label>
				</div>
				<div class="row">
					<input type="text" name="commail" id="email" class="textfield" value="<?php echo $ckmail; ?>" size="24" tabindex="2" />
					<label for="email" class="small">电子邮箱 (我们会为您保密)</label>
				</div>
				<div class="row">
					<input type="text" name="comurl" id="url" class="textfield" value="<?php echo $ckurl; ?>" size="24" tabindex="3" />
					<label for="url" class="small">网址</label>
				</div>
			</div>

			
		
		<!-- comment input -->
		<div class="row">
			<textarea name="comment"  id="comment" tabindex="4" rows="8" cols="50"></textarea>
		</div>

		<!-- comment submit and rss -->
		<div id="submitbox">
			<div class="submitbutton">
				<?php echo $cheackimg; ?><input name="Submit" id="submit" class="button" type="submit" value="发表评论" onclick="return checkform()" />
			</div>
						<input type="hidden" name="comment_post_ID" value="1" />
			<div class="fixed"></div>
		</div>

	</div>
	</form>
<?php endif; ?>
</div>
<?php 
include getViews('side');
include getViews('footer');
 ?>