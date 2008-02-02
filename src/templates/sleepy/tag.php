<!--<?php 
if(!defined('EMLOG_ROOT')) {exit('error!');}
//include getViews('side');
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
<h2><b>标签</b></h2>
<div class="entry">
<p><small>所有标签：（标签字体越大其包含的日志越多）</small></p>
<p>
<!--
EOT;
foreach($tags as $key=>$value){
echo <<<EOT
-->
<span style="font-size:$value[fontsize]px; 	line-height:1.5; height:30px;"><a href="?action=taglog&tag=$value[tagurl]">$value[tag]</a></span>&nbsp;
<!--
EOT;
}echo <<<EOT
-->
$tagmsg
</p>
</div>
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