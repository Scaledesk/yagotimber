!function(a,b){"use strict";a.fn.imgLazyLoad=function(c){var d=this,e=a.extend({container:b,effect:"fadeIn",speed:600,delay:400,callback:function(){}},c),f=a(e.container),g=function(){if(!d.length)return f.off("scroll.lazyLoad");var c=f.outerHeight(),g=f.scrollTop();e.container!==b&&(g=f.offset().top),d.each(function(){var b=a(this),f=b.offset().top;if(g+c>f&&f+b.outerHeight()>g){d=d.not(b);var h=b.attr("data-src");a(new Image).prop("src",h).load(function(){b.hide().attr("src",h)[e.effect](e.speed,function(){e.callback.call(this)}).removeAttr("data-src")})}})},h=function(a,b){if(!b)return a;var c;return function(){clearTimeout(c),c=setTimeout(function(){a()},b)}};if(!f.length)throw e.container+" is not defined";return g(),f.on("scroll.imgLazyLoad",h(g,e.delay)),this}}(jQuery,window);