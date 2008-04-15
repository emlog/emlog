<?php
if(!defined('EMLOG_ROOT')) {exit('error!');}
//$att_img = getAttachment($att_img,600,500);
echo <<<EOT
<DIV class=post id=post-1>
<H2><b>$log_title</b></A></H2>
<DIV class=entry>
<P>$log_content</P>
<a name="att"></a>
<p>$att_img</p>
<p>$attachment</p>
<p>$tag</p>
<p>$neighborLog</P>
</DIV></DIV>
<p>$post_time $log_author</p>
EOT;
if($allow_tb == 'y'){
echo <<<EOT
<h5>引用地址:<a name="tb"></a></h5>
<p>gbk: {$blogurl}tb.php?id=$logid&amp;sc={$tbscode}&amp;enc=gbk</p>  
<p>UTF-8: {$blogurl}tb.php?id=$logid&amp;sc={$tbscode}&amp;enc=utf-8</p>
EOT;
}
foreach($tb as $key=>$value){
echo <<<EOT
<ul class="trackback">
	<li>来自: <a href="$value[url]" target="_blank">$value[blog_name]</a></li>
    <li>标题: <a href="$value[url]" target="_blank">$value[title]</a> </li>
    <li>摘要: $value[excerpt]</li>
	<li>引用时间: $value[date]</li>
</ul>
EOT;
}echo <<<EOT
<h5>评论<a name="comment" id="comment"></a></h5>
EOT;
foreach($com as $key=>$value){
$value['reply'] = $value['reply']?"<span style=\"color:green;\"><b>博主回复</b>：{$value['reply']}</span>":'';
echo <<<EOT
<p><a name="$value[cid]"></a></p>
<div class="commentlist">
<cite>$value[poster]</cite> Says:<br />
<small class="commentmetadata">$value[addtime]</small>
<p>$value[content]</p>
<p>$value[reply]</p>
</div>
EOT;
}if($allow_remark == 'y'){
echo <<<EOT
<H3 id=respond>参与评论</H3>
<form  method="post"  name="commentform" action="index.php?action=addcom" onsubmit="return checkcomment(this)">
    <p>
        <input type="hidden" name="gid" value="$logid" />
      <br />
      <input name="comname"  type="text" value="$ckname" />
      <font color="red">姓名</font><br />
      <br />
	<input name="commail" type="text" size="45" value="$ckmail" maxlength="100" />
  电子邮件地址<br />
  <input name="comurl" type="text" size="45" value="$ckurl" maxlength="100" />
  个人主页<br />
  <br />
          <textarea name="comment" cols="45" rows="10" ></textarea>
  </p>
    <p><br />
          $cheackimg
          <input name="Submit" type="submit" value="提交我的评论" onclick="return checkform()" />
          <input type="checkbox" name="remember" value="1" checked="checked" />
          记住我
    </p>
</form>
EOT;
}
include getViews('footer');
?>