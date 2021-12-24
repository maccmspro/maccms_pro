# 视频模块(Vod)

获取视频列表
-------------------------------------------

- 请求路径：`/vod/get_list`
- 请求方式：`GET`
- 请求参数：

| 名称       | 类型      | 描述             | 限制                                                         | 必填 |
| ---------- | --------- | ---------------- | ------------------------------------------------------------ | ---- |
| offset     | `integer` | 起始位置         | 0-500，默认0                                                 | 否   |
| limit      | `integer` | 获取条数         | 1-500，默认20                                                | 否   |
| vod_id     | `integer` | 查询单条ID       | 0-21亿，默认NULL                                             | 否   |
| type_id    | `integer` | 类型ID           | 0-21亿，默认NULL                                             | 否   |
| type_id_1  | `integer` | 子类型ID         | 0-21亿，默认NULL                                             | 否   |
| vod_letter | `string`  | 名称开头字母     | 默认NULL                                                     | 否   |
| tag        | `string`  | 标签数组查询     | 默认NULL                                                     | 否   |
| vod_name   | `string`  | 视频名称（模糊） | 默认NULL                                                     | 否   |
| vod_blurb  | `string`  | 视频详情（模糊） | 默认NULL                                                     | 否   |
| orderby    | `string`  | 排序倒序         | 点击量hits, 顶数up, 发布日期pubdate, 周点击hits_week, 月点击hits_month, 日点击hits_day, 分数score | 否   |

- 返回示例：

```json
{
    "code": 1,
    "msg": "获取成功",
    "info": {
        "offset": 0,
        "limit": 1,
        "total": 83400,
        "rows": [
            {
                "vod_id": 83435,
                "vod_name": "巴黎诱惑",
                "vod_actor": "马丽,张大明,黄国强,叶芷玲",
                "vod_hits": 3293,
                "vod_time": 1619193641,
                "vod_remarks": "HD"
            },
            ...
        ]
    }
}
```



获取视频详情
-------------------------------------------

- 请求路径：`/vod/get_detail`
- 请求方式：`GET`
- 请求参数：

| 名称   | 类型      | 描述       | 限制                  | 必填 |
| ------ | --------- | ---------- | --------------------- | ---- |
| vod_id | `integer` | 该视频的ID | 1~9223372036854775807 | 是   |

- 返回示例：

```json
{
    "code": 1,
    "msg": "获取成功",
    "info": [
        {
            "vod_id": 1,
            "type_id": 9,
            "type_id_1": 1,
            "group_id": 0,
            "vod_name": "钢铁骑士",
            "vod_sub": "",
            "vod_en": "gangtieqishi",
            "vod_status": 1,
            "vod_letter": "G",
            "vod_color": "",
            "vod_tag": "",
            "vod_class": "科幻",
            "vod_pic": "https://img.sokoyo-rj.com/tuku/upload/vod/2019-04-19/201904191555613947.jpg",
            "vod_pic_thumb": "",
            "vod_pic_slide": "",
            "vod_actor": "本·温切尔,玛丽亚·贝罗,乔什·布雷纳,",
            "vod_director": "斯特瓦特·亨德尔",
            "vod_writer": "",
            "vod_behind": "",
            "vod_blurb": "“钢铁骑士”曾是一款风行全球的男孩人偶玩具，也曾被拍成电视系列动画片，此次真人电影版的故事是《雷神2：黑暗世界》的编剧Christopher Yost原创的。故事讲述16岁男孩Max（本·温切尔 饰）",
            "vod_remarks": "HD",
            "vod_pubdate": "",
            "vod_total": 0,
            "vod_serial": "0",
            "vod_tv": "",
            "vod_weekday": "",
            "vod_area": "美国",
            "vod_lang": "英语",
            "vod_year": "2016",
            "vod_version": "",
            "vod_state": "",
            "vod_author": "",
            "vod_jumpurl": "",
            "vod_tpl": "",
            "vod_tpl_play": "",
            "vod_tpl_down": "",
            "vod_isend": 1,
            "vod_lock": 0,
            "vod_level": 0,
            "vod_copyright": 0,
            "vod_points": 0,
            "vod_points_play": 0,
            "vod_points_down": 0,
            "vod_hits": 518,
            "vod_hits_day": 1,
            "vod_hits_week": 1,
            "vod_hits_month": 2,
            "vod_duration": "",
            "vod_up": 710,
            "vod_down": 117,
            "vod_score": "1.0",
            "vod_score_all": 49,
            "vod_score_num": 49,
            "vod_time": 1617805970,
            "vod_time_add": 1607050838,
            "vod_time_hits": 1625451719,
            "vod_time_make": 0,
            "vod_trysee": 0,
            "vod_douban_id": 0,
            "vod_douban_score": "0.0",
            "vod_reurl": "",
            "vod_rel_vod": "",
            "vod_rel_art": "",
            "vod_pwd": "",
            "vod_pwd_url": "",
            "vod_pwd_play": "",
            "vod_pwd_play_url": "",
            "vod_pwd_down": "",
            "vod_pwd_down_url": "",
            "vod_content": "“钢铁骑士”曾是一款风行全球的男孩人偶玩具，也曾被拍成电视系列动画片，此次真人电影版的故事是《雷神2：黑暗世界》的编剧Christopher Yost原创的。故事讲述16岁男孩Max（本·温切尔 饰）和母亲居住在一个小镇上，他的科学家父亲当年在他出生后不久就神秘死亡了。Max拥有一种他自己都无法控制的超强能量，直到他遇到有着先进技术的外星人...<span class=\"intro-more hide\">简介：“钢铁骑士”曾是一款风行全球的男孩人偶玩具，也曾被拍成电视系列动画片，此次真人电影版的故事是《雷神2：黑暗世界》的编剧Christopher Yost原创的。故事讲述16岁男孩Max（本·温切尔 饰）和母亲居住在一个小镇上，他的科学家父亲当年在他出生后不久就神秘死亡了。Max拥有一种他自己都无法控制的超强能量，直到他遇到有着先进技术的外星人Steel（乔什·布雷纳 配音）后，Max才学会运用它，“钢铁骑士”就此诞生！",
            "vod_play_from": "zuidam3u8$$$123kum3u8",
            "vod_play_server": "no$$$no",
            "vod_play_note": "$$$",
            "vod_play_url": "BD1280高清中字版$https://leshi.cdn-zuyida.com/20170910/3pJxFU9o/index.m3u8$$$HD高清$https://www.zhuticlub.com:65/20190418/uz3m0oKl/index.m3u8",
            "vod_down_from": "",
            "vod_down_server": "",
            "vod_down_note": "",
            "vod_down_url": "",
            "vod_plot": 0,
            "vod_plot_name": "",
            "vod_plot_detail": ""
        }
    ]
}
```



获取视频年份
-------------------------------------------

- 请求路径：`/vod/get_year`

- 请求方式：`GET`

- 请求参数：

  | 名称      | 类型      | 描述       | 限制                  | 必填 |
  | --------- | --------- | ---------- | --------------------- | ---- |
  | type_id_1 | `integer` | 视频类型ID | 1~9223372036854775807 | 是   |

- 返回示例：

```json
{
    "code": 1,
    "msg": "获取成功",
    "info": {
        "total": 150,
        "rows": [
            "1990",
            "1920",
            "1911",
            "1902",
           	...
        ]
    }
}
```



获取视频类型
-------------------------------------------

- 请求路径：`/vod/get_class`

- 请求方式：`GET`

- 请求参数：

  | 名称      | 类型      | 描述       | 限制                  | 必填 |
  | --------- | --------- | ---------- | --------------------- | ---- |
  | type_id_1 | `integer` | 视频类型ID | 1~9223372036854775807 | 是   |

- 返回示例：

```json
{
    "code": 1,
    "msg": "获取成功",
    "info": {
        "total": 33,
        "rows": [
            "伦理片",
            "剧情",
            "剧情片",
            ...
        ]
    }
}
```



获取视频地区
-------------------------------------------

- 请求路径：`/vod/get_area`

- 请求方式：`GET`

- 请求参数：

  | 名称      | 类型      | 描述       | 限制                  | 必填 |
  | --------- | --------- | ---------- | --------------------- | ---- |
  | type_id_1 | `integer` | 视频类型ID | 1~9223372036854775807 | 是   |

- 返回示例：

```json
{
    "code": 1,
    "msg": "获取成功",
    "info": {
        "total": 16,
        "rows": [
            "俄罗斯",
            "其它",
            "加拿大",
            "印度",
            "台湾",
            ...
        ]
    }
}
```

