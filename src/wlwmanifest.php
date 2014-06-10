<?php
/**
 * Emlog wlwmanifest Service Interface
 *
 * @copyright (c) Valery Votintsev, codersclub.org
 */

define('EMLOG_ROOT', str_replace('\\','/',dirname(__FILE__)));

load_language('wlwmanifest');

require_once EMLOG_ROOT . '/config.php';
require_once EMLOG_ROOT . '/include/lib/function.base.php';

header("Content-type: text/xml; charset=utf-8");

?><?xml version="1.0" encoding="utf-8" ?>
<manifest xmlns="http://schemas.microsoft.com/wlw/manifest/weblog">
	<options>
		<clientType>Metaweblog API</clientType>
		<supportsKeywords>Yes</supportsKeywords>
		<supportsGetTags>Yes</supportsGetTags>
	</options>
	<weblog>
		<serviceName>Emlog</serviceName>
<!--vot-->	<homepageLinkText><?=<?=lang('site_view')?></homepageLinkText>
<!--vot-->	<adminLinkText><?=lang('admin_panel')?></adminLinkText>
		<adminUrl>
			<![CDATA[ 
				{blog-postapi-url}/../admin/ 
			]]>
		</adminUrl>
		<postEditingUrl>
			<![CDATA[ 
				{blog-postapi-url}/../admin/write_log.php?action=edit&gid={post-id} 
			]]>
		</postEditingUrl>
	</weblog>
  <buttons>
	<button>
		<id>0</id>
<!--vot-->	<text><?=lang('comment_edit')?></text>
		<clickUrl>
			<![CDATA[ 
				{blog-postapi-url}/../admin/comment.php
			]]>
		</clickUrl>
	</button>
  </buttons>
</manifest>