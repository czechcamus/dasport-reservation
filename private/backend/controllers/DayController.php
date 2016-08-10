<?php
/**
 * Created by PhpStorm.
 * User: Pavel
 * Date: 9.8.2016
 * Time: 12:31
 */

namespace backend\controllers;


use backend\models\DayForm;
use backend\utilities\PlanFilter;
use Yii;
use yii\web\Controller;

class DayController extends Controller
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


	/**
	 * Updates an existing record model.
	 * If update is successful, the browser will be redirected to the 'plan/view' page.
	 * @param integer $id
	 * @return mixed
	 */
	public function actionUpdate($id)
	{
		$model = new DayForm(['plan_id' => $this->plan->id,  'item_id' => $id, 'action' => $this->action->id]);

		if ($model->load(Yii::$app->request->post()) && $model->validate()) {
			$model->save(false);

			$session = Yii::$app->session;
			$session->setFlash('info', Yii::t('back', 'Day successfully updated!'));

			return $this->redirect(['/plan/view', 'device_id' => $this->plan->device->id, 'id' => $this->plan->id]);
		}
		return $this->render('update', compact('model'));
	}

}