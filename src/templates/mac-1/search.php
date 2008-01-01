<!--<?php 
if(!defined('EMLOG_ROOT')) {exit('error!');}
print <<<EOT
-->
      <div id="nav">
        <ul>
          <li class="page_item current_page_item"><a href="./index.php" title="Home">Home</a></li>
        </ul>
      </div>
  <div id="content">
	<div class="post">
<div class="entry">
<p id="t">$search_info</p>
<!--
EOT;
foreach($slog as $key=>$value){
print <<<EOT
-->
<p><a href="?action=showlog&gid=$value[gid]">$value[title]</a> ($value[date])</p>
<!--
EOT;
}print <<<EOT
-->	
</div>
</div>
</div>
<div id="footer">&copy; 2007 <a href="http://www.emlog.net" target="_blank">emlog</a></div>
</div>
EOT;
include getViews('side');
?>