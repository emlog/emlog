<?php
/*
Plugin Name: 评论管理插件
Version: 1.2
Plugin URL: http://kller.cn/?post=129
Description: 增强型的评论管理，可批量删除评论、批量屏蔽昵称，批量删除URL地址，并可以自定义相关规则来实现类似白名单，黑名单的功能。
ForEmlog: 5.0+
Author: KLLER
Author Email: kller@foxmail.com
Author URL: http://kller.cn
*/
!defined('EMLOG_ROOT') && exit('access deined!');
define('KL_COMMENT_MANAGE_VERSION', '1.2');
define('KL_COMMENT_MANAGE_ROOT', EMLOG_ROOT.'/content/plugins/kl_comment_manage');
function kl_comment_manage()
{
	echo '<div class="sidebarsubmenu" id="kl_comment_manage"><a href="./plugin.php?plugin=kl_comment_manage">评论管理</a></div>';
}
addAction('adm_sidebar_ext', 'kl_comment_manage');

function kl_comment_manage_to_backup(){
	global $tables;
	array_push($tables, 'kl_comment_manage');
}
addAction('data_prebakup', 'kl_comment_manage_to_backup');

function kl_comment_manage_ajax()
{
	$field_arr = array('ip'=>'IP', 'mail'=>'邮箱', 'url'=>'URL', 'poster'=>'昵称', 'comment'=>'评论', 'gid'=>'文章ID');
	$sign_arr = array('eq'=>'等于', 'neq'=>'不等于', 'leq'=>'开头为', 'req'=>'结尾为', 'like'=>'包含');
	if(empty($_POST['field']) || !in_array($_POST['field'], array_keys($field_arr)) || empty($_POST['sign']) || !in_array($_POST['sign'], array_keys($sign_arr)) || empty($_POST['keyword']) || (empty($_POST['operate']) || !in_array($_POST['operate'], array('anti','hide','pub'))) || !isset($_POST['disabled'])) exit("<span style=\"color:red\">参数错误。</span>");
	$field = $_POST['field'];
	$sign = $_POST['sign'];
	$keyword = addslashes(trim($_POST['keyword']));
	$operate = addslashes(trim($_POST['operate']));
	$disabled = intval($_POST['disabled']);

	$DB = mysql::getInstance();
	$sql = 'select id from '.DB_PREFIX."kl_comment_manage where `field`='{$field}' and `sign`='{$sign}' and `keyword`='{$keyword}'";
	if($DB->num_rows($DB->query($sql)) > 0){
		echo "<span style=\"color:red\">此条件已存在规则列表中。</span>";
	}else{
		$cau_time = time();
		$sql = 'insert into '.DB_PREFIX."kl_comment_manage(`field`, `sign`, `keyword`, `operate`, `hits`, `disabled`, `cau_time`) values('{$field}', '{$sign}', '{$keyword}', '{$operate}', 0, {$disabled}, {$cau_time})";
		$DB->query($sql);
		kl_comment_manage_update_rules();
		if($DB->affected_rows() > 0) echo "<span style=\"color:green\">添加成功。</span>";
	}
}

function kl_comment_manage_action_do($operate, $cid=0)
{
	$comment = isset($_POST['comment']) ? addslashes(trim($_POST['comment'])) : '';
	$comname = isset($_POST['comname']) ? addslashes(trim($_POST['comname'])) : '';
	$comurl = isset($_POST['comurl']) ? addslashes(trim($_POST['comurl'])) : '';
	$commail = isset($_POST['commail']) ? addslashes(trim($_POST['commail'])) : '';
	$comgid = isset($_POST['gid']) ? intval($_POST['gid']) : 0;
	$comip = getIp();
	$rules_cache = kl_comment_manage_get_rules();
	$msg_arr = array(
	'comment'=>'您填写的评论内容中含有博主不允许发表的信息，请修改后重新提交。',
	'poster'=>'您填写的昵称中含有博主不允许发表的信息，请修改后重新提交。',
	'url'=>'您填写的个人主页中含有博主不允许发表的信息，请修改后重新提交。',
	'mail'=>'您填写的邮件地址中含有博主不允许发表的信息，请修改后重新提交。',
	'gid'=>'抱歉，此文章不允许发表评论',
	'ip'=>'您的IP已被博主屏蔽了。'
	);
	$arr = array('comment'=>$comment, 'poster'=>$comname, 'url'=>$comurl, 'mail'=>$commail, 'gid'=>$comgid, 'ip'=>$comip);
	$japanese_chars = 'あいうえおアイウエオ';
	$japanese_chars_long = implode('|', str_split($japanese_chars, 3));
	$japanese_chars_mark = '[japanese]';
	foreach($arr as $ak => $av){
		if(!empty($rules_cache[$operate][$ak])){
			foreach($rules_cache[$operate][$ak] as $rule){
				if($rule['disabled'] == '1') continue;
				$hits = false;
				if(in_array($ak, array('poster', 'comment')) && $rule['keyword'] == $japanese_chars_mark && preg_match('/'.$japanese_chars_long.'/', $av)){
					$hits = true;
				}elseif($rule['sign'] == 'eq' && $rule['keyword'] == $av){
					$hits = true;
				}elseif($rule['sign'] == 'neq' && $rule['keyword'] != $av){
					$hits = true;
				}elseif($rule['sign'] == 'leq' && preg_match('/^'.preg_quote($rule['keyword'], '/').'/', $av)){
					$hits = true;
				}elseif($rule['sign'] == 'req' && preg_match('/'.preg_quote($rule['keyword'], '/').'$/', $av)){
					$hits = true;
				}elseif($rule['sign'] == 'like' && preg_match('/'.preg_quote($rule['keyword'], '/').'/', $av)){
					$hits = true;
				}
				if($hits){
					kl_comment_manage_update_hits($rule['id']);
					if($operate == 'anti'){
						emMsg($msg_arr[$ak]);
					}elseif($operate == 'pub'){
						kl_comment_manage_update_comment($cid, 'n');
						emDirect(Url::log($comgid).'#'.$cid);
					}elseif($operate == 'hide'){
						kl_comment_manage_update_comment($cid, 'y');
						emMsg('评论发表成功，请等待管理员审核', Url::log($comgid));
					}
				}
			}
		}
	}
}

function kl_comment_manage_action_saved($cid)
{
	$ischkcomment = Option::get('ischkcomment');
	$hide = ROLE == 'visitor' ? $ischkcomment : 'n';
	if($hide == 'n'){
		kl_comment_manage_action_do('hide', $cid);
	}else{
		kl_comment_manage_action_do('pub', $cid);
		kl_comment_manage_action_do('hide', $cid);
	}
}
addAction('comment_saved', 'kl_comment_manage_action_saved');

function kl_comment_manage_action_post()
{
	kl_comment_manage_action_do('anti');
}
addAction('comment_post', 'kl_comment_manage_action_post');

function kl_comment_manage_get_rules()
{
	$rules_arr = array();
	$cache_file = KL_COMMENT_MANAGE_ROOT."/cache/rules.php";
	if(file_exists($cache_file)){
		$rules_arr = include $cache_file;
		if(is_array($rules_arr)) return $rules_arr;
	}
	return kl_comment_manage_update_rules();
}

function kl_comment_manage_update_rules()
{

	$cache_file = KL_COMMENT_MANAGE_ROOT."/cache/rules.php";
	$DB = Mysql::getInstance();
	$query = $DB->query('select id, `field`, `sign`, `keyword`, `operate`, `disabled` from '.DB_PREFIX."kl_comment_manage order by id desc");
	$rules_arr = array(
	'anti'=>array('ip'=>array(), 'url'=>array(), 'mail'=>array(), 'poster'=>array(), 'comment'=>array(), 'gid'=>array()),
	'hide'=>array('ip'=>array(), 'url'=>array(), 'mail'=>array(), 'poster'=>array(), 'comment'=>array(), 'gid'=>array()),
	'pub'=>array('ip'=>array(), 'url'=>array(), 'mail'=>array(), 'poster'=>array(), 'comment'=>array(), 'gid'=>array()),
	);
	$operate_arr = array_keys($rules_arr);
	$field_arr = array_keys($rules_arr['pub']);
	while($row = $DB->fetch_array($query)){
		$field = $row['field'];
		$operate = $row['operate'];
		if(in_array($operate, $operate_arr)){
			unset($row['operate']);
			if(in_array($field, $field_arr)){
				unset($row['operate']);
				array_push($rules_arr[$operate][$field], $row);
			}
		}
	}
	@file_put_contents($cache_file, "<?php if(!defined('EMLOG_ROOT')) {exit('error!');}\nreturn ".var_export($rules_arr, true).';');
	return $rules_arr;
}

function kl_comment_manage_update_comment($cid, $hide)
{
	global $CACHE;
	$cid = intval($cid);
	$DB = mysql::getInstance();
	$sql = 'update '.DB_PREFIX."comment set `hide`='{$hide}' where cid={$cid}";
	$DB->query($sql);
	$CACHE->updateCache('sta');

}

function kl_comment_manage_update_hits($id)
{
	$id = intval($id);
	$DB = mysql::getInstance();
	$last_hits_time = time();
	$sql = 'update '.DB_PREFIX."kl_comment_manage set hits=hits+1, last_hits_time={$last_hits_time} where id={$id}";
	$DB->query($sql);
}