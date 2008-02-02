<!--<?php 
if(!defined('EMLOG_ROOT')) {exit('error!');}
echo <<<EOT
-->
<div class="narrowcolumn">

		<div class="top-menu">
		<ul>
			<li><h1><a href="./"><strong>$blogname</strong></a></h1> <br />($blog_info)</li>
		</ul>
	</div>

	<div id="banner">&#160;</div>

	
	<div class="post">
<h2>$search_info</h2>
	<div class="entry">
<!--
EOT;
foreach($slog as $key=>$value){
echo <<<EOT
-->
<p><a href="?action=showlog&gid=$value[gid]">$value[title]</a> ($value[date])</p>
<!--
EOT;
}echo <<<EOT
-->	
</div>
</div>
</div>
EOT;
include getViews('side');
include getViews('footer');
?>