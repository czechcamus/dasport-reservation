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

class DayForm extends BackendForm {

	public $day_nr;
	public $is_open;
	public $time_from;
	public $time_to;
	public $plan_id;

	public function __construct( $config ) {
		$this->plan_id  = $config['plan_id'];
		$this->modelClass = Day::className();
		array_shift( $config );
		parent::__construct( $config );
	}

	/**
	 * @inheritdoc
	 */
	public function rules() {
		return [
			[ [ 'time_from', 'time_to' ], 'required' ],
			[ [ 'time_from', 'time_to' ], 'date', 'format' => 'HH:mm' ],
			[ 'is_open', 'boolean' ],
			[ 'day_nr', 'safe' ]
		];
	}

	/**
	 * @inheritdoc
	 */
	public function attributeLabels() {
		return [
			'is_open' => Module::t('res', 'Is open'),
			'time_from' => Module::t('res', 'Time from'),
			'time_to' => Module::t('res', 'Time to'),
			'plan_id'   => Module::t('res', 'Plan ID' )
		];
	}

	/**
	 * Gets day model
	 * @return null|Day
	 */
	public function getDay() {
		$day = null;
		if ($this->item_id) {
			$day = Day::findOne($this->item_id);
		}
		return $day;
	}
}