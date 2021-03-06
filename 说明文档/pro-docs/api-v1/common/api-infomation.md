接口概况
========================================

## 通用说明
- 接口的输入和输出，使用UTF-8编码
- 接口返回以json格式输出
- 接口在正常状态下，HTTP返回码均为200（不同于业务返回码code）
- 所有接口采用https协议
- API请求前缀: `https://{你的域名}/api.php/`

## 接口返回节点
- `code`: 
    - 整型数值
    - 业务返回码，1表示成功，非1为失败
    - 在接口返回码(code)不为1时，业务未特殊限制时，前端报错以返回的msg为准
    - 在某些异常情况下获取不到msg时，前端默认处理异常信息
- `msg`: 
    - 字符串类型
    - 返回信息，可能为空，根据业务不同使用
- `info`: 
    - json结构字符串
    - 数据节点，可能为空{}，不为空时，定义参考返回示例
