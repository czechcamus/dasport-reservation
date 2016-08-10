<?php

namespace common\models;

use Yii;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "dr_request".
 *
 * @property integer $id
 * @property integer $device_id
 * @property string $date
 * @property string $time_from
 * @property string $time_to
 * @property string $subject_name
 * @property string $subject_email
 * @property string $subject_phone
 * @property string $notice
 *
 * @property Device $device
 */
class Request extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'dr_request';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['device_id', 'date', 'time_from', 'time_to', 'subject_name', 'subject_email', 'subject_phone'], 'required'],
            [['device_id'], 'integer'],
            [['date', 'time_from', 'time_to'], 'safe'],
            [['subject_name', 'subject_email'], 'string', 'max' => 50],
            [['subject_phone'], 'string', 'max' => 20],
            [['notice'], 'string', 'max' => 255],
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
            'date' => Yii::t('app', 'Date'),
            'time_from' => Yii::t('app', 'Time from'),
            'time_to' => Yii::t('app', 'Time to'),
            'subject_name' => Yii::t('app', 'Subject name'),
            'subject_email' => Yii::t('app', 'Subject email'),
            'subject_phone' => Yii::t('app', 'Subject phone'),
            'notice' => Yii::t('app', 'Notice'),
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
     * @inheritdoc
     * @return RequestQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new RequestQuery(get_called_class());
    }
}
