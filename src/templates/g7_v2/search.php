<!--<?php 
if(!defined('EMLOG_ROOT')) {exit('error!');}
echo <<<EOT
-->
<div class="post">
<div class="content">
<h2><b>日志搜索</b></h2>
<p>$search_info</p>
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