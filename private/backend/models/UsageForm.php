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
use common\utilities\DateToDateValidator;
use common\utilities\NameValidator;
use InvalidArgumentException;
use Yii;

class UsageForm extends BackendForm {

	public $subject_id;
	public $date;
	public $time_from;
	public $time_to;
	public $repetition;
	public $name;
	public $email;
	public $phone;
	public $notice;

	private $_plan;
	private $_dayTimes;

	const NO_REPEAT = 0;
	const DAY_REPEAT = 1;
	const WEEK_REPEAT = 2;
	const TWO_WEEK_REPEAT = 3;
	const MONTH_REPEAT = 4;

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
			[ [ 'name', 'email' ], 'string', 'max' => 50 ],
			[ 'name', NameValidator::className() ],
			[ 'email' , 'email' ],
			[ [ 'phone' ], 'string', 'max' => 20 ],
			[ 'time_from', DateToDateValidator::className(), 'compareAttribute' => 'time_to', 'operator' => '<'],
			[ 'repetition' , 'boolean' ],
			[ 'notice', 'string' ]
		];
	}

	/**
	 * @inheritdoc
	 */
	public function attributeLabels() {
		return [
			'subject_id' => Yii::t('app', 'Subject'),
			'date' => Yii::t('app', 'Date'),
			'name' => Yii::t('app', 'Name'),
			'email' => Yii::t('app', 'Email'),
			'phone' => Yii::t('app', 'Phone'),
			'time_from' => Yii::t('app', 'Time from'),
			'time_to' => Yii::t('app', 'Time to'),
			'repetition' => Yii::t('app', 'Repetition'),
			'notice' => Yii::t('app', 'Notice')
		];
	}

	/**
	 * Sets date attribute
	 * @param $date
	 */
	public function setDate( $date ) {
		$this->date = $date;
		$this->setDayTimes();
	}

	/**
	 * Sets time from and time to attribute
	 * @param $hour_nr
	 */
	public function setTimes($hour_nr) {
		if ($this->_dayTimes) {
			$this->time_from = $this->_dayTimes[$hour_nr];
			$this->time_to = $this->_dayTimes[++$hour_nr];
		}
	}

	/**
	 * Returns repeat options array
	 * @return array
	 */
	public function getRepeatOptions() {
		return [
			self::NO_REPEAT => Yii::t('back', 'no repeat'),
			self::DAY_REPEAT => Yii::t('back', 'daily'),
			self::WEEK_REPEAT => Yii::t('back', 'weekly'),
			self::TWO_WEEK_REPEAT => Yii::t('back', 'fortnightly'),
			self::MONTH_REPEAT => Yii::t('back', 'monthly')
		];
	}

	/**
	 * Returns day times array
	 * @return array
	 */
	public function getDayTimes() {
		return $this->_dayTimes ?: [];
	}

	/**
	 * Sets day times array
	 */
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