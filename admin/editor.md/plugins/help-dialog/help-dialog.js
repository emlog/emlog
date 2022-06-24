/*!
 * Help dialog plugin for Editor.md
 *
 * @file        help-dialog.js
 * @author      pandao
 * @version     1.2.0
 * @updateTime  2015-03-08
 * {@link       https://github.com/pandao/editor.md}
 * @license     MIT
 */

(function() {

	var factory = function (exports) {

		var $            = jQuery;
		var pluginName   = "help-dialog";

		exports.fn.helpDialog = function() {
			var _this       = this;
			var lang        = this.lang;
			/* 修改：更换对话框创建的位置 */
			// var editor       = this.editor;
			var editor       = $("#editor-md-dialog");
			var settings    = this.settings;
			var path        = settings.pluginPath + pluginName + "/";
			var classPrefix = this.classPrefix;
			var dialogName  = classPrefix + pluginName, dialog;
			var dialogLang  = lang.dialog.help;

			if (editor.find("." + dialogName).length < 1)
			{			
				var dialogContent = `<div class=\"markdown-body\" style=\"font-family:微软雅黑, Helvetica, Tahoma, STXihei,Arial;height:390px;overflow:auto;font-size:14px;border-bottom:1px solid #ddd;padding:0 20px 20px 0;\">
				<h5>Markdown语法教程</h5><ul>
				<li><p><a href="http://daringfireball.net/projects/markdown/syntax/" title="Markdown Syntax">Markdown Syntax</a></p>
				</li><li><p><a href="https://guides.github.com/features/mastering-markdown/" title="Mastering Markdown">Mastering Markdown</a></p>
				</li><li><p><a href="https://help.github.com/articles/markdown-basics/" title="Markdown Basics">Markdown Basics</a></p>
				</li><li><p><a href="https://help.github.com/articles/github-flavored-markdown/" title="GitHub Flavored Markdown">GitHub Flavored Markdown</a></p>
				</li><li><p><a href="http://www.markdown.cn/" title="Markdown 语法说明（简体中文）">Markdown 语法说明（简体中文）</a></p>
				</li><li><p><a href="http://markdown.tw/" title="Markdown 語法說明（繁體中文）">Markdown 語法說明（繁體中文）</a></p>
				</li></ul>
				<h5 id="h5--keyboard-shortcuts-">键盘快捷键</h5><blockquote>
				<p>快捷键表格中的Ctrl与Alt，在Mac系统中可分别被Cmd与Opt取代。</p>
				</blockquote>
				<table>
					<thead>
					<tr>
					<th style="text-align: center;"><strong><strong>Ctrl + S</strong></strong></th>
					<th style="text-align: center;">保存</th>
					<th style="text-align: center;"><strong><strong>F9</strong></strong></th>
					<th style="text-align: center;">切换实时预览</th>
					<th style="text-align: center;"><strong><strong>Ctrl + Shift + R</strong></strong></th>
					<th style="text-align: center;">全部替换</th>
					</tr>
					</thead>
					<tbody>
					<tr>
					<td style="text-align: center;"><strong><strong>Ctrl+1~6</strong></strong></td>
					<td style="text-align: center;">分别对应H1到H6</td>
					<td style="text-align: center;"><strong><strong>F10</strong></strong></td>
					<td style="text-align: center;">编辑器全屏预览</td>
					<td style="text-align: center;"><strong><strong>Ctrl + D</strong></strong></td>
					<td style="text-align: center;">当前时间</td>
					</tr>
					<tr>
					<td style="text-align: center;"><strong><strong>Ctrl + U</strong></strong></td>
					<td style="text-align: center;">无序列表</td>
					<td style="text-align: center;"><strong><strong>按住Ctrl键的同时，选择编辑区的不同地方</strong></strong></td>
					<td style="text-align: center;">多光标选择</td>
					<td style="text-align: center;"><strong><strong>Ctrl + H</strong></strong></td>
					<td style="text-align: center;">水平线</td>
					</tr>
					<tr>
					<td style="text-align: center;"><strong><strong>Ctrl + B</strong></strong></td>
					<td style="text-align: center;">粗体</td>
					<td style="text-align: center;"><strong><strong>Ctrl+ A</strong></strong></td>
					<td style="text-align: center;">全选</td>
					<td style="text-align: center;"><strong><strong>Ctrl + L</strong></strong></td>
					<td style="text-align: center;">链接</td>
					</tr>
					<tr>
					<td style="text-align: center;"><strong><strong>Ctrl + I</strong></strong></td>
					<td style="text-align: center;">斜体</td>
					<td style="text-align: center;"><strong><strong>Ctrl+ Z</strong></strong></td>
					<td style="text-align: center;">撤销</td>
					<td style="text-align: center;"><strong><strong>Ctrl + Shift + A</strong></strong></td>
					<td style="text-align: center;">Github链接</td>
					</tr>
					<tr>
					<td style="text-align: center;"><strong><strong>Ctrl + K</strong></strong></td>
					<td style="text-align: center;">行内代码</td>
					<td style="text-align: center;"><strong><strong>Ctrl+ Y</strong></strong></td>
					<td style="text-align: center;">重做</td>
					<td style="text-align: center;"><strong><strong>Ctrl + Shift + I</strong></strong></td>
					<td style="text-align: center;">图片</td>
					</tr>
					<tr>
					<td style="text-align: center;"><strong><strong>Shift + Alt + L</strong></strong></td>
					<td style="text-align: center;">所选文本转为小写</td>
					<td style="text-align: center;"><strong><strong>Ctrl + F</strong></strong></td>
					<td style="text-align: center;">查找搜索</td>
					<td style="text-align: center;"><strong><strong>Ctrl + Shift + C</strong></strong></td>
					<td style="text-align: center;">代码区块</td>
					</tr>
					<tr>
					<td style="text-align: center;"><strong><strong>Shift + Alt+ U</strong></strong></td>
					<td style="text-align: center;">首字母转为大写</td>
					<td style="text-align: center;"><strong><strong>Ctrl + Shift + G</strong></strong></td>
					<td style="text-align: center;">上一个结果</td>
					<td style="text-align: center;"><strong><strong>Ctrl + Shift + P</strong></strong></td>
					<td style="text-align: center;">Pre标签代码区块</td>
					</tr>
					<tr>
					<td style="text-align: center;"><strong><strong>Ctrl + Alt + G</strong></strong></td>
					<td style="text-align: center;">跳转到行</td>
					<td style="text-align: center;"><strong><strong>Ctrl + G</strong></strong></td>
					<td style="text-align: center;">下一个结果</td>
					<td style="text-align: center;"><strong><strong>Ctrl + Shift + H</strong></strong></td>
					<td style="text-align: center;">Html实体字符</td>
					</tr>
					</tbody>
					</table>
				</div>`;

				dialog = this.createDialog({
					name       : dialogName,
					title      : dialogLang.title,
					width      : 840,
					height     : 540,
					mask       : settings.dialogShowMask,
					drag       : settings.dialogDraggable,
					content    : dialogContent,
					lockScreen : settings.dialogLockScreen,
					maskStyle  : {
						opacity         : settings.dialogMaskOpacity,
						backgroundColor : settings.dialogMaskBgColor
					},
					buttons    : {
						close : [lang.buttons.close, function() {      
							this.hide().lockScreen(false).hideMask();
							
							return false;
						}]
					}
				});
			}

			dialog = editor.find("." + dialogName);

			this.dialogShowMask(dialog);
			this.dialogLockScreen();
			dialog.show();

			/* 
			var helpContent = dialog.find(".markdown-body");

			if (helpContent.html() === "") 
			{
				$.get(path + "help.md", function(text) {
					var md = exports.$marked(text);
					helpContent.html(md);
                    
                    helpContent.find("a").attr("target", "_blank");
				});
			}
			*/
		};

	};
    
	// CommonJS/Node.js
	if (typeof require === "function" && typeof exports === "object" && typeof module === "object")
    { 
        module.exports = factory;
    }
	else if (typeof define === "function")  // AMD/CMD/Sea.js
    {
		if (define.amd) { // for Require.js

			define(["editormd"], function(editormd) {
                factory(editormd);
            });

		} else { // for Sea.js
			define(function(require) {
                var editormd = require("./../../editormd");
                factory(editormd);
            });
		}
	} 
	else
	{
        factory(window.editormd);
	}

})();
