var TplConfigEx = {
	'Browser': {
		url: document.URL,
		domain: document.domain,
		title: document.title,
		urlpath: document.location.pathname,
		language: (navigator.browserLanguage || navigator.language).toLowerCase(),
		canvas: function() {
			return !!document.createElement("canvas").getContext
		}(),
		useragent: function() {
			var a = navigator.userAgent;
			return {
				mobile: !! a.match(/AppleWebKit.*Mobile.*/),
				ios: !! a.match(/\(i[^;]+;( U;)? CPU.+Mac OS X/),
				android: -1 < a.indexOf("Android") || -1 < a.indexOf("Linux"),
				iPhone: -1 < a.indexOf("iPhone") || -1 < a.indexOf("Mac"),
				iPad: -1 < a.indexOf("iPad"),
				trident: -1 < a.indexOf("Trident"),
				presto: -1 < a.indexOf("Presto"),
				webKit: -1 < a.indexOf("AppleWebKit"),
				gecko: -1 < a.indexOf("Gecko") && -1 === a.indexOf("KHTML"),
				weixin: -1 < a.indexOf("MicroMessenger")
			}
		}()
	},
	'Cookie': {
		'Set':function(name,value,days){
	        var expires;
	        if (days) {
	            expires = days;
	        } else{
	            expires = "";
	        }
	        $.cookie(name,value,{expires:expires,path:'/'});
		},
		'Get':function(name){
			var styles = $.cookie(name);
		    return styles;
		},
		'Del':function(name){
	        $.cookie(name,null,{expires:-1,path: '/'});
		}
	},
	'History': {
		'Limit':12,
        'Days':7,
		'Json':'',
		'Init':function(){
			var get_history = TplConfigEx.Cookie.Get("history");
			if(get_history){
				var json=eval("("+get_history+")");
				var list="";
				for(i=0;i<json.length;i++){
					list = list + '<li class="vodlist_item"><a href="'+json[i].link+'" title="'+json[i].name+'"><div class="vodlist_thumb" style="background-image:url('+json[i].pic+')"><span class="pic_text text_right">观看至'+json[i].part+'</span></div><div class="vodlist_titbox"><p class="vodlist_title">'+json[i].name+'</p></div></a></li>';
				}
				$("#tplconfig_history").append(list);
				$(".tplconfig_history_title").prepend('<a class="clean_history" target="_self" href="javascript:void(0)" onclick="TplConfigEx.History.Clear();">清空</a>');
			}else{
				$("#tplconfig_history").append('<li class="tplconfig_history_no"> <div class="nodata-img"></div> <i class="iconfont"></i>暂无观看记录<p class="user_log_tips"> <a class="mac_user" href="javascript:void(0)">登录查看更多</a></p></li>');
				// <a class="mac_user" href="javascript:void(0)">登录查看更多</a></p></li>
			}
			if($.cookie('user_id')){
				$('.user_log_tips').hide()
			}else{
				$('.user_log_tips').show()
			}
			$('.history').click(function(){
				$('html,body').addClass("overhidden");
				$('.tplconfig_history_bg').addClass("hfixed");
				$("body").append('<div class="mac_pop_bg"></div>');
				$("#close_history").click(function(){
					$(".tplconfig_history_bg").removeClass("hfixed");
					$('html,body').removeClass("overhidden");
					$('.mac_pop_bg').remove();
				});
				$('.mac_user').click(function(){
					location.href='/user/login.html'
					console.log(location)
				});
			});
			if($(".hl_history").length){
	            var $that = $(".hl_history");
	            TplConfigEx.History.Set($that.attr('data-name'),$that.attr('data-link'),$that.attr('data-pic'),$that.attr('data-part'));
	        }
		},
		'Set':function(name,link,pic,part){
			if(!link){ link = document.URL;}
			var history = TplConfigEx.Cookie.Get("history");
			var len=0;
			var canadd=true;
			if(history){
			   history = eval("("+history+")"); 
			   len=history.length;
			   $(history).each(function(){
			      if(name===this.name){
			         canadd=false;
			         var json="[";
			         $(history).each(function(i){
			            var temp_name,temp_pic,temp_url,temp_part;
			            if(this.name===name){
			                 temp_name=name;temp_pic=pic;temp_url=link;temp_part=part;
			            }else{
			                 temp_name=this.name;temp_pic=this.pic;temp_url=this.link;temp_part=this.part;
			            }
			            json+="{\"name\":\""+temp_name+"\",\"pic\":\""+temp_pic+"\",\"link\":\""+temp_url+"\",\"part\":\""+temp_part+"\"}";
			            if(i!==len-1){
							json+=",";
						} 
			          });
			          json+="]";
			          TplConfigEx.Cookie.Set('history',json,this.Days);
			          return false;
			        }
			    });
			}
			if(canadd){
			    var json="[";
			    var isfirst="]";
			    isfirst=!len?"]":",";
			    json+="{\"name\":\""+name+"\",\"pic\":\""+pic+"\",\"link\":\""+link+"\",\"part\":\""+part+"\"}"+isfirst;
			     if(len>this.Limit-1){
					len-=1;
				 }   	
		        for(i=0;i<len-1;i++){
		            json+="{\"name\":\""+history[i].name+"\",\"pic\":\""+history[i].pic+"\",\"link\":\""+history[i].link+"\",\"part\":\""+history[i].part+"\"},";
		       	}
		        if(len>0){
		            json+="{\"name\":\""+history[len-1].name+"\",\"pic\":\""+history[len-1].pic+"\",\"link\":\""+history[len-1].link+"\",\"part\":\""+history[len-1].part+"\"}]";
		        }
			    TplConfigEx.Cookie.Set('history',json,this.Days);
			}  
		},
		'Clear': function(){
            TplConfigEx.Cookie.Del('history');
            $("#tplconfig_history").empty();
			$(".tplconfig_history_box").html('<div class="tplconfig_history_clear">已清空观看记录</div>');
        },
	},
	'Shows':{
		'Text': function() {
			showdiv = function(obj) {
				var x = obj.parentNode;
				var y = x.nextSibling;
				if (y.nodeType !== 1) {
					y = y.nextSibling;
				}
				y.style.display = "block";
				x.style.display = "none";
			}

			hidediv = function(obj) {
				var y = obj.parentNode;
				var x = y.previousSibling;
				if (x.nodeType !== 1) {
					x = x.previousSibling;
				}
				y.style.display = "none";
				x.style.display = "block";
			}
			$.each($(".context span"), function (i) {
				if ($('.context span').eq(i).height() > 50) {
					$('.context span').eq(i).next().css('display', 'block');
				} else {
					$('.context span').eq(i).next().css('display', 'none');
				}
			});
		},
		'List': function() {
			showlist = function() {
				$('.playlist_notfull,.listshow').css('display', 'none');
				$('.playlist_full').css('display', 'block');
			};
			hidelist = function() {
				$('.playlist_notfull').css('display', 'block');
				$('.playlist_full').css('display', 'none');
			};
			$.each($("#playlistbox li"), function () {
				var Lnum = document.getElementById('playlistbox').getElementsByTagName("li").length;
				var W = $(window).width();
				if (W > 820) {
					if (Lnum > 24) {
						$('.playlist_full').css('display', 'none');
					}else{
						$('.playlist_notfull,.listshow').css('display', 'none');
						$('.playlist_full').css('display', 'block');
					}
				}else{
                    $('.playlist_notfull,.listshow').css('display', 'none');
                    $('.playlist_full').css('display', 'block');
                }
			});

		}

	 },
	'Notice':function(){
		var tips_title = $("#tips_title").val();
		var tips_text = $("#tips_text").val();
		let lang=localStorage.getItem('lang')
		if(TplConfigEx.Cookie.Get('hl_notice')===null && tips_text ){
			$("body").append('<div class="hl_wrap"><div class="hl_content gonggao hl_notice"><div class="hl_content_hd "><h4 class="hl_content_title">' + tips_title + '</h4></div><div class="hl_content_bd">' + tips_text + '</div><div class="hl_content_ft"><a class="hl_btn_no" href="javascript:;">'+(lang==1?'I got it':'我知道了')+'</a><a class="close_box" href="javascript:;">取消</a></div></div></div>');setTimeout(function(){$(".hl_notice").addClass("hl_show");$(".hl_wrap").prepend('<div class="mac_pop_bg"></div>');$(".mac_pop_bg").click(function() {$(".hl_wrap").remove();});}, 100);
			$(".hl_btn_no").click(function() {
				TplConfigEx.Cookie.Set('hl_notice','ok',1);
				$(".hl_wrap").remove();
			});
			$(".close_box,.hl_btn_no").click(function() {
				$(".hl_wrap").remove();
			});
		}
	}
};

$(function(){
	TplConfigEx.History.Init();
	TplConfigEx.Shows.Text();
	TplConfigEx.Shows.List();
});


