<?php 
/**
 * Feeds Gatherer
 * @copyright (c) Emlog All Rights Reserved
 */
!defined('EMLOG_ROOT') && exit('access deined!');
function plugin_setting_view()
{
	global $feeds_gatherer_data;
	$emLink = new Link_Model();
	$act = isset($_GET['act']) ? addslashes($_GET['act']) : '';
?>
<div class=containertitle><b>Feeds Gatherer设置</b>
<?php if(isset($_GET['setting'])):?>
<?php if(isset($_GET['inited'])): ?><span class="actived">初始化完成</span>
<?php else: ?><span class="actived">插件设置完成</span><?php endif;?>
<?php endif;?>
</div>
<div class=line></div>
<?php if($act == 'init'): ?>
<?php if($feeds_gatherer_data['inited'] == 0):?>
<div style="margin:20px 0px 0px 0px;">
<form action="plugin.php?plugin=feeds_gatherer&action=setting&act=init" method="post">
<input name="submit" type="submit" value="初始化Feeds Gatherer" class="submit" />
</form>
</div>
<?php else: ?>
<?php header("Location: ./plugin.php?plugin=feeds_gatherer"); ?>
<?php endif; ?>
<?php endif; ?>
<?php if($act == ''): 
	$links = $emLink->getLinks();
	$feeds_gatherer_rss = $feeds_gatherer_data['rss'];
?>
<div class="filters">
<span class="filter"><a href="../?plugin=feeds_gatherer" target="_blank">前台查看</a></span>
</div>
  <table width="100%" id="adm_link_list" class="item_list">
    <thead>
      <tr>
    	<th width="40"><b>更新</b></th>
        <th width="180"><b>链接</b></th>
		<th width="30" class="tdcenter"><b>查看</b></th>
		<th width="380"><b>描述</b></th>
		<th width="130"><b>RSS地址</b></th>
      </tr>
    </thead>
    <tbody>
	<?php
		foreach($links as $key=>$value):
		if(!isset($feeds_gatherer_rss[$value['id']]))
			$feeds_gatherer_rss[$value['id']] = feeds_gatherer_add($value['id'],$value['siteurl']);
	?>
      <tr>
        <td>
        <form action="plugin.php?plugin=feeds_gatherer&action=setting&act=update&id=<?php echo $value['id']; ?>" method="post">
		<input name="submit" type="submit" value="更新" class="submit" />
		</form>
		</td>
		<td><a href="plugin.php?plugin=feeds_gatherer&act=mod&id=<?php echo $value['id']; ?>"><?php echo $value['sitename']; ?></a></td>
		<td class="tdcenter">
	  	<a href="<?php echo $value['siteurl']; ?>" target="_blank" title="查看链接">
	  	<img src="./views/images/vlog.gif" align="absbottom" border="0" /></a>
	  	</td>
        <td><?php echo $value['description']; ?></td>
    	<td><?php echo $feeds_gatherer_rss[$value['id']]; ?></td>
      </tr>
	<?php endforeach; ?>
    </tbody>
  </table>
<div style="margin:20px 0px 0px 0px;">
<form action="plugin.php?plugin=feeds_gatherer&action=setting&act=update1" method="post">
<li>更新频率：<input name="freq" size="10" value="<?php echo $feeds_gatherer_data['freq']; ?>" />（秒）</li>
<li>每次更新个数：<input name="num" size="10" value="<?php echo $feeds_gatherer_data['num']; ?>" /></li>
<li>侧边栏友链数：<input name="sidenum" size="10" value="<?php echo $feeds_gatherer_data['sidenum']; ?>" />（留空为不限制）</li>
<li><input name="submit" type="submit" value="保存设置" class="submit" /></li>
</form>
<form action="plugin.php?plugin=feeds_gatherer&action=setting&act=update2" method="post">
<li><input name="submit" type="submit" value="更新所有友链" class="submit" /></li>
</form>
</div>
<?php endif; ?>
<?php if($act == 'mod'):
	$linkId = isset($_GET['id']) ? intval($_GET['id']) : '';
	$linkData = $emLink->getOneLink($linkId);
	extract($linkData);
?>
<form action="plugin.php?plugin=feeds_gatherer&action=setting&act=mod&id=<?php echo $linkId;?>" method="post">
<div>
	<li>名称：<?php echo $sitename; ?></li>
	<li>地址：<a href="<?php echo $siteurl; ?>" target="_blank"><?php echo $siteurl; ?></a></li>
	<li>描述：<?php echo $description; ?></li>
	<li>RSS：<input value="<?php echo $feeds_gatherer_data['rss'][$linkId]; ?>" name="rssurl" size="30"/></li>
	<li>
	<input type="submit" value="保 存" class="submit" />
	<input type="button" value="取 消" class="submit" onclick="javascript: window.history.back();"/></li>
</div>
</form>
<?php endif; ?>
<script>
$("#feeds_gatherer").addClass('sidebarsubmenu1');
</script>
<?php
}
function plugin_setting()
{
	$act = isset($_GET['act']) ? addslashes($_GET['act']) : '';
	if($act == 'init')
	{
		global $DB;
		require_once(EMLOG_ROOT.'/model/class.link.php');
		$emLink = new emLink($DB);
		$links = $emLink->getLinks();
		$feeds_gatherer_rss = array();
		foreach($links as $value)
		{
			if(substr($value['siteurl'],-1) != '/')
				$value['siteurl'] .= '/';
			$feeds_gatherer_rss[$value['id']] = $value['siteurl'].'rss.php';
		}
		$feeds_gatherer_data['inited'] = 1;
		$feeds_gatherer_data['rss'] = $feeds_gatherer_rss;
		$feeds_gatherer_data['time'] = time();
		$feeds_gatherer_data['freq'] = 600;
		$feeds_gatherer_data['num'] = 3;
		$feeds_gatherer_data['sidenum'] = 3;
		$feeds_gatherer_data['task'] = array_keys($feeds_gatherer_rss);
		$feeds_gatherer_file = EMLOG_ROOT.'/content/plugins/feeds_gatherer/data';
		@$feeds_gatherer_fp = fopen($feeds_gatherer_file, 'w') OR emMsg('读取文件失败，如果您使用的是Unix/Linux主机，请修改文件/content/plugins/feeds_gatherer/data的权限为777。如果您使用的是Windows主机，请联系管理员，将该文件设为everyone可写');
		@fwrite($feeds_gatherer_fp,serialize($feeds_gatherer_data)) OR emMsg('写入文件失败，如果您使用的是Unix/Linux主机，请修改文件/content/plugins/feeds_gatherer/data的权限为777。如果您使用的是Windows主机，请联系管理员，将该文件设为everyone可写');
		feeds_gatherer_update(array_keys($feeds_gatherer_rss));
	}
	if($act == 'mod')
	{
		$id = isset($_GET['id']) ? intval($_GET['id']) : '';
		$rssurl = isset($_POST['rssurl']) ? addslashes(trim($_POST['rssurl'])) : '';
		if($id)
		{
			global $feeds_gatherer_data;
			$feeds_gatherer_data['rss'][$id] = $rssurl;
			$feeds_gatherer_file = EMLOG_ROOT.'/content/plugins/feeds_gatherer/data';
			@$feeds_gatherer_fp = fopen($feeds_gatherer_file, 'w') OR emMsg('读取文件失败，如果您使用的是Unix/Linux主机，请修改文件/content/plugins/feeds_gatherer/data的权限为777。如果您使用的是Windows主机，请联系管理员，将该文件设为everyone可写');
			@fwrite($feeds_gatherer_fp,serialize($feeds_gatherer_data)) OR emMsg('写入文件失败，如果您使用的是Unix/Linux主机，请修改文件/content/plugins/feeds_gatherer/data的权限为777。如果您使用的是Windows主机，请联系管理员，将该文件设为everyone可写');
			feeds_gatherer_update(array($id));
		}
	}
	if($act == 'update')
	{
		$id = isset($_GET['id']) ? intval($_GET['id']) : '';
		if($id)
		{
			feeds_gatherer_update(array($id));
		}
	}
	if($act == 'update1')
	{
		global $feeds_gatherer_data;
		$freq = isset($_POST['freq']) ? intval($_POST['freq']) : 600;
		$num = isset($_POST['num']) ? intval($_POST['num']) : 3;
		$sidenum = isset($_POST['num']) ? intval($_POST['sidenum']) : 0;
		$feeds_gatherer_data['freq'] = $freq;
		$feeds_gatherer_data['num'] = $num;
		$feeds_gatherer_data['sidenum'] = $sidenum;
		$feeds_gatherer_file = EMLOG_ROOT.'/content/plugins/feeds_gatherer/data';
		@$feeds_gatherer_fp = fopen($feeds_gatherer_file, 'w') OR emMsg('读取文件失败，如果您使用的是Unix/Linux主机，请修改文件/content/plugins/feeds_gatherer/data的权限为777。如果您使用的是Windows主机，请联系管理员，将该文件设为everyone可写');
		@fwrite($feeds_gatherer_fp,serialize($feeds_gatherer_data)) OR emMsg('写入文件失败，如果您使用的是Unix/Linux主机，请修改文件/content/plugins/feeds_gatherer/data的权限为777。如果您使用的是Windows主机，请联系管理员，将该文件设为everyone可写');
	}
	if($act == 'update2')
	{
		global $feeds_gatherer_data;
		$ids = array_keys($feeds_gatherer_data['rss']);
		feeds_gatherer_update($ids);
	}
}
?>
