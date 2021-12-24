# 用户模块（user）

获取用户列表
-------------------------------------------

- 请求路径：`/user/get_list`
- 请求方式：`GET`
- 请求参数：

| 名称       | 类型      | 描述             | 限制                             | 必填 |
| ---------- | --------- | ---------------- | -------------------------------- | ---- |
| offset     | `integer` | 起始位置         | 0-500，默认0                     | 否   |
| limit      | `integer` | 获取条数         | 1-500，默认20                    | 否   |
| name       | `string`  | 用户名           | 最大50字符                       | 否   |
| nickname   | `string`  | 用户昵称         | 最大50字符                       | 否   |
| email      | `string`  | 用户邮箱         | 最大50字符                       | 否   |
| qq         | `string`  | 用户qq           | 最大50字符                       | 否   |
| phone      | `string`  | 用户手机号码     | 最大50字符                       | 否   |
| time_start | `integer` | 用户创建时间开始 | 1~9223372036854775807            | 否   |
| time_end   | `integer` | 用户创建时间结束 | 1~9223372036854775807            | 否   |
| group_id   | `integer` | 分组ID           | 1~9223372036854775807            | 否   |
| orderby    | `string`  | 排序             | 支持login_time, reg_time, points | 否   |

- 返回示例：

```json
{
    "code": 1,
    "msg": "获取成功",
    "info": {
        "total": 1,
        "rows": [
            {
                "user_id": 5,
                "user_name": "childchild1",
                "user_nick_name": "",
                "user_phone": ""
            },
            ...
        ]
    }
}
```



获取用户详情
-------------------------------------------

- 请求路径：`/user/get_detail`
- 请求方式：`GET`
- 请求参数：

| 名称 | 类型      | 描述   | 限制                  | 必填 |
| ---- | --------- | ------ | --------------------- | ---- |
| id   | `integer` | 用户ID | 1~9223372036854775807 | 否   |

- 返回示例：

```json
{
    "code": 1,
    "msg": "获取成功",
    "info": {
        "total": 1,
        "rows": [
            {
                "user_id": 5,
                "group_id": 2,
                "user_name": "childchild1",
                "user_pwd": "3837a6be5d5a64b70b1f9e0e052ba103",
                "user_nick_name": "",
                "user_qq": "",
                "user_email": "",
                "user_phone": "",
                "user_status": 1,
                "user_portrait": "",
                "user_portrait_thumb": "",
                "user_openid_qq": "",
                "user_openid_weixin": "",
                "user_question": "",
                "user_answer": "",
                "user_points": 10,
                "user_points_froze": 0,
                "user_reg_time": 1626754683,
                "user_reg_ip": 2130706433,
                "user_login_time": 1626754683,
                "user_login_ip": 2130706433,
                "user_last_login_time": 0,
                "user_last_login_ip": 0,
                "user_login_num": 1,
                "user_extend": 0,
                "user_random": "34e772b435c48f52432b3e02853bbf93",
                "user_end_time": 0,
                "user_pid": 2,
                "user_pid_2": 1,
                "user_pid_3": 0
            },
            ...
        ]
    }
}
```

