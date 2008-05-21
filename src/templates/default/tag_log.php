<?php
if(!defined('EMLOG_ROOT')) {exit('error!');}
//include getViews('side');
echo <<<EOT
?>
<div class="content">
	<ul id="t">
		<li>标签： <b>$tag</b></li>
	</ul>
	<ul class="taglog">
<?php
EOT;
foreach($taglogs as $key=>$value){
echo <<<EOT
?>
	<li><a href="index.php?action=showlog&gid={$value['gid']}">{$value['title']}</a> {$value['date']}</li>
<?php
EOT;
}echo <<<EOT
?>
	</ul>
</div>
<?php
EOT;
include getViews('footer');
?>
