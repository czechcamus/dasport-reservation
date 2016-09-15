<?php
/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

use backend\modules\reservation\Module;
use yii\grid\GridView;
use yii\helpers\Html;
use yii\helpers\Url;

?>
	<h2><?= Module::t('res', 'Plans' ); ?></h2>

<?= /** @noinspection PhpUnusedParameterInspection */
GridView::widget( [
	'dataProvider' => $dataProvider,
	'layout'       => "{items}",
	'columns'      => [
		[
			'attribute' => 'date_from',
			'label' => Module::t('res', 'Period' ),
			'format' => 'html',
			'value' => function ( $model, $key) {
				return Html::a(Yii::$app->formatter->asDate($model->date_from, 'php:d.m.Y') . ' - ' . Yii::$app->formatter->asDate($model->date_to, 'php:d.m.Y'), ['/reservation/plan/view', 'device_id' => $model->device_id, 'id' => $key], ['title' => Module::t('res', 'Details of plan')]);
			}
		],
		[
			'class'      => 'yii\grid\ActionColumn',
			'template'   => '{update} {delete} {copy}',
			'urlCreator' => function ( $action, $model, $key ) {
				$params = [
					'/reservation/plan/' . $action,
					'device_id' => $model->device_id,
					'id'        => $key
				];

				return Url::toRoute( $params );
			},
			'buttons'    => [
				'copy' => function ( $url, $model, $key ) {
					return Html::a( '<span class="glyphicon glyphicon-duplicate" aria-hidden="true"></span>', $url,
						[
							'title' => Module::t('res', 'Copy' ),
							'class' => 'btn btn-link',
							'style' => 'padding: 0 0 3px'
						] );
				}
			]
		]
	]
] ); ?>