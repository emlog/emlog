<!--<?php 
if(!defined('EMLOG_ROOT')) {exit('error!');}
foreach($logs as $value){
//$value[att_img] = getAttachment($value[att_img],200,120);
echo <<<EOT
-->
		<div class="post" id="post-$value[logid]">

<h2 class="posttitle"><a href="?action=showlog&gid=$value[logid]">$value[toplog] $value[log_title]</a></h2>

<p class="postmeta"> 
Posted on $value[post_time]<br />
  
 <a href="?action=showlog&gid=$value[com_url]">评论($value[comnum])</a>
 <a href="?action=showlog&gid=$value[tb_url]">引用($value[tbcount])</a> 
 <a href="?action=showlog&gid=$value[logid]">浏览($value[views])</a>
</p>

<div class="postentry">
				$value[log_description]
<p>$value[att_img]</p>
<p>$value[attachment]</p>
<p>$value[tag]</p>
</div>
</div>
<!--
EOT;
}echo <<<EOT
-->
<div class="browse">$page_url</div>
<!--
EOT;
echo <<<EOT
-->
</div>
EOT;
include getViews('side');
include getViews('footer');
?>