<?php

namespace common\models;

use common\utilities\RelationsDelete;
use common\utilities\TextIdValidator;
use Yii;
use yii\db\ActiveRecord;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "dr_device".
 *
 * @property integer $id
 * @property string $text_id
 * @property string $title
 * @property string $description
 *
 * @property Plan[] $plans
 * @property Price[] $prices
 * @property Request[] $requests
 * @property Usage[] $usages
 */
class Device extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'dr_device';
    }

	/**
	 * @inheritdoc
	 */
	public function behaviors() {
		$parentBehaviors = parent::behaviors();
		$thisBehaviors = [
			'relationDelete' => [
				'class' => RelationsDelete::className(),
				'relations' => ['plans', 'prices', 'requests', 'usages']
			]
		];
		return ArrayHelper::merge($parentBehaviors, $thisBehaviors);
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['text_id', 'title'], 'required'],
            [['description'], 'string'],
            [['text_id', 'title'], 'string', 'max' => 50],
            [['text_id'], TextIdValidator::className()],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'text_id' => Yii::t('app', 'Text ID'),
            'title' => Yii::t('app', 'Title'),
            'description' => Yii::t('app', 'Description'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPlans()
    {
        return $this->hasMany(Plan::className(), ['device_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPrices()
    {
        return $this->hasMany(Price::className(), ['device_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRequests()
    {
        return $this->hasMany(Request::className(), ['device_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUsages()
    {
        return $this->hasMany(Usage::className(), ['device_id' => 'id']);
    }

    /**
     * @inheritdoc
     * @return DeviceQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new DeviceQuery(get_called_class());
    }
}
