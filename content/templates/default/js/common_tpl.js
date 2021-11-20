  "use strict"

/**
 * jqurey添加动画扩展，先加速度至配速的50%，再减速到零
 */
 jQuery.extend( jQuery.easing,
{
    easeInOut: function (x, t, b, c, d) {
      if ((t/=d/2) < 1) return c/2*t*t + b
      return -c/2 * ((--t)*(t-2) - 1) + b
    }
})

var myBlog = {
    /**
     * 初始化
     */
    init : function(){
      this.tocAnalyse()  // toc目录生成
      if ($("#comment-info").length == 0) {  // 大屏幕登录状态，评论框下两角变圆角 
        $(".commentform #comment").css("height","140px")
                                  .css('border-radius', '10px')
      }
      $(".markdown img").attr("data-action","zoom")  // 为摘要、文章、页面中图片添加“查看大图”
                        .parent().removeAttr("href")
                        .parent("p").css("text-align","center")
      //$("#commentform").attr("onsubmit","return myBlog.comSubmitTip()")  // 评论提交在表单验证未通过的情况下是不能提交的
    },
    /**
     * 回复
     */
    comReply : function($t) {
      var $ele,getpid,$com_board
      $ele        = $t.parent().parent()
      getpid      = $ele.parent().attr("id").substring(8)
      $com_board  = $("#comment-post")

      $ele.append($com_board)
      $("#comment-pid").attr("value",getpid)
      $("#cancel-reply").css("display","unset")
      $("#comment-place").toggleClass("com-bottom")
    },
    /**
     * 取消回复
     */
    cancelReply : function($t) {
      $("#comment-pid").attr("value","0")
      $("#cancel-reply").css("display","none")
      $("#comment-place").append($("#comment-post"))
                         .toggleClass("com-bottom")
    },
    /**
     * 手机点击展开导航按钮
     */
    navToggle : function($t) {
      var time,effect,$navbar,$nav_c,nav_height
      time       = 'slow'
      effect     = 'easeInOut'
      $navbar    = $("#navbarResponsive")
      $nav_c     = $(".blog-header-c")
      nav_height = ($nav_c.height() == 74) ? $navbar.height() + 74 : 74

      $nav_c.animate({height:nav_height+'px'},time,effect)
      $navbar.slideToggle(time,effect)
    },
    /**
     * 定位大屏状态下的导航下拉框位置
     */
    calMargin : function($t) {
      if (window.outerWidth < 992) return
      console.log('hover')
      var $fatherLink,$childMenu,menuWidth,count

      menuWidth     = 135  // 大屏幕端的子导航下拉框宽度(px)，可根据需要修改
      count         = ($t.outerWidth() - menuWidth)/2 + "px"
      $childMenu    = $t.siblings('.dropdown-menus')

      $childMenu.css("width",menuWidth + "px")
                .css("margin-left",count)
    },
    /**
     * 提交评论前对表单的验证
     */
    comSubmitTip : function($t) {
      return true
    },
    /**
     * 显示(隐藏)验证码模态窗
     */
    viewModal : function() {
      var $modal,$lock
      $modal  = $(".modal-dialog,.lock-screen")
      $lock   = $(".lock-screen")

      $('body,html').toggleClass('scroll-fix')
      $modal.fadeToggle()
      $("input[name='imgcode']").attr("autocomplete","off")
    },
    /**
     * 点击刷新验证码
     */
    captchaRefresh : function($t) {
      var timestamp = new Date().getTime()
      $t.attr("src", "./include/lib/checkcode.php?" + timestamp)
    },
    /**
     * toc 分析
     * 
     * tip: 在文章最开头单独一行输入[toc]，或者<!--[toc]-->，即可启用
     */
    tocFlag     : /\[toc\]/gi,  // 判断toc是否声明的正则表达式
    tocArray    : new Array(),  // 储存toc的数组
    tocAnalyse  : function() {
      if (window.outerWidth < 1275)       return  // 屏幕小于 1275px  退出  
      if ($("#emlogEchoLog").length == 0) return  // 不在阅读页面  退出
      if (!this.tocFlag.test($('#emlogEchoLog').html().substring(0,30))) return  // 未声明toc标签  退出

      var $logCon   = $(".log-con")
      var logConMar = parseInt($logCon.css("margin-left"))
      var $titles   = $("#emlogEchoLog h1,h2,h3,h4,h5,h6:eq(0)")
      var arr       = this.tocArray
      var tocFlag   = document.querySelector("#emlogEchoLog p")

      tocFlag.innerHTML = tocFlag.innerHTML.replace(this.tocFlag,"")  // 去除toc声明
      if($titles.length > 0){
        $logCon.css("margin-left",logConMar + 150 + 'px')  // 文章正文向右偏移150px
      }else{
        return  // 未发现标题（h标签） 退出
      }
      
      $titles.attr("toc-date","title")
      for(var i = 0 ;i < $titles.length;i++){  // 将标签数据依次存入数组
        let $tit      = $("#emlogEchoLog [toc-date='title']:eq("+ i +")")
        let repeatNum = 
        arr[i]        = new Array()

        arr[i]['type'] = $tit.prop('tagName').substring(1)
        arr[i]['content'] = $tit.text()
        arr[i]['pos'] = $tit.offset().top
        for(var k = 0;k < arr.length - 1;k++){
          if(arr[i]['content'] == arr[k]['content']) repeatNum++
        }
        arr[i]['id'] = $tit.text()+repeatNum
        $tit.attr("id",arr[i]['id'])
      }
      this.tocRender()
    },

    /**
     * toc 目录渲染
     */ 
    tocRender : function()  {
      var tocHtml = ''
      var data    = this.tocArray
      var $logcon = $(".log-con")
      var padNum  = parseInt($logcon.css("margin-left")) - 270
      var judgeN  = 0

      tocHtml = tocHtml + '<div class="toc-con" style="left:'+ padNum +'px" id="toc-con">'   // 渲染
      tocHtml = tocHtml + '<div style="height:calc(100vh - 70px);overflow-y:scroll;" ><lu>'
      for(var i = 0 ;i < data.length ; i++) {
        let k         = 0
        let itemType  = data[i]['type']
        let isPadding = ''
        
        if(itemType != judgeN) isPadding = 'style="padding-top:4px"'
        tocHtml = tocHtml + '<li ' + isPadding + ' id="to' + i + '" >'
        while(k < itemType){
          tocHtml = tocHtml + '&nbsp;&nbsp;&nbsp;&nbsp;'
          k++
        }
        tocHtml = tocHtml + data[i]['content'] + '</li>'
        judgeN = itemType
      }
      tocHtml = tocHtml + '</lu></div></div>'
      $logcon.before(tocHtml)

      for(var i = 0 ;i < data.length ; i++) {  // 批量添加监听事件
        let temp = data[i]["id"]
        $('#to' + i).bind("click",function(){
          window.onscroll = function(){tocSetPos()} 
          $('body,html').animate({scrollTop:$('#' + temp).offset().top - 20},300,function(){
            tocGetPos()
            window.onscroll = function(){tocSetPos();tocGetPos()} 
          })
        })
      }
      function tocSetPos() {  // 判断位置和设置定位样式
        if (document.documentElement.scrollTop > 200) {
          $("#toc-con").css("position","fixed")
                       .css("top","0px")
        }else{
          $("#toc-con").css("position","absolute")
                       .css("top","200px")
        }
      }
      function tocGetPos() {  // 获取位置并改变指定标题颜色
        let $tempItem
        $('#toc-con li').css('color','unset')
        for(var i = 0;i < data.length;i++) {
          let winPos = document.documentElement.scrollTop + 30
          if(winPos > data[i]['pos']) $tempItem = $('#to'+i)
        }
        if($tempItem) $tempItem.css('color','red')
      }
      tocSetPos()
      window.onscroll = function() {  // 滚轮事件
        tocSetPos()
        tocGetPos()
       }
    }
}

/**
 * 监听
 */
$(document).ready(function(){
  myBlog.init()

  $(".com-reply").click(function(){
    myBlog.comReply($(this))
  }),

  $(".cancel-reply").click(function(){
    myBlog.cancelReply($(this))
  }),

  $(".blog-header-toggle").click(function(){
    myBlog.navToggle($(this))
  }),

  $(".has-down").mouseenter(function(){
    myBlog.calMargin($(this))
  }),

  $("#captcha").click(function () {
    myBlog.captchaRefresh($(this))
  }),

  $('#comment_submit[type="button"], #close-modal').click(function () {
    myBlog.viewModal()
  }),

  $(".form-control").blur(function () {
    myBlog.comSubmitTip($(this))
  })
})
