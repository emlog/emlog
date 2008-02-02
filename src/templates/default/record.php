<!--<?php 
if(!defined('EMLOG_ROOT')) {exit('error!');}
//include getViews('side');
echo <<<EOT
-->
<div class="content">
<li id="t"><b>全部存档</b></li>
<!--
EOT;
foreach($records as $key=>$value){
if($isurlrewrite=='n'){
echo <<<EOT
-->
<li><a href="index.php?record={$value['record2_url']}">{$value['record2']}</a></li>
<!--
EOT;
}else
{
	echo <<<EOT
-->
<li><a href="record-{$value['record2_url']}.html">{$value['record2']}</a></li>
<!--
EOT;
}
}echo <<<EOT
-->
</div>
<br />
<!--
EOT;
?>-->
