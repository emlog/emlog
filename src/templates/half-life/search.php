<!--<?php 
if(!defined('EMLOG_ROOT')) {exit('error!');}
print <<<EOT
-->
	<div class="narrowcolumn">
	<div class="post">
<p id="t">$search_info</p>
<!--
EOT;
foreach($slog as $key=>$value){
print <<<EOT
-->
<p><a href="?action=showlog&gid=$value[gid]">$value[title]</a> ($value[date])</p>
<!--
EOT;
}print <<<EOT
-->	
</div>
</div>
EOT;
include getViews('obar');
include getViews('footer');
?>