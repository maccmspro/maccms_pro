# 广告模块（banner）

获取广告列表
-------------------------------------------

- 请求路径：`/banner/get_list`

- 请求方式：`GET`

- 请求参数：

  | 名称               | 类型      | 描述                  | 限制                  | 必填 |
  | ------------------ | --------- | --------------------- | --------------------- | ---- |
  | banner_stime_end   | `integer` | 标题开始时间-选择结束 | 1~9223372036854775807 | 否   |
  | banner_stime_start | `integer` | 标题开始时间-选择开始 | 1~9223372036854775807 | 否   |
  | banner_etime_end   | `integer` | 标题结束时间-选择结束 | 1~9223372036854775807 | 否   |
  | banner_etime_start | `integer` | 标题结束时间-选择开始 | 1~9223372036854775807 | 否   |
  | id                 | `integer` | 广告ID                | 1~9223372036854775807 | 否   |
  | pic                | `integer` | 父级ID                | 1~9223372036854775807 | 否   |
  | title              | `string`  | 标题                  | 最大30字              | 否   |
  | link               | `string`  | 链接                  | 最大30字              | 否   |
  | cat                | `string`  | 类别                  | 最大30字              | 否   |
  | type               | `integer` | 类型                  | 1~10                  | 否   |
  | status             | `integer` | 状态                  | 1~10                  | 否   |
  | order              | `string`  | 排序                  | 支持 time,up,down     | 否   |
  | offset             | `integer` | 起始位置              | 1~9223372036854775807 | 否   |
  | limit              | `integer` | 获取条数              | 1~9223372036854775807 | 否   |

- 返回示例：

```json
{
    "code": 1,
    "msg": "获取成功",
    "info": {
        "total": 1,
        "rows": [
            {
                "banner_id": 5,
                "banner_title": "4",
                "banner_link": "https://baidu.com",
                "banner_cat": 0,
                "banner_pic": "",
                "banner_stime": 1627920000,
                "banner_etime": 1659456000,
                "banner_type": 0,
                "banner_status": 1,
                "banner_order": 50
            }，
            ...
        ]
    }
}
```

获取广告详情
-------------------------------------------

- 请求路径：`/banner/get_detail`
- 请求方式：`GET`
- 请求参数：

| 名称      | 类型      | 描述   | 限制         | 必填 |
| --------- | --------- | ------ | ------------ | ---- |
| banner_id | `integer` | 类型ID | 0-500，默认0 | 否   |

- 返回示例：

```json
{
    "code": 1,
    "msg": "获取成功",
    "info": [
        {
            "banner_id": 5,
            "banner_title": "4",
            "banner_link": "https://baidu.com",
            "banner_cat": 0,
            "banner_pic": "",
            "banner_stime": 1627920000,
            "banner_etime": 1659456000,
            "banner_type": 0,
            "banner_status": 1,
            "banner_order": 50
        }
    ]
}
```

