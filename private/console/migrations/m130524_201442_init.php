<?php

use yii\db\Migration;

class m130524_201442_init extends Migration
{
    public function safeUp()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            // http://stackoverflow.com/questions/766809/whats-the-difference-between-utf8-general-ci-and-utf8-unicode-ci
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('dr_device', [
            'id' => $this->primaryKey(),
            'text_id' => $this->string(50)->notNull()->unique(),
            'title' => $this->string(50)->notNull(),
            'description' => $this->text()
        ], $tableOptions);

        $this->createTable('dr_plan', [
            'id' => $this->primaryKey(),
            'device_id' => $this->integer()->notNull(),
            'date_from' => $this->date()->notNull(),
            'date_to' => $this->date()->notNull(),
            'hour_length' => $this->integer()->notNull()
        ], $tableOptions);

        $this->createTable('dr_week', [
            'id' => $this->primaryKey(),
            'plan_id' => $this->integer()->notNull(),
            'day_nr' => $this->smallInteger()->notNull(),
	        'is_open' => $this->boolean(),
            'time_from' => $this->time()->notNull(),
            'time_to' => $this->time()->notNull()
        ], $tableOptions);

	    $this->createTable('dr_subject', [
		    'id' => $this->primaryKey(),
		    'name' => $this->string(50)->notNull()->unique(),
		    'email' => $this->string(50)->notNull(),
		    'phone' => $this->string(20)->notNull()
	    ], $tableOptions);

	    $this->createTable('dr_price', [
		    'id' => $this->primaryKey(),
		    'device_id' => $this->integer()->notNull(),
		    'title' => $this->string(50)->notNull(),
		    'price' => $this->integer()->notNull(),
		    'notice' => $this->string()
	    ], $tableOptions);

	    $this->createTable('dr_usage', [
		    'id' => $this->primaryKey(),
		    'device_id' => $this->integer()->notNull(),
		    'subject_id' => $this->integer()->notNull(),
		    'date' => $this->date()->notNull(),
		    'hour_nr' => $this->smallInteger()->notNull(),
		    'notice' => $this->string()
	    ], $tableOptions);

	    $this->createTable('dr_request', [
		    'id' => $this->primaryKey(),
		    'device_id' => $this->integer()->notNull(),
		    'date' => $this->date()->notNull(),
		    'time_from' => $this->time()->notNull(),
		    'time_to' => $this->time()->notNull(),
		    'subject_name' => $this->string(50)->notNull(),
		    'subject_email' => $this->string(50)->notNull(),
		    'subject_phone' => $this->string(20)->notNull(),
		    'notice' => $this->string()
	    ], $tableOptions);

    }

    public function safeDown()
    {
        $this->dropTable('dr_device');
        $this->dropTable('dr_plan');
        $this->dropTable('dr_week');
        $this->dropTable('dr_subject');
        $this->dropTable('dr_price');
        $this->dropTable('dr_usage');
        $this->dropTable('dr_request');
    }
}
