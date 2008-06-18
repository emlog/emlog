<?php
if(!defined('EMLOG_ROOT')) {exit('error!');}
//$att_img = getAttachment($att_img,600,500);
?>
<DIV class=post id=post-1>
<H2><b><?php echo $log_title;?></b></H2>
<DIV class=entry>
<p><?php echo $log_content;?></p>
<a name="att"></a>
<p><?php echo $att_img;?></p>
<p><?php echo $att_img;?></p>
<p><?php echo $att_img;?></p>
<p><?php echo $neighborLog;?></P>
</DIV></DIV>
<p><?php echo $post_time;?> <?php echo $log_author;?></p>
<?php if($allow_tb == 'y'): ?>
<h5>引用地址:<a name="tb"></a></h5>
<input type="text" id="input" style="width:350px" value="<?php echo $blogurl;?>tb.php?sc=<?php echo $tbscode;?>&amp;id=<?php echo $logid;?>" /><a name="tb"></a>
<?php endif; ?>
<?php foreach($tb as $key=>$value): ?>
<ul class="trackback">
	<li>来自: <a href="<?php echo $value['url'];?>" target="_blank"><?php echo $value['blog_name'];?></a></li>
    <li>标题: <a href="<?php echo $value['url'];?>" target="_blank"><?php echo $value['title'];?></a> </li>
    <li>摘要: <?php echo $value['excerpt'];?></li>
	<li>引用时间: <?php echo $value['date'];?></li>
</ul>
<?php endforeach; ?>
<h5>评论<a name="comment" id="comment"></a></h5>
<?php
foreach($com as $key=>$value):
$value['reply'] = $value['reply']?"<span style=\"color:green;\"><b>博主回复</b>：{$value['reply']}</span>":'';
?>
<p><a name="<?php echo $value['cid'];?>"></a></p>
<div class="commentlist">
<cite><?php echo $value['poster'];?></cite> Says:<br />
<small class="commentmetadata"><?php echo $value['addtime'];?></small>
<p><?php echo $value['content'];?></p>
<p><?php echo $value['reply'];?></p>
</div>
<?php endforeach; ?>
<?php if($allow_remark == 'y'): ?>
<H3 id=respond>参与评论</H3>
<form  method="post"  name="commentform" action="index.php?action=addcom" onsubmit="return checkcomment(this)">
    <p>
        <input type="hidden" name="gid" value="<?php echo $logid;?>" />
      <br />
      <input name="comname"  type="text" value="<?php echo $ckname;?>" />
      <font color="red">姓名</font><br />
      <br />
	<input name="commail" type="text" size="45" value="<?php echo $ckmail;?>" maxlength="100" />
  电子邮件地址<br />      <br />
  <input name="comurl" type="text" size="45" value="<?php echo $ckurl;?>" maxlength="100" />
  个人主页<br />
  <br />
          <textarea name="comment" cols="45" rows="10" ></textarea>
  </p>
    <p><br />
          <?php echo $cheackimg;?>
          <input name="Submit" type="submit" value="提交我的评论" onclick="return checkform()" />
          <input type="checkbox" name="remember" value="1" checked="checked" />
          记住我
    </p>
</form>
<?php endif; ?>
<?php include getViews('footer'); ?>