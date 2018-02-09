<?php

use yii\db\Migration;

/**
 * Handles the creation of table `post`.
 */
class m180201_181502_create_post_table extends Migration {

    public function up() {
        $this->createTable('{{%post}}', [
            'id' => $this->primaryKey(),
            'module' => $this->string(100)->notNull(),
            'title' => $this->string(255),
            'slug' => $this->string(100),
            'excerpt' => $this->string(),
            'content' => $this->text(),
            'created_at' => $this->integer()->notNull(),
            'updated_at' => $this->integer()->notNull(),
        ]);
        $this->createIndex('slug-category-idx', '{{%post}}', ['module', 'slug'], true);
    }

    public function down() {
        $this->dropTable('{{%post}}');
    }
}
