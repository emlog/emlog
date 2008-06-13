<!--<?php 
if(!defined('EMLOG_ROOT')) {exit('error!');}
include getViews('side');
//$att_img = getAttachment($att_img,600,500);
echo <<<EOT
-->
<div class="logcontent">
<p align="center" id="tit">$log_title</p>
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
<p class="other"><b>引用地址：</b> <input type="text" style="width:350px" class="input" value="{$blogurl}tb.php?sc={$tbscode}&amp;id={$logid}"><a name="tb"></a></p>
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
    <li>摘要: <font color=#fbab9c>$value[excerpt]</font></li>
	<li>引用时间: <font color=#fbab9c>$value[date]</font></li>
</div>
<!--
EOT;
}if($com){
echo <<<EOT
-->
<p class="other"><b>评论:</b><a name="comment"></a></p>
<!--
EOT;
}echo <<<EOT
-->	
<div id="com_list">
<!--
EOT;
foreach($com as $key=>$value){
$value['reply'] = $value['reply']?"<span><b>博主回复</b>：</span>{$value['reply']}":'';
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
<p class="other"><b>发表评论:</b><a name="comment"></a></p>
<form  method="post"  name="commentform" action="index.php?action=addcom">
<table width="520" border="0" cellspacing="5" cellpadding="0">
<tr>
<td class="other">姓　　名：</td>
<td>
<input type="hidden" name="gid" value="$logid" />
<input type="text" name="comname" style="width:200px; background:#c2f5f9;color:#fbab9c" maxlength="49" value="$ckname"></td>
</tr>
<tr>
<td class="other">电子邮件：</td>
<td class="other"><input type="text" name="commail" style="width:300px; background:#c2f5f9;color:#fbab9c" maxlength="128"  value="$ckmail"> (选填)</td>
</tr>
<tr>
<td class="other">个人主页：</td>
<td class="other"><input type="text" name="comurl" style="width:300px; background:#c2f5f9;color:#fbab9c" maxlength="128"  value="$ckurl"> (选填)</td>
</tr>
<tr>
<td valign="top" class="other">内　　容：</td>
<td><textarea name="comment" style="width:420px;height:155px; background:#c2f5f9;color:#fbab9c"></textarea>
</td>
</tr>

<tr>
<td valign="top"class="other">&nbsp;</td>
<td valign="top" class="other">$cheackimg<input name="Submit" type="submit" style="background:#c2f5f9;color:#fbab9c"value="发表评论" onclick="return checkform()" />
<input type="checkbox" name="remember" value="1" checked="checked" style="border:2px #fbab9c" />记住我</td>
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