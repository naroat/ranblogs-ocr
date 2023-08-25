# openapi 集合

## 版本

PHP >= 7.3

Composer >= 2

## OpenAi使用

拉取项目后通过composer安装组件库， composer >= 2
``` 
composer install
```

.env中添加openai的secret-key
```
SECRET_KEY=sk-xxxxxxxxxxxxxxxxxxxxxxxx
```

## 启动项目

``` 
# 启动
./bin/server.sh start

# 停止
./bin/server.sh stop

# 重启
./bin/server.sh restart
```