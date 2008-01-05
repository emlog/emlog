<!--<?php 
if(!defined('EMLOG_ROOT')) {exit('error!');}
print <<<EOT
-->
<div class="content">
<div class="mypost">
	<p><b>$tag</b></p>
	<p><small>包含该标签的所有日志：</small></p>
<ul class="taglog">
<!--
EOT;
foreach($taglogs as $key=>$value){
print <<<EOT
-->
	<p><a href="index.php?action=showlog&gid=$value[gid]">$value[title]</a> <small>$value[date]</small></p>
<!--
EOT;
}print <<<EOT
-->
	</ul>
</div>
<!--
EOT;
print <<<EOT
-->
</div>
</div>
EOT;
include getViews('side');
include getViews('footer');
?>
