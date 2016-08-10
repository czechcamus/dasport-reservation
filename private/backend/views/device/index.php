<?php
/* @var $this yii\web\View */
/* @var $searchModel backend\models\DeviceSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

use yii\helpers\Html;
use yii\grid\GridView;

$this->title = Yii::t('back', 'Devices');
$this->params['breadcrumbs'][] = $this->title;
$modelClass = Yii::t('back', 'Device');
?>
<div>

	<h1><?= Html::encode($this->title) ?></h1>

	<p>
		<?= Html::a(Yii::t('back', 'Create {modelClass}', compact('modelClass')), ['create'],
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
					return Html::a($model->title, ['/device/view', 'id' => $key], ['title' => Yii::t('back', 'Details of device')]);
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
							'/device/copy',
							'id' => $key
						],
						[
							'title' => Yii::t('back', 'Copy'),
							'class' => 'btn btn-link',
							'style' => 'padding: 0 0 3px'
						]);
					}
				]
			]
		],
	]); ?>

</div>
