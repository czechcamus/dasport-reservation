<?php
/* @var $this yii\web\View */
/* @var $model backend\modules\reservation\models\Plan */

use backend\modules\reservation\Module;
use backend\modules\reservation\widgets\DayList;
use yii\helpers\Html;
use yii\widgets\DetailView;

/** @var \backend\modules\reservation\controllers\PlanController $controller */
$controller = $this->context;
$modelClass = Module::t('res', 'Plan');
$this->title = Module::t('res', 'Plan for') . ': ' . Yii::$app->formatter->asDate($model->date_from, 'php:d.m.Y') . ' - ' . Yii::$app->formatter->asDate($model->date_to, 'php:d.m.Y');
$this->params['breadcrumbs'][] = [ 'label' => Module::t('res', 'Devices' ), 'url' => [ '/reservation/device/index' ] ];
$this->params['breadcrumbs'][] = [ 'label' => $controller->device->title, 'url' => [ '/reservation/device/view', 'id' => $controller->device->id ] ];
$this->params['breadcrumbs'][] = $this->title;
?>
<div>

	<h1><?= Html::encode($this->title) ?></h1>

	<p>
		<?= Html::a(Module::t('res', 'Update'), ['update', 'device_id' => $controller->device->id, 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
		<?= Html::a(Module::t('res', 'Delete'), ['delete', 'device_id' => $controller->device->id, 'id' => $model->id], [
			'class' => 'btn btn-danger',
			'data' => [
				'confirm' => Module::t('res', 'Are you sure you want to delete this item?'),
				'method' => 'post',
			],
		]) ?>
	</p>

	<?= DetailView::widget([
		'model' => $model,
		'attributes' => [
			[
				'attribute' => 'date_from',
				'format' => ['date', 'php:d.m.Y']
			],
			[
				'attribute' => 'date_to',
				'format' => ['date', 'php:d.m.Y']
			],
			[
				'attribute' => 'time_from',
				'format' => ['date', 'php:H:i']
			],
			[
				'attribute' => 'time_to',
				'format' => ['date', 'php:H:i']
			],
			'hour_length',
		],
	]) ?>

	<div class="row">
		<div class="col-xs-12">
			<?= DayList::widget(['plan_id' => $model->id]); ?>
		</div>
	</div>

</div>