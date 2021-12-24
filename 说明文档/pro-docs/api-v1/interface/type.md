# 类型模块（topic）

获取全部类型（第一级）
-------------------------------------------

- 请求路径：`/type/get_all_list`
- 请求方式：`GET`
- 请求参数：无

- 返回示例：

```json
{
    "code": 1,
    "msg": "获取成功",
    "info": {
        "total": 5,
        "rows": [
            {
                "type_id": 1,
                "type_name": "电影",
                "type_en": "dianying",
            },
            ...
        ]
    }
}
```



获取类型树
-------------------------------------------

- 请求路径：`/type/get_list`
- 请求方式：`GET`
- 请求参数：

| 名称    | 类型      | 描述   | 限制         | 必填 |
| ------- | --------- | ------ | ------------ | ---- |
| type_id | `integer` | 类型ID | 0-500，默认0 | 否   |

- 返回示例：

```json
{
    "code": 1,
    "msg": "获取成功",
    "info": {
        "total": 5,
        "rows": [
            {
                "type_id": 2,
                "type_name": "连续剧",
                "type_en": "lianxuju",
                "type_sort": 2,
                "type_mid": 1,
                "type_pid": 0,
                "type_status": 1,
                "type_tpl": "type.html",
                "type_tpl_list": "show.html",
                "type_tpl_detail": "ds.html",
                "type_tpl_play": "play.html",
                "type_tpl_down": "down.html",
                "type_key": "电视剧,最新电视剧,好看的电视剧,热播电视剧,电视剧在线观看,电视剧排行,电视剧大全,电视剧列表",
                "type_des": "【电视剧大全】为您提供最新电视剧排行榜，内地电视剧、韩国电视剧、泰国电视剧、香港电视剧、美国电视剧、好看的电视剧等热播电视剧排行榜，并提供免费高清电视剧在线观看，在线看电视剧尽在策驰影院电视剧大全。",
                "type_title": "电视剧大全-追剧好看的最新最火电视剧免费在线观看策驰影院电视剧",
                "type_union": "",
                "type_extend":"{\"class\":\"\古\装,\战\争,\青\春\偶\像,\喜\剧,\家\庭,\犯\罪,\动\作,\奇\幻,\剧\情,\历\史,\经\典,\乡\村,\情\景,\商\战,\网\剧,\其\他\",\"area\":\"\内\地,\韩\国,\香\港,\台\湾,\日\本,\美\国,\泰\国,\英\国,\新\加\坡,\其\他\",\"lang\":\"\国\语,\英\语,\粤\语,\闽\南\语,\韩\语,\日\语,\其\它\",\"year\":\"2021,2020,2019,2018,2017,2016,2015,2014,2013,2012,2011,2010\",\"star\":\"\王\宝\强,\胡\歌,\霍\建\华,\赵\丽\颖,\刘\涛,\刘\诗\诗,\陈\伟\霆,\吴\奇\隆,\陆\毅,\唐\嫣,\关\晓\彤,\孙\俪,\李\易\峰,\张\翰,\李\晨,\范\冰\冰,\林\心\如,\文\章,\马\伊\琍,\佟\大\为,\孙\红\雷,\陈\建\斌,\李\小\璐\",\"director\":\"\张\纪\中,\李\少\红,\刘\江,\孔\笙,\张\黎,\康\洪\雷,\高\希\希,\胡\玫,\赵\宝\刚,\郑\晓\龙\",\"state\":\"\正\片,\预\告\片,\花\絮\",\"version\":\"\高\清\版,\剧\场\版,\抢\先\版,OVA,TV,\影\院\版\"}",
                "type_logo": "",
                "type_pic": "",
                "type_jumpurl": "",
                "child": [
                    {
                        "type_id": 13,
                        "type_name": "国产剧",
                        "type_en": "guochanju",
                        "type_sort": 1,
                        "type_mid": 1,
                        "type_pid": 2,
                        "type_status": 1,
                        "type_tpl": "type.html",
                        "type_tpl_list": "show.html",
                        "type_tpl_detail": "ds.html",
                        "type_tpl_play": "play.html",
                        "type_tpl_down": "down.html",
                        "type_key": "国产剧,国产剧在线播放,免费在线观看国产剧,国产剧大全,策驰影院免费在线观看电影网",
                        "type_des": "国产剧,国产剧在线播放,免费在线观看国产剧,策驰影院整合网络上视频,电影,电视剧,动漫,综艺,美剧,港剧节目提供给各大网友免费在线观看。策驰电影网整合多个平台会员最新电影,最新电视剧,最新动漫,追剧,最新综艺免费在线观看。",
                        "type_title": "国产剧-国产剧在线播放-策驰影院免费在线观看电影网",
                        "type_union": "",
                        "type_extend":"{\"class\":\"\",\"area\":\"\大\陆\",\"lang\":\"\",\"year\":\"\",\"star\":\"\",\"director\":\"\",\"state\":\"\",\"version\":\"\"}",
                        "type_logo": "",
                        "type_pic": "",
                        "type_jumpurl": ""
                    },
                    {
                        "type_id": 12,
                        "type_name": "战争片",
                        "type_en": "zhanzhengpian",
                        "type_sort": 7,
                        "type_mid": 1,
                        "type_pid": 1,
                        "type_status": 1,
                        "type_tpl": "type.html",
                        "type_tpl_list": "show.html",
                        "type_tpl_detail": "dy.html",
                        "type_tpl_play": "play.html",
                        "type_tpl_down": "down.html",
                        "type_key": "好看的战争片,最新战争片,经典战争片,国语战争片电影",
                        "type_des": "2018最新战争片，好看的战争片大全和排行榜推荐，免费战争片在线观看和视频在线播放是由本网站整理和收录，欢迎战争片爱好者来到这里在线观看战争片",
                        "type_title": "好看的战争片-最新战争片-经典战争片-最新战争片推荐",
                        "type_union": "",
                        "type_extend": "{\"class\":\"\",\"area\":\"\",\"lang\":\"\",\"year\":\"\",\"star\":\"\",\"director\":\"\",\"state\":\"\",\"version\":\"\"}",
                        "type_logo": "",
                        "type_pic": "",
                        "type_jumpurl": ""
                    }
                ]
            }
        ]
    }
}
```

