<!--<?php 
if(!defined('EMLOG_ROOT')) {exit('error!');}
print <<<EOT
-->
<div class="narrowcolumn">

		<div class="top-menu">
		<ul>
			<li><h1><a href="./"><strong>$blogname</strong></a></h1> <br />$blog_info</li>
		</ul>
	</div>

	<div id="banner">&#160;</div>

	
	<div class="post">
	<h2><b>$tag</b></h2>
	<div class="entry">
<!--
EOT;
foreach($taglogs as $key=>$value){
print <<<EOT
-->
	<p><a href="index.php?action=showlog&gid=$value[gid]">$value[title]</a> <small>$value[date]</small></p>
<!--
EOT;
}print <<<EOT
-->
</div>
<!--
EOT;
print <<<EOT
-->
</div>
</div>
EOT;
include getViews('side');
include getViews('footer');
?>
