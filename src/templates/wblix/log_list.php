<!--<?php 
if(!defined('EMLOG_ROOT')) {exit('error!');}
echo <<<EOT
-->
<div id="content">
<!--
EOT;
foreach($logs as $value){
//$value[att_img] = getAttachment($value[att_img],200,120);
echo <<<EOT
-->
<div class="entry single">

<h1>$value[toplog]<a href="?action=showlog&gid=$value[logid]">$value[log_title]</a></h1>

<p class="info">
<em class="date">Posted on $value[post_time]</em>
</p>

$value[log_description]
<p>$value[att_img]</p>
<p>$value[attachment]</p>
<p>$value[tag]</p>

<p class="info">
<em class="caty">
  
 <a href="?action=showlog&gid=$value[com_url]">评论($value[comnum])</a>
 <a href="?action=showlog&gid=$value[tb_url]">引用($value[tbcount])</a> 
 <a href="?action=showlog&gid=$value[logid]">浏览($value[views])</a></em>
</p>

</div>
<!--
EOT;
}echo <<<EOT
-->
<p>$page_url</p>
</div>
EOT;
include getViews('side');
include getViews('footer');
?>
