<?php
$content= <<<EOF
yii2 blog
=========

# 源码

https://github.com/netyum/yii2-blog

# 安装

```bash
cd yii2-blog
composer install
```

#初始化数据

```bash
php yii mirgate
```

# 部署

通常向web目录指向yii2-blog/web即可，需要配置一个yii2-blog/config/mail.php, 设置一个你的smtp

```php
<?php
return [
    'class' => 'yii\swiftmailer\Mailer',
    'transport' => [
        'class' => 'Swift_SmtpTransport',
        'host' => '',  //smtp服务器
        'username' => '',  //帐号
        'password' => '',  //密码
        'port' => '',      //对应端口
        'encryption' => 'tls', //发送协议
    ],  
    'messageConfig' => [
        'charset' => 'UTF-8',
        // ['email'=>'name']  
        //'from' => ['' => '']  //email发送时使用的，email地址即和上面的smtp一样，后面的name随便，别人收后看到的是name
    ]   
];
```

默认管理员帐号是 admin@yiibook.com
密码是  yiibook

# 演示地址

http://yii2-blog.yiibook.com
EOF;

return [
    'one' => [
        'category_id' => 1,
		'user_id' => 1,
        'title' => 'yii2-blog说明',
		'slug' => 'readme',
		'content' => $content,
        'comments_count' => 0,
		'created_at' => '2014-04-29 15:41:38',
		'updated_at' => '2014-04-29 15:41:38'
    ],
];