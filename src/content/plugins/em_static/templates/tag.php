<?php defined('EMLOG_ROOT') or die('本页面禁止直接访问!'); ?>
<style>
	.em_static_error {
		border: 1px solid red;
	}
</style>
<div class="containertitle"><b>静态化管理</b></div>
<div class="line"></div>
<div class="em_static">
	<div class="containertitle2">
		<a class="navi1" href="?plugin=em_static&do=home">最新日志生成</a>
		<a class="navi4" href="?plugin=em_static&do=create_all">全站日志生成</a>
		<a class="navi3" href="?plugin=em_static&do=tag_alias">标签别名管理</a>
		<a class="navi4" href="?plugin=em_static&do=config">自动生成设置</a>		
		<a class="navi4" href="?plugin=em_static&do=url">URL格式管理</a>
	</div>
	<?php include em_static_template('warning');?>
	<p><a href="javascript:;" id="desc">什么是标签别名?为什么要设置标签别名?</a></p>
	<p id="tag_desc" style="display: none; color: #666">
		1. 标签别名指的是为所有的标签(特别是中文标签)设置一个纯英文格式的别名,用于生成路径和文件.<br />
		2. 生成带有中文或其他非英语语言的文件夹或文件在不同系统上可能存在文件名编码兼容问题而导致生成的静态页面url无法访问.所以要设置纯英文字符别名来避免出现这种情况.<br />
	</p>
	<form method="post" id="submit">
	<?php if (!empty($tag_array)):?>
	<?php foreach ($tag_array as $tag):?>
	
	<p><b>标签:<?php echo $tag['tagname']?></b></p>
	<p> 
		<input type="hidden" name="tid[]" value="<?php echo $tag['tid']?>" />		
		<input type="text" name="alias[]" value="<?php echo ! isset($tag_alias_cache[$tag['tid']]) ? em_static_tag_to_url($tag['tagname']) : $tag_alias_cache[$tag['tid']]?>"/><span style="color: #666">别名只能是英文数字和-_</span>
	</p>
	<?php endforeach;?>
	<p><input type="submit" value="保存别名设置" /></p>
	<?php endif;?>
	</form>
</div>
<script>
	$().ready(function() {
		$('#desc').click(function() {
			$('#tag_desc').toggle();
		});
		$('#submit').submit(function() {
			var pass = true;
			$('input[type=text]').each(function() {
				if ( ! /^[\w-_]+$/.test(this.value)) {
					pass = false;
					$(this).addClass('em_static_error');
				} else {
					$(this).removeClass('em_static_error');
				}
			});
			$('input.em_static_error').first().focus();
			return pass;
		});
	});
</script>