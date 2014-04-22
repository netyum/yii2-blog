<?php

use yii\db\Schema;
use Carbon\Carbon;
class m140422_024415_init extends \yii\db\Migration
{
    public function up()
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
            'category_id' => Schema::TYPE_INTEGER .' NOT NULL',
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
            $this->addForeignKey('f', '{{%category}}', 'id', '{{%article}}', 'category_id');
            $this->addForeignKey('f', '{{%article}}', 'category_id', '{{%category}}', 'id');
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
    }

    public function down()
    {
        $tables = array('activation', 'article', 'category', 'comment', 'password_reminder', 'user');
        foreach($tables as $table) {
            $tablename = '{{%'. $table .'}}';
            try { $this->dropTable($tablename); } catch (Exception $e) {}
        }
    }
}
