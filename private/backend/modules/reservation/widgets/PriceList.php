<?php
/**
 * Created by PhpStorm.
 * User: Pavel
 * Date: 9.8.2016
 * Time: 13:50
 */

namespace backend\modules\reservation\widgets;


use backend\modules\reservation\Module;
use backend\modules\reservation\models\Price;
use yii\base\InvalidParamException;
use yii\base\Widget;
use yii\data\ActiveDataProvider;

class PriceList extends Widget
{
	public $device_id;

	private $_dataProvider;

	/**
	 * @inheritdoc
	 */
	public function init() {
		parent::init();
		if ($this->device_id) {
			$query = Price::find()->where(['device_id' => $this->device_id])->orderBy(['title' => SORT_ASC]);
			$this->_dataProvider = new ActiveDataProvider(['query' => $query]);
		} else {
			throw new InvalidParamException(Module::t('res', 'No device ID given!'));
		}
	}

	/**
	 * @inheritdoc
	 */
	public function run() {
		/** @noinspection PhpUndefinedFieldInspection */
		if ($this->_dataProvider->totalCount) {
			$output = $this->render('priceList', [
				'dataProvider' => $this->_dataProvider
			]);
		} else {
			$output = '';
		}
		return $output;
	}
}