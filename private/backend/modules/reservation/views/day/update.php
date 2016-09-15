<?php
/* @var $this yii\web\View */
/* @var $model \backend\modules\reservation\models\DayForm */

use backend\modules\reservation\Module;
use yii\helpers\Html;

/** @var \backend\modules\reservation\controllers\DayController $controller */
$controller = $this->context;
$modelClass = Module::t('res', 'Day');
$this->title = Module::t('res', 'Update {modelClass}', compact('modelClass')) . ': ' . $model->getDay()->getDayName();
$this->params['breadcrumbs'][] = [ 'label' => Module::t('res', 'Devices' ), 'url' => [ '/reservation/device/index' ] ];
$this->params['breadcrumbs'][] = [ 'label' => $controller->plan->device->title, 'url' => [ '/reservation/device/view', 'id' => $controller->plan->device->id ] ];
$this->params['breadcrumbs'][] = [ 'label' => Module::t('res', 'Plan for', compact('modelClass')) . ': ' . Yii::$app->formatter->asDate($controller->plan->date_from, 'php:d.m.Y') . ' - ' . Yii::$app->formatter->asDate($controller->plan->date_to, 'php:d.m.Y'), 'url' => [ '/plan/view', 'device_id' => $controller->plan->device->id, 'id' => $controller->plan->id ] ];
$this->params['breadcrumbs'][] = $this->title;
?>
<div>

	<h1><?= Html::encode($this->title) ?></h1>

	<?= $this->render('_form', compact('model')) ?>

</div>