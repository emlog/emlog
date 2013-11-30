var movingEyes = {
	MAX_DIST : 11,//最大移动距离
	EYE_RADIUS : 15,//眼睛半径
	PUPIL_RADIUS : 5,//眼珠半径
	pupils : [$("#movingEye1"),$("#movingEye2")],//眼珠对象
	//初始化
	init : function() {
		$(document).mousemove(movingEyes.moveEyes);//绑定鼠标移动事件
	},
	//动眼函数
	moveEyes : function(e) {
		if (!e) e = window.event;
		var app = movingEyes;
		for (var i = 0; i < app.pupils.length; i++) {//对每个眼睛进行循环
			var pupil = app.pupils[i];
			// 获取眼睛中心
			var midx = pupil.parent().offset().left + app.EYE_RADIUS;
			var midy = pupil.parent().offset().top + app.EYE_RADIUS;
			// 页面滚动距离
			var scrollx = 0;
			var scrolly = 0;
			if (typeof(window.pageXOffset) == 'number') {
				scrollx = window.pageXOffset;
				scrolly = window.pageYOffset;
			} else {
				scrollx = document.documentElement.scrollLeft;
				scrolly = document.documentElement.scrollTop;
			}
			// 眼睛中心到鼠标的偏移
			var distX = e.clientX + scrollx - midx;
			var distY = e.clientY + scrolly - midy;
			// 眼睛中心到鼠标位置的距离
			var dist = Math.sqrt(Math.pow(distX, 2) + Math.pow(distY, 2));
			if (dist > app.MAX_DIST) {
				// 鼠标在眼睛外面，则按比例放缩将眼珠放在眼睛内
				var scale = app.MAX_DIST / dist;
				distX *= scale; distY *= scale;
			}
			// 设置眼珠新位置
			pupil.css({left:parseInt(distX + app.EYE_RADIUS - app.PUPIL_RADIUS) + "px",top:parseInt(distY + app.EYE_RADIUS - app.PUPIL_RADIUS) + "px"});
		}
	}
};
movingEyes.init();
$(".logo").click(function(){
	window.location.href = "http://" + document.location.host;
});