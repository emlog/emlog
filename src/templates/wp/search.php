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
</ul>
</div>
</div>
EOT;
include getViews('footer');
?>