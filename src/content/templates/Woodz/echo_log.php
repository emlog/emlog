<?php
if(!defined('EMLOG_ROOT')) {exit('error!');}
?>
	<div id="content" class="narrowcolumn">
			<div class="post" id="post-1">
                <div class="post-top">
                    <div class="post-title">
                    	<h2><?php echo $log_title; ?></h2>
						<h4><?php echo $comnum; ?></h4>
						 <h3>
						 <?php if($log_cache_sort[$logid]): ?>
						Post in <span class="sort"><a href="./?sort=<?php echo $sortid; ?>"><?php echo $log_cache_sort[$logid]; ?></a></span>
						<?php endif;?> | Post on <?php echo date('Y-n-j G:i l', $date); ?>                        
						</h3>
				</div>
                </div>

				<div class="entry clear">
					<p><?php echo $log_content; ?></p>
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
	&laquo; <a href="./?action=showlog&gid=<?php echo $prevLog['gid']; ?>"><?php echo $prevLog['title'];?></a>
<?php endif;?>
<?php if($nextLog && $prevLog):?>
	|
<?php endif;?>
<?php if($nextLog):?>
	 <a href="./?action=showlog&gid=<?php echo $nextLog['gid']; ?>"><?php echo $nextLog['title'];?></a>&raquo;
<?php endif;?>
</p>
</div>
<?php if($allow_tb == 'y'):?>	
<div id="tb_list">
<p><b>引用地址：</b> <input type="text" style="width:350px" class="input" value="<?php echo $blogurl; ?>tb.php?sc=<?php echo $tbscode; ?>&amp;id=<?php echo $logid; ?>"><a name="tb"></a></p>
</div>
<?php endif; ?>

<?php 
foreach($tb as $key=>$value):
?>
<div class="comment odd alt thread-odd thread-alt depth-1">
	<li><a href="<?php echo $value['url'];?>" target="_blank"><?php echo $value['title'];?></a> </li>
	<li>BLOG: <?php echo $value['blog_name'];?></li>
	<li><?php echo $value['date'];?></li>
</div>
<?php endforeach; ?>

			</div>

	
<!-- You can start editing here. -->
<?php if($comments): ?>
<h2 id="comments">Comments:<a name="comment"></a></h2>
<?php endif; ?>

<div class="commentlist">
<?php
foreach($comments as $key=>$value):
$reply = $value['reply']?"<span><b>博主回复</b>：{$value['reply']}</span>":'';
?>
		<div class="comment odd alt thread-odd thread-alt depth-1">
        <div class="commentmet_data">
        	<div class="commentmetadata"><a name="<?php echo $value['cid']; ?>"></a>
	<?php echo $value['poster']; ?> <span>says...</span></div>
			
			

			<div class="commentmetadata_text">		<?php echo $value['content']; ?>
		<div id="replycomm<?php echo $value['cid']; ?>"><?php echo $reply; ?></div>
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
        	<div class="commentmetadata_end">
		<?php if($value['mail']):?>
		<a href="mailto:<?php echo $value['mail']; ?>" title="发邮件给<?php echo $value['poster']; ?>">Email</a>
	<?php endif;?>
	<?php if($value['url']):?>
		<a href="<?php echo $value['url']; ?>" title="访问<?php echo $value['poster']; ?>的主页" target="_blank">主页</a>
	<?php endif;?><?php echo $value['date']; ?></div>

		</div>
		</div>
<?php endforeach; ?>			
		<div class="clear"></div>
	</div>

<div id="respond">
<h3 id="respond_title">Write a comment</h3>
<form method="post"  name="commentform" action="index.php?action=addcom" id="commentform">


<p>
<input type="hidden" name="gid" value="<?php echo $logid; ?>" />
<input type="text" name="comname" class="comm_input_text" id="author" value="<?php echo $ckname; ?>" size="22" tabindex="1" />
<label for="author">昵称</label></p>

<p>
<input type="text" name="commail" style="width:260px" maxlength="128"  value="<?php echo $ckmail; ?>" class="comm_input_text" id="email" size="22" tabindex="2">
<label for="email">邮箱 (选填)</label></p>

<p>
<input type="text" name="comurl" class="comm_input_text" style="width:260px" size="22" tabindex="3"  value="<?php echo $ckurl; ?>">
<label for="url">主页 (选填)</label></p>

<p>
<textarea name="comment" class="comm_textarea_text" id="comment" cols="40" rows="8" style="width:400px" tabindex="4"></textarea></p>

<p>
<?php echo $cheackimg; ?><input name="Submit" type="submit" value="发表评论" onclick="return checkform()" style="border:1px solid #CCCCCC; background:#333333; color:#FFFFFF;" />
</p>

</form>
</div>
	</div>    
<?php 
include getViews('side');
include getViews('footer'); 
?>