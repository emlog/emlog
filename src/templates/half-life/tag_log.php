<!--<?php 
if(!defined('EMLOG_ROOT')) {exit('error!');}
print <<<EOT
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
print <<<EOT
-->
	<p><a href="index.php?action=showlog&gid=$value[gid]">$value[title]</a> $value[date]</p>
<!--
EOT;
}print <<<EOT
-->
	</ul>
</div>
</div>
EOT;
include getViews('obar');
include getViews('footer');
?>
