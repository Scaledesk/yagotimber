!function(a,b,c,d){"use strict";function f(b,c){this.self=this,this.elem=b,this.$elem=a(b),this.metadata=this.$elem.data("options"),this.options=a.extend({},a.fn[e].default,this.metadata,c),this.lists=a(b).children(this.options.selector)}var e="loadMore";a.extend(f.prototype,{inIt:function(){var a=this;a.lists.length<=a.options.limit?a.Out():a.More(),a.firstLoad=[],a.firstLoad.push(a.lists.splice(0,a.options.limit)),a.show(a.firstLoad[0])},More:function(){var b=this,c=0;a(b.options.loadBtn).on("click",function(){c+=1,b.lists.length&&(b.firstLoad.push(b.lists.splice(0,b.options.load)),b.show(b.firstLoad[c])),0==b.lists.length&&b.Out()})},show:function(b){var c=this;a(b).fadeIn(),c.options.animate&&c.animateCss(c.options.animateIn,b)},Out:function(){var b=this;a(b.options.loadBtn).hide()},animateCss:function(b,c){var d="webkitAnimationEnd mozAnimationEnd MSAnimationEnd oanimationend animationend";a(c).addClass("animated "+b).one(d,function(){a(c).removeClass("animated "+b)})}}),a.fn[e]=function(a){return this.each(function(){new f(this,a).inIt()})},a.fn[e].default={selector:"",limit:3,load:3,loadBtn:"",animate:!0,animateIn:"fadeInUp"}}(jQuery,window,document);