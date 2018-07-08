<?php

use Webmis\Mvc\Application;

// 自动加载
require_once __DIR__.'/../vendor/autoload.php';

// 配置文件
$config = require __DIR__ . '/../app/config/config.php';

// 创建应用
$app = new Application($config);
echo $app->getContent();
