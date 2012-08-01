<?php if(!defined('EMLOG_ROOT')) {exit('error!');}?>
<script charset="utf-8" src="./editor/kindeditor.js"></script>
<div class=containertitle><b><? echo $lang['post_add'];?></b><span id="msg_2"></span></div>
<div id="msg"></div>
  <form action="save_log.php?action=add" method="post" enctype="multipart/form-data" id="addlog" name="addlog">
    <table cellspacing="1" cellpadding="4" width="720" border="0">
      <tbody>
        <tr nowrap="nowrap">
          <td>
          <label for="title" id="title_label"><? echo $lang['title'];?></label>
          <input type="text" maxlength="200" style="width:710px;" name="title" id="title"/>
          </td>
        </tr>
        <tr>
          <td>
          <a href="javascript: displayToggle('FrameUpload', 0);autosave(1);" class="thickbox"><? echo $lang['attachment_manager'];?></a><span id="asmsg">
          <?php doAction('adm_writelog_head'); ?>
          <input type="hidden" name="as_logid" id="as_logid" value="-1"></span><br />
          <div id="FrameUpload" style="display: none;">
		  	<iframe width="720" height="290" frameborder="0" src="attachment.php?action=selectFile"></iframe>
		  </div>
		  <textarea id="content" name="content" cols="100" rows="8" style="width:719px; height:460px;"></textarea>
          <script>loadEditor('content');</script>
          </td>
        </tr>
        <tr nowrap="nowrap">
          <td>
		  <div style="margin:10px 0px 5px 0px;">
		  <label for="tag" id="tag_label"><? echo $lang['tags_by_comma']; ?></label>
          <input name="tag" id="tag" maxlength="200" style="width:432px;" />

          <select name="sort" id="sort" style="width:200px;">
	        <option value="-1"><? echo $lang['choose_category']; ?></option>
			<?php foreach($sorts as $val):?>
			<option value="<?php echo $val['sid']; ?>"><?php echo $val['sortname']; ?></option>
			<?php endforeach;?>
	      </select>

	      <input maxlength="200" style="width:139px;" name="postdate" id="postdate" value="<?php echo $postDate; ?>"/>
	      <input name="date" id="date" type="hidden" value="" >
		  </div>
          <?php if (!empty($tags)):?>
		  <div style="color:#2A9DDB;cursor:pointer;"><a href="javascript:displayToggle('tagbox', 0);"><? echo $lang['tag_select'];?>+</a></div>
          <?php endif; ?>
          <div id="tagbox" style="width:688px;margin:0px 0px 0px 30px;display:none;">
          <?php 
          $tagStr = '';
          foreach ($tags as $val){
          	$tagStr .=" <a href=\"javascript: insertTag('{$val['tagname']}','tag');\">{$val['tagname']}</a> ";
          }
          echo $tagStr;?>
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
            <script>loadEditor('excerpt');</script>
          </td>
        </tr>
        <tr nowrap="nowrap">
          <td><span id="alias_msg_hook"></span><b><? echo $lang['link_alias']; ?>: </b>(<? echo $lang['link_alias_need_to']; ?> <a href="./permalink.php" target="_blank"><? echo $lang['link_alias_enable']; ?></a>)<span id="alias_msg_hook"></span><br />
			<input name="alias" id="alias" style="width:711px;" />
          </td>
        </tr>   
        <tr nowrap="nowrap">
          <td><b><? echo $lang['reference_notice']; ?>:</b> (<? echo $lang['reference_per_line']; ?>)<br />
			<textarea name="pingurl" id="pingurl" style="width:715px; height:50px;" class="input"></textarea>
          </td>
        </tr>
        <tr>
          <td><b><? echo $lang['post_password']; ?>:</b>
          <input type="text" value="" name="password" id="password" style="width:80px;" />
          <span id="post_options">
          <input type="checkbox" value="y" name="top" id="top" />
          <label for="top"><? echo $lang['post_pin']; ?></label>
          <input type="checkbox" value="y" name="allow_remark" id="allow_remark" checked="checked" />
          <label for="allow_remark"><? echo $lang['comments_allow']; ?></label>
          <input type="checkbox" value="y" id="allow_tb" name="allow_tb" checked="checked" />
          <label for="allow_tb"><? echo $lang['trackbacks_allow']; ?></label>
          </span>
		  </td>
        </tr>
	</table>
	<table cellspacing="1" cellpadding="4" width="720" border="0">
		<tr>
          <td align="center"><br>
          <input type="hidden" name="ishide" id="ishide" value="">
          <input type="submit" value="<? echo $lang['post_publish'];?>" onclick="return checkform();" class="button" />
          <input type="hidden" name="author" id="author" value=<?php echo UID; ?> />	 
          <input type="button" name="savedf" id="savedf" value="<? echo $lang['post_save_draft'];?>" onclick="autosave(2);" class="button" />
		  </td>
        </tr>
    </table>
  </form>
<div class=line></div>
<script>
$("#menu_wt").addClass('sidebarsubmenu1');
$("#advset").css('display', $.cookie('em_advset') ? $.cookie('em_advset') : '');
$("#alias").keyup(function(){checkalias();});
$("#title").focus(function(){$("#title_label").hide();});
$("#title").blur(function(){if($("#title").val() == '') {$("#title_label").show();}});
$("#tag").focus(function(){$("#tag_label").hide();});
$("#tag").blur(function(){if($("#tag").val() == '') {$("#tag_label").show();}});
setTimeout("autosave(0)",60000);
</script>