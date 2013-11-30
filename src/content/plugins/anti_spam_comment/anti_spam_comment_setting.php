<?php 
/**
 * 反垃圾评论插件
 * @copyright (c) Emlog All Rights Reserved
 */
!defined('EMLOG_ROOT') && exit('access deined!');
function plugin_setting_view()
{
	$DB = MySql::getInstance();
?>
<div class="containertitle2">
<a class="navi<?php echo isset($_GET['advance']) ? 1 : 3;?>" href="./plugin.php?plugin=anti_spam_comment">基本设置</a>
<a class="navi<?php echo isset($_GET['advance']) ? 2 : 4;?>" href="./plugin.php?plugin=anti_spam_comment&advance=true">高级选项</a>
<?php if(isset($_GET['setting'])):?><span class="actived">插件设置完成</span><?php endif;?>
<?php if(isset($_GET['error'])):?><span class="actived">插件设置失败</span><?php endif;?>
</div>
<?php if(isset($_GET['advance'])) :?>
<?php
$act = isset($_GET['act']) ? trim($_GET['act']) : '';
if($act):
	global $CACHE;
	switch ($act) {
		case 'shieldname':
			$id = isset($_GET['id']) ? intval($_GET['id']) : '';
			$DB->query("UPDATE ".DB_PREFIX."comment SET poster='该昵称已屏蔽' WHERE cid={$id}");
			$CACHE->updateCache(array('sta','comment'));
			header("Location: ./plugin.php?plugin=anti_spam_comment&advance=true&setting=true");
			break;
		case 'delurl':
			$id = isset($_GET['id']) ? intval($_GET['id']) : '';
			$DB->query("UPDATE ".DB_PREFIX."comment SET url='' WHERE cid={$id}");
			$CACHE->updateCache(array('sta','comment'));
			header("Location: ./plugin.php?plugin=anti_spam_comment&advance=true&setting=true");
			break;
		case 'admin_all_coms':
			$operate = isset($_POST['operate']) ? $_POST['operate'] : '';
			$comments = isset($_POST['com']) ? array_map('intval', $_POST['com']) : array();
			$commentsId = '('.implode(',',$comments).')';
			switch ($operate) {
				case 'shieldname':
					$DB->query("UPDATE ".DB_PREFIX."comment SET poster='该昵称已屏蔽' WHERE cid IN{$commentsId}");
					$CACHE->updateCache(array('sta','comment'));
					header("Location: ./plugin.php?plugin=anti_spam_comment&advance=true&setting=true");
					break;
				case 'delurl':
					$DB->query("UPDATE ".DB_PREFIX."comment SET url='' WHERE cid IN{$commentsId}");
					$CACHE->updateCache(array('sta','comment'));
					header("Location: ./plugin.php?plugin=anti_spam_comment&advance=true&setting=true");
					break;
			}
			break;
		case 'save':
			$comname = isset($_POST['comname']) ? addslashes(trim($_POST['comname'])) : '';
			$comment = isset($_POST['comment']) ? addslashes(trim($_POST['comment'])) : '';
			$commail = isset($_POST['commail']) ? addslashes(trim($_POST['commail'])) : '';
			$comurl = isset($_POST['comurl']) ? addslashes(trim($_POST['comurl'])) : '';
			if ($comurl && strncasecmp($comurl,'http://',7))
			{
				$comurl = 'http://'.$comurl;
			}
			$cid = isset($_POST['cid']) ? intval($_POST['cid']) : '';
			$DB->query("UPDATE ".DB_PREFIX."comment SET poster='$comname',comment='$comment',mail='$commail',url='$comurl' WHERE cid={$cid}");
			$CACHE->updateCache(array('sta','comment'));
			header("Location: ./plugin.php?plugin=anti_spam_comment&advance=true&setting=true");
			break;
		case 'edit':
			$Comment_Model = new Comment_Model();
			$cid = isset($_GET['cid']) ? intval($_GET['cid']) : '';
			extract($Comment_Model->getOneComment($cid));
?>
<form action="./plugin.php?plugin=anti_spam_comment&advance=true&act=save" method="post">
<div>
	<li>昵称</li>
	<li><input size="40" value="<?php echo $poster; ?>" name="comname" /></li>
	<li>邮箱</li>
	<li><input size="40" value="<?php echo $mail; ?>" name="commail" /></li>
	<li>地址</li>
	<li><input size="40" value="<?php echo $url; ?>" name="comurl" /></li>
	<li>内容</li>
	<li><textarea name="comment" rows="3" cols="45"><?php echo $comment; ?></textarea></li>
	<li>
	<input type="hidden" value="<?php echo $cid; ?>" name="cid" />
	<input type="submit" value="保 存" class="submit" />
	<input type="button" value="取 消" class="submit" onclick="javascript: window.history.back();" /></li>
</div>
</form>
<?php
			break;
	}
else:
$blogid = isset($_GET['gid']) ? intval($_GET['gid']) : null;
$hide = isset($_GET['hide']) ? addslashes($_GET['hide']) : '';
$page = isset($_GET['page']) ? intval($_GET['page']) : 1;
$ip = isset($_GET['ip']) ? addslashes($_GET['ip']) : '';
$poster = isset($_GET['poster']) ? addslashes($_GET['poster']) : '';
$addUrl_1 = $addUrl_2 = $addUrl_3 = $addUrl_4 = '';
if($blogid) {
	$addUrl_1 = "gid={$blogid}&";
	$blogid = "AND a.gid=$blogid";
}
if($hide) {
	$addUrl_2 = "hide=$hide&";
	$hide = "AND a.hide='$hide'";
}
if($ip) {
	$addUrl_3 = "ip=$ip&";
	$ip = "AND a.ip='$ip'";
}
if($poster) {
	$addUrl_4 = "poster=$poster&";
	$poster = "AND a.poster='$poster'";
}
$addUrl = $addUrl_1.$addUrl_2.$addUrl_3.$addUrl_4;
$perpage_num = Option::get('admin_perpage_num');
if($page)
{
	$startId = ($page - 1) * $perpage_num;
	$limit = " LIMIT $startId, ".$perpage_num;
}
$sql = "SELECT a.cid,a.hide,a.date,a.comment,a.gid,a.poster,a.ip,a.mail,a.url,b.title FROM ".DB_PREFIX."comment as a, ".DB_PREFIX."blog as b where 1=1 $blogid $hide $ip $poster AND a.gid=b.gid ORDER BY a.cid DESC";
$query = $DB->query($sql);
$cmnum = $DB->num_rows($query);
$query = $DB->query($sql.$limit);
$pageurl =  pagination($cmnum, $perpage_num, $page, "./plugin.php?plugin=anti_spam_comment&advance=true&{$addUrl}page=");
$sql = "SELECT a.cid,a.hide,a.date,a.comment,a.gid,a.poster,a.ip,a.mail,a.url,b.title FROM ".DB_PREFIX."comment as a, ".DB_PREFIX."blog as b where 1=1 $blogid AND a.hide='y' $ip AND a.gid=b.gid ORDER BY a.cid DESC";
$hideCommNum = $DB->num_rows($DB->query($sql));
if ($hideCommNum > 0) : 
$hide_ = $hide_y = $hide_n = '';
$a = "hide_$hide";
$$a = "class=\"filter\"";
?>
<div class="filters">
<span <?php echo $hide_; ?>><a href="./plugin.php?plugin=anti_spam_comment&advance=true&<?php echo $addUrl_1.$addUrl_3; ?>">全部</a></span>
<span <?php echo $hide_y; ?>><a href="./plugin.php?plugin=anti_spam_comment&advance=true&hide=y&<?php echo $addUrl_1.$addUrl_3; ?>">待审
<?php
$hidecmnum = ROLE == 'admin' ? $sta_cache['hidecomnum'] : $sta_cache[UID]['hidecommentnum'];
if ($hidecmnum > 0) echo '('.$hidecmnum.')';
?>
</a></span>
<span <?php echo $hide_n; ?>><a href="./plugin.php?plugin=anti_spam_comment&advance=true&hide=n&<?php echo $addUrl_1.$addUrl_3; ?>">已审</a></span>
</div>
<?php elseif($addUrl): ?>
<div class="filters">
<span><a href="./plugin.php?plugin=anti_spam_comment&advance=true">全部</a></span>
</div>
<?php endif; ?>
<form action="./plugin.php?plugin=anti_spam_comment&advance=true&act=admin_all_coms" method="post" name="form_com" id="form_com">
	<table width="100%" id="adm_comment_list" class="item_list">
		<thead>
			<tr>
				<th width="19"><input onclick="CheckAll(this.form)" type="checkbox" value="on" name="chkall" /></th>
				<th width="350"><b>内容</b></th>
				<th width="300"><b>评论者</b></th>
				<th width="250"><b>所属日志</b></th>
			</tr>
		</thead>
		<tbody>
		<?php
		while($res = $DB->fetch_array($query)):
		$ishide = $res['hide']=='y'?'<font color="red">[待审]</font>':'';
		$mail = !empty($res['mail']) ? "({$res['mail']})" : '';
		$ip = !empty($res['ip']) ? "<br />IP：<a href=\"./plugin.php?plugin=anti_spam_comment&advance=true&ip={$res['ip']}\">{$res['ip']}</a>" : '';
		$url = !empty($res['url']) ? "({$res['url']})" : '';
		$res['content'] = str_replace('<br>',' ',$res['comment']);
		$sub_content = subString($res['content'], 0, 50);
		$res['title'] = subString($res['title'], 0, 42);
		?>
			<tr>
				<td><input type="checkbox" value="<?php echo $res['cid']; ?>" name="com[]" class="ids" /></td>
				<td><a href="./plugin.php?plugin=anti_spam_comment&advance=true&act=edit&cid=<?php echo $res['cid']; ?>" title="<?php echo $res['content']; ?>"><?php echo $sub_content; ?></a> <?php echo $ishide; ?>
				<br /><?php echo smartDate($res['date']); ?>
				<span style="display:none; margin-left:8px;">
				<a href="javascript: asc_confirm(<?php echo $res['cid']; ?>, 'name');">屏蔽昵称</a>
				<a href="javascript: asc_confirm(<?php echo $res['cid']; ?>, 'url');">删除地址</a>
				</span>
				</td>
				<td><a href="./plugin.php?plugin=anti_spam_comment&advance=true&poster=<?php echo urlencode($res['poster']);?>"><?php echo htmlspecialchars($res['poster']);?></a> <?php echo $url; ?> <?php echo $ip;?> <?php echo $mail;?></td>
				<td><a href="./plugin.php?plugin=anti_spam_comment&advance=true&gid=<?php echo $res['gid']; ?>"><?php echo $res['title']; ?></a></td>
			</tr>
		<?php endwhile; ?>
		</tbody>
	</table>
	<div class="list_footer">
	选中项：
	<a href="javascript:asc_commentact('shieldname');">屏蔽昵称</a>
	<a href="javascript:asc_commentact('delurl');">删除地址</a>
	<input name="operate" id="operate" res="" type="hidden" />
	</div>
	<div class="page"><?php echo $pageurl; ?> (有<?php echo $cmnum; ?>条评论)</div> 
</form>
<script>
$(document).ready(function(){
	$("#adm_comment_list tbody tr:odd").addClass("tralt_b");
	$("#adm_comment_list tbody tr")
		.mouseover(function(){$(this).addClass("trover");$(this).find("span").show();})
		.mouseout(function(){$(this).removeClass("trover");$(this).find("span").hide();})
});
setTimeout(hideActived,2600);
function asc_commentact(act){
	if (getChecked('ids') == false) {
		alert('请选择要操作的评论');
		return;
	}
	if(act == 'shieldname' && !confirm('你确定要屏蔽所选评论的评论人昵称吗？')){return;}
	if(act == 'delurl' && !confirm('你确定要删除所选评论的评论人地址吗？')){return;}
	$("#operate").val(act);
	$("#form_com").submit();
}
function asc_confirm (id, property) {
	switch (property){
		case 'name':
		var urlreturn="./plugin.php?plugin=anti_spam_comment&advance=true&act=shieldname&id="+id;
		var msg = "你确定要屏蔽该评论人昵称？";break;
		case 'url':
		var urlreturn="./plugin.php?plugin=anti_spam_comment&advance=true&act=delurl&id="+id;
		var msg = "你确定要删除该评论人地址吗？";break;
	}
	if(confirm(msg)){window.location = urlreturn;}else {return;}
}
</script>
<?php endif; ?>
<?php else: ?>
<?php
	$data = asc_read();
	extract($data);
	$blacklist = implode("\n",$blacklist);
	$url_keywords = implode("\n",$url_keywords);
	$ex1 = $ex2 = '';
	$vari = array(
		array('英文字母abc…ABC…<font color="red">*</font>：','asc_letter'),
		array('数字0-9：','asc_digit'),
		array('英文字符（包括英文字母、数字和其它英文符号）<font color="red">*</font>：','asc_char'),
		array('星号*：','asc_star')
		);
	if($auto_blacklist == 1) {
		$ex1 = 'checked="checked"';
	}
	if($need_chinese == 1) {
		$ex2 = 'checked="checked"';
	}
?>
<form action="plugin.php?plugin=anti_spam_comment&action=setting" method="post">
<table cellspacing="8" cellpadding="4" width="95%" align="center" border="0">
	<tbody>
		<tr nowrap="nowrap">
		<td width="33%" align="right">评论时间间隔（秒）：</td>
		<td width="67%"><input size="10" name="time_limit" type="text" value="<?php echo $time_limit; ?>" /></td>
		</tr>
		<tr nowrap="nowrap">
		<td width="33%" align="right">必须包含汉字：</td>
		<td width="67%"><input size="10" name="need_chinese" type="checkbox" value="1" <?php echo $ex2; ?> /></td>
		</tr>
		<tr nowrap="nowrap">
		<td align="right" valign="top">IP黑名单：<br/><br/>
		可封IP段，填入IP开头地址，如162.204
		</td>
		<td><textarea name="blacklist" cols="" rows="4" style="width:300px;height:70px;"><?php echo $blacklist; ?></textarea></td>
		</tr>
		<tr nowrap="nowrap">
		<td align="right">将频繁尝试发表评论的IP加入黑名单</td>
 		<td><input name="auto_blacklist" type="checkbox" value="1" <?php echo $ex1;?> /></td>
		</tr>
		<tr nowrap="nowrap">
		<td align="right">每分钟允许尝试评论次数：</td>
 		<td><input size="10" name="max_attempt" type="text" value="<?php echo $max_attempt; ?>" />（开启自动黑名单有效）</td>
		</tr>
		<tr nowrap="nowrap">
		<td align="right" valign="top">屏蔽词汇（以 | 分割）：<br />
		可以使用通配符*或者系统<a href="#var">内置变量</a>
		</td>
		<td><textarea name="keywords" cols="" rows="4" style="width:300px;height:70px;"><?php echo $keywords; ?></textarea></td>
		</tr>
		<tr nowrap="nowrap">
		<td align="right" valign="top">屏蔽昵称（以 | 分割）：<br />
		可以使用通配符*或者系统<a href="#var">内置变量</a>
		</td>
		<td><textarea name="name_keywords" cols="" rows="4" style="width:300px;height:70px;"><?php echo $name_keywords; ?></textarea></td>
		</tr>
		<tr nowrap="nowrap">
		<td align="right" valign="top">屏蔽地址（每行一条）：<br/>
		可以使用通配符*或者系统<a href="#var">内置变量</a>
		</td>
		<td><textarea name="url_keywords" cols="" rows="4" style="width:300px;height:70px;"><?php echo $url_keywords; ?></textarea></td>
		</tr>
		<tr>
		<td align="center" colspan="2"><input type="submit" value="保存设置" class="button" /></td>
		</tr>
	</tbody>
</table>
</form>
<b><a name="var"></a>内置变量</b>
<table cellspacing="8" cellpadding="4" width="95%" align="center" border="0">
	<tbody>
<?php
	foreach($vari as $value):
?>
		<tr nowrap="nowrap">
		<td width="40%" align="right"><?php echo $value[0]; ?></td>
		<td width="60%"><b><?php echo $value[1]; ?></b></td>
		</tr>
<?php
	endforeach;
?>
		<tr>
		<td align="center" colspan="2"><font color="red">*注</font>：该项仅当评论全文符合时过滤评论（例如关键字填入asc_letter时，仅过滤纯英文评论）</td>
		</tr>
	</tbody>
</table>
<?php endif;?>
<script>
$("#anti_spam_comment").addClass('sidebarsubmenu1');
</script>
<?php 
}
function plugin_setting()
{
	$time_limit = isset($_POST['time_limit']) ? intval(trim($_POST['time_limit'])) : 0;
	$need_chinese = isset($_POST['need_chinese']) ? intval($_POST['need_chinese']) : 0;
	$blacklist = isset($_POST['blacklist']) ? trim($_POST['blacklist']) : '';
	$auto_blacklist = isset($_POST['auto_blacklist']) ? intval($_POST['auto_blacklist']) : 0;
	$max_attempt = isset($_POST['max_attempt']) ? intval(trim($_POST['max_attempt'])) : 0;
	$keywords = isset($_POST['keywords']) ? trim($_POST['keywords']) : '';
	$name_keywords = isset($_POST['name_keywords']) ? trim($_POST['name_keywords']) : '';
	$url_keywords = isset($_POST['url_keywords']) ? trim($_POST['url_keywords']) : '';
	$data = serialize(array(
		'time_limit' => $time_limit,
		'need_chinese' => $need_chinese,
		'blacklist' => preg_split("/[\r\n]+/", $blacklist),
		'auto_blacklist' => $auto_blacklist,
		'max_attempt' => $max_attempt,
		'keywords' => $keywords,
		'name_keywords' => $name_keywords,
		'url_keywords' => preg_split("/[\r\n]+/", $url_keywords)
		));
	$file = EMLOG_ROOT.'/content/plugins/anti_spam_comment/data';
	@ $fp = fopen($file, 'wb') OR emMsg('读取文件失败，如果您使用的是Unix/Linux主机，请修改文件/content/plugins/anti_spam_comment/data的权限为777。如果您使用的是Windows主机，请联系管理员，将该文件设为everyone可写');
	@ $fw =	fwrite($fp,$data) OR emMsg('写入文件失败，如果您使用的是Unix/Linux主机，请修改文件/content/plugins/anti_spam_comment/data的权限为777。如果您使用的是Windows主机，请联系管理员，将该文件设为everyone可写');
	fclose($fp);
	return TRUE;
}
?>