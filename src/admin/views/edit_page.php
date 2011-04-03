<?php if(!defined('EMLOG_ROOT')) {exit('error!');}?>
<script charset="utf-8" src="./editor/kindeditor.js"></script>
<div class=containertitle><b>编辑页面</b><span id="msg_2"></span></div><div id="msg"></div>
<div class=line></div>
  <form action="page.php?action=edit" method="post" id="addlog" name="addlog">
    <table cellspacing="1" cellpadding="4" width="720" border="0">
      <tbody>
        <tr nowrap="nowrap">
          <td><b>标题：</b><span id="auto_msg"></span><br />
          <input maxlength="200" style="width:380px;" name="title" id="title" value="<?php echo $title; ?>"/>
          </td>
        </tr>
        <tr>
          <td>
          <b>内容：</b> <a href="javascript: displayToggle('FrameUpload', 0);" class="thickbox">附件管理</a><span id="asmsg">
          <?php doAction('adm_writelog_head'); ?>
          <input type="hidden" name="as_logid" id="as_logid" value="<?php echo $pageId; ?>"></span><br />
          <div id="FrameUpload" style="display: none;"><iframe width="720" height="160" frameborder="0" src="attachment.php?action=attlib&logid=<?php echo $pageId; ?>"></iframe></div>          
		  <textarea id="content" name="content" style="width:719px; height:460px; border:#CCCCCC solid 1px;"><?php echo $content; ?></textarea>
          <script>loadEditor('content');</script>
		  </td>
        </tr>
        <tr nowrap="nowrap">
          <td>链接别名：</b>(用于自定义该页面的链接地址，由英文字母、数字、下划线组成，需要<a href="./permalink.php" target="_blank">启用链接别名</a>)<br />
			<input name="alias" id="alias" style="width:711px;" value="<?php echo $alias; ?>" />
          </td>
        </tr> 
        <tr nowrap="nowrap">
          <td><b>转向地址：</b>(如果填写，页面标题将指向该地址)<br />
          <input name="url" id="url" maxlength="200" style="width:715px;" value="<?php echo $pageUrl; ?>" /><br />
          </td>
        </tr>
        <tr>
        <td>
          <span id="page_options">
          <label for="allow_remark">页面接受评论</label>
          <input type="checkbox" value="y" name="allow_remark" id="allow_remark" <?php echo $is_allow_remark; ?> />
          <label for="allow_tb">在新窗口打开</label>
          <input type="checkbox" value="y" id="is_blank" name="is_blank" <?php echo $is_blank; ?> />
          </span>
        </td>
        </tr>
        <tr>
          <td align="center" colspan="2"><br>
          <input type="hidden" name="ishide" id="ishide" value="<?php echo $hide; ?>">
		  <input type="hidden" name="gid" id="gid" value=<?php echo $pageId; ?> />
		  <input type="hidden" name="alias_flg" id="alias_flg" value="0">
		  <input type="button" value="保存并返回" onclick="savelog();" class="button" />
		  <input type="button" name="savedf" id="savedf" value="保存" onclick="autosave(3);" class="button" />
		  <span id="savelog_msg_hook"></span>
		  </td>
        </tr>
	</tbody>
	</table>
  </form>
<div class=line></div>
<script>
checkalias();
$("#alias").keyup(function(){checkalias();});
$("#menu_page").addClass('sidebarsubmenu1');
</script>