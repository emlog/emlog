<!--<?php 
if(!defined('EMLOG_ROOT')) {exit('error!');}
print <<<EOT
-->
<div id="content">
<div class="entry single">
<p>$search_info</p>
<div>
<!--
EOT;
foreach($slog as $key=>$value){
print <<<EOT
-->
<p><a href="?action=showlog&gid=$value[gid]">$value[title]</a> <small>($value[date])</small></p>
<!--
EOT;
}print <<<EOT
-->	
</div>
</div>
<!--
EOT;
print <<<EOT
-->
</div>
EOT;
include getViews('side');
include getViews('footer');
?>