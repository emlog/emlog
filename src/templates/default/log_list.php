<!--<?php 
if(!defined('EMLOG_ROOT')) {exit('error!');}
include getViews('side');
foreach($logs as $value){
print <<<EOT
-->
<div class="logcontent">
<div id="t">$value[toplog]<a href="?action=showlog&gid=$value[logid]">$value[log_title]</a> </div>
<p id="date">$value[post_time]</p>
<div class="log_desc">$value[log_description]</div>
<p>$value[att_img]</p>
<p>$value[attachment]</p>
<p>$value[tag]</p>
<div align="right">
  
 <a href="?action=showlog&gid=$value[com_url]">评论($value[comnum])</a>
 <a href="?action=showlog&gid=$value[tb_url]">引用($value[tbcount])</a> 
 <a href="?action=showlog&gid=$value[logid]">浏览($value[views])</a>
</div>
</div>
<!--
EOT;
}print <<<EOT
-->
<div id="pageurl"> $page_url</div>
EOT;
include getViews('footer');
?>
