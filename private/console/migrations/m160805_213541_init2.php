<?php

use yii\db\Migration;

class m160805_213541_init2 extends Migration
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

		$this->createIndex(
			'idx-plan-device_id',
			'dr_plan',
			'device_id'
		);

		$this->addForeignKey(
			'fk-plan-device_id',
			'dr_plan',
			'device_id',
			'dr_device',
			'id',
			'CASCADE'
		);

		$this->createTable('dr_week', [
			'id' => $this->primaryKey(),
			'plan_id' => $this->integer()->notNull(),
			'day_nr' => $this->smallInteger()->notNull(),
			'is_open' => $this->boolean(),
			'time_from' => $this->time()->notNull(),
			'time_to' => $this->time()->notNull()
		], $tableOptions);

		$this->createIndex(
			'idx-week-plan_id',
			'dr_week',
			'plan_id'
		);

		$this->addForeignKey(
			'fk-week-plan_id',
			'dr_week',
			'plan_id',
			'dr_plan',
			'id',
			'CASCADE'
		);

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

		$this->createIndex(
			'idx-price-device_id',
			'dr_price',
			'device_id'
		);

		$this->addForeignKey(
			'fk-price-device_id',
			'dr_price',
			'device_id',
			'dr_device',
			'id',
			'CASCADE'
		);

		$this->createTable('dr_usage', [
			'id' => $this->primaryKey(),
			'device_id' => $this->integer()->notNull(),
			'subject_id' => $this->integer()->notNull(),
			'date' => $this->date()->notNull(),
			'hour_nr' => $this->smallInteger()->notNull(),
			'notice' => $this->string()
		], $tableOptions);

		$this->createIndex(
			'idx-usage-device_id',
			'dr_usage',
			'device_id'
		);

		$this->createIndex(
			'idx-usage-subject_id',
			'dr_usage',
			'subject_id'
		);

		$this->addForeignKey(
			'fk-usage-device_id',
			'dr_usage',
			'device_id',
			'dr_device',
			'id',
			'CASCADE'
		);

		$this->addForeignKey(
			'fk-usage-subject_id',
			'dr_usage',
			'subject_id',
			'dr_subject',
			'id',
			'CASCADE'
		);

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

		$this->createIndex(
			'idx-request-device_id',
			'dr_request',
			'device_id'
		);

		$this->addForeignKey(
			'fk-request-device_id',
			'dr_request',
			'device_id',
			'dr_device',
			'id',
			'CASCADE'
		);
	}

	public function safeDown()
	{
		$this->dropForeignKey('fk-request-device_id', 'dr_request');
		$this->dropForeignKey('fk-usage-subject_id', 'dr_usage');
		$this->dropForeignKey('fk-usage-device_id', 'dr_usage');
		$this->dropForeignKey('fk-price-device_id', 'dr_price');
		$this->dropForeignKey('fk-week-plan_id', 'dr_week');
		$this->dropForeignKey('fk-plan-device_id', 'dr_plan');
		$this->dropIndex('idx-request-device_id', 'dr_request');
		$this->dropIndex('idx-usage-subject_id', 'dr_usage');
		$this->dropIndex('idx-usage-device_id', 'dr_usage');
		$this->dropIndex('idx-price-device_id', 'dr_price');
		$this->dropIndex('idx-week-plan_id', 'dr_week');
		$this->dropIndex('idx-plan-device_id', 'dr_plan');
		$this->dropTable('dr_device');
		$this->dropTable('dr_plan');
		$this->dropTable('dr_week');
		$this->dropTable('dr_subject');
		$this->dropTable('dr_price');
		$this->dropTable('dr_usage');
		$this->dropTable('dr_request');
	}
}
