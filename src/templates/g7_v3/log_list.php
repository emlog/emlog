<!--<?php 
if(!defined('EMLOG_ROOT')) {exit('error!');}
foreach($logs as $value){
//$value[att_img] = getAttachment($value[att_img],200,120);
echo <<<EOT
-->
<h2>
{$value['toplog']}<a href="./?action=showlog&gid={$value['logid']}">{$value['log_title']}</a>
</h2>
<p class="postdata">Posted in $value[post_time]</p>
<div id="content_post">
				<p>$value[log_description]</p>
				<p>$value[att_img]</p>
				<p>$value[attachment]</p>
				<p class="tags">$value[tag]</p>
				<p class="postinfo" >				  
 	<a href="./?action=showlog&gid={$value['logid']}#comment">评论({$value['comnum']})</a>
 	<a href="./?action=showlog&gid={$value['logid']}#tb">引用({$value['tbcount']})</a> 
 	<a href="./?action=showlog&gid={$value['logid']}">浏览({$value['views']})</a>
				</p>
</div>
<!--
EOT;
}echo <<<EOT
-->
<p>$page_url</p>
</div>
<!--
EOT;
echo <<<EOT
-->
EOT;
include getViews('side');
include getViews('footer');
?>
