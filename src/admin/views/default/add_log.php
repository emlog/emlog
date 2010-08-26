<?php if(!defined('EMLOG_ROOT')) {exit('error!');}?>
<script type="text/javascript" src="./ckeditor/ckeditor.js"></script>
<div class=containertitle><b><? echo $lang['post_add'];?></b><span id="msg_2"></span></div><div id="msg"></div>
<div class=line></div>
  <form action="save_log.php?action=add" method="post" enctype="multipart/form-data" id="addlog" name="addlog">
    <table cellspacing="1" cellpadding="4" width="720" border="0">
      <tbody>
        <tr nowrap="nowrap">
          <td><b><? echo $lang['title'];?>:</b><br />
          <input type="text" maxlength="200" style="width:380px;" name="title" id="title"/>
	      <select name="sort" id="sort">
	        <option value="-1"><? echo $lang['choose_category']; ?></option>
			<?php foreach($sorts as $val):?>
			<option value="<?php echo $val['sid']; ?>"><?php echo $val['sortname']; ?></option>
			<?php endforeach;?>
	      </select>
	      <input maxlength="200" style="width:139px;" name="postdate" id="postdate" value="<?php echo $postDate; ?>"/>
	      <input name="date" id="date" type="hidden" value="" >
        </td>
        </tr>
        <tr>
          <td>
          <b><? echo $lang['content']; ?>:</b> <a href="javascript: displayToggle('FrameUpload', 0);autosave(1);" class="thickbox"><? echo $lang['attachment_manager'];?></a><span id="asmsg">
          <?php doAction('adm_writelog_head'); ?>
          <input type="hidden" name="as_logid" id="as_logid" value="-1"></span><br />
          <div id="FrameUpload" style="display: none;"><iframe width="720" height="160" frameborder="0" src="attachment.php?action=selectFile"></iframe></div>
		  <textarea id="content" name="content" style="width:719px; height:460px; border:#CCCCCC solid 1px;"></textarea>
		  <script type="text/javascript">CKEDITOR.replace( 'content',{resize_minHeight : 460,height : 460});</script> 
          </td>
        </tr>
        <tr nowrap="nowrap">
          <td><b><? echo $lang['tags'];?>:</b> (<? echo $lang['tag_separate'];?>)<br />
          <input name="tag" id="tag" maxlength="200" style="width:715px;" /><br />
          <div style="color:#2A9DDB;cursor:pointer;"><a href="javascript:displayToggle('tagbox', 0);"><? echo $lang['tag_select'];?> &raquo;</a></div>
          <div id="tagbox" style="width:688px;margin-left:30px;display:none;">
          <?php 
          $tagStr = '';
          foreach ($tags as $val)
          {
          	$tagStr .=" <a href=\"javascript: insertTag('{$val['tagname']}','tag');\">{$val['tagname']}</a> ";
          }
          echo $tagStr;
          ?>
          </div>
          </td>
        </tr>
	</tbody>
	</table>
	<div id="show_advset" onclick="displayToggle('advset', 1);"><b><? echo $lang['advanced_options'];?></b></div>
	<table cellspacing="1" cellpadding="4" width="720" border="0" id="advset">
        <tr nowrap="nowrap">
          <td><? echo $lang['post_abstract'];?>:<br />
			<textarea id="excerpt" name="excerpt" style="width:719px; height:260px; border:#CCCCCC solid 1px;"></textarea>
		  	<script type="text/javascript">CKEDITOR.replace( 'excerpt',{resize_minHeight : 230,height : 230});</script>
          </td>
        </tr>      
        <tr nowrap="nowrap">
          <td><? echo $lang['trackback_notes'];?><b><br /></b>
			<textarea name="pingurl" id="pingurl" rows="3" cols="" style="width:715px;" onclick="if (this.value=='<? echo $lang['trackback_enter'];?>') this.value='';" class="input"><? echo $lang['trackback_enter'];?></textarea>
          </td>
        </tr>
        <tr>
          <td><? echo $lang['comments_enable'];?>:
          <input type="radio" checked="checked" value="y" name="allow_remark" id="allow_remark" /><? echo $lang['yes'];?>
          <input type="radio" value="n" name="allow_remark" id="allow_remark" /><? echo $lang['no'];?>
          </td>
        </tr>
        <tr>
          <td><? echo $lang['trackback_enable'];?>:
          <input type="radio" checked="checked" value="y" name="allow_tb" id="allow_tb" /><? echo $lang['yes'];?>
          <input type="radio" value="n" name="allow_tb" id="allow_tb" /><? echo $lang['no'];?>
		  </td>
        </tr>
        <tr>
          <td><? echo $lang['post_password'];?>:
          <input type="text" value="" name="password" id="password" class="input" /> (<? echo $lang['post_password_leave_empty'];?>)
		  </td>
        </tr>
	</table>
	<table cellspacing="1" cellpadding="4" width="720" border="0">
		<tr>
          <td align="center"><br>
          <input type="hidden" name="ishide" id="ishide" value="">
          <input type="submit" value="<? echo $lang['post_publish'];?>" onclick="return chekform();" class="button" />
          <input type="hidden" name="author" id="author" value=<?php echo UID; ?> />	 
          <input type="button" name="savedf" id="savedf" value="<? echo $lang['post_save_draft'];?>" onclick="autosave(2);" class="button" />
		  </td>
        </tr>
    </table>
  </form>
<div class=line></div>
<script type="text/javascript">
$("#title").focus();
$("#menu_wt").addClass('sidebarsubmenu1');
$("#advset").css('display', $.cookie('em_advset') ? $.cookie('em_advset') : '');
setTimeout("autosave(0)",60000);
</script>