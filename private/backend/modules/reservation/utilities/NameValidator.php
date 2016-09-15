<?php
/**
 * Created by PhpStorm.
 * User: Pavel
 * Date: 9.8.2016
 * Time: 8:21
 */

namespace backend\modules\reservation\utilities;


use backend\modules\reservation\models\Subject;
use backend\modules\reservation\Module;
use yii\validators\Validator;

class NameValidator extends Validator
{
	public function init() {
		parent::init();
		$this->message = Module::t('res', 'This name of subject is already used!');
	}

	public function validateAttribute( $model, $attribute ) {
		$value = $model->$attribute;
		if (isset($model->id) || isset($model->item_id)) {
			/** @noinspection PhpUndefinedFieldInspection */
			$modelId = isset($model->id) ? $model->id : $model->item_id;
			if (Subject::find()->where(['!=', 'id', $modelId])->andWhere(['name' => $value])->exists()) {
				$model->addError($attribute, $this->message);
			}
		} else {
			if (Subject::find()->where(['name' => $value])->exists()) {
				$model->addError($attribute, $this->message);
			}
		}
	}
}