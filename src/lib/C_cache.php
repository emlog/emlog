<?php
/**
 * 生成文本缓存类
 * @copyright (c) 2008, Emlog All Rights Reserved
 * @version emlog-2.7.0
 * $Id$
 */

class mkcache {

	var $dbhd;
	var $dbprefix;

	function mkcache($dbhandle,$dbprefix)
	{
		$this->dbhd = $dbhandle;
		$this->dbprefix = $dbprefix;
	}
	/**
	 * 站点配置缓存
	 *
	 * @param unknown_type $cf
	 */
	function mc_config($cf)
	{
		$show_config=$this->dbhd->fetch_array($this->dbhd->query("SELECT * FROM ".$this->dbprefix."config"));
		$config_cache = array(
		'sitekey' => htmlspecialchars($show_config['site_key']),
		'blogname' =>htmlspecialchars(stripslashes($show_config['blogname'])),
		'bloginfo'=>htmlspecialchars(stripslashes($show_config['bloginfo'])),
		'index_lognum' =>$show_config['index_lognum'],
		'index_twnum' =>$show_config['index_twnum'],
		'index_comment_num' =>$show_config['index_comnum'],
		'ischkcomment'=>$show_config['ischkcomment'],
		'isurlrewrite'=>$show_config['isurlrewrite'],
		'isgzipenable'=>$show_config['isgzipenable'],
		'istrackback'=>$show_config['istrackback'],
		'comment_code'=>$show_config['comment_code'],
		'login_code'=>$show_config['login_code'],
		'comment_subnum'=>$show_config['comment_subnum'],
		'nonce_templet'=>$show_config['nonce_templet'],
		'blogurl'=>htmlspecialchars($show_config['blogurl']),
		'icp'=>htmlspecialchars($show_config['icp']),
		'timezone'=>$show_config['timezone'],
		'exarea'=>$show_config['exarea'],
		'edition'=>__VERSION
		);
		$cacheData = serialize($config_cache);
		$this->cacheWrite($cacheData,$cf);
	}
	/**
	 * 个人资料缓存
	 *
	 * @param unknown_type $cf
	 */
	function mc_blogger($cf)
	{
		$blogger = $this->dbhd->fetch_one_array("select * from ".$this->dbprefix."user ");
		$icon = '';
		if($blogger['photo'])
		{
			$photosrc = substr($blogger['photo'],3);
			$imgsize = chImageSize($blogger['photo'],ICON_MAX_W,ICON_MAX_H);
			$icon = "<img src=\"".htmlspecialchars($photosrc)."\" width=\"{$imgsize['w']}\" height=\"{$imgsize['h']}\" alt=\"blogger\" />";
		}
		$user_cache = array(
		'photo' => $icon,
		'name' =>htmlspecialchars($blogger['nickname']),
		'mail'	=>htmlspecialchars($blogger['email']),
		'des'=>$blogger['description']
		);
		$cacheData = serialize($user_cache);
		$this->cacheWrite($cacheData,$cf);
	}
	/**
	 * 博客统计缓存
	 *
	 * @param unknown_type $cf
	 */
	function mc_sta($cf)
	{
		$dh = $this->dbhd->fetch_one_array("select * from ".$this->dbprefix."statistics");
		$lognum = $this->dbhd->num_rows($this->dbhd->query("SELECT gid FROM ".$this->dbprefix."blog WHERE hide='n' "));
		$comnum = $this->dbhd->num_rows($this->dbhd->query("SELECT cid FROM ".$this->dbprefix."comment WHERE hide='n' "));
		$tbnum = $this->dbhd->num_rows($this->dbhd->query("SELECT gid FROM ".$this->dbprefix."trackback "));
		$twnum = $this->dbhd->num_rows($this->dbhd->query("SELECT id FROM ".$this->dbprefix."twitter "));
		$hidecom = $this->dbhd->num_rows($this->dbhd->query("SELECT gid FROM ".$this->dbprefix."comment where hide='y' "));

		$sta_cache = array(
		'day_view_count' => $dh['day_view_count'],
		'view_count' =>$dh['view_count'],
		'lognum'=>$lognum,
		'comnum'=>$comnum,
		'twnum'=>$twnum,
		'hidecom'=>$hidecom,
		'tbnum'=>$tbnum
		);
		$cacheData = serialize($sta_cache);
		$this->cacheWrite($cacheData,$cf);
	}
	/**
	 * 最新评论缓存
	 *
	 * @param unknown_type $cf
	 */
	function mc_comment($cf)
	{
		$show_config=$this->dbhd->fetch_array($this->dbhd->query("SELECT * FROM ".$this->dbprefix."config"));
		$index_comment_num = $show_config['index_comnum'];
		$comment_subnum = $show_config['comment_subnum'];
		$query=$this->dbhd->query("SELECT cid,gid,comment,date,poster,reply FROM ".$this->dbprefix."comment WHERE hide='n' ORDER BY cid DESC LIMIT 0, $index_comment_num ");
		$com_cache = array();
		while($show_com=$this->dbhd->fetch_array($query))
		{
			$com_cache[] = array(
			'url' => "index.php?action=showlog&gid={$show_com['gid']}#{$show_com['cid']}",
			'name' => htmlspecialchars($show_com['poster']),
			'content' => htmlClean2(subString($show_com['comment'],0,$comment_subnum)),
			'reply' => $show_com['reply']
			);
		}
		$cacheData = serialize($com_cache);
		$this->cacheWrite($cacheData,$cf);
	}
	/**
	 * 侧边栏标签缓存
	 *
	 * @param unknown_type $cf
	 */
	function mc_tags($cf)
	{
		$query=$this->dbhd->query("SELECT tagname,usenum FROM ".$this->dbprefix."tag ORDER BY usenum DESC");
		$tag_cache = array();
		while($show_tag = $this->dbhd->fetch_array($query))
		{
			$size = 14+round($show_tag['usenum']/3);
			$fontsize = $size >40?40:$size;
			$tag = $show_tag['tagname'];
			$tagurl = urlencode($show_tag['tagname']);
			$tag_cache[] = array(
			'tagurl' => $tagurl,
			'tagname' => htmlspecialchars($show_tag['tagname']),
			'fontsize'=> $fontsize
			);
		}

		$cacheData = serialize($tag_cache);
		$this->cacheWrite($cacheData,$cf);
	}
	/**
	 * 友站缓存
	 *
	 * @param unknown_type $cf
	 */
	function mc_link($cf)
	{
		$link_cache = array();
		$query=$this->dbhd->query("SELECT siteurl,sitename,description FROM ".$this->dbprefix."link ORDER BY taxis ASC");
		while($show_link=$this->dbhd->fetch_array($query))
		{
			$link_cache[] = array(
			'link'=>htmlspecialchars($show_link['sitename']),
			'url'=>htmlspecialchars($show_link['siteurl']),
			'des'=>htmlspecialchars($show_link['description'])
			);
		}
		$cacheData = serialize($link_cache);
		$this->cacheWrite($cacheData,$cf);
	}
	/**
	 * twitter缓存
	 *
	 * @param unknown_type $cf
	 */
	function mc_twitter($cf)
	{
		$show_config=$this->dbhd->fetch_array($this->dbhd->query("SELECT index_twnum FROM ".$this->dbprefix."config"));
		$index_twnum = $show_config['index_twnum']+1;
		$query=$this->dbhd->query("SELECT * FROM ".$this->dbprefix."twitter ORDER BY id DESC LIMIT $index_twnum");
		$tw_cache = array();
		while($show_tw=$this->dbhd->fetch_array($query))
		{
			$tw_cache[] = array(
			'content' => htmlspecialchars($show_tw['content']),
			'date' => $show_tw['date'],
			'id' => $show_tw['id']
			);
		}
		$cacheData = serialize($tw_cache);
		$this->cacheWrite($cacheData,$cf);
	}
	/**
	 * 日志归档缓存
	 *
	 * @param unknown_type $cf
	 */
	function mc_record($cf)
	{
		global $isurlrewrite;
		$query=$this->dbhd->query("select date from ".$this->dbprefix."blog WHERE hide='n' ORDER BY date DESC");
		$record='xxxx_x';
		$p = 0;
		$lognum = 1;
		$dang_cache = array();
		while($show_record=$this->dbhd->fetch_array($query))
		{
			$f_record=date('Y_n',$show_record['date']);
			if ($record!=$f_record){
				$h = $p-1;
				if($h!=-1)
				{
					$dang_cache[$h]['lognum'] = $lognum;
				}
				if($isurlrewrite == 'y')
				{
					$dang_cache[$p] = array(
					'record'=>date("Y年n月",$show_record['date']),
					'url'=>"record-".date("Ym",$show_record['date']).".html"
					);
				}
				else
				{
					$dang_cache[$p] = array(
					'record'=>date("Y年n月",$show_record['date']),
					'url'=>"index.php?record=".date("Ym",$show_record['date'])
					);
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
			$dang_cache[$j]['lognum'] = $lognum;
		}

		$cacheData = serialize($dang_cache);
		$this->cacheWrite($cacheData,$cf);
	}
	/**
	 * 日志标签缓存
	 *
	 * @param unknown_type $cf
	 */
	function mc_logtags($cf)
	{
		$sql="SELECT gid FROM ".$this->dbprefix."blog ORDER BY top DESC ,date DESC";
		$query1=$this->dbhd->query($sql);
		$log_cache_tags = array();
		while($show_log=$this->dbhd->fetch_array($query1))
		{
			$tag = '';
			$gid = $show_log['gid'];
			//tag
			$tquery = "SELECT tagname FROM ".$this->dbprefix."tag WHERE gid LIKE '%,$gid,%' " ;
			$result = $this->dbhd->query($tquery);
			$tagnum = $this->dbhd->num_rows($result);
			if($tagnum>0)
			{
				while($show_tag=$this->dbhd->fetch_array($result))
				{
					$tag .= "	<a href=\"./?action=taglog&tag=".urlencode($show_tag['tagname'])."\">".htmlspecialchars($show_tag['tagname']).'</a>';
				}
			}else
			{
				$tag = '';
			}
			$log_cache_tags[$show_log['gid']] = $tag;
			unset($tag);
		}
		$cacheData = serialize($log_cache_tags);
		$this->cacheWrite($cacheData,$cf);
	}
	/**
	 * 日志附件缓存
	 *
	 * @param unknown_type $cf
	 * @param unknown_type $cont_attid
	 */
	function mc_logatts($cf,$cont_attid='')
	{
		$sql="SELECT gid,attcache FROM ".$this->dbprefix."blog ORDER BY top DESC ,date DESC";
		$query1=$this->dbhd->query($sql);
		$log_cache_atts = array();
		while($rows=$this->dbhd->fetch_array($query1))
		{
			$gid = $rows['gid'];
			$att_img = '';
			$attachment = '';
			//attachment
			$attquery = $this->dbhd->query("SELECT * FROM ".$this->dbprefix."attachment WHERE blogid=$gid ");
			while($show_attach=$this->dbhd->fetch_array($attquery)){
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
					$att_img .= "<br />图片附件 : {$show_attach['attdes']}<br /><a href=\"$imgsrc2\" target=\"_blank\"><img src=\"$imgsrc\" width=\"{$imgsize['w']}\" height=\"{$imgsize['h']}\" border=\"0\" alt=\"点击查看原图\" /></a>";
				}else
				{
					$file_atturl = $atturl;
					$attachment .= "<br /><a href=\"$file_atturl\" target=\"_blank\">{$show_attach['filename']}</a>\t".changeFileSize($show_attach['filesize']).' '.$show_attach['attdes'];
				}
			}
			$log_cache_atts[$gid] = array(
			'attachment'=>$attachment,
			'att_img'=>$att_img
			);
			unset($attachment);
			unset($att_img);
		}
		$cacheData = serialize($log_cache_atts);
		$this->cacheWrite($cacheData,$cf);
	}

	/**
	 * 写入缓存
	 *
	 * @param unknown_type $cacheDate
	 * @param unknown_type $cachefile
	 */
	function cacheWrite ($cacheDate,$cachefile)
	{
		@ $fp = fopen($cachefile, 'wb') OR sysMsg('打开缓存文件失败，请查看文件权限');
		@ $fw =	fwrite($fp,$cacheDate) OR sysMsg('写入缓存失败，请查看文件权限');
		fclose($fp);
	}

	/**
	 * 读取缓存文件
	 *
	 * @param  $filename 缓存文件
	 * @return unknown
	 */
	function readCache($cachefile)
	{
		if(@$fp = fopen($cachefile, 'r'))
		{
			@$data = fread($fp,filesize($cachefile));
			fclose($fp);
		}
		return unserialize($data);
	}
}
?>