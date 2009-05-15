<?php
if(!defined('EMLOG_ROOT')) {exit('error!');}
?>
<div class="content">
<img src="<?php echo CERTEMPLATE_URL; ?>/images/img_08.jpg" alt="" />
	<div class="contenttext">
		<div class="post" id="post-<?php echo $value['logid']; ?>">
			<div class="postheader">
				<div class="postdate">
					<div class="postday"><?php echo date('Y', $date); ?></div>
					<div class="postmonth"><?php echo date('Y', $date); ?></div>
				</div> <!-- POST DATE -->
				
				<div class="posttitle">
					<h3><?php echo $log_title; ?></h3>
				</div> <!-- POST TITLE -->

				<div class="postmeta">
					<div class="postauthor">by <?php echo $name; ?></div> <!-- POST AUTHOR -->
					<div class="postcategory">
					<?php if($log_cache_sort[$logid]): ?>
					分类：<a href="<?php echo BLOG_URL; ?>?sort=<?php echo $sortid; ?>"><?php echo $log_cache_sort[$logid]; ?></a>
					<?php endif;?>
					<?php 
					$tag = !empty($log_cache_tags[$logid]) ? '标签:'.$log_cache_tags[$logid] : '';
					echo $tag;
					?>
					</div> <!-- POST CATEGORY -->
				</div> <!-- POST META -->
			</div> <!-- POST HEADER -->
			<div style=" clear:both;"></div>
			<div class="posttext">
			<?php echo $log_content; ?>
			<p>
				<?php 
				$attachment = !empty($log_cache_atts[$logid]) ? '<b>文件附件</b>:'.$log_cache_atts[$logid] : '';
				echo $attachment;
				?>
			</p>
			</div> <!-- POST TEXT -->
		</div> <!-- POST -->
		<div class="navigation">
		<?php if($prevLog):?>
		<div class="alignleft"><a href="<?php echo BLOG_URL; ?>?post=<?php echo $prevLog['gid']; ?>" title="<?php echo $prevLog['title'];?>">&laquo; 上一篇</a></div>
		<?php endif;?>
		<?php if($nextLog):?>
			 <div class="alignright"><a href="<?php echo BLOG_URL; ?>?post=<?php echo $nextLog['gid']; ?>" title="<?php echo $nextLog['title'];?>">下一篇&raquo;</a></div>
		<?php endif;?>
		</div>
		<div style="clear: both; height: 20px;"></div>
		
		<?php if($allow_tb == 'y'):?>
		<div class="cite2"><cite>
		<span class="author">引用地址：
		<input type="text" style="width:350px" class="input" value="<?php echo BLOG_URL; ?>tb.php?sc=<?php echo $tbscode; ?>&amp;id=<?php echo $logid; ?>">
		<a name="tb"></a></span>
		</cite></div>
		<?php endif; ?>

		<?php foreach($tb as $key=>$value):?>
		<ol class="commentlist">
				<li class="alt" id="comment-1">
		<cite>
		<span class="author"><a href="<?php echo $value['url'];?>" target="_blank"><?php echo $value['blog_name'];?></a></span>
		<span class="time">引用时间:<?php echo $value['date'];?></span><br />
		标题: <a href="<?php echo $value['url'];?>" target="_blank"><?php echo $value['title'];?></a><br />
		摘要:<?php echo $value['excerpt'];?>
		</cite>
		</ol>
		<?php endforeach; ?>

		<div style="clear: both; height: 20px;"></div>
		<ol class="commentlist">
		<?php
		foreach($comments as $key=>$value):
		$reply = $value['reply']?"<span><b>博主回复</b>：{$value['reply']}</span>":'';
		?>
		<a name="<?php echo $value['cid']; ?>"></a>
		<li class="alt" id="comment-1">
		<div class="cite2"><cite>
		<span class="author"><?php echo $value['poster']; ?>
		<?php if($value['mail']):?>
		<a href="mailto:<?php echo $value['mail']; ?>" title="发邮件给<?php echo $value['poster']; ?>">Email</a>
		<?php endif;?>
		<?php if($value['url']):?>
			<a href="<?php echo $value['url']; ?>" title="访问<?php echo $value['poster']; ?>的主页" target="_blank">主页</a>
		<?php endif;?>
		</span><span class="time"><?php echo $value['date']; ?></span>
		<?php if(ISLOGIN === true): ?>	
			<a href="javascript:void(0);" onclick="showhidediv('replybox<?php echo $value['cid']; ?>','reply<?php echo $value['cid']; ?>')">回复</a>
			<div id='replybox<?php echo $value['cid']; ?>' style="display:none;">
			<textarea name="reply<?php echo $value['cid']; ?>" class="input" id="reply<?php echo $value['cid']; ?>" style="overflow-y: hidden;width:360px;height:50px;"><?php echo $value['reply']; ?></textarea>
			<br />
			<a href="javascript:void(0);" onclick="postinfo('<?php echo BLOG_URL; ?>admin/comment.php?action=doreply&cid=<?php echo $value['cid']; ?>&flg=1','reply<?php echo $value['cid']; ?>','replycomm<?php echo $value['cid']; ?>');">提交</a>
			<a href="javascript:void(0);" onclick="showhidediv('replybox<?php echo $value['cid']; ?>')">取消</a>
			</div>
		<?php endif; ?>
		</cite>
		<div style="clear: both;"></div>
		</div>
		<div class="commenttext"><div class="commenttext2">
		<p><?php echo $value['content']; ?></p>
		<div id="replycomm<?php echo $value['cid']; ?>"><?php echo $reply; ?></div>
		</div></div>
		</li>
		<?php endforeach; ?>
		</ol>

		<div class="comm">
		<form method="post"  name="commentform" action="<?php echo BLOG_URL; ?>index.php?action=addcom" id="commentform">
		<p><input type="text" name="comname" id="author" value="<?php echo $ckname; ?>" size="22" tabindex="1" />
		<label for="author"><small>姓名</small></label></p>
		
		<p><input type="text" name="commail" id="email" value="<?php echo $ckmail; ?>" size="22" tabindex="2" />
		<label for="email"><small>电子邮件(选填)</small></label></p>
		
		<p><input type="text" name="comurl" id="url" value="<?php echo $ckurl; ?>" size="22" tabindex="3" />
		<label for="url"><small>主页</small></label></p>
		<p><textarea name="comment" id="comment" cols="54" rows="10" tabindex="4"></textarea></p>
		
		<p><?php echo $cheackimg; ?>
		<input name="submit" type="submit" id="submit" tabindex="5" src="http://localhost/wordpress/wp-content/themes/dum-dum/img/comm/trimite.jpg" value="发表评论" />
		<input type="hidden" name="gid" value="<?php echo $logid; ?>" />
		</p>
		</form>
		</div>
		</div> <!-- CONTENT TEXT -->
		<img src="<?php echo CERTEMPLATE_URL; ?>/images/img_09.jpg" style="vertical-align: bottom;" alt="" />
		</div> <!-- CONTENT -->
<?php 
include getViews('side');
include getViews('footer'); 
?>