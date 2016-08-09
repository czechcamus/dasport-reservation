<?php
/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

use yii\grid\GridView;
use yii\helpers\Html;

?>
<h2><?= Yii::t('back', 'Prices'); ?></h2>

<?= /** @noinspection PhpUnusedParameterInspection */
GridView::widget([
	'dataProvider' => $dataProvider,
	'layout' => "{items}",
	'columns' => [
		'title',
		'price',
		'notice',
		[
			'class' => 'yii\grid\ActionColumn',
			'controller' => '/price',
			'template' => '{update} {delete} {copy}',
			'buttons' => [
				'copy' => function ($url, $model, $key) {
					return Html::a('<span class="glyphicon glyphicon-duplicate" aria-hidden="true"></span>', [
						'/price/copy',
						'device_id' => $model->device_id,
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
	]
]); ?>