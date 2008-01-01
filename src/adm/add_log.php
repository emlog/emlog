<?php
/* emlog 2.5.0 Emlog.Net */
require_once('./globals.php');
$pid = isset($_GET['pid'])?$_GET['pid']:'';

if($action == '')
{
	include getViews('header');
	//已有tags
	$query = $DB->query("select tagname from ".$db_prefix."tag");
	$oldtags = '';
	while($tags = $DB->fetch_array($query))
	{
		$oldtags .=" <a href=\"javascript: inserttag('".$tags['tagname']."','tags');\">".$tags['tagname']."</a> "	;
	}
	//时间
	$year = date('Y');
	$month = date('m');
	$day = date('d');
	$hour = date('H');
	$minute = date('i');
	$second	 = date('s');

require_once(getViews('add_log'));
include getViews('footer');cleanPage();
}
##################添加日志##################
if($action== 'addlog')
{
	if($pid == 'draft')
	{
		$ishide='y';
		$ok_msg = '草稿保存成功！';
		$ok_url = 'admin_log.php?pid=draft';
	}else
	{
		$ishide = 'n';
		$ok_msg = '日志成功发布！';
		$ok_url = 'admin_log.php';
	}
		$title = isset($_POST['title'])?addslashes(trim($_POST['title'])):'';
		$tagstring = isset($_POST['tag'])?addslashes(trim($_POST['tag'])):'';
		$edittime = isset($_POST['edittime'])?intval(isset($_POST['edittime'])):'';
		$content = isset($_POST['content'])?addslashes(trim($_POST['content'])):'';
		$pingurl  = isset($_POST['pingurl'])?addslashes($_POST['pingurl']):'';
		$allow_remark = isset($_POST['allow_remark'])?addslashes($_POST['allow_remark']):'';
		$allow_tb = isset($_POST['allow_tb'])?addslashes($_POST['allow_tb']):'';
		$tbmsg = '';	 //define trackback msg		
   if($title == '')
		formMsg('标题不能为空！','./add_log.php',0);
	//时间处理
	if($timezone!=8)
	{
		$oversec = ($timezone-8)*3600;
		$localtime = time()-$oversec;
	}else
		$localtime = time();
	if($edittime)
	{
		$newtime = @gmmktime(intval($_POST['newhour']),intval($_POST['newmin']),
										intval($_POST['newsec']),intval($_POST['newmonth']),
										intval($_POST['newday']),intval($_POST['newyear']))-$timezone*3600;
		if(empty($newtime))
			$newtime = $localtime;
	} else
		$newtime = $localtime;
			
	//查询嵌入到日志中的附件id 存入数组
	//preg_match_all("/ematt:([0-9]+)/i",$content, $matches );
	//$cont_attid = serialize($matches[1]); 
	
	//日志写入数据库
	$sql="insert into ".$db_prefix."blog (`title`,`date`,`content`,`hide`,`allow_remark`,`allow_tb`,`attcache`) values('$title','$newtime','$content','$ishide','$allow_remark','$allow_tb','')";
	$DB->query($sql);
	//获取当前添加日志ID
	$logid=$DB->insert_id();
	//写入tag
	if (!empty($tagstring))
	{
		$tag = explode(',',$tagstring);
		$tag = formatArray($tag);
		for ($i = 0; $i < count($tag); $i++)
		{
			$result = $DB->fetch_one_array("SELECT tagname FROM ".$db_prefix."tag WHERE `tagname`='".trim($tag[$i])."' ");
				if(empty($result)) {
					$query="INSERT INTO ".$db_prefix."tag (`tagname`,`gid`) VALUES('".$tag[$i]."',',$logid,')";
					$DB->query($query);
				}else{
				  	$query="UPDATE ".$db_prefix."tag SET `usenum`=`usenum`+1, `gid`=concat(`gid`,'$logid,') where `tagname` = '".$tag[$i]."' ";
					$DB->query($query);
				}
			}
		$MC->mc_tags('../cache/tags');
	}
	//上传附件
	$attach = isset($_FILES['attach'])?$_FILES['attach']:'';
	if($attach){
		$des = $_POST['attdes'];
		for ($i = 0; $i < count($attach['name']); $i++)
		{
			if($attach['error'][$i]!=4){
				$ades = addslashes(trim($des[$i]));
				//$att_type 允许上传的后缀名
				$upfname = uploadFile($attach['name'][$i],$attach['tmp_name'][$i],$attach['size'][$i],$att_type,$attach['type'][$i]);
				//写入附件信息
				$query="INSERT INTO ".$db_prefix."attachment (`blogid`,`filename`,`attdes`,`filesize`,`filepath`,`addtime`) values ('".$logid."','".$attach['name'][$i]."','".$ades."','".$attach['size'][$i]."','".$upfname."','".time()."')";	
				$DB->query($query);
			}
		}
	}
	// 发送Trackback部分
	if(!empty($pingurl))
	{
		if (substr($blogurl, -1) !== '/') {
			$blogurl = $blogurl."/";
		}
		$url = $blogurl."index.php?action=showlog&gid=".$logid;
		$host = explode(',', $pingurl);
		$host_num = count($host);
		for($i=0; $i<$host_num; $i++) {			
			$host[$i] = trim($host[$i]);
			$data ="url=".rawurlencode($url)."&title=".rawurlencode($title)."&blog_name=".rawurlencode($blogname)."&excerpt=".rawurlencode($content);
			$result = sendPacket($host[$i], $data);
			if (strpos($result, "error>1</error")) {
				$tbmsg = "(发送 Trackback 失败)";
			} else {
				$tbmsg = "(发送 Trackback 成功)";
			}
		}
	}
$MC->mc_sta('../cache/sta');
$MC->mc_record('../cache/records');
$MC->mc_logtags('../cache/log_tags');
$MC->mc_logatts('../cache/log_atts');
formMsg($ok_msg.$tbmsg,$ok_url,1);

}//end add log
?>
