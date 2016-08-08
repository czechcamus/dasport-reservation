<?php

namespace common\models;

use common\utilities\RelationsDelete;
use Yii;
use yii\db\ActiveRecord;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "dr_subject".
 *
 * @property integer $id
 * @property string $name
 * @property string $email
 * @property string $phone
 *
 * @property Usage[] $usages
 */
class Subject extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'dr_subject';
    }

	/**
	 * @inheritdoc
	 */
	public function behaviors() {
		$parentBehaviors = parent::behaviors();
		$thisBehaviors = [
			'relationDelete' => [
				'class' => RelationsDelete::className(),
				'relations' => 'usages'
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
            [['name', 'email', 'phone'], 'required'],
            [['name', 'email'], 'string', 'max' => 50],
            [['phone'], 'string', 'max' => 20],
            [['name'], 'unique'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'name' => Yii::t('app', 'Name'),
            'email' => Yii::t('app', 'Email'),
            'phone' => Yii::t('app', 'Phone'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUsages()
    {
        return $this->hasMany(Usage::className(), ['subject_id' => 'id']);
    }

    /**
     * @inheritdoc
     * @return SubjectQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new SubjectQuery(get_called_class());
    }
}
