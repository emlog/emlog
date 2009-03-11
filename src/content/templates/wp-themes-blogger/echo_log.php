<?php
if(!defined('EMLOG_ROOT')) {exit('error!');}
?>
   <div class="postcontent">
            <div class="postcontent_in">

        <h2><?php echo $log_title; ?></h2>

<?php if($log_cache_sort[$logid]): ?>
<span class="sort">[<a href="./?sort=<?php echo $sortid; ?>"><?php echo $log_cache_sort[$logid]; ?></a>]</span>
<?php endif;?><?php echo $post_time; ?>
<div class="post">

	<div class="storycontent">
		<div class="excrept_post_p"><?php echo $log_content; ?></div>
        <p>
	<?php 
	$attachment = !empty($log_cache_atts[$logid]) ? '<b>文件附件</b>:'.$log_cache_atts[$logid] : '';
	echo $attachment;
	?>
</p>
    <div class="clear"></div>
	</div>

    <div class="meta">
       	<?php 
	$tag = !empty($log_cache_tags[$logid]) ? '标签:'.$log_cache_tags[$logid] : '';
	echo $tag;
	?>
            </div>

	<div class="feedback">
					</div>

</div>
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

<!-- You can start editing here. -->
<?php if($allow_tb == 'y'):?>	
<div id="trackback">
<p><b>引用地址：</b> <input type="text" style="width:350px" class="input" value="<?php echo $blogurl; ?>tb.php?sc=<?php echo $tbscode; ?>&amp;id=<?php echo $logid; ?>"><a name="tb"></a></p>
</div>
<?php endif; ?>

<?php 
foreach($tb as $key=>$value):
?>
<div class="trackbacklist">
	<li><a href="<?php echo $value['url'];?>" target="_blank"><?php echo $value['title'];?></a> </li>
	<li style="font-size:12px; color:#999999;">BLOG: <?php echo $value['blog_name'];?></li>
	<li style="font-size:10px;"><?php echo $value['date'];?></li>
</div>
<?php endforeach; ?>


		<h2>Comments</h2>
    	<ol class="commentlist">
        <?php
foreach($comments as $key=>$value):
$reply = $value['reply']?"<span><b>博主回复</b>：{$value['reply']}</span>":'';
?>
	        		<li class="comment even thread-even depth-1" id="comment-1">
				<div id="div-comment-1">
				<div class="comment-author vcard">
                
		 <span class="says">says:<a name="<?php echo $value['cid']; ?>"></a>
	<b><?php echo $value['poster']; ?> </b></span>		
	<?php if($value['mail']):?>
		<a href="mailto:<?php echo $value['mail']; ?>" title="发邮件给<?php echo $value['poster']; ?>">Email</a>
	<?php endif;?>
	<?php if($value['url']):?>
		<a href="<?php echo $value['url']; ?>" title="访问<?php echo $value['poster']; ?>的主页" target="_blank">主页</a>
	<?php endif;?></div>

		<div class="comment-meta commentmetadata"><?php echo $value['date']; ?></div>

		<p>	<span style="color:#666666; font-size:12px;"><?php echo $value['content']; ?></span>
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

		<div class="reply">
				</div>
				</div>
  <?php endforeach; ?>
	    </ol>
	<div class="navigation">
		<div class="alignleft"></div>
		<div class="alignright"></div>
	</div>

 


<div id="respond">

<h3>Leave a Reply</h3>

<?php if($allow_remark == 'y'): ?>
<form  method="post"  name="commentform" action="index.php?action=addcom" id="commentform">
<table width="620" border="0" cellspacing="8" cellpadding="0">
<tr>
<td class="f14">姓　 名：</td>
<td>
<input  id="comment" type="hidden" name="gid" value="<?php echo $logid; ?>" />
<input id="comment" type="text" name="comname" style="width:200px" maxlength="49" value="<?php echo $ckname; ?>"></td>
</tr>
<tr>
<td class="f14">电子邮件:</td>
<td><input id="comment" type="text" name="commail" style="width:300px" maxlength="128"  value="<?php echo $ckmail; ?>"> (选填)</td>
</tr>
<tr>
<td class="f14">个人主页:</td>
<td><input id="comment" type="text" name="comurl" style="width:300px" maxlength="128"  value="<?php echo $ckurl; ?>"> (选填)</td>
</tr>
<tr>
<td valign="top" class="f14">内　 容：</td>
<td><textarea name="comment" style="width:500px;height:155px" id="comment"></textarea>
</td>
</tr>

<tr>
<td valign="top"class="f14">&nbsp;</td>
<td valign="top" class="f14">
<?php echo $cheackimg; ?><input name="Submit" id="submit" type="submit" value="发表评论" onclick="return checkform()" />
</td>
</tr>
</table>
</form>
<?php endif; ?>
</div>




            </div>
        </div>
            </div>

                            <div id="sidebar"><!-- Sidebar Start Here -->
                <div id="sidebar_in">


<?php 
include getViews('side');
include getViews('footer'); 
?>