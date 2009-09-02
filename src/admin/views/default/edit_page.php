<?php if(!defined('EMLOG_ROOT')) {exit('error!');}?>
<div class=containertitle><b><? echo $lang['page_edit'];?></b><span id="msg_2"></span></div><div id="msg"></div>
<div class=line></div>
  <form action="page.php?action=edit" method="post" id="addlog" name="addlog">
    <table cellspacing="1" cellpadding="4" width="720" border="0">
      <tbody>
        <tr nowrap="nowrap">
          <td><b><? echo $lang['title'];?>:</b><span id="auto_msg"></span><br />
          <input maxlength="200" style="width:380px;" name="title" id="title" value="<?php echo $title; ?>"/>
          </td>
        </tr>
        <tr>
          <td>
          <b><? echo $lang['content'];?>:</b> <a href="javascript: displayToggle('FrameUpload', 0);" class="thickbox"><? echo $lang['attachment_manager'];?></a><span id="asmsg">
          <?php doAction('adm_writelog_head'); ?>
          <input type="hidden" name="as_logid" id="as_logid" value="<?php echo $pageId; ?>"></span><br />
          <div id="FrameUpload" style="display: none;"><iframe width="720" height="160" frameborder="0" src="attachment.php?action=attlib&logid=<?php echo $pageId; ?>"></iframe></div>
          <input type="hidden" id="content" name="content" value="<?php echo $content; ?>" style="display:none" />
          <input type="hidden" id="content___Config" value="CustomConfigurationsPath=fckeditor/fckconfig.js" style="display:none" />
          <iframe src="fckeditor/editor/fckeditor.html?InstanceName=content&amp;Toolbar=Default" width="720" height="460" frameborder="0" scrolling="no"></iframe>
          </td>
        </tr>
        <tr nowrap="nowrap">
          <td><b><? echo $lang['page_url'];?>: </b> (<? echo $lang['page_url_info'];?>)<br />
          <input name="url" id="url" maxlength="200" style="width:715px;" value="<?php echo $pageUrl; ?>" /><br />
          </td>
        </tr>
        <tr>
        <td><? echo $lang['page_comments_enable'];?>?
          	<input type="radio" checked="checked" value="y" name="allow_remark" <?php echo $ex; ?>/><? echo $lang['yes'];?>
          	<input type="radio" value="n" name="allow_remark" <?php echo $ex2; ?> /><? echo $lang['no'];?>
        </td>
        </tr>
        <tr>
        <td><? echo $lang['page_new_window'];?>?
          	<input type="radio" checked="checked" value="_blank" name="is_blank" <?php echo $ex3; ?>/><? echo $lang['yes'];?>
          	<input type="radio" value="_parent" name="is_blank" <?php echo $ex4; ?> /><? echo $lang['no'];?>
        </td>
        </tr>
        <tr>
          <td align="center" colspan="2"><br>
          <input type="hidden" name="ishide" id="ishide" value="<?php echo $hide; ?>">
		  <input type="hidden" name="gid" value=<?php echo $pageId; ?> />
		  <input type="submit" value="<? echo $lang['post_save_and_return'];?>" onclick="return chekform();" class="button" />
		  <input type="button" name="savedf" id="savedf" value="<? echo $lang['post_save_draft'];?>" onclick="autosave(3);" class="button" />
		  </td>
        </tr>
	</tbody>
	</table>
  </form>
<div class=line></div>
<script>
$("#menu_page").addClass('sidebarsubmenu1');
</script>