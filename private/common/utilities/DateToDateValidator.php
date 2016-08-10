<?php
/**
 * Created by PhpStorm.
 * User: Pavel
 * Date: 9.8.2016
 * Time: 8:21
 */

namespace common\utilities;


use yii\validators\Validator;

class DateToDateValidator extends Validator
{
	public $compareAttribute;
	public $operator;

	public function validateAttribute( $model, $attribute ) {
		$error = false;
		$value1 = \Yii::$app->formatter->asTimestamp($model->$attribute);
		$value2 = \Yii::$app->formatter->asTimestamp($model->{$this->compareAttribute});
		switch ($this->operator) {
			case "<":
				if (!($value1 < $value2)) {
					$this->message = \Yii::t('app', 'First date must be smaller then last date!');
					$error = true;
				}
				break;
			case "<=":
				if (!($value1 <= $value2)) {
					$this->message = \Yii::t('app', 'First date must be smaller or equal then last date!');
					$error = true;
				}
				break;
			case "!=":
				if (!($value1 != $value2)) {
					$this->message = \Yii::t('app', 'First date must not be equal last date!');
					$error = true;
				}
				break;
			case ">":
				if (!($value1 > $value2)) {
					$this->message = \Yii::t('app', 'First date must be greater then last date!');
					$error = true;
				}
				break;
			case ">=":
				if (!($value1 >= $value2)) {
					$this->message = \Yii::t('app', 'First date must be greater or equal then last date!');
					$error = true;
				}
				break;
			default:
				if (!($value1 == $value2)) {
					$this->message = \Yii::t('app', 'First date must be equal then last date!');
					$error = true;
				}
				break;
		}
		if ($error === true)
			$model->addError($attribute, $this->message);
	}
}