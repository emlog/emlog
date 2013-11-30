<?php 
/*
* 碎语部分
*/
if(!defined('EMLOG_ROOT')) {exit('error!');} 
?>
<div class="article">
	<div class="post single" id="tw">
	<h2>碎语</h2>
    <?php if(ROLE == 'admin' || ROLE == 'writer'): ?>
    <div class="top"><a href="<?php echo BLOG_URL . 'admin/twitter.php' ?>">发布碎语</a></div>
    <?php endif; ?>
    <?php 
    foreach($tws as $val):
    $author = $user_cache[$val['author']]['name'];
    $avatar = empty($user_cache[$val['author']]['avatar']) ? 
                BLOG_URL . 'admin/views/' . ADMIN_TPL . '/images/avatar.jpg' : 
                BLOG_URL . $user_cache[$val['author']]['avatar'];
    $tid = (int)$val['id'];
    ?>
	<div class="avatar"><img src="<?php echo $avatar; ?>" width="32px" height="32px" /></div>
    <div class="meta"><?php echo $author; ?><br /><?php echo $val['date'];?></div>
    <div class="reply"><a href="javascript:loadr('<?php echo DYNAMIC_BLOGURL; ?>?action=getr&tid=<?php echo $tid;?>','<?php echo $tid;?>');">回复(<span id="rn_<?php echo $tid;?>"><?php echo $val['replynum'];?></span>)</a></div>
	<div class="clear"></div>
	<div class="entry"><?php echo $val['t']; ?></div>
   	<ul id="r_<?php echo $tid;?>" class="r"></ul>
    <div class="huifu" id="rp_<?php echo $tid;?>">   
		<textarea id="rtext_<?php echo $tid; ?>"></textarea>
    	<div class="tbutton">
	        <div class="tinfo" style="display:<?php if(ROLE == 'admin' || ROLE == 'writer'){echo 'none';}?>">
        	昵称：<input type="text" id="rname_<?php echo $tid; ?>" value="" />
        	<span style="display:<?php if($reply_code == 'n'){echo 'none';}?>">验证码：<input type="text" id="rcode_<?php echo $tid; ?>" value="" /><?php echo $rcode; ?></span>        
	        </div>
	        <input class="button_p" type="button" onclick="reply('<?php echo DYNAMIC_BLOGURL; ?>?action=reply',<?php echo $tid;?>);" value="回复" /> 
        	<div class="msg"><span id="rmsg_<?php echo $tid; ?>" style="color:#FF0000"></span></div>
    	</div>
    </div>
    <div class="wrapper"></div>
    <?php endforeach;?>
    <div class="wpagenavi">
		<?php echo $pageurl;?> (有<?php echo $twnum; ?>条碎语)
    </div>
	</div>
</div>
<!-- Article end -->
<!-- Sidebar begin -->
	<?php  include View::getView('side'); ?>
<!-- Sidebar end -->
<?php include View::getView('footer'); ?>