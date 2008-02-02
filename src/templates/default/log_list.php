<!--<?php 
if(!defined('EMLOG_ROOT')) {exit('error!');}
include getViews('side');
foreach($logs as $value){
echo <<<EOT
-->
<div class="logcontent">
<!--
EOT;
if($isurlrewrite=='n'){
echo <<<EOT
-->
<div id="t">{$value['toplog']}<a href="?action=showlog&gid={$value['logid']}">{$value['log_title']}</a> </div>
<!--
EOT;
}else{
echo <<<EOT
-->
<div id="t">{$value['toplog']}<a href="showlog-{$value['logid']}.html">{$value['log_title']}</a> </div>
<!--
EOT;
}echo <<<EOT
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
	echo <<<EOT
	-->
 	<a href="?action=showlog&gid={$value['logid']}#comment">评论({$value['comnum']})</a>
 	<a href="?action=showlog&gid={$value['logid']}#tb">引用({$value['tbcount']})</a> 
 	<a href="?action=showlog&gid={$value['logid']}">浏览({$value['views']})</a>
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