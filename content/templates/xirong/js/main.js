/**
 * 息壤信息咨询服务主题 - 主JavaScript文件
 * 功能：主题切换、导航控制、动画效果、交互增强
 */

(function () {
    'use strict';

    // ============================================
    // 工具函数
    // ============================================

    /**
     * 防抖函数
     */
    function debounce(func, wait) {
        let timeout;
        return function executedFunction(...args) {
            const later = () => {
                clearTimeout(timeout);
                func(...args);
            };
            clearTimeout(timeout);
            timeout = setTimeout(later, wait);
        };
    }

    /**
     * 节流函数
     */
    function throttle(func, limit) {
        let inThrottle;
        return function (...args) {
            if (!inThrottle) {
                func.apply(this, args);
                inThrottle = true;
                setTimeout(() => (inThrottle = false), limit);
            }
        };
    }

    /**
     * 安全地获取DOM元素
     */
    function getElement(selector) {
        return document.querySelector(selector);
    }

    function getElements(selector) {
        return document.querySelectorAll(selector);
    }

    // ============================================
    // 页面加载动画
    // ============================================

    function initPageLoader() {
        const loader = getElement('#page-loader');
        if (!loader) return;

        window.addEventListener('load', () => {
            setTimeout(() => {
                loader.classList.add('hidden');
                // 移除DOM以释放资源
                setTimeout(() => loader.remove(), 300);
            }, 500);
        });
    }

    // ============================================
    // 主题切换系统
    // ============================================

    const ThemeSwitcher = {
        STORAGE_KEY: 'xr-theme',
        themes: ['light', 'dark', 'auto'],

        init() {
            this.themeBtn = getElement('#theme-btn');
            this.themeMenu = getElement('#theme-menu');
            this.themeOptions = getElements('.xr-theme-option');

            if (!this.themeBtn || !this.themeMenu) return;

            this.loadTheme();
            this.bindEvents();
        },

        loadTheme() {
            const savedTheme = localStorage.getItem(this.STORAGE_KEY) || 'auto';
            this.setTheme(savedTheme);
        },

        setTheme(theme) {
            if (!this.themes.includes(theme)) return;

            document.documentElement.setAttribute('data-theme', theme);
            localStorage.setItem(this.STORAGE_KEY, theme);

            // 更新主题菜单选项的激活状态
            this.themeOptions.forEach(option => {
                const optionTheme = option.dataset.theme;
                if (optionTheme === theme) {
                    option.style.backgroundColor = 'var(--color-surface-hover)';
                } else {
                    option.style.backgroundColor = '';
                }
            });
        },

        toggleMenu() {
            const isActive = this.themeMenu.classList.toggle('active');

            if (isActive) {
                // 点击外部关闭菜单
                const closeMenu = (e) => {
                    if (!this.themeBtn.contains(e.target) && !this.themeMenu.contains(e.target)) {
                        this.themeMenu.classList.remove('active');
                        document.removeEventListener('click', closeMenu);
                    }
                };
                setTimeout(() => document.addEventListener('click', closeMenu), 0);
            }
        },

        bindEvents() {
            this.themeBtn.addEventListener('click', () => this.toggleMenu());

            this.themeOptions.forEach(option => {
                option.addEventListener('click', () => {
                    const theme = option.dataset.theme;
                    this.setTheme(theme);
                    this.themeMenu.classList.remove('active');
                });
            });
        }
    };

    // ============================================
    // 导航栏控制
    // ============================================

    const Navigation = {
        init() {
            this.header = getElement('#main-header');
            this.mobileMenuBtn = getElement('#mobile-menu-btn');
            this.mobileMenuOverlay = getElement('#mobile-menu-overlay');
            this.nav = getElement('#main-nav');
            this.navLinks = getElements('.xr-nav-link');

            if (!this.header) return;

            this.lastScrollTop = 0;
            this.scrollThreshold = 100;

            this.bindEvents();
        },

        handleScroll() {
            const scrollTop = window.pageYOffset || document.documentElement.scrollTop;

            // 添加滚动阴影
            if (scrollTop > 10) {
                this.header.classList.add('scrolled');
            } else {
                this.header.classList.remove('scrolled');
            }

            // 滚动时隐藏/显示导航栏
            if (scrollTop > this.scrollThreshold) {
                if (scrollTop > this.lastScrollTop && scrollTop > this.header.offsetHeight) {
                    this.header.classList.add('hidden');
                } else {
                    this.header.classList.remove('hidden');
                }
            }

            this.lastScrollTop = scrollTop <= 0 ? 0 : scrollTop;
        },

        toggleMobileMenu() {
            if (!this.nav || !this.mobileMenuOverlay) return;

            const isActive = this.nav.classList.toggle('active');
            this.mobileMenuOverlay.classList.toggle('active', isActive);
            document.body.style.overflow = isActive ? 'hidden' : '';
        },

        closeMobileMenu() {
            if (!this.nav || !this.mobileMenuOverlay) return;

            this.nav.classList.remove('active');
            this.mobileMenuOverlay.classList.remove('active');
            document.body.style.overflow = '';
        },

        bindEvents() {
            // 滚动事件
            window.addEventListener('scroll', throttle(() => this.handleScroll(), 100));

            // 移动端菜单
            if (this.mobileMenuBtn) {
                this.mobileMenuBtn.addEventListener('click', () => this.toggleMobileMenu());
            }

            if (this.mobileMenuOverlay) {
                this.mobileMenuOverlay.addEventListener('click', () => this.closeMobileMenu());
            }

            // 点击导航链接后关闭移动菜单
            this.navLinks.forEach(link => {
                link.addEventListener('click', () => {
                    this.closeMobileMenu();
                });
            });
        }
    };

    // ============================================
    // 平滑滚动
    // ============================================

    function initSmoothScroll() {
        const links = getElements('a[href^="#"]');

        links.forEach(link => {
            link.addEventListener('click', function (e) {
                const href = this.getAttribute('href');

                // 忽略只有#的链接
                if (href === '#') {
                    e.preventDefault();
                    return;
                }

                const targetId = href.substring(1);
                const target = document.getElementById(targetId);

                if (target) {
                    e.preventDefault();
                    const headerHeight = getElement('#main-header')?.offsetHeight || 72;
                    const targetPosition = target.getBoundingClientRect().top + window.pageYOffset - headerHeight;

                    window.scrollTo({
                        top: targetPosition,
                        behavior: 'smooth'
                    });
                }
            });
        });
    }

    // ============================================
    // 返回顶部按钮
    // ============================================

    const BackToTop = {
        init() {
            this.btn = getElement('#back-to-top');
            if (!this.btn) return;

            this.bindEvents();
        },

        handleScroll() {
            const scrollTop = window.pageYOffset || document.documentElement.scrollTop;

            if (scrollTop > 300) {
                this.btn.classList.add('visible');
            } else {
                this.btn.classList.remove('visible');
            }
        },

        scrollToTop() {
            window.scrollTo({
                top: 0,
                behavior: 'smooth'
            });
        },

        bindEvents() {
            window.addEventListener('scroll', throttle(() => this.handleScroll(), 100));
            this.btn.addEventListener('click', () => this.scrollToTop());
        }
    };

    // ============================================
    // FAQ手风琴
    // ============================================

    function initFAQ() {
        const faqItems = getElements('.xr-faq-item');

        faqItems.forEach(item => {
            const question = item.querySelector('.xr-faq-question');

            if (question) {
                question.addEventListener('click', () => {
                    const isActive = item.classList.contains('active');

                    // 关闭所有其他FAQ
                    faqItems.forEach(otherItem => {
                        if (otherItem !== item) {
                            otherItem.classList.remove('active');
                        }
                    });

                    // 切换当前FAQ
                    item.classList.toggle('active', !isActive);
                });
            }
        });
    }

    // ============================================
    // Footer手风琴（移动端）
    // ============================================

    function initFooterAccordion() {
        if (window.innerWidth > 768) return; // 仅移动端启用

        const columns = getElements('.xr-footer-column');

        columns.forEach(column => {
            const title = column.querySelector('.xr-footer-column-title');

            if (title) {
                title.addEventListener('click', () => {
                    const isActive = column.classList.contains('active');

                    // 关闭所有其他列
                    columns.forEach(otherColumn => {
                        if (otherColumn !== column) {
                            otherColumn.classList.remove('active');
                        }
                    });

                    // 切换当前列
                    column.classList.toggle('active', !isActive);
                });
            }
        });

        // 窗口大小改变时重新初始化
        let resizeTimer;
        window.addEventListener('resize', () => {
            clearTimeout(resizeTimer);
            resizeTimer = setTimeout(() => {
                if (window.innerWidth > 768) {
                    columns.forEach(column => column.classList.remove('active'));
                }
            }, 250);
        });
    }

    // ============================================
    // 模态弹窗
    // ============================================

    const Modal = {
        init() {
            this.triggers = getElements('[data-modal]');
            this.modals = getElements('.xr-modal');

            if (this.triggers.length === 0) return;

            this.bindEvents();
        },

        open(modalId) {
            const modal = getElement(`#modal-${modalId}`);
            if (!modal) return;

            modal.classList.add('active');
            document.body.style.overflow = 'hidden';

            // ESC键关闭
            const closeOnEsc = (e) => {
                if (e.key === 'Escape') {
                    this.close(modal);
                    document.removeEventListener('keydown', closeOnEsc);
                }
            };
            document.addEventListener('keydown', closeOnEsc);
        },

        close(modal) {
            modal.classList.remove('active');
            document.body.style.overflow = '';
        },

        bindEvents() {
            // 打开按钮
            this.triggers.forEach(trigger => {
                trigger.addEventListener('click', (e) => {
                    e.preventDefault();
                    const modalId = trigger.dataset.modal;
                    this.open(modalId);
                });
            });

            // 关闭按钮和覆盖层
            this.modals.forEach(modal => {
                const closeBtn = modal.querySelector('.xr-modal-close');
                const overlay = modal.querySelector('.xr-modal-overlay');

                if (closeBtn) {
                    closeBtn.addEventListener('click', () => this.close(modal));
                }

                if (overlay) {
                    overlay.addEventListener('click', () => this.close(modal));
                }
            });
        }
    };

    // ============================================
    // 简易AOS动画库（自实现）
    // ============================================

    const AOS = {
        elements: [],
        offset: 120,

        init() {
            this.elements = Array.from(getElements('[data-aos]'));
            if (this.elements.length === 0) return;

            this.bindEvents();
            this.check();
        },

        check() {
            this.elements.forEach(element => {
                if (this.isElementInViewport(element)) {
                    element.classList.add('aos-animate');
                }
            });
        },

        isElementInViewport(el) {
            const rect = el.getBoundingClientRect();
            const windowHeight = window.innerHeight || document.documentElement.clientHeight;

            return (
                rect.top <= windowHeight - this.offset &&
                rect.bottom >= 0
            );
        },

        bindEvents() {
            window.addEventListener('scroll', throttle(() => this.check(), 100));
            window.addEventListener('resize', debounce(() => this.check(), 200));
        }
    };

    // ============================================
    // 防XSS：清理输入
    // ============================================

    function sanitizeInput(input) {
        const div = document.createElement('div');
        div.textContent = input;
        return div.innerHTML;
    }

    // ============================================
    // 性能优化：图片懒加载
    // ============================================

    function initLazyLoading() {
        if ('IntersectionObserver' in window) {
            const imageObserver = new IntersectionObserver((entries, observer) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        const img = entry.target;
                        if (img.dataset.src) {
                            img.src = img.dataset.src;
                            img.removeAttribute('data-src');
                        }
                        observer.unobserve(img);
                    }
                });
            });

            const images = getElements('img[data-src]');
            images.forEach(img => imageObserver.observe(img));
        }
    }

    // ============================================
    // 主初始化函数
    // ============================================

    function init() {
        // 页面加载动画
        initPageLoader();

        // 主题切换
        ThemeSwitcher.init();

        // 导航控制
        Navigation.init();

        // 平滑滚动
        initSmoothScroll();

        // 返回顶部
        BackToTop.init();

        // FAQ手风琴
        initFAQ();

        // Footer手风琴
        initFooterAccordion();

        // 模态弹窗
        Modal.init();

        // AOS动画
        AOS.init();

        // 图片懒加载
        initLazyLoading();

        // 性能监控（开发环境）
        if (window.location.hostname === 'localhost' || window.location.hostname === '127.0.0.1') {
            console.log('%c息壤主题已加载', 'color: #0066FF; font-size: 16px; font-weight: bold;');
            console.log('主题版本: 1.0.0');
            console.log('设计: 简约、优雅、高级质感');
        }
    }

    // ============================================
    // 启动应用
    // ============================================

    // DOM加载完成后初始化
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', init);
    } else {
        init();
    }

    // 导出到全局（用于调试）
    window.XRTheme = {
        ThemeSwitcher,
        Navigation,
        BackToTop,
        Modal,
        version: '1.0.0'
    };

})();
