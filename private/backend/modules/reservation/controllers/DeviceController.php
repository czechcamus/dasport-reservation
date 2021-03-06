<?php
/**
 * Created by PhpStorm.
 * User: Pavel
 * Date: 8.8.2016
 * Time: 9:18
 */

namespace backend\modules\reservation\controllers;


use backend\modules\reservation\models\DeviceForm;
use backend\modules\reservation\models\DeviceSearch;
use backend\modules\reservation\models\PeriodForm;
use backend\modules\reservation\models\Device;
use backend\modules\reservation\Module;
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
						'roles' => ['booker'],
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
		$session = Yii::$app->session;
		$model = $this->findModel($id);
		$periodModel = new PeriodForm(['device_id' => $id]);
		if ($periodModel->load(Yii::$app->request->post())) {
			if ($periodModel->validate()) {
				$session->set('periodModel_' . $id, $periodModel);
			}
		} else {
			if ($sessionPeriodModel = $session->get('periodModel_' . $id)) {
				$periodModel = $sessionPeriodModel;
			} else {
				if ($periodModel->existsActualPlans()) {
					$periodModel->setDefaultPeriod();
				}
			}
		}

		return $this->render('view', compact('model', 'periodModel'));
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
			$session->setFlash('info', Module::t('res', 'New device successfully added!'));

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
			$session->setFlash('info', Module::t('res', 'New device successfully added!'));

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
			$session->setFlash('info', Module::t('res', 'Device successfully updated!'));

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
			$session->setFlash('info', Module::t('res', 'Device successfully deleted!'));
		}

		return $this->redirect(['index']);
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