<?php
/**
 * Created by PhpStorm.
 * User: Pavel
 * Date: 8.8.2016
 * Time: 9:18
 */

namespace backend\controllers;


use backend\models\DeviceForm;
use backend\models\DeviceSearch;
use common\models\Device;
use Yii;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

class DeviceController extends Controller
{
	/**
	 * @inheritdoc
	 */
	public function behaviors()
	{
		return [
			'verbs' => [
				'class' => VerbFilter::className(),
				'actions' => [
					'delete' => ['post'],
				],
			],
			'access' => [
				'class' => AccessControl::className(),
				'rules' => [
					[
						'roles' => ['@'],
						'allow' => true
					]
				]
			]
		];
	}

	/**
	 * Lists all record models.
	 * @return mixed
	 */
	public function actionIndex()
	{
		$searchModel = new DeviceSearch;
		$dataProvider = $searchModel->search(Yii::$app->request->queryParams);

		return $this->render('index', compact('searchModel', 'dataProvider'));
	}


	/**
	 * Displays a single model.
	 * @param integer $id
	 * @return mixed
	 */
	public function actionView($id)
	{
		return $this->render('view', [
			'model' => $this->findModel($id),
		]);
	}

	/**
	 * Creates a new record model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 * @return mixed
	 */
	public function actionCreate()
	{
		$model = new DeviceForm(['item_id' => null, 'action' => $this->action->id]);

		if ($model->load(Yii::$app->request->post()) && $model->validate()) {
			$model->save();

			$session = Yii::$app->session;
			$session->setFlash('info', Yii::t('back', 'New device successfully added!'));

			return $this->redirect(['view', 'id' => $model->item_id]);
		}

		return $this->render('create', compact('model'));
	}

	/**
	 * Creates a new model from an existing model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 * @param $id
	 * @return mixed
	 */
	public function actionCopy($id)
	{
		$model = new DeviceForm(['item_id' => $id, 'action' => $this->action->id]);

		if ($model->load(Yii::$app->request->post()) && $model->validate()) {
			$model->save();

			$session = Yii::$app->session;
			$session->setFlash('info', Yii::t('back', 'New device successfully added!'));

			return $this->redirect(['view', 'id' => $model->item_id]);
		}

		return $this->render('create', compact('model'));
	}

	/**
	 * Updates an existing record model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id
	 * @return mixed
	 */
	public function actionUpdate($id)
	{
		$model = new DeviceForm(['item_id' => $id, 'action' => $this->action->id]);

		if ($model->load(Yii::$app->request->post()) && $model->validate()) {
			$model->save(false);

			$session = Yii::$app->session;
			$session->setFlash('info', Yii::t('back', 'Device successfully updated!'));

			return $this->redirect(['view', 'id' => $model->item_id]);
		}
		return $this->render('update', compact('model'));
	}

	/**
	 * Deletes an existing record model.
	 * If deletion is successful, the browser will be redirected to the 'index' page.
	 * @param integer $id
	 * @return mixed
	 */
	public function actionDelete($id)
	{
		$model = $this->findModel($id);
		if ($model->delete()) {
			$session = Yii::$app->session;
			$session->setFlash('info', Yii::t('back', 'Device successfully deleted!'));
		}

		return $this->redirect(['index']);
	}

	/**
	 * Displays list of days with usage information
	 * @return string
	 */
	public function actionDayList() {
		$dayList = $this->renderPartial('_dayList', [
			'firstDate' => Yii::$app->request->post('firstDate'),
			'lastDate' => Yii::$app->request->post('lastDate')
		]);
		return $this->render('view', [
			'id' => Yii::$app->request->post('device_id'),
			'dayList' => $dayList
		]);
	}

	/**
	 * Finds the model based on its primary key value.
	 * If the model is not found, a 404 HTTP exception will be thrown.
	 * @param integer $id
	 * @return Device the loaded model
	 * @throws NotFoundHttpException if the model cannot be found
	 */
	protected function findModel($id)
	{
		if (($model = Device::findOne($id)) !== null) {
			return $model;
		} else {
			throw new NotFoundHttpException('The requested page does not exist.');
		}
	}
}