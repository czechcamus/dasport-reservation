<?php
/**
 * Created by PhpStorm.
 * User: Pavel
 * Date: 10.8.2016
 * Time: 6:20
 */

namespace backend\widgets;


use common\models\Plan;
use yii\base\InvalidParamException;
use yii\base\Widget;
use yii\data\ActiveDataProvider;

class PlanList extends Widget
{
	public $device_id;

	private $_dataProvider;

	/**
	 * @inheritdoc
	 */
	public function init() {
		parent::init();
		if ($this->device_id) {
			$query = Plan::find()->where(['device_id' => $this->device_id])->orderBy(['date_from' => SORT_ASC]);
			$this->_dataProvider = new ActiveDataProvider(['query' => $query]);
		} else {
			throw new InvalidParamException(\Yii::t('back', 'No device ID given!'));
		}
	}

	/**
	 * @inheritdoc
	 */
	public function run() {
		/** @noinspection PhpUndefinedFieldInspection */
		if ($this->_dataProvider->totalCount) {
			$output = $this->render('planList', [
				'dataProvider' => $this->_dataProvider
			]);
		} else {
			$output = '';
		}
		return $output;
	}
}