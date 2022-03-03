islogin = 0;


function checkcookie() {
    if (document.cookie.indexOf('qr_u=') >= 0) {
        islogin = 1;
        return true;
    }
    return false;
}
checkcookie();

$(function() {
    // drop-down
    $(".drop-down").hover(function() {
        $(this).find(".drop-title").addClass("drop-title-hover");
        $(this).find(".drop-box").show();
    }, function() {
        $(this).find(".drop-title").removeClass("drop-title-hover");
        $(this).find(".drop-box").hide();
    });

    // 上传图片
    layui.use('upload', function(){
        var upload = layui.upload;
        upload.render({
            elem: '.head_photo', 
            url: maccms.base_url + '/index.php/user/portrait',
            field:'file',
            done: function(res) {
                if (res.code == 1) {
                    res.msg && alert(res.msg);
                    location.reload();
                }
            }
            ,error: function(){
                
            }
        });
    });

    // 移动端语言切换下拉框
    layui.use('dropdown',function(){
        var dropdown = layui.dropdown
        dropdown.render({
            elem:'.change_lang_mobile',
            data:[
                {
                    title:'简体中文',
                    templet:'<div class="lang" data-lang="cn"><img class="lang-img" src="' + maccms.path_tpl + '/images/pro/lang-zh.png"><span class="lang-txt" data-lang="string_lang_zh">简体中文</span></div>',
                    lang:'cn',
                    id:1,
                    src: maccms.path_tpl + '/images/pro/lang-zh.png',
                    href:'#'
                },
                {
                    title:'English',
                    lang:'en',
                    templet:'<div class="lang" data-lang="en"><img class="lang-img" src="' + maccms.path_tpl + '/images/pro/lang-en.png"><span class="lang-txt" data-lang="string_lang_en">English</span></div>',
                    id:2,
                    src: maccms.path_tpl + '/images/pro/lang-en.png',
                    href:'#'
                },
            ],
            click:function(data,othis){
                let lang=data.lang
                let new_lang=''
                if(lang == 'en'){
                    new_lang = 1;
                }else{
                    new_lang = 0;
                }
                localStorage.setItem('lang',new_lang)
                localStorage.setItem('langSrc',data.src)
                $('.no-lang').hide()
                $('.has-lang').show()
                $('.has-lang').attr('src',localStorage.getItem('langSrc'))
                language_pack.loadProperties(new_lang);
            }
        })
    })
});

$(document).ready(function() {
    // ui-input
    $(".ui-input").focus(function() {
        $(this).addClass("ui-input-focus");
    }).hover(function() {
        $(this).addClass("ui-input-hover");
    }, function() {
        $(this).removeClass("ui-input-hover");
    });
    $(".ui-input").blur(function() {
        $(this).removeClass("ui-input-focus");
    });

    // ui-form-placeholder
    $(".ui-form-placeholder").each(function() {
        var _label = $(this).find(".ui-label");
        var _input = $(this).find(".ui-input");
        var _text = $(this).find(".ui-input").val();

        if (_text != "") {
            _label.hide();
        }

        _label.css("z-index", "3");
        _label.click(function() {
            $(this).hide();
            _input.focus();
        });
        _input.focus(function() {
            _label.hide();
        });
    });

    // ui-button
    $(".ui-button").hover(function() {
        $(this).addClass("ui-button-hover");
    }, function() {
        $(this).removeClass("ui-button-hover");
    });

    // close-his	
    $(".close-his").click(function() {
        $(this).parents(".drop-box").hide();
    });

    // show-tipinfo
    $(".show-tipinfo a").hover(function() {
        $(this).parent().parent().find(".tipInfo").show();
    }, function() {
        $(this).parent().parent().find(".tipInfo").hide();
    });

    $("#wish").trigger('click');



    // timeinfo
    $(".timeinfo").hover(function() {
        $(this).addClass("timeinfo-active");
    }, function() {
        $(this).removeClass("timeinfo-active");
    });

    // Date List Jquery
    $(".date-list").each(function() {
        $lis = $(this).find("li:last").index();
        if ($lis > 5) {
            $(this).addClass("date-long");
        }
    });


});

// Tab Menu JS Common
function setTab(name, cursel, n) {
    for (i = 1; i <= n; i++) {
        var menu = document.getElementById(name + i);
        var con = document.getElementById("con_" + name + "_" + i);
        if(i == cursel){
            $(menu).addClass('current')
            $(con).show()
        }else{
            $(menu).removeClass('current')
            $(con).hide()
        }
    }
}

function checkcookie() {
    if (document.cookie.indexOf('baient_pro=') >= 0) {
        islogin = 1;
        return true;
    }
    return false;
}
function qrsearch(){
    var W = $(window).width();
    if(W > 820){
        if($("#wd").val()=='请在此处输入影片片名或演员名称。'||$("#wd").val()==''){
            $("#wd").val('');
            $("#wd").focus();
        }else{
            document.location = MAC_PATH + 'index.php/vod/search.html?wd='+ encodeURIComponent($("#wd").val())+"";
        }
        return false;
    }else{
        if($("#wd").val()=='请在此处输入影片片名或演员名称。'||$("#wd").val()==''){
            $("#wd").val('');
            $("#wd").focus();
        }else{
            document.location = MAC_PATH + 'index.php/vod/search.html?wd='+ encodeURIComponent($("#wd").val())+"";
        }
        return false; 
    }
}
checkcookie();
$(document).ready(function() {
    // Baby Time Step A Tips
    $(".play-mode-list a").each(function(j, div) {
        $(this).click(function() {
            //$("html,body").animate({scrollTop:$("#"+listid).offset().top}, 500); //我要平滑
            if ($(this).parent().hasClass("current")) {
                return;
            }
            var txt = $(this).attr("title").split('-');
            $(".detail-pic .text").text(txt[1]);
            var listid = $(this).attr("id") + '-list';
            if (listid != 'bdhd-pl-list' && listid != 'qvod-pl-list') {
                $('#' + listid + ' .txt').text('( 无需安装任何插件，即可快速播放 )');
            }
            $(this).parent().nextAll().removeClass("current");
            $(this).parent().prevAll().removeClass("current");
            $(this).parent().addClass("current")
            $('.play-list-box').hide().css("opacity", 0);

            $('.play-list-box:eq(' + j + ')').show().animate({ "opacity": "1" }, 1200);
        });
    });
    //order
    $('#detail-list .order a').click(function() {
        if ($(this).hasClass('asc')) {
            $(this).removeClass('asc').addClass('desc').text('降序');
        } else {
            $(this).removeClass('desc').addClass('asc').text('升序');
        }
        var a = $('.play-list-box:eq(' + $(this).attr('data') + ') .play-list');
        var b = $('.play-list-box:eq(' + $(this).attr('data') + ') .play-list a');
        a.html(b.get().reverse());
    });


});

function intval(v) {
    v = parseInt(v);
    return isNaN(v) ? 0 : v;
}
// 获取元素信息
function getPos(e) {
    var l = 0;
    var t = 0;
    var w = intval(e.style.width);
    var h = intval(e.style.height);
    var wb = e.offsetWidth;
    var hb = e.offsetHeight;
    while (e.offsetParent) {
        l += e.offsetLeft + (e.currentStyle ? intval(e.currentStyle.borderLeftWidth) : 0);
        t += e.offsetTop + (e.currentStyle ? intval(e.currentStyle.borderTopWidth) : 0);
        e = e.offsetParent;
    }
    l += e.offsetLeft + (e.currentStyle ? intval(e.currentStyle.borderLeftWidth) : 0);
    t += e.offsetTop + (e.currentStyle ? intval(e.currentStyle.borderTopWidth) : 0);
    return { x: l, y: t, w: w, h: h, wb: wb, hb: hb };
}
// 获取滚动条信息
function getScroll() {
    var t, l, w, h;
    if (document.documentElement && document.documentElement.scrollTop) {
        t = document.documentElement.scrollTop;
        l = document.documentElement.scrollLeft;
        w = document.documentElement.scrollWidth;
        h = document.documentElement.scrollHeight;
    } else if (document.body) {
        t = document.body.scrollTop;
        l = document.body.scrollLeft;
        w = document.body.scrollWidth;
        h = document.body.scrollHeight;
    }
    return { t: t, l: l, w: w, h: h };
}
// 锚点(Anchor)间平滑跳转
function scroller(el, duration) {
    if (typeof el != 'object') {
        el = document.getElementById(el);
    }
    if (!el) return;
    var z = this;
    z.el = el;
    z.p = getPos(el);
    z.s = getScroll();
    z.clear = function() {
        window.clearInterval(z.timer);
        z.timer = null
    };
    z.t = (new Date).getTime();
    z.step = function() {
        var t = (new Date).getTime();
        var p = (t - z.t) / duration;
        if (t >= duration + z.t) {
            z.clear();
            window.setTimeout(function() { z.scroll(z.p.y, z.p.x) }, 13);
        } else {
            st = ((-Math.cos(p * Math.PI) / 2) + 0.5) * (z.p.y - z.s.t) + z.s.t;
            sl = ((-Math.cos(p * Math.PI) / 2) + 0.5) * (z.p.x - z.s.l) + z.s.l;
            z.scroll(st, sl);
        }
    };
    z.scroll = function(t, l) { window.scrollTo(l, t) };
    z.timer = window.setInterval(function() { z.step(); }, 13);
}


// 多语言
const language_pack = {
	now_lang : 0, // 0:ch,1:en
	loadProperties : function(new_lang){
		var self = this;
		var tmp_lang = '';
		if(new_lang == 0 || !new_lang){
			tmp_lang = 'zh';
			$('body').removeClass('en').addClass('zh');
            $.cookie("langType", 0,{ path: '/' });
		}else{
			tmp_lang = 'en';
			$('body').removeClass('zh').addClass('en');
            $.cookie("langType", 1,{ path: '/' });
		}
		jQuery.i18n.properties({
			name: 'strings', 
			path: maccms.path_tpl + '/asset/language/',
			language: tmp_lang,
			cache: false,
			mode:'map', 
			callback: function() {
				for(var i in $.i18n.map){
                    // 语言
					$('[data-lang="'+i+'"]').text($.i18n.map[i]);
                    // 自定义属性
                    $('[data-title="'+i+'"]').attr('title',$.i18n.map[i])
                    // placehoder
                    $('[data-placeholder="'+i+'"]').attr('placeholder',$.i18n.map[i])
                    // value
                    $('[data-value="'+i+'"]').attr('value',$.i18n.map[i])
				}
				// document.title = $.i18n.map[i];
			}
		});
		self.now_lang = new_lang;
	}
}

$(document).ready(function(){
    let baseLang
    if(!localStorage.getItem('lang') && localStorage.getItem('lang')!==0 ){
        if (navigator.userLanguage) {  
            baseLang = navigator.userLanguage.substring(0,2).toLowerCase();  
        } else {  
            baseLang = navigator.language.substring(0,2).toLowerCase();  
        } 
        if(baseLang=='zh'){
            localStorage.setItem('lang',0)
            $.cookie("langType", 0,{ path: '/' });
            $('.has-lang').attr('src', maccms.path_tpl + '/images/pro/lang-zh.png')
            localStorage.setItem('langSrc', maccms.path_tpl + '/images/pro/lang-zh.png')
        }else{
            localStorage.setItem('lang',1)
            $.cookie("langType", 1,{ path: '/' });
            $('.has-lang').attr('src', maccms.path_tpl + '/images/pro/lang-en.png')
            localStorage.setItem('langSrc', maccms.path_tpl + '/images/pro/lang-en.png')
        }
    }else{
        language_pack.loadProperties(localStorage.getItem('lang'));
        $('.has-lang').attr('src',localStorage.getItem('langSrc'))
        $('.no-lang').hide()
        $('.has-lang').show()
    }
	$('.lang').click(function(e){
		var new_lang;
        let src=$(this).children('.lang-img').attr('src')
        $('.has-lang').attr('src',src)
        $('.no-lang').hide()
        $('.has-lang').show()
		if($($(this)[0]).attr('data-lang') == 'en'){
            new_lang = 1;
            $('.actor_lang_en').show()
			$('.actor_lang_zh').hide()
		}else{
            new_lang = 0;
            $('.actor_lang_en').hide()
			$('.actor_lang_zh').show()
		}
        localStorage.setItem('lang',new_lang)
        localStorage.setItem('langSrc',src)
		language_pack.loadProperties(new_lang);
	});
    // 鼠标移上去VIP图标隐藏
    $('.vod_info').mouseover(function(e){
        $(this).addClass('vod_show')
        $(this).parent().find('.vod_vip').hide()
    })
    $('.vod_info').mouseout(function(e){
        $(this).removeClass('vod_show')
        $(this).parent().find('.vod_vip').show()
    })
    // 鼠标移上去的效果
    $('.vod_info').mouseover(function(e){
		if($(window).width()>=820){
			$(this).addClass('vod_show')
            $(this).parent().find('.vodlist_thumb').find('.vod_vip ').hide()
		}
    })
    $('.vodlist_thumb').mouseover(function(e){
		if($(window).width()>=820){
        	$('vod_info').addClass('vod_show')
		}
    })
    $('.vod_info').mouseout(function(e){
        $(this).removeClass('vod_show')
        $(this).parent().find('.vodlist_thumb').find('.vod_vip ').show()
    })

    // 首页轮播开始
    let bannerNum=$('.51buypic').children().length
    for(var i=0;i<bannerNum;i++){
        $('.banner-num').append(`<li class="banner-li banner-active${i}"></li>`)
    }
    function initbanner(){
        $('.51buypic').children().each(function(index,element){
            if(index==0){
                $(element).addClass('show-banner')
                $(element).removeClass('hide-banner')
                $(element).show()
                $('.banner-active'+index).addClass('show-tab')
            }else{
                setTimeout(()=>{
                    $(element).hide()
                },500)
                $(element).removeClass('show-banner')
                $(element).addClass('hide-banner')
                $('.banner-active'+index).removeClass('show-tab')
            }
        })
    }
    initbanner()
    let slideIndex=0
    function changeBanner(){
        $('.51buypic').children().each(function(index,element){
            if(index==slideIndex){
                $(element).show()
                $(element).addClass('show-banner')
                $(element).removeClass('hide-banner')
                $('.banner-active'+index).addClass('show-tab')
            }else{
                setTimeout(()=>{
                    $(element).hide()
                },500)
                $(element).removeClass('show-banner')
                $(element).addClass('hide-banner')
                $('.banner-active'+index).removeClass('show-tab')
            }
        })
    }
    setInterval(()=>{
        if(slideIndex<bannerNum){
            changeBanner()
            slideIndex+=1
        }else{
            slideIndex=0
            initbanner()
        }
    },5000)
    $('.banner-li').click(function(){
        let allClass=$(this).attr('class')
        let str=allClass.split(" ")[1]
        if(slideIndex==Number(str.charAt(str.length-1)))return
        if(!$(this).hasClass('show-tab')){
            slideIndex=Number(str.charAt(str.length-1))
            $(this).addClass('show-tab')
            changeBanner()
        }else{
            $(this).removeClass('show-tab')
        }
    
    })
    // 首页轮播结束


    // 个人中心列没有时，屏蔽操作条
    if($('.data__list').find('li').length<=0 ){
        $('.gong').hide()
    }

    
});



