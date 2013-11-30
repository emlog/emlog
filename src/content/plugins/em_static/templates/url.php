<?php defined('EMLOG_ROOT') or die('本页面禁止直接访问!'); ?>
<style>
	.em_static, .em_static .text{
		font-family: Verdana;
	}
	.em_static .text {
		border-top:0;
		border-left:0;
		border-right:0;
		border-bottom:1px solid #ccc;
		width: 400px;
	}
	.em_static .hidden_tab {
		display: none;
	}
	
	.example-link {
		color: blue;
	}
	.format-block {
		display: none;
	}
</style>
<div class=containertitle><b>静态化url格式设置</b></div>
<div class=line></div>
<div class="em_static">
	<p>
		<a href="?plugin=em_static">&LT;&LT; 返回上一个页面</a>
	</p>
	<div class="containertitle2">
		<a class="navi3" href="#posts" id="posts">日志URL</a>
		<a class="navi4" href="#sort" id="sort">分类URL</a>
		<a class="navi4" href="#tag" id="tag">标签URL</a>
		<a class="navi4" href="#record" id="record">归档URL</a>
		<a class="navi4" href="#author" id="author">作者URL</a>
	</div>
	<?php include em_static_template('warning');?>
	<form method="post" enctype="multipart/form-data">
		<div id="posts_tab" class="tab">	
			<p><b>文章静态页面URL示例(文章id形式):</b></p>
			<p class="example-link"><?php echo BLOG_URL ?><span id="post-id-url"></span>   <a href="javascript:;" class="edit-link" id="1">编辑</a></p>
			<div id="p-1" class="format-block">
			<p>文件夹路径 [支持变量 {%日志id%}]</p>
			<p>/<input type="text" name="post_path" value="<?php echo $config['post_path'] ?>" class="text static_path" id="post_path" /></p>
			<p>文件格式 [支持变量 {%日志id%}]</p>
			<p>/<span class="post_path"><?php echo $config['post_path'] ?></span><input type="text" name="post_format" id="post_format" value="<?php echo $config['post_format'] ?>" class="text"/></p>
			</div>
			
			
			<p><b>文章静态页面URL示例(文章别名形式 形式):</b></p>
			<p class="example-link"><?php echo BLOG_URL ?><span id="post-alias-url"></span>   <a href="javascript:;" class="edit-link" id="2">编辑</a></p>
			<div id="p-2" class="format-block">
			<p>文件夹路径 [支持变量 {%日志别名%}]</p>
			<p><input type="text" name="post_alias_path" value="<?php echo $config['post_alias_path'] ?>" class="text static_path" id="post_alias_path" /></p>			
			<p>文件格式[支持变量 {%日志别名%}]</p>
			<p><span class="post_alias_path"><?php echo $config['post_alias_path'] ?></span><input type="text" name="post_alias_format" id="post_alias_format" value="<?php echo $config['post_alias_format'] ?>" class="text"/></p>
			</div>
		
		
			<p><b>文章评论静态分页URL示例(文章id形式):</b></p>
			<p class="example-link"><?php echo BLOG_URL ?><span id="post-comment-url"></span>   <a href="javascript:;" class="edit-link" id="3">编辑</a></p>
			<div id="p-3" class="format-block">
			<p>文件夹路径[支持变量 {%日志id%}]</p>
			<p><?php echo BLOG_URL ?><input type="text" name="post_comment_page_path" value="<?php echo $config['post_comment_page_path'] ?>" class="text static_path" id="post_comment_page_path" /></p>
			<p>文件格式 [支持变量 {%日志id%} {%页码%}]</p>
			<p><?php echo BLOG_URL ?><span class="post_comment_page_path"><?php echo $config['post_comment_page_path'] ?></span><input type="text" name="post_comment_page_format" id="post_comment_page_format" value="<?php echo $config['post_comment_page_format'] ?>" class="text"/></p>
			</div>
			
			<p><b>文章评论静态分页URL示例(文章别名形式):</b></p>
			<p class="example-link"><?php echo BLOG_URL ?><span id="post-alias-comment-url"></span>   <a href="javascript:;" class="edit-link" id="4">编辑</a></p>
			<div id="p-4" class="format-block">
			<p>文件夹路径[支持变量 {%日志别名%}]</p>
			<p><?php echo BLOG_URL ?><input type="text" name="post_comment_alias_page_path" value="<?php echo $config['post_comment_alias_page_path'] ?>" class="text static_path" id="post_comment_alias_page_path" /></p>
			<p>文件格式[支持变量 {%日志别名%} {%页码%}]</p>
			<p><?php echo BLOG_URL ?><span class="post_comment_alias_page_path"><?php echo $config['post_comment_alias_page_path'] ?></span><input type="text" name="post_comment_alias_page_format" id="post_comment_alias_page_format" value="<?php echo $config['post_comment_alias_page_format'] ?>" class="text"/></p>			
			</div>
			
			<p><b>文章列表分页URL示例:</b></p>
			<p class="example-link"><?php echo BLOG_URL ?><span id="post-page"></span>   <a href="javascript:;" class="edit-link" id="5">编辑</a></p>
			<div id="p-5" class="format-block">			
			<p>文件夹路径</p>
			<p><?php echo BLOG_URL ?><input type="text" name="page_path" value="<?php echo $config['page_path'] ?>" class="text static_path" id="page_path" /></p>
			<p>文件格式[支持变量 {%页码%}]</p>
			<p><?php echo BLOG_URL ?><span class="page_path"><?php echo $config['page_path'] ?></span><input type="text" name="page_format" id="page_format" value="<?php echo $config['page_format'] ?>" class="text"/></p>	
			</div>
		</div>
		
		<div id="sort_tab" class="tab hidden_tab">	
			<p><b>文章分类列表首页URL示例(分类id形式):</b></p>
			<p class="example-link"><?php echo BLOG_URL ?><span id="sort-page"></span>   <a href="javascript:;" class="edit-link" id="6">编辑</a></p>
			<div id="p-6" class="format-block">				
			<p>文件夹路径 [支持变量 {%分类id%}]</p>
			<p><?php echo BLOG_URL ?><input type="text" name="sort_path" value="<?php echo $config['sort_path'] ?>" class="text static_path" id="sort_path" /></p>
			<p>文件格式[支持变量 {%分类id%}]</p>
			<p><?php echo BLOG_URL ?><span class="sort_path"><?php echo $config['sort_path'] ?></span><input type="text" name="sort_format" id="sort_format" value="<?php echo $config['sort_format'] ?>" class="text"/></p>
			</div>
			
			<p><b>文章分类列表首页URL示例(分类别名形式):</b></p>
			<p class="example-link"><?php echo BLOG_URL ?><span id="sort-alias-page"></span>   <a href="javascript:;" class="edit-link" id="7">编辑</a></p>
			<div id="p-7" class="format-block">				
			<p>文件夹路径 [支持变量 {%分类别名%}]</p>
			<p><?php echo BLOG_URL ?><input type="text" name="sort_alias_path" value="<?php echo $config['sort_alias_path'] ?>" class="text static_path" id="sort_alias_path" /></p>			
			<p>文件格式 [支持变量 {%分类别名%} {%页码%}]</p>
			<p><?php echo BLOG_URL ?><span class="sort_alias_path"><?php echo $config['sort_alias_path'] ?></span><input type="text" name="sort_alias_format" id="sort_alias_format" value="<?php echo $config['sort_alias_format'] ?>" class="text"/></p>
			</div>
			
			<p><b>文章分类列表URL示例(分类id形式):</b></p>
			<p class="example-link"><?php echo BLOG_URL ?><span id="sort-id-pages"></span>   <a href="javascript:;" class="edit-link" id="8">编辑</a></p>
			<div id="p-8" class="format-block">				
			<p>文件夹路径 [支持变量 {%分类id%}]</p>
			<p><?php echo BLOG_URL ?><input type="text" name="sort_page_path" value="<?php echo $config['sort_page_path'] ?>" class="text static_path" id="sort_page_path" /></p>
			<p>文件格式 [支持变量 {%分类id%}]</p>
			<p><?php echo BLOG_URL ?><span class="sort_page_path"><?php echo $config['sort_page_path'] ?></span><input type="text" name="sort_page_format" id="sort_page_format" value="<?php echo $config['sort_page_format'] ?>" class="text"/></p>
			</div>
			
			<p><b>文章分类列表URL示例(分类别名形式):</b></p>
			<p class="example-link"><?php echo BLOG_URL ?><span id="sort-alias-pages"></span>   <a href="javascript:;" class="edit-link" id="9">编辑</a></p>
			<div id="p-9" class="format-block">			
			<p>文件夹路径[支持变量 {%分类别名%}]</p>
			<p><?php echo BLOG_URL ?><input type="text" name="sort_page_alias_path" value="<?php echo $config['sort_page_alias_path'] ?>" class="text static_path" id="sort_page_alias_path" /></p>			
			<p>文件格式[支持变量 {%分类别名%} {%页码%}]</p>
			<p><?php echo BLOG_URL ?><span class="sort_page_alias_path"><?php echo $config['sort_page_alias_path'] ?></span><input type="text" name="sort_page_alias_format" id="sort_page_alias_format" value="<?php echo $config['sort_page_alias_format'] ?>" class="text"/></p>
			</div>
		</div>
		
		<div id="tag_tab" class="tab hidden_tab">
			<p><b>标签列表首页URL示例:</b></p>
			<p class="example-link"><?php echo BLOG_URL ?><span id="tag_index"></span>   <a href="javascript:;" class="edit-link" id="10">编辑</a></p>
			<div id="p-10" class="format-block">		
			<p>文件夹路径[支持变量 {%标签别名%}]</p>
			<p><?php echo BLOG_URL ?><input type="text" name="tag_path" value="<?php echo $config['tag_path'] ?>" class="text static_path" id="tag_path" /></p>
			<p>文件格式[支持变量 {%标签别名%}]</p>
			<p><?php echo BLOG_URL ?><span class="tag_path"><?php echo $config['tag_path'] ?></span><input type="text" name="tag_format" id="tag_format" value="<?php echo $config['tag_format'] ?>" class="text"/></p>
			</div>
			
			<p><b>标签列表分页URL示例:</b></p>
			<p class="example-link"><?php echo BLOG_URL ?><span id="tag_page"></span>   <a href="javascript:;" class="edit-link" id="11">编辑</a></p>
			<div id="p-11" class="format-block">			
			<p>文件夹路径[支持变量 {%标签别名%}]</p>
			<p><?php echo BLOG_URL ?><input type="text" name="tag_page_path" value="<?php echo $config['tag_page_path'] ?>" class="text static_path" id="tag_page_path" /></p>	
			<p>文件格式[支持变量 {%标签别名%} {%页码%}]</p>
			<p><?php echo BLOG_URL ?><span class="tag_page_path"><?php echo $config['tag_path'] ?></span><input type="text" name="tag_page_format" id="tag_page_format" value="<?php echo $config['tag_page_format'] ?>" class="text"/></p>
			</div>
		</div>

		<div id="record_tab" class="tab hidden_tab">
			<p><b>日志归档首页URL示例:</b></p>
			<p class="example-link"><?php echo BLOG_URL ?><span id="record_index"></span>   <a href="javascript:;" class="edit-link" id="12">编辑</a></p>
			<div id="p-12" class="format-block">		
			<p>文件夹路径[支持变量 {%日期%}]</p>
			<p><?php echo BLOG_URL ?><input type="text" name="record_path" value="<?php echo $config['record_path'] ?>" class="text static_path" id="record_path" /></p>	
			<p>文件格式[支持变量 {%日期%}]</p>
			<p><?php echo BLOG_URL ?><span class="record_path"><?php echo $config['record_path'] ?></span><input type="text" name="record_format" id="record_format" value="<?php echo $config['record_format'] ?>" class="text"/></p>	
			</div>

			<p><b>日志归档分页URL示例:</b></p>
			<p class="example-link"><?php echo BLOG_URL ?><span id="record_page"></span>   <a href="javascript:;" class="edit-link" id="13">编辑</a></p>
			<div id="p-13" class="format-block">
			<p>文件夹路径[支持变量 {%日期%}]</p>
			<p><?php echo BLOG_URL ?><input type="text" name="record_page_path" value="<?php echo $config['record_page_path'] ?>" class="text static_path" id="record_page_path"/></p>	
			<p>文件格式[支持变量 {%日期%} {%页码%}]</p>
			<p><?php echo BLOG_URL ?><span class="record_page_path"><?php echo $config['record_page_path'] ?></span><input type="text" name="record_page_format" id="record_page_format" value="<?php echo $config['record_page_format'] ?>" class="text"/></p>
			</div>
		</div>
	
		<div id="author_tab" class="tab hidden_tab">
			<p><b>日志归档首页URL示例:</b></p>
			<p class="example-link"><?php echo BLOG_URL ?><span id="author_index"></span>   <a href="javascript:;" class="edit-link" id="14">编辑</a></p>
			<div id="p-14" class="format-block">		
			<p>文件夹路径[支持变量 {%用户id%}]</p>
			<p><?php echo BLOG_URL ?><input type="text" name="author_path" value="<?php echo $config['author_path'] ?>" class="text static_path" id="author_path" /></p>	
			<p>文件格式[支持变量 {%用户id%}]</p>
			<p><?php echo BLOG_URL ?><span class="author_path"><?php echo $config['author_path'] ?></span><input type="text" name="author_format" id="author_format" value="<?php echo $config['author_format'] ?>" class="text"/></p>	
			</div>

			<p><b>日志归档分页URL示例:</b></p>
			<p class="example-link"><?php echo BLOG_URL ?><span id="author_page"></span>   <a href="javascript:;" class="edit-link" id="15">编辑</a></p>
			<div id="p-15" class="format-block">			
			<p>文件夹路径[支持变量 {%用户id%}]</p>
			<p><?php echo BLOG_URL ?><input type="text" name="author_page_path" value="<?php echo $config['author_page_path'] ?>" class="text static_path" id="author_page_path" /></p>	
			<p>分页文件格式[支持变量 {%用户id%} {%页码%}]</p>
			<p><?php echo BLOG_URL ?><span class="author_page_path"><?php echo $config['author_page_path'] ?></span><input type="text" name="author_page_format" id="author_page_format" value="<?php echo $config['author_page_format'] ?>" class="text"/></p>	
			</div>
		</div>
	
	<p><input type="submit" value="保存设置" /></p>
	</form>
</div>
<script>
function bind_change(display, path, p_search, p_replace, format, f_search, f_replace) {
	format_url(display, path, p_search, p_replace, format, f_search, f_replace);
	$('#'+path+', #'+format).bind('keyup', function() {
		format_url(display, path, p_search, p_replace, format, f_search, f_replace);
	});
}

function format_url(display, path, p_search, p_replace, format, f_search, f_replace) {
	var path_format = $('#'+path).val().replace(p_search, p_replace);
	if (path_format != '' && ! /\/$/.test(path_format))
		path_format += '/';	
	var url_format = $('#'+format).val();
	for (var i = 0; i <= f_search.length; i++) {
		url_format = url_format.replace(f_search[i], f_replace[i]);
	}
	$('#'+display).html(path_format+url_format);
}

			
$().ready(function() {

	$('.static_path').bind('keyup', function(e) {	
		$('span.'+this.id).html(this.value);			
	}).bind('blur', function() {
		if (this.value != '' && ! /\/$/.test(this.value))
			this.value += '/';
		$('span.'+this.id).html(this.value);
	});

	$('.edit-link').click(function() {
		$('#p-'+this.id).toggle();
	});
	
	$('.containertitle2 a').click(function() {
		$('div.tab').addClass('hidden_tab');
		$('.containertitle2 a').each(function(index) {
			if (index == 0)
				$(this).removeClass('navi3').addClass('navi1');
			else
				$(this).removeClass('navi3').addClass('navi4');
		});
		$('#'+this.id+'_tab').removeClass('hidden_tab');
		$(this).removeClass('navi4').addClass('navi3');
	});
	$("#em_static").addClass('sidebarsubmenu1');
	if (window.location.hash) {
		$(window.location.hash).click();
	}

	bind_change('post-id-url', 'post_path', '{%日志id%}', '1', 'post_format', ['{%日志id%}'], ['1']);
	bind_change('post-alias-url', 'post_alias_path', '{%日志别名%}', 'your-alias',  'post_alias_format', ['{%日志别名%}'], ['your-alias']);
	bind_change('post-comment-url', 'post_comment_page_path', '{%日志id%}', '1', 'post_comment_page_format', ['{%日志id%}', '{%页码%}'], ['1', '10']);
	bind_change('post-alias-comment-url', 'post_comment_alias_page_path', '{%日志别名%}', 'your-alias', 'post_comment_alias_page_format', ['{%日志别名%}', '{%页码%}'], ['your-alias', '10']);
	bind_change('post-page', 'page_path', '{%页码%}', '1', 'page_format',  ['{%页码%}'], ['1']);
	bind_change('sort-page', 'sort_path',  '{%分类id%}', '1', 'sort_format',  ['{%分类id%}'], ['1']);
	bind_change('sort-alias-page', 'sort_alias_path', '{%分类别名%}', 'your-alias', 'sort_alias_format',  ['{%分类别名%}', '{%页码%}'], ['your-alias', '10']);
	bind_change('sort-id-pages', 'sort_page_path', '{%分类id%}', '1', 'sort_page_format',  ['{%分类id%}', '{%页码%}'], ['1', '10']);
	bind_change('sort-alias-pages', 'sort_page_alias_path', '{%分类别名%}', 'your-alias', 'sort_page_alias_format',  ['{%分类别名%}', '{%页码%}'], ['your-alias', '10']);
	bind_change('tag_index', 'tag_path', '{%标签别名%}', 'tag-name', 'tag_format',  ['{%标签别名%}', '{%页码%}'], ['tag-name', '10']);
	bind_change('tag_page', 'tag_page_path', '{%标签别名%}', 'tag-name', 'tag_page_format',  ['{%标签别名%}', '{%页码%}'], ['tag-name', '10']);
	bind_change('record_index', 'record_path', '{%日期%}', '201301', 'record_format',  ['{%日期%}'], ['201301']);
	bind_change('record_page', 'record_page_path', '{%日期%}', '201301', 'record_page_format',  ['{%日期%}', '{%页码%}'], ['201301', '10']);
	bind_change('author_index', 'author_path', '{%用户id%}', '1', 'author_format',  ['{%用户id%}', '{%页码%}'], ['1', '10']);
	bind_change('author_page', 'author_page_path', '{%用户id%}', '1', 'author_page_format',  ['{%用户id%}', '{%页码%}'], ['1', '10']);
	

	
});
</script>
