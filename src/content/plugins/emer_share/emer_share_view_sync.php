<div id="emshare_main">
<form id="form1" name="form1" method="post" action="plugin.php?plugin=emer_share&action=setting">
    <div id="sinat_form">
        <li>同步策略：
            <select name="sync">
                <?php
                $ex1 = $ex2 = $ex3 = '';
                $sync = 'ex' . EMEER_SHARE_SYNC;
                $$sync = 'selected="selected"';
                ?>
                <option value="1" <?php echo $ex1; ?>>碎语和日志</option>
                <option value="2" <?php echo $ex2; ?>>仅碎语</option>
                <option value="3" <?php echo $ex3; ?>>仅日志</option>
            </select>
        </li>
		<li>博客分类：
            <select name="category" id="emer_category">

            </select>
        </li>
		<li>开启云平台相关日志：<input <?php echo EMEER_SHARE_RALATE ? 'checked="checked"' : '';?>  type="checkbox" name="rale"/>
			显示相关日志数量：
            <select name="ralecount">
                <?php
                $ex2 = $ex3 = $ex4 = $ex5 = $ex6 = $ex7 = $ex8 = '';
                $rale = 'ex' . EMEER_SHARE_RALATENUM;
                $$rale = 'selected="selected"';
                ?>
                <option value="2" <?php echo $ex2; ?>>2</option>
                <option value="3" <?php echo $ex3; ?>>3</option>
                <option value="4" <?php echo $ex4; ?>>4</option>
				<option value="5" <?php echo $ex5; ?>>5</option>
				<option value="6" <?php echo $ex6; ?>>6</option>
				<option value="7" <?php echo $ex7; ?>>7</option>
				<option value="8" <?php echo $ex8; ?>>8</option>
            </select>
        </li>
        <p><input type="submit" value="保存设置" /></p>
    </div>
</form>
<div style="margin:30px 0px 0px 0px;">如果你修改过博客标题、描述、邮箱请<a href="plugin.php?plugin=emer_share&do=sync">同步博客信息</a></div>
<div style="margin:10px 0px 0px 0px;"><a href="http://emer.emlog.net" target="_blank">访问emer云分享平台&raquo;</a></div>
</div>
<script>
jQuery(function(){
jQuery.getJSON('<?php echo EMER_API_URL?>category?callback=?',function(data){
var current = <?php echo EMEER_SHARE_CATEGORY;?>;
var catl = [];
jQuery.each(data,function(i,n){
catl.push('<option value="'+n.categoryid+'" '+(current == n.categoryid ? 'selected="selected"' : '')+'>'+n.category+'</option>');
});
jQuery('#emer_category').html(catl.join(""));
});
});
</script>