<!--<?php 
if(!defined('EMLOG_ROOT')) {exit('error!');}
echo <<<EOT
-->
<DIV class=post id=post-1>
<h3>$search_info</h3>
<div>
<ul>
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
</ul>
</div>
</div>
EOT;
include getViews('footer');
?>