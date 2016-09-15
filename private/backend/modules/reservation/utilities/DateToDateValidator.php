<?php
/**
 * Created by PhpStorm.
 * User: Pavel
 * Date: 9.8.2016
 * Time: 8:21
 */

namespace backend\modules\reservation\utilities;

use backend\modules\reservation\Module;
use yii\validators\Validator;

/**
 * Class DateToDateValidator compares two dates in format Y-m-d or times in format H:i
 * @param $compareAttribute string attribute to compare with validated attribute
 * @param $operator string - one of '<', '<=', '>', '>=', '!=' or anything what is interpreted as '='
 * @package common\utilities
 */
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
					$this->message = $model->getAttributeLabel($attribute) . ' ' . Module::t('res', 'must be smaller then') . ' ' . $model->getAttributeLabel($this->compareAttribute) . '!';
					$error = true;
				}
				break;
			case "<=":
				if (!($value1 <= $value2)) {
					$this->message = $model->getAttributeLabel($attribute) . ' ' . Module::t('res', 'must be smaller or equal then') . ' ' . $model->getAttributeLabel($this->compareAttribute) . '!';
					$error = true;
				}
				break;
			case "!=":
				if (!($value1 != $value2)) {
					$this->message = $model->getAttributeLabel($attribute) . ' ' . Module::t('res', 'must not be equal') . ' ' . $model->getAttributeLabel($this->compareAttribute) . '!';
					$error = true;
				}
				break;
			case ">":
				if (!($value1 > $value2)) {
					$this->message = $model->getAttributeLabel($attribute) . ' ' . Module::t('res', 'must be greater then') . ' ' . $model->getAttributeLabel($this->compareAttribute) . '!';
					$error = true;
				}
				break;
			case ">=":
				if (!($value1 >= $value2)) {
					$this->message = $model->getAttributeLabel($attribute) . ' ' . Module::t('res', 'must be greater or equal then') . ' ' . $model->getAttributeLabel($this->compareAttribute) . '!';
					$error = true;
				}
				break;
			default:
				if (!($value1 == $value2)) {
					$this->message = $model->getAttributeLabel($attribute) . ' ' . Module::t('res', 'must be equal then') . ' ' . $model->getAttributeLabel($this->compareAttribute) . '!';
					$error = true;
				}
				break;
		}
		if ($error === true)
			$model->addError($attribute, $this->message);
	}
}