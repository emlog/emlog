<?php
/**
 * Sidebar components, modules page
 */
if (!defined('EMLOG_ROOT')) {
    exit('error!');
}
?>
<?php
//widget：link
function widget_link($title)
{
    global $CACHE;
    $link_cache = $CACHE->readCache('link');
    //if (!blog_tool_ishome()) return;#Only show the friend link on the homepage and remove the double slash comment
    ?>
    <div class="widget shadow-theme">
        <div class="widget-title m">
            <h3><?php echo $title; ?></h3>
        </div>
        <ul class="widget-list no-margin-bottom">
            <?php foreach ($link_cache as $value): ?>
                <li><a href="<?php echo $value['url']; ?>" title="<?php echo $value['des']; ?>" target="_blank"><?php echo $value['link']; ?></a></li>
            <?php endforeach; ?>
        </ul>
    </div>
<?php } ?>
<?php
//widget：blogger
function widget_blogger($title)
{
    global $CACHE;
    $user_cache = $CACHE->readCache('user');
    $name = $user_cache[1]['mail'] != '' ? "<a href=\"mailto:" . $user_cache[1]['mail'] . "\">" . $user_cache[1]['name'] . "</a>" : $user_cache[1]['name']; ?>
    <div class="widget shadow-theme">
        <div class="widget-title m">
            <h3><?php echo $title; ?></h3>
        </div>
        <ul class="list-unstyled">
            <div id="bloggerinfoimg">
                <?php if (!empty($user_cache[1]['photo']['src'])): ?>
                    <img src="<?php echo BLOG_URL . $user_cache[1]['photo']['src']; ?>" width="<?php echo $user_cache[1]['photo']['width']; ?>"
                         height="<?php echo $user_cache[1]['photo']['height']; ?>" alt="blogger"/>
                <?php endif; ?>
            </div>
            <p><b><?php echo $name; ?></b>
                <?php echo $user_cache[1]['des']; ?></p>
        </ul>
    </div>
<?php } ?>
<?php
//widget：日历
function widget_calendar($title)
{ ?>
    <div class="widget shadow-theme">
        <div class="widget-title m">
            <h3><?php echo $title; ?></h3>
        </div>
        <ul class="list-unstyled">
            <div id="calendar"></div>
            <script>sendinfo('<?php echo Calendar::url(); ?>', 'calendar');</script>
        </ul>
    </div>
<?php } ?>
<?php
//widget:Tags
function widget_tag($title)
{
    global $CACHE;
    $tag_cache = $CACHE->readCache('tags'); ?>
    <div class="widget shadow-theme">
        <div class="widget-title m">
            <h3><?php echo $title; ?></h3>
        </div>
        <ul class="list-unstyled">
            <?php foreach ($tag_cache as $value): ?>
                <span style="font-size:<?php echo $value['fontsize']; ?>pt; line-height:30px;">
<!--vot-->	<a href="<?php echo Url::tag($value['tagurl']); ?>" title="<?php echo $value['usenum']; ?> <?=lang('_posts')?>"><?php echo $value['tagname']; ?></a></span>
            <?php endforeach; ?>
        </ul>
    </div>
<?php } ?>
<?php
//widget:Sort
function widget_sort($title)
{
    global $CACHE;
    $sort_cache = $CACHE->readCache('sort'); ?>
    <div class="widget shadow-theme">
        <div class="widget-title m">
            <h3><?php echo $title; ?></h3>
        </div>
        <ul class="list-unstyled">
            <?php
            foreach ($sort_cache as $value):
                if ($value['pid'] != 0) continue;
                ?>
                <li>
                    <a href="<?php echo Url::sort($value['sid']); ?>"><?php echo $value['sortname']; ?>(<?php echo $value['lognum'] ?>)</a>
                    <?php if (!empty($value['children'])): ?>
                        <ul>
                            <?php
                            $children = $value['children'];
                            foreach ($children as $key):
                                $value = $sort_cache[$key];
                                ?>
                                <li>
                                    <a href="<?php echo Url::sort($value['sid']); ?>"><?php echo $value['sortname']; ?>(<?php echo $value['lognum'] ?>)</a>
                                </li>
                            <?php endforeach; ?>
                        </ul>
                    <?php endif; ?>
                </li>
            <?php endforeach; ?>
        </ul>
    </div>
<?php } ?>
<?php
//widget:Latest Comments
function widget_newcomm($title)
{
    global $CACHE;
    $com_cache = $CACHE->readCache('comment');
    ?>
    <div class="widget shadow-theme">
        <div class="widget-title m">
            <h3><?php echo $title; ?></h3>
        </div>
        <ul class="list-unstyled">
            <?php
            foreach ($com_cache as $value):
                $url = Url::comment($value['gid'], $value['page'], $value['cid']);
                ?>
                <li id="comment"><?php echo $value['name']; ?>
                    <br/><a href="<?php echo $url; ?>"><?php echo $value['content']; ?></a></li>
            <?php endforeach; ?>
        </ul>
    </div>
<?php } ?>
<?php
//widget:Latest Posts
function widget_newlog($title)
{
    global $CACHE;
    $newLogs_cache = $CACHE->readCache('newlog');
    ?>
    <div class="widget shadow-theme">
        <div class="widget-title m">
            <h3><?php echo $title; ?></h3>
        </div>
        <ul class="list-unstyled">
            <?php foreach ($newLogs_cache as $value): ?>
                <li><a href="<?php echo Url::log($value['gid']); ?>"><?php echo $value['title']; ?></a></li>
            <?php endforeach; ?>
        </ul>
    </div>
<?php } ?>
<?php
//widget:Popular Posts
function widget_hotlog($title)
{
    $index_hotlognum = Option::get('index_hotlognum');
    $Log_Model = new Log_Model();
    $hotLogs = $Log_Model->getHotLog($index_hotlognum); ?>
    <div class="widget shadow-theme">
        <div class="widget-title m">
            <h3><?php echo $title; ?></h3>
        </div>
        <ul class="list-unstyled">
            <?php foreach ($hotLogs as $value): ?>
                <li><a href="<?php echo Url::log($value['gid']); ?>"><?php echo $value['title']; ?></a></li>
            <?php endforeach; ?>
        </ul>
    </div>
<?php } ?>
<?php
//widget:Random Post
function widget_search($title)
{ ?>
    <div class="widget shadow-theme">
        <div class="widget-title m">
            <h3><?php echo $title; ?></h3>
        </div>
        <ul class="list-unstyled">
            <form name="keyform" method="get" action="<?php echo BLOG_URL; ?>index.php">
                <input name="keyword" class="search" type="text"/>
            </form>
        </ul>
    </div>
<?php } ?>
<?php
//widget:Archive
function widget_archive($title)
{
    global $CACHE;
    $record_cache = $CACHE->readCache('record');
    ?>
    <div class="widget shadow-theme">
        <div class="widget-title m">
            <h3><?php echo $title; ?></h3>
        </div>
        <ul class="list-unstyled">
            <?php foreach ($record_cache as $value): ?>
                <li><a href="<?php echo Url::record($value['date']); ?>"><?php echo $value['record']; ?>(<?php echo $value['lognum']; ?>)</a></li>
            <?php endforeach; ?>
        </ul>
    </div>
<?php } ?>
<?php
//widget:Custom Component
function widget_custom_text($title, $content)
{ ?>
    <div class="widget shadow-theme">
        <div class="widget-title m">
            <h3><?php echo $title; ?></h3>
        </div>
        <ul class="list-unstyled">
            <?php echo $content; ?>
        </ul>
    </div>
<?php } ?>
<?php
//blog:Navigation
function blog_navi()
{
    global $CACHE;
    $navi_cache = $CACHE->readCache('navi');
    ?>
    <div class="collapse navbar-collapse" id="navbarResponsive">
        <ul class="navbar-nav ml-auto">
            <?php
            foreach ($navi_cache as $value):
                if ($value['pid'] != 0) {
                    continue;
                }
                if ($value['url'] == ROLE_ADMIN && (ROLE == ROLE_ADMIN || ROLE == ROLE_WRITER)):
                    ?>
                    <li class="nav-item"><a href="<?php echo BLOG_URL; ?>admin/" class="nav-link"><?=lang('site_management')?></a></li>
                    <li class="nav-item"><a href="<?php echo BLOG_URL; ?>admin/?action=logout" class="nav-link"><?=lang('logout')?></a></li>
                    <?php
                    continue;
                endif;
                $newtab = $value['newtab'] == 'y' ? 'target="_blank"' : '';
                $value['url'] = $value['isdefault'] == 'y' ? BLOG_URL . $value['url'] : trim($value['url'], '/');
                $current_tab = BLOG_URL . trim(Dispatcher::setPath(), '/') == $value['url'] ? 'active' : '';
                ?>
                <?php if (!empty($value['children']) || !empty($value['childnavi'])) : ?>
                <li class="nav-item">
                    <?php if (!empty($value['children'])): ?>
                        <a href="<?php echo $value['url']; ?>" <?php echo $newtab; ?>><?php echo $value['naviname']; ?> <b class="caret"></b></a>
                        <ul class="dropdown-menu">
                            <?php foreach ($value['children'] as $row) {
                                echo '<li class="nav-item"><a class="nav-link" href="' . Url::sort($row['sid']) . '">' . $row['sortname'] . '</a></li>';
                            } ?>
                        </ul>
                    <?php endif; ?>
                    <?php if (!empty($value['childnavi'])) : ?>
                        <a href="<?php echo $value['url']; ?>" <?php echo $newtab; ?>><?php echo $value['naviname']; ?> <b class="caret"></b></a>
                        <ul class="dropdown-menu">
                            <?php foreach ($value['childnavi'] as $row) {
                                $newtab = $row['newtab'] == 'y' ? 'target="_blank"' : '';
                                echo '<li class="nav-item"><a class="nav-link" href="' . $row['url'] . "\" $newtab >" . $row['naviname'] . '</a></li>';
                            } ?>
                        </ul>
                    <?php endif; ?>
                </li>
            <?php else: ?>
                <li class="nav-item"><a class="nav-link" href="<?php echo $value['url']; ?>" <?php echo $newtab; ?>><?php echo $value['naviname']; ?></a></li>
            <?php endif; ?>
            <?php endforeach; ?>
        </ul>
    </div>
<?php } ?>
<?php
//blog:Top
function topflg($top, $sortop = 'n', $sortid = null)
{
    if (blog_tool_ishome()) {
/*vot*/ echo $top == 'y' ? "<img src=\"" . TEMPLATE_URL . "/images/top.png\" title=\"".lang('top_posts')."\"> " : '';
    } elseif ($sortid) {
/*vot*/ echo $sortop == 'y' ? "<img src=\"" . TEMPLATE_URL . "/images/sortop.png\" title=\"".lang('cat_top_posts')."\"> " : '';
    }
}

?>
<?php
//blog:Editor
function editflg($logid, $author)
{
/*vot*/	$editflg = ROLE == ROLE_ADMIN || $author == UID ? '<a href="' . BLOG_URL . 'admin/write_log.php?action=edit&gid=' . $logid . '" target="_blank">' . lang('edit') . '</a>' : '';
    echo $editflg;
}

?>
<?php
//blog:Category
function blog_sort($blogid)
{
    global $CACHE;
    $log_cache_sort = $CACHE->readCache('logsort');
    ?>
    <?php if (!empty($log_cache_sort[$blogid])): ?>
    <a href="<?php echo Url::sort($log_cache_sort[$blogid]['id']); ?>"><?php echo $log_cache_sort[$blogid]['name']; ?></a>
<?php endif; ?>
<?php } ?>
<?php
//blog:Post Tags
function blog_tag($blogid)
{
    global $CACHE;
    $tag_model = new Tag_Model();

    $log_cache_tags = $CACHE->readCache('logtags');
    if (!empty($log_cache_tags[$blogid])) {
/*vot*/ $tag = lang('tags').':';
        foreach ($log_cache_tags[$blogid] as $value) {
            $tag .= "	<a href=\"" . Url::tag($value['tagurl']) . "\">" . $value['tagname'] . '</a>';
        }
        echo $tag;
    } else {
        $tag_ids = $tag_model->getTagIdsFromBlogId($blogid);
        $tag_names = $tag_model->getNamesFromIds($tag_ids);

        if (!empty($tag_names)) {
/*vot*/     $tag = lang('tags').':';

            foreach ($tag_names as $key => $value) {
                $tag .= "	<a href=\"" . Url::tag(rawurlencode($value)) . "\">" . htmlspecialchars($value) . '</a>';
            }

            echo $tag;
        }
    }
}

?>
<?php
//blog:Post author
function blog_author($uid)
{
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
//blog:Neighbor Post
function neighbor_log($neighborLog)
{
    extract($neighborLog); ?>
    <?php if ($prevLog): ?>
    &laquo; <a href="<?php echo Url::log($prevLog['gid']) ?>"><?php echo $prevLog['title']; ?></a>
<?php endif; ?>
    <?php if ($nextLog && $prevLog): ?>
    |
<?php endif; ?>
    <?php if ($nextLog): ?>
    <a href="<?php echo Url::log($nextLog['gid']) ?>"><?php echo $nextLog['title']; ?></a>&raquo;
<?php endif; ?>
<?php } ?>
<?php
//blog:Comment List
function blog_comments($comments)
{
    extract($comments);
    if ($commentStacks): ?>
        <a name="comments"></a>
<!--vot-->    <p class="comment-header"><b><?=lang('comments')?>:</b></p>
    <?php endif; ?>
    <?php
    $isGravatar = Option::get('isgravatar');
    foreach ($commentStacks as $cid):
        $comment = $comments[$cid];
        $comment['poster'] = $comment['url'] ? '<a href="' . $comment['url'] . '" target="_blank">' . $comment['poster'] . '</a>' : $comment['poster'];
        ?>
        <div class="comment" id="comment-<?php echo $comment['cid']; ?>">
            <a name="<?php echo $comment['cid']; ?>"></a>
            <?php if ($isGravatar == 'y'): ?>
                <div class="avatar"><img src="<?php echo getGravatar($comment['mail']); ?>"/></div><?php endif; ?>
            <div class="comment-info">
                <b><?php echo $comment['poster']; ?> </b><br/><span class="comment-time"><?php echo $comment['date']; ?></span>
                <div class="comment-content"><?php echo $comment['content']; ?></div>
<!--vot-->      <div class="comment-reply"><a href="#comment-<?php echo $comment['cid']; ?>" onclick="commentReply(<?php echo $comment['cid']; ?>,this)"><?=lang('reply')?></a></div>
            </div>
            <?php blog_comments_children($comments, $comment['children']); ?>
        </div>
    <?php endforeach; ?>
    <div id="pagenavi">
        <?php echo $commentPageUrl; ?>
    </div>
<?php } ?>
<?php
//blog:sub-comment list
function blog_comments_children($comments, $children)
{
    $isGravatar = Option::get('isgravatar');
    foreach ($children as $child):
        $comment = $comments[$child];
        $comment['poster'] = $comment['url'] ? '<a href="' . $comment['url'] . '" target="_blank">' . $comment['poster'] . '</a>' : $comment['poster'];
        ?>
        <div class="comment comment-children" id="comment-<?php echo $comment['cid']; ?>">
            <a name="<?php echo $comment['cid']; ?>"></a>
            <?php if ($isGravatar == 'y'): ?>
                <div class="avatar"><img src="<?php echo getGravatar($comment['mail']); ?>"/></div><?php endif; ?>
            <div class="comment-info">
                <b><?php echo $comment['poster']; ?> </b><br/><span class="comment-time"><?php echo $comment['date']; ?></span>
                <div class="comment-content"><?php echo $comment['content']; ?></div>
                <?php if ($comment['level'] < 4): ?>
<!--vot-->          <div class="comment-reply"><a href="#comment-<?php echo $comment['cid']; ?>" onclick="commentReply(<?php echo $comment['cid']; ?>,this)"><?=lang('reply')?></a>
                    </div><?php endif; ?>
            </div>
            <?php blog_comments_children($comments, $comment['children']); ?>
        </div>
    <?php endforeach; ?>
<?php } ?>
<?php
//blog:Post a comment form
function blog_comments_post($logid, $ckname, $ckmail, $ckurl, $verifyCode, $allow_remark)
{
    if ($allow_remark == 'y'): ?>
        <div id="comment-place">
            <div class="comment-post" id="comment-post">
<!--vot-->      <div class="cancel-reply" id="cancel-reply" style="display:none"><a href="javascript:void(0);" onclick="cancelReply()"><?=lang('cancel_reply')?></a></div>
<!--vot-->      <p class="comment-header"><b><?=lang('comment_leave')?>:</b> <a name="respond"></a></p>
                <form method="post" name="commentform" action="<?php echo BLOG_URL; ?>index.php?action=addcom" id="commentform">
                    <input type="hidden" name="gid" value="<?php echo $logid; ?>"/>
                    <?php if (ROLE == ROLE_VISITOR): ?>
                        <p>
                            <input type="text" name="comname" maxlength="49" value="<?php echo $ckname; ?>" size="22" tabindex="1">
<!--vot-->                  <label for="author"><small><?=lang('nickname')?></small></label>
                        </p>
                        <p>
                            <input type="text" name="commail" maxlength="128" value="<?php echo $ckmail; ?>" size="22" tabindex="2">
<!--vot-->                  <label for="email"><small><?=lang('email_optional')?></small></label>
                        </p>
                        <p>
                            <input type="text" name="comurl" maxlength="128" value="<?php echo $ckurl; ?>" size="22" tabindex="3">
<!--vot-->                  <label for="url"><small><?=lang('homepage_optional')?></small></label>
                        </p>
                    <?php endif; ?>
                    <p><textarea name="comment" id="comment" rows="10" tabindex="4"></textarea></p>
<!--vot-->          <p><?php echo $verifyCode; ?> <input type="submit" id="comment_submit" value="<?=lang('comment_leave')?>" tabindex="6"></p>
                    <input type="hidden" name="pid" id="comment-pid" value="0" size="22" tabindex="1"/>
                </form>
            </div>
        </div>
    <?php endif; ?>
<?php } ?>
<?php
//blog-tool: Determine whether it is the Home
function blog_tool_ishome()
{
    if (BLOG_URL . trim(Dispatcher::setPath(), '/') == BLOG_URL) {
        return true;
    } else {
        return FALSE;
    }
}

?>
