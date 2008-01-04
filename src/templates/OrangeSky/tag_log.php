<!--<?php 
if(!defined('EMLOG_ROOT')) {exit('error!');}
print <<<EOT
-->
<div class="post">
<br />
<br />
	<p>包含<b>$tag</b>标签的所有日志：</p><br />
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
