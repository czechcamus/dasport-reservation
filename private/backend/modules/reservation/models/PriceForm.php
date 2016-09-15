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

class PriceForm extends BackendForm {

	public $title;
	public $price;
	public $notice;
	public $device_id;

	public function __construct( $config ) {
		$this->device_id = $config['device_id'];
		$this->modelClass = Price::className();
		array_shift($config);
		parent::__construct( $config );
	}

	/**
	 * @inheritdoc
	 */
	public function rules() {
		return [
			[ [ 'title', 'price' ], 'required' ],
			[ 'title', 'string', 'max' => 50 ],
			[ 'price', 'integer' ],
			[ 'notice', 'string' ]
		];
	}

	/**
	 * @inheritdoc
	 */
	public function attributeLabels() {
		return [
			'title'     => Module::t('res', 'Title' ),
			'price'     => Module::t('res', 'Price in CZK' ),
			'notice'    => Module::t('res', 'Notice' ),
			'device_id' => Module::t('res', 'Device ID' )
		];
	}
}