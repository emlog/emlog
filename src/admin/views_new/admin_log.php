<?php
if(!defined('EMLOG_ROOT')) {exit('error!');}
$isdraft = $pid == 'draft' ? '&pid=draft' : '';
$isDisplaySort = !$sid ? "style=\"display:none;\"" : '';
$isDisplayTag = !$tagId ? "style=\"display:none;\"" : '';
$isDisplayUser = !$uid ? "style=\"display:none;\"" : '';
?>
<div class="containertitle"><b><?php echo $pwd; ?></b>
<?php if(isset($_GET['active_del'])):?><span class="actived">删除成功</span><?php endif;?>
<?php if(isset($_GET['active_up'])):?><span class="actived">置顶成功</span><?php endif;?>
<?php if(isset($_GET['active_down'])):?><span class="actived">取消置顶成功</span><?php endif;?>
<?php if(isset($_GET['error_a'])):?><span class="error">请选择要处理的文章</span><?php endif;?>
<?php if(isset($_GET['error_b'])):?><span class="error">请选择要执行的操作</span><?php endif;?>
<?php if(isset($_GET['active_post'])):?><span class="actived">发布成功</span><?php endif;?>
<?php if(isset($_GET['active_move'])):?><span class="actived">移动成功</span><?php endif;?>
<?php if(isset($_GET['active_change_author'])):?><span class="actived">更改作者成功</span><?php endif;?>
<?php if(isset($_GET['active_hide'])):?><span class="actived">转入草稿箱成功</span><?php endif;?>
<?php if(isset($_GET['active_savedraft'])):?><span class="actived">草稿保存成功</span><?php endif;?>
<?php if(isset($_GET['active_savelog'])):?><span class="actived">保存成功</span><?php endif;?>
<?php if(isset($_GET['active_ck'])):?><span class="actived">文章审核成功</span><?php endif;?>
<?php if(isset($_GET['active_unck'])):?><span class="actived">文章驳回成功</span><?php endif;?>
</div>
<div class=line></div>
<div class="filters">
<div id="f_title">
	<div style="float:left; margin-top:8px;">
		<span <?php echo !$sid && !$tagId && !$uid && !$keyword ? "class=\"filter\"" : ''; ?>><a href="./admin_log.php?<?php echo $isdraft; ?>">全部</a></span>
        <span id="f_t_sort">
            <select name="bysort" id="bysort" onChange="selectSort(this);" style="width:110px;">
            <option value="" selected="selected">按分类查看...</option>
            <?php 
            foreach($sorts as $key=>$value):
            if ($value['pid'] != 0) {
                continue;
            }
            $flg = $value['sid'] == $sid ? 'selected' : '';
            ?>
            <option value="<?php echo $value['sid']; ?>" <?php echo $flg; ?>><?php echo $value['sortname']; ?></option>
            <?php
                $children = $value['children'];
                foreach ($children as $key):
                $value = $sorts[$key];
                $flg = $value['sid'] == $sid ? 'selected' : '';
            ?>
            <option value="<?php echo $value['sid']; ?>" <?php echo $flg; ?>>&nbsp; &nbsp; &nbsp; <?php echo $value['sortname']; ?></option>
            <?php
            endforeach;
            endforeach;
            ?>
            <option value="-1" <?php if($sid == -1) echo 'selected'; ?>>未分类</option>
            </select>
        </span>
        <?php if (ROLE == ROLE_ADMIN && count($user_cache) > 1):?>
        <span id="f_t_user">
            <select name="byuser" id="byuser" onChange="selectUser(this);" style="width:110px;">
                <option value="" selected="selected">按作者查看...</option>
                <?php 
                foreach($user_cache as $key=>$value):
                $flg = $key == $uid ? 'selected' : '';
                ?>
                <option value="<?php echo $key; ?>" <?php echo $flg; ?>><?php echo $value['name']; ?></option>
                <?php
                endforeach;
                ?>
            </select>
        </span>
        <?php endif;?>
        <span id="f_t_tag"><a href="javascript:void(0);">按标签查看</a></span>
	</div>
	<div style="float:right;">
		<form action="admin_log.php" method="get">
		<input type="text" id="input_s" name="keyword">
		<?php if($pid):?>
		<input type="hidden" id="pid" name="pid" value="draft">
		<?php endif;?>
		</form>
	</div>
	<div style="clear:both"></div>
</div>
<div id="f_tag" <?php echo $isDisplayTag ?>>
	标签：
	<?php 
    if(empty($tags)) echo '还没有标签';
    foreach($tags as $val):
		$a = 'tag_'.$val['tid'];
		$$a = '';
		$b = 'tag_'.$tagId;
		$$b = "class=\"filter\"";
	?>
	<span <?php echo $$a; ?>><a href="./admin_log.php?tagid=<?php echo $val['tid'].$isdraft; ?>"><?php echo $val['tagname']; ?></a></span>
	<?php endforeach;?>
</div>
</div>
<form action="admin_log.php?action=operate_log" method="post" name="form_log" id="form_log">
  <input type="hidden" name="pid" value="<?php echo $pid; ?>">
  <table class="table table-striped table-bordered table-hover dataTable no-footer">
  <thead>
      <tr>
        <th width="511" colspan="2"><b>标题</b></th>
		<?php if ($pid != 'draft'): ?>
		<th width="40" class="tdcenter"><b>查看</b></th>
		<?php endif; ?>
		<th width="100"><b>作者</b></th>
        <th width="146"><b>分类</b></th>
        <th width="130"><b><a href="./admin_log.php?sortDate=<?php echo $sortDate.$sorturl; ?>">时间</a></b></th>
		<th width="39" class="tdcenter"><b><a href="./admin_log.php?sortComm=<?php echo $sortComm.$sorturl; ?>">评论</a></b></th>
		<th width="59" class="tdcenter"><b><a href="./admin_log.php?sortView=<?php echo $sortView.$sorturl; ?>">阅读</a></b></th>
      </tr>
	</thead>
 	<tbody>
	<?php
	if($logs):
	foreach($logs as $key=>$value):
	$sortName = $value['sortid'] == -1 && !array_key_exists($value['sortid'], $sorts) ? '未分类' : $sorts[$value['sortid']]['sortname'];
	$author = $user_cache[$value['author']]['name'];
    $author_role = $user_cache[$value['author']]['role'];
	?>
      <tr>
      <td width="21"><input type="checkbox" name="blog[]" value="<?php echo $value['gid']; ?>" class="ids" /></td>
      <td width="490"><a href="write_log.php?action=edit&gid=<?php echo $value['gid']; ?>"><?php echo $value['title']; ?></a>
      <?php if($value['top'] == 'y'): ?><img src="./views/images/top.png" align="top" title="首页置顶" /><?php endif; ?>
      <?php if($value['sortop'] == 'y'): ?><img src="./views/images/sortop.png" align="top" title="分类置顶" /><?php endif; ?>
	  <?php if($value['attnum'] > 0): ?><img src="./views/images/att.gif" align="top" title="附件：<?php echo $value['attnum']; ?>" /><?php endif; ?>
      <?php if($pid != 'draft' && $value['checked'] == 'n'): ?><sapn style="color:red;"> - 待审</sapn><?php endif; ?>
      <span style="display:none; margin-left:8px;">
		<?php if($pid != 'draft' && ROLE == ROLE_ADMIN && $value['checked'] == 'n'): ?>
		<a href="./admin_log.php?action=operate_log&operate=check&gid=<?php echo $value['gid']?>&token=<?php echo LoginAuth::genToken(); ?>">审核</a> 
        <?php elseif($pid != 'draft' && ROLE == ROLE_ADMIN && $author_role == ROLE_WRITER):?>
        <a href="./admin_log.php?action=operate_log&operate=uncheck&gid=<?php echo $value['gid']?>&token=<?php echo LoginAuth::genToken(); ?>">驳回</a> 
        <?php endif;?>
      </span>
      </td>
	  <?php if ($pid != 'draft'): ?>
	  <td class="tdcenter">
	  <a href="<?php echo Url::log($value['gid']); ?>" target="_blank" title="在新窗口查看">
	  <img src="./views/images/vlog.gif" align="absbottom" border="0" /></a>
	  </td>
	  <?php endif; ?>
      <td><a href="./admin_log.php?uid=<?php echo $value['author'].$isdraft;?>"><?php echo $author; ?></a></td>
      <td><a href="./admin_log.php?sid=<?php echo $value['sortid'].$isdraft;?>"><?php echo $sortName; ?></a></td>
      <td><?php echo $value['date']; ?></td>
	  <td class="tdcenter"><a href="comment.php?gid=<?php echo $value['gid']; ?>"><?php echo $value['comnum']; ?></a></td>
	  <td class="tdcenter"><?php echo $value['views']; ?></a></td>
      </tr>
	<?php endforeach;else:?>
	  <tr><td class="tdcenter" colspan="8">还没有文章</td></tr>
	<?php endif;?>
	</tbody>
	</table>
    <input name="token" id="token" value="<?php echo LoginAuth::genToken(); ?>" type="hidden" />
	<input name="operate" id="operate" value="" type="hidden" />
	<div class="list_footer">
	<a href="javascript:void(0);" id="select_all">全选</a> 选中项：
    <a href="javascript:logact('del');" class="care">删除</a> | 
	<?php if($pid == 'draft'): ?>
	<a href="javascript:logact('pub');">发布</a>
	<?php else: ?>
	<a href="javascript:logact('hide');">放入草稿箱</a> | 

	<?php if (ROLE == ROLE_ADMIN):?>
    <select name="top" id="top" onChange="changeTop(this);" style="width:90px;">
        <option value="" selected="selected">置顶操作...</option>
        <option value="top">首页置顶</option>
        <option value="sortop">分类置顶</option>
        <option value="notop">取消置顶</option>
    </select>
    <?php endif;?>

	<select name="sort" id="sort" onChange="changeSort(this);" style="width:110px;">
	<option value="" selected="selected">移动到分类...</option>

    <?php 
    foreach($sorts as $key=>$value):
	if ($value['pid'] != 0) {
		continue;
	}
    ?>
    <option value="<?php echo $value['sid']; ?>"><?php echo $value['sortname']; ?></option>
	<?php
		$children = $value['children'];
		foreach ($children as $key):
		$value = $sorts[$key];
	?>
    <option value="<?php echo $value['sid']; ?>">&nbsp; &nbsp; &nbsp; <?php echo $value['sortname']; ?></option>
	<?php
    endforeach;
    endforeach;
    ?>
	<option value="-1">未分类</option>
	</select>

	<?php if (ROLE == ROLE_ADMIN && count($user_cache) > 1):?>
	<select name="author" id="author" onChange="changeAuthor(this);" style="width:110px;">
	<option value="" selected="selected">更改作者为...</option>
	<?php foreach($user_cache as $key => $val):
	$val['name'] = $val['name'];
	?>
	<option value="<?php echo $key; ?>"><?php echo $val['name']; ?></option>
	<?php endforeach;?>
	</select>
	<?php endif;?>

	<?php endif;?>
	</div>
</form>
<div class="page"><?php echo $pageurl; ?> (有<?php echo $logNum; ?>篇<?php echo $pid == 'draft' ? '草稿' : '文章'; ?>)</div>
<script>
$(document).ready(function(){
	$("#f_t_tag").click(function(){$("#f_tag").toggle();$("#f_sort").hide();$("#f_user").hide();});
	//$("#select_all").toggle(function () {$(".ids").attr("checked", "checked");},function () {$(".ids").removeAttr("checked");});
});
setTimeout(hideActived,2600);
function logact(act){
	if (getChecked('ids') == false) {
		alert('请选择要操作的文章');
		return;}
	if(act == 'del' && !confirm('你确定要删除所选文章吗？')){return;}
	$("#operate").val(act);
	$("#form_log").submit();
}
function changeSort(obj) {
	if (getChecked('ids') == false) {
		alert('请选择要操作的文章');
		return;}
	if($('#sort').val() == '')return;
	$("#operate").val('move');
	$("#form_log").submit();
}
function changeAuthor(obj) {
	if (getChecked('ids') == false) {
		alert('请选择要操作的文章');
		return;}
	if($('#author').val() == '')return;
	$("#operate").val('change_author');
	$("#form_log").submit();
}
function changeTop(obj) {
	if (getChecked('ids') == false) {
		alert('请选择要操作的文章');
		return;}
	if($('#top').val() == '')return;
	$("#operate").val(obj.value);
	$("#form_log").submit();
}
function selectSort(obj) {
    window.open("./admin_log.php?sid=" + obj.value + "<?php echo $isdraft?>", "_self");
}
function selectUser(obj) {
    window.open("./admin_log.php?uid=" + obj.value + "<?php echo $isdraft?>", "_self");
}
<?php if ($isdraft) :?>
$("#menu_draft").addClass('sidebarsubmenu1');
<?php else:?>
$("#menu_log").addClass('sidebarsubmenu1');
<?php endif;?>
</script>
