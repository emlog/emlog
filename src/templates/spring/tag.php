<!--<?php 
if(!defined('EMLOG_ROOT')) {exit('error!');}
//include getViews('side');
echo <<<EOT
-->
<div class="post">
<p><b>标签</b></p>
<p><small>所有标签：（标签字体越大其包含的日志越多）</small></p>
<p>
<!--
EOT;
foreach($tags as $key=>$value){
echo <<<EOT
-->
<span style="font-size:$value[fontsize]px; height:30px;"><a href="./index.php?action=taglog&amp;tag=$value[tagurl]">$value[tag]</a></span>&nbsp;
<!--
EOT;
}echo <<<EOT
-->
$tagmsg
</p>
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