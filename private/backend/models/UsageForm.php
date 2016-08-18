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
use common\models\Subject;
use common\models\Usage;
use common\utilities\DateToDateValidator;
use common\utilities\NameValidator;
use common\utilities\RepetitionValidator;
use InvalidArgumentException;
use Yii;

class UsageForm extends BackendForm {

	public $subject_id;
	public $device_id;
	public $date;
	public $time_from;
	public $time_to;
	public $hour_nr;
	public $repetition;
	public $repetition_end_date;
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
	const THREE_WEEK_REPEAT = 4;
	const FOUR_WEEK_REPEAT = 5;

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
			[ [ 'phone', 'email' ], 'required' ],
			[ [ 'name', 'email' ], 'string', 'max' => 50 ],
			[ 'name', 'required', 'when' => function($model) {
				return $model->subject_id < 1;
			} ],
			[ 'name', NameValidator::className(), 'when' => function($model) {
				return $model->subject_id < 1;
			} ],
			[ 'email' , 'email' ],
			[ 'phone', 'string', 'max' => 20 ],
			[ [ 'time_from', 'time_to' ], 'integer' ],
			[ 'time_from', 'compare', 'compareAttribute' => 'time_to', 'operator' => '<'],
			[ 'repetition_end_date', 'date', 'format' => 'y-MM-dd' ],
			[ 'repetition_end_date', DateToDateValidator::className(), 'compareAttribute' => 'date', 'operator' => '>=' ],
			[ 'repetition' , RepetitionValidator::className(), 'limitsAttributes' => ['time_from', 'time_to'] ],
			[ 'notice', 'string' ],
			[ [ 'date', 'subject_id' ], 'safe' ]
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
			'repetition_end_date' => Yii::t('app', 'Repetition end date'),
			'notice' => Yii::t('app', 'Notice')
		];
	}

	/**
	 * Saves model to database
	 *
	 * @param bool $insert
	 */
	public function save( $insert = true ) {
		$this->device_id = $this->_plan->device_id;
		if (!($this->subject_id > 0)) {
			$this->saveSubject();
		}
		if ($insert) {
			$dayTimeValue = 86400;
			switch ($this->repetition) {
				case self::DAY_REPEAT:
					$additionalTime = $dayTimeValue;
					break;
				case self::WEEK_REPEAT:
					$additionalTime = 7 * $dayTimeValue;
					break;
				case self::TWO_WEEK_REPEAT;
					$additionalTime = 14 * $dayTimeValue;
					break;
				case self::THREE_WEEK_REPEAT;
					$additionalTime = 21 * $dayTimeValue;
					break;
				case self::FOUR_WEEK_REPEAT;
					$additionalTime = 28 * $dayTimeValue;
					break;
				default:
					$this->repetition_end_date = $this->date;
					$additionalTime = $dayTimeValue;
					break;
			}
			/** @noinspection PhpUndefinedFieldInspection */
			for ($i = \Yii::$app->formatter->asTimestamp($this->date); $i <= \Yii::$app->formatter->asTimestamp($this->repetition_end_date); $i += $additionalTime) {
				if ($day = Day::find()->where([
					'plan_id' => $this->_plan->id,
					'is_open' => 1,
					'day_nr' => date('N', $i)
				])->one()) {
					for ($j = $this->time_from; $j < $this->time_to; ++$j) {
						$jTimestamp = Yii::$app->formatter->asTimestamp($this->getDayTimes()[$j]);
						if ($jTimestamp >= Yii::$app->formatter->asTimestamp($day->time_from) && $jTimestamp <= Yii::$app->formatter->asTimestamp($day->time_to)) {
							$this->date = Yii::$app->formatter->asDate($i, 'y-MM-dd');
							$this->hour_nr = $j;
							parent::save($insert);
						}
					}
				}
			}
		} else {
			parent::save($insert);
		}
	}

	/**
	 * Sets date attribute
	 * @param $date
	 */
	public function setDate( $date ) {
		$this->date = $date;
		$this->repetition_end_date = $date;
		$this->setDayTimes();
	}

	/**
	 * Sets time from and time to attribute
	 * @param $hour_nr
	 */
	public function setTimes($hour_nr) {
		$this->time_from = $hour_nr;
		$this->time_to = ++$hour_nr;
	}

	/**
	 * Returns repeat options array
	 * @return array
	 */
	public function getRepeatOptions() {
		return [
			self::NO_REPEAT         => Yii::t('back', 'no repeat'),
			self::DAY_REPEAT        => Yii::t('back', 'daily'),
			self::WEEK_REPEAT       => Yii::t('back', 'weekly'),
			self::TWO_WEEK_REPEAT   => Yii::t('back', 'one time in two weeks'),
			self::THREE_WEEK_REPEAT => Yii::t('back', 'one time in three weeks'),
			self::FOUR_WEEK_REPEAT => Yii::t('back', 'one time in four weeks'),
		];
	}

	/**
	 * Returns plan object
	 * @return Plan
	 */
	public function getPlan() {
		return $this->_plan;
	}

	/**
	 * Returns day times array
	 * @return array
	 */
	public function getDayTimes() {
		if (!$this->_dayTimes) {
			$this->setDayTimes();
		}
		return $this->_dayTimes;
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

	/**
	 * Saves new subject
	 * @return int
	 */
	private function saveSubject() {
		$subjectModel = new Subject;
		$subjectModel->attributes = $this->toArray(['name', 'email', 'phone']);
		if ($subjectModel->save()) {
			$this->subject_id = $subjectModel->id;
		}
	}
}