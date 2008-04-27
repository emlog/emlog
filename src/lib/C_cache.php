<?php
/**
 * 生成文本缓存类
 * @copyright (c) 2008, Emlog All Rights Reserved
 * @version emlog-2.6.5
 */

class mkcache {
	
	var $link;
	var $Archives;
	var $log_tags;
	var $log_atts;//附件
	var $tags;
	var $comment;
	var $twitter;

	//站点配置缓存
	function mc_config($cf)
	{
		global $DB,$db_prefix;
		$show_config=$DB->fetch_array($DB->query("SELECT * FROM {$db_prefix}config"));
		$exarea = addslashes($show_config['exarea']);
		$config ="\n\$config_cache = array('sitekey' =>\"".htmlspecialchars($show_config['site_key'])."\",'blogname' =>\"".htmlspecialchars(stripslashes($show_config['blogname']))."\",'bloginfo'=>\"".htmlspecialchars(stripslashes($show_config['bloginfo']))."\",'index_lognum' =>\"".$show_config['index_lognum']."\",'index_twnum' =>\"".$show_config['index_twnum']."\",'index_tagnum' =>\"".$show_config['index_tagnum']."\",'index_comment_num' =>\"".$show_config['index_comnum']."\",'ischkcomment'=>\"".$show_config['ischkcomment']."\",'isurlrewrite'=>\"".$show_config['isurlrewrite']."\",'istrackback'=>\"".$show_config['istrackback']."\",'comment_code'=>\"".$show_config['comment_code']."\",'login_code'=>\"".$show_config['login_code']."\",'comment_subnum'=>\"".$show_config['comment_subnum']."\",'nonce_templet'=>\"".$show_config['nonce_templet']."\",'blogurl'=>\"".htmlspecialchars($show_config['blogurl'])."\",'icp'=>\"".htmlspecialchars($show_config['icp'])."\",'timezone'=>\"".$show_config['timezone']."\",'exarea'=>\"".$exarea."\");";

		$cache = "<?php".$config."\n?>";
		$this->mc_print($cache,$cf);
	}
	//个人资料
	function mc_blogger($cf)
	{
		global $DB,$db_prefix;
		$blogger = $DB->fetch_one_array("select * from {$db_prefix}user ");
		$icon = '';
		if($blogger['photo'])
		{
			$photosrc = substr($blogger['photo'],3);
			$imgsize = chImageSize($blogger['photo'],ICON_MAX_W,ICON_MAX_H);
			$icon = "<img src=\\\"".htmlspecialchars($photosrc)."\\\" width=\\\"".$imgsize['w']."\\\" height=\\\"".$imgsize['h']."\\\" alt=\\\"blogger\\\" />";
		}
		$user="\n\$user_cache = array('photo' => \"$icon\",'name' =>\"".htmlspecialchars($blogger['nickname'])."\",'mail'	=>\"".htmlspecialchars($blogger['email'])."\",'des'=>\"".htmlspecialchars($blogger['description'])."\");";
		$cache = "<?php".$user."\n?>";
		$this->mc_print($cache,$cf);
	}
	//访问统计
	function mc_sta($cf)
	{
		global $DB,$db_prefix;
		$dh = $DB->fetch_one_array("select * from {$db_prefix}statistics");
		$lognum = $DB->num_rows($DB->query("SELECT gid FROM {$db_prefix}blog WHERE hide='n' "));
		$comnum = $DB->num_rows($DB->query("SELECT cid FROM {$db_prefix}comment WHERE hide='n' "));
		$tbnum = $DB->num_rows($DB->query("SELECT gid FROM {$db_prefix}trackback "));
		$twnum = $DB->num_rows($DB->query("SELECT id FROM {$db_prefix}twitter "));
		$hidecom = $DB->num_rows($DB->query("SELECT gid FROM {$db_prefix}comment where hide='y' "));

		$sta="\n\$sta_cache = array(
				'day_view_count' => \"".$dh['day_view_count']."\",
				'view_count' =>\"".$dh['view_count']."\",
				'lognum'=>\"".$lognum."\",
				'comnum'=>\"".$comnum."\",
				'twnum'=>\"".$twnum."\",
				'hidecom'=>\"".$hidecom."\",
				'tbnum'=>\"".$tbnum."\"
				);";
		$cache = "<?php".$sta."\n?>";
		$this->mc_print($cache,$cf);
	}
	//评论缓存
	function mc_comment($cf)
	{
		global $DB,$db_prefix;
		$show_config=$DB->fetch_array($DB->query("SELECT * FROM {$db_prefix}config"));
		$index_comment_num = $show_config['index_comnum'];
		$comment_subnum = $show_config['comment_subnum'];
		$query=$DB->query("SELECT cid,gid,comment,date,poster FROM {$db_prefix}comment WHERE hide='n' ORDER BY cid DESC LIMIT 0, $index_comment_num ");
		$j = 0;
		while($show_com=$DB->fetch_array($query)){
			$this->comment.= "\n\$com_cache[".$j."] = array('url'=>\"index.php?action=showlog&gid=".$show_com['gid']."#".$show_com['cid']."\",'name'=>\"".base64_encode(htmlspecialchars($show_com['poster']))."\",'content'=>\"".base64_encode(htmlClean2(subString($show_com['comment'],0,$comment_subnum)))."\");";
			$j++;
		}
		$cache = "<?php".$this->comment."\n?>";
		$this->mc_print($cache,$cf);
	}
	//侧边栏标签缓存
	function mc_tags($cf)
	{
		global $DB,$db_prefix;
		$show_config=$DB->fetch_array($DB->query("SELECT index_tagnum FROM {$db_prefix}config"));
		$index_tagnum = $show_config['index_tagnum'];
		$query=$DB->query("SELECT tagname,usenum FROM {$db_prefix}tag ORDER BY usenum DESC LIMIT 0, $index_tagnum ");
		$m = 0;
		while($show_tag = $DB->fetch_array($query)){
			$size = 14+round($show_tag['usenum']/3);
			$fontsize = $size >40?40:$size;
			$tag = $show_tag['tagname'];
			$tagurl = urlencode($show_tag['tagname']);
			$this->tags.= "\n\$tag_cache[".$m."] = array('tagurl'=>\"$tagurl\",'tagname'=>\"".htmlspecialchars($show_tag['tagname'])."\",'fontsize'=>\"$fontsize\");";
			$m++;
		}

		$cache = "<?php".$this->tags."\n?>";
		$this->mc_print($cache,$cf);
	}
	//友站缓存
	function mc_link($cf)
	{
		global $DB,$db_prefix;
		$query=$DB->query("SELECT siteurl,sitename,description FROM {$db_prefix}link ORDER BY taxis ASC");
		$k = 0;
		while($show_link=$DB->fetch_array($query)){
			$this->link.= "\n\$link_cache[".$k."] = array('link'=>\"".htmlspecialchars($show_link['sitename'])."\",'url'=>\"".htmlspecialchars($show_link['siteurl'])."\",'des'=>\"".htmlspecialchars($show_link['description'])."\");";
			$k++;
		}
		$cache = "<?php".$this->link."\n?>";
		$this->mc_print($cache,$cf);
	}
	//twitter
	function mc_twitter($cf)
	{
		global $DB,$db_prefix;
		$show_config=$DB->fetch_array($DB->query("SELECT index_twnum FROM {$db_prefix}config"));
		$index_twnum = $show_config['index_twnum']+1;
		$query=$DB->query("SELECT * FROM {$db_prefix}twitter ORDER BY id DESC LIMIT $index_twnum");
		$k = 0;
		while($show_tw=$DB->fetch_array($query)){
			$this->twitter.= "\n\$tw_cache[".$k."] = array('content'=>\"".htmlspecialchars($show_tw['content'])."\",'date'=>\"".$show_tw['date']."\",'id'=>\"".$show_tw['id']."\");";
			$k++;
		}
		$cache = "<?php".$this->twitter."\n?>";
		$this->mc_print($cache,$cf);
	}
	//日志归档缓存
	function mc_record($cf)
	{
		global $DB,$db_prefix;
		global $isurlrewrite;
		$query=$DB->query("select date from {$db_prefix}blog WHERE hide='n' ORDER BY date DESC");
		$record='xxxx_x';
		$p = 0;
		$lognum = 1;
		while($show_record=$DB->fetch_array($query)){
			$f_record=date('Y_n',$show_record['date']);
			if ($record!=$f_record){
				$h = $p-1;
				if($h!=-1)
				{
					$this->Archives.= "\n\$dang_cache[".$h."]['lognum']=\"".$lognum."\";";
				}
				if($isurlrewrite == 'y')
				{
					$this->Archives.= "\n\$dang_cache[".$p."] = array('record'=>\"".date("Y年n月",$show_record['date'])."\",'url'=>\"record-".date("Ym",$show_record['date']).".html\",'lognum'=>\"\");";
				}
				else
				{
					$this->Archives.= "\n\$dang_cache[".$p."] = array('record'=>\"".date("Y年n月",$show_record['date'])."\",'url'=>\"index.php?record=".date("Ym",$show_record['date'])."\",'lognum'=>\"\");";
				}
				$p++;
				$lognum = 1;
			}else{
				$lognum++;
				continue;
			}
			$record=$f_record;
		}
		$j = $p-1;
		if($j>=0)
		{
			$this->Archives.= "\n\$dang_cache[".$j."]['lognum']=\"".$lognum."\";";
		}

		$cache = "<?php".$this->Archives."\n?>";
		$this->mc_print($cache,$cf);
	}
	//日志标签缓存
	function mc_logtags($cf)
	{
		global $DB,$db_prefix;
		$sql="SELECT gid FROM {$db_prefix}blog ORDER BY top DESC ,date DESC";
		$query1=$DB->query($sql);
		while($show_log=$DB->fetch_array($query1)) {
			$tag = '';
			$gid = $show_log['gid'];
			//tag
			$tquery = "SELECT tagname FROM {$db_prefix}tag WHERE gid LIKE '%,$gid,%' " ;
			$result = $DB->query($tquery);
			$tagnum = $DB->num_rows($result);
			if($tagnum>0){
				while($show_tag=$DB->fetch_array($result)){
					$tag .= "	<a href=\\\"./?action=taglog&tag=".urlencode($show_tag['tagname'])."\\\">".htmlspecialchars($show_tag['tagname']).'</a>';
				}
			}else	{
				$tag = '';
			}
			$this->log_tags .= "\n\$log_cache_tags[".$show_log['gid']."] = \"".$tag."\";";
			unset($tag);
		}
		$cache = "<?php".$this->log_tags."\n?>";
		$this->mc_print($cache,$cf);
	}
	//日志附件缓存
	function mc_logatts($cf,$cont_attid='')
	{
		global $DB,$db_prefix;
		$sql="SELECT gid,attcache FROM {$db_prefix}blog ORDER BY top DESC ,date DESC";
		$query1=$DB->query($sql);
		while($rows=$DB->fetch_array($query1)){
			$gid = $rows['gid'];
			$att_img = '';
			$attachment = '';
			//attachment
			$attquery = $DB->query("SELECT * FROM {$db_prefix}attachment WHERE blogid=$gid ");
			while($show_attach=$DB->fetch_array($attquery)){
				$cont_attid = unserialize($rows['attcache']);
				if($cont_attid && in_array($show_attach['aid'],$cont_attid))
				{
					continue;
				}
				$att_path = $show_attach['filepath'];//eg: ../uploadfile/200710/b.jpg
				$atturl = substr($att_path,3);//eg: uploadfile/200710/b.jpg
				$postfix = strtolower(substr(strrchr($show_attach['filename'], "."),1));//文件后缀
				if($postfix == 'jpg' OR $postfix == 'jpeg' OR $postfix == 'gif' OR $postfix == 'png')
				{
					$imgsrc = $atturl;
					if(substr(basename($imgsrc),0,5) == 'thum-')
					{
						$imgsrc2 = str_replace('thum-','',$imgsrc);
					}else{
						$imgsrc2 = $imgsrc;
					}
					$imgsize = chImageSize($att_path,IMG_ATT_MAX_W,IMG_ATT_MAX_H);
					$att_img .= "<br />图片附件 : ".$show_attach['attdes']."<br /><a href=\\\"$imgsrc2\\\" target=\\\"_blank\\\"><img src=\\\"$imgsrc\\\" width=\\\"".$imgsize['w']."\\\" height=\\\"".$imgsize['h']."\\\" border=\\\"0\\\" alt=\\\"点击查看原图\\\" /></a>";
				}else
				{
					$file_atturl = $atturl;
					$attachment .= "<br /><a href=\\\"".$file_atturl."\\\" target=\\\"_blank\\\">".$show_attach['filename']."</a>\t".changeFileSize($show_attach['filesize']).' '.$show_attach['attdes'];
				}
			}
			$this->log_atts .= "\n\$log_cache_atts[".$gid."] = array('attachment'=>\"".$attachment."\",'att_img'=>\"".$att_img."\");";
			unset($attachment);
			unset($att_img);
		}
		$cache = "<?php".$this->log_atts."\n?>";
		$this->mc_print($cache,$cf);
	}

	//写入缓存
	function mc_print ($content,$cachefile)
	{
		@ $fp = fopen($cachefile, 'wb') OR sysMsg('打开缓存文件失败，请查看文件权限');
		@ $fw =	fwrite($fp,$content) OR sysMsg('写入缓存失败，请查看文件权限');
		fclose($fp);
	}
}
?>