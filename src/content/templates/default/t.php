<?php 
/*
* 碎语部分
*/
if(!defined('EMLOG_ROOT')) {exit('error!');} 
?>
<div id="tw">
    <ul>
    <?php 
    foreach($tws as $val):
    $author = $user_cache[$val['author']]['name'];
    $avatar = empty($user_cache[$val['author']]['avatar']) ? '../admin/views/' . ADMIN_TPL . '/images/avatar.jpg' : '../' . $user_cache[$val['author']]['avatar'];
    ?> 
    <li class="li">
    <div class="main_img"><img src="<?php echo $avatar; ?>" width="32px" height="32px" /></div>
    <p class="post1"><?php echo $author; ?><br /><?php echo $val['t'];?></p>
    <div class="clear"></div>
    <div class="bttome">
        <p class="post" id="<?php echo $val['id'];?>"><a href="javascript:void(0);">回复(<span><?php echo $val['replynum'];?></span>)</a></p>
        <p class="time"><?php echo $val['date'];?> <a href="javascript: em_confirm(<?php echo $val['id'];?>, 'tw');">删除</a> </p>
    </div>
	<div class="clear"></div>
   	<div id="r_<?php echo $val['id'];?>" class="r"></div>
    <div class="huifu" id="rp_<?php echo $val['id'];?>">   
	<textarea name="reply"></textarea>
    <div><input class="button_p" type="button" onclick="doreply(<?php echo $val['id'];?>);" value="回复" /> <span style="color:#FF0000"></span></div>
    </div>
    </li>
    <?php endforeach;?>
	 <li id="pagenavi"><?php echo $pageurl;?>(有<?php echo $twnum; ?>条碎语)</li>
    </ul>
</div>
<?php
 include getViews('side');
 include getViews('footer');
?>