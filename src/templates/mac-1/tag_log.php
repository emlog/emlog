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
	<div><b>$tag</b></p><small>(包含该标签的所有日志)</small></div>
<div class="entry">
<!--
EOT;
foreach($taglogs as $key=>$value){
print <<<EOT
-->
	<p><a href="index.php?action=showlog&gid=$value[gid]">$value[title]</a> $value[date]</p>
<!--
EOT;
}print <<<EOT
-->
$tagmsg
</div>
</div>
</div>
<div id="footer">&copy; 2007 <a href="http://www.emlog.net" target="_blank">emlog</a> Theme by <a href="http://www.ndesign-studio.com/">Nick La</a> </div>
</div>
EOT;
include getViews('side');
?>