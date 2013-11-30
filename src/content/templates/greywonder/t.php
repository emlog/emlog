<?php 
/*
* 碎语部分
*/
if(!defined('EMLOG_ROOT')) {exit('error!');} 
?>
<div class="header single">
	<div class="container">
		<h2><?php echo Option::get('twnavi');?></h2>
	</div>
</div>
<div class="main">
	<div class="content">
		<div class="post">
			<div class="tw">
    			<ul>
    				<?php 
	    				foreach($tws as $val):
    					$author = $user_cache[$val['author']]['name'];
    					$avatar = empty($user_cache[$val['author']]['avatar']) ? 
                		BLOG_URL . 'admin/views/images/avatar.jpg' : 
	                	BLOG_URL . $user_cache[$val['author']]['avatar'];
    					$tid = (int)$val['id'];
    				?> 
    				<li>
	    				<div class="avatar"><img src="<?php echo $avatar; ?>" width="32px" height="32px" /></div>
    					<div class="date"><?php echo $val['date'];?></div>
    					<div class="author"><?php echo $author; ?></div>
    					<div class="twitter"><?php echo $val['t'];?></div>
    					<div class="reply"><a href="javascript:loadr('<?php echo DYNAMIC_BLOGURL; ?>?action=getr&tid=<?php echo $tid;?>','<?php echo $tid;?>');">回复(<span id="rn_<?php echo $tid;?>"><?php echo $val['replynum'];?></span>)</a></div>
   						<ul id="r_<?php echo $tid;?>" class="r"></ul>
    					<div class="huifu" id="rp_<?php echo $tid;?>">   
							<textarea id="rtext_<?php echo $tid; ?>"></textarea>
							<div class="tinfo" style="display:<?php if(ROLE == 'admin' || ROLE == 'writer'){echo 'none';}?>">
        						昵称：<input type="text" id="rname_<?php echo $tid; ?>" value="" />
        						<span style="display:<?php if($reply_code == 'n'){echo 'none';}?>">验证码：<input type="text" id="rcode_<?php echo $tid; ?>" value="" /><?php echo $rcode; ?></span>        
        					</div>
        					<input class="button" type="button" onclick="reply('<?php echo DYNAMIC_BLOGURL; ?>?action=reply',<?php echo $tid;?>);alert1(1)" value="回复" />
        					<div class="msg"><span id="rmsg_<?php echo $tid; ?>"></span></div>
    					</div>
    				</li>
    				<?php endforeach;?>
    			</ul>
				<div class="pagenavi"><?php echo $pageurl;?></div>
			</div>
		</div>
		<?php include View::getView('side'); ?>
	</div>
</div>
<?php include View::getView('footer');?>