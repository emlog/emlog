# Storage XSS ATTACKS | 存储型XSS攻击
前台注册用户可插入恶意代码攻击后台

## Supported Versions | 支持的版本

| Version | Supported          |
| ------- | ------------------ |
| pro2.2.0 | :white_check_mark: |
| pro2.1.15 | :white_check_mark: |


## Report | 报告详情
#### 注册用户发布新文章
![image](https://github.com/emlog/emlog/assets/130351664/815cf3b9-d91d-476c-a183-3b360cb2d454)

发表，抓包，修改，放包。
![image](https://github.com/emlog/emlog/assets/130351664/38a30ceb-c3f5-45d3-ba1e-a9256e600d67)

可以在管理后台查看到刚刚发布的这台新文章
![image](https://github.com/emlog/emlog/assets/130351664/6f570b71-12e3-4652-bbed-c6ad4c07dc96)

点进去查看文章详情。
![image](https://github.com/emlog/emlog/assets/130351664/156eaeb6-126b-4d40-9f15-f49ddeb6ba0a)

可以看到存储型XSS攻击成功

