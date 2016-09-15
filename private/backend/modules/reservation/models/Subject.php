<?php

namespace backend\modules\reservation\models;

use backend\modules\reservation\Module;
use backend\modules\reservation\utilities\NameValidator;
use backend\modules\reservation\utilities\RelationsDelete;
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
				'relations' => ['usages']
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
	        [['email'], 'email'],
            [['phone'], 'string', 'max' => 20],
	        ['name', NameValidator::className()]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Module::t('res', 'ID'),
            'name' => Module::t('res', 'Name'),
            'email' => Module::t('res', 'Email'),
            'phone' => Module::t('res', 'Phone'),
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

	/**
	 * Returns subjects list for dropdowns
	 * @return array
	 */
	public static function getSubjects() {
		return ArrayHelper::map(self::find()->orderBy([
			'name' => SORT_ASC
		])->all(), 'id', 'name');
	}
}
