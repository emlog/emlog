/*!
 * Video (upload) dialog plugin for Editor.md
 * {@link       https://github.com/pandao/editor.md}
 * @license     MIT
 */
(function () {
    var factory = function (exports) {
        //定义插件名称
        var pluginName = "video-dialog";
        exports.fn.videoDialog = function () {
            var _this = this;
            var cm = this.cm;
            var lang = this.lang;
            /* 修改：更换对话框创建的位置 */
            // var editor       = this.editor;
            var editor = $("#editor-md-dialog");
            var settings = this.settings;
            var cursor = cm.getCursor();
            var selection = cm.getSelection();
            var videoLang = lang.dialog.video;
            var classPrefix = this.classPrefix;
            var iframeName = classPrefix + "video-iframe";
            var dialogName = classPrefix + pluginName, dialog;
            cm.focus();
            var loading = function (show) {
                var _loading = dialog.find("." + classPrefix + "dialog-mask");
                _loading[(show) ? "show" : "hide"]();
            };
            if (editor.find("." + dialogName).length < 1) {
                var guid = (new Date).getTime();
                //定义请求URL
                var action = settings.videoUploadURL + (settings.videoUploadURL.indexOf("?") >= 0 ? "&" : "?") + "guid=" + guid;
                //判断是否跨域请求
                if (settings.crossDomainUpload) {
                    action += "&callback=" + settings.uploadCallbackURL + "&dialog_id=editormd-video-dialog-" + guid;
                }
                //组合弹出框
                var dialogContent = ((settings.videoUpload) ? "<form action=\"" + action + "\" target=\"" + iframeName + "\" method=\"post\" enctype=\"multipart/form-data\" class=\"" + classPrefix + "form\">" : "<div class=\"" + classPrefix + "form\">") + ((settings.videoUpload) ? "<iframe name=\"" + iframeName + "\" id=\"" + iframeName + "\" guid=\"" + guid + "\"></iframe>" : "") + "<label>" + videoLang.url + "</label>" + "<input type=\"text\" data-url />" + (function () {
                    return (settings.videoUpload) ? "<div class=\"" + classPrefix + "file-input\">" + "<input type=\"file\" name=\"" + classPrefix + "video-file\" accept=\"video/*\" />" + "<input type=\"submit\" value=\"" + videoLang.uploadButton + "\" />" + "</div>" : "";
                })() + "<br/>" + ((settings.videoUpload) ? "</form>" : "</div>");
                //var videoFooterHTML = "<button class=\"" + classPrefix + "btn " + classPrefix + "video-manager-btn\" style=\"float:left;\">" + videoLang.managerButton + "</button>";
                //动态创建对话框
                dialog = this.createDialog({
                    title: videoLang.title,
                    width: (settings.videoUpload) ? 465 : 380,
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
                                alert(videoLang.videoURLEmpty);
                                return false;
                            }
                            var videoHtml = "";//视频展示HTML
                            videoHtml += '<video controls preload="auto" width="100%" poster="" data-setup=\'{"aspectRatio":"16:9"}\'><source src="' + url + '" type="video/mp4"><object data="' + url + '" width="100%"><embed src="' + url + '" width="100%"><p class="vjs-no-js">如果你无法看到该视频,那么可能你的电脑不支持该文件格式。</p></object></video>';
                            videoHtml = "\n" + videoHtml + "\n";
                            cm.replaceSelection(videoHtml);
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
                dialog.attr("id", classPrefix + "video-dialog-" + guid);
                if (!settings.videoUpload) {
                    return;
                }
                //获取到上传视频节点
                var fileInput = dialog.find("[name=\"" + classPrefix + "video-file\"]");
                //当节点的数据发生变化时，触发change事件
                fileInput.bind("change", function () {
                    if (settings.videoUploadURL == "") {
                        alert('你还没有配置上传地址');
                        return false;
                    }
                    var fileName = fileInput.val();//获取到视频文件
                    var isVideo = new RegExp("(\\.(" + settings.videoFormats.join("|") + "))$"); // /(\.(mp4|rmvb))$/
                    //判断文件是否为空
                    if (fileName === "") {
                        alert(videoLang.uploadFileEmpty);
                        return false;
                    }
                    //验证文件格式
                    if (!isVideo.test(fileName)) {
                        alert(videoLang.formatNotAllowed + settings.videoFormats.join(", "));
                        return false;
                    }
                    //验证文件大小
                    //注意：这里判断文件大小，需要你们自定义大小，不要直接复制我的
                    /*if(this.files[0].size > Number(settings.fileUploadSize*1024*1024)){
                        alert("文件过大，建议小于 " + settings.fileUploadSize + "M");
                        return false;
                    }*/
                    loading(true);
                    //提交上传的视频文件
                    var submitHandler = function () {
                        var uploadIframe = document.getElementById(iframeName);
                        uploadIframe.onload = function () {
                            loading(false);
                            var body = (uploadIframe.contentWindow ? uploadIframe.contentWindow : uploadIframe.contentDocument).document.body;
                            var json = (body.innerText) ? body.innerText : ((body.textContent) ? body.textContent : null);
                            json = (typeof JSON.parse !== "undefined") ? JSON.parse(json) : eval("(" + json + ")");
                            if (!settings.crossDomainUpload) {
                                if (json.success === 1) {
                                    dialog.find("[data-url]").val(json.url);
                                } else {
                                    alert(json.message);
                                }
                            }
                            return false;
                        };
                    };
                    dialog.find("[type=\"submit\"]").bind("click", submitHandler).trigger("click");
                });
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