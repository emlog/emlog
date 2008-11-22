<?php if(!defined('ADMIN_ROOT')) {exit('error!');}?>
<script>
function doautosave(){
	var title = $("title").value.Trim();
	if(title!=""){autosave('add_log.php?action=autosave','asmsg');}	
}
setTimeout("doautosave()",30000);
</script>
<div class=containertitle><b>编辑日志</b></div>
<div class=line></div>
  <form action="edit_log.php?action=edit" method="post" id="addlog" name="addlog">
    <table cellspacing="1" cellpadding="4" width="95%" align="center" border="0">
      <tbody>
        <tr nowrap="nowrap">
          <td><b>标题：</b><span id="auto_msg"></span><br />
          <input maxlength="200" style="width:500px;" name="title" id="title" value="<?php echo $title; ?>"/>
	        <select name="sort">
			<?php if($sortid < 0):?>
			<option value="-1">选择分类...</option>
			<?php endif;
			foreach($sorts as $val):
			$flg = $val['sid'] == $sortid ? 'selected' : '';
			?>
			<option value="<?php echo $val['sid']; ?>" <?php echo $flg; ?>><?php echo $val['sortname']; ?></option>
			<?php endforeach; ?>
	       </select>
          </td>
        </tr>
        <tr>
          <td>
              <table cellspacing="0" cellpadding="0" width="100%" border="0">
                  <tr>
                    <td>
					<b>内容：</b> <a href="javascript: displayToggle('FrameUpload');" class="thickbox">附件管理</a>
					<span id="asmsg"><input type="hidden" name="as_logid" id="as_logid" value="<?php echo $logid; ?>"></span><br />
					
					<div id="FrameUpload" style="display: none;"><iframe width="720" frameborder=0 height="160" frameborder=0 src="attachment.php?action=attlib&logid=<?php echo $logid; ?>"></iframe></div>
					
					<input type="hidden" id="content" name="content" value="<?php echo $content; ?>" style="display:none" />
					<input type="hidden" id="content___Config" value="CustomConfigurationsPath=fckeditor/fckconfig.js" style="display:none" />
					<iframe id="content___Frame" src="fckeditor/editor/fckeditor.html?InstanceName=content&amp;Toolbar=Default" width="720" height="460" frameborder="0" scrolling="no"></iframe>
                    </td>
                  </tr>
        </table> 
        </td>       
        </tr>
        <tr nowrap="nowrap">
          <td><b>标签:</b>(Tag，日志的关键字，半角逗号&quot;,&quot;分隔多个标签)<br />
            <input id="tags" maxlength="200" style="width:715px;" name="tag" value="<?php echo $tagStr; ?>" /><br /><div style="width:715px;">选择已有标签：<?php echo $oldTagStr; ?></div></td>
        </tr>
        <tr nowrap="nowrap">
          <td><b>引用通告：</b>(Trackback，通知你所引用的日志)<br />
          <textarea name="pingurl" cols="" rows="3" style="width:715px;" onclick="if (this.value=='每行输入一个引用地址') this.value='';">每行输入一个引用地址</textarea>
          </td>
        </tr>
        <tr>
          <td><b>更改发布时间</b>
            <input id="switch" onclick="doshow('changedate');" type="checkbox" value="1" name="edittime" />
              <br />
              <div style="clear:both; display: none;" id="changedate">
			  <input name="newyear" type="text" value="<?php echo $year; ?>" maxlength="" size="2"> 年 
			  <input name="newmonth" type="text" value="<?php echo $month; ?>" maxlength="2" size="1"> 月 
			  <input name="newday" type="text" value="<?php echo $day; ?>" maxlength="2" size="1"> 日 
			  <input name="newhour" type="text" value="<?php echo $hour; ?>" maxlength="2" 	size="1"> 时
			  <input name="newmin" type="text" value="<?php echo $minute; ?>" maxlength="2" size="1"> 分 
			  <input name="newsec" type="text" value="<?php echo $second; ?>" maxlength="2" size="1"> 秒
			  <input name="date" type="hidden" value="<?php echo $date; ?>" >
		  <br />请正确填写各参数,如果参数错误将仍使用当前服务器时间! 范例:2006年01月08日08时06分01秒 (24小时制)</div></td>
        </tr>
    </table>
	  <table cellspacing="1" cellpadding="4" width="95%" align="center" border="0">
          <td>接受评论？是
              <input type="radio" checked="checked" value="y" name="allow_remark" <?php echo $ex; ?>/>
            否
          <input type="radio" value="n" name="allow_remark" <?php echo $ex2; ?> /></td>
        </tr>
        <tr>
          <td>接受引用？是
              <input type="radio" checked="checked" value="y" name="allow_tb" <?php echo $add; ?> />
            否
          <input type="radio" value="n" name="allow_tb" <?php echo $add2; ?> /></td>
        </tr>
        <tr>
          <td align="center" colspan="2">
		  <input type="hidden" name="gid" value=<?php echo $logid; ?> />
		  <input type="submit" value="保存日志" onclick="return chekform();" class="submit2" />
		  </td>
        </tr>
      </tbody>
    </table>
  </form>
  <div class=line></div>