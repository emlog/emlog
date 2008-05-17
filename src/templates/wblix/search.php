<!--<?php 
if(!defined('EMLOG_ROOT')) {exit('error!');}
echo <<<EOT
-->
<div id="content">
<div class="entry single">
<p>$search_info</p>
<div>
<!--
EOT;
foreach($slog as $key=>$value){
echo <<<EOT
-->
<p><a href="./?action=showlog&gid={$value['gid']}">{$value['title']}</a> ({$value['date']})</p>
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