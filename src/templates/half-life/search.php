<!--<?php 
if(!defined('EMLOG_ROOT')) {exit('error!');}
echo <<<EOT
-->
	<div class="narrowcolumn">
	<div class="post">
<p id="t">$search_info</p>
<!--
EOT;
foreach($slog as $key=>$value){
echo <<<EOT
-->
<p><a href="./?action=showlog&gid={$value['gid']}">{$value['title']}</a> ({$value['date']})</p>
<!--
EOT;
}echo <<<EOT
-->		
</div>
</div>
EOT;
include getViews('obar');
include getViews('footer');
?>