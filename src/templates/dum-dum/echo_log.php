<?php
if(!defined('EMLOG_ROOT')) {exit('error!');}
include getViews('side');
//$att_img = getAttachment($att_img,600,500);
?>
<div class="content">
<img src="<?php echo $tpl_dir; ?>dum-dum/images/img_08.jpg" alt="" />
	<div class="contenttext">
		<div class="post" id="post-<?php echo $value['logid']; ?>">
			<div class="postheader">
				<div class="postdate">
					<div class="postday">2</div> <!-- POST DAY -->
					<div class="postmonth">3</div> <!-- POST MONTH -->
				</div> <!-- POST DATE -->
				
				<div class="posttitle">
					<h3><?php echo $log_title; ?></h3>
				</div> <!-- POST TITLE -->

				<div class="postmeta">
					<div class="postauthor">by wwwwwwwwww</div> <!-- POST AUTHOR -->
					<div class="postcategory"><?php echo $tag; ?></div> <!-- POST CATEGORY -->
				</div> <!-- POST META -->
			</div> <!-- POST HEADER -->
			<div style=" clear:both;"></div>
			<div class="posttext">
			<?php echo $log_content; ?>
			<p><?php echo $att_img; ?></p>
			<p><?php echo $attachment; ?></p>	
			<p><?php echo $tag; ?></p>
			</div> <!-- POST TEXT -->
		</div> <!-- POST -->
		<div class="navigation">
		<?php if($previousLog):?>
		<div class="alignleft"><a href="./?action=showlog&gid=<?php echo $previousLog['gid']; ?>">&laquo; <?php echo $previousLog['title'];?></a></div>
		<?php endif;?>
		<?php if($nextLog):?>
			 <div class="alignright"><a href="./?action=showlog&gid=<?php echo $nextLog['gid']; ?>"><?php echo $nextLog['title'];?>&raquo;</a></div>
		<?php endif;?>
		</div>
		<div style="clear: both; height: 20px;"></div>
		<ol class="commentlist">
		<?php
		foreach($com as $key=>$value):
		$reply = $value['reply']?"<span><b>博主回复</b>：{$value['reply']}</span>":'';
		?>
		<li class="alt" id="comment-1">
		<div class="cite2"><cite>
		<span class="author"><?php echo $value['poster']; ?>
		<?php if($value['mail']):?>
		<a href="mailto:<?php echo $value['mail']; ?>" title="发邮件给<?php echo $value['poster']; ?>">Email</a>
		<?php endif;?>
		<?php if($value['url']):?>
			<a href="<?php echo $value['url']; ?>" title="访问<?php echo $value['poster']; ?>的主页" target="_blank">主页</a>
		<?php endif;?>
		</span><span class="time"><?php echo $value['addtime']; ?></span></cite>
		<div style="clear: both;"></div>
		</div>
		<div class="commenttext"><div class="commenttext2">
		<p><?php echo $value['content']; ?></p>
		<div id="replycomm<?php echo $value['cid']; ?>"><?php echo $reply; ?></div>
		<?php if(ISLOGIN === true): ?>	
			<a href="javascript:void(0);" onclick="showhidediv('replybox<?php echo $value['cid']; ?>','reply<?php echo $value['cid']; ?>')">回复</a>
			<div id='replybox<?php echo $value['cid']; ?>' style="display:none;">
			<textarea name="reply<?php echo $value['cid']; ?>" class="input" id="reply<?php echo $value['cid']; ?>" style="overflow-y: hidden;width:360px;height:50px;"><?php echo $value['reply']; ?></textarea>
			<br />
			<a href="javascript:void(0);" onclick="postinfo('./adm/comment.php?action=doreply&cid=<?php echo $value['cid']; ?>&flg=1','reply<?php echo $value['cid']; ?>','replycomm<?php echo $value['cid']; ?>');">提交</a>
			<a href="javascript:void(0);" onclick="showhidediv('replybox<?php echo $value['cid']; ?>')">取消</a>
			</div>
		<?php endif; ?>
		</div></div>
		</li>
		<?php endforeach; ?>
		</ol>

		<div class="comm">
		<form method="post"  name="commentform" action="index.php?action=addcom" id="commentform">
		<p><input type="text" name="author" id="author" value="ddddddddddd" size="22" tabindex="1" />
		<label for="author"><small>Name (required)</small></label></p>
		
		<p><input type="text" name="email" id="email" value="dddddddd@fa.com" size="22" tabindex="2" />
		<label for="email"><small>Mail (will not be displayed) (required)</small></label></p>
		
		<p><input type="text" name="url" id="url" value="" size="22" tabindex="3" />
		<label for="url"><small>Website</small></label></p>
		<p><textarea name="comment" id="comment" cols="54" rows="10" tabindex="4"></textarea></p>
		
		<p><input name="submit" type="submit" id="submit" tabindex="5" src="http://localhost/wordpress/wp-content/themes/dum-dum/img/comm/trimite.jpg" value="Send Comment" />
		<input type="hidden" name="comment_post_ID" value="1" />
		</p>
		
		</form>
		
		</div>
		</div> <!-- CONTENT TEXT -->
		<img src="<?php echo $tpl_dir; ?>dum-dum/images/img_09.jpg" style="vertical-align: bottom;" alt="" />
		</div> <!-- CONTENT -->

<?php include getViews('footer'); ?>