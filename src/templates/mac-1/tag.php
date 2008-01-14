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
<div><b>所有标签：</b>（标签字体越大其包含的日志越多）</div>
<div class="entry">
<!--
EOT;
foreach($tags as $key=>$value){
print <<<EOT
-->
<span style="font-size:$value[fontsize]px; height:30px;"><a href="?action=taglog&tag=$value[tagurl]">$value[tag]</a></span>&nbsp;
<!--
EOT;
}print <<<EOT
-->
$tagmsg
</div>
</div>
</div><!--/content -->
<div id="footer">&copy; 2007 <a href="http://www.emlog.net" target="_blank">emlog</a> Theme by <a href="http://www.ndesign-studio.com/">Nick La</a> </div>
</div>
EOT;
include getViews('side');
?>