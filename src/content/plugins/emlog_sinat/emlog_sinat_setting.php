<?php
if(!defined('EMLOG_ROOT')) {exit('error!');}

session_start();
include_once( 'emlog_sinat_config.php' );
include_once( 'weibooauth.php' );

if (!file_exists(EMLOG_ROOT.'/content/plugins/emlog_sinat/emlog_sinat_token_conf.php'))
{
	if (isset($_GET['oauth_token'])) //callback
	{
		$o = new WeiboOAuth( WB_AKEY , WB_SKEY , $_SESSION['keys']['oauth_token'] , $_SESSION['keys']['oauth_token_secret']  );
	
		$last_key = $o->getAccessToken(  $_REQUEST['oauth_verifier'] ) ;
		save_access_token($last_key['oauth_token'], $last_key['oauth_token_secret'], $last_key['user_id']);
		include_once( 'emlog_sinat_token_conf.php' );
	} 
	else //get request token
	{
		$o = new WeiboOAuth( WB_AKEY , WB_SKEY  );
		$keys = $o->getRequestToken();
		$aurl = $o->getAuthorizeURL( $keys['oauth_token'] ,false , BLOG_URL.'admin/plugin.php?plugin=emlog_sinat');
		$_SESSION['keys'] = $keys;
	}
} 
else //auth done
{
	include_once( 'emlog_sinat_token_conf.php' );
}

function plugin_setting_view(){
	global $aurl;
?>
<script>
$("#emlog_sinat").addClass('sidebarsubmenu1');
</script>
<style>
    #sinat_form {margin:20px 5px;}
    #sinat_form li{padding:5px;}
    #sinat_form li input{padding:2px; width:180px; height:20px;}
    #sinat_form p input{padding:2px; width:80px; height:30px;}
    #sinat_form p span{margin-left:30px;}
</style>
<div class=containertitle><img src="../content/plugins/emlog_sinat/t.png"> <b>新浪微博插件</b>
<?php if(isset($_GET['setting'])):?><span class="actived">插件设置完成</span><?php endif;?>
<?php if(isset($_GET['error'])):?><span class="error">保存失败，配置文件不可写</span><?php endif;?>
</div>
<div class=line></div>
<div class="des">新浪微博插件基于sina微博API，可以将emlog内发布的碎语、日志自动同步到你所指定的sina微博账号，无需你手动操作。
<br /><br />提示：请确保本插件目录及emlog_sinat_profile.php文件据有写权限（777）。</div>
<div id="sinat_form">

<?php 
$a = defined('SINAT_ACCESS_TOKEN');
if (!isset($_GET['oauth_token']) && !defined('SINAT_ACCESS_TOKEN')): ?>
	<li><a href="<?php echo $aurl ?>"><img src="../content/plugins/emlog_sinat/t-login.png"></a></li>
<?php else:?>
<?php
	$c = new WeiboClient( WB_AKEY , WB_SKEY , SINAT_ACCESS_TOKEN , SINAT_ACCESS_SECRET  );
	$ms  = $c->show_user(SINAT_UID);
?>
	<li><img src="<?php echo $ms['profile_image_url']?>" style="border:2px #CCCCCC solid;"/></li>
	<li><b><?php echo $ms['name']?></b> (当前新浪微博账号， <a href="./plugin.php?plugin=emlog_sinat&do=chg">更换账号</a>，更换账户
	时请先退出当前浏览器中新浪微博(weibo.com)的登录状态)</li>
<?php endif;?>

</div>
<form id="form1" name="form1" method="post" action="plugin.php?plugin=emlog_sinat&action=setting">
<div id="sinat_form">
<li>内容同步方案：
        <select name="sync">
        <?php 
        $ex1 = $ex2 = $ex3 = '';
        $sync = 'ex' . SINAT_SYNC;
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
        $tfrom = 'ex' . SINAT_TFROM;
        $$tfrom = 'selected="selected"';
        ?>
          <option value="4" <?php echo $ex4; ?>>是</option>
          <option value="5" <?php echo $ex5; ?>>否</option>
        </select>
</li>
<p><input name="input" type="submit" value="保存设置" /> <span><a href="http://t.sina.com" target="_blank">访问新浪微博&raquo;</a></span></p>
</div>
</form>
<?php
}

function save_access_token($token, $secret, $uid){
    $profile = EMLOG_ROOT.'/content/plugins/emlog_sinat/emlog_sinat_token_conf.php';

	$sinat_new_profile = "<?php\ndefine('SINAT_ACCESS_TOKEN','$token');\ndefine('SINAT_ACCESS_SECRET','$secret');\ndefine('SINAT_UID','$uid');\n";

	$fp = @fopen($profile,'wb');
	if(!$fp) {
	    emMsg('操作失败，请确保插件目录(/content/plugins/emlog_sinat/)可写');
	}
	fwrite($fp,$sinat_new_profile);
	fclose($fp);
}

function plugin_setting(){
    $profile = EMLOG_ROOT.'/content/plugins/emlog_sinat/emlog_sinat_profile.php';

	$sinat_sync = htmlspecialchars($_POST['sync'], ENT_QUOTES);
	$sinat_tfrom = htmlspecialchars($_POST['tfrom'], ENT_QUOTES);

	$sinat_new_profile = "<?php\ndefine('SINAT_SYNC','$sinat_sync');\ndefine('SINAT_TFROM','$sinat_tfrom');\n";

	$fp = @fopen($profile,'wb');
	if(!$fp) {
	    return false;
	}
	fwrite($fp,$sinat_new_profile);
	fclose($fp);
}
?>