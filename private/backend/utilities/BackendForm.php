<?php
/**
 * Created by PhpStorm.
 * User: Pavel
 * Date: 8.8.2016
 * Time: 13:28
 */

namespace backend\utilities;


use yii\base\Model;
use yii\base\UnknownPropertyException;
use yii\db\ActiveRecord;
use yii\db\Exception;

class BackendForm extends Model {
	public $item_id;
	public $modelClass;

	const SCENARIO_CREATE = 'create';
	const SCENARIO_SEARCH = 'search';

	/**
	 * BackendForm constructor.
	 *
	 * @param array $config
	 *
	 * @throws Exception
	 * @throws UnknownPropertyException
	 */
	public function __construct( $config ) {
		if ( isset( $this->modelClass ) ) {
			parent::__construct();
			if ( $config['item_id'] ) {
				/** @var ActiveRecord $model */
				$model = call_user_func( [ $this->modelClass, 'findOne' ], $config['item_id'] );
				if ( $model ) {
					if ( $config['action'] != 'copy' ) /** @noinspection PhpUndefinedFieldInspection */ {
						$this->item_id = $model->id;
					}
					$data = $model->toArray();
					$this->attributes = $data;
				} else {
					/** @noinspection PhpToStringImplementationInspection */
					throw new Exception( \Yii::t( 'back',
						'model not found' ) . ' ' . $this->modelClass . ' ID ' . $config['item_id'] );
				}
			}
		} else {
			throw new UnknownPropertyException( \Yii::t( 'back', 'modelClass property not set' ) );
		}
	}

	/**
	 * Saves model to database
	 *
	 * @param bool $insert
	 */
	public function save( $insert = true ) {
		/** @var ActiveRecord $model */
		/** @noinspection PhpUndefinedMethodInspection */
		if ( $model = $insert === true ? new $this->modelClass : call_user_func( [ $this->modelClass, 'findOne' ],
			$this->item_id ))
		{
			$model->attributes = $this->toArray();
			if ($model->save( false )) {
				/** @noinspection PhpUndefinedFieldInspection */
				$this->item_id = $model->id;
			}
		}
	}

	/**
	 * Deletes record from database
	 */
	public function delete() {
		/** @var ActiveRecord $model */
		/** @noinspection PhpUndefinedMethodInspection */
		if ( $model = call_user_func( [ $this->modelClass, 'findOne' ], $this->item_id ) ) {
			$model->delete();
		}
	}

}