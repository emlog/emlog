<?php if(!defined('EMLOG_ROOT')) {exit('error!');} ?>
		<ul id="navigation">
			<?php foreach ($navibar as $key => $val):
			if ($val['hide'] == 'y'){continue;}
			if (empty($val['url'])){$val['url'] = './?post='.$key;}
			?>
			<li><a href="<?php echo $val['url']; ?>" target="<?php echo $val['is_blank']; ?>"><?php echo $val['title']; ?></a></li>
			<?php endforeach;?>
			<?php doAction('navbar', '<li>', '</li>'); ?>
		</ul>
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
