<?php
if(!defined('EMLOG_ROOT')) {exit('error!');}
function plugin_setting_view(){
?>
<script>
$("#wbto").addClass('sidebarsubmenu1');
</script>
<style>
    #wbto_form {margin:20px 5px;}
    #wbto_form li{padding:5px;}
    #wbto_form li input{padding:2px; width:180px; height:20px;}
    #wbto_form p input{padding:2px; width:80px; height:30px;}
    #wbto_form p span{margin-left:30px;}
</style>
<div class=containertitle><img src="../content/plugins/wbto/t.png"> <b>Wbto插件</b>
<?php if(isset($_GET['setting'])):?><span class="actived">插件设置完成</span><?php endif;?>
<?php if(isset($_GET['error'])):?><span class="error">保存失败，配置文件不可写</span><?php endif;?>
</div>
<div class=line></div>
<div class="des">Wbto插件基于Wbto开放API，可以将在emlog内发布的碎语、日志同步到你所指定的Wbto账号，省去手动同步成本。
<br /><br />提示：请确保本插件目录下wbto_profile.php文件据有写权限（777）。</div>
<form id="form1" name="form1" method="post" action="plugin.php?plugin=wbto&action=setting">
<div id="wbto_form">
<li>Wbto账号：<input name="user" type="text" id="user" value="<?php echo WBTO_USER_NAME;?>" /> </li>
<li>Wbto密码：<input type="password" name="pwd" id="pwd" value="<?php echo WBTO_USER_PASSWD;?>" /></li>
<li>内容同步方案：
        <select name="sync">
        <?php 
        $ex1 = $ex2 = $ex3 = '';
        $sync = 'ex' . WBTO_SYNC;
        $$sync = 'selected="selected"';
        ?>
          <option value="1" <?php echo $ex1; ?>>碎语和日志</option>
          <option value="2" <?php echo $ex2; ?>>仅碎语</option>
          <option value="3" <?php echo $ex3; ?>>仅日志</option>
        </select>
</li>
<li>碎语内容追加来源博客：
            <select name="tfrom">
        <?php 
        $ex4 = $ex5 = '';
        $tfrom = 'ex' . WBTO_TFROM;
        $$tfrom = 'selected="selected"';
        ?>
          <option value="4" <?php echo $ex4; ?>>是</option>
          <option value="5" <?php echo $ex5; ?>>否</option>
        </select>
</li>
<p><input name="input" type="submit" value="保存设置" /> <span><a href="http://www.wbto.cn" target="_blank">访问Wbto&raquo;</a></span></p>
</div>
</form>
<?php
}

function plugin_setting(){
    $profile = EMLOG_ROOT.'/content/plugins/wbto/wbto_profile.php';

	$wbto_user = htmlspecialchars($_POST['user'], ENT_QUOTES);
	$wbto_pwd = htmlspecialchars($_POST['pwd'], ENT_QUOTES);
	$wbto_sync = htmlspecialchars($_POST['sync'], ENT_QUOTES);
	$wbto_tfrom = htmlspecialchars($_POST['tfrom'], ENT_QUOTES);

	$wbto_new_profile = "<?php\ndefine('WBTO_USER_NAME','$wbto_user');\ndefine('WBTO_USER_PASSWD','$wbto_pwd');\ndefine('WBTO_SYNC','$wbto_sync');\ndefine('WBTO_TFROM','$wbto_tfrom');\n";

	$fp = @fopen($profile,'wb');
	if(!$fp) {
	    return false;
	}
	fwrite($fp,$wbto_new_profile);
	fclose($fp);
}
?>