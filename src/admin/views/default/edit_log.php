<?php 
if(!defined('EMLOG_ROOT')) {exit('error!');}
$isdraft = $hide == 'y' ? true : false;
?>
<script type="text/javascript" src="../lib/js/jquery/plugin-cookie.js"></script>
<div class=containertitle><b><? echo $lang['post_edit'];?></b><span id="msg_2"></span></div><div id="msg"></div>
<div class=line></div>
  <form action="save_log.php?action=edit" method="post" id="addlog" name="addlog">
    <table cellspacing="1" cellpadding="4" width="720" border="0">
      <tbody>
        <tr nowrap="nowrap">
          <td><b><? echo $lang['title'];?>:</b><span id="auto_msg"></span><br />
          <input maxlength="200" style="width:380px;" name="title" id="title" value="<?php echo $title; ?>"/>
		<br />
		<? echo $lang['category'];?>:
			<select name="sort" id="sort">
			<?php
			$sorts[] = array('sid'=>-1, 'sortname'=>$lang['choose_category'].'...');
			foreach($sorts as $val):
			$flg = $val['sid'] == $sortid ? 'selected' : '';
			?>
			<option value="<?php echo $val['sid']; ?>" <?php echo $flg; ?>><?php echo $val['sortname']; ?></option>
			<?php endforeach; ?>
			</select>
		<? echo $lang['time'];?>:
	       <input maxlength="200" style="width:125px;" name="postdate" id="postdate" value="<?php echo date('Y-m-d H:i:s', $date); ?>"/>
	       <input name="date" id="date" type="hidden" value="<?php echo $date; ?>" >
          </td>
        </tr>
        <tr>
          <td>
          <b><? echo $lang['content'];?>:</b> <a href="javascript: displayToggle('FrameUpload', 0);" class="thickbox"><? echo $lang['attachment_manager'];?></a><span id="asmsg">
          <?php doAction('adm_writelog_head'); ?>
          <input type="hidden" name="as_logid" id="as_logid" value="<?php echo $logid; ?>"></span><br />
          <div id="FrameUpload" style="display: none;"><iframe width="720" height="160" frameborder="0" src="attachment.php?action=attlib&logid=<?php echo $logid; ?>"></iframe></div>
          <input type="hidden" id="content" name="content" value="<?php echo $content; ?>" style="display:none" />
          <input type="hidden" id="content___Config" value="CustomConfigurationsPath=fckeditor/fckconfig.js" style="display:none" />
          <iframe src="fckeditor/editor/fckeditor.html?InstanceName=content&amp;Toolbar=Default" width="720" height="460" frameborder="0" scrolling="no"></iframe>
          </td>
        </tr>
        <tr nowrap="nowrap">
          <td><b><? echo $lang['tags'];?>:</b> (<? echo $lang['tag_separate'];?>)<br />
          <input name="tag" id="tag" maxlength="200" style="width:715px;" value="<?php echo $tagStr; ?>" /><br />
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
			<input type="hidden" id="excerpt" name="excerpt" value="<?php echo $excerpt; ?>" style="display:none" />
			<input type="hidden" value="CustomConfigurationsPath=fckeditor/fckconfig.js" style="display:none" />
			<iframe src="fckeditor/editor/fckeditor.html?InstanceName=excerpt&amp;Toolbar=Basic" width="720" height="260" frameborder="0" scrolling="no"></iframe>
          </td>
        </tr>      
        <tr nowrap="nowrap">
          <td><? echo $lang['trackback_notes'];?>: (<? echo $lang['trackback_notes'];?>)<b><br /></b>
			<textarea name="pingurl" id="pingurl" rows="3" cols="" style="width:715px;" onclick="if (this.value=='<? echo $lang['trackback_enter'];?>') this.value='';" class="input"><? echo $lang['trackback_enter'];?></textarea>
          </td>
        </tr>
        <tr>
        <td><? echo $lang['comments_enable'];?>?
          	<input type="radio" checked="checked" value="y" name="allow_remark" <?php echo $ex; ?>/><? echo $lang['yes'];?>
          	<input type="radio" value="n" name="allow_remark" <?php echo $ex2; ?> /><? echo $lang['no'];?>
        </td>
        </tr>
        <tr>
          <td><? echo $lang['trackback_enable'];?>?
          <input type="radio" checked="checked" value="y" name="allow_tb" <?php echo $add; ?> /><? echo $lang['yes'];?>
          <input type="radio" value="n" name="allow_tb" <?php echo $add2; ?> /><? echo $lang['no'];?>
          </td>
        </tr>
        <tr>
          <td><? echo $lang['post_password'];?>:
          <input type="text" value="<?php echo $password; ?>" name="password" id="password" class="input" /> (<? echo $lang['post_password_leave_empty'];?>)
		  </td>
        </tr>
	</table>
	<table cellspacing="1" cellpadding="4" width="720" align="center" border="0">
        <tr>
          <td align="center" colspan="2"><br>
          <input type="hidden" name="ishide" id="ishide" value="<?php echo $hide; ?>">
		  <input type="hidden" name="gid" value=<?php echo $logid; ?> />
		  <input type="hidden" name="author" id="author" value=<?php echo $author; ?> />	  
		  <input type="submit" value="<? echo $lang['post_save_and_return'];?>" onclick="return chekform();" class="button" />
		  <input type="button" name="savedf" id="savedf" value="<? echo $lang['post_save_draft'];?>" onclick="autosave(2);" class="button" />
		  </td>
        </tr>
    </table>
  </form>
<div class=line></div>
<script type="text/javascript">
$("#advset").css('display', $.cookie('em_advset') ? $.cookie('em_advset') : '');
setTimeout("autosave(0)",60000);
<?php if ($isdraft) :?>
$("#menu_draft").addClass('sidebarsubmenu1');
<?php else:?>
$("#menu_log").addClass('sidebarsubmenu1');
<?php endif;?>
</script>