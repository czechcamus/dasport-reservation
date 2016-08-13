<?php
/**
 * Created by PhpStorm.
 * User: Pavel
 * Date: 13.8.2016
 * Time: 19:53
 */

namespace common\utilities;


use yii\validators\Validator;

/**
 * Class DateFutureValidator checks if date is greater or equal then today
 * @package common\utilities
 */
class DateFutureValidator extends Validator {

	public function init() {
		parent::init();
		$this->message = \Yii::t( 'app', 'must be greater or equal then today!' );
	}

	public function validateAttribute( $model, $attribute ) {
		$todayTime = strtotime( date( 'Y-m-d', time() ) );
		$value     = \Yii::$app->formatter->asTimestamp( $model->$attribute );
		if ( $value < $todayTime ) {
			$model->addError( $attribute, $model->getAttributeLabel($attribute) . ' ' . $this->message );
		}
	}
}