<!--<?php
if(!defined('EMLOG_ROOT')) {exit('error!');}
print <<<EOT
-->
<DIV class=post id=post-1>
<p id="t"><b>标签(Tag)</b></p>
<p>所有标签：（标签字体越大其包含的日志越多）</p>
<ul class="tagul">
<li>
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
</li>
$tagmsg
</ul>
</div>
EOT;
include getViews('footer');
?>