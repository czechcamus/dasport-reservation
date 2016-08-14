<?php
/**
 * Created by PhpStorm.
 * User: Pavel
 * Date: 12.8.2016
 * Time: 8:44
 */

namespace backend\models;


use common\models\Device;
use common\models\Plan;
use common\utilities\DateFutureValidator;
use common\utilities\DatePlanValidator;
use common\utilities\DateToDateValidator;
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
			'firstDate' => Yii::t( 'back', 'First date' ),
			'lastDate'  => Yii::t( 'back', 'Last date' )
		];
	}

	/**
	 * Sets default period dates
	 *
	 * @param $device_id
	 *
	 * @throws Exception
	 */
	public function setDefaultPeriod( $device_id ) {
		if ( $this->existsActualPlans( $device_id ) ) {
			$firstDate = ( new Query() )->select( 'date_from' )->from( 'dr_plan' )->where( [ 'device_id' => $device_id ] )->andWhere( [
				'date_from' => date( 'Y-m-d', time() )
			] )->scalar();
			if ( ! $firstDate ) {
				$firstDate = ( new Query() )->select( 'date_from' )->from( 'dr_plan' )->where( [ 'device_id' => $device_id ] )->andWhere( [
					'>',
					'date_from',
					date( 'Y-m-d', time() )
				] )->scalar();
			}

			$this->firstDate = $firstDate;
			$this->lastDate  = date( 'Y-m-d',
				strtotime( $firstDate ) + ( Yii::$app->params['dayListDefaultPeriod'] * 86400 ) );
		} else {
			throw new Exception( Yii::t( 'app', 'No actual plans available!' ) );
		}
	}

	/**
	 * Checking for actual plans
	 *
	 * @param $device_id
	 *
	 * @return bool
	 */
	public function existsActualPlans( $device_id ) {
		$actualPlans = Plan::find()->where( [ 'device_id' => $device_id ] )->andWhere( [
			'>',
			'date_to',
			date( 'Y-m-d', time() )
		] )->all();

		return empty( $actualPlans ) ? false : true;
	}
}