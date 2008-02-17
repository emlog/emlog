<!--<?php 
if(!defined('EMLOG_ROOT')) {exit('error!');}
echo <<<EOT
-->
<div class="narrowcolumn">
<div class="post">
	<p><b>$tag</b></p>
	<p><small>包含该标签的所有日志：</small></p>
<ul class="taglog">
<!--
EOT;
foreach($taglogs as $key=>$value){
if($isurlrewrite=='n'){
echo <<<EOT
-->
	<li><a href="index.php?action=showlog&gid={$value['gid']}">{$value['title']}</a> {$value['date']}</li>
<!--
EOT;
}else{
	echo <<<EOT
-->
	<li><a href="showlog-{$value['gid']}.html">{$value['title']}</a> {$value['date']}</li>
<!--
EOT;
}
}echo <<<EOT
-->
	</ul>
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
