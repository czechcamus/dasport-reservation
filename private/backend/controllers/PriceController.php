<?php
/**
 * Created by PhpStorm.
 * User: Pavel
 * Date: 9.8.2016
 * Time: 12:31
 */

namespace backend\controllers;


use backend\models\PriceForm;
use backend\utilities\DeviceFilter;
use Yii;
use yii\web\Controller;

class PriceController extends Controller
{
	public $device;

	/**
	 * @inheritdoc
	 */
	public function behaviors() {
		return [
			'device' => [
				'class' => DeviceFilter::className()
			]
		];
	}

	/**
	 * Creates a new record model.
	 * If creation is successful, the browser will be redirected to the 'device/view' page.
	 * @return mixed
	 */
	public function actionCreate() {
		$model = new PriceForm(['device_id' => $this->device->id,  'item_id' => null, 'action' => $this->action->id]);

		if ($model->load(Yii::$app->request->post()) && $model->validate()) {
			$model->save();

			$session = Yii::$app->session;
			$session->setFlash('info', Yii::t('back', 'New price successfully added!'));

			return $this->redirect(['/device/view', 'id' => $this->device->id]);
		}

		return $this->render('create', compact('model'));
	}

	/**
	 * Creates a new model from an existing model.
	 * If creation is successful, the browser will be redirected to the 'device/view' page.
	 * @param $id
	 * @return mixed
	 */
	public function actionCopy($id)
	{
		$model = new SubjectForm(['item_id' => $id, 'action' => $this->action->id]);

		if ($model->load(Yii::$app->request->post()) && $model->validate()) {
			$model->save();

			$session = Yii::$app->session;
			$session->setFlash('info', Yii::t('back', 'New subject successfully added!'));

			return $this->redirect(['index']);
		}

		return $this->render('create', compact('model'));
	}

}