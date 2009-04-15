<?php
if(!defined('EMLOG_ROOT')) {exit('error!');}
?>
<!--博客说明或者当前所在位置-->
<div id="center_small">
	<div class="clear"></div>
	<div id="day_text">
        您的位置：<a href="index.php">首页</a>>
		<?php if($log_cache_sort[$logid]): ?>
         <a href="./?sort=<?php echo $sortid; ?>"><?php echo $log_cache_sort[$logid]; ?></a>
		<?php endif;?> > 
        <?php echo $log_title; ?>
    </div>
    <div id="header_right_bottom">
    </div>
</div>
<div class="clear"></div>
<!--页面中部-->
<div id="center_box">
<!--页面左侧日志部分-->
	<div id="left_box">
    	<div class="note_box">
    		<div class="note_title">
        	<?php echo $log_title; ?>
        	</div>
            <div class="note_tag">
            	<div class="note_tag_text1">
            	<?php if($log_cache_sort[$logid]): ?>
        		 <a href="./?sort=<?php echo $sortid; ?>"><?php echo $log_cache_sort[$logid]; ?></a>
				<?php endif;?>
            	</div>
                <div class="note_tag_text2">
            	<?php echo date('Y-n-j G:i l', $date); ?>
            	</div>           
        	</div>
        	<div class="note_content">
       			<?php echo $log_content; ?>
			<p>
				<?php 
				$attachment = !empty($log_cache_atts[$logid]) ? '<b>文件附件</b>:'.$log_cache_atts[$logid] : '';
				echo $attachment;
				?>
			</p>
        	</div>
            <?php if($allow_tb == 'y'):?>	
            <div class="copy_box">
            引用地址： 
            <input value="<?php echo $blogurl; ?>tb.php?sc=<?php echo $tbscode; ?>&amp;id=<?php echo $logid; ?>" type="text" style="border:0px; color:#FFCC00; width:350px;"  /><a name="tb"></a>
			<?php 
			foreach($tb as $key=>$value):
			?>
			<li><a href="<?php echo $value['url'];?>" target="_blank"><?php echo $value['title'];?></a> <br>
			BLOG: <?php echo $value['blog_name'];?><br>
			<?php echo $value['date'];?><br>
			<?php endforeach; ?>
         	</div>
            <?php endif; ?>
        	<div class="note_tag" style="margin-top:10px;">
            	<div class="note_tag_text5">
                <?php 
				$tag = !empty($log_cache_tags[$logid]) ? 'Tags:'.$log_cache_tags[$logid] : '';
				echo $tag;
				?>
            	</div>
        	</div>
            <div class="note_tag_2" style="margin-top:10px;">
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
        </div>
        
<!--评论-->       
        <?php if($comments): ?>
         <div class="note_tag_2" style="margin-top:10px; margin-left:20px; color:#525454;">
         <b>评论</b>：
        </div> 
        <div class="com_box">   	
            <div class="commentlist">
			<?php
			foreach($comments as $key=>$value):
			$reply = $value['reply']?"<span style='color:#148EC0'>博主回复：</span><span>{$value['reply']}</span>":'';
			?>
			<li class="<?=$oddcomment;?>">
			<a name="<?php echo $value['cid']; ?>"></a>
            
    		<div class="com_poster">
			 <?php echo $value['poster']; ?>&nbsp;<span style="color:#525454;;"> <?php echo $value['date']; ?></span> 
            			<?php if($value['mail']):?>
			<a href="mailto:<?php echo $value['mail']; ?>" title="发邮件给<?php echo $value['poster']; ?>">Email</a>
			<?php endif;?>
			<?php if($value['url']):?>
			<a href="<?php echo $value['url']; ?>" title="访问<?php echo $value['poster']; ?>的主页" target="_blank">主页</a>
			<?php endif;?>	
   			</div> 
    		<div class="comment">
   			    <span class="commenttxt"><?php echo $value['content']; ?></span>            
				<div id="replycomm<?php echo $value['cid']; ?>">
   				<span class="commenttxt"><?php echo $reply; ?></span>
   				<span class="commenttxt">
   			<?php if(ISLOGIN === true): ?>
			<a href="javascript:void(0);" onclick="showhidediv('replybox<?php echo $value['cid']; ?>','reply<?php echo $value['cid']; ?>')">回复</a>
			<div id='replybox<?php echo $value['cid']; ?>' style="display:none;">
			<textarea name="reply<?php echo $value['cid']; ?>" class="input" id="reply<?php echo $value['cid']; ?>" style="overflow-y: hidden;width:360px;height:50px;"><?php echo $value['reply']; ?></textarea>
			<br />
			<span class="commenttxt">
        	<a href="javascript:void(0);" onclick="postinfo('./admin/comment.php?action=doreply&cid=<?php echo $value['cid']; ?>		&flg=1','reply<?php echo $value['cid']; ?>','replycomm<?php echo $value['cid']; ?>');">提交</a>
			<a href="javascript:void(0);" onclick="showhidediv('replybox<?php echo $value['cid']; ?>')">取消</a>
        	</span>
			</div>           
			<?php endif; ?> 
   				
   				</span>
            </div> 			            			
			</div>
       		</li>
			<?php endforeach; ?>       
			</div> 
        </div>
        <?php endif; ?>       
        <div class="note_tag_2" style="margin-top:20px; margin-left:20px; color:#525454;">
       <b> 发表评论：</b>
        </div> 
        <div class="com_box_bottom"> 
        	<form  method="post"  name="commentform" action="index.php?action=addcom">
			
  			<span>姓名</span>
            <input type="hidden" name="gid" value="<?php echo $logid; ?>"  size="22" tabindex="1"/><input type="text" name="comname" class="textfield" maxlength="49" value="<?php echo $ckname; ?>">
<br />
		
			<span>邮箱</span>
			<input type="text" name="commail" class="textfield"  maxlength="128"  value="<?php echo $ckmail; ?>">
			<span>(选填)</span><br />
			
			<span>主页</span>
			<input type="text" name="comurl" class="textfield" maxlength="128"  value="<?php echo $ckurl; ?>">
			<span>(选填)</span><br />
<textarea  class="textfield_2" name="comment" id="comment" cols="55" rows="10" tabindex="4"></textarea>
			<br/>
			<?php echo $cheackimg; ?><input name="submit" type="submit" id="submit" tabindex="5" value="提交留言" class="textfield_3" />
			</form>         
        </div>        
    </div>
<!--页面右侧部分-->
    <div id="right_box">
        <div id="sear_box">
         <form id="searchform" name="keyform" method="get" action="index.php">
         <div id="sear_box_left">
        	<input type="text" name="keyword" style="width:195px; height:15px; border:#E2E5EA solid 1px;" />
         </div>
         <div id="sear_box_right">
         <input type="submit" style="width:50px; height:20px; border:#E2E5EA solid 1px; font-size:12px; background-color:#f1f1f1;" value="搜索" />
         </div>
        </form>
        </div>
        <div id="side_box">
        <?php include getViews('side'); ?>
        </div>
    </div>
<div class="clear"></div>
</div>
<div class="clear"></div>
<?php include getViews('footer'); ?>