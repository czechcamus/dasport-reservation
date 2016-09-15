<?php
/**
 * Created by PhpStorm.
 * User: Pavel
 * Date: 9.8.2016
 * Time: 12:31
 */

namespace backend\modules\reservation\controllers;


use backend\modules\reservation\models\PriceForm;
use backend\modules\reservation\Module;
use backend\modules\reservation\utilities\DeviceFilter;
use backend\modules\reservation\models\Price;
use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

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
			$session->setFlash('info', Module::t('res', 'New price successfully added!'));

			return $this->redirect(['/reservation/device/view', 'id' => $this->device->id]);
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
		$model = new PriceForm(['device_id' => $this->device->id,  'item_id' => $id, 'action' => $this->action->id]);

		if ($model->load(Yii::$app->request->post()) && $model->validate()) {
			$model->save();

			$session = Yii::$app->session;
			$session->setFlash('info', Module::t('res', 'New price successfully added!'));

			return $this->redirect(['/reservation/device/view', 'id' => $this->device->id]);
		}

		return $this->render('create', compact('model'));
	}

	/**
	 * Updates an existing record model.
	 * If update is successful, the browser will be redirected to the 'device/view' page.
	 * @param integer $id
	 * @return mixed
	 */
	public function actionUpdate($id)
	{
		$model = new PriceForm(['device_id' => $this->device->id,  'item_id' => $id, 'action' => $this->action->id]);

		if ($model->load(Yii::$app->request->post()) && $model->validate()) {
			$model->save(false);

			$session = Yii::$app->session;
			$session->setFlash('info', Module::t('res', 'Price successfully updated!'));

			return $this->redirect(['/reservation/device/view', 'id' => $this->device->id]);
		}
		return $this->render('update', compact('model'));
	}

	/**
	 * Deletes an existing record model.
	 * If deletion is successful, the browser will be redirected to the 'device/view' page.
	 * @param integer $id
	 * @return mixed
	 */
	public function actionDelete($id)
	{
		$model = $this->findModel($id);
		if ($model->delete()) {
			$session = Yii::$app->session;
			$session->setFlash('info', Module::t('res', 'Price successfully deleted!'));
		}

		return $this->redirect(['/reservation/device/view', 'id' => $this->device->id]);
	}

	/**
	 * Finds the model based on its primary key value.
	 * If the model is not found, a 404 HTTP exception will be thrown.
	 * @param integer $id
	 * @return Price the loaded model
	 * @throws NotFoundHttpException if the model cannot be found
	 */
	protected function findModel($id)
	{
		if (($model = Price::findOne($id)) !== null) {
			return $model;
		} else {
			throw new NotFoundHttpException('The requested page does not exist.');
		}
	}

}