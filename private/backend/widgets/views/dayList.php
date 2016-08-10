<?php
/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

use common\models\Day;
use yii\grid\GridView;
use yii\helpers\Url;

?>
<h2><?= Yii::t('back', 'Days'); ?></h2>

<?= GridView::widget([
	'dataProvider' => $dataProvider,
	'layout' => "{items}",
	'columns' => [
		[
			'attribute' => 'day_nr',
			'value' => function($model) {
				/** @var $model Day */
				return $model->getDayName();
			}
		],
		[
			'attribute' => 'is_open',
			'value' => function ($model) {
				return $model->is_open == 1 ? Yii::t('back', 'yes') : Yii::t('back', 'no');
			}
		],
		[
			'attribute' => 'time_from',
			'value' => function($model) {
				return $model->is_open ? Yii::$app->formatter->asDate($model->time_from, 'php:H:i') : '---';
			}
		],
		[
			'attribute' => 'time_to',
			'value' => function($model) {
				return $model->is_open ? Yii::$app->formatter->asDate($model->time_to, 'php:H:i') : '---';
			}
		],
		[
			'class' => 'yii\grid\ActionColumn',
			'template' => '{update}',
			'urlCreator' => function($action, $model, $key) {
				$params = [
					'/day/' . $action,
					'plan_id' => $model->plan_id,
					'id' => $key
				];
				return Url::toRoute($params);
			}
		]
	]
]); ?>