<!--<?php 
if(!defined('EMLOG_ROOT')) {exit('error!');}
echo <<<EOT
-->
<div class="post">
<div class="content">
	<h2><b>$tag</b></h2>
	<p><small>包含该标签的所有日志：</small></p>
<ul>
<!--
EOT;
foreach($taglogs as $key=>$value){
echo <<<EOT
-->
	<li><a href="index.php?action=showlog&gid={$value['gid']}">{$value['title']}</a> {$value['date']}</li>
<!--
EOT;
}echo <<<EOT
-->
	</ul>
</div>
<!--
EOT;
echo <<<EOT
-->
</div>
</div>
</div>
EOT;
include getViews('footer');
?>