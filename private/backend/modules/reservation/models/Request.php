<?php

namespace backend\modules\reservation\models;

use backend\modules\reservation\Module;
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
            'id' => Module::t('res', 'ID'),
            'device_id' => Module::t('res', 'Device ID'),
            'date' => Module::t('res', 'Date'),
            'time_from' => Module::t('res', 'Time from'),
            'time_to' => Module::t('res', 'Time to'),
            'subject_name' => Module::t('res', 'Subject name'),
            'subject_email' => Module::t('res', 'Subject email'),
            'subject_phone' => Module::t('res', 'Subject phone'),
            'notice' => Module::t('res', 'Notice'),
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
