# RanBlogs-Ocr

## 服务端

### 版本

PHP >= 7.3

Composer >= 2

### 部署

1. 拉取代码,进入项目目录

2. 复制文件`.env.example`出来并命名`.env`; 按需修改`.env`中的配置，比如数据库，redis,项目命，百度api密钥等

3. 安装组件库: `composer install`

4. 

## 启动项目

``` 
# 启动
./bin/server.sh start

# 停止
./bin/server.sh stop

# 重启
./bin/server.sh restart
```

## 请求示例

![聊天接口示例](https://github.com/zero-rbl/hyperf-openapi/raw/master/docs/images/371681208955_.pic.jpg)

