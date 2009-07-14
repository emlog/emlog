<?php
/*
Template Name:bluedark-10
Description:高科技的,明快的,深邃的 ……
Author:Askgraphics.com
Author Url:http://www.skinpress.com
Sidebar Amount:2
*/
if(!defined('EMLOG_ROOT')) {exit('error!');}
require_once (getViews('module'));
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<meta name="keywords" content="<?php echo $site_key; ?>" />
<meta name="generator" content="emlog" />
<title><?php echo $blogtitle; ?></title>
<link rel="alternate" type="application/rss+xml" title="RSS"  href="<?php echo BLOG_URL; ?>rss.php">
<link href="<?php echo CERTEMPLATE_URL; ?>/main.css" rel="stylesheet" type="text/css" />
<script src="<?php echo BLOG_URL; ?>lib/js/common_tpl.js" type="text/javascript"></script>
<?php doAction('index_head'); ?>
</head>
<body> 
<center> 
<div id="page"> 
 
<div id="header"> 
	<div id="header_top"> 
		<div id="header_title"> 
			<a href="./"><?php echo $blogname; ?></a> | <span><?php echo $bloginfo; ?></span> 
		</div> 
		
			<div id="menu"> 
				<div id="menu_pad"> 
					<table cellpadding="0" cellspacing="0" align="left" width="99%"> 
						<tr> 
							<td> 
								<table cellpadding="0" cellspacing="0" align="left"> 
									<td class="menu"> 
										<a href="./">首页</a>
									</td> 
									<td class="m_sep">&nbsp;</td> 
								<?php foreach ($navibar as $key => $val):
			if ($val['hide'] == 'y'){continue;}
			if (empty($val['url'])){$val['url'] = './?post='.$key;}
			?>
            	<td class="menu"> 
								<a href="<?php echo $val['url']; ?>" target="<?php echo $val['is_blank']; ?>"><?php echo $val['title']; ?></a>
							</td> 
							<td class="m_sep">&nbsp;</td> 	
			<?php endforeach;?>
            
          <?php doAction('navbar', '<td class="menu">', '</td><td class="m_sep">&nbsp;</td>'); ?>
						
                        	<?php if(ROLE == 'admin' || ROLE == 'writer'): ?>
                            
                            <td class="menu"> 
								<a href="./admin/write_log.php">写日志</a>
							</td> 
							<td class="m_sep">&nbsp;</td>
                            <td class="menu"> 
								<a href="./admin/">管理中心</a>
							</td> 
							<td class="m_sep">&nbsp;</td> 
                            <td class="menu"> 
								<a href="./admin/?action=logout">退出</a>
							</td> 
							<td class="m_sep">&nbsp;</td> 
			<?php else: ?>
             <td class="menu"> 
								<a href="./admin/">登录</a>
							</td> 
							<td class="m_sep">&nbsp;</td>
			<?php endif; ?>          
								</table> 
							</td> 
							<td align="right"> 
								<div id="right_search_box"> 
								<form method="get" id="searchform" name="keyform" style="display:inline;" action="./"> 
								<table> 
									<tr> 
										<td>Serach:</td> 
										<td><input name="keyword"  type="text" class="s" value="" name="s" id="s" /></td> 
										<td><input type="image" id="logserch_logserch" class="sub" onclick="return keyw()"  src="<?php echo CERTEMPLATE_URL; ?>/images/go.png" onclick="return keyw()"/></td> 
									</tr> 
								</table> 
								</form> 
							</div> 

                            
                            
							</td> 
						</tr> 
					</table> 
				</div> 
			</div> 
	</div> 
	<div id="header_end"> 
		<div id="header_text_pad"> 
			<div id="header_end_title"> 
				你可以修改这段文字在header.php
			</div> 
			<div id="header_end_text"> 
			可以写下这个blog的简短介绍：）
			</div> 
		</div> 
	</div> 
</div> 
