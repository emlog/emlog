<?php
if(!defined('EMLOG_ROOT')) {exit('error!');}
?>
<!-- 引用 -->
<?php if($allow_tb == 'y'):?>	
<div>
<p><b>引用地址：</b> <input type="text" style="width:350px" class="input" value="<?php echo $blogurl; ?>tb.php?sc=<?php echo $tbscode; ?>&amp;id=<?php echo $logid; ?>"><a name="tb"></a></p>
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
<h1 class="comments-title">我要评论</h1>

<form  method="post"  name="commentform" action="index.php?action=addcom">
	<p>姓&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;名：<input type="hidden" name="gid" value="<?php echo $logid; ?>" /><input type="text" name="comname" style="width:200px" maxlength="49" value="<?php echo $ckname; ?>"></p>
	<p>电子邮件：<input type="text" name="commail" style="width:300px" class="text" maxlength="128"  value="<?php echo $ckmail; ?>"> (选填)</p>
	<p>个人主页：<input type="text" name="comurl" style="width:300px" class="text" maxlength="128"  value="<?php echo $ckurl; ?>"> (选填)</p>
	<p>内&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;容：</p>
    <p><textarea name="comment" style="width:520px;height:155px"></textarea></p>
	<p><?php echo $cheackimg; ?><input name="Submit" type="submit" value="发表评论" onclick="return checkform()" />
	<input type="checkbox" name="remember" class="text" value="1" checked="checked" />记住我</p>
</form>
<?php endif; ?>