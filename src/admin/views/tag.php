<?php if(!defined('EMLOG_ROOT')) {exit('error!');}?>
<section class="content-header">
    <h1>标签管理</h1>
    <div class="containertitle">
    <?php if(isset($_GET['active_del'])):?><span class="alert alert-success">删除标签成功</span><?php endif;?>
    <?php if(isset($_GET['active_edit'])):?><span class="alert alert-success">修改标签成功</span><?php endif;?>
    <?php if(isset($_GET['error_a'])):?><span class="alert alert-danger">请选择要删除的标签</span><?php endif;?>
    </div>
</section>
<section class="content">
<div class=line></div>
<form action="tag.php?action=dell_all_tag" method="post" name="form_tag" id="form_tag">
<div>
<li>
<?php 
if($tags):
foreach($tags as $key=>$value): ?>	
<input type="checkbox" name="tag[<?php echo $value['tid']; ?>]" class="ids" value="1" >
<a href="tag.php?action=mod_tag&tid=<?php echo $value['tid']; ?>"><?php echo $value['tagname']; ?></a> &nbsp;&nbsp;&nbsp;
<?php endforeach; ?>
</li>
<input name="token" id="token" value="<?php echo LoginAuth::genToken(); ?>" type="hidden" />
<li style="margin:20px 0px">
<a href="javascript:void(0);" id="select_all">全选</a> 选中项：
<a href="javascript:deltags();" class="care">删除</a>
</li>
<?php else:?>
<li style="margin:20px 30px">还没有标签，写文章的时候可以给文章打标签</li>
<?php endif;?>
</div>
</form>
</section>
<script>
selectAllToggle();
function deltags(){
	if (getChecked('ids') == false) {
		alert('请选择要删除的标签');
		return;
	}
	if(!confirm('你确定要删除所选标签吗？')){return;}
	$("#form_tag").submit();
}
setTimeout(hideActived,2600);
$("#menu_tag").addClass('active');
</script>
