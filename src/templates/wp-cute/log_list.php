<!--<?php 
if(!defined('EMLOG_ROOT')) {exit('error!');}
include getViews('side');
foreach($logs as $value){
echo <<<EOT
-->
<DIV class=post id=post-1>
<H2><!--
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
-->  </H2>
<SMALL>| $value[post_time] </SMALL>
<DIV class=entry>
<P>$value[log_description]</P>
</DIV>
<p>$value[att_img]</p>
<p>$value[attachment]</p>
<p style="color: #FF0000;">$value[tag]</p>
<P class=postmetadata>  
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
-->	</P>
</DIV>
<!--
EOT;
}echo <<<EOT
-->
<div id="pageurl"> $page_url</div>
EOT;
include getViews('footer');
?>