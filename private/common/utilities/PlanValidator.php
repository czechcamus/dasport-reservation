<?php
/**
 * Created by PhpStorm.
 * User: Pavel
 * Date: 10.8.2016
 * Time: 16:08
 */

namespace common\utilities;


use common\models\Plan;
use yii\validators\Validator;

class PlanValidator extends Validator {
	public $firstAttribute;

	public function validateAttribute( $model, $attribute ) {
		$error = false;
		$conflictPlans = [ ];
		$value1 = \Yii::$app->formatter->asTimestamp( $model->{$this->firstAttribute} );
		$value2 = \Yii::$app->formatter->asTimestamp( $model->$attribute );
		/** @var @var $plans Plan */
		/** @noinspection PhpUndefinedFieldInspection */
		if ( $model->item_id ) {
			/** @noinspection PhpUndefinedFieldInspection */
			$plans = Plan::find()->where( [ 'device_id' => $model->device_id ] )->andWhere( [
				'!=',
				'id',
				$model->item_id
			] )->all();
		} else {
			/** @noinspection PhpUndefinedFieldInspection */
			$plans = Plan::findAll( [ 'device_id' => $model->device_id ] );
		}
		foreach ( $plans as $plan ) {
			$timestamp1 = \Yii::$app->formatter->asTimestamp( $plan->date_from );
			$timestamp2 = \Yii::$app->formatter->asTimestamp( $plan->date_to );
			if ( ( $value1 < $timestamp1 && $value2 >= $timestamp1 ) ||
			     ( $value1 <= $timestamp2 && $value2 > $timestamp2 )
			) {
				$conflictPlans[] = \Yii::$app->formatter->asDate( $plan->date_from,
						'php:d.m.Y' ) . ' - ' . \Yii::$app->formatter->asDate( $plan->date_to, 'php:d.m.Y' );
				$error           = true;
			}
		}
		if ( $error === true ) {
			$this->message = \Yii::t( 'app',
					'This plan is in conflict with one or more other plans' ) . ': ' . implode( ', ', $conflictPlans );
			$model->addError( $attribute, $this->message );
		}
	}
}