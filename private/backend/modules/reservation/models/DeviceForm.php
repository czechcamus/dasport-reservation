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
use backend\modules\reservation\utilities\TextIdValidator;

class DeviceForm extends BackendForm {

	public $text_id;
	public $title;
	public $description;

	public function __construct( $config ) {
		$this->modelClass = Device::className();
		parent::__construct( $config );
	}

	/**
	 * @inheritdoc
	 */
	public function rules() {
		return [
			[ [ 'text_id', 'title' ], 'required' ],
			[ [ 'description' ], 'string' ],
			[ [ 'text_id', 'title' ], 'string', 'max' => 50 ],
			[ [ 'text_id' ], TextIdValidator::className() ]
		];
	}

	/**
	 * @inheritdoc
	 */
	public function attributeLabels() {
		return [
			'text_id'     => Module::t('res', 'Text ID' ),
			'title'       => Module::t('res', 'Title' ),
			'description' => Module::t('res', 'Description' ),
		];
	}
}