<?php

use yii\db\Schema;
use Carbon\Carbon;

class m140422_024415_init extends \yii\db\Migration
{
    public function safeUp()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB';
        }

        /*
        -- article
        */
        $this->createTable('{{%article}}', [
            'id' => Schema::TYPE_PK,
            'category_id' => Schema::TYPE_INTEGER ." NOT NULL DEFAULT '0'",
            'user_id' => Schema::TYPE_INTEGER .' NOT NULL',
            'title' => Schema::TYPE_STRING . ' NOT NULL',
            'slug' => Schema::TYPE_STRING . ' NOT NULL',
            'content' => Schema::TYPE_TEXT . ' NOT NULL',
            'comments_count' => Schema::TYPE_INTEGER ." NOT NULL DEFAULT '0'",
            'meta_title' => Schema::TYPE_STRING,
            'meta_description' => Schema::TYPE_STRING,
            'meta_keywords' => Schema::TYPE_STRING,
            'created_at' => Schema::TYPE_DATETIME . ' NOT NULL',
            'updated_at' => Schema::TYPE_DATETIME . ' NOT NULL'
        ]);
        $this->createIndex('article_title_unique', '{{%article}}', 'title', true);
        $this->createIndex('article_slug_unique', '{{%article}}', 'slug', true);
        $this->createIndex('article_category_id_index', '{{%article}}', 'category_id');

        /*
        -- category
        */
        $this->createTable('{{%category}}', [
            'id' => Schema::TYPE_PK,
            'name' => Schema::TYPE_STRING .' NOT NULL',
            'sort_order' => Schema::TYPE_INTEGER .' NOT NULL',
            'created_at' => Schema::TYPE_DATETIME .' NOT NULL',
            'updated_at' => Schema::TYPE_DATETIME .' NOT NULL'
        ]);
        $this->createIndex('category_name_unique', '{{%category}}', 'name', true);

        if ($this->db->driverName === 'mysql') {
            $this->addForeignKey('category_article_f', '{{%category}}', 'id', '{{%article}}', 'category_id');
            $this->addForeignKey('article_category_f', '{{%article}}', 'category_id', '{{%category}}', 'id');
        }

        /*
        -- activation
        */
        $this->createTable('{{%activation}}', [
            'id' => Schema::TYPE_PK,
            'email' => Schema::TYPE_STRING .' NOT NULL',
            'token' => Schema::TYPE_STRING .' NOT NULL',
            'created_at' => Schema::TYPE_DATETIME .' NOT NULL'
        ]);
        $this->createIndex('activation_email_index', '{{%activation}}', 'email');
        $this->createIndex('activation_token_index', '{{%activation}}', 'token');

        /*
        -- comment
        */
        $this->createTable('{{%comment}}', [
            'id' => Schema::TYPE_PK,
            'user_id' => Schema::TYPE_INTEGER .' NOT NULL',
            'article_id' => Schema::TYPE_INTEGER .' NOT NULL',
            'content' => Schema::TYPE_TEXT . ' NOT NULL',
            'created_at' => Schema::TYPE_DATETIME . ' NOT NULL',
            'updated_at' => Schema::TYPE_DATETIME . ' NOT NULL',
            'deleted_at' => Schema::TYPE_DATETIME . ' NOT NULL',
        ]);
        $this->createIndex('comment_user_id_index', '{{%comment}}', 'user_id');
        $this->createIndex('comment_article_id_index', '{{%comment}}', 'article_id');

        /*
        -- password_reminder
        */
        $this->createTable('{{%password_reminder}}', [
            'id' => Schema::TYPE_PK,
            'email' => Schema::TYPE_STRING .' NOT NULL',
            'token' => Schema::TYPE_STRING .' NOT NULL',
            'created_at' => Schema::TYPE_DATETIME .' NOT NULL'
        ]);
        $this->createIndex('password_reminder_email_index', '{{%password_reminder}}', 'email');
        $this->createIndex('password_reminder_token_index', '{{%password_reminder}}', 'token');

        /*
        -- user
        */
        $this->createTable('{{%user}}', [
            'id' => Schema::TYPE_PK,
            'email' => Schema::TYPE_STRING .' NOT NULL',
            'password' => Schema::TYPE_STRING .' NOT NULL',
            'portrait' => Schema::TYPE_STRING,
            'is_admin' => Schema::TYPE_SMALLINT ." NOT NULL DEFAULT '0'",
            'signin_at' => Schema::TYPE_DATETIME,
            'activated_at' => Schema::TYPE_DATETIME,
            'created_at' => Schema::TYPE_DATETIME .' NOT NULL',
            'updated_at' => Schema::TYPE_DATETIME .' NOT NULL',
            'salt' => Schema::TYPE_STRING
        ]);
        $this->createIndex('user_email_unique', '{{%user}}', 'email', true);

        $this->insert('{{%user}}', [
            'email' => 'admin@yiibook.com',
            'password'=> '137a420293bd23c9385a979faaf12f4262297d2c',
            'is_admin' => 1,
            'activated_at' => new Carbon,
            'created_at' => new Carbon,
            'updated_at' => new Carbon,
            'salt' => 'FQZ0vaLyPC'
        ]);

        $this->insert('{{%category}}', [
            'name' => 'yii2相关',
            'sort_order' => 1,
            'created_at' => new Carbon,
            'updated_at' => new Carbon,
        ]);

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
        $this->insert('{{%article}}',[
            'category_id' => 1,
            'user_id' => 1,
            'title' => 'yii2-blog说明',
            'slug' => 'readme',
            'content' => $content,
            'created_at' => new Carbon,
            'updated_at' => new Carbon
        ]);
    }

    public function safeDown()
    {
        $tables = array('activation', 'article', 'category', 'comment', 'password_reminder', 'user');
        foreach ($tables as $table) {
            $tablename = '{{%'. $table .'}}';
            try {
                $this->dropTable($tablename);
            } catch (Exception $e) {
            }
        }
    }
}
