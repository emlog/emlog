<div class="categories-upper"></div>
<div class="categories">
  <ul>
	<?php foreach($com_cache as $value): ?>
	<li>
	<a href="<?php echo $value['url']; ?>"><?php echo $value['content']; ?> by <?php echo $value['name']; ?>
	<?php if($value['reply']): ?>
	<img src="<?php echo $em_tpldir; ?>images/reply.gif" style="border:0" title="博主回复：<?php echo $value['reply']; ?>"align="absmiddle"/>
	<?php endif;?>
	</a>
	</li>
	<?php endforeach; ?>
  </ul>
</div>
<div class="categories-btm"></div>
<div class="links">
<ul>
	<?php foreach($link_cache as $value): ?>     	
	<li><a href="<?php echo $value['url']; ?>" title="<?php echo $value['des']; ?>" target="_blank"><?php echo $value['link']; ?></a></li>
	<?php endforeach; ?>
</ul>
</div>
<div class="side-meta">
  <ul>
    <li><span onclick="showhidediv('blogger')"><b>博主信息</b></span></li>
    	<ul id="blogger">
    	<li><?php echo $photo; ?></li>
		<li><b><?php echo $name; ?></b></li>
		<li><span id="bloggerdes"><?php echo $blogger_des; ?></span>
		<?php if(ISLOGIN === true): ?>
		<a href="javascript:void(0);" onclick="showhidediv('modbdes','bdes')">
		<img src="<?php echo $em_tpldir; ?>images/modify.gif" align="absmiddle" style="border:0"alt="修改我的状态"/></a></li>
		<li id='modbdes' style="display:none;">
		<textarea name="bdes" class="input" id="bdes" style="overflow-y: hidden;width:190px;height:60px;"><?php echo $blogger_des; ?></textarea>
		<br />
		<a href="javascript:void(0);" onclick="postinfo('./adm/blogger.php?action=modintro&flg=1','bdes','bloggerdes');">提交</a>
		<a href="javascript:void(0);" onclick="showhidediv('modbdes')">取消</a>
		<?php endif; ?>
		</li>
    	</ul>
    <li><span onclick="showhidediv('tags')"><b>标签</b></span></li>
    	<ul id="tags">
    	<?php foreach($tag_cache as $value):?>
		<a href="index.php?tag=<?php echo $value['tagurl']; ?>" style="font-size:<?php echo $value['fontsize']; ?>pt;;line-height:30px;" title="<?php echo $value['usenum']; ?> 篇日志"><?php echo $value['tagname']; ?></a>
		<?php endforeach; ?>
    	</ul>
    <li><span onclick="showhidediv('calendar')"><b>日历</b></span></li>
    	<ul id="calendar">
    	</ul>
    	<script>sendinfo('<?php echo $calendar_url; ?>','calendar');</script>
    <?php if($index_twnum>0): ?>
	<li><span onclick="showhidediv('twitter')"><b>Twitter</b></span></li>
	<ul id="twitter">
	<?php
	if(isset($tw_cache) && is_array($tw_cache)):
		$morebt = count($tw_cache)>$index_twnum?"<li id=\"twdate\"><a href=\"javascript:void(0);\" onclick=\"sendinfo('twitter.php?p=2','twitter')\">较早的&raquo;</a></li>":'';
		foreach (array_slice($tw_cache,0,$index_twnum) as $value):
			$delbt = ISLOGIN === true?"<a href=\"javascript:void(0);\" onclick=\"isdel('{$value['id']}','twitter')\">删除</a>":'';
			$value['date'] = smartyDate($localdate,$value['date']);
			?>
			<li> <?php echo $value['content']; ?> <?php echo $delbt; ?><br><font color="#21565E"><?php echo $value['date']; ?></font></li>
		<?php endforeach;?>
		<?php echo $morebt;?>
	<?php endif;?>
	</ul>
	<?php if(ISLOGIN === true): ?>
		<ul>
		<li><a href="javascript:void(0);" onclick="showhidediv('addtw','tw')">我要唠叨</a></li>
		<li id='addtw' style="display: none;">
		<textarea name="tw" id="tw" style="overflow-y: hidden;width:200px;height:70px;" class="input"></textarea>
		<a href="javascript:void(0);" onclick="postinfo('./twitter.php?action=add','tw','twitter');">提交</a>
		<a href="javascript:void(0);" onclick="showhidediv('addtw')">取消</a>
		</li>
		</ul>
	<?php endif;?>
	<?php endif;?>
	<li><span onclick="showhidediv('record')"><b>日志归档</b></span></li>
		<ul id="record">
		<?php foreach($dang_cache as $value): ?>
		<li><a href="<?php echo $value['url']; ?>"><?php echo $value['record']; ?>(<?php echo $value['lognum']; ?>)</a></li>
		<?php endforeach; ?>		
		</ul>
	<li><span onclick="showhidediv('bloginfo')"><b>博客信息</b></span></li>
		<ul id="bloginfo">
		<li>日志数量：<?php echo $sta_cache['lognum']; ?></li>
		<li>评论数量：<?php echo $sta_cache['comnum']; ?></li>
		<li>引用数量：<?php echo $sta_cache['tbnum']; ?></li>
		<li>今日访问：<?php echo $sta_cache['day_view_count']; ?></li>
		<li>总访问量：<?php echo $sta_cache['view_count']; ?></li>
		</ul>
	<?php echo $exarea; ?>
	<?php 
		if(ISLOGIN==false):
		$login_code=='y'?
		$ckcode= "<img src=\"./lib/C_checkcode.php\" align=\"absmiddle\"><input name=\"imgcode\" type=\"text\" class=\"input\" style=\"width:40px;\"><br/>":
		$ckcode = '';
	?>
	<li><span onclick="showhidediv('loginfm')"><b>登录</b></span></li>
		<ul id="loginfm" style="display:none">
		<form name="f" method="post" action="index.php?action=login">
		用户：<input name="user" id="user" type="text" class="input" style="width:80px;"/><br/>
		密码：<input name="pw" type="password"  class="input" style="width:80px;"/><br />
		<?php echo $ckcode; ?> 
		<input type="submit" value="登录">
		</form>
		</ul>
	<?php else: ?>
	<li><span onclick="showhidediv('adm')"><b>管理</b></span></li>
		<ul id="adm">
			<li><a href="./adm/add_log.php">写日志</a></li>
			<li><a href="./adm/">管理中心</a></li>
			<li><a href="./index.php?action=logout">退出</a></li>
		</ul>
	<?php endif; ?>
  	</ul>
</div>