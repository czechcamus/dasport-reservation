<?php
/**
 * Created by PhpStorm.
 * User: Pavel
 * Date: 8.8.2016
 * Time: 8:11
 */

namespace backend\models;


use backend\utilities\BackendForm;
use common\models\Subject;
use common\utilities\NameValidator;
use Yii;

class SubjectForm extends BackendForm {
	public $name;
	public $email;
	public $phone;

	public function __construct( $config ) {
		$this->modelClass = Subject::className();
		parent::__construct( $config );
	}

	/**
	 * @inheritdoc
	 */
	public function rules() {
		return [
			[ [ 'name', 'email' , 'phone' ], 'required' ],
			[ [ 'name', 'email' ], 'string', 'max' => 50 ],
			[ 'email' , 'email' ],
			[ [ 'phone' ], 'string', 'max' => 20 ],
			[ 'name', NameValidator::className() ]
		];
	}

	/**
	 * @inheritdoc
	 */
	public function attributeLabels() {
		return [
			'name'     => Yii::t( 'back', 'Name' ),
			'email'       => Yii::t( 'back', 'Email' ),
			'phone' => Yii::t( 'back', 'Phone' ),
		];
	}
}