<!--<?php 
if(!defined('EMLOG_ROOT')) {exit('error!');}
include getViews('side');
foreach($logs as $value){
echo <<<EOT
-->
<div class="logcontent">
<div id="t">
<!--
EOT;
if($isurlrewrite=='n'){
echo <<<EOT
-->
{$value['toplog']}<a href="./?action=showlog&gid={$value['logid']}">{$value['log_title']}</a>
<!--
EOT;
}else{
echo <<<EOT
-->
{$value['toplog']}<a href="showlog-{$value['logid']}.html">{$value['log_title']}</a>
<!--
EOT;
}echo <<<EOT
-->
</div>
<p id="date">{$value['post_time']}</p>
<div class="log_desc">{$value['log_description']}</div>
<p class="other">{$value['att_img']}</p>
<p class="other">{$value['attachment']}</p>
<p class="other">{$value['tag']}</p>
<div align="right">
<!--
EOT;
if($isurlrewrite=='n'){
	echo <<<EOT
	-->
 	<a href="./?action=showlog&gid={$value['logid']}#comment">评论({$value['comnum']})</a>
 	<a href="./?action=showlog&gid={$value['logid']}#tb">引用({$value['tbcount']})</a> 
 	<a href="./?action=showlog&gid={$value['logid']}">浏览({$value['views']})</a>
	<!--
EOT;
}else{
	echo <<<EOT
-->
	<a href="showlog-{$value['logid']}.html#comment">评论({$value['comnum']})</a>
	<a href="showlog-{$value['logid']}.html#tb">引用({$value['tbcount']})</a> 
	<a href="showlog-{$value['logid']}.html">浏览({$value['views']})</a>
<!--
EOT;
}
echo <<<EOT
-->	
</div>
</div>
<!--
EOT;
}echo <<<EOT
-->
<div id="pageurl"> $page_url</div>
EOT;
include getViews('footer');
?>