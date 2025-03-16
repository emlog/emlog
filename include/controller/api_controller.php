<?php

/**
 * Rest API controller
 *
 * @package EMLOG
 * @link https://www.emlog.net
 */

class Api_Controller
{

    /**
     * @var Log_Model
     */
    public $Log_Model;
    /**
     * @var Twitter_Model
     */
    public $Twitter_Model;
    /**
     * @var Tag_Model
     */
    public $Tag_Model;
    /**
     * @var User_Model
     */
    public $User_Model;
    /**
     * @var Media_Model
     */
    public $Media_Model;
    /**
     * @var Comment_Model
     */
    public $Comment_Model;
    /**
     * @var Like_Model
     */
    public $Like_Model;

    public $Cache;
    public $authApiKey;
    public $authReqSign;
    public $authReqTime;
    public $curUserInfo;
    public $curUid;

    function starter($params)
    {
        $_func = isset($_GET['rest-api']) ? addslashes($_GET['rest-api']) : '';
        if (empty($_func)) {
            Output::error('error router');
        }

        $this->checkApiOpen($_func);

        if (method_exists($this, $_func)) {
            $this->Log_Model = new Log_Model();
            $this->Tag_Model = new Tag_Model();
            $this->Twitter_Model = new Twitter_Model();
            $this->User_Model = new User_Model();
            $this->Media_Model = new Media_Model();
            $this->Comment_Model = new Comment_Model();
            $this->Like_Model = new Like_Model();
            $this->Cache = Cache::getInstance();
            $this->$_func();
        } else {
            Output::error('api method is not exist');
        }
    }

    private function article_post()
    {
        $title = Input::postStrVar('title');
        $content = Input::postStrVar('content');
        $excerpt = Input::postStrVar('excerpt');
        $author_uid = Input::postIntVar('author_uid', 1);
        $post_date = Input::postStrVar('post_date');
        $sort_id = Input::postIntVar('sort_id', -1);
        $tags = strip_tags(Input::postStrVar('tags'));
        $cover = Input::postStrVar('cover');
        $draft = Input::postStrVar('draft', 'n');
        $alias = Input::postStrVar('alias');
        $top = Input::postStrVar('top', 'n');
        $sortop = Input::postStrVar('sortop', 'n');
        $allow_remark = Input::postStrVar('allow_remark', 'n');
        $password = Input::postStrVar('password');
        $link = Input::postStrVar('link');
        $template = Input::postStrVar('template');
        $field_keys = Input::postStrArray('field_keys');
        $field_values = Input::postStrArray('field_values');

        $this->auth();

        if (empty($title) || empty($content)) {
            Output::error('parameter error');
        }

        $sta_cache = $this->Cache->readCache('sta');
        if (!Register::isRegLocal() && $sta_cache['lognum'] > 50) {
            Output::error(html_entity_decode("&#x672A;&#x6CE8;&#x518C;&#x7684;&#x7248;&#x672C;", ENT_COMPAT, 'UTF-8'));
        }

        if ($this->curUid) {
            $author_uid = $this->curUid;
        }

        $checked = 'y';
        if (isset($_COOKIE[AUTH_COOKIE_NAME])) {
            if (Article::hasReachedDailyPostLimit()) {
                Output::error('Exceeded daily posting limit');
            }
            //管理员发文不审核,注册用户受开关控制
            $checked = Option::get('ischkarticle') == 'y' && !User::haveEditPermission() ? 'n' : 'y';
        }

        $logData = [
            'title'        => $title,
            'content'      => $content,
            'excerpt'      => $excerpt,
            'author'       => $author_uid,
            'sortid'       => $sort_id,
            'cover'        => $cover,
            'date'         => strtotime($post_date ?: date('Y-m-d H:i:s')),
            'hide'         => $draft === 'y' ? 'y' : 'n',
            'checked'      => $checked,
            'alias'        => $alias,
            'top '         => $top,
            'sortop '      => $sortop,
            'allow_remark' => $allow_remark,
            'password'     => $password,
            'link'         => $link,
            'template'     => $template,
        ];

        $article_id = $this->Log_Model->addlog($logData);
        $this->Tag_Model->addTag($tags, $article_id);
        $this->Cache->updateCache();

        Field::updateField($article_id, $field_keys, $field_values);

        doAction('save_log', $article_id, '', $logData);

        output::ok(['article_id' => $article_id,]);
    }

    private function article_update()
    {
        $id = Input::postIntVar('id');
        $title = Input::postStrVar('title');
        $content = Input::postStrVar('content');
        $excerpt = Input::postStrVar('excerpt');
        $post_date = isset($_POST['post_date']) ? trim($_POST['post_date']) : '';
        $sort_id = Input::postIntVar('sort_id', -1);
        $cover = Input::postStrVar('cover');
        $tags = isset($_POST['tags']) ? strip_tags(addslashes(trim($_POST['tags']))) : '';
        $author_uid = isset($_POST['author_uid']) ? (int)trim($_POST['author_uid']) : 1;
        $draft = Input::postStrVar('draft', 'n');
        $field_keys = Input::postStrArray('field_keys');
        $field_values = Input::postStrArray('field_values');

        $this->auth();

        if (empty($id) || empty($title)) {
            Output::error('parameter error');
        }

        if ($this->curUid) {
            $author_uid = $this->curUid;
        }

        $logData = [
            'title'   => $title,
            'content' => $content,
            'excerpt' => $excerpt,
            'sortid'  => $sort_id,
            'cover'   => $cover,
            'author'  => $author_uid,
            'date'    => strtotime($post_date ?: date('Y-m-d H:i:s')),
            'hide'    => $draft === 'y' ? 'y' : 'n',
        ];

        $this->Log_Model->updateLog($logData, $id, $author_uid);
        $this->Tag_Model->updateTag($tags, $id);
        $this->Cache->updateCache();

        Field::updateField($id, $field_keys, $field_values);

        doAction('save_log', $id, '', $logData);

        output::ok();
    }

    private function article_list()
    {
        $page = isset($_GET['page']) ? (int)trim($_GET['page']) : 1;
        $count = isset($_GET['count']) ? (int)trim($_GET['count']) : Option::get('index_lognum');
        $sort_id = isset($_GET['sort_id']) ? (int)trim($_GET['sort_id']) : 0;
        $keyword = isset($_GET['keyword']) ? addslashes(htmlspecialchars(urldecode(trim($_GET['keyword'])))) : '';
        $keyword = str_replace(['%', '_'], ['\%', '\_'], $keyword);
        $tag = isset($_GET['tag']) ? addslashes(urldecode(trim($_GET['tag']))) : '';
        $order = Input::getStrVar('order');

        $sub = '';
        if ($sort_id) {
            $sub .= ' and sortid = ' . $sort_id;
        }
        if ($keyword) {
            $sub .= " and title like '%{$keyword}%'";
        }
        if ($tag) {
            $blogIdStr = $this->Tag_Model->getTagByName($tag);
            if ($blogIdStr) {
                $sub .= "and gid IN ($blogIdStr)";
            }
        }

        $sub2 = ' ORDER BY ';
        switch ($order) {
            case 'views':
                $sub2 .= 'views DESC';
                break;
            case 'comnum':
                $sub2 .= 'comnum DESC';
                break;
            default:
                $sub2 .= 'top DESC, sortop DESC, date DESC';
                break;
        }

        $r = $this->Log_Model->getLogsForHome($sub . $sub2, $page, $count);
        $sta_cache = $this->Cache->readCache('sta');
        $lognum = $sta_cache['lognum'];
        $total_pages = $lognum > 0 ? ceil($lognum / $count) : 1;
        $has_more = $page < $total_pages;

        $sort_cache = $this->Cache->readCache('sort');
        $articles = [];
        foreach ($r as $value) {
            $articles[] = [
                'id'          => (int)$value['gid'],
                'title'       => $value['title'],
                'cover'       => $value['log_cover'],
                'url'         => $value['log_url'],
                'description' => $value['log_description'],
                'description_raw' => empty($value['excerpt']) ? $value['content'] : $value['excerpt'],
                'date'        => date('Y-m-d H:i:s', $value['date']),
                'author_id'   => (int)$value['author'],
                'author_name' => $this->getAuthorName($value['author']),
                'sort_id'     => (int)$value['sortid'],
                'sort_name'   => isset($sort_cache[$value['sortid']]['sortname']) ? $sort_cache[$value['sortid']]['sortname'] : '',
                'views'       => (int)$value['views'],
                'comnum'      => (int)$value['comnum'],
                'like_count'  => (int)$value['like_count'],
                'top'         => $value['top'],
                'sortop'      => $value['sortop'],
                'tags'        => $this->getTags((int)$value['gid']),
                'need_pwd'    => $value['password'] ? 'y' : 'n',
                'fields'      => $value['fields'],
                'parent_id'   => (int)$value['parent_id'],
            ];
        }

        output::ok([
            'articles' => $articles,
            'page' => $page,
            'total_pages' => $total_pages,
            'has_more' => $has_more,
        ]);
    }

    private function article_detail()
    {
        $id = Input::getIntVar('id', 0);
        $password = Input::getStrVar('password');

        $sort_cache = $this->Cache->readCache('sort');
        $r = $this->Log_Model->getOneLogForHome($id);
        $article = '';
        if (empty($r)) {
            Output::error('Article not found');
        }

        if ($r['password'] && $r['password'] !== $password) {
            Output::error('Wrong password');
        }

        $user_info = $this->User_Model->getOneUser($r['author']);
        $author_name = isset($user_info['nickname']) ? $user_info['nickname'] : '';
        $author_avatar = isset($user_info['photo']) ? getFileUrl($user_info['photo']) : '';

        $article = [
            'title'         => $r['log_title'],
            'date'          => date('Y-m-d H:i:s', $r['date']),
            'id'            => (int)$r['logid'],
            'sort_id'       => (int)$r['sortid'],
            'sort_name'     => isset($sort_cache[$r['sortid']]['sortname']) ? $sort_cache[$r['sortid']]['sortname'] : '',
            'type'          => $r['type'],
            'author_id'     => (int)$r['author'],
            'author_name'   => $author_name,
            'author_avatar' => $author_avatar,
            'content'       => $r['log_content'],
            'content_raw'   => $r['content_raw'],
            'excerpt'       => $r['excerpt'],
            'excerpt_raw'   => $r['excerpt_raw'],
            'cover'         => $r['log_cover'],
            'views'         => (int)$r['views'],
            'comnum'        => (int)$r['comnum'],
            'like_count'    => (int)$r['like_count'],
            'top'           => $r['top'],
            'sortop'        => $r['sortop'],
            'tags'          => $this->getTags($id),
            'fields'        => $r['fields'],
            'parent_id'     => (int)$r['parent_id'],
        ];

        $this->Log_Model->updateViewCount($id);

        output::ok(['article' => $article,]);
    }

    private function sort_list()
    {
        $sort_cache = $this->Cache->readCache('sort');
        $data = [];
        foreach ($sort_cache as $sort_id => $value) {
            unset($value['children']);
            if ($value['pid'] === 0) {
                $data[$sort_id] = $value;
            } else {
                $data[$value['pid']]['children'][] = $value;
            }
        }
        sort($data);
        output::ok(['sorts' => $data,]);
    }

    private function note_post()
    {
        $t = Input::postStrVar('t');
        $private = Input::postStrVar('private', 'n');
        $author_uid = Input::postIntVar('author_uid', 1);

        $this->auth();

        if (empty($t)) {
            Output::error('parameter error');
        }

        if ($private !== 'y') {
            $private = 'n';
        }

        if ($this->curUid) {
            $author_uid = $this->curUid;
        }

        $data = [
            'content' => $t,
            'author'  => $author_uid,
            'private' => $private,
            'date'    => time(),
        ];

        $id = $this->Twitter_Model->addTwitter($data);
        $this->Cache->updateCache('sta');
        doAction('post_note', $data, $id);
        output::ok(['note_id' => $id,]);
    }

    private function note_list()
    {
        $page = Input::getIntVar('page', 1);
        $author_uid = Input::getIntVar('author_uid');
        $count = Input::getIntVar('count', 20);

        $this->auth();

        if ($this->curUid) {
            $author_uid = $this->curUid;
        }

        $r = $this->Twitter_Model->getTwitters($author_uid, $page, $count);

        $notes = [];
        foreach ($r as $value) {
            $notes[] = [
                'id'          => (int)$value['id'],
                't'           => $value['t'],
                't_raw'       => $value['t_raw'],
                'date'        => $value['date'],
                'author_id'   => (int)$value['author'],
                'author_name' => $this->getAuthorName($value['author']),
            ];
        }
        output::ok(['notes' => $notes,]);
    }

    public function userinfo()
    {
        $this->checkAuthCookie();

        $data = [
            'uid'         => (int)$this->curUserInfo['uid'],
            'nickname'    => htmlspecialchars($this->curUserInfo['nickname']),
            'role'        => $this->curUserInfo['role'],
            'photo'       => $this->curUserInfo['photo'],
            'avatar'      => $this->curUserInfo['photo'] ? BLOG_URL . str_replace("../", '', $this->curUserInfo['photo']) : '',
            'email'       => $this->curUserInfo['email'],
            'description' => htmlspecialchars($this->curUserInfo['description']),
            'ip'          => $this->curUserInfo['ip'],
            'create_time' => (int)$this->curUserInfo['create_time'],
        ];

        output::ok(['userinfo' => $data]);
    }

    public function user_detail()
    {
        $uid = Input::getIntVar('id');

        $this->checkApiKey();

        $userInfo = $this->User_Model->getOneUser($uid);
        if (empty($userInfo)) {
            output::ok(['userinfo' => []]);
        }

        $data = [
            'uid'         => (int)$userInfo['uid'],
            'nickname'    => htmlspecialchars($userInfo['nickname']),
            'role'        => $userInfo['role'],
            'avatar'      => getFileUrl($userInfo['photo']),
            'description' => htmlspecialchars($userInfo['description']),
            'create_time' => (int)$userInfo['create_time'],
        ];

        output::ok(['userinfo' => $data]);
    }

    public function upload()
    {
        $sid = Input::postIntVar('sid');
        $author_uid = Input::postIntVar('author_uid', 1);
        $attach = isset($_FILES['file']) ? $_FILES['file'] : '';

        $this->checkApiKey();

        if (!$attach || $attach['error'] === 4) {
            Output::error('Upload error');
        }

        $ret = '';
        addAction('upload_media', 'upload2local');
        doOnceAction('upload_media', $attach, $ret);

        if (empty($ret['success']) || !isset($ret['file_info'])) {
            Output::error($ret['message']);
        }

        $aid = $this->Media_Model->addMedia($ret['file_info'], $sid, $author_uid);

        Output::ok(['media_id' => $aid, 'url' => $ret['url'], 'file_info' => $ret['file_info']]);
    }

    private function comment_list()
    {
        $id = Input::getIntVar('id');
        $page = Input::getIntVar('page', 1);

        if (empty($id)) {
            Output::error('parameter error');
        }

        $comments = $this->Comment_Model->getComments($id, 'n', $page);
        output::ok($comments);
    }

    private function comment_list_simple()
    {
        $id = Input::getIntVar('id');

        if (empty($id)) {
            Output::error('parameter error');
        }

        $comments = $this->Comment_Model->getCommentListForApi($id, 'n');
        output::ok(['comments' => $comments]);
    }

    private function unlike()
    {
        $blogId = Input::postIntVar('id', -1);

        $this->checkAuthCookie();

        if (empty($blogId)) {
            Output::error('parameter error');
        }

        $r = $this->Like_Model->unLike($this->curUid, $blogId);

        if ($r === false) {
            Output::error('unlike failed');
        }

        output::ok();
    }

    private function like_list()
    {
        $id = Input::getIntVar('id');

        if (empty($id)) {
            Output::error('parameter error');
        }

        $r = $this->Like_Model->getList($id);

        $likes = [];
        foreach ($r as $value) {
            $likes[] = [
                'id'          => (int)$value['id'],
                'gid'         => (int)$value['gid'],
                'uid'         => (int)$value['uid'],
                'date'        => $value['date'],
                'avatar'      => $value['avatar'],
                'poster'      => $value['poster'],
            ];
        }

        output::ok(['likes' => $likes]);
    }

    private function getTags($id)
    {
        $tag_ids = $this->Tag_Model->getTagIdsFromBlogId($id);
        $tag_names = $this->Tag_Model->getNamesFromIds($tag_ids);
        $tags = [];
        if (!empty($tag_names)) {
            foreach ($tag_names as $value) {
                $tags[] = [
                    'name' => htmlspecialchars($value),
                    'url'  => Url::tag(rawurlencode($value)),
                ];
            }
        }
        return $tags;
    }

    private function getAuthorName($uid)
    {
        $userInfo = $this->User_Model->getOneUser($uid);
        return isset($userInfo['nickname']) ? $userInfo['nickname'] : '';
    }

    private function checkApiOpen($apiName)
    {
        if (in_array($apiName, ['article_list'])) {
            return;
        }
        if (Option::get('is_openapi') === 'n') {
            Output::error('api is closed');
        }
    }

    private function auth()
    {
        if (isset($_COOKIE[AUTH_COOKIE_NAME])) {
            $this->checkAuthCookie();
        } else {
            $this->checkApiKey();
        }
    }

    private function checkApiKey()
    {
        $this->authApiKey = Input::requestStrVar('api_key');
        $this->authReqSign = Input::requestStrVar('req_sign');
        $this->authReqTime = Input::requestStrVar('req_time');

        if (empty($this->authApiKey) && (empty($this->authReqSign) || empty($this->authReqTime))) {
            Output::authError('auth param error');
        }

        $apikey = Option::get('apikey');

        if ($apikey === $this->authApiKey) {
            return;
        }

        $sign = md5($this->authReqTime . $apikey);
        if ($sign === $this->authReqSign) {
            return;
        }
        Output::authError('auth error');
    }

    private function checkAuthCookie()
    {
        if (!isset($_COOKIE[AUTH_COOKIE_NAME])) {
            Output::authError('auth cookie error');
        }
        $userInfo = loginauth::validateAuthCookie($_COOKIE[AUTH_COOKIE_NAME]);
        if (!$userInfo) {
            Output::authError('auth cookie error');
        }
        $this->curUserInfo = $userInfo;
        $this->curUid = (int)$userInfo['uid'];
    }
}
