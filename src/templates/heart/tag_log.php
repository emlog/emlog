<!--<?php 
if(!defined('EMLOG_ROOT')) {exit('error!');}
include getViews('side');
echo <<<EOT
-->
<div class="content">
	<ul id="t">
		<li>标签： <b>$tag</b></li>
	</ul>
	<ul class="taglog">
<!--
EOT;
foreach($taglogs as $key=>$value){
if($isurlrewrite=='n'){
echo <<<EOT
-->
	<li><a href="index.php?action=showlog&gid={$value['gid']}">{$value['title']}</a> {$value['date']}</li>
<!--
EOT;
}else{
	echo <<<EOT
-->
	<li><a href="showlog-{$value['gid']}.html">{$value['title']}</a> {$value['date']}</li>
<!--
EOT;
}
}echo <<<EOT
-->
	</ul>
</div>
EOT;
include getViews('footer');
?>
