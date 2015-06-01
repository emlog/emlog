<?php

$lang = array(

//---------------------------
//admin/views/add_log.php

 'post_tags_separated'	=> 'Тэги, через запятую или пробел. Слишком много тэгов - тоже плохо, ибо тормоза.',//'文章标签，逗号或空格分隔，过多的标签会影响系统运行效率',
 'tags_have'		=> 'Тэги+',//'已有标签+',
 'tag_not_set'		=> 'Тэги не заданы!',//'还没有设置过标签！',

//---------------------------
//admin/views/admin_log.php
 'tags'			=> 'Тэги',//'标签',
 'tags_no'		=> 'Нет тэгов',//'还没有标签',
 'tag_by_view'		=> 'Показ по тэгам',//'按标签查看',

//---------------------------
//admin/views/edit_log.php
// 'post_tags_separated'	=> 'Posts tags, separated by comma or space. Too many tags will affect the system efficiency',//'文章标签，逗号或空格分隔，过多的标签会影响系统运行效率',
// 'tags_have'			=> 'Have tags+',//'已有标签+',
// 'tag_not_set'		=> 'Tags have not been set!',//'还没有设置过标签！',

//---------------------------
//admin/views/tag.php
 'tag_manage'		=> 'Управление тэгами',//'标签管理',
 'tag_delete_ok'	=> 'Тэг успешно удалён',//'删除标签成功',
 'tag_modify_ok'	=> 'Тэг успешно изменён',//'修改标签成功',
 'tag_select_to_delete'	=> 'Выберите тэг для удаления',//'请选择要删除的标签','请选择要删除的标签'
 'tags_no_info'		=> 'Тэги не установлены! Вы можете добавить их при написании сообщения.',//'还没有标签，写文章的时候可以给文章打标签',
// 'tag_select_to_delete'	=> 'Please, select tab that you want to delete',//'请选择要删除的标签','请选择要删除的标签'
 'tag_delete_sure'	=> 'Уверены, что следует удалить данный тэг?',//'你确定要删除所选标签吗？',

//---------------------------
//admin/views/tagedit.php
 'tag_edit'		=> 'Редактировать тэг',//'标签修改',
 'tag_empty'		=> 'Тэг не может быть пустым',//'标签不能为空',

//---------------------------
//include/model/tag_model.php
//[67] DO NOT TRANSLATE!!!	preg_split ("/[,\s]|(，)/", $tagStr)
//[88] DO NOT TRANSLATE!!!	preg_split ("/[,\s]|(，)/", $tagStr)

);
