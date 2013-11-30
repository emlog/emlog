<?php
function emer_share_post($blogOrtwitter, $emer_post_data = array()) {
    global $CACHE;
    $emer_user_cache = $CACHE->readCache('user');
    $emer_share_post_url = EMER_API_URL. $blogOrtwitter;
    $emer_post_data_base = array(
		'version'=>EMEER_SHARE_VERSION,
		'mid'=>EMEER_SHARE_ID
    );
    $post_data = array_merge($emer_post_data_base, $emer_post_data);
    $emer_share_ch = curl_init();
    curl_setopt($emer_share_ch, CURLOPT_URL, $emer_share_post_url);
    curl_setopt($emer_share_ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($emer_share_ch, CURLOPT_POST, 1);
	curl_setopt($emer_share_ch,CURLOPT_USERPWD,EMEER_SHARE_ID.':'.EMEER_SHARE_PW);
    curl_setopt($emer_share_ch, CURLOPT_POSTFIELDS, $post_data);
	
    $emer_share_output = curl_exec($emer_share_ch);

    if ($emer_share_output === FALSE) {
			emMsg("cURL Error: " . curl_error($emer_share_ch));
    }
	$emer_share_resluts = json_decode($emer_share_output,true);
	
	if(!$emer_share_resluts) emMsg($emer_share_output);
	
	if($emer_share_resluts["status"] === false){
		emMsg("云平台同步错误提示: " . $emer_share_resluts["info"]);
	}
	return $emer_share_resluts['data'];
}

function emer_share_excerpt($data){
	$emer_excerpt = trim(preg_replace("/&[a-z]+\;/i", '', strip_tags(stripcslashes($data['content']))));
	if(empty($emer_excerpt)){
			$emer_excerpt = $data['title'].'无文字预览！';
	}else{
		$emer_excerpt_length = emer_share_getStringLength($emer_excerpt);
		if($emer_excerpt_length  > 200){
			$emer_excerpt = emer_share_subString($emer_excerpt,0,200)."...";
		}
	}
	return $emer_excerpt;
}

function emer_share_getStringLength($text)
{
	if(function_exists('mb_substr'))
	{
		$length = mb_strlen($text,'UTF-8');
	}elseif(function_exists('iconv_substr')){
		$length = iconv_strlen($text,'UTF-8');
	}else{
		preg_match_all("/[\x01-\x7f]|[\xc2-\xdf][\x80-\xbf]|\xe0[\xa0-\xbf][\x80-\xbf]|[\xe1-\xef][\x80-\xbf][\x80-\xbf]|\xf0[\x90-\xbf][\x80-\xbf][\x80-\xbf]|[\xf1-\xf7][\x80-\xbf][\x80-\xbf][\x80-\xbf]/", $text, $ar);
		$length = count($ar[0]);
	}
	return $length;
}

function emer_share_subString($text, $start=0, $limit=12)
{
	if(function_exists('mb_substr'))
	{
		$more = (mb_strlen($text, 'UTF-8') > $limit) ? TRUE : FALSE;
		$text = mb_substr($text, 0, $limit, 'UTF-8');
		return $text;
	}elseif(function_exists('iconv_substr')){
		$more = (iconv_strlen($text, 'UTF-8') > $limit) ? TRUE : FALSE;
		$text = iconv_substr($text, 0, $limit, 'UTF-8');
		return $text;
	}else{
		preg_match_all("/[\x01-\x7f]|[\xc2-\xdf][\x80-\xbf]|\xe0[\xa0-\xbf][\x80-\xbf]|[\xe1-\xef][\x80-\xbf][\x80-\xbf]|\xf0[\x90-\xbf][\x80-\xbf][\x80-\xbf]|[\xf1-\xf7][\x80-\xbf][\x80-\xbf][\x80-\xbf]/", $text, $ar);
		if(func_num_args() >= 3)
		{
			if(count($ar[0]) > $limit){
				$more = TRUE;
				$text = join("", array_slice($ar[0], 0, $limit));
			}else{
				$more = FALSE;
				$text = join("", array_slice($ar[0], 0, $limit));
			}
		}else{
			$more = FALSE;
			$text =  join("", array_slice($ar[0], 0));
		}
		return $text;
	}
}

function emer_share_img($content){
	preg_match('/<img([^>]+)src=\"([^>\"]+)\"?([^>]*)>/i',stripcslashes($content),$matches);
	if(count($matches) > 0){
		$url = parse_url($matches[2]);
		$host = $_SERVER['HTTP_HOST'];
		if(isset($url['host']) && $url['host'] != $host) {
			return $matches[2];
		}else{
			return BLOG_URL.$matches[2];
		}
	}
	
	return "";
}

function get_blog_tag($logid){
	global $CACHE;
	$log_cache_tags = $CACHE->readCache('logtags');
	$emer_share_tag = array();
	if (!empty($log_cache_tags[$logid])){
		foreach ($log_cache_tags[$logid] as $value){
			$emer_share_tag []= "'".$value['tagname']."'";
		}
    }
	return join(',',$emer_share_tag);
}
/**
 * 兼容函数库 针对5.2.0以下版本
 */
if (!function_exists('json_decode')) {
    function json_decode($json,$assoc=false)
    {
        // 目前不支持二维数组或对象
        $begin  =  substr($json,0,1) ;
        if(!in_array($begin,array('{','[')))
            // 不是对象或者数组直接返回
            return $json;
        $parse = substr($json,1,-1);
        $data  = explode(',',$parse);
        if($flag = $begin =='{' ) {
            // 转换成PHP对象
            $result   = new stdClass();
            foreach($data as $val) {
                $item    = explode(':',$val);
                $key =  substr($item[0],1,-1);
                $result->$key = json_decode($item[1],$assoc);
            }
            if($assoc)
                $result   = get_object_vars($result);
        }else {
            // 转换成PHP数组
            $result   = array();
            foreach($data as $val)
                $result[]  =  json_decode($val,$assoc);
        }
        return $result;
    }
}
?>