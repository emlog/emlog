<?php
/**
 * 发表评论
 *
 * @copyright (c) Emlog All Rights Reserved
 * $Id$
 */

class Comment_Controller {

    /**
     * 增加评论
     */
    function addComment($params) {
        $name = isset($_POST['comname']) ? addslashes(trim($_POST['comname'])) : '';
        $content = isset($_POST['comment']) ? addslashes(trim($_POST['comment'])) : '';
        $mail = isset($_POST['commail']) ? addslashes(trim($_POST['commail'])) : '';
        $url = isset($_POST['comurl']) ? addslashes(trim($_POST['comurl'])) : '';
        $imgcode = isset($_POST['imgcode']) ? strtoupper(trim($_POST['imgcode'])) : '';
        $blogId = isset($_POST['gid']) ? intval($_POST['gid']) : -1;

        if ($url && strncasecmp($url,'http://',7)) {
            $url = 'http://'.$url;
        }
        $Comment_Model = new Comment_Model();
        $Comment_Model->setCommentCookie($name,$mail,$url);
        if($Comment_Model->isLogCanComment($blogId) === false){
            emMsg('发表评论失败：该日志已关闭评论','javascript:history.back(-1);');
        }elseif ($Comment_Model->isCommentExist($blogId, $name, $content) === true){
            emMsg('发表评论失败：已存在相同内容评论','javascript:history.back(-1);');
        }elseif (preg_match("/['<>,#|;\/\$\\&\r\t()%@+?^]/",$name) || strlen($name) > 20 || strlen($name) == 0){
            emMsg('发表评论失败：姓名不符合规范','javascript:history.back(-1);');;
        } elseif ($mail != '' && !checkMail($mail)) {
            emMsg('发表评论失败：邮件地址不符合规范', 'javascript:history.back(-1);');
        } elseif (strlen($content) == '' || strlen($content) > 2000) {
            emMsg('发表评论失败：内容不符合规范','javascript:history.back(-1);');
        } elseif (Option::get('comment_code') == 'y' && session_start() && $imgcode != $_SESSION['code']) {
            emMsg('发表评论失败：验证码错误','javascript:history.back(-1);');
        } else {
            $Comment_Model->addComment($name, $content, $mail, $url, $imgcode, $blogId);
        }
    }
}
