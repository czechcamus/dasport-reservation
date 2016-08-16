<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model \backend\models\UsageForm */

/** @var \backend\controllers\UsageController $controller */
$controller = $this->context;
$modelClass = Yii::t('back', 'Usage');
$this->title = Yii::t('back', 'Update {modelClass}: ', compact('modelClass')) . ' - ' . Yii::$app->formatter->asDate($model->date, 'd.M.y');
$this->params['breadcrumbs'][] = [ 'label' => Yii::t( 'back', 'Devices' ), 'url' => [ '/device/index' ] ];
$this->params['breadcrumbs'][] = [ 'label' => $controller->plan->device->title, 'url' => [ '/device/view', 'id' => $controller->plan->device->id ] ];
$this->params['breadcrumbs'][] = $this->title;
?>
<div>

	<h1><?= Html::encode($this->title) ?></h1>

	<?= $this->render('_form', compact('model')) ?>

</div>