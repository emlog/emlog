<?php
if(!defined('EMLOG_ROOT')) {exit('error!');}
function plugin_setting_view(){
?>
<script>
$("#emlog2f5").addClass('sidebarsubmenu1');
</script>
<style>
    #follow5_form {margin:20px 5px;}
    #follow5_form li{padding:5px;}
    #follow5_form li input{padding:2px; width:180px; height:20px;}
    #follow5_form p input{padding:2px; width:80px; height:30px;}
    #follow5_form p span{margin-left:30px;}
</style>
<div class=containertitle><img src="../content/plugins/emlog2f5/t.png"> <b>Follow5插件</b>
<?php if(isset($_GET['setting'])):?><span class="actived">插件设置完成</span><?php endif;?>
<?php if(isset($_GET['error'])):?><span class="error">保存失败，配置文件不可写</span><?php endif;?>
</div>
<div class=line></div>
<div class="des">Follow5插件基于Follow5开放API，可以将在emlog内发布的碎语、日志同步到你所指定的Follow5账号，省去手动同步成本。
<br /><br />提示：请确保本插件目录下emlog2f5_profile.php文件据有写权限（777）。</div>
<form id="form1" name="form1" method="post" action="plugin.php?plugin=emlog2f5&action=setting">
<div id="follow5_form">
<li>Follow5账号：<input name="user" type="text" id="user" value="<?php echo FOLLOW5_USER_NAME;?>" /> </li>
<li>Follow5密码：<input type="password" name="pwd" id="pwd" value="<?php echo FOLLOW5_USER_PASSWD;?>" /></li>
<li>内容同步方案：
        <select name="sync">
        <?php 
        $ex1 = $ex2 = $ex3 = '';
        $sync = 'ex' . FOLLOW5_SYNC;
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
        $tfrom = 'ex' . FOLLOW5_TFROM;
        $$tfrom = 'selected="selected"';
        ?>
          <option value="4" <?php echo $ex4; ?>>是</option>
          <option value="5" <?php echo $ex5; ?>>否</option>
        </select>
</li>
<p><input name="input" type="submit" value="保存设置" /> <span><a href="http://www.follow5.com" target="_blank">访问Follow5&raquo;</a></span></p>
</div>
</form>
<?php
}

function plugin_setting(){
    $profile = EMLOG_ROOT.'/content/plugins/emlog2f5/emlog2f5_profile.php';

	$follow5_user = htmlspecialchars($_POST['user'], ENT_QUOTES);
	$follow5_pwd = htmlspecialchars($_POST['pwd'], ENT_QUOTES);
	$follow5_sync = htmlspecialchars($_POST['sync'], ENT_QUOTES);
	$follow5_tfrom = htmlspecialchars($_POST['tfrom'], ENT_QUOTES);

	$follow5_new_profile = "<?php\ndefine('FOLLOW5_USER_NAME','$follow5_user');\ndefine('FOLLOW5_USER_PASSWD','$follow5_pwd');\ndefine('FOLLOW5_SYNC','$follow5_sync');\ndefine('FOLLOW5_TFROM','$follow5_tfrom');\n";

	$fp = @fopen($profile,'wb');
	if(!$fp) {
	    return false;
	}
	fwrite($fp,$follow5_new_profile);
	fclose($fp);
}
?>