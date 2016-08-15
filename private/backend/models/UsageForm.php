<?php
/**
 * Created by PhpStorm.
 * User: Pavel
 * Date: 8.8.2016
 * Time: 8:11
 */

namespace backend\models;


use backend\utilities\BackendForm;
use common\models\Day;
use common\models\Plan;
use common\models\Usage;
use InvalidArgumentException;
use Yii;
use yii\base\Exception;

class UsageForm extends BackendForm {

	public $subject_id;
	public $date;
	public $time_from;
	public $time_to;

	private $_plan;
	private $_dayTimes;

	public function __construct( $config ) {
		$this->_plan = Plan::findOne($config['plan_id']);
		$this->modelClass = Usage::className();
		array_shift( $config );
		parent::__construct( $config );
	}

	/**
	 * @inheritdoc
	 */
	public function rules() {
		return [
			[ [ 'subject_id', 'date', 'time_from', 'time_to' ], 'safe' ]
		];
	}

	/**
	 * @inheritdoc
	 */
	public function attributeLabels() {
		return [
			'subject_id' => Yii::t('app', 'Subject'),
			'date' => Yii::t('app', 'Date'),
			'time_from' => Yii::t('app', 'Time from'),
			'time_to' => Yii::t('app', 'Time to'),
		];
	}

	public function setDate( $date ) {
		$this->date = $date;
		$this->setDayTimes();
	}

	public function setTimes($hour_nr) {
		$this->time_from = $this->_dayTimes[$hour_nr];
		$this->time_to = $this->_dayTimes[++$hour_nr];
	}

	private function setDayTimes() {
		if ($this->date == null) {
			throw new InvalidArgumentException( Yii::t( 'back', 'Date not set!' ) );
		}
		$dayWeekNr = date('N', Yii::$app->formatter->asTimestamp($this->date));
		$day = Day::find()->where(['plan_id' => $this->_plan->id])->andWhere(['day_nr' => $dayWeekNr])->one();
		$dayTimes = [];
		for ($i = strtotime($this->_plan->time_from), $j = 1; $i <= strtotime($this->_plan->time_to); $i += (60 * $this->_plan->hour_length)) {
			if ($i >= strtotime($day->time_from) && $i <= strtotime($day->time_to)) {
				$dayTimes[strval($j)] = date('H:i', $i);
			}
			++$j;
		}
		$this->_dayTimes = $dayTimes;
	}
}