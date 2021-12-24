# 留言本模块（gbook）

留言本列表
-------------------------------------------

- 请求路径：`/gbook/get_list`
- 请求方式：`GET`
- 请求参数：

| 名称       | 类型      | 描述               | 限制                  | 必填 |
| ---------- | --------- | ------------------ | --------------------- | ---- |
| offset     | `integer` | 起始位置           | 0-500，默认0          | 否   |
| limit      | `integer` | 获取条数           | 1-500，默认20         | 否   |
| id         | `integer` | 编号               | 1~9223372036854775807 | 否   |
| user_id    | `integer` | 用户ID             | 1~9223372036854775807 | 否   |
| status     | `integer` | 状态               | 0未审核 1已审核 ..    | 否   |
| name       | `string`  | 昵称               | 最大20字              | 否   |
| content    | `string`  | 留言内容           | 最大20字              | 否   |
| orderby    | `string`  | id,time,reply_time | 排序倒序              | 否   |
| time_start | `integer` | 开始时间           | 1~9223372036854775807 | 否   |
| time_end   | `integer` | 结束时间           | 1~9223372036854775807 | 否   |

- 返回示例：

```json
{
    "code": 1,
    "msg": "获取成功",
    "info": {
        "offset": 0,
        "limit": 20,
        "total": 1,
        "rows": [
            {
                "gbook_id": 2,
                "gbook_rid": 0,
                "user_id": 0,
                "gbook_status": 1,
                "gbook_name": "游客",
                "gbook_ip": 0,
                "gbook_time": 1622244382,
                "gbook_reply_time": 0,
                "gbook_content": "嫂子",
                "gbook_reply": ""
            },
            ...
        ]
    }
}
```

