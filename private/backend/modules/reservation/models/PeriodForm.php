<?php
/**
 * Created by PhpStorm.
 * User: Pavel
 * Date: 12.8.2016
 * Time: 8:44
 */

namespace backend\modules\reservation\models;


use backend\modules\reservation\Module;
use backend\modules\reservation\utilities\DateFutureValidator;
use backend\modules\reservation\utilities\DatePlanValidator;
use backend\modules\reservation\utilities\DateToDateValidator;
use Exception;
use Yii;
use yii\base\Model;
use yii\db\Query;

class PeriodForm extends Model {
	public $firstDate;
	public $lastDate;
	public $device;

	public function __construct( $config ) {
		parent::__construct();
		$this->device = Device::findOne($config['device_id']);
	}

	/**
	 * @inheritdoc
	 */
	public function rules() {
		return [
			[ [ 'firstDate', 'lastDate' ], 'required' ],
			[ [ 'firstDate', 'lastDate' ], 'date', 'format' => 'y-MM-dd' ],
			[ 'firstDate', DateFutureValidator::className() ],
			[ [ 'firstDate', 'lastDate' ], DatePlanValidator::className(), 'device_id' => $this->device->id ],
			[ 'firstDate', DateToDateValidator::className(), 'compareAttribute' => 'lastDate', 'operator' => '<='],

		];
	}

	/**
	 * @inheritdoc
	 */
	public function attributeLabels() {
		return [
			'firstDate' => Module::t('res', 'First date' ),
			'lastDate'  => Module::t('res', 'Last date' )
		];
	}

	/**
	 * Sets default period dates
	 *
	 * @throws Exception
	 */
	public function setDefaultPeriod( ) {
		if ( !$this->firstDate && !$this->lastDate ) {
			$actualDate = date('Y-m-d', time());
			if (( new Query() )->select( 'date_from' )->from( 'dr_plan' )->where( [ 'device_id' => $this->device->id ] )->andWhere( [
				'<=',
				'date_from',
				$actualDate
			] )->andWhere( [
				'>=',
				'date_to',
				$actualDate
			])->count()) {
				$firstDate = $actualDate;
			} else {
				$firstDate = ( new Query() )->select( 'date_from' )->from( 'dr_plan' )->where( [ 'device_id' => $this->device->id ] )->andWhere( [
					'>=',
					'date_from',
					$actualDate
				] )->scalar();
			}

			$this->firstDate = $firstDate;
			$this->lastDate  = date( 'Y-m-d',
				strtotime( $firstDate ) + ( Yii::$app->modules['reservation']->params['dayListDefaultPeriod'] * 86400 ) );
		} else {
			throw new Exception( Module::t('res', 'No date period set!' ) );
		}
	}

	/**
	 * Checking for actual plans
	 *
	 * @return bool
	 */
	public function existsActualPlans( ) {
		$actualPlans = Plan::find()->where( [ 'device_id' => $this->device->id ] )->andWhere( [
			'>',
			'date_to',
			date( 'Y-m-d', time() )
		] )->all();

		return empty( $actualPlans ) ? false : true;
	}
}