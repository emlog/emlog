"use strict"

/**
 * jquery animation extension. First accelerate to 50%, then decelerate to zero
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
     * Initialization
     */
    init : function(){
      this.tocAnalyse()  // TOC catalog generation
      if ($("#comment-info").length == 0) {  // Large screen login status, the bottom two corners of the comment box are rounded 
        $(".commentform #comment").css("height","140px")
                                  .css('border-radius', '10px')
      }
      for(let num = 0;num < $(".markdown img").length;num++){  // Add the function of viewing the large image in the text (by default, the link in the parent tag <a> of the image is the original address of the image)
        let $this     = $(".markdown img:eq("+ num +")")
        let sourceSrc = $(".markdown img:eq("+ num +")").parent().attr('href')

        $this.attr("data-action","zoom")
             .parent().attr("sourcesrc",sourceSrc)
             .removeAttr("href")
      }
      $("#commentform").attr("onsubmit","return myBlog.comSubmitTip()")  // Comment submission cannot be submitted if the form verification fails
    },
    /**
     * Reply
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
     * Cancel reply
     */
    cancelReply : function($t) {
      $("#comment-pid").attr("value","0")
      $("#cancel-reply").css("display","none")
      $("#comment-place").append($("#comment-post"))
                         .toggleClass("com-bottom")
    },
    /**
     * Click on the mobile phone to expand the navigation button
     */
    navToggle : function($t) {
      var time,effect,$navbar,$nav_c,nav_height
      time       = 'fast'
      effect     = 'easeInOut'
      $navbar    = $("#navbarResponsive")
      $nav_c     = $(".blog-header-c")
      nav_height = ($nav_c.height() == 74) ? $navbar.height() + 74 : 74

      $nav_c.animate({height:nav_height+'px'},time,effect)
      $navbar.slideToggle(time,effect)
    },
    /**
     * Locate the position of the navigation drop-down box in the large screen state
     */
    calMargin : function($t) {
      if (window.outerWidth < 992) return
      var $childMenu,menuWidth,count

      menuWidth     = 135  // The width of the sub-navigation drop-down box on the big screen (px), can be modified as needed
      count         = ($t.outerWidth() - menuWidth)/2 + "px"
      $childMenu    = $t.siblings('.dropdown-menus')

      $childMenu.css("width",menuWidth + "px")
                .css("margin-left",count)
    },
    /**
     * Validation of the form before submitting the comment
     */
    comTip        : '',
    comSubmitTip  : function(value) {
      if(value == 'judge') {
        let cnReg      = /[\u4e00-\u9fa5]/
        let mailReg    = /^[a-z0-9]+([._\\-]*[a-z0-9])*@([a-z0-9]+[-a-z0-9]*[a-z0-9]+.){1,63}[a-z0-9]+$/
        let urlReg     = /[^\s]*\.+[^\s]/

        let isCn       = $('#commentform').attr('is-chinese')
        let comContent = $('#comment').val()
        let mail       = $('#info_m').val()
        let url        = $('#info_u').val()

        if(isCn == 'y' && !cnReg.test(comContent)){
/*vot*/   this.comTip = lang('chinese_must_have')
        }else if(typeof mail !== "undefined" && mail != '' && !mailReg.test(mail)){
/*vot*/   this.comTip = lang('email_invalid')
        }else if(typeof url !== "undefined" && url != '' && !urlReg.test(url)){
/*vot*/   this.comTip = lang('url_invalid')
        }else {
          this.comTip = ''
        }
      }else{
        if(this.comTip != ''){
          alert(this.comTip)
          return false
        }else{
          return true
        }
      }
    },
    /**
     * Show (hide) the verification code modal window
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
     * Click Refresh verification code
     */
    captchaRefresh : function($t) {
      var timestamp   = new Date().getTime()
      $t.attr("src", "./include/lib/checkcode.php?" + timestamp)
    },
    /**
     * When the image is clicked, the thumbnail will be converted to the original image
     */
    toggleImgSrc : function($t) {
      $t.addClass('zoomFocus')
      $t.attr('src2',$t.attr('src'))
      $t.attr('src',$t.parent().attr('sourcesrc'))
    },
    /**
     * toc analysis
     * 
     * Enable toc directory method: write '[toc]' or'<!--[toc]-->' at the beginning of the article, preferably on a single line
     */
    tocFlag     : /\[toc\]/gi,  // Regular expression to determine whether toc is declared
    tocArray    : new Array(),  // Array to store toc
    tocAnalyse  : function() {
      var tocFlag   = document.querySelector("#emlogEchoLog p")

      if ($("#emlogEchoLog").length == 0) return  // Not reading the page, Exit
      if (!this.tocFlag.test($('#emlogEchoLog').html().substring(0,30))) return  // No toc tag declared, Exit
      tocFlag.innerHTML = tocFlag.innerHTML.replace(this.tocFlag,"")  // Remove toc statement
      if (window.outerWidth < 1275)       return  // The screen is smaller than 1275px exit

      var $logCon   = $(".log-con")
      var logConMar = parseInt($logCon.css("margin-left"))
      var $titles   = $("#emlogEchoLog h1,h2,h3,h4,h5,h6:eq(0)")
      var arr       = this.tocArray

      if($titles.length > 0){
        $logCon.css("margin-left",logConMar + 150 + 'px')  // The text of the article is offset 150px to the right
      }else{
        return  // No title found (h tag), Exit
      }
      
      $titles.attr("toc-date","title")
      for(var i = 0 ;i < $titles.length;i++){  // Store the label data in the array one by one
        let $tit      = $("#emlogEchoLog [toc-date='title']:eq("+ i +")")
        arr[i]        = new Array()

        arr[i]['type'] = $tit.prop('tagName').substring(1)
        arr[i]['content'] = $tit.text()
        arr[i]['pos'] = $tit.offset().top
        arr[i]['id'] = $tit.text()
        $tit.attr("id",arr[i]['id'])
      }
      this.tocRender()
    },
    /**
     * toc directory rendering
     */ 
    tocRender : function()  {
      var tocHtml = ''
      var data    = this.tocArray
      var $logcon = $(".log-con")
      var padNum  = parseInt($logcon.css("margin-left")) - 270
      var judgeN  = 0
      var chilPad = 4
      var minType = 6

      for (var i =0;i < data.length; i++){
        if(data[i]['type'] < minType) minType = data[i]['type']
      }
      tocHtml = tocHtml + '<div class="toc-con" style="left:'+ padNum +'px" id="toc-con">'   // Rendering
      tocHtml = tocHtml + '<div style="height:calc(100vh - 70px);overflow-y:scroll;" ><lu>'
      for(var i = 0 ;i < data.length ; i++) {
        let k         = minType
        let itemType  = data[i]['type']
        let isPadding = ''
        let isBold    = ['','']
        
        if(itemType != judgeN) isPadding = 'style="padding-top:' + chilPad + 'px"'
        tocHtml = tocHtml + '<li ' + isPadding + ' id="to' + i + '" title="' + data[i]['content'] + '" >'
        if(itemType == minType) {
          isBold[0] = '<b>'
          isBold[1] = '</b>'
        }
        while(k < itemType){
          tocHtml = tocHtml + '&nbsp;&nbsp;&nbsp;&nbsp;'
          k++
        }
        tocHtml = tocHtml + isBold[0] + data[i]['content'] + isBold[1] + '</li>'
        judgeN = itemType
      }
      tocHtml = tocHtml + '</lu></div></div>'
      $logcon.before(tocHtml)

      for(var i = 0 ;i < data.length ; i++) {  // Add listening events in batches
        let tempPos = data[i]["pos"]
        $('#to' + i).bind("click",function(){
          window.onscroll = function(){tocSetPos()} 
          $('body,html').animate({scrollTop:tempPos},300,function(){
            tocGetPos()
            window.onscroll = function(){tocSetPos();tocGetPos()} 
          })
        })
      }
      function tocSetPos() {  // Determine location and set positioning style
        if (document.documentElement.scrollTop > 200) {
          $("#toc-con").css("position","fixed")
                       .css("top","0px")
        }else{
          $("#toc-con").css("position","absolute")
                       .css("top","200px")
        }
      }
      function tocGetPos() {  // Get the position and change the color of the specified title
        let $tempItem
        $('#toc-con li').css('color','unset').attr('isRed','n')
        for(var i = 0;i < data.length;i++) {
          let winPos = document.documentElement.scrollTop + 30
          if(winPos > data[i]['pos']) $tempItem = $('#to'+i)
        }
        if($tempItem) $tempItem.css('color','red').attr('isRed','y')

        let redScreenPos = $("li[isred='y']").offset().top - document.documentElement.scrollTop
        let tocHeight    = $("#toc-con div").outerHeight()
        let tocPos       = $("#toc-con div").scrollTop()
        if(redScreenPos > tocHeight){  // Adjust the position of the toc scroll bar according to the reading position of the article
          $("#toc-con div").scrollTop($("li[isred='y']").offset().top - tocHeight)
        }else if(redScreenPos < 0){
          $("#toc-con div").scrollTop(tocPos + redScreenPos - (tocHeight/2))
        }else{
          if(redScreenPos > (tocHeight/2)) $("#toc-con div").scrollTop(tocPos + 10)
          if(redScreenPos < (tocHeight/2 - 40)) $("#toc-con div").scrollTop(tocPos - 10)
        }
      }
      tocSetPos()
      window.onscroll = function(){tocSetPos();tocGetPos()}  // Wheel event
      $('#toc-con div').mouseover(function(){  // Adjust the wheel event according to the mouse position
        window.onscroll = function(){tocSetPos()} 
      }).mouseout(function(){
        window.onscroll = function(){tocSetPos();tocGetPos()} 
      })
    }
}

/**
 * Monitor
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
    myBlog.comSubmitTip('judge')
  }),

  $(".markdown img").click(function () {
    myBlog.toggleImgSrc($(this))
  })
})
