<!--<?php 
if(!defined('EMLOG_ROOT')) {exit('error!');}
print <<<EOT
-->
	<div class="narrowcolumn">
	<div class="post">
<p id="t"><b>标签</b></p>
<p>所有标签：（标签字体越大其包含的日志越多）</p>
<p id="tags">
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
</p>
</div>
</div>
EOT;
include getViews('obar');
include getViews('footer');
?>