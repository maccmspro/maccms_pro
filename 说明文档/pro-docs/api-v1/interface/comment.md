# 评论模块（comment）

获取评论
-------------------------------------------

- 请求路径：`/comment/get_list`
- 请求方式：`GET`
- 请求参数：

| 名称    | 类型      | 描述     | 限制                  | 必填 |
| ------- | --------- | -------- | --------------------- | ---- |
| offset  | `integer` | 起始位置 | 0-500，默认0          | 否   |
| limit   | `integer` | 获取条数 | 1-500，默认20         | 否   |
| rid     | `integer` | 视频ID   | 1~9223372036854775807 | 否   |
| orderby | `string`  | 排序     | 支持 time,up,down     | 否   |

- 返回示例：

```json
{
    "code": 1,
    "msg": "获取成功",
    "info": {
        "offset": 0,
        "limit": 20,
        "total": 3,
        "rows": [
            {
                "comment_id": 3,
                "comment_mid": 3,
                "comment_rid": 3,
                "comment_pid": 0,
                "user_id": 3,
                "comment_status": 1,
                "comment_name": "昵称3",
                "comment_ip": 885646400,
                "comment_time": 345678900,
                "comment_content": "昵称内容3",
                "comment_up": 3,
                "comment_down": 1,
                "comment_reply": 0,
                "comment_report": 0
            },
            ...
        ]
    }
}
```

