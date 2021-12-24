# 专题模块（topic）

获取专题列表
-------------------------------------------

- 请求路径：`/topic/get_list`
- 请求方式：`GET`
- 请求参数：

| 名称       | 类型      | 描述       | 限制             | 必填 |
| ---------- | --------- | ---------- | ---------------- | ---- |
| offset     | `integer` | 起始位置   | 0-500，默认0     | 否   |
| limit      | `integer` | 获取条数   | 1-500，默认20    | 否   |
| time_start | `integer` | 查询单条ID | 0-21亿，默认NULL | 否   |
| time_end   | `integer` | 类型ID     | 0-21亿，默认NULL | 否   |
| orderby    | `string`  | 排序字段   | 默认topic_time   | 否   |

- 返回示例：

```json
{
    "code": 1,
    "msg": "获取成功",
    "info": {
        "offset": 0,
        "limit": 20,
        "total": 7231,
        "rows": [
            {
                "topic_id": 7231,
                "topic_name": "四个骑摩托车的电影美国喜剧",
                "topic_en": "sigeqimotuochededianyingmeiguoxiju",
                "topic_pic_slide": "http://www.4te1.com/H86ea4b2709f049f2b231adf0a281406ei.jpg",
                "topic_content": "四个骑摩托车的电影美国喜剧电影系列专题，为您提供最新最全的四个骑摩托车的电影美国喜剧电影"
            },
          ....
        ]
    }
}
```



获取专题详情
-------------------------------------------

- 请求路径：`/topic/get_detail`
- 请求方式：`GET`
- 请求参数：

| 名称     | 类型      | 描述   | 限制                  | 必填 |
| -------- | --------- | ------ | --------------------- | ---- |
| topic_id | `integer` | 专题ID | 1~9223372036854775807 | 是   |

- 返回示例：

```json
{
    "code": 1,
    "msg": "获取成功",
    "info": {
        "topic_id": 1,
        "topic_name": "2013华鼎电影颁奖礼",
        "topic_en": "huadingdianyingbanjiangli",
        "topic_sub": "",
        "topic_status": 1,
        "topic_sort": 0,
        "topic_letter": "",
        "topic_color": "",
        "topic_tpl": "detail.html",
        "topic_type": "",
        "topic_pic": "http://www.4te1.com/H86ea4b2709f049f2b231adf0a281406ei.jpg",
        "topic_pic_thumb": "http://www.4te1.com/load.png",
        "topic_pic_slide": "http://www.4te1.com/H86ea4b2709f049f2b231adf0a281406ei.jpg",
        "topic_key": "",
        "topic_des": "",
        "topic_title": "",
        "topic_blurb": "",
        "topic_remarks": "",
        "topic_level": 0,
        "topic_up": 0,
        "topic_down": 0,
        "topic_score": "0.0",
        "topic_score_all": 0,
        "topic_score_num": 0,
        "topic_hits": 0,
        "topic_hits_day": 0,
        "topic_hits_week": 0,
        "topic_hits_month": 0,
        "topic_time": 1612799741,
        "topic_time_add": 1612799741,
        "topic_time_hits": 0,
        "topic_time_make": 0,
        "topic_tag": "",
        "topic_rel_vod": [
            {
                "1": {
                    "vod_id": 1,
                    "vod_name": "钢铁骑士",
                    "vod_en": "gangtieqishi",
                    "vod_pic": "https://img.sokoyo-rj.com/tuku/upload/vod/2019-04-19/201904191555613947.jpg",
                    "vod_actor": "本·温切尔,玛丽亚·贝罗,乔什·布雷纳,",
                    "vod_director": "斯特瓦特·亨德尔",
                    "vod_blurb": "“钢铁骑士”曾是一款风行全球的男孩人偶玩具，也曾被拍成电视系列动画片，此次真人电影版的故事是《雷神2：黑暗世界》的编剧Christopher Yost原创的。故事讲述16岁男孩Max（本·温切尔 饰）",
                    "vod_content": "“钢铁骑士”曾是一款风行全球的男孩人偶玩具，也曾被拍成电视系列动画片，此次真人电影版的故事是《雷神2：黑暗世界》的编剧Christopher Yost原创的。故事讲述16岁男孩Max（本·温切尔 饰）和母亲居住在一个小镇上，他的科学家父亲当年在他出生后不久就神秘死亡了。Max拥有一种他自己都无法控制的超强能量，直到他遇到有着先进技术的外星人...<span class=\"intro-more hide\">简介：“钢铁骑士”曾是一款风行全球的男孩人偶玩具，也曾被拍成电视系列动画片，此次真人电影版的故事是《雷神2：黑暗世界》的编剧Christopher Yost原创的。故事讲述16岁男孩Max（本·温切尔 饰）和母亲居住在一个小镇上，他的科学家父亲当年在他出生后不久就神秘死亡了。Max拥有一种他自己都无法控制的超强能量，直到他遇到有着先进技术的外星人Steel（乔什·布雷纳 配音）后，Max才学会运用它，“钢铁骑士”就此诞生！",
                    "vod_play_url": "BD1280高清中字版$https://leshi.cdn-zuyida.com/20170910/3pJxFU9o/index.m3u8$$$HD高清$https://www.zhuticlub.com:65/20190418/uz3m0oKl/index.m3u8"
                }
            },
            ...
        ],
        "topic_rel_art": [
            {
                "29": {
                    "art_id": 29,
                    "type_id": 32,
                    "art_name": "公告内容",
                    "art_sub": "公告内容",
                    "art_en": "losengonggaoneirong",
                    "art_blurb": "losen公告内容losen公告内容losen公告内容losen公告内容losen公告内容losen公告内容losen公告内容losen公告内容",
                    "art_content": "<p><span style=\"color: rgb(60, 67, 83); font-family: &quot;Helvetica Neue&quot;, Helvetica, Tahoma, Arial, &quot;PingFang SC&quot;, &quot;Source Han Sans CN&quot;, &quot;Source Han Sans&quot;, &quot;Hiragino Sans GB&quot;, &quot;WenQuanYi Micro Hei&quot;, sans-serif; font-size: 14px; font-weight: 700; background-color: rgb(239, 239, 239);\">产品反馈-专题描述字体和图片太小了</span></p>"
                }
            },
            ...
        ],
        "topic_content": "2013华鼎电影颁奖礼电影系列专题，为您提供最新最全的2013华鼎电影颁奖礼电影",
        "topic_extend": null
    }
}
```

