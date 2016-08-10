<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model \backend\models\DayForm */

/** @var \backend\controllers\DayController $controller */
$controller = $this->context;
$modelClass = Yii::t('back', 'Day');
$this->title = Yii::t('back', 'Update {modelClass}', compact('modelClass')) . ': ' . $model->getDay()->getDayName();
$this->params['breadcrumbs'][] = [ 'label' => Yii::t( 'back', 'Devices' ), 'url' => [ '/device/index' ] ];
$this->params['breadcrumbs'][] = [ 'label' => $controller->plan->device->title, 'url' => [ '/device/view', 'id' => $controller->plan->device->id ] ];
$this->params['breadcrumbs'][] = [ 'label' => Yii::t('back', 'Plan for', compact('modelClass')) . ': ' . Yii::$app->formatter->asDate($controller->plan->date_from, 'php:d.m.Y') . ' - ' . Yii::$app->formatter->asDate($controller->plan->date_to, 'php:d.m.Y'), 'url' => [ '/plan/view', 'device_id' => $controller->plan->device->id, 'id' => $controller->plan->id ] ];
$this->params['breadcrumbs'][] = $this->title;
?>
<div>

	<h1><?= Html::encode($this->title) ?></h1>

	<?= $this->render('_form', compact('model')) ?>

</div>