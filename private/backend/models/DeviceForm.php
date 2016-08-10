<?php
/**
 * Created by PhpStorm.
 * User: Pavel
 * Date: 8.8.2016
 * Time: 8:11
 */

namespace backend\models;


use backend\utilities\BackendForm;
use common\models\Device;
use common\utilities\TextIdValidator;
use Yii;

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
			'text_id'     => Yii::t( 'back', 'Text ID' ),
			'title'       => Yii::t( 'back', 'Title' ),
			'description' => Yii::t( 'back', 'Description' ),
		];
	}
}