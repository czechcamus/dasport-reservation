<?php

namespace common\models;

use Yii;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "dr_week".
 *
 * @property integer $id
 * @property integer $plan_id
 * @property integer $day_nr
 * @property integer $is_open
 * @property string $time_from
 * @property string $time_to
 *
 * @property Plan $plan
 */
class Week extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'dr_week';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['plan_id', 'day_nr', 'time_from', 'time_to'], 'required'],
            [['plan_id', 'day_nr', 'is_open'], 'integer'],
            [['time_from', 'time_to'], 'safe'],
            [['plan_id'], 'exist', 'skipOnError' => true, 'targetClass' => Plan::className(), 'targetAttribute' => ['plan_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'plan_id' => Yii::t('app', 'Plan ID'),
            'day_nr' => Yii::t('app', 'Day Nr'),
            'is_open' => Yii::t('app', 'Is Open'),
            'time_from' => Yii::t('app', 'Time From'),
            'time_to' => Yii::t('app', 'Time To'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPlan()
    {
        return $this->hasOne(Plan::className(), ['id' => 'plan_id']);
    }

    /**
     * @inheritdoc
     * @return WeekQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new WeekQuery(get_called_class());
    }
}
