<?php
/**
 * Created by PhpStorm.
 * User: Pavel
 * Date: 9.8.2016
 * Time: 12:31
 */

namespace backend\controllers;


use backend\models\UsageForm;
use backend\utilities\PlanFilter;
use common\models\Usage;
use Yii;
use yii\base\InvalidParamException;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

class UsageController extends Controller
{
	public $plan;

	/**
	 * @inheritdoc
	 */
	public function behaviors() {
		return [
			'plan' => [
				'class' => PlanFilter::className()
			]
		];
	}

	public function actionCreate() {
		if (!$date = Yii::$app->request->get('date')) {
			throw new InvalidParamException(Yii::t('back', 'No date given!'));
		}
		if (!$hour_nr = Yii::$app->request->get('hour_nr')) {
			throw new InvalidParamException(Yii::t('back', 'No time given!'));
		}

		$model = new UsageForm(['plan_id' => $this->plan->id,  'item_id' => null, 'action' => UsageForm::SCENARIO_CREATE]);

		if ($model->load(Yii::$app->request->post())) {
			if ($model->validate()) {
				$model->save();

				$session = Yii::$app->session;
				$session->setFlash('info', Yii::t('back', 'New usage(s) successfully added!'));

				return $this->redirect(['device/view', 'id' => $this->plan->device->id]);
			}
		} else {
			$model->setDate($date);
			$model->setTimes($hour_nr);
		}

		return $this->render('create', compact('model'));

	}

	/**
	 * Updates an existing record model.
	 * If update is successful, the browser will be redirected to the 'plan/view' page.
	 * @param integer $id
	 * @return mixed
	 */
	public function actionUpdate($id)
	{
		$model = new UsageForm(['plan_id' => $this->plan->id,  'item_id' => $id, 'action' => UsageForm::SCENARIO_UPDATE]);

		if ($model->load(Yii::$app->request->post()) && $model->validate()) {
			$model->save(false);

			$session = Yii::$app->session;
			$session->setFlash('info', Yii::t('back', 'Usage successfully updated!'));

			return $this->redirect(['device/view', 'id' => $this->plan->device->id]);
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
			$session->setFlash('info', Yii::t('back', 'Usage successfully deleted!'));
		}

		return $this->redirect(['device/view', 'id' => $this->plan->device->id]);
	}

	/**
	 * Finds the model based on its primary key value.
	 * If the model is not found, a 404 HTTP exception will be thrown.
	 * @param integer $id
	 * @return Usage the loaded model
	 * @throws NotFoundHttpException if the model cannot be found
	 */
	protected function findModel($id)
	{
		if (($model = Usage::findOne($id)) !== null) {
			return $model;
		} else {
			throw new NotFoundHttpException('The requested page does not exist.');
		}
	}
}