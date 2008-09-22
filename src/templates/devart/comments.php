<?php
if(!defined('EMLOG_ROOT')) {exit('error!');}
?>
<!-- 引用 -->
<?php if($allow_tb == 'y'):?>	
<div>
<p><b>引用地址：</b> <input type="text" style="width:350px" class="text" value="<?php echo $blogurl; ?>tb.php?sc=<?php echo $tbscode; ?>&amp;id=<?php echo $logid; ?>"><a name="tb"></a></p>
</div>
<?php endif; ?>

<?php if (is_array($tb) && !empty($tb)): ?>
	<?php foreach($tb as $key=>$value):?>
    <div>
        <li>来自: <a href="<?php echo $value['url'];?>" target="_blank"><?php echo $value['blog_name'];?></a></li>
        <li>标题: <a href="<?php echo $value['url'];?>" target="_blank"><?php echo $value['title'];?></a> </li>
        <li>摘要:<?php echo $value['excerpt'];?></li>
        <li>引用时间:<?php echo $value['date'];?></li>
    </div>
    <?php endforeach; ?>
<?php endif;?>
<!-- 评论 -->
<?php if($com): ?>
	<h1 class="comments-title"><a name="comment"></a>评论</h1>
	<div id="comments">

		<?php 
			foreach($com as $key=>$value):
				$reply = $value['reply']?"<span><b>博主回复</b>：{$value['reply']}</span>":'';
		?>
			<div class="comment" id="comment-<?php echo $value['cid']; ?>">
			
				<div class="comment-content">
					<div class="comment-info">
                    	<span>
                        	<?php echo $value['poster']; ?>
							<?php if($value['mail']):?>
                                <a href="mailto:<?php echo $value['mail']; ?>" title="发邮件给<?php echo $value['poster']; ?>">Email</a>
                            <?php endif;?>
                            <?php if($value['url']):?>
                                <a href="<?php echo $value['url']; ?>" title="访问<?php echo $value['poster']; ?>的主页" target="_blank">主页</a>
                            <?php endif;?>
						</span>
							 <?php echo $value['addtime']; ?>
                    </div>
					
					<?php echo $value['content']; ?>
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
				</div>
			</div>
		<?php endforeach; ?>

	</div>
<?php endif; ?>

<?php if($allow_remark == 'y'): ?>
<h1 class="comments-title"></h1>
<form method="post"  name="commentform" action="index.php?action=addcom" id="commentform">
			Your comment
			<input type="hidden" name="gid" value="<?php echo $logid; ?>" />
			<p><textarea name="comment" id="comment"></textarea></p>
				<p><input type="text" name="comname" id="comname" class="text" value="" />
				<label for="author">Name</label></p>

				<p><input type="text" name="commail" id="commail" class="text" value="<?php echo $ckmail; ?>" />
				<label for="email">Mail (选填)</label></p>

				<p><input type="text" name="comurl" id="comurl" class="text" value="<?php echo $ckurl; ?>" />
				<label for="url">Website (选填)</label></p>
						
						
			<p>
			<?php echo $cheackimg; ?>
			<input name="submit" type="submit" id="submit" value="Submit Comment" /><input type="hidden" name="comment_post_ID" value="3" />
			<input type="checkbox" name="remember" value="1" checked="checked" />记住我
			</p>
			
			

		</form>
<?php endif; ?>