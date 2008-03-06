<!--<?php 
if(!defined('EMLOG_ROOT')) {exit('error!');}
//include getViews('side');
echo <<<EOT
-->
<div class="content">
<p id="t"><b>标签</b></p>
<p>所有标签：（标签字体越大其包含的日志越多）</p>
<p id="tags">
<!--
EOT;
foreach($tags as $key=>$value){
echo <<<EOT
-->
<span style="font-size:{$value['fontsize']}px; height:30px;"><a href="./?action=taglog&tag={$value['tagurl']}">{$value['tag']}</a></span>&nbsp;
<!--
EOT;
}echo <<<EOT
-->
$tagmsg
</p>
</div>
EOT;
include getViews('footer');
?>