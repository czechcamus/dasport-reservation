<?php

use backend\modules\reservation\Module;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model \backend\modules\reservation\models\DeviceForm */

/** @var \backend\modules\reservation\controllers\DeviceController $controller */
$controller = $this->context;
$modelClass = Module::t('res', 'Device');
$this->title = Module::t('res', 'Update {modelClass}: ', compact('modelClass')) . ' ' . $model->title;
$this->params['breadcrumbs'][] = ['label' => Module::t('res', 'Devices'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div>

	<h1><?= Html::encode($this->title) ?></h1>

	<?= $this->render('_form', compact('model')) ?>

</div>