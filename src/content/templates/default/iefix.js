window.onload =  function() {
	/** 通过JS实现:hover类的效果 **/
	var nav_bar = document.getElementById('nav');
	var ul = nav_bar.getElementsByTagName('ul')[0];
	var childs = ul.childNodes;
	for(var index = 0; index < childs.length; index++) {
		if (childs[index].nodeType == 1) {
			childs[index].onmouseover = function()  {
				this.className += ' li-hover';
			};
			childs[index].onmouseout = function()  {
				this.className = this.className.replace(
					new RegExp('(^|\\s+)li-hover(\\s+|$)', 'g'),
					'$1'
				);
			};			
		}
	}
};
