<?php
if(!defined('EMLOG_ROOT')) {exit('error!');}
?>
<div id="blog">
	<table cellpadding="0" cellspacing="2" width="100%">
		<tr>
			<td valign="top" id="blog_left">
				<div class="item_class">
					
				<table cellpadding="0" cellspacing="0" width="540">
							<tr>
								<td valign="top" class="item_date">
									<div class="date_month"><?php echo date('n月', $date); ?></div>
									<div class="date_day"><?php echo date('j', $date); ?></div>
								</td>
								<td width="10"></td>
								<td valign="top" class="item_titles">
									<div class="item_title1">
										<b><?php echo $log_title; ?></b>
									</div>
									<div class="item_title2">
									<?php if($log_cache_sort[$logid]): ?>
									Filed Under <i><span class="sort">[<a href="./?sort=<?php echo $sortid; ?>"><?php echo $log_cache_sort[$logid]; ?></a>]</span>
<?php endif;?>
									
										 on <?php echo date('Y-n-j G:i l', $date); ?></i>
									</div>
									<div class="item_text">
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
									<div class="item_panel">
										<div class="panel_links">
<div class="nextlog">
<?php if($prevLog):?>
	&laquo; 上一篇 <a href="./?action=showlog&gid=<?php echo $prevLog['gid']; ?>"><?php echo $prevLog['title'];?></a>
<?php endif;?>
<?php if($nextLog && $prevLog):?>
	|
<?php endif;?>
<?php if($nextLog):?>
	 <a href="./?action=showlog&gid=<?php echo $nextLog['gid']; ?>"><?php echo $nextLog['title'];?></a> 下一篇 &raquo;
<?php endif;?>
</div>
										</div>
									</div>
								</td>
							</tr>
						</table>
				<br />
				<?php if($allow_tb == 'y'):?>	
<div id="trackback">
<p><b>引用地址：</b> <input type="text" style="width:350px" class="input" value="<?php echo $blogurl; ?>tb.php?sc=<?php echo $tbscode; ?>&amp;id=<?php echo $logid; ?>"><a name="tb"></a></p>
</div>
<?php endif; ?>

<?php 
foreach($tb as $key=>$value):
?>
<div class="trackback">
	<li><a href="<?php echo $value['url'];?>" target="_blank"><?php echo $value['title'];?></a> </li>
	<li>BLOG: <?php echo $value['blog_name'];?></li>
	<li><?php echo $value['date'];?></li>
</div>
<?php endforeach; ?>
				<br />

	
<!-- You can start editing here. -->

	<div class="blog_comm">
	<?php if($comments): ?>
	<div class="comm_title">
			Comments:<a name="comment"></a>
		</div>
<?php endif; ?>
		<?php
foreach($comments as $key=>$value):
$reply = $value['reply']?"<span><b>博主回复</b>：{$value['reply']}</span>":'';
?>
		<div class="comm_count">
			posted on <a name="<?php echo $value['cid']; ?>"></a>
	<b><?php echo $value['poster']; ?> </b>
		</div>
			
		<div class="comm_data">
			<div class="comm_data_pad">
				<?php if($value['mail']):?>
		<a href="mailto:<?php echo $value['mail']; ?>" title="发邮件给<?php echo $value['poster']; ?>">Email</a>
	<?php endif;?>
	<?php if($value['url']):?>
		<a href="<?php echo $value['url']; ?>" title="访问<?php echo $value['poster']; ?>的主页" target="_blank">主页</a>
	<?php endif;?>
		<?php echo $value['date']; ?>
			</div>
		</div>
		<div class="comm_text">
			<?php echo $value['content']; ?>
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
		<div class="bl_line"></div>
		<br />
<?php endforeach; ?>
	
			
	</div>

 

<?php if($allow_remark == 'y'): ?>
<div id="comm_form">

<div class="form_table">
	<div id="form_title">
		<div id="form_title_text">Post a comment</div>
	</div>
	<br />
<form  method="post"  name="commentform" action="index.php?action=addcom">
<table cellpadding="2" style="padding-left:15px;"> 
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
<td><textarea name="comment" style="width:360px;height:155px"></textarea>
</td>
</tr>

<tr>
<td valign="top"class="f14">&nbsp;</td>
<td valign="top" class="f14">
<?php echo $cheackimg; ?>
<input  name="Submit" type="image" src="<?php echo $em_tpldir; ?>images/sub.png" width="65" height="25" id="submit" tabindex="5" onclick="return checkform()" />
</td>
</tr>
</table>
</form>
								<div class="form_comm_end"></div>
							</div>
<?php endif; ?>
							</div>


		</div>
			</td>
			<td valign="top" id="blog_right">
				<div id="blog_right_top">
				</div>
				<div id="blog_right_pad">
						<div id="sidebar">
		<ul>
<?php
include getViews('side');
include getViews('footer'); ?>