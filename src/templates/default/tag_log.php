<!--<?php 
if(!defined('EMLOG_ROOT')) {exit('error!');}
//include getViews('side');
print <<<EOT
-->
<div class="content">
	<ul id="t">
		<li><b>$tag</b></li>
	</ul>
	<p>包含该标签的所有日志：</p>
	<ul class="taglog">
<!--
EOT;
foreach($taglogs as $key=>$value){
print <<<EOT
-->
	<li><a href="index.php?action=showlog&gid=$value[gid]">$value[title]</a> $value[date]</li>
<!--
EOT;
}print <<<EOT
-->
	</ul>
</div>
EOT;
include getViews('footer');
?>
