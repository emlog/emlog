/*
 * FCKeditor - The text editor for Internet - http://www.fckeditor.net
 * Copyright (C) 2003-2008 Frederico Caldeira Knabben
 *
 * == BEGIN LICENSE ==
 *
 * Licensed under the terms of any of the following licenses at your
 * choice:
 *
 *  - GNU General Public License Version 2 or later (the "GPL")
 *    http://www.gnu.org/licenses/gpl.html
 *
 *  - GNU Lesser General Public License Version 2.1 or later (the "LGPL")
 *    http://www.gnu.org/licenses/lgpl.html
 *
 *  - Mozilla Public License Version 1.1 or later (the "MPL")
 *    http://www.mozilla.org/MPL/MPL-1.1.html
 *
 * == END LICENSE ==
 *
 * Chinese Simplified language file.
 */

var FCKLang =
{
// Language direction : "ltr" (left to right) or "rtl" (right to left).
Dir					: "ltr",

// Toolbar Items and Context Menu
Preview				: "预览",
Cut					: "剪切",
Copy				: "复制",
Paste				: "粘贴",
PasteText			: "粘贴为无格式文本",
PasteWord			: "从 MS Word 粘贴",
RemoveFormat		: "清除格式",
InsertLinkLbl		: "超链接",
InsertLink			: "插入/编辑超链接",
RemoveLink			: "取消超链接",
Anchor				: "插入/编辑锚点链接",
AnchorDelete		: "清除锚点链接",
InsertImageLbl		: "图象",
InsertImage			: "插入/编辑图象",
InsertFlashLbl		: "Flash",
InsertFlash			: "插入/编辑 Flash",
InsertTableLbl		: "表格",
InsertTable			: "插入/编辑表格",
InsertLineLbl		: "分割符",
InsertLine			: "插入日志分割符",
InsertSmileyLbl		: "表情符",
InsertSmiley		: "插入表情",
About				: "关于 FCKeditor",
Bold				: "加粗",
Italic				: "倾斜",
Underline			: "下划线",
StrikeThrough		: "删除线",
LeftJustify			: "左对齐",
CenterJustify		: "居中对齐",
RightJustify		: "右对齐",
BlockJustify		: "两端对齐",
DecreaseIndent		: "减少缩进量",
IncreaseIndent		: "增加缩进量",
Blockquote			: "引用文字",
Undo				: "撤消",
Redo				: "重做",
NumberedListLbl		: "编号列表",
NumberedList		: "插入/删除编号列表",
BulletedListLbl		: "项目列表",
BulletedList		: "插入/删除项目列表",
ShowDetails			: "显示详细资料",
Style				: "样式",
FontFormat			: "格式",
Font				: "字体",
FontSize			: "",
TextColor			: "文本颜色",
BGColor				: "背景颜色",
Source				: "源代码",
InsertCodes			: "插入代码",

FontFormats			: "普通;已编排格式;地址;标题 1;标题 2;标题 3;标题 4;标题 5;标题 6;段落(DIV)",

// Alerts and Messages
ProcessingXHTML		: "正在处理 XHTML，请稍等...",
Done				: "完成",
PasteWordConfirm	: "您要粘贴的内容好像是来自 MS Word，是否要清除 MS Word 格式后再粘贴？",
NotCompatiblePaste	: "该命令需要 Internet Explorer 5.5 或更高版本的支持，是否按常规粘贴进行？",
UnknownToolbarItem	: "未知工具栏项目 \"%1\"",
UnknownCommand		: "未知命令名称 \"%1\"",
NotImplemented		: "命令无法执行",
UnknownToolbarSet	: "工具栏设置 \"%1\" 不存在",
NoActiveX			: "浏览器安全设置限制了本编辑器的某些功能。您必须启用安全设置中的“运行 ActiveX 控件和插件”，否则将出现某些错误并缺少功能。",
DialogBlocked		: "无法打开对话框窗口，请确认是否启用了禁止弹出窗口或网页对话框（IE）。",

// Dialogs
DlgBtnOK			: "确定",
DlgBtnCancel		: "取消",
DlgBtnClose			: "关闭",
DlgAdvancedTag		: "高级",
DlgOpOther			: "<其它>",
DlgInfoTab			: "信息",
DlgAlertUrl			: "请插入 URL",

// General Dialogs Labels
DlgGenNotSet		: "<没有设置>",

// Image Dialog
DlgImgTitle			: "图象属性",
DlgImgInfoTab		: "图象",
DlgImgURL			: "文件地址",
DlgImgAlt			: "图片描述",
DlgImgWidth			: "宽度",
DlgImgHeight		: "高度",
DlgImgBorder		: "边框大小",
DlgImgHSpace		: "水平间距",
DlgImgVSpace		: "垂直间距",
DlgImgAlign			: "对齐方式",
DlgImgAlignLeft		: "左对齐",
DlgImgAlignAbsBottom: "绝对底边",
DlgImgAlignAbsMiddle: "绝对居中",
DlgImgAlignBaseline	: "基线",
DlgImgAlignBottom	: "底边",
DlgImgAlignMiddle	: "居中",
DlgImgAlignRight	: "右对齐",
DlgImgAlignTextTop	: "文本上方",
DlgImgAlignTop		: "顶端",
DlgImgAlertUrl		: "请输入图象地址",

// Flash Dialog
DlgFlashTitle		: "Flash 属性",
DlgFlashChkPlay		: "自动播放",
DlgFlashChkLoop		: "循环",
DlgFlashChkMenu		: "启用Flash菜单",
DlgFlashScale		: "缩放",
DlgFlashScaleAll	: "全部显示",
DlgFlashScaleNoBorder	: "无边框",
DlgFlashScaleFit	: "严格匹配",

// Code Dialog
DlgCodesTitle		: "插入代码",
DlgCodesLanguage	: "语言",
DlgCodesContent		: "内容",

// Link Dialog
DlgLnkWindowTitle	: "超链接",

DlgLnkTarget		: "目标",
DlgLnkTargetBlank	: "新窗口 (_blank)",
DlgLnkTargetParent	: "父窗口 (_parent)",
DlgLnkTargetSelf	: "本窗口 (_self)",
DlgLnkTargetTop		: "整页 (_top)",

DlnLnkMsgNoUrl		: "请输入超链接地址",
DlnLnkMsgNoEMail	: "请输入电子邮件地址",
DlnLnkMsgNoAnchor	: "请选择一个锚点",
DlnLnkMsgInvPopName	: "弹出窗口名称必须以字母开头，并且不能含有空格。",

// Color Dialog
DlgColorTitle		: "选择颜色",

// Smiley Dialog
DlgSmileyTitle		: "插入表情",

// Table Dialog
DlgTableTitle		: "表格属性",
DlgTableRows		: "行数",
DlgTableColumns		: "列数",
DlgTableBorder		: "边框",
DlgTableAlign		: "对齐",
DlgTableAlignNotSet	: "<没有设置>",
DlgTableAlignLeft	: "左对齐",
DlgTableAlignCenter	: "居中",
DlgTableAlignRight	: "右对齐",
DlgTableWidth		: "宽度",
DlgTableWidthPx		: "像素",
DlgTableWidthPc		: "百分比",
DlgTableHeight		: "高度",
DlgTableCellSpace	: "间距",
DlgTableCellPad		: "边距",
DlgTableCaption		: "标题",
DlgTableSummary		: "摘要",

// Paste Operations / Dialog
PasteErrorCut	: "您的浏览器安全设置不允许编辑器自动执行剪切操作，请使用键盘快捷键(Ctrl+X)来完成。",
PasteErrorCopy	: "您的浏览器安全设置不允许编辑器自动执行复制操作，请使用键盘快捷键(Ctrl+C)来完成。",

PasteAsText		: "粘贴为无格式文本",
PasteFromWord	: "从 MS Word 粘贴",

DlgPasteMsg2	: "请使用键盘快捷键(<STRONG>Ctrl+V</STRONG>)把内容粘贴到下面的方框里，再按 <STRONG>确定</STRONG>。",
DlgPasteSec		: "因为你的浏览器的安全设置原因，本编辑器不能直接访问你的剪贴板内容，你需要在本窗口重新粘贴一次。",
DlgPasteIgnoreFont		: "忽略 Font 标签",
DlgPasteRemoveStyles	: "清理 CSS 样式",

// Color Picker
ColorAutomatic	: "自动",

// Anchor Dialog
DlgAnchorTitle		: "命名锚点",
DlgAnchorName		: "锚点名称",
DlgAnchorErrorName	: "请输入锚点名称",

// About Dialog
DlgAboutAboutTab	: "关于",
DlgAboutInfo		: "要获得更多信息请访问 "

};
