<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\Device */

/** @var \backend\controllers\DeviceController $controller */
$controller = $this->context;
$modelClass = Yii::t('back', 'Device');
$this->title = Yii::t('back', 'Update {modelClass}: ', compact('modelClass')) . ' ' . $model->title;
$this->params['breadcrumbs'][] = ['label' => Yii::t('back', 'Devices'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div>

	<h1><?= Html::encode($this->title) ?></h1>

	<?= $this->render('_form', compact('model')) ?>

</div>