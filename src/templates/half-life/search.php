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
if($isurlrewrite=='n'){
echo <<<EOT
-->
<p><a href="./?action=showlog&gid={$value['gid']}">{$value['title']}</a> ({$value['date']})</p>
<!--
EOT;
}else{
echo <<<EOT
-->
<p><a href="showlog-{$value['gid']}.html">{$value['title']}</a> ({$value['date']})</ps>
<!--
EOT;
}	
}echo <<<EOT
-->		
</div>
</div>
EOT;
include getViews('obar');
include getViews('footer');
?>