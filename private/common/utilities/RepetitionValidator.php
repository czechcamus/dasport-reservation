<?php
/**
 * Created by PhpStorm.
 * User: Pavel
 * Date: 10.8.2016
 * Time: 16:08
 */

namespace common\utilities;


use backend\models\UsageForm;
use common\models\Usage;
use yii\base\InvalidParamException;
use yii\validators\Validator;

/**
 * Class RepetitionValidator checks if usage is not in conflict with another usage
 * Validated attribute is repetition
 *
 * @param $limitsAttributes array is array of usage from and usage to hour number
 *
 * @package common\utilities
 */
class RepetitionValidator extends Validator {

	public $limitsAttributes;

	public function validateAttribute( $model, $attribute ) {
		if ( empty( $this->limitsAttributes ) || count( $this->limitsAttributes ) != 2 ) {
			throw new InvalidParamException( \Yii::t( 'app', 'No time limits parameters!' ) );
		} else {
			$error           = false;
			$conflictUsages  = [ ];
			$requestedUsages = [ ];
			/** @noinspection PhpUndefinedFieldInspection */
			if ( $model->item_id ) {
				/** @noinspection PhpUndefinedFieldInspection */
				/** @noinspection PhpUndefinedMethodInspection */
				$usages = Usage::find()->where( [ 'device_id' => $model->plan->device_id ] )->andWhere( [
					'!=',
					'id',
					$model->item_id
				] )->all();
			} else {
				/** @noinspection PhpUndefinedFieldInspection */
				/** @noinspection PhpUndefinedMethodInspection */
				$usages = Usage::findAll( [ 'device_id' => $model->plan->device_id ] );
			}

			/** @var UsageForm $model */
			$dayTimeValue = 86400;
			switch ($model->$attribute) {
				case UsageForm::DAY_REPEAT:
					$additionalTime = $dayTimeValue;
					break;
				case UsageForm::WEEK_REPEAT:
					$additionalTime = 7 * $dayTimeValue;
					break;
				case UsageForm::TWO_WEEK_REPEAT;
					$additionalTime = 14 * $dayTimeValue;
					break;
				case UsageForm::THREE_WEEK_REPEAT;
					$additionalTime = 21 * $dayTimeValue;
					break;
				case UsageForm::FOUR_WEEK_REPEAT;
					$additionalTime = 28 * $dayTimeValue;
					break;
				default:
					$model->repetition_end_date = $model->date;
					$additionalTime = $dayTimeValue;
					break;
			}
			/** @noinspection PhpUndefinedFieldInspection */
			for ($i = \Yii::$app->formatter->asTimestamp($model->date); $i <= \Yii::$app->formatter->asTimestamp($model->repetition_end_date); $i += $additionalTime) {
				for ($j = $model->{$this->limitsAttributes[0]}; $j < $model->{$this->limitsAttributes[1]}; ++$j) {
					$requestedUsages[] = [
						'date' => \Yii::$app->formatter->asDate($i, 'y-MM-dd'),
						'hour_nr' => $j
					];
				}
			}

			/** @var Usage $usage */
			foreach ( $usages as $usage ) {
				$searchedArray = [
					'date' => $usage->date,
					'hour_nr' => $usage->hour_nr
				];
				if (array_search($searchedArray, $requestedUsages)) {
					/** @noinspection PhpUndefinedFieldInspection */
					$conflictUsages[] = \Yii::$app->formatter->asDate($usage->date, 'dd.MM.y') . ' ' . $model->dayTimes[$usage->hour_nr] . ': ' . $usage->subject->name;
					$error           = true;
				}
			}
			if ( $error === true ) {
				$this->message = \Yii::t( 'app',
						'This usage is in conflict with one or more other usages' ) . ': ' . implode( ', ',
						$conflictUsages );
				$model->addError( $attribute, $this->message );
			}
		}
	}
}