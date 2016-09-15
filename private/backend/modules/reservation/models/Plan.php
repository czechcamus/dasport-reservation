<?php

namespace backend\modules\reservation\models;

use backend\modules\reservation\Module;
use backend\modules\reservation\utilities\DaysGenerator;
use backend\modules\reservation\utilities\RelationsDelete;
use yii\db\ActiveRecord;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "dr_plan".
 *
 * @property integer $id
 * @property integer $device_id
 * @property string $date_from
 * @property string $date_to
 * @property string $time_from
 * @property string $time_to
 * @property integer $hour_length
 *
 * @property Device $device
 * @property Day[] $days
 */
class Plan extends ActiveRecord {
	/**
	 * @inheritdoc
	 */
	public static function tableName() {
		return 'dr_plan';
	}

	/**
	 * @inheritdoc
	 */
	public function behaviors() {
		$parentBehaviors = parent::behaviors();
		$thisBehaviors   = [
			'relationDelete' => [
				'class'     => RelationsDelete::className(),
				'relations' => [ 'days' ]
			],
			'days' => [
				'class' => DaysGenerator::className()
			]
		];

		return ArrayHelper::merge( $parentBehaviors, $thisBehaviors );
	}

	/**
	 * @inheritdoc
	 */
	public function rules() {
		return [
			[ [ 'device_id', 'date_from', 'date_to', 'time_from', 'time_to', 'hour_length' ], 'required' ],
			[ [ 'device_id', 'hour_length' ], 'integer' ],
			[ [ 'date_from', 'date_to' ], 'date', 'format' => 'y-MM-dd' ],
			[ [ 'time_from', 'time_to' ], 'date', 'format' => 'HH:mm' ],
			[
				[ 'device_id' ],
				'exist',
				'skipOnError'     => true,
				'targetClass'     => Device::className(),
				'targetAttribute' => [ 'device_id' => 'id' ]
			],
		];
	}

	/**
	 * @inheritdoc
	 */
	public function attributeLabels() {
		return [
			'id'          => Module::t('res', 'ID' ),
			'device_id'   => Module::t('res', 'Device ID' ),
			'date_from'   => Module::t('res', 'Date from' ),
			'date_to'     => Module::t('res', 'Date to' ),
			'time_from'   => Module::t('res', 'Time from' ),
			'time_to'     => Module::t('res', 'Time to' ),
			'hour_length' => Module::t('res', 'Length of hour (min.)' ),
		];
	}

	/**
	 * @return \yii\db\ActiveQuery
	 */
	public function getDevice() {
		return $this->hasOne( Device::className(), [ 'id' => 'device_id' ] );
	}

	/**
	 * @return \yii\db\ActiveQuery
	 */
	public function getDays() {
		return $this->hasMany( Day::className(), [ 'plan_id' => 'id' ] );
	}

	/**
	 * @inheritdoc
	 * @return PlanQuery the active query used by this AR class.
	 */
	public static function find() {
		return new PlanQuery( get_called_class() );
	}
}
