# 演员模块（actor）

获取演员列表
-------------------------------------------

- 请求路径：`/actor/get_list`
- 请求方式：`GET`
- 请求参数：

| 名称       | 类型      | 描述         | 限制                                                | 必填 |
| ---------- | --------- | ------------ | --------------------------------------------------- | ---- |
| offset     | `integer` | 起始位置     | 0-500，默认0                                        | 否   |
| limit      | `integer` | 获取条数     | 1-500，默认20                                       | 否   |
| id         | `integer` | 演员ID       | 1~9223372036854775807                               | 否   |
| type_id    | `integer` | 类型ID       | 1~100                                               | 否   |
| sex        | `string`  | 性别         | 支持 男，女                                         | 否   |
| area       | `string`  | 地区         | 最大255字符                                         | 否   |
| letter     | `string`  | 首字母搜索   | 最大1字符                                           | 否   |
| level      | `string`  | 等级显示     | 最大1字符                                           | 否   |
| name       | `string`  | 演员名称     | 最大20字符                                          | 否   |
| blood      | `string`  | 演员血型     | 最大10字符                                          | 否   |
| starsign   | `string`  | 演员星座     | 最大255字符                                         | 否   |
| time_end   | `integer` | 创建结束时间 | 1~9223372036854775807                               | 否   |
| time_start | `integer` | 创建开始时间 | 1~9223372036854775807                               | 否   |
| orderby    | `string`  | 排序         | 支持hits,type_id,hits_month,hits_week,hits_day,time | 否   |

- 返回示例：

```json
{
    "code": 1,
    "msg": "获取成功",
    "info": {
        "offset": 0,
        "limit": 20,
        "total": 4,
        "rows": [
            {
                "actor_id": 1,
                "actor_name": "甄志丹",
                "actor_en": "zhenzhidan",
                "actor_alias": "zzd",
                "actor_sex": "男",
                "actor_hits_month": 0,
                "actor_hits_week": 0,
                "actor_hits_day": 0,
                "actor_time": 0
            },
            ...
        ]
    }
}
```



获取演员详情
-------------------------------------------

- 请求路径：`/actor/get_detail`
- 请求方式：`GET`
- 请求参数：

| 名称     | 类型      | 描述   | 限制                  | 必填 |
| -------- | --------- | ------ | --------------------- | ---- |
| actor_id | `integer` | 演员ID | 1~9223372036854775807 | 是   |

- 返回示例：

```json
{
    "code": 1,
    "msg": "获取成功",
    "info": [
        {
            "actor_id": 1,
            "type_id": 1,
            "type_id_1": 1,
            "actor_name": "甄志丹",
            "actor_en": "zhenzhidan",
            "actor_alias": "zzd",
            "actor_status": 0,
            "actor_lock": 0,
            "actor_letter": "",
            "actor_sex": "男",
            "actor_color": "",
            "actor_pic": "",
            "actor_blurb": "",
            "actor_remarks": "",
            "actor_area": "",
            "actor_height": "",
            "actor_weight": "",
            "actor_birthday": "",
            "actor_birtharea": "",
            "actor_blood": "",
            "actor_starsign": "",
            "actor_school": "",
            "actor_works": "",
            "actor_tag": "",
            "actor_class": "",
            "actor_level": 0,
            "actor_time": 0,
            "actor_time_add": 0,
            "actor_time_hits": 0,
            "actor_time_make": 0,
            "actor_hits": 0,
            "actor_hits_day": 0,
            "actor_hits_week": 0,
            "actor_hits_month": 0,
            "actor_score": "0.0",
            "actor_score_all": 0,
            "actor_score_num": 0,
            "actor_up": 0,
            "actor_down": 0,
            "actor_tpl": "",
            "actor_jumpurl": "",
            "actor_content": "123456789"
        }
    ]
}
```

