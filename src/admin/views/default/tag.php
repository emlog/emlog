<?php if(!defined('ADMIN_ROOT')) {exit('error!');}?>
<script>setTimeout(hideActived,2600);</script>
<div class=containertitle><b>标签管理</b>
<?php if(isset($_GET['active_del'])):?><span class="actived">删除标签成功</span><?php endif;?>
<?php if(isset($_GET['active_edit'])):?><span class="actived">修改标签成功</span><?php endif;?>
<?php if(isset($_GET['error_a'])):?><span class="error">请选择要删除的标签</span><?php endif;?>
</div>
<div class=line></div>
<form action="tag.php?action=dell_all_tag" method="post">
  <table width="95%" align="center">
    <tbody>
      <tr>
        <td width="800">
		<?php foreach($tags as $key=>$value): ?>	
		<input type="checkbox" name="tag[<?php echo $value['tid']; ?>]" value="1" >
		<a href="tag.php?action=mod_tag&tid=<?php echo $value['tid']; ?>"><?php echo $value['tagname']; ?></a> &nbsp;&nbsp;&nbsp;
		<?php endforeach; ?>
		</td>
      </tr>
    </tbody>
  </table>
  <table width="95%">
    <tbody>
      <tr>
        <td align="center" colspan="5">
		<input type="submit" value="删除所选标签" class="submit2" />
		</td>
      </tr>
    </tbody>
  </table>
</form>