<?php if(!defined('ADMIN_ROOT')) {exit('error!');} ?>
<script type='text/javascript'>
$(document).ready(function(){
	$(".addItem a").click(function(){$(".addItem p").toggle("fast");});
	$("#adm_link_list tbody tr:odd").addClass("tralt_b");
	$("#adm_link_list tbody tr")
		.mouseover(function(){$(this).addClass("trover")})
		.mouseout(function(){$(this).removeClass("trover")})
});
setTimeout(hideActived,2600);
</script>
<div class=containertitle><b>友情链接</b>
<?php if(isset($_GET['active_taxis'])):?><span class="actived">排序更新成功</span><?php endif;?>
<?php if(isset($_GET['active_del'])):?><span class="actived">删除链接成功</span><?php endif;?>
<?php if(isset($_GET['active_edit'])):?><span class="actived">修改链接成功</span><?php endif;?>
<?php if(isset($_GET['active_add'])):?><span class="actived">添加链接成功</span><?php endif;?>
<?php if(isset($_GET['error_a'])):?><span class="error">站点名称和地址不能为空</span><?php endif;?>
</div>
<div class=line></div>
<form action="link.php?action=link_taxis" method="post">
  <table width="95%" align="center" id="adm_link_list">
    <thead>
      <tr class="rowstop">
        <td width="155"><b>友情链接</b></td>
        <td width="230"><b>排序</b></td>
		<td width="600"><b>描述</b></td>
        <td width="222"></td>
      </tr>
    </thead>
    <tbody>
	<?php foreach($links as $key=>$value):?>  
      <tr>
        <td><a href="<?php echo $value['siteurl']; ?>" target="_blank"><?php echo $value['sitename']; ?></a></td>
		<td><input size="18" name="link[<?php echo $value['id']; ?>]" value="<?php echo $value['taxis']; ?>" maxlength="4" /></td>
        <td><?php echo $value['description']; ?></td>
        <td><a href="link.php?action=mod_link&amp;linkid=<?php echo $value['id']; ?>">编辑</a>
        <a href="javascript: em_confirm(<?php echo $value['id']; ?>, 'link');">删除</a></td>
      </tr>
	<?php endforeach; ?>
    </tbody>
    <tfoot>
      <tr>
        <td align="center" colspan="4">
	  	<input type="submit" value="更新排序" class="submit2" />
      	<input type="reset" value="重置" class="submit2" />
		</td>
      </tr>
    </tfoot>
  </table>
</form>
<div class=containertitle><b>添加链接</b></div>
<div class=line></div>
<form action="link.php?action=addlink" method="post" name="link" id="link">
    <table cellspacing="1" cellpadding="4" width="95%" align="center" border="0">
      <tbody>
        <tr nowrap="nowrap">
          <td>站点名称
            <br />
            <input maxlength="200" size="35" name="sitename" />
            <br /></td></tr>
        <tr nowrap="nowrap">
          <td>地址（站点地址必须以http://开头）<br />
  <input maxlength="200" size="35" name="siteurl" />
              <br /></td>
        </tr>
        <tr nowrap="nowrap">
        <td>描述（可选）不得超过255字节<br />
			<textarea name="description" rows="5" cols="40" type="text"></textarea><br />
		  </td>
        </tr>
        <tr>
          <td colspan="2">
	 	 	<input type="submit" value="确 定" />
     		<input type="reset" value="重 置" />         
		  </td>
        </tr>
      </tbody>
    </table>
</form>