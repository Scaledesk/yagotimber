/*
*	@package MicroSlider	-- A super lightweight slider plugin for jQuery
*	@version 1.0
*	@author	 Micro Mao <http://weibo.com/u/2782246567/   @代码诗人小毛>
*/
;(function(){
	jQuery.fn.Microslider = function(opt){
		var def = {
			content:'#id-xm-content',			//内容ID
			control:'#id-xm-control',			//控制ID
			slider:'#id-xm-slider',				//滑动ID
			speed:350,							//轮转速度
			pace:5000,							//频率
			width:960
		};
		def = jQuery.extend({},def,opt);
		var num = jQuery(def.content).find('li').length;
		var cur = 0;
		var timer = setInterval(function(){_animate();},def.pace);
		jQuery(def.control).find('li').not(def.slider).each(function(i){
			jQuery(this).bind('mouseover',function(){
				cur = i;
				var pos = jQuery(this).position();
				_pause();
				jQuery(def.slider).stop().animate({left:pos.left},def.speed,function(){
					_continue();
				});
				jQuery(def.content).stop().animate({left:-def.width*i},def.speed);
			});
		});
		function _pause(){clearInterval(timer);}
		function _animate(){
			var next = (++cur)%num;
			var pos = jQuery(def.control).find('li').eq(next).position();
			jQuery(def.slider).stop().animate({left:pos.left},def.speed);
			jQuery(def.content).stop().animate({left:-def.width*next},def.speed);
		}
		function _continue(){timer = setInterval(function(){_animate();},def.pace);}
	}
})(jQuery);