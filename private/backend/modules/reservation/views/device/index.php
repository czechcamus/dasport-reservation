<?php
/* @var $this yii\web\View */
/* @var $searchModel backend\modules\reservation\models\DeviceSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

use backend\modules\reservation\Module;
use yii\helpers\Html;
use yii\grid\GridView;

$this->title = Module::t('res', 'Devices');
$this->params['breadcrumbs'][] = $this->title;
$modelClass = Module::t('res', 'Device');
?>
<div>

	<h1><?= Html::encode($this->title) ?></h1>

	<p>
		<?= Html::a(Module::t('res', 'Create {modelClass}', compact('modelClass')), ['create'],
			[
				'class' => 'btn btn-success'
			]
		) ?>
	</p>

	<?= /** @noinspection PhpUnusedParameterInspection */
	GridView::widget([
		'dataProvider' => $dataProvider,
		'filterModel' => $searchModel,
		'columns' => [
			['class' => 'yii\grid\SerialColumn'],

			[
				'attribute' => 'title',
				'value' => function($model, $key) {
					return Html::a($model->title, ['/reservation/device/view', 'id' => $key], ['title' => Module::t('res', 'Details of device')]);
				},
				'format' => 'html'
			],
			'text_id',
			[
				'class' => 'yii\grid\ActionColumn',
				'template' => '{update} {delete} {copy}',
				'buttons' => [
					'copy' => function ($url, $model, $key) {
						return Html::a('<span class="glyphicon glyphicon-duplicate" aria-hidden="true"></span>', [
							'/reservation/device/copy',
							'id' => $key
						],
						[
							'title' => Module::t('res', 'Copy'),
							'class' => 'btn btn-link',
							'style' => 'padding: 0 0 3px'
						]);
					}
				]
			]
		],
	]); ?>

</div>
