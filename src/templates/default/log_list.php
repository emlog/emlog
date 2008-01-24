<!--<?php 
if(!defined('EMLOG_ROOT')) {exit('error!');}
include getViews('side');
foreach($logs as $value){
print <<<EOT
-->
<div class="logcontent">
<!--
EOT;
if($isurlrewrite=='n'){
print <<<EOT
-->
<div id="t">{$value['toplog']}<a href="?action=showlog&gid={$value['logid']}">{$value['log_title']}</a> </div>
<!--
EOT;
}else{
print <<<EOT
-->
<div id="t">{$value['toplog']}<a href="showlog-{$value['logid']}.html">{$value['log_title']}</a> </div>
<!--
EOT;
}print <<<EOT
-->
<p id="date">{$value['post_time']}</p>
<div class="log_desc">{$value['log_description']}</div>
<p>{$value['att_img']}</p>
<p>{$value['attachment']}</p>
<p>{$value['tag']}</p>
<div align="right">
<!--
EOT;
if($isurlrewrite=='n'){
	print <<<EOT
	-->
 	<a href="?action=showlog&gid={$value['logid']}#comment">评论({$value['comnum']})</a>
 	<a href="?action=showlog&gid={$value['logid']}#tb">引用({$value['tbcount']})</a> 
 	<a href="?action=showlog&gid={$value['logid']}">浏览({$value['views']})</a>
	<!--
EOT;
}else{
	print <<<EOT
-->
	<a href="showlog-{$value['logid']}.html#comment">评论({$value['comnum']})</a>
	<a href="showlog-{$value['logid']}.html#tb">引用({$value['tbcount']})</a> 
	<a href="showlog-{$value['logid']}.html">浏览({$value['views']})</a>
<!--
EOT;
}
print <<<EOT
-->	
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