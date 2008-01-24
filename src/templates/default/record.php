<!--<?php 
if(!defined('EMLOG_ROOT')) {exit('error!');}
//include getViews('side');
print <<<EOT
-->
<div class="content">
<li id="t"><b>全部存档</b></li>
<!--
EOT;
foreach($records as $key=>$value){
if($isurlrewrite=='n'){
print <<<EOT
-->
<li><a href="index.php?record={$value['record2_url']}">{$value['record2']}</a></li>
<!--
EOT;
}else
{
	print <<<EOT
-->
<li><a href="record-{$value['record2_url']}.html">{$value['record2']}</a></li>
<!--
EOT;
}
}print <<<EOT
-->
</div>
<br />
<!--
EOT;
?>-->
