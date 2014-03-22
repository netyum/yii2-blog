yii2-blog
=========

a blog web app for yii2


# 安装

```
cd yii2-blog
composer install
```

如果不能使用composer，请前在这里下载 http://121.199.39.90/yii2-blog.tgz

# 部署

通常向web目录指向yii2-blog/web即可，需要配置一个yii2-blog/config/mail.php, 设置一个你的smtp

```
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

默认管理员帐号是 admin@yiibook 
密码是  yiibook

# 演示地址

http://110.76.45.201
