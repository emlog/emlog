<!--<?php 
if(!defined('EMLOG_ROOT')) {exit('error!');}
echo <<<EOT
-->

	<div class="maincolumn">

		<div class="banner">&#160;</div>

		<div class="clear"></div>
<!--
EOT;
foreach($logs as $value){
//$value[att_img] = getAttachment($value[att_img],200,120);
echo <<<EOT
-->

		<div class="post" id="post-$value[logid]">
		<div class="wrapper">

			<div class="postmeta">
				<ul>
					<li>Posted on: $value[post_time]</li>
					<li> 
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
					</li>
				</ul>
			</div>

<h2>
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
</h2>

			<div class="entry">
				$value[log_description]
<p>$value[att_img]</p>
<p>$value[attachment]</p>
<p>$value[tag]</p>
			</div>

		</div>
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

