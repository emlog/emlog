<?php
/**
 * Sidebar components, modules page
 */
if (!defined('EMLOG_ROOT')) {
	exit('error!');
}
?>
<?php
/**
 * widget:link
 */
function widget_link($title) {
	global $CACHE;
	$link_cache = $CACHE->readCache('link');
	//if (!blog_tool_ishome()) return;#Only show the friend link on the homepage and remove the double slash comment
	?>
    <div class="widget shadow-theme">
        <div class="widget-title">
            <h3><?= $title ?></h3>
        </div>
        <ul class="widget-list no-margin-bottom unstyle-li">
			<?php foreach ($link_cache as $value): ?>
                <li><a href="<?= $value['url'] ?>" target="_blank"><?= $value['link'] ?></a></li>
			<?php endforeach ?>
        </ul>
    </div>
<?php } ?>
<?php
/**
 * widget:blogger
 */
function widget_blogger($title) {
	global $CACHE;
	$user_cache = $CACHE->readCache('user');
	$name = $user_cache[1]['mail'] != '' ? "<a href=\"mailto:" . $user_cache[1]['mail'] . "\">" . $user_cache[1]['name'] . "</a>" : $user_cache[1]['name'] ?>
    <div class="widget shadow-theme">
        <div class="widget-title">
            <h3><?= $title ?></h3>
        </div>
        <div class="unstyle-li bloggerinfo"> 
        <?php if (!empty($user_cache[1]['photo']['src'])): ?>
            <div>
                <img class='bloggerinfo-img' src="<?= BLOG_URL . $user_cache[1]['photo']['src'] ?>" alt="blogger"/>
            </div>
        <?php endif ?>
            <div class='bloginfo-name'><b><?= $name ?></b></div>
            <div class='bloginfo-descript'><?= $user_cache[1]['des'] ?></div>
        </div>
    </div>
<?php } ?>
<?php
/**
 * widget:calendar
 */
function widget_calendar($title) { ?>
    <div class="widget shadow-theme">
        <div class="widget-title m">
            <h3><?= $title ?></h3>
        </div>
        <div class="unstyle-li">
            <div id="calendar"></div>
            <script>sendinfo('<?= Calendar::url() ?>', 'calendar');</script>
        </div>
    </div>
<?php } ?>
<?php
/**
 * widget:Tags
 */
function widget_tag($title) {
	global $CACHE;
	$tag_cache = $CACHE->readCache('tags') ?>
    <div class="widget shadow-theme">
        <div class="widget-title m">
            <h3><?= $title ?></h3>
        </div>
        <div class="unstyle-li tag-container">
			<?php foreach ($tag_cache as $value): ?>
                <span style="font-size:<?= $value['fontsize'] ?>pt; line-height:30px;">
<!--vot-->	<a href="<?= Url::tag($value['tagurl']) ?>" title="<?= $value['usenum'] + 2 ?> <?=lang('_posts')?>" class='tags_side' ><?= $value['tagname'] ?></a></span>
			<?php endforeach ?>
        </div>
    </div>
<?php } ?>
<?php
/**
 * widget:Sort
 */
function widget_sort($title) {
	global $CACHE;
	$sort_cache = $CACHE->readCache('sort') ?>
    <div class="widget shadow-theme">
        <div class="widget-title m">
            <h3><?= $title ?></h3>
        </div>
        <ul class="unstyle-li log-classify-f">
			<?php
			foreach ($sort_cache as $value):
				if ($value['pid'] != 0) continue;
				?>
                <li>
                    <a href="<?= Url::sort($value['sid']) ?>"><?= $value['sortname'] ?>&nbsp;&nbsp;<?= (($value['lognum']) > 0) ? '('.($value['lognum']).')' : '' ?></a>
					<?php if (!empty($value['children'])): ?>
                        <ul class="log-classify-c">
							<?php
							$children = $value['children'];
							foreach ($children as $key):
								$value = $sort_cache[$key];
								?>
                                <li>
                                    <a href="<?= Url::sort($value['sid']) ?>">--&nbsp;&nbsp;<?= $value['sortname'] ?>
                                        &nbsp;&nbsp;(<?= $value['lognum'] ?>)</a>
                                </li>
							<?php endforeach ?>
                        </ul>
					<?php endif ?>
                </li>
			<?php endforeach ?>
        </ul>
    </div>
<?php } ?>
<?php
/**
 * widget:Latest Comments
 */
function widget_newcomm($title) {
	global $CACHE;
	$com_cache  = $CACHE->readCache('comment');
    $isGravatar = Option::get('isgravatar');
	?>
    <div class="widget shadow-theme">
        <div class="widget-title">
            <h3><?= $title ?></h3>
        </div>
        <hr>
        <ul class="unstyle-li">
			<?php
			foreach ($com_cache as $value):
				$url = Url::comment($value['gid'], $value['page'], $value['cid']);
				?>
                <li class="comment-info">
                <?php if ($isGravatar == 'y'): ?>
                    <img class='comment-info_img' src="<?= getGravatar($value['mail']) ?>" alt="commentator" />
                <?php endif ?>
                    <span class='comm-lates-name'><?= $value['name'] ?></span>
                    <span class='logcom-latest-time'><?= smartDate($value['date']) ?></span><br/>
                    <a href="<?= $url ?>" style="color: #989898;"><?= $value['content'] ?></a>
                    <hr>
                </li>
			<?php endforeach ?>
        </ul>
    </div>
<?php } ?>
<?php
/**
 * widget:Latest Posts
 */
function widget_newlog($title) {
	global $CACHE;
	$newLogs_cache = $CACHE->readCache('newlog');
	?>
    <div class="widget shadow-theme">
        <div class="widget-title m">
            <h3><?= $title ?></h3>
        </div>
        <ul class="unstyle-li">
			<?php foreach ($newLogs_cache as $value): ?>
                <li class="blog-lates"><a href="<?= Url::log($value['gid']) ?>"><?= $value['title'] ?></a></li>
			<?php endforeach ?>
        </ul>
    </div>
<?php } ?>
<?php
/**
 * widget:Popular Posts
 */
function widget_hotlog($title) {
	$index_hotlognum = Option::get('index_hotlognum');
	$Log_Model = new Log_Model();
	$hotLogs = $Log_Model->getHotLog($index_hotlognum) ?>
    <div class="widget shadow-theme">
        <div class="widget-title m">
            <h3><?= $title ?></h3>
        </div>
        <ul class="unstyle-li">
			<?php foreach ($hotLogs as $value): ?>
                <li class="blog-hot"><a href="<?= Url::log($value['gid']) ?>"><?= $value['title'] ?></a></li>
			<?php endforeach ?>
        </ul>
    </div>
<?php } ?>
<?php
/**
 * widget:Random Post
 */
function widget_search($title) { ?>
    <div class="widget shadow-theme">
        <div class="widget-title">
            <h3><?= $title ?></h3>
        </div>
        <div class="unstyle-li" style="text-align: center;">
            <form name="keyform" method="get" action="<?= BLOG_URL ?>index.php">
                <input name="keyword" class="search form-control" autocomplete="off" type="text"/>
<!--vot-->	<input type="submit" value="<?=lang('search')?>">
            </form>
        </div>
    </div>
<?php } ?>
<?php
/**
 * widget:Archive
 */
function widget_archive($title) {
	$bar_id = "36";
	global $CACHE;
	$record_cache = $CACHE->readCache('record');
	?>
    <div class="widget shadow-theme">
        <div class="widget-title m">
            <h3><?= $title ?></h3>
        </div>
        <ul class="unstyle-li">
			<?php foreach ($record_cache as $value): ?>
<?php
/*vot*/	//2008年12月, 2008-12
/*vot*/	$sep = mb_substr($value['record'],4,1);
/*vot*/	$da = explode($sep,$value['record']);
/*vot*/	$value['record'] = lang('month_' . intval($da[1])) . ' ' . $da[0];
?>
		<li><a href="<?= Url::record($value['date']) ?>"><?= $value['record'] ?> (<?= $value['lognum'] ?>)</a></li>
			<?php endforeach ?>
        </ul>
    </div>
<?php } ?>
<?php
/**
 * widget:Custom widget
 */
function widget_custom_text($title, $content) { ?>
    <div class="widget shadow-theme">
        <div class="widget-title m">
            <h3><?= $title ?></h3>
        </div>
        <ul class="unstyle-li">
			<?= $content ?>
        </ul>
    </div>
<?php } ?>
<?php
/**
 * blog:Navigation
 */
function blog_navi() {
	global $CACHE;
	$navi_cache = $CACHE->readCache('navi');
	?>
    <div class="blog-header-nav" id="navbarResponsive">
        <ul class="nav-list">
			<?php
			foreach ($navi_cache as $value):
				if ($value['pid'] != 0) {
					continue;
				}
				if ($value['url'] == 'admin' && (!User::isVistor())):
					?>
<!--vot-->          <li class="list-item list-menu"><a href="<?= BLOG_URL ?>admin/" class="nav-link"><?=lang('site_management')?></a></li>
<!--vot-->          <li class="list-item list-menu"><a href="<?= BLOG_URL ?>admin/account.php?action=logout" class="nav-link"><?=lang('logout')?></a></li>
					<?php
					continue;
				endif;
				$newtab = $value['newtab'] == 'y' ? 'target="_blank"' : '';
				$value['url'] = $value['isdefault'] == 'y' ? BLOG_URL . $value['url'] : trim($value['url'], '/');
				$current_tab = BLOG_URL . trim(Dispatcher::setPath(), '/') == $value['url'] ? 'active' : '';
				?>
				<?php if (!empty($value['children']) || !empty($value['childnavi'])) : ?>
                <li class="list-item list-menu">
					<?php if (!empty($value['children'])): ?>
                        <a class="nav-link has-down" id="nav_link" <?= $newtab ?>><?= $value['naviname'] ?> <b class="caret"></b></a>
                        <ul class="dropdown-menus">
							<?php foreach ($value['children'] as $row) {
								echo '<li class="list-item list-menu"><a class="nav-link" href="' . Url::sort($row['sid']) . '">' . $row['sortname'] . '</a></li>';
							} ?>
                        </ul>
					<?php endif ?>
					<?php if (!empty($value['childnavi'])) : ?>
                        <a class='nav-link has-down' id="nav_link" <?= $newtab ?> ><?= $value['naviname'] ?><b class="caret"></b></a>
                        <ul class="dropdown-menus">
							<?php foreach ($value['childnavi'] as $row) {
								$newtab = $row['newtab'] == 'y' ? 'target="_blank"' : '';
								echo '<li class="list-item list-menu"><a class="nav-link" href="' . $row['url'] . "\" $newtab >" . $row['naviname'] . '</a></li>';
							} ?>
                        </ul>
					<?php endif ?>
                </li>
			<?php else: ?>
                <li class="list-item list-menu"><a class="nav-link" href="<?= $value['url'] ?>" <?= $newtab ?>><?= $value['naviname'] ?></a></li>
			<?php endif ?>
			<?php endforeach ?>
        </ul>
    </div>
<?php } ?>
<?php
/**
 * blog:Top
 */
function topflg($top, $sortop = 'n', $sortid = null) {
/*vot*/	$ishome_flg = '<span title="' . lang('home_top') . '" class="log-topflg" >' . lang('top') . '</span>';
/*vot*/	$issort_flg = '<span title="' . lang('category_top') . '" class="log-topflg" >' . lang('category_top') . '</span>';
	if (blog_tool_ishome()) {
		echo $top == 'y' ? $ishome_flg : '';
	} elseif ($sortid) {
		echo $sortop == 'y' ? $issort_flg : '';
	}
}

?>
<?php
/**
 * blog:Editor
 */
function editflg($logid, $author) {
/*vot*/	$editflg = User::isAdmin() || $author == UID ? '<a href="' . BLOG_URL . 'admin/article.php?action=edit&gid=' . $logid . '" target="_blank">&nbsp;&nbsp;&nbsp;' . lang('edit') . '</a>' : '';
	echo $editflg;
}

?>
<?php
/**
 * blog:Category
 */
function blog_sort($blogid) {
	global $CACHE;
	$log_cache_sort = $CACHE->readCache('logsort');
	?>
	<?php if (!empty($log_cache_sort[$blogid])) { ?>
<!--vot--><a href="<?= Url::sort($log_cache_sort[$blogid]['id']) ?>" title="<?=lang('category')?>: <?= $log_cache_sort[$blogid]['name'] ?>"><?= $log_cache_sort[$blogid]['name'] ?></a>
	<?php } else { ?>
<!--vot--><a href="#" title="<?=lang('uncategorized')?>"><?=lang('no')?></a>
	<?php }
} ?>
<?php
/**
 * Article Listing Page: Categories
 */
function bloglist_sort($blogid) {
	global $CACHE;
	$log_cache_sort = $CACHE->readCache('logsort');
	?>
	<?php if (!empty($log_cache_sort[$blogid])) { ?>
        <span class="loglist-sort" >
<!--vot-->  <a href="<?= Url::sort($log_cache_sort[$blogid]['id']) ?>" title="<?=lang('category')?>: <?= $log_cache_sort[$blogid]['name'] ?>"><?= $log_cache_sort[$blogid]['name'] ?></a>
        </span>
    <?php }
} ?>
<?php
/**
 * blog:Post Tags
 */
function blog_tag($blogid) {
	global $CACHE;
	$tag_model = new Tag_Model();

	$log_cache_tags = $CACHE->readCache('logtags');
	if (!empty($log_cache_tags[$blogid])) {
		$tag = '';
/*vot*/         echo lang('tags') . ': ';
		foreach ($log_cache_tags[$blogid] as $value) {
/*vot*/			$tag .= "	<a href=\"" . Url::tag($value['tagurl']) . "\" class='tags'  title='{lang('tag')}' >" . $value['tagname'] . '</a>';
		}
		echo $tag;
	} else {
		$tag_ids = $tag_model->getTagIdsFromBlogId($blogid);
		$tag_names = $tag_model->getNamesFromIds($tag_ids);
		if (!empty($tag_names)) {
/*vot*/			$tag = lang('tags').':';
			foreach ($tag_names as $key => $value) {
/*vot*/				$tag .= "	<a href=\"" . Url::tag(rawurlencode($value)) . "\" class='tags' title='{lang('tag')}' >" . htmlspecialchars($value) . '</a>';
			}
			echo $tag;
		}
	}
}
?>
<?php
/**
 * blog:Post author
 */
function blog_author($uid) {
	global $CACHE;
	$user_cache = $CACHE->readCache('user');
	$author = $user_cache[$uid]['name'];
	$mail = $user_cache[$uid]['mail'];
	$des = $user_cache[$uid]['des'];
	$title = !empty($mail) || !empty($des) ? "title=\"$des $mail\"" : '';
	echo '<a href="' . Url::author($uid) . "\" $title>$author</a>";
}
?>
<?php
/**
 * blog:Neighbor Post
 */
function neighbor_log($neighborLog) {
	extract($neighborLog) ?>
	<?php if ($prevLog): ?>
<!--vot--><span class="prev-log"><a href="<?= Url::log($prevLog['gid']) ?>" title="<?= $prevLog['title'] ?>"><?=lang('prev')?></a></span>
	<?php endif ?>
	<?php if ($nextLog): ?>
<!--vot--><span class="next-log"><a href="<?= Url::log($nextLog['gid']) ?>" title="<?= $nextLog['title'] ?>"><?=lang('next')?></a></span>
	<?php endif ?>
<?php } ?>
<?php
/**
 * blog:comment list
 */
function blog_comments($comments) {
	extract($comments);
	if ($commentStacks): ?>
<!--vot-->    <div class="comment-header"><b><?=lang('comments')?>:</b></div>
	<?php endif ?>
	<?php
	$isGravatar = Option::get('isgravatar');

	foreach ($commentStacks as $cid):
		$comment = $comments[$cid];
		$comment['poster'] = $comment['url'] ? '<a href="' . $comment['url'] . '" target="_blank">' . $comment['poster'] . '</a>' : $comment['poster'];
		?>
        <div class="comment" id="comment-<?= $comment['cid'] ?>">
			<?php if ($isGravatar == 'y'): ?>
                <div class="avatar"><img src="<?= getGravatar($comment['mail']) ?>"/></div>
            <div class="comment-infos">
                <div class="arrow"></div>
                <b><?= $comment['poster'] ?> </b><span class="comment-time"><?= $comment['date'] ?></span>
                <div class="comment-content"><?= $comment['content'] ?></div>
<!--vot-->      <div class="comment-reply"><a class="com-reply"><?=lang('reply')?></a></div>
            </div>
            <?php else: ?>
            <div class="comment-infos-unGravatar">
                <b><?= $comment['poster'] ?> </b><span class="comment-time"><?= $comment['date'] ?></span>
                <div class="comment-content"><?= $comment['content'] ?></div>
<!--vot-->      <div class="comment-reply"><a class="com-reply"><?=lang('reply')?></a></div>
            </div>
            <?php endif ?>
			<?php blog_comments_children($comments, $comment['children']) ?>
        </div>
	<?php endforeach ?>
    <div id="pagenavi">
		<?= $commentPageUrl ?>
    </div>
<?php } ?>
<?php
/**
 * blog:sub-comment list
 */
function blog_comments_children($comments, $children) {
	$isGravatar = Option::get('isgravatar');
	foreach ($children as $child):
		$comment = $comments[$child];
		$comment['poster'] = $comment['url'] ? '<a href="' . $comment['url'] . '" target="_blank">' . $comment['poster'] . '</a>' : $comment['poster'];
		?>
        <div class="comment comment-children" id="comment-<?= $comment['cid'] ?>">
			<?php if ($isGravatar == 'y'): ?>
            <div class="avatar"><img src="<?= getGravatar($comment['mail']) ?>" alt="commentator" /></div>
            <div class="comment-infos">
                <div class="arrow"></div>
                <b><?= $comment['poster'] ?> </b><span class="comment-time"><?= $comment['date'] ?></span>
                <div class="comment-content"><?= $comment['content'] ?></div>
				<?php if ($comment['level'] < 4): ?>
<!--vot-->      <div class="comment-reply"><a class="com-reply"><?=lang('reply')?></a>
                </div><?php endif ?>
            </div>
            <?php else: ?>
            <div class="comment-infos-unGravatar">
                <b><?= $comment['poster'] ?> </b><span class="comment-time"><?= $comment['date'] ?></span>
                <div class="comment-content"><?= $comment['content'] ?></div>
                <?php if ($comment['level'] < 4): ?>
<!--vot-->      <div class="comment-reply"><a class="com-reply"><?=lang('reply')?></a>
                </div><?php endif ?>
            </div>
            <?php endif ?>
			<?php blog_comments_children($comments, $comment['children']) ?>
        </div>
	<?php endforeach ?>
<?php } ?>
<?php
/**
 * blog:Post a comment form
 */
function blog_comments_post($logid, $ckname, $ckmail, $ckurl, $verifyCode, $allow_remark) {
	$isNeedChinese = Option::get('comment_needchinese');
	if ($allow_remark == 'y'): ?>
        <div id="comment-place">
            <div class="comment-post" id="comment-post">
<!--vot-->      <div class="cancel-reply" id="cancel-reply" style="display:none"><a><?=lang('cancel_reply')?></a></div>
                <form class="commentform" method="post" name="commentform" action="<?= BLOG_URL ?>index.php?action=addcom" id="commentform"
                      is-chinese="<?= $isNeedChinese ?>">
                    <input type="hidden" name="gid" value="<?= $logid ?>"/>
                    <textarea class="form-control log_comment" name="comment" id="comment" rows="10" tabindex="4" required></textarea>
					<?php if (User::isVistor()): ?>
                        <div class="comment-info" id="comment-info">
<!--vot-->                  <input class="form-control com_control comment-name" id="info_n" autocomplete="off" type="text" name="comname" maxlength="49"
                                   value="<?= $ckname ?>" size="22"
                                   tabindex="1" placeholder="<?=lang('nickname')?>*" required/>
<!--vot-->                  <input class="form-control com_control comment-mail" id="info_m" autocomplete="off" type="text" name="commail" maxlength="128"
                                   value="<?= $ckmail ?>" size="22"
                                   tabindex="2" placeholder="<?=lang('homepage')?>" />
<!--vot-->                  <input class="form-control com_control comment-url" id="info_u" autocomplete="off" type="text" name="comurl" maxlength="128"
                                   value="<?= $ckurl ?>" size="22"
                                   tabindex="3" placeholder="<?=lang('homepage')?>"/>
                        </div>
					<?php endif ?>

                    <span class="com_submit_p">
<!--vot-->              <input class="btn"<?php if ($verifyCode != "") { ?> type="button" data-toggle="modal" data-target="#myModal"<?php } else { ?> type="submit"<?php } ?>
                               id="comment_submit" value="<?=lang('comment_leave')?>" tabindex="6"/>
                    </span>
					<?php if ($verifyCode != "") { ?>
			<!-- Verification window -->
                        <div class="modal" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content" style="display: table-cell;">
<!--vot-->                          <div class="modal-header" style="border-bottom: 0px;">
					<?=lang('enter_captcha')?>
                                    </div>
									<?= $verifyCode ?>
                                    <div class="modal-footer" style="border-top: 0px;">
<!--vot-->				<button type="button" class="btn" id="close-modal" data-dismiss="modal"><?=lang('close')?></button>
<!--vot-->				<button type="submit" class="btn" id="comment_submit2"><?=lang('submit')?></button>
                                    </div>
                                </div>
                            </div>
                            <div class="lock-screen"></div>
                        </div>
			<!-- Verification window (end)  -->
					<?php } ?>
                    <input type="hidden" name="pid" id="comment-pid" value="0" tabindex="1"/>
                </form>
            </div>
        </div>
	<?php endif ?>
<?php } ?>
<?php
/**
 * blog-tool: Determine whether it is the Home
 */
function blog_tool_ishome() {
	if (BLOG_URL . trim(Dispatcher::setPath(), '/') == BLOG_URL) {
		return true;
	} else {
		return FALSE;
	}
}
?>
