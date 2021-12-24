网址模块（website） 
===========================================

获取网址列表
-------------------------------------------

- 请求路径：`/website/get_list`
- 请求方式：`GET`
- 请求参数：

| 名称       | 类型      | 描述         | 限制                                            | 必填 |
| ---------- | --------- | ------------ | ----------------------------------------------- | ---- |
| offset     | `integer` | 起始位置     | 0-500，默认0                                    | 否   |
| limit      | `integer` | 获取条数     | 1-500，默认20                                   | 否   |
| type_id    | `integer` | 分类id       | 1-100                                           | 否   |
| name       | `string`  | 网址名       | 最大20字符                                      | 否   |
| sub        | `string`  | 副标         | 最大20字符                                      | 否   |
| en         | `string`  | 拼音         | 最大20字符                                      | 否   |
| status     | `integer` | 状态         | 1-9                                             | 否   |
| letter     | `string`  | 首字母       | 最大1字符                                       | 否   |
| area       | `string`  | 地区         | 最大10字符                                      | 否   |
| lang       | `string`  | 语言         | 最大10字符                                      | 否   |
| level      | `string`  | 推荐值       | 1-9                                             | 否   |
| start_time | `integer` | 开始时间搜索 | 1~9223372036854775807                           | 否   |
| end_time   | `integer` | 结束时间搜索 | 1~9223372036854775807                           | 否   |
| tag        | `string`  | 标签         | 最大20字符                                      | 否   |
| orderby    | `string`  | 排序         | 支持：id,time,time_add,score,hits,up,down,level | 否   |

- 返回示例：

```json
{
    "code": 1,
    "msg": "获取成功",
    "info": {
        "offset": 0,
        "limit": 20,
        "total": 2,
        "rows": [
            {
                "website_id": 1,
                "type_id": 0,
                "type_id_1": 0,
                "website_name": "网址名",
                "website_sub": "副标",
                "website_en": "拼音",
                "website_status": 0,
                "website_letter": "G",
                "website_color": "高亮颜色1",
                "website_lock": 0,
                "website_sort": 0,
                "website_jumpurl": "跳转url111",
                "website_pic": "截图1",
                "website_logo": "logo3",
                "website_area": "地区5",
                "website_lang": "语言7",
                "website_level": 1,
                "website_time": 0,
                "website_time_add": 0,
                "website_time_hits": 0,
                "website_time_make": 0,
                "website_time_referer": 0,
                "website_hits": 0,
                "website_hits_day": 0,
                "website_hits_week": 0,
                "website_hits_month": 0,
                "website_score": "0.0",
                "website_score_all": 0,
                "website_score_num": 0,
                "website_up": 0,
                "website_down": 0,
                "website_referer": 0,
                "website_referer_day": 0,
                "website_referer_week": 0,
                "website_referer_month": 0,
                "website_tag": "标签",
                "website_class": "类别1",
                "website_remarks": "备注1",
                "website_tpl": "样板1",
                "website_blurb": "简介2",
                "website_content": "内容333333"
            },
            ...
        ]
    }
}
```



获取网址详情
-------------------------------------------

- 请求路径：`/website/get_detail`
- 请求方式：`GET`
- 请求参数：

| 名称       | 类型      | 描述         | 限制                  | 必填 |
| ---------- | --------- | ------------ | --------------------- | ---- |
| website_id | `integer` | 开始时间搜索 | 1~9223372036854775807 | 否   |

- 返回示例：

```json
{
    "code": 1,
    "msg": "获取成功",
    "info": [
        {
            "website_id": 1,
            "type_id": 0,
            "type_id_1": 0,
            "website_name": "网址名",
            "website_sub": "副标",
            "website_en": "拼音",
            "website_status": 0,
            "website_letter": "G",
            "website_color": "高亮颜色1",
            "website_lock": 0,
            "website_sort": 0,
            "website_jumpurl": "跳转url111",
            "website_pic": "截图1",
            "website_logo": "logo3",
            "website_area": "地区5",
            "website_lang": "语言7",
            "website_level": 1,
            "website_time": 0,
            "website_time_add": 0,
            "website_time_hits": 0,
            "website_time_make": 0,
            "website_time_referer": 0,
            "website_hits": 0,
            "website_hits_day": 0,
            "website_hits_week": 0,
            "website_hits_month": 0,
            "website_score": "0.0",
            "website_score_all": 0,
            "website_score_num": 0,
            "website_up": 0,
            "website_down": 0,
            "website_referer": 0,
            "website_referer_day": 0,
            "website_referer_week": 0,
            "website_referer_month": 0,
            "website_tag": "标签",
            "website_class": "类别1",
            "website_remarks": "备注1",
            "website_tpl": "样板1",
            "website_blurb": "简介2",
            "website_content": "内容333333"
        }
    ]
}
```

