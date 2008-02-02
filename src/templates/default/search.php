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
if($isurlrewrite=='n'){
echo <<<EOT
-->
<li><a href="?action=showlog&gid={$value['gid']}">{$value['title']}</a> ({$value['date']})</li>
<!--
EOT;
}else{
echo <<<EOT
-->
<li><a href="showlog-{$value['gid']}.html">{$value['title']}</a> ({$value['date']})</li>
<!--
EOT;
}	
}echo <<<EOT
-->	
</div>
</div>
EOT;
include getViews('footer');
?>