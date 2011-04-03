<?php
if(!defined('EMLOG_ROOT')) {exit('error!');}
$isdraft = $hide == 'y' ? true : false;
?>
<script charset="utf-8" src="./editor/kindeditor.js"></script>
<div class=containertitle><b><?php if ($isdraft) :?>编辑草稿<?php else:?>编辑日志<?php endif;?>
    </b><span id="msg_2"></span></div><div id="msg"></div>
<div class=line></div>
  <form action="save_log.php?action=edit" method="post" id="addlog" name="addlog">
    <table cellspacing="1" cellpadding="4" width="720" border="0">
      <tbody>
        <tr nowrap="nowrap">
          <td><b>标题：</b><span id="auto_msg"></span><br />
          <input maxlength="200" style="width:380px;" name="title" id="title" value="<?php echo $title; ?>"/>
			<select name="sort" id="sort">
			<?php
			$sorts[] = array('sid'=>-1, 'sortname'=>'选择分类...');
			foreach($sorts as $val):
			$flg = $val['sid'] == $sortid ? 'selected' : '';
			?>
			<option value="<?php echo $val['sid']; ?>" <?php echo $flg; ?>><?php echo $val['sortname']; ?></option>
			<?php endforeach; ?>
			</select>
	       <input maxlength="200" style="width:139px;" name="postdate" id="postdate" value="<?php echo gmdate('Y-m-d H:i:s', $date); ?>"/>
	       <input name="date" id="date" type="hidden" value="<?php echo $date; ?>" >
          </td>
        </tr>
        <tr>
          <td>
          <b>内容：</b> <a href="javascript: displayToggle('FrameUpload', 0);" class="thickbox">附件管理</a><span id="asmsg">
          <?php doAction('adm_writelog_head'); ?>
          <input type="hidden" name="as_logid" id="as_logid" value="<?php echo $logid; ?>"></span><br />
          <div id="FrameUpload" style="display: none;"><iframe width="720" height="160" frameborder="0" src="attachment.php?action=attlib&logid=<?php echo $logid; ?>"></iframe></div>
		  <textarea id="content" name="content" style="width:719px; height:460px; border:#CCCCCC solid 1px;"><?php echo $content; ?></textarea>
          <script>loadEditor('content');</script>
		  </td>
        </tr>
        <tr nowrap="nowrap">
          <td><b>标签：</b>(Tag，日志的关键字，半角逗号&quot;,&quot;分隔多个标签)<br />
          <input name="tag" id="tag" maxlength="200" style="width:715px;" value="<?php echo $tagStr; ?>" />
          <?php if (!empty($tags)):?>
          <br /><div style="color:#2A9DDB;cursor:pointer;"><a href="javascript:displayToggle('tagbox', 0);">选择已有标签+</a></div>
          <?php endif; ?>
          <div id="tagbox" style="width:688px;margin-left:30px;display:none;">
          <?php
          $tagStr = '';
          foreach ($tags as $val){
          	$tagStr .=" <a href=\"javascript: insertTag('{$val['tagname']}','tag');\">{$val['tagname']}</a> ";
          }
          echo $tagStr;
          ?>
          </div>
            </td>
        </tr>
	</tbody>
	</table>
	<div id="show_advset" onclick="displayToggle('advset', 1);"><b>高级选项</b></div>
	<table cellspacing="1" cellpadding="4" width="720" border="0" id="advset">
        <tr nowrap="nowrap">
          <td><b>日志摘要：</b><br />
		  <textarea id="excerpt" name="excerpt" style="width:719px; height:260px; border:#CCCCCC solid 1px;"><?php echo $excerpt; ?></textarea>
		  <script>loadEditor('excerpt');</script>
		  </td>
        </tr>
        <tr nowrap="nowrap">
          <td>链接别名：</b>(用于自定义该篇日志的链接地址，由英文字母、数字、下划线组成，且不能为纯数字。需要<a href="./permalink.php" target="_blank">启用链接别名</a>)<br />
			<input name="alias" id="alias" value="<?php echo $alias;?>" style="width:711px;" />
          </td>
        </tr>
        <tr nowrap="nowrap">
          <td><b>引用通告：</b>(Trackback，通知你所引用的日志，每行输入一条引用地址)<br />
            <textarea name="pingurl" id="pingurl" style="width:715px; height:50px;" class="input"></textarea>
          </td>
        </tr>
        <tr>
          <td><b>日志访问密码：</b>
          <input type="text" value="<?php echo $password; ?>" name="password" id="password" style="width:80px;" /> (留空则不加访问密码)
          <span id="post_options">
          <input type="checkbox" value="y" name="top" id="top" <?php echo $is_top; ?> />
          <label for="top">日志置顶</label>
          <input type="checkbox" value="y" name="allow_remark" id="allow_remark" <?php echo $is_allow_remark; ?> />
          <label for="allow_remark">允许评论</label>
          <input type="checkbox" value="y" id="allow_tb" name="allow_tb" <?php echo $is_allow_tb; ?> />
          <label for="allow_tb">允许引用</label>
          </span>
		  </td>
        </tr>
	</table>
	<table cellspacing="1" cellpadding="4" width="720" align="center" border="0">
        <tr>
          <td width="420" align="right"><br>
          <input type="hidden" name="ishide" id="ishide" value="<?php echo $hide; ?>" />
		  <input type="hidden" name="gid" id="gid" value=<?php echo $logid; ?> />
		  <input type="hidden" name="alias_flg" id="alias_flg" value="0">
		  <input type="hidden" name="author" id="author" value=<?php echo $author; ?> />
		  <input type="button" name="savelg" id="savelg" value="保存并返回" onclick="savelog();" class="button" />
		  <input type="button" name="savedf" id="savedf" value="保存" onclick="autosave(2);" class="button" />
		  <?php if ($isdraft) :?>
		  <input type="submit" name="pubdf" id="pubdf" value="发布" onclick="return checkform();" class="button" />
		  <?php endif;?>
		  </td>
		  <td style="padding:20px 0px 0px 0px"><span id="savelog_msg_hook"></span></td>
        </tr>
    </table>
  </form>
<div class=line></div>
<script>
checkalias();
$("#alias").blur(function(){checkalias();});
$("#advset").css('display', $.cookie('em_advset') ? $.cookie('em_advset') : '');
setTimeout("autosave(0)",60000);
<?php if ($isdraft) :?>
$("#menu_draft").addClass('sidebarsubmenu1');
<?php else:?>
$("#menu_log").addClass('sidebarsubmenu1');
<?php endif;?>
</script>