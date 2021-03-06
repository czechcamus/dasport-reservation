<?php
/**
 * Created by PhpStorm.
 * User: Pavel
 * Date: 9.8.2016
 * Time: 12:31
 */

namespace backend\modules\reservation\controllers;


use backend\modules\reservation\models\DayForm;
use backend\modules\reservation\Module;
use backend\modules\reservation\utilities\PlanFilter;
use Yii;
use yii\filters\AccessControl;
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
			$session->setFlash('info', Module::t('res', 'Day successfully updated!'));

			return $this->redirect(['/reservation/plan/view', 'device_id' => $this->plan->device->id, 'id' => $this->plan->id]);
		}
		return $this->render('update', compact('model'));
	}

}