<?php
/**
 * Created by PhpStorm.
 * User: Pavel
 * Date: 30.8.2016
 * Time: 7:08
 */

namespace backend\modules\reservation;


use Yii;

class Module extends \yii\base\Module
{
	public function init() {
		parent::init();
		Yii::$app->language = 'cs';
		Yii::configure($this, require(__DIR__ . '/config/config.php'));
		$this->registerTranslations();
	}

	public function registerTranslations()
	{
		Yii::$app->i18n->translations['modules/reservation/res'] = [
			'class' => 'yii\i18n\PhpMessageSource',
			'basePath' => '@backend/modules/reservation/messages',
			'fileMap' => [
				'modules/reservation/res' => 'res.php'
            ],
        ];
    }


	public static function t($category, $message, $params = [], $language = null)
	{
		return Yii::t('modules/reservation/' . $category, $message, $params, $language);
	}
}