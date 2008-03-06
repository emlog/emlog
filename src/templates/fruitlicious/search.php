<!--<?php 
if(!defined('EMLOG_ROOT')) {exit('error!');}
echo <<<EOT
-->
<div class="post">
<p>$search_info</p>
<div>
<!--
EOT;
foreach($slog as $key=>$value){
if($isurlrewrite=='n'){
echo <<<EOT
-->
<p><a href="./?action=showlog&gid={$value['gid']}">{$value['title']}</a> ({$value['date']})</p>
<!--
EOT;
}else{
echo <<<EOT
-->
<p><a href="showlog-{$value['gid']}.html">{$value['title']}</a> ({$value['date']})</p>
<!--
EOT;
}	
}echo <<<EOT
-->
</div>
</div>
<!--
EOT;
echo <<<EOT
-->
</div>
EOT;
include getViews('side');
include getViews('footer');
?>