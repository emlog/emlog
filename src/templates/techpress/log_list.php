<!--<?php 
if(!defined('EMLOG_ROOT')) {exit('error!');}
echo <<<EOT
-->

		<div class="narrowcolumn">
<!--
EOT;
foreach($logs as $value){
//$value[att_img] = getAttachment($value[att_img],200,120);
echo <<<EOT
-->
			<div class="post">
				<div class="postdate">$value[post_time]</div>
				<h2>$value[toplog]<a href="?action=showlog&gid=$value[logid]">$value[log_title]</a></h2>
				<div class="entry">
$value[log_description]
<p>$value[att_img]</p>
<p>$value[attachment]</p>
<p>$value[tag]</p>

				<p class="postinfo">
  
 <a href="?action=showlog&gid=$value[com_url]">评论($value[comnum])</a>
 <a href="?action=showlog&gid=$value[tb_url]">引用($value[tbcount])</a> 
 <a href="?action=showlog&gid=$value[logid]">浏览($value[views])</a>
				</p>

				</div>
			</div>
<!--
EOT;
}echo <<<EOT
-->
<div class="browse">$page_url</div>
		</div>
EOT;
include getViews('side');
include getViews('footer');
?>