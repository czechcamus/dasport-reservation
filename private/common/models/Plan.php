<?php

namespace common\models;

use common\utilities\RelationsDelete;
use Yii;
use yii\db\ActiveRecord;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "dr_plan".
 *
 * @property integer $id
 * @property integer $device_id
 * @property string $date_from
 * @property string $date_to
 * @property integer $hour_length
 *
 * @property Device $device
 * @property Week[] $weeks
 */
class Plan extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'dr_plan';
    }

	/**
	 * @inheritdoc
	 */
	public function behaviors() {
		$parentBehaviors = parent::behaviors();
		$thisBehaviors = [
			'relationDelete' => [
				'class' => RelationsDelete::className(),
				'relations' => ['weeks']
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
            [['device_id', 'date_from', 'date_to', 'hour_length'], 'required'],
            [['device_id', 'hour_length'], 'integer'],
            [['date_from', 'date_to'], 'safe'],
            [['device_id'], 'exist', 'skipOnError' => true, 'targetClass' => Device::className(), 'targetAttribute' => ['device_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'device_id' => Yii::t('app', 'Device ID'),
            'date_from' => Yii::t('app', 'Date From'),
            'date_to' => Yii::t('app', 'Date To'),
            'hour_length' => Yii::t('app', 'Hour Length'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDevice()
    {
        return $this->hasOne(Device::className(), ['id' => 'device_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getWeeks()
    {
        return $this->hasMany(Week::className(), ['plan_id' => 'id']);
    }

    /**
     * @inheritdoc
     * @return PlanQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new PlanQuery(get_called_class());
    }
}
