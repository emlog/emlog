<?php if(!defined('EMLOG_ROOT')) {exit('error!');} ?>
    <div class="clear"></div>
    <div id="StartBaloon">
  <img src="<?php echo CERTEMPLATE_URL; ?>/images/ardn_16.png" alt="\/" />点这里 ...
</div>

<div id="StartMenu" onclick="SMClkd();">
  <div class="SMTop"><img src="<?php echo CERTEMPLATE_URL; ?>/images/1pxtrans.gif" alt=" " /></div>
  <div class="SMMiddle">
    <div class="SMsub">
      <ul>
        <li onclick="SMRaise(1);">
          <a href="javascript: void(0)">
          <img src="<?php echo CERTEMPLATE_URL; ?>/images/categories_32.png" alt=" " />
          <b>分类</b><br />
          查看所有分类...
          </a>
        </li>
        <li onclick="SMRaise(2);">
          <a href="javascript: void(0)">
          <img src="<?php echo CERTEMPLATE_URL; ?>/images/tags_32.png" alt=" " />
          <b>标签</b><br />
          查看所有标签...
          </a>
        </li>
        <li>
          <a href="<?php echo BLOG_URL; ?>rss.php">
          <img src="<?php echo CERTEMPLATE_URL; ?>/images/feed_32.png" alt=" " />
          <b>RSS订阅</b><br />
          订阅这个博客...
          </a>
        </li>
      </ul>
      <div class="SMsgbhr"><img src="<?php echo CERTEMPLATE_URL; ?>/images/smhrlt.png" alt=" " /></div>
      <div class="SMsgb" onclick="SMRaise(3);"><a href="javascript:void(0);"><img src="<?php echo CERTEMPLATE_URL; ?>/images/smfwd.png" alt=" " />最近的50篇日志</a></div>
      <div id="SMSearchForm"><?php include getViews('sm_searchform'); ?></div>
    </div>
    
    <div class="SMsub SMsh" id="SMSub1">
      <div class="SMSubDiv" style="padding:0;margin:4px 0 0 4px;">
        <div class="SMCats"><ul>
        <?php 
        global $sort_cache;
        foreach($sort_cache as $value): ?>
	<li class="cat-item cat-item-<?php echo $value['sid']; ?>">
	<a href="./?sort=<?php echo $value['sid']; ?>"title="View all posts filed under <?php echo $value['sortname']; ?>"><?php echo $value['sortname']; ?>(<?php echo $value['lognum'] ?>)</a>
	</li>
	<?php endforeach; ?>
        </ul></div>
        <div class="SMsgbhr"><img src="<?php echo CERTEMPLATE_URL; ?>/images/smhrlt.png" alt=" " /></div>
        <div class="SMsgb" onclick="SMLower(1);"><a href="javascript:void(0);"><img src="<?php echo CERTEMPLATE_URL; ?>/images/smback.png" alt=" " />返回</a></div>
      </div>
    </div>
    
    <div class="SMsub SMsh" id="SMSub2">
      <div class="SMSubDiv" style="padding:0;margin:4px 0 0 4px;">
          <div class="SMTags SMCats">
           <?php foreach($tag_cache as $value): ?>
		<a href="./?tag=<?php echo $value['tagurl']; ?>" style="font-size:<?php echo $value['fontsize']; ?>pt;"title="<?php echo $value['usenum']; ?> topic<?php if($value['usenum'] > 1) echo "s"; ?>"><?php echo $value['tagname']; ?></a>
	<?php endforeach; ?>
          </div>
        <div class="SMsgbhr"><img src="<?php echo CERTEMPLATE_URL; ?>/images/smhrlt.png" alt=" " /></div>
        <div class="SMsgb" onclick="SMLower(2);"><a href="javascript:void(0);"><img src="<?php echo CERTEMPLATE_URL; ?>/images/smback.png" alt=" " />返回</a></div>
      </div>
    </div>
    
    <div class="SMsub SMsh" id="SMSub3">
      <div class="SMSubDiv SMap">
          <ul><?php latest_posts();?></ul>
        <div class="SMsgbhr"><img src="<?php echo CERTEMPLATE_URL; ?>/images/smhrlt.png" alt=" " /></div>
        <div class="SMsgb" onclick="SMLower(3);"><a href="javascript:void(0);"><img src="<?php echo CERTEMPLATE_URL; ?>/images/smback.png" alt=" " />返回</a></div>
      </div>
    </div>
        
    <div class="SMRight">
    <div class="SMAvatarB"><img src="<?php echo CERTEMPLATE_URL; ?>/images/1pxtrans.gif" alt=" " /></div>
    
    
    <div class="SMAvatar">
    <?php
    	global $user_cache;
    	if(isset($user_cache[1]['photo']['src']))
		{
			$imgsrc = $user_cache[1]['photo']['src'];
			$imgtn = chImageSize($imgsrc,46,46);
			$width = $imgtn['w'];
			$height = $imgtn['h'];
		}else{
			$imgsrc = CERTEMPLATE_URL."/images/avatar.bmp";
			$width = 46;
			$height = 46;
		}
	?>
	<img src='<?php echo $imgsrc; ?>' class='avatar avatar-48 photo' height='<?php echo $height;?>' width='<?php echo $width;?>' />
    </div>

    <?php if (ISLOGIN){ ?>
      <div class="SMRtDiv">
      <img class="SMSep" src="<?php echo CERTEMPLATE_URL; ?>/images/sm-sep.png" alt=" " />
      <a class="SMRtHov" href="./admin/write_log.php" title="写日志">写日志</a>
      <a class="SMRtHov" href="./admin/page.php?action=new" title="新建页面">新建页面</a>
      <img class="SMSep" src="<?php echo CERTEMPLATE_URL; ?>/images/sm-sep.png" alt=" " />
      </div>
    <?php } else {echo " ";} ?>

    <div class="clear"></div>
    
    <?php
      if (ISLOGIN){
        if (ROLE == 'admin')
          {
            $adminbtn='<a class="SMRtHov" href="./admin/" title="管理中心"><span>管理中心</span></a>';
          }
        else
          {
            $adminbtn='<a class="SMRtHov" href="./admin/blogger.php" title="编辑个人资料"><span>编辑个人资料</span></a>';
          } 
      }else{
      	  $adminbtn = '';
      }
    ?>
      
      <div class="SMAdmin">
        <?php echo $adminbtn;?>
      </div>
      
      <div class="SMRtPoCom" onclick="SMFlot(5);">更换主题...</div>
      
      <div class="liload">
      
      <?php
      //determine which state the logout/login/Admin buttons should be in
      if (ISLOGIN) {
        $logoutbtn = '<a title="退出" href="./admin/?action=logout"><span>退出</span></a>';
        $logoutcls = 'logout';
        
        $loginbtn = '<span>[登录]</span>';
        $logincls = 'loggedin';
        $uinfo = '用户信息';
      }
      else {
        $logoutbtn = '<span>[退出]</span>';
        $logoutcls ='loggedout';
        
        $loginbtn = '<a title="登录" href="./admin"><span>登录</span></a>';
        $logincls = 'login';
        $uinfo = '博客信息';
      }?>

        <div class="LogAdmin">
          <ul>
            <li class="<?php echo $logoutcls; ?>"><?php echo $logoutbtn;?></li>
            <li class="<?php echo $logincls; ?>"><?php echo $loginbtn;?></li>
            <li title="<?php echo $uinfo ?>" class="opts" onclick="SMFlot(4);">&nbsp;</li>
          </ul>
        </div>

      </div>
    </div>

    <div class="SMRtPoComFl SMsh" onclick="FlyOutWasClicked=1;" id="SMSub4">
      <ul class="SMRtFlOpt SMRtFlOptInd">
        <?php
        if (ISLOGIN){
        	global $user_cache;
          ?><li><b>用户级别</b> &raquo; <?php echo ROLE; ?></li>
          <li><b>日志数量</b> &raquo; <?php echo $user_cache[UID]['lognum']; ?></li>
          <li><b>评论数量</b> &raquo; <?php echo $user_cache[UID]['commentnum']; ?></li><?php
        }
        else {
        	global $user_cache,$sta_cache;
          ?><li><b>用户数量</b> &raquo; <?php echo count($user_cache); ?></li>
          <li><b>日志数量</b> &raquo; <?php echo $sta_cache['lognum'];; ?></li>
          <li><b>评论数量</b> &raquo; <?php echo $sta_cache['comnum']; ?></li><?php
        }
        ?>

      </ul>
    </div>
<?php
     insert_stylemenu();
?>
  </div>
  <div class="SMBottom"><img src="<?php echo CERTEMPLATE_URL; ?>/images/1pxtrans.gif" alt=" " /></div>
</div>

<iframe src="javascript:false" 
  style="position:fixed; bottom: 32px; left: -200px; visibility:hidden; display: none; width: 174px; height: 128px; z-index: 5;"
  id="hovif" frameborder="0" scrolling="no">
</iframe>

<iframe src="javascript:false" 
  style="position:fixed; bottom: 32px; left: -200px; visibility:hidden; display: none; width: 174px; height: 128px; z-index: 5;"
  id="moif" frameborder="0" scrolling="no">
</iframe>

<iframe src="javascript:false" 
  style="position:fixed; bottom: 0px; left: -50px; visibility:hidden; display: none; width: 5000px; height: 34px; z-index: 5;"
  id="tbif" frameborder="0" scrolling="no">
</iframe>

<iframe src="javascript:false" 
  style="background:transparent;position:fixed; bottom: 30px; left: -50px; visibility:hidden; display: none; width: 445px; height: 233px; z-index: 5;"
  id="smif" frameborder="0" scrolling="no">
</iframe>

<iframe src="javascript:false" 
  style="position:fixed; bottom: 261px; left: 294px; visibility:hidden; display: none; width: 56px; height: 26px; z-index: 5;"
  id="avif" frameborder="0" scrolling="no">
</iframe>

<iframe src="javascript:false" 
  style="position:fixed; bottom: 0px; left: -200px; visibility:hidden; display: none; width: 5px; height: 5px; z-index: 5;"
  id="flif" frameborder="0" scrolling="no">
</iframe>
    
<!-- Task Bar -->
    <div id="menuspan" class="mnusp">
      <div class="menu">
        <div class="nvtl"><ul><li onclick="OClkd();"><a><span>- O -</span></a></li></ul></div>
        
        <div class="menu-sep"><img src="<?php echo CERTEMPLATE_URL; ?>/images/1pxtrans.gif" alt=" " /></div>
        <div class="nav"><ul>
        <li<?php if (empty($_GET)){?> class="current_page_item_tb" <?php } ?>><a href="./">首页</a></li>
        <?php foreach ($navibar as $key => $val):
			if ($val['hide'] == 'y'){continue;}
			if (empty($val['url'])){$val['url'] = './?post='.$key;}
			?>
			<li <?php if($key == $logid){?> class="current_page_item_tb" <?php } ?>><a href="<?php echo $val['url']; ?>" target="<?php echo $val['is_blank']; ?>"><?php echo $val['title']; ?></a></li>
		<?php endforeach;?>
        <?php cats_insert();?>
        <?php doAction('navbar', '<li>', '</li>'); ?>
        </ul> 
        </div>
        <div class="clock">
          <span id="clockhr">&nbsp;</span>:<span id="clockmin">&nbsp;</span>&nbsp;<span id="clockpart">&nbsp;</span>
        </div>
      </div>
    </div>
	<?php insert_kids(); ?>
    <div class="clear"></div>
    <div class="footer"><img src="<?php echo CERTEMPLATE_URL; ?>/images/1pxtrans.gif" alt=" " /></div>
    <?php doAction('index_footer'); ?>
    <script type="text/javascript">
      document.getElementById('menuspan').style.zIndex = "10";
      document.getElementById('StartMenu').style.zIndex = "10";
    </script>
  </body>
</html>
