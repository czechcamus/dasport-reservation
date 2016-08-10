<?php
/**
 * Created by PhpStorm.
 * User: Pavel
 * Date: 9.8.2016
 * Time: 8:21
 */

namespace common\utilities;


use common\models\Device;
use yii\validators\Validator;

class TextIdValidator extends Validator
{
	public function init() {
		parent::init();
		$this->message = \Yii::t('app', 'This text ID is already used!');
	}

	public function validateAttribute( $model, $attribute ) {
		$value = $model->$attribute;
		if (isset($model->id) || isset($model->item_id)) {
			/** @noinspection PhpUndefinedFieldInspection */
			$modelId = isset($model->id) ? $model->id : $model->item_id;
			if (Device::find()->where(['!=', 'id', $modelId])->andWhere(['text_id' => $value])->exists()) {
				$model->addError($attribute, $this->message);
			}
		} else {
			if (Device::find()->where(['text_id' => $value])->exists()) {
				$model->addError($attribute, $this->message);
			}
		}
	}
}