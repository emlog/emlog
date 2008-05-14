<!--<?php 
if(!defined('EMLOG_ROOT')) {exit('error!');}
//include getViews('side');
echo <<<EOT
-->
<div class="content">
<p id="t">$search_info</p>
<div id="t_search">
<!--
EOT;
foreach($slog as $key=>$value){
echo <<<EOT
-->
<li><a href="./?action=showlog&gid={$value['gid']}">{$value['title']}</a> ({$value['date']})</li>
<!--
EOT;	
}echo <<<EOT
-->	
</div>
</div>
EOT;
include getViews('footer');
?>