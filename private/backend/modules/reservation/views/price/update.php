<?php
/* @var $this yii\web\View */
/* @var $model \backend\modules\reservation\models\PriceForm */

use backend\modules\reservation\Module;
use yii\helpers\Html;

/** @var \backend\modules\reservation\controllers\PriceController $controller */
$controller = $this->context;
$modelClass = Module::t('res', 'Price');
$this->title = Module::t('res', 'Update {modelClass}: ', compact('modelClass')) . ' ' . $model->title;
$this->params['breadcrumbs'][] = [ 'label' => Module::t('res', 'Devices' ), 'url' => [ '/reservation/device/index' ] ];
$this->params['breadcrumbs'][] = [ 'label' => $controller->device->title, 'url' => [ '/reservation/device/view', 'id' => $controller->device->id ] ];
$this->params['breadcrumbs'][] = $this->title;
?>
<div>

	<h1><?= Html::encode($this->title) ?></h1>

	<?= $this->render('_form', compact('model')) ?>

</div>