<?php
/*
Plugin Name: 文章自定义浏览量
Version: 1.1
Plugin URL: https://www.emlog.net/plugin/detail/439
Description: 自定义文章浏览量，简单粗暴。
Author: Richest
Author URL: https://www.emlog.net/plugin/detail/439
*/
!defined('EMLOG_ROOT') && exit('access deined!');

function richest_views(){ ?>
<?php 
$db = MySql::getInstance();
$type = isset($_GET['action']) ? addslashes(trim($_GET['action'])) : '';
$gid = isset($_GET['gid']) ? addslashes(trim($_GET['gid'])) : '';
if($type=='edit' AND isset($gid)):?>
<?php 
$sql = "SELECT `views` FROM `".DB_PREFIX."blog` WHERE `gid`=".$gid.";";
$result = $db->query($sql);
$views = $db->fetch_array($result);
?>
<label>自定义浏览量：</label><input class="form-control" name="views" id="views" type="text" value="<?php echo $views['views'];?>" placeholder="请输入自定义浏览数量...">
<?php else:?>
<label>自定义浏览量：</label><input class="form-control" name="views" id="views" type="text" value="0" placeholder="请输入浏览数量...">
<?php endif;?>
<?php }
addAction('adm_writelog_side', 'richest_views');
function richest_views_add($logid){
$views = isset($_POST['views']) ? addslashes(trim($_POST['views'])) : '';
$db = MySql::getInstance();
$db->query("UPDATE `".DB_PREFIX."blog` SET  `views` =  '".$views."' WHERE  `gid` = ".$logid.";");	
$sql = "UPDATE ".DB_PREFIX."blog set views = ceil(RAND()*".$i.") where gid=".$gid.";";
}
addAction('save_log','richest_views_add');

