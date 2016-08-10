<?php

use yii\db\Migration;

class m160810_045629_update1 extends Migration
{
	public function safeUp()
    {
	    $tableOptions = null;

	    $this->dropForeignKey('fk-week-plan_id', 'dr_week');
	    $this->dropIndex('idx-week-plan_id', 'dr_week');
	    $this->dropTable('dr_week');
	    $this->addColumn('dr_plan', 'time_from', $this->time()->notNull());
	    $this->addColumn('dr_plan', 'time_to', $this->time()->notNull());

	    $this->createTable('dr_day', [
		    'id' => $this->primaryKey(),
		    'plan_id' => $this->integer()->notNull(),
		    'day_nr' => $this->smallInteger()->notNull(),
		    'is_open' => $this->boolean(),
		    'time_from' => $this->time()->notNull(),
		    'time_to' => $this->time()->notNull()
	    ], $tableOptions);

	    $this->createIndex(
		    'idx-day-plan_id',
		    'dr_day',
		    'plan_id'
	    );

	    $this->addForeignKey(
		    'fk-day-plan_id',
		    'dr_day',
		    'plan_id',
		    'dr_plan',
		    'id',
		    'CASCADE'
	    );
    }

    public function safeDown()
    {
	    $tableOptions = null;

    	$this->dropForeignKey('fk-day-plan_id', 'dr_day');
	    $this->dropIndex('idx-day-plan_id', 'dr_day');
	    $this->dropTable('dr_day');

	    $this->dropColumn('dr_plan', 'time_to');
	    $this->dropColumn('dr_plan', 'time_from');

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
    }
}
