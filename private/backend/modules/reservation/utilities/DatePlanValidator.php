<?php
/**
 * Created by PhpStorm.
 * User: Pavel
 * Date: 13.8.2016
 * Time: 19:43
 */

namespace backend\modules\reservation\utilities;


use backend\modules\reservation\models\Plan;
use backend\modules\reservation\Module;
use yii\validators\Validator;

/**
 * Class DatePlanValidator checks if date is in any valid plan
 * @param $device_id integer id of actual device
 * @package common\utilities
 */
class DatePlanValidator extends Validator {

	public $device_id;

	public function init() {
		parent::init();
		$this->message = Module::t('res', 'must be in any valid plan!' );
	}

	public function validateAttribute( $model, $attribute ) {
		$error = true;
		$todayTime = strtotime( date( 'Y-m-d', time() ) );
		$testDate = \Yii::$app->formatter->asDate($todayTime, 'y-MM-dd');
		$plans = Plan::find()->where(['device_id' => $this->device_id])->andWhere(['>=', 'date_to', $testDate])->all();
		foreach ( $plans as $plan ) {
			if ($model->$attribute >= $plan->date_from && $model->$attribute <= $plan->date_to){
				$error = false;
				break;
			}
		}
		if ($error === true)
			$model->addError($attribute, $model->getAttributeLabel($attribute) . ' ' . $this->message );
	}
}