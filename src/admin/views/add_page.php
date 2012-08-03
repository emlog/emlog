<?php if(!defined('EMLOG_ROOT')) {exit('error!');}?>
<script charset="utf-8" src="./editor/kindeditor.js"></script>
<script charset="utf-8" src="./editor/lang/<? echo str_replace('-','_', EMLOG_LANGUAGE); ?>.js"></script>
<div class=containertitle><b><? echo $lang['page_add']; ?></b><span id="msg_2"></span></div>
<div id="msg"></div>
  <form action="page.php?action=add" method="post" enctype="multipart/form-data" id="addlog" name="addlog">
    <table cellspacing="1" cellpadding="4" width="720" border="0">
      <tbody>
        <tr nowrap="nowrap">
          <td>
          <label for="title" id="title_label"><? echo $lang['title'];?></label>
          <input type="text" maxlength="200" style="width:710px;" name="title" id="title"/>
	      <input name="date" id="date" type="hidden" value="" >
        </td>
        </tr>
        <tr>
          <td>
          <a href="javascript: displayToggle('FrameUpload', 0);autosave(4);" class="thickbox"><? echo $lang['attachment_manager']; ?></a><span id="asmsg">
          <?php doAction('adm_writelog_head'); ?>
          <input type="hidden" name="as_logid" id="as_logid" value="-1"></span><br />
          <div id="FrameUpload" style="display: none;">
          	<iframe width="720" height="290" frameborder="0" src="attachment.php?action=selectFile"></iframe>
          </div>
		  <textarea id="content" name="content" style="width:719px; height:460px; border:#CCCCCC solid 1px;"></textarea>
          <script>loadEditor('content');</script>
		  </td>
        </tr>
        <tr nowrap="nowrap">
          <td><span id="alias_msg_hook"></span><b><? echo $lang['link_alias'];?>:</b> (<? echo $lang['link_alias_need_to']; ?> <a href="./permalink.php" target="_blank"><? echo $lang['link_alias_enable']; ?></a>)<br />
			<input name="alias" id="alias" style="width:711px;" />
          </td>
        </tr>
        <tr>
          <td>
          <span id="page_options">
          <label for="allow_remark"><? echo $lang['page_comments_allow']; ?></label>
          <input type="checkbox" value="y" name="allow_remark" id="allow_remark" />
          </span>
          </td>
        </tr>
		<tr>
          <td align="center"><br>
          <input type="hidden" name="ishide" id="ishide" value="">
          <input type="submit" value="<? echo $lang['page_publish'];?>" onclick="return checkform();" class="button" />
          <input type="button" name="savedf" id="savedf" value="<? echo $lang['page_save'];?>" onclick="autosave(3);" class="button" />
		  </td>
        </tr>
	</tbody>
	</table>
  </form>
<div class=line></div>
<script>
$("#menu_page").addClass('sidebarsubmenu1');
$("#alias").keyup(function(){checkalias();});

$("#title").focus(function(){$("#title_label").hide();});
$("#title").blur(function(){if($("#title").val() == '') {$("#title_label").show();}});

</script>