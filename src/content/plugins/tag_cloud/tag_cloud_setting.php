<?php
if(!defined('EMLOG_ROOT')) {exit('error!');}
function plugin_setting_view(){
	include_once(EMLOG_ROOT.'/content/plugins/tag_cloud/tag_cloud_config.php');
?>
<script>$("#tag_cloud").addClass('sidebarsubmenu1');</script>
<div class=containertitle><b><?php echo tag_cloud_tname;?>设置</b>
<?php if(isset($_GET['setting'])):?><span class="actived"><?php echo tag_cloud_tname;?>设置成功</span><?php endif;?>
</div>
<?php if(tag_cloud_firstset==TRUE):?>

<div class=line></div>
<a>系统检测发现你是第一次使用3D标签云，你需要点击下面的按钮来进行初始化以创建所有标签</a>
<br/><br/>
<div>
<form id="form1" name="form1" method="post" action="plugin.php?plugin=tag_cloud&action=setting&inittagcloud=1">
<input align="center" type="submit" name="sumbit" value="创建所有标签" />
</form>
</div>
<?php else:;?>
<div class=line></div>
本插件配合Widgets使用。你在安装本插件后，3D标签云会默认放置在侧边栏底部。如想自由更改位置，请在后台的Widgets里面更改。如想不使用本插件，可以在Widgets里面移除（不是删除），同时最好在插件里面禁用本插件。
<div class=line></div>
<div>
<form id="form1" name="form1" method="post" action="plugin.php?plugin=tag_cloud&action=setting&changeinfo=1">
<table width="800" border="0" cellspacing="0" cellpadding="0">
<tr>
<td width="150"><span>宽度</span></td>
<td width="800"><input name="tag_cloud_width" type="text" id="width" style="width:180px;" value="<?php echo tag_cloud_width;?>"/>Flash宽</td></tr><tr>
<td width="150"><span>高度</span></td>
<td width="800"><input name="tag_cloud_height" type="text" id="height" style="width:180px;" value="<?php echo tag_cloud_height;?>"/>Flash高</td></tr><tr>
<td width="150"><span>渐变颜色</span></td>
<td width="800"><input name="tag_cloud_tcolor" type="text" id="tcolor" style="width:180px;" value="<?php echo tag_cloud_tcolor;?>"/>标签的渐变颜色（如0xbd1016，不要填#bd1016或者bd1016)</td></tr><tr>
<td width="150"><span>标签基本颜色</span></td>
<td width="800"><input name="tag_cloud_tcolor2" type="text" id="tcolor2" style="width:180px;" value="<?php echo tag_cloud_tcolor2;?>"/>标签的基本颜色（如0x808080，不要填#808080或者808080)</td></tr><tr>
<td width="150"><span>鼠标经过颜色</span></td>
<td width="800"><input name="tag_cloud_hicolor" type="text" id="hicolor" style="width:180px;" value="<?php echo tag_cloud_hicolor;?>"/>标签的基本颜色（如0x0065ff，不要填#0065ff或者0065ff)</td></tr><tr>
<td width="150"><span>背景颜色</span></td>
<td width="800"><input name="tag_cloud_bgcolor" type="text" id="bgcolor" style="width:180px;" value="<?php echo tag_cloud_bgcolor;?>"/>你要设置的单个标签背景色（如#f3f3f3，不要填f3f3f3或者0xf3f3f3)</td></tr><tr>
<td width="150"><span>滚动速度</span></td>
<td width="800"><input name="tag_cloud_tspeed" type="text" id="tspeed" style="width:180px;" value="<?php echo tag_cloud_tspeed;?>"/>指定一个标签滚动速度，默认为：100</td></tr><tr>
<td width="150"><span>透明模式</span></td>
<td width="800"><input name="tag_cloud_trans" type="text" id="trans" style="width:180px;" value="<?php echo tag_cloud_trans;?>"/>是否让背景透明（填transparent表示背景透明，不填或填其它字符则不透明）</td></tr><tr>
</tr>
<tr>
<td height="37">&nbsp;</td>
<td><input name="Input" type="submit" value="提交" /> <input name="Input" type="reset" value="取消" /></td>
</tr>
</table>
</form>
</div>
<div class=line></div>
<a>如果你不甚删除侧边栏widgets或者因为某种原因要更新所有标签，请点击下面的按钮</a>
<br/><br/>
<div>
<form id="form2" name="form2" method="post" action="plugin.php?plugin=tag_cloud&action=setting&inittagcloud=1">
<input align="center" type="submit" name="sumbit" value="更新" />
</form>
</div>
<?php endif;?>
<?php
}
function plugin_setting()
{
	if(isset($_GET['inittagcloud']))//更新xml
	{
		global $DB,$CACHE,$options_cache,$isurlrewrite;
		tag_cloud_update();
		//写入widgest
		$custom_widget = $options_cache['custom_widget'] ? @unserialize($options_cache['custom_widget']) : array();
		$tag_cloud_widgets_content = '<script type="text/javascript" src="'.BLOG_URL.'index.php?tag_cloud_widgets"></script>';
		if(is_array($custom_widget))
		{
			if(!in_array('custom_wg_tag_cloud',array_keys($custom_widget)))//如果没有标签云widgets，则添加
			{
				//添加
				$custom_wg_index = 'custom_wg_tag_cloud';
				$custom_widget[$custom_wg_index] = array('title'=>"标签云",'content'=>$tag_cloud_widgets_content);
				$custom_widget_str = addslashes(serialize($custom_widget));
				$DB->query("update ".DB_PREFIX."options set option_value='$custom_widget_str' where option_name='custom_widget'");
				//启用
				$widgets = !empty($options_cache['widgets1']) ? unserialize($options_cache['widgets1']) : array();
				$widgets[] = "custom_wg_tag_cloud";
				$widgets = serialize($widgets);
				$DB->query("update ".DB_PREFIX."options set option_value='$widgets' where option_name='widgets1'");
				$CACHE->updateCache('options');
			}
		}
		if(tag_cloud_first == TRUE)
		{
			$tag_cloud_fp = @fopen(EMLOG_ROOT.'/content/plugins/tag_cloud/tag_cloud_config.php','r');
			$tag_cloud_config = @fread($tag_cloud_fp,filesize(EMLOG_ROOT.'/content/plugins/tag_cloud/tag_cloud_config.php'));
			fclose($tag_cloud_fp);
			$tag_cloud_patt = array("/define\('tag_cloud_firstset',(.*)\)/",);
			$tag_cloud_replace = array("define('tag_cloud_firstset','')",);
			$tag_cloud_new_config = preg_replace($tag_cloud_patt, $tag_cloud_replace, $tag_cloud_config);
			$tag_cloud_fp = fopen(EMLOG_ROOT.'/content/plugins/tag_cloud/tag_cloud_config.php','w');
			if(!@fwrite($tag_cloud_fp,$tag_cloud_new_config))
			{
				emMsg('更新文件/content/plugins/tag_cloud/tagcloud.xml失败，请检查权限');
			}
			fclose($tag_cloud_fp);
		}
	}
	if(isset($_GET['changeinfo']))
	{
	    $tag_cloud_fp = fopen(EMLOG_ROOT.'/content/plugins/tag_cloud/tag_cloud_config.php','r');
		$tag_cloud_config = fread($tag_cloud_fp,filesize(EMLOG_ROOT.'/content/plugins/tag_cloud/tag_cloud_config.php'));
		fclose($tag_cloud_fp);  
		$tag_cloud_width = htmlspecialchars($_POST['tag_cloud_width'], ENT_QUOTES);
		$tag_cloud_height = htmlspecialchars($_POST['tag_cloud_height'], ENT_QUOTES);
		$tag_cloud_tcolor = htmlspecialchars($_POST['tag_cloud_tcolor'], ENT_QUOTES);
		$tag_cloud_tcolor2 = htmlspecialchars($_POST['tag_cloud_tcolor2'], ENT_QUOTES);
		$tag_cloud_hicolor = htmlspecialchars($_POST['tag_cloud_hicolor'], ENT_QUOTES);
		$tag_cloud_bgcolor = htmlspecialchars($_POST['tag_cloud_bgcolor'], ENT_QUOTES);
		$tag_cloud_trans = htmlspecialchars($_POST['tag_cloud_trans'], ENT_QUOTES);
		$tag_cloud_tspeed = htmlspecialchars($_POST['tag_cloud_tspeed'], ENT_QUOTES);
		$tag_cloud_patt = array(
							  "/define\('tag_cloud_width',(.*)\)/",
							  "/define\('tag_cloud_height',(.*)\)/",
							  "/define\('tag_cloud_tcolor',(.*)\)/",
							  "/define\('tag_cloud_tcolor2',(.*)\)/",
							  "/define\('tag_cloud_hicolor',(.*)\)/",
							  "/define\('tag_cloud_bgcolor',(.*)\)/",
							  "/define\('tag_cloud_trans',(.*)\)/",
							  "/define\('tag_cloud_tspeed',(.*)\)/",
	                                                   );
		$tag_cloud_replace = array(
								 "define('tag_cloud_width','".$tag_cloud_width."')",
								 "define('tag_cloud_height','".$tag_cloud_height."')",
								 "define('tag_cloud_tcolor','".$tag_cloud_tcolor."')",
								 "define('tag_cloud_tcolor2','".$tag_cloud_tcolor2."')",
								 "define('tag_cloud_hicolor','".$tag_cloud_hicolor."')",
								 "define('tag_cloud_bgcolor','".$tag_cloud_bgcolor."')",
								 "define('tag_cloud_trans','".$tag_cloud_trans."')",
								 "define('tag_cloud_tspeed','".$tag_cloud_tspeed."')",
								                                      );
		$tag_cloud_new_config = preg_replace($tag_cloud_patt, $tag_cloud_replace, $tag_cloud_config);
		$tag_cloud_fp = fopen(EMLOG_ROOT.'/content/plugins/tag_cloud/tag_cloud_config.php','w');
		fwrite($tag_cloud_fp,$tag_cloud_new_config);
		fclose($tag_cloud_fp);
	}
}
?>

