<?php
/**
 * google picasa相册插件
 * @copyright (c) Emlog All Rights Reserved
 */
require_once('XMLParser.php');
require_once('./common.php');

$cerTemplatePath = TEMPLATE_PATH.$nonce_templet.'/';
$calendar_url = './calendar.php?' ;

$album = isset($_GET['album']) ? $_GET['album'] : '';

$user_info = '';
$cachefile = './content/plugins/picasa_album/cache/account';
if(@$fp = fopen($cachefile, 'r'))
{
	$user_info = unserialize(fread($fp,filesize($cachefile)));
	fclose($fp);
}
$account = isset($user_info['account']) ? $user_info['account'] : '';
$thum_width = isset($user_info['thum_width']) ? $user_info['thum_width'] : '';

//显示相册列表
if (!$album)
{
	$XMLP = new SofeeXmlParser();
	$feed = "http://picasaweb.google.com/data/feed/base/user/{$account}?kind=album&access=public&hl=zh_CN";
	$XMLP->parseFile($feed);

	$albumData = $XMLP->getTree();
	$albumData = $albumData['feed'];

	$blogtitle =  $albumData['author']['name']['value'] . '的相册 - ' . $blogname;
	$log_title =  $albumData['author']['name']['value'] . '的相册';
	$log_content = '';
	
	$albums = isset($albumData['entry']) ? $albumData['entry'] : array();
	
	foreach ($albums as $val)
	{
		if(!is_array($val))
		{
			$albums = array($albums);
			break;
		}
	}
	foreach ($albums as $val)
	{
		$title = $val['media:group']['media:title']['value'];
		$description = subString($val['media:group']['media:description']['value'], 0, 30);
		preg_match('/albumid\/(\d+)/', $val['id']['value'], $match);
		$albumId = $match[1];
		$thumb = $val['media:group']['media:thumbnail'];

		$thumb_url = $thumb['url'];
		$thumb_width = $thumb['width'];
		$thumb_height = $thumb['height'];
		$log_content .=	'
		<ul id="pic_list">
		<li>
		<a href="./?plugin=picasa_album&album='.$albumId.'">
		<img src="'.$thumb_url.'" width="'.$thumb_width.'" height="'.$thumb_height.'"></a>
		<p><a href="./?plugin=picasa_album&album='.$albumId.'">'.$title.'</a><br /><span>'.$description.'</span></p>
		</li>
		</ul>';
	}

	$allow_remark = 'n';
	$logid = '';

	addAction('index_head', 'album_list_css');
	
	include getViews('header');
	include getViews('page');
}
//显示单个相册里的照片
if ($album)
{
	$XMLP = new SofeeXmlParser();
	$feed = "http://picasaweb.google.com/data/feed/base/user/{$account}/albumid/".$album."?hl=zh_CN";
	$XMLP->parseFile($feed);

	$albumData = $XMLP->getTree();
	$albumData = $albumData['feed'];

	$blogtitle =  $albumData['title']['value'] . ' - ' . $blogname;
	$log_title =  $albumData['title']['value'];
	$description =  $albumData['subtitle']['value'];
	$log_content = '
	<div class="pic_info">'.$description.'</div>
	<div class="pic_back"> <a href="./?plugin=picasa_album">&laquo;返回相册列表</a></div>
	<div id="gallery"><ul>';

	$photos = isset($albumData['entry']) ? $albumData['entry'] : array();
	
	foreach ($photos as $val)
	{
		if(!is_array($val))
		{
			$photos = array($photos);
			break;
		}
	}

	foreach ($photos as $val)
	{
		$thumb = $val['media:group']['media:thumbnail'][1];
		$thumb_url = $thumb['url'];
		$thumb_width = $thumb['width'];
		$thumb_height = $thumb['height'];
		$photo_src = preg_replace('/^(.+\/)(s\d+)(.+)$/', '$1s'.$thum_width.'$3', $thumb_url);

		$log_content .=	'
        <li>
		<a href="'.$photo_src.'">
		<img src="'.$thumb_url.'" width="'.$thumb_width.'" height="'.$thumb_height.'"></a>
		</li>';
	}
	$log_content .= '</ul></div>';

	$allow_remark = 'n';
	$logid = '';

	addAction('index_head', 'album_photo_css');

	include getViews('header');
	include getViews('page');
}

//单个相册里的照片 css样式
function album_photo_css()
{
echo <<<EOT
<script type="text/javascript" src="./content/plugins/picasa_album/js/jquery.js"></script>
<script type="text/javascript" src="./content/plugins/picasa_album/js/jquery.lightbox-0.5.js"></script>
<link rel="stylesheet" type="text/css" href="./content/plugins/picasa_album/css/jquery.lightbox-0.5.css" media="screen" />
<script type="text/javascript">
$(function() {
$('#gallery a').lightBox();
});
</script>
<style type="text/css">
#gallery {padding: 10px;text-align:center; font-size:12px;}
.pic_info{ font-size:12px; color:#999999; padding:5px 17px; line-height:1.6;}
#gallery ul { list-style: none; }
#gallery ul li { display: inline; }
#gallery ul img {padding: 5px 5px 20px;border:1px solid #CCCCCC; margin:5px;}
#gallery ul a:hover img {border:1px solid #000;margin:5px;}
.pic_back {text-align:center; font-size:12px; padding:0px 20px;}
</style>
EOT;
}
//相册列表 css样式
function album_list_css()
{
echo <<<EOT
<style type="text/css">
#pic_list{font-size:12px;color: #666666;float:left;margin:3px;padding:0px;text-align:center;}
#pic_list p{margin:0px; padding:0px;width:180px;}
#pic_list li{width:180px;height:210px;margin:0px !important;padding:0px;list-style:none; overflow:hidden; float:left;}
#pic_list li img{margin:0px;padding:0px;border-bottom:1px #fff solid;}
</style>
EOT;
}

cleanPage(true);

?>
