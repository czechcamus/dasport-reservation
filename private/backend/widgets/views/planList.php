<?php
/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

use yii\grid\GridView;
use yii\helpers\Html;
use yii\helpers\Url;

?>
	<h2><?= Yii::t( 'back', 'Plans' ); ?></h2>

<?= /** @noinspection PhpUnusedParameterInspection */
GridView::widget( [
	'dataProvider' => $dataProvider,
	'layout'       => "{items}",
	'columns'      => [
		[
			'attribute' => 'date_from',
			'label' => Yii::t( 'back', 'Period' ),
			'format' => 'html',
			'value' => function ( $model, $key) {
				return Html::a(Yii::$app->formatter->asDate($model->date_from, 'php:d.m.Y') . ' - ' . Yii::$app->formatter->asDate($model->date_to, 'php:d.m.Y'), ['/plan/view', 'device_id' => $model->device_id, 'id' => $key]);
			}
		],
		[
			'class'      => 'yii\grid\ActionColumn',
			'template'   => '{update} {delete} {copy}',
			'urlCreator' => function ( $action, $model, $key ) {
				$params = [
					'/plan/' . $action,
					'device_id' => $model->device_id,
					'id'        => $key
				];

				return Url::toRoute( $params );
			},
			'buttons'    => [
				'copy' => function ( $url, $model, $key ) {
					return Html::a( '<span class="glyphicon glyphicon-duplicate" aria-hidden="true"></span>', $url,
						[
							'title' => Yii::t( 'back', 'Copy' ),
							'class' => 'btn btn-link',
							'style' => 'padding: 0 0 3px'
						] );
				}
			]
		]
	]
] ); ?>