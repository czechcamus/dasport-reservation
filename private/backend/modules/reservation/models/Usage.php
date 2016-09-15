<?php

namespace backend\modules\reservation\models;

use backend\modules\reservation\Module;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "dr_usage".
 *
 * @property integer $id
 * @property integer $device_id
 * @property integer $subject_id
 * @property string $date
 * @property integer $hour_nr
 * @property string $notice
 *
 * @property Subject $subject
 * @property Device $device
 */
class Usage extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'dr_usage';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['device_id', 'subject_id', 'date', 'hour_nr'], 'required'],
            [['device_id', 'subject_id', 'hour_nr'], 'integer'],
            [['date'], 'safe'],
            [['notice'], 'string', 'max' => 255],
            [['subject_id'], 'exist', 'skipOnError' => true, 'targetClass' => Subject::className(), 'targetAttribute' => ['subject_id' => 'id']],
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
            'subject_id' => Module::t('res', 'Subject ID'),
            'date' => Module::t('res', 'Date'),
            'hour_nr' => Module::t('res', 'Hour Nr.'),
            'notice' => Module::t('res', 'Notice'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSubject()
    {
        return $this->hasOne(Subject::className(), ['id' => 'subject_id']);
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
     * @return UsageQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new UsageQuery(get_called_class());
    }
}
