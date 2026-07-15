/**
 * 迷你原生 JS 弹窗库
 */

(function (window, undefined) {
    // 动态注入 CSS 样式，包含动画、遮罩、居中、按钮以及现代 UI 样式
    const styleId = 'lay-mini-style';
    if (!document.getElementById(styleId)) {
        const style = document.createElement('style');
        style.id = styleId;
        style.textContent = `
            .lay-mini-shade {
                position: fixed;
                top: 0;
                left: 0;
                width: 100vw;
                height: 100vh;
                background: rgba(0, 0, 0, 0.4);
                backdrop-filter: blur(2px);
                z-index: 19891014;
                opacity: 0;
                transition: opacity 0.2s ease-out;
            }
            .lay-mini-shade.lay-show {
                opacity: 1;
            }
            .lay-mini-container {
                position: fixed;
                top: 50%;
                left: 50%;
                transform: translate(-50%, -50%) scale(0.9);
                z-index: 19891015;
                background: #fff;
                border-radius: 8px;
                box-shadow: 0 10px 30px rgba(0, 0, 0, 0.15);
                width: 90%;
                max-width: 420px;
                min-width: 280px;
                padding: 20px 24px;
                box-sizing: border-box;
                font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif;
                opacity: 0;
                transition: transform 0.2s cubic-bezier(0.34, 1.56, 0.64, 1), opacity 0.2s ease-out;
            }
            .lay-mini-container.lay-show {
                transform: translate(-50%, -50%) scale(1);
                opacity: 1;
            }
            .lay-mini-header {
                font-size: 16px;
                font-weight: 600;
                color: #333;
                margin-bottom: 14px;
                padding-right: 24px;
                position: relative;
                min-height: 20px;
            }
            .lay-mini-close {
                position: absolute;
                right: -4px;
                top: -2px;
                width: 20px;
                height: 20px;
                cursor: pointer;
                opacity: 0.5;
                transition: opacity 0.15s;
                display: flex;
                align-items: center;
                justify-content: center;
            }
            .lay-mini-close:hover {
                opacity: 0.8;
            }
            .lay-mini-close::before, .lay-mini-close::after {
                content: '';
                position: absolute;
                width: 2px;
                height: 14px;
                background-color: #333;
            }
            .lay-mini-close::before {
                transform: rotate(45deg);
            }
            .lay-mini-close::after {
                transform: rotate(-45deg);
            }
            .lay-mini-body {
                font-size: 14px;
                color: #444;
                line-height: 1.6;
                margin-bottom: 20px;
                word-break: break-all;
            }
            .lay-mini-body.has-icon {
                display: flex;
                gap: 14px;
                align-items: center;
            }
            .lay-mini-icon-box {
                flex-shrink: 0;
                width: 28px;
                height: 28px;
                display: flex;
                align-items: center;
                justify-content: center;
            }
            .lay-mini-icon {
                width: 28px;
                height: 28px;
                display: block;
            }
            
            .lay-mini-content {
                flex-grow: 1;
            }
            .lay-mini-footer {
                display: flex;
                justify-content: flex-end;
                gap: 8px;
            }
            .lay-mini-btn {
                padding: 6px 16px;
                font-size: 14px;
                border-radius: 4px;
                cursor: pointer;
                font-weight: 500;
                border: 1px solid transparent;
                transition: all 0.15s;
                outline: none;
                user-select: none;
                text-decoration: none;
                box-sizing: border-box;
                display: inline-flex;
                align-items: center;
                justify-content: center;
            }
            .lay-mini-btn-primary {
                background-color: #007bff;
                color: #fff !important;
                border-color: #007bff;
            }
            .lay-mini-btn-primary:hover {
                background-color: #0069d9;
                border-color: #0062cc;
            }
            .lay-mini-btn-danger {
                background-color: #dc3545;
                color: #fff !important;
                border-color: #dc3545;
            }
            .lay-mini-btn-danger:hover {
                background-color: #bd2130;
                border-color: #b21f2d;
            }
            .lay-mini-btn-primary *, .lay-mini-btn-danger * {
                color: inherit !important;
            }
            .lay-mini-btn-secondary {
                background-color: #f8f9fa;
                border-color: #ced4da;
                color: #495057 !important;
            }
            .lay-mini-btn-secondary:hover {
                background-color: #e2e6ea;
                border-color: #dae0e5;
            }
            .lay-mini-prompt-input {
                width: 100%;
                padding: 8px 12px;
                border: 1px solid #ced4da;
                border-radius: 4px;
                font-size: 14px;
                outline: none;
                box-sizing: border-box;
                margin-top: 10px;
                transition: border-color 0.15s, box-shadow 0.15s;
            }
            .lay-mini-prompt-input:focus {
                border-color: #80bdff;
                box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.25);
            }
        `;
        document.head.appendChild(style);
    }

    // 内嵌的高清晰度 SVG 常用图标，替代原有的 iconfont 字体包加载
    const SVGIcons = {
        // 警告 (icon: 0)
        0: `<svg viewBox="0 0 24 24" class="lay-mini-icon"><circle cx="12" cy="12" r="10" fill="#ffc107"/><path d="M12 8v4M12 16h.01" stroke="#333" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" fill="none"/></svg>`,
        // 成功 (icon: 1)
        1: `<svg viewBox="0 0 24 24" class="lay-mini-icon"><circle cx="12" cy="12" r="10" fill="#28a745"/><path d="M8.5 12.5l2.5 2.5 5-5" stroke="#fff" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" fill="none"/></svg>`,
        // 错误 (icon: 2)
        2: `<svg viewBox="0 0 24 24" class="lay-mini-icon"><circle cx="12" cy="12" r="10" fill="#dc3545"/><path d="M15 9l-6 6M9 9l6 6" stroke="#fff" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" fill="none"/></svg>`,
        // 询问 (icon: 3)
        3: `<svg viewBox="0 0 24 24" class="lay-mini-icon"><circle cx="12" cy="12" r="10" fill="#17a2b8"/><path d="M9.09 9a3 3 0 0 1 5.83 1c0 2-3 3-3 3M12 17h.01" stroke="#fff" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" fill="none"/></svg>`
    };

    let layerIndex = 0; // 自增弹窗索引ID
    const activeLayers = {}; // 存放当前打开的弹窗及相关DOM和配置

    const layer = {
        v: 'mini-1.0.0',
        
        /**
         * 打开弹窗的核心函数
         * @param {Object} options 配置项
         * @returns {number} 弹窗索引
         */
        open: function (options) {
            options = options || {};
            layerIndex++;
            const currentIdx = layerIndex;

            // 创建遮罩层
            const shade = document.createElement('div');
            shade.className = 'lay-mini-shade';
            shade.id = 'lay-mini-shade-' + currentIdx;
            document.body.appendChild(shade);

            // 创建弹窗主体
            const container = document.createElement('div');
            container.className = 'lay-mini-container';
            container.id = 'lay-mini-container-' + currentIdx;

            // 头部（标题 & 关闭按钮）
            let headerHtml = '';
            if (options.title !== false) {
                const titleText = options.title || '信息';
                headerHtml = `
                    <div class="lay-mini-header">
                        <span class="lay-mini-title">${titleText}</span>
                        <span class="lay-mini-close" data-role="close"></span>
                    </div>
                `;
            }

            // 内容区（如果有 icon 选项，则展示图标）
            let bodyClass = 'lay-mini-body';
            let iconHtml = '';
            if (options.icon !== undefined && SVGIcons[options.icon]) {
                bodyClass += ' has-icon';
                iconHtml = `<div class="lay-mini-icon-box">${SVGIcons[options.icon]}</div>`;
            }

            const bodyHtml = `
                <div class="${bodyClass}">
                    ${iconHtml}
                    <div class="lay-mini-content">${options.content || ''}</div>
                </div>
            `;

            // 按钮区
            let footerHtml = '';
            if (options.btn && options.btn.length > 0) {
                let btnButtons = '';
                options.btn.forEach((btnText, i) => {
                    // 支持带 HTML 样式的按钮文本，比如 <span class="text-danger">...</span>
                    let btnClass = 'lay-mini-btn lay-mini-btn-secondary';
                    if (i === 0) {
                        btnClass = 'lay-mini-btn lay-mini-btn-primary';
                    } else if (btnText.indexOf('text-danger') !== -1 || btnText.indexOf('danger') !== -1) {
                        btnClass = 'lay-mini-btn lay-mini-btn-danger';
                    }
                    btnButtons += `<button class="${btnClass}" data-index="${i}">${btnText}</button>`;
                });
                footerHtml = `<div class="lay-mini-footer">${btnButtons}</div>`;
            }

            container.innerHTML = headerHtml + bodyHtml + footerHtml;
            document.body.appendChild(container);

            // 缓存 DOM 节点以供后续操作
            activeLayers[currentIdx] = {
                shade: shade,
                container: container,
                options: options
            };

            // 触发淡入动画（使用 setTimeout 确保 DOM 已渲染）
            setTimeout(() => {
                shade.classList.add('lay-show');
                container.classList.add('lay-show');
            }, 10);

            // 绑定遮罩点击关闭事件
            if (options.shadeClose) {
                shade.addEventListener('click', () => {
                    layer.close(currentIdx);
                });
            }

            // 绑定头部关闭按钮事件
            const closeBtn = container.querySelector('.lay-mini-close');
            if (closeBtn) {
                closeBtn.addEventListener('click', () => {
                    if (options.cancel && typeof options.cancel === 'function') {
                        const res = options.cancel(currentIdx, container);
                        if (res !== false) layer.close(currentIdx);
                    } else {
                        layer.close(currentIdx);
                    }
                });
            }

            // 绑定按钮点击事件
            const buttons = container.querySelectorAll('.lay-mini-btn');
            buttons.forEach(btn => {
                btn.addEventListener('click', function () {
                    const btnIdx = parseInt(this.getAttribute('data-index'));
                    let callback;
                    if (btnIdx === 0) {
                        callback = options.yes;
                    } else if (btnIdx === 1) {
                        callback = options.btn2 || options.cancel;
                    } else if (btnIdx === 2) {
                        callback = options.btn3;
                    }

                    if (callback && typeof callback === 'function') {
                        // 在 prompt 中，第一个参数通常是输入的 value
                        const promptInput = container.querySelector('.lay-mini-prompt-input');
                        const val = promptInput ? promptInput.value : undefined;
                        
                        let res;
                        if (val !== undefined) {
                            res = callback(val, currentIdx, container);
                        } else {
                            res = callback(currentIdx, container);
                        }
                        
                        if (res !== false) {
                            layer.close(currentIdx);
                        }
                    } else {
                        layer.close(currentIdx);
                    }
                });
            });

            return currentIdx;
        },

        /**
         * 弹出一个提示框，只有一个确认按钮
         * @param {string} content 提示内容
         * @param {Object|Function} options 配置项或确定按钮回调
         * @param {Function} yes 确定按钮回调
         * @returns {number} 弹窗索引
         */
        alert: function (content, options, yes) {
            if (typeof options === 'function') {
                yes = options;
                options = {};
            }
            options = options || {};
            return this.open({
                content: content,
                title: options.title !== undefined ? options.title : '提示',
                icon: options.icon,
                shadeClose: options.shadeClose !== undefined ? options.shadeClose : true,
                btn: options.btn || ['确定'],
                yes: yes
            });
        },

        /**
         * 弹出一个确认框，支持最多三个按钮的回调
         * @param {string} content 提示内容
         * @param {Object|Function} options 配置项或第一个按钮回调
         * @param {Function} yes 第一个按钮回调
         * @param {Function} cancel 第二个按钮回调
         * @param {Function} third 第三个按钮回调
         * @returns {number} 弹窗索引
         */
        confirm: function (content, options, yes, cancel, third) {
            if (typeof options === 'function') {
                third = cancel;
                cancel = yes;
                yes = options;
                options = {};
            }
            options = options || {};
            return this.open({
                content: content,
                title: options.title !== undefined ? options.title : '确认',
                icon: options.icon !== undefined ? options.icon : 3,
                shadeClose: options.shadeClose !== undefined ? options.shadeClose : false,
                btn: options.btn || ['确定', '取消'],
                yes: yes,
                btn2: cancel,
                btn3: third
            });
        },

        /**
         * 弹出输入框
         * @param {Object} options 配置项
         * @param {Function} yes 确定按钮回调
         * @returns {number} 弹窗索引
         */
        prompt: function (options, yes) {
            options = options || {};
            const formType = options.formType || 0;
            const value = options.value || '';
            const placeholder = options.placeholder || '';

            let inputHtml = '';
            if (formType === 2) {
                inputHtml = `<textarea class="lay-mini-prompt-input" rows="4" placeholder="${placeholder}">${value}</textarea>`;
            } else {
                const inputType = formType === 1 ? 'password' : 'text';
                inputHtml = `<input type="${inputType}" class="lay-mini-prompt-input" value="${value}" placeholder="${placeholder}" />`;
            }

            return this.open({
                title: options.title !== undefined ? options.title : '输入',
                content: inputHtml,
                shadeClose: false,
                btn: options.btn || ['确定', '取消'],
                yes: function (val, index, layero) {
                    if (yes) yes(val, index, layero);
                }
            });
        },

        /**
         * 关闭指定索引的弹窗
         * @param {number} index 弹窗索引
         */
        close: function (index) {
            const active = activeLayers[index];
            if (!active) return;

            const shade = active.shade;
            const container = active.container;

            // 触发淡出与收缩动画
            shade.classList.remove('lay-show');
            container.classList.remove('lay-show');

            // 动画结束后移除 DOM 并清理缓存
            setTimeout(() => {
                if (shade.parentNode) shade.parentNode.removeChild(shade);
                if (container.parentNode) container.parentNode.removeChild(container);
                delete activeLayers[index];
            }, 200);
        },

        /**
         * 关闭所有弹窗
         */
        closeAll: function () {
            Object.keys(activeLayers).forEach(idx => {
                layer.close(idx);
            });
        }
    };

    window.layer = layer;
})(window);