# 文章模块（art）

获取文章列表
-------------------------------------------

- 请求路径：`/art/get_list`
- 请求方式：`GET`
- 请求参数：

| 名称       | 类型      | 描述           | 限制                                                         | 必填 |
| ---------- | --------- | -------------- | ------------------------------------------------------------ | ---- |
| offset     | `integer` | 起始位置       | 0-500，默认0                                                 | 否   |
| limit      | `integer` | 获取条数       | 1-500，默认20                                                | 否   |
| tag        | `string`  | 标签名称       | 最大100字                                                    | 否   |
| orderby    | `string`  | 排序字段       | 可选参数 id,time,time_add,score,hits,hits_day,hits_week,hits_month,up,down,level | 否   |
| letter     | `string`  | 首字母查询     | 大写 A~Z                                                     | 否   |
| status     | `integer` | 状态查询       | 1~10                                                         | 否   |
| name       | `string`  | 文章名查询     | 最大100字                                                    | 否   |
| sub        | `string`  | 文章子名称查询 | 最大100字                                                    | 否   |
| blurb      | `string`  | 简介查询       | 最大100字                                                    | 否   |
| title      | `string`  | 页标题查询     | 最大50字                                                     | 否   |
| content    | `string`  | 页详细介绍查询 | 最大100字                                                    | 否   |
| time_start | `integer` | 开始时间戳     | 1~9223372036854775807                                        | 否   |
| time_end   | `integer` | 结束时间戳     | 1~9223372036854775807                                        | 否   |

- 返回示例：

```json
{
    "code": 1,
    "msg": "获取成功",
    "info": {
        "offset": 5,
        "limit": 1,
        "total": 20,
        "rows": [
            {
                "art_id": 29,
                "art_name": "公告内容",
                "art_sub": "公告内容",
                "art_en": "losengonggaoneirong",
                "art_blurb": "losen公告内容losen公告内容losen公告内容losen公告内容losen公告内容losen公告内容losen公告内容losen公告内容",
                "art_time": 1622204382,
                "art_time_add": 1599127919
            },
            ...
        ]
    }
}
```



获取文章详情
-------------------------------------------

- 请求路径：`/art/get_detail`
- 请求方式：`GET`
- 请求参数：

| 名称   | 类型      | 描述   | 限制                  | 必填 |
| ------ | --------- | ------ | --------------------- | ---- |
| art_id | `integer` | 文章ID | 1~9223372036854775807 | 否   |

- 返回示例：

```json
{
    "code": 1,
    "msg": "获取成功",
    "info": [
        {
            "art_id": 5,
            "type_id": 31,
            "type_id_1": 0,
            "group_id": 0,
            "art_name": "油条视频官方通告",
            "art_sub": "",
            "art_en": "youtiaoshipinguanfangtonggao",
            "art_status": 1,
            "art_letter": "Y",
            "art_color": "",
            "art_from": "",
            "art_author": "",
            "art_tag": "",
            "art_class": "",
            "art_pic": "",
            "art_pic_thumb": "",
            "art_pic_slide": "",
            "art_blurb": "1、油条每天更新各类火爆视频、性感女优、火辣女神清纯动漫、制服诱惑，总有一款值得观看。2、油条推出各种增加观影次数的活动，如果碰到提示观影次数不足，请完成每日任务来增加观影次数3，加入油条官方交友群：",
            "art_remarks": "",
            "art_jumpurl": "",
            "art_tpl": "",
            "art_level": 0,
            "art_lock": 0,
            "art_points": 0,
            "art_points_detail": 0,
            "art_up": 0,
            "art_down": 0,
            "art_hits": 0,
            "art_hits_day": 0,
            "art_hits_week": 0,
            "art_hits_month": 0,
            "art_time": 1562949469,
            "art_time_add": 1562595051,
            "art_time_hits": 0,
            "art_time_make": 0,
            "art_score": "0.0",
            "art_score_all": 0,
            "art_score_num": 0,
            "art_rel_art": "",
            "art_rel_vod": "",
            "art_pwd": "",
            "art_pwd_url": "",
            "art_title": "",
            "art_note": "",
            "art_content": "<p style=\"text-align: left;\">1、油条每天更新各类火爆视频、性感女优、火辣女神</p><p style=\"text-align: left;\">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;清纯动漫、制服诱惑，总有一款值得观看。</p><p><br/></p><p style=\"text-align: left;\">2、油条推出各种增加观影次数的活动，如果碰到提示观影<br/></p><p style=\"text-align: left;\">次数不足，请完成每日任务增加观影次数</p><p><br/></p><p style=\"text-align: left;\">3、加入油条官方交友群：https://t.me/youtiaosm</p><p style=\"text-align: left;\">最后感谢大家对油条的支持，油条为了大家以后的性福</p><p style=\"text-align: left;\">会一步一步做到更好，让油条视频是大家最好的选择。</p><p><br/></p>"
        }
    ]
}
```
