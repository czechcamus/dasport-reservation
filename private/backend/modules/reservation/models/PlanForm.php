<?php
/**
 * Created by PhpStorm.
 * User: Pavel
 * Date: 8.8.2016
 * Time: 8:11
 */

namespace backend\modules\reservation\models;


use backend\modules\reservation\Module;
use backend\modules\reservation\utilities\BackendForm;
use backend\modules\reservation\utilities\DateToDateValidator;
use backend\modules\reservation\utilities\PlanValidator;

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
			'date_from'   => Module::t('res', 'Date from' ),
			'date_to'     => Module::t('res', 'Date to' ),
			'time_from'   => Module::t('res', 'Time from' ),
			'time_to'     => Module::t('res', 'Time to' ),
			'hour_length' => Module::t('res', 'Length of hour (min.)' ),
			'device_id'   => Module::t('res', 'Device ID' )
		];
	}
}