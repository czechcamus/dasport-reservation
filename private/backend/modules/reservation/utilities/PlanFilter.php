<?php
/**
 * Created by PhpStorm.
 * User: Pavel
 * Date: 9.8.2016
 * Time: 12:49
 */

namespace backend\modules\reservation\utilities;


use backend\modules\reservation\models\Plan;
use yii\base\ActionFilter;

class PlanFilter extends ActionFilter
{
	/**
	 * @param \yii\base\Action $action
	 *
	 * @return bool
	 */
	public function beforeAction( $action ) {
		$request = \Yii::$app->request;
		if (!$request->get('plan_id')) {
			return false;
		}
		/** @noinspection PhpUndefinedFieldInspection */
		$action->controller->plan = Plan::findOne($request->get('plan_id'));
		return parent::beforeAction($action);
	}
}