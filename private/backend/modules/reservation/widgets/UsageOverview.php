<?php
/**
 * Created by PhpStorm.
 * User: Pavel
 * Date: 14.8.2016
 * Time: 18:54
 */

namespace backend\modules\reservation\widgets;


use backend\modules\reservation\models\PeriodForm;
use backend\modules\reservation\Module;
use yii\base\InvalidParamException;
use yii\base\Widget;

/**
 * Class UsageOverview displays usage overview
 * @package backend\widgets
 */
class UsageOverview extends Widget
{
	/** @var PeriodForm */
	public $periodModel;

	/**
	 * @inheritdoc
	 */
	public function init() {
		parent::init();
		if (!$this->periodModel) {
			throw new InvalidParamException(Module::t('res', 'No period model given!'));
		}
	}

	/**
	 * @inheritdoc
	 */
	public function run() {
		return $this->render('usageOverview', [
			'periodModel' => $this->periodModel
		]);
	}
}