<?php
/**
 * Created by PhpStorm.
 * User: Pavel
 * Date: 9.8.2016
 * Time: 12:31
 */

namespace backend\controllers;


use backend\models\DayForm;
use backend\models\UsageForm;
use backend\utilities\PlanFilter;
use Yii;
use yii\base\InvalidParamException;
use yii\web\Controller;

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

		$model = new UsageForm(['plan_id' => $this->plan->id,  'item_id' => null, 'action' => $this->action->id]);

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