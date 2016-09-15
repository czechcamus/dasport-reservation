<?php

namespace backend\modules\reservation\models;

use backend\modules\reservation\Module;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "dr_price".
 *
 * @property integer $id
 * @property integer $device_id
 * @property string $title
 * @property integer $price
 * @property string $notice
 *
 * @property Device $device
 */
class Price extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'dr_price';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['device_id', 'title', 'price'], 'required'],
            [['device_id', 'price'], 'integer'],
            [['title'], 'string', 'max' => 50],
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
            'title' => Module::t('res', 'Title'),
            'price' => Module::t('res', 'Price'),
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
     * @return PriceQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new PriceQuery(get_called_class());
    }
}
