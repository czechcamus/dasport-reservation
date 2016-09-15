<?php

namespace backend\modules\reservation\models;

use backend\modules\reservation\Module;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "dr_day".
 *
 * @property integer $id
 * @property integer $plan_id
 * @property integer $day_nr
 * @property integer $is_open
 * @property string $time_from
 * @property string $time_to
 *
 * @property Plan $plan
 */
class Day extends ActiveRecord
{
	const DAY_MONDAY = 1;
	const DAY_TUESDAY = 2;
	const DAY_WEDNESDAY = 3;
	const DAY_THURSDAY = 4;
	const DAY_FRIDAY = 5;
	const DAY_SATURDAY = 6;
	const DAY_SUNDAY = 7;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'dr_day';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['plan_id', 'day_nr', 'time_from', 'time_to'], 'required'],
            [['plan_id', 'day_nr', 'is_open'], 'integer'],
            [['time_from', 'time_to'], 'safe'],
            [['plan_id'], 'exist', 'skipOnError' => true, 'targetClass' => Plan::className(), 'targetAttribute' => ['plan_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Module::t('res', 'ID'),
            'plan_id' => Module::t('res', 'Plan ID'),
            'day_nr' => Module::t('res', 'Day'),
            'is_open' => Module::t('res', 'Is open'),
            'time_from' => Module::t('res', 'Time from'),
            'time_to' => Module::t('res', 'Time to'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPlan()
    {
        return $this->hasOne(Plan::className(), ['id' => 'plan_id']);
    }

	/**
	 * Returns day name
	 * @return string
	 */
	public function getDayName() {
		$dayName = '';
		switch ($this->day_nr) {
			case self::DAY_MONDAY:
				$dayName = Module::t('res', 'monday');
				break;
			case self::DAY_TUESDAY:
				$dayName = Module::t('res', 'tuesday');
				break;
			case self::DAY_WEDNESDAY:
				$dayName = Module::t('res', 'wednesday');
				break;
			case self::DAY_THURSDAY:
				$dayName = Module::t('res', 'thursday');
				break;
			case self::DAY_FRIDAY:
				$dayName = Module::t('res', 'friday');
				break;
			case self::DAY_SATURDAY:
				$dayName = Module::t('res', 'saturday');
				break;
			case self::DAY_SUNDAY:
				$dayName = Module::t('res', 'sunday');
				break;
		}
		return $dayName;
    }

    /**
     * @inheritdoc
     * @return DayQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new DayQuery(get_called_class());
    }
}
