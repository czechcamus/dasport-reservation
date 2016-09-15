<?php
/**
 * Created by PhpStorm.
 * User: Pavel
 * Date: 8.8.2016
 * Time: 8:11
 */

namespace backend\modules\reservation\models;


use backend\modules\reservation\Module;
use backend\modules\reservation\utilities\BackendForm;
use backend\modules\reservation\utilities\NameValidator;

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
			'name'     => Module::t('res', 'Name' ),
			'email'       => Module::t('res', 'Email' ),
			'phone' => Module::t('res', 'Phone' ),
		];
	}
}