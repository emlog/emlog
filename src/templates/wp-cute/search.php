<!--<?php 
if(!defined('EMLOG_ROOT')) {exit('error!');}
print <<<EOT
-->
<DIV class=post id=post-1>
<h3>$search_info</h3>
<!--
EOT;
foreach($slog as $key=>$value){
print <<<EOT
-->
<div>
<ul>
<li><a href="?action=showlog&gid=$value[gid]">$value[title]</a> ($value[date])</li>
</ul>
</div>
<!--
EOT;
}print <<<EOT
-->
</div>
EOT;
include getViews('footer');
?>