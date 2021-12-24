# 友情链接模块（Link）

友情链接列表
-------------------------------------------

- 请求路径：`/link/get_list`
- 请求方式：`GET`
- 请求参数：

| 名称       | 类型      | 描述         | 限制                    | 必填 |
| ---------- | --------- | ------------ | ----------------------- | ---- |
| offset     | `integer` | 起始位置     | 0-500，默认0            | 否   |
| limit      | `integer` | 获取条数     | 1-500，默认20           | 否   |
| id         | `integer` | 仅查询此ID   | 1~9223372036854775807   | 否   |
| type       | `integer` | 类型ID       | 1~9223372036854775807   | 否   |
| name       | `string`  | 友情链接名称 | 最大100字符             | 否   |
| sort       | `integer` | 排序类型ID   | 1~9223372036854775807   | 否   |
| time_start | `integer` | 增加时间开始 | 1~9223372036854775807   | 否   |
| time_end   | `integer` | 增加时间结束 | 1~9223372036854775807   | 否   |
| orderby    | `string`  | 排序         | 支持 id, time, time_add | 否   |

- 返回示例：

```json
{
    "code": 1,
    "msg": "获取成功",
    "info": {
        "total": 3,
        "rows": [
            {
                "link_id": 1,
                "link_type": 0,
                "link_name": "美剧网",
                "link_sort": 0,
                "link_add_time": 1607063109,
                "link_time": 1611987942,
                "link_url": "https://mjhd.tv",
                "link_logo": ""
            },
            ....
        ]
    }
}
```

