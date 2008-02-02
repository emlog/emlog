<!--<?php 
if(!defined('EMLOG_ROOT')) {exit('error!');}
echo <<<EOT
-->
	<div class="maincolumn">

		<div class="banner">&#160;</div>

		<div class="clear"></div>
<div class="post">
<p>$search_info</p>
<div>
<!--
EOT;
foreach($slog as $key=>$value){
echo <<<EOT
-->
<p><a href="?action=showlog&gid=$value[gid]">$value[title]</a> <small>($value[date])</small></p>
<!--
EOT;
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