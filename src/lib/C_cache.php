<?php
/**
 * 生成文本缓存类
 * @copyright (c) Emlog All Rights Reserved
 * @version emlog-3.2.0
 * $Id$
 */

class mkcache {
	var $db;
	var $db_prefix;

	function mkcache($dbhandle, $db_prefix)
	{
		$this->db = $dbhandle;
		$this->db_prefix = $db_prefix;
	}
	/**
	 * 站点配置缓存
	 */
	function mc_options()
	{
		$options_cache = array();
		$res = $this->db->query("SELECT * FROM ".$this->db_prefix."options");
		while($row = $this->db->fetch_array($res))
		{
			if(in_array($row['option_name'],array('site_key', 'blogname', 'bloginfo', 'blogurl', 'icp')))
			{
				$row['option_value'] = htmlspecialchars($row['option_value']);
			}
			$options_cache[$row['option_name']] = $row['option_value'];
		}
		$cacheData = serialize($options_cache);
		$this->cacheWrite($cacheData,'options');
	}
	/**
	 * 用户信息缓存
	 */
	function mc_user()
	{
		$user_cache = array();
		$query = $this->db->query("SELECT * FROM ".$this->db_prefix."user");
		while($row = $this->db->fetch_array($query))
		{
			$logNum = $this->db->num_rows($this->db->query("SELECT gid FROM ".$this->db_prefix."blog WHERE author={$row['uid']} and hide='n' and type='blog'"));
			$draftNum = $this->db->num_rows($this->db->query("SELECT gid FROM ".$this->db_prefix."blog WHERE author={$row['uid']} and hide='y' and type='blog'"));
			$commentNum = $this->db->num_rows($this->db->query("SELECT a.cid FROM ".$this->db_prefix."comment as a, ".$this->db_prefix."blog as b where a.gid=b.gid and b.author={$row['uid']}"));
			$hidecommentNum = $this->db->num_rows($this->db->query("SELECT a.cid FROM ".$this->db_prefix."comment as a, ".$this->db_prefix."blog as b where a.gid=b.gid and a.hide='y' and b.author={$row['uid']}"));
			$tbNum = $this->db->num_rows($this->db->query("SELECT a.tbid FROM ".$this->db_prefix."trackback as a, ".$this->db_prefix."blog as b where a.gid=b.gid and b.author={$row['uid']}"));
			$icon = '';
			if($row['photo'] && file_exists($row['photo']))
			{
				$photosrc = substr($row['photo'],3);
				$imgsize = chImageSize($row['photo'],ICON_MAX_W,ICON_MAX_H);
				$icon = "<img src=\"".htmlspecialchars($photosrc)."\" width=\"{$imgsize['w']}\" height=\"{$imgsize['h']}\" alt=\"blogger\" />";
			}
			$row['nickname'] = empty($row['nickname']) ? $row['username'] : $row['nickname'];
			$user_cache[$row['uid']] = array(
			'photo' => $icon,
			'name' =>htmlspecialchars($row['nickname']),
			'mail'	=>htmlspecialchars($row['email']),
			'des'=>$row['description'],
			'lognum' => $logNum,
			'draftnum' => $draftNum,
			'commentnum' => $commentNum,
			'hidecommentnum' => $hidecommentNum,
			'tbnum' => $tbNum
			);
		}
		$cacheData = serialize($user_cache);
		$this->cacheWrite($cacheData,'user');
	}
	/**
	 * 博客统计缓存
	 */
	function mc_sta()
	{
		$lognum = $this->db->num_rows($this->db->query("SELECT gid FROM ".$this->db_prefix."blog WHERE type='blog' and hide='n' "));
		$draftnum = $this->db->num_rows($this->db->query("SELECT gid FROM ".$this->db_prefix."blog WHERE type='blog' and hide='y'"));
		$comnum = $this->db->num_rows($this->db->query("SELECT cid FROM ".$this->db_prefix."comment WHERE hide='n' "));
		$hidecom = $this->db->num_rows($this->db->query("SELECT gid FROM ".$this->db_prefix."comment where hide='y' "));
		$tbnum = $this->db->num_rows($this->db->query("SELECT gid FROM ".$this->db_prefix."trackback "));
		$twnum = $this->db->num_rows($this->db->query("SELECT id FROM ".$this->db_prefix."twitter "));
		$sta_cache = array(
		'lognum'=>$lognum,
		'draftnum'=>$draftnum,
		'comnum'=>$comnum,
		'comnum_all'=>$comnum + $hidecom,
		'twnum'=>$twnum,
		'hidecomnum'=>$hidecom,
		'tbnum'=>$tbnum
		);
		$cacheData = serialize($sta_cache);
		$this->cacheWrite($cacheData,'sta');
	}
	/**
	 * 最新评论缓存
	 */
	function mc_comment()
	{
		$show_config=$this->db->fetch_array($this->db->query("SELECT option_value FROM ".$this->db_prefix."options where option_name='index_comnum'"));
		$index_comnum = $show_config['option_value'];
		$show_config=$this->db->fetch_array($this->db->query("SELECT option_value FROM ".$this->db_prefix."options where option_name='comment_subnum'"));
		$comment_subnum = $show_config['option_value'];
		$query=$this->db->query("SELECT cid,gid,comment,date,poster,reply FROM ".$this->db_prefix."comment WHERE hide='n' ORDER BY cid DESC LIMIT 0, $index_comnum ");
		$com_cache = array();
		while($show_com=$this->db->fetch_array($query))
		{
			$com_cache[] = array(
			'url' => BLOG_URL."?post={$show_com['gid']}#{$show_com['cid']}",
			'name' => htmlspecialchars($show_com['poster']),
			'content' => htmlClean(subString($show_com['comment'],0,$comment_subnum), false),
			'reply' => $show_com['reply']
			);
		}
		$cacheData = serialize($com_cache);
		$this->cacheWrite($cacheData,'comments');
	}
	/**
	 * 侧边栏标签缓存
	 */
	function mc_tags()
	{
		$tag_cache = array();
		$query=$this->db->query("SELECT gid FROM ".$this->db_prefix."tag");
		$i = 0;
		$j = 0;
		$tagnum = 0;
		$maxuse = 0;
		$minuse = 0;
		while($row = $this->db->fetch_array($query))
		{
			$usenum = substr_count($row['gid'], ',') - 1; 
			if($usenum > $i)
			{
				$maxuse = $usenum;
				$i = $usenum;
			}
			if($usenum < $j)
			{
				$minuse = $usenum;
			}
			$j = $usenum;
			$tagnum++;
		}
		$spread = ($tagnum>12?12:$tagnum);
		$rank = $maxuse-$minuse;
		$rank = ($rank==0?1:$rank);
		$rank = $spread/$rank;
		//获取草稿id
		$hideGids = array();
		$query=$this->db->query("SELECT gid FROM ".$this->db_prefix."blog where hide='y' and type='blog'");
		while($row = $this->db->fetch_array($query))
		{
			$hideGids[] = $row['gid'];
		}
		$query=$this->db->query("SELECT tagname,gid FROM ".$this->db_prefix."tag");
		while($show_tag = $this->db->fetch_array($query))
		{
			//排除草稿在tag日志数里的统计
			foreach ($hideGids as $val)
			{
				$show_tag['gid'] = str_replace(','.$val.',', ',', $show_tag['gid']); 
			}
			if($show_tag['gid'] == ',')
			{
				continue;
			}
			$usenum = substr_count($show_tag['gid'], ',') - 1;
			$fontsize = 10 + round(($usenum - $minuse) * $rank);//maxfont:22pt,minfont:10pt
			$tag_cache[] = array(
			'tagurl' => urlencode($show_tag['tagname']),
			'tagname' => htmlspecialchars($show_tag['tagname']),
			'fontsize' => $fontsize,
			'usenum' => $usenum
			);
		}
		$cacheData = serialize($tag_cache);
		$this->cacheWrite($cacheData,'tags');
	}
	/**
	 * 侧边栏分类缓存
	 */
	function mc_sort()
	{
		$sort_cache = array();
		$query = $this->db->query("SELECT sid,sortname,taxis FROM ".$this->db_prefix."sort ORDER BY taxis ASC");
		while($row = $this->db->fetch_array($query))
		{
			$logNum = $this->db->num_rows($this->db->query("SELECT sortid FROM ".$this->db_prefix."blog WHERE sortid=".$row['sid']." and hide='n' and type='blog'"));
			$sort_cache[$row['sid']] = array(
			'lognum' => $logNum,
			'sortname' => htmlspecialchars($row['sortname']),
			'sid' => intval($row['sid']),
			'taxis' => intval($row['taxis'])
			);
		}
		$cacheData = serialize($sort_cache);
		$this->cacheWrite($cacheData,'sort');
	}
	/**
	 * 友站缓存
	 */
	function mc_link()
	{
		$link_cache = array();
		$query=$this->db->query("SELECT siteurl,sitename,description FROM ".$this->db_prefix."link ORDER BY taxis ASC");
		while($show_link=$this->db->fetch_array($query))
		{
			$link_cache[] = array(
			'link'=>htmlspecialchars($show_link['sitename']),
			'url'=>htmlspecialchars($show_link['siteurl']),
			'des'=>htmlspecialchars($show_link['description'])
			);
		}
		$cacheData = serialize($link_cache);
		$this->cacheWrite($cacheData,'links');
	}
	/**
	 * twitter缓存
	 */
	function mc_twitter()
	{
		$show_config=$this->db->fetch_array($this->db->query("SELECT option_value FROM ".$this->db_prefix."options where option_name='index_twnum'"));
		$index_twnum = $show_config['option_value']+1;
		$query = $this->db->query("SELECT * FROM ".$this->db_prefix."twitter ORDER BY id DESC LIMIT $index_twnum");
		$tw_cache = array();
		while($show_tw=$this->db->fetch_array($query))
		{
			$tw_cache[] = array(
			'content' => htmlspecialchars($show_tw['content']),
			'date' => $show_tw['date'],
			'id' => $show_tw['id']
			);
		}
		$cacheData = serialize($tw_cache);
		$this->cacheWrite($cacheData,'twitter');
	}

	/**
	 * 最新日志
	 */
	function mc_newlog()
	{
		$row = $this->db->fetch_array($this->db->query("SELECT option_value FROM ".$this->db_prefix."options where option_name='index_newlognum'"));
		$index_newlognum = $row['option_value'];
		$sql = "SELECT gid,title FROM ".$this->db_prefix."blog WHERE hide='n' and type='blog' ORDER BY date DESC LIMIT 0, $index_newlognum";
		$res = $this->db->query($sql);
		$logs = array();
		while($row = $this->db->fetch_array($res))
		{
			$row['gid'] = intval($row['gid']);
			$row['title'] = htmlspecialchars($row['title']);
			$logs[] = $row;
		}
		$cacheData = serialize($logs);
		$this->cacheWrite($cacheData,'newlogs');
	}

	/**
	 * 日志归档缓存
	 */
	function mc_record()
	{
		$query = $this->db->query("select date from ".$this->db_prefix."blog WHERE hide='n' and type='blog' ORDER BY date DESC");
		$record = 'xxxx_x';
		$p = 0;
		$lognum = 1;
		$dang_cache = array();
		while($show_record = $this->db->fetch_array($query))
		{
			$f_record=date('Y_n',$show_record['date']);
			if ($record!=$f_record){
				$h = $p-1;
				if($h!=-1)
				{
					$dang_cache[$h]['lognum'] = $lognum;
				}
				$dang_cache[$p] = array(
				'record'=>date("Y年n月",$show_record['date']),
				'url'=>BLOG_URL."?record=".date("Ym",$show_record['date'])
				);
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
		$this->cacheWrite($cacheData,'records');
	}
	/**
	 * 日志标签缓存
	 */
	function mc_logtags()
	{
		$query = $this->db->query("SELECT gid FROM ".$this->db_prefix."blog where type='blog'");
		$log_cache_tags = array();
		while($row = $this->db->fetch_array($query))
		{
			$gid = $row['gid'];
			$tags = array();
			$tquery = "SELECT tagname,tid FROM ".$this->db_prefix."tag WHERE gid LIKE '%,$gid,%' " ;
			$result = $this->db->query($tquery);
			while($trow = $this->db->fetch_array($result))
			{
				$trow['tagname'] = htmlspecialchars($trow['tagname']);
				$trow['tid'] = intval($trow['tid']);
				$tags[] = $trow;
			}
			$log_cache_tags[$gid] = $tags;
			unset($tags);
		}
		$cacheData = serialize($log_cache_tags);
		$this->cacheWrite($cacheData,'log_tags');
	}
	/**
	 * 日志分类缓存
	 */
	function mc_logsort()
	{
		$sql = "SELECT gid,sortid FROM ".$this->db_prefix."blog where type='blog'";
		$query = $this->db->query($sql);
		$log_cache_sort = array();
		while($row = $this->db->fetch_array($query))
		{
			if($row['sortid'] > 0)
			{
				$res = $this->db->query("SELECT sortname FROM ".$this->db_prefix."sort where sid=".$row['sortid']);
				$srow = $this->db->fetch_array($res);
				$sortName = htmlspecialchars($srow['sortname']);
			}else {
				$sortName = '';
			}
			$log_cache_sort[$row['gid']] = $sortName;
			unset($tag);
		}
		$cacheData = serialize($log_cache_sort);
		$this->cacheWrite($cacheData,'log_sort');
	}
	/**
	 * 日志\页面附件缓存
	 */
	function mc_logatts()
	{
		$sql = "SELECT gid FROM ".$this->db_prefix."blog";
		$query = $this->db->query($sql);
		$log_cache_atts = array();
		while($row = $this->db->fetch_array($query))
		{
			$gid = $row['gid'];
			$attachment = '';
			//attachment
			$attQuery = $this->db->query("SELECT * FROM ".$this->db_prefix."attachment WHERE blogid=$gid ");
			while($show_attach = $this->db->fetch_array($attQuery))
			{
				$att_path = $show_attach['filepath'];//eg: ../uploadfile/200710/b.jpg
				$atturl = substr($att_path,3);//eg: uploadfile/200710/b.jpg
				$postfix = strtolower(substr(strrchr($show_attach['filename'], "."),1));
				if(!in_array($postfix, array('jpg', 'jpeg', 'gif', 'png', 'bmp')))
				{
					$file_atturl = $atturl;
					$attachment .= "<br /><a href=\"$file_atturl\" target=\"_blank\">{$show_attach['filename']}</a>\t".changeFileSize($show_attach['filesize']);
				}
			}
			$log_cache_atts[$gid] = $attachment;
			unset($attachment);
		}
		$cacheData = serialize($log_cache_atts);
		$this->cacheWrite($cacheData,'log_atts');
	}

	/**
	 * 写入缓存
	 */
	function cacheWrite ($cacheDate,$cachefile)
	{
		$cachefile = EMLOG_ROOT.'/content/cache/'.$cachefile;
		@ $fp = fopen($cachefile, 'wb') OR emMsg('读取缓存失败。如果您使用的是Unix/Linux主机，请修改缓存目录 (content/cache) 下所有文件的权限为777。如果您使用的是Windows主机，请联系管理员，将该目录下所有文件设为everyone可写');
		@ $fw =	fwrite($fp,$cacheDate) OR emMsg('写入缓存失败，缓存目录 (content/cache) 不可写');
		fclose($fp);
	}

	/**
	 * 读取缓存文件
	 */
	function readCache($cachefile)
	{
		$cachefile = EMLOG_ROOT.'/content/cache/'.$cachefile;
		if(@$fp = fopen($cachefile, 'r'))
		{
			@$data = fread($fp,filesize($cachefile));
			fclose($fp);
		}
		return unserialize($data);
	}
}
?>