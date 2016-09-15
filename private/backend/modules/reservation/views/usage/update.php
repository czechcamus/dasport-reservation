<?php
/* @var $this yii\web\View */
/* @var $model \backend\modules\reservation\models\UsageForm */

use backend\modules\reservation\Module;
use yii\helpers\Html;

/** @var \backend\modules\reservation\controllers\UsageController $controller */
$controller = $this->context;
$modelClass = Module::t('res', 'Usage');
$this->title = Module::t('res', 'Update {modelClass}: ', compact('modelClass')) . ' - ' . Yii::$app->formatter->asDate($model->date, 'd.M.y');
$this->params['breadcrumbs'][] = [ 'label' => Module::t('res', 'Devices' ), 'url' => [ '/reservation/device/index' ] ];
$this->params['breadcrumbs'][] = [ 'label' => $controller->plan->device->title, 'url' => [ '/reservation/device/view', 'id' => $controller->plan->device->id ] ];
$this->params['breadcrumbs'][] = $this->title;
?>
<div>

	<h1><?= Html::encode($this->title) ?></h1>

	<?= $this->render('_form', compact('model')) ?>

</div>