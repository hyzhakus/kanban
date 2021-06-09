<?php

use yii\db\Migration;

/**
 * Class m210609_045816_init_db
 */
class m210609_045816_init_db extends Migration
{
    public function safeUp()
    {
        $this->createTable('users', [
            'id' => $this->primaryKey(),
            'email' => $this->string()->notNull(),
            'password' => $this->string()->notNull(),
            'name' => $this->string()->notNull(),
            'role' => $this->tinyInteger()->notNull(),
        ]);
        $this->createIndex('idx-users-email', 'users', 'email', true);
        $this->insert('users', [
            'id' => 1,
            'email' => 'john@doe.com',
            'password' => '$2y$10$/lukCrCb2ycPGiE4PvGcFupylh2P1Xm6NsM0T98XAlOWGcTWxdXA2',
            'name' => 'John Doe',
            'role' => 1,
        ]);

        $this->createTable('desk', [
            'id' => $this->primaryKey(),
            'name' => $this->string()->notNull(),
            'sort' => $this->tinyInteger()->notNull(),
        ]);
        $this->insert('desk', ['id' => 1, 'name' => 'BACK-LOG', 'sort' => 10]);
        $this->insert('desk', ['id' => 2, 'name' => 'TO-DO', 'sort' => 20]);
        $this->insert('desk', ['id' => 3, 'name' => 'IN-PROGRESS', 'sort' => 30]);
        $this->insert('desk', ['id' => 4, 'name' => 'DONE', 'sort' => 40]);

        $this->createTable('tasks', [
            'id' => $this->primaryKey(),
            'user_id' => $this->integer()->notNull(),
            'desk_id' => $this->integer()->notNull(),
            'created_at' => $this->dateTime()->defaultExpression('CURRENT_TIMESTAMP')->notNull(),
            'name' => $this->string()->notNull(),
            'note' => $this->text(),
            'sort' => $this->tinyInteger()->notNull(),
        ]);
        $this->createIndex('idx-tasks-user_id', 'tasks', 'user_id');
        $this->createIndex('idx-tasks-desk_id', 'tasks', 'desk_id');
        $this->addForeignKey('fk-tasks-user_id', 'tasks', 'user_id', 'users', 'id');
        $this->addForeignKey('fk-tasks-desk_id', 'tasks', 'desk_id', 'desk', 'id');

    }

    public function safeDown()
    {
        $this->dropTable('users');
        $this->dropTable('desk');
        $this->dropTable('tasks');
    }

}
