<?php
/**
 * Created by PhpStorm.
 * User: Pavel
 * Date: 8.8.2016
 * Time: 8:11
 */

namespace backend\models;


use backend\utilities\BackendForm;
use common\models\Price;
use Yii;

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
			[ [ 'title' ], 'string', 'max' => 50 ],
			[ 'price', 'integer' ],
			[ 'notice', 'string' ]
		];
	}

	/**
	 * @inheritdoc
	 */
	public function attributeLabels() {
		return [
			'title'     => Yii::t( 'back', 'Title' ),
			'price'     => Yii::t( 'back', 'Price in CZK' ),
			'notice'    => Yii::t( 'back', 'Notice' ),
			'device_id' => Yii::t( 'back', 'Device ID' )
		];
	}
}