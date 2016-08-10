<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model \backend\models\PlanForm */

/** @var \backend\controllers\PlanController $controller */
$controller = $this->context;
$modelClass = Yii::t('back', 'Plan');
$this->title = Yii::t('back', 'Update {modelClass} for', compact('modelClass')) . ': ' . Yii::$app->formatter->asDate($model->date_from, 'php:d.m.Y') . ' - ' . Yii::$app->formatter->asDate($model->date_to, 'php:d.m.Y');
$this->params['breadcrumbs'][] = [ 'label' => Yii::t( 'back', 'Devices' ), 'url' => [ '/device/index' ] ];
$this->params['breadcrumbs'][] = [ 'label' => $controller->device->title, 'url' => [ '/device/view', 'id' => $controller->device->id ] ];
$this->params['breadcrumbs'][] = $this->title;
?>
<div>

	<h1><?= Html::encode($this->title) ?></h1>

	<?= $this->render('_form', compact('model')) ?>

</div>