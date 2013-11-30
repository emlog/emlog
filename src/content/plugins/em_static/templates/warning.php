<?php defined('EMLOG_ROOT') or die('本页面禁止直接访问!'); ?>
<?php 
$cache = Cache::getInstance();
$options = $cache->readCache('options');
$tags = $cache->readCache('tags');
if ($options['isurlrewrite'] == 1):
?>
<div style="border:1px solid #FF6600; text-align: center; color: #ff6600; padding: 2px;">
	请注意: 您博客的日志链接的形式不是默认形式，请到<a href="./permalink.php"><u>设置页面</u></a>将博客的url形式设置为默认格式。
</div>
<?php endif;?>
<?php if ( !empty($tags) && ! is_writable(EM_STATIC_TAG_CACHE_FILE)):?>
<div style="border:1px solid #FF6600; text-align: center; color: #ff6600; padding: 2px;">
	请注意:您还未给您博客的所有标签设置url别名, 请到<a href="?plugin=em_static&do=tag_alias"><u>设置页面</u></a>设置url别名！
</div>
<?php endif;?>
<?php if ( ! is_writable(EMLOG_ROOT)):?>
<div style="border:1px solid #FF6600; text-align: center; color: #ff6600; padding: 2px;">
	请注意: 您的博客目录没有写入权限，插件无法创建目录和静态文件。
</div>
<?php endif;?>
<?php if ( ! is_writable(EM_STATIC_ROOT)):?>
<div style="border:1px solid #FF6600; text-align: center; color: #ff6600; padding: 2px;">
	请注意: 插件目录没有写入权限，插件无法创建缓存文件。
</div>
<?php endif;?>
<?php if ( ! function_exists('curl_init')):?>
<div style="border:1px solid #FF6600; text-align: center; color: #ff6600; padding: 2px;">
	请注意:您的空间不支持php_curl扩展，插件将无法正常工作！
</div>
<?php endif;?>
<?php unset($cache, $options, $tags);?>
