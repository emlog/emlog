<?php if(!defined('ADM_ROOT')) {exit('error!');} ?>
<div class=containertitle><b>友站管理</b></div>
<div class=line></div>
<form action="link.php?action=link_taxis" method="post">
  <table width="95%" align="center">
    <tbody>
      <tr class="rowstop">
        <td width="155"><b>友情站点</b></td>
        <td width="230"><b>站点排序</b></td>
		<td width="600"><b>描述</b></td>
        <td width="222"></td>
      </tr>
<?php foreach($links as $key=>$value):?>  
      <tr class="<?php echo $value['rowbg']; ?>">
        <td><a href="<?php echo $value['siteurl']; ?>" target="_blank"><?php echo $value['sitename']; ?></a></td>
		<td><input size="18" name="link[<?php echo $value['id']; ?>]" value="<?php echo $value['taxis']; ?>" maxlength="4" /></td>
        <td><?php echo $value['description']; ?></td>
        <td><a href="link.php?action=mod_link&amp;linkid=<?php echo $value['id']; ?>">编辑</a>
        <a href="javascript: isdel(<?php echo $value['id']; ?>, 2);">删除</a></td>
      </tr>
<?php endforeach; ?>  
	  
    </tbody>
  </table>
  <table width="95%" align="center">
    <tbody>
      <tr>
        <td align="center">
	  <input type="submit" value="确 定" class="submit2" />
      <input type="reset" value="重 置" class="submit2" />
		</td>
      </tr>
    </tbody>
  </table>
</form>
<div class=containertitle><b>添加友情站点</b></div>
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
          <td>地址<b>(</b>站点地址必须以http://开头)<br />
  <input maxlength="200" size="35" name="siteurl" />
              <br /></td>
        </tr>
        <tr nowrap="nowrap">
          <td>描述（可选）不得超过255字节<br />
  <textarea name="description" rows="5" cols="40" type="text"></textarea>
              <br /></td>
        </tr>
        <tr>
          <td align="center" colspan="2">
	  <input type="submit" value="确 定" class="submit2" />
      <input type="reset" value="重 置" class="submit2" />         
		  </td>
        </tr>
      </tbody>
    </table>
</form>