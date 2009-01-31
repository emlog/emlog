<?php
if(!defined('EMLOG_ROOT')) {exit('error!');}
?>
 <div id="main"><div id="main-block">
 <div id="content">
    	            <ul>
            	    <li class="post" id="post-1">
                		<div class="content">
                            <div class="title">
                        	    <h2><?php echo $log_title; ?></h2>
                            </div>
							<div class="postdata">
                               <?php if($log_cache_sort[$logid]): ?>
<span class="category">[<a href="./?sort=<?php echo $sortid; ?>"><?php echo $log_cache_sort[$logid]; ?></a>]</span>
<?php endif;?>
                                <span class="date"><?php echo $post_time; ?></span>
                            </div><!--.postdata-->
							
                    		<div class="entry">
                    		    <p><div class="log_desc"> <?php echo $log_content; ?></div>
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
</p></p>
                    		</div>
               		  </div>
                		<div class="footer"></div>
<div class="nextlog">
<?php if($prevLog):?>
	&laquo; <a href="./?action=showlog&gid=<?php echo $prevLog['gid']; ?>"><?php echo $prevLog['title'];?></a>
<?php endif;?>
<?php if($nextLog && $prevLog):?>
	|
<?php endif;?>
<?php if($nextLog):?>
	 <a href="./?action=showlog&gid=<?php echo $nextLog['gid']; ?>"><?php echo $nextLog['title'];?></a>&raquo;
<?php endif;?>
</div>
                	
					

				
					
					</li>
            	            	<li class="post">
            		<div class="content">
            			
<!-- You can start editing here. -->

    <h3>评论(<?php echo $comnum; ?>)</h3>

    <ul class="comments-list">
<?php
foreach($comments as $key=>$value):
$reply = $value['reply']?"<span><b>博主回复</b>：{$value['reply']}</span>":'';
?>
                <li class="<?=$oddcomment;?>">
            <a name="<?php echo $value['cid']; ?>"></a>
	<b><?php echo $value['poster']; ?> </b> Says:<br />
           
            <div class="comment"><p>	<?php echo $value['content']; ?>
		<div id="replycomm<?php echo $value['cid']; ?>"><?php echo $reply; ?></div>
	<?php if(ISLOGIN === true): ?>
		<a href="javascript:void(0);" onclick="showhidediv('replybox<?php echo $value['cid']; ?>','reply<?php echo $value['cid']; ?>')">回复</a>
		<div id='replybox<?php echo $value['cid']; ?>' style="display:none;">
		<textarea name="reply<?php echo $value['cid']; ?>" class="input" id="reply<?php echo $value['cid']; ?>" style="overflow-y: hidden;width:360px;height:50px;"><?php echo $value['reply']; ?></textarea>
		<br />
		<a href="javascript:void(0);" onclick="postinfo('./admin/comment.php?action=doreply&cid=<?php echo $value['cid']; ?>&flg=1','reply<?php echo $value['cid']; ?>','replycomm<?php echo $value['cid']; ?>');">提交</a>
		<a href="javascript:void(0);" onclick="showhidediv('replybox<?php echo $value['cid']; ?>')">取消</a>
		</div>
	<?php endif; ?></p>
	 <small class="commentmetadata">
			<?php if($value['mail']):?>
		<a href="mailto:<?php echo $value['mail']; ?>" title="发邮件给<?php echo $value['poster']; ?>">Email</a>
	<?php endif;?>
	<?php if($value['url']):?>
		<a href="<?php echo $value['url']; ?>" title="访问<?php echo $value['poster']; ?>的主页" target="_blank">主页</a>
	<?php endif;?>
		<?php echo $value['date']; ?>
			</small>
</div>
        </li>
<?php endforeach; ?>
        
        
    </ul>

 

<?php if($allow_remark == 'y'): ?>
<a name="respond"></a><h3 id="leavecomment">Leave a Comment</h3>
<form  method="post"  name="commentform" action="index.php?action=addcom">
<table  border="0" cellspacing="8" cellpadding="0">
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
<td><textarea name="comment" style="width:420px;height:155px"></textarea>
</td>
</tr>

<tr>
<td valign="top"class="f14">&nbsp;</td>
<td valign="top" class="f14">
<?php echo $cheackimg; ?><input name="Submit" type="submit" value="发表评论" onclick="return checkform()" />
</td>
</tr>
</table>
</form>
<?php endif;?>

            		</div>
            		<div class="footer"></div>
            	</li>
				
				
				<?php if($allow_tb == 'y'):?>	
<li class="post">
<div class="content">
<div id="tb_list">
<p><b>引用地址：</b> <input type="text" style="width:350px" class="input" value="<?php echo $blogurl; ?>tb.php?sc=<?php echo $tbscode; ?>&amp;id=<?php echo $logid; ?>"><a name="tb"></a></p>
<p><?php 
foreach($tb as $key=>$value):
?>
	<span style="font-size:13px; font-weight:800;"><a href="<?php echo $value['url'];?>" target="_blank"><?php echo $value['title'];?></a></span><br />
	BLOG: <span style="color:#999999;"><?php echo $value['blog_name'];?></span><br />
	<span style="color:#999999;"><?php echo $value['date'];?></span>
<?php endforeach; ?></p>
</div>
</div>
<div class="footer"></div>
</li>

<?php endif; ?>
             </ul>
            </div><!--#content-->
			</div><!--#main-block-->

<?php
	include getViews('side'); 
include getViews('footer'); ?>