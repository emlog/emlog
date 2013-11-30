<?php
/**
 * sendmail插件
 * design by KLLER
 */

!defined('EMLOG_ROOT') && exit('access deined!');

function plugin_setting_view()
{
	include(EMLOG_ROOT.'/content/plugins/kl_sendmail/kl_sendmail_config.php');
?>
<script type="text/javascript">
jQuery.fn.onlyPressNum = function(){$(this).css('ime-mode','disabled');$(this).css('-moz-user-select','none');$(this).bind('keydown',function(event){var k=event.keyCode;if(!((k==13)||(k==9)||(k==35)||(k == 36)||(k==8)||(k==46)||(k>=48&&k<=57)||(k>=96&&k<=105)||(k>=37&&k<=40))){event.preventDefault();}})}
jQuery(function($){
	$('#port').onlyPressNum();
	$('#testsend').click(function(){$('#testresult').html('邮件发送中..');$.get('../content/plugins/kl_sendmail/kl_sendmail_test_do.php',{sid:Math.random()},function(result){if($.trim(result)!=''){$('#testresult').html(result);}else{$('#testresult').html('发送失败！');}});});
	$("#kl_sendmail").addClass('sidebarsubmenu1');
});
setTimeout(hideActived,2600);
</script>
<style type="text/css">
.table_b { float:left;border-collapse: collapse;border-style: none; border:1px solid #ccc; width:100%;}
.table_b td { border:1px solid #e0e0e0; padding:2px 5px; line-height:22px; }
</style>
<div class=containertitle><b>Sendmail</b>
<?php if(isset($_GET['setting'])):?><span class="actived">插件设置完成</span><?php endif;?>
</div>
<div class=line></div>
<div>
	<form id="form1" name="form1" method="post" action="plugin.php?plugin=kl_sendmail&action=setting">

  		  <table width="500" border="0" cellspacing="1" cellpadding="0" class="table_b">
            <tr>
              <td width="92" height="30"><span style="width:300px;">smtp服务器:</span></td>
              <td width="300"><input name="smtp" type="text" id="smtp" style="width:180px;" value="<?php echo KL_MAIL_SMTP;?>"/>
                如:smtp.163.com</td>
              <td rowspan="8">&nbsp;</td>
              <td><span style="width:300px;">测试发送:<font color="red">（请先在左边设置好相关信息<b>保存</b>后测试）</font></span></td>
            </tr>
            <tr>
              <td height="30"><span style="width:200px;">smtp端口:</span></td>
              <td><input name="port" type="text" id="port" style="ime-mode:disabled;width:180px;" value="<?php echo KL_MAIL_PORT;?>"/>
              一般默认为:25</td>
              <td><input id="testsend" type="button" value="发送一封测试邮件" /></td>
            </tr>
            <tr>
              <td height="30">发信邮箱:</td>
              <td><input name="sendemail" type="text" id="sendemail" style="width:180px;" value="<?php echo KL_MAIL_SENDEMAIL;?>"/></td>
              <td><span style="width:300px;">测试结果:</span></td>
            </tr>
            <tr>
              <td height="30">发信密码: </td>
              <td><input type="password" name="password" value="<?php echo KL_MAIL_PASSWORD;?>" style="width:180px;"/></td>
              <td rowspan="3"><div id="testresult" style="height:64px; padding:10px; border:1px dashed #ccc; overflow:auto;/*background-color:#bbd9e2;*/"></div></td>
            </tr>
            <tr>
              <td height="30">收信邮箱:</td>
              <td><input name="toemail" type="text" id="toemail" style="width:180px;" value="<?php echo KL_MAIL_TOEMAIL;?>"/></td>
            </tr>
            <tr>
              <td height="30">发送方式:</td>
              <td><label><input type="radio" name="sendtype" value="0" <?php if(KL_MAIL_SENDTYPE == 0) echo 'checked'; ?> />Mail方式</label> <label><input type="radio" name="sendtype" value="1" <?php if(KL_MAIL_SENDTYPE == 1) echo 'checked'; ?> />SMTP方式</label></td>
            </tr>
            <tr>
              <td valign="top" height="30">发送选项:</td>
              <td><label><input type="checkbox" name="issendmail" value="Y" <?php if(KL_IS_SEND_MAIL == 'Y') echo 'checked';?>/>收到评论时通知自己</label><br /><label><input type="checkbox" name="isreplymail" value="Y" <?php if(KL_IS_REPLY_MAIL == 'Y') echo 'checked';?>/>回复评论时通知评论者</label><br /><label><input type="checkbox" name="istwittermail" value="Y" <?php if(KL_IS_TWITTER_MAIL == 'Y') echo 'checked';?>/>收到碎语回复时通知自己</label></td>
              <td rowspan="2">
                <div style="padding:5px; height:86px; border:1px dashed #CCC">
				<font color="green"><b>温馨提示：</b></font>发送方式设置为SMTP方式时,发信邮箱必须支持smtp并且开启smtp服务才能发送成功。<br />
				相关参考资料： <a href="http://kller.cn/?post=77" target="_blank">关于邮箱开启smtp服务的方法</a>
				</div>
              </td>
            </tr>
            <tr>
              <td height="37">&nbsp;</td>
              <td><input name="Input" type="submit" value="保　存" /></td>
            </tr>
          </table>
	</form>
</div>
<?php
}

function plugin_setting()
{
	//修改配置信息
	$fso = fopen(EMLOG_ROOT.'/content/plugins/kl_sendmail/kl_sendmail_config.php','r'); //获取配置文件内容
	$config = fread($fso,filesize(EMLOG_ROOT.'/content/plugins/kl_sendmail/kl_sendmail_config.php'));
	fclose($fso);

	$smtp=htmlspecialchars($_POST['smtp'], ENT_QUOTES);
	$port=htmlspecialchars($_POST['port'], ENT_QUOTES);
	$sendemail=htmlspecialchars($_POST['sendemail'], ENT_QUOTES);
	$password=htmlspecialchars($_POST['password'], ENT_QUOTES);
	$toemail=htmlspecialchars($_POST['toemail'], ENT_QUOTES);
	$sendtype=intval($_POST['sendtype']);
	$issendmail = isset($_POST['issendmail']) ? 'Y' : '';
	$isreplymail = isset($_POST['isreplymail']) ? 'Y' : '';
	$istwittermail = isset($_POST['istwittermail']) ? 'Y' : '';

	$patt = array(
	"/define\('KL_MAIL_SMTP',(.*)\)/",
	"/define\('KL_MAIL_PORT',(.*)\)/",
	"/define\('KL_MAIL_SENDEMAIL',(.*)\)/",
	"/define\('KL_MAIL_PASSWORD',(.*)\)/",
	"/define\('KL_MAIL_TOEMAIL',(.*)\)/",
	"/define\('KL_MAIL_SENDTYPE',(.*)\)/",
	"/define\('KL_IS_SEND_MAIL',(.*)\)/",
	"/define\('KL_IS_REPLY_MAIL',(.*)\)/",
	"/define\('KL_IS_TWITTER_MAIL',(.*)\)/",
	);

	$replace = array(
	"define('KL_MAIL_SMTP','".$smtp."')",
	"define('KL_MAIL_PORT','".$port."')",
	"define('KL_MAIL_SENDEMAIL','".$sendemail."')",
	"define('KL_MAIL_PASSWORD','".$password."')",
	"define('KL_MAIL_TOEMAIL','".$toemail."')",
	"define('KL_MAIL_SENDTYPE','".$sendtype."')",
	"define('KL_IS_SEND_MAIL','".$issendmail."')",
	"define('KL_IS_REPLY_MAIL','".$isreplymail."')",
	"define('KL_IS_TWITTER_MAIL','".$istwittermail."')",
	);

	$new_config = preg_replace($patt, $replace, $config);
	$fso = fopen(EMLOG_ROOT.'/content/plugins/kl_sendmail/kl_sendmail_config.php','w'); //写入替换后的配置文件
	fwrite($fso,$new_config);
	fclose($fso);
}
?>