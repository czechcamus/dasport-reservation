<?php
/**
 * Created by PhpStorm.
 * User: Pavel
 * Date: 10.8.2016
 * Time: 6:20
 */

namespace backend\widgets;


use common\models\Day;
use yii\base\InvalidParamException;
use yii\base\Widget;
use yii\data\ActiveDataProvider;

class DayList extends Widget
{
	public $plan_id;

	private $_dataProvider;

	/**
	 * @inheritdoc
	 */
	public function init() {
		parent::init();
		if ($this->plan_id) {
			$query = Day::find()->where(['plan_id' => $this->plan_id])->orderBy(['day_nr' => SORT_ASC]);
			$this->_dataProvider = new ActiveDataProvider(['query' => $query]);
		} else {
			throw new InvalidParamException(\Yii::t('back', 'No plan ID given!'));
		}
	}

	/**
	 * @inheritdoc
	 */
	public function run() {
		/** @noinspection PhpUndefinedFieldInspection */
		if ($this->_dataProvider->totalCount) {
			$output = $this->render('dayList', [
				'dataProvider' => $this->_dataProvider
			]);
		} else {
			$output = '';
		}
		return $output;
	}
}