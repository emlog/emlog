<?php
if(!defined('EMLOG_ROOT')) {exit('error!');}
?>
			<div class="content span-24">
				<div class="posts span-18 last">

					<div class="paddings">
						<ul class="items">
																					<li>
<h2><?php echo $log_title; ?></h2>
								<div class="info">	<span class="cat"><?php if($log_cache_sort[$logid]): ?>
<span class="sort">[<a href="<?php echo BLOG_URL; ?>?sort=<?php echo $sortid; ?>"><?php echo $log_cache_sort[$logid]; ?></a>]</span><?php endif;?></span>
</div>

								<div class="paddings-p"><?php echo $log_content; ?></div>
								                                <p>
	<?php 
	$attachment = !empty($log_cache_atts[$logid]) ? '<b>文件附件</b>:'.$log_cache_atts[$logid] : '';
	echo $attachment;
	?>
</p>
								<div class="clear"></div>

								
								<div class="info">
								<span class="tag "><?php 
	$tag = !empty($log_cache_tags[$logid]) ? '标签:'.$log_cache_tags[$logid] : '';echo $tag;?></span><br />
	<span class="date"><?php echo date('Y-n-j G:i l', $date); ?></span>	
																											
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
<?php if($allow_tb == 'y'):?>	
<div id="trackback1">
<b>引用地址：</b> <input type="text" style="width:350px" class="input" value="<?php echo BLOG_URL; ?>tb.php?sc=<?php echo $tbscode; ?>&amp;id=<?php echo $logid; ?>"><a name="tb"></a>
</div>
<?php endif; ?>                       
<?php 
foreach($tb as $key=>$value):
?>
	<li style="font-size:12px; margin:0px;border-bottom:#CCCCCC solid 1px; background-color:#f5f5f5;"><a href="<?php echo $value['url'];?>" target="_blank"><?php echo $value['title'];?></a> </li>
	<li style="font-size:12px; margin:0px;">BLOG: <?php echo $value['blog_name'];?></li>
	<li style="font-size:12px; margin:0px;"><?php echo $value['date'];?></li>
<?php endforeach; ?>																<div class="com">


<!-- You can start editing here. -->
	<div class="clr">&nbsp;</div>
<?php if($comments):?>
	<h3 id="comments" class="block"><b>评论:</b><a name="comment"></a></h3>
<?php endif; ?>
	<ol class="list-4">
    
<?php
foreach($comments as $key=>$value):
$reply = $value['reply']?"<span><b>博主回复</b>：{$value['reply']}</span>":'';
?>
	
		<li class="alt" id="comment-1">
        	<div class="com-header">
            
                    <span>	<a name="<?php echo $value['cid']; ?>"></a><b><?php echo $value['poster']; ?> </b></span> 	<br />                            
                    <small class="commentmetadata">
                    	<?php echo $value['date']; ?>
                    	<?php if($value['mail']):?>
		<a href="mailto:<?php echo $value['mail']; ?>" title="发邮件给<?php echo $value['poster']; ?>">Email</a>
	<?php endif;?>
	<?php if($value['url']):?>
		<a href="<?php echo $value['url']; ?>" title="访问<?php echo $value['poster']; ?>的主页" target="_blank">主页</a>
	<?php endif;?>                    </small>
            </div>	
			<?php echo $value['content']; ?>
		<div id="replycomm<?php echo $value['cid']; ?>"><?php echo $reply; ?></div>
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

	
	
	</ol>

 </div>

<div class="reply">


  <?php if($allow_remark == 'y'): ?>    
<h3 id="respond">我要评论</h3>


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
<?php echo $cheackimg; ?><input name="Submit" type="submit" value="发表评论" onclick="return checkform()" />
</p>

</form>
<?php endif; ?>




</div>							</li>
																					<li>
								<div class="navigation">
									<div class="fl"></div>
			                        <div class="fr"></div>
			                    	<div class="clear"></div>
		                        </div>
		                    </li>
						</ul>
					</div>
				</div>

							<div class="sidebar span-7 last">
				<div class="paddings">

<?php
include getViews('side');
include getViews('footer'); ?>