<!--<?php 
if(!defined('EMLOG_ROOT')) {exit('error!');}
//include getViews('side');
//$att_img = getAttachment($att_img,600,500);
echo <<<EOT
-->
<div class="logcontent">
<p id="tit">$log_title</p>
<p id="date">$post_time</p>
<div class="log_con">
$log_content
<a name="att"></a>
<p>$att_img</p>
<p>$attachment</p>	
<p>$tag</p>
</div>
<div class="nextlog">$neighborLog</div>
<!--
EOT;
if($allow_tb == 'y'){
echo <<<EOT
-->	
<div id="tb_list">
<p><b>引用:</b><a name="tb"></a></p>
<li>gbk: {$blogurl}tb.php?id=$logid&amp;sc={$tbscode}&amp;enc=gbk</li>  
<li>UTF-8: {$blogurl}tb.php?id=$logid&amp;sc={$tbscode}&amp;enc=utf-8</li>
</div>
<!--
EOT;
}echo <<<EOT
-->	
<!--
EOT;
foreach($tb as $key=>$value){
echo <<<EOT
-->
<div class="trackback">
	<li>来自: <a href="$value[url]" target="_blank">$value[blog_name]</a></li>
    <li>标题: <a href="$value[url]" target="_blank">$value[title]</a> </li>
    <li>摘要: $value[excerpt]</li>
	<li>引用时间: $value[date]</li>
</div>
<!--
EOT;
}if($com){
echo <<<EOT
-->
<p><b>评论:</b><a name="comment"></a></p>
<!--
EOT;
}echo <<<EOT
-->	
<div id="com_list">
<!--
EOT;
foreach($com as $key=>$value){
$value['reply'] = $value['reply']?"<span><b>博主回复</b>：{$value['reply']}</span>":'';
echo <<<EOT
-->
<li><a name="$value[cid]"></a>$value[poster] $value[addtime]<br />$value[content]<br />$value[reply]</li>
<!--
EOT;
}echo <<<EOT
-->	
</div>
<!--
EOT;
if($allow_remark == 'y'){
echo <<<EOT
-->
<p><b>发表评论:</b><a name="comment"></a></p>
<form  method="post"  name="commentform" action="index.php?action=addcom">
<table width="620" border="0" cellspacing="5" cellpadding="0">
<tr>
<td class="f14">姓　 名：</td>
<td>
<input type="hidden" name="gid" value="$logid" />
<input type="text" name="comname" style="width:200px" maxlength="49" value="$ckname"></td>
</tr>
<tr>
<td class="f14">电子邮件:</td>
<td><input type="text" name="commail" style="width:300px" maxlength="128"  value="$ckmail"> (选填)</td>
</tr>
<tr>
<td class="f14">个人主页:</td>
<td><input type="text" name="comurl" style="width:300px" maxlength="128"  value="$ckurl"> (选填)</td>
</tr>
<tr>
<td valign="top" class="f14">内　 容：</td>
<td><textarea name="comment" style="width:520px;height:155px"></textarea>
</td>
</tr>

<tr>
<td valign="top"class="f14">&nbsp;</td>
<td valign="top" class="f14">$cheackimg<input name="Submit" type="submit" value="发表评论" onclick="return checkform()" />
<input type="checkbox" name="remember" value="1" checked="checked" />记住我</td>
</tr>
</table>
</form>
<!--
EOT;
}echo <<<EOT
-->
</div>
EOT;
include getViews('footer');
?>