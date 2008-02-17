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

<h1><!--
EOT;
if($isurlrewrite=='n'){
echo <<<EOT
-->
{$value['toplog']}<a href="?action=showlog&gid={$value['logid']}">{$value['log_title']}</a>
<!--
EOT;
}else{
echo <<<EOT
-->
{$value['toplog']}<a href="showlog-{$value['logid']}.html">{$value['log_title']}</a>
<!--
EOT;
}echo <<<EOT
--></h1>

<p class="info">
<em class="date">Posted on $value[post_time]</em>
</p>

$value[log_description]
<p>$value[att_img]</p>
<p>$value[attachment]</p>
<p>$value[tag]</p>

<p class="info">
<em class="caty">
  
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
-->	</em>
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
