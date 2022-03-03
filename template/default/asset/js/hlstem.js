var tplconfig = {
    browser: {
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
                mobile: !!a.match(/AppleWebKit.*Mobile.*/),
                ios: !!a.match(/\(i[^;]+;( U;)? CPU.+Mac OS X/),
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
    mobile: {
        share: function() {
            $(".open-share").click(function() {
                $('.share-drop-wrap').show()
                $('.dropdown').show()
            })
        }
    },
    swiper: function() {
        $.getScript(maccms.path + "template/default/asset/js/stem/swiper.min.js", function() {
            var windowWidth = $(window).width();
            var effect=windowWidth<=820?'fade':'slide'
            var swiper = new Swiper('.banner-top', {
                effect : 'slide',
                autoplay: false,
                autoplayDisableOnInteraction: false,
                speed:1000,
                loop: true,
                slidesPerView: 5,
                centeredSlides: true,
                mousewheelControl: true,
                prevButton: '.swiper-button-prev',
                nextButton: '.swiper-button-next',
                lazyLoading: true,
                lazyLoadingInPrevNext: true,
                runCallbacksOnInit: false,
                onInit: function() {
                    setTimeout(function() {
                        var Bgimgurl = $(".banner-top .swiper-slide-active a").css("backgroundImage").replace('url(', '').replace(')', '');
                        document.getElementById("bgimage").style.backgroundImage = "url(" + Bgimgurl + ")";
                    }, 1500);
                },
                onSlideChangeStart: function() {
                    var Bgimgurl = $(".banner-top .swiper-slide-active a").css("backgroundImage").replace('url(', '').replace(')', '');
                    document.getElementById("bgimage").style.backgroundImage = "url(" + Bgimgurl + ")";
                },
                breakpoints: {
                    1280: {
                        slidesPerView: 5.5,
                    },
                    1024: {
                        slidesPerView: 4.6,
                    },
                    820: {
                        slidesPerView: 1,
                        spaceBetween: 5
                    },
                }
            });
            var swiper = new Swiper('.banner-wtop', {
                autoplay: 5000,
                autoplayDisableOnInteraction: false,
                loop: true,
                prevButton: '.swiper-button-prev',
                nextButton: '.swiper-button-next',
                pagination: '.swiper-pagination',
                paginationClickable: true,
                onInit: function() {
                    setTimeout(function() {
                        $.adaptiveBackground.run()
                    }, 1500);
                },
            });
            var swiper = new Swiper('.art_banner', {
                autoplay: 5000,
                autoplayDisableOnInteraction: false,
                spaceBetween: 1,
                speed: 1000,
                slidesPerView: 1,
                loop: true,
                prevButton: '.swiper-button-prev',
                nextButton: '.swiper-button-next',
                pagination: '.swiper-pagination',
                paginationClickable: true,
                lazyLoading: true,
                lazyLoadingInPrevNext: true,
            });

            var swiper = new Swiper('.51buypic', {
                effect:'fade',
                autoplay: 5000,
                autoplayDisableOnInteraction: false,
                loop: true,
                prevButton: '.swiper-button-prev',
                nextButton: '.swiper-button-next',
                pagination: '.swiper-pagination',
                paginationClickable: true,
                onInit: function() {
                    setTimeout(function() {
                        $.adaptiveBackground.run()
                    }, 1500);
                },
            });
        });
    },
    menu: function() {
        var windowWidth = $(window).width();
        if (windowWidth < 820) {
            $(".menu").click(function() {
                $('html,body').addClass("overhidden");
                $(".all_menu").addClass("menu_block");
                $(".close_menu").click(function() {
                    $('html,body').removeClass("overhidden");
                    $(".all_menu").removeClass("menu_block");
                });
            });
        } else {
            $(".head_menu_b").each(function(s) {
                $(this).hover(
                    function() {
                        $(".all_menu").eq(s).show();
                    },
                    function() {
                        $(".all_menu").eq(s).hide();
                    })
            })
        }
    },
    fixed: function() {
        if (window.location.hash) {
            var targetScroll = $(window.location.hash).offset().top - 80;
            $("html,body").animate({ scrollTop: targetScroll }, 300);
        };
        
        $(window).scroll(function() {
            var $this = $(this);
            var targetTop = $(this).scrollTop();
            var width = $(window).width();
            if (targetTop >= 1200) {
                $(".ads_rbox").addClass("adfixed");
            } else {
                $(".ads_rbox").removeClass("adfixed");
            }
            if(width<=820){
                if (targetTop >= 200) {
                    $(".submit").addClass("search_btn");
                    $('.rank-i').addClass('fo')
                    $('.head_search .form_control').css('padding','0.15rem 3.5rem 0.15rem 1rem')
                } else {
                    $(".submit").removeClass("search_btn");
                    $('.rank-i').removeClass('fo')
                    $('.head_search .form_control').css('padding','0.15rem 2.125rem 0.15rem 1rem')
                }
            }

        })
    },
    Search: function() {
        var width = $(window).width();
        $("input.form_control").focus(function() {
            $(".submit").addClass("search_btn");
            if(width<=820){
                $('.head_search .form_control').css('padding','0.15rem 3.5rem 0.15rem 1rem')
            }
            $('.mac_results').show()
        });
        $("input.form_control").blur(function() {
            $(".submit").removeClass("search_btn");
            if(width<=820){
                $('.head_search .form_control').css('padding','0.15rem 2.125rem 0.15rem 1rem')
            }
            setTimeout(()=>{
                $('.mac_results').hide()
            },500)
        });
    },
    change: function() {
        if ($('.v_change').length) {
            var divs = [];
            var divCnt = 3;
            for (var i = 0; i < divCnt; i++) {
                divs[i] = $(".cbox" + (i + 1));
            }
            var selectedDiv = 0;
            $('.v_change').on('click', function() {
                selectedDiv++;
                selectedDiv = selectedDiv % divCnt;
                for (var i = 0; i < divCnt; i++) {
                    $(this).closest('.pannel', '.cbox_list').find(divs[i]).removeClass('show fadeIn').addClass('hide fadeOut');
                }
                $(this).closest('.pannel', '.cbox_list').find(divs[selectedDiv]).removeClass('hide fadeOut').addClass('show fadeIn');
                $('.lazyload').lazyload({
                    threshold: 130
                });
            });
        }
    },
    wrapper: function() {
        var windowWidth = $(window).width();
        if (windowWidth < 820) {
            $.getScript(maccms.path + "template/default/asset/js/stem/scroller.js");
            $.getScript(maccms.path + "template/default/asset/js/stem/iscroll.js", function() {
                $(".wrapper").navbarscroll()
                $('#hl01').navbarscroll({ SelectName: '.tplconfig-01' });
                $('#hl02').navbarscroll({ SelectName: '.tplconfig-02' });
                $('#hl03').navbarscroll({ SelectName: '.tplconfig-03' });
                $('#hl04').navbarscroll({ SelectName: '.tplconfig-04' });
                $('#hl05').navbarscroll({ SelectName: '.tplconfig-05' });
                $('#hl06').navbarscroll({ SelectName: '.tplconfig-06' });
            });
        }
    },
    flip: function() {
        $(".flip").click(function() {
            $(".panel").slideToggle("slow");
            $(".xs1").toggle();
            $(".xs2").toggle();
        });
    },
    close: function() {
        $(".close_ads_btn").click(function() {
            $("#bottom_ads").remove();
            $(".foot").removeClass("foot_stem");
        });
        $(".close_tips").click(function() {
            $("#fd_tips").remove();
        });
    },
    shorturl: function() {
        var short = $(".shorturl");
        var openapi = $("#openapi").val();
        var shareurl = $("#shareurl").val();
        if (shareurl == "") {
            var URL2 = encodeURI(tplconfig.browser.url);
        } else {
            var URL2 = shareurl + encodeURI(tplconfig.browser.urlpath);
        };
        if (openapi == 'sina') {
            var apiurl = $("#apiurl").val();
            if (apiurl == '' || apiurl == '#') {
                return;
            }
            $.ajax({
                url: apiurl + URL2,
                type: "GET",
                dataType: "jsonp",
                cache: false,
                success: function(data, status) {
                    for (x in data.data.urls[0]);
                    short.append(data.data.urls[0].url_short);
                },
                error: function(obj, info, errObj) {
                    short.append(URL2);
                },
            });
        } else {
            var Tok = $("#Tok").val();
            var Term = $("#Term").val();
            var ajax = new XMLHttpRequest();
            var token = Tok;
            var longUrl = URL2;
            var termOfValidity = Term;
            ajax.open('post', 'https://dwz.cn/admin/v2/create', 'true');
            ajax.setRequestHeader("Content-Type", "application/json");
            ajax.setRequestHeader("Token", token);
            ajax.send(JSON.stringify({
                Url: longUrl,
                TermOfValidity: termOfValidity
            }));
            ajax.onreadystatechange = function() {
                if (ajax.readyState === 4 && ajax.status === 200) {
                    var obj = JSON.parse(ajax.responseText)
                    console.log(ajax.responseText);
                    if (obj.Code === 0) { short.append(obj.ShortUrl); } else { short.append(URL2); }
                }
            }
        };
    },
    images: {
        lazyload: function() {
            $.getScript(maccms.path + "template/default/asset/js/stem/jquery.lazyload.min.js", function() {
                $(".lazyload").lazyload({
                    effect: "fadeIn",
                    threshold: 200,
                    failurelimit: 20,
                });
                var windowWidth = $(window).width();
                if (windowWidth < 820) {
                    $(".list_scroll .vodlist_thumb").removeClass("lazyload");
                    $(".list_scroll .vodlist_thumb").addClass("boxload");
                    $(".boxload").lazyload({
                        effect: "fadeIn",
                        threshold: 150,
                        failurelimit: 5,
                        container: $(".vodlist_sm,.vodlist_sh")
                    });
                }
            })
        },
        qrcode: function() {
            $.getScript(maccms.path + "template/default/asset/js/stem/jquery.qrcode.min.js", function() {
                $(".cans").qrcode({
                    width: 120,
                    height: 120,
                    text: encodeURI(tplconfig.browser.url)
                });

                function convertCanvasToImage(canvas) {
                    var image = new Image();
                    image.src = canvas.toDataURL("image/png");
                    return image;
                }
                var mycans = $('canvas')[0];
                var img = convertCanvasToImage(mycans);
                $('.qrcode').append(img);
            })
        }
    },
    scrolltop: function() {
        var a = $(window);
        $scrollTopLink = $("a.backtop");
        a.scroll(function() {
            500 < $(this).scrollTop() ? $scrollTopLink.css("display", "block") : $scrollTopLink.css("display", "none")
        });
        $scrollTopLink.on("click", function() {
            $("html, body").animate({
                scrollTop: 0
            }, 400);
            return !1
        });
    },
    copy: function() {
        $.getScript(maccms.path + "template/default/asset/js/stem/clipboard.min.js", function() {
            var btn = document.getElementsByClassName('copy_btn');
            var clipboard = new Clipboard(btn);
            clipboard.on('success', function(e) {
                $('#show').slideDown().delay(1500).slideUp(300);
            });
            clipboard.on('error', function(e) {
                $('#show').slideDown().delay(1500).slideUp(300);
            });
        })
    },
    sort: function() {
        $(".sort_btn").each(function() {
            $(this).on("click", function(e) {
                e.preventDefault();
                $(this).parent().parent().parent().find(".content_playlist").each(function() {
                    var playlist = $(this).find("li");
                    for (let i = 0, j = playlist.length - 1; i < j;) {
                        var l = playlist.eq(i).clone(true);
                        var r = playlist.eq(j).replaceWith(l);
                        playlist.eq(i).replaceWith(r);
                        ++i;
                        --j;
                    }
                });
            });
        });
    },
    color: {
        style: function() {
            var version = $("#version").val();
            $(".mycolor").click(function() {
                var style = $(this).attr("id");
                $("link[name='color']").attr("href", maccms.path + "template/default/asset/css/" + style + ".css?v=" + version + "");
                $(this).addClass("hide").siblings().removeClass("hide");
                $.cookie("mystyle", style, { expires: 1, path: '/' });
                if(style=='white'){
                    $('.black_logo').hide()
                    $('.white_logo').show()
                }else{
                    $('.black_logo').show()
                    $('.white_logo').hide()
                }
            });
        },
        themes: function() {
            var version = $("#version").val();
            $("#themes li").click(function() {
                var themes = $(this).attr("id");
                $("link[name='skin']").attr("href", maccms.path + "template/default/asset/css/" + themes + ".css?v=" + version + "");
                $(this).addClass("cur").siblings().removeClass("cur");
                $.cookie("mythemes", themes, { expires: 1, path: '/' });
            });
        }
    },
    wxqrcode: function() {
        var wx_title = $("#wx_title").val();
        var wx_text = $("#wx_text").val();
        var wx_qrcode = $("#wx_qrcode").val();
        var zans_title = $("#zans_title").val();
        var zans_text = $("#zans_text").val();
        var zans_qrcode = $("#zans_qrcode").val();
        $(".btn_wxgzh").click(function() {
            $("body").append('<div class="hl_wrap"><div class="mac_pop_bg"></div><div class="hl_content"><div class="hl_content_hd"><h4 class="hl_content_title">' + wx_title + '</h4></div><div class="hl_content_bd"><img class="info_img" src="' + wx_qrcode + '" alt="公众号二维码">' + wx_text + '</div><div class="hl_content_ft"><a class="close_box" href="javascript:;">下次再说</a></div></div></div>');
            $(".close_box,.mac_pop_bg").click(function() {
                $(".hl_wrap").remove();
            });
        });
        $(".btn_zhans").click(function() {
            $("body").append('<div class="hl_wrap"><div class="mac_pop_bg"></div><div class="hl_content"><div class="hl_content_hd"><h4 class="hl_content_title">' + zans_title + '</h4></div><div class="hl_content_bd"><img class="info_img" src="' + zans_qrcode + '" alt="赞赏二维码">' + zans_text + '</div><div class="hl_content_ft"><a class="hl_btn_no" href="javascript:;">残忍拒绝</a><a class="close_box" href="javascript:;">取消</a></div></div></div>');
            $(".hl_btn_no").click(function() {
                var lang=localStorage.getItem('lang')
                alert(lang==1?'I knew you could order, hum ~, but I also wish you a happy movie ~!':"就知道你会点，哼~，不过还要祝你观影愉快～！")
                $(".hl_wrap").remove();
            });
            $(".close_box,.mac_pop_bg").click(function() {
                $(".hl_wrap").remove();
            });
        });
    }
};
$(document).ready(function() {
    tplconfig.browser.useragent.mobile && (tplconfig.mobile.share());
    tplconfig.swiper();
    tplconfig.menu();
    tplconfig.fixed();
    tplconfig.Search();
    tplconfig.change();
    tplconfig.wrapper();
    tplconfig.flip();
    tplconfig.close();
    tplconfig.shorturl();
    tplconfig.images.lazyload();
    tplconfig.images.qrcode();
    tplconfig.scrolltop();
    tplconfig.copy();
    tplconfig.sort();
    tplconfig.color.style();
    tplconfig.color.themes();
    tplconfig.wxqrcode();
});