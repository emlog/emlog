<?php
/* emlog 2.5.0 Emlog.Net */

class mkcache extends MySql{

	var $db_prefix;
	var $link;
	var $Archives;
	var $log_tags;
	var $log_atts;//附件
	var $tags;
	var $comment;
	
	function mkcache($host,$user,$pass,$db,$prefix)
	{
		$this->host = $host;
		$this->pass = $pass;
		$this->user = $user;
		$this->db = $db;
		$this->db_prefix = $prefix;
		$this->dbconnect($this->host, $this->user, $this->pass,$this->db);
	}
	
	//站点配置缓存
	function mc_config($cf) 
	{
		$show_config=$this->fetch_array($this->query("SELECT * FROM ".$this->db_prefix."config"));
			$exarea = addslashes($show_config['exarea']);
			$config ="\n\$config_cache = array('sitekey' =>\"".htmlspecialchars($show_config['site_key'])."\",'blogname' =>\"".htmlspecialchars(stripslashes($show_config['blogname']))."\",'bloginfo'=>\"".htmlspecialchars(stripslashes($show_config['bloginfo']))."\",'index_lognum' =>\"".$show_config['index_lognum']."\",'index_tagnum' =>\"".$show_config['index_tagnum']."\",'index_comment_num' =>\"".$show_config['index_comnum']."\",'iscomment'=>\"".$show_config['iscomment']."\",'comment_code'=>\"".$show_config['comment_code']."\",'login_code'=>\"".$show_config['login_code']."\",'comment_subnum'=>\"".$show_config['comment_subnum']."\",'nonce_templet'=>\"".$show_config['nonce_templet']."\",'blogurl'=>\"".htmlspecialchars($show_config['blogurl'])."\",'icp'=>\"".htmlspecialchars($show_config['icp'])."\",'timezone'=>\"".$show_config['timezone']."\",'exarea'=>\"".$exarea."\");";
	
		$cache = "<?php".$config."\n?>";
		$this->mc_print($cache,$cf); 
	}
	//个人资料
	function mc_blogger($cf)
	{
		$blogger = $this->fetch_one_array("select * from ".$this->db_prefix."user ");
		$photosrc = substr($blogger['photo'],3);
		$imgsize = chImage($blogger['photo'],ICON_MAX_W,ICON_MAX_H);
		$user="\n\$user_cache = array('photo' => \"<img src=\\\"".htmlspecialchars($photosrc)."\\\" width=\\\"".$imgsize['w']."\\\" height=\\\"".$imgsize['h']."\\\" alt=\\\"blogger\\\" />\",'name' =>\"".htmlspecialchars($blogger['nickname'])."\",'mail'	=>\"".htmlspecialchars($blogger['email'])."\",'des'=>\"".htmlspecialchars($blogger['description'])."\");";
	
		$cache = "<?php".$user."\n?>";
		$this->mc_print($cache,$cf);
	}
	//访问统计
	function mc_sta($cf)
	{
		$dh= $this->fetch_one_array("select * from ".$this->db_prefix."statistics");
		$lognum=$this->num_rows($this->query("SELECT gid FROM ".$this->db_prefix."blog WHERE hide='n' "));
		$comnum=$this->num_rows($this->query("SELECT cid FROM ".$this->db_prefix."comment WHERE hide='n' "));
		$tbnum=$this->num_rows($this->query("SELECT gid FROM ".$this->db_prefix."trackback "));
	
		$sta="\n\$sta_cache = array(
				'day_view_count' => \"".$dh['day_view_count']."\",
				'view_count' =>\"".$dh['view_count']."\",
				'lognum'=>\"".$lognum."\",
				'comnum'=>\"".$comnum."\",
				'tbnum'=>\"".$tbnum."\"
				);";
		$cache = "<?php".$sta."\n?>";
		$this->mc_print($cache,$cf);
	}
	//评论缓存
	function mc_comment($cf)
	{
		$show_config=$this->fetch_array($this->query("SELECT * FROM ".$this->db_prefix."config"));
		$index_comment_num = $show_config['index_comnum'];
		$comment_subnum = $show_config['comment_subnum'];
		$query=$this->query("SELECT cid,gid,comment,date,poster FROM ".$this->db_prefix."comment WHERE hide='n' ORDER BY cid DESC LIMIT 0, $index_comment_num ");
		$j = 0;
		while($show_com=$this->fetch_array($query)){
			$this->comment.= "\n\$com_cache[".$j."] = array('url'=>\"index.php?action=showlog&gid=".$show_com['gid']."#".$show_com['cid']."\",'name'=>\"".base64_encode(htmlspecialchars($show_com['poster']))."\",'content'=>\"".base64_encode(htmlClean2(subString($show_com['comment'],0,$comment_subnum)))."\");";
			$j++;
		}
		$cache = "<?php".$this->comment."\n?>";
		$this->mc_print($cache,$cf);
	}
	//侧边栏标签缓存
	function mc_tags($cf)
	{
		$show_config=$this->fetch_array($this->query("SELECT index_tagnum FROM ".$this->db_prefix."config"));
		$index_tagnum = $show_config['index_tagnum'];
		$query=$this->query("SELECT tagname,usenum FROM ".$this->db_prefix."tag ORDER BY usenum DESC LIMIT 0, $index_tagnum ");
			$m = 0;
			while($show_tag = $this->fetch_array($query)){
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
	//blogroll缓存
	function mc_link($cf)
	{
		$query=$this->query("SELECT siteurl,sitename,description FROM ".$this->db_prefix."link ORDER BY taxis ASC");
		$k = 0;
		while($show_link=$this->fetch_array($query)){
			$this->link.= "\n\$link_cache[".$k."] = array('link'=>\"".htmlspecialchars($show_link['sitename'])."\",'url'=>\"".htmlspecialchars($show_link['siteurl'])."\",'des'=>\"".htmlspecialchars($show_link['description'])."\");";
			$k++;
			}
		$cache = "<?php".$this->link."\n?>";
		$this->mc_print($cache,$cf);
	}
	//日志归档缓存
	function mc_record($cf)
	{
		$query=$this->query("select date from ".$this->db_prefix."blog WHERE hide='n' ORDER BY date DESC");
		$record='xxxx_x';
		$p = 0;
		$lognum = 1;
		while($show_record=$this->fetch_array($query)){
			$f_record=date('Y_n',$show_record['date']);
			if ($record!=$f_record){
				$h = $p-1;
				if($h!=-1)
				{
					$this->Archives.= "\n\$dang_cache[".$h."]['lognum']=\"".$lognum."\";";
				}
				$this->Archives.= "\n\$dang_cache[".$p."] = array('record'=>\"".date("Y年n月",$show_record['date'])."\",'url'=>\"index.php?record=".date("Ym",$show_record['date'])."\",'lognum'=>\"\");";
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
		$sql="SELECT gid FROM ".$this->db_prefix."blog ORDER BY top DESC ,date DESC";
		$query1=$this->query($sql);
		while($show_log=$this->fetch_array($query1)) {
			$tag = '';
			$gid = $show_log['gid'];
			//tag
			$tquery = "SELECT tagname FROM ".$this->db_prefix."tag WHERE gid LIKE '%,$gid,%' " ;
			$result = $this->query($tquery);
			$tagnum = $this->num_rows($result);
			if($tagnum>0){
				while($show_tag=$this->fetch_array($result)){
					$tag .= "	<a href=\\\"?action=taglog&tag=".urlencode($show_tag['tagname'])."\\\">".htmlspecialchars($show_tag['tagname']).'</a>'; 
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
		$sql="SELECT gid,attcache FROM ".$this->db_prefix."blog ORDER BY top DESC ,date DESC";
		$query1=$this->query($sql);
		while($rows=$this->fetch_array($query1)){
			$gid = $rows['gid'];
			$att_img = '';
			$attachment = '';
			//attachment
			$attquery = $this->query("SELECT * FROM ".$this->db_prefix."attachment WHERE blogid=$gid ");
			while($show_attach=$this->fetch_array($attquery)){
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
					$imgsize = chImage($att_path,IMG_ATT_MAX_W,IMG_ATT_MAX_H);
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
		@ $fp = fopen($cachefile, 'wb') OR
		$this->msg('打开文件失败');
		@	$fw =	fwrite($fp,$content) OR
		$this->msg('写入缓存失败！可能是缓存文件(cache.php)权限不够');
		fclose($fp);
	}
}
?>