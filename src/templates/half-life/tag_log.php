<!--<?php 
if(!defined('EMLOG_ROOT')) {exit('error!');}
echo <<<EOT
-->
	<div class="narrowcolumn">
	<div class="post">
	<ul id="t">
		<p><b>$tag</b></p><small>(包含该标签的所有日志)</small>
	</ul>
<ul class="taglog">
<!--
EOT;
foreach($taglogs as $key=>$value){
echo <<<EOT
-->
	<p><a href="index.php?action=showlog&gid={$value['gid']}">{$value['title']}</a> {$value['date']}</p>
<!--
EOT;
}echo <<<EOT
-->
	</ul>
</div>
</div>
EOT;
include getViews('obar');
include getViews('footer');
?>