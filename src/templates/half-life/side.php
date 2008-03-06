<!--<?php 
if(!defined('EMLOG_ROOT')) {exit('error!');}
echo <<<EOT
-->	
		<div class="sidebar">
<ul>


<li><h2>日历</h2>
		<ul>
			<li id="calendar"></li>
		</ul>
</li>

<li><h2>标签</h2>
		<ul>
		<li>
<!--
EOT;
foreach($tag_cache as $value){
echo <<<EOT
-->
<span style="font-size:$value[fontsize]px; height:30px;"><a href="./?action=taglog&tag=$value[tagurl]">$value[tagname]</a></span>&nbsp;
<!--
EOT;
}echo <<<EOT
-->
		<a href="./index.php?action=tag" title="更多标签" >&gt;&gt;</a>
		</li>
		</ul>
</li>

<li><h2>Blogroll</h2>
		<ul>
<!--
EOT;
foreach($link_cache as $value){
echo <<<EOT
-->     	
		<li><a href="$value[url]" title="$value[des]" target="_blank">$value[link]</a></li>
<!--
EOT;
}echo <<<EOT
-->	
		</ul>
</li>
	
</ul>
		</div>
<!--
EOT;
?>-->