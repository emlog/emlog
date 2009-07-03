<?php if(!defined('EMLOG_ROOT')) {exit('error!');} ?>
<div id="sidebarA" class="sidebar">
	<ul>
			<li><h2>Search</h2>
				<ul>
					<li>
					<form method="get" id="searchform" name="keyform" action="./">
					<input type="text" name="keyword" id="s" />
					<input type="submit" id="searchsubmit" value="Search" onclick="return keyw()" />
					</form>
					</li>
				</ul>
			</li>
	</ul>
</div>
