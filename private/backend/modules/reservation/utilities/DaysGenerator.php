<?php
/**
 * Created by PhpStorm.
 * User: Pavel
 * Date: 10.8.2016
 * Time: 9:46
 */

namespace backend\modules\reservation\utilities;


use backend\modules\reservation\models\Day;
use backend\modules\reservation\models\Plan;
use yii\base\Behavior;

/**
 * Class DaysGenerator generates day records for given plan
 * @package backend\utilities
 */
class DaysGenerator extends Behavior
{
	/**
	 * @return array
	 */
	public function events() {
		return [
			Plan::EVENT_AFTER_INSERT => 'generateDays'
		];
	}

	public function generateDays() {
		/** @var Plan $model */
		$model = $this->owner;
		for ($i = 1; $i <= 7; $i++) {
			$dayModel = new Day;
			$dayModel->plan_id = $model->id;
			$dayModel->day_nr = $i;
			$dayModel->is_open = 1;
			$dayModel->time_from = $model->time_from;
			$dayModel->time_to = $model->time_to;
			$dayModel->save(false);
		}
	}
}