/*!
 * audio (upload) dialog plugin for Editor.md
 * {@link       https://github.com/pandao/editor.md}
 * @license     MIT
 */
(function () {
    var factory = function (exports) {
        //定义插件名称
        var pluginName = "audio-dialog";
        exports.fn.audioDialog = function () {
            var _this = this;
            var cm = this.cm;
            var lang = this.lang;
            /* 修改：更换对话框创建的位置 */
            // var editor       = this.editor;
            var editor = $("#editor-md-dialog");
            var settings = this.settings;
            var cursor = cm.getCursor();
            var selection = cm.getSelection();
            var audioLang = lang.dialog.audio;
            var classPrefix = this.classPrefix;
            var iframeName = classPrefix + "audio-iframe";
            var dialogName = classPrefix + pluginName, dialog;
            cm.focus();
            var loading = function (show) {
                var _loading = dialog.find("." + classPrefix + "dialog-mask");
                _loading[(show) ? "show" : "hide"]();
            };
            if (editor.find("." + dialogName).length < 1) {
                var guid = (new Date).getTime();
                //组合弹出框
                var dialogContent = "<div class=\"" + classPrefix + "form\"><label>" + audioLang.url + "</label>" + "<input type=\"text\" data-url />" + (function () {
                    return "";
                })() + "<br/>" + ((settings.videoUpload) ? "</form>" : "</div>");
                //动态创建对话框
                dialog = this.createDialog({
                    title: audioLang.title,
                    width: (settings.audioUpload) ? 465 : 380,
                    height: 254,
                    name: dialogName,
                    content: dialogContent,
                    mask: settings.dialogShowMask,
                    drag: settings.dialogDraggable,
                    lockScreen: settings.dialogLockScreen,
                    maskStyle: {
                        opacity: settings.dialogMaskOpacity, backgroundColor: settings.dialogMaskBgColor
                    },
                    buttons: {
                        enter: [lang.buttons.enter, function () {
                            var url = this.find("[data-url]").val();
                            var alt = this.find("[data-alt]").val();
                            if (url === "") {
                                alert(audioLang.audioURLEmpty);
                                return false;
                            }
                            var audioHtml = '<audio preload="auto" id="audio" controls loop style="width: 100%;"><source src="' + url + '"></audio>';
                            audioHtml = "\n" + audioHtml + "\n";
                            cm.replaceSelection(audioHtml);
                            if (alt === "") {
                                cm.setCursor(cursor.line, cursor.ch + 2);
                            }
                            this.hide().lockScreen(false).hideMask();
                            return false;
                        }], cancel: [lang.buttons.cancel, function () {
                            this.hide().lockScreen(false).hideMask();
                            return false;
                        }]
                    }
                });
                dialog.attr("id", classPrefix + "audio-dialog-" + guid);
                if (!settings.audioUpload) {
                    return;
                }
            }
            dialog = editor.find("." + dialogName);
            dialog.find("[type=\"text\"]").val("");
            dialog.find("[type=\"file\"]").val("");
            dialog.find("[data-link]").val("http://");
            this.dialogShowMask(dialog);
            this.dialogLockScreen();
            dialog.show();
        };
    };
    // CommonJS/Node.js
    if (typeof require === "function" && typeof exports === "object" && typeof module === "object") {
        module.exports = factory;
    } else if (typeof define === "function")  // AMD/CMD/Sea.js
    {
        if (define.amd) { // for Require.js
            define(["editormd"], function (editormd) {
                factory(editormd);
            });
        } else { // for Sea.js
            define(function (require) {
                var editormd = require("./../../editormd");
                factory(editormd);
            });
        }
    } else {
        factory(window.editormd);
    }
})();