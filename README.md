# WebMIS
WebMIS is just a development idea.<br>
Home: http://mvc.webmis.vip/<br>
Admin: http://mvc.webmis.vip/admin/<br>
uanme: admin  passwd: admin

# Install
```bash
Database : public/db/mvc.sql
```

# Configuration
### 1) Apache
```bash
AllowOverride All
Require all granted
Options Indexes FollowSymLinks
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