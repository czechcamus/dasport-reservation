<?php
/**
 * Created by PhpStorm.
 * User: Pavel
 * Date: 9.8.2016
 * Time: 12:49
 */

namespace backend\modules\reservation\utilities;


use backend\modules\reservation\models\Device;
use yii\base\ActionFilter;

class DeviceFilter extends ActionFilter
{
	/**
	 * @param \yii\base\Action $action
	 *
	 * @return bool
	 */
	public function beforeAction( $action ) {
		$request = \Yii::$app->request;
		if (!$request->get('device_id')) {
			return false;
		}
		/** @noinspection PhpUndefinedFieldInspection */
		$action->controller->device = Device::findOne($request->get('device_id'));
		return parent::beforeAction($action);
	}
}