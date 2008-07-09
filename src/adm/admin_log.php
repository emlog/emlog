<?php
/**
 * 管理日志
 * @copyright (c) 2008, Emlog All Rights Reserved
 * @version emlog-2.7.0
 * $Id$
 */

require_once('./globals.php');

$pid = isset($_GET['pid'])?$_GET['pid']:'';

$sortView = (isset($_GET['sortView']) && $_GET['sortView'] == 'ASC') ?  'DESC':'ASC';
$sortComm = (isset($_GET['sortComm']) && $_GET['sortComm'] == 'ASC') ?  'DESC':'ASC';
$sortDate = (isset($_GET['sortDate']) && $_GET['sortDate'] == 'DESC') ?  'ASC':'DESC';
$sortTitle = (isset($_GET['sortTitle']) && $_GET['sortTitle'] == 'DESC') ?  'ASC':'DESC';

$subSql = 'ORDER BY ';

if(isset($_GET['sortView']))
	$subSql .= "views $sortView";
elseif(isset($_GET['sortComm']))
	$subSql .= "comnum $sortComm";
elseif(isset($_GET['sortDate']))
	$subSql .= "date $sortDate";
elseif(isset($_GET['sortTitle']))
	$subSql .= "title $sortTitle";
else 
	$subSql .= 'top DESC,date DESC';

if($action == ''){
	include getViews('header');
	$page = intval(isset($_GET['page'])?$_GET['page']:1);
	if (!empty($page)) {
		$start_limit = ($page - 1) *15;
	} else {
		$start_limit = 0;
		$page = 1;
	}
	$hide_state = $pid?'y':'n';
	if($pid == 'draft'){
		$log_act = "<input type=\"radio\" value=\"show\" name=\"modall\" />发布";
		$hide_stae = 'y';
		$sorturl = '&pid=draft';
		$pwd = '草稿箱';
	}else{
		$log_act = "<input type=\"radio\" value=\"top\" name=\"modall\" />推荐
        	 	 	<input type=\"radio\" value=\"notop\" name=\"modall\" /> 取消推荐
				 	<input type=\"radio\" value=\"hide\" name=\"modall\" />转入草稿箱";
		$hide_stae = 'n';
		$sorturl = '';
		$pwd = '日志管理';
	}
	$sql="select * from {$db_prefix}blog where hide='$hide_state'";
	$query=$DB->query($sql);
	$num=$DB->num_rows($query);
	$logsql="SELECT gid,title,date,top,comnum,views FROM {$db_prefix}blog WHERE hide='$hide_state' $subSql LIMIT $start_limit, 15";
	$logquery=$DB->query($logsql);
	$logs = array();
	while($dh=$DB->fetch_array($logquery))
	{
		$dh['title'] = htmlspecialchars($dh['title']);
		$gid = $dh['gid'];
		$adddate = date("Y-m-d H:i",$dh['date']);
		$istop = $dh['top']=='y'? "<font color=\"red\">[推荐]</font>" :'';
		$query=$DB->query("SELECT blogid FROM {$db_prefix}attachment WHERE blogid='".$dh['gid']."' ");
		$attach_num=$DB->num_rows($query);
		$attach = $attach_num>0?"<font color=\"green\">[附件:".$attach_num."]</font>":'';
		$rowbg = getRowbg();

		$logs[] = array(
			'title'=>$dh['title'],
			'gid'=>$gid,
			'date'=>$adddate,
			'comnum'=>$dh['comnum'],
			'views'=>$dh['views'],
			'istop'=>$istop,
			'attach'=>$attach,
			'rowbg'=>$rowbg
		);
	}
	
	$subPage = '';
	foreach ($_GET as $key=>$val){
		$subPage .= $key != 'page'?"&$key=$val":'';
	}
	$pageurl =  pagination($num,15,$page,"admin_log.php?{$subPage}&page");

	require_once(getViews('admin_log'));
	include getViews('footer');cleanPage();
}

###################批量操作日志###############
if($action== 'admin_all_log') {
	$dowhat = isset($_POST['modall'])?$_POST['modall']:'';
	if($dowhat == '') {
		formMsg('请选择一个要执行的操作','javascript:history.back(-1);',0);
	}
	$logs =isset($_POST['blog'])?$_POST['blog']:'';
	if($logs == '') {
		formMsg('请选择要执行操作的日志','javascript:history.back(-1);',0);
	}
	//删除日志
	if($dowhat == 'del_log' && !empty($logs)) {
		foreach($logs as $key=>$value)
		{
			delLog($key);
		}
		$MC->mc_sta('../cache/sta');
		$MC->mc_record('../cache/records');
		$MC->mc_comment('../cache/comments');
		$MC->mc_logtags('../cache/log_tags');
		$MC->mc_tags('../cache/tags');
		formMsg('删除日志成功','./admin_log.php',1);
	}
	//推荐日志
	if($dowhat == 'top') {
		foreach($logs as $key=>$value) {
			$DB->query("UPDATE {$db_prefix}blog SET top='y' WHERE gid='$key' ");
		}
		formMsg('推荐日志成功','./admin_log.php',1);
	}
	//取消推荐
	if($dowhat == 'notop') {
		foreach($logs as $key=>$value) {
			$DB->query("UPDATE {$db_prefix}blog SET top='n' WHERE gid='$key' ");
		}
		formMsg('日志已取消推荐','./admin_log.php',1);
	}
	//转入草稿箱
	if($dowhat == 'hide') {
		foreach($logs as $key=>$value) {
			$DB->query("UPDATE {$db_prefix}blog SET hide='y' WHERE gid='$key' ");
			$DB->query("UPDATE {$db_prefix}comment SET hide='y' WHERE gid='$key' ");
		}
		$MC->mc_sta('../cache/sta');
		$MC->mc_record('../cache/records');
		$MC->mc_comment('../cache/comments');
		$MC->mc_logtags('../cache/log_tags');
		formMsg('日志成功转入草稿箱','./admin_log.php',1);
	}
	//从草稿箱发布
	if($dowhat == 'show') {
		foreach($logs as $key=>$value)
		{
			$DB->query("UPDATE {$db_prefix}blog SET hide='n' WHERE gid='$key' ");
			$DB->query("UPDATE {$db_prefix}comment SET hide='n' WHERE gid='$key' ");
		}
		$MC->mc_sta('../cache/sta');
		$MC->mc_comment('../cache/comments');
		$MC->mc_logtags('../cache/log_tags');
		$MC->mc_record('../cache/records');	//重新计算归档日志数目 故更新归档缓存
		formMsg('发布成功','./admin_log.php?pid=draft',1);
	}
}

######################日志修改######################
if ($action=='mod'){

	include getViews('header');

	$logid = isset($_GET['gid'])?intval($_GET['gid']):'';
	$sql = "select * from {$db_prefix}blog where gid=$logid ";
	$result = $DB->query($sql);
	$rows = $DB->fetch_array($result);
	extract($rows);
	$title = htmlspecialchars($title);
	$adddate = $date;
	//auto save
	$as_logid = $hide == 'n'?-2:$logid;
	//log_content
	$content = htmlspecialchars($content);
	//tag
	$query = $DB->query("SELECT tagname FROM {$db_prefix}tag WHERE gid LIKE '%,$logid,%' ");
	$tag = '';
	while($tagstring = $DB->fetch_array($query))
	{
		$tag.=','.htmlspecialchars($tagstring['tagname']);
	}
	$tag = substr($tag,1);
	//old tag
	$query = $DB->query("select tagname from {$db_prefix}tag");
	$oldtags = '';
	while($tags = $DB->fetch_array($query)){
		$tagname = htmlspecialchars($tags['tagname']);
		$oldtags .=" <a href=\"javascript: inserttag('".$tagname."','tags');\">".$tagname."</a> "	;
	}
	//date
	$year = date('Y',$date);
	$month = date('m',$date);
	$day = date('d',$date);
	$hour = date('H',$date);
	$minute = date('i',$date);
	$second	 = date('s',$date);
	//attachment
	$sql="SELECT * FROM {$db_prefix}attachment where blogid=$logid ";
	$query=$DB->query($sql);
	$attachnum = $DB->num_rows($query);
	if($attachnum!=0){
		while($dh=$DB->fetch_array($query)){
			$attsize = changeFileSize($dh['filesize']);
			$attdes = htmlspecialchars($dh['attdes']);
			$filename = htmlspecialchars($dh['filename']);

			$attach[] = array(
			'attsize'=>$attsize,
			'aid'=>$dh['aid'],
			'attdes'=>$attdes,
			'filepath'=>$dh['filepath'],
			'filename'=>$filename
			);
		}
	}else{
		unset($attach);
	}

	if($allow_remark=='y'){
		$ex="checked=\"checked\"";
		$ex2="";
	}else{
		$ex="";
		$ex2="checked=\"checked\"";
	}
	if($allow_tb=='y'){
		$add="checked=\"checked\"";
		$add2="";
	}else{
		$add="";
		$add2="checked=\"checked\"";
	}

	require_once(getViews('edit_log'));
	include getViews('footer');cleanPage();
}

//修改
if($action=="edit"){
	$title = addslashes(trim($_POST['title']));
	$tagstring = addslashes(trim($_POST['tag']))	;
	$edittime = intval(isset($_POST['edittime'])?$_POST['edittime']:'');
	$content = addslashes($_POST['content']);
	$pingurl  = addslashes($_POST['pingurl']);
	$allow_remark = addslashes($_POST['allow_remark']);
	$allow_tb = addslashes($_POST['allow_tb']);
	$logid = 	intval($_POST['gid']);
	$date = addslashes($_POST['date']);
	$tbmsg = '';	 //define trackback msg

	//查询嵌入到日志中的附件id 存入数组
	preg_match_all("/ematt:([0-9]+)/i",$content, $matches );
	$cont_attid = serialize($matches[1]);

	//是否修改日期 /生成新的日期码
	if($edittime == 1)
	{
		$unixtime = @gmmktime($_POST['newhour'],$_POST['newmin'],$_POST['newsec'],$_POST['newmonth'],$_POST['newday'],$_POST['newyear'])-$timezone*3600;;
		if(empty($unixtime))
		{
			$unixtime = $date;
		}
	}else{
		$unixtime = $date;
	}

	$sql=" UPDATE {$db_prefix}blog SET
				title='$title',
				date='$unixtime',
				allow_remark='$allow_remark',
				allow_tb='$allow_tb',
				content='$content',
				attcache='$cont_attid' 
				WHERE gid='$logid' ";
	$logid = intval($_POST['gid']);
	//更新附件说明
	if (isset($_POST['attachdes']))
	{
		$des1 = $_POST['attachdes'];
		foreach($des1 as $key=>$value){
			$DB->query("UPDATE {$db_prefix}attachment SET attdes = '$value' WHERE aid='$key' ");
		}
	}
	//上传附件
	$attach = isset($_FILES['attach'])?$_FILES['attach']:'';
	if($attach)
	{
		$des = $_POST['attdes'];
		for ($i = 0; $i < count($attach['name']); $i++) {
			if($attach['error'][$i]!=4){
				$ades = addslashes(trim($des[$i]));
				$upfname = uploadFile($attach['name'][$i],$attach['tmp_name'][$i],$attach['size'][$i],$att_type,$attach['type'][$i]);
				//写入附件信息
				$query="INSERT INTO {$db_prefix}attachment (blogid,filename,attdes,filesize,filepath,addtime) values ('".$logid."','".$attach['name'][$i]."','".$ades."','".$attach['size'][$i]."','".$upfname."','".time()."')";
				$DB->query($query);
			}
		}
	}
	//更新（tag）
	$tag = explode(',',$tagstring);
	$query = $DB->query("SELECT tagname FROM {$db_prefix}tag WHERE gid LIKE '%".$logid."%' ");
	$i = 0;
	while($result = $DB->fetch_array($query)){
		$old_tag[$i] = $result['tagname'];
		$i++;
	}
	if(empty($old_tag))
	$old_tag = array('');
	$dif_tag = findArray(formatArray($tag),$old_tag);
	for($n=0;$n<count($dif_tag);$n++){
		$a = 0;
		for($j=0;$j<count($old_tag);$j++) {
			if($dif_tag[$n]==$old_tag[$j]){
				$DB->query("UPDATE {$db_prefix}tag SET usenum=usenum-1,gid= REPLACE(gid,',$logid,',',') WHERE tagname='".$dif_tag[$n]."' ");
				$DB->query("DELETE FROM {$db_prefix}tag WHERE usenum=0 ");
				break;
			}
			elseif($j==count($old_tag)-1){
				$result = $DB->fetch_one_array("SELECT tagname FROM {$db_prefix}tag WHERE tagname='".trim($dif_tag[$n])."' ");
				if(empty($result)) {
					$query="INSERT INTO {$db_prefix}tag (tagname,gid) VALUES('".$dif_tag[$n]."',',$logid,')";
					$DB->query($query);
				}else{
					$query="UPDATE {$db_prefix}tag SET usenum=usenum+1, gid=concat(gid,'$logid,') where tagname = '".$dif_tag[$n]."' ";
					$DB->query($query);
				}
			}//end elseif
		}//end for2
	}//end for1

	// 发送Trackback部分
	if(!empty($pingurl))
	{
		$url = $blogurl."index.php?action=showlog&gid=".$logid;
		$hosts = explode("\n", $pingurl);
		$tbmsg = '';
		foreach ($hosts as $key => $value)
		{
			$host = trim($value);
			if(strstr(strtolower($host), "http://") || strstr(strtolower($host), "https://"))
			{
				$data ="url=".rawurlencode($url)."&title=".rawurlencode($title)."&blog_name=".rawurlencode($blogname)."&excerpt=".rawurlencode($content);
				$result = strtolower(sendPacket($host, $data));
				if (strstr($result, "<error>0</error>") === false) {
					$tbmsg .= "(引用{$key}:发送失败)";
				} else {
					$tbmsg .= "(引用{$key}:发送成功)";
				}
			}
		}
	}
	$DB->query($sql);
	$MC->mc_logtags('../cache/log_tags');
	$MC->mc_logatts('../cache/log_atts',$cont_attid,$logid);//嵌入内容中的附件id数组：$cont_attid
	$MC->mc_record('../cache/records');
	$MC->mc_tags('../cache/tags');
	formMsg( "保存成功\t$tbmsg","javascript:history.go(-1);",1);
}

//删除日志
if ($action== 'delLog'){
	$gid = isset($_GET['gid'])?intval($_GET['gid']):'';
	delLog($gid);
	$MC->mc_sta('../cache/sta');
	$MC->mc_record('../cache/records');
	$MC->mc_comment('../cache/comments');
	$MC->mc_logtags('../cache/log_tags');
	$MC->mc_tags('../cache/tags');
	formMsg('删除日志成功','./admin_log.php',1);
}
?>