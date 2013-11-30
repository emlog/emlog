<?php 
!defined('EMLOG_ROOT') && exit('access deined!');
function plugin_setting_view(){
	global $CACHE;
	$DB = mysql::getInstance();
	$warning_msg = is_writable('../content/plugins/kl_comment_manage/cache') ? '' : '<span class="error">kl_comment_manage/cache文件夹可能不可写，如果已经是可写状态，请忽略此信息。</span>';
	$page = isset($_GET['page']) ? intval($_GET['page']) : 1;
	$field_arr = array('ip'=>'IP', 'mail'=>'邮箱', 'url'=>'URL', 'poster'=>'昵称', 'comment'=>'评论', 'gid'=>'文章ID');
	$sign_arr = array('eq'=>'等于', 'neq'=>'不等于', 'leq'=>'开头为', 'req'=>'结尾为', 'like'=>'包含');
	$operate_arr = array('pub'=>'审核通过', 'hide'=>'不通过审核', 'anti'=>'不让发表');
	$operate_with_color_arr = array('pub'=>'<span style="color:green;">审核通过</span>', 'hide'=>'<span style="color:blue;">不通过审核</span>', 'anti'=>'<span style="color:red;">不让发表</span>');
	$japanese_chars = 'あいうえおアイウエオ';
	$japanese_chars_long = implode('|', str_split($japanese_chars, 3));
	$japanese_chars_mark = '[japanese]';
	if(isset($_GET['act']) && trim($_GET['act']) == 'rules'){
		$query = $DB->query('select * from '.DB_PREFIX."kl_comment_manage order by cau_time desc, id desc");
		$rules = array();
		while($row = $DB->fetch_array($query)) array_push($rules, $row);
		if(isset($_GET['do']) && trim($_GET['do']) == 'add'){
			$kl_id = isset($_POST['kl_id']) ? intval($_POST['kl_id']) : 0;
			$field = isset($_POST['field']) ? addslashes(trim($_POST['field'])) : '';
			$sign = isset($_POST['sign']) ? addslashes(trim($_POST['sign'])) : '';
			$keyword = isset($_POST['keyword']) ? addslashes(trim($_POST['keyword'])) : '';
			$operate = isset($_POST['operate']) ? addslashes(trim($_POST['operate'])) : '';
			$disabled = isset($_POST['disabled']) ? intval($_POST['disabled']) : 1;
			if($keyword == '' || $field == '' || $sign == '')	emDirect("./plugin.php?plugin=kl_comment_manage&act=rules&do=edit&id={$kl_id}&error_a=1");
			$cau_time = time();
			if($kl_id > 0){
				$DB->query('update '.DB_PREFIX."kl_comment_manage set `field`='{$field}', `sign`='{$sign}', `keyword`='{$keyword}', `operate`='{$operate}', `disabled`={$disabled}, `cau_time`={$cau_time} where id={$kl_id}");
				kl_comment_manage_update_rules();
				emDirect("./plugin.php?plugin=kl_comment_manage&act=rules&active_edit=1");
			}else{
				$DB->query('insert into '.DB_PREFIX."kl_comment_manage(`field`, `sign`, `keyword`, `operate`, `disabled`, `hits`, `cau_time`) values('{$field}', '{$sign}', '{$keyword}', '{$operate}', {$disabled}, 0, {$cau_time})");
				kl_comment_manage_update_rules();
				emDirect("./plugin.php?plugin=kl_comment_manage&act=rules&active_add=1");
			}
		}elseif(isset($_GET['do']) && trim($_GET['do']) == 'edit'){
			$id = isset($_GET['id']) ? intval($_GET['id']) : 0;
			if($id > 0){
				$query = $DB->query('select * from '.DB_PREFIX."kl_comment_manage where id={$id}");
				if($DB->num_rows($query) > 0) $the_rule = $DB->fetch_array($query);
			}
		}elseif(isset($_GET['do']) && trim($_GET['do']) == 'del'){
			$id = isset($_GET['id']) ? intval($_GET['id']) : 0;
			if($id > 0){
				$query = $DB->query('delete from '.DB_PREFIX."kl_comment_manage where id={$id}");
				if($DB->affected_rows() > 0){
					kl_comment_manage_update_rules();
					emDirect("./plugin.php?plugin=kl_comment_manage&act=rules&active_del=1");
				}
			}
		}
?>
<div class=containertitle><b>评论管理【插件】</b><span style="font-size:12px;color:#999999;">（版本：<?php echo KL_COMMENT_MANAGE_VERSION;?>）</span><?php echo $warning_msg;?></div>
<div class=line></div>
<div class="containertitle2">
<a class="navi1" href="?plugin=kl_comment_manage">批量管理</a>
<a class="navi3" href="?plugin=kl_comment_manage&act=rules">自定义规则</a>
<?php if(isset($_GET['active_del'])):?><span class="actived">删除成功</span><?php endif;?>
<?php if(isset($_GET['active_edit'])):?><span class="actived">修改成功</span><?php endif;?>
<?php if(isset($_GET['active_add'])):?><span class="actived">添加成功</span><?php endif;?>
<?php if(isset($_GET['error_a'])):?><span class="error">字段、符号和关键词不能为空</span><?php endif;?>
</div>
<div style="border:1px dashed #ccc;margin:5px 0px;padding-left:5px;<?php if(isset($the_rule['id'])) echo 'background:#FDFFCE';?>">
	<form action="?plugin=kl_comment_manage&act=rules&do=add" method="post" name="link" id="link">
		<div id="word_new">
			<span style="font-weight:bold;color:#999;"><strong>》 <?php echo isset($the_rule['id']) ? '修改规则'.$the_rule['id'] : '添加规则';?>：</strong>当</span>
			<select name="field">
				<option value="">请选择</option>
				<?php foreach($field_arr as $fk => $fv):?>
				<option value="<?php echo $fk;?>"<?php if(isset($the_rule['field']) && $the_rule['field'] == $fk) echo ' selected';?>><?php echo $fv;?></option>
				<?php endforeach;?>
			</select>
			<select name="sign">
				<option value="">请选择</option>
				<?php foreach($sign_arr as $sk => $sv):?>
				<option value="<?php echo $sk;?>"<?php if(isset($the_rule['sign']) && $the_rule['sign'] == $sk) echo ' selected';?>><?php echo $sv;?></option>
				<?php endforeach;?>
			</select>
			<input maxlength="255" style="width:180px;" name="keyword" value="<?php if(isset($the_rule['keyword'])) echo $the_rule['keyword'];?>" />
			<span style="font-weight:bold;color:#999;">时，执行</span>
			<select name="operate">
				<option value="pub"<?php if(isset($the_rule['operate']) && $the_rule['operate'] == 'pub') echo ' selected';?>>审核通过</option>
				<option value="hide"<?php if(isset($the_rule['operate']) && $the_rule['operate'] == 'hide') echo ' selected';?>>不通过审核</option>
				<option value="anti"<?php if(isset($the_rule['operate']) && $the_rule['operate'] == 'anti') echo ' selected';?>>不让发表</option>
			</select>
			<span style="font-weight:bold;color:#999;">操作，状态</span>
			<select name="disabled">
				<option value="1"<?php if(isset($the_rule['disabled']) && $the_rule['disabled'] == 1) echo ' selected';?>>未启用</option>
				<option value="0"<?php if(isset($the_rule['disabled']) && $the_rule['disabled'] == 0) echo ' selected';?>>启用</option>
			</select>
			<input name="kl_id" type="hidden" value="<?php if(isset($the_rule['id'])) echo $the_rule['id'];?>" /><input type="submit" name="" value="保存规则"  />
		</div>
	</form>
</div>
<table width="100%" id="kl_comment_manage_list" class="item_list">
	<thead>
		<tr>
			<th width="50"><b>序号</b></th>
			<th width="80"><b>字段</b></th>
			<th width="80"><b>符号</b></th>
			<th width="200"><b>关键词</b></th>
			<th width="80" class="tdcenter"><b>执行动作</b></th>
			<th width="60" class="tdcenter"><b>状态</b></th>
			<th width="60" class="tdcenter"><b>命中次数</b></th>
			<th width="120" class="tdcenter"><b>最后命中的时间</b></th>
			<th width="100" class="tdcenter">操作</th>
		</tr>
	</thead>
	<tbody>
	<?php 
	if($rules):
	$i = 0;
	foreach($rules as $key=>$value):
	?>  
		<tr <?php if($i == 0 && isset($_GET['active_edit'])):?>style="background:#FDFFCE"<?php endif;?>>
			<td><?php echo $value['id']; ?></td>
			<td><?php echo $field_arr[$value['field']];?></td>
			<td><?php echo $sign_arr[$value['sign']];?></td>
			<td><?php echo $value['keyword']; ?></td>
			<td class="tdcenter"><?php echo $operate_with_color_arr[$value['operate']]; ?></td>
			<td class="tdcenter"><?php echo $value['disabled'] ? '未启用' : '<span style="font-weight:bold;color:green;">启用</span>'; ?></td>
			<td class="tdcenter"><?php echo $value['hits']; ?></td>
			<td class="tdcenter"><?php if($value['last_hits_time']) echo date('Y-m-d H:i:s', $value['last_hits_time']); ?></td>
			<td class="tdcenter">
				<a href="plugin.php?plugin=kl_comment_manage&field=<?php echo $value['field'];?>&sign=<?php echo $value['sign'];?>&keyword=<?php echo $value['keyword'];?>">查看</a>
				<a href="plugin.php?plugin=kl_comment_manage&act=rules&do=edit&id=<?php echo $value['id']; ?>">编辑</a>
				<a href="plugin.php?plugin=kl_comment_manage&act=rules&do=del&id=<?php echo $value['id']; ?>" onclick="javascript:if(!confirm('确定要删除此规则？')){return false;}" class="care">删除</a>
			</td>
		</tr>
	<?php $i++;endforeach;else:?>
		<tr><td class="tdcenter" colspan="6">还没有添加相关规则</td></tr>
	<?php endif;?>
	</tbody>
</table>
<div class="page">(共有<?php echo count($rules); ?>条规则)</div>
<script type="text/javascript">
$("#kl_comment_manage").addClass('sidebarsubmenu1');
$(document).ready(function(){
	$("#kl_comment_manage_list tbody tr:odd").addClass("tralt_b");
	$("#kl_comment_manage_list tbody tr").mouseover(function(){$(this).addClass("trover")}).mouseout(function(){$(this).removeClass("trover")})
});
</script>
<?php
	}else{
		$field = !empty($_GET['field']) ? addslashes($_GET['field']) : '';
		$sign = !empty($_GET['sign']) ? addslashes($_GET['sign']) : '';
		$keyword = !empty($_GET['keyword']) ? addslashes(trim($_GET['keyword'])) : '';
		$kl_num = !empty($_GET['kl_num']) ? intval($_GET['kl_num']) : 50;
		$hide = isset($_GET['hide']) ? addslashes($_GET['hide']) : '';
		$fanwei = isset($_POST['fanwei']) ? intval($_POST['fanwei']) : 0;
		if($fanwei){
			$argu = isset($_POST['argu']) ? $_POST['argu'] : '';
			if(!empty($argu)){
				$arguArr = unserialize(base64_decode($argu));
			}
			compact($arguArr);
		}else{
			$arguArr = array('field'=>$field, 'sign'=>$sign, 'keyword'=>$keyword, 'hide'=>$hide);
			$arguStr = base64_encode(serialize($arguArr));
		}
		$condition = '1';
		$addUrl = "&field={$field}&sign={$sign}&keyword={$keyword}&kl_num={$kl_num}";
		if(!empty($keyword)){
			if($keyword == $japanese_chars_mark && in_array($field, array('comment','poster'))){
				$condition .= " AND a.{$field} REGEXP '({$japanese_chars_long})+'";
			}elseif($sign == 'eq'){
				$condition .= " AND a.{$field}='{$keyword}'";
			}elseif($sign == 'neq'){
				$condition .= " AND a.{$field}!='{$keyword}'";
			}elseif($sign == 'leq'){
				$condition .= " AND a.{$field} LIKE '{$keyword}%'";
			}elseif($sign == 'req'){
				$condition .= " AND a.{$field} LIKE '%{$keyword}'";
			}elseif($sign == 'like'){
				$condition .= " AND a.{$field} LIKE '%{$keyword}%'";
			}
		}
		$condition_b = $condition;
		$addUrl_b = $addUrl;
		if($hide) {
			$addUrl .= "&hide=$hide";
			$condition .= " AND a.hide='{$hide}'";
		}
		if(isset($_GET['do']) && trim($_GET['do']) == 'shieldname'){
			$id = isset($_GET['id']) ? intval($_GET['id']) : '';
			$DB->query("UPDATE ".DB_PREFIX."comment SET poster='该昵称已屏蔽' WHERE cid={$id}");
			$CACHE->updateCache(array('sta','comment'));
			emDirect("./plugin.php?plugin=kl_comment_manage{$addUrl}&page={$page}&active_shieldname=1");
		}elseif(isset($_GET['do']) && trim($_GET['do']) == 'delurl'){
			$id = isset($_GET['id']) ? intval($_GET['id']) : '';
			$DB->query("UPDATE ".DB_PREFIX."comment SET url='' WHERE cid={$id}");
			$CACHE->updateCache(array('sta','comment'));
			emDirect("./plugin.php?plugin=kl_comment_manage{$addUrl}&page={$page}&active_delurl=1");
		}elseif(isset($_GET['do']) && trim($_GET['do']) == 'del'){
			$id = isset($_GET['id']) ? intval($_GET['id']) : '';
			$Comment_Model = new Comment_Model();
			$Comment_Model->delComment($id);
			$CACHE->updateCache(array('sta','comment'));
			emDirect("./plugin.php?plugin=kl_comment_manage{$addUrl}&page={$page}&active_del=1");
		}elseif(isset($_GET['do']) && trim($_GET['do']) == 'pub'){
			$id = isset($_GET['id']) ? intval($_GET['id']) : '';
			$Comment_Model = new Comment_Model();
			$Comment_Model->showComment($id);
			$CACHE->updateCache(array('sta','comment'));
			emDirect("./plugin.php?plugin=kl_comment_manage{$addUrl}&page={$page}&active_pub=1");
		}elseif(isset($_GET['do']) && trim($_GET['do']) == 'hide'){
			$id = isset($_GET['id']) ? intval($_GET['id']) : '';
			$Comment_Model = new Comment_Model();
			$Comment_Model->hideComment($id);
			$CACHE->updateCache(array('sta','comment'));
			emDirect("./plugin.php?plugin=kl_comment_manage{$addUrl}&page={$page}&active_hide=1");
		}elseif(isset($_GET['do']) && trim($_GET['do']) == 'admin_all_coms'){
			$operate = isset($_POST['operate']) ? $_POST['operate'] : '';
			if($fanwei){
				$sql = 'select cid from '.DB_PREFIX.'comment a where '.$condition;
				$query = $DB->query($sql);
				$comments = array();
				while($row = $DB->fetch_array($query)){
					$comments[] = $row['cid'];
				}
			}else{
				$comments = isset($_POST['com']) ? array_map('intval', $_POST['com']) : array();
			}
			$commentsId = '('.implode(',',$comments).')';
			switch ($operate) {
				case 'shieldname':
					$DB->query("UPDATE ".DB_PREFIX."comment SET poster='该昵称已屏蔽' WHERE cid IN{$commentsId}");
					$CACHE->updateCache(array('sta','comment'));
					emDirect("./plugin.php?plugin=kl_comment_manage{$addUrl}&page={$page}&active_admin_all_coms_shieldname=1");
					break;
				case 'delurl':
					$DB->query("UPDATE ".DB_PREFIX."comment SET url='' WHERE cid IN{$commentsId}");
					$CACHE->updateCache(array('sta','comment'));
					emDirect("./plugin.php?plugin=kl_comment_manage{$addUrl}&page={$page}&active_admin_all_coms_delurl=1");
					break;
				case 'del':
					if(function_exists('set_time_limit')) set_time_limit(0);
					$Comment_Model = new Comment_Model();
					$Comment_Model->batchComment('delcom', $comments);
					$CACHE->updateCache(array('sta','comment'));
					emDirect("./plugin.php?plugin=kl_comment_manage{$addUrl}&page={$page}&active_admin_all_coms_del=1");
					break;
				case 'pub':
					if(function_exists('set_time_limit')) set_time_limit(0);
					$Comment_Model = new Comment_Model();
					$Comment_Model->batchComment('showcom', $comments);
					$CACHE->updateCache(array('sta','comment'));
					emDirect("./plugin.php?plugin=kl_comment_manage{$addUrl}&page={$page}&active_admin_all_coms_pub=1");
					break;
				case 'hide':
					if(function_exists('set_time_limit')) set_time_limit(0);
					$Comment_Model = new Comment_Model();
					$Comment_Model->batchComment('hidecom', $comments);
					$CACHE->updateCache(array('sta','comment'));
					emDirect("./plugin.php?plugin=kl_comment_manage{$addUrl}&page={$page}&active_admin_all_coms_hide=1");
					break;
			}
		}elseif(isset($_GET['do']) && trim($_GET['do']) == 'save'){
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
			emDirect("./plugin.php?plugin=kl_comment_manage{$addUrl}&page={$page}&active_save=1");
			break;
		}elseif(isset($_GET['do']) && trim($_GET['do']) == 'edit'){
			$Comment_Model = new Comment_Model();
			$id = isset($_GET['id']) ? intval($_GET['id']) : '';
			$sql = "select * from ".DB_PREFIX."comment where cid=$id";
			$res = $DB->query($sql);
			if ($DB->affected_rows() < 1) {
				exit('没找到此评论');
			}
			$commentArray = $DB->fetch_array($res);
			extract($commentArray);
?>
<div class=containertitle><b>评论管理</b><?php echo $warning_msg;?></div>
<div class=line></div>
<div class="containertitle2">
<a class="navi3" href="?plugin=kl_comment_manage">批量管理</a>
<a class="navi4" href="?plugin=kl_comment_manage&act=rules">自定义规则</a>
</div>
<form action="./plugin.php?plugin=kl_comment_manage<?php echo $addUrl; ?>&page=<?php echo $page; ?>&do=save" method="post">
<h2>修改id为 <?php echo $id;?> 的评论：</h2>
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
	<input type="hidden" value="<?php echo $id; ?>" name="cid" />
	<input type="submit" value="保 存" class="submit" />
	<input type="button" value="取 消" class="submit" onclick="javascript: window.history.back();" /></li>
</div>
</form>
<?php
exit;
		}
		$perpage_num = $kl_num;
		if($page)
		{
			$startId = ($page - 1) * $perpage_num;
			$limit = " LIMIT $startId, ".$perpage_num;
		}
		$sql = "SELECT a.cid,a.hide,a.date,a.comment,a.gid,a.poster,a.ip,a.mail,a.url,b.title FROM ".DB_PREFIX."comment as a, ".DB_PREFIX."blog as b where {$condition} AND a.gid=b.gid ORDER BY a.cid DESC";
		$query = $DB->query($sql);
		$cmnum = $DB->num_rows($query);
		$query = $DB->query($sql.$limit);
		$pageurl = pagination($cmnum, $perpage_num, $page, "./plugin.php?plugin=kl_comment_manage{$addUrl}&page=");
		$sql = "SELECT a.cid,a.hide,a.date,a.comment,a.gid,a.poster,a.ip,a.mail,a.url,b.title FROM ".DB_PREFIX."comment as a, ".DB_PREFIX."blog as b where {$condition_b} AND a.gid=b.gid ORDER BY a.cid DESC";
		$cmnum = $DB->num_rows($DB->query($sql));
		$sql = "SELECT a.cid,a.hide,a.date,a.comment,a.gid,a.poster,a.ip,a.mail,a.url,b.title FROM ".DB_PREFIX."comment as a, ".DB_PREFIX."blog as b where {$condition_b} AND a.hide='y' AND a.gid=b.gid ORDER BY a.cid DESC";
		$hideCommNum = $DB->num_rows($DB->query($sql));
		$hide_ = $hide_y = $hide_n = '';
		$a = "hide_$hide";
		$$a = "class=\"filter\"";
?>
<div class=containertitle><b>评论管理【插件】</b><span style="font-size:12px;color:#999999;">（版本：<?php echo KL_COMMENT_MANAGE_VERSION;?>）</span><?php echo $warning_msg;?></div>
<div class=line></div>
<div class="containertitle2">
<a class="navi3" href="?plugin=kl_comment_manage">批量管理</a>
<a class="navi4" href="?plugin=kl_comment_manage&act=rules">自定义规则</a>
<?php if(isset($_GET['active_shieldname'])):?><span class="actived">屏蔽昵称成功</span><?php endif;?>
<?php if(isset($_GET['active_delurl'])):?><span class="actived">删除地址成功</span><?php endif;?>
<?php if(isset($_GET['active_del'])):?><span class="actived">删除评论成功</span><?php endif;?>
<?php if(isset($_GET['active_pub'])):?><span class="actived">审核成功</span><?php endif;?>
<?php if(isset($_GET['active_hide'])):?><span class="actived">屏蔽评论成功</span><?php endif;?>
<?php if(isset($_GET['active_save'])):?><span class="actived">评论修改成功</span><?php endif;?>
<?php if(isset($_GET['active_admin_all_coms_shieldname'])):?><span class="actived">批量屏蔽昵称成功</span><?php endif;?>
<?php if(isset($_GET['active_admin_all_coms_delurl'])):?><span class="actived">批量删除地址成功</span><?php endif;?>
<?php if(isset($_GET['active_admin_all_coms_del'])):?><span class="actived">批量删除评论成功</span><?php endif;?>
<?php if(isset($_GET['active_admin_all_coms_pub'])):?><span class="actived">批量审核成功</span><?php endif;?>
<?php if(isset($_GET['active_admin_all_coms_hide'])):?><span class="actived">批量屏蔽评论成功</span><?php endif;?>
</div>
<form action="./plugin.php?plugin=kl_comment_manage" method="GET">
	<input type="hidden" name="plugin" value="kl_comment_manage" />
	<span style="color:#999;font-size:24px;">查询条件：</span>
	<select id="field" name="field">
		<?php foreach($field_arr as $fk => $fv):?>
		<option value="<?php echo $fk;?>"<?php if(!empty($field) && $field==$fk) echo ' selected';?>><?php echo $fv;?></option>
		<?php endforeach;?>
	</select>
	<select id="sign" name="sign">
		<?php foreach($sign_arr as $sk => $sv):?>
		<option value="<?php echo $sk;?>"<?php if(!empty($sign) && $sign==$sk) echo ' selected';?>><?php echo $sv;?></option>
		<?php endforeach;?>
	</select>
	<input id="input_s" name="keyword" value="<?php if(!empty($_GET['keyword'])) echo $_GET['keyword'];?>" />
	<select name="kl_num">
		<option value="50"<?php if(!empty($kl_num) && $kl_num==50) echo ' selected';?>>每页显示50条</option>
		<option value="100"<?php if(!empty($kl_num) && $kl_num==100) echo ' selected';?>>每页显示100条</option>
		<option value="200"<?php if(!empty($kl_num) && $kl_num==200) echo ' selected';?>>每页显示200条</option>
		<option value="300"<?php if(!empty($kl_num) && $kl_num==300) echo ' selected';?>>每页显示300条</option>
		<option value="500"<?php if(!empty($kl_num) && $kl_num==500) echo ' selected';?>>每页显示500条</option>
	</select>
	<input type="submit" value="查询" />
	<?php if(!empty($field) && !empty($sign) && !empty($keyword)):?>
	<?php
	$the_rules = kl_comment_manage_get_rules();
	$the_arr = array_merge($the_rules['anti'][$field], $the_rules['hide'][$field], $the_rules['pub'][$field]);
	$display = true;
	foreach($the_arr as $tav){
		if($tav['sign'] == $sign && $tav['keyword'] == $keyword){
			$display = false;
			break;
		}
	}
	if($display):
	?>
	<!--<input id="do_btn" type="button" value="将此条件加入自定义规则" />-->
	<br />
	<div style="border:1px dashed #ccc;margin:5px 0px;padding-left:5px;background:#FDFFCE">
		<span style="color:#666;">将此条件加入自定义规则：当前台发表的评论符合此条件时</span>
		<select id="operate_b" name="operate_b" style="color:#666;">
			<option value="anti">不让发表</option>
			<option value="hide">不通过审核</option>
			<option value="pub">审核通过</option>
		</select>
		<select id="disabled" name="disabled" style="color:#666;">
			<option value="0">启用</option>
			<option value="1">暂不启用</option>
		</select>
		<input id="do_btn" type="button" value="保存此规则" style="color:#666;" /><div id="kl_comment_manage_msg" style="display:inline;"></div>
	</div>
	<?php endif;?>
	<?php endif;?>
</form>
<div class="filters">
<span <?php echo $hide_; ?>><a href="./plugin.php?plugin=kl_comment_manage<?php echo $addUrl_b; ?>">全部(<?php echo $cmnum;?>)</a></span>
<span <?php echo $hide_y; ?>><a href="./plugin.php?plugin=kl_comment_manage&hide=y<?php echo $addUrl_b; ?>">待审(<?php echo $hideCommNum;?>)</a></span>
<span <?php echo $hide_n; ?>><a href="./plugin.php?plugin=kl_comment_manage&hide=n<?php echo $addUrl_b; ?>">已审(<?php echo $cmnum-$hideCommNum;?>)</a></span>
<span style="margin-left:80px;color:#999;">*关键词中输入 <a href="./plugin.php?plugin=kl_comment_manage&field=comment&sign=like&keyword=%5Bjapanese%5D&kl_num=50">[japanese]</a> 为搜索含日文的评论（仅支持昵称和评论字段）</span>
</div>
<form action="./plugin.php?plugin=kl_comment_manage<?php echo $addUrl; ?>&page=<?php echo $page; ?>&do=admin_all_coms" method="post" name="form_com" id="form_com">
	<table width="100%" id="adm_comment_list" class="item_list">
		<thead>
			<tr>
				<th width="419" colspan="2"><b>内容</b></th>
				<th width="280"><b>评论者</b></th>
				<th width="220"><b>所属日志</b></th>
			</tr>
		</thead>
		<tbody>
		<?php
		$ress = array();
		while($res = $DB->fetch_array($query)) array_push($ress, $res);
		if($ress){
		foreach($ress as $res):
		$ishide = $res['hide']=='y'?'<font color="red">[待审]</font>':'';
		$mail = !empty($res['mail']) ? "(<a title=\"查看的所有邮箱为&quot;{$res['mail']}&quot;的评论\" href=\"./plugin.php?plugin=kl_comment_manage&field=mail&sign=eq&keyword=".urlencode($res['mail'])."\">{$res['mail']}</a>)" : '';
		$ip = !empty($res['ip']) ? "<br />IP：<a title=\"查看的所有IP为&quot;{$res['ip']}&quot;的评论\" href=\"./plugin.php?plugin=kl_comment_manage&field=ip&sign=eq&keyword={$res['ip']}\">{$res['ip']}</a>" : '';
		$url = !empty($res['url']) ? "(<a title=\"查看的所有URL为&quot;{$res['url']}&quot;的评论\" href=\"./plugin.php?plugin=kl_comment_manage&field=url&sign=eq&keyword=".urlencode($res['url'])."\">{$res['url']}</a>)" : '';
		$res['content'] = str_replace('<br>',' ',$res['comment']);
		$sub_content = subString($res['content'], 0, 50);
		$res['title'] = subString($res['title'], 0, 42);
		?>
			<tr>
				<td><input type="checkbox" value="<?php echo $res['cid']; ?>" name="com[]" class="ids" /></td>
				<td><a href="plugin.php?plugin=kl_comment_manage<?php echo $addUrl; ?>&page=<?php echo $page; ?>&do=edit&id=<?php echo $res['cid']; ?>" title="<?php echo $res['content']; ?>"><?php echo $sub_content; ?></a> <?php echo $ishide; ?>
				<br /><?php echo smartDate($res['date']); ?>
				<span style="display:none; margin-left:8px;">
				<a href="plugin.php?plugin=kl_comment_manage<?php echo $addUrl; ?>&page=<?php echo $page; ?>&do=del&id=<?php echo $res['cid']; ?>" onclick="javascript:if(!confirm('你确定要删除所选的评论吗？')){return false;}" class="care">删除评论</a>
				<a href="plugin.php?plugin=kl_comment_manage<?php echo $addUrl; ?>&page=<?php echo $page; ?>&do=shieldname&id=<?php echo $res['cid']; ?>" onclick="javascript:if(!confirm('你确定要屏蔽该评论人昵称？')){return false;}" class="care">屏蔽昵称</a>
				<a href="plugin.php?plugin=kl_comment_manage<?php echo $addUrl; ?>&page=<?php echo $page; ?>&do=delurl&id=<?php echo $res['cid']; ?>" onclick="javascript:if(!confirm('你确定要删除该评论人地址吗？')){return false;}" class="care">删除地址</a>
				<?php if($res['hide'] == 'y'):?>
				<a href="plugin.php?plugin=kl_comment_manage<?php echo $addUrl; ?>&page=<?php echo $page; ?>&do=pub&id=<?php echo $res['cid']; ?>">审核</a>
				<?php else:?>
				<a href="plugin.php?plugin=kl_comment_manage<?php echo $addUrl; ?>&page=<?php echo $page; ?>&do=hide&id=<?php echo $res['cid']; ?>">屏蔽</a>
				<?php endif;?>
				</span>
				</td>
				<td><a title="查看的所有评论者为&quot;<?php echo $res['poster'];?>&quot;的评论" href="./plugin.php?plugin=kl_comment_manage&field=poster&sign=eq&keyword=<?php echo urlencode($res['poster']);?>"><?php echo htmlspecialchars($res['poster']);?></a> <?php echo $url; ?> <?php echo $ip;?> <?php echo $mail;?></td>
				<td><a title="查看文章为&quot;<?php echo $res['title'];?>&quot;的所有评论" href="./plugin.php?plugin=kl_comment_manage&field=gid&sign=eq&keyword=<?php echo $res['gid']; ?>"><?php echo $res['title']; ?></a></td>
			</tr>
		<?php endforeach;}else{ ?>
		<tr><td class="tdcenter" colspan="4">没有找到符合条件的评论</td></tr>
		<?php }?>
		</tbody>
	</table>
	<div class="list_footer">
	<a href="javascript:void(0);" id="select_all">全选</a> 
	<select id="fanwei" name="fanwei">
		<option value="0">选中的评论</option>
		<option value="1">此条件下的全部评论</option>
	</select>
	<a href="javascript:kl_commentact('del');" class="care">删除评论</a>
	<a href="javascript:kl_commentact('shieldname');" class="care">屏蔽昵称</a>
	<a href="javascript:kl_commentact('delurl');" class="care">删除地址</a>
	<a href="javascript:kl_commentact('pub');">审核</a>
	<a href="javascript:kl_commentact('hide');">屏蔽</a>
	<input name="operate" id="operate" type="hidden" />
	<input name="argu" type="hidden" value="<?php echo $arguStr;?>" />
	</div>
	<div class="page"><?php echo $pageurl; ?> (有<?php echo $cmnum; ?>条评论)</div> 
</form>
<script>
$("#kl_comment_manage").addClass('sidebarsubmenu1');
$(document).ready(function(){
	<?php if(!empty($field) && !empty($sign) && !empty($keyword)):?>
	$('#field').change(function(){$('#do_btn,#operate_b,#disabled').attr('disabled', 'disabled');});
	$('#sign').change(function(){$('#do_btn,#operate_b,#disabled').attr('disabled', 'disabled');});
	$('#input_s').change(function(){$('#do_btn,#operate_b,#disabled').attr('disabled', 'disabled');});
	$('#do_btn').click(function(){
		$('#kl_comment_manage_msg').html('操作中..');
		$.post('../content/plugins/kl_comment_manage/kl_comment_manage_ajax.php',
		{sid:Math.random(), 'field':'<?php echo $field;?>', 'sign':'<?php echo $sign;?>', 'keyword':'<?php echo $keyword;?>', 'operate':$('#operate_b').val(), 'disabled':$('#disabled').val()},
		function(result){
			if($.trim(result)!=''){
				$('#kl_comment_manage_msg').html(result);
			}else{
				$('#kl_comment_manage_msg').html('操作失败！');
			}
		});
	});
	<?php endif;?>
	$("#select_all").toggle(function () {$(".ids").attr("checked", "checked");},function () {$(".ids").removeAttr("checked");});
	$("#adm_comment_list tbody tr:odd").addClass("tralt_b");
	$("#adm_comment_list tbody tr")
		.mouseover(function(){$(this).addClass("trover");$(this).find("span").show();})
		.mouseout(function(){$(this).removeClass("trover");$(this).find("span").hide();})
});
function emptyAjaxMsg(){
	$('#kl_comment_manage_msg').html('');
}
setTimeout(emptyAjaxMsg,5200);
setTimeout(hideActived,2600);
function kl_commentact(act){
	if ($('#fanwei').val()==0 && getChecked('ids') == false) {
		alert('请选择要操作的评论');
		return;
	}
	if(act == 'shieldname' && !confirm('你确定要屏蔽评论人昵称吗？')){return;}
	if(act == 'delurl' && !confirm('你确定要删除评论人地址吗？')){return;}
	if(act == 'del' && !confirm('你确定要删除评论吗？')){return;}
	$("#operate").val(act);
	$("#form_com").submit();
}
</script>
<?php
	}
}

function plugin_setting(){}