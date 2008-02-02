<!--<?php
if(!defined('EMLOG_ROOT')) {exit('error!');}
echo <<<EOT
-->
<DIV class=post id=post-1>
	<h2>$tag</h2>
	<p>包含该标签的所有日志</p>
	<ul class="taglog">
<!--
EOT;
foreach($taglogs as $key=>$value){
echo <<<EOT
-->
	<li><a href="index.php?action=showlog&gid=$value[gid]">$value[title]</a> $value[date]</li>
<!--
EOT;
}echo <<<EOT
-->
	</ul>
</div>
EOT;
include getViews('footer');
?>