# WebMIS
WebMIS是轻量级、高性能、面向对象的HMVC框架！<br>
Home: http://mvc.webmis.vip/<br>
Admin: http://mvc.webmis.vip/admin/<br>
uanme: admin  passwd: admin

# 安装
### 1) Composer方式
``` bash
composer create-project webmiss/webmis=1.0.* mvc
```
或者 composer.json
``` bash
{
    "require": {
        "webmiss/webmis":"1.0.*"
    }
}
```
### 导入数据库
``` bash
public/db/mvc.sql
```

# 美化URL
### 1) Apache
```bash
AllowOverride All
Require all granted
Options Indexes FollowSymLinks
```
public/.htaccess
```bash
AddDefaultCharset UTF-8

<IfModule mod_rewrite.c>
    RewriteEngine On
    RewriteCond %{REQUEST_FILENAME} !-d
    RewriteCond %{REQUEST_FILENAME} !-f
    RewriteRule ^(.*)$ index.php?_url=/$1 [QSA,L]
</IfModule>
```

### 2) Nginx
```bash
listen 80;
server_name mvc.webmis.cn;

set $root_path '/home/www/mvc/public/';
root $root_path;
index index.php index.html;

try_files $uri $uri/ @rewrite;
location @rewrite {
    rewrite ^/(.*)$ /index.php?_url=/$1;
}

location ~* ^/(webmis|upload|themes|favicon.png)/(.+)$ {
    root $root_path;
}
```

### Url
```bash
Home: http://localhost/
Admin: http://localhost/admin/Index/index
```