<?php
/**
 * Created by PhpStorm.
 * User: Pavel
 * Date: 8.8.2016
 * Time: 8:11
 */

namespace backend\models;


use backend\utilities\BackendForm;
use common\models\Plan;
use common\utilities\DateToDateValidator;
use common\utilities\PlanValidator;
use Yii;

class PlanForm extends BackendForm {

	public $date_from;
	public $date_to;
	public $time_from;
	public $time_to;
	public $hour_length;
	public $device_id;

	public function __construct( $config ) {
		$this->device_id  = $config['device_id'];
		$this->modelClass = Plan::className();
		array_shift( $config );
		parent::__construct( $config );
	}

	/**
	 * @inheritdoc
	 */
	public function rules() {
		return [
			[ [ 'date_from', 'date_to', 'time_from', 'time_to', 'hour_length' ], 'required' ],
			[ [ 'date_from', 'date_to' ], 'date', 'format' => 'y-MM-dd' ],
			[ 'date_from', DateToDateValidator::className(), 'compareAttribute' => 'date_to', 'operator' => '<'],
			[ 'date_to', PlanValidator::className(), 'firstAttribute' => 'date_from'],
			[ [ 'time_from', 'time_to' ], 'date', 'format' => 'HH:mm' ],
			[ 'hour_length', 'integer' ]
		];
	}

	/**
	 * @inheritdoc
	 */
	public function attributeLabels() {
		return [
			'date_from'   => Yii::t( 'back', 'Date from' ),
			'date_to'     => Yii::t( 'back', 'Date to' ),
			'time_from'   => Yii::t( 'back', 'Time from' ),
			'time_to'     => Yii::t( 'back', 'Time to' ),
			'hour_length' => Yii::t( 'back', 'Length of hour (min.)' ),
			'device_id'   => Yii::t( 'back', 'Device ID' )
		];
	}
}